<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tema extends Model
{
    protected $table = 'tema';

    protected $fillable = ['tahun_ajaran_id', 'name', 'status', 'semester', 'alasan_edit', 'edited_by'];

    public function subTemas(): HasMany
    {
        return $this->hasMany(SubTema::class, 'tema_id')->orderBy('name');
    }

    public function getSemesterLabelAttribute(): string
    {
        return 'Semester ' . $this->semester;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}
