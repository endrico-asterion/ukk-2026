@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Aspirasi</h2>

    <form action="{{ route('siswa.aspirasi.update', ['aspirasi' => $aspirasi->id_aspirasi]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="lokasi">Lokasi Kejadian / Ruangan:</label>
            <input type="text" name="lokasi" id="lokasi" class="form-control" value="{{ $aspirasi->lokasi }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="keterangan">Keterangan Pengaduan:</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="4" required>{{ $aspirasi->keterangan }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('siswa.aspirasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection