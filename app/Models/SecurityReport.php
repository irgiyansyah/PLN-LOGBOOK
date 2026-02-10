<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SecurityReport extends Model
{
    use HasFactory;

    // Supaya semua kolom bisa diisi
    protected $guarded = [];

    // Relasi: 1 Laporan punya BANYAK Personil
    public function personnels(): HasMany
    {
        return $this->hasMany(SecurityPersonnel::class);
    }

    // Relasi: 1 Laporan punya BANYAK Barang Inventaris
    public function inventories(): HasMany
    {
        return $this->hasMany(SecurityInventory::class);
    }

    // Relasi: 1 Laporan punya BANYAK Kegiatan (Log)
    public function activities(): HasMany
    {
        return $this->hasMany(SecurityActivity::class);
    }
}