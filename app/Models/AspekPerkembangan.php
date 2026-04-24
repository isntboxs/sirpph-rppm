<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AspekPerkembangan extends Model
{
    protected $table = 'aspek_perkembangan';

    protected $fillable = ['name', 'emote', 'warna'];

    public function getBadgeAttribute(): string
    {
        return '<span class="ap ' . $this->warna . '">'
            . $this->emote . ' ' . $this->name
            . '</span>';
    }

    public function kegiatans(): BelongsToMany
    {
        return $this->belongsToMany(Kegiatan::class, 'kegiatan_aspek', 'aspek_perkembangan_id', 'kegiatan_id');
    }
}
