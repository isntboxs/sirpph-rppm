<?php
namespace App\Notifications;
use App\Models\Rpph;

class RpphDisetujui extends BaseNotification
{
    public function __construct(protected Rpph $rpph) {}

    public function toArray(object $notifiable): array
    {
        return $this->format(
            judul: 'RPPH Disetujui',
            pesan: 'RPPH hari ' . $this->rpph->hari . ' telah disetujui',
            url  : '/rpph',
            icon : '✅'
        );
    }
}