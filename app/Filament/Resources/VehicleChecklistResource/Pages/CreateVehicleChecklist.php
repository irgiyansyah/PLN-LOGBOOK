<?php

namespace App\Filament\Resources\VehicleChecklistResource\Pages;

use App\Filament\Resources\VehicleChecklistResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVehicleChecklist extends CreateRecord
{
    protected static string $resource = VehicleChecklistResource::class;

    // 1. Ubah Tombol "Create" jadi "Simpan"
    protected function getCreateFormAction(): Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan');
    }

    // 2. Ubah Tombol "Create & create another" jadi "Simpan & Buat Lagi"
    protected function getCreateAnotherFormAction(): Actions\Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('Simpan & Buat Lagi');
    }

    // 3. Ubah Tombol "Cancel" jadi "Batal"
    protected function getCancelFormAction(): Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }

    // 4. Redirect (Opsional): Setelah simpan, balik ke tabel (bukan diam di form)
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}