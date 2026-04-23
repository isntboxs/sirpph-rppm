<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BentukKegiatan extends Model
{
    protected $table = 'bentuk_kegiatan';

    protected $fillable = ['name'];
}