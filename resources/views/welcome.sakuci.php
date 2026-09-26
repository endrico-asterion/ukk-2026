@php 
    $totalAspirasi = \App\Models\Aspirasi::count();
    $totalMenunggu = \App\Models\Tanggapan::where('status', 'menunggu')->count();
    $totalProses   = \App\Models\Tanggapan::where('status', 'proses')->count();
    $totalSelesai  = \App\Models\Tanggapan::where('status', 'selesai')->count();

    // Kategori pengaduan terbanyak
    $semuaKategori = \App\Models\Kategori::all();
    $kategoriChart = [];
    foreach ($semuaKategori as $k) {
        $jumlah = \App\Models\Aspirasi::where('id_kategori', '=', $k->id_kategori)->count();
        $kategoriChart[] = [
            'nama'   => $k->nama_kategori,
            'jumlah' => $jumlah,
        ];
    }
    usort($kategoriChart, fn($a, $b) => $b['jumlah'] <=> $a['jumlah']);
    $maxJumlah = $kategoriChart ? max(array_column($kategoriChart, 'jumlah')) : 0;

    // Pengaduan terbaru
    $terbaru = \App\Models\Aspirasi::orderBy('id_aspirasi', 'desc')->limit(5)->get();
@endphp

@extends('layouts.app')

@section('title', config('app.name') . ' -- Kerangka PHP Ringan')

@section('content')

    {{-- Hero --}}
   <section class="hero-elegant">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                
                <h1 class="hero-title mb-3">
                    Pengaduan <span class="text-brand">86</span>
                </h1>
                <p class="text-body-secondary mb-4" style="max-width: 480px;">
                    Sampaikan aspirasi atau keluhan mengenai fasilitas dan sarana sekolahmu di sini dengan cepat dan transparan.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-brand px-4" href="/admin/kategori">Lihat Web Pengaduan 86!</a>
                   
                </div>
            </div>

            <div class="col-lg-6">
                <div class="stat-panel">
                    <div class="stat-row">
                        <span class="stat-label">Total Pengaduan</span>
                        <span class="stat-value">{{ $totalAspirasi ?? 0 }}</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Menunggu</span>
                        <span class="stat-value">{{ $totalMenunggu ?? 0 }}</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Proses</span>
                        <span class="stat-value">{{ $totalProses ?? 0 }}</span>
                    </div>
                    <div class="stat-row">
                        <span class="stat-label">Selesai</span>
                        <span class="stat-value">{{ $totalSelesai ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        {{-- Chart kategori + List terbaru --}}
        <div class="row g-4 mb-5">
            <div class="col-lg-6">
                <div class="card bg-body-secondary border h-100 shadow-sm card-lift">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">Kategori Pengaduan Terbanyak</h5>
                        @forelse($kategoriChart as $item)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-medium">{{ $item['nama'] }}</span>
                                <span class="text-body-secondary">{{ $item['jumlah'] }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-brand" role="progressbar"
                                     style="width: {{ $maxJumlah > 0 ? round(($item['jumlah'] / $maxJumlah) * 100) : 0 }}%">
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-body-secondary mb-0">Belum ada data kategori.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <class="card card-elegant h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">Pengaduan Terbaru</h5>
                        @forelse($terbaru as $item)
                        <div class="d-flex justify-content-between align-items-start border-bottom pb-2 mb-2">
                            <div>
                                <div class="fw-medium">{{ $item->kategori->nama_kategori ?? '-' }}</div>
                                <small class="text-body-secondary">{{ $item->lokasi }}</small>
                            </div>
                            <span class="badge text-bg-warning">{{ $item->tanggapan->status ?? 'menunggu' }}</span>
                        </div>
                        @empty
                        <p class="text-body-secondary mb-0">Belum ada pengaduan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="row g-4 align-items-center mb-5">
            <div class="col-lg-7">
                <div class="p-4 p-md-5 rounded-3 text-bg-primary shadow">
                    <h3 class="fw-bold">Ada Sarana Sekolah yang Rusak?</h3>
                    <p class="mb-4">Laporkan kerusakan fasilitas sekolah seperti meja, kursi, AC, atau fasilitas komputer agar segera diperbaiki oleh tim sarpras.</p>
                    <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-light btn-lg fw-bold text-primary">+ Buat Pengaduan Baru</a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card bg-body-secondary border p-3 h-100">
                    <h5 class="fw-bold mb-3 text-warning">Cara Mengirim Pengaduan</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">1. Klik tombol <strong>Buat Pengaduan Baru</strong>.</li>
                        <li class="mb-2">2. Pilih kategori sarana dan isi lokasi kerusakan.</li>
                        <li class="mb-2">3. Tuliskan deskripsi detail permasalahan.</li>
                        <li class="mb-2">4. Kirim dan pantau statusnya di menu <strong>Riwayat</strong>.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

@endsection