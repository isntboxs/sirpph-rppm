<?php
namespace App\Notifications;
use App\Models\Portofolio;

class PortofolioBaru extends BaseNotification
{
    public function __construct(protected Portofolio $portofolio) {}

    public function toArray(object $notifiable): array
    {
        return $this->format(
            judul: 'Portofolio Baru',
            pesan: 'Ada update portofolio baru untuk '
                 . $this->portofolio->siswa->name,
            url  : '/portofolio-anak',
            icon : '📸'
        );
    }
}