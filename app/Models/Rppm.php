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
        'tanggal_dibuat',
        'tujuan',
        'capaian',
        'kegiatan_pembuka',
        'kegiatan_inti',
        'recalling',
        'kegiatan_penutup',
        'rencana_penilaian',
        'status',
        'catatan_kepala'
    ];

    protected $casts = [
        'tanggal_dibuat' => 'date',
        'minggu_ke'      => 'integer',
        'tahun_ajaran_id' => 'integer',
    ];

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

    public function laporanRpp()
    {
        return $this->hasOne(LaporanRpp::class, 'rppm_id');
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

    public static function syncDraftsForGuru(int $guruId, int $taId)
    {
        $subTemas = SubTema::whereHas('tema', function ($q) use ($taId) {
            $q->where('tahun_ajaran_id', $taId)->where('status', 'disetujui');
        })->get();

        if ($subTemas->isEmpty()) return;

        $existingRppms = self::where('guru_id', $guruId)
            ->where('tahun_ajaran_id', $taId)
            ->pluck('sub_tema_id')
            ->toArray();

        $newRppmData = [];
        $now = now()->toDateString();
        $nowTime = now();

        foreach ($subTemas as $st) {
            if (!in_array($st->id, $existingRppms)) {
                $newRppmData[] = [
                    'guru_id' => $guruId,
                    'sub_tema_id' => $st->id,
                    'tahun_ajaran_id' => $taId,
                    'minggu_ke' => $st->minggu_ke,
                    'status' => 'draft',
                    'tanggal_dibuat' => $now,
                    'created_at' => $nowTime,
                    'updated_at' => $nowTime,
                ];
            }
        }

        if (!empty($newRppmData)) {
            self::insert($newRppmData);
        }

        $rppms = self::where('guru_id', $guruId)->where('tahun_ajaran_id', $taId)->get();
        $existingLaporans = LaporanRpp::where('guru_id', $guruId)->pluck('rppm_id')->toArray();
        $newLaporanData = [];

        foreach ($rppms as $rppm) {
            if (!in_array($rppm->id, $existingLaporans)) {
                $newLaporanData[] = [
                    'rppm_id' => $rppm->id,
                    'guru_id' => $guruId,
                    'tanggal' => $now,
                    'status' => 'draft',
                    'created_at' => $nowTime,
                    'updated_at' => $nowTime,
                ];
            }
        }

        if (!empty($newLaporanData)) {
            LaporanRpp::insert($newLaporanData);
        }
    }

    public static function syncDraftsForAllGurus(int $taId)
    {
        $gurus = User::guru()->active()->get();
        foreach ($gurus as $guru) {
            self::syncDraftsForGuru($guru->id, $taId);
        }
    }
}
