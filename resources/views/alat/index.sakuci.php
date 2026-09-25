@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Alat</h2>
    <a href="{{ route('alat.create') }}" class="btn btn-primary">Tambah Alat</a>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Alat</th>
                <th>Nama Alat</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; ?>
            @forelse($data as $item)
            <tr>
                <td><?= $no++ ?></td>
                <td>{{ $item->kode_alat }}</td>
                <td>{{ $item->nama_alat }}</td>
                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                <td>
                    <a href="{{ route('alat.edit', ['alat' => $item->id_alat]) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('alat.destroy', ['alat' => $item->id_alat]) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Belum ada data alat.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {!! $data->links() !!}
</div>
@endsection