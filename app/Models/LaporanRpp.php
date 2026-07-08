<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaporanRpp extends Model
{
    protected $table = 'laporan_rpp';

    protected $fillable = [
        'guru_id',
        'rppm_id',
        'tanggal',
        'keterangan_singkat',
        'status',
        'catatan_kepala'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function rppm(): BelongsTo
    {
        return $this->belongsTo(Rppm::class, 'rppm_id');
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(LaporanRppFoto::class, 'laporan_rpp_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'        => '📝 Draft',
            'pending'      => '⏳ Terkirim',
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
