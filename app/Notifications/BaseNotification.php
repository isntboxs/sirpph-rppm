<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

abstract class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['database', WebPushChannel::class];
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

    public function toWebPush(object $notifiable, object $notification): WebPushMessage
    {
        $data = $this->toArray($notifiable);

        return (new WebPushMessage)
            ->title($data['judul'])
            ->icon($data['icon'])
            ->body($data['pesan'])
            ->data([
                'url' => $data['url'],
            ]);
    }
}
