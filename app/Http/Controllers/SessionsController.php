<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;


class SessionsController extends Controller
{
    //
    public function login()
    {
        return view("login");
    }

    public function login_post() {

        if(auth()->attempt(request(['email', 'password']))== false){
            return back()->withErrors([
                'message' => 'El usuario o la contraseña es incorrecto!'
            ]);
        }

        if(auth()->user()->rol == 'Admin'){
            return redirect()->route('crud.list');
        }elseif(auth()->user()->rol == 'Asociacion'){
            return redirect()->route('crud2.list');
        }elseif(auth()->user()->rol == 'Credito'){
            return redirect()->to('credito');
        }elseif(auth()->user()->rol == 'Consultante'){
            return redirect()->to('consultante');
        }elseif(auth()->user()->rol == 'Proveedor'){
            return redirect()->to('proveedor');
        }
    
        return redirect()->to('inicia-sesion');
      
    }

    public function destroy(){
        auth()->logout();

        return redirect()->to('index');
    }
}
