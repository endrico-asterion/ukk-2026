@php 
    $totalAspirasi = \App\Models\Aspirasi::count();
    $totalMenunggu = \App\Models\Tanggapan::where('status', 'menunggu')->count();
    $totalProses   = \App\Models\Tanggapan::where('status', 'proses')->count();
    $totalSelesai  = \App\Models\Tanggapan::where('status', 'selesai')->count();

    $semuaKategori = \App\Models\Kategori::all();
    $kategoriChart = [];
    foreach ($semuaKategori as $k) {
        $jumlah = \App\Models\Aspirasi::where('id_kategori', '=', $k->id_kategori)->count();
        $kategoriChart[] = ['nama' => $k->nama_kategori, 'jumlah' => $jumlah];
    }
    usort($kategoriChart, fn($a, $b) => $b['jumlah'] <=> $a['jumlah']);
    $maxJumlah = $kategoriChart ? max(array_column($kategoriChart, 'jumlah')) : 0;

    $terbaru = \App\Models\Aspirasi::orderBy('id_aspirasi', 'desc')->limit(6)->get();
@endphp

@extends('layouts.app')

@section('title', config('app.name') . ' -- Kerangka PHP Ringan')

@section('content')
<div class="wl">
    <div class="wl-orb a" aria-hidden="true"></div>
    <div class="wl-orb b" aria-hidden="true"></div>

    <div class="wl-grid">

        {{-- Sidebar --}}
        <header id="atas" class="wl-side">
            <div>
                <p class="wl-eyebrow">Sistem Pengaduan Sarana Sekolah</p>
                <h1 class="wl-title">Pengaduan<br>86</h1>
                <p class="wl-intro">Sampaikan aspirasi atau keluhan mengenai fasilitas dan sarana sekolahmu di sini dengan cepat dan transparan.</p>
                <div class="wl-status"><span class="wl-dot"></span>{{ $totalMenunggu ?? 0 }} pengaduan menunggu ditangani</div>
                <nav class="wl-nav" aria-label="Bagian halaman">
                    <a href="#statistik">Statistik</a>
                    <a href="#terbaru">Pengaduan terbaru</a>
                    <a href="#cara">Cara mengirim</a>
                    <a href="#kontak">Buat pengaduan</a>
                </nav>
            </div>
            <div class="wl-foot">
            <span id="wlJam"></span>
            </div>
        </header>

        <div class="wl-main">

            {{-- Statistik --}}
            <section id="statistik" class="wl-sec">
                <h2 class="wl-h2">Statistik pengaduan</h2>
                <div class="wl-stats">
                    <div class="wl-stat"><div class="wl-num">{{ $totalAspirasi ?? 0 }}</div><div class="wl-muted">Total pengaduan</div></div>
                    <div class="wl-stat"><div class="wl-num">{{ $totalMenunggu ?? 0 }}</div><div class="wl-muted">Menunggu</div></div>
                    <div class="wl-stat"><div class="wl-num">{{ $totalProses ?? 0 }}</div><div class="wl-muted">Proses</div></div>
                    <div class="wl-stat"><div class="wl-num">{{ $totalSelesai ?? 0 }}</div><div class="wl-muted">Selesai</div></div>
                </div>

                <p class="wl-sub">Kategori pengaduan terbanyak</p>
                @forelse($kategoriChart as $item)
                <div class="wl-bar">
                    <div class="wl-bar-head"><span>{{ $item['nama'] }}</span><span class="wl-muted">{{ $item['jumlah'] }}</span></div>
                    <div class="wl-track"><div class="wl-fill" style="width: {{ $maxJumlah > 0 ? round(($item['jumlah'] / $maxJumlah) * 100) : 0 }}%"></div></div>
                </div>
                @empty
                <p class="wl-muted">Belum ada data kategori.</p>
                @endforelse
            </section>

            {{-- Pengaduan terbaru --}}
            <section id="terbaru" class="wl-sec">
                <h2 class="wl-h2">Pengaduan terbaru</h2>
                <div class="wl-chips" role="group" aria-label="Filter kategori">
                    <button type="button" class="wl-chip" data-filter="Semua" aria-pressed="true">Semua</button>
                    @foreach($semuaKategori as $k)
                    <button type="button" class="wl-chip" data-filter="{{ $k->nama_kategori }}" aria-pressed="false">{{ $k->nama_kategori }}</button>
                    @endforeach
                </div>

                <div class="wl-list">
                    @forelse($terbaru as $item)
                    @php
                        $status  = $item->tanggapan->status ?? 'menunggu';
                        $katNama = $item->kategori->nama_kategori ?? '-';
                        $alatNama = $item->alat->nama_alat ?? '-';
                        $tgl     = $item->created_at ? date('d M Y', strtotime($item->created_at)) : '-';
                        $fotoUrl = $item->foto ? asset('uploads/aspirasi/' . $item->foto) : '';
                    @endphp
                    <button type="button" class="wl-card"
                            data-kat="{{ $katNama }}" data-alat="{{ $alatNama }}" data-status="{{ $status }}"
                            data-lokasi="{{ $item->lokasi }}" data-ket="{{ $item->keterangan }}"
                            data-tgl="{{ $tgl }}" data-foto="{{ $fotoUrl }}">
                        <div class="wl-thumb">
                            @if($fotoUrl)
                            <img src="{{ $fotoUrl }}" alt="">
                            @else
                            <svg viewBox="0 0 200 200" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
                                <circle cx="70" cy="90" r="56" style="fill: var(--wl-orb1); opacity: .9"/>
                                <circle cx="130" cy="120" r="38" style="fill: var(--wl-accent); opacity: .85"/>
                                <rect x="40" y="140" width="110" height="60" rx="14" style="fill: var(--wl-orb2); opacity: .9"/>
                            </svg>
                            @endif
                        </div>
                        <div>
                            <div class="wl-card-head"><h3>{{ $katNama }}</h3><span class="wl-muted wl-small">{{ $tgl }}</span></div>
                            <p class="wl-muted wl-clip">{{ $item->lokasi }}{{ $alatNama !== '-' ? ' · ' . $alatNama : '' }}: {{ mb_strimwidth($item->keterangan, 0, 90, '...') }}</p>
                            <div class="wl-card-foot"><span class="wl-pill {{ $status }}">{{ $status }}</span><span class="wl-link">Lihat detail</span></div>
                        </div>
                    </button>
                    @empty
                    <p class="wl-muted">Belum ada pengaduan.</p>
                    @endforelse
                </div>
                <p id="wlKosong" class="wl-muted" hidden>Tidak ada pengaduan di kategori ini.</p>
            </section>

            {{-- Cara mengirim --}}
            <section id="cara" class="wl-sec">
                <h2 class="wl-h2">Cara mengirim pengaduan</h2>
                <ol class="wl-tl">
                    <li><p class="wl-muted wl-small">Langkah 1</p><p class="wl-tl-title">Klik tombol Buat Pengaduan Baru</p></li>
                    <li><p class="wl-muted wl-small">Langkah 2</p><p class="wl-tl-title">Pilih kategori sarana dan isi lokasi kerusakan</p></li>
                    <li><p class="wl-muted wl-small">Langkah 3</p><p class="wl-tl-title">Tuliskan deskripsi detail permasalahan</p></li>
                    <li><p class="wl-muted wl-small">Langkah 4</p><p class="wl-tl-title">Kirim dan pantau statusnya di menu Riwayat</p></li>
                </ol>
            </section>

            {{-- Ajakan --}}
            <section id="kontak" class="wl-sec">
                <h2 class="wl-h2">Ada sarana sekolah yang rusak?</h2>
                <p class="wl-muted wl-lead">Laporkan kerusakan fasilitas seperti meja, kursi, AC, atau komputer agar segera diperbaiki oleh tim sarpras.</p>
                <div class="wl-actions">
                    <a href="{{ route('siswa.aspirasi.create') }}" class="wl-btn primary">Buat Pengaduan Baru</a>
                    
                </div>
            </section>

        </div>
    </div>

    {{-- Panel detail --}}
    <div id="wlPanel" class="wl-panel" role="dialog" aria-modal="true" aria-label="Detail pengaduan" hidden>
        <div id="wlBackdrop" class="wl-backdrop"></div>
        <div class="wl-sheet">
            <button type="button" id="wlTutup" class="wl-close">Tutup</button>
            <img id="wlPFoto" class="wl-pfoto" alt="Foto pengaduan" hidden>
            <p id="wlPTgl" class="wl-muted wl-small"></p>
            <h3 id="wlPKat" class="wl-ptitle"></h3>
            <span id="wlPStatus" class="wl-pill"></span>
            <dl class="wl-dl">
                <div><dt>Alat</dt><dd id="wlPAlat"></dd></div>
                <div><dt>Lokasi</dt><dd id="wlPLokasi"></dd></div>
                <div><dt>Keterangan</dt><dd id="wlPKet"></dd></div>
            </dl>
            <a href="{{ route('siswa.aspirasi.create') }}" class="wl-btn primary">Buat pengaduan serupa</a>
        </div>
    </div>
</div>

<script>
(function () {
    var root = document.querySelector('.wl');
    if (!root) return;

    var jam = document.getElementById('wlJam');
    function tick() {
        if (!jam) return;
        var t = new Intl.DateTimeFormat('id-ID', { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', hour12: false }).format(new Date()).replace('.', ':');
        jam.textContent = 'Pukul ' + t + ' WIB';
    }
    tick();
    setInterval(tick, 20000);

    var tema = document.getElementById('wlTema');
    if (tema) {
        tema.addEventListener('click', function () {
            var t = document.getElementById('themeToggle');
            if (t) t.click();
        });
    }

    var chips = root.querySelectorAll('.wl-chip');
    var cards = root.querySelectorAll('.wl-card');
    var kosong = document.getElementById('wlKosong');
    chips.forEach(function (c) {
        c.addEventListener('click', function () {
            var f = c.getAttribute('data-filter');
            var n = 0;
            chips.forEach(function (x) { x.setAttribute('aria-pressed', x === c ? 'true' : 'false'); });
            cards.forEach(function (k) {
                var tampil = f === 'Semua' || k.getAttribute('data-kat') === f;
                k.hidden = !tampil;
                if (tampil) n++;
            });
            if (kosong) kosong.hidden = n > 0;
        });
    });

    var links = root.querySelectorAll('.wl-nav a');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (es) {
            es.forEach(function (e) {
                if (e.isIntersecting) {
                    links.forEach(function (a) { a.classList.toggle('on', a.getAttribute('href') === '#' + e.target.id); });
                }
            });
        }, { rootMargin: '-40% 0px -55% 0px' });
        ['statistik', 'terbaru', 'cara', 'kontak'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) io.observe(el);
        });
    }

    var panel = document.getElementById('wlPanel');
    var terakhir = null;
    function isi(id, v) {
        var el = document.getElementById(id);
        if (el) el.textContent = v;
    }
    function buka(k) {
        terakhir = k;
        isi('wlPKat', k.getAttribute('data-kat'));
        isi('wlPTgl', k.getAttribute('data-tgl'));
        isi('wlPAlat', k.getAttribute('data-alat'));
        isi('wlPLokasi', k.getAttribute('data-lokasi'));
        isi('wlPKet', k.getAttribute('data-ket'));
        var s = k.getAttribute('data-status');
        var st = document.getElementById('wlPStatus');
        st.textContent = s;
        st.className = 'wl-pill ' + s;
        var foto = k.getAttribute('data-foto');
        var img = document.getElementById('wlPFoto');
        if (foto) {
            img.src = foto;
            img.hidden = false;
        } else {
            img.hidden = true;
        }
        panel.hidden = false;
        document.body.style.overflow = 'hidden';
        document.getElementById('wlTutup').focus();
    }
    function tutup() {
        panel.hidden = true;
        document.body.style.overflow = '';
        if (terakhir) terakhir.focus();
    }
    cards.forEach(function (k) {
        k.addEventListener('click', function () { buka(k); });
    });
    document.getElementById('wlTutup').addEventListener('click', tutup);
    document.getElementById('wlBackdrop').addEventListener('click', tutup);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !panel.hidden) tutup();
    });
})();
</script>
@endsection