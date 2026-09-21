<?php

namespace App\Models;

use Sakuci\Database\Model;

class Tanggapan extends Model
{
    protected static ?string $table = 'tanggapan';
    protected string $primaryKey = 'id_tanggapan';

    protected array $fillable = ['id_aspirasi', 'status', 'feedback'];
}
