<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'condition',
        'receiver_name', // <--- INI YANG BENAR (Sesuai file migrasi Mas)
        'received_date',
    ];
}