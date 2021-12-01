<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'bukti_transfer',
        'total_harga',
        'id_user',
        'status'
    ];

    public function pesanan(){
        return $this->hasMany(Pesanan::class, 'id_pembayaran');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
