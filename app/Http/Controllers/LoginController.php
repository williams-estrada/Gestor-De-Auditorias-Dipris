<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('Login');
    }
    public function store(Request $request){  
        $correo = request()->input('correo_electronico');
        $encontrado = Usuarios::where('correo_electronico', '=', $correo)->first();
        if(is_null($encontrado)){
            return back()->with('status', 'Email o contraseña incorrecto');
            //return view('Errorpassword');
        }else{
            $contraseña = request()->input('contraseña');
            $contraseña_encontrada =$encontrado->contraseña;
            if(Hash::check($contraseña,$contraseña_encontrada)){
                Auth::login($encontrado);
                return redirect()->to('/home');
            }else{
                return back()->with('status', 'Email o contraseña incorrecto');
                //return view('Errorpassword');
            }
        }
    }
    public function destroy(){
        auth()->logout();
        return redirect()->to('/');
    }
}
