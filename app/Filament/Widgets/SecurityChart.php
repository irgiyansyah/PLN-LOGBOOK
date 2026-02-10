<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters; // Import Penting
use App\Models\SecurityReport;
use App\Models\VehicleChecklist;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class SecurityChart extends ChartWidget
{
    use InteractsWithPageFilters; // Wajib ada

    protected static ?string $heading = 'Grafik Aktivitas';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // 1. Ambil Filter
        $tipe = $this->filters['tipe_laporan'] ?? 'satpam';
        $start = $this->filters['startDate'] ?? now()->subDays(7);
        $end = $this->filters['endDate'] ?? now();

        // 2. Tentukan Data mana yang diambil
        if ($tipe === 'satpam') {
            // Query Data Satpam
            $data = Trend::model(SecurityReport::class)
                ->between(start: $start, end: $end)
                ->perDay()
                ->dateColumn('report_date')
                ->count();
            
            $label = 'Laporan Satpam';
            $color = '#3b82f6'; // Biru

        } else {
            // Query Data Kendaraan
            $data = Trend::model(VehicleChecklist::class)
                ->between(start: $start, end: $end)
                ->perDay()
                ->dateColumn('date')
                ->count();

            $label = 'Kendaraan Masuk';
            $color = '#10b981'; // Hijau
        }

        // 3. Tampilkan Data
        return [
            'datasets' => [
                [
                    'label' => $label,
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'fill' => true, 
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Grafik garis
    }
}