<?php
namespace App\Notifications;
use App\Models\Kegiatan;

class KegiatanDiusulkan extends BaseNotification
{
    public function __construct(protected Kegiatan $kegiatan) {}

    public function toArray(object $notifiable): array
    {
        return $this->format(
            judul: 'Usulan Kegiatan Baru',
            pesan: 'Ada usulan kegiatan baru "' . $this->kegiatan->name
                 . '" menunggu validasi',
            url  : '/validasi-kegiatan',
            icon : '🗂️'
        );
    }
}