<?php
namespace App\Notifications;
use App\Models\Rppm;

class RppmDiajukan extends BaseNotification
{
    public function __construct(protected Rppm $rppm) {}

    public function toArray(object $notifiable): array
    {
        return $this->format(
            judul: 'RPPM Baru Menunggu',
            pesan: 'Guru ' . $this->rppm->guru->name
                 . ' mengajukan RPPM "' . $this->rppm->subTema->tema->name . '"',
            url  : '/validasi-rppm',
            icon : '📋'
        );
    }
}