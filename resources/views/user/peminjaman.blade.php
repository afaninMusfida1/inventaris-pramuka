@extends('layouts.app')

@section('title', 'Peminjaman Saya')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <div class="p-4 bg-white shadow rounded-lg mb-6">
        <h2 class="text-xl font-semibold mb-3 text-gray-800">Notifikasi</h2>
        @if (!empty($notifikasiPeminjaman) && $notifikasiPeminjaman->isNotEmpty())
    <div class="p-4 mb-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
        <h4 class="font-semibold">Pemberitahuan Pengembalian Barang</h4>
        <ul class="list-disc list-inside">
            @foreach ($notifikasiPeminjaman as $pinjam)
                <li>
                    Barang <strong>{{ $pinjam->barang->nama_barang }}</strong> harus dikembalikan pada 
                    <strong>{{ \Carbon\Carbon::parse($pinjam->tanggal_pengembalian)->format('d M Y') }}</strong>.
                </li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Peminjaman</h1>
        <a href="{{ route('barang.tersedia') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            + Ajukan Peminjaman
        </a>
    </div>

    @if (session('success'))
        <div class="mt-4 p-3 bg-green-50 border border-green-400 text-green-700 rounded-md shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto mt-6 bg-white shadow-lg rounded-lg">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="px-4 py-3 text-left border-b">Barang</th>
                    <th class="px-4 py-3 text-left border-b">Jumlah</th>
                    <th class="px-4 py-3 text-left border-b">Tanggal Peminjaman</th>
                    <th class="px-4 py-3 text-left border-b">Tanggal Pengembalian</th>
                    <th class="px-4 py-3 text-left border-b">Status</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($peminjamanUser) && $peminjamanUser->isNotEmpty())
                    @foreach ($peminjamanUser as $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-4 border-b">{{ optional($p->barang)->nama_barang ?? 'Barang tidak ditemukan' }}</td>
                            <td class="px-4 py-4 border-b">{{ $p->jumlah }}</td>
                            <td class="px-4 py-4 border-b">{{ $p->tanggal_peminjaman }}</td>
                            <td class="px-4 py-4 border-b">{{ $p->tanggal_pengembalian }}</td>
                            <td class="px-4 py-3 border-b">
                                <span class="px-3 py-1 rounded-full text-sm font-medium 
                                    {{ $p->status_peminjaman == 'disetujui' ? 'bg-green-200 text-green-800' : ($p->status_peminjaman == 'pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">
                                    {{ ucfirst($p->status_peminjaman) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada peminjaman.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
