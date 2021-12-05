<?php

namespace App\Http\Controllers\Admin;

use App\Helper\CustomController;
use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class TransaksiController extends CustomController
{
    //
    public function index()
    {
        $data = Pembayaran::with(['user', 'pesanan.jadwal.kapal'])->paginate(10);

        return view('admin.transaksi')->with(['data' => $data]);
    }

    public function show($id)
    {
        $data = Pembayaran::with(['user', 'pesanan.jadwal.kapal'])->find($id);
        if (\request()->isMethod('POST')) {
            return $this->konfirmasi($data);
        }

        return $data;
    }

    public function konfirmasi($pembayaran)
    {
        $status = \request('status');
        $pembayaran->update(['status' => $status]);
        if ($status == 2) {
            if ($pembayaran->bukti_transfer) {
                $this->unlinkFile($pembayaran, 'bukti_transfer');
            }
            $pembayaran->update(['bukti_transfer' => null]);
        } else {
            foreach ($pembayaran->pesanan as $p) {
                $namaKapal = $p->jadwal->kapal->nama;
                $namaKapal = str_replace(' ','', $namaKapal);
                $kodeTiket = substr($namaKapal, 0, 3).$p->id;
                $p->update(['kode_tiket' => $kodeTiket]);
            }
        }

        return 'berhasil';
    }
}
