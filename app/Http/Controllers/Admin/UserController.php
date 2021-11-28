<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index()
    {
        $user = User::paginate(10);

        return view('admin.user')->with(['data' => $user]);
    }

    public function update()
    {
        $field = \request()->validate(
            [
                'username' => 'required',
                'nama'     => 'required',
                'password' => 'required|confirmed',
                'alamat'   => 'required',
                'no_hp'    => 'required',
                'roles'    => 'required',
            ]
        );

        $user1 = User::where('username', '=', $field['username'])->first();
        if ($user1) {
            return response()->json(
                [
                    'msg' => 'Username sudah digunakan',
                ],
                201
            );
        }
        Arr::set($field, 'password', Hash::make($field['password']));
        $user = User::create($field);
        if ($field['roles'] != 'admin') {
            $token = $user->createToken($field['roles'], [$field['roles']])->plainTextToken;
            $user->update(['token' => $token]);

            return response()->json(
                [
                    'status' => 200,
                    'data'   => [
                        'token' => $token,
                        'roles' => $user->roles,
                    ],
                ]
            );
        }

        return 'berhasil';
    }
}
