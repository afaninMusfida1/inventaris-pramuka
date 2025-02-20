@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-bold mb-4">Ajukan Peminjaman</h1>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label for="barang_id" class="block font-medium mb-1">Pilih Barang</label>
        <select name="barang_id" id="barang_id" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
            @foreach($barang as $item)
                <option value="{{ $item->id }}">{{ $item->nama_barang }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="jumlah">Jumlah Barang:</label>
        <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="1">
    </div>

    <div>
        <label for="tanggal_peminjaman" class="block font-medium mb-1">Tanggal Peminjaman</label>
        <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" 
            class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
    </div>

    <button type="submit" 
        class="w-full bg-blue-500 text-white py-2 rounded-md shadow-md hover:bg-blue-600 transition">
        Ajukan Peminjaman
    </button>
</form>
</div>
@endsection
