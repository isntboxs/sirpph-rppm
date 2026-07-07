<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'kelas_id',
        'name',
        'tanggal_lahir',
        'jenis_kelamin',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function portofolios()
    {
        return $this->hasMany(Portofolio::class);
    }

    public function getUmurAttribute(): int
    {
        return Carbon::parse($this->tanggal_lahir)->age;
    }

    public function getTanggalLahirFormatAttribute(): string
    {
        return Carbon::parse($this->tanggal_lahir)->format('d/m/Y');
    }

    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? '👦 Laki-laki' : '👧 Perempuan';
    }

    public function scopeKelas($query, int $kelasId)
    {
        return $query->where('kelas_id', $kelasId);
    }
}
