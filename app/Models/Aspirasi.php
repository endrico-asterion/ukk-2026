<?php

namespace App\Models;

use Sakuci\Database\Model;

class Aspirasi extends Model
{
    protected static ?string $table = 'aspirasi';
    protected string $primaryKey = 'id_aspirasi';

    protected array $fillable = ['id_siswa', 'id_kategori', 'lokasi', 'keterangan'];

    public function kategori()
{
    return $this->belongsTo(\App\Models\Kategori::class, 'id_kategori', 'id_kategori');
}

public function tanggapan()
{
    return $this->hasOne(\App\Models\Tanggapan::class, 'id_aspirasi', 'id_aspirasi');
}
}

