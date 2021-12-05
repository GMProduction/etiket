<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class LaporanTransaksi extends Controller
{
    //
    public function pesanan()
    {
        $pesanan = Pesanan::with('jadwal.kapal')->where('kode_tiket', '!=', null);
        if (\request('start')) {
            $start = date('Y-m-d', strtotime(\request('start')));
            $end   = date('Y-m-d', strtotime(\request('end')));
            $pesanan->whereBetween('tanggal', [$start, $end]);
        }
        $pesanan = $pesanan->paginate(10);

        return $pesanan;
    }

    public function index(){

        return view('admin.laporantransaksi')->with(['data' => $this->pesanan()]);
    }

    public function cetakLaporanTransaksi()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->dataTransaksi())->setPaper('f4', 'potrait');

        return $pdf->stream();
    }

    public function dataTransaksi()
    {

        $data = [
            'data'  => $this->pesanan(),
            'start' => \request('start'),
            'end'   => \request('end'),
        ];

        return view('admin/cetaktransaksi')->with($data);
    }


}
