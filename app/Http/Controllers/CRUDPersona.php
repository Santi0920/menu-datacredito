<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CRUDPersona extends Controller
{
    //listar
    public function list()
    {
        
        
        $datos=DB::select("
        SELECT A.ID, A.Cedula, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado,
        A.Reporte, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT 
        FROM persona
        A JOIN documentosintesis B ON A.ID = B.ID_Persona JOIN documentopn C ON B.ID_Persona = C.ID_Persona JOIN documentot
        D ON C.ID_Persona = D.ID_Persona ORDER BY Nombre ASC");
        
        
        return view("datacredito")->with("datos", $datos);
    }


//registrar
    public function create(Request $request)
    {
        $existingPerson = DB::select('SELECT * FROM persona WHERE Cedula = ?', [$request->Cedula]);
    if ($existingPerson) {
        if($existingPerson == true){
            return back()->with("incorrecto", "Persona con cc. $request->Cedula ya existe! Error al Registrar!");
        } 
    // }

    // if ($request->hasFile('NombreS')) {
    //     $file = $request->file('NombreS');
    //     $filename =  $file->getClientOriginalName();
    //     $dir = '';
    //     $path = $dir . $filename;
    
    //     if (Storage::exists($path)) {
    //         $message = "El archivo $filename ya existe! Error al Registrar!";
    //         return back()->with("incorrecto", $message);
    //     } else {
    //         $message = "El archivo $filename es nuevo! Puede registrar.";
    //         return back()->with("correcto", $message);
    //     }
    
  


    }else{
        // if ($request->Score > 950) {
        //     $request->Score = 950;
        // }
        
        $sql=DB::insert('INSERT INTO persona (Cedula, Nombre, Apellidos, Score, CuentaAsociada, Agencia, Estado, Reporte) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',[
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
        if($request->hasFile('NombreS')){
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
        
        if($request->hasFile('NombrePN')){
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
        $filename =  $file->getClientOriginalName();
        $dir3 = "";
        $ruta_carga3= "";
    
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
            $filename ?? null,
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
        
        $sql=DB::update("UPDATE persona SET Cedula=?, Nombre =?, Apellidos = ?, Score = ?, Agencia = ?, Estado = ?, Reporte = ? WHERE ID = $id",[
            $request->Cedula,
            $request->Nombre,
            $request->Apellidos,
            $request->Score,
            $request->Agencia,
            $request->Estado,
            $request->Reporte,

        ]);
    
        
        $sql2=DB::update("UPDATE documentosintesis SET FechaInsercion = ?, NombreS = ? WHERE ID = $id",[
            $request->FechaInsercion,
            $request->NombreSin,
            
        ]);
    
        $sql3=DB::update("UPDATE documentopn SET NombrePN = ? WHERE ID_Persona = $id",[
            $request->NombrePN,
            
        ]);
    
        $sql4=DB::update("UPDATE documentot SET NombreT=?, Consecutivof = ?, Tipof = ? WHERE ID_Persona = $id",[
            $request->NombreT,
            $request->Consecutivof,
            $request->Tipof,

        ]);

        if($sql == true && $sql2 == true && $sql3 == true && $sql4 == true){
            return back()->with("correcto", "El usuario ".ucwords($request->Nombre)." ". strtoupper($request->Apellidos). " con identificación <?php echo $request->Cedula ?> fue actualizado correctamente!");
        } else{
            return back()->with("incorrecto", "Error al modificar el registro!");
        }
    }

    public function delete($id)
    {
        
        $sql = DB::select("SELECT NombreS FROM documentosintesis WHERE ID_Persona=$id");
        $filename = $sql[0]->NombreS;
        if ($filename != null) {
            $file_path = 'Storage/files/sintesis/'.$filename;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        $sql2 = DB::select("SELECT NombrePN FROM documentopn WHERE ID_Persona=$id");
        $filename = $sql2[0]->NombrePN;
        if ($filename != null) {
            $file_path = 'Storage/files/pn/'.$filename;
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
        
      
   
        
     
        $sql=DB::update("DELETE FROM documentot WHERE ID_Persona=$id",[
        ]);

        $sql2=DB::update("DELETE FROM documentot WHERE ID_Persona=$id",[
        ]);

        $sql3=DB::update("DELETE FROM documentosintesis WHERE ID_Persona=$id",[
        ]);

        $sql4=DB::update("DELETE FROM persona WHERE ID=$id",[
        ]);
    

        if($sql == true && $sql2 == true && $sql3 == true && $sql4 == true){
            return back()->with("incorrecto", "Error al eliminar!");
        } else{
            return back()->with("correcto", "Registro eliminado correctamente!");
        }
    } 
} 
