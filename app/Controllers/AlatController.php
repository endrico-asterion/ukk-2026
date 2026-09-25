<?php

namespace App\Controllers;

use Sakuci\Controller;
use Sakuci\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;

class AlatController extends Controller
{
    public function index(Request $request)
   {
        $data = Alat::orderBy('id_alat', 'desc')->paginate(10);
        return $this->view('alat.index', compact('data'));
    }

    public function create(Request $request)
    {
        $kategori = Kategori::all();
        return $this->view('alat.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'id_kategori' => 'required',
        ]);

        $terakhir = Alat::orderBy('id_alat', 'desc')->first();
        $nomorUrut = $terakhir ? ((int) substr($terakhir->kode_alat, 3)) + 1 : 1;
        $kodeOtomatis = 'ALT' . sprintf("%03d", $nomorUrut);

        Alat::create([
            'kode_alat'   => $kodeOtomatis,
            'nama_alat'   => $request->input('nama_alat'),
            'id_kategori' => $request->input('id_kategori'),
        ]);

        return redirect()->route('alat.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit($id_alat)
    {
        $alat = Alat::findOrFail($id_alat);
        $kategori = Kategori::all();
        return $this->view('alat.edit', compact('alat', 'kategori'));
    }

    public function update(Request $request, $id_alat)
    {
        $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'id_kategori' => 'required',
        ]);

        $alat = Alat::findOrFail($id_alat);
        $alat->update([
            'nama_alat'   => $request->input('nama_alat'),
            'id_kategori' => $request->input('id_kategori'),
        ]);

        return redirect()->route('alat.index')->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy($id_alat)
    {
        $alat = Alat::findOrFail($id_alat);
        $alat->delete();

        return redirect()->route('alat.index')->with('success', 'Alat berhasil dihapus.');
    }
}
