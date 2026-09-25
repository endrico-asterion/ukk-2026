@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Alat</h2>

    <form action="{{ route('alat.update', ['alat' => $alat->id_alat]) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama Alat</label>
        <input type="text" name="nama_alat" class="form-control" value="{{ $alat->nama_alat }}" required>

        <label>Kategori</label>
        <select name="id_kategori" class="form-control" required>
            @foreach($kategori as $k)
            <option value="{{ $k->id_kategori }}" {{ $k->id_kategori == $alat->id_kategori ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection