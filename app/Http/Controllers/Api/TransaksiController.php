<?php

namespace App\Http\Controllers\Api;

use App\Helper\CustomController;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class TransaksiController extends CustomController
{
    //
    public function index(){
        if (\request()->isMethod('POST')){
            return $this->store();
        }
        $pesanan = Pesanan::with('jadwal')->where([['id_user','=', Auth::id()],['status','=',0]])->get();
        return $pesanan;
    }

    public function store(){
        $field = \request()->validate([
            'nama' => 'required',
            'id_jadwal' => 'required',
            'tanggal' => 'required'
        ]);
        $fieldSave = [];
        foreach (\request('nama') as $key => $d){
            Arr::set($fieldSave[$key], 'nama', $d);
            Arr::set($fieldSave[$key], 'tanggal', $field['tanggal']);
            Arr::set($fieldSave[$key], 'id_jadwal', $field['id_jadwal']);
            Arr::set($fieldSave[$key], 'id_user', \auth()->id());
            $jadwal = Jadwal::find($field['id_jadwal']);
            Arr::set($fieldSave[$key],'harga', $jadwal->harga);
            Arr::set($fieldSave[$key],'created_at', new \DateTime());
            Arr::set($fieldSave[$key],'updated_at', new \DateTime());
        }
        Pesanan::insert($fieldSave);
        return response()->json('Berhasil', 200);

    }

    public function delete($id){
        $pesanan = Pesanan::where('id_user','=',\auth()->id())->find($id);
        if (!$pesanan){
            return response()->json('Pesanan tidak ditemukan', 202);
        }
        Pesanan::destroy($id);
        return response()->json('Berhasil', 200);
    }

    public function checkout(){
        $pesanan = Pesanan::where([['id_user','=', Auth::id()],['status','=',0]])->get();
        $totalHarga = $pesanan->sum('harga');
        $pembayaran = Pembayaran::create([
            'total_harga' => $totalHarga,
            'id_user' => \auth()->id(),
        ]);
        foreach ($pesanan as $key => $d){
            $d->update([
                'id_pembayaran' => $pembayaran->id,
                'status' => 1
                ]);
        }
        return response()->json('Berhasil', 200);
    }

    public function pembayaran(){
        $data = Pembayaran::with('pesanan')->where('id_user','=', \auth()->id())->get();
        return $data;
    }

    public function pembayaranDetail($id){

        $data = Pembayaran::with('pesanan')->where([['id_user','=', \auth()->id()],['id','=',$id]])->first();
        if (\request()->isMethod('POST')){
            return $this->storeImgPayment($data);
        }
        return $data;
    }

    public function storeImgPayment($data){
        \request()->validate([
            'image' => 'required|image'
        ]);

        if ($data->bukti_transfer) {
            $this->unlinkFile($data, 'bukti_transfer');
        }
        $textImg = $this->generateImageName('image');
        $string  = '/images/payment/'.$textImg;
        $this->uploadImage('image', $textImg, 'imgPayment');
        $data->update([
            'bukti_transfer' => $string,
            'status' => 0
        ]);

        return $data;
    }

}
