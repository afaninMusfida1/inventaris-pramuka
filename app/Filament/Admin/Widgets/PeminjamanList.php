<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use App\Models\Peminjaman;

class PeminjamanList extends Widget
{
    protected static string $view = 'filament.admin.widgets.peminjaman-list';

    protected function getData(): array
    {
        return [
            'peminjaman' => Peminjaman::where('status', 'dipinjam')
                ->with('user', 'barang')
                ->latest()
                ->take(10)
                ->get(),
        ];
    }
}
