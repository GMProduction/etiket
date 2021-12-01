<?php

namespace App\Http\Controllers\Admin;

use App\Helper\CustomController;
use App\Http\Controllers\Controller;
use App\Models\MasterKapal;
use App\Models\Pelabuhan;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class KapalController extends CustomController
{
    //
    public function index()
    {
        if (\request()->isMethod('POST')) {
            return $this->store();
        }
        $data = MasterKapal::paginate(10);

        return view('admin.kapal')->with(['data' => $data]);
    }

    public function store()
    {
        $field = \request()->all();
        if (\request('id')) {
            $kapal = MasterKapal::find(\request('id'));
            if (\request()->hasFile('image')) {
                if ($kapal->image) {
                    $this->unlinkFile($kapal, 'image');
                }
                $textImg = $this->generateImageName('image');
                $string  = '/images/kapal/'.$textImg;
                $this->uploadImage('image', $textImg, 'kapal');
                Arr::set($field, 'image', $string);
            }
            $kapal->update($field);
        } else {
            \request()->validate(['image' => 'required']);
            $textImg = $this->generateImageName('image');
            $string  = '/images/kapal/'.$textImg;
            $this->uploadImage('image', $textImg, 'kapal');
            Arr::set($field, 'image', $string);

            MasterKapal::create($field);
        }
        return 'berhasil';
    }

    public function getPelabuhanAsal(){
        return Pelabuhan::all();
    }

    public function getPelabuhanTujuan(){
        $data = Pelabuhan::where('id','!=', \request('id'))->get();
        return $data;
    }
}
