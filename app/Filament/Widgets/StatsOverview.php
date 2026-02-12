<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters; // Import Penting

// Import Semua Model
use App\Models\SecurityReport;
use App\Models\VehicleChecklist;
use App\Models\GuestBook;
use App\Models\PackageReport;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters; // Agar widget ini membaca filter dashboard

    protected function getStats(): array
    {
        // 1. Ambil Data dari Filter Dashboard
        $tipe = $this->filters['tipe_laporan'] ?? 'all';
        $start = $this->filters['startDate'] ?? now()->subDays(7);
        $end = $this->filters['endDate'] ?? now();

        // --- KONDISI 1: PILIH "SATPAM" ---
        if ($tipe === 'satpam') {
            return [
                Stat::make('Total Laporan Satpam', SecurityReport::whereBetween('created_at', [$start, $end])->count())
                    ->description('Laporan Masuk')
                    ->descriptionIcon('heroicon-m-shield-check')
                    ->color('primary'),
                
                Stat::make('Insiden / Rawan', SecurityReport::whereBetween('created_at', [$start, $end])->where('area_status', '!=', 'Aman')->count())
                    ->description('Perlu Perhatian')
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color('danger'),
            ];
        }

        // --- KONDISI 2: PILIH "KENDARAAN" ---
        if ($tipe === 'kendaraan') {
            return [
                // Menggunakan created_at sesuai resource sebelumnya
                Stat::make('Total Kendaraan', VehicleChecklist::whereBetween('created_at', [$start, $end])->count())
                    ->description('Keluar Masuk')
                    ->descriptionIcon('heroicon-m-truck')
                    ->color('info'),
                
                Stat::make('Parkir Menginap/Aktif', VehicleChecklist::whereNull('time_out')->count())
                    ->description('Belum Keluar')
                    ->descriptionIcon('heroicon-m-clock')
                    ->color('warning'),
            ];
        }

        // --- KONDISI 3: PILIH "TAMU" ---
        if ($tipe === 'tamu') {
            return [
                // Menggunakan visit_date sesuai resource sebelumnya
                Stat::make('Total Tamu', GuestBook::whereBetween('visit_date', [$start, $end])->count())
                    ->description('Tamu Berkunjung')
                    ->descriptionIcon('heroicon-m-user-group')
                    ->color('success'),
            ];
        }

        // --- KONDISI 4: PILIH "PAKET" ---
        if ($tipe === 'paket') {
            return [
                // Menggunakan received_date sesuai resource sebelumnya
                Stat::make('Total Paket', PackageReport::whereBetween('received_date', [$start, $end])->count())
                    ->description('Paket Diterima')
                    ->descriptionIcon('heroicon-m-cube')
                    ->color('warning'),
            ];
        }

        // --- DEFAULT: PILIH "SEMUA" (Tampilkan Ringkasan 3 Utama) ---
        return [
            Stat::make('Total Tamu', GuestBook::whereBetween('visit_date', [$start, $end])->count())
                ->description('Periode Ini')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Total Paket', PackageReport::whereBetween('received_date', [$start, $end])->count())
                ->description('Periode Ini')
                ->descriptionIcon('heroicon-m-cube')
                ->color('warning'),

            Stat::make('Total Kendaraan', VehicleChecklist::whereBetween('created_at', [$start, $end])->count())
                ->description('Periode Ini')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),
        ];
    }
}