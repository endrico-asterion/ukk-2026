<?php

namespace App\Models;

use Sakuci\Database\Model;

class Aspirasi extends Model
{
    protected static ?string $table = 'aspirasi';
    protected string $primaryKey = 'id_aspirasi';

    protected array $fillable = ['id_siswa', 'id_kategori', 'lokasi', 'keterangan'];
}
