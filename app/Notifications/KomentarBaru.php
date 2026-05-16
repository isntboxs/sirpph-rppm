<?php
namespace App\Notifications;
use App\Models\KomentarPortofolio;

class KomentarBaru extends BaseNotification
{
    public function __construct(protected KomentarPortofolio $komentar) {}

    public function toArray(object $notifiable): array
    {
        return $this->format(
            judul: 'Komentar Baru',
            pesan: $this->komentar->user->name
                 . ' mengomentari portofolio '
                 . $this->komentar->portofolio->siswa->name,
            url  : '/portofolio-siswa',
            icon : '💬'
        );
    }
}