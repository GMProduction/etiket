<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function register()
    {
        $field = \request()->validate(
            [
                'username' => 'required',
                'name'     => 'required',
                'password' => 'required|confirmed',
                'alamat'   => 'required',
                'no_hp'    => 'required',
                'role'    => 'required',
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

        if (! \request('id')){
            Arr::set($field, 'password', Hash::make($field['password']));
            $user  = User::create($field);
            if ($field['role'] != 'admin'){
                $token = $user->createToken($field['role'],[$field['role']])->plainTextToken;
                $user->update(['token' => $token]);
                return response()->json(
                    [
                        'status' => 200,
                        'data'   => [
                            'token' => $token,
                            'role' => $user->role,
                        ],
                    ]
                );
            }
            return 'berhasil';
        }



        Arr::forget($field,'password');
        if (strpos(request('password'), '*') === false) {
            Arr::set($field, 'password', Hash::make(request('password')));
        }
        $user = User::find(\request('id'));
        $user->update($field);

        return 'berhasil';


    }

    public function login()
    {
        $field = \request()->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ]
        );

        $user = User::where('username', '=', $field['username'])->first();
        if ( ! $user || ! Hash::check($field['password'], $user->password) || ! $user->role) {
            return response()->json(
                [
                    'msg' => $user,
                ],
                401
            );
        }

        $user->tokens()->delete();
        $token = $user->createToken($user->role,[$user->role])->plainTextToken;
        $user->update(
            [
                'token' => $token,
            ]
        );

        return response()->json(
            [
                'status' => 200,
                'data'   => [
                    'token' => $token,
                    'roles' => $user->role,
                ],
            ]
        );
    }
}
