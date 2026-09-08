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
                    <a href="" class="btn btn-warning">Edit</a>
                    <a href="" class="btn btn-danger">Hapus</a>
                </td>
            </tr>

            @endforeach
        </table>

        @endsection 
