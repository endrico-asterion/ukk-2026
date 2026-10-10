<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Aspirasi;
use App\Models\Tanggapan;
use App\Models\Kategori;
use App\Models\Alat;
use Illuminate\Support\Facades\DB;

class AspirasiController extends Controller
{
    
    public function index(Request $request)
{
    $filter = [
        'tanggal'     => $request->input('tanggal'),
        'bulan'       => $request->input('bulan'),
        'id_siswa'    => $request->input('id_siswa'),
        'id_kategori' => $request->input('id_kategori'),
    ];

    $query = Aspirasi::orderBy('id_aspirasi', 'desc');

    if ($filter['tanggal']) {
        $query = $query->where('created_at', '>=', $filter['tanggal'] . ' 00:00:00')
                       ->where('created_at', '<=', $filter['tanggal'] . ' 23:59:59');
    } elseif ($filter['bulan']) {
        $awal  = $filter['bulan'] . '-01 00:00:00';
        $akhir = date('Y-m-t', strtotime($awal)) . ' 23:59:59';
        $query = $query->where('created_at', '>=', $awal)
                       ->where('created_at', '<=', $akhir);
    }

    if ($filter['id_siswa']) {
        $query = $query->where('id_siswa', $filter['id_siswa']);
    }

    if ($filter['id_kategori']) {
        $query = $query->where('id_kategori', $filter['id_kategori']);
    }

    $data     = $query->paginate(10);
    $kategori = Kategori::all();
    $siswa    = \App\Models\Siswa::all();

    return $this->view('aspirasi.index', compact('data', 'kategori', 'siswa', 'filter'));
}

   
    public function create(Request $request)
    {
       
        $kategori = Kategori::all();
        $alat     = Alat::all();
        return $this->view('aspirasi.create', compact('kategori', 'alat'));
    }

    
    public function store(Request $request)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    
    $userId = $_SESSION['user']['id'] ?? $_SESSION['user_id'] ?? null;

    if (!$userId) {
        return $this->redirect('/login')->with('error', 'Sesi login habis, silakan login ulang.');
    }

    
    $siswa = \App\Models\Siswa::where('user_id', $userId)->first();

    if (!$siswa) {
        return $this->redirect('/login')->with('error', 'Data siswa tidak ditemukan untuk akun ini.');
    }

    $request->validate([
        'id_kategori' => 'required',
        'id_alat'     => 'nullable',
        'lokasi'      => 'required|string|max:100',
        'keterangan'  => 'required|string|max:255',
    ]);

    $foto = $this->simpanFoto();

    if ($foto === false) {
    return $this->redirect('/siswa/aspirasi/tambah')
        ->with('error', 'Foto tidak valid. Gunakan JPG, PNG, atau WEBP maksimal 2 MB.');
    }

    $aspirasi = Aspirasi::create([
        'id_siswa'    => $siswa->id_siswa,
        'id_kategori' => $request->input('id_kategori'),
        'id_alat'     => $request->input('id_alat') ?: null,
        'lokasi'      => $request->input('lokasi'),
        'keterangan'  => $request->input('keterangan'),
        'foto'        => $foto, 
    ]);

    Tanggapan::create([
        'id_aspirasi' => $aspirasi->id_aspirasi,
        'status'      => 'menunggu',
        'feedback'    => null,
    ]);

    return $this->redirect('/siswa/aspirasi')->with('success', 'Aspirasi berhasil dikirim');
    }

    public function edit(Request $request, $aspirasi)
    {
    $aspirasi = Aspirasi::findOrFail($aspirasi);
    return $this->view('aspirasi.edit', compact('aspirasi'));
    }

    public function update(Request $request, $aspirasi)
    {
    $aspirasi = Aspirasi::findOrFail($aspirasi);

    $request->validate([
        'status'   => 'required|in:menunggu,proses,selesai',
        'feedback' => 'nullable|string',
    ]);

    $tanggapan = Tanggapan::where('id_aspirasi', $aspirasi->id_aspirasi)->first();

    if ($tanggapan) {
    $tanggapan->status   = $request->input('status');
    $tanggapan->feedback = $request->input('feedback');
    $tanggapan->save();
    } else {
    Tanggapan::create([
        'id_aspirasi' => $aspirasi->id_aspirasi,
        'status'      => $request->input('status'),
        'feedback'    => $request->input('feedback'),
    ]);
    }

    return $this->redirect('/admin/aspirasi')->with('success', 'Status aspirasi berhasil diperbarui');
    }

     /**
    * Simpan foto aspirasi (opsional).
    * Mengembalikan: null = tidak ada file, false = file tidak valid, string = nama file tersimpan.
    */
    private function simpanFoto()
    {
    if (!isset($_FILES['foto']) || $_FILES['foto']['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    $file = $_FILES['foto'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        return false;
    }

    $ext   = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $boleh = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($ext, $boleh)) {
        return false;
    }

    if (!@getimagesize($file['tmp_name'])) {
        return false;
    }

    $folder = $_SERVER['DOCUMENT_ROOT'] . '/uploads/aspirasi';
    if (!is_dir($folder)) {
        mkdir($folder, 0775, true);
    }

    $nama = 'asp_' . date('YmdHis') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;

    if (!move_uploaded_file($file['tmp_name'], $folder . '/' . $nama)) {
        return false;
    }

    return $nama;
    }

    public function destroy(Request $request, $aspirasi)
    {
    $aspirasi = Aspirasi::findOrFail($aspirasi);
    $aspirasi->delete();

    return $this->redirect('/admin/aspirasi')->with('success', 'Aspirasi berhasil dihapus');
    }

    private function siswaSaatIni()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $userId = $_SESSION['user']['id'] ?? $_SESSION['user_id'] ?? null;
    if (!$userId) {
        return null;
    }
    return \App\Models\Siswa::where('user_id', $userId)->first();
}

public function riwayat(Request $request)
{
    $siswa = $this->siswaSaatIni();
    if (!$siswa) {
        return $this->redirect('/login')->with('error', 'Data siswa tidak ditemukan untuk akun ini.');
    }

    $data = Aspirasi::where('id_siswa', $siswa->id_siswa)
        ->orderBy('id_aspirasi', 'desc')
        ->paginate(10);

    return $this->view('aspirasi.riwayat', compact('data'));
}

public function editSiswa(Request $request, $aspirasi)
{
    $siswa = $this->siswaSaatIni();
    if (!$siswa) {
        return $this->redirect('/login')->with('error', 'Data siswa tidak ditemukan untuk akun ini.');
    }

    $aspirasi = Aspirasi::where('id_aspirasi', $aspirasi)
        ->where('id_siswa', $siswa->id_siswa)
        ->first();

    if (!$aspirasi) {
        return $this->redirect('/siswa/aspirasi')->with('error', 'Aspirasi tidak ditemukan.');
    }

    return $this->view('aspirasi.edit_siswa', compact('aspirasi'));
}

public function updateSiswa(Request $request, $aspirasi)
{
    $siswa = $this->siswaSaatIni();
    if (!$siswa) {
        return $this->redirect('/login')->with('error', 'Data siswa tidak ditemukan untuk akun ini.');
    }

    $aspirasi = Aspirasi::where('id_aspirasi', $aspirasi)
        ->where('id_siswa', $siswa->id_siswa)
        ->first();

    if (!$aspirasi) {
        return $this->redirect('/siswa/aspirasi')->with('error', 'Aspirasi tidak ditemukan.');
    }

    $request->validate([
        'lokasi'     => 'required|string|max:100',
        'keterangan' => 'required|string|max:255',
    ]);

    $aspirasi->update([
        'lokasi'     => $request->input('lokasi'),
        'keterangan' => $request->input('keterangan'),
    ]);

    return $this->redirect('/siswa/aspirasi')->with('success', 'Aspirasi berhasil diperbarui');
}
        
}
