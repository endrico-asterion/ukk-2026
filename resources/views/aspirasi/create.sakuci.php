@extends('layouts.app')

@section('content')


<div class="container">
    <h2>Form Pengaduan Sarana Sekolah</h2>

    <form action="{{ route('siswa.aspirasi.store') }}" method="POST">
        @csrf

        
        <div class="form-group mb-3">
            <label for="id_kategori">Kategori Sarana:</label>
            <select name="id_kategori" id="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $item)
                    <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        
        <div class="form-group mb-3">
            <label for="lokasi">Lokasi Kejadian / Ruangan:</label>
            <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Contoh: Lab Komputer 2, Kelas XII RPL" required>
        </div>

        
        <div class="form-group mb-3">
            <label for="keterangan">Keterangan Pengaduan:</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder="Jelaskan detail kerusakan sarana..." required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Aspirasi</button>
    </form>
</div>

@endsection