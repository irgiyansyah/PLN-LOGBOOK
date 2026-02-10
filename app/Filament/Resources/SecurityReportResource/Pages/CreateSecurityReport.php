<?php

namespace App\Filament\Resources\SecurityReportResource\Pages;

use App\Filament\Resources\SecurityReportResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions; // <--- WAJIB ADA INI SUPAYA TIDAK ERROR

class CreateSecurityReport extends CreateRecord
{
    protected static string $resource = SecurityReportResource::class;

    // Judul Halaman
    public function getTitle(): string
    {
        return 'Tambah Laporan Satpam';
    }

    // Tombol "Create" jadi "Simpan"
    protected function getCreateFormAction(): Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan');
    }

    // Tombol "Create & Create Another" jadi "Simpan & Buat Lagi"
    protected function getCreateAnotherFormAction(): Actions\Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('Simpan & Buat Lagi');
    }
}