<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

abstract class BaseNotification extends Notification
{
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    abstract public function toArray(object $notifiable): array;

    protected function format(string $judul, string $pesan, string $url = '', string $icon = '🔔'): array
    {
        return [
            'judul' => $judul,
            'pesan' => $pesan,
            'url'   => $url,
            'icon'  => $icon,
        ];
    }
}