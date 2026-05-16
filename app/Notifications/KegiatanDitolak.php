<?php
namespace App\Notifications;
use App\Models\Kegiatan;

class KegiatanDitolak extends BaseNotification
{
    public function __construct(protected Kegiatan $kegiatan) {}

    public function toArray(object $notifiable): array
    {
        return $this->format(
            judul: 'Kegiatan Ditolak',
            pesan: 'Kegiatan "' . $this->kegiatan->name . '" ditolak',
            url  : '/validasi-kegiatan',
            icon : '❌'
        );
    }
}