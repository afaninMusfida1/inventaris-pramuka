<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PeminjamanReminderNotification extends Notification
{
    use Queueable;

    private $peminjaman;
    private $tipe;

    public function __construct($peminjaman, $tipe)
    {
        $this->peminjaman = $peminjaman;
        $this->tipe = $tipe; // "H-1" atau "Hari H"
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "[$this->tipe] Jangan lupa mengembalikan barang: {$this->peminjaman->barang->nama_barang} pada {$this->peminjaman->tanggal_pengembalian}.",
            'tanggal_pengembalian' => $this->peminjaman->tanggal_pengembalian,
        ];
    }
}
