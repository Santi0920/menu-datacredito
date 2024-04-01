<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewControl extends Controller
{
    public function data(){
        $user = DB::select("
        SELECT A.ID, A.Inspektor, A.Observaciones, A.FechaCorreo, A.Linea, A.Cedula, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado, A.Tipo, A.Consulta,
        A.Reporte, A.TipoAsociado, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT, E.ConsecutivoA, E.NombreA
        FROM persona A 
        JOIN documentosintesis B ON A.ID = B.ID_Persona 
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona 
        JOIN documentot D ON C.ID_Persona = D.ID_Persona 
        JOIN documentoa E ON D.ID_Persona = E.ID_Persona 
        WHERE A.Activado = 1 AND (A.Tipo = 'Persona' OR A.Tipo = 'Empleado') AND (A.TipoAsociado = 'Asociacion' OR A.TipoAsociado = 'Empleado')
        ORDER BY A.Nombre ASC");
       
        
        return datatables()->of($user)->toJson();

    }
    public function data2(){
        $user = DB::select("
        SELECT A.ID, A.Inspektor, A.ConsecutivoRC, A.ObRC, A.Observaciones, A.FechaCorreo, A.TipoAsociado, A.Cedula, A.Linea, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado,
        A.Reporte, A.Monto, A.NombreAnalisis, A.ConsecutivoAnalisis, A.DeudaEsp, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT
        FROM persona A 
        JOIN documentosintesis B ON A.ID = B.ID_Persona 
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona 
        JOIN documentot D ON C.ID_Persona = D.ID_Persona 
        WHERE A.Activado = 1 && (A.Tipo = 'Persona' OR A.Tipo = 'Empleado') && A.TipoAsociado = 'Credito'
        ORDER BY Nombre ASC");
       
        
        return datatables()->of($user)->toJson();

    }

    public function data3(){
        $user = DB::select("
        SELECT A.ID, A.Inspektor, A.Cedula,A.FechaCorreo, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado, A.Tipo, A.Consulta,
        A.Reporte, A.NombreAnalisis, A.ConsecutivoAnalisis, A.Monto, A.DeudaEsp, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT, E.NombreA, E.ConsecutivoA, E.NombreContrato
        FROM persona A 
        JOIN documentosintesis B ON A.ID = B.ID_Persona 
        JOIN documentopn C ON B.ID_Persona = C.ID_Persona 
        JOIN documentot D ON C.ID_Persona = D.ID_Persona 
        JOIN documentoa E ON D.ID_Persona = E.ID_Persona
        WHERE A.Activado = 1 && A.TipoAsociado = 'NuevoEmpleado' && A.Tipo = 'NuevoEmpleado'
        ORDER BY Nombre ASC");
       
        
        return datatables()->of($user)->toJson();

    }

    public function data4()
    {
        $users = DB::select("
            SELECT A.ID, A.Inspektor, A.Cedula, A.FechaCorreo, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado, A.Tipo, A.Consulta,
            A.Reporte, A.TipoProveedor, A.NombreAnalisis, A.ConsecutivoAnalisis, A.Monto, A.DeudaEsp, B.FechaInsercion, B.NombreS, C.NombrePN, P.NIT, P.NombreRC, P.ValorCompra, P.ValorAcumulado, P.RazonSocial ,E.NombreA, E.ConsecutivoA
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
}
