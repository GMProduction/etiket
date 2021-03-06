<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

    public function pesanan()
    {
        $pesanan = Pesanan::where('kode_tiket', '!=', null);
        if (\request('start')) {
            $start = date('Y-m-d', strtotime(\request('start')));
            $end   = date('Y-m-d', strtotime(\request('end')));
            $pesanan->whereBetween('tanggal', [$start, $end]);
        }
        $pesanan = $pesanan->get();

        return $pesanan;
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

    public function cetakLaporanPemasukan()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->dataPemasukan())->setPaper('f4', 'potrait');

        return $pdf->stream();
    }

    public function dataPemasukan()
    {

        $data = [
            'data'  => "data",
            'start' => "2012-01-01",
            'end'   => "2012-01-01",
        ];

        return view('admin/cetakpemasukan')->with($data);
    }

}
