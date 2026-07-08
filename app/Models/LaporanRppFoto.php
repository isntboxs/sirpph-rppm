<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanRppFoto extends Model
{
    protected $table = 'laporan_rpp_foto';

    protected $fillable = [
        'laporan_rpp_id',
        'jenis',
        'path',
    ];

    public function laporanRpp(): BelongsTo
    {
        return $this->belongsTo(LaporanRpp::class, 'laporan_rpp_id');
    }
}
