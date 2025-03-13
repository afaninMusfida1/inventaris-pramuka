<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Peminjaman;
use Carbon\Carbon;

class PeminjamanChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Peminjaman';

    protected function getType(): string
    {
        return 'line'; // Menggunakan Line Chart
    }

    protected function getData(): array
    {
        // Ambil data peminjaman aktual
        $actual = Peminjaman::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subDays(14)) // Data 14 hari terakhir
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Simulasi data forecast (prediksi) dengan menaikkan nilai 10%
        $forecast = $actual->map(fn ($data) => [
            'tanggal' => $data->tanggal,
            'total' => round($data->total * 1.1),
        ]);

        return [
            'datasets' => [
                [
                    'label' => 'Aktual',
                    'data' => $actual->pluck('total')->toArray(),
                    'borderColor' => 'blue',
                    'backgroundColor' => 'rgba(0, 0, 255, 0.2)',
                    'tension' => 0.4, // Garis lebih halus
                ],
                [
                    'label' => 'Forecast',
                    'data' => $forecast->pluck('total')->toArray(),
                    'borderColor' => 'red',
                    'backgroundColor' => 'rgba(255, 0, 0, 0.2)',
                    'borderDash' => [5, 5], // Garis putus-putus
                    'tension' => 0.4,
                ],
            ],
            'labels' => $actual->pluck('tanggal')->toArray(),
        ];
    }
}
