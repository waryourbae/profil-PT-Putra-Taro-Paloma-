<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * ══════════════════════════════════════════════════════
 *  CARA KERJA INTEGRASI HR → WEBSITE UTAMA
 * ══════════════════════════════════════════════════════
 *
 *  OPSI A — HR PUSH ke website ini (Webhook):
 *    HR system POST ke: https://website-anda.com/api/sliders/sync
 *    Header: Authorization: Bearer {API_TOKEN_dari_.env}
 *
 *  OPSI B — Website ini PULL dari HR (Cron/Scheduled):
 *    Jalankan: php artisan slider:sync-from-hr
 *    atau tambahkan di app/Console/Kernel.php:
 *    $schedule->command('slider:sync-from-hr')->hourly();
 *
 * ══════════════════════════════════════════════════════
 */
class SliderApiController extends Controller
{
    /**
     * ── OPSI A: HR system push data berita ke sini (Webhook) ──
     *
     * Endpoint  : POST /api/sliders/sync
     * Header    : Authorization: Bearer {APP_API_TOKEN}
     * Body JSON :
     * {
     *   "action": "create" | "update" | "delete",
     *   "id": 123,                  // ID dari HR system
     *   "title": "Judul Berita",
     *   "image_url": "https://hr.example.com/storage/foto.jpg",
     *   "url": "https://hr.example.com/berita/123",
     *   "is_active": true
     * }
     */
    public function syncFromHR(Request $request)
    {
        // Validasi token (simpan APP_API_TOKEN di .env kedua sistem)
        $token = $request->bearerToken();
        if ($token !== config('app.api_token')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'action'    => 'required|in:create,update,delete',
            'id'        => 'required|integer',
            'title'     => 'required_unless:action,delete|string|max:255',
            'image_url' => 'required_unless:action,delete|url',
            'url'       => 'nullable|url',
            'is_active' => 'nullable|boolean',
        ]);

        $action     = $request->action;
        $externalId = $request->id;

        if ($action === 'delete') {
            $slider = Slider::where('external_id', $externalId)
                            ->where('source', 'api_hr')
                            ->first();
            if ($slider) {
                Storage::disk('public')->delete($slider->image_path);
                $slider->delete();
            }
            return response()->json(['success' => true, 'message' => 'Slider dihapus']);
        }

        // Download & simpan gambar dari HR system
        $imagePath = $this->downloadAndSaveImage($request->image_url, $externalId);

        if (!$imagePath) {
            return response()->json(['message' => 'Gagal mengunduh gambar dari HR'], 422);
        }

        $sliderData = [
            'title'       => $request->title,
            'image_path'  => $imagePath,
            'url'         => $request->url,
            'is_active'   => $request->boolean('is_active', true),
            'source'      => 'api_hr',
            'external_id' => $externalId,
        ];

        if ($action === 'create') {
            $sliderData['order'] = Slider::max('order') + 1;
            $slider = Slider::create($sliderData);
            return response()->json(['success' => true, 'id' => $slider->id], 201);
        }

        // update
        $slider = Slider::where('external_id', $externalId)
                        ->where('source', 'api_hr')
                        ->first();

        if (!$slider) {
            // Belum ada → buat baru
            $sliderData['order'] = Slider::max('order') + 1;
            $slider = Slider::create($sliderData);
        } else {
            // Hapus foto lama jika ganti
            if ($slider->image_path !== $imagePath) {
                Storage::disk('public')->delete($slider->image_path);
            }
            $slider->update($sliderData);
        }

        return response()->json(['success' => true, 'id' => $slider->id]);
    }

    /**
     * ── OPSI B: Website ini ambil data dari HR (dipakai oleh Artisan command) ──
     *
     * Tambahkan di .env:
     *   HR_API_URL=https://hr.perusahaan.com
     *   HR_API_TOKEN=token_rahasia_dari_hr
     */
    public function pullFromHR(): array
    {
        $hrUrl   = config('services.hr.url');
        $hrToken = config('services.hr.token');

        if (!$hrUrl || !$hrToken) {
            Log::warning('HR API URL/token belum dikonfigurasi di .env');
            return ['synced' => 0, 'error' => 'Konfigurasi tidak lengkap'];
        }

        try {
            $response = Http::withToken($hrToken)
                            ->timeout(15)
                            ->get("{$hrUrl}/api/berita/aktif"); // Sesuaikan endpoint HR-nya

            if (!$response->successful()) {
                Log::error('HR API error: ' . $response->status());
                return ['synced' => 0, 'error' => 'HR API error ' . $response->status()];
            }

            $beritaList = $response->json('data', []);
            $synced = 0;

            foreach ($beritaList as $berita) {
                $imagePath = $this->downloadAndSaveImage(
                    $berita['image_url'] ?? $berita['foto'],
                    $berita['id']
                );
                if (!$imagePath) continue;

                Slider::updateOrCreate(
                    ['external_id' => $berita['id'], 'source' => 'api_hr'],
                    [
                        'title'      => $berita['judul'] ?? $berita['title'],
                        'image_path' => $imagePath,
                        'url'        => $berita['url'] ?? null,
                        'is_active'  => $berita['is_active'] ?? true,
                        'order'      => $berita['urutan'] ?? 0,
                    ]
                );
                $synced++;
            }

            return ['synced' => $synced];

        } catch (\Exception $e) {
            Log::error('Gagal sync dari HR: ' . $e->getMessage());
            return ['synced' => 0, 'error' => $e->getMessage()];
        }
    }

    /**
     * Download gambar dari URL eksternal & simpan ke storage lokal
     */
    private function downloadAndSaveImage(string $imageUrl, int $externalId): ?string
    {
        try {
            // Cek apakah sudah ada (supaya tidak download ulang)
            $existing = Slider::where('external_id', $externalId)
                               ->where('source', 'api_hr')
                               ->first();

            if ($existing) return $existing->image_path;

            $response = Http::timeout(10)->get($imageUrl);
            if (!$response->successful()) return null;

            $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $filename  = "sliders/hr_{$externalId}.{$extension}";

            Storage::disk('public')->put($filename, $response->body());
            return $filename;

        } catch (\Exception $e) {
            Log::error("Gagal download gambar: {$imageUrl} — " . $e->getMessage());
            return null;
        }
    }
}