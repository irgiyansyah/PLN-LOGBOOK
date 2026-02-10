<?php

namespace App\Filament\Resources\VehicleChecklistResource\Pages;

use App\Filament\Resources\VehicleChecklistResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVehicleChecklist extends EditRecord
{
    protected static string $resource = VehicleChecklistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
