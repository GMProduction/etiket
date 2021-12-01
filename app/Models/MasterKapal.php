<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKapal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'keterangan',
        'kapasitas',
        'image'
    ];

    public function jadwal(){
        return $this->hasMany(Jadwal::class, 'id_kapal');
    }
}
