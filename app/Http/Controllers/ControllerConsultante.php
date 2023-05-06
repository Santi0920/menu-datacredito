<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;



class ControllerConsultante extends Controller
{
        //listar
        public function listar()
        {
            $datos=DB::select("
            SELECT A.ID, A.Cedula, A.Nombre, A.Apellidos, A.Score, A.CuentaAsociada, A.Agencia, A.Estado,
            A.Reporte, B.FechaInsercion, B.NombreS, C.NombrePN, D.Consecutivof, D.Tipof, D.NombreT 
            FROM persona
            A JOIN documentosintesis B ON A.ID = B.ID_Persona JOIN documentopn C ON B.ID_Persona = C.ID_Persona JOIN documentot
            D ON C.ID_Persona = D.ID_Persona ORDER BY Nombre ASC");
            
            
            return view("consultante")->with("datos", $datos);
        }

public function imprimir($id)
    {
        $sql=DB::select("SELECT persona.*, documentosintesis.FechaInsercion FROM persona 
        INNER JOIN documentosintesis ON persona.ID = documentosintesis.ID_persona 
        WHERE persona.ID = $id");

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
        if ($diferencia->days <= 90) {
            $dias_restantes = 90 - $diferencia->days;
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

        //Estado
        $fpdf->SetFont('Helvetica', 'B',20);
        $fpdf->Cell(27,5,'Estado: ');
        $fpdf->SetFont('Helvetica', '',20);
        $fpdf->Cell(1,5, strtoupper($resultado->Estado));
        $fpdf->Ln();

        //Nombre
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



    $nombre_archivo = 'files/tickets/Ticket-'.$resultado->Cedula.'.pdf';
        $nombre_archivo2 = '../files/pn/PN-'.$resultado->Cedula.'.pdf';
        $nombre_archivo3 = '../files/sintesis/'.$resultado->Cedula.'-'.$resultado->Apellidos.'.pdf';
        $nombre_archivo4 = '../files/sintesis/'.$resultado->Cedula.'-'.$resultado->Apellidos.'.pdf';
        $url_qr = 'Proyecto/controllers/descargar.php?qr='.$resultado->ID;

  
        //QRcode::png($url_qr, 'Storage/temp/'.$nombre_archivo.'.png', QR_ECLEVEL_L, 5);
        
        // Agregar código QR al PDF
        //$fpdf->Image('../temp/.png', 2, 105, 100, 100);
        $fpdf->Ln();
        $fpdf->SetFont('Helvetica', 'B',48);
        $fpdf->Cell(72,40,'Agencia: ');
        $fpdf->SetFont('Helvetica', '',48);
        $fpdf->Cell(83,40, $resultado->Agencia);

        $fpdf->Output('I', 'Storage/files/tickets/Ticket-'.$resultado->Cedula.'.pdf');
        $fpdf->Output('F', 'Storage/files/tickets/Ticket-'.$resultado->Cedula.'.pdf');
        exit;
        
        }
    }
}

