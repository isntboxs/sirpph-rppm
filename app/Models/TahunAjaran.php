<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'name',
        'active',
        'semester',
    ];

    protected $casts = [
        'active' => 'boolean',
        'semester' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public static function getActive(): ?self
    {
        return self::where('active', true)->first();
    }
}