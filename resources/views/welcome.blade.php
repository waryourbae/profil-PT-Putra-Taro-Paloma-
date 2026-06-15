<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PT Putra Taro Paloma') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green: #16a34a;
            --green-dark: #14532d;
            --green-light: #dcfce7;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-900: #111827;
            --transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--gray-900);
            color: var(--white);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ─── NAVBAR ─────────────────────────────── */
        #navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 16px 24px;
            transition: background 0.3s, box-shadow 0.3s;
        }
        #navbar.scrolled {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(12px);
            box-shadow: 0 1px 20px rgba(0,0,0,0.08);
        }
        .nav-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .nav-logo img { height: 36px; width: auto; }
        .nav-logo-fallback {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: var(--green);
            display: none;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }
        .nav-brand {
            font-weight: 700;
            font-size: 14px;
            color: white;
            transition: color 0.3s;
        }
        #navbar.scrolled .nav-brand { color: var(--gray-900); }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }
        .nav-links a {
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            color: rgba(255,255,255,0.85);
            position: relative;
            transition: color 0.3s;
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -3px; left: 0;
            width: 0; height: 2px;
            background: var(--green);
            border-radius: 2px;
            transition: width 0.3s;
        }
        .nav-links a:hover::after { width: 100%; }
        #navbar.scrolled .nav-links a { color: #374151; }
        #navbar.scrolled .nav-links a:hover { color: var(--green); }

        @media (max-width: 768px) {
            .nav-links { display: none; }
        }

        /* ─── SLIDER ─────────────────────────────── */
        .slider-container {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.8s ease, transform 0.8s ease;
            transform: scale(1.03);
        }
        .slide.active {
            opacity: 1;
            transform: scale(1);
            z-index: 2;
        }
        .slide.prev {
            opacity: 0;
            transform: scale(0.98);
            z-index: 1;
        }

        .slide-img {
            width: 100%; height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* Overlay gradient */
        .slide::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(0,0,0,0.72) 0%,
                rgba(0,0,0,0.35) 50%,
                rgba(0,0,0,0.15) 100%
            );
            z-index: 1;
        }

        /* Slide content */
        .slide-content {
            position: absolute;
            bottom: 15%;
            left: 6%;
            z-index: 3;
            max-width: 600px;
        }

        .slide-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--green);
            color: white;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 100px;
            margin-bottom: 16px;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s 0.2s ease, transform 0.5s 0.2s ease;
        }
        .slide.active .slide-badge {
            opacity: 1;
            transform: translateY(0);
        }

        .slide-title {
            font-family: 'Fraunces', serif;
            font-size: clamp(28px, 4vw, 52px);
            font-weight: 700;
            line-height: 1.15;
            color: white;
            margin-bottom: 20px;
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.5s 0.35s ease, transform 0.5s 0.35s ease;
        }
        .slide.active .slide-title {
            opacity: 1;
            transform: translateY(0);
        }

        .slide-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: var(--gray-900);
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 8px;
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s 0.5s ease, transform 0.5s 0.5s ease,
                        background 0.2s, box-shadow 0.2s;
        }
        .slide.active .slide-btn {
            opacity: 1;
            transform: translateY(0);
        }
        .slide-btn:hover {
            background: var(--green-light);
            box-shadow: 0 8px 24px rgba(22,163,74,0.25);
        }
        .slide-btn i { font-size: 12px; }

        /* ─── ARROW CONTROLS ─────────────────────── */
        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            width: 52px; height: 52px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.4);
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(8px);
            color: white;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, border-color 0.2s, transform 0.2s;
        }
        .slider-arrow:hover {
            background: var(--green);
            border-color: var(--green);
            transform: translateY(-50%) scale(1.08);
        }
        .slider-arrow.prev { left: 24px; }
        .slider-arrow.next { right: 24px; }

        /* ─── PROGRESS BAR ────────────────────────── */
        .slider-progress {
            position: absolute;
            bottom: 0; left: 0;
            height: 3px;
            background: var(--green);
            z-index: 10;
            transition: none;
        }
        .slider-progress.animating {
            transition: width linear;
        }

        /* ─── SLIDE COUNTER ───────────────────────── */
        .slide-counter {
            position: absolute;
            bottom: 32px;
            right: 40px;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.7);
        }
        .slide-counter .current { color: white; font-size: 22px; font-family: 'Fraunces', serif; }
        .slide-counter .sep { color: rgba(255,255,255,0.3); }

        /* ─── EMPTY STATE ─────────────────────────── */
        .slider-empty {
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #064e3b 0%, #14532d 50%, #1a1a2e 100%);
            text-align: center;
            padding: 40px;
        }
        .slider-empty .empty-icon {
            width: 80px; height: 80px;
            border-radius: 20px;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 24px;
        }
        .slider-empty h2 {
            font-family: 'Fraunces', serif;
            font-size: 32px;
            color: white;
            margin-bottom: 12px;
        }
        .slider-empty p {
            color: rgba(255,255,255,0.6);
            font-size: 15px;
            max-width: 360px;
            line-height: 1.6;
        }
    </style>
</head>
<body>

{{-- ── NAVBAR ──────────────────────────────────────────────── --}}
<nav id="navbar">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-logo">
            <img src="/images/logo-fks.png" alt="Logo"
                onerror="this.style.display='none';document.querySelector('.nav-logo-fallback').style.display='flex'">
            <span class="nav-logo-fallback">T</span>
            <span class="nav-brand">PT Putra Taro Paloma</span>
        </a>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}#berita">Berita</a></li>
            <li><a href="{{ route('tentang') }}">Tentang Kami</a></li>
            <li><a href="{{ route('kontak') }}">Kontak</a></li>
        </ul>
    </div>
</nav>

{{-- ── SLIDER ───────────────────────────────────────────────── --}}
@php $sliders = \App\Models\Slider::where('is_active', true)->orderBy('order')->get(); @endphp

@if($sliders->count() > 0)
<div class="slider-container" id="mainSlider">

    @foreach($sliders as $i => $slide)
    <div class="slide {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}">
        <img
            src="{{ Storage::url($slide->image_path) }}"
            alt="{{ $slide->title }}"
            class="slide-img"
            loading="{{ $i === 0 ? 'eager' : 'lazy' }}"
        >
        <div class="slide-content">
            <span class="slide-badge">
                <i class="fas fa-newspaper"></i>
                Berita Terbaru
            </span>
            <h2 class="slide-title">{{ $slide->title }}</h2>
            @if($slide->url)
            <a href="{{ $slide->url }}" class="slide-btn">
                Baca Selengkapnya
                <i class="fas fa-arrow-right"></i>
            </a>
            @endif
        </div>
    </div>
    @endforeach

    {{-- Arrow Controls --}}
    @if($sliders->count() > 1)
    <button class="slider-arrow prev" onclick="sliderPrev()" aria-label="Sebelumnya">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="slider-arrow next" onclick="sliderNext()" aria-label="Berikutnya">
        <i class="fas fa-chevron-right"></i>
    </button>

    {{-- Progress & Counter --}}
    <div class="slider-progress" id="sliderProgress"></div>
    <div class="slide-counter">
        <span class="current" id="counterCurrent">1</span>
        <span class="sep">/</span>
        <span id="counterTotal">{{ $sliders->count() }}</span>
    </div>
    @endif

</div>

@else
{{-- Empty State --}}
<div class="slider-empty">
    <div class="empty-icon">📰</div>
    <h2>Belum Ada Berita</h2>
    <p>Tambahkan berita/slider melalui panel admin untuk ditampilkan di sini.</p>
</div>
@endif

<script>
(function() {
    const DURATION = 5000; // 5 detik per slide
    const slides = document.querySelectorAll('.slide');
    const progress = document.getElementById('sliderProgress');
    const counterCurrent = document.getElementById('counterCurrent');
    const total = slides.length;

    if (total <= 1) return;

    let current = 0;
    let timer = null;
    let paused = false;

    function goTo(index) {
        slides[current].classList.remove('active');
        slides[current].classList.add('prev');
        setTimeout(() => slides[current].classList.remove('prev'), 800);

        current = (index + total) % total;
        slides[current].classList.add('active');
        if (counterCurrent) counterCurrent.textContent = current + 1;
        resetProgress();
    }

    function resetProgress() {
        if (!progress) return;
        progress.style.transition = 'none';
        progress.style.width = '0%';
        // Force reflow
        progress.offsetWidth;
        progress.classList.add('animating');
        progress.style.transitionDuration = DURATION + 'ms';
        progress.style.width = '100%';
    }

    function startTimer() {
        clearInterval(timer);
        timer = setInterval(() => {
            if (!paused) goTo(current + 1);
        }, DURATION);
    }

    window.sliderNext = () => { goTo(current + 1); startTimer(); };
    window.sliderPrev = () => { goTo(current - 1); startTimer(); };

    // Pause on hover
    const container = document.getElementById('mainSlider');
    if (container) {
        container.addEventListener('mouseenter', () => paused = true);
        container.addEventListener('mouseleave', () => paused = false);
    }

    // Touch swipe support
    let touchStartX = 0;
    if (container) {
        container.addEventListener('touchstart', e => touchStartX = e.touches[0].clientX, { passive: true });
        container.addEventListener('touchend', e => {
            const diff = touchStartX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 50) {
                diff > 0 ? sliderNext() : sliderPrev();
            }
        }, { passive: true });
    }

    // Init
    resetProgress();
    startTimer();
})();

// Navbar scroll effect
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 50);
}, { passive: true });
</script>
</body>
</html>