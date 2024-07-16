<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo8;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;


class CRUDCredito extends Controller
{
    public function data(){
        $user = DB::select("
        SELECT A.ID, A.Inspektor, A.ConsecutivoRC, A.ObRC, A.Observaciones, A.FechaCorreo, A.TipoAsociado, A.Cedula, A.Linea, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado, A.Activado,
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

    // public function datosPagare() {



    //     //api intentos
    //     $attempts = 0;
    //     $maxAttempts = 3; //INTENTOS MAXIMOS
    //     $retryDelay = 300; // Milisegundos

    //     do {
    //         try {
    //             //$response = Http::get('http://app.coopserp.com/conexion_s400/api/infopagare/'.$noagencia);
    //              $response = Http::get('http://app.coopserp.com/conexion_s400/api/infopagare/');
    //             $datapagare = $response->json()['pagares'];
    //             break;
    //         } catch (\Exception $e) {
    //             $attempts++;
    //             usleep($retryDelay * 1000);
    //         }
    //         } while ($attempts < $maxAttempts);





    //     // Iterar sobre cada registro en $data y almacenar en la base de datos
    //     foreach ($datapagare as $registro) {
    //         //variables a usar:
    //         $agencia = $registro['AGENCIA'];
    //         $cuenta = $registro['CUENTA'];
    //         $cedula = $registro['CEDULA'];
    //         $nombres = $registro['NOMBRES'];
    //         $idpagare = $registro['IDPAGARE'];
    //         $linea = $registro['LINEA'] . ' - ' . $registro['LINEANOM'];
    //         $capital = $registro['CAPITAL'];
    //         $ncuotas = $registro['NCUOTAS'];
    //         $vcuotas = $registro['VCUOTAS'];
    //         $tasaAPI = $registro['TASA'];
    //         $estado = $registro['ESTADO'];
    //         $nomina = $registro['NOMINA'];
    //         $entidad = $registro['ENTIDAD'];
    //         $dependencia = $registro['DEPENDENCIA'];
    //         $direccion = $registro['DIRECCION'];
    //         $fijo = $registro['FIJO'];
    //         $pcuota = $registro['PCUOTA'];
    //         $ucuota = $registro['UCUOTA'];
    //         $usuario = $registro['USUARIO'];
    //         $garantia = $registro['GARANTIA'];
    //         $interes = $registro['INTERES'];
    //         $correo = $registro['CORREO'];
    //         $celular = $registro['CELULAR'];
    //         $nomNomina = $registro['NOMNOMINA'];

    //         $foundMatchingPagare = false;


    //         $existingPagare = DB::select('SELECT ExisteDatacredito, ID_Pagare, CuentaCoop FROM pagareprueba WHERE CuentaCoop = ? AND ID_Pagare = ?', [$registro['CUENTA'], $registro['IDPAGARE']]);

    //         if (!empty($existingPagare)) {

    //             $existePersona = DB::select('SELECT Cedula, Score FROM persona WHERE Cedula = ?', [$cedula]);
    //             foreach ($existingPagare as $pagare) {
    //                 if($pagare->ExisteDatacredito == 1 && !empty($existePersona)){
    //                     DB::delete("DELETE FROM pagareprueba WHERE CuentaCoop = ? AND ID_Pagare = ?",[$registro['CUENTA'], $registro['IDPAGARE']]);
    //                     $foundMatchingPagare = true;
    //                 }


    //                 if($pagare->ExisteDatacredito == 2 && $existePersona[0]->Score != null){
    //                     DB::delete("DELETE FROM pagareprueba WHERE CuentaCoop = ? AND ID_Pagare = ?",[$registro['CUENTA'], $registro['IDPAGARE']]);
    //                     $foundMatchingPagare = true;
    //                 }

    //                 if ($pagare->ID_Pagare == $idpagare && $pagare->CuentaCoop == $cuenta) {

    //                     // Si encuentra un pagare con los mismos ID_Pagare y CuentaCoop, marca la bandera como verdadera.
    //                     $foundMatchingPagare = true;
    //                 }
    //             }

    //         }
    //         else{

    //         if (!$foundMatchingPagare) {

    //             $existingPerson = DB::select('SELECT Cedula, ID, Score FROM persona WHERE Cedula = ?', [$registro['CEDULA']]);

    //             //EXTRAIGO LA INFORMACION DE LA API
    //             $cuota1 = $registro['PCUOTA'];
    //             $cuotaFinal = $registro['UCUOTA'];

    //             //PARA QUE LAS FECHAS SE CONVIERTAN EN TEXTO
    //             $codigoAnio = substr($cuota1, 0, 1);
    //             $anio = substr($cuota1, 1, 2);
    //             $mes = substr($cuota1, 3, 2);
    //             $dia = substr($cuota1, 5, 2);

    //             $codigoAnio2 = substr($cuotaFinal, 0, 1);
    //             $anio2 = substr($cuotaFinal, 1, 2);
    //             $mes2 = substr($cuotaFinal, 3, 2);
    //             $dia2 = substr($cuotaFinal, 5, 2);

    //             $anioReal = 2000 + (int)$anio;

    //             $anioReal2 = 2000 + (int)$anio2;

    //             $meses = [
    //                 '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
    //                 '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
    //                 '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
    //                 '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
    //             ];

    //             $nombreMes = $meses[$mes];

    //             $nombreMes2 = $meses[$mes2];

    //             //FECHAS CON FORMATO TEXTO
    //             $fechaFormateada = $nombreMes . " " . (int)$dia . " del " . $anioReal;

    //             $fechaFormateada2 = $nombreMes2 . " " . (int)$dia2 . " del " . $anioReal2;

    //             //VALIDO SI LA NOMINA EXISTE EN LA BASE DE DATOS LOCAL PARA ASIGNAR FECHA DE REPORTE POSTERIOR
    //             $NOMINA = $registro['NOMINA'];
    //             $DEPENDENCIA = $registro['DEPENDENCIA'];
    //             $ENTIDAD = $registro['ENTIDAD'];

    //             // API S400 PARA VALIDAR FECHANACIMIENTO Y DEUDATOTAL
    //             $url = env('URL_SERVER_API');
    //             $attempts = 0;
    //             $maxAttempts = 3; // INTENTOS MÁXIMOS
    //             $retryDelay = 500; // Milisegundos

    //             $estadoEdad = null;
    //             $deudatotalAPI = null;

    //             do {
    //                 try {
    //                     $response = Http::get($url . 'fechan/' . $registro['CUENTA']);
    //                     $data = $response->json();

    //                     $response2 = Http::get($url . 'deudatotal/' . $registro['CUENTA']);
    //                     $data2 = $response2->json();

    //                     $estadoEdad = $data['status'];
    //                     $deudatotalAPI = $data2['deudatotal'];

    //                     // Si llegamos aquí, la solicitud fue exitosa, podemos salir del bucle.
    //                     break;
    //                 } catch (\Exception $e) {
    //                     $attempts++;
    //                     usleep($retryDelay * 1000);
    //                 }
    //             } while ($attempts < $maxAttempts);

    //                 //ES EL TOTAL DE LO DE ARRIBA MAS EL CAPITAL QUE APENAS SE SOLICITA
    //                 $deudatotal = $deudatotalAPI + $registro['CAPITAL'];
    //                 if($estadoEdad == 200 && $deudatotal >= 20000000){
    //                     $edad = 1;
    //                     $deuda = 1;
    //                 }else if($estadoEdad == 200 && $deudatotal >= 50000000){
    //                     $edad = 1;
    //                     $deuda = 2;
    //                 }else if ($estadoEdad == 200){
    //                     $edad = 1;
    //                     $deuda = null;
    //                 }else if ($deudatotal >= 20000000){
    //                     $edad = null;
    //                     $deuda = 1;
    //                 }else if ($deudatotal >= 50000000){
    //                     $edad = null;
    //                     $deuda = 2;
    //                 }else{
    //                     $edad = null;
    //                     $deuda = null;
    //                 }

    //             //VALIDO SI EXISTE EN LA BD DE DATACREDITO
    //             if (!empty($existingPerson)) {

    //                 $persona = $existingPerson[0];
    //                 if ($persona->Score != null) {

    //                         //VALIDO SI EL SCORE ES MAYOR O IGUAL DE 650
    //                         if ($persona->Score >= 650) {

    //                             //VALIDO QUE SEA IGUAL A LO QUE ESTA EN LA BD DE DATACREDITO EN LA TABLA S400_PLANO
    //                             $existeNominaDepen = DB::select('SELECT CODNOMINA, CODDEPENDENCIA, NOMDEPENDENCIA, CODENTIDAD FROM s400_plano WHERE CODNOMINA = ? AND CODDEPENDENCIA = ? AND CODENTIDAD = ?', [$NOMINA, $DEPENDENCIA, $ENTIDAD]);

    //                             //SI LA NOMINA Y DEPENDENCIA EXISTE EN EL ARCHIVO PLANO
    //                             if (!empty($existeNominaDepen)) {

    //                                 $existeDia = DB::select('SELECT DIAS, MESANTERIOR, ENTREMES FROM s400_plano WHERE CODNOMINA = ? AND CODDEPENDENCIA = ? AND CODENTIDAD = ?', [$NOMINA, $DEPENDENCIA, $ENTIDAD]);
    //                                 //FECHA MES ACTUAL
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 0 && $existeDia[0]->ENTREMES == 0) {
    //                                     //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                                     $fechadelCredito = Carbon::now('America/Bogota');
    //                                     $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                                     Carbon::setLocale('es');
    //                                     $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                                     //DIA DE REPORTE DE LA NOMINA
    //                                     $diaReporte = max(1, $existeDia[0]->DIAS);

    //                                     //se asigna la fecha de reporte de manera automatica
    //                                     $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);
    //                                     $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;
    //                                     Carbon::setLocale('es');
    //                                     $fechaReporteString = $fechaReporte->translatedFormat('F d Y');


    //                                     //fecha primera cuota
    //                                     $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);


    //                                     //interes proporcional
    //                                     $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                                     $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                                     $tasa = $registro['TASA'];
    //                                     $capital = $registro['CAPITAL'];

    //                                     $tasa = str_replace(',', '.', $tasa);
    //                                     $tasa = floatval($tasa);

    //                                     $tasa = $tasa / 100;

    //                                     $capital = floatval($capital);

    //                                     $interval = $fechadelCredito->diff($endOfMonth);
    //                                     $c30 = $interval->days;

    //                                     $cuotaMensual = $capital * $tasa;
    //                                     $cuotaDiaria = $cuotaMensual / 30;
    //                                     $interesProporcional = $cuotaDiaria * $c30;

    //                                     $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;

    //                                     // Calcular el último día del mes siguiente a la fecha del crédito
    //                                     $ultimoDiaMesSiguienteCredito = $fechadelCredito->copy()->addMonth()->endOfMonth();

    //                                     // Calcular el último día del mes de la primera cuota
    //                                     $ultimoDiaMesPrimeraCuota = $fecha1eraCuota->copy()->endOfMonth();

    //                                     // Comparar si son iguales
    //                                     //resultado
    //                                     $resultado = $ultimoDiaMesSiguienteCredito->eq($ultimoDiaMesPrimeraCuota) ? true : false;

    //                                     // Ajustar $fechaReporte basado en si la fecha del crédito es mayor que $fechaReporteActual
    //                                     $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;

    //                                     // Implementar la lógica de la fórmula de Excel
    //                                     $condicion1 = $fechadelCredito->lt($fechaReporte); // B14 < E15
    //                                     // La condición 2 es redundante y siempre verdadera, por lo que la omitimos
    //                                     $condicion3 = $fechaReporte->diffInDays($fechadelCredito) <= 31; // DIAS(E15;B14)<=31

    //                                     // Comprobar si todas las condiciones relevantes son verdaderas
    //                                     $resultado1 = $condicion1 && $condicion3 ? true : false;

    //                                     // Primera condición externa
    //                                     if ($fechadelCredito->gt($fechaReporte)) {
    //                                         $resultado2 = false;
    //                                     } else {
    //                                         // Condición interna
    //                                         $ultimoDiaMesPrimeraCuota = $fecha1eraCuota->copy()->endOfMonth();
    //                                         $ultimoDiaMesSiguienteReporte = $fechaReporte->copy()->addMonth()->endOfMonth();

    //                                         $diasDiferencia = $fechaReporte->diffInDays($fechadelCredito, false);

    //                                         if ($ultimoDiaMesPrimeraCuota->eq($ultimoDiaMesSiguienteReporte) && $diasDiferencia <= 31) {
    //                                             $resultado2 = true;
    //                                         } else {
    //                                             $resultado2 = false;
    //                                         }
    //                                     }


    //                                     // Condición 1: Comprobar si el último día del mes de la fecha en C14 es igual al último día del mes siguiente a E15
    //                                     $condicion3 = $fecha1eraCuota->copy()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth());

    //                                     // Condición 2: La diferencia en días entre E15 y B14 es de 31 días o menos
    //                                     $condicion4 = $fechaReporte->diffInDays($fechadelCredito, false) <= 31;

    //                                     // Resultado basado en las condiciones
    //                                     $resultado3 = ($condicion3 || $condicion4) ? true : false ;


    //                                     // Calcular el último día del mes de B14
    //                                     $ultimoDiaMesB14 = $fechadelCredito->copy()->endOfMonth();

    //                                     // Calcular el último día del mes anterior a E15
    //                                     $ultimoDiaMesAnteriorE15 = $fechaReporte->copy()->subMonth()->endOfMonth();

    //                                     // Verificar las condiciones
    //                                     $condicion5 = $ultimoDiaMesB14->eq($ultimoDiaMesAnteriorE15);
    //                                     $condicion6 = $fechaReporte->gte($fechadelCredito);
    //                                     $condicion7 = $fechaReporte->diffInDays($fechadelCredito) <= 31;

    //                                     // Evaluar si todas las condiciones son verdaderas
    //                                     $resultado4 = $condicion5 && $condicion6 && $condicion7 ? true : false ;


    //                                     // Primer nivel de comprobación
    //                                     if ($fechadelCredito->gt($fechaReporte)) {
    //                                         $resultado5 = false;
    //                                     } else {
    //                                         // Segundo nivel de comprobación
    //                                         $ultimoDiaMesC14 = $fecha1eraCuota->endOfMonth(); // Último día del mes para C14
    //                                         $ultimoDiaMesSiguienteB14 = $fechadelCredito->copy()->addMonth()->endOfMonth(); // Último día del mes siguiente a B14

    //                                         $condicionA = $ultimoDiaMesC14->eq($ultimoDiaMesSiguienteB14);
    //                                         $condicionB = $fechaReporte->diffInDays($fechadelCredito) <= 31;

    //                                         $resultado5 = $condicionA && $condicionB ? true : false ;
    //                                     }

    //                                     $NoAgencia = $registro['AGENCIA'];
    //                                     //dd($fechaReporteString, $fechaStringCredito, $fecha1eraCuota);

    //                                     if (($resultado == true && $resultado1 == true && $resultado2 == true) || ($resultado3 == true && $resultado4 == true &&  $resultado5  == true)) {
    //                                     //NUMERO DE AGENCIA

    //                                         $razon = 'Aprobado por score(>=650) alto y por cumplir las fechas.';
    //                                         if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 1',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 2',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 3',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 4',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 5',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }
    //                                     //llave que cierra la condicion de fecha actual
    //                                     }else{
    //                                         if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 0) {
    //                                             $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth()->endOfMonth();
    //                                             Carbon::setLocale('es');
    //                                             $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                         }
    //                                         $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";


    //                                         if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 1',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 2',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 3',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 4',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 5',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }

    //                                     }
    //                                 //llave que cierra lo del mesanterior ==0
    //                                 }
    //                                 //FECHA MES SIGUIENTE
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 1) {

    //                                     //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                                     $fechadelCredito = Carbon::now('America/Bogota');
    //                                     $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                                     Carbon::setLocale('es');
    //                                     $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                                     //DIA REPORTE DE LA S400 PLANO
    //                                     $diaReporte = max(1, $existeDia[0]->DIAS);
    //                                     $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);

    //                                     $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;
    //                                     Carbon::setLocale('es');
    //                                     $fechaReporteString = $fechaReporte->translatedFormat('F d Y');

    //                                     //fecha primera cuota
    //                                     $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);
    //                                     Carbon::setLocale('es');
    //                                     $fechaString2 = $fecha1eraCuota->format('d/m/Y');
    //                                     $fechaCarbon2 = Carbon::createFromFormat('d/m/Y', $fechaString2);
    //                                     $formateada = $fechaReporte->format('d/m/Y');
    //                                     $formateadaCarbon = Carbon::createFromFormat('d/m/Y', $formateada);

    //                                     //interes proporcional
    //                                     $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                                     $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                                     $tasa = $registro['TASA'];
    //                                     $capital = $registro['CAPITAL'];

    //                                     $tasa = str_replace(',', '.', $tasa);
    //                                     $tasa = floatval($tasa);

    //                                     $tasa = $tasa / 100;

    //                                     $capital = floatval($capital);

    //                                     $interval = $fechadelCredito->diff($endOfMonth);
    //                                     $c30 = $interval->days;

    //                                     $cuotaMensual = $capital * $tasa;
    //                                     $cuotaDiaria = $cuotaMensual / 30;
    //                                     $interesProporcional = $cuotaDiaria * $c30;

    //                                     $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;

    //                                     // Fórmula 1
    //                                     $resultado1 = (
    //                                         $fechaCarbon2->copy()->endOfMonth()->eq($formateadaCarbon->copy()->addMonths(2)->endOfMonth()) &&
    //                                         (
    //                                             $fechadelCredito->copy()->addMonths(3)->endOfMonth() instanceof Carbon &&
    //                                             $fechadelCredito->copy()->addMonths(2)->endOfMonth() instanceof Carbon &&
    //                                             $formateadaCarbon->diffInDays($fechadelCredito) <= 30
    //                                         )
    //                                     );


    //                                     // Fórmula 2
    //                                     $resultado2 = (
    //                                         Carbon::now('America/Bogota')->endOfMonth(2)->eq($fecha1eraCuota->endOfMonth()) &&
    //                                         $fechaReporte->gte($fechadelCredito) &&
    //                                         $fechaReporte->diffInDays($fechadelCredito) <= 30
    //                                     ) ?  true : false ;

    //                                     // Fórmula 3
    //                                     $resultado3 = ($fechadelCredito->gt($fecha1eraCuota)) ? false : (
    //                                         (Carbon::now('America/Bogota')->endOfMonth(0)->eq($fechaReporte->endOfMonth()) ||
    //                                             $fechaReporte->diffInDays($fechadelCredito) <= 30) ? true : false
    //                                     );

    //                                     $NoAgencia = $registro['AGENCIA'];
    //                                     if (($resultado1 == true && $resultado2 == true && $resultado3 == true) || ($resultado1 == false && $resultado2 == true && $resultado3 == true) || ($resultado1 == true && $resultado2 == false && $resultado3 == true) || ($resultado1 == true && $resultado2 == true && $resultado3 == false) || ($resultado1 == false && $resultado2 == true && $resultado3 == false)) {

    //                                         $razon = 'Aprobado por score(>=650) alto y por cumplir las fechas.';
    //                                         //NUMERO DE AGENCIA
    //                                         if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 1',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 2',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 3',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 4',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 5',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }
    //                                     }else{
    //                                         if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 1) {
    //                                             $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth(2)->endOfMonth();
    //                                             Carbon::setLocale('es');
    //                                             $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                         }

    //                                         $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";
    //                                         if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 1',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 2',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 3',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 4',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 5',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }

    //                                         //llave que cierra las condiciones de mesanterior == 1
    //                                     }
    //                                 //llave que cierra mesanterior == 1
    //                                 }
    //                                 //FECHA ENTREMES
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->ENTREMES == 1) {
    //                                     //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                                     $fechadelCredito = Carbon::now('America/Bogota');
    //                                     $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                                     Carbon::setLocale('es');
    //                                     $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                                     //DIA REPORTE
    //                                     $diaReporte = max(1, $existeDia[0]->DIAS);
    //                                     $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);

    //                                     if ($fechadelCredito->format('m') != $fechaReporteActual->format('m')) {
    //                                         $fechaReporteActual->addMonth();
    //                                     }
    //                                     $fechaReporte = $fechaReporteActual;

    //                                     Carbon::setLocale('es');
    //                                     $fechaReporteString = $fechaReporte->translatedFormat('F d Y');

    //                                     //fechaprimera cuota
    //                                     $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);
    //                                     Carbon::setLocale('es');
    //                                     $fechaString2 = $fecha1eraCuota->format('d/m/Y');
    //                                     $fechaCarbon2 = Carbon::createFromFormat('d/m/Y', $fechaString2);

    //                                     //interesproporcional
    //                                     $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                                     $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                                     $tasa = $registro['TASA'];
    //                                     $capital = $registro['CAPITAL'];

    //                                     $tasa = str_replace(',', '.', $tasa);
    //                                     $tasa = floatval($tasa);

    //                                     $tasa = $tasa / 100;

    //                                     $capital = floatval($capital);

    //                                     $interval = $fechadelCredito->diff($endOfMonth);
    //                                     $c30 = $interval->days;

    //                                     $cuotaMensual = $capital * $tasa;
    //                                     $cuotaDiaria = $cuotaMensual / 30;
    //                                     $interesProporcional = $cuotaDiaria * $c30;

    //                                     $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;


    //                                     $NoAgencia = $registro['AGENCIA'];

    //                                     $result = $fechadelCredito > $fechaReporte;


    //                                     $result1 = $fechaReporte->lt($fechadelCredito) &&
    //                                         ($fechaReporte->diffInMonths($fechaReporte, false) === 1 ||
    //                                             $fechaReporte->diffInDays($fechadelCredito) <= 30);


    //                                     $result2 =  $fechaReporte->gt($fechadelCredito) || ($fechaReporte->diffInDays($fechadelCredito) <= 30 && $fecha1eraCuota->diffInMonths($fechadelCredito) == 2);

    //                                     //CUARTO CONDICIONAL
    //                                     $resultado3 = $fechadelCredito->copy()->addMonth()->endOfMonth()->eq($fechaCarbon2->copy()->endOfMonth());

    //                                     //QUINTO
    //                                     $resultado4 = $fechadelCredito->lt($fechaReporte) && $fechaReporte->copy()->addMonth()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth()) && $fechaReporte->diffInDays($fechadelCredito) <= 30;


    //                                     //SEXTO
    //                                     $resultado5 = $fechadelCredito->gt($fechaReporte) ? false : ($fechaCarbon2->copy()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth()) && $fechaReporte->diffInDays($fechadelCredito) <= 30);

    //                                     if (($result == true && $result1 == true && $result2  == true) || ($resultado3 == true && $resultado4 == true &&  $resultado5  == true)) {

    //                                         $razon = 'Aprobado por score(>=650) alto y por cumplir las fechas.';
    //                                         if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA

    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 1',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                     DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 2',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 3',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 4',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'edad' => $edad,
    //                                                     'deuda' => $deuda,
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 1,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 5',
    //                                                     'AutorizacionGerente' => 0,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }
    //                                     }else{
    //                                         if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->ENTREMES == 1) {
    //                                             $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth(2)->endOfMonth();
    //                                             Carbon::setLocale('es');
    //                                             $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                         }
    //                                         $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";

    //                                         if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA

    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 1',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                     DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 2',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 3',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 4',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 5',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }

    //                                     }
    //                                 //llave que cierra entremes
    //                                 }

    //                             //llave que cierra si existe la nomina en s400_plano
    //                             }else{
    //                                 $usuarioActual = Auth::user();
    //                                 $nombre = $usuarioActual->name;
    //                                 $rol = $usuarioActual->rol;
    //                                 $cedulaagregada = $request->Cedula_Persona;
    //                                 date_default_timezone_set('America/Bogota');
    //                                 $ip = $_SERVER['REMOTE_ADDR'];
    //                                 $fechaHoraActual = date('Y-m-d H:i:s');
    //                                 $agencia = $usuarioActual->agenciau;
    //                                 $login = DB::insert("INSERT INTO auditoria (Hora_login, Usuario_nombre, Usuario_Rol, AgenciaU, Acción_realizada, Hora_Accion, Cedula_Registrada, cerro_sesion, IP) VALUES (?, ?, ?, ?, 'CreoNuevaNomina', ?, ?, ?, ?)", [
    //                                     null,
    //                                     $nombre,
    //                                     $rol,
    //                                     $agencia,
    //                                     $fechaHoraActual,
    //                                     $cedulaagregada,
    //                                     null,
    //                                     $ip
    //                                 ]);

    //                                 $insertNomiDepe = DB::insert("INSERT INTO s400_plano (CODNOMINA, NOMBRENOMINA, CODDEPENDENCIA, NOMDEPENDENCIA, CODENTIDAD) VALUES (?, ?, ?, ?, ?)", [
    //                                     $NOMINA,
    //                                     $NOMBRENOMINA,
    //                                     $NODEPENDENCIA,
    //                                     $DEPENDENCIA,
    //                                     $ENTIDAD
    //                                 ]);
    //                                 $foundMatchingPagare = true;
    //                             }
    //                         //llave que cierra el score si es >=650
    //                         }else if($persona->Score < 650){
    //                             ;
    //                             //VALIDO QUE SEA IGUAL A LO QUE ESTA EN LA BD DE DATACREDITO EN LA TABLA S400_PLANO
    //                             $existeNominaDepen = DB::select('SELECT CODNOMINA, CODDEPENDENCIA, NOMDEPENDENCIA, CODENTIDAD FROM s400_plano WHERE CODNOMINA = ? AND CODDEPENDENCIA = ? AND CODENTIDAD = ?', [$NOMINA, $DEPENDENCIA, $ENTIDAD]);

    //                             //SI LA NOMINA Y DEPENDENCIA EXISTE EN EL ARCHIVO PLANO
    //                             if (!empty($existeNominaDepen)) {

    //                                 $existeDia = DB::select('SELECT DIAS, MESANTERIOR, ENTREMES FROM s400_plano WHERE CODNOMINA = ? AND CODDEPENDENCIA = ? AND CODENTIDAD = ?', [$NOMINA, $DEPENDENCIA, $ENTIDAD]);

    //                                 //FECHA MES ACTUAL
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 0 && $existeDia[0]->ENTREMES == 0) {

    //                                     //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                                     $fechadelCredito = Carbon::now('America/Bogota');
    //                                     $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                                     Carbon::setLocale('es');
    //                                     $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                                     //DIA DE REPORTE DE LA NOMINA
    //                                     $diaReporte = max(1, $existeDia[0]->DIAS);

    //                                     //se asigna la fecha de reporte de manera automatica
    //                                     $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);
    //                                     $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;
    //                                     Carbon::setLocale('es');
    //                                     $fechaReporteString = $fechaReporte->translatedFormat('F d Y');

    //                                     //fechar primera cuota
    //                                     $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);


    //                                     //interes proporcional
    //                                     $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                                     $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                                     $tasa = $registro['TASA'];
    //                                     $capital = $registro['CAPITAL'];

    //                                     $tasa = str_replace(',', '.', $tasa);
    //                                     $tasa = floatval($tasa);

    //                                     $tasa = $tasa / 100;

    //                                     $capital = floatval($capital);

    //                                     $interval = $fechadelCredito->diff($endOfMonth);
    //                                     $c30 = $interval->days;

    //                                     $cuotaMensual = $capital * $tasa;
    //                                     $cuotaDiaria = $cuotaMensual / 30;
    //                                     $interesProporcional = $cuotaDiaria * $c30;

    //                                     $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;

    //                                     // Calcular el último día del mes siguiente a la fecha del crédito
    //                                     $ultimoDiaMesSiguienteCredito = $fechadelCredito->copy()->addMonth()->endOfMonth();

    //                                     // Calcular el último día del mes de la primera cuota
    //                                     $ultimoDiaMesPrimeraCuota = $fecha1eraCuota->copy()->endOfMonth();

    //                                     // Comparar si son iguales
    //                                     //resultado
    //                                     $resultado = $ultimoDiaMesSiguienteCredito->eq($ultimoDiaMesPrimeraCuota) ? true : false;



    //                                     // Ajustar $fechaReporte basado en si la fecha del crédito es mayor que $fechaReporteActual
    //                                     $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;

    //                                     // Implementar la lógica de la fórmula de Excel
    //                                     $condicion1 = $fechadelCredito->lt($fechaReporte); // B14 < E15
    //                                     // La condición 2 es redundante y siempre verdadera, por lo que la omitimos
    //                                     $condicion3 = $fechaReporte->diffInDays($fechadelCredito) <= 31; // DIAS(E15;B14)<=31

    //                                     // Comprobar si todas las condiciones relevantes son verdaderas
    //                                     $resultado1 = $condicion1 && $condicion3 ? true : false;




    //                                     // Primera condición externa
    //                                     if ($fechadelCredito->gt($fechaReporte)) {
    //                                         $resultado2 = false;
    //                                     } else {
    //                                         // Condición interna
    //                                         $ultimoDiaMesPrimeraCuota = $fecha1eraCuota->copy()->endOfMonth();
    //                                         $ultimoDiaMesSiguienteReporte = $fechaReporte->copy()->addMonth()->endOfMonth();

    //                                         $diasDiferencia = $fechaReporte->diffInDays($fechadelCredito, false);

    //                                         if ($ultimoDiaMesPrimeraCuota->eq($ultimoDiaMesSiguienteReporte) && $diasDiferencia <= 31) {
    //                                             $resultado2 = true;
    //                                         } else {
    //                                             $resultado2 = false;
    //                                         }
    //                                     }


    //                                     // Condición 1: Comprobar si el último día del mes de la fecha en C14 es igual al último día del mes siguiente a E15
    //                                     $condicion3 = $fecha1eraCuota->copy()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth());

    //                                     // Condición 2: La diferencia en días entre E15 y B14 es de 31 días o menos
    //                                     $condicion4 = $fechaReporte->diffInDays($fechadelCredito, false) <= 31;

    //                                     // Resultado basado en las condiciones
    //                                     $resultado3 = ($condicion3 || $condicion4) ? true : false ;


    //                                     // Calcular el último día del mes de B14
    //                                     $ultimoDiaMesB14 = $fechadelCredito->copy()->endOfMonth();

    //                                     // Calcular el último día del mes anterior a E15
    //                                     $ultimoDiaMesAnteriorE15 = $fechaReporte->copy()->subMonth()->endOfMonth();

    //                                     // Verificar las condiciones
    //                                     $condicion5 = $ultimoDiaMesB14->eq($ultimoDiaMesAnteriorE15);
    //                                     $condicion6 = $fechaReporte->gte($fechadelCredito);
    //                                     $condicion7 = $fechaReporte->diffInDays($fechadelCredito) <= 31;

    //                                     // Evaluar si todas las condiciones son verdaderas
    //                                     $resultado4 = $condicion5 && $condicion6 && $condicion7 ? true : false ;


    //                                     // Primer nivel de comprobación
    //                                     if ($fechadelCredito->gt($fechaReporte)) {
    //                                         $resultado5 = false;
    //                                     } else {
    //                                         // Segundo nivel de comprobación
    //                                         $ultimoDiaMesC14 = $fecha1eraCuota->endOfMonth(); // Último día del mes para C14
    //                                         $ultimoDiaMesSiguienteB14 = $fechadelCredito->copy()->addMonth()->endOfMonth(); // Último día del mes siguiente a B14

    //                                         $condicionA = $ultimoDiaMesC14->eq($ultimoDiaMesSiguienteB14);
    //                                         $condicionB = $fechaReporte->diffInDays($fechadelCredito) <= 31;

    //                                         $resultado5 = $condicionA && $condicionB ? true : false ;
    //                                     }

    //                                     if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 0) {
    //                                         $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth()->endOfMonth();
    //                                         Carbon::setLocale('es');
    //                                         $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                     }
    //                                     //dd($resultado,$resultado1, $resultado2, $resultado3, $resultado4, $resultado5);
    //                                     //NUMERO DE AGENCIA
    //                                     $NoAgencia = $registro['AGENCIA'];
    //                                     if ((($resultado == true && $resultado1 == true && $resultado2 == true) || ($resultado3 == true && $resultado4 == true && $resultado5 == true))){
    //                                         //dd($nombres);
    //                                         $razon = "Rechazado por score bajo.";
    //                                         if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 1',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 2',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 3',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 4',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 5',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }
    //                                     }else{
    //                                         $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";
    //                                         if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 1',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 2',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 3',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 4',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 5',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }
    //                                     }
    //                                 //llave que cierra lo del mesanterior ==0
    //                                 }
    //                                 //FECHA MES SIGUIENTE
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 1) {

    //                                     //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                                     $fechadelCredito = Carbon::now('America/Bogota');
    //                                     $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                                     Carbon::setLocale('es');
    //                                     $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                                     //DIA REPORTE DE LA S400 PLANO
    //                                     $diaReporte = max(1, $existeDia[0]->DIAS);
    //                                     $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);

    //                                     $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;
    //                                     Carbon::setLocale('es');
    //                                     $fechaReporteString = $fechaReporte->translatedFormat('F d Y');

    //                                     $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);
    //                                     $formateada = $fechaReporte->format('d/m/Y');
    //                                     $formateadaCarbon = Carbon::createFromFormat('d/m/Y', $formateada);
    //                                     Carbon::setLocale('es');
    //                                     $fechaString2 = $fecha1eraCuota->format('d/m/Y');
    //                                     $fechaCarbon2 = Carbon::createFromFormat('d/m/Y', $fechaString2);

    //                                     //interes proporcional
    //                                     $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                                     $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                                     $tasa = $registro['TASA'];
    //                                     $capital = $registro['CAPITAL'];

    //                                     $tasa = str_replace(',', '.', $tasa);
    //                                     $tasa = floatval($tasa);

    //                                     $tasa = $tasa / 100;

    //                                     $capital = floatval($capital);

    //                                     $interval = $fechadelCredito->diff($endOfMonth);
    //                                     $c30 = $interval->days;

    //                                     $cuotaMensual = $capital * $tasa;
    //                                     $cuotaDiaria = $cuotaMensual / 30;
    //                                     $interesProporcional = $cuotaDiaria * $c30;

    //                                     $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;

    //                                     //NUMERO DE AGENCIA
    //                                     $NoAgencia = $registro['AGENCIA'];

    //                                     // Fórmula 1
    //                                     $resultado1 = (
    //                                         $fechaCarbon2->copy()->endOfMonth()->eq($formateadaCarbon->copy()->addMonths(2)->endOfMonth()) &&
    //                                         (
    //                                             $fechadelCredito->copy()->addMonths(3)->endOfMonth() instanceof Carbon &&
    //                                             $fechadelCredito->copy()->addMonths(2)->endOfMonth() instanceof Carbon &&
    //                                             $formateadaCarbon->diffInDays($fechadelCredito) <= 30
    //                                         )
    //                                     );


    //                                     // Fórmula 2
    //                                     $resultado2 = (
    //                                         Carbon::now('America/Bogota')->endOfMonth(2)->eq($fecha1eraCuota->endOfMonth()) &&
    //                                         $fechaReporte->gte($fechadelCredito) &&
    //                                         $fechaReporte->diffInDays($fechadelCredito) <= 30
    //                                     ) ?  true : false ;

    //                                     // Fórmula 3
    //                                     $resultado3 = ($fechadelCredito->gt($fecha1eraCuota)) ? false : (
    //                                         (Carbon::now('America/Bogota')->endOfMonth(0)->eq($fechaReporte->endOfMonth()) ||
    //                                             $fechaReporte->diffInDays($fechadelCredito) <= 30) ? true : false
    //                                     );
    //                                     if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 1) {
    //                                         $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth(2)->endOfMonth();
    //                                         Carbon::setLocale('es');
    //                                         $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                     }
    //                                     // dd($resultado1, $resultado2, $resultado3);
    //                                     if ($resultado1 == true && $resultado2 == true && $resultado3 == true) {

    //                                         if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 1) {
    //                                                 $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth(2)->endOfMonth();
    //                                                 Carbon::setLocale('es');
    //                                                 $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');


    //                                             $razon = "Rechazado por score bajo.";
    //                                             if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                                 if (empty($existingPagare)) {
    //                                                     //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                     $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                     $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                     DB::table('pagareprueba')->insert([
    //                                                         'FechaReporte' => $fechaReporteString,
    //                                                         'Aprobado' => 0,
    //                                                         'Razon' => $razon,
    //                                                         'CoorAsignada' => 'Coordinacion 1',
    //                                                         'AutorizacionGerente' => 1,
    //                                                         'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                         'FechaAccion'=> $fechaStringCredito,
    //                                                         'Garantia' => $garantia,
    //                                                         'NoAgencia' => $agencia,
    //                                                         'NombreAgencia' => $nombreAgencia,
    //                                                         'CuentaCoop' => $cuenta,
    //                                                         'Cedula_Persona' => $cedula,
    //                                                         'NombreCompleto' => $nombres,
    //                                                         'ID_Pagare' => $idpagare,
    //                                                         'NoLC' => $registro['LINEA'],
    //                                                         'Linea_Credito' => $registro['LINEANOM'],
    //                                                         'Capital' => $capital,
    //                                                         'NoCuotas' => $ncuotas,
    //                                                         'ValorCuota' => $vcuotas,
    //                                                         'Tasa' => $tasaAPI,
    //                                                         'FechaCredito' => $fechaStringCredito,
    //                                                         'Nomina' => $nomina .' - '.$nomNomina,
    //                                                         'Direccion' => $direccion,
    //                                                         'TelFijo' => $fijo,
    //                                                         'Fecha1Cuota' => $fechaFormateada,
    //                                                         'FechaUltimaCuota' => $fechaFormateada2,
    //                                                         'Celular' => $celular,
    //                                                         'Correo' => $correo,
    //                                                         'GeneradorPagare' => $usuario,
    //                                                         'ID_Persona'=> $persona->ID
    //                                                     ]);
    //                                                 }
    //                                             }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                                 if (empty($existingPagare)) {
    //                                                     //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                     $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                     $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                     DB::table('pagareprueba')->insert([
    //                                                         'FechaReporte' => $fechaReporteString,
    //                                                         'Aprobado' => 0,
    //                                                         'Razon' => $razon,
    //                                                         'CoorAsignada' => 'Coordinacion 2',
    //                                                         'AutorizacionGerente' => 1,
    //                                                         'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                         'FechaAccion'=> $fechaStringCredito,
    //                                                         'Garantia' => $garantia,
    //                                                         'NoAgencia' => $agencia,
    //                                                         'NombreAgencia' => $nombreAgencia,
    //                                                         'CuentaCoop' => $cuenta,
    //                                                         'Cedula_Persona' => $cedula,
    //                                                         'NombreCompleto' => $nombres,
    //                                                         'ID_Pagare' => $idpagare,
    //                                                         'NoLC' => $registro['LINEA'],
    //                                                         'Linea_Credito' => $registro['LINEANOM'],
    //                                                         'Capital' => $capital,
    //                                                         'NoCuotas' => $ncuotas,
    //                                                         'ValorCuota' => $vcuotas,
    //                                                         'Tasa' => $tasaAPI,
    //                                                         'FechaCredito' => $fechaStringCredito,
    //                                                         'Nomina' => $nomina .' - '.$nomNomina,
    //                                                         'Direccion' => $direccion,
    //                                                         'TelFijo' => $fijo,
    //                                                         'Fecha1Cuota' => $fechaFormateada,
    //                                                         'FechaUltimaCuota' => $fechaFormateada2,
    //                                                         'Celular' => $celular,
    //                                                         'Correo' => $correo,
    //                                                         'GeneradorPagare' => $usuario,
    //                                                         'ID_Persona'=> $persona->ID
    //                                                     ]);
    //                                                 }
    //                                             }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                                 if (empty($existingPagare)) {
    //                                                     //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                     $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                     $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                     DB::table('pagareprueba')->insert([
    //                                                         'FechaReporte' => $fechaReporteString,
    //                                                         'Aprobado' => 0,
    //                                                         'Razon' => $razon,
    //                                                         'CoorAsignada' => 'Coordinacion 3',
    //                                                         'AutorizacionGerente' => 1,
    //                                                         'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                         'FechaAccion'=> $fechaStringCredito,
    //                                                         'Garantia' => $garantia,
    //                                                         'NoAgencia' => $agencia,
    //                                                         'NombreAgencia' => $nombreAgencia,
    //                                                         'CuentaCoop' => $cuenta,
    //                                                         'Cedula_Persona' => $cedula,
    //                                                         'NombreCompleto' => $nombres,
    //                                                         'ID_Pagare' => $idpagare,
    //                                                         'NoLC' => $registro['LINEA'],
    //                                                         'Linea_Credito' => $registro['LINEANOM'],
    //                                                         'Capital' => $capital,
    //                                                         'NoCuotas' => $ncuotas,
    //                                                         'ValorCuota' => $vcuotas,
    //                                                         'Tasa' => $tasaAPI,
    //                                                         'FechaCredito' => $fechaStringCredito,
    //                                                         'Nomina' => $nomina .' - '.$nomNomina,
    //                                                         'Direccion' => $direccion,
    //                                                         'TelFijo' => $fijo,
    //                                                         'Fecha1Cuota' => $fechaFormateada,
    //                                                         'FechaUltimaCuota' => $fechaFormateada2,
    //                                                         'Celular' => $celular,
    //                                                         'Correo' => $correo,
    //                                                         'GeneradorPagare' => $usuario,
    //                                                         'ID_Persona'=> $persona->ID
    //                                                     ]);
    //                                                 }
    //                                             }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                                 if (empty($existingPagare)) {
    //                                                     //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                     $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                     $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                     DB::table('pagareprueba')->insert([
    //                                                         'FechaReporte' => $fechaReporteString,
    //                                                         'Aprobado' => 0,
    //                                                         'Razon' => $razon,
    //                                                         'CoorAsignada' => 'Coordinacion 4',
    //                                                         'AutorizacionGerente' => 1,
    //                                                         'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                         'FechaAccion'=> $fechaStringCredito,
    //                                                         'Garantia' => $garantia,
    //                                                         'NoAgencia' => $agencia,
    //                                                         'NombreAgencia' => $nombreAgencia,
    //                                                         'CuentaCoop' => $cuenta,
    //                                                         'Cedula_Persona' => $cedula,
    //                                                         'NombreCompleto' => $nombres,
    //                                                         'ID_Pagare' => $idpagare,
    //                                                         'NoLC' => $registro['LINEA'],
    //                                                         'Linea_Credito' => $registro['LINEANOM'],
    //                                                         'Capital' => $capital,
    //                                                         'NoCuotas' => $ncuotas,
    //                                                         'ValorCuota' => $vcuotas,
    //                                                         'Tasa' => $tasaAPI,
    //                                                         'FechaCredito' => $fechaStringCredito,
    //                                                         'Nomina' => $nomina .' - '.$nomNomina,
    //                                                         'Direccion' => $direccion,
    //                                                         'TelFijo' => $fijo,
    //                                                         'Fecha1Cuota' => $fechaFormateada,
    //                                                         'FechaUltimaCuota' => $fechaFormateada2,
    //                                                         'Celular' => $celular,
    //                                                         'Correo' => $correo,
    //                                                         'GeneradorPagare' => $usuario,
    //                                                         'ID_Persona'=> $persona->ID
    //                                                     ]);
    //                                                 }
    //                                             }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                                 if (empty($existingPagare)) {
    //                                                     //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                     $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                     $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                     DB::table('pagareprueba')->insert([
    //                                                         'FechaReporte' => $fechaReporteString,
    //                                                         'Aprobado' => 0,
    //                                                         'Razon' => $razon,
    //                                                         'CoorAsignada' => 'Coordinacion 5',
    //                                                         'AutorizacionGerente' => 1,
    //                                                         'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                         'FechaAccion'=> $fechaStringCredito,
    //                                                         'Garantia' => $garantia,
    //                                                         'NoAgencia' => $agencia,
    //                                                         'NombreAgencia' => $nombreAgencia,
    //                                                         'CuentaCoop' => $cuenta,
    //                                                         'Cedula_Persona' => $cedula,
    //                                                         'NombreCompleto' => $nombres,
    //                                                         'ID_Pagare' => $idpagare,
    //                                                         'NoLC' => $registro['LINEA'],
    //                                                         'Linea_Credito' => $registro['LINEANOM'],
    //                                                         'Capital' => $capital,
    //                                                         'NoCuotas' => $ncuotas,
    //                                                         'ValorCuota' => $vcuotas,
    //                                                         'Tasa' => $tasaAPI,
    //                                                         'FechaCredito' => $fechaStringCredito,
    //                                                         'Nomina' => $nomina .' - '.$nomNomina,
    //                                                         'Direccion' => $direccion,
    //                                                         'TelFijo' => $fijo,
    //                                                         'Fecha1Cuota' => $fechaFormateada,
    //                                                         'FechaUltimaCuota' => $fechaFormateada2,
    //                                                         'Celular' => $celular,
    //                                                         'Correo' => $correo,
    //                                                         'GeneradorPagare' => $usuario,
    //                                                         'ID_Persona'=> $persona->ID
    //                                                     ]);
    //                                                 }
    //                                             }
    //                                         }
    //                                     }else{
    //                                         $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth(2)->endOfMonth();
    //                                         Carbon::setLocale('es');
    //                                         $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');


    //                                         $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";
    //                                         if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 1',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 2',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 3',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 4',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 5',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }
    //                                     }

    //                                 //llave que cierra mesanterior == 1
    //                                 }
    //                                 //FECHA ENTREMES
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->ENTREMES == 1) {

    //                                     //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                                     $fechadelCredito = Carbon::now('America/Bogota');
    //                                     $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                                     Carbon::setLocale('es');
    //                                     $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                                     //DIA REPORTE
    //                                     $diaReporte = max(1, $existeDia[0]->DIAS);
    //                                     $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);

    //                                     if ($fechadelCredito->format('m') != $fechaReporteActual->format('m')) {
    //                                         $fechaReporteActual->addMonth();
    //                                     }
    //                                     $fechaReporte = $fechaReporteActual;

    //                                     Carbon::setLocale('es');
    //                                     $fechaReporteString = $fechaReporte->translatedFormat('F d Y');

    //                                     //fechaprimera cuota
    //                                     $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);
    //                                     Carbon::setLocale('es');
    //                                     $fechaString2 = $fecha1eraCuota->format('d/m/Y');
    //                                     $fechaCarbon2 = Carbon::createFromFormat('d/m/Y', $fechaString2);

    //                                     //interes proporcional
    //                                     $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                                     $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                                     $tasa = $registro['TASA'];
    //                                     $capital = $registro['CAPITAL'];

    //                                     $tasa = str_replace(',', '.', $tasa);
    //                                     $tasa = floatval($tasa);

    //                                     $tasa = $tasa / 100;

    //                                     $capital = floatval($capital);

    //                                     $interval = $fechadelCredito->diff($endOfMonth);
    //                                     $c30 = $interval->days;

    //                                     $cuotaMensual = $capital * $tasa;
    //                                     $cuotaDiaria = $cuotaMensual / 30;
    //                                     $interesProporcional = $cuotaDiaria * $c30;

    //                                     $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;


    //                                     $NoAgencia = $registro['AGENCIA'];

    //                                     $result = $fechadelCredito > $fechaReporte;


    //                                     $result1 = $fechaReporte->lt($fechadelCredito) &&
    //                                         ($fechaReporte->diffInMonths($fechaReporte, false) === 1 ||
    //                                             $fechaReporte->diffInDays($fechadelCredito) <= 30);


    //                                     $result2 =  $fechaReporte->gt($fechadelCredito) || ($fechaReporte->diffInDays($fechadelCredito) <= 30 && $fecha1eraCuota->diffInMonths($fechadelCredito) == 2);

    //                                     //CUARTO CONDICIONAL
    //                                     $resultado3 = $fechadelCredito->copy()->addMonth()->endOfMonth()->eq($fechaCarbon2->copy()->endOfMonth());

    //                                     //QUINTO
    //                                     $resultado4 = $fechadelCredito->lt($fechaReporte) && $fechaReporte->copy()->addMonth()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth()) && $fechaReporte->diffInDays($fechadelCredito) <= 30;


    //                                     //SEXTO
    //                                     $resultado5 = $fechadelCredito->gt($fechaReporte) ? false : ($fechaCarbon2->copy()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth()) && $fechaReporte->diffInDays($fechadelCredito) <= 30);

    //                                     if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->ENTREMES == 1) {
    //                                         $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth(1)->endOfMonth();
    //                                         Carbon::setLocale('es');
    //                                         $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                     }


    //                                     if (($result == true && $result1 == true && $result2 == true) || ($resultado3 == true && $resultado4 == true && $resultado5 == true)) {
    //                                         $razon = "Rechazado por score bajo.";

    //                                         if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA

    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 1',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                     DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 2',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 3',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 4',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 5',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }
    //                                     //llave que cierra las condiciones
    //                                     }else{
    //                                         $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";
    //                                         if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 1',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                     DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 2',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 3',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 4',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                             if (empty($existingPagare)) {
    //                                                 //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                                 $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                                 $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                                 DB::table('pagareprueba')->insert([
    //                                                     'FechaReporte' => $fechaReporteString,
    //                                                     'Aprobado' => 0,
    //                                                     'Razon' => $razon,
    //                                                     'CoorAsignada' => 'Coordinacion 5',
    //                                                     'AutorizacionGerente' => 1,
    //                                                     'InteresProporcional' => $interesProporcionalCorrecto,
    //                                                     'FechaAccion'=> $fechaStringCredito,
    //                                                     'Garantia' => $garantia,
    //                                                     'NoAgencia' => $agencia,
    //                                                     'NombreAgencia' => $nombreAgencia,
    //                                                     'CuentaCoop' => $cuenta,
    //                                                     'Cedula_Persona' => $cedula,
    //                                                     'NombreCompleto' => $nombres,
    //                                                     'ID_Pagare' => $idpagare,
    //                                                     'NoLC' => $registro['LINEA'],
    //                                                     'Linea_Credito' => $registro['LINEANOM'],
    //                                                     'Capital' => $capital,
    //                                                     'NoCuotas' => $ncuotas,
    //                                                     'ValorCuota' => $vcuotas,
    //                                                     'Tasa' => $tasaAPI,
    //                                                     'FechaCredito' => $fechaStringCredito,
    //                                                     'Nomina' => $nomina .' - '.$nomNomina,
    //                                                     'Direccion' => $direccion,
    //                                                     'TelFijo' => $fijo,
    //                                                     'Fecha1Cuota' => $fechaFormateada,
    //                                                     'FechaUltimaCuota' => $fechaFormateada2,
    //                                                     'Celular' => $celular,
    //                                                     'Correo' => $correo,
    //                                                     'GeneradorPagare' => $usuario,
    //                                                     'ID_Persona'=> $persona->ID
    //                                                 ]);
    //                                             }
    //                                         }
    //                                     }
    //                                 //llave que cierra entremes
    //                                 }

    //                             //llave que cierra si existe la nomina en s400_plano
    //                             }else{
    //                                 $insertNomiDepe = DB::insert("INSERT INTO s400_plano (CODNOMINA, NOMBRENOMINA, CODDEPENDENCIA, NOMDEPENDENCIA, CODENTIDAD) VALUES (?, ?, ?, ?, ?)", [
    //                                     $CODIGONOMINA,
    //                                     $NOMBRENOMINA,
    //                                     $NODEPENDENCIA,
    //                                     $DEPENDENCIA,
    //                                     $ENTIDAD
    //                                 ]);
    //                             }
    //                         }
    //                 }else{//SI EL SCORE ES NULL
    //                         $existeDia = DB::select('SELECT DIAS, MESANTERIOR, ENTREMES FROM s400_plano WHERE CODNOMINA = ? AND CODDEPENDENCIA = ? AND CODENTIDAD = ?', [$NOMINA, $DEPENDENCIA, $ENTIDAD]);
    //                         //FECHA MES ACTUAL
    //                         if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 0 && $existeDia[0]->ENTREMES == 0) {
    //                             //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                             $fechadelCredito = Carbon::now('America/Bogota');
    //                             $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                             Carbon::setLocale('es');
    //                             $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                             //DIA DE REPORTE DE LA NOMINA
    //                             $diaReporte = max(1, $existeDia[0]->DIAS);

    //                             //se asigna la fecha de reporte de manera automatica
    //                             $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);
    //                             $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;
    //                             Carbon::setLocale('es');
    //                             $fechaReporteString = $fechaReporte->translatedFormat('F d Y');


    //                             //fecha primera cuota
    //                             $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);


    //                             //interes proporcional
    //                             $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                             $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                             $tasa = $registro['TASA'];
    //                             $capital = $registro['CAPITAL'];

    //                             $tasa = str_replace(',', '.', $tasa);
    //                             $tasa = floatval($tasa);

    //                             $tasa = $tasa / 100;

    //                             $capital = floatval($capital);

    //                             $interval = $fechadelCredito->diff($endOfMonth);
    //                             $c30 = $interval->days;

    //                             $cuotaMensual = $capital * $tasa;
    //                             $cuotaDiaria = $cuotaMensual / 30;
    //                             $interesProporcional = $cuotaDiaria * $c30;

    //                             $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;



    //                             // Calcular el último día del mes siguiente a la fecha del crédito
    //                             $ultimoDiaMesSiguienteCredito = $fechadelCredito->copy()->addMonth()->endOfMonth();

    //                             // Calcular el último día del mes de la primera cuota
    //                             $ultimoDiaMesPrimeraCuota = $fecha1eraCuota->copy()->endOfMonth();

    //                             // Comparar si son iguales
    //                             //resultado
    //                             $resultado = $ultimoDiaMesSiguienteCredito->eq($ultimoDiaMesPrimeraCuota) ? true : false;



    //                             // Ajustar $fechaReporte basado en si la fecha del crédito es mayor que $fechaReporteActual
    //                             $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;

    //                             // Implementar la lógica de la fórmula de Excel
    //                             $condicion1 = $fechadelCredito->lt($fechaReporte); // B14 < E15
    //                             // La condición 2 es redundante y siempre verdadera, por lo que la omitimos
    //                             $condicion3 = $fechaReporte->diffInDays($fechadelCredito) <= 31; // DIAS(E15;B14)<=31

    //                             // Comprobar si todas las condiciones relevantes son verdaderas
    //                             $resultado1 = $condicion1 && $condicion3 ? true : false;




    //                             // Primera condición externa
    //                             if ($fechadelCredito->gt($fechaReporte)) {
    //                                 $resultado2 = false;
    //                             } else {
    //                                 // Condición interna
    //                                 $ultimoDiaMesPrimeraCuota = $fecha1eraCuota->copy()->endOfMonth();
    //                                 $ultimoDiaMesSiguienteReporte = $fechaReporte->copy()->addMonth()->endOfMonth();

    //                                 $diasDiferencia = $fechaReporte->diffInDays($fechadelCredito, false);

    //                                 if ($ultimoDiaMesPrimeraCuota->eq($ultimoDiaMesSiguienteReporte) && $diasDiferencia <= 31) {
    //                                     $resultado2 = true;
    //                                 } else {
    //                                     $resultado2 = false;
    //                                 }
    //                             }


    //                             // Condición 1: Comprobar si el último día del mes de la fecha en C14 es igual al último día del mes siguiente a E15
    //                             $condicion3 = $fecha1eraCuota->copy()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth());

    //                             // Condición 2: La diferencia en días entre E15 y B14 es de 31 días o menos
    //                             $condicion4 = $fechaReporte->diffInDays($fechadelCredito, false) <= 31;

    //                             // Resultado basado en las condiciones
    //                             $resultado3 = ($condicion3 || $condicion4) ? true : false ;


    //                             // Calcular el último día del mes de B14
    //                             $ultimoDiaMesB14 = $fechadelCredito->copy()->endOfMonth();

    //                             // Calcular el último día del mes anterior a E15
    //                             $ultimoDiaMesAnteriorE15 = $fechaReporte->copy()->subMonth()->endOfMonth();

    //                             // Verificar las condiciones
    //                             $condicion5 = $ultimoDiaMesB14->eq($ultimoDiaMesAnteriorE15);
    //                             $condicion6 = $fechaReporte->gte($fechadelCredito);
    //                             $condicion7 = $fechaReporte->diffInDays($fechadelCredito) <= 31;

    //                             // Evaluar si todas las condiciones son verdaderas
    //                             $resultado4 = $condicion5 && $condicion6 && $condicion7 ? true : false ;


    //                             // Primer nivel de comprobación
    //                             if ($fechadelCredito->gt($fechaReporte)) {
    //                                 $resultado5 = false;
    //                             } else {
    //                                 // Segundo nivel de comprobación
    //                                 $ultimoDiaMesC14 = $fecha1eraCuota->endOfMonth(); // Último día del mes para C14
    //                                 $ultimoDiaMesSiguienteB14 = $fechadelCredito->copy()->addMonth()->endOfMonth(); // Último día del mes siguiente a B14

    //                                 $condicionA = $ultimoDiaMesC14->eq($ultimoDiaMesSiguienteB14);
    //                                 $condicionB = $fechaReporte->diffInDays($fechadelCredito) <= 31;

    //                                 $resultado5 = $condicionA && $condicionB ? true : false ;
    //                             }

    //                                 $NoAgencia = $registro['AGENCIA'];

    //                             if (($resultado == true && $resultado1 == true && $resultado2 == true) || ($resultado3 == true && $resultado4 == true &&  $resultado5  == true)) {
    //                             //NUMERO DE AGENCIA
    //                                 $razon = 'Aprobado por cumplir las fechas pero faltaria el score.';
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }
    //                             //llave que cierra la condicion de fecha actual
    //                             }else{
    //                                 $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 0) {
    //                                     $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth()->endOfMonth();
    //                                     Carbon::setLocale('es');
    //                                     $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                 }
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }

    //                             }
    //                         //llave que cierra lo del mesanterior ==0
    //                         }
    //                         //FECHA MES SIGUIENTE
    //                         if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 1) {
    //                             //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                             $fechadelCredito = Carbon::now('America/Bogota');
    //                             $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                             Carbon::setLocale('es');
    //                             $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                             //DIA REPORTE DE LA S400 PLANO
    //                             $diaReporte = max(1, $existeDia[0]->DIAS);
    //                             $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);

    //                             $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;
    //                             Carbon::setLocale('es');
    //                             $fechaReporteString = $fechaReporte->translatedFormat('F d Y');

    //                             //fecha primera cuota
    //                             $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);

    //                             //interes proporcional
    //                             $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                             $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                             $tasa = $registro['TASA'];
    //                             $capital = $registro['CAPITAL'];

    //                             $tasa = str_replace(',', '.', $tasa);
    //                             $tasa = floatval($tasa);

    //                             $tasa = $tasa / 100;

    //                             $capital = floatval($capital);

    //                             $interval = $fechadelCredito->diff($endOfMonth);
    //                             $c30 = $interval->days;

    //                             $cuotaMensual = $capital * $tasa;
    //                             $cuotaDiaria = $cuotaMensual / 30;
    //                             $interesProporcional = $cuotaDiaria * $c30;

    //                             $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;

    //                             // Fórmula 1
    //                             $resultado1 = (
    //                                 $fechaCarbon2->copy()->endOfMonth()->eq($formateadaCarbon->copy()->addMonths(2)->endOfMonth()) &&
    //                                 (
    //                                     $fechadelCredito->copy()->addMonths(3)->endOfMonth() instanceof Carbon &&
    //                                     $fechadelCredito->copy()->addMonths(2)->endOfMonth() instanceof Carbon &&
    //                                     $formateadaCarbon->diffInDays($fechadelCredito) <= 30
    //                                 )
    //                             );


    //                             // Fórmula 2
    //                             $resultado2 = (
    //                                 Carbon::now('America/Bogota')->endOfMonth(2)->eq($fecha1eraCuota->endOfMonth()) &&
    //                                 $fechaReporte->gte($fechadelCredito) &&
    //                                 $fechaReporte->diffInDays($fechadelCredito) <= 30
    //                             ) ?  true : false ;

    //                             // Fórmula 3
    //                             $resultado3 = ($fechadelCredito->gt($fecha1eraCuota)) ? false : (
    //                                 (Carbon::now('America/Bogota')->endOfMonth(0)->eq($fechaReporte->endOfMonth()) ||
    //                                     $fechaReporte->diffInDays($fechadelCredito) <= 30) ? true : false
    //                             );


    //                             $NoAgencia = $registro['AGENCIA'];
    //                             if (($resultado1 == true && $resultado2 == true && $resultado3 == true) || ($resultado1 == false && $resultado2 == true && $resultado3 == true) || ($resultado1 == true && $resultado2 == false && $resultado3 == true) || ($resultado1 == true && $resultado2 == true && $resultado3 == false) || ($resultado1 == false && $resultado2 == true && $resultado3 == false)) {
    //                                 $razon = 'Aprobado por cumplir las fechas pero faltaria el score.';
    //                                 //NUMERO DE AGENCIA
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }
    //                             }else{
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 1) {
    //                                     $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth(2)->endOfMonth();
    //                                     Carbon::setLocale('es');
    //                                     $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                 }

    //                                 $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }

    //                                 //llave que cierra las condiciones de mesanterior == 1
    //                             }
    //                         //llave que cierra mesanterior == 1
    //                         }
    //                         //FECHA ENTREMES
    //                         if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->ENTREMES == 1) {
    //                             //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                             $fechadelCredito = Carbon::now('America/Bogota');
    //                             $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                             Carbon::setLocale('es');
    //                             $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                             //DIA REPORTE
    //                             $diaReporte = max(1, $existeDia[0]->DIAS);
    //                             $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);

    //                             if ($fechadelCredito->format('m') != $fechaReporteActual->format('m')) {
    //                                 $fechaReporteActual->addMonth();
    //                             }
    //                             $fechaReporte = $fechaReporteActual;

    //                             Carbon::setLocale('es');
    //                             $fechaReporteString = $fechaReporte->translatedFormat('F d Y');

    //                             //fechaprimera cuota
    //                             $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);
    //                             Carbon::setLocale('es');
    //                             $fechaString2 = $fecha1eraCuota->format('d/m/Y');
    //                             $fechaCarbon2 = Carbon::createFromFormat('d/m/Y', $fechaString2);

    //                             //interesproporcional
    //                             $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                             $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                             $tasa = $registro['TASA'];
    //                             $capital = $registro['CAPITAL'];

    //                             $tasa = str_replace(',', '.', $tasa);
    //                             $tasa = floatval($tasa);

    //                             $tasa = $tasa / 100;

    //                             $capital = floatval($capital);

    //                             $interval = $fechadelCredito->diff($endOfMonth);
    //                             $c30 = $interval->days;

    //                             $cuotaMensual = $capital * $tasa;
    //                             $cuotaDiaria = $cuotaMensual / 30;
    //                             $interesProporcional = $cuotaDiaria * $c30;

    //                             $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;


    //                             $NoAgencia = $registro['AGENCIA'];

    //                             $result = $fechadelCredito > $fechaReporte;


    //                             $result1 = $fechaReporte->lt($fechadelCredito) &&
    //                                 ($fechaReporte->diffInMonths($fechaReporte, false) === 1 ||
    //                                     $fechaReporte->diffInDays($fechadelCredito) <= 30);


    //                             $result2 =  $fechaReporte->gt($fechadelCredito) || ($fechaReporte->diffInDays($fechadelCredito) <= 30 && $fecha1eraCuota->diffInMonths($fechadelCredito) == 2);

    //                             //CUARTO CONDICIONAL
    //                             $resultado3 = $fechadelCredito->copy()->addMonth()->endOfMonth()->eq($fechaCarbon2->copy()->endOfMonth());

    //                             //QUINTO
    //                             $resultado4 = $fechadelCredito->lt($fechaReporte) && $fechaReporte->copy()->addMonth()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth()) && $fechaReporte->diffInDays($fechadelCredito) <= 30;


    //                             //SEXTO
    //                             $resultado5 = $fechadelCredito->gt($fechaReporte) ? false : ($fechaCarbon2->copy()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth()) && $fechaReporte->diffInDays($fechadelCredito) <= 30);

    //                             if (($result == true && $result1 == true && $result2  == true) || ($resultado3 == true && $resultado4 == true &&  $resultado5  == true)) {
    //                                 $razon = 'Aprobado por cumplir las fechas pero faltaria el score.';
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $razon = 'Aprobado por cumplir las fechas y ademas el credito no requiere consulta entonces es aprobado.';
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                             DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }
    //                             }else{
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->ENTREMES == 1) {
    //                                     $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth(2)->endOfMonth();
    //                                     Carbon::setLocale('es');
    //                                     $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                 }
    //                                 $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA

    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                             DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 2,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }

    //                             }
    //                         //llave que cierra entremes
    //                         }

    //                 }
    //             //cierre de llave para validar si existe en el datacredito
    //             }else{

    //                 $existeDia = DB::select('SELECT DIAS, MESANTERIOR, ENTREMES FROM s400_plano WHERE CODNOMINA = ? AND CODDEPENDENCIA = ? AND CODENTIDAD = ?', [$NOMINA, $DEPENDENCIA, $ENTIDAD]);
    //                 //FECHA MES ACTUAL

    //                 if(3000000 <= $capital){

    //                         //FECHA MES ACTUAL
    //                         if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 0 && $existeDia[0]->ENTREMES == 0) {
    //                             //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                             $fechadelCredito = Carbon::now('America/Bogota');
    //                             $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                             Carbon::setLocale('es');
    //                             $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                             //DIA DE REPORTE DE LA NOMINA
    //                             $diaReporte = max(1, $existeDia[0]->DIAS);

    //                             //se asigna la fecha de reporte de manera automatica
    //                             $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);
    //                             $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;
    //                             Carbon::setLocale('es');
    //                             $fechaReporteString = $fechaReporte->translatedFormat('F d Y');


    //                             //fecha primera cuota
    //                             $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);


    //                             //interes proporcional
    //                             $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                             $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                             $tasa = $registro['TASA'];
    //                             $capital = $registro['CAPITAL'];

    //                             $tasa = str_replace(',', '.', $tasa);
    //                             $tasa = floatval($tasa);

    //                             $tasa = $tasa / 100;

    //                             $capital = floatval($capital);

    //                             $interval = $fechadelCredito->diff($endOfMonth);
    //                             $c30 = $interval->days;

    //                             $cuotaMensual = $capital * $tasa;
    //                             $cuotaDiaria = $cuotaMensual / 30;
    //                             $interesProporcional = $cuotaDiaria * $c30;

    //                             $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;



    //                             // Calcular el último día del mes siguiente a la fecha del crédito
    //                             $ultimoDiaMesSiguienteCredito = $fechadelCredito->copy()->addMonth()->endOfMonth();

    //                             // Calcular el último día del mes de la primera cuota
    //                             $ultimoDiaMesPrimeraCuota = $fecha1eraCuota->copy()->endOfMonth();

    //                             // Comparar si son iguales
    //                             //resultado
    //                             $resultado = $ultimoDiaMesSiguienteCredito->eq($ultimoDiaMesPrimeraCuota) ? true : false;



    //                             // Ajustar $fechaReporte basado en si la fecha del crédito es mayor que $fechaReporteActual
    //                             $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;

    //                             // Implementar la lógica de la fórmula de Excel
    //                             $condicion1 = $fechadelCredito->lt($fechaReporte); // B14 < E15
    //                             // La condición 2 es redundante y siempre verdadera, por lo que la omitimos
    //                             $condicion3 = $fechaReporte->diffInDays($fechadelCredito) <= 31; // DIAS(E15;B14)<=31

    //                             // Comprobar si todas las condiciones relevantes son verdaderas
    //                             $resultado1 = $condicion1 && $condicion3 ? true : false;




    //                             // Primera condición externa
    //                             if ($fechadelCredito->gt($fechaReporte)) {
    //                                 $resultado2 = false;
    //                             } else {
    //                                 // Condición interna
    //                                 $ultimoDiaMesPrimeraCuota = $fecha1eraCuota->copy()->endOfMonth();
    //                                 $ultimoDiaMesSiguienteReporte = $fechaReporte->copy()->addMonth()->endOfMonth();

    //                                 $diasDiferencia = $fechaReporte->diffInDays($fechadelCredito, false);

    //                                 if ($ultimoDiaMesPrimeraCuota->eq($ultimoDiaMesSiguienteReporte) && $diasDiferencia <= 31) {
    //                                     $resultado2 = true;
    //                                 } else {
    //                                     $resultado2 = false;
    //                                 }
    //                             }


    //                             // Condición 1: Comprobar si el último día del mes de la fecha en C14 es igual al último día del mes siguiente a E15
    //                             $condicion3 = $fecha1eraCuota->copy()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth());

    //                             // Condición 2: La diferencia en días entre E15 y B14 es de 31 días o menos
    //                             $condicion4 = $fechaReporte->diffInDays($fechadelCredito, false) <= 31;

    //                             // Resultado basado en las condiciones
    //                             $resultado3 = ($condicion3 || $condicion4) ? true : false ;


    //                             // Calcular el último día del mes de B14
    //                             $ultimoDiaMesB14 = $fechadelCredito->copy()->endOfMonth();

    //                             // Calcular el último día del mes anterior a E15
    //                             $ultimoDiaMesAnteriorE15 = $fechaReporte->copy()->subMonth()->endOfMonth();

    //                             // Verificar las condiciones
    //                             $condicion5 = $ultimoDiaMesB14->eq($ultimoDiaMesAnteriorE15);
    //                             $condicion6 = $fechaReporte->gte($fechadelCredito);
    //                             $condicion7 = $fechaReporte->diffInDays($fechadelCredito) <= 31;

    //                             // Evaluar si todas las condiciones son verdaderas
    //                             $resultado4 = $condicion5 && $condicion6 && $condicion7 ? true : false ;


    //                             // Primer nivel de comprobación
    //                             if ($fechadelCredito->gt($fechaReporte)) {
    //                                 $resultado5 = false;
    //                             } else {
    //                                 // Segundo nivel de comprobación
    //                                 $ultimoDiaMesC14 = $fecha1eraCuota->endOfMonth(); // Último día del mes para C14
    //                                 $ultimoDiaMesSiguienteB14 = $fechadelCredito->copy()->addMonth()->endOfMonth(); // Último día del mes siguiente a B14

    //                                 $condicionA = $ultimoDiaMesC14->eq($ultimoDiaMesSiguienteB14);
    //                                 $condicionB = $fechaReporte->diffInDays($fechadelCredito) <= 31;

    //                                 $resultado5 = $condicionA && $condicionB ? true : false ;
    //                             }

    //                                 $NoAgencia = $registro['AGENCIA'];

    //                             if (($resultado == true && $resultado1 == true && $resultado2 == true) || ($resultado3 == true && $resultado4 == true &&  $resultado5  == true)) {
    //                             //NUMERO DE AGENCIA
    //                                 $razon = 'Aprobado por cumplir las fechas y ademas el credito no requiere consulta entonces es aprobado.';
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }
    //                             //llave que cierra la condicion de fecha actual
    //                             }else{
    //                                 $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 0) {
    //                                     $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth()->endOfMonth();
    //                                     Carbon::setLocale('es');
    //                                     $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                 }
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }

    //                             }
    //                         //llave que cierra lo del mesanterior ==0
    //                         }
    //                         //FECHA MES SIGUIENTE
    //                         if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 1) {
    //                             //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                             $fechadelCredito = Carbon::now('America/Bogota');
    //                             $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                             Carbon::setLocale('es');
    //                             $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                             //DIA REPORTE DE LA S400 PLANO
    //                             $diaReporte = max(1, $existeDia[0]->DIAS);
    //                             $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);

    //                             $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;
    //                             Carbon::setLocale('es');
    //                             $fechaReporteString = $fechaReporte->translatedFormat('F d Y');

    //                             //fecha primera cuota
    //                             $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);

    //                             //interes proporcional
    //                             $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                             $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                             $tasa = $registro['TASA'];
    //                             $capital = $registro['CAPITAL'];

    //                             $tasa = str_replace(',', '.', $tasa);
    //                             $tasa = floatval($tasa);

    //                             $tasa = $tasa / 100;

    //                             $capital = floatval($capital);

    //                             $interval = $fechadelCredito->diff($endOfMonth);
    //                             $c30 = $interval->days;

    //                             $cuotaMensual = $capital * $tasa;
    //                             $cuotaDiaria = $cuotaMensual / 30;
    //                             $interesProporcional = $cuotaDiaria * $c30;

    //                             $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;

    //                             // Fórmula 1
    //                             $resultado1 = (
    //                                 $fechaCarbon2->copy()->endOfMonth()->eq($formateadaCarbon->copy()->addMonths(2)->endOfMonth()) &&
    //                                 (
    //                                     $fechadelCredito->copy()->addMonths(3)->endOfMonth() instanceof Carbon &&
    //                                     $fechadelCredito->copy()->addMonths(2)->endOfMonth() instanceof Carbon &&
    //                                     $formateadaCarbon->diffInDays($fechadelCredito) <= 30
    //                                 )
    //                             );


    //                             // Fórmula 2
    //                             $resultado2 = (
    //                                 Carbon::now('America/Bogota')->endOfMonth(2)->eq($fecha1eraCuota->endOfMonth()) &&
    //                                 $fechaReporte->gte($fechadelCredito) &&
    //                                 $fechaReporte->diffInDays($fechadelCredito) <= 30
    //                             ) ?  true : false ;

    //                             // Fórmula 3
    //                             $resultado3 = ($fechadelCredito->gt($fecha1eraCuota)) ? false : (
    //                                 (Carbon::now('America/Bogota')->endOfMonth(0)->eq($fechaReporte->endOfMonth()) ||
    //                                     $fechaReporte->diffInDays($fechadelCredito) <= 30) ? true : false
    //                             );


    //                             $NoAgencia = $registro['AGENCIA'];
    //                             if (($resultado1 == true && $resultado2 == true && $resultado3 == true) || ($resultado1 == false && $resultado2 == true && $resultado3 == true) || ($resultado1 == true && $resultado2 == false && $resultado3 == true) || ($resultado1 == true && $resultado2 == true && $resultado3 == false) || ($resultado1 == false && $resultado2 == true && $resultado3 == false)) {
    //                                 $razon = 'Aprobado por cumplir las fechas y ademas el credito no requiere consulta entonces es aprobado.';
    //                                 //NUMERO DE AGENCIA
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }
    //                             }else{
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 1) {
    //                                     $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth(2)->endOfMonth();
    //                                     Carbon::setLocale('es');
    //                                     $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                 }

    //                                 $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }

    //                                 //llave que cierra las condiciones de mesanterior == 1
    //                             }
    //                         //llave que cierra mesanterior == 1
    //                         }
    //                         //FECHA ENTREMES
    //                         if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->ENTREMES == 1) {
    //                             //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                             $fechadelCredito = Carbon::now('America/Bogota');
    //                             $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                             Carbon::setLocale('es');
    //                             $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                             //DIA REPORTE
    //                             $diaReporte = max(1, $existeDia[0]->DIAS);
    //                             $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);

    //                             if ($fechadelCredito->format('m') != $fechaReporteActual->format('m')) {
    //                                 $fechaReporteActual->addMonth();
    //                             }
    //                             $fechaReporte = $fechaReporteActual;

    //                             Carbon::setLocale('es');
    //                             $fechaReporteString = $fechaReporte->translatedFormat('F d Y');

    //                             //fechaprimera cuota
    //                             $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);
    //                             Carbon::setLocale('es');
    //                             $fechaString2 = $fecha1eraCuota->format('d/m/Y');
    //                             $fechaCarbon2 = Carbon::createFromFormat('d/m/Y', $fechaString2);

    //                             //interesproporcional
    //                             $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                             $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                             $tasa = $registro['TASA'];
    //                             $capital = $registro['CAPITAL'];

    //                             $tasa = str_replace(',', '.', $tasa);
    //                             $tasa = floatval($tasa);

    //                             $tasa = $tasa / 100;

    //                             $capital = floatval($capital);

    //                             $interval = $fechadelCredito->diff($endOfMonth);
    //                             $c30 = $interval->days;

    //                             $cuotaMensual = $capital * $tasa;
    //                             $cuotaDiaria = $cuotaMensual / 30;
    //                             $interesProporcional = $cuotaDiaria * $c30;

    //                             $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;


    //                             $NoAgencia = $registro['AGENCIA'];

    //                             $result = $fechadelCredito > $fechaReporte;


    //                             $result1 = $fechaReporte->lt($fechadelCredito) &&
    //                                 ($fechaReporte->diffInMonths($fechaReporte, false) === 1 ||
    //                                     $fechaReporte->diffInDays($fechadelCredito) <= 30);


    //                             $result2 =  $fechaReporte->gt($fechadelCredito) || ($fechaReporte->diffInDays($fechadelCredito) <= 30 && $fecha1eraCuota->diffInMonths($fechadelCredito) == 2);

    //                             //CUARTO CONDICIONAL
    //                             $resultado3 = $fechadelCredito->copy()->addMonth()->endOfMonth()->eq($fechaCarbon2->copy()->endOfMonth());

    //                             //QUINTO
    //                             $resultado4 = $fechadelCredito->lt($fechaReporte) && $fechaReporte->copy()->addMonth()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth()) && $fechaReporte->diffInDays($fechadelCredito) <= 30;


    //                             //SEXTO
    //                             $resultado5 = $fechadelCredito->gt($fechaReporte) ? false : ($fechaCarbon2->copy()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth()) && $fechaReporte->diffInDays($fechadelCredito) <= 30);

    //                             if (($result == true && $result1 == true && $result2  == true) || ($resultado3 == true && $resultado4 == true &&  $resultado5  == true)) {
    //                                 $razon = 'Aprobado por cumplir las fechas y ademas el credito no requiere consulta entonces es aprobado.';
    //                                 //$razon = 'Aprobado por score(>=650) alto y por cumplir las fechas.';

    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA

    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                             DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }
    //                             }else{
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->ENTREMES == 1) {
    //                                     $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth(2)->endOfMonth();
    //                                     Carbon::setLocale('es');
    //                                     $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                 }
    //                                 $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";

    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA

    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                             DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }

    //                             }
    //                         //llave que cierra entremes
    //                         }



    //                 //cierre de condicion <= 3000000
    //                 }else{

    //                         //FECHA MES ACTUAL
    //                         if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 0 && $existeDia[0]->ENTREMES == 0) {
    //                             //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                             $fechadelCredito = Carbon::now('America/Bogota');
    //                             $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                             Carbon::setLocale('es');
    //                             $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                             //DIA DE REPORTE DE LA NOMINA
    //                             $diaReporte = max(1, $existeDia[0]->DIAS);

    //                             //se asigna la fecha de reporte de manera automatica
    //                             $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);
    //                             $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;
    //                             Carbon::setLocale('es');
    //                             $fechaReporteString = $fechaReporte->translatedFormat('F d Y');


    //                             //fecha primera cuota
    //                             $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);


    //                             //interes proporcional
    //                             $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                             $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                             $tasa = $registro['TASA'];
    //                             $capital = $registro['CAPITAL'];

    //                             $tasa = str_replace(',', '.', $tasa);
    //                             $tasa = floatval($tasa);

    //                             $tasa = $tasa / 100;

    //                             $capital = floatval($capital);

    //                             $interval = $fechadelCredito->diff($endOfMonth);
    //                             $c30 = $interval->days;

    //                             $cuotaMensual = $capital * $tasa;
    //                             $cuotaDiaria = $cuotaMensual / 30;
    //                             $interesProporcional = $cuotaDiaria * $c30;

    //                             $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;



    //                             // Calcular el último día del mes siguiente a la fecha del crédito
    //                             $ultimoDiaMesSiguienteCredito = $fechadelCredito->copy()->addMonth()->endOfMonth();

    //                             // Calcular el último día del mes de la primera cuota
    //                             $ultimoDiaMesPrimeraCuota = $fecha1eraCuota->copy()->endOfMonth();

    //                             // Comparar si son iguales
    //                             //resultado
    //                             $resultado = $ultimoDiaMesSiguienteCredito->eq($ultimoDiaMesPrimeraCuota) ? true : false;



    //                             // Ajustar $fechaReporte basado en si la fecha del crédito es mayor que $fechaReporteActual
    //                             $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;

    //                             // Implementar la lógica de la fórmula de Excel
    //                             $condicion1 = $fechadelCredito->lt($fechaReporte); // B14 < E15
    //                             // La condición 2 es redundante y siempre verdadera, por lo que la omitimos
    //                             $condicion3 = $fechaReporte->diffInDays($fechadelCredito) <= 31; // DIAS(E15;B14)<=31

    //                             // Comprobar si todas las condiciones relevantes son verdaderas
    //                             $resultado1 = $condicion1 && $condicion3 ? true : false;




    //                             // Primera condición externa
    //                             if ($fechadelCredito->gt($fechaReporte)) {
    //                                 $resultado2 = false;
    //                             } else {
    //                                 // Condición interna
    //                                 $ultimoDiaMesPrimeraCuota = $fecha1eraCuota->copy()->endOfMonth();
    //                                 $ultimoDiaMesSiguienteReporte = $fechaReporte->copy()->addMonth()->endOfMonth();

    //                                 $diasDiferencia = $fechaReporte->diffInDays($fechadelCredito, false);

    //                                 if ($ultimoDiaMesPrimeraCuota->eq($ultimoDiaMesSiguienteReporte) && $diasDiferencia <= 31) {
    //                                     $resultado2 = true;
    //                                 } else {
    //                                     $resultado2 = false;
    //                                 }
    //                             }


    //                             // Condición 1: Comprobar si el último día del mes de la fecha en C14 es igual al último día del mes siguiente a E15
    //                             $condicion3 = $fecha1eraCuota->copy()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth());

    //                             // Condición 2: La diferencia en días entre E15 y B14 es de 31 días o menos
    //                             $condicion4 = $fechaReporte->diffInDays($fechadelCredito, false) <= 31;

    //                             // Resultado basado en las condiciones
    //                             $resultado3 = ($condicion3 || $condicion4) ? true : false ;


    //                             // Calcular el último día del mes de B14
    //                             $ultimoDiaMesB14 = $fechadelCredito->copy()->endOfMonth();

    //                             // Calcular el último día del mes anterior a E15
    //                             $ultimoDiaMesAnteriorE15 = $fechaReporte->copy()->subMonth()->endOfMonth();

    //                             // Verificar las condiciones
    //                             $condicion5 = $ultimoDiaMesB14->eq($ultimoDiaMesAnteriorE15);
    //                             $condicion6 = $fechaReporte->gte($fechadelCredito);
    //                             $condicion7 = $fechaReporte->diffInDays($fechadelCredito) <= 31;

    //                             // Evaluar si todas las condiciones son verdaderas
    //                             $resultado4 = $condicion5 && $condicion6 && $condicion7 ? true : false ;


    //                             // Primer nivel de comprobación
    //                             if ($fechadelCredito->gt($fechaReporte)) {
    //                                 $resultado5 = false;
    //                             } else {
    //                                 // Segundo nivel de comprobación
    //                                 $ultimoDiaMesC14 = $fecha1eraCuota->endOfMonth(); // Último día del mes para C14
    //                                 $ultimoDiaMesSiguienteB14 = $fechadelCredito->copy()->addMonth()->endOfMonth(); // Último día del mes siguiente a B14

    //                                 $condicionA = $ultimoDiaMesC14->eq($ultimoDiaMesSiguienteB14);
    //                                 $condicionB = $fechaReporte->diffInDays($fechadelCredito) <= 31;

    //                                 $resultado5 = $condicionA && $condicionB ? true : false ;
    //                             }

    //                                 $NoAgencia = $registro['AGENCIA'];

    //                             if (($resultado == true && $resultado1 == true && $resultado2 == true) || ($resultado3 == true && $resultado4 == true &&  $resultado5  == true)) {
    //                             //NUMERO DE AGENCIA
    //                                 $razon = 'Aprobado por cumplir las fechas pero faltaria el score.';
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }
    //                             //llave que cierra la condicion de fecha actual
    //                             }else{
    //                                 $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 0) {
    //                                     $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth()->endOfMonth();
    //                                     Carbon::setLocale('es');
    //                                     $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                 }
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }

    //                             }
    //                         //llave que cierra lo del mesanterior ==0
    //                         }
    //                         //FECHA MES SIGUIENTE
    //                         if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 1) {
    //                             //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                             $fechadelCredito = Carbon::now('America/Bogota');
    //                             $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                             Carbon::setLocale('es');
    //                             $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                             //DIA REPORTE DE LA S400 PLANO
    //                             $diaReporte = max(1, $existeDia[0]->DIAS);
    //                             $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);

    //                             $fechaReporte = $fechadelCredito->gt($fechaReporteActual) ? $fechaReporteActual->addMonth() : $fechaReporteActual;
    //                             Carbon::setLocale('es');
    //                             $fechaReporteString = $fechaReporte->translatedFormat('F d Y');

    //                             //fecha primera cuota
    //                             $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);

    //                             //interes proporcional
    //                             $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                             $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                             $tasa = $registro['TASA'];
    //                             $capital = $registro['CAPITAL'];

    //                             $tasa = str_replace(',', '.', $tasa);
    //                             $tasa = floatval($tasa);

    //                             $tasa = $tasa / 100;

    //                             $capital = floatval($capital);

    //                             $interval = $fechadelCredito->diff($endOfMonth);
    //                             $c30 = $interval->days;

    //                             $cuotaMensual = $capital * $tasa;
    //                             $cuotaDiaria = $cuotaMensual / 30;
    //                             $interesProporcional = $cuotaDiaria * $c30;

    //                             $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;

    //                             // Fórmula 1
    //                             $resultado1 = (
    //                                 $fechaCarbon2->copy()->endOfMonth()->eq($formateadaCarbon->copy()->addMonths(2)->endOfMonth()) &&
    //                                 (
    //                                     $fechadelCredito->copy()->addMonths(3)->endOfMonth() instanceof Carbon &&
    //                                     $fechadelCredito->copy()->addMonths(2)->endOfMonth() instanceof Carbon &&
    //                                     $formateadaCarbon->diffInDays($fechadelCredito) <= 30
    //                                 )
    //                             );


    //                             // Fórmula 2
    //                             $resultado2 = (
    //                                 Carbon::now('America/Bogota')->endOfMonth(2)->eq($fecha1eraCuota->endOfMonth()) &&
    //                                 $fechaReporte->gte($fechadelCredito) &&
    //                                 $fechaReporte->diffInDays($fechadelCredito) <= 30
    //                             ) ?  true : false ;

    //                             // Fórmula 3
    //                             $resultado3 = ($fechadelCredito->gt($fecha1eraCuota)) ? false : (
    //                                 (Carbon::now('America/Bogota')->endOfMonth(0)->eq($fechaReporte->endOfMonth()) ||
    //                                     $fechaReporte->diffInDays($fechadelCredito) <= 30) ? true : false
    //                             );


    //                             $NoAgencia = $registro['AGENCIA'];
    //                             if (($resultado1 == true && $resultado2 == true && $resultado3 == true) || ($resultado1 == false && $resultado2 == true && $resultado3 == true) || ($resultado1 == true && $resultado2 == false && $resultado3 == true) || ($resultado1 == true && $resultado2 == true && $resultado3 == false) || ($resultado1 == false && $resultado2 == true && $resultado3 == false)) {
    //                                 $razon = 'Aprobado por cumplir las fechas pero faltaria el score.';
    //                                 //NUMERO DE AGENCIA
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }
    //                             }else{
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->MESANTERIOR == 1) {
    //                                     $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth(2)->endOfMonth();
    //                                     Carbon::setLocale('es');
    //                                     $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                 }

    //                                 $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }

    //                                 //llave que cierra las condiciones de mesanterior == 1
    //                             }
    //                         //llave que cierra mesanterior == 1
    //                         }
    //                         //FECHA ENTREMES
    //                         if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->ENTREMES == 1) {
    //                             //FECHA DEL SISTEMA PARA ASIGNARLO A LOS NUEVOS REGISTROS
    //                             $fechadelCredito = Carbon::now('America/Bogota');
    //                             $fechadelCreditoUtc = $fechadelCredito->setTimezone('UTC');
    //                             Carbon::setLocale('es');
    //                             $fechaStringCredito = $fechadelCredito->translatedFormat('F d Y');

    //                             //DIA REPORTE
    //                             $diaReporte = max(1, $existeDia[0]->DIAS);
    //                             $fechaReporteActual = Carbon::createFromFormat('Y/m/d', $fechadelCredito->format('Y') . '/' . $fechadelCredito->format('m') . '/' . $diaReporte);

    //                             if ($fechadelCredito->format('m') != $fechaReporteActual->format('m')) {
    //                                 $fechaReporteActual->addMonth();
    //                             }
    //                             $fechaReporte = $fechaReporteActual;

    //                             Carbon::setLocale('es');
    //                             $fechaReporteString = $fechaReporte->translatedFormat('F d Y');

    //                             //fechaprimera cuota
    //                             $fecha1eraCuota = Carbon::createFromFormat('y/m/d', $anio . '/' . $mes . '/' . $dia);
    //                             Carbon::setLocale('es');
    //                             $fechaString2 = $fecha1eraCuota->format('d/m/Y');
    //                             $fechaCarbon2 = Carbon::createFromFormat('d/m/Y', $fechaString2);

    //                             //interesproporcional
    //                             $endOfMonth = $fechadelCredito->copy()->endOfMonth();
    //                             $fechaHoraActualStr = $fechadelCredito->format('Y-m-d H:i:s');
    //                             $tasa = $registro['TASA'];
    //                             $capital = $registro['CAPITAL'];

    //                             $tasa = str_replace(',', '.', $tasa);
    //                             $tasa = floatval($tasa);

    //                             $tasa = $tasa / 100;

    //                             $capital = floatval($capital);

    //                             $interval = $fechadelCredito->diff($endOfMonth);
    //                             $c30 = $interval->days;

    //                             $cuotaMensual = $capital * $tasa;
    //                             $cuotaDiaria = $cuotaMensual / 30;
    //                             $interesProporcional = $cuotaDiaria * $c30;

    //                             $interesProporcionalCorrecto = ($capital * $tasa) / 30 * $c30;


    //                             $NoAgencia = $registro['AGENCIA'];

    //                             $result = $fechadelCredito > $fechaReporte;


    //                             $result1 = $fechaReporte->lt($fechadelCredito) &&
    //                                 ($fechaReporte->diffInMonths($fechaReporte, false) === 1 ||
    //                                     $fechaReporte->diffInDays($fechadelCredito) <= 30);


    //                             $result2 =  $fechaReporte->gt($fechadelCredito) || ($fechaReporte->diffInDays($fechadelCredito) <= 30 && $fecha1eraCuota->diffInMonths($fechadelCredito) == 2);

    //                             //CUARTO CONDICIONAL
    //                             $resultado3 = $fechadelCredito->copy()->addMonth()->endOfMonth()->eq($fechaCarbon2->copy()->endOfMonth());

    //                             //QUINTO
    //                             $resultado4 = $fechadelCredito->lt($fechaReporte) && $fechaReporte->copy()->addMonth()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth()) && $fechaReporte->diffInDays($fechadelCredito) <= 30;


    //                             //SEXTO
    //                             $resultado5 = $fechadelCredito->gt($fechaReporte) ? false : ($fechaCarbon2->copy()->endOfMonth()->eq($fechaReporte->copy()->addMonth()->endOfMonth()) && $fechaReporte->diffInDays($fechadelCredito) <= 30);

    //                             if (($result == true && $result1 == true && $result2  == true) || ($resultado3 == true && $resultado4 == true &&  $resultado5  == true)) {
    //                                 $razon = 'Aprobado por cumplir las fechas pero faltaria el score.';
    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $razon = 'Aprobado por cumplir las fechas y ademas el credito no requiere consulta entonces es aprobado.';
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                             DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'edad' => $edad,
    //                                             'deuda' => $deuda,
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 1,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 0,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }
    //                             }else{
    //                                 if (($existeDia[0]->DIAS >= 1 || $existeDia[0]->DIAS <= 31) && $existeDia[0]->ENTREMES == 1) {
    //                                     $finalMesFechaCreditoUnMes = $fechadelCredito->copy()->addMonth(2)->endOfMonth();
    //                                     Carbon::setLocale('es');
    //                                     $fechadeStringCuotaEsperada = $finalMesFechaCreditoUnMes->translatedFormat('F d Y');
    //                                 }
    //                                 $razon = "Como la fecha de crédito fue " . $fechaStringCredito . " la primera cuota debe ser " . $fechadeStringCuotaEsperada .".";

    //                                 if ($NoAgencia == 34 || $NoAgencia == 35 || $NoAgencia == 36 || $NoAgencia == 37 || $NoAgencia == 38 || $NoAgencia == 40 || $NoAgencia == 41 || $NoAgencia == 87 || $NoAgencia == 93 || $NoAgencia == 96) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA

    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 1',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 33 || $NoAgencia == 39 || $NoAgencia == 46 || $NoAgencia == 70 || $NoAgencia == 77 || $NoAgencia == 78 || $NoAgencia == 80 || $NoAgencia == 88 || $NoAgencia == 92 || $NoAgencia == 98) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                             DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 2',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 32 || $NoAgencia == 42 || $NoAgencia == 47 || $NoAgencia == 81 || $NoAgencia == 82 || $NoAgencia == 83 || $NoAgencia == 85 || $NoAgencia == 90 || $NoAgencia == 94) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 3',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 44 || $NoAgencia == 45 || $NoAgencia == 48 || $NoAgencia == 49 || $NoAgencia == 74 || $NoAgencia == 75 || $NoAgencia == 84 || $NoAgencia == 89 || $NoAgencia == 91 || $NoAgencia == 95 || $NoAgencia == 97) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 4',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }else if ($NoAgencia == 13 || $NoAgencia == 30 || $NoAgencia == 31 || $NoAgencia == 43 || $NoAgencia == 68 || $NoAgencia == 73 || $NoAgencia == 76 || $NoAgencia == 86) {
    //                                     if (empty($existingPagare)) {
    //                                         //PARA TRAER EL NOMBRE DE LA AGENCIA POR EL NUMERO DE LA AGENCIA
    //                                         $existeAgencia = DB::select('SELECT NameAgencia FROM agencias WHERE NumAgencia = ?', [$NoAgencia]);
    //                                         $nombreAgencia = isset($existeAgencia[0]) ? $existeAgencia[0]->NameAgencia : null;
    //                                         DB::table('pagareprueba')->insert([
    //                                             'FechaReporte' => $fechaReporteString,
    //                                             'ExisteDatacredito' => 1,
    //                                             'Aprobado' => 0,
    //                                             'Razon' => $razon,
    //                                             'CoorAsignada' => 'Coordinacion 5',
    //                                             'AutorizacionGerente' => 1,
    //                                             'InteresProporcional' => $interesProporcionalCorrecto,
    //                                             'FechaAccion'=> $fechaStringCredito,
    //                                             'Garantia' => $garantia,
    //                                             'NoAgencia' => $agencia,
    //                                             'NombreAgencia' => $nombreAgencia,
    //                                             'CuentaCoop' => $cuenta,
    //                                             'Cedula_Persona' => $cedula,
    //                                             'NombreCompleto' => $nombres,
    //                                             'ID_Pagare' => $idpagare,
    //                                             'NoLC' => $registro['LINEA'],
    //                                             'Linea_Credito' => $registro['LINEANOM'],
    //                                             'Capital' => $capital,
    //                                             'NoCuotas' => $ncuotas,
    //                                             'ValorCuota' => $vcuotas,
    //                                             'Tasa' => $tasaAPI,
    //                                             'FechaCredito' => $fechaStringCredito,
    //                                             'Nomina' => $nomina .' - '.$nomNomina,
    //                                             'Direccion' => $direccion,
    //                                             'TelFijo' => $fijo,
    //                                             'Fecha1Cuota' => $fechaFormateada,
    //                                             'FechaUltimaCuota' => $fechaFormateada2,
    //                                             'Celular' => $celular,
    //                                             'Correo' => $correo,
    //                                             'GeneradorPagare' => $usuario,
    //                                             'ID_Persona'=> 7323
    //                                         ]);
    //                                     }
    //                                 }

    //                             }
    //                         //llave que cierra entremes
    //                         }
    //                 }
    //             }
    //             //cierre validacion pagare
    //         }
    //     }
    //     //CIERRE FOREACH
    //     }


    //     $user = DB::select("
    //     SELECT *
    //     FROM persona A
    //     JOIN pagareprueba B ON A.ID = B.ID_Persona
    //     WHERE B.Ordinario = 0
    //     ORDER BY A.ID ASC

    // ");


    // $enfermedades = DB::table('enfermedades')->get(); // Consulta para obtener todas las enfermedades

    // // Procesar las enfermedades para obtener un arreglo que se pueda agregar al DataTable
    // $dataEnfermedades = [];
    // foreach ($enfermedades as $enfermedad) {
    //     $dataEnfermedades[] = [
    //         'id' => $enfermedad->ID_Enferm,
    //         'nombre' => $enfermedad->Enfermedad,
    //     ];
    // }

    // return datatables()->of($user)
    //     ->addColumn('Enfermedades', function ($row) use ($dataEnfermedades) {
    //         $checkboxes = '<div class="row">';

    //         $numEnfermedades = count($dataEnfermedades);
    //         $numColumnas = 3;
    //         $numFilas = ceil($numEnfermedades / $numColumnas);

    //         for ($col = 0; $col < $numColumnas; $col++) {
    //             $checkboxes .= '<div class="col-md-4 text-start mb-2" id="asd">';

    //             for ($fila = 0; $fila < $numFilas; $fila++) {
    //                 $index = $fila + $col * $numFilas;

    //                 if ($index < $numEnfermedades) {
    //                     $enfermedad = $dataEnfermedades[$index];

    //                     $checkboxes .= '<label for="enfermedad_' . $index . '">
    //                                         <span class="fw-semibold">' . $enfermedad['id'] . '.</span>
    //                                         <input style="transform: scale(1.3);" type="checkbox" class="ms-1 mb-2" id="enfermedad_' . $index . '" name="enfermedades[]" value="'. $enfermedad['nombre'] .'">
    //                                         ' . $enfermedad['nombre'] . '
    //                                     </label><br>';
    //                 }
    //             }

    //             $checkboxes .= '</div>';
    //         }

    //         $checkboxes .= '</div>';

    //         return $checkboxes;
    //     })
    //     ->rawColumns(['Enfermedades'])
    //     ->toJson();
    // }
}
