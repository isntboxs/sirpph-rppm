<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rpph extends Model
{
    protected $table = 'rpph';

    protected $fillable = [
        'rppm_id',
        'hari',
        'pembuka',
        'inti',
        'penutup',
        'status',
        'catatan_kepala',
    ];

    public function rppm(): BelongsTo
    {
        return $this->belongsTo(Rppm::class, 'rppm_id');
    }

    public function kegiatans()
    {
        return RppmKegiatan::where('rppm_id', $this->rppm_id)
            ->where('hari', $this->hari)
            ->with('kegiatan.aspeks', 'kegiatan.alatBahans', 'kegiatan.bentukKegiatan')
            ->orderBy('urutan')
            ->get();
    }

    public function scopePending(Builder $q): Builder
    {
        return $q->where('status', 'pending');
    }

    public function scopeDisetujui(Builder $q): Builder
    {
        return $q->where('status', 'disetujui');
    }

    public function scopePendingValidasi(Builder $q): Builder
    {
        return $q->where('status', 'pending');
    }

    public function getTanggalFormatAttribute(): string
    {
        return $this->created_at
            ->locale('id')
            ->translatedFormat('d F Y');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'        => '📝 Draft',
            'pending'      => '⏳ Menunggu',
            'disetujui'    => '✅ Disetujui',
            'dikembalikan' => '↩️ Dikembalikan',
            default        => '-',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'draft'        => 'bdr',
            'pending'      => 'bpnd',
            'disetujui'    => 'bok',
            'dikembalikan' => 'brj',
            default        => 'bdr',
        };
    }
}
