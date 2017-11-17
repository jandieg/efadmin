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

function getDropdownMoneda($moneda, $id) {
    $html = "<select id='".$id."'>";
    $monedas = array(        
        'USD' => 'Dolar',
        'ARS' => 'Peso Argentino',
        'BOB' => 'Boliviano (Bolivia)',
        'CLP' => 'Peso Chileno',
        'COP' => 'Peso Colombiano',
        'CRC' => 'Colon Costarricense',
        'DOP' => 'Peso Dominicano',
        'MXN' => 'Peso Mexicano',
        'PEN' => 'Sol Peruano',
        'VEF' => 'Bolivar Venezolano'
    );

    foreach ($monedas as $k => $m) {
        if ($k == $moneda) {
            $html.= "<option value='".$k."' selected>".$m."</option>";
        } else {
            $html.= "<option value='".$k."'>".$m."</option>";
        }
    }

    $html.="</select>";
    return $html;
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
         print_r($objSede1->setTipoCambio(1, $anho, $sede, $_POST['_mes_1'], $_POST['_moneda_1']));
         $comp = $objSede2->setTipoCambio(2, $anho, $sede, $_POST['_mes_2'], $_POST['_moneda_2']);
         $comp = $objSede3->setTipoCambio(3, $anho, $sede, $_POST['_mes_3'], $_POST['_moneda_3']);
         $comp = $objSede4->setTipoCambio(4, $anho, $sede, $_POST['_mes_4'], $_POST['_moneda_4']);
         $comp = $objSede5->setTipoCambio(5, $anho, $sede, $_POST['_mes_5'], $_POST['_moneda_5']);
         $comp = $objSede6->setTipoCambio(6, $anho, $sede, $_POST['_mes_6'], $_POST['_moneda_6']);
         $comp = $objSede7->setTipoCambio(7, $anho, $sede, $_POST['_mes_7'], $_POST['_moneda_7']);
         $comp = $objSede8->setTipoCambio(8, $anho, $sede, $_POST['_mes_8'], $_POST['_moneda_8']);
         $comp = $objSede9->setTipoCambio(9, $anho, $sede, $_POST['_mes_9'], $_POST['_moneda_9']);
         $comp = $objSede10->setTipoCambio(10, $anho, $sede, $_POST['_mes_10'], $_POST['_moneda_10']);
         $comp = $objSede11->setTipoCambio(11, $anho, $sede, $_POST['_mes_11'], $_POST['_moneda_11']);
         $comp = $objSede12->setTipoCambio(12, $anho, $sede, $_POST['_mes_12'], $_POST['_moneda_12']);
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
         $listamon = array();
         $lasedeid = "";

         foreach ($datos as $d) {
            $lasede = $d['sede'];
            $lasedeid = $d['sede_id'];
            
            if (strlen($d['mes']) > 0) {
                $listamon[intval($d['mes'])] = $d['moneda'];
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
         <div class='span2 lista-botones'><span><strong>Sede: ".$lasede."</strong></span></div>";
         $lista .= "</div></br></br>";
        $lista.= "<div class='container-grids'>";
         foreach($datosm as $k => $dd) {
            if (strlen($listamon[$k]) > 0) {
                $lista.="
                <div class='".$meses[$k]."'>".getDropdownMoneda($listamon[$k],'moneda_'.$k)."</div>
                <div class='".$meses[$k]."'><span><strong>".$meses[$k].": </strong></span></div>
                <div class='".$meses[$k]."'><input ".$deshabilitado." type='text' id='mes_".$k."' value='".$dd."' /></div>"
                ;
            } else {
                $lista.= "
                <div class='".$meses[$k]."'>".getDropdownMoneda('USD','moneda_'.$k)."</div>
                <div class='".$meses[$k]."'><span><strong>".$meses[$k].": </strong></span></div>
                <div class='".$meses[$k]."'><input ".$deshabilitado." type='text' id='mes_".$k."' value='".$dd."' /></div>
                ";
            }             
         }
         $lista.="</div>";

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
         $listamon = array();
         $lasedeid = "";

         foreach ($datos as $d) {
            $lasede = $d['sede'];
            $lasedeid = $d['sede_id'];
            
            if (strlen($d['mes']) > 0) {
                $listamon[intval($d['mes'])] = $d['moneda'];
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
         <div class='span2 lista-botones'><span><strong>Sede: ".$lasede."</strong></span></div>";
         $lista .= "</div></br></br>";

         $lista.= "<div class='container-grids'>";
         foreach($datosm as $k => $dd) {
            if (strlen($listamon[$k]) > 0) {
                $lista.="
                <div class='".$meses[$k]."'>".getDropdownMoneda($listamon[$k],'moneda_'.$k)."</div>
                <div class='".$meses[$k]."'><span><strong>".$meses[$k].": </strong></span></div>
                <div class='".$meses[$k]."'><input ".$deshabilitado." type='text' id='mes_".$k."' value='".$dd."' /></div>"
                ;
            } else {
                $lista.= "
                <div class='".$meses[$k]."'>".getDropdownMoneda('USD','moneda_'.$k)."</div>
                <div class='".$meses[$k]."'><span><strong>".$meses[$k].": </strong></span></div>
                <div class='".$meses[$k]."'><input ".$deshabilitado." type='text' id='mes_".$k."' value='".$dd."' /></div>
                ";
            }             
         }
         $lista.="</div>";
         
         echo $lista;
         break;
        endswitch;
    } catch (Exception $exc) { echo getError($exc);}  
    
     exit(); 
}
?>