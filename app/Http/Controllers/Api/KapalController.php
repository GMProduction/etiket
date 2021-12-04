<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\MasterKapal;
use App\Models\Pelabuhan;
use Illuminate\Http\Request;

class KapalController extends Controller
{
    //
    public function index(){
        $tanggal = \request('tanggal');
        $asal = \request('asal');
        $tujuan = \request('tujuan');
        $hari = date('w', strtotime($tanggal));


        if ($tanggal || $tujuan || $asal){
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
        }else{
            $jadwal = Jadwal::with(['kapal','asal','tujuan'])->get();
        }

        return $jadwal;
    }

    public function show($id){
        return Jadwal::with(['kapal','asal','tujuan'])->find($id);
    }

    public function pelabuhan(){
        $data = Pelabuhan::where('id','!=', \request('id'))->get();
        return $data;
    }

//    public function cariTanggal(){
//        $hari = date('w', strtotime(\request('tanggal')));
//        $asal = \request('asal');
//        $tujuan = \request('tujuan');
//        $jadwal = Jadwal::with(['kapal','asal','tujuan']);
//        if (\request('tanggal')){
//            $jadwal->where('hari','=',$hari);
//        }
//        if (\request('asal')){
//            $jadwal->where('id_asal','=', $asal);
//        }
//        if (\request('tujuan')){
//            $jadwal->where('id_tujuan','=', $tujuan);
//        }
//        $jadwal = $jadwal->get();
//        return $jadwal;
//    }
}
