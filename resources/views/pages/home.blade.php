@extends('layouts.app')
@section('title', 'Berita - PT Putra Taro Paloma')
@section('description', 'Ikuti berita dan informasi terkini dari PT Putra Taro Paloma.')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --green-main:  #2d7a2d;
    --green-mid:   #3a8f3a;
    --green-light: #4aad4a;
    --cream:       #f5f0e4;
    --cream-soft:  #faf7f0;
    --dark-text:   #1a2e1a;
}

body { font-family: 'Plus Jakarta Sans', sans-serif; }

/* ══════════════════════════════
   HERO SLIDER BERITA
══════════════════════════════ */
.hero-berita {
    position: relative;
    width: 100%;
    height: 100vh;
    min-height: 560px;
    max-height: 820px;
    overflow: hidden;
    background: var(--green-main);
}

.hb-slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity .85s ease;
    pointer-events: none;
}
.hb-slide.active {
    opacity: 1;
    pointer-events: auto;
}

.hb-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    transform: scale(1.06);
    transition: transform 7s cubic-bezier(.25,.46,.45,.94);
}
.hb-slide.active .hb-bg { transform: scale(1); }

.hb-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to top,
        rgba(10,35,10,.92) 0%,
        rgba(15,45,15,.65) 40%,
        rgba(20,55,20,.35) 100%
    );
    z-index: 1;
}

.hb-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
    background-size: 56px 56px;
    z-index: 2;
    pointer-events: none;
}

.hb-content {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    z-index: 10;
    padding: 0 80px 80px;
    max-width: 900px;
}

.hb-breadcrumb {
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 22px;
    opacity: 0; transform: translateY(8px);
    transition: opacity .5s .05s, transform .5s .05s;
}
.hb-slide.active .hb-breadcrumb { opacity: 1; transform: translateY(0); }
.hb-breadcrumb a {
    font-size: 12px; font-weight: 600;
    color: rgba(255,255,255,.5); text-decoration: none;
    transition: color .2s;
}
.hb-breadcrumb a:hover { color: rgba(255,255,255,.8); }
.hb-breadcrumb span { font-size: 12px; color: rgba(255,255,255,.35); }
.hb-breadcrumb .bc-active { font-size: 12px; color: rgba(255,255,255,.65); font-weight: 600; }

.hb-cat {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: 10px; font-weight: 800;
    letter-spacing: .13em; text-transform: uppercase;
    color: #a7f3a7; margin-bottom: 14px;
    opacity: 0; transform: translateY(8px);
    transition: opacity .5s .15s, transform .5s .15s;
}
.hb-slide.active .hb-cat { opacity: 1; transform: translateY(0); }
.hb-cat-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--green-light);
    animation: catpulse 2.2s infinite;
}
@keyframes catpulse {
    0%,100% { opacity: 1; transform: scale(1); }
    50%      { opacity: .35; transform: scale(.65); }
}

.hb-title {
    font-family: 'Fraunces', Georgia, serif;
    font-size: clamp(15px, 3.8vw, 25px);
    font-weight: 700; color: white; line-height: 1.14;
    text-shadow: 0 4px 28px rgba(0,0,0,.4);
    display: -webkit-box;
    -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    margin-bottom: 18px;
    opacity: 0; transform: translateY(18px);
    transition: opacity .6s .25s, transform .6s .25s;
}
.hb-slide.active .hb-title { opacity: 1; transform: translateY(0); }

.hb-excerpt {
    font-size: 15px; color: rgba(255,255,255,.62);
    line-height: 1.75; max-width: 560px;
    display: -webkit-box;
    -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    margin-bottom: 28px;
    opacity: 0; transform: translateY(12px);
    transition: opacity .55s .38s, transform .55s .38s;
}
.hb-slide.active .hb-excerpt { opacity: 1; transform: translateY(0); }

.hb-bottom {
    display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
    opacity: 0; transform: translateY(10px);
    transition: opacity .55s .5s, transform .55s .5s;
}
.hb-slide.active .hb-bottom { opacity: 1; transform: translateY(0); }

.hb-meta { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
.hb-meta-item {
    display: flex; align-items: center; gap: 5px;
    font-size: 12px; color: rgba(255,255,255,.52);
}
.hb-meta-item i { color: var(--green-light); font-size: 10px; }
.hb-meta-sep { width: 1px; height: 14px; background: rgba(255,255,255,.2); }

.hb-btn {
    display: inline-flex; align-items: center; gap: 9px;
    background: white; color: var(--green-main);
    font-size: 13px; font-weight: 800;
    padding: 13px 26px; border-radius: 12px;
    text-decoration: none;
    transition: transform .2s, box-shadow .2s;
    box-shadow: 0 4px 20px rgba(0,0,0,.2);
    white-space: nowrap;
}
.hb-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(0,0,0,.3); }
.hb-btn-icon {
    width: 26px; height: 26px; border-radius: 7px;
    background: rgba(45,122,45,.12);
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; transition: transform .2s;
}
.hb-btn:hover .hb-btn-icon { transform: translateX(3px); }

.hb-prog {
    position: absolute;
    bottom: 0; left: 0;
    height: 3px; width: 0;
    background: linear-gradient(90deg, var(--green-light), white);
    border-radius: 0 2px 0 0;
    z-index: 20;
}

.hb-controls {
    position: absolute;
    right: 80px; bottom: 80px;
    z-index: 20;
    display: flex; flex-direction: column; align-items: flex-end; gap: 16px;
}
.hb-dots { display: flex; align-items: center; gap: 7px; }
.hb-dot {
    width: 6px; height: 6px; border-radius: 4px;
    background: rgba(255,255,255,.3); border: none;
    cursor: pointer; padding: 0;
    transition: all .35s cubic-bezier(.34,1.56,.64,1);
}
.hb-dot.active { background: white; width: 24px; }
.hb-dot:hover  { background: rgba(255,255,255,.6); }

.hb-counter {
    font-family: 'Fraunces', serif;
    font-size: 13px; font-weight: 400;
    color: rgba(255,255,255,.4);
}
.hb-counter strong {
    font-size: 22px; font-weight: 700;
    color: white; margin-right: 2px;
}

.hb-arrow {
    position: absolute;
    top: 50%; transform: translateY(-50%);
    z-index: 20;
    width: 46px; height: 46px; border-radius: 50%;
    border: 1.5px solid rgba(255,255,255,.3);
    background: rgba(255,255,255,.1);
    backdrop-filter: blur(8px);
    color: white; cursor: pointer; font-size: 20px;
    display: flex; align-items: center; justify-content: center;
    transition: all .25s;
}
.hb-arrow:hover {
    background: white; border-color: white;
    color: var(--green-main); transform: translateY(-50%) scale(1.07);
}
.hb-arrow.prev { left: 32px; }
.hb-arrow.next { right: 32px; }

.hb-scroll {
    position: absolute;
    bottom: 32px; left: 50%; transform: translateX(-50%);
    z-index: 20;
    display: flex; flex-direction: column; align-items: center; gap: 6px;
    animation: bob 2.4s ease-in-out infinite;
}
@keyframes bob { 0%,100%{transform:translateX(-50%) translateY(0)} 50%{transform:translateX(-50%) translateY(6px)} }
.hb-scroll-bar { width: 1px; height: 32px; background: linear-gradient(white, transparent); }
.hb-scroll-txt { font-size: 9px; font-weight: 700; letter-spacing: .13em; text-transform: uppercase; color: rgba(255,255,255,.35); }

/* ── Fallback (tidak ada berita) — judul di bawah ── */
.hb-fallback {
    position: absolute; inset: 0; z-index: 10;
    display: flex; align-items: flex-end;
    padding: 0 80px 100px;
}
.hb-fallback-inner { max-width: 700px; }
.hb-fallback-eyebrow {
    font-size: 11px; font-weight: 700;
    letter-spacing: .16em; text-transform: uppercase;
    color: rgba(255,255,255,.45);
    margin-bottom: 16px;
    display: flex; align-items: center; gap: 10px;
}
.hb-fallback-eyebrow::before {
    content: '';
    display: inline-block;
    width: 28px; height: 2px;
    background: rgba(255,255,255,.3); border-radius: 2px;
}
.hb-fallback h1 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: clamp(32px, 4.5vw, 54px);
    font-weight: 800; color: white;
    line-height: 1.12; letter-spacing: -1px;
    margin-bottom: 16px;
}
.hb-fallback p {
    font-size: 15px; color: rgba(255,255,255,.5);
    line-height: 1.8; font-weight: 400; max-width: 420px;
}

.hero-berita::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, rgba(74,173,74,.5), transparent);
    z-index: 30;
}

@media (max-width: 900px) {
    .hb-content  { padding: 0 24px 72px; }
    .hb-controls { right: 24px; bottom: 72px; }
    .hb-arrow    { display: none; }
    .hb-scroll   { display: none; }
    .hb-fallback { padding: 0 24px 80px; }
}
@media (max-width: 600px) {
    .hero-berita { max-height: none; height: 92svh; }
    .hb-title { font-size: clamp(22px,6vw,34px); }
    .hb-fallback h1 { font-size: clamp(26px, 7vw, 38px); }
}

/* ══════════════════════════════
   KONTEN BERITA (di bawah hero)
══════════════════════════════ */
.berita-section {
    background: var(--cream);
    padding: 80px 0;
    border-top: 1px solid #e0dbc8;
}
.berita-inner { max-width: 1380px; margin: 0 auto; padding: 0 48px; }
.berita-header {
    display: flex; align-items: flex-end; justify-content: space-between;
    margin-bottom: 44px; gap: 20px; flex-wrap: wrap;
}
.berita-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 10px; font-weight: 800; letter-spacing: .15em; text-transform: uppercase;
    color: var(--green-main); margin-bottom: 8px;
}
.berita-eyebrow::before { content:''; width:20px; height:2px; background:var(--green-main); border-radius:2px; }
.berita-h2 {
    font-family: 'Fraunces', serif;
    font-size: clamp(24px,3vw,36px);
    font-weight: 700; color: var(--dark-text); line-height: 1.2;
}
.berita-sub { font-size: 13px; color: #8aa88a; margin-top: 5px; }
.berita-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 22px; }
.b-card {
    background: white; border-radius: 20px; overflow: hidden;
    border: 1px solid #e4dfc8; text-decoration: none; color: inherit;
    display: block;
    transition: transform .3s cubic-bezier(.34,1.56,.64,1), box-shadow .3s;
}
.b-card:hover { transform: translateY(-6px); box-shadow: 0 22px 50px rgba(45,122,45,.1); }
.b-img-wrap { position: relative; overflow: hidden; aspect-ratio: 16/10; background: #d4e8d4; }
.b-img { width: 100%; height: 100%; object-fit: cover; transition: transform .55s ease; }
.b-card:hover .b-img { transform: scale(1.06); }
.b-no-img {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #d4ecd4, #b8ddb8);
}
.b-no-img i { font-size: 36px; color: var(--green-main); opacity: .3; }
.b-cat-pill {
    position: absolute; top: 12px; left: 12px;
    font-size: 10px; font-weight: 800; color: var(--green-main);
    background: rgba(240,253,240,.94); border: 1px solid rgba(45,122,45,.18);
    padding: 4px 11px; border-radius: 100px;
    backdrop-filter: blur(4px); letter-spacing: .04em;
}
.b-body { padding: 22px 24px 24px; display: flex; flex-direction: column; }
.b-cat-lbl { font-size: 9px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: var(--green-main); margin-bottom: 9px; }
.b-title {
    font-family: 'Fraunces', serif; font-size: 16px; font-weight: 700;
    color: var(--dark-text); line-height: 1.36;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    margin-bottom: 9px; transition: color .2s;
}
.b-card:hover .b-title { color: var(--green-main); }
.b-excerpt {
    font-size: 13px; color: #7a8e7a; line-height: 1.75;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    margin-bottom: 18px; flex: 1;
}
.b-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding-top: 14px; border-top: 1px solid #f0ede4;
}
.b-meta { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.b-mi { display: flex; align-items: center; gap: 4px; font-size: 11px; color: #9aaa9a; }
.b-mi i { color: var(--green-light); font-size: 10px; }
.b-more { display: flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 800; color: var(--green-main); }
.b-more i { font-size: 10px; transition: transform .2s; }
.b-card:hover .b-more i { transform: translateX(3px); }

@media (max-width: 900px) {
    .berita-grid { grid-template-columns: repeat(2,1fr); }
    .berita-inner { padding: 0 22px; }
}
@media (max-width: 600px) {
    .berita-grid { grid-template-columns: 1fr; }
    .berita-section { padding: 56px 0; }
}

.fade-up { opacity: 0; transform: translateY(20px); transition: opacity .55s ease, transform .55s ease; }
.fade-up.visible { opacity: 1; transform: translateY(0); }
</style>
@endpush

@section('content')

{{-- ══ HERO SLIDER BERITA ══════════════════ --}}
<section class="hero-berita" id="heroBerita">

    @if(isset($featured) && count($featured) > 0)

        @foreach($featured as $i => $item)
        <div class="hb-slide {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}">

            <div class="hb-bg"
                 style="background-image:url('{{ $item['image_slider'] ?? $item['image'] ?? '' }}')">
            </div>
            <div class="hb-overlay"></div>
            <div class="hb-grid"></div>

            <div class="hb-content">
                <div class="hb-breadcrumb">
                    <a href="{{ route('home') }}"><i class="fas fa-home" style="font-size:10px"></i> Beranda</a>
                    <span><i class="fas fa-chevron-right" style="font-size:8px"></i></span>
                    <span class="bc-active">Berita</span>
                </div>

                <div class="hb-cat">
                    <span class="hb-cat-dot"></span>
                    {{ $item['category'] ?? 'Berita Perusahaan' }}
                </div>

                <h1 class="hb-title">{{ $item['title'] }}</h1>
                <p class="hb-excerpt">{{ $item['excerpt'] }}</p>

                <div class="hb-bottom">
                    <div class="hb-meta">
                        <span class="hb-meta-item">
                            <i class="fas fa-user-circle"></i>
                            {{ $item['author'] ?? 'Admin' }}
                        </span>
                        <span class="hb-meta-sep"></span>
                        <span class="hb-meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            {{ isset($item['publishedAt'])
                                ? \Carbon\Carbon::parse($item['publishedAt'])->translatedFormat('d M Y')
                                : '' }}
                        </span>
                    </div>
                    <a href="{{ route('berita.detail', $item['id']) }}" class="hb-btn">
                        Baca Selengkapnya
                        <span class="hb-btn-icon"><i class="fas fa-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
        @endforeach

        <div class="hb-prog" id="hbProg"></div>

        @if(count($featured) > 1)
        <div class="hb-controls">
            <div class="hb-dots" id="hbDots">
                @foreach($featured as $j => $__)
                <button class="hb-dot {{ $j === 0 ? 'active':'' }}"
                        onclick="hbGo({{ $j }})"
                        aria-label="Slide {{ $j+1 }}"></button>
                @endforeach
            </div>
            <div class="hb-counter">
                <strong id="hbNum">01</strong>
                / {{ str_pad(count($featured),2,'0',STR_PAD_LEFT) }}
            </div>
        </div>
        <button class="hb-arrow prev" onclick="hbGo(hbCur-1)" aria-label="Sebelumnya">&#8249;</button>
        <button class="hb-arrow next" onclick="hbGo(hbCur+1)" aria-label="Berikutnya">&#8250;</button>
        @endif

        <div class="hb-scroll">
            <div class="hb-scroll-bar"></div>
            <span class="hb-scroll-txt">Scroll</span>
        </div>

    @else

        <div style="position:absolute;inset:0;background:linear-gradient(160deg,rgba(15,45,15,.85) 0%,rgba(30,80,30,.7) 50%,rgba(45,122,45,.5) 100%);z-index:1"></div>
        <div class="hb-fallback">
            <div class="hb-fallback-inner">
                <p class="hb-fallback-eyebrow">PT Putra Taro Paloma</p>
                <h1>Belum Ada Berita</h1>
                <p>Berita dan informasi terbaru akan ditampilkan di sini.</p>
            </div>
        </div>

    @endif

</section>

{{-- ══ DAFTAR BERITA ════════════════════════ --}}
@if(isset($berita) && count($berita) > 0)
<section class="berita-section">
    <div class="berita-inner">
        <div class="berita-header">
            <div>
                <p class="berita-eyebrow">Semua Berita</p>
                <h2 class="berita-h2">Berita Perusahaan</h2>
                <p class="berita-sub">Informasi dan kegiatan terbaru dari PT Putra Taro Paloma</p>
            </div>
        </div>

        <div class="berita-grid">
            @foreach($berita as $news)
            <a href="{{ route('berita.detail', $news['id']) }}" class="b-card fade-up">
                <div class="b-img-wrap">
                    @if(!empty($news['image_slider']) || !empty($news['image']))
                        <img src="{{ $news['image_slider'] ?? $news['image'] }}"
                             alt="{{ $news['title'] }}" class="b-img" loading="lazy">
                    @else
                        <div class="b-no-img"><i class="fas fa-newspaper"></i></div>
                    @endif
                    <span class="b-cat-pill">{{ $news['category'] ?? 'Berita' }}</span>
                </div>
                <div class="b-body">
                    <p class="b-cat-lbl">{{ $news['category'] ?? 'Berita' }}</p>
                    <h3 class="b-title">{{ $news['title'] }}</h3>
                    <p class="b-excerpt">{{ $news['excerpt'] }}</p>
                    <div class="b-footer">
                        <div class="b-meta">
                            <span class="b-mi"><i class="fas fa-user-circle"></i> {{ $news['author'] ?? 'Admin' }}</span>
                            <span class="b-mi">
                                <i class="fas fa-calendar-alt"></i>
                                {{ isset($news['publishedAt'])
                                    ? \Carbon\Carbon::parse($news['publishedAt'])->translatedFormat('d M Y')
                                    : '' }}
                            </span>
                        </div>
                        <span class="b-more">Selengkapnya <i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        @if(isset($berita) && method_exists($berita, 'links'))
        <div style="margin-top:48px; display:flex; justify-content:center;">
            {{ $berita->links() }}
        </div>
        @endif
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
/* ── Hero Slider ── */
(function () {
    const DUR    = 6000;
    const slides = document.querySelectorAll('.hb-slide');
    const prog   = document.getElementById('hbProg');
    const cnum   = document.getElementById('hbNum');
    const total  = slides.length;
    if (total <= 1) { if (prog) { prog.style.transition = `width ${DUR * 999}ms linear`; prog.style.width = '100%'; } return; }

    window.hbCur = 0;
    let timer, paused = false;

    window.hbGo = function (n) {
        slides[hbCur].classList.remove('active');
        hbCur = ((n % total) + total) % total;
        slides[hbCur].classList.add('active');
        if (cnum) cnum.textContent = String(hbCur + 1).padStart(2, '0');
        document.querySelectorAll('.hb-dot').forEach((d, i) => d.classList.toggle('active', i === hbCur));
        resetProg();
        clearInterval(timer);
        startTimer();
    };

    function resetProg() {
        if (!prog) return;
        prog.style.transition = 'none';
        prog.style.width = '0%';
        prog.offsetWidth;
        prog.style.transition = `width ${DUR}ms linear`;
        prog.style.width = '100%';
    }

    function startTimer() {
        timer = setInterval(() => { if (!paused) hbGo(hbCur + 1); }, DUR);
    }

    const wrap = document.getElementById('heroBerita');
    if (wrap) {
        wrap.addEventListener('mouseenter', () => paused = true);
        wrap.addEventListener('mouseleave', () => paused = false);
        let tx = 0;
        wrap.addEventListener('touchstart', e => tx = e.touches[0].clientX, { passive: true });
        wrap.addEventListener('touchend', e => {
            const d = tx - e.changedTouches[0].clientX;
            if (Math.abs(d) > 50) hbGo(hbCur + (d > 0 ? 1 : -1));
        }, { passive: true });
    }

    resetProg();
    startTimer();
})();

/* ── Scroll fade-up cards ── */
(function () {
    const obs = new IntersectionObserver(entries => {
        entries.forEach((e, idx) => {
            if (e.isIntersecting) {
                setTimeout(() => e.target.classList.add('visible'), idx * 80);
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));
})();
</script>
@endpush