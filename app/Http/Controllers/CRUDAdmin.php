<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CRUDAdmin extends Controller
{
    //listar
    public function list()
    {


        $datos = DB::select("
        SELECT A.ID, A.Cedula, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado,
        A.Reporte, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT 
        FROM persona
        A JOIN documentosintesis B ON A.ID = B.ID_Persona JOIN documentopn C ON B.ID_Persona = C.ID_Persona JOIN documentot
        D ON C.ID_Persona = D.ID_Persona ORDER BY Nombre ASC");


        $datos2 = DB::select("SELECT * FROM users WHERE rol = 'consultante' OR rol = 'asociacion' OR rol = 'credito' OR rol = 'proveedor'");
        $max_date = date(DATE_ATOM);
        return view("datacredito", compact("datos", "datos2"));
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
            $tipo = $request->Tipof;
            $archivo3 = DB::select("SELECT NombreT, Tipof FROM documentot WHERE NombreT = ?", [$filename3]);

            if (!empty($archivo3)) {
                return back()->withErrors([
                    'message' => 'El archivo FORMATO ' . $tipo . ' - "' . $filename3 . '" ya existe!'
                ]);
            }
        } else {
            // if ($request->Score > 950) {
            //     $request->Score = 950;
            // }

            $sql = DB::insert('INSERT INTO persona (Cedula, Nombre, Apellidos, Score, CuentaAsociada, Agencia, Estado, Reporte) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                $request->Cedula,
                $request->Nombre,
                $request->Apellidos,
                $request->Score,
                $request->CuentaAsociada,
                $request->Agencia,
                $request->Estado,
                $request->Reporte
            ]);
            $idPersona = DB::getPdo()->lastInsertId();
            if ($request->hasFile('NombreS')) {
                $file = $request->file('NombreS');
                $dir = 'Storage/files/sintesis/';
                $filename =  $file->getClientOriginalName();
                $uploadSucces = $request->file('NombreS')->move($dir, $filename);

                $sql2 = DB::insert('INSERT INTO documentosintesis (FechaInsercion, NombreS, ID_Persona) VALUES (?, ?, ?)', [
                    $request->FechaInsercion,
                    $filename ?? null,
                    $idPersona
                ]);
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
                $uploadSucces = $request->file('NombrePN')->move($dir, $filename);

                $sql3 = DB::insert('INSERT INTO documentopn (NombrePN, ID_Persona) VALUES (?, ?)', [
                    $filename ?? null,
                    $idPersona
                ]);
            } else {
                $sql3 = DB::insert('INSERT INTO documentopn (NombrePN, ID_Persona) VALUES (?, ?)', [
                    null,
                    $idPersona
                ]);
            }

            if ($request->hasFile('NombreT')) {
                $file = $request->file('NombreT');
                $filename2 =  $file->getClientOriginalName();
                $dir3 = "";
                $ruta_carga3 = "";

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
                $sql4 = DB::insert('INSERT INTO documentot (NombreT, Consecutivof, Tipof, ID_Persona) VALUES (?, ?, ?, ?)', [
                    null,
                    $request->Consecutivof,
                    $request->Tipof,
                    $idPersona
                ]);
            }

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
        } else {

            $sql = DB::update("UPDATE persona SET Cedula=?, Nombre =?, Apellidos = ?, Score = ?, Agencia = ?, Estado = ?, Reporte = ? , CuentaAsociada= ? WHERE ID = $id", [
                $request->cedula2,
                $request->nombre3,
                $request->apellidos3,
                $request->score3,
                $request->agencia3,
                $request->estado3,
                $request->reporte3,
                $request->cuenta3

            ]);



            $dir = 'Storage/files/sintesis/';
            if ($request->hasFile('archivo22') && !empty($filename)) {
                $uploadSucces = $request->file('archivo22')->move($dir, $filename);
            }

            $dir2 = 'Storage/files/pn/';
            if ($request->hasFile('archivo11') && !empty($filename2)) {
                $uploadSucces = $request->file('archivo11')->move($dir2, $filename2);
            }



            // Obtener el nombre de los archivos actuales
            $archivo = DB::select("SELECT NombreS FROM documentosintesis WHERE ID_Persona = ?", [$id]);
            $nombre_archivo = $archivo[0]->NombreS;

            $archivo2 = DB::select("SELECT NombrePN FROM documentopn WHERE ID_Persona = ?", [$id]);
            $nombre_archivo2 = $archivo2[0]->NombrePN;


            if ($request->hasFile('archivo22')) {
                // Actualizar el archivo y la fecha en la tabla documentosintesis
                $sql2 = DB::update("UPDATE documentosintesis SET FechaInsercion = ?, NombreS = ? WHERE ID_Persona = $id", [
                    $request->fecha3,
                    $request->archivo22
                ]);
            } else {
                // Solo actualizar la fecha en la tabla documentosintesis
                $sql2 = DB::update("UPDATE documentosintesis SET FechaInsercion = ? WHERE ID_Persona = $id", [
                    $request->fecha3
                ]);
            }

            if ($request->archivo11 != null) {
                // Actualizar el archivo en la tabla documentopn
                $sql3 = DB::update("UPDATE documentopn SET NombrePN = ? WHERE ID_Persona = $id", [
                    $nuevo_archivo2
                ]);
            }


            if ($sql == true || $sql2 = true || $sql3 == true) {
                return back()->with("correcto", "El usuario " . ucwords($request->nombre3) . " " . strtoupper($request->apellidos3) . " con identificación $request->cedula2 fue actualizado correctamente!");
            } else {
                return back()->with("incorrecto", "Error al modificar el registro!");
            }
        }
    }

    public function delete($id)
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



    public function store(Request $request)
    {
        $existingPerson = DB::select('SELECT * FROM users WHERE email = ?', [$request->email]);

        if ($existingPerson == true) {
            return back()->with("incorrecto", "Correo registrado en la base de datos! Error al Registrar!");
        } else {
            if (!preg_match('/^[a-zA-Z\sñÑ]+$/', $request->name)) {
                return back()->with("incorrecto", "El nombre de usuario debe contener solo letras!");
            } else {
                if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    return back()->with("incorrecto", "El correo electrónico no tiene un formato válido!");
                } else {
                    if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,12}$/', $request->password)) {
                        return back()->with("incorrecto", "La contraseña debe tener entre 8 y 12 caracteres y contener al menos una letra, un número y un símbolo!"); 
                    }else{
                        if($request->password !== $request->password_confirmation){
                            return back()->with("incorrecto", "Las contraseñas no coinciden. Por favor, inténtelo de nuevo."); 
                        }
                    }
                }
            }
        }
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'rol' => 'required',
            'password' => 'required|confirmed'
        ]);

        $user = User::create(request(['name', 'email', 'rol', 'password']));


    
        return back()->with("correcto", "Persona Registrada correctamente!");
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
}