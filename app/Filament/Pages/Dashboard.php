<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm; // Import Penting
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use App\Filament\Widgets\StatsOverview; // Import Widget Statistik

class Dashboard extends BaseDashboard
{
    use HasFiltersForm; // Agar filter muncul di atas

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Filter Dashboard')
                    ->description('Filter data berdasarkan kategori dan tanggal')
                    ->schema([
                        // 1. Filter Kategori Laporan
                        Select::make('tipe_laporan')
                            ->label('Fokus Laporan:')
                            ->options([
                                'all' => 'Semua Laporan (Ringkasan)',
                                'satpam' => 'Laporan Satpam',
                                'tamu' => 'Buku Tamu',
                                'kendaraan' => 'Kendaraan',
                                'paket' => 'Paket',
                            ])
                            ->default('all')
                            ->native(false),
                            
                        // 2. Filter Tanggal Mulai
                        DatePicker::make('startDate')
                            ->label('Mulai Tanggal')
                            ->default(now()->subDays(7)), // Default 1 minggu terakhir
                        
                        // 3. Filter Tanggal Selesai
                        DatePicker::make('endDate')
                            ->label('Sampai Tanggal')
                            ->default(now()),
                    ])
                    ->columns(3), // Tampil 3 kolom sejajar
            ]);
    }

    public function getWidgets(): array
    {
        return [
            StatsOverview::class, // Memanggil widget yang benar
            // CombinedActivityChart::class, // Uncomment jika file grafik sudah ada
        ];
    }
}