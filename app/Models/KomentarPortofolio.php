<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KomentarPortofolio extends Model
{
    protected $table = 'komentar_portofolio';

    protected $fillable = ['portofolio_id', 'user_id', 'komentar'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function portofolio(): BelongsTo
    {
        return $this->belongsTo(Portofolio::class, 'portofolio_id');
    }

    public function getWaktuFormatAttribute(): string
    {
        return $this->created_at->locale('id')->diffForHumans();
    }
}
