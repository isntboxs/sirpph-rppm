<?php
namespace App\Notifications;
use App\Models\Rpph;

class RpphDikembalikan extends BaseNotification
{
    public function __construct(protected Rpph $rpph) {}

    public function toArray(object $notifiable): array
    {
        return $this->format(
            judul: 'RPPH Dikembalikan',
            pesan: 'RPPH hari ' . $this->rpph->hari
                 . ' dikembalikan. Catatan: ' . $this->rpph->catatan_kepala,
            url  : '/rpph',
            icon : '↩️'
        );
    }
}