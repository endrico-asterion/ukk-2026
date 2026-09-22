<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $data = Kategori::orderBy('id_kategori', 'desc')->paginate(5);
        return $this->view('kategori.index', compact('data'));
    }

    public function create(Request $request)
    {
        return $this->view('kategori.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

       
        $terakhir = Kategori::orderBy('id_kategori', 'desc')->first();
        
        
        $nomorUrut = $terakhir && isset($terakhir->kode_kategori) ? ((int) substr($terakhir->kode_kategori, 3)) + 1 : 1;
        
        
        $kodeOtomatis = 'KTG' . sprintf("%03d", $nomorUrut);

        
        Kategori::create([
            'kode_kategori' => $kodeOtomatis,
            'nama_kategori' => $request->input('nama_kategori'),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        return $this->view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id_kategori)
    {
        
        $request->validate([
            'nama_kategori' => 'required|string|max:225',
        ]);

        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->update([
            'nama_kategori' => $request->input('nama_kategori'),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
