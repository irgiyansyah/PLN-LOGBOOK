<?php

namespace App\Filament\Resources\PackageReportResource\Pages;

use App\Filament\Resources\PackageReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackageReport extends EditRecord
{
    protected static string $resource = PackageReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
