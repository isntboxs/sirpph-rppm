<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nama',
        'kelas',
        'tanggal_lahir',
        'jenis_kelamin',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function orangTua(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ortu_siswa');
    }
}
