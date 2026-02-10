<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\SecurityReport;
use App\Models\VehicleChecklist;
use App\Models\GuestBook;
use App\Models\PackageReport; // Jangan lupa import model baru

class DashboardStats extends BaseWidget
{
    // Atur waktu refresh data (opsional, biar realtime)
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        return [
            // 1. STATISTIK SATPAM
            Stat::make('Laporan Satpam', SecurityReport::count())
                ->description('Total laporan masuk')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Hiasan grafik kecil

            // 2. STATISTIK KENDARAAN
            Stat::make('Kendaraan', VehicleChecklist::whereDate('created_at', today())->count())
                ->description('Keluar/Masuk Hari Ini')
                ->descriptionIcon('heroicon-m-truck')
                ->color('warning'),

            // 3. STATISTIK TAMU
            Stat::make('Tamu', GuestBook::whereDate('created_at', today())->count())
                ->description('Kunjungan Hari Ini')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            // 4. STATISTIK PAKET (MODUL BARU)
            Stat::make('Paket Masuk', PackageReport::whereDate('created_at', today())->count())
                ->description('Diterima Hari Ini')
                ->descriptionIcon('heroicon-m-cube')
                ->color('danger'),
        ];
    }
}