<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Admin\Widgets\StatsOverview;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Laporan Peminjaman';

    public function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class, // Gunakan widget yang sudah dibuat
        ];
    }
}
