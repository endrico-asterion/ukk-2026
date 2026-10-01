@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tanggapi Aspirasi</h2>

    <table class="table mb-4">
        <tr><th width="150">Kategori</th><td>{{ $aspirasi->kategori->nama_kategori ?? '-' }}</td></tr>
        <tr><th>Alat</th><td>{{ $aspirasi->alat->nama_alat ?? '-' }}</td></tr>
        <tr><th>Lokasi</th><td>{{ $aspirasi->lokasi }}</td></tr>
        <tr><th>Keterangan</th><td>{{ $aspirasi->keterangan }}</td></tr>
    </table>

    <form action="{{ route('aspirasi.update', ['aspirasi' => $aspirasi->id_aspirasi]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="status">Status:</label>
            @php $statusSekarang = $aspirasi->tanggapan->status ?? 'menunggu'; @endphp
            <select name="status" id="status" class="form-control" required>
                <option value="menunggu" {{ $statusSekarang == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="proses"   {{ $statusSekarang == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai"  {{ $statusSekarang == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="feedback">Feedback (opsional):</label>
            <textarea name="feedback" id="feedback" class="form-control" rows="4">{{ $aspirasi->tanggapan->feedback ?? '' }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('aspirasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection