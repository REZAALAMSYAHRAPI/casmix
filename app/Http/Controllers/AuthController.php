<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    function Login(){
        // Session::flush();
        return view('auth.login');
    }
    function mesinLogin(Request $request){
        $data = [
            'id_user' => $request->id_user,
            'password' => $request->password,
        ];
        $result = DB::table('user')
            ->select('id_user', 'password')
            ->whereRaw("aes_decrypt(user.id_user, 'nur') = ? AND aes_decrypt(user.password, 'windi') = ?", [$data['id_user'], $data['password']])
            ->first();
        if(!$result){
            Session::flash('errorLogin', 'Cek kembali akun anda');
            return redirect('/login');
        }else{
            $userLogin = DB::table('pegawai')
                ->select('pegawai.nama')
                ->where('pegawai.nik', '=', $request->id_user)
                ->first();
            session(['user' => $userLogin]);
            session(['auth' => $data]);
            return redirect()->intended('/')->with('sucsessLogin', 'Berhasil Login');
        }
    }
    function Logout(Request $request){
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('sucsessLogout', 'Berhasil Logout');
    }
}
