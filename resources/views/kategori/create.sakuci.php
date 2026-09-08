@extends('layouts.app')

@section('content')

<h1>Tambah Kategori</h1>
<form action="{{ route('kategori.store') }}" method="POST">
    @csrf
    <div class="form-group mb-3">
        <label>keterangan</label>
        <input type="text" name="keterangan" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

@endsection