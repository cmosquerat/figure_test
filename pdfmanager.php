<?php
header("Access-Control-Allow-Origin: *");
require("fpdf.php");
$contador = 1;


class PDF extends FPDF {

    const DPI = 96;
    const MM_IN_INCH = 25.4;
    const A4_HEIGHT = 297;
    const A4_WIDTH = 210;
    // tweak these values (in pixels)
    const MAX_WIDTH = 800;
    const MAX_HEIGHT = 500;

    function Header()
{

 
    // Arial bold 15
    $this->SetFont('Arial','B',15);
         $this->SetTextColor(128);
    $this->Image('logo.png',15,10,30,0,'','');
    // Movernos a la derecha
    $this->Cell(80);
    // Título
  
    // Salto de línea
    $this->Ln(20);


}


function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-20);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    
    // Número de página
    $this->Cell(20,10,'Page '.$this->PageNo().'/{nb}',0,1,'C');
    
}

    function pixelsToMM($val) {
        return $val * self::MM_IN_INCH / self::DPI;
    }

    function resizeToFit($imgFilename) {
        list($width, $height) = getimagesize($imgFilename);

        $widthScale = self::MAX_WIDTH / $width;
        $heightScale = self::MAX_HEIGHT / $height;

        $scale = min($widthScale, $heightScale);

        return array(
            round($this->pixelsToMM($scale * $width)),
            round($this->pixelsToMM($scale * $height))
        );
    }

    function centreImage($img) {
        list($width, $height) = $this->resizeToFit($img);

        // you will probably want to swap the width/height
        // around depending on the page's orientation
        $this->Image(
            $img, (self::A4_HEIGHT - $width) / 2,
            (self::A4_WIDTH - $height) / 2,
            $width,
            $height
        );
    }
}



$con = mysqli_connect('localhost','root','%unal$','db_cognitivo');

if(mysqli_connect_errno())
{
echo "Conexión Fallida";
exit();

}


$directory = $_POST['directory'];
$figuras = $_POST['figuras'];
$caracterizacion = $_POST['caracterizacion'];
$tiempo = $_POST['tiempo'];



$check_query = "SELECT DOCUMENTO,NOMBRE,APELLIDO1,APELLIDO2,EDAD,SEXO,CORREO,NOMBRE_DEPARTAMENTO_PROCEDEMCIA,NOMBRE_MUNICIPIO_PROCEDENCIA,ESTRATO,PBM,TIPCOLEGIO,ESTADO_CIVIL,PROM_ACADEMICO_ACTUAL,FACULTAD,SEDE,TIPO_NIVEL,PLAN FROM users WHERE documento = '" .$directory. "';";
$id_check = mysqli_query($con,$check_query) or die ("Usuario no encontrado");

if (mysqli_num_rows($id_check ) != 1){

	echo("Usuario no encontrado");
	exit();

}


$userdata = mysqli_fetch_assoc($id_check);


$file_path = 'upload/'.$directory;
$images = glob($file_path . "/*.png");
setlocale(LC_CTYPE, 'en_US');
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image('logo_unal.png',150,5,50,0,'','');

$pdf->SetFont('Times','',10);
$pdf->Ln(5);
$pdf->Rect(2, 2, 205, 292, 'D');
// 
$pdf->Ln(10);


$pdf-> SetFontSize(20);
$pdf->Cell(0,0,utf8_decode('Prueba Figuras Enmascaradas'),0,0,'C');
$pdf->Ln(30);
$pdf->Cell(20);
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

// Resultado figuras enmascaradas


$pdf->Ln(5);
$pdf->Cell(20);
$pdf-> SetFontSize(20);
$pdf->Cell(50,10,utf8_decode('Resultado Figuras Enmascaradas'),0,1,'L');
$pdf->Ln(2);
$pdf-> SetFontSize(10);
$pdf->SetTextColor(255);
$pdf->Cell(20);
$pdf->Cell(40,7,utf8_decode(' Figuras Completadas'),0,0,'L',true);
$pdf->Cell(40,7,utf8_decode(' Figuras no Completadas'),0,0,'L',true);
$pdf->Cell(30,7,utf8_decode(' Tiempo'),0,0,'L',true);
$pdf->Cell(40,7,utf8_decode(' Caracterizacion'),0,1,'L',true);
$pdf->SetTextColor(0);
$pdf->Cell(20.2);
$pdf->Cell(40,7,utf8_decode('  '.$figuras.' Figuras'),1,0,'L');
$pdf->Cell(40,7,utf8_decode( '  '.(50 - $figuras).' Figuras'),1,0,'L');
$pdf->Cell(30,7,utf8_decode( '  '.round(($tiempo/60),2).' Minutos'),1,0,'L');
$pdf->Cell(40,7,utf8_decode( '  '.$caracterizacion),1,1,'L');





$pdf->SetAutoPageBreak(false,10);
foreach($images as $image) {
	
	$pdf->AddPage("L");
    $pdf->Image('logo_unal.png',240,5,50,0,'','');
    $pdf->Rect(2, 2, 292, 205, 'D');
	$pdf->Cell(0,8,iconv('UTF-8', 'windows-1252', "Tablero: " . strval($contador)),0,1,'C');
    $pdf->centreImage($image);
    $contador += 1;
    
    
    
}



$pdf->Output('F',$file_path.'/resultado.pdf'); 
echo(sizeof($images));
?>

INSERT INTO `figuras` (`ID_FIGURAS`, `ID_TABLERO`, `NOMBRE_FIGURA`) VALUES (NULL, '', 'Figura 1'),(NULL, '', 'Figura 2'),(NULL, '', 'Figura  3'),(NULL, '', 'Figura  4'),(NULL, '', 'Figura  5'),(NULL, '', 'Figura 6'),(NULL, '', 'Figura 7'),(NULL, '', 'Figura 8'),(NULL, '', 'Figura 9'),(NULL, '', 'Figura 10')