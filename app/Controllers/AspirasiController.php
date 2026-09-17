<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Aspirasi;
use App\Models\Tanggapan;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class AspirasiController extends Controller
{
    // Halaman Tampil Semua Aspirasi (Siswa / Admin)
    public function index(Request $request)
    {
        $data = Aspirasi::orderBy('id_aspirasi', 'desc')->paginate(10);
        return $this->view('aspirasi.index', compact('data'));
    }

    // Halaman Form Input Aspirasi Siswa
    public function create(Request $request)
    {
        // Ambil data kategori untuk dropdown pilihan di form
        $kategori = Kategori::all();
        return $this->view('aspirasi.create', compact('kategori'));
    }

    // Process Simpan Data (1 Input -> 2 Tabel)
    public function store(Request $request)
    {
        // 1. Validasi Input dari Form
        $request->validate([
            'id_kategori' => 'required',
            'lokasi'      => 'required|string|max:100',
            'keterangan'  => 'required|string|max:255',
        ]);

        // Ambil ID Siswa dari akun yang sedang login / session
        // (Ubah angka 1 ini dengan auth/session login siswa kamu)
        $id_siswa = auth()->user()->siswa->id_siswa ?? 1;

        // 2. Gunakan DB::transaction agar kedua tabel tersimpan secara serentak
        DB::transaction(function () use ($request, $id_siswa) {

            // TABEL 1: Simpan ke tabel 'aspirasi'
            $aspirasi = Aspirasi::create([
                'id_siswa'    => $id_siswa,
                'id_kategori' => $request->input('id_kategori'),
                'lokasi'      => $request->input('lokasi'),
                'keterangan'  => $request->input('keterangan'),
            ]);

            // TABEL 2: Simpan otomatis ke tabel 'tanggapan'
            // Mengambil 'id_aspirasi' yang baru saja dibuat di atas
            Tanggapan::create([
                'id_aspirasi' => $aspirasi->id_aspirasi,
                'status'      => 'menunggu', // Status awal pengaduan
                'feedback'    => null,       // Belum ada tanggapan dari admin
            ]);

        });

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil dikirim dan sedang menunggu tanggapan!');
    }
}