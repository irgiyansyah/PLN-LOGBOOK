<?php

namespace App\Filament\Resources\SecurityReportResource\Pages;

use App\Filament\Resources\SecurityReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSecurityReports extends ListRecords
{
    protected static string $resource = SecurityReportResource::class;

    // 1. GANTI JUDUL HALAMAN (Security Reports -> Laporan Satpam)
    public function getTitle(): string
    {
        return 'Laporan Satpam';
    }

   protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Laporan Satpam') // <--- Ganti jadi ini
                ->icon('heroicon-o-plus'),
        ];
    }
}