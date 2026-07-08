<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class GeneralNotification extends BaseNotification
{
    use Queueable;

    public $title;
    public $message;
    public $url;

    public function __construct($title, $message, $url = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
    }

    public function toArray(object $notifiable): array
    {
        return $this->format(
            $this->title,
            $this->message,
            $this->url ?? '#',
            '📢'
        );
    }
}
