<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\EnviarCorreo7;
use App\Mail\EnviarCorreo13;
use App\Mail\EnviarCorreo5;
use App\Mail\EnviarCorreo6;
use Illuminate\Support\Facades\Mail;
use Codedge\Fpdf\Fpdf\Fpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use Carbon\Carbon;

class ControllerNuevoEmpleado extends Controller
{
    public function data(){
        $usuarioActual = Auth::user();
        $agenciaU = $usuarioActual->agenciau;
        $user = DB::select("
        SELECT DISTINCT A.ID, A.Inspektor, A.Observaciones, A.Cedula,A.FechaCorreo, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado, A.Tipo, A.Consulta,
        A.Reporte, B.FechaInsercion, B.NombreS, C.NombrePN,E.NombreA, D.Consecutivof, D.Tipof, D.NombreT, E.ConsecutivoA, E.NombreContrato
        FROM persona A 
        JOIN documentosintesis B ON A.ID = B.ID_Persona 
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona
        JOIN documentot D ON C.ID_Persona = D.ID_Persona  
        JOIN documentoa E ON D.ID_Persona = E.ID_Persona
        WHERE A.Activado = 1 && A.TipoAsociado = 'NuevoEmpleado' && A.Tipo = 'NuevoEmpleado'  && A.Enviado = 0
        ORDER BY Nombre ASC");

        return datatables()->of($user)->toJson();

    }




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

                date_default_timezone_set('America/Bogota');
                $fechaHoraActual = date('Y-m-d H:i:s');
                $usuarioActual = Auth::user();
                $agenciaU = $usuarioActual->agenciau;
                $sql = DB::insert('INSERT INTO persona (Cedula, Nombre, Apellidos, Score, CuentaAsociada, Agencia, Estado, Reporte, Tipo, TipoAsociado, Enviado, FechaCorreo, Inspektor) VALUES (?, ?, UPPER(?), ?, ?, ?, ?, ?, ?, ?,?, ?, ?)', [
                    $request->Cedula,
                    $request->Nombre,
                    $request->Apellidos,
                    null,
                    $request->CuentaAsociada,
                    $agenciaU,
                    $request->Estado,
                    null,
                    'NuevoEmpleado',
                    'NuevoEmpleado',
                    1,
                    $fechaHoraActual,
                    $request->Inspektor
                ]);
                $idPersona = DB::getPdo()->lastInsertId();

                if ($request->hasFile('NombreA') != null) {
                    $file4 = $request->file('NombreA');
                    $filename4 =  $file4->getClientOriginalName();
                    $archivo4 = DB::select("SELECT NombreA FROM documentoa WHERE NombreA = ?", [$filename4]);
        
                    if (!empty($archivo4)) {
                        $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
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
                        $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                        return back()->withErrors([
                            'message' => 'El archivo Cédula - "' . $filename2 . '" ya existe!'
                        ]);
                    }
                }


                if ($request->hasFile('NombreT')) {
                    $file = $request->file('NombreT');
                    $filename2 =  $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $dir3 = "";
                    $ruta_carga3 = "";
                
                    // Verificar si la extensión es PDF
                    if ($extension === 'pdf') {
                        if ($request->Tipof == "T1") {
                            $dir3 = "Storage/files/t1/";
                            $ruta_carga3 = $dir3 . $file->getClientOriginalName();
                            if ($file->getClientOriginalName() !== 'T1-' . $request->Cedula . '.pdf') {
                                $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                                return back()->withErrors([
                                    'message' => 'El nombre del archivo no cumple con el formato requerido ->T1-' . $request->Cedula . '.pdf'
                                ]);
                            }
                        } elseif ($request->Tipof == "T2") {
                            $dir3 = "Storage/files/t2/";
                            $ruta_carga3 = $dir3 . $file->getClientOriginalName();
                            if ($file->getClientOriginalName() !== 'T2-' . $request->Cedula . '.pdf') {
                                $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                                return back()->withErrors([
                                    'message' => 'El nombre del archivo no cumple con el formato requerido ->T2-' . $request->Cedula . '.pdf'
                                ]);
                            }
                        }
                
                        if ($request->Tipof != "N/A") {
                            $uploadSucces = $file->move($dir3, $ruta_carga3);
                        }
                
                        $sql4 = DB::insert('INSERT INTO documentot (NombreT, Consecutivof, Tipof, ID_Persona) VALUES (?, ?, ?, ?)', [
                            $filename2 ?? null,
                            $request->Consecutivof,
                            $request->Tipof ?? 'N/A',
                            $idPersona
                        ]);
                    } else {
                        $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                        return back()->withErrors([
                            'message' => 'Solo se puede subir archivos PDF.'
                        ]);
                    }
                } else {
                    $sql4 = DB::insert('INSERT INTO documentot (NombreT, Consecutivof, Tipof, ID_Persona) VALUES (?, ?, ?, ?)', [
                        null,
                        $request->Consecutivof,
                        $request->Tipof ?? 'N/A',
                        $idPersona
                    ]);
                }

            
            if ($request->hasFile('NombreS')) {
                $file = $request->file('NombreS');
                $dir = 'Storage/files/sintesis/';
                $filename =  $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                
                if ($file->getClientOriginalName() !== 'Sintesis-' . $request->Cedula . '.pdf') {
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                    return back()->withErrors([
                        'message' => 'El nombre del archivo no cumple con el formato requerido ->Sintesis-' . $request->Cedula . '.pdf'
                    ]);
                }
                if ($extension === 'pdf') {
                    $uploadSucces = $request->file('NombreS')->move($dir, $filename);
            
                    $sql2 = DB::insert('INSERT INTO documentosintesis (FechaInsercion, NombreS, ID_Persona) VALUES (?, ?, ?)', [
                        $request->FechaInsercion,
                        $filename ?? null,
                        $idPersona
                    ]);
                } else {
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            } else {
                $sql2 = DB::insert('INSERT INTO documentosintesis (FechaInsercion, NombreS, ID_Persona) VALUES (?, ?, ?)', [
                    $request->FechaInsercion ?? null,
                    null,
                    $idPersona
                ]);
            }


            if ($request->hasFile('contrato')) {
                $file3 = $request->file('contrato');
                $dir3 = 'Storage/files/cedula/';
                $filename3 =  $file3->getClientOriginalName();
                $extension3 = $file3->getClientOriginalExtension();

                $file5 = $request->file('NombreA');
                $dir5 = 'Storage/files/autorizacion/';
                $filename5 =  $file5->getClientOriginalName();
                $extension5 = $file5->getClientOriginalExtension();
                
                if ($file5->getClientOriginalName() !== 'Autorizacion-' . $request->Cedula . '.pdf') {
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                    return back()->withErrors([
                        'message' => 'El nombre del archivo no cumple con el formato requerido ->Autorizacion-' . $request->Cedula . '.pdf'
                    ]);
                }
                if ($file3->getClientOriginalName() !==  $request->Cedula . '.pdf') {
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                    return back()->withErrors([
                        'message' => 'El nombre del archivo no cumple con el formato requerido ->' . $request->Cedula . '.pdf'
                    ]);
                }

                if ($extension3 === 'pdf' && $extension5 = 'pdf') {
                    $uploadSucces = $request->file('contrato')->move($dir3, $filename3);
                    $uploadSucces = $request->file('NombreA')->move($dir5, $filename5);
            
                    $sql2 = DB::insert('INSERT INTO documentoa (NombreA, ConsecutivoA, NombreContrato, ID_Persona) VALUES (?, ?, ?, ?)', [
                        $filename5 ?? null,
                        $request->consecutivoa,
                        $filename3 ?? null,
                        $idPersona
                    ]);
                } else {
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            } else {
                $sql2 = DB::insert('INSERT INTO documentoa (ConsecutivoA, NombreContrato, ID_Persona) VALUES (?, ?, ?, ?)', [
                    null,
                    $request->consecutivoa,
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
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
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
                $cedula = $request->Cedula;
                $usuarioActual = Auth::user();
                $agencia = $usuarioActual->agenciau;
                $usuarios = DB::table('users')->where('rol', 'Thumano')->pluck('email');
                $talento = " de Talento Humano";
                foreach ($usuarios as $email) {
                    Mail::to($email)->send(new EnviarCorreo7($cedula, $talento, $agencia));
                    Mail::to('2803-axl@coopserp.com')->send(new EnviarCorreo7($cedula, $talento, $agencia));
                }
                 return back()->with("correcto", "Persona Registrada correctamente!")->with("showLoadingAlert", true);
             } else {
                 return back()->with("incorrecto", "Error al insertar el registro!");
             }
         }
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
                'message' => 'El archivo subido contiene un nombre diferente al archivo AUTORIZACIÓN ' . $nombre_archivo3 . ' actual (' . $nombre_archivo3 . ').\n'
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
                'message' => 'El archivo subido contiene un nombre diferente al archivo Cédula actual (' . $nombre_archivo4 . ').\n'
            ]);
        
        
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
                'message' => 'El archivo subido contiene un nombre diferente al archivo AUTORIZACIÓN ' . $nombre_archivo3 . ' actual (' . $nombre_archivo3 . ').\n'
            ]);
        
        }
        

        }else {
            if($request->Score == 'S/E'){
                $request->Score = 'S/E';
             }
                 elseif
                 ($request->Score > 950) {
                    $request->Score = 950;
                }
            if($request->Consulta == true){
            $sql7 = DB::update("UPDATE persona SET Nombre =?, Apellidos = ?, Inspektor = ?, Enviado = ?, Consulta = ?  WHERE ID = $id", [
                $request->nombre3,
                $request->apellidos3,
                $request->Inspektor2,
                1,
                1
            ]);
        }else{
            $sql6 = DB::update("UPDATE persona SET Nombre =?, Apellidos = ?, Inspektor = ?, Enviado = ?, Consulta = ?  WHERE ID = $id", [
                $request->nombre3,
                $request->apellidos3,
                $request->Inspektor2,
                0,
                0
            ]);  

        }

            $dir3 = 'Storage/files/autorizacion/';
            if ($request->hasFile('archivo3') && !empty($filename3)) {
                $file3 = $request->file('archivo3');

          
                if ($file3->getClientOriginalExtension() === 'pdf') {
                    $uploadSuccess = $file3->move($dir3, $filename3);
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            }

            $dir4 = 'Storage/files/cedula/';
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


            

            if ($request->contrato1 != null) {
                $sql3 = DB::update("UPDATE documentoa SET NombreContrato = ? WHERE ID_Persona = $id", [
                    $nuevo_archivo4
                ]);
            }

            if ($request->hasFile('archivo3')) {
                $sql5 = DB::update("UPDATE documentoa SET ConsecutivoA = ?, NombreA = ? WHERE ID_Persona = $id", [
                    $request->consecutivof33,
                    $nuevo_archivo3
                ]);
            } else {
                $sql5 = DB::update("UPDATE documentoa SET ConsecutivoA = ? WHERE ID_Persona = $id", [
                    $request->consecutivof33
                ]);
            }

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

            if ($request->Tipoasociado == true) {
                $sql4 = DB::update("UPDATE persona SET Tipo = ?, TipoAsociado = ? WHERE ID = $id", [
                    'Empleado',
                    'Empleado'
                ]);
            }

            if(isset($sql4) && $sql4 == true) {
                $persona = DB::selectOne('SELECT Nombre, Apellidos FROM persona WHERE ID = ?', [$id]);
                $nombreUsuario = $persona ? ucfirst(strtolower($persona->Nombre)) . ' ' . $persona->Apellidos : '';
                $recibo = $request->recibo;
                $cedulaRegistrada = DB::select("SELECT Cedula FROM persona WHERE ID = $id");
                $cedula = $cedulaRegistrada[0]->Cedula;
                $agencia = $usuarioActual->agenciau;  
                $usuarios = DB::table('users')->where('rol', 'Asociacion')->pluck('email');
                foreach ($usuarios as $email) {
                    Mail::to($email)->send(new EnviarCorreo13($cedula, $nombreUsuario, $agencia));
                }
                Mail::to('2803-axl@coopserp.com')->send(new EnviarCorreo13($cedula, $nombreUsuario, $agencia));
                return back()->with("correcto", "El usuario " . ucwords($request->nombre3) . " " . strtoupper($request->apellidos3) . " con identificación $request->cedula2 puede visualizarlo en Asociados!");
            }
            else if ($sql == true || $sql2 = true || $sql5) {
                $persona = DB::selectOne('SELECT Nombre, Apellidos FROM persona WHERE ID = ?', [$id]);
                $nombreUsuario = $persona ? ucfirst(strtolower($persona->Nombre)) . ' ' . $persona->Apellidos : '';
                $recibo = $request->recibo;
                $cedulaRegistrada = DB::select("SELECT Cedula FROM persona WHERE ID = $id");
                $cedula = $cedulaRegistrada[0]->Cedula;
                $agencia = $usuarioActual->agenciau;  
                $usuarios = DB::table('users')->where('rol', 'Asociacion')->pluck('email');
                foreach ($usuarios as $email) {
                    Mail::to($email)->send(new EnviarCorreo13($cedula, $nombreUsuario, $agencia));
                }

                Mail::to('2803-axl@coopserp.com')->send(new EnviarCorreo13($cedula, $nombreUsuario, $agencia));
                return back()->with("correcto", "El usuario " . ucwords($request->nombre3) . " " . strtoupper($request->apellidos3) . " con identificación $request->cedula2 fue actualizado correctamente!");
            } else {
                return back()->with("incorrecto", "Error al modificar el registro!");
            }
        }
    }


    public function imprimir($id)
    {
        $sql=DB::select("SELECT persona.*, documentosintesis.FechaInsercion FROM persona 
        INNER JOIN documentosintesis ON persona.ID = documentosintesis.ID_persona 
        WHERE persona.ID = $id");

        $fpdf = new Fpdf('P','mm', 'A4');
        $fpdf = new Fpdf('P','mm', 'A4');
        $fpdf->AddPage("landscape");
        $x = 3; 
        $y = 3; 
        $w = $fpdf->GetPageWidth() - 150;
        $h = $fpdf->GetPageHeight() - 134; 
        $fpdf->Rect($x, $y, $w, $h, 'D');

        foreach ($sql as $resultado) {
            $fecha_actual = Carbon::now('America/Bogota');
            $fecha_string = $fecha_actual->format('d/m/Y');
            $fecha_insercion = Carbon::parse($resultado->FechaInsercion);
            $diferencia = $fecha_actual->diff($fecha_insercion);
        if ($diferencia->days <= 180) {
            $dias_restantes = 180 - $diferencia->days;
            $diferencia_str = "Vence " . ($dias_restantes == 1 ? "1 día" : "$dias_restantes días");
        } else {
            $diferencia_str = "Vencido";
        }

        //Cedula
        $fpdf->SetFont('Helvetica', 'B',30);
        $fpdf->Cell(85, 5, utf8_decode('DATACRÉDITO:'));
        $fpdf->SetFont('Helvetica', 'B',38);
        $fpdf->Cell(20, 5, $resultado->CuentaAsociada);
        $fpdf->Cell(20, 12,"");
        $fpdf->Ln();



        $fpdf->SetFont('Helvetica', 'B',20);
        $fpdf->Cell(26,5,utf8_decode('Cédula: '));
        $fpdf->SetFont('Helvetica', '',28);
        $fpdf->Cell(64.8,5,$resultado->Cedula);



        //Nombre
        $fpdf->Ln();
        $fpdf->SetFont('Helvetica', 'B',20);
        $fpdf->Cell(30,15,'Nombre: ');
        $fpdf->SetFont('Helvetica', '',20);
        $fpdf->Cell(60.5,15,mb_convert_case($resultado->Nombre, MB_CASE_TITLE, "UTF-8"));

        //Apellidos
        $fpdf->Ln();
        $fpdf->SetFont('Helvetica', 'B',20);
        $fpdf->Cell(35,5,'Apellidos: ');
        $fpdf->SetFont('Arial', '',20);
        $fpdf->Cell(70.5,5, strtoupper(utf8_decode($resultado->Apellidos)));

        //fecha
        $fpdf->Ln();
        $fpdf->SetFont('Helvetica', 'B',20);
        $fpdf->Cell(59,13.1,''.utf8_decode($diferencia_str));
        $fpdf->SetFont('Helvetica', '',20);


        //Cuenta Asociada
        $fpdf->SetFont('Helvetica', 'B',20);
        $fpdf->Cell(37,13,'Fecha Imp: ');
        $fpdf->SetFont('Helvetica', '',20);
        $fpdf->Cell(1,13, $fecha_string);

        //Score
        $fpdf->Ln();
        $fpdf->SetFont('Helvetica', 'B',31);
        $fpdf->Cell(35.7,8,'Score: ');
        $fpdf->SetFont('Helvetica', 'B',48);



        if ($resultado->Score >= 650) {
            if (!empty($resultado->Reporte)) {
                $fpdf->Cell(76, 8, $resultado->Score . "-" . $resultado->Reporte);
            } else {
                $fpdf->Cell(76, 8, $resultado->Score);
            }
            $fpdf->Ln();
        } else {
            if (!empty($resultado->Reporte)) {
                $fpdf->Cell(76, 8, $resultado->Score . "-" . $resultado->Reporte);
            } else {
                $fpdf->Cell(76, 8, $resultado->Score);
            }
            $fpdf->Ln();
        }



    
        
        
        $url_qr = 'Storage/files/temp/qr-'.$resultado->ID;
        
        QrCode::format('png')->generate('http://190.66.10.146/menu-datacredito/descargare-'.$id ,public_path('Storage/files/tickets/qr/QR-'.$id.'.png'));


            $fpdf->Image("Storage/files/tickets/qr/QR-".$id.".png", 15, 107, 90, 90);
        
        //QRcode::png($url_qr, 'Storage/temp/'.$nombre_archivo.'.png', QR_ECLEVEL_L, 5);
        
        
        // QrCode::format('png')->size(25)->generate('/asociacion')->save('Storage/files/temp/QR-'.$nombre_archivo);
        // Agregar código QR al PDF
        // $fpdf->Image('Storage/files/temp/QR-'.$nombre_archivo.'.png', 2, 105, 100, 100);
        // $fpdf->Image("Storage/files/tickets/qr/QR-".$id.".png", 15, 107, 90, 90);
        $fpdf->Ln();
        $fpdf->SetFont('Helvetica', 'B',48);
        $fpdf->Cell(72,40,'Agencia: ');
        $fpdf->SetFont('Helvetica', '',48);
        $fpdf->Cell(83,40, utf8_decode($resultado->Agencia));

        $fpdf->Output('I', 'Storage/files/tickets/Ticket-'.$resultado->Cedula.'.pdf');
        $fpdf->Output('F', 'Storage/files/tickets/Ticket-'.$resultado->Cedula.'.pdf');
        exit;
        
        }
    }

        public function data2(){
        $usuarioActual = Auth::user();
        $agenciaU = $usuarioActual->agenciau;
        $user = DB::select("
        SELECT DISTINCT A.ID, A.Inspektor, A.Observaciones, A.Cedula,A.FechaCorreo, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado, A.Tipo, A.Consulta,
        A.Reporte, B.FechaInsercion, B.NombreS, C.NombrePN,E.NombreA, D.Consecutivof, D.Tipof, D.NombreT, E.ConsecutivoA, E.NombreContrato
        FROM persona A 
        JOIN documentosintesis B ON A.ID = B.ID_Persona 
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona
        JOIN documentot D ON C.ID_Persona = D.ID_Persona  
        JOIN documentoa E ON D.ID_Persona = E.ID_Persona
        WHERE A.Activado = 1 && A.Tipo = 'NuevoEmpleado'  && A.Enviado = 0
        ORDER BY Nombre ASC");

        return datatables()->of($user)->toJson();
        


    }


    public function data3(){
        $usuarioActual = Auth::user();
        $agenciaU = $usuarioActual->agenciau;
        $user = DB::select("
        SELECT A.ID, A.Inspektor, A.Observaciones, A.Cedula, A.FechaCorreo, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado, A.Tipo, A.Consulta,
        A.Reporte, A.TipoProveedor, A.NombreAnalisis, A.ConsecutivoAnalisis, A.Monto, A.DeudaEsp, B.FechaInsercion, B.NombreS, C.NombrePN, P.NIT, P.NombreRC, P.ValorCompra, P.ValorAcumulado, P.RazonSocial,E.NombreA, E.ConsecutivoA
        FROM persona A 
        JOIN documentosintesis B ON A.ID = B.ID_Persona 
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona 
        JOIN documentoa E ON C.ID_Persona = E.ID_Persona
        JOIN proveedor P ON E.ID_Persona = P.ID_Persona 
        WHERE A.Activado = 1 && A.Tipo = 'Proveedor' && Enviado = 0  && A.Agencia = '$agenciaU'
        ORDER BY Nombre ASC
    ");
    
    return datatables()->of($user)->toJson();

    }


    public function createprov(Request $request)
    {
        $existingPerson = DB::select('SELECT * FROM persona WHERE Cedula = ?', [$request->Cedula]);
    
        if ($existingPerson == true) {
            return back()->with("incorrecto", "Persona con cc. $request->Cedula ya existe! Error al Registrar!");
        }
        $existingNIT = DB::select('SELECT * FROM proveedor WHERE NIT = ?', [$request->nit]);
        if ($existingNIT == true) {
            return back()->with("incorrecto", "Persona con NIT. $request->nit ya existe! Error al Registrar!");
        }
        
        else {
            if($request->Score == 'S/E'){
                $request->Score = 'S/E';
             }
                 elseif
                 ($request->Score > 950) {
                    $request->Score = 950;
                }
                date_default_timezone_set('America/Bogota');
                $fechaHoraActual = date('Y-m-d H:i:s');
                if ($request->tipo_persona == "PN") {
                $usuarioActual = Auth::user();
                $agenciaU = $usuarioActual->agenciau; 
                $sql = DB::insert('INSERT INTO persona (Cedula, Nombre, Apellidos, Score, CuentaAsociada, Agencia, Estado, Reporte, Tipo, Enviado, TipoProveedor, FechaCorreo, Inspektor) VALUES (?, ?, UPPER(?), ?, ?, ?, ?, ?, ?, ?, ?,?, ?)', [
                    $request->cedula,
                    $request->nombre,
                    $request->apellidos,
                    null,
                    null,
                    $agenciaU,
                    null,
                    null,
                    'Proveedor',
                    1,
                     $request->tipo_persona,
                     $fechaHoraActual,
                     $request->Inspektor
                     
                ]);
                $idPersona = DB::getPdo()->lastInsertId();
                if ($request->hasFile('NombreA') != null) {
                    $file4 = $request->file('NombreA');
                    $filename4 =  $file4->getClientOriginalName();
                    $archivo4 = DB::select("SELECT NombreA FROM documentoa WHERE NombreA = ?", [$filename4]);
        
                    if (!empty($archivo4)) {
                        $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM proveedor WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                        return back()->withErrors([
                            'message' => 'El archivo Autorización - "' . $filename4 . '" ya existe!'
                        ]);
                    }
                } 
                
                if ($request->hasFile('NombreRC') != null) {
                $file = $request->file('NombreRC');
                $filename =  $file->getClientOriginalName();
                $archivo = DB::select("SELECT NombreRC FROM proveedor WHERE NombreRC = ?", [$filename]);
    
                if (!empty($archivo)) {
                    $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM proveedor WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                    return back()->withErrors([
                        'message' => 'El archivo RECIBO DE CAJA - "' . $filename . '" ya existe!'
                    ]);
                }
            }
                

            
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
                    $request->FechaInsercion ?? null,
                    null,
                    $idPersona
                ]);
            }
                         if ($request->hasFile('NombreRC')) {
                 $file = $request->file('NombreRC');
                 $dir = 'Storage/files/rc/';
                 $filename =  $file->getClientOriginalName();
                 $extension = $file->getClientOriginalExtension();
             
                 
                 if ($extension === 'pdf') {
                     $uploadSucces = $request->file('NombreRC')->move($dir, $filename);
             
                     $sql2 = DB::insert('INSERT INTO proveedor (NombreRC, ValorCompra, ValorAcumulado, ID_Persona) VALUES (?, ?, ?, ?)', [
                        $filename ?? null, 
                        $request->valorcompra,
                        $request->valorcompra,
                         $idPersona
                     ]);
                     if ($file->getClientOriginalName() !== 'RC-' . $request->cedula . '.pdf') {
                        $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM proveedor WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                        if (file_exists($dir . $filename)) {
                            unlink($dir . $filename);
                        }
                        return back()->withErrors([
                            'message' => 'El nombre del archivo no cumple con el formato requerido ->RC-' . $request->cedula . '.pdf'
                        ]);
                    }
                 } else {
                    $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM proveedor WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                     return back()->withErrors([
                         'message' => 'Solo se puede subir archivos PDF.'
                     ]);
                 }
             } else {
                 $sql2 = DB::insert('INSERT INTO proveedor (NombreRC, ValorAcumulado, ValorCompra, ID_Persona) VALUES (?, ?, ?, ?)', [
                    null, 
                    $request->valorcompra,
                    $request->valorcompra,
                     $idPersona
                 ]);
             }

            if ($request->hasFile('NombreA')) {
                $file2 = $request->file('NombreA');
                if ($file2 != null) {
                    $dir2 = 'Storage/files/autorizacion/';
                    $filename2 =  $file2->getClientOriginalName();
                    $extension2 = $file2->getClientOriginalExtension();
        
                    if ($file2->getClientOriginalName() !== 'Autorizacion-' . $request->cedula . '.pdf') {
                        $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM proveedor WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                        return back()->withErrors([
                            'message' => 'El nombre del archivo no cumple con el formato requerido ->Autorizacion-' . $request->cedula . '.pdf'
                        ]);
                    }
                    if ($extension2 === 'pdf') {
                        $uploadSucces2 = $request->file('NombreA')->move($dir2, $filename2);
                        $sql4 = DB::insert('INSERT INTO documentoa (NombreA, ConsecutivoA, NombreContrato, ID_Persona) VALUES (?, ?, ?, ?)', [
                            $filename2 ?? null,
                            $request->consecutivoa,
                            null,
                            $idPersona
                        ]);
                    } else {
                        $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM proveedor WHERE ID_Persona=$idPersona", []);
                        $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
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
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
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
        }else if($request->tipo_persona == "PJ"){
            date_default_timezone_set('America/Bogota');
            $fechaHoraActual = date('Y-m-d H:i:s');
            $usuarioActual = Auth::user();
            $agenciaU = $usuarioActual->agenciau; 
            $sql = DB::insert('INSERT INTO persona (Cedula, Nombre, Apellidos, Score, CuentaAsociada, Agencia, Estado, Reporte, Tipo, Enviado, TipoProveedor, FechaCorreo) VALUES (?, ?, UPPER(?), ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                null,
                null,
                null,
                null,
                null,
                $agenciaU,
                null,
                null,
                'Proveedor',
                1,
                 $request->tipo_persona,
                 $fechaHoraActual
            ]);
            $idPersona = DB::getPdo()->lastInsertId();
            if ($request->hasFile('NombreA') != null) {
                $file4 = $request->file('NombreA');
                $filename4 =  $file4->getClientOriginalName();
                $archivo4 = DB::select("SELECT NombreA FROM documentoa WHERE NombreA = ?", [$filename4]);
    
                if (!empty($archivo4)) {
                    $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM proveedor WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                    return back()->withErrors([
                        'message' => 'El archivo Autorización - "' . $filename4 . '" ya existe!'
                    ]);
                }
            } 
            
            if ($request->hasFile('NombreRC') != null) {
            $file = $request->file('NombreRC');
            $filename =  $file->getClientOriginalName();
            $archivo = DB::select("SELECT NombreRC FROM proveedor WHERE NombreRC = ?", [$filename]);

            if (!empty($archivo)) {
                $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                $sql4 = DB::update("DELETE FROM proveedor WHERE ID_Persona=$idPersona", []);
                $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                return back()->withErrors([
                    'message' => 'El archivo RECIBO DE CAJA - "' . $filename . '" ya existe!'
                ]);
            }
        }
            

        
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
                $request->FechaInsercion ?? null,
                null,
                $idPersona
            ]);
        }
                     if ($request->hasFile('NombreRC')) {
             $file = $request->file('NombreRC');
             $dir = 'Storage/files/rc/';
             $filename =  $file->getClientOriginalName();
             $extension = $file->getClientOriginalExtension();
         
             
             if ($extension === 'pdf') {
                 $uploadSucces = $request->file('NombreRC')->move($dir, $filename);
         
                 $sql2 = DB::insert('INSERT INTO proveedor (NombreRC, NIT, RazonSocial, ValorCompra, ValorAcumulado, ID_Persona) VALUES (?, ?, ?, ?, ?, ?)', [

                    $filename ?? null, 
                    $request->nit,
                    $request->razonSocial,
                    $request->valorcompra,
                    $request->valorcompra,
                     $idPersona
                 ]);
                 if ($file->getClientOriginalName() !== 'RC-' . $request->nit . '.pdf') {
                    $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM proveedor WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                    if (file_exists($dir . $filename)) {
                        unlink($dir . $filename);
                    }
                    return back()->withErrors([
                        'message' => 'El nombre del archivo no cumple con el formato requerido ->RC-' . $request->nit . '.pdf'
                    ]);
                }
             } else {
                $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                $sql4 = DB::update("DELETE FROM proveedor WHERE ID_Persona=$idPersona", []);
                $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                 return back()->withErrors([
                     'message' => 'Solo se puede subir archivos PDF.'
                 ]);
             }
         } else {
             $sql2 = DB::insert('INSERT INTO proveedor (NombreRC, NIT, RazonSocial, ValorCompra, ValorAcumulado, ID_Persona) VALUES (?, ?, ?, ?, ? ,?)', [
                null, 
                $request->nit,
                $request->razonSocial,
                $request->valorcompra,
                $request->valorcompra,
                 $idPersona
             ]);
         }

        if ($request->hasFile('NombreA')) {
            $file2 = $request->file('NombreA');
            if ($file2 != null) {
                $dir2 = 'Storage/files/autorizacion/';
                $filename2 =  $file2->getClientOriginalName();
                $extension2 = $file2->getClientOriginalExtension();
    
                if ($file2->getClientOriginalName() !== 'Autorizacion-' . $request->nit . '.pdf') {
                    $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM proveedor WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
                    return back()->withErrors([
                        'message' => 'El nombre del archivo no cumple con el formato requerido ->Autorizacion-' . $request->cedula . '.pdf'
                    ]);
                }
                if ($extension2 === 'pdf') {
                    $uploadSucces2 = $request->file('NombreA')->move($dir2, $filename2);
                    $sql4 = DB::insert('INSERT INTO documentoa (NombreA, ConsecutivoA, NombreContrato, ID_Persona) VALUES (?, ?, ?, ?)', [
                        $filename2 ?? null,
                        $request->consecutivoa,
                        null,
                        $idPersona
                    ]);
                } else {
                    $sql4 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM proveedor WHERE ID_Persona=$idPersona", []);
                    $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
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
                $sql4 = DB::update("DELETE FROM persona WHERE ID=$idPersona", []);
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
        }
            
    
        
        
            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;
            $cedulaagregada = $request->Cedula;
            date_default_timezone_set('America/Bogota');
            $ip = $_SERVER['REMOTE_ADDR'];
            $fechaHoraActual = date('Y-m-d H:i:s');
$agencia = $usuarioActual->agenciau;                  
$login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'CreoProveedor', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                $cedulaagregada,
                null,
                $ip
            ]);
            if ($sql && $sql4) {
                if($request->tipo_persona == 'PN'){
                $cedula = $request->cedula;
                $usuarios = DB::table('users')->where('rol', 'Thumano')->pluck('email');
                $usuarioActual = Auth::user();
                $agencia = $usuarioActual->agenciau;    
                $talento = " de Talento Humano";
                foreach ($usuarios as $email) {
                    Mail::to($email)->send(new EnviarCorreo6($cedula, $talento, $agencia));
                }
            }else{
                $nit = $request->nit;
                $razon = $request->razonSocial;
                $usuarios = DB::table('users')->where('rol', 'Thumano')->pluck('email');
                $usuarioActual = Auth::user();
                $agencia = $usuarioActual->agenciau;  
                $talento = " de Talento Humano";
                foreach ($usuarios as $email) {
                    Mail::to($email)->send(new EnviarCorreo5($nit, $talento, $razon, $agencia));
                }
            }
                return back()->with("correcto2", "Persona Registrada correctamente!")->with("showLoadingAlert", true);
            } else {
                return back()->with("incorrecto", "Error al insertar el registro!");
            }
            
        }
    }


    public function updateprov(Request $request, $id)
    {
 
     $archivo4 = DB::select("SELECT NombreRC FROM proveedor WHERE ID_Persona = ?", [$id]);
     $nombre_archivo4 = $archivo4[0]->NombreRC;
     $filename4 = $nombre_archivo4;
     if ($archivo4) {
         $nombre_archivo4 = $archivo4[0]->NombreRC;
         if ($request->hasFile('archivo4')) {
             $file4 = $request->file('archivo4');
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
             'message' => 'El archivo subido contiene un nombre diferente al archivo RECIBO DE CAJA -> ' . $nombre_archivo4 . ' actual (' . $nombre_archivo4 . ').\n'
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
             'message' => 'El archivo subido contiene un nombre diferente al archivo AUTORIZACIÓN -> ' . $nombre_archivo3 . ' actual (' . $nombre_archivo3 . ').\n'
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
 
             if ($request->hasFile('archivo3') != null) {
                 $file = $request->file('archivo3');
                 $filename =  $file->getClientOriginalName();
                 $archivo = DB::select("SELECT NombreA FROM documentoa WHERE NombreA = ?", [$filename]);
             
                 if (!empty($archivo)) {
                     return back()->withErrors([
                         'message' => 'El archivo Autorización - "' . $filename . '" ya existe!'
                     ]);
                 }
             }
     
             if ($request->hasFile('archivo4') != null) {
                 $file4 = $request->file('archivo4');
                 $filename4 =  $file4->getClientOriginalName();
                 $archivo4 = DB::select("SELECT NombreRC FROM proveedor WHERE NombreRC = ?", [$filename4]);
             
                 if (!empty($archivo4)) {
                     return back()->withErrors([
                         'message' => 'El archivo Recibo de Caja - "' . $filename4 . '" ya existe!'
                     ]);
               
             }
         }
 
         $tipo = DB::select("SELECT TipoProveedor FROM persona WHERE ID = ?",[$id]);
         $tipoproveedor = $tipo[0]->TipoProveedor;
 
         if($tipoproveedor == "PN"){
 
             $sql = DB::update("UPDATE persona SET Cedula=?, Nombre =?, Apellidos = ?, Agencia = ?, Inspektor =?  WHERE ID = $id", [
                 $request->cedula2,
                 $request->nombre3,
                 $request->apellidos3,
                 $request->agencia3,
                 $request->Inspektor3,
             ]);
 
 
             $proveedor = DB::select("SELECT ValorAcumulado FROM proveedor WHERE ID_Persona = ?", [$id]);
             $valorAcumuladoActual = $proveedor[0]->ValorAcumulado;
 
             $nuevoValorCompra = $request->valorcompra1;
 
             $nuevoValorAcumulado = $valorAcumuladoActual + $nuevoValorCompra;
             
             $dir4 = 'Storage/files/rc/';
             if ($request->hasFile('archivo4') && !empty($filename4)) {
                 $file4 = $request->file('archivo4');
                 if ($file4->getClientOriginalName() !== 'Autorizacion-' . $request->cedula2 . '.pdf') {
                     return back()->withErrors([
                         'message' => 'El nombre del archivo no cumple con el formato requerido ->Autorizacion-' . $request->cedula2 . '.pdf'
                     ]);
                 }
                 if ($file4->getClientOriginalExtension() === 'pdf') {
                     $uploadSuccess = $file4->move($dir4, $filename4);
                 } else {
                     return back()->withErrors([
                         'message' => 'Solo se puede subir archivos PDF.'
                     ]);
                 }
             }
             if ($request->hasFile('archivo4')) {
                 $sql5 = DB::update("UPDATE proveedor SET ValorCompra = ?, ValorAcumulado = ?, NombreRC = ? WHERE ID_Persona = $id", [
                     $request->valorcompra1,
                     $nuevoValorAcumulado,
                     $nuevo_archivo4
                 ]);
             } else {
                 $sql5 = DB::update("UPDATE proveedor SET ValorCompra = ?, ValorAcumulado = ?, NombreRC = ? WHERE ID_Persona = $id", [
                     $request->valorcompra1,
                     $nuevoValorAcumulado,
                     null
                 ]);
             }
             
 
 
             $dir = 'Storage/files/autorizacion/';
             if ($request->hasFile('archivo3') && !empty($filename)) {
                 $file = $request->file('archivo3');
                 if ($file->getClientOriginalName() !== 'Autorizacion-' . $request->cedula2 . '.pdf') {
                     return back()->withErrors([
                         'message' => 'El nombre del archivo no cumple con el formato requerido ->Autorizacion-' . $request->cedula2 . '.pdf'
                     ]);
                 }
                 if ($file->getClientOriginalExtension() === 'pdf') {
                     $uploadSuccess = $file->move($dir, $filename);
                 } else {
                     return back()->withErrors([
                         'message' => 'Solo se puede subir archivos PDF.'
                     ]);
                 }
             }
                if ($request->hasFile('archivo3')) {
                    $sql5 = DB::update("UPDATE documentoa SET ConsecutivoA = ?, NombreA = ? WHERE ID_Persona = $id", [
                        $request->consecutivoa44,
                        $nuevo_archivo3
                    ]);
                } else {
                    $sql5 = DB::update("UPDATE documentoa SET ConsecutivoA = ? WHERE ID_Persona = $id", [
                        $request->consecutivoa44
                    ]);
                }
        }else{
                 $sql = DB::update("UPDATE persona SET Agencia = ?, Inspektor = ?  WHERE ID = $id", [
                     $request->agencia4,
                     $request->Inspektor2,
                 ]);
     
     
                 $proveedor = DB::select("SELECT ValorAcumulado FROM proveedor WHERE ID_Persona = ?", [$id]);
                 $valorAcumuladoActual = $proveedor[0]->ValorAcumulado;
     
                 $nuevoValorCompra = $request->valorcompra2;
     
                 $nuevoValorAcumulado = $valorAcumuladoActual + $nuevoValorCompra;
                 
                 $dir4 = 'Storage/files/rc/';
                 if ($request->hasFile('archivo4') && !empty($filename4)) {
                     $file4 = $request->file('archivo4');
                     if ($file4->getClientOriginalName() !== 'RC-' . $request->nit2 . '.pdf') {
                         return back()->withErrors([
                             'message' => 'El nombre del archivo no cumple con el formato requerido ->RC-' . $request->nit2 . '.pdf'
                         ]);
                     }
      
                     if ($file4->getClientOriginalExtension() === 'pdf') {
                         $uploadSuccess = $file4->move($dir4, $filename4);
                     } else {
                         return back()->withErrors([
                             'message' => 'Solo se puede subir archivos PDF.'
                         ]);
                     }
                 }
                 if ($request->hasFile('archivo4')) {
                     $sql2 = DB::update("UPDATE proveedor SET NIT = ?, RazonSocial = ?, ValorCompra = ?, ValorAcumulado = ?, NombreRC = ? WHERE ID_Persona = $id", [
                         $request->nit2,
                         $request->razonsocial2,
                         $request->valorcompra2,
                         $nuevoValorAcumulado,
                         $nuevo_archivo4
                     ]);
                 } else {
                     $sql2 = DB::update("UPDATE proveedor SET NIT = ?, RazonSocial = ?, ValorCompra = ?, ValorAcumulado = ?, NombreRC = ? WHERE ID_Persona = $id", [
                         $request->nit2,
                         $request->razonsocial2,
                         $request->valorcompra2,
                         $nuevoValorAcumulado,
                         null
                     ]);
                 }
                 
     
     
                 $dir = 'Storage/files/autorizacion/';
                 if ($request->hasFile('archivo3') && !empty($filename)) {
                     $file = $request->file('archivo3');
                     if ($file->getClientOriginalName() !== 'Autorizacion-' . $request->nit2 . '.pdf') {
                         return back()->withErrors([
                             'message' => 'El nombre del archivo no cumple con el formato requerido ->Autorizacion-' . $request->nit2 . '.pdf'
                         ]);
                     }
      
                     if ($file->getClientOriginalExtension() === 'pdf') {
                         $uploadSuccess = $file->move($dir, $filename);
                     } else {
                         return back()->withErrors([
                             'message' => 'Solo se puede subir archivos PDF.'
                         ]);
                     }
                 }
                    if ($request->hasFile('archivo3')) {
                        $sql5 = DB::update("UPDATE documentoa SET ConsecutivoA = ?, NombreA = ? WHERE ID_Persona = $id", [
                            $request->consecutivoa33,
                            $nuevo_archivo3
                        ]);
                    } else {
                        $sql5 = DB::update("UPDATE documentoa SET ConsecutivoA = ? WHERE ID_Persona = $id", [
                            $request->consecutivoa33
                        ]);
                    }
             }
 
 
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
            if ($request->Consulta == true) {
                $sql4 = DB::update("UPDATE persona SET Consulta = ? WHERE ID = $id", [
                    1
                ]);
            }
            if(isset($sql4) && $sql4 == true) {
                $persona = DB::selectOne('SELECT Nombre, Apellidos FROM persona WHERE ID = ?', [$id]);
                $nombreUsuario = $persona ? ucfirst(strtolower($persona->Nombre)) . ' ' . $persona->Apellidos : '';
                $recibo = $request->recibo;
                $cedulaRegistrada = DB::select("SELECT Cedula FROM persona WHERE ID = $id");
                $cedula = $cedulaRegistrada[0]->Cedula;
                $usuarios = DB::table('users')->where('rol', 'Thumano')->pluck('email');
                foreach ($usuarios as $email) {
                    Mail::to($email)->send(new EnviarCorreo3($cedula, $nombreUsuario, $recibo));
                }
                if($tipoproveedor == 'PN'){
                return back()->with("correcto", "El usuario " . ucwords($request->nombre3) . " " . strtoupper($request->apellidos3) . " con identificación $request->cedula2 puede ser consultado!");
                }else{
                 return back()->with("correcto", "El usuario con razón social " . ucwords($request->razonsocial2) . " con NIT # $request->nit2 puede ser consultado!");
                }
            }
            else if ($sql == true || $sql2 = true || $sql5 = true) {
             if($tipoproveedor == 'PN'){
                 
                 return back()->with("correcto", "El usuario " . ucwords($request->nombre3) . " " . strtoupper($request->apellidos3) . " con identificación $request->cedula2 fue actualizado correctamente!");
                }
                else{
                    return back()->with("correcto", "La persona con razón social " . ucwords($request->razonsocial2) . " con NIT # $request->nit2 fue actualizado correctamente!");
                }
            } else {
                return back()->with("incorrecto", "Error al modificar el registro!");
            }
            
        }
    }
    

    public function data4(){
        $usuarioActual = Auth::user();
        $agenciaU = $usuarioActual->agenciau;
        $user = DB::select("
        SELECT A.ID, A.Cedula, A.FechaCorreo, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado, A.Tipo, A.Consulta,
        A.Reporte, A.TipoProveedor, A.NombreAnalisis, A.ConsecutivoAnalisis, A.Monto, A.DeudaEsp, B.FechaInsercion, B.NombreS, C.NombrePN, P.NIT, P.NombreRC, P.ValorCompra, P.ValorAcumulado, P.RazonSocial,E.NombreA, E.ConsecutivoA
        FROM persona A 
        JOIN documentosintesis B ON A.ID = B.ID_Persona 
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona 
        JOIN documentoa E ON C.ID_Persona = E.ID_Persona
        JOIN proveedor P ON E.ID_Persona = P.ID_Persona 
        WHERE A.Activado = 1 && A.Tipo = 'Proveedor' && Enviado = 0  && A.Agencia = '$agenciaU'
        ORDER BY Nombre ASC
    ");

        return datatables()->of($user)->toJson();


    }
}
