@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Aspirasi</h2>
   

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <?php $no = 1; ?>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
            <tr>
                <td><?= $no++ ?></td>
                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ $item->tanggapan->status ?? '-' }}</td>
                <td>
                    <a href="{{ route('aspirasi.edit', ['aspirasi' => $item->id_aspirasi]) }}" class="btn btn-warning btn-sm">Edit</a>
                    
                    <form action="{{ route('aspirasi.destroy', ['aspirasi' => $item->id_aspirasi]) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">Belum ada data aspirasi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $data->links() }}
</div>
@endsection