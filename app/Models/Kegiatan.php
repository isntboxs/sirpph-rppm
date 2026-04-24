<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';

    protected $fillable = [
        'tema_id',
        'bentuk_kegiatan_id',
        'name',
        'deskripsi',
        'foto_icon',
        'status',
        'diusulkan_oleh',
        'catatan_kepala',
    ];

    // ── Relasi ────────────────────────────────────────────────────────────

    public function tema(): BelongsTo
    {
        return $this->belongsTo(Tema::class, 'tema_id');
    }

    public function bentukKegiatan(): BelongsTo
    {
        return $this->belongsTo(BentukKegiatan::class, 'bentuk_kegiatan_id');
    }

    public function diusulkanOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diusulkan_oleh');
    }

    public function aspeks(): BelongsToMany
    {
        return $this->belongsToMany(
            AspekPerkembangan::class,
            'kegiatan_aspek',
            'kegiatan_id',
            'aspek_perkembangan_id'
        )->orderBy('id');
    }

    public function alatBahans(): BelongsToMany
    {
        return $this->belongsToMany(
            AlatBahan::class,
            'kegiatan_alat',
            'kegiatan_id',
            'alat_bahan_id'
        )->orderBy('name');
    }

    public function scopeDiusulkan(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeDisetujui(Builder $query): Builder
    {
        return $query->where('status', 'disetujui');
    }

    public function scopeDitolak(Builder $query): Builder
    {
        return $query->where('status', 'ditolak');
    }

    public function scopeTema(Builder $query, int $temaId): Builder
    {
        return $query->where('tema_id', $temaId);
    }

    public function scopeBentuk(Builder $query, int $bentukId): Builder
    {
        return $query->where('bentuk_kegiatan_id', $bentukId);
    }

    public function scopeAspek(Builder $query, int $aspekId): Builder
    {
        return $query->whereHas('aspeks', function (Builder $q) use ($aspekId) {
            $q->where('aspek_perkembangan_id', $aspekId);
        });
    }

    public function scopeCari(Builder $query, string $keyword): Builder
    {
        return $query->where('name', 'like', '%' . $keyword . '%');
    }

    public function scopeOlehGuru(Builder $query, int $guruId): Builder
    {
        return $query->where('diusulkan_oleh', $guruId);
    }

    public function scopeStatusFilter(Builder $query, ?string $status): Builder
    {
        return $query->when($status, function ($q) use ($status) {
            $q->where('status', $status);
        });
    }

    // cek apakah kegiatan terkunci 
    // Terkunci = sudah dipakai di 3 tahun ajaran berbeda di dalam RPPM
    // Kita akan implement ini nanti saat tabel rppm_kegiatan sudah ada
    public function isTerkunci(): bool
    {
        // Placeholder dulu, akan diisi saat RPPM sudah dibuat
        // Logikanya: hitung distinct tahun_ajaran_id dari rppm_kegiatan
        return false;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => '⏳',
            'disetujui' => '✅',
            'ditolak'   => '❌',
            default     => '-',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'bpnd',
            'disetujui' => 'bok',
            'ditolak'   => 'brj',
            default     => 'bdr',
        };
    }
}
