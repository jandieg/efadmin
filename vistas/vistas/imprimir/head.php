<?php
require_once MODELO.'Reporte.php';
require_once MODELO.'Grupo.php';
require_once MODELO.'StatusMember.php';
require_once E_LIB.'GeneradorPDF.php';
$objGrupo= new Grupo();
$nombre_grupo= $objGrupo->getNombreForum_($_GET['_id_grupo']);
//_año
if($_GET['_estado'] == '2'){
    $encabezado='DUES - TOP EXECUTIVE FORUM MEMBERS';
}else{
    $encabezado='DUES PENDING - EXECUTIVE FORUM MEMBERS';
}

// L: Orientación Horizontal
// P: Orientación Vertical
$objEj = new GeneradorPDF('L', 'Reporte');
$objEj->setAtributos(array('text-align' => 'center','font-weight' => 'bold', 'background-color' => '#2ECCFA'));

$cuerpo='';
$tabla = array();
$objR= new Reporte();
$objR->setEstablecerfehas($_GET['_año']);
if($_GET['_estado'] == '2'){
    $resultset= $objR->get($_GET['_id_grupo']);
}else{
    $resultset= $objR->getPendientes($_GET['_id_grupo']);
}
 while($row = $resultset->fetch_assoc()) { 
     array_push($tabla, $row);
     $cuerpo.= $objEj->generadorTablaFilas(array(
        (($row['Código'] == "zzz") ? "" : $row['Código']),
         $row['nombre'],
        (($row['EF Paid'] == "") ? "" : date('m-Y',strtotime($row['EF Paid']))),
         (($row['1st FM'] == "") ? "" : date('m-Y',strtotime($row['1st FM']))),
        (empty($row['Dues Mo']) ? "" : "$ ".$row['Dues Mo']),
         $row['status-Code'],
         (empty($row['Enero']) ? "" : "$ ".$row['Enero']),
         (empty($row['Febrero']) ? "" : "$ ".$row['Febrero']),
         (empty($row['Marzo']) ? "" : "$ ".$row['Marzo']),
         (empty($row['Abril']) ? "" : "$ ".$row['Abril']),
         (empty($row['Mayo']) ? "" : "$ ".$row['Mayo']),
         (empty($row['Junio']) ? "" : "$ ".$row['Junio']),
         (empty($row['Julio']) ? "" : "$ ".$row['Julio']),
         (empty($row['Agosto']) ? "" : "$ ".$row['Agosto']),
         (empty($row['Septiembre']) ? "" : "$ ".$row['Septiembre']),
         (empty($row['Octubre']) ? "" : "$ ".$row['Octubre']),
         (empty($row['Noviembre']) ? "" : "$ ".$row['Noviembre']),
         (empty($row['Diciembre']) ? "" : "$ ".$row['Diciembre']),
         (empty($row['YTD']) ? "" : "$ ".$row['YTD']))); 
  
 }    
 
$cab["1"] = array("width" => "50","valor" => "Código" );
$cab["2"] = array("width" => "100","valor" => "Nombre" );
$cab["3"] = array("width" => "40","valor" => "EF Paid" );
$cab["4"] = array("width" => "40","valor" => "1st FM" );
$cab["5"] = array("width" => "35","valor" => "Dues Mo" );
$cab["19"] = array("width" => "25","valor" => "Status" );
$cab["6"] = array("width" => "35","valor" => "January" );
$cab["7"] = array("width" => "35","valor" => "February" );
$cab["8"] = array("width" => "35","valor" => "March" );
$cab["9"] = array("width" => "35","valor" => "April" );
$cab["10"] = array("width" => "35","valor" => "May" );
$cab["11"] = array("width" => "35","valor" => "June" );
$cab["12"] = array("width" => "35","valor" => "July" );
$cab["13"] = array("width" => "35","valor" => "August" );
$cab["14"] = array("width" => "40","valor" => "September" );
$cab["15"] = array("width" => "35","valor" => "October" );
$cab["16"] = array("width" => "40","valor" => "November" );
$cab["17"] = array("width" => "40","valor" => "December" );
$cab["18"] = array("width" => "35","valor" => "YTD" );
     
 
$tabla1 = $objEj->generadorTabla($cab, $cuerpo);

$tablapie= array();
$objStatus= new StatusMember();
$resultset= $objStatus->get('A','1');
while ($row = $resultset->fetch_assoc()) {
	array_push($tablapie, array($row['mem_sta_codigo'],$row['mem_sta_descripcion']));
}
$tabla2 =$objEj->generadorGlosario($tablapie);

$html = '';
$html .= '<br/><br/>
            <div style="font-size: 6px; text-align: center;"> <span>EXECUTIVE Inc.</span> </div>
            <br/>
            <table border="0" cellspacing="0" cellpadding="2">
                <tr style="font-size:9px;">
                        <td width="25%">International Business Partner:</td>
                        <td width="20%">ECUADOR-01</td>
                        <td style="text-align:right;" width="35%">Forum Leader:</td>
                        <td width="20%"><font align="center" color="#FF0000" size="9">'.$nombre_grupo.'</font></td>
               </tr>
               <tr style="font-size:9px;">
                            <td style="text-align:center;" width="25%">Reflects "Received Revenues" thru:</td>
                            <td width="20%">'.date('Y-m-d').'</td>
               </tr>
            </table>
            <br/>
            <div style="font-size: 12px; text-align: center;">
                    <span>'.$encabezado.'</span>
            </div>
            <br/> 
            '.$tabla1.'
            <br/> 
            <br/>
            <span style="font-size:6px;">* Member Status Code</span>
            <br/> 
            '.$tabla2.'
            <br/>';

$objEj->setHtml($html);
$objEj->setCrearV2();
exit();
