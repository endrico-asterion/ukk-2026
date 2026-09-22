<?php

namespace App\Models;

use Sakuci\Database\Model;

class Siswa extends Model
{
    protected static ?string $table = 'siswa';
    protected string $primaryKey = 'id_siswa';

    protected array $fillable = ['user_id', 'nis', 'kelas' ];
}
