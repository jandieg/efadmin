<?php
require_once MODELO.'Reporte.php';
require_once MODELO.'Grupo.php';
require_once MODELO.'Asistencia.php';
require_once E_LIB.'GeneradorPDF.php';

$objGrupo= new Grupo();
$nombre_forum= $objGrupo->getNombreForum_($_GET['_id_grupo']);
$tipo_evento= $_GET['_name_tipo_evento'];
$fecha= date("Y-m-d");
$nombre_grupo= $_GET['_name_grupo'];

$fecha_inicio = getPrimerDiaMes($_GET['_año'],'1');
$fecha_fin= getUltimoDiaMes($_GET['_año'],'12');

$columnas='';
$filas='';
////////////////////////////////////////////////////////////////////////////
// Base
$objAsistencia= new Asistencia();
if($_GET['_tipo_asistencia'] == "1"){
    $resultset= $objAsistencia->getAsistencia($_GET['_id_grupo'], $fecha_inicio, $fecha_fin,$_GET['_id_tipo_evento']);  
    $arrayMiembros= array();
    $arrayCabeceraId= array();
    $arrayCabecera= array();
    $arrayEventos= array();
    $banderaMiembros='';
    $cont= 1;
    $color="";
    while($row = $resultset->fetch_assoc()) { 
        $isFalta='';
        //Que solo sean fechas ya pasadas
        if(date('Y-m-d',strtotime($row['eve_fechafin'])) <= date("Y-m-d")){
            if($row['asis_estado'] == '0'){
                $checked="1";
                $color="";
            }else{
                $checked="";
                $color="#E2FCF7";
            }
            $isFalta=$row['asis_estado'];
        }else{
            $checked="";
            $color="";
        }
        //Guardo en un array todos los eventos, en base al miembro
        $arrayEventos[$cont] =  array("evento" => $checked,
            "color" => $color,
            "miembro_id" => $row['miembro_mie_id'],
            "faltas" => $isFalta,
            "control" => date('n',strtotime($row['eve_fechafin'])));
        //Guardo los miembros en un array, es decir, sin repeticiones
        if($banderaMiembros != $row['miembro_mie_id']){
           $arrayMiembros[$cont] = array("nombre" => $row['nombre'], "miembro_id" => $row['miembro_mie_id'], "fecha" => $row['eve_fechafin']);
        }
        $banderaMiembros=$row['miembro_mie_id'];

        //Guardo la cabecera que seran los meses de la fecha de cada evento
        if ( !in_array($row['eve_id'],  $arrayCabeceraId)) {
            $arrayCabecera[$cont]= array("valor" => date('M',strtotime($row['eve_fechafin'])),
                                             "control" => date('n',strtotime($row['eve_fechafin'])));
            $arrayCabeceraId[$cont]= $row['eve_id'];
        }  
        $cont= $cont + 1;         
    } 
        if(count($arrayCabecera) > 0){
            //Cabecera de la tabla
            $control=1;
            $columnas='';   
            $columnas .='<tr style="background-color:#2ECCFA;">';
            $columnas.='<th style="text-align:center;" width="25%">Nombres</th>';
            foreach($arrayCabecera as $valor =>$val){
                $columnas .= getAddMeses($control, $val["control"], $val["control"],TRUE, "4%");//Para add columnas
                $control= $val["control"] + 1;//Para add columnas

                $columnas .='<th style="text-align:center;" width="4%">'.$val["valor"].'</th>';
            }
             $columnas .= getAddMeses($control, 12, "",TRUE,"4%");//Para add columnas
                $columnas.='<th style="text-align:center;" width="5%">Faltas</th>';
        //        $columnas.='<th style="text-align:center;" width="8%">Falt. Promedio</th>';
        //        $columnas.='<th style="text-align:center;" width="8%">Asis. Promedio</th>';
            $columnas .='</tr>';
            //cuerpo de la tabla
            //$totalFaltasMes= array();
            $control=1;//Para add columnas
            $filas='';
            $promedio_totales=0;
            $cont2= 0;
            foreach ($arrayMiembros as $valores => $valor) { 
                $cont_faltas= 0;
                $cont= 0;
                $filas .='<tr>';
                $filas .='<td >&nbsp;&nbsp;'.$valor['nombre'].'</td>';

                foreach ($arrayEventos as $eventos => $evento) {

                    //unicamente va a dibujar los eventos del miembro
                    if($evento['miembro_id']==$valor['miembro_id']){   //$evento['mes']
                        $filas .= getAddMeses($control, $evento["control"], $evento["control"],FALSE,"");//Para add columnas
                        $control= $evento["control"] + 1;//Para add columnas
                       $filas .='<td style="text-align:center; background-color:'.$evento['color'].';">'.$evento['evento'].'</td>'; 
                        if($evento['faltas']=="0"){
                            $cont_faltas= $cont_faltas + 1;
                        }
                        if($evento['faltas'] != ""){
                            $cont= $cont + 1;
                        }

                    }
                }
                $filas .= getAddMeses($control, 12, '',FALSE,"");//Para add columnas
                $control= 1;
                //$promedio= round(($cont_faltas * 100) / $cont, 0);
                //$promedio_año=round((($cont - $cont_faltas) * 100 ) / $cont , 0);  
                $filas .='<td style="text-align:center;">'.$cont_faltas.'</td>';
        //        $filas .='<td style="text-align:center;">'.$promedio.'%</td>';
        //        $filas .='<td style="text-align:center;">'.$promedio_año.'%</td>';
                $filas .='</tr>';  

                //$promedio_totales= $promedio_totales + $promedio;
                $cont2= $cont2 + 1;
            }
            ////////////////////////////////////////////////////////////////////////////////
            //Calculando los totales
            $cont_faltas= 0;
            $cont= 0;

            $control=1;
            $filas .='<tr>';
            $filas .='<td style="text-align:right;">Totales</td>'; 
            $objAsistencia= new Asistencia();
            $resultset= $objAsistencia->getAsistenciaTotales($_GET['_id_grupo'], $fecha_inicio, $fecha_fin,$_GET['_id_tipo_evento']);  
            while($row = $resultset->fetch_assoc()) { 
                $fecha_num= date('n',strtotime($row['eve_fechafin']));
                $filas .= getAddMeses($control, $fecha_num, $fecha_num,FALSE,"");//Para add columnas
                $control= $fecha_num + 1;//Para add columnas 
                if(date('Y-m-d',strtotime($row['eve_fechafin'])) <= date("Y-m-d")){
                    $filas .='<td style="text-align:center;">'.($row['total_asistencia'] - $row['suma_aistencia_evento']).'</td>'; 
                    $cont_faltas= $cont_faltas + ($row['total_asistencia'] - $row['suma_aistencia_evento']);
                    $cont= $cont + 1;
                }else{
                    $filas .='<td style="text-align:center;"></td>'; 
                }

            }
            $filas .= getAddMeses($control, 12, '',FALSE,"");
            $promedio= round($promedio_totales / $cont2, 0);
            $promedio_año= 100 - $promedio;  
            $filas .='<td style="text-align:center;">'.$cont_faltas.'</td>';
        //    $filas .='<td style="text-align:center;">'.$promedio.'%</td>';
        //    $filas .='<td style="text-align:center;">'.$promedio_año.'%</td>';
            $filas .='</tr>';
}

}elseif($_GET['_tipo_asistencia'] == "3"){
    
        $resultset= $objAsistencia->getAsistenciaCasos($_GET['_id_grupo'], $fecha_inicio, $fecha_fin,$_GET['_id_tipo_evento']);  
        $arrayMiembros= array();
        $arrayCabeceraId= array();
        $arrayCabecera= array();
        //$arrayCabecera[0]= "Nombre";
        $arrayEventos= array();
        $banderaMiembros='';
        $caso="";
        $cont= 1;
        while($row = $resultset->fetch_assoc()) { 
            $caso="";
            //Que solo sean fechas ya pasadas
             if(date('Y-m-d',strtotime($row['eve_fechafin'])) <= date("Y-m-d")){
                if($row['id_eve_emp'] != ""){   
                    $caso="#2ECCFA";
                } 
             }
            //Guardo en un array todos los eventos, en base al miembro
            $arrayEventos[$cont] =  array("evento" =>  $caso,
                "miembro_id" => $row['miembro_mie_id'],
                "estado" => $row['estado'],
                "control" => date('n',strtotime($row['eve_fechafin'])));
            //Guardo los miembros en un array, es decir, sin repeticiones
            if($banderaMiembros != $row['miembro_mie_id']){
               $arrayMiembros[$cont] = array("nombre" => $row['nombre'], 
                   "miembro_id" => $row['miembro_mie_id']);
            }
            $banderaMiembros=$row['miembro_mie_id']; 
            //Guardo la cabecera que seran los meses de la fecha de cada evento
            if ( !in_array($row['eve_id'],  $arrayCabeceraId)) {
                
                //$arrayCabecera[$cont]= date('M',strtotime($row['eve_fechafin']));
                $arrayCabecera[$cont]= array("valor" => date('M',strtotime($row['eve_fechafin'])),
                                             "control" => date('n',strtotime($row['eve_fechafin'])));
                $arrayCabeceraId[$cont]= $row['eve_id'];
            }  
            $cont= $cont + 1;         
        } 
        //Cabecera de la tabla
        $control=1; //Para add columnas
        $columnas='';   
        $columnas.='<tr style="background-color:#2ECCFA;">';
        $columnas.='<th style="text-align:center;" width="28%">Nombres</th>';
        foreach($arrayCabecera as $valor => $val){
            $columnas .= getAddMeses($control, $val["control"], $val["control"],TRUE,"5%");//Para add columnas
            $control= $val["control"] + 1;//Para add columnas
            $columnas.='<th style="text-align:center;" width="5%">&nbsp;&nbsp;'.$val["valor"].'</th>';
        }
        $columnas .= getAddMeses($control, 12, "",TRUE,"5%");//Para add columnas
        $columnas .='</tr>';
        //cuerpo de la tabla
        $control=1;//Para add columnas
        $filas='';
        foreach ($arrayMiembros as $valores => $valor) {            
            $filas .='<tr>';
            $filas .='<td>&nbsp;&nbsp;'.$valor['nombre'].'</td>';
            foreach ($arrayEventos as $eventos => $evento) {
                //unicamente va a dibujar los eventos del miembro
                if($evento['miembro_id']==$valor['miembro_id']){   //$evento['mes']
                    $filas .= getAddMeses($control, $evento["control"], $evento["control"],FALSE,"");//Para add columnas
                    $control= $evento["control"] + 1;//Para add columnas
                    
                    $filas .='<td style="background-color:'.$evento['evento'].'; text-align:center;">&nbsp;&nbsp;</td>'; 
                }
            }
            $filas .= getAddMeses($control, 12, '',FALSE,"");//Para add columnas
            $filas .='</tr>';
            $control= 1;//Para add columnas
        }
}

////////////////////////////////////////////////////////////////////////////////

$html = '';
$html .= '<br/>
            <div style="font-size: 6px; text-align: center;"> <span>EXECUTIVE Inc.</span> </div>
            <br/>
            <table border="0" cellspacing="0" cellpadding="2">
                <tr style="font-size:9px;">
                    <td width="100">Grupo:</td>
                    <td width="200">'.$nombre_grupo.'</td>
                    <td style="text-align:right;" width="25%">Tipo Evento:</td>
                    <td width="20%"><font align="center" color="#FF0000" size="9">'.$tipo_evento.'</font></td>
               </tr>
               <tr style="font-size:9px;">
                    <td width="100">Forum Leader:</td>
                    <td width="200">'.$nombre_forum.'</td>
                    <td style="text-align:right;" width="25%">Fecha:</td>
                    <td width="20%"><font align="center" color="#FF0000" size="9">'.$fecha.'</font></td>
               </tr>
            </table>
            <br/>
            <div style="font-size: 12px; text-align: center;">
                    <span>'.$_GET['_name_tipo_asistencia'].' EXECUTIVE FORUM MEMBERS ('.$_GET['_año'].')</span>
            </div>
            <br/> 
            <div style="center;">
                <table cellpadding="2" cellspacing="0" border="1" style="font-size:8px;" width="100%">
                '.$columnas. $filas.'
                </table>
            </div>
            
            <br/>';


// L: Orientación Horizontal
// P: Orientación Vertical
$objEj = new GeneradorPDF('L', 'Reporte');
$objEj->setHtml($html);
$objEj->setCrearV2();


function getAddMeses($partida, $tope, $control, $bandera, $width) {
    $html=''; 
    for ($index = $partida; $index <= $tope; $index++) {
        if($index != $control){
            if($bandera == TRUE){
                $html.='<th style="text-align:center;" width="'.$width.'">'.getMesTexto($index).'</th>';
            }else{
                 $html.='<td></td>';  
            }         
        } 
    }
    return $html;
}

exit();
