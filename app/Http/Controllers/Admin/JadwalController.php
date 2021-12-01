<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\MasterKapal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    //
    public function show($id)
    {
        $data = Jadwal::with(['asal','tujuan'])->where('id_kapal', '=', $id)->get();
        return $data;
    }

    public function store($id){
       if (\request('id')){
            $jadwal = Jadwal::find(\request('id'));
            $jadwal->update(\request()->all());
       }else{
           $kapal = MasterKapal::find($id);
           $kapal->jadwal()->create(\request()->all());
       }
        return 'berhasil';
    }

    public function delete($id){
        Jadwal::destroy($id);
        return 'berhasil';
    }
}
