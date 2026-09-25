@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Tambah Alat</h2>

    <form action="{{ route('alat.store') }}" method="POST">
        @csrf

        <label>Nama Alat</label>
        <input type="text" name="nama_alat" class="form-control" required>

        <label>Kategori</label>
        <select name="id_kategori" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategori as $k)
            <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection