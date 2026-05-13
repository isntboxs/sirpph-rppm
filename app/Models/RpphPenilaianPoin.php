<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RpphPenilaianPoin extends Model
{
    protected $table = 'rpph_penilaian_poin';

    protected $fillable = ['penilaian_id', 'poin', 'urutan'];

    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(RpphPenilaian::class, 'penilaian_id');
    }
}