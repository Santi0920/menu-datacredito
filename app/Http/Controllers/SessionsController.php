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

    public function admin() {
        if(auth()->attempt(request(['email', 'password']))== false){
            return back()->withErrors([
                'message' => 'El usuario o la contraseña es incorrecto!'
            ]);
        }else{
            if(auth()->user()->rol == 'Admin'){
                return redirect()->route('crud.list');
            }else{
                return redirect()->to('inicia-sesion');
            }
        }
        
    }

    public function asociacion() {
        if(auth()->attempt(request(['email', 'password']))== false){
            return back()->withErrors([
                'message' => 'El usuario o la contraseña es incorrecto!'
            ]);
        }else{
            if(auth()->user()->rol == 'Asociacion'){
                return redirect()->to('asociacion');
            }else{
                return redirect()->to('inicia-sesion');
            }
        }
        
    }

    public function credito() {
        if(auth()->attempt(request(['email', 'password']))== false){
            return back()->withErrors([
                'message' => 'El usuario o la contraseña es incorrecto!'
            ]);
        }else{
            if(auth()->user()->rol == 'Credito'){
                return redirect()->to('credito');
            }else{
                return redirect()->to('inicia-sesion');
            }
        }
        
    }

    public function consultante() {
        if(auth()->attempt(request(['email', 'password']))== false){
            return back()->withErrors([
                'message' => 'El usuario o la contraseña es incorrecto!'
            ]);
        }else{
            if(auth()->user()->rol == 'Consultante'){
                return redirect()->to('consultante');
            }else{
                return redirect()->to('inicia-sesion');
            }
        }
        
    }

    public function destroy(){
        auth()->logout();

        return redirect()->to('index');
    }
}
