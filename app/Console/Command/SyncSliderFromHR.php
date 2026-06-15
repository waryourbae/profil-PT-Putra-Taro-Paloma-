<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\SliderApiController;
use Illuminate\Console\Command;

class SyncSliderFromHR extends Command
{
    protected $signature   = 'slider:sync-from-hr';
    protected $description = 'Sinkronisasi berita/slider dari sistem HR';

    public function handle(SliderApiController $api): int
    {
        $this->info('🔄 Mulai sinkronisasi dari HR...');

        $result = $api->pullFromHR();

        if (isset($result['error'])) {
            $this->error('❌ Error: ' . $result['error']);
            return Command::FAILURE;
        }

        $this->info("✅ Berhasil sync {$result['synced']} berita dari HR.");
        return Command::SUCCESS;
    }
}