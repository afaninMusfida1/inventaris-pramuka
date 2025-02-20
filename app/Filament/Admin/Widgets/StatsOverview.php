<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Peminjaman; // Sesuaikan dengan modelmu

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Peminjaman', Peminjaman::count()) // Ganti dengan query real
                ->description('Total semua peminjaman.')
                ->color('success'),
        ];
    }
}
