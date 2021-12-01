<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    //
    public function index(){
        $data = Pembayaran::with(['user','pesanan.jadwal.kapal'])->paginate(10);
        return view('admin.transaksi')->with(['data' => $data]);
    }

    public function show($id){
        $data = Pembayaran::with(['user','pesanan.jadwal.kapal'])->find($id);
        return $data;
    }
}
