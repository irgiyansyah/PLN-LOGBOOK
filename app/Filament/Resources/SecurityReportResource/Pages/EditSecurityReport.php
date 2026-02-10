<?php

namespace App\Filament\Resources\SecurityReportResource\Pages;

use App\Filament\Resources\SecurityReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSecurityReport extends EditRecord
{
    protected static string $resource = SecurityReportResource::class;

    // 1. Judul Halaman
    public function getTitle(): string
    {
        return 'Laporan Mutasi Satpam';
    }

    // 2. Tombol Hapus (Pojok Kanan Atas)
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // 3. Tombol Simpan (Bawah) - Ganti Nama Jadi Indonesia
    protected function getSaveFormAction(): Actions\Action
    {
        return parent::getSaveFormAction()
            ->label('Simpan Perubahan');
    }
}