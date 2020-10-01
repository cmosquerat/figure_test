<?php
header("Access-Control-Allow-Origin: *");
require('lolpdf/fpdf.php');
require_once 'core/init2.php'; 

class PDF extends FPDF
{
// Cabecera de página


function Circle($x, $y, $r, $style='D')
{
    $this->Ellipse($x,$y,$r,$r,$style);
}

function Ellipse($x, $y, $rx, $ry, $style='D')
{
    if($style=='F')
        $op='f';
    elseif($style=='FD' || $style=='DF')
        $op='B';
    else
        $op='S';
    $lx=4/3*(M_SQRT2-1)*$rx;
    $ly=4/3*(M_SQRT2-1)*$ry;
    $k=$this->k;
    $h=$this->h;
    $this->_out(sprintf('%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c',
        ($x+$rx)*$k,($h-$y)*$k,
        ($x+$rx)*$k,($h-($y-$ly))*$k,
        ($x+$lx)*$k,($h-($y-$ry))*$k,
        $x*$k,($h-($y-$ry))*$k));
    $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
        ($x-$lx)*$k,($h-($y-$ry))*$k,
        ($x-$rx)*$k,($h-($y-$ly))*$k,
        ($x-$rx)*$k,($h-$y)*$k));
    $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
        ($x-$rx)*$k,($h-($y+$ly))*$k,
        ($x-$lx)*$k,($h-($y+$ry))*$k,
        $x*$k,($h-($y+$ry))*$k));
    $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c %s',
        ($x+$lx)*$k,($h-($y+$ry))*$k,
        ($x+$rx)*$k,($h-($y+$ly))*$k,
        ($x+$rx)*$k,($h-$y)*$k,
        $op));
}

function Header()
{

 
    // Arial bold 15
    $this->SetFont('Arial','B',15);
         $this->SetTextColor(128);
    $this->Image('lolpdf/img/logo.png',15,10,30,0,'','');
    // Movernos a la derecha
    $this->Cell(80);
    // Título
  
    // Salto de línea
    $this->Ln(20);


}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-20);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    
    // Número de página
    $this->Cell(20,10,'Page '.$this->PageNo().'/{nb}',0,1,'C');
    
}
}



require_once 'core/init2.php'; 



$userdata = getUserDataByUserId2($_POST['id']);
$cuetionario= getCuestionario($_POST['id']);

// Creación de pdf

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image('images/escudoUnal_black.png',150,5,50,0,'','');

$pdf->SetFont('Times','',10);
$pdf->Ln(5);
$pdf->Rect(2, 2, 205, 292, 'D');
// 
$pdf->Ln(10);

$pdf->Cell(25);
$pdf-> SetFontSize(20);
$pdf->Cell(50,10,utf8_decode('Datos personales'),0,1,'L');
$pdf-> SetFontSize(10);
$pdf->Ln(2);
$pdf->SetTextColor(255);
$pdf->SetFillColor(75,161,187);
$pdf->Cell(20);
$pdf->Cell(150,7,utf8_decode(' Documento'),0,1,'L',true);

$pdf->SetTextColor(0);
$pdf->Cell(20.2);
$pdf->Cell(149.7,7,utf8_decode('  '.$userdata['DOCUMENTO']),1,1,'L');

//////// tablas
$pdf->SetTextColor(255);
$pdf->Cell(20);
$pdf->Cell(75,7,utf8_decode(' Nombre'),0,0,'L',true);
$pdf->Cell(75,7,utf8_decode(' Apellidos'),0,1,'L',true);
$pdf->SetTextColor(0);
$pdf->Cell(20.2);
$pdf->Cell(74.7,7,utf8_decode('  '. $userdata['NOMBRE']),1,0,'L');
$pdf->Cell(75,7,utf8_decode( '  '.$userdata['APELLIDO1'].' '.$userdata['APELLIDO2']),1,1,'L');
/////////tabla
$pdf->SetTextColor(255);
$pdf->Cell(20);
$pdf->Cell(75,7,utf8_decode(' Lugar de nacimiento'),0,0,'L',true);
$pdf->Cell(37.5,7,utf8_decode(' Edad'),0,0,'L',true);
$pdf->Cell(37.5,7,utf8_decode(' Género'),0,1,'L',true);
$pdf->SetTextColor(0);
$pdf->Cell(20.2);
$pdf->Cell(74.7,7,utf8_decode('  '. $userdata['NOMBRE_MUNICIPIO_PROCEDENCIA'] . '- '. $userdata['NOMBRE_DEPARTAMENTO_PROCEDEMCIA']),1,0,'L');
$pdf->Cell(37.5,7,utf8_decode( '  '.$userdata['EDAD']),1,0,'L');
$pdf->Cell(37.5,7,utf8_decode( '  '.$userdata['SEXO']),1,1,'L');

/////////tabla
$pdf->SetTextColor(255);
$pdf->Cell(20);
$pdf->Cell(50,7,utf8_decode(' Correo'),0,0,'L',true);
$pdf->Cell(40,7,utf8_decode(' Estado Civil'),0,0,'L',true);
$pdf->Cell(30,7,utf8_decode(' PBM'),0,0,'L',true);
$pdf->Cell(30,7,utf8_decode(' PAPA'),0,1,'L',true);
$pdf->SetTextColor(0);
$pdf->Cell(20.2);
$pdf->Cell(49.7,7,utf8_decode('  '.$userdata['CORREO']),1,0,'L');
$pdf->Cell(40,7,utf8_decode( '  '.$userdata['ESTADO_CIVIL']),1,0,'L');
$pdf->Cell(30,7,utf8_decode( '  '.$userdata['PBM']),1,0,'L');
$pdf->Cell(30,7,utf8_decode( '  '.$userdata['PROM_ACADEMICO_ACTUAL']),1,1,'L');


//// 
$pdf->Ln(5);
$pdf->Cell(20);
$pdf-> SetFontSize(20);
$pdf->Cell(50,10,utf8_decode('Programa Académico'),0,1,'L');
$pdf->Ln(2);
$pdf-> SetFontSize(10);
$pdf->SetTextColor(255);
$pdf->Cell(20);
$pdf->Cell(75,7,utf8_decode(' Sede'),0,0,'L',true);
$pdf->Cell(75,7,utf8_decode(' Plan'),0,1,'L',true);
$pdf->SetTextColor(0);
$pdf->Cell(20.2);
$pdf->Cell(74.7,7,utf8_decode('  '. $userdata['SEDE']),1,0,'L');
$pdf->Cell(75,7,utf8_decode( '  '.$userdata['PLAN']),1,1,'L');


$pdf->SetTextColor(255);
$pdf->Cell(20);
$pdf->Cell(110,7,utf8_decode(' Facultad'),0,0,'L',true);
$pdf->Cell(40,7,utf8_decode(' Nivel'),0,1,'L',true);
$pdf->SetTextColor(0);
$pdf->Cell(20.2);
$pdf->Cell(109.7,7,utf8_decode('  '. $userdata['FACULTAD']),1,0,'L');
$pdf->Cell(40,7,utf8_decode( '  '.$userdata['TIPO_NIVEL']),1,1,'L');

$pdf->Ln(5);
$DOCUMENTO= $_POST['id'];

$sql2 = "SELECT tipo FROM validacion WHERE id_cuestionario = 2 
              and DOCUMENTO = $DOCUMENTO";
              $query2 = $connect->query($sql2);
              $result2 = $query2->fetch_array();






 if($result2['tipo']==1){
                $pdf->Circle(70,200,10,'F');
                }
                else{
                  $pdf->Circle(70,200,10,'D');
              }    

              if($result2['tipo']==2){
                $pdf->Circle(145,200,10,'F');
              }
              else{
                 $pdf->Circle(145,200,10,'F');
            }     


 
 $pdf->Ln(5);
$pdf->SetTextColor(255);
$pdf->Cell(20);
$pdf->Cell(150,7,utf8_decode('Perfil Cognitivo'),0,1,'C',true);
$pdf->SetTextColor(0);
$pdf->Cell(20);
$pdf->Cell(75,7,utf8_decode('dependiente'),1,0,'C');
$pdf->Cell(75,7,utf8_decode('indendiente'),1,0,'C');









$pdf->AddPage('L','letter');
$pdf->Image('images/escudoUnal_black.png',210,5,50,0,'','');
$pdf->Ln(10);

$pdf->SetTextColor(255);
    $pdf->Cell(180,7,utf8_decode(' Descripcion'),0,0,'L',true);
    $pdf->SetTextColor(0);

     $pdf->Cell(70,7,utf8_decode('                    0          1         2         3'),1,1,'L',false);

    $numy=50;
    $radio=2;

$DOCUMENTO= $_POST['id'];
$sql = "SELECT descripcion,valor FROM respuestas,pregunta,cuestionarios WHERE cuestionarios.id_cuestionario = 2 
                    and respuestas.id_pregunta = pregunta.id_pregunta and pregunta.id_pregunta =cuestionarios.id_pregunta and DOCUMENTO = $DOCUMENTO";
                    $query = $connect->query($sql);

                $sql3 = "SELECT valor FROM validacion WHERE id_cuestionario = 2  and DOCUMENTO = $DOCUMENTO";

                        $query3 = $connect->query($sql3);
                        $con =$query3->fetch_array();

        if ($con['valor']==1) {

                       while ($result = $query->fetch_array()) {
                          
                          $pdf->Cell(180,7,utf8_decode(' '.$result['descripcion']),1,0,'L',false);
                          $pdf->Cell(70,7,utf8_decode(' '),1,1,'L',false);
                          $numx=210;
                         if($result['valor']==0){
                             $pdf->Circle ($numx,$numy,$radio,'F');
                         }else{
                             $pdf->Circle($numx,$numy,$radio,'D');
                         }
                         $numx+=10;
                        if($result['valor']==1){
                             $pdf->Circle($numx,$numy,$radio,'F');
                         }else{
                             $pdf->Circle($numx,$numy,$radio,'D');
                         }
                         $numx+=10;
                         if($result['valor']==2){
                             $pdf->Circle($numx,$numy,$radio,'F');
                         }else{
                             $pdf->Circle($numx,$numy,$radio,'D');
                         }
                         $numx+=10;
                         if($result['valor']==3){
                             $pdf->Circle($numx,$numy,$radio,'F');
                         }else{
                             $pdf->Circle($numx,$numy,$radio,'D');
                         }
                         $numx+=10;
                        
                         $numy=$numy+7;
                     }
                 }


$pdf->Output();
?>