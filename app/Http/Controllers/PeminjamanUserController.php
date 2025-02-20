<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanUser;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;

class PeminjamanUserController extends Controller
{
    public function index()
{
    // Mengambil data peminjaman user yang sudah login dan mengaitkan barang
    $peminjamanUser = PeminjamanUser::where('user_id', Auth::id())->with('barang')->get();

    return view('user.peminjaman', compact('peminjamanUser'));
}


public function create()
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Ambil semua barang yang tersedia
    $barang = Barang::all(); // Ambil semua barang

    return view('user.form_peminjaman', compact('barang'));
}


public function store(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $request->validate([
        'barang_id' => 'required|exists:barang,id',
        'tanggal_peminjaman' => 'required|date|after_or_equal:today',
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
        // Buat data peminjaman dengan barang_id
        $peminjaman = Peminjaman::create([
            'nama_peminjam' => Auth::user()->name,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'status_peminjaman' => 'pending',
            'barang_id' => $request->barang_id, // Tambahkan barang_id ke tabel peminjaman
        ]);

        // Simpan ke peminjaman_users dengan peminjaman_id
        PeminjamanUser::create([
            'user_id' => Auth::id(),
            'barang_id' => $request->barang_id,
            'peminjaman_id' => $peminjaman->id, // Pastikan ID terisi!
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
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


    
}
