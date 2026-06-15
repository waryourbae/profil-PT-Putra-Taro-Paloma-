@extends('layouts.app')
@section('title', 'Kontak - PT Putra Taro Paloma')
@section('description', 'Hubungi PT Putra Taro Paloma. Kami siap membantu Anda.')

@section('content')

{{-- Hero --}}
<div class="relative bg-gradient-to-br from-gray-900 to-gray-800 pt-32 pb-20 overflow-hidden">
    <div class="absolute inset-0 opacity-5" style="background-image:radial-gradient(circle,white 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center animate-fadeUp">
        <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-600/20 text-green-400 text-xs font-bold rounded-full mb-5 uppercase tracking-wider border border-green-500/30">
            <i class="fas fa-envelope"></i> Hubungi Kami
        </span>
        <h1 class="font-display text-5xl font-bold text-white mb-5">Ada yang Bisa Kami Bantu?</h1>
        <p class="text-gray-400 text-lg max-w-xl mx-auto">Jangan ragu untuk menghubungi kami. Tim kami siap membantu Anda.</p>
    </div>
</div>

<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- Info Cards --}}
            <div class="space-y-5 animate-fadeUp">
                @foreach([
                    ['icon'=>'fa-map-marker-alt','color'=>'green','title'=>'Alamat','val'=>'Jl. Pancasila IV, Desa Cicadas, Gn. Putri, Bogor, Jawa Barat'],
                    ['icon'=>'fa-phone','color'=>'blue','title'=>'Telepon','val'=>'0822-2161-3388'],
                    ['icon'=>'fa-envelope','color'=>'violet','title'=>'Email','val'=>'admin@taropaloma.com'],
                    ['icon'=>'fa-clock','color'=>'amber','title'=>'Jam Kerja','val'=>'Senin – Jumat, 08.00–17.00 WIB'],
                ] as $item)
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-start gap-4">
                    <div class="w-11 h-11 rounded-xl bg-{{ $item['color'] }}-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas {{ $item['icon'] }} text-{{ $item['color'] }}-600"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm">{{ $item['title'] }}</p>
                        <p class="text-gray-500 text-sm mt-1 leading-relaxed">{{ $item['val'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Form --}}
            <div class="lg:col-span-2 animate-fadeUp delay-200">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <h2 class="font-display text-2xl font-bold text-gray-900 mb-2">Kirim Pesan</h2>
                    <p class="text-gray-500 text-sm mb-8">Isi form di bawah ini dan kami akan segera menghubungi Anda.</p>

                    @if(session('success'))
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 mb-6 text-sm text-green-700">
                        <i class="fas fa-check-circle text-green-500"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('kontak.send') }}" class="space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="nama" required value="{{ old('nama') }}"
                                    placeholder="Masukkan nama Anda..."
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-gray-50 focus:bg-white @error('nama') border-red-400 @enderror">
                                @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" required value="{{ old('email') }}"
                                    placeholder="email@contoh.com"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-gray-50 focus:bg-white @error('email') border-red-400 @enderror">
                                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">No. Telepon</label>
                            <input type="text" name="telepon" value="{{ old('telepon') }}"
                                placeholder="08xx-xxxx-xxxx"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-gray-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider">Pesan <span class="text-red-500">*</span></label>
                            <textarea name="pesan" rows="5" required
                                placeholder="Tuliskan pesan atau pertanyaan Anda..."
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-gray-50 focus:bg-white resize-none @error('pesan') border-red-400 @enderror">{{ old('pesan') }}</textarea>
                            @error('pesan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit"
                            class="w-full py-4 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-sm transition hover:scale-[1.02] shadow-lg shadow-green-500/20 flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
