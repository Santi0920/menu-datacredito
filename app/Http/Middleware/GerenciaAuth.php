<?php

namespace App\Http\Middleware;

use Auth;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GerenciaAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
/*
     public function handle($request, Closure $next)
     {
        
         $data = User::where(Auth::user()->rol == 'Admin')->first();// obtengo solo un registro el cual es un objeto.
         if(isset($data->email)){
             return $next($request);
         }
         return abort(403);
     }*/

    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check()){
            if(auth()->user()->rol == 'Gerencia'){
              return $next($request);
            }
        }
        return redirect()->to('inicia-sesion');
    }
}
