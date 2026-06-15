<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    private function hrApiUrl(): string
    {
        return config('services.hr.url', 'http://hr.putrataropaloma.com');
    }

    public function index()
    {
        $featured = Cache::remember('landing_featured', 300, function () {
            try {
                $response = Http::timeout(5)->get($this->hrApiUrl() . '/api/news', [
                    'featured' => 1,
                    'limit'    => 5,
                ]);

                if ($response->successful()) {
                    return $response->json('data', []);
                }
            } catch (\Exception $e) {
                Log::warning('HR API tidak bisa diakses: ' . $e->getMessage());
            }

            return [];
        });

        return view('pages.home', compact('featured'));
    }

    public function beritaIndex()
    {
        // Slider hero — ambil berita featured (sama seperti home)
        $featured = Cache::remember('landing_featured', 300, function () {
            try {
                $response = Http::timeout(5)->get($this->hrApiUrl() . '/api/news', [
                    'featured' => 1,
                    'limit'    => 5,
                ]);

                if ($response->successful()) {
                    return $response->json('data', []);
                }
            } catch (\Exception $e) {
                Log::warning('HR API tidak bisa diakses: ' . $e->getMessage());
            }

            return [];
        });

        // Semua berita untuk grid di bawah hero
        $berita = Cache::remember('landing_berita_all', 300, function () {
            try {
                $response = Http::timeout(5)->get($this->hrApiUrl() . '/api/news', [
                    'limit' => 12,
                ]);

                if ($response->successful()) {
                    return $response->json('data', []);
                }
            } catch (\Exception $e) {
                Log::warning('HR API tidak bisa diakses: ' . $e->getMessage());
            }

            return [];
        });

        return view('pages.berita.index', compact('featured', 'berita'));
    }

    public function beritaDetail($id)
    {
        try {
            $response = Http::timeout(5)->get($this->hrApiUrl() . "/api/news/{$id}");

            if ($response->successful()) {
                $berita = $response->json('data');
                if ($berita) {
                    return view('pages.berita-detail', compact('berita'));
                }
            }
        } catch (\Exception $e) {
            Log::warning('HR API detail error: ' . $e->getMessage());
        }

        abort(404);
    }

    public function tentang()
    {
        return view('pages.tentang');
    }

    public function kontak()
    {
        return view('pages.kontak');
    }

    public function kontakSend()
    {
        // TODO: handle form kontak
    }
}