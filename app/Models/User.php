<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable, HasPushSubscriptions;

    protected $table = 'users';

    protected $authIdentifierName = 'username';

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'active',
        'no_telp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::needsRehash($value)
            ? Hash::make($value)
            : $value;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKepalaSekolah(): bool
    {
        return $this->role === 'kepala';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }



    public function isActive(): bool
    {
        return $this->active === true;
    }

    public function kelas(): HasOne
    {
        return $this->hasOne(Kelas::class, 'guru_id');
    }



    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeKepalaSekolah($query)
    {
        return $query->where('role', 'kepala');
    }

    public function scopeGuru($query)
    {
        return $query->where('role', 'guru');
    }



    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function roleText(): string
    {
        return match ($this->role) {
            'admin'  => 'Admin',
            'kepala' => 'Kepala Sekolah',
            'guru'   => $this->kelas ? 'Guru ' . $this->kelas->name : 'Guru',
            default  => 'Unknown',
        };
    }

    public function roleBadge(): string
    {
        return match ($this->role) {
            'admin'  => 'ra',
            'kepala' => 'rk',
            'guru'   => 'rg',
            default  => 'ro',
        };
    }
}
