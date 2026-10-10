@extends('layouts.app')

@section('content')


<div class="container">
    <h2>Form Pengaduan Sarana Sekolah</h2>
    
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('siswa.aspirasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        
        <div class="form-group mb-3">
            <label for="id_kategori">Kategori Sarana:</label>
            <select name="id_kategori" id="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $item)
                    <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="id_alat">Alat / Sarana (opsional):</label>
            <select name="id_alat" id="id_alat" class="form-control">
                <option value="">-- Tidak ada / Lainnya --</option>
                @foreach($alat as $a)
                    <option value="{{ $a->id_alat }}" data-kategori="{{ $a->id_kategori }}">{{ $a->nama_alat }}</option>    
                @endforeach
                </select>
        </div>

        
        <div class="form-group mb-3">
            <label for="lokasi">Lokasi Kejadian / Ruangan:</label>
            <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Contoh: Lab Komputer 2, Kelas XII RPL" required>
        </div>

        
        <div class="form-group mb-3">
            <label for="keterangan">Keterangan Pengaduan:</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder="Jelaskan detail kerusakan sarana..." required></textarea>
        </div>

        <div class="form-group mb-3">
        <label for="foto">Foto Bukti (opsional):</label>
        <input type="file" name="foto" id="foto" class="form-control" accept="image/png, image/jpeg, image/webp">
        <small class="text-muted">Format JPG, PNG, atau WEBP. Maksimal 2 MB.</small>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Aspirasi</button>
    </form>
</div>

<script>
    const kategori = document.getElementById('id_kategori');
    const alat = document.getElementById('id_alat');

    // simpan semua alat dari opsi yang sudah ada
    const semuaAlat = Array.from(alat.querySelectorAll('option[data-kategori]'))
        .map(opt => ({
            id: opt.value,
            nama: opt.textContent.trim(),
            kategori: opt.dataset.kategori
        }));

    function isiAlat() {
        alat.innerHTML = '<option value="">-- Tidak ada / Lainnya --</option>';

        semuaAlat
            .filter(a => a.kategori === kategori.value)
            .forEach(a => {
                const opt = document.createElement('option');
                opt.value = a.id;
                opt.textContent = a.nama;
                alat.appendChild(opt);
            });
    }

    kategori.addEventListener('change', isiAlat);
    isiAlat();
</script>


@endsection