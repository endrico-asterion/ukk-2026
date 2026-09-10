@extends('layouts.app')

@section('content')
    <h1>Edit kategori</h1>
    <form action="{{ route('kategori.update', ['id_kategori' => $kategori->id_kategori]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="keterangan">keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan"
            value="{{ $kategori->keterangan }}" required>
</div>
<button type="submit" class="btn btn-primary">update</button>
</form>
@endsection