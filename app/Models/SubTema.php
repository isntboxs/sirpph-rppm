<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubTema extends Model
{
    protected $table = 'sub_tema';
    protected $fillable = ['tema_id', 'name', 'minggu_ke', 'status', 'alasan_edit', 'edited_by'];

    public function tema(): BelongsTo
    {
        return $this->belongsTo(Tema::class, 'tema_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}