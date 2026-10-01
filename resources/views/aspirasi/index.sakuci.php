@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Aspirasi</h2>
   

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('aspirasi.index') }}" class="row g-2 mb-3">
    <div class="col-md-2">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="{{ $filter['tanggal'] }}">
    </div>
    <div class="col-md-2">
        <label class="form-label">Bulan</label>
        <input type="month" name="bulan" class="form-control" value="{{ $filter['bulan'] }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Siswa</label>
        <select name="id_siswa" class="form-control">
            <option value="">Semua siswa</option>
            @foreach($siswa as $s)
                <option value="{{ $s->id_siswa }}" {{ $filter['id_siswa'] == $s->id_siswa ? 'selected' : '' }}>
                    {{ $s->nis }} - {{ $s->kelas }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Kategori</label>
        <select name="id_kategori" class="form-control">
            <option value="">Semua kategori</option>
            @foreach($kategori as $k)
                <option value="{{ $k->id_kategori }}" {{ $filter['id_kategori'] == $k->id_kategori ? 'selected' : '' }}>
                    {{ $k->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 d-flex align-items-end gap-2">
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('aspirasi.index') }}" class="btn btn-secondary">Reset</a>
    </div>
</form>
   
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Alat</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
         <?php $no = 1; ?>
            @forelse($data as $item)
            <tr>
                <td><?= $no++ ?></td>
                <td>{{ $item->created_at ? date('d-m-Y', strtotime($item->created_at)) : '-' }}</td>
                <td>{{ $item->siswa->nis ?? '-' }} ({{ $item->siswa->kelas ?? '-' }})</td>
                <td>{{ $item->alat->nama_alat ?? '-' }}</td>
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
                <td colspan="9">Belum ada data aspirasi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {!! $data->links() !!}
</div>
@endsection