<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'kode_invoice',
        'pelanggan',
        'alamat',
        'telepon',
        'keterangan',
        'tempo',
        'pengerjaan',
        'teknisi',
        'dibayar',
        'total_bayar',
        'pelunasan',
    ];
}
