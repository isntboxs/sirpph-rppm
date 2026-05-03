<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RppmKegiatan extends Model
{
    protected $table = 'rppm_kegiatan';

    protected $fillable = [
        'rppm_id',
        'kegiatan_id',
        'hari',
        'urutan',
    ];

    public function rppm(): BelongsTo
    {
        return $this->belongsTo(Rppm::class, 'rppm_id');
    }

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }
}