@extends('layouts.app')
@section('title', 'Tentang Kami - PT Putra Taro Paloma')
@section('description', 'Mengenal lebih dekat PT Putra Taro Paloma, produsen makanan ringan berkualitas tinggi.')

@section('content')

{{-- Hero --}}
<div class="relative bg-gradient-to-br from-green-800 to-emerald-600 pt-32 pb-20 overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle,white 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-2xl animate-fadeUp">
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 text-white text-xs font-bold rounded-full mb-5 uppercase tracking-wider">
                <i class="fas fa-building"></i> Profil Perusahaan
            </span>
            <h1 class="font-display text-5xl font-bold text-white mb-5 leading-tight">
                Tentang PT Putra Taro Paloma
            </h1>
            <p class="text-green-100 text-lg leading-relaxed">
                Lebih dari 30 tahun kami hadir menghadirkan produk makanan ringan berkualitas tinggi untuk keluarga Indonesia.
            </p>
        </div>
    </div>
</div>

{{-- Visi Misi --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="animate-fadeUp">
                <span class="text-green-600 font-bold text-sm uppercase tracking-wider">Siapa Kami</span>
                <h2 class="font-display text-4xl font-bold text-gray-900 mt-2 mb-6">Perusahaan Makanan Ringan Terpercaya</h2>
                <p class="text-gray-600 leading-relaxed mb-5">
                    PT Putra Taro Paloma adalah perusahaan manufaktur makanan ringan yang berdiri sejak tahun 1993. Berlokasi di Gunung Putri, Bogor, kami telah menjadi salah satu produsen makanan ringan terkemuka di Indonesia.
                </p>
                <p class="text-gray-600 leading-relaxed mb-5">
                    Dengan lebih dari 500 karyawan dan fasilitas produksi modern, kami berkomitmen untuk menghasilkan produk yang aman, berkualitas, dan lezat untuk dinikmati oleh seluruh keluarga Indonesia.
                </p>
                <div class="flex gap-4 mt-8">
                    <a href="{{ route('kontak') }}"
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-sm transition hover:scale-105 shadow-lg shadow-green-500/20">
                        <i class="fas fa-envelope mr-2"></i> Hubungi Kami
                    </a>
                </div>
            </div>

            {{-- Visi Misi Cards --}}
            <div class="space-y-5 animate-fadeUp delay-200">
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-100 rounded-2xl p-7">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-green-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-green-500/30">
                            <i class="fas fa-eye text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg mb-2">Visi</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Menjadi perusahaan makanan ringan terkemuka di Asia Tenggara yang mengutamakan kualitas, inovasi, dan kepuasan pelanggan.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 rounded-2xl p-7">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-500/30">
                            <i class="fas fa-bullseye text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg mb-2">Misi</h3>
                            <ul class="text-gray-600 text-sm leading-relaxed space-y-1.5">
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-blue-500 mt-0.5 text-xs flex-shrink-0"></i> Menghasilkan produk berkualitas tinggi dengan standar internasional</li>
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-blue-500 mt-0.5 text-xs flex-shrink-0"></i> Menciptakan lapangan kerja dan berkontribusi pada masyarakat</li>
                                <li class="flex items-start gap-2"><i class="fas fa-check-circle text-blue-500 mt-0.5 text-xs flex-shrink-0"></i> Berinovasi secara berkelanjutan untuk memenuhi kebutuhan konsumen</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Nilai Perusahaan --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 animate-fadeUp">
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-bold mb-4">
                <i class="fas fa-star text-xs"></i> Nilai Kami
            </span>
            <h2 class="font-display text-4xl font-bold text-gray-900">Yang Kami Junjung Tinggi</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
            @foreach([
                ['icon'=>'fa-shield-alt','color'=>'green','title'=>'Kualitas','desc'=>'Setiap produk kami melewati standar kontrol kualitas yang ketat untuk memastikan produk terbaik sampai ke tangan konsumen.'],
                ['icon'=>'fa-leaf','color'=>'emerald','title'=>'Keberlanjutan','desc'=>'Kami berkomitmen pada praktik bisnis yang ramah lingkungan dan berkelanjutan untuk generasi mendatang.'],
                ['icon'=>'fa-users','color'=>'blue','title'=>'Karyawan','desc'=>'Kami percaya bahwa karyawan adalah aset terbesar kami dan selalu mengutamakan kesejahteraan mereka.'],
            ] as $i => $val)
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm animate-scaleIn delay-{{ $i * 100 + 100 }}">
                <div class="w-14 h-14 rounded-2xl bg-{{ $val['color'] }}-100 flex items-center justify-center mb-5">
                    <i class="fas {{ $val['icon'] }} text-{{ $val['color'] }}-600 text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-3">{{ $val['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $val['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Lokasi --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="animate-fadeUp">
                <span class="text-green-600 font-bold text-sm uppercase tracking-wider">Lokasi Kami</span>
                <h2 class="font-display text-4xl font-bold text-gray-900 mt-2 mb-6">Temukan Kami</h2>
                <div class="space-y-5">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Alamat</p>
                            <p class="text-gray-500 text-sm mt-1">Jl. Pancasila IV, Desa Cicadas, Kec. Gunung Putri, Kabupaten Bogor, Jawa Barat</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Telepon</p>
                            <p class="text-gray-500 text-sm mt-1">0822-2161-3388</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Email</p>
                            <p class="text-gray-500 text-sm mt-1">admin@taropaloma.com</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Jam Operasional</p>
                            <p class="text-gray-500 text-sm mt-1">Senin – Jumat: 08.00 – 17.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="animate-fadeUp delay-200">
                <div class="rounded-2xl overflow-hidden shadow-xl border border-gray-100 h-80">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.3!2d107.0!3d-6.47!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMjgnMDYuMCJTIDEwN8KwMDAnMDYuMCJF!5e0!3m2!1sid!2sid!4v1234567890"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
