<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Prosem extends Model
{
    protected $table = 'prosem';

    protected $fillable = [
        'tahun_ajaran_id',
        'tema_id',
        'sub_tema_id',
        'minggu_ke',
        'status',
        'catatan',
    ];

    protected $casts = [
        'minggu_ke' => 'integer',
    ];

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function tema(): BelongsTo
    {
        return $this->belongsTo(Tema::class, 'tema_id');
    }

    public function subTema(): BelongsTo
    {
        return $this->belongsTo(SubTema::class, 'sub_tema_id');
    }

    public function scopeMenunggu(Builder $q): Builder
    {
        return $q->where('status', 'menunggu');
    }

    public function scopeValid(Builder $q): Builder
    {
        return $q->where('status', 'valid');
    }

    public function scopeInvalid(Builder $q): Builder
    {
        return $q->where('status', 'invalid');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => '⏳ Menunggu',
            'valid'    => '✅ Valid',
            'invalid'  => '❌ Invalid',
            default    => '-',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'bpnd',
            'valid'    => 'bok',
            'invalid'  => 'brj',
            default    => 'bdr',
        };
    }
}
