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

    public function store() {
        if(auth()->attempt(request(['email', 'password']))== false){
            return back()->withErrors([
                'message' => 'El usuario o la contraseña es incorrecto!'
            ]);
        }
        return redirect()->to('datacredito');
    }

    public function destroy(){
        auth()->logout();

        return redirect()->to('index');
    }
}
