<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PeminjamanUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PeminjamanReminderNotification;

class PeminjamanReminder extends Command
{
    protected $signature = 'peminjaman:reminder';
    protected $description = 'Kirim notifikasi peminjaman jika H-1 atau Hari H pengembalian barang';

    public function handle()
    {
        $today = Carbon::today();
        $yesterday = $today->subDay(); // H-1 (Sehari sebelum hari ini)

        // Ambil peminjaman untuk H-1 (Sehari sebelum pengembalian)
        $peminjamanHMin1 = PeminjamanUser::whereDate('tanggal_pengembalian', $yesterday)
            ->where('status_peminjaman', 'pending')
            ->with('user')
            ->get();

        // Ambil peminjaman untuk Hari H (Tanggal pengembalian)
        $peminjamanHariH = PeminjamanUser::whereDate('tanggal_pengembalian', $today)
            ->where('status_peminjaman', 'pending')
            ->with('user')
            ->get();

        // Kirim notifikasi H-1
        foreach ($peminjamanHMin1 as $pinjam) {
            Notification::send($pinjam->user, new PeminjamanReminderNotification($pinjam, 'H-1'));
        }

        // Kirim notifikasi Hari H
        foreach ($peminjamanHariH as $pinjam) {
            Notification::send($pinjam->user, new PeminjamanReminderNotification($pinjam, 'Hari H'));
        }

        $this->info('Notifikasi berhasil dikirim untuk H-1 dan Hari H.');
    }
}
