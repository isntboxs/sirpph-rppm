<?php
namespace App\Notifications;
use App\Models\Rppm;

class RppmDikembalikan extends BaseNotification
{
    public function __construct(protected Rppm $rppm) {}

    public function toArray(object $notifiable): array
    {
        return $this->format(
            judul: 'RPPM Dikembalikan',
            pesan: 'RPPM "' . $this->rppm->subTema->tema->name
                 . '" dikembalikan. Catatan: ' . $this->rppm->catatan_kepala,
            url  : '/rppm',
            icon : '↩️'
        );
    }
}