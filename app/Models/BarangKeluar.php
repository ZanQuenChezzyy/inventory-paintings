<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'pengambil_id',
        'tipe_lokasi_id',
        'tanggal',
        'kuantitas',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    public function pengambil(): BelongsTo
    {
        return $this->belongsTo(Pengambil::class, 'pengambil_id', 'id');
    }

    public function tipeLokasi(): BelongsTo
    {
        return $this->belongsTo(Pengambil::class, 'tipe_lokasi_id', 'id');
    }

    public function pemakaianLapangan(): BelongsTo
    {
        return $this->belongsTo(Pengambil::class);
    }
}