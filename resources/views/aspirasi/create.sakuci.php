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
            <div class="input-group">
            <input type="file" name="foto" id="foto" class="form-control" accept="image/png, image/jpeg, image/webp">
            <button type="button" id="batalFoto" class="btn btn-outline-secondary" style="display:none">Batal</button>
        </div>
            <small class="text-muted">Format JPG, PNG, atau WEBP. Maksimal 2 MB.</small>
            <img id="previewFoto" alt="Pratinjau foto" style="display:none; max-height:150px; margin-top:8px;" class="rounded">
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

<script>
(function () {
    const foto = document.getElementById('foto');
    const batal = document.getElementById('batalFoto');
    const preview = document.getElementById('previewFoto');

    function reset() {
        foto.value = '';
        preview.removeAttribute('src');
        preview.style.display = 'none';
        batal.style.display = 'none';
    }

    foto.addEventListener('change', function () {
        if (foto.files && foto.files[0]) {
            preview.src = URL.createObjectURL(foto.files[0]);
            preview.style.display = 'block';
            batal.style.display = 'inline-block';
        } else {
            reset();
        }
    });

    batal.addEventListener('click', reset);
})();
</script>


@endsection