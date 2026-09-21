@extends('layouts.app')

@section('content')
    <h1>Edit kategori</h1>
    <form action="{{ route('kategori.update', ['id_kategori' => $kategori->id_kategori]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="nama_kategori">keterangan</label>
            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori"
            value="{{ $kategori->nama_kategori }}" required>
</div>
<button type="submit" class="btn btn-primary">update</button>
</form>
@endsection