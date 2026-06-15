<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

Route::get('/',              [LandingController::class, 'index'])->name('home');
Route::get('/berita',        [LandingController::class, 'beritaIndex'])->name('berita.index');
Route::get('/berita/{id}',   [LandingController::class, 'beritaDetail'])->name('berita.detail');
Route::get('/tentang-kami',  [LandingController::class, 'tentang'])->name('tentang');
Route::get('/kontak',        [LandingController::class, 'kontak'])->name('kontak');
Route::post('/kontak',       [LandingController::class, 'kontakSend'])->name('kontak.send');