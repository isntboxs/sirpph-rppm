<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RpphPenilaian extends Model
{
    protected $table = 'rpph_penilaian';

    protected $fillable = ['rpph_id', 'nama', 'urutan'];

    public function rpph(): BelongsTo
    {
        return $this->belongsTo(Rpph::class, 'rpph_id');
    }

    public function poins(): HasMany
    {
        return $this->hasMany(RpphPenilaianPoin::class, 'penilaian_id')
            ->orderBy('urutan');
    }
}
