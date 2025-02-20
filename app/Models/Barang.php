<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id'; // Pastikan ID benar
    public $timestamps = false; // Jika tabel tidak punya created_at & updated_at

    protected $fillable = [
        'nama_barang',
        'jumlah_stok',
        'kategori_id',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function peminjamanUsers()
    {
        return $this->hasMany(PeminjamanUser::class, 'barang_id'); // Relasi ke model PeminjamanUser
    }
    
}
