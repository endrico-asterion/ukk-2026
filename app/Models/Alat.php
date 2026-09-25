<?php

namespace App\Models;

use Sakuci\Database\Model;
use App\Models\Alat;
use App\Models\Kategori;

class Alat extends Model
{
    protected static ?string $table = 'alat';
    protected string $primaryKey = 'id_alat';

    protected array $fillable = ['kode_alat', 'nama_alat', 'id_kategori'];


    public function kategori()

    {

    return $this->belongsTo(kategori::class, 'id_kategori', 'id_kategori');

    }   
}