<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kapal',
        'hari',
        'jam',
        'id_asal',
        'id_tujuan',
        'harga',
    ];

    protected $with = ['asal','tujuan'];

    public function kapal(){
        return $this->belongsTo(MasterKapal::class, 'id_kapal');
    }

    public function asal(){
        return $this->belongsTo(Pelabuhan::class, 'id_asal');
    }

    public function tujuan(){
        return $this->belongsTo(Pelabuhan::class, 'id_tujuan');
    }
}
