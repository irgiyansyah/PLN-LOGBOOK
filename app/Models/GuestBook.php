<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestBook extends Model
{
    use HasFactory;

    // INI YANG KETINGGALAN TADI
    // Kita harus mengizinkan kolom-kolom ini untuk diisi dari Form
    protected $fillable = [
        'name',
        'institution',
        'purpose',
        'phone',
        'visit_date',
        'signature',
        'photo',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];
}