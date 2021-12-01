<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'nama',
        'id_jadwal',
        'harga',
        'kode_tiket',
        'status',
        'id_pembayaran',
        'tanggal'
    ];

    public function jadwal(){
        return $this->belongsTo(Jadwal::class, 'id_jadwal');
    }

    public function pembayaran(){

    }
}
