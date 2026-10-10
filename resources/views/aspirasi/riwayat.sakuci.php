@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0">Aspirasi Saya</h2>
        <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-primary">Tambah Aspirasi</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Alat</th>
                <th>Foto</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Feedback</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @forelse($data as $item)
            <tr>
                <td><?= $no++ ?></td>
                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $item->alat->nama_alat ?? '-' }}</td>
                <td>
                 @if($item->foto)
                <a href="/uploads/aspirasi/{{ $item->foto }}" target="_blank">
                <img src="/uploads/aspirasi/{{ $item->foto }}" alt="Foto" style="height:50px;">
                </a>
                @else
                -
                @endif
                </td>
                <td>{{ $item->lokasi }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ $item->tanggapan->status ?? '-' }}</td>
                <td>{{ $item->tanggapan->feedback ?? '-' }}</td>
                <td>
                    <a href="{{ route('siswa.aspirasi.edit', ['aspirasi' => $item->id_aspirasi]) }}" class="btn btn-warning btn-sm">Edit</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">Belum ada aspirasi yang kamu kirim.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {!! $data->links() !!}
</div>
@endsection