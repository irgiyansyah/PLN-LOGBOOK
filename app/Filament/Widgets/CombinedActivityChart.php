<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\SecurityReport;
use App\Models\VehicleChecklist;
use App\Models\GuestBook;
use App\Models\PackageReport;

class CombinedActivityChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Aktivitas Mingguan';
    protected static ?int $sort = 2; // Biar posisinya di bawah kartu statistik

    protected function getData(): array
    {
        // Fungsi helper untuk mengambil data 7 hari terakhir
        $getTrend = fn ($model) => Trend::model($model)
            ->between(start: now()->subDays(7), end: now())
            ->perDay()
            ->count();

        $dataSatpam = $getTrend(SecurityReport::class);
        $dataKendaraan = $getTrend(VehicleChecklist::class);
        $dataTamu = $getTrend(GuestBook::class);
        $dataPaket = $getTrend(PackageReport::class);

        return [
            'datasets' => [
                [
                    'label' => 'Laporan Satpam',
                    'data' => $dataSatpam->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#3b82f6', // Biru
                ],
                [
                    'label' => 'Kendaraan',
                    'data' => $dataKendaraan->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#f59e0b', // Kuning/Oranye
                ],
                [
                    'label' => 'Tamu',
                    'data' => $dataTamu->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#10b981', // Hijau
                ],
                [
                    'label' => 'Paket',
                    'data' => $dataPaket->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#ef4444', // Merah
                ],
            ],
            'labels' => $dataSatpam->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Grafik Garis
    }
}