@extends('layouts.app')
@section('title', ($news['title'] ?? 'Detail Berita') . ' - PT Putra Taro Paloma')
@section('description', $news['excerpt'] ?? '')

@section('content')

{{-- Hero image --}}
<div class="relative h-72 md:h-96 bg-gray-900 overflow-hidden mt-0">
    <img src="{{ $news['image_detail'] ?? $news['image_slider'] ?? $news['image'] ?? 'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=1920' }}"
         alt="{{ $news['title'] }}"
         class="w-full h-full object-cover opacity-60">
    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10">
        <div class="max-w-4xl mx-auto">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-600 text-white text-xs font-bold rounded-full mb-3 uppercase tracking-wide">
                {{ $news['category'] ?? 'Berita' }}
            </span>
            <h1 class="font-display text-2xl md:text-4xl font-bold text-white leading-tight animate-fadeUp">
                {{ $news['title'] }}
            </h1>
        </div>
    </div>
</div>

{{-- Content --}}
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Meta --}}
    <div class="flex items-center gap-5 text-sm text-gray-500 mb-8 pb-8 border-b border-gray-100">
        <span class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-user text-green-600 text-xs"></i>
            </div>
            <span class="font-semibold text-gray-700">{{ $news['author'] ?? 'Admin' }}</span>
        </span>
        <span class="flex items-center gap-2">
            <i class="fas fa-calendar text-green-500"></i>
            {{ isset($news['publishedAt']) ? \Carbon\Carbon::parse($news['publishedAt'])->translatedFormat('d F Y') : '-' }}
        </span>
        <a href="{{ route('home') }}#berita" class="ml-auto flex items-center gap-2 text-green-600 hover:text-green-700 font-semibold transition">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>

    {{-- Excerpt --}}
    @if($news['excerpt'] ?? null)
    <p class="text-xl text-gray-600 leading-relaxed mb-8 font-medium italic border-l-4 border-green-500 pl-5 bg-green-50 py-4 rounded-r-xl">
        {{ $news['excerpt'] }}
    </p>
    @endif

    {{-- Body --}}
    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed space-y-4">
        {!! nl2br(e($news['content'] ?? 'Konten tidak tersedia.')) !!}
    </div>

    {{-- Share --}}
    <div class="mt-12 pt-8 border-t border-gray-100">
        <p class="text-sm font-bold text-gray-500 mb-3 uppercase tracking-wider">Bagikan Berita</p>
        <div class="flex gap-3">
            <a href="https://wa.me/?text={{ urlencode($news['title'] . ' - ' . url()->current()) }}" target="_blank"
                class="flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl text-sm font-semibold transition">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
                class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition">
                <i class="fab fa-facebook"></i> Facebook
            </a>
        </div>
    </div>
</article>

{{-- Related --}}
@if(count($related) > 0)
<section class="bg-gray-50 py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="font-display text-2xl font-bold text-gray-900 mb-8">Berita Lainnya</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($related as $item)
            <a href="{{ route('berita.detail', $item['id']) }}"
                class="news-card bg-white rounded-2xl overflow-hidden border border-gray-100 block">
                <div class="h-40 bg-gray-100 overflow-hidden">
                    <img src="{{ $item['image_slider'] ?? $item['image'] ?? 'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=800' }}"
                         alt="{{ $item['title'] }}"
                         class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                </div>
                <div class="p-4">
                    <span class="text-xs text-green-600 font-bold">{{ $item['category'] ?? 'Berita' }}</span>
                    <h4 class="font-bold text-gray-800 text-sm mt-1 line-clamp-2 hover:text-green-600 transition-colors">
                        {{ $item['title'] }}
                    </h4>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
