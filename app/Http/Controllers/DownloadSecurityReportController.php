<?php

namespace App\Http\Controllers;

use App\Models\SecurityReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DownloadSecurityReportController extends Controller
{
    public function __invoke($id)
    {
        // PERBAIKAN: Gunakan nama relasi yang sesuai dengan Model / Resource
        // (personnels, inventories, activities)
        $record = SecurityReport::with(['personnels', 'inventories', 'activities'])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.security-report', ['record' => $record]);
        
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Satpam-' . $record->created_at->format('d-m-Y') . '.pdf');
    }
}