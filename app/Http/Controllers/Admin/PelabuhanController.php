<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelabuhan;
use Illuminate\Http\Request;

class PelabuhanController extends Controller
{
    //
    public function index(){
        if (\request()->isMethod('POST')){
            $this->store();
        }
        $pelabuhan = Pelabuhan::paginate(10);
        return view('admin.pelabuhan')->with(['data' => $pelabuhan]);
    }

    public function store(){
        if (\request('id')){
            $pelabuhan = Pelabuhan::find(\request('id'));
            $pelabuhan->update(\request()->all());
        }else{
            Pelabuhan::create(\request()->all());
        }
        return 'berhasil';
    }
}
