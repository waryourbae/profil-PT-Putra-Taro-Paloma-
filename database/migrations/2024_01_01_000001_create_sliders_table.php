<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title');               // Judul berita
            $table->string('image_path');           // Path foto (storage)
            $table->string('url')->nullable();      // Link 'Baca Selengkapnya'
            $table->integer('order')->default(0);   // Urutan tampil
            $table->boolean('is_active')->default(true);
            $table->string('source')->default('manual'); // 'manual' atau 'api_hr'
            $table->unsignedBigInteger('external_id')->nullable(); // ID dari HR system
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};