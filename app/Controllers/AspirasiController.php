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
    
    public function index(Request $request)
    {
        $data = Aspirasi::orderBy('id_aspirasi', 'desc')->paginate(10);
        return $this->view('aspirasi.index', compact('data'));
    }

   
    public function create(Request $request)
    {
       
        $kategori = Kategori::all();
        return $this->view('aspirasi.create', compact('kategori'));
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
        'lokasi'      => 'required|string|max:100',
        'keterangan'  => 'required|string|max:255',
    ]);

    $aspirasi = Aspirasi::create([
        'id_siswa'    => $siswa->id_siswa,
        'id_kategori' => $request->input('id_kategori'),
        'lokasi'      => $request->input('lokasi'),
        'keterangan'  => $request->input('keterangan'),
    ]);

    Tanggapan::create([
        'id_aspirasi' => $aspirasi->id_aspirasi,
        'status'      => 'menunggu',
        'feedback'    => null,
    ]);

    return $this->redirect('/aspirasi/tambah')->with('success', 'Aspirasi berhasil dikirim');
}
        
    }
