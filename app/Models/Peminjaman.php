<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman'; 

    protected $fillable = [
        'nama_peminjam',
        'tanggal_peminjaman',
        'status_peminjaman',
        'barang_id', // Pastikan kolom ini ada di database
    ];

    protected $attributes = [
        'status_peminjaman' => 'pending',
    ];

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    // Relasi ke PeminjamanUser
    public function peminjamanUser()
    {
        return $this->hasMany(PeminjamanUser::class, 'peminjaman_id');
    }

    public function detailPeminjaman()
    {
        return $this->hasOne(PeminjamanUser::class, 'peminjaman_id');
    }
}
