<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanUser;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use Carbon\Carbon;

class PeminjamanUserController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $today = Carbon::today();
    $tomorrow = Carbon::tomorrow();

    // Ambil semua peminjaman user yang login
    $peminjamanUser = PeminjamanUser::where('user_id', $user->id)
        ->with('barang') 
        ->get();

    // Ambil notifikasi peminjaman (Hari ini dan besok)
    $notifikasiPeminjaman = PeminjamanUser::where('user_id', $user->id)
        ->whereBetween('tanggal_pengembalian', [$today, $tomorrow]) // Hanya untuk hari ini dan besok
        ->where('status_peminjaman', 'pending')
        ->with('barang')
        ->get();

    return view('user.peminjaman', compact('peminjamanUser', 'notifikasiPeminjaman'));
}



public function create(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Jika user memilih barang dari daftar barang tersedia
    $barangTerpilih = null;
    if ($request->has('barang_id')) {
        $barangTerpilih = Barang::find($request->barang_id);
    }

    // Ambil semua barang yang tersedia
    $barang = Barang::where('jumlah_stok', '>', 0)->get();

    return view('user.form_peminjaman', compact('barang', 'barangTerpilih'));
}



public function store(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $request->validate([
        'barang_id' => 'required|exists:barang,id',
        'tanggal_peminjaman' => 'required|date|after_or_equal:today',
        'tanggal_pengembalian' => 'required|date|after:tanggal_peminjaman',
        'jumlah' => 'required|integer|min:1',
    ]);

    $barang = Barang::find($request->barang_id);

    if (!$barang) {
        return back()->withErrors(['error' => 'Barang tidak ditemukan.']);
    }

    if ($barang->jumlah_stok < $request->jumlah) {
        return back()->withErrors(['error' => 'Stok barang tidak mencukupi.']);
    }

    try {
        // Buat data peminjaman utama
        $peminjaman = Peminjaman::create([
            'nama_peminjam' => Auth::user()->name,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian, // Simpan tanggal pengembalian
            'status_peminjaman' => 'pending',
            'barang_id' => $request->barang_id,
        ]);

        // Simpan ke tabel peminjaman_users
        PeminjamanUser::create([
            'user_id' => Auth::id(),
            'barang_id' => $request->barang_id,
            'peminjaman_id' => $peminjaman->id,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian, // Simpan tanggal pengembalian
            'status_peminjaman' => 'pending',
            'jumlah' => $request->jumlah,
        ]);

        // Kurangi stok barang
        $barang->decrement('jumlah_stok', $request->jumlah);

    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
    }

    return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan.');
}


public function listBarang()
{
    $barang = Barang::where('jumlah_stok', '>', 0)
        ->with('kategori') // Pastikan relasi kategori dimuat
        ->get();

    return view('user.barang_tersedia', compact('barang'));
}

public function notifikasiPeminjaman()
{
    $user = Auth::user();
    $today = Carbon::today();
    $tomorrow = Carbon::tomorrow();

    // Ambil semua peminjaman user
    $peminjamanUser = PeminjamanUser::where('user_id', $user->id)
        ->with('barang') 
        ->get();

    // Ambil notifikasi peminjaman (Hari ini dan besok)
    $notifikasiPeminjaman = PeminjamanUser::where('user_id', $user->id)
        ->whereBetween('tanggal_pengembalian', [$today, $tomorrow])
        ->where('status_peminjaman', 'pending')
        ->with('barang')
        ->get();

    return view('user.peminjaman', compact('peminjamanUser', 'notifikasiPeminjaman'));
}
 
}
