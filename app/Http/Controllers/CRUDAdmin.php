<?php

namespace App\Http\Controllers;

use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CRUDAdmin extends Controller
{

    public function data(){
        $user = DB::select("
        SELECT A.ID, A.Cedula, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Tipo, A.TipoAsociado,
        A.Reporte, A.Monto, A.NombreAnalisis, A.ConsecutivoAnalisis, A.DeudaEsp, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT, E.NombreA, E.ConsecutivoA, E.NombreContrato
        FROM persona A 
        JOIN documentosintesis B ON A.ID = B.ID_Persona 
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona 
        JOIN documentot D ON C.ID_Persona = D.ID_Persona
        JOIN documentoa E ON D.ID_Persona = E.ID_Persona
        WHERE A.Activado = 1 && A.Tipo = 'Persona'
        ORDER BY Nombre ASC");
        



        return datatables()->of($user)->toJson();
        


    }

   


    public function view()
    {
        $datos = DB::select("
        SELECT A.ID, A.Cedula, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado,
        A.Reporte, A.Monto, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT 
        FROM persona
        A JOIN documentosintesis B ON A.ID = B.ID_Persona JOIN documentopn C ON B.ID_Persona = C.ID_Persona JOIN documentot
        D ON C.ID_Persona = D.ID_Persona ORDER BY Nombre ASC");
        $datos2 = DB::select("SELECT * FROM users");
        


        return view("Admin/datacredito", compact("datos","datos2"));
    }

    public function view6()
    {
        $datos = DB::select("
        SELECT A.ID, A.Cedula, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado,
        A.Reporte, A.Monto, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT 
        FROM persona
        A JOIN documentosintesis B ON A.ID = B.ID_Persona JOIN documentopn C ON B.ID_Persona = C.ID_Persona JOIN documentot
        D ON C.ID_Persona = D.ID_Persona ORDER BY Nombre ASC");
        $datos2 = DB::select("SELECT * FROM users");
        


        return view("Admin/proveedor", compact("datos","datos2"));
    }

    public function view4()
    {
        $datos = DB::select("
        SELECT A.ID, A.Cedula, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado,
        A.Reporte, A.Monto, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT 
        FROM persona
        A JOIN documentosintesis B ON A.ID = B.ID_Persona JOIN documentopn C ON B.ID_Persona = C.ID_Persona JOIN documentot
        D ON C.ID_Persona = D.ID_Persona ORDER BY Nombre ASC");
        $datos2 = DB::select("SELECT * FROM users");
        


        return view("Admin/eliminadose", compact("datos","datos2"));
    }


    public function view5()
    {
        $datos = DB::select("
        SELECT A.ID, A.Cedula, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado,
        A.Reporte, A.Monto, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT 
        FROM persona
        A JOIN documentosintesis B ON A.ID = B.ID_Persona JOIN documentopn C ON B.ID_Persona = C.ID_Persona JOIN documentot
        D ON C.ID_Persona = D.ID_Persona ORDER BY Nombre ASC");
        $datos2 = DB::select("SELECT * FROM users");
        


        return view("Admin/eliminadosp", compact("datos","datos2"));
    }
    public function data4(){
        $user = DB::select("
        SELECT A.ID, A.Inspektor, A.Observaciones, A.Cedula,A.FechaCorreo, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado, A.Tipo, A.Consulta,
        A.Reporte, B.FechaInsercion, B.NombreS, C.NombrePN,E.NombreA, D.Consecutivof, D.Tipof, D.NombreT, E.ConsecutivoA, E.NombreContrato
        FROM persona A 
        JOIN documentosintesis B ON A.ID = B.ID_Persona 
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona
        JOIN documentot D ON C.ID_Persona = D.ID_Persona  
        JOIN documentoa E ON D.ID_Persona = E.ID_Persona
        WHERE A.Activado = 0 && A.TipoAsociado = 'NuevoEmpleado' && A.Tipo = 'NuevoEmpleado'  && A.Enviado = 0
        ORDER BY Nombre ASC");

        return datatables()->of($user)->toJson();


    }


    public function data5(){
        $user = DB::select("
        SELECT A.ID, A.Inspektor, A.Cedula, A.FechaCorreo, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado, A.Tipo, A.Consulta,
        A.Reporte, A.TipoProveedor,A.Observaciones, A.NombreAnalisis, A.ConsecutivoAnalisis, A.Monto, A.DeudaEsp, B.FechaInsercion, B.NombreS, C.NombrePN, P.NIT, P.NombreRC, P.ValorCompra, P.ValorAcumulado, P.RazonSocial ,E.NombreA, E.ConsecutivoA
        FROM persona A 
        JOIN documentosintesis B ON A.ID = B.ID_Persona 
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona 
        JOIN documentoa E ON C.ID_Persona = E.ID_Persona
        JOIN proveedor P ON E.ID_Persona = P.ID_Persona 
        WHERE A.Activado = 0 && A.Tipo = 'Proveedor'
        ORDER BY Nombre ASC
    ");

        return datatables()->of($user)->toJson();


    }


    public function data6(){
        $user = DB::select("
        SELECT A.ID, A.Inspektor, A.Cedula, A.FechaCorreo, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado, A.Tipo, A.Consulta,
        A.Reporte, A.TipoProveedor,A.Observaciones, A.NombreAnalisis, A.ConsecutivoAnalisis, A.Monto, A.DeudaEsp, B.FechaInsercion, B.NombreS, C.NombrePN, P.NIT, P.NombreRC, P.ValorCompra, P.ValorAcumulado, P.RazonSocial ,E.NombreA, E.ConsecutivoA
        FROM persona A 
        JOIN documentosintesis B ON A.ID = B.ID_Persona 
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona 
        JOIN documentoa E ON C.ID_Persona = E.ID_Persona
        JOIN proveedor P ON E.ID_Persona = P.ID_Persona 
        WHERE A.Activado = 1 && A.Tipo = 'Proveedor'
        ORDER BY Nombre ASC
    ");

        return datatables()->of($user)->toJson();


    }

    public function data2(){
        $user = DB::select("
        SELECT A.ID, A.Cedula, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Tipo, A.TipoAsociado,
        A.Reporte, A.Monto, A.NombreAnalisis, A.ConsecutivoAnalisis, A.DeudaEsp, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT, E.NombreA, E.ConsecutivoA, E.NombreContrato
        FROM persona A 
        JOIN documentosintesis B ON A.ID = B.ID_Persona 
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona 
        JOIN documentot D ON C.ID_Persona = D.ID_Persona
        JOIN documentoa E ON D.ID_Persona = E.ID_Persona
        WHERE A.Activado = 0
        ORDER BY Nombre ASC");

        return datatables()->of($user)->toJson();


    }

    public function view2()
    {
        $datos = DB::select("
        SELECT A.ID, A.Cedula, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado,
        A.Reporte, A.Monto, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT 
        FROM persona
        A JOIN documentosintesis B ON A.ID = B.ID_Persona JOIN documentopn C ON B.ID_Persona = C.ID_Persona JOIN documentot
        D ON C.ID_Persona = D.ID_Persona ORDER BY Nombre ASC");
        $datos2 = DB::select("SELECT * FROM users");
        
        return view("Admin/eliminados", compact("datos","datos2"));
    }

    public function view3()
    {
        $datos = DB::select("
        SELECT A.ID, A.Cedula, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado,
        A.Reporte, A.Monto, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT 
        FROM persona
        A JOIN documentosintesis B ON A.ID = B.ID_Persona JOIN documentopn C ON B.ID_Persona = C.ID_Persona JOIN documentot
        D ON C.ID_Persona = D.ID_Persona ORDER BY Nombre ASC");
        $datos2 = DB::select("SELECT * FROM users");
        
        return view("Admin/empleados", compact("datos","datos2"));
    }


    //registrar
    public function create(Request $request)
    {
        $existingPerson = DB::select('SELECT * FROM persona WHERE Cedula = ?', [$request->Cedula]);

        if ($existingPerson == true) {
            return back()->with("incorrecto", "Persona con cc. $request->Cedula ya existe! Error al Registrar!");
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

            if ($request->hasFile('NombreT') != null) {
                $file3 = $request->file('NombreT');
                $filename3 =  $file3->getClientOriginalName();
                $archivo3 = DB::select("SELECT NombreT FROM documentot WHERE NombreT = ?", [$filename3]);
            }
                if (!empty($archivo3)) {
                    return back()->withErrors([
                        'message' => 'El archivo con Formato '.$request->Tipof.' - "' . $filename3 . '" ya existe!'
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



                
            $sql = DB::insert('INSERT INTO persona (Cedula, Nombre, Apellidos, Score, CuentaAsociada, Agencia, Estado, Reporte, Tipo) VALUES (?, ?, UPPER(?), ?, ?, ?, ?, ?, ?)', [
                $request->Cedula,
                $request->Nombre,
                $request->Apellidos,
                $request->Score,
                $request->CuentaAsociada,
                $request->Agencia,
                $request->Estado,
                $request->Reporte,
                'Persona'
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
                    } elseif ($request->Tipof == "T2") {
                        $dir3 = "Storage/files/t2/";
                        $ruta_carga3 = $dir3 . $file->getClientOriginalName();
                    }
            
                    if ($request->Tipof != "N/A") {
                        $uploadSucces = $file->move($dir3, $ruta_carga3);
                    }
            
                    $sql4 = DB::insert('INSERT INTO documentot (NombreT, Consecutivof, Tipof, ID_Persona) VALUES (?, ?, ?, ?)', [
                        $filename2 ?? null,
                        $request->Consecutivof,
                        $request->Tipof,
                        $idPersona
                    ]);
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            } else {
                $sql4 = DB::insert('INSERT INTO documentot (NombreT, Consecutivof, Tipof, ID_Persona) VALUES (?, ?, ?, ?)', [
                    null,
                    $request->Consecutivof,
                    $request->Tipof,
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
$login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'CreoUsuario', ?, ?, ?, ?)", [
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

            if($request->Score == 'S/E'){
                $request->Score = 'S/E';
             }
                 elseif
                 ($request->Score > 950) {
                    $request->Score = 950;
                }


                if ($request->hasFile('archivo22') != null) {
                    $file3 = $request->file('archivo22');
                    $filename3 =  $file3->getClientOriginalName();
                    $archivo3 = DB::select("SELECT NombreS FROM documentosintesis WHERE NombreS = ?", [$filename3]);
                }
                    if (!empty($archivo3)) {
                        return back()->withErrors([
                            'message' => 'El archivo Síntesis ' . $filename3 . '" ya existe!'
                        ]);
                        
                    
                }

                if ($request->hasFile('archivo11') != null) {
                    $file3 = $request->file('archivo11');
                    $filename3 =  $file3->getClientOriginalName();
                    $archivo3 = DB::select("SELECT NombrePN FROM documentopn WHERE NombrePN = ?", [$filename3]);
                }
                    if (!empty($archivo3)) {
                        return back()->withErrors([
                            'message' => 'El archivo PN ' . $filename3 . '" ya existe!'
                        ]);
                        
                    
                }


                if ($request->hasFile('archivo33') != null) {
                    $file3 = $request->file('archivo33');
                    $filename3 =  $file3->getClientOriginalName();
                    $archivo3 = DB::select("SELECT NombreT FROM documentot WHERE NombreT = ?", [$filename3]);
                }
                    if (!empty($archivo3)) {
                        return back()->withErrors([
                            'message' => 'El archivo con Formato '.$request->Tipof.' - "' . $filename3 . '" ya existe!'
                        ]);
                        
                    
                }

                if ($request->hasFile('archivo55') != null) {
                    $file3 = $request->file('archivo55');
                    $filename3 =  $file3->getClientOriginalName();
                    $archivo3 = DB::select("SELECT NombreAnalisis FROM persona WHERE NombreAnalisis = ?", [$filename3]);
                }
                    if (!empty($archivo3)) {
                        return back()->withErrors([
                            'message' => 'El archivo Análisis ' . $filename3 . '" ya existe!'
                        ]);
                        
                    
                }



                if ($request->hasFile('archivo22')) {
                    $file = $request->file('archivo22');
                    $dir = 'Storage/files/sintesis/';
                    $filename =  $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                
                    
                    if ($file->getClientOriginalExtension() === 'pdf') {
                        $uploadSucces = $request->file('archivo22')->move($dir, $filename);
                        $sql = DB::select("SELECT NombreS FROM documentosintesis WHERE ID_Persona=$id");
                        $filename = $sql[0]->NombreS;
                        if ($filename != null) {
                            $file_path = 'Storage/files/sintesis/' . $filename;
                            if (file_exists($file_path)) {
                                unlink($file_path);
                            }
                        }
                    } else {
                        return back()->withErrors([
                            'message' => 'Solo se puede subir archivos PDF.'
                        ]);
                    }
                }
                if ($request->hasFile('archivo22')) {
                    $file2 = $request->file('archivo22');
                    $filenamesin =  $file2->getClientOriginalName();
                }
    
                 
    
                if ($request->hasFile('archivo22')) {
                    $sql2 = DB::update("UPDATE documentosintesis SET FechaInsercion = ?, NombreS = ? WHERE ID_Persona = $id", [
                        $request->fecha3,
                        $filenamesin
                    ]);
                } else {
                    $sql2 = DB::update("UPDATE documentosintesis SET FechaInsercion = ? WHERE ID_Persona = $id", [
                        $request->fecha3
                    ]);
                }
    
    
    
                if ($request->hasFile('archivo11')) {
                    $file = $request->file('archivo11');
                    $dir = 'Storage/files/pn/';
                    $filename =  $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                
                    
                    if ($file->getClientOriginalExtension() === 'pdf') {
                        $uploadSucces = $request->file('archivo11')->move($dir, $filename);
                        $sql = DB::select("SELECT NombrePN FROM documentopn WHERE ID_Persona=$id");
                        $filename = $sql[0]->NombrePN;
                        if ($filename != null) {
                            $file_path = 'Storage/files/pn/' . $filename;
                            if (file_exists($file_path)) {
                                unlink($file_path);
                            }
                        }
                    } else {
                        return back()->withErrors([
                            'message' => 'Solo se puede subir archivos PDF.'
                        ]);
                    }
                }
                if ($request->hasFile('archivo11')) {
                    $file2 = $request->file('archivo11');
                    $filenamepn =  $file2->getClientOriginalName();
                }
                if ($request->archivo11 != null) {
                    $sql3 = DB::update("UPDATE documentopn SET NombrePN = ? WHERE ID_Persona = $id", [
                        $filenamepn
                    ]);
                }
    
    
                if ($request->hasFile('archivo55')) {
                    $file = $request->file('archivo55');
                    $dir = 'Storage/files/analisis/';
                    $filename =  $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                
                    
                    if ($file->getClientOriginalExtension() === 'pdf') {
                        $uploadSucces = $request->file('archivo55')->move($dir, $filename);
                        $sql = DB::select("SELECT NombreAnalisis FROM persona WHERE ID=$id");
                        $filename = $sql[0]->NombreAnalisis;
                        if ($filename != null) {
                            $file_path = 'Storage/files/analisis/' . $filename;
                            if (file_exists($file_path)) {
                                unlink($file_path);
                            }
                        }
                    } else {
                        return back()->withErrors([
                            'message' => 'Solo se puede subir archivos PDF.'
                        ]);
                    }
                }
                if ($request->hasFile('archivo55')) {
                    $file2 = $request->file('archivo55');
                    $filenameanalisis =  $file2->getClientOriginalName();
                }
                if ($request->archivo55 != null) {
                    $sql3 = DB::update("UPDATE persona SET NombreAnalisis = ? WHERE ID = $id", [
                        $filenameanalisis
                    ]);
                }

            $sql = DB::update("UPDATE persona SET Cedula=?, Nombre =?, Apellidos = ?, Score = ?, Agencia = ?, Estado = ?, Reporte = ? , CuentaAsociada= ?, Monto = ?, DeudaEsp = ? WHERE ID = $id", [
                $request->cedula2,
                $request->nombre3,
                $request->apellidos3,
                $request->score3,
                $request->agencia3,
                $request->estado3,
                $request->reporte3,
                $request->cuenta3,
                $request->monto,
                $request->deudaesp

            ]);

            $sql3 = DB::select("SELECT NombreT, Tipof FROM documentot WHERE ID_Persona=$id");
            $filename = $sql3[0]->NombreT;
            $tipof = $sql3[0]->Tipof;
            if ($filename != null) {
                if ($tipof == "T1") {
                    $dir3 = "Storage/files/t1/";
                    $ruta_carga3 = $dir3 . $filename;
                    if (file_exists($ruta_carga3)) {
                        unlink($ruta_carga3);
                    }
                } elseif ($tipof == "T2") {
                    $dir3 = "Storage/files/t2/";
                    $ruta_carga3 = $dir3 . $filename;
                    if (file_exists($ruta_carga3)) {
                        unlink($ruta_carga3);
                    }
                }
            }
            
            if ($request->hasFile('archivo33')) {
                $file = $request->file('archivo33');
                $filename2 =  $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $dir3 = "";
                $ruta_carga3 = "";
            
                // Verificar si la extensión es PDF
                if ($extension === 'pdf') {
                    if ($request->tipof3 == "T1") {
                        $dir3 = "Storage/files/t1/";
                        $ruta_carga3 = $dir3 . $file->getClientOriginalName();
                    } elseif ($request->tipof3 == "T2") {
                        $dir3 = "Storage/files/t2/";
                        $ruta_carga3 = $dir3 . $file->getClientOriginalName();
                    }
                    

                    
                    if ($request->tipof3 != "N/A") {
                        $uploadSucces = $file->move($dir3, $ruta_carga3);
                    }
            
                    $sql5 =DB::update('UPDATE documentot SET NombreT = ?, Consecutivof = ?, Tipof = ? WHERE ID_Persona = ?', [
                        $filename2 ?? null,
                        $request->consecutivof33,
                        $request->tipof3,
                        $id
                    ]);
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            } else {
                $sql5 = DB::update('UPDATE documentot SET NombreT = ?, Consecutivof = ?, Tipof = ? WHERE ID_Persona = ?', [
                    null,
                    $request->consecutivof33,
                    $request->tipof3,
                    $id
                ]);
            }



            $archivo = DB::select("SELECT NombreAnalisis FROM persona WHERE ID = ?", [$id]);
            $nombre_archivo = $archivo[0]->NombreAnalisis;


            if ($request->hasFile('archivo55')) {
                $sql2 = DB::update("UPDATE persona SET NombreAnalisis = ?, ConsecutivoAnalisis = ? WHERE ID = $id", [
                    $nombre_archivo,
                    $request->consecutivoa,
                    
                ]);
            } else {
                $sql2 = DB::update("UPDATE persona SET ConsecutivoAnalisis = ? WHERE ID = $id", [
                    $request->consecutivoa,
                    
                ]);
            }

            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;
            date_default_timezone_set('America/Bogota');

            $fechaHoraActual = date('Y-m-d H:i:s');
            $cedula = DB::select("SELECT Cedula FROM persona WHERE ID = $id");
            $cedulaRegistrada = $cedula[0]->Cedula;
            $ip = $_SERVER['REMOTE_ADDR'];
$agencia = $usuarioActual->agenciau;                  
$login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'ActualizoUsuario', ?, ?, ?, ?)", [
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
                return back()->with("correcto", "El usuario " . ucwords($request->nombre3) . " " . strtoupper($request->apellidos3) . " con identificación $request->cedula2 fue actualizado correctamente!");
            } else {
                return back()->with("incorrecto", "Error al modificar el registro!");
            }
        }
    

    public function delete($id, Request $request)
    {

        $sql = DB::select("SELECT NombreS FROM documentosintesis WHERE ID_Persona=$id");
        $filename = $sql[0]->NombreS;
        if ($filename != null) {
            $file_path = 'Storage/files/sintesis/' . $filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $sql2 = DB::select("SELECT NombrePN FROM documentopn WHERE ID_Persona=$id");
        $filename = $sql2[0]->NombrePN;
        if ($filename != null) {
            $file_path = 'Storage/files/pn/' . $filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $sql2 = DB::select("SELECT NombreAnalisis FROM persona WHERE ID=$id");
        $filename = $sql2[0]->NombreAnalisis;
        if ($filename != null) {
            $file_path = 'Storage/files/analisis/' . $filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $sql2 = DB::select("SELECT NombreA FROM documentoa WHERE ID=$id");
        if (count($sql2) > 0) {
            $filename = $sql2[0]->NombreA;
            if ($filename != null) {
                $file_path = 'Storage/files/autorizacion/' . $filename;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }

        $sql3 = DB::select("SELECT NombreT, Tipof FROM documentot WHERE ID_Persona=$id");
        $filename = $sql3[0]->NombreT;
        $tipof = $sql3[0]->Tipof;
        if ($filename != null) {
            if ($tipof == "T1") {
                $dir3 = "Storage/files/t1/";
                $ruta_carga3 = $dir3 . $filename;
                if (file_exists($ruta_carga3)) {
                    unlink($ruta_carga3);
                }
            } elseif ($tipof == "T2") {
                $dir3 = "Storage/files/t2/";
                $ruta_carga3 = $dir3 . $filename;
                if (file_exists($ruta_carga3)) {
                    unlink($ruta_carga3);
                }
            }
        }



        $usuarioActual = Auth::user();
        $nombre = $usuarioActual->name;
        $rol = $usuarioActual->rol;
        date_default_timezone_set('America/Bogota');
        $fechaHoraActual = date('Y-m-d H:i:s');
        $cedulaResult = DB::select("SELECT Cedula FROM persona WHERE ID = $id");
        $cedula = $cedulaResult[0]->Cedula;
        $ip = $_SERVER['REMOTE_ADDR'];
$agencia = $usuarioActual->agenciau;                  
$login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'CreoUsuario', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                $cedula,
                null,
                $ip
            ]);

        $sql = DB::update("DELETE FROM documentoa WHERE ID_Persona=$id", []);

        $sql = DB::update("DELETE FROM documentot WHERE ID_Persona=$id", []);

        $sql2 = DB::update("DELETE FROM documentot WHERE ID_Persona=$id", []);

        $sql3 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$id", []);

        $sql4 = DB::update("DELETE FROM persona WHERE ID=$id", []);



        if ($sql == true && $sql2 == true && $sql3 == true && $sql4 == true) {
            return back()->with("incorrecto", "Error al eliminar!");
        } else {
            return back()->with("correcto", "Registro eliminado correctamente!");
        }
    }

    public function delete2(Request $request, $id)
    {   
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

        $sql = DB::update("UPDATE persona SET activado = 0 WHERE ID=$id", []);

        if ($sql == true) {
            return back()->with("correcto", "Registro eliminado correctamente!");
            
        } else {
            return back()->with("incorrecto", "Error al eliminar!");
            
        }
    }

    public function delete3($id, Request $request)
    {

        $sql = DB::select("SELECT NombreS FROM documentosintesis WHERE ID_Persona=$id");
        $filename = $sql[0]->NombreS;
        if ($filename != null) {
            $file_path = 'Storage/files/sintesis/' . $filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $sql2 = DB::select("SELECT NombrePN FROM documentopn WHERE ID_Persona=$id");
        $filename = $sql2[0]->NombrePN;
        if ($filename != null) {
            $file_path = 'Storage/files/pn/' . $filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $sql3 = DB::select("SELECT NombreA FROM documentoa WHERE ID_Persona=$id");
        $filename = $sql3[0]->NombreA;
        if ($filename != null) {
            $file_path = 'Storage/files/autorizacion/' . $filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $sql4 = DB::select("SELECT NombreContrato FROM documentoa WHERE ID_Persona=$id");
        $filename = $sql4[0]->NombreContrato;
        if ($filename != null) {
            $file_path = 'Storage/files/contrato/' . $filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $sql2 = DB::select("SELECT NombreAnalisis FROM persona WHERE ID=$id");
        $filename = $sql2[0]->NombreAnalisis;
        if ($filename != null) {
            $file_path = 'Storage/files/analisis/' . $filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $usuarioActual = Auth::user();
        $nombre = $usuarioActual->name;
        $rol = $usuarioActual->rol;
        date_default_timezone_set('America/Bogota');
        $fechaHoraActual = date('Y-m-d H:i:s');
        $cedulaResult = DB::select("SELECT Cedula FROM persona WHERE ID = $id");
        $cedula = $cedulaResult[0]->Cedula;
        $ip = $_SERVER['REMOTE_ADDR'];
$agencia = $usuarioActual->agenciau;                  
$login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'EliminoUsuarioDEFINITIVO', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                $cedula,
                null,
                $ip
            ]);

        $sql3 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$id", []);

        $sql3 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$id", []);

        $sql3 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$id", []);

        $sql4 = DB::update("DELETE FROM persona WHERE ID=$id", []);



        if ($sql == true && $sql2 == true && $sql3 == true && $sql4 == true) {
            return back()->with("correcto", "Registro eliminado correctamente!");
        } else {
            return back()->with("incorrecto", "Error al eliminar!");
        }
    }


    public function delete4($id, Request $request)
    {

        $sql = DB::select("SELECT NombreS FROM documentosintesis WHERE ID_Persona=$id");
        $filename = $sql[0]->NombreS;
        if ($filename != null) {
            $file_path = 'Storage/files/sintesis/' . $filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $sql2 = DB::select("SELECT NombrePN FROM documentopn WHERE ID_Persona=$id");
        $filename = $sql2[0]->NombrePN;
        if ($filename != null) {
            $file_path = 'Storage/files/pn/' . $filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $sql3 = DB::select("SELECT NombreA FROM documentoa WHERE ID_Persona=$id");
        $filename = $sql3[0]->NombreA;
        if ($filename != null) {
            $file_path = 'Storage/files/autorizacion/' . $filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

  

        $sql2 = DB::select("SELECT NombreRC FROM proveedor WHERE ID_Persona=$id");
        $filename = $sql2[0]->NombreRC;
        if ($filename != null) {
            $file_path = 'Storage/files/rc/' . $filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $usuarioActual = Auth::user();
        $nombre = $usuarioActual->name;
        $rol = $usuarioActual->rol;
        date_default_timezone_set('America/Bogota');
        $fechaHoraActual = date('Y-m-d H:i:s');
        $cedulaResult = DB::select("SELECT Cedula FROM persona WHERE ID = $id");
        $cedula = $cedulaResult[0]->Cedula;
        $ip = $_SERVER['REMOTE_ADDR'];
$agencia = $usuarioActual->agenciau;                  
$login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'EliminoUsuarioDEFINITIVO', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                $cedula,
                null,
                $ip
            ]);

        $sql3 = DB::update("DELETE FROM documentoa WHERE ID_Persona=$id", []);

        $sql3 = DB::update("DELETE FROM documentopn WHERE ID_Persona=$id", []);

        $sql3 = DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$id", []);

        $sql3 = DB::update("DELETE FROM proveedor WHERE ID_Persona=$id", []);

        $sql4 = DB::update("DELETE FROM persona WHERE ID=$id", []);



        if ($sql == true && $sql2 == true && $sql3 == true && $sql4 == true) {
            return back()->with("correcto", "Registro eliminado correctamente!");
        } else {
            return back()->with("incorrecto", "Error al eliminar!");
        }
    }

    public function activate($id)
    {

        $sql = DB::update("UPDATE persona SET activado = 1 WHERE ID=$id", []);
        
        if ($sql == true) {
            return back()->with("correcto", "Registro activado correctamente!");
            
        } else {
            return back()->with("incorrecto", "Error al eliminar!");
            
        }
    }



    public function store(Request $request)
{
    $existingPerson = DB::select('SELECT * FROM users WHERE email = ?', [$request->email]);

    if ($existingPerson == true) {
        return back()->with("incorrecto", "Correo registrado en la base de datos! Error al Registrar!");
    }

    if (!preg_match('/^[a-zA-Z\sñÑ]+$/', $request->name)) {
        return back()->with("incorrecto", "El nombre de usuario debe contener solo letras!");
    }

    if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
        return back()->with("incorrecto", "El correo electrónico no tiene un formato válido!");
    }

    if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,12}$/', $request->password)) {
        return back()->with("incorrecto", "La contraseña debe tener entre 8 y 12 caracteres y contener al menos una letra, un número y un símbolo!");
    }

    if ($request->password !== $request->password_confirmation) {
        return back()->with("incorrecto", "Las contraseñas no coinciden. Por favor, inténtelo de nuevo.");
    }
    

    $this->validate(request(), [
        'name' => 'required',
        'email' => 'required|email',
        'rol' => 'required',
        'password' => 'required|confirmed',
        'agenciau' => 'required'
    ]);

    $user = User::create(request(['name', 'email', 'rol', 'password', 'agenciau']));

    Mail::to($request->email)->send(new VerificationEmail($user));

    return back()->with("correcto", "Persona registrada correctamente!");
}

public function verifyEmail(Request $request, $id)
{
    $sql = DB::update("UPDATE users set activo=1 WHERE ID=$id", []);
    if ($sql == true) {
        return redirect('inicia-sesion')->with('correcto', 'Correo electrónico verificado correctamente');
    } elseif ($sql == false) {
        return redirect('inicia-sesion')->with('incorrecto', 'Correo electrónico ya está verificado');
    }
    
}

    public function activo($id)
    {
        $sql = DB::update("UPDATE users SET activo=1 WHERE ID=$id", []);

        if ($sql == true) {
            return back()->with("correcto", "EL USUARIO SE HA ACTIVADO CORRECTAMENTE!");
        } elseif ($sql == false) {
            return back()->with("incorrecto", "EL USUARIO YA ESTA ACTIVADO!");
        }
    }

    public function desactivar($id)
    {
        $sql = DB::update("UPDATE users SET activo=0 WHERE ID=$id", []);

        if ($sql == true) {
            return back()->with("correcto", "EL USUARIO SE HA DESACTIVADO CORRECTAMENTE!");
        } elseif ($sql == false) {
            return back()->with("incorrecto", "EL USUARIO YA ESTA DESACTIVADO!");
        }
    }

    public function eliminarRol($id)
    {
        $sql = DB::update("DELETE FROM users WHERE id=$id", []);


        if ($sql == true) {
            return back()->with("correcto", "Registro eliminado correctamente!");
        } else {
            return back()->with("correcto", "El usuario ya ha sido eliminado!");
        }
    }

    public function create2(Request $request)
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
                    $dir = 'Storage/files/autorizacion/';
                    $filename =  $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
            
                    $file2 = $request->file('contrato');
                    $dir2 = 'Storage/files/contrato/';
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
    public function update2(Request $request, $id)
    {

        if ($request->hasFile('archivo22') != null) {
            $file3 = $request->file('archivo22');
            $filename3 =  $file3->getClientOriginalName();
            $archivo3 = DB::select("SELECT NombreS FROM documentosintesis WHERE NombreS = ?", [$filename3]);
        }
            if (!empty($archivo3)) {
                return back()->withErrors([
                    'message' => 'El archivo Síntesis - ' . $filename3 . '" ya existe!'
                ]);
                
            
        }

        if ($request->hasFile('archivo11') != null) {
            $file3 = $request->file('archivo11');
            $filename3 =  $file3->getClientOriginalName();
            $archivo3 = DB::select("SELECT NombrePN FROM documentopn WHERE NombrePN = ?", [$filename3]);
        }
            if (!empty($archivo3)) {
                return back()->withErrors([
                    'message' => 'El archivo PN - ' . $filename3 . '" ya existe!'
                ]);
                
            
        }

        
        if ($request->hasFile('archivo3') != null) {
            $file3 = $request->file('archivo3');
            $filename3 =  $file3->getClientOriginalName();
            $archivo3 = DB::select("SELECT NombreA FROM documentoa WHERE NombreA = ?", [$filename3]);
        }
            if (!empty($archivo3)) {
                return back()->withErrors([
                    'message' => 'El archivo AUTORIZACIÓN - ' . $filename3 . '" ya existe!'
                ]);
                
            
        }

        if ($request->hasFile('contrato1') != null) {
            $file3 = $request->file('contrato1');
            $filename3 =  $file3->getClientOriginalName();
            $archivo3 = DB::select("SELECT NombreContrato FROM documentoa WHERE NombreContrato = ?", [$filename3]);
        }
            if (!empty($archivo3)) {
                return back()->withErrors([
                    'message' => 'El archivo CONTRATO - ' . $filename3 . '" ya existe!'
                ]);
                
            
        }

       
            if($request->Score == 'S/E'){
                $request->Score = 'S/E';
             }
                 elseif
                 ($request->Score > 950) {
                    $request->Score = 950;
                }
            
           
            $sql = DB::update("UPDATE persona SET Cedula=?, Nombre =?, Apellidos = ?, Score = ?, Agencia = ?,Reporte = ?  WHERE ID = $id", [
                $request->cedula2,
                $request->nombre3,
                $request->apellidos3,
                $request->score3,
                $request->agencia3,
                $request->reporte3,
            ]);


            if ($request->hasFile('archivo22')) {
                $file = $request->file('archivo22');
                $dir = 'Storage/files/sintesis/';
                $filename =  $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
            
                
                if ($file->getClientOriginalExtension() === 'pdf') {
                    $uploadSucces = $request->file('archivo22')->move($dir, $filename);
                    $sql = DB::select("SELECT NombreS FROM documentosintesis WHERE ID_Persona=$id");
                    $filename = $sql[0]->NombreS;
                    if ($filename != null) {
                        $file_path = 'Storage/files/sintesis/' . $filename;
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                    }
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            }
            if ($request->hasFile('archivo11')) {
                $file = $request->file('archivo11');
                $dir = 'Storage/files/pn/';
                $filename =  $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
            
                
                if ($file->getClientOriginalExtension() === 'pdf') {
                    $uploadSucces = $request->file('archivo11')->move($dir, $filename);
                    $sql = DB::select("SELECT NombrePN FROM documentopn WHERE ID_Persona=$id");
                    $filename = $sql[0]->NombrePN;
                    if ($filename != null) {
                        $file_path = 'Storage/files/pn/' . $filename;
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                    }
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            }


            if ($request->hasFile('archivo3')) {
                $file = $request->file('archivo3');
                $dir = 'Storage/files/autorizacion/';
                $filename =  $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
            
                
                if ($file->getClientOriginalExtension() === 'pdf') {
                    $uploadSucces = $request->file('archivo3')->move($dir, $filename);
                    $sql = DB::select("SELECT NombreA FROM documentoa WHERE ID_Persona=$id");
                    $filename = $sql[0]->NombreA;
                    if ($filename != null) {
                        $file_path = 'Storage/files/autorizacion/' . $filename;
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                    }
                } else {
                    return back()->withErrors([
                        'message' => 'Solo se puede subir archivos PDF.'
                    ]);
                }
            }

            if ($request->hasFile('contrato1')) {
                $file = $request->file('contrato1');
                $dir = 'Storage/files/autorizacion/contrato/';
                $filename =  $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
            
                
                if ($file->getClientOriginalExtension() === 'pdf') {
                    $uploadSucces = $request->file('contrato1')->move($dir, $filename);
                    $sql = DB::select("SELECT NombreContrato FROM documentoa WHERE ID_Persona=$id");
                    $filename = $sql[0]->NombreContrato;
                    if ($filename != null) {
                        $file_path = 'Storage/files/autorizacion/contrato/' . $filename;
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                    }
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
                $file2 = $request->file('archivo22');
                $filenamesin =  $file2->getClientOriginalName();
            }
            if ($request->hasFile('archivo22')) {
                $sql2 = DB::update("UPDATE documentosintesis SET FechaInsercion = ?, NombreS = ? WHERE ID_Persona = $id", [
                    $request->fecha3,
                    $filenamesin
                ]);
            } else {
                $sql2 = DB::update("UPDATE documentosintesis SET FechaInsercion = ? WHERE ID_Persona = $id", [
                    $request->fecha3
                ]);
            }

            if ($request->hasFile('archivo11')) {
                $file2 = $request->file('archivo11');
                $filenamepn =  $file2->getClientOriginalName();
            }
            if ($request->archivo11 != null) {
                $sql3 = DB::update("UPDATE documentopn SET NombrePN = ? WHERE ID_Persona = $id", [
                    $filenamepn
                ]);
            }

            if ($request->hasFile('contrato1')) {
                $file2 = $request->file('contrato1');
                $filenamec =  $file2->getClientOriginalName();
            }
            if ($request->contrato1 != null) {
                $sql3 = DB::update("UPDATE documentoa SET NombreContrato = ? WHERE ID_Persona = $id", [
                    $filenamec
                ]);
            }

            if ($request->hasFile('archivo3')) {
                $file2 = $request->file('archivo3');
                $filenameautorizacion =  $file2->getClientOriginalName();
            }
            if ($request->hasFile('archivo3')) {
                $sql4 = DB::update("UPDATE documentoa SET ConsecutivoA = ?, NombreA = ? WHERE ID_Persona = $id", [
                    $request->consecutivof33,
                    $filenameautorizacion
                ]);
            } else {
                $sql4 = DB::update("UPDATE documentoa SET ConsecutivoA = ? WHERE ID_Persona = $id", [
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
            if ($sql == true || $sql2 = true || $sql3 == true || $sql4 == true) {
                return back()->with("correcto", "El usuario " . ucwords($request->nombre3) . " " . strtoupper($request->apellidos3) . " con identificación $request->cedula2 fue actualizado correctamente!");
            } else {
                return back()->with("incorrecto", "Error al modificar el registro!");
            }
        }
    
    

    public function data3(){
        $user = DB::select("
        SELECT A.ID, A.Inspektor, A.Observaciones, A.Cedula,A.FechaCorreo, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado, A.Tipo, A.Consulta,
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

    
    public function create3(Request $request)
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
                $sql = DB::insert('INSERT INTO persona (Cedula, Nombre, Apellidos, Score, CuentaAsociada, Agencia, Estado, Reporte, Tipo, Enviado, TipoProveedor,FechaCorreo) VALUES (?, ?, UPPER(?), ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                    $request->cedula,
                    $request->nombre,
                    $request->apellidos,
                    null,
                    null,
                    $request->Agencia,
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
            $sql = DB::insert('INSERT INTO persona (Cedula, Nombre, Apellidos, Score, CuentaAsociada, Agencia, Estado, Reporte, Tipo, Enviado, TipoProveedor, FechaCorreo) VALUES (?, ?, UPPER(?), ?, ?, ?, ?, ?, ?, ?, ?,?)', [
                null,
                null,
                null,
                null,
                null,
                $request->Agencia,
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
                return back()->with("correcto2", "Persona Registrada correctamente!")->with("showLoadingAlert", true);
            } else {
                return back()->with("incorrecto", "Error al insertar el registro!");
            }
            
        }
    }

    public function update3(Request $request, $id)
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
 
             $sql = DB::update("UPDATE persona SET Cedula=?, Nombre =?, Apellidos = ?, Agencia = ?  WHERE ID = $id", [
                 $request->cedula2,
                 $request->nombre3,
                 $request->apellidos3,
                 $request->agencia3,
             ]);
 
 
             $proveedor = DB::select("SELECT ValorAcumulado FROM proveedor WHERE ID_Persona = ?", [$id]);
             $valorAcumuladoActual = $proveedor[0]->ValorAcumulado;
 
             $nuevoValorCompra = $request->valorcompra1;
 
             $nuevoValorAcumulado = $valorAcumuladoActual + $nuevoValorCompra;
             
             $dir4 = 'Storage/files/rc/';
             if ($request->hasFile('archivo4') && !empty($filename4)) {
                 $file4 = $request->file('archivo4');
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
                 $sql = DB::update("UPDATE persona SET Agencia = ?  WHERE ID = $id", [
                     $request->agencia4,
                 ]);
     
     
                 $proveedor = DB::select("SELECT ValorAcumulado FROM proveedor WHERE ID_Persona = ?", [$id]);
                 $valorAcumuladoActual = $proveedor[0]->ValorAcumulado;
     
                 $nuevoValorCompra = $request->valorcompra2;
     
                 $nuevoValorAcumulado = $valorAcumuladoActual + $nuevoValorCompra;
                 
                 $dir4 = 'Storage/files/rc/';
                 if ($request->hasFile('archivo4') && !empty($filename4)) {
                     $file4 = $request->file('archivo4');
      
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
            $ip = $_SERVER['REMOTE_ADDR'];
            $fechaHoraActual = date('Y-m-d H:i:s');
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

    public function eliminarTotal(Request $request) {
        $cedula = $request->eliminado;
    
        // Buscar el ID de la persona con la cédula proporcionada
        $persona = DB::table('persona')->where('Cedula', $cedula)->first();
    
        if (!$persona) {
            return back()->with("incorrecto", "No se encontró ninguna persona con la cédula proporcionada.");
        }
    
        $idd = $persona->ID;

        // // Eliminar registros relacionados en otras tablas
        DB::table('documentoa')->where('ID_Persona', $idd)->delete();
        DB::table('documentot')->where('ID_Persona', $idd)->delete();
        DB::table('documentosintesis')->where('ID_Persona', $idd)->delete();
        DB::table('documentopn')->where('ID_Persona', $idd)->delete();
    
        // Finalmente, eliminar la persona
        DB::table('persona')->where('ID', $idd)->delete();
    
        return back()->with("correcto", "Registro eliminado correctamente!"); 
        
        
        $usuarioActual = Auth::user();
        $nombre = $usuarioActual->name;
        $rol = $usuarioActual->rol;
        $cedulaagregada = $request->Cedula;
        date_default_timezone_set('America/Bogota');
        $cedula = DB::select("SELECT Cedula FROM persona WHERE ID = $id");
        $cedulaRegistrada = $cedula[0]->Cedula;
        $ip = $_SERVER['REMOTE_ADDR'];
        $fechaHoraActual = date('Y-m-d H:i:s');
$agencia = $usuarioActual->agenciau;                  
$login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'EliminoAsociado-Empleado-Credio', ?, ?, ?, ?)", [
            null,
            $nombre,
            $rol,
            $agencia,
            $fechaHoraActual,
            $cedulaRegistrada,
            null,
            $ip
        ]);
    }
    

public function eliminarTotalPro (Request $request){

    if($request->tipo_persona == "PN") {
        $cedula = $request->eliminado;
   // Buscar el ID de la persona con la cédula proporcionada
   $persona = DB::table('persona')->where('Cedula', $cedula)->first();

   if (!$persona) {
       return back()->with("incorrecto", "No se encontró ninguna persona con la cédula proporcionada.");
   }

   $idd = $persona->ID;


       // // Eliminar registros relacionados en otras tablas
       DB::table('documentoa')->where('ID_Persona', $idd)->delete();
       DB::table('documentosintesis')->where('ID_Persona', $idd)->delete();
       DB::table('documentopn')->where('ID_Persona', $idd)->delete();
       DB::table('proveedor')->where('ID_Persona', $idd)->delete();
   
       // Finalmente, eliminar la persona
       DB::table('persona')->where('ID', $idd)->delete();

    }else {

        $nit = $request->eliminado;
        // Buscar la empresa con el NIT proporcionado
        $empresa = DB::table('proveedor')->where('NIT', $nit)->first();

        if (!$empresa) {
            return back()->with("incorrecto", "No se encontró ninguna empresa con el NIT proporcionado.");
        }

        $idPersona = $empresa->ID_Persona;

        // Eliminar registros relacionados en otras tablas
        DB::table('documentosintesis')->where('ID_Persona', $idPersona)->delete();
        DB::table('documentopn')->where('ID_Persona', $idPersona)->delete();
        DB::table('documentoa')->where('ID_Persona', $idPersona)->delete();

        // Eliminar la empresa
        DB::table('proveedor')->where('ID_Persona', $idPersona)->delete();

        // Finalmente, eliminar la persona
        DB::table('persona')->where('ID', $idPersona)->delete();

        return back()->with("correcto", "Registro eliminado correctamente!");

    }
 

               $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;
            $cedulaagregada = $request->Cedula;
            date_default_timezone_set('America/Bogota');
            $cedula = DB::select("SELECT Cedula FROM persona WHERE ID = $id");
            $cedulaRegistrada = $cedula[0]->Cedula;
            $ip = $_SERVER['REMOTE_ADDR'];
            $fechaHoraActual = date('Y-m-d H:i:s');
$agencia = $usuarioActual->agenciau;                  
$login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'EliminoProveedoTotalmente', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                $cedulaRegistrada,
                null,
                $ip
            ]);



    return back()->with("correcto", "Registro eliminado correctamente!");   
}


public function data7(){
    $user = DB::select("
    SELECT * FROM s400_plano");

    return datatables()->of($user)->toJson();


}

public function updateFechaReporte(Request $request, $id)
    {
        //radiobutton
        
        $mesReporte = $request->tipo_fecha;
        if($mesReporte == 0){
            $diaFecha = $request->diafecha;
            $diaFechaConFormato = $diaFecha .' MES ACTUAL';
            $sql = DB::update("UPDATE s400_plano SET FECHAREPORTE = ?, MESANTERIOR = ?, DIAS = ?, ENTREMES = ? WHERE ID = $id", [
                $diaFechaConFormato,
                $mesReporte,
                $diaFecha,
                0
            ]);

        }else if ($mesReporte == 1){
            $diaFecha = $request->diafecha;
            $diaFechaConFormato = $diaFecha .' MES ANTERIOR';
            $sql = DB::update("UPDATE s400_plano SET FECHAREPORTE = ?, MESANTERIOR = ?, DIAS = ?, ENTREMES = ? WHERE ID = $id", [
                $diaFechaConFormato,
                $mesReporte,
                $diaFecha,
                0
            ]);

        }else if($mesReporte == 2){
            $diaFecha = $request->diafecha;
            $diaFechaConFormato = 'SIN FECHA';
            $sql = DB::update("UPDATE s400_plano SET FECHAREPORTE = ?, MESANTERIOR = ?, DIAS = ? WHERE ID = $id", [
                $diaFechaConFormato,
                $mesReporte,
                $diaFecha
            ]);

        }else if($mesReporte == 3){
            $diaFecha = $request->diafecha;
            $diaFechaConFormato = $diaFecha .' ENTREMES';
            $sql = DB::update("UPDATE s400_plano SET FECHAREPORTE = ?, MESANTERIOR = ?, ENTREMES = ?, DIAS = ? WHERE ID = $id", [
                $diaFechaConFormato,
                0,
                1,
                $diaFecha,
            ]);
        }
        

            $usuarioActual = Auth::user();
            $nombre = $usuarioActual->name;
            $rol = $usuarioActual->rol;
            date_default_timezone_set('America/Bogota');

            $fechaHoraActual = date('Y-m-d H:i:s');
            $ip = $_SERVER['REMOTE_ADDR'];
            $agencia = $usuarioActual->agenciau;                  
            $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'ActualizoUsuario', ?, ?, ?, ?)", [
                null,
                $nombre,
                $rol,
                $agencia,
                $fechaHoraActual,
                null,
                null,
                $ip
            ]);
            if ($sql) {
                return back()->with("correcto2", "<span style='font-size: 22px'>La fecha de reporte de la nomina <strong>".$request->NOMBRENOMINA."</strong> con dependencia <strong>".$request->CODDEPENDENCIA ."-".$request->NOMDEPENDENCIA."</strong> fue asignado correctamente(<strong>".$diaFechaConFormato."</strong>)</span>");
            } else {
                return back()->with("incorrecto", "Error al modificar el registro!");
            }
        }


}