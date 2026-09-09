@extends('layouts.app')

@section('content')

<h1>kategori</h1>
<a href="{{ route('kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
<table class="table table-bordered mt-3">
    <tr>
        <th>No</th>
        <th>Nama Kategori</th>
        <th>Aksi</th>
    </tr>
    @php $no = 1; @endphp
    @foreach ($data as $d)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $d->keterangan }}</td>
        <td>
           <a href="{{ route('kategori.edit', ['kategori' => $d->id_kategori]) }}" class="btn btn-warning">Edit</a>

           <form action="{{ route('kategori.destroy', ['kategori' => $d->id_kategori]) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
             <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus kategori ini?')">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

@endsection
