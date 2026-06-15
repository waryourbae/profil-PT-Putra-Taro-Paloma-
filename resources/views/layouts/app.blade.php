<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PT Putra Taro Paloma')</title>
    <meta name="description" content="@yield('description', 'PT Putra Taro Paloma')">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Fraunces', serif; }

        /* Navbar default: transparan */
        #navbar {
            transition: background 0.35s, box-shadow 0.35s, padding 0.35s;
            background: transparent;
        }
        #navbar.scrolled {
            background: #2d7a2d;
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
        }

        @keyframes fadeUp  { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeIn  { from{opacity:0} to{opacity:1} }
        @keyframes scaleIn { from{opacity:0;transform:scale(0.95)} to{opacity:1;transform:scale(1)} }
        .animate-fadeUp  { animation: fadeUp  0.6s ease both; }
        .animate-fadeIn  { animation: fadeIn  0.5s ease both; }
        .animate-scaleIn { animation: scaleIn 0.5s ease both; }
        .delay-100 { animation-delay:0.1s; } .delay-200 { animation-delay:0.2s; }
        .delay-300 { animation-delay:0.3s; } .delay-400 { animation-delay:0.4s; }

        .news-card { transition: transform 0.3s, box-shadow 0.3s; }
        .news-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }

        .line-clamp-2 { display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; }
        .line-clamp-3 { display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden; }

        ::-webkit-scrollbar { width:6px; }
        ::-webkit-scrollbar-track { background:#f1f5f9; }
        ::-webkit-scrollbar-thumb { background:#94a3b8; border-radius:3px; }
    </style>
    @stack('styles')
</head>
<body class="bg-white text-gray-900 antialiased">

{{-- ── NAVBAR ───────────────────────────────────────────────────────────── --}}
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 py-4 px-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            <img src="/images/logo-fks.png" alt="FKS Food" class="h-9 w-auto"
                onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
            <div style="display:none" class="w-9 h-9 rounded-xl bg-green-600 items-center justify-center text-white font-bold text-base flex">T</div>
            <div class="hidden sm:block">
                <p class="font-bold text-sm leading-tight text-white tracking-tight">PT Putra Taro Paloma</p>
            </div>
        </a>

        {{-- Desktop Menu --}}
        <div class="hidden lg:flex items-center gap-1">
            <a href="{{ route('home') }}"
               class="text-sm font-bold px-4 py-2 rounded-lg transition-all"
               style="color:rgba(255,255,255,.88)"
               onmouseover="this.style.background='rgba(255,255,255,.15)'"
               onmouseout="this.style.background='transparent'">Beranda</a>

            <a href="{{ route('berita.index') }}"
               class="text-sm font-bold px-4 py-2 rounded-lg transition-all {{ request()->routeIs('berita*') ? 'bg-white/15' : '' }}"
               style="color:rgba(255,255,255,.88)"
               onmouseover="this.style.background='rgba(255,255,255,.15)'"
               onmouseout="this.style.background='{{ request()->routeIs('berita*') ? 'rgba(255,255,255,.15)' : 'transparent' }}'">Berita</a>

            <a href="{{ route('tentang') }}"
               class="text-sm font-bold px-4 py-2 rounded-lg transition-all {{ request()->routeIs('tentang') ? 'bg-white/15' : '' }}"
               style="color:rgba(255,255,255,.88)"
               onmouseover="this.style.background='rgba(255,255,255,.15)'"
               onmouseout="this.style.background='{{ request()->routeIs('tentang') ? 'rgba(255,255,255,.15)' : 'transparent' }}'">Tentang Kami</a>

            {{-- Tombol Login --}}
            <a href="/login"
               title="Login"
               class="ml-3 flex items-center justify-center w-10 h-10 rounded-full transition-all"
               style="background:rgba(255,255,255,.15);color:white;"
               onmouseover="this.style.background='white';this.style.color='#2d7a2d';this.style.transform='translateY(-2px)'"
               onmouseout="this.style.background='rgba(255,255,255,.15)';this.style.color='white';this.style.transform='translateY(0)'">
               <i class="fas fa-user text-sm"></i>
            </a>
        </div>

        {{-- Mobile toggle --}}
        <button id="mobileToggle" class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center text-white transition" style="background:rgba(255,255,255,.15)">
            <i class="fas fa-bars" id="menuIconOpen"></i>
            <i class="fas fa-times hidden" id="menuIconClose"></i>
        </button>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobileMenu" class="hidden lg:hidden mt-3 mx-0 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
        <div class="p-4 space-y-1">
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-700 font-semibold text-sm transition">
                <i class="fas fa-home w-4 text-center text-green-600"></i> Beranda
            </a>
            <a href="{{ route('berita.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-700 font-semibold text-sm transition">
                <i class="fas fa-newspaper w-4 text-center text-green-600"></i> Berita
            </a>
            <a href="{{ route('tentang') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-green-50 hover:text-green-700 font-semibold text-sm transition">
                <i class="fas fa-info-circle w-4 text-center text-green-600"></i> Tentang Kami
            </a>
            <a href="/login" class="flex items-center gap-3 px-4 py-3 rounded-xl font-extrabold text-sm transition" style="color:#2d7a2d">
                <i class="fas fa-user w-4 text-center" style="color:#2d7a2d"></i> Login
            </a>
        </div>
    </div>
</nav>

{{-- ── CONTENT ───────────────────────────────────────────────────────────── --}}
@yield('content')

{{-- ── FOOTER — disembunyikan di halaman berita ─────────────────────────── --}}
@unless(request()->routeIs('berita*'))
<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-5">
                    <img src="/images/logo-fks.png" alt="Logo" class="h-10 w-auto"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    <div style="display:none" class="w-10 h-10 rounded-xl bg-green-600 items-center justify-center text-white font-bold flex">T</div>
                    <p class="font-bold text-white">PT Putra Taro Paloma</p>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
                    Produsen makanan ringan berkualitas tinggi yang telah melayani konsumen Indonesia.
                </p>
                <div class="flex gap-3 mt-5">
                    <a href="#" class="w-9 h-9 rounded-lg bg-gray-800 hover:bg-green-600 flex items-center justify-center text-gray-400 hover:text-white transition">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-gray-800 hover:bg-green-600 flex items-center justify-center text-gray-400 hover:text-white transition">
                        <i class="fab fa-facebook text-sm"></i>
                    </a>
                </div>
            </div>
            <div>
                <h3 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Menu</h3>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-green-500"></i> Beranda</a></li>
                    <li><a href="{{ route('berita.index') }}" class="hover:text-white transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-green-500"></i> Berita</a></li>
                    <li><a href="{{ route('tentang') }}" class="hover:text-white transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-green-500"></i> Tentang Kami</a></li>
                    <li><a href="{{ route('kontak') }}" class="hover:text-white transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-green-500"></i> Kontak</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Kontak</h3>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-1 text-green-500 flex-shrink-0"></i>
                        <span>Jl. Pancasila IV, Desa Cicadas, Gn. Putri, Bogor</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone text-green-500 flex-shrink-0"></i>
                        <span>0822-2161-3388</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-green-500 flex-shrink-0"></i>
                        <span>admin@taropaloma.com</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col md:flex-row items-center justify-between gap-3 text-sm text-gray-500">
            <p>© {{ date('Y') }} PT Putra Taro Paloma. All rights reserved.</p>
            <p>Made with <span class="text-red-400">♥</span> in Indonesia</p>
        </div>
    </div>
</footer>
@endunless

<script>
const navbar = document.getElementById('navbar');

window.addEventListener('scroll', function () {
    navbar.classList.toggle('scrolled', window.scrollY > 60);
}, { passive: true });

document.getElementById('mobileToggle').addEventListener('click', function() {
    const menu = document.getElementById('mobileMenu');
    const open = menu.classList.toggle('hidden');
    document.getElementById('menuIconOpen').classList.toggle('hidden', !open);
    document.getElementById('menuIconClose').classList.toggle('hidden', open);
});
</script>
@stack('scripts')
</body>
</html>