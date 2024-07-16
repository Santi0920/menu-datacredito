<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;
use App\Mail\EnviarCorreo8;
use Illuminate\Support\Facades\Auth;

class CRUDCoordinador extends Controller
{
    //
    public function data(){

        $user = DB::select("
        SELECT DISTINCT  A.ID, A.Inspektor, A.Observaciones, A.FechaCorreo, A.Linea, A.Cedula, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado, A.Tipo, A.Consulta,
        A.Reporte, A.TipoAsociado, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT, E.ConsecutivoA, E.NombreA
        FROM persona A
        JOIN documentosintesis B ON A.ID = B.ID_Persona
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona
        JOIN documentot D ON C.ID_Persona = D.ID_Persona
        JOIN documentoa E ON D.ID_Persona = E.ID_Persona
        WHERE A.Activado = 1 AND (A.Tipo = 'Persona' OR A.Tipo = 'Empleado') AND (A.TipoAsociado = 'Asociacion' OR A.TipoAsociado = 'Empleado')
        ");


        return datatables()->of($user)->toJson();



    }

    public function data2(){
        $user = DB::select("SELECT DISTINCT  A.ID, A.Inspektor, A.ConsecutivoRC, A.ObRC, A.Observaciones, A.FechaCorreo, A.TipoAsociado, A.Cedula, A.Linea, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado,
        A.Reporte, A.Monto, A.NombreAnalisis, A.ConsecutivoAnalisis, A.DeudaEsp, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT, E.NombreA, E.ConsecutivoA
        FROM persona A
        JOIN documentosintesis B ON A.ID = B.ID_Persona
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona
        JOIN documentot D ON C.ID_Persona = D.ID_Persona
        JOIN documentoa E ON D.ID_Persona = E.ID_Persona
        WHERE A.Activado = 1 && (A.Tipo = 'Persona' OR A.Tipo = 'Empleado') && A.TipoAsociado = 'Credito'
        ORDER BY Nombre ASC");


        return datatables()->of($user)->toJson();



    }




    public function update(Request $request, $id)
    {

        $archivo = DB::select("SELECT NombreS FROM documentosintesis WHERE ID_Persona = ?", [$id]);
        $nombre_archivo = $archivo[0]->NombreS;
        $filename = $nombre_archivo;
        if ($archivo) {
            $nombre_archivo = $archivo[0]->NombreS;
            if ($request->hasFile('archivo22')) {
                $file = $request->file('archivo22');
                $filename =  $file->getClientOriginalName();
            }



            $nuevo_archivo = $filename;
            if ($archivo) {
                $pdfactual = $nombre_archivo;
            } else {
                $pdfactual = null;
            }
        }
        if (!empty($archivo) && $archivo != $pdfactual) {
            $nuevo_nombre = $nuevo_archivo;
        }

        if (isset($nombre_archivo) && isset($nuevo_nombre) && $nombre_archivo !== $nuevo_nombre) {
            return back()->withErrors([
                'message' => 'El archivo subido contiene un nombre diferente al archivo SINTESIS actual. (' . $nombre_archivo . ').\n'
            ]);
        }

        $fecha = DB::select("SELECT FechaInsercion FROM documentosintesis WHERE ID_Persona = ?", [$id]);
        $fechai = $fecha[0]->FechaInsercion;
        $fechadef = $request->fecha3;

        $archivo2 = DB::select("SELECT NombrePN FROM documentopn WHERE ID_Persona = ?", [$id]);
        $nombre_archivo2 = $archivo2[0]->NombrePN;
        $filename2 = $nombre_archivo2;
        if ($archivo2) {
            $nombre_archivo2 = $archivo2[0]->NombrePN;
            if ($request->hasFile('archivo11')) {
                $file2 = $request->file('archivo11');
                $filename2 =  $file2->getClientOriginalName();
            }


            $nuevo_archivo2 = $filename2;
            if ($archivo2) {
                $pdfactual2 = $nombre_archivo2;
            } else {
                $pdfactual2 = null;
            }
        }

        if (!empty($archivo2) && $archivo2 != $pdfactual2) {
            $nuevo_nombre2 = $nuevo_archivo2;
        }

        if (isset($nombre_archivo2) && isset($nuevo_nombre2) && $nombre_archivo2 !== $nuevo_nombre2) {

            return back()->withErrors([
                'message' => 'El archivo subido contiene un nombre diferente al archivo PN actual (' . $nombre_archivo2 . ').\n'
            ]);
        }
         else {
            if($request->Score == 'S/E'){
                $request->Score = 'S/E';
             }
                elseif
                ($request->Score > 950) {
                $request->Score = 950;
            }

            $sql = DB::update("UPDATE persona SET Cedula=?, Nombre =?, Apellidos = UPPER(?), Score = ?, Agencia = ?, Estado = ?, Reporte = ? , CuentaAsociada= ?, Enviado=?, Consulta=?, Observaciones = ? WHERE ID = $id", [
                $request->cedula2,
                $request->nombre3,
                $request->apellidos3,
                $request->score3,
                $request->agencia3,
                $request->estado3,
                $request->reporte3,
                $request->cuenta3,
                0,
                0,
                $request->Observaciones

            ]);


            $dir = 'Storage/files/sintesis/';
            if ($request->hasFile('archivo22') && !empty($filename)) {
                $file = $request->file('archivo22');

                if ($file->getClientOriginalExtension() === 'pdf') {
                    if ($file->getClientOriginalName() !== 'Sintesis-' . $request->cedula2 . '.pdf') {
                        return back()->withErrors([
                            'message' => 'El nombre del archivo no cumple con el formato requerido ->Sintesis-' . $request->cedula2 . '.pdf'
                        ]);
                    }

                    $uploadSuccess = $file->move($dir, $filename);
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            }

            $dir2 = 'Storage/files/pn/';
            if ($request->hasFile('archivo11') && !empty($filename2)) {
                $file2 = $request->file('archivo11');
                if ($file2->getClientOriginalName() !== 'PN-' . $request->cedula2 . '.pdf') {
                    return back()->withErrors([
                        'message' => 'El nombre del archivo no cumple con el formato requerido ->PN-' . $request->cedula2 . '.pdf'
                    ]);
                }

                if ($file2->getClientOriginalExtension() === 'pdf') {
                    $uploadSuccess = $file2->move($dir2, $filename2);
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            }




            $archivo = DB::select("SELECT NombreS FROM documentosintesis WHERE ID_Persona = ?", [$id]);
            $nombre_archivo = $archivo[0]->NombreS;

            $archivo2 = DB::select("SELECT NombrePN FROM documentopn WHERE ID_Persona = ?", [$id]);
            $nombre_archivo2 = $archivo2[0]->NombrePN;


            if ($request->hasFile('archivo22')) {

                $sql2 = DB::update("UPDATE documentosintesis SET FechaInsercion = ?, NombreS = ? WHERE ID_Persona = $id", [
                    $request->fecha3,
                    $nuevo_archivo
                ]);
            } else {

                $sql2 = DB::update("UPDATE documentosintesis SET FechaInsercion = ? WHERE ID_Persona = $id", [
                    $request->fecha3
                ]);
            }

            if ($request->archivo11 != null) {

                $sql3 = DB::update("UPDATE documentopn SET NombrePN = ? WHERE ID_Persona = $id", [
                    $nuevo_archivo2
                ]);
            }

            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;
            $cedulaagregada = $request->Cedula;
            date_default_timezone_set('America/Bogota');
            $ip = $_SERVER['REMOTE_ADDR'];
            $fechaHoraActual = date('Y-m-d H:i:s');
            $cedula = DB::select("SELECT Cedula FROM persona WHERE ID = $id");
            $cedulaRegistrada = $cedula[0]->Cedula;
            $agencia = $usuarioActual->agenciau;
            $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'ActualizoAsociacion', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                $cedulaRegistrada,
                null,
                $ip
            ]);

            if ($sql == true || $sql2 = true || $sql3 == true) {
                $persona = DB::selectOne('SELECT Nombre, Apellidos FROM persona WHERE ID = ?', [$id]);
                $nombreUsuario = $persona ? ucfirst(strtolower($persona->Nombre)) . ' ' . $persona->Apellidos : '';
                $Cedula = DB::selectOne('SELECT Cedula FROM persona WHERE ID = ?', [$id]);
                $talento = "";
                $tipo = "la Persona";
                $agencia = $request->agencia3;
                $usuarios = DB::table('users')->where('rol', 'Consultante')->where('agenciaU', $agencia)->pluck('email');

                foreach ($usuarios as $email) {
                    Mail::to($email)->send(new EnviarCorreo($Cedula->Cedula, $nombreUsuario, $talento, $tipo));
                }
                return back()->with("correcto", "El usuario " . ucwords($request->nombre3) . " " . strtoupper($request->apellidos3) . " con identificación $request->cedula2 fue actualizado correctamente!");

            } else {
                return back()->with("incorrecto", "Error al modificar el registro!");
            }
        }
    }


    public function delete2($id, Request $request)
    {

        $sql = DB::update("UPDATE persona SET activado = 0 WHERE ID=$id", []);

        if ($sql == true) {
            return back()->with("correcto", "Registro eliminado correctamente!");
            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;
            date_default_timezone_set('America/Bogota');

            $fechaHoraActual = date('Y-m-d H:i:s');
            $cedula = DB::select("SELECT Cedula FROM persona WHERE ID = $id");
            $cedulaRegistrada = $cedula[0]->Cedula;
            $ip = $_SERVER['REMOTE_ADDR'];
            $agencia = $usuarioActual->agenciau;
            $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'Desactivo-EliminoUsuario', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                $cedulaRegistrada,
                null,
                $ip
            ]);
        } else {
            return back()->with("incorrecto", "Error al eliminar!");

        }
    }

    public function updatecredito(Request $request, $id)
    {


        $archivo = DB::select("SELECT NombreS FROM documentosintesis WHERE ID_Persona = ?", [$id]);
        $nombre_archivo = $archivo[0]->NombreS;
        $filename = $nombre_archivo;
        if ($archivo) {
            $nombre_archivo = $archivo[0]->NombreS;
            if ($request->hasFile('archivo22')) {
                $file = $request->file('archivo22');
                $filename =  $file->getClientOriginalName();
            }



            $nuevo_archivo = $filename;
            if ($archivo) {
                $pdfactual = $nombre_archivo;
            } else {
                $pdfactual = null;
            }
        }
        if (!empty($archivo) && $archivo != $pdfactual) {
            $nuevo_nombre = $nuevo_archivo;
        }

        if (isset($nombre_archivo) && isset($nuevo_nombre) && $nombre_archivo !== $nuevo_nombre) {
            return back()->withErrors([
                'message' => 'El archivo subido contiene un nombre diferente al archivo SINTESIS ' . $nombre_archivo . ' actual (' . $nombre_archivo . ').\n'
            ]);
        }

        $fecha = DB::select("SELECT FechaInsercion FROM documentosintesis WHERE ID_Persona = ?", [$id]);
        $fechai = $fecha[0]->FechaInsercion;
        $fechadef = $request->fecha3;



        $archivo2 = DB::select("SELECT NombrePN FROM documentopn WHERE ID_Persona = ?", [$id]);
        $nombre_archivo2 = $archivo2[0]->NombrePN;
        $filename2 = $nombre_archivo2;
        if ($archivo2) {
            $nombre_archivo2 = $archivo2[0]->NombrePN;
            if ($request->hasFile('archivo11')) {
                $file2 = $request->file('archivo11');
                $filename2 =  $file2->getClientOriginalName();
            }


            $nuevo_archivo2 = $filename2;
            if ($archivo2) {
                $pdfactual2 = $nombre_archivo2;
            } else {
                $pdfactual2 = null;
            }
        }

        if (!empty($archivo2) && $archivo2 != $pdfactual2) {
            $nuevo_nombre2 = $nuevo_archivo2;
        }

        if (isset($nombre_archivo2) && isset($nuevo_nombre2) && $nombre_archivo2 !== $nuevo_nombre2) {

            return back()->withErrors([
                'message' => 'El archivo subido contiene un nombre diferente al archivo PN actual (' . $nombre_archivo2 . ').\n'
            ]);
        }


else {
                if($request->Score == 'S/E'){
                    $request->Score = 'S/E';
                }
                 elseif
                 ($request->Score > 950) {
                    $request->Score = 950;
                }

                $sql = DB::select("SELECT DeudaEsp FROM persona WHERE ID = ?", [$id]);
                $totalDeuda = $sql[0]->DeudaEsp;


                $nuevoTotalDeuda = $totalDeuda + $request->monto;

                $sql = DB::update("UPDATE persona SET Cedula=?, Nombre =?, Apellidos = UPPER(?), Score = ?, Agencia = ?, Estado = ?, Reporte = ? , CuentaAsociada= ?, Enviado=?, Consulta=?, Observaciones = ? WHERE ID = $id", [
                    $request->cedula2,
                    $request->nombre3,
                    $request->apellidos3,
                    $request->score3,
                    $request->agencia3,
                    $request->estado3,
                    $request->reporte3,
                    $request->cuenta3,
                    0,
                    0,
                    $request->Observaciones

                ]);





            $dir = 'Storage/files/sintesis/';
            if ($request->hasFile('archivo22') && !empty($filename)) {
                $file = $request->file('archivo22');

                if ($file->getClientOriginalExtension() === 'pdf') {
                    if ($file->getClientOriginalName() !== 'Sintesis-' . $request->cedula2 . '.pdf') {
                        return back()->withErrors([
                            'message' => 'El nombre del archivo no cumple con el formato requerido ->Sintesis-' . $request->cedula2 . '.pdf'
                        ]);
                    }

                    $uploadSuccess = $file->move($dir, $filename);
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            }

            $dir2 = 'Storage/files/pn/';
            if ($request->hasFile('archivo11') && !empty($filename2)) {
                $file2 = $request->file('archivo11');
                if ($file2->getClientOriginalName() !== 'PN-' . $request->cedula2 . '.pdf') {
                    return back()->withErrors([
                        'message' => 'El nombre del archivo no cumple con el formato requerido ->PN-' . $request->cedula2 . '.pdf'
                    ]);
                }

                if ($file2->getClientOriginalExtension() === 'pdf') {
                    $uploadSuccess = $file2->move($dir2, $filename2);
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            }

            $archivo = DB::select("SELECT NombreS FROM documentosintesis WHERE ID_Persona = ?", [$id]);
            $nombre_archivo = $archivo[0]->NombreS;

            $archivo2 = DB::select("SELECT NombrePN FROM documentopn WHERE ID_Persona = ?", [$id]);
            $nombre_archivo2 = $archivo2[0]->NombrePN;


            if ($request->hasFile('archivo22')) {

                $sql2 = DB::update("UPDATE documentosintesis SET FechaInsercion = ?, NombreS = ? WHERE ID_Persona = $id", [
                    $request->fecha3,
                    $nuevo_archivo
                ]);
            } else {

                $sql2 = DB::update("UPDATE documentosintesis SET FechaInsercion = ? WHERE ID_Persona = $id", [
                    $request->fecha3
                ]);
            }

            if ($request->archivo11 != null) {

                $sql3 = DB::update("UPDATE documentopn SET NombrePN = ? WHERE ID_Persona = $id", [
                    $nuevo_archivo2
                ]);
            }


            $sql2 = DB::update("UPDATE persona SET Enviado = ? WHERE ID = $id", [
                    0

            ]);

            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;
            $cedulaagregada = $request->Cedula;
            date_default_timezone_set('America/Bogota');
            $fechaHoraActual = date('Y-m-d H:i:s');
            $cedula = DB::select("SELECT Cedula FROM persona WHERE ID = $id");
            $cedulaRegistrada = $cedula[0]->Cedula;
            $ip = $_SERVER['REMOTE_ADDR'];
$agencia = $usuarioActual->agenciau;
$login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'ActualizoCredito', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                $cedulaRegistrada,
                null,
                $ip
            ]);



            if ($sql == true || $sql2 = true ) {
                $persona = DB::selectOne('SELECT Nombre, Apellidos FROM persona WHERE ID = ?', [$id]);
                $nombreUsuario = $persona ? ucfirst(strtolower($persona->Nombre)) . ' ' . $persona->Apellidos : '';
                $Cedula = DB::selectOne('SELECT Cedula FROM persona WHERE ID = ?', [$id]);
                $agencia = $request->agencia3;
                $tipo = "la Persona";
                $usuarios = DB::table('users')->where('rol', 'Consultante')->where('agenciaU', $agencia)->pluck('email');
                foreach ($usuarios as $email) {
                Mail::to($email)->send(new EnviarCorreo8($Cedula->Cedula, $nombreUsuario, $tipo));
                }
                return back()->with("correcto", "El usuario " . ucwords($request->nombre3) . " " . strtoupper($request->apellidos3) . " con identificación $request->cedula2 fue actualizado correctamente!");

            } else {
                return back()->with("incorrecto", "Error al modificar el registro!");
            }

        }
    }


    public function delete3($id)
    {

        $sql = DB::update("UPDATE persona SET activado = 0 WHERE ID=$id", []);

        if ($sql == true) {
            return back()->with("correcto", "Registro eliminado correctamente!");

        } else {
            return back()->with("incorrecto", "Error al eliminar!");

        }
    }


    public function data3(){
        $user = DB::select("SELECT DISTINCT  A.ID, A.Inspektor, A.ConsecutivoRC, A.ObRC, A.Observaciones, A.FechaCorreo, A.TipoAsociado, A.Cedula, A.Linea, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado,
        A.Reporte, A.Monto, A.NombreAnalisis, A.ConsecutivoAnalisis, A.DeudaEsp, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT, E.NombreA, E.ConsecutivoA
        FROM persona A
        JOIN documentosintesis B ON A.ID = B.ID_Persona
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona
        JOIN documentot D ON C.ID_Persona = D.ID_Persona
        JOIN documentoa E ON D.ID_Persona = E.ID_Persona
        WHERE A.Activado = 1 && (A.Tipo = 'Persona' OR A.Tipo = 'Empleado' OR A.Tipo = 'NuevoEmpleado') && A.TipoAsociado = 'Asociacion Virtual'
        ORDER BY Nombre ASC");


        return datatables()->of($user)->toJson();

    }



}
