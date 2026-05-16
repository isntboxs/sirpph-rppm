<?php
namespace App\Notifications;
use App\Models\Rpph;

class RpphDiajukan extends BaseNotification
{
    public function __construct(protected Rpph $rpph) {}

    public function toArray(object $notifiable): array
    {
        return $this->format(
            judul: 'RPPH Menunggu Validasi',
            pesan: 'Guru ' . $this->rpph->rppm->guru->name
                 . ' mengajukan RPPH hari ' . $this->rpph->hari,
            url  : '/validasi-rpph',
            icon : '📄'
        );
    }
}