<?php
namespace App\Notifications;
use App\Models\Kegiatan;

class KegiatanDisetujui extends BaseNotification
{
    public function __construct(protected Kegiatan $kegiatan) {}

    public function toArray(object $notifiable): array
    {
        return $this->format(
            judul: 'Kegiatan Disetujui',
            pesan: 'Kegiatan "' . $this->kegiatan->name . '" telah disetujui',
            url  : '/kumpulan-kegiatan',
            icon : '✅'
        );
    }
}