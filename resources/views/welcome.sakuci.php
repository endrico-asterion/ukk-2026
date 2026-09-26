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

    $terbaru = \App\Models\Aspirasi::orderBy('id_aspirasi', 'desc')->limit(5)->get();
@endphp

@extends('layouts.app')

@section('title', config('app.name') . ' -- Kerangka PHP Ringan')

@section('content')

<section class="hero-modern">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-6">
                <div class="hero-eyebrow">Sistem Pengaduan Sarana Sekolah</div>
                <h1 class="hero-title-modern serif-italic mb-0">
                    Sampaikan aspirasi tentang fasilitas sekolahmu, kapan saja
                </h1>
                <div class="hero-meta">sekali lapor langsung gercep!</div>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a class="btn-modern-primary" href="#statistik">Lihat Statistik Pengaduan</a>
                    
                </div>
            </div>

            <div class="col-lg-6">
                <div class="stat-grid-modern">
                    <div class="stat-item-modern">
                        <div class="stat-value-modern">{{ $totalAspirasi ?? 0 }}</div>
                        <div class="stat-label-modern">Total pengaduan</div>
                    </div>
                    <div class="stat-item-modern">
                        <div class="stat-value-modern">{{ $totalMenunggu ?? 0 }}</div>
                        <div class="stat-label-modern">Menunggu</div>
                    </div>
                    <div class="stat-item-modern">
                        <div class="stat-value-modern">{{ $totalProses ?? 0 }}</div>
                        <div class="stat-label-modern">Proses</div>
                    </div>
                    <div class="stat-item-modern">
                        <div class="stat-value-modern">{{ $totalSelesai ?? 0 }}</div>
                        <div class="stat-label-modern">Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container section-spacing-modern" id="statistik">

    <div class="row g-4 mb-5">
    <div class="col-lg-6">
        <div class="surface-modern h-100">
            <h5 class="surface-title-modern" data-count="{{ count($kategoriChart) }} kategori">Kategori pengaduan terbanyak</h5>
            @forelse($kategoriChart as $item)
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <span style="font-size: .9rem;">{{ $item['nama'] }}</span>
                    <span class="text-muted" style="font-size: .85rem;">{{ $item['jumlah'] }}</span>
                </div>
                <div class="bar-track-modern">
                    <div class="bar-fill-modern" style="width: {{ $maxJumlah > 0 ? round(($item['jumlah'] / $maxJumlah) * 100) : 0 }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-muted mb-0">Belum ada data kategori.</p>
            @endforelse
        </div>
    </div>

    <div class="col-lg-6">
        <div class="surface-modern h-100">
            <h5 class="surface-title-modern" data-count="{{ count($terbaru) }} aktif">Pengaduan terbaru</h5>
            @forelse($terbaru as $item)
            @php $status = $item->tanggapan->status ?? 'menunggu'; @endphp
            <div class="list-row-modern">
                <div>
                    <div style="font-size: .9rem; font-weight: 500;">{{ $item->kategori->nama_kategori ?? '-' }}</div>
                    <small class="text-muted">{{ $item->lokasi }}</small>
                </div>
                <span class="pill-modern status-{{ $status }}">{{ $status }}</span>
            </div>
            @empty
            <p class="text-muted mb-0">Belum ada pengaduan.</p>
            @endforelse
        </div>
    </div>
</div>

    <div class="row g-4 align-items-stretch">
    <div class="col-lg-7">
        <div class="cta-modern h-100">
            <h3 class="serif-italic mb-3" style="font-size: 1.6rem; font-weight: 500;">Ada sarana sekolah yang rusak?</h3>
            <p class="mb-4 text-muted">Laporkan kerusakan fasilitas sekolah seperti meja, kursi, AC, atau fasilitas komputer agar segera diperbaiki oleh tim sarpras.</p>
            <a href="{{ route('siswa.aspirasi.create') }}" class="btn-modern-light">Buat Pengaduan Baru</a>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="surface-modern h-100">
            <h5 class="surface-title-modern">Cara mengirim pengaduan</h5>
            <div class="step-item-modern">1. Klik tombol <strong>Buat Pengaduan Baru</strong></div>
            <div class="step-item-modern">2. Pilih kategori sarana dan isi lokasi kerusakan</div>
            <div class="step-item-modern">3. Tuliskan deskripsi detail permasalahan</div>
            <div class="step-item-modern">4. Kirim dan pantau statusnya di menu <strong>Riwayat</strong></div>
        </div>
    </div>
</div>
    </div>

</div>

@endsection