<?php

namespace App\Filament\Resources\VehicleChecklistResource\Pages;

use App\Filament\Resources\VehicleChecklistResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVehicleChecklists extends ListRecords
{
    protected static string $resource = VehicleChecklistResource::class;

    // Fungsi ini untuk mengubah tombol di pojok kanan atas
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data Kendaraan'), // <-- Ganti teks tombol disini
        ];
    }
}