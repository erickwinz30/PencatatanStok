<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class ControllerLogin extends BaseController
{
    public function login()
    {
        Auth::logout();
        return view('login');
    }
    public function actionlogin(Request $x)
    {
        $data = [
            'email' => $x->input('email'),
            'password' => $x->input('password'),
            'role' => 'gudang'
        ];
        if (Auth::Attempt($data)) {
            return redirect('viewBarang');
        } else {
            return redirect('login')->with('error', 'Email atau password salah!!!');
        }
    }
    public function registrasi()
    {
        return view('registrasi');
    }
    public function postregistrasi(Request $x)
    {
        $data = $x->all();
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'telp' => $data['telp'],
            'role' => 'gudang',
            'password' => Hash::make($data['password'])
        ]);
        return redirect("login")
            ->withSuccess('Akun telah terbuat!!!');
    }
}
