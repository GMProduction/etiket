<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class ChekinController extends Controller
{
    //
    public function scanQr(){
        $id = \request('qrid');
        $pesanan = Pesanan::where('kode_tiket', '=', $id)->get();
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

        $pesanan->update(['status' => 2]);
        return response()->json([
            'msg' => 'Berhasil Chekin'
        ]);
    }
}
