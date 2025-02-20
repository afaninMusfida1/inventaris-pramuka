<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

        {{-- Bagian Peminjaman --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">Daftar Peminjaman</h2>

            <a href="{{ route('peminjaman.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-600 transition">
                Ajukan Peminjaman
            </a>

            @if (session('success'))
                <div class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto mt-6">
                <table class="w-full border-collapse bg-white shadow-md rounded-lg">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 text-left border-b">Barang</th>
                            <th class="px-4 py-2 text-left border-b">Jumlah</th>
                            <th class="px-4 py-2 text-left border-b">Tanggal Peminjaman</th>
                            <th class="px-4 py-2 text-left border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($peminjamanUser) && $peminjamanUser->isNotEmpty())
                            @foreach ($peminjamanUser as $p)
                                <tr class="hover:bg-gray-100 transition">
                                    <td class="px-4 py-3 border-b">{{ optional($p->barang)->nama_barang ?? 'Barang tidak ditemukan' }}</td>
                                    <td class="px-4 py-3 border-b">{{ $p->jumlah }}</td>
                                    <td class="px-4 py-3 border-b">{{ $p->tanggal_peminjaman }}</td>
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
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">Tidak ada peminjaman</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
