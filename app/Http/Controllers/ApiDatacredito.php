<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Pagare;
use App\Models\Persona;
use App\Models\documentoa;
use App\Models\documentopn;
use App\Models\documentosintesis;
use App\Models\documentot;

class ApiDatacredito extends Controller
{
    //

    public function show($cedula){
        $persona = Persona::where('Cedula', $cedula)->first();
    
        if (!$persona) {
            return response()->json(['status' => 404, 'persona' => 'Persona con '.$cedula .' no encontrada.']);
        }
    
        $ID = $persona->ID;
    
        $documentoa = Documentoa::where('ID_Persona', $ID)->first();
        $documentopn = Documentopn::where('ID_Persona', $ID)->first();
        $documentosintesis = Documentosintesis::where('ID_Persona', $ID)->first();
        $documentot = Documentot::where('ID_Persona', $ID)->first();
    
        $documentos = [
            'documentoa' => $documentoa,
            'documentopn' => $documentopn,
            'documentosintesis' => $documentosintesis,
            'documentot' => $documentot
        ];
    
        return response()->json(['status' => 200, 'persona' => $persona, 'documentos' => $documentos]);
    }



    public function showPagare($cedula){
        $pagare = Pagare::where('Cedula_Persona', $cedula)->first();

    
        if (!$pagare) {
            return response()->json(['status' => 404, 'pagare' => 'Pagare vinculado a cédula  No.'.$cedula .' no encontrada.']);
        }

        if($pagare->Correo == null){
            $correo = 'No tiene correo porque es ordinario.';
        }else{
            $correo = $pagare->Correo;
        }


        if($pagare->ID_Pagare == null){
            $idpagare = 'No tiene Consecutivo de Pagare porque es ordinario.';
        }else{
            $idpagare = $pagare->ID_Pagare;
        }
    
        return response()->json([
            'status' => 200,
            'pagare' => [
                'ID' => $pagare->ID,
                'NoAgencia' => $pagare->NoAgencia,
                'NombreAgencia' => $pagare->NombreAgencia,
                'InteresProporcional' => $pagare->InteresProporcional,
                'CoorAsignada' => $pagare->CoorAsignada,
                'CuentaCoop' => $pagare->CuentaCoop,
                'Cedula_Persona' => $pagare->Cedula_Persona,
                'NombreCompleto' => $pagare->NombreCompleto,
                'ID_Pagare' => $idpagare,
                'NoLC' => $pagare->NoLC,
                'Linea_Credito' => $pagare->Linea_Credito,
                'Capital' => $pagare->Capital,
                'NoCuotas' => $pagare->NoCuotas,
                'ValorCuota' => $pagare->ValorCuota,
                'Tasa' => $pagare->Tasa,
                'Nomina' => $pagare->Nomina,
                'Direccion' => $pagare->Direccion,
                'TelFijo' => $pagare->TelFijo,
                'Fecha1Cuota' => $pagare->Fecha1Cuota,
                'FechaUltimaCuota' => $pagare->FechaUltimaCuota,
                'Celular' => $pagare->Celular,
                'Correo' => $correo,
                'GeneradorPagare' => $pagare->GeneradorPagare,
                'Aprobado' => $pagare->Aprobado,
                'FechaAccion' => $pagare->FechaAccion,
                'FechaReporte' => $pagare->FechaReporte,
                'ID_Persona' => $pagare->ID_Persona,
            ]
        ]);
    }



    public function showUsers($email)
    {
        $usuarios = User::select('id','email', 'password', 'rol', 'agenciau', 'name')
                        ->where('email', $email)
                        ->get();
    
        $usuarios = $usuarios->map(function($usuario) {
            return [
                'id' => $usuario->id,
                'email' => strtolower($usuario->email),
                'password' => $usuario->password,
                'rol' => $usuario->rol,
                'agenciau' => $usuario->agenciau,
                'name' => $usuario->name,
            ];
        });
    

        if ($usuarios->isEmpty()) {
            return response()->json(['status' => 404, 'persona' => 'No hay usuarios existentes.']);
        }
    

        return response()->json(['status' => 200, 'usuarios' => $usuarios]);
    }
    
    
    
}
