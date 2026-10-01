<?php

namespace App\Models;

use Sakuci\Database\Model;

class Aspirasi extends Model
{
    protected static ?string $table = 'aspirasi';
    protected string $primaryKey = 'id_aspirasi';

    protected array $fillable = ['id_siswa', 'id_kategori', 'id_alat', 'lokasi', 'keterangan', 'foto'];

    public function kategori()
    {
    return $this->belongsTo(\App\Models\Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat', 'id_alat');
    }

    public function tanggapan()
    {
    return $this->hasOne(\App\Models\Tanggapan::class, 'id_aspirasi', 'id_aspirasi');
    }

    public function siswa()

    {

    return $this->belongsTo(\App\Models\Siswa::class, 'id_siswa', 'id_siswa');
    
    }

}

