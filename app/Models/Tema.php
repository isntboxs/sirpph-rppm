<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tema extends Model
{
    protected $table = 'tema';

    protected $fillable = ['name', 'semester'];

    public function subTemas(): HasMany
    {
        return $this->hasMany(SubTema::class, 'tema_id')->orderBy('name');
    }

    public function getSemesterLabelAttribute(): string
    {
        return 'Semester ' . $this->semester;
    }
}
