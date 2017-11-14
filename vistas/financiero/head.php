<?php
require_once MODELO.'Sede.php';

function getTipoCambio($anho) {
    $objSede = new Sede();
    $resultset = $objSede->getTipoCambio($anho,$_SESSION['user_id_ben']);
    $data = array();
    $i = 0;
    while ($row = $resultset->fetch_assoc()) {
        $data[$i]['sede'] = $row['sede_razonsocial'];
        $data[$i]['sede_id'] = $row['sede_id'];
        $data[$i]['mes'] = $row['mes'];
        $data[$i]['cambio'] = $row['cambio'];
        $data[$i]['moneda'] = $row['moneda'];
        $i++;
    }
    return $data;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):
        case 'KEY_GUARDAR_CAMBIO' :
         $objSede1 = new Sede();
         $objSede2 = new Sede();
         $objSede3 = new Sede();
         $objSede4 = new Sede();
         $objSede5 = new Sede();
         $objSede6 = new Sede();
         $objSede7 = new Sede();
         $objSede8 = new Sede();
         $objSede9 = new Sede();
         $objSede10 = new Sede();
         $objSede11 = new Sede();
         $objSede12 = new Sede();
         $anho = $_POST['_anho'];
         $sede = $_POST['_sede'];
         print_r($objSede1->setTipoCambio(1, $anho, $sede, $_POST['_mes_1'], $_POST['_moneda']));
         $comp = $objSede2->setTipoCambio(2, $anho, $sede, $_POST['_mes_2'], $_POST['_moneda']);
         $comp = $objSede3->setTipoCambio(3, $anho, $sede, $_POST['_mes_3'], $_POST['_moneda']);
         $comp = $objSede4->setTipoCambio(4, $anho, $sede, $_POST['_mes_4'], $_POST['_moneda']);
         $comp = $objSede5->setTipoCambio(5, $anho, $sede, $_POST['_mes_5'], $_POST['_moneda']);
         $comp = $objSede6->setTipoCambio(6, $anho, $sede, $_POST['_mes_6'], $_POST['_moneda']);
         $comp = $objSede7->setTipoCambio(7, $anho, $sede, $_POST['_mes_7'], $_POST['_moneda']);
         $comp = $objSede8->setTipoCambio(8, $anho, $sede, $_POST['_mes_8'], $_POST['_moneda']);
         $comp = $objSede9->setTipoCambio(9, $anho, $sede, $_POST['_mes_9'], $_POST['_moneda']);
         $comp = $objSede10->setTipoCambio(10, $anho, $sede, $_POST['_mes_10'], $_POST['_moneda']);
         $comp = $objSede11->setTipoCambio(11, $anho, $sede, $_POST['_mes_11'], $_POST['_moneda']);
         $comp = $objSede12->setTipoCambio(12, $anho, $sede, $_POST['_mes_12'], $_POST['_moneda']);
         echo $comp;
        break;
         case 'KEY_GET_CAMBIO':
         $meses = array(
             1=>'Enero',
             2=>'Febrero',
             3=>'Marzo',
             4=>'Abril',
             5=>'Mayo',
             6=>'Junio',
             7=>'Julio',
             8=>'Agosto',
             9=>'Septiembre',
             10=>'Octubre',
             11=>'Noviembre',
             12=>'Diciembre'             
         );
         $datosm = array(
             1=>1,
             2=>1,
             3=>1,
             4=>1,
             5=>1,
             6=>1,
             7=>1,
             8=>1,
             9=>1,
             10=>1,
             11=>1,
             12=>1
         );
         $anho = date('Y');
         $datos = getTipoCambio($anho);
         $lasede = "";
         $lamoneda = "";
         $lasedeid = "";
         foreach ($datos as $d) {
            $lasede = $d['sede'];
            $lasedeid = $d['sede_id'];
            $lamoneda = $d['moneda'];
            if (strlen($d['mes']) > 0) {
                $datosm[intval($d['mes'])] = $d['cambio'];
            }
         }

         $lista = "<div class='flex-container'>"
         ."<div>".$datos['sede'] ."</div><input type='hidden' id='_la_sede' value ='".$lasedeid."'><div>"
         ."</div>";
         $deshabilitado = '';
         if (! in_array(trim($_SESSION['user_perfil']), array('Administrador Regional'))) {
             $deshabilitado = 'disabled';
         }
         
         $lista .= "<div class='row'>
         <div class='span2 lista-botones'><span><strong>Sede: ".$lasede."</strong></span></div>
         <div class='span2 lista-botones'><span><strong>Moneda: </strong></span><input type='text' id='_la_moneda' value='".$lamoneda."' "
         .$deshabilitado."></div>";
         foreach($datosm as $k => $dd) {
             $lista.= "<div class='span2 lista-botones'><span><strong>".$meses[$k].": </strong></span><input ".$deshabilitado." type='text' id='mes_".$k."' value='".$dd."' /></div>";
         }
         $lista .="</div>";
         $lista .="</div>";
         echo $lista;
         break;

          case 'KEY_GET_CAMBIO2':
         $meses = array(
             1=>'Enero',
             2=>'Febrero',
             3=>'Marzo',
             4=>'Abril',
             5=>'Mayo',
             6=>'Junio',
             7=>'Julio',
             8=>'Agosto',
             9=>'Septiembre',
             10=>'Octubre',
             11=>'Noviembre',
             12=>'Diciembre'             
         );
         $datosm = array(
             1=>1,
             2=>1,
             3=>1,
             4=>1,
             5=>1,
             6=>1,
             7=>1,
             8=>1,
             9=>1,
             10=>1,
             11=>1,
             12=>1
         );
         $anho = $_POST['_anho'];
         $datos = getTipoCambio($anho);
         $lasede = "";
         $lamoneda = "";
         $lasedeid = "";
         foreach ($datos as $d) {
            $lasede = $d['sede'];
            $lasedeid = $d['sede_id'];
            $lamoneda = $d['moneda'];
            if (strlen($d['mes']) > 0) {
                $datosm[intval($d['mes'])] = $d['cambio'];
            }
         }

         $lista = "<div class='flex-container'>"
         ."<div><strong>".$datos['sede'] ."</strong></div><input type='hidden' id='_la_sede' value ='".$lasedeid."'><div>"
         ."</div>";
         $deshabilitado = '';
         if (! in_array(trim($_SESSION['user_perfil']), array('Administrador Regional'))) {
             $deshabilitado = 'disabled';
         }
         $lista .= "<div class='row'>
         <div class='span2 lista-botones'><span><strong>Sede: ".$lasede."</strong></span></div>
         <div class='span2 lista-botones'><span><strong>Moneda: </strong></span><input type='text' id='_la_moneda' value='".$lamoneda."' "
         .$deshabilitado."></div>";
         foreach($datosm as $k => $dd) {
             $lista.= "<div class='span2 lista-botones'><span><strong>".$meses[$k].": </strong></span><input ".$deshabilitado." type='text' id='mes_".$k."' value='".$dd."' /></div>";
         }
         $lista .="</div>";
         $lista .="</div>";
         echo $lista;
         break;
        endswitch;
    } catch (Exception $exc) { echo getError($exc);}  
    
     exit(); 
}
?>