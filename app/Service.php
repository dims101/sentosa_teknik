<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'layanan',
        'promo',
        'harga',
        'keterangan'
    ];
}
