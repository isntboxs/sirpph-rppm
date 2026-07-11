<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordResetNotification extends BaseNotification implements ShouldQueue
{
    use Queueable;

    protected $userName;
    protected $userId;
    protected $resetCode;

    public function __construct($userName, $userId, $resetCode)
    {
        $this->userName = $userName;
        $this->userId = $userId;
        $this->resetCode = $resetCode;
    }

    public function toArray(object $notifiable): array
    {
        return $this->format(
            'Lupa Password',
            'User ' . $this->userName . ' meminta reset password. Kode Konfirmasi: [' . $this->resetCode . ']. Jangan setujui jika user tidak memberikan kode ini secara langsung!',
            route('kelola_pengguna', ['highlight_user' => $this->userId]),
            '🔑'
        );
    }
}
