<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rppm extends Model
{
    protected $table = 'rppm';

    protected $fillable = [
        'guru_id',
        'tahun_ajaran_id',
        'sub_tema_id',
        'minggu_ke',
        'model_pembelajaran',
        'tujuan',
        'capaian',
        'status',
        'catatan_kepala',
    ];

    // ── Relasi ────────────────────────────────────────────────────────────

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function subTema(): BelongsTo
    {
        return $this->belongsTo(SubTema::class, 'sub_tema_id');
    }

    public function rppmKegiatans(): HasMany
    {
        return $this->hasMany(RppmKegiatan::class, 'rppm_id')->orderBy('hari')->orderBy('urutan');
    }

    public function rpphs(): HasMany
    {
        return $this->hasMany(Rpph::class, 'rppm_id');
    }

    public function scopeDraft(Builder $q): Builder
    {
        return $q->where('status', 'draft');
    }

    public function scopePending(Builder $q): Builder
    {
        return $q->where('status', 'pending');
    }

    public function scopeDisetujui(Builder $q): Builder
    {
        return $q->where('status', 'disetujui');
    }

    public function scopeDikembalikan(Builder $q): Builder
    {
        return $q->where('status', 'dikembalikan');
    }

    public function scopeOlehGuru(Builder $q, int $guruId): Builder
    {
        return $q->where('guru_id', $guruId);
    }

    public function scopePendingValidasi(Builder $q): Builder
    {
        return $q->where('status', 'pending');
    }

    public function getJumlahAspekAttribute(): int
    {
        return AspekPerkembangan::whereHas('kegiatans', function ($q) {
            $q->whereHas('rppmKegiatans', function ($q2) {
                $q2->where('rppm_id', $this->id);
            });
        })->count();
    }

    public function kegiatanPerHari(): array
    {
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $result = [];

        foreach ($hari as $h) {
            $result[$h] = $this->rppmKegiatans
                ->where('hari', $h)
                ->values();
        }

        return $result;
    }

    public function aspekTerstimulasi(): \Illuminate\Support\Collection
    {
        return $this->rppmKegiatans
            ->flatMap(fn($rk) => $rk->kegiatan->aspeks)
            ->unique('id');
    }

    public function aspekBelumTerstimulasi(): \Illuminate\Support\Collection
    {
        $sudahAda = $this->aspekTerstimulasi()->pluck('id');
        return AspekPerkembangan::whereNotIn('id', $sudahAda)->get();
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
