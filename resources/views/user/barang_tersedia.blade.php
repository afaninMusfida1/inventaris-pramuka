@extends('layouts.app')

@section('title', 'Barang Tersedia')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Barang Tersedia</h1>

    <div class="overflow-x-auto mt-6 bg-white shadow-md rounded-lg">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left border-b">Nama Barang</th>
                    <th class="px-4 py-2 text-left border-b">Kategori</th>
                    <th class="px-4 py-2 text-left border-b">Jumlah Stok</th>
                    <th class="px-4 py-2 text-left border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($barang) && $barang->isNotEmpty())
                    @foreach ($barang as $item)
                        <tr class="hover:bg-gray-100 transition">
                            <td class="px-4 py-3 border-b">{{ $item->nama_barang }}</td>
                            <td class="px-4 py-3 border-b">{{ $item->kategori->nama_kategori ?? 'Lainnya' }}</td>
                            <td class="px-4 py-3 border-b">{{ $item->jumlah_stok }}</td>
                            <td class="px-4 py-3 border-b">
                                <a href="{{ route('peminjaman.create', ['barang_id' => $item->id]) }}" 
                                   class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-600 transition">
                                    Pinjam
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">Tidak ada barang tersedia</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
