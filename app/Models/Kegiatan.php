<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function rppmKegiatans(): HasMany
    {
        return $this->hasMany(RppmKegiatan::class, 'kegiatan_id');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
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

    public function jumlahTahunDipakai(): int
    {
        return RppmKegiatan::where('kegiatan_id', $this->id)
            ->join('rppm', 'rppm.id', '=', 'rppm_kegiatan.rppm_id')
            ->where('rppm.status', 'disetujui')
            ->distinct('rppm.tahun_ajaran_id')
            ->count('rppm.tahun_ajaran_id');
    }

    private static function subqueryJumlahTahun(): string
    {
        return '(
            SELECT COUNT(DISTINCT r.tahun_ajaran_id)
            FROM rppm_kegiatan rk
            JOIN rppm r ON r.id = rk.rppm_id
            WHERE rk.kegiatan_id = kegiatan.id
            AND r.status = "disetujui"
        )';
    }

    public function scopeWithJumlahTahun(Builder $query): Builder
    {
        return $query->selectRaw('kegiatan.*, ' . self::subqueryJumlahTahun() . ' as jumlah_tahun_dipakai');
    }

    public function isTerkunci(): bool
    {
        return $this->jumlahTahunDipakai() >= 3;
    }

    public function getPresentasePemakaianAttribute(): int
    {
        return min(100, ($this->jumlahTahunDipakai() / 3) * 100);
    }

    public function getLabelPemakaianAttribute(): string
    {
        $n = $this->jumlahTahunDipakai();
        if ($n >= 3) return '🔒 Terkunci Permanen';
        return $n . '/3 tahun ajaran';
    }

    public function scopeTerkunci(Builder $query): Builder
    {
        return $query->whereRaw('(
            SELECT COUNT(DISTINCT r.tahun_ajaran_id)
            FROM rppm_kegiatan rk
            JOIN rppm r ON r.id = rk.rppm_id
            WHERE rk.kegiatan_id = kegiatan.id
            AND r.status = "disetujui"
        ) >= 3');
    }

    public function scopeBelumTerkunci(Builder $query): Builder
    {
        return $query->whereRaw('(
            SELECT COUNT(DISTINCT r.tahun_ajaran_id)
            FROM rppm_kegiatan rk
            JOIN rppm r ON r.id = rk.rppm_id
            WHERE rk.kegiatan_id = kegiatan.id
            AND r.status = "disetujui"
        ) < 3');
    }

    public function getWarnaProgressAttribute(): string
    {
        return match (true) {
            $this->jumlah_tahun_dipakai >= 3 => 'pk',
            $this->jumlah_tahun_dipakai >= 2 => 'or',
            default                          => 'gr',
        };
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
