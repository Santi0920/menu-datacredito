<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;
use App\Mail\EnviarCorreo4;
use App\Mail\EnviarCorreo6;
class CRUDThumano extends Controller
{
    public function data(){
        $user = DB::select("
        SELECT DISTINCT A.ID, A.Inspektor, A.Cedula,A.FechaCorreo, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado, A.Tipo, A.Consulta,
        A.Reporte, A.Observaciones, A.NombreAnalisis, A.ConsecutivoAnalisis, A.Monto, A.DeudaEsp, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT, E.NombreA, E.ConsecutivoA, E.NombreContrato
        FROM persona A 
        JOIN documentosintesis B ON A.ID = B.ID_Persona 
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona 
        JOIN documentot D ON C.ID_Persona = D.ID_Persona 
        JOIN documentoa E ON D.ID_Persona = E.ID_Persona
        WHERE A.Activado = 1 && A.TipoAsociado = 'NuevoEmpleado' && A.Tipo = 'NuevoEmpleado'
        ORDER BY Nombre ASC");

        return datatables()->of($user)->toJson();

    }

    public function data2()
    {
        $users = DB::select("
            SELECT DISTINCT A.ID, A.Inspektor, A.Cedula, A.FechaCorreo, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado, A.Tipo, A.Consulta,
            A.Reporte, A.TipoProveedor,A.Observaciones, A.NombreAnalisis, A.ConsecutivoAnalisis, A.Monto, A.DeudaEsp, B.FechaInsercion, B.NombreS, C.NombrePN, P.NIT, P.NombreRC, P.ValorCompra, P.ValorAcumulado, P.RazonSocial ,E.NombreA, E.ConsecutivoA
            FROM persona A 
            JOIN documentosintesis B ON A.ID = B.ID_Persona 
            JOIN documentopn C ON B.ID_Persona = C.ID_Persona 
            JOIN documentoa E ON C.ID_Persona = E.ID_Persona
            JOIN proveedor P ON E.ID_Persona = P.ID_Persona 
            WHERE A.Activado = 1 && A.Tipo = 'Proveedor'
            ORDER BY Nombre ASC
        ");
    
        return datatables()->of($users)->toJson();
    }

    public function view()
    {
        $datos = DB::select("
        SELECT A.ID, A.Cedula, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado,
        A.Reporte, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT 
        FROM persona
        A JOIN documentosintesis B ON A.ID = B.ID_Persona JOIN documentopn C ON B.ID_Persona = C.ID_Persona JOIN documentot
        D ON C.ID_Persona = D.ID_Persona ORDER BY Nombre ASC");
        $datos2 = DB::select("SELECT * FROM users WHERE rol = 'Consultante' OR rol = 'Asociacion' OR rol = 'Thumano'");
        


        return view("Thumano/thumano", compact("datos","datos2"));
    }

    //registrar
    public function create(Request $request)
    {
        $existingPerson = DB::select('SELECT * FROM persona WHERE Cedula = ?', [$request->Cedula]);

        if ($existingPerson == true) {
            return back()->with("incorrecto", "Persona con cc. $request->Cedula ya existe! Error al Registrar!");
        }
        
         else {
            if($request->Score == 'S/E'){
            $request->Score = 'S/E';
         }
             elseif
             ($request->Score > 950) {
                $request->Score = 950;
            }

            if ($request->hasFile('NombreS') != null) {
                $file = $request->file('NombreS');
                $filename =  $file->getClientOriginalName();
                $archivo = DB::select("SELECT NombreS FROM documentosintesis WHERE NombreS = ?", [$filename]);
    
                if (!empty($archivo)) {
                    return back()->withErrors([
                        'message' => 'El archivo SINTESIS - "' . $filename . '" ya existe!'
                    ]);
                }
            }
            if ($request->hasFile('NombrePN') != null) {
                $file2 = $request->file('NombrePN');
                $filename2 =  $file2->getClientOriginalName();
                $archivo2 = DB::select("SELECT NombrePN FROM documentopn WHERE NombrePN = ?", [$filename2]);
    
                if (!empty($archivo2)) {
                    return back()->withErrors([
                        'message' => 'El archivo PN - "' . $filename2 . '" ya existe!'
                    ]);
                }
            }
            if ($request->hasFile('NombreA') != null) {
                $file4 = $request->file('NombreA');
                $filename4 =  $file4->getClientOriginalName();
                $archivo4 = DB::select("SELECT NombreA FROM documentoa WHERE NombreA = ?", [$filename4]);
    
                if (!empty($archivo4)) {
                    return back()->withErrors([
                        'message' => 'El archivo Autorización - "' . $filename4 . '" ya existe!'
                    ]);
                }
            }   
            if ($request->hasFile('contrato') != null) {
                $file2 = $request->file('contrato');
                $filename2 =  $file2->getClientOriginalName();
                $archivo2 = DB::select("SELECT NombreContrato FROM documentoa WHERE NombreContrato = ?", [$filename2]);
    
                if (!empty($archivo2)) {
                    return back()->withErrors([
                        'message' => 'El archivo Contrato - "' . $filename2 . '" ya existe!'
                    ]);
                }
            }
            


                
            $sql = DB::insert('INSERT INTO persona (Cedula, Nombre, Apellidos, Score, Agencia, Reporte, Tipo) VALUES (?, ?, UPPER(?), ?, ?, ?, ?)', [
                $request->Cedula,
                $request->Nombre,
                $request->Apellidos,
                $request->Score,
                $request->Agencia,
                $request->Reporte,
                'Empleado'
            ]);
            $idPersona = DB::getPdo()->lastInsertId();
            if ($request->hasFile('NombreS')) {
                $file = $request->file('NombreS');
                $dir = 'Storage/files/sintesis/';
                $filename =  $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
            
                
                if ($extension === 'pdf') {
                    $uploadSucces = $request->file('NombreS')->move($dir, $filename);
            
                    $sql2 = DB::insert('INSERT INTO documentosintesis (FechaInsercion, NombreS, ID_Persona) VALUES (?, ?, ?)', [
                        $request->FechaInsercion,
                        $filename ?? null,
                        $idPersona
                    ]);
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            } else {
                $sql2 = DB::insert('INSERT INTO documentosintesis (FechaInsercion, NombreS, ID_Persona) VALUES (?, ?, ?)', [
                    $request->FechaInsercion,
                    null,
                    $idPersona
                ]);
            }
            

            if ($request->hasFile('NombrePN')) {
                $file = $request->file('NombrePN');
                $dir = 'Storage/files/pn/';
                $filename =  $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();

                if ($extension === 'pdf') {
                    $uploadSucces = $request->file('NombrePN')->move($dir, $filename);
            
                    $sql3 = DB::insert('INSERT INTO documentopn (NombrePN, ID_Persona) VALUES (?, ?)', [
                        $filename ?? null,
                        $idPersona
                    ]);
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            } else {
                $sql3 = DB::insert('INSERT INTO documentopn (NombrePN, ID_Persona) VALUES (?, ?)', [
                    null,
                    $idPersona
                ]);
            }//
                
        
            if ($request->hasFile('NombreA')) {
                $file = $request->file('NombreA');
                if ($file != null) {
                    $dir = 'Storage/files/analisis/';
                    $filename =  $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
            
                    $file2 = $request->file('contrato');
                    $dir2 = 'Storage/files/analisis/contrato/';
                    $filename2 =  $file2->getClientOriginalName();
                    $extension2 = $file2->getClientOriginalExtension();
            
                    if ($extension === 'pdf' || $extension2 === 'pdf') {
                        $uploadSucces = $request->file('NombreA')->move($dir, $filename);
                        $uploadSucces2 = $request->file('contrato')->move($dir2, $filename2);
                        $sql4 = DB::insert('INSERT INTO documentoa (NombreA, ConsecutivoA, NombreContrato, ID_Persona) VALUES (?, ?, ?, ?)', [
                            $filename ?? null,
                            $request->consecutivoa,
                            $filename2 ?? null,
                            $idPersona
                        ]);
                    } else {
                        return back()->withErrors([
                            'message' => 'Solo se puede subir archivos PDF.'
                        ]);
                    }
                }
            } else {
                $sql4 = DB::insert('INSERT INTO documentoa (NombreA, NombreContrato, ConsecutivoA, ID_Persona) VALUES (?, ?, ?, ?)', [
                    null,
                    null,
                    $request->consecutivoa,
                    $idPersona
                ]);
            }

            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;
            $cedulaagregada = $request->Cedula;
            date_default_timezone_set('America/Bogota');
            $ip = $_SERVER['REMOTE_ADDR'];
            $fechaHoraActual = date('Y-m-d H:i:s');
$agencia = $usuarioActual->agenciau;                  
$login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'CreoEmpleado', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                $cedulaagregada,
                null,
                $ip
            ]);
            if ($sql && $sql2 && $sql3 && $sql4) {
                return back()->with("correcto", "Persona Registrada correctamente!");
            } else {
                return back()->with("incorrecto", "Error al insertar el registro!");
            }
        }
    }

    //Actualizar registro
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
        
        $archivo3 = DB::select("SELECT NombreA FROM documentoa WHERE ID_Persona = ?", [$id]);
        $nombre_archivo3 = $archivo3[0]->NombreA;
        $filename3 = $nombre_archivo3;
        if ($archivo3) {
            $nombre_archivo3 = $archivo3[0]->NombreA;
            if ($request->hasFile('archivo3')) {
                $file3 = $request->file('archivo3');
                $filename3 =  $file3->getClientOriginalName();
            }



            $nuevo_archivo3 = $filename3;
            if ($archivo3) {
                $pdfactual3 = $nombre_archivo3;
            } else {
                $pdfactual3 = null;
            }
        }
        if (!empty($archivo3) && $archivo3 != $pdfactual3) {
            $nuevo_nombre3 = $nuevo_archivo3;
        }

        if (isset($nombre_archivo3) && isset($nuevo_nombre3) && $nombre_archivo3 !== $nuevo_nombre3) {
            return back()->withErrors([
                'message' => 'El archivo subido contiene un nombre diferente al archivo AUTORIZACIÓN actual (' . $nombre_archivo3 . ').\n'
            ]);
        
        }
        
        $archivo4 = DB::select("SELECT NombreContrato FROM documentoa WHERE ID_Persona = ?", [$id]);
        $nombre_archivo4 = $archivo4[0]->NombreContrato;
        $filename4 = $nombre_archivo4;
        if ($archivo4) {
            $nombre_archivo4 = $archivo4[0]->NombreContrato;
            if ($request->hasFile('contrato1')) {
                $file4 = $request->file('contrato1');
                $filename4 =  $file4->getClientOriginalName();
            }



            $nuevo_archivo4 = $filename4;
            if ($archivo4) {
                $pdfactual4 = $nombre_archivo4;
            } else {
                $pdfactual4 = null;
            }
        }
        if (!empty($archivo4) && $archivo4 != $pdfactual4) {
            $nuevo_nombre4 = $nuevo_archivo4;
        }

        if (isset($nombre_archivo4) && isset($nuevo_nombre4) && $nombre_archivo4 !== $nuevo_nombre4) {
            return back()->withErrors([
                'message' => 'El archivo subido contiene un nombre diferente al archivo CONTRATO actual (' . $nombre_archivo4 . ').\n'
            ]);
        
        
        

        }else {
            if($request->score3 == 'S/E'){
                $request->score3 = 'S/E';
             }
                 elseif
                 ($request->score3 > 950) {
                    $request->score3 = 950;
                }
            

            $sql = DB::update("UPDATE persona SET Cedula=?, Nombre =?, Apellidos = ?, Score = ?, Agencia = ?,Reporte = ?, Observaciones = ? WHERE ID = $id", [
                $request->cedula2,
                $request->nombre3,
                $request->apellidos3,
                $request->score3,
                $request->agencia3,
                $request->reporte3,
                $request->Observaciones,

                

            ]);


            $dir = 'Storage/files/sintesis/';
            if ($request->hasFile('archivo22') && !empty($filename)) {
                $file = $request->file('archivo22');
            
                if ($file->getClientOriginalExtension() === 'pdf') {
                    if ($file->getClientOriginalName() !== 'Sintesis-' . $request->cedula2 . '.pdf') {
                        return back()->withErrors([
                            'message' => 'El nombre del archivo no cumple con el formato requerido ->Sintesis-' . $request->cedula2 . '.pdf'
                        ]);
                        $sql = DB::update("DELETE FROM documentot WHERE ID_Persona=$id", []);

                        $sql2 = DB::update("DELETE FROM documentot WHERE ID_Persona=$id", []);
                
                        $sql3 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$id", []);
                
                        $sql4 = DB::update("DELETE FROM persona WHERE ID=$id", []);
                    }
            
                    $uploadSuccess = $file->move($dir, $filename);
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                    $sql = DB::update("DELETE FROM documentot WHERE ID_Persona=$id", []);

                    $sql2 = DB::update("DELETE FROM documentot WHERE ID_Persona=$id", []);
            
                    $sql3 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$id", []);
            
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$id", []);
                }
            }

            $dir2 = 'Storage/files/pn/';
            if ($request->hasFile('archivo11') && !empty($filename2)) {
                $file2 = $request->file('archivo11');
                if ($file2->getClientOriginalName() !== 'PN-' . $request->cedula2 . '.pdf') {
                    return back()->withErrors([
                        'message' => 'El nombre del archivo no cumple con el formato requerido ->PN-' . $request->cedula2 . '.pdf'
                    ]);
                    $sql = DB::update("DELETE FROM documentot WHERE ID_Persona=$id", []);

                    $sql2 = DB::update("DELETE FROM documentot WHERE ID_Persona=$id", []);
            
                    $sql3 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$id", []);
            
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$id", []);
                }
          
                if ($file2->getClientOriginalExtension() === 'pdf') {
                    $uploadSuccess = $file2->move($dir2, $filename2);
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                    $sql = DB::update("DELETE FROM documentot WHERE ID_Persona=$id", []);

                    $sql2 = DB::update("DELETE FROM documentot WHERE ID_Persona=$id", []);
            
                    $sql3 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$id", []);
            
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$id", []);
                }
            }

            $dir3 = 'Storage/files/analisis/';
            if ($request->hasFile('archivo3') && !empty($filename3)) {
                $file3 = $request->file('archivo3');

          
                if ($file3->getClientOriginalExtension() === 'pdf') {
                    $uploadSuccess = $file3->move($dir3, $filename3);
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                    $sql = DB::update("DELETE FROM documentot WHERE ID_Persona=$id", []);

                    $sql2 = DB::update("DELETE FROM documentot WHERE ID_Persona=$id", []);
            
                    $sql3 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$id", []);
            
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$id", []);
                }
            }

            $dir4 = 'Storage/files/analisis/contrato/';
            if ($request->hasFile('contrato1') && !empty($filename4)) {
                $file4 = $request->file('contrato1');

          
                if ($file4->getClientOriginalExtension() === 'pdf') {
                    $uploadSuccess = $file4->move($dir4, $filename4);
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
            
            $archivo3 = DB::select("SELECT NombreA FROM documentoa WHERE ID_Persona = ?", [$id]);
            $nombre_archivo3 = $archivo3[0]->NombreA;
            
            $archivo4 = DB::select("SELECT NombreContrato FROM documentoa WHERE ID_Persona = ?", [$id]);
            $nombre_archivo4 = $archivo4[0]->NombreContrato;



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

            if ($request->archivo11 != null) {
                $sql3 = DB::update("UPDATE documentopn SET NombrePN = ? WHERE ID_Persona = $id", [
                    $nuevo_archivo2
                ]);
            }

            $sql5 = DB::update("UPDATE persona SET Enviado = ?, Consulta = ? WHERE ID = $id", [
                0,
                0
            ]);

            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;
            $cedulaagregada = $request->Cedula;
            date_default_timezone_set('America/Bogota');
            $cedula = DB::select("SELECT Cedula FROM persona WHERE ID = $id");
            $cedulaRegistrada = $cedula[0]->Cedula;
            $fechaHoraActual = date('Y-m-d H:i:s');
            $ip = $_SERVER['REMOTE_ADDR'];
$agencia = $usuarioActual->agenciau;                  
$login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'ActualizoEmpleado', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                $cedulaRegistrada,
                null,
                $ip
            ]);

   
  
            if ($sql == true || $sql2 = true || $sql5) {        
                $persona = DB::selectOne('SELECT Nombre, Apellidos FROM persona WHERE ID = ?', [$id]);
                $nombreUsuario = $persona ? ucfirst(strtolower($persona->Nombre)) . ' ' . $persona->Apellidos : '';
                $Cedula = DB::selectOne('SELECT Cedula FROM persona WHERE ID = ?', [$id]);
                $agencia = $request->agencia3;
                $usuarios = DB::table('users')->whereIn('rol', ['Consultante', 'NuevoEmpleado'])->where('agenciaU', $agencia)->pluck('email');
                $talento = " de Talento Humano";
                $tipo = "el     Empleado";
                foreach ($usuarios as $email) {
                Mail::to($email)->send(new EnviarCorreo($Cedula->Cedula, $nombreUsuario, $talento, $tipo));
                }        

                return back()->with("correcto", "El usuario " . ucwords($request->nombre3) . " " . strtoupper($request->apellidos3) . " con identificación $request->cedula2 fue actualizado correctamente!");
            } else {
                return back()->with("incorrecto", "Error al modificar el registro!");
            }
        }
    }
    

 //Actualizar registro
 public function update3(Request $request, $id)
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
                'message' => 'El archivo subido contiene un nombre diferente al archivo SINTESIS actual (' . $nombre_archivo . ').\n'
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
            if($request->score3 == 'S/E'){
                $request->score3 = 'S/E';
             }
                 elseif
                 ($request->score3 > 950) {
                    $request->score3 = 950;
                }

                if($request->score4 == 'S/E'){
                    $request->score4 = 'S/E';
                 }
                     elseif
                     ($request->score4 > 950) {
                        $request->score4 = 950;
                    }
            
                $tipoprov = DB::select("SELECT TipoProveedor FROM persona WHERE ID = ?", [$id]);
                $tipoproveedor = $tipoprov[0]->TipoProveedor;
                if($tipoproveedor == 'PN'){
            $sql = DB::update("UPDATE persona SET Cedula=?, Nombre =?, Apellidos = ?, Score = ?, Agencia = ?,Reporte = ?,Enviado = ?, Observaciones = ? WHERE ID = $id", [
                $request->cedula2,
                $request->nombre3,
                $request->apellidos3,
                $request->score3,
                $request->agencia3,
                $request->reporte3,
                0,
                $request->Observaciones,
                

            ]);
        }else if($tipoproveedor == 'PJ'){
            $sql = DB::update("UPDATE persona SET Cedula=?, Nombre =?, Apellidos = ?, Score = ?, Agencia = ?,Reporte = ?, Enviado = ?, Observaciones = ?  WHERE ID = $id", [
                null,
                null,
                null,
                $request->score4,
                $request->agencia4,
                $request->reporte4,
                0,
                $request->Observaciones2,
            ]);

            $sql = DB::update("UPDATE proveedor SET NIT=?, RazonSocial =?  WHERE ID_Persona = $id", [
                $request->nit2,
                $request->razonsocial2
            ]);

        }


            $dir = 'Storage/files/sintesis/';
            if ($request->hasFile('archivo22') && !empty($filename)) {
                $file = $request->file('archivo22');
               
                if ($file->getClientOriginalExtension() === 'pdf') {
                    if($tipoproveedor == 'PN'){
                    if ($file->getClientOriginalName() !== 'Sintesis-' . $request->cedula2 . '.pdf') {
                        return back()->withErrors([
                            'message' => 'El nombre del archivo no cumple con el formato requerido ->Sintesis-' . $request->cedula2 . '.pdf'
                        ]);
                    }
                }else if($tipoproveedor == 'PJ'){
                    if ($file->getClientOriginalName() !== 'Sintesis-' . $request->nit2 . '.pdf') {
                        return back()->withErrors([
                            'message' => 'El nombre del archivo no cumple con el formato requerido ->Sintesis-' . $request->nit2 . '.pdf'
                        ]);
                    }
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
               
                if ($file2->getClientOriginalExtension() === 'pdf') {
                    if($tipoproveedor == 'PN'){
                    if ($file2->getClientOriginalName() !== 'PN-' . $request->cedula2 . '.pdf') {
                        return back()->withErrors([
                            'message' => 'El nombre del archivo no cumple con el formato requerido ->PN-' . $request->cedula2 . '.pdf'
                        ]);
                    }
                }else if($tipoproveedor == 'PJ'){
                    if ($file2->getClientOriginalName() !== 'PN-' . $request->nit2 . '.pdf') {
                        return back()->withErrors([
                            'message' => 'El nombre del archivo no cumple con el formato requerido ->PN-' . $request->nit2 . '.pdf'
                        ]);
                    }
                }
            
                    $uploadSuccess = $file2->move($dir2, $filename2);
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            }
      


            

            if($tipoproveedor == 'PN'){
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

            if ($request->archivo11 != null) {
                $sql3 = DB::update("UPDATE documentopn SET NombrePN = ? WHERE ID_Persona = $id", [
                    $nuevo_archivo2
                ]);
            }

            $sql5 = DB::update("UPDATE persona SET Enviado = ?, Consulta = ? WHERE ID = $id", [
                0,
                0
            ]);
        }else if($tipoproveedor == 'PJ'){
            if ($request->hasFile('archivo22')) {
                $sql2 = DB::update("UPDATE documentosintesis SET FechaInsercion = ?, NombreS = ? WHERE ID_Persona = $id", [
                    $request->fecha4,
                    $nuevo_archivo
                ]);
            } else {
                $sql2 = DB::update("UPDATE documentosintesis SET FechaInsercion = ? WHERE ID_Persona = $id", [
                    $request->fecha4
                ]);
            }

            if ($request->archivo11 != null) {
                $sql3 = DB::update("UPDATE documentopn SET NombrePN = ? WHERE ID_Persona = $id", [
                    $nuevo_archivo2
                ]);
            }

            if ($request->archivo11 != null) {
                $sql3 = DB::update("UPDATE documentopn SET NombrePN = ? WHERE ID_Persona = $id", [
                    $nuevo_archivo2
                ]);
            }

            $sql5 = DB::update("UPDATE persona SET Enviado = ?, Consulta = ? WHERE ID = $id", [
                0,
                0
            ]);
        }

     

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
$login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'ActualizoProveedor', ?, ?, ?, ?)", [
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
            if($tipoproveedor == 'PN'){
             $persona = DB::selectOne('SELECT Nombre, Apellidos FROM persona WHERE ID = ?', [$id]);
             $nombreUsuario = $persona ? ucfirst(strtolower($persona->Nombre)) . ' ' . $persona->Apellidos : '';
             $Cedula = DB::selectOne('SELECT Cedula FROM persona WHERE ID = ?', [$id]);
             $agencia = $request->agencia3;
             $usuarios = DB::table('users')->whereIn('rol', ['Consultante', 'Jefatura', 'ControlMasivo'])->where('agenciaU', $agencia)->pluck('email');
             $talento = " de Talento Humano";
             $tipo = "la Persona - Proveedor";
             foreach ($usuarios as $email) {
             Mail::to($email)->send(new EnviarCorreo($Cedula->Cedula, $nombreUsuario, $talento, $tipo));
             }
             return back()->with("correcto", "El usuario " . ucwords($request->nombre3) . " " . strtoupper($request->apellidos3) . " con identificación $request->cedula2 fue actualizado correctamente!");    
            }else{
             $persona = DB::selectOne('SELECT Nombre, Apellidos FROM persona WHERE ID = ?', [$id]);
             $nombreUsuario = $persona ? ucfirst(strtolower($persona->Nombre)) . ' ' . $persona->Apellidos : '';
             $nit = $request->nit2;
             $razon = $request->razonsocial2;
             $agencia = $request->agencia3;
             $usuarios = DB::table('users')->whereIn('rol', ['Consultante', 'Jefatura', 'ControlMasivo'])->where('agenciaU', $agencia)->pluck('email');
             $talento = " de Talento Humano";
             $tipo = "el Proveedor";
             foreach ($usuarios as $email) {
             Mail::to($email)->send(new EnviarCorreo4($nit, $razon, $talento, $tipo));
             }
             return back()->with("correcto", "La persona con razón social " . ucwords($request->razonsocial2) . " con NIT # $request->nit2 fue actualizado correctamente!");
            }
         } else {
             return back()->with("incorrecto", "Error al modificar el registro!");
         }
     }
 }

}