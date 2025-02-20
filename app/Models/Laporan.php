<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan'; // Nama tabel di database
    protected $fillable = [
        'peminjaman_id',
        'barang_id',
        'status',
    ];

    /**
     * Relasi ke tabel peminjaman
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    /**
     * Relasi ke tabel barang
     */
    public function barang()
{
    return $this->belongsTo(Barang::class, 'barang_id');
}

}
