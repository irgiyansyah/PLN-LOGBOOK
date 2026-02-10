<?php

namespace App\Filament\Resources\PackageReportResource\Pages;

use App\Filament\Resources\PackageReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPackageReports extends ListRecords
{
    protected static string $resource = PackageReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
