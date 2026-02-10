<?php

namespace App\Exports;

use App\Models\VehicleChecklist; // <--- GANTI JADI INI JUGA
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class VehicleExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        // GANTI QUERYNYA PAKAI VehicleChecklist
        return VehicleChecklist::query()
            ->whereDate('created_at', '>=', $this->startDate)
            ->whereDate('created_at', '<=', $this->endDate)
            ->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'NO',
            'TANGGAL',
            'NAMA DRIVER',
            'JENIS KENDARAAN (MOBIL/MOTOR)',
            'NOMOR POLISI',
            'JAM MASUK',
            'JAM KELUAR',
            'KETERANGAN',
        ];
    }

    public function map($vehicle): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            Carbon::parse($vehicle->created_at)->format('d/m/Y'),
            $vehicle->driver_name,
            $vehicle->vehicle_type,
            $vehicle->license_plate,
            Carbon::parse($vehicle->time_in)->format('H:i'),
            $vehicle->time_out ? Carbon::parse($vehicle->time_out)->format('H:i') : '-',
            $vehicle->notes,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'EAB308'],
                ],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}