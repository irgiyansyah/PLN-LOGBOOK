<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DownloadSecurityReportController;

// 1. Route Home (Halaman Depan)
Route::get('/', function () {
    return view('welcome');
}); // <--- DITUTUP DULU DISINI

// 2. Route Cetak PDF (Ditaruh diluarnya, bukan didalamnya)
Route::get('/security-reports/{id}/pdf', DownloadSecurityReportController::class)
    ->name('security_reports.pdf');