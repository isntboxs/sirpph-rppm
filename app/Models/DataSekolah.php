<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSekolah extends Model
{
    protected $table = 'data_sekolah';

    protected $fillable = [
        'name',
        'npsn',
        'no_telp',
        'alamat',
    ];

    public static function getData(): ?self
    {
        return self::first();
    }
}