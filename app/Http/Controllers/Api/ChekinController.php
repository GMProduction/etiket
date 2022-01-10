<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ChekinController extends Controller
{
    //
    public function scanQr(){
        $id = \request('qrid');
        $pesanan = Pesanan::where('kode_tiket', '=', $id)->firstOrFail();
        $now = date_create(date('Y-m-d', strtotime(now())));
        $tanggalBerangkat = date_create($pesanan->tanggal);
        $diff = date_diff($now, $tanggalBerangkat);
        $diffString = $diff->format("%R%a");
        if ($diffString === '+0'){
            if (!$pesanan){
                return response()->json([
                    'msg' => 'QR Code tidak ditemukan'
                ]);
            }
            if ($pesanan->status == 2){
                return response()->json([
                    'msg' => 'Kamu sudah checkin'
                ]);
            }
        }elseif ($diff->format("%R") === '+'){
            return response()->json([
                'msg' => 'Kamu baru bisa checkin besuk pada hari '.date('l, d F Y',strtotime($pesanan->tanggal)).' ( '.$diff->format("%a").' hari lagi )'
            ]);
        }else{
            return response()->json([
                'msg' => 'Kamu sudah tidak bisa checkin, tanggal checkin sudah terlewat'
            ]);
        }

        $pesanan->update(['status' => 2]);
        return response()->json([
            'msg' => 'Berhasil Checkin'
        ]);
    }

    public function dataPenumpang($id){
        $now = date('Y-m-d', strtotime(now()));
        $pesanan = Pesanan::where([['status','!=',0],['tanggal','=',$now],['id_jadwal','=',$id]])->get();
        foreach ($pesanan as $key => $d){
            $status = 'Sudah Checkin';
            if ($d->status == 1){
                $status = 'Menunggu Checkin';
            }
            $pesanan[$key] = Arr::set($pesanan[$key],'status_checkin',$status);
        }
        return $pesanan;

    }

    public function dataKapal(){
        $hari = date('w', strtotime(now()));
        $jadwal = Jadwal::with(['kapal','asal','tujuan'])->where('hari','=',$hari)->get();
        return $jadwal;
    }
}
