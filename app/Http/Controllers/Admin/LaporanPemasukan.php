<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class LaporanPemasukan extends Controller
{
    //
    public function data(){
        $data = Pembayaran::with('user')->where('status','=',1);
        if (\request('start')) {
            $start = date('Y-m-d', strtotime(\request('start')));
            $end   = date('Y-m-d', strtotime(\request('end')));
            $data->whereBetween('updated_at', [$start, $end]);
        }
        $data = $data->paginate(10);

        return $data;
    }

    public function index(){
        return view('admin.laporanpemasukan')->with(['data' => $this->data()]);
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
            'data'  => $this->data(),
            'start' => \request('start'),
            'end'   => \request('end'),
            'total' => $this->data()->sum('total_harga')
        ];

        return view('admin/cetakpemasukan')->with($data);
    }
}
