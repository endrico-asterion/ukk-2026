@php 
    $totalAspirasi = \App\Models\Aspirasi::count();
    $totalMenunggu = \App\Models\Tanggapan::where('status', 'menunggu')->count();
    $totalProses   = \App\Models\Tanggapan::where('status', 'proses')->count();
    $totalSelesai  = \App\Models\Tanggapan::where('status', 'selesai')->count();
@endphp

@extends('layouts.app')

@section('title', config('app.name') . ' -- Kerangka PHP Ringan')

@section('content')

    {{-- Hero --}}
    <section class="text-center py-4 py-lg-5">
        <span class="badge rounded-pill badge-brand px-3 py-2 mb-3">pengaduan v8.6</span>

        <h1 class="display-5 fw-bold mb-3">
            pengaduan<br class="d-none d-md-inline">
            <span class="text-brand">86</span>
        </h1>

        <p class="lead text-secondary mx-auto mb-4" style="max-width: 620px;">
            sampaikan aspirasi atau keluhan mengenai fasilitas dan 
            sarana sekolah mu di sini dengan cepat dan transparan.

        </p>

        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <a class="btn btn-brand btn-lg px-4" href="/admin/kategori">liat web pengaduan 86!</a>
            <a class="btn btn-outline-brand btn-lg px-4" href="https://github.com/indrabsus/sakuci-framework" target="_blank">GitHub</a>
        </div>

        
    </section>

   

<div class="container my-5">
    
   
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card bg-dark text-white border-secondary h-100 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-uppercase text-muted">Total Pengaduan</h6>
                    <h2 class="display-5 fw-bold text">{{ $totalAspirasi ?? 0 }}</h2>
                    <small class="text-muted">Aspirasi terkirim</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-white border-secondary h-100 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-uppercase text-muted">Menunggu</h6>
                    <h2 class="display-5 fw-bold text">{{ $totalMenunggu ?? 0 }}</h2>
                    <small class="text-muted">Dalam antrean</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-white border-secondary h-100 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-uppercase text-muted">Proses</h6>
                    <h2 class="display-5 fw-bold text">{{ $totalProses ?? 0 }}</h2>
                    <small class="text-muted">Sedang ditangani</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-white border-secondary h-100 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-uppercase text-muted">Selesai</h6>
                    <h2 class="display-5 fw-bold text">{{ $totalSelesai ?? 0 }}</h2>
                    <small class="text-muted">Telah ditanggapi</small>
                </div>
            </div>
        </div>
    </div>

   
    <div class="row g-4 align-items-center mb-5">
      
        <div class="col-lg-7">
            <div class="p-4 p-md-5 rounded-3 bg-gradient bg-primary text-white shadow">
                <h3 class="fw-bold">Ada Sarana Sekolah yang Rusak?</h3>
                <p class="mb-4">Laporkan kerusakan fasilitas sekolah seperti meja, kursi, AC, atau fasilitas komputer agar segera diperbaiki oleh tim sarpras.</p>
                <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-light btn-lg fw-bold text-primary">+ Buat Pengaduan Baru</a>
            </div>
        </div>

      
        <div class="col-lg-5">
            <div class="card bg-dark text-white border-secondary p-3">
                <h5 class="fw-bold mb-3 text-warning"> Cara Mengirim Pengaduan</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">1, Klik tombol <strong>Buat Pengaduan Baru</strong>.</li>
                    <li class="mb-2">2, Pilih kategori sarana dan isi lokasi kerusakan.</li>
                    <li class="mb-2">3, Tuliskan deskripsi detail permasalahan.</li>
                    <li class="mb-2">4, Kirim dan pantau statusnya di menu <strong>Riwayat</strong>.</li>
                </ul>
            </div>
        </div>
    </div>

</div>


    
       

   

@endsection
