<?php
namespace App\Notifications;
use App\Models\Rppm;

class RppmDisetujui extends BaseNotification
{
    public function __construct(protected Rppm $rppm) {}

    public function toArray(object $notifiable): array
    {
        return $this->format(
            judul: 'RPPM Disetujui',
            pesan: 'RPPM "' . $this->rppm->subTema->tema->name
                 . '" telah disetujui Kepala Sekolah',
            url  : '/rppm',
            icon : '✅'
        );
    }
}