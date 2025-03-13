<?php
namespace App\Filament\Admin\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\BarChartWidget;
use App\Models\Peminjaman;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Barang Tersedia', Barang::where('status', 'tersedia')->count())
                ->description('Total barang yang bisa dipinjam')
                ->color('success'),

            Card::make('Barang Dipinjam', Barang::where('status', 'dipinjam')->count())
                ->description('Total barang yang sedang dipinjam')
                ->color('warning'),

            Card::make('Barang Rusak', Barang::where('status', 'rusak')->count())
                ->description('Total barang yang rusak')
                ->color('danger'),

            Card::make('Barang Hilang', Barang::where('status', 'hilang')->count())
                ->description('Total barang yang hilang')
                ->color('gray'),
        ];
    }

    protected function getFooter(): ?BarChartWidget
    {
        return new class extends BarChartWidget {
            protected static ?string $heading = 'Statistik Peminjaman';

            protected function getData(): array
            {
                $data = Peminjaman::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
                    ->where('created_at', '>=', Carbon::now()->subDays(7))
                    ->groupBy('tanggal')
                    ->orderBy('tanggal')
                    ->get();

                return [
                    'datasets' => [
                        [
                            'label' => 'Total Peminjaman',
                            'data' => $data->pluck('total')->toArray(),
                            'backgroundColor' => '#4F46E5',
                        ],
                    ],
                    'labels' => $data->pluck('tanggal')->toArray(),
                ];
            }
        };
    }
}
