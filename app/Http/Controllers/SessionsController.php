<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SessionsController extends Controller
{
    //
    public function login()
    {
        return view("login");
    }

    public function login_post(Request $request)
    {
        if (auth()->attempt(request(['email', 'password'])) == false) {
            return back()->withErrors([
                'message' => 'El usuario o la contraseña es incorrecto!'
            ]);
        }


        $user = auth()->user();

        if ($user->activo == 0) {
            auth()->logout();

            return back()->withErrors([
                'message' => 'Tu cuenta está desactivada. Por favor, contacta al administrador.'
            ]);
        }


        if ($user->rol == 'Admin') {
            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;

            date_default_timezone_set('America/Bogota');

            $fechaHoraActual = date('Y-m-d H:i:s');
            $ip = $_SERVER['REMOTE_ADDR'];
            $agencia = $usuarioActual->agenciau;
            $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'Ingreso', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                null,
                null,
                $ip
            ]);

            return redirect()->route('crud.list');


        } elseif ($user->rol == 'Asociacion') {
            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;

            date_default_timezone_set('America/Bogota');

            $fechaHoraActual = date('Y-m-d H:i:s');

            $ip = $_SERVER['REMOTE_ADDR'];
            $agencia = $usuarioActual->agenciau;
            $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'Ingreso', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                null,
                null,
                $ip
            ]);

            if($user->agenciau == 'Asociacion Virtual'){
                return redirect()->to('avirtual');
            }else{
                return redirect()->to('coordinador');
            }



        } elseif ($user->rol == 'Consultante') {
            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;

            date_default_timezone_set('America/Bogota');

            $fechaHoraActual = date('Y-m-d H:i:s');

            $ip = $_SERVER['REMOTE_ADDR'];
            $agencia = $usuarioActual->agenciau;
            $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'Ingreso', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                null,
                null,
                $ip
            ]);

            return redirect()->to('director');
        }elseif ($user->rol == 'Thumano') {
            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;

            date_default_timezone_set('America/Bogota');

            $fechaHoraActual = date('Y-m-d H:i:s');

            $ip = $_SERVER['REMOTE_ADDR'];
            $agencia = $usuarioActual->agenciau;
            $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'Ingreso', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                null,
                null,
                $ip
            ]);

            return redirect()->to('thumano');
        }elseif ($user->rol == 'Credito') {
            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;

            date_default_timezone_set('America/Bogota');

            $fechaHoraActual = date('Y-m-d H:i:s');

            $ip = $_SERVER['REMOTE_ADDR'];
            $agencia = $usuarioActual->agenciau;
            $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'Ingreso', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                null,
                null,
                $ip
            ]);

            return redirect()->to('credito');
        }elseif ($user->rol == 'Control') {
            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;

            date_default_timezone_set('America/Bogota');

            $fechaHoraActual = date('Y-m-d H:i:s');

            $ip = $_SERVER['REMOTE_ADDR'];
            $agencia = $usuarioActual->agenciau;
            $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'Ingreso', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                null,
                null,
                $ip
            ]);

            return redirect()->to('control');
        }elseif ($user->rol == 'NuevoEmpleado') {
            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;

            date_default_timezone_set('America/Bogota');

            $fechaHoraActual = date('Y-m-d H:i:s');

            $ip = $_SERVER['REMOTE_ADDR'];
            $agencia = $usuarioActual->agenciau;
            $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'Ingreso', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                null,
                null,
                $ip
            ]);

            return redirect()->to('nuevosempleados');
        }elseif ($user->rol == 'Jefatura') {
            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;

            date_default_timezone_set('America/Bogota');

            $fechaHoraActual = date('Y-m-d H:i:s');

            $ip = $_SERVER['REMOTE_ADDR'];
            $agencia = $usuarioActual->agenciau;
            $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'Ingreso', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                null,
                null,
                $ip
            ]);

            return redirect()->to('jefaturaproveedor');
        }elseif ($user->rol == 'ControlMasivo') {
            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;

            date_default_timezone_set('America/Bogota');

            $fechaHoraActual = date('Y-m-d H:i:s');

            $ip = $_SERVER['REMOTE_ADDR'];
            $agencia = $usuarioActual->agenciau;
            $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'Ingreso', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                null,
                null,
                $ip
            ]);

            return redirect()->to('controlmasivoproveedor');
        }elseif ($user->rol == 'Gerencia') {
            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;

            date_default_timezone_set('America/Bogota');

            $fechaHoraActual = date('Y-m-d H:i:s');

            $ip = $_SERVER['REMOTE_ADDR'];
            $agencia = $usuarioActual->agenciau;
            $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'Ingreso', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                null,
                null,
                $ip
            ]);

            return redirect()->to('gerenciaproveedor');

        }elseif ($user->rol == 'Coordinacion') {
            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;

            date_default_timezone_set('America/Bogota');

            $fechaHoraActual = date('Y-m-d H:i:s');

            $ip = $_SERVER['REMOTE_ADDR'];
            $agencia = $usuarioActual->agenciau;
            $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'Ingreso', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                null,
                null,
                $ip
            ]);

            return redirect()->to('coordinacion');
        }


        return redirect()->to('inicia-sesion');
    }

    public function destroy(Request $request){
        $usuarioActual = Auth::user();
        $nombre = $usuarioActual->name;
        $rol = $usuarioActual->rol;

        date_default_timezone_set('America/Bogota');
        $fechaHoraActual = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'];
$agencia = $usuarioActual->agenciau;
$logout = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'Cerro Sesión', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                null,
                null,
                $ip
            ]);


        auth()->logout();



        return redirect()->to('index');
    }
}
