<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFilters;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;

// Import Widget Baru Kita
use App\Filament\Widgets\DashboardStats;
use App\Filament\Widgets\CombinedActivityChart;

class Dashboard extends BaseDashboard
{
    use HasFilters;

    // 1. BAGIAN FILTER (Jangan dihapus)
    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Filter Dashboard')
                    ->schema([
                        // Filter Tipe Laporan (Opsional, kalau mau spesifik)
                        Select::make('tipe_laporan')
                            ->label('Fokus Laporan:')
                            ->options([
                                'all' => 'Semua Laporan',
                                'satpam' => 'Laporan Satpam',
                                'tamu' => 'Buku Tamu',
                                'kendaraan' => 'Kendaraan',
                                'paket' => 'Paket',
                            ])
                            ->default('all')
                            ->native(false),
                            
                        // Filter Tanggal
                        DatePicker::make('startDate')
                            ->label('Mulai Tanggal')
                            ->default(now()->subDays(7)), // Default 1 minggu terakhir
                        
                        DatePicker::make('endDate')
                            ->label('Sampai Tanggal')
                            ->default(now()),
                    ])
                    ->columns(3), // Tampil 3 kolom biar rapi
            ]);
    }

    // 2. BAGIAN WIDGET (Statistik & Grafik)
    public function getWidgets(): array
    {
        return [
            // Kartu Statistik (4 Kotak di Atas)
            DashboardStats::class,
            
            // Grafik Garis (Di Bawahnya)
            CombinedActivityChart::class,
        ];
    }
}