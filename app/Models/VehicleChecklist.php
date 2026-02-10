<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleChecklist extends Model
{
    use HasFactory;

    // --- TAMBAHKAN BARIS INI (KUNCI PERBAIKANNYA) ---
    // Artinya: Semua kolom boleh diisi (Mass Assignment Allowed)
    protected $guarded = []; 
    
    // ATAU kalau mau lebih spesifik (pilih salah satu cara), pakai $fillable:
    /*
    protected $fillable = [
        'date',
        'driver_name',
        'license_plate',
        'vehicle_type',
        'time_in',
        'time_out',
        'remarks',
    ];
    */
}