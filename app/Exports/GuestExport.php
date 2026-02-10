<?php

namespace App\Exports;

use App\Models\GuestBook;
use Maatwebsite\Excel\Concerns\FromQuery; // Ganti FromCollection jadi FromQuery biar lebih ringan
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable; // Tambahan
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class GuestExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    // 1. Terima Data Tanggal dari Form Filament
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // 2. Query Data Berdasarkan Tanggal
    public function query()
    {
        return GuestBook::query()
            // Filter berdasarkan tanggal kunjungan (visit_date)
            // Kalau mau berdasarkan waktu input, ganti 'visit_date' jadi 'created_at'
            ->whereDate('visit_date', '>=', $this->startDate)
            ->whereDate('visit_date', '<=', $this->endDate)
            ->orderBy('visit_date', 'desc');
    }

    public function headings(): array
    {
        return [
            'NO',
            'NAMA TAMU',
            'INSTANSI',
            'TUJUAN',
            'NO. HP',
            'TANGGAL',
            'TANDA TANGAN',
            'BUKTI FOTO',
        ];
    }

    public function map($guest): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $guest->name,
            $guest->institution,
            $guest->purpose,
            $guest->phone,
            Carbon::parse($guest->visit_date)->locale('id')->isoFormat('D MMMM Y'),
            $guest->signature ? 'Ada' : '-',
            $guest->photo ? asset('storage/' . $guest->photo) : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFF00'],
                ],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}