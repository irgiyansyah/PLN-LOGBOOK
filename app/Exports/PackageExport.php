<?php

namespace App\Exports;

use App\Models\PackageReport;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class PackageExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
        return PackageReport::query()
            ->whereDate('received_date', '>=', $this->startDate)
            ->whereDate('received_date', '<=', $this->endDate)
            ->orderBy('received_date', 'desc');
    }

    public function headings(): array
    {
        return ['NO.', 'BARANG', 'KONDISI', 'PENERIMA', 'TANGGAL'];
    }

    public function map($package): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $package->item_name,
            $package->condition,
            $package->receiver_name, // <--- GANTI JADI receiver_name
            Carbon::parse($package->received_date)->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFC000'],
                ],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}