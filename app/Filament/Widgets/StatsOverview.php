<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters; // Import Penting
use App\Models\SecurityReport;
use App\Models\VehicleChecklist;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters; // Agar widget ini "mendengar" filter dashboard

    protected function getStats(): array
    {
        // 1. Ambil nilai filter dari Dashboard
        $tipe = $this->filters['tipe_laporan'] ?? 'satpam';
        $start = $this->filters['startDate'] ?? now()->subDays(7);
        $end = $this->filters['endDate'] ?? now();

        // 2. LOGIKA JIKA PILIH "SATPAM"
        if ($tipe === 'satpam') {
            return [
                Stat::make('Total Laporan Satpam', SecurityReport::whereBetween('report_date', [$start, $end])->count())
                    ->description('Data Shift Pagi/Sore/Malam')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->color('primary'),
                
                Stat::make('Insiden / Rawan', SecurityReport::whereBetween('report_date', [$start, $end])->where('area_status', '!=', 'Aman')->count())
                    ->description('Perlu Perhatian')
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color('danger'),
            ];
        }

        // 3. LOGIKA JIKA PILIH "KENDARAAN"
        return [
            Stat::make('Total Kendaraan Masuk', VehicleChecklist::whereBetween('date', [$start, $end])->count())
                ->description('Tamu & Pegawai')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),
            
            Stat::make('Sedang Parkir', VehicleChecklist::whereNull('time_out')->count())
                ->description('Belum Keluar')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}