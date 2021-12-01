<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\MasterKapal;
use Illuminate\Http\Request;

class KapalController extends Controller
{
    //
    public function index(){
        return MasterKapal::all();
    }

    public function show($id){
        return MasterKapal::with('jadwal')->find($id);
    }

    public function cariTanggal(){
        $hari = date('w', strtotime(\request('tanggal')));
        $asal = \request('asal');
        $tujuan = \request('tujuan');
        $jadwal = Jadwal::with(['kapal','asal','tujuan']);
        if (\request('tanggal')){
            $jadwal->where('hari','=',$hari);
        }
        if (\request('asal')){
            $jadwal->where('id_asal','=', $asal);
        }
        if (\request('tujuan')){
            $jadwal->where('id_tujuan','=', $tujuan);
        }
        $jadwal = $jadwal->get();
        return $jadwal;
    }
}
