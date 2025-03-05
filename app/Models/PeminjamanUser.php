<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanUser extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_users';

    protected $fillable = [
        'user_id',
        'barang_id',
        'jumlah',
        'peminjaman_id',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'status_peminjaman',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Sesuaikan dengan nama kolom foreign key di tabel peminjaman
    }
    

    public function peminjaman()
{
    return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
}

}
