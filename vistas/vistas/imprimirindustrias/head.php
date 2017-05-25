<?php
//imprimirindustrias
//UPDATE `industria` SET `seccion_id`='3' WHERE `ind_id`>= '10' and ind_id <='33'
require_once MODELO.'Industria.php';
require_once E_LIB.'GeneradorPDF.php';

$nombre_forum= "";
$tipo_evento= "";
$fecha= date("Y-m-d");
$nombre_grupo= "";

// L: Orientación Horizontal
// P: Orientación Vertical
$objEj = new GeneradorPDF('P', 'Reporte');
////////////////////////////////////////////////////////////////////////////
// Base
$filas='';
$cont=1;
$bandera_2= '';
$seccion_subtitulo= '';
$bandera= FALSE;

$objIndustrias= new Industria();
$resultset= $objIndustrias->getIndustriasWithSeccion("A");
while($row = $resultset->fetch_assoc()) { 
    if($bandera_2 != $row['sec_ind_titulo']){
        $bandera_2= $row['sec_ind_titulo'];
        $bandera= FALSE;
    }else{
        $bandera= TRUE;
    }
    
    
    $pos = strpos($row['ind_descripcion'], "-");
    if($bandera == FALSE){
        $filas.='<tr>';
        $filas.= '<th colspan="3" scope="col" style="background-color:#2ECCFA; text-align:center; font-size:7px; font-weight:bold;">&nbsp;&nbsp;&nbsp;'.$row['sec_ind_titulo'].' - '.$row['sec_ind_subtitulo'].'</th>';
        $filas.='</tr>';   

        $filas.= $objEj->generadorTablaFilas(array(
                "",
                "&nbsp;&nbsp;&nbsp;".substr($row['ind_descripcion'], 0, $pos),
                "&nbsp;&nbsp;&nbsp;".substr($row['ind_descripcion'], $pos + 1))); 
        $bandera= TRUE;
        $bandera_2= $row['sec_ind_titulo'];
    }else{
        $filas.= $objEj->generadorTablaFilas(array(
                "",
                "&nbsp;&nbsp;&nbsp;".substr($row['ind_descripcion'], 0, $pos),
                "&nbsp;&nbsp;&nbsp;".substr($row['ind_descripcion'], $pos + 1))); 
        //$bandera_2= $row['sec_ind_titulo'];

    }
    
    $cont=$cont + 1;   
 }
$cab["1"] = array("width" => "7%","valor" => "&nbsp;&nbsp;&nbsp;Marcar" );
$cab["2"] = array("width" => "10%","valor" => "&nbsp;&nbsp;&nbsp;Código" );
$cab["3"] = array("width" => "83%","valor" => "&nbsp;&nbsp;&nbsp;Industrias" );
$columnas=  $objEj->generadorTablaColumnas($cab, "#2ECCFA", "bold" );
//$columnas ='';
////////////////////////////////////////////////////////////////////////////////

$html = '';
$html .= '<div style="">
            <table cellpadding="2" cellspacing="0" border="1" style=" font-size:6.5px;" width="100%">
            '.$columnas. $filas.'
            </table>
        </div>

        <br/>';

$objEj->setEncabezadoTitulo("Clasificación Industrial Internacional Uniforme de todas las Actividades Económicas (CIIU)");
$objEj->setEncabezadoSubTitulo("Naciones Unidas - Nueva York");
$objEj->setHtml($html);
$objEj->setCrearV1();

exit();
