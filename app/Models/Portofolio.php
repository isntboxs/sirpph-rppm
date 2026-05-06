<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portofolio extends Model
{
    protected $table = 'portofolio';

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'rpph_id',
        'kegiatan_id',
        'foto_icon',
        'catatan',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function rpph(): BelongsTo
    {
        return $this->belongsTo(Rpph::class, 'rpph_id');
    }

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public function aspeks(): BelongsToMany
    {
        return $this->belongsToMany(
            AspekPerkembangan::class,
            'portofolio_aspek',
            'portofolio_id',
            'aspek_id'
        )->orderBy('id');
    }

    public function komentars(): HasMany
    {
        return $this->hasMany(KomentarPortofolio::class, 'portofolio_id')
            ->with('user:id,name,role')
            ->latest();
    }


    public function scopeOlehGuru(Builder $q, int $guruId): Builder
    {
        return $q->where('guru_id', $guruId);
    }

    public function scopeSiswa(Builder $q, int $siswaId): Builder
    {
        return $q->where('siswa_id', $siswaId);
    }

    public function scopeAspek(Builder $q, int $aspekId): Builder
    {
        return $q->whereHas('aspeks', fn($a) => $a->where('aspek_id', $aspekId));
    }


    public function getTanggalFormatAttribute(): string
    {
        return $this->created_at->locale('id')->translatedFormat('d F Y');
    }
}
