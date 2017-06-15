<?php

session_start();

error_reporting(E_ERROR | E_PARSE);

include_once("../../incluidos/db_config/config.php");



$currency = '$ ';

$smtp_Username ='jdb';// '9198ce4c0a23ad0d51628e6f5c62c68d';

$smtp_Password ='Welcome123!';// 'cdf0cff2d7e8684e0faeb484936682d2'; //OLD PWD 427f36aba4d2bf1e16a0a4e26f49b4a2





$sql = "SELECT * FROM miembro_inscripcion WHERE MONTH(mie_ins_fecha_cobro)='$i' AND YEAR(mie_ins_fecha_cobro)='$year' AND YEAR(mie_ins_fecha_ingreso)='$year'";	


function set_report_date($year){
	$nextyear = intval($year) + 1; 
	$fechabase = $nextyear."0430";
	$fechabase2 = date('Ymd');
	if (intval($fechabase) > intval($fechabase2) ) {
		$data = date('m/d/Y');
	} else {
		$data = "04/30/".$nextyear;
	}
/*if($year < date('Y')){
$data = "12/1/".$year;
}else{
$data = date('m/d/Y');
}*/


return $data;
}



function calculate_summary_value($month,$year,$type){

include("../../incluidos/db_config/config.php");

$array = array("1","3","4");

if($type=='dues'){

//$sql = "SELECT sum(mie_ins_valor) AS total FROM miembro_inscripcion WHERE MONTH(mie_ins_fechamodificacion)='$month' AND YEAR(mie_ins_fechamodificacion)='$year' AND estado_cobro_id='2'";

$sql="SELECT sum(cobro_total) AS total FROM cobro WHERE MONTH(cobro_fecharegistro)='$month' AND YEAR(cobro_fecharegistro)='$year'";

}

if($type=='enrollment'){

	//AND miembro.status_member_id IN (".implode(',', $array).")

$sql="SELECT miembro.*, miembro_inscripcion.*, SUM(miembro_inscripcion.mie_ins_valor) AS total FROM miembro, miembro_inscripcion WHERE YEAR(miembro_inscripcion.mie_ins_fecha_ingreso)='$year' AND MONTH(miembro_inscripcion.mie_ins_fecha_cobro)='$month' AND YEAR(miembro_inscripcion.mie_ins_fecha_cobro)='$year' AND miembro.mie_id = miembro_inscripcion.miembro_id ";

}

if($type=='other'){

$sql="SELECT miembro.*, miembro_inscripcion.*, SUM(miembro_inscripcion.mie_ins_valor) AS total FROM miembro, miembro_inscripcion WHERE YEAR(miembro_inscripcion.mie_ins_fecha_cobro)='$year' AND MONTH(miembro_inscripcion.mie_ins_fecha_cobro)='$month' AND miembro.status_member_id NOT IN (".implode(',', $array).") AND miembro.mie_id = miembro_inscripcion.miembro_id ";

}

if($type=='price'){

	/*

	SELECT MAX(t0.detalleprecobro_valor)

FROM detallepresupuestocobro AS t0

WHERE ((MONTH(t0.detalleprecobro_fechavencimiento) = mes) AND (YEAR(t0.detalleprecobro_fechavencimiento) = a�o))

	*/

$sql="SELECT MAX(t0.precobro_valor) AS total

FROM presupuestocobro AS t0

WHERE (t0.precobro_year = '$year')";

}

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		if($type=='enrollment'){

		$data = $row['total'];	

		}else{

		$data = $row['total'];	

		}

		

		if (!$data){

			$data='0';

		}

		

return $data;

}



//echo calculate_summary_value('01','2016','dues');







function convert_datetime($string,$type){

	

        $sql_date=strtotime($string);

		$month =  date('m', $sql_date);

		$day =  date('d', $sql_date);

		$year =  date('Y', $sql_date);

if($type=='literal'){

if($month==1){ $month='Jan'; }

if($month==2){ $month='Feb'; }

if($month==3){ $month='Mar'; }

if($month==4){ $month='Apr'; }

if($month==5){ $month='May'; }

if($month==6){ $month='Jun'; }

if($month==7){ $month='Jul'; }

if($month==8){ $month='Aug'; }

if($month==9){ $month='Sep'; }

if($month==10){ $month='Oct'; }

if($month==11){ $month='Nov'; }

if($month==12){ $month='Dic'; }

		$data = $month.'-'.$year;



}else if($type=='month'){

			$data = $month;



}else {

		$data = $month.'/'.$day.'/'.$year;

	

}

		

		

		return $data;



}



//echo convert_datetime('2003-05-01 00:00:00','test');



function getInscription_info($id,$type){

include("../../incluidos/db_config/config.php");

		$sql = "SELECT * FROM miembro_inscripcion WHERE miembro_id='$id'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		if($type=='ins'){

		$sql_date=$row['mie_ins_fecha_ingreso'];
		if ( substr($row['mie_ins_fecha_ingreso'],0,10) == "2000-01-01") {
			$data = '-';			
		} else {
			$data = convert_datetime($sql_date,'literal');
		}
		

		}else if($type=='ins_month'){

		$str=strtotime($row['mie_ins_fecha_ingreso']);

		$month =  date('m', $str);

		$data = $month;

		}else if($type=='ins_year'){

		$str=strtotime($row['mie_ins_fecha_ingreso']);

		$year =  date('Y', $str);

		$data = $year;

		}else{

		$sql_date=$row['mie_ins_fecha_cobro'];
		if (substr($sql_date,0,10) == "2000-01-01" || $row['estado_cobro_id'] == 1) {
			$data = "-";
		} else {
			$data = convert_datetime($sql_date,'literal');
		}
		

		}

		

		return $data;

}

/*
echo getInscription_info(97,'ins_month');
echo '<p>';
echo getInscription_info(97,'ins_year');
*/


function getPaying_info($memid,$type,$SP){

	include("../../incluidos/db_config/config.php");

	



		$sql = "SELECT * FROM miembro_inscripcion WHERE miembro_id='$memid'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		

		

		$sql_date = strtotime($row['mie_ins_fecha_cobro']);

		$month =  date('m', $sql_date);

		$day =  date('d', $sql_date);

		

		//Transforming Months to Text//

if($month==1){ $month='Jan'; }

if($month==2){ $month='Feb'; }

if($month==3){ $month='Mar'; }

if($month==4){ $month='Apr'; }

if($month==5){ $month='May'; }

if($month==6){ $month='Jun'; }

if($month==7){ $month='Jul'; }

if($month==8){ $month='Aug'; }

if($month==9){ $month='Sep'; }

if($month==10){ $month='Oct'; }

if($month==11){ $month='Nov'; }

if($month==12){ $month='Dic'; }



if($type=='dates'){

$data = $month.'-'.$day;	

}

if($type=='price'){

	

	if($SP>=1){

	$data=$row['mie_ins_valor'] - $SP;		

	}else{

	$data = $row['mie_ins_valor'];

	}

}







		return $data;



}





function get_paid_month_info($id,$month,$year){

	include("../../incluidos/db_config/config.php");

	

		$sql = "SELECT sum(cobro_total) AS TOTAL FROM cobro WHERE miembro_id='$id' AND MONTH(cobro_fecharegistro)='$month' AND YEAR(cobro_fecharegistro)='$year'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		

		$total = $row['TOTAL'];

		

		if($total){

			$total = $row['TOTAL'];

		}else{

		    $total='';	

		}

		

		return $total;



}



//echo comment_months('37','01','2016');



function detectPayment($id,$month,$year,$pos){

		include("../../incluidos/db_config/config.php");

		$sql = "SELECT * FROM detallecobro WHERE miembro_mie_id='$id' AND MONTH(det_cobro_fecharegistro)='$month' AND YEAR(det_cobro_fecharegistro)='$year'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		$sql_date = strtotime($row['det_cobro_fecharegistro']);

		$data =  date('m', $sql_date);	

		return $data;

		

}



function countPayments($id,$month,$year,$pos){

		include("../../incluidos/db_config/config.php");

		$sql = "SELECT count(det_cobro_id) AS total FROM detallecobro WHERE miembro_mie_id='$id' AND MONTH(det_cobro_fecharegistro)='$month' AND YEAR(det_cobro_fecharegistro)='$year' Group By det_cobro_fecharegistro";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		$data =  $row['total'];	

		return $data;

		

}







//echo countPayments('37','01','2016','9');



function comment_months($id,$month,$year,$pos){

	include("../../incluidos/db_config/config.php");

		$sql = "SELECT * FROM detallecobro WHERE miembro_mie_id='$id' AND MONTH(det_cobro_fecharegistro)='$month' AND YEAR(det_cobro_fecharegistro)='$year'";	

		$res = mysqli_query($con,$sql);

		$data = ' ';

		while($row = mysqli_fetch_array($res)){

		$sql_date = get_Paid_months($row['detallepresupuestocobro_detalleprecobro_id']);

$month =  date('m', $sql_date);	
$xyear =  date('Y', $sql_date);	

if($month==1){ $month='ENERO'.$xyear; //cellColor('H'.$pos, 'ffff00'); 

}

if($month==2){ $month='FEBRERO'.$xyear; //cellColor('I'.$pos, 'ffff00'); 

}

if($month==3){ $month='MARZO'.$xyear; //cellColor('J'.$pos, 'ffff00'); 

}

if($month==4){ $month='ABRIL'.$xyear; //cellColor('K'.$pos, 'ffff00'); 

}

if($month==5){ $month='MAYO'.$xyear; //cellColor('L'.$pos, 'ffff00'); 

}

if($month==6){ $month='JUNIO'.$xyear; //cellColor('M'.$pos, 'ffff00'); 

}

if($month==7){ $month='JULIO'.$xyear; //cellColor('N'.$pos, 'ffff00'); 

}

if($month==8){ $month='AGOSTO'.$xyear; //cellColor('O'.$pos, 'ffff00'); 

}

if($month==9){ $month='SEPTIEMBRE'.$xyear; //cellColor('P'.$pos, 'ffff00'); 

}

if($month==10){ $month='OCTUBRE'.$xyear; //cellColor('Q'.$pos, 'ffff00'); 

}

if($month==11){ $month='NOVIEMBRE'.$xyear; //cellColor('R'.$pos, 'ffff00'); 

}

if($month==12){ $month='DICIEMBRE'.$xyear; //cellColor('S'.$pos, 'ffff00'); 

}



		

		$data.= $month.'  '; 

		}

		return $data;
		//return substr($data,0,-2);
}

function comment_months_literal($id,$month,$year,$pos){

	include("../../incluidos/db_config/config.php");

		$sql = "SELECT * FROM detallecobro WHERE miembro_mie_id='$id' AND MONTH(det_cobro_fecharegistro)='$month' AND YEAR(det_cobro_fecharegistro)='$year'";	

		$res = mysqli_query($con,$sql);

		$data = ' ';

		while($row = mysqli_fetch_array($res)){

		$sql_date = get_Paid_months($row['detallepresupuestocobro_detalleprecobro_id']);

$month =  date('m', $sql_date);	
$xyear =  date('Y', $sql_date);	

if($month==1){ $month='ENERO'; //cellColor('H'.$pos, 'ffff00'); 

}

if($month==2){ $month='FEBRERO'; //cellColor('I'.$pos, 'ffff00'); 

}

if($month==3){ $month='MARZO'; //cellColor('J'.$pos, 'ffff00'); 

}

if($month==4){ $month='ABRIL'; //cellColor('K'.$pos, 'ffff00'); 

}

if($month==5){ $month='MAYO'; //cellColor('L'.$pos, 'ffff00'); 

}

if($month==6){ $month='JUNIO'; //cellColor('M'.$pos, 'ffff00'); 

}

if($month==7){ $month='JULIO'; //cellColor('N'.$pos, 'ffff00'); 

}

if($month==8){ $month='AGOSTO'; //cellColor('O'.$pos, 'ffff00'); 

}

if($month==9){ $month='SEPTIEMBRE'; //cellColor('P'.$pos, 'ffff00'); 

}

if($month==10){ $month='OCTUBRE'; //cellColor('Q'.$pos, 'ffff00'); 

}

if($month==11){ $month='NOVIEMBRE'; //cellColor('R'.$pos, 'ffff00'); 

}

if($month==12){ $month='DICIEMBRE'; //cellColor('S'.$pos, 'ffff00'); 

}



		

		$data.= $month.'  '; 

		}

		return $data;
		//return substr($data,0,-2);
}

function getColorPintar($mes,$anho,$anhorep) {
	$nextyear = intval($anhorep) +1;
	$nextyear = $nextyear *100;
	$nextyear = $nextyear + 4;
	$data = array();
	$data['primeranho'] = true;
	if (intval($anho) < intval($anhorep)) {
		$data['value'] = "H";
	}
	if (intval($anho.$mes) > $nextyear) {
		return "ZZ";
	}
	
	
	if (intval($anho) > $anhorep) {
		$data['primeranho'] = false;
	}
	if ($mes == "01") {
		if ($data['primeranho']) {
			$data['value'] = "H";
		} else {
			$data['value'] = "U";
		}
		
		
	} else if ($mes == "02") {
		if ($data['primeranho']) {
			$data['value'] = "I";
		} else {
			$data['value'] = "V";
		}		
	} else if ($mes == "03") {
		if ($data['primeranho']) {
			$data['value'] = "J";
		} else {
			$data['value'] = "W";
		}		
	} else if ($mes == "04") {
		if ($data['primeranho']) {
			$data['value'] = "K";
		} else {
			$data['value'] = "X";
		}		
	} else if ($mes == "05") {
		$data['value'] = "L";
	} else if ($mes == "06") {
		$data['value'] = "M";
	} else if ($mes == "07") {
		$data['value'] = "N";
	} else if ($mes == "08") {
		$data['value'] = "O";
	} else if ($mes == "09") {
		$data['value'] = "P";
	} else if ($mes == "10") {
		$data['value'] = "Q";
	} else if ($mes == "11") {
		$data['value'] = "R";
	} else {
		$data['value'] = "S";
	}
	return $data;
}

function comment_months_literal_nextyear($id,$month,$year,$pos){

	include("../../incluidos/db_config/config.php");

		$sql = "SELECT * FROM detallecobro WHERE miembro_mie_id='$id' AND MONTH(det_cobro_fecharegistro)='$month' AND YEAR(det_cobro_fecharegistro)='$year'";	

		$res = mysqli_query($con,$sql);

		$data = ' ';

		while($row = mysqli_fetch_array($res)){

		$sql_date = get_Paid_months($row['detallepresupuestocobro_detalleprecobro_id']);

$month =  date('m', $sql_date);	
$xyear =  date('Y', $sql_date);	

if($month==1){ $month='ENERO'; //cellColor('H'.$pos, 'ffff00'); 

}

if($month==2){ $month='FEBRERO'; //cellColor('I'.$pos, 'ffff00'); 

}

if($month==3){ $month='MARZO'; //cellColor('J'.$pos, 'ffff00'); 

}

if($month==4){ $month='ABRIL'; //cellColor('K'.$pos, 'ffff00'); 

}
		if (strlen($month) < 3) {
			$month = "";
		}

		$data.= $month.'  '; 

		}

		return $data;
		//return substr($data,0,-2);
}

//echo comment_months(110,4,2016,99);


function get_Paid_months($id){

	    include("../../incluidos/db_config/config.php");

	    $sql = "SELECT * FROM detallepresupuestocobro WHERE detalleprecobro_id='$id'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);	

		$data = strtotime($row['detalleprecobro_fechavencimiento']);

		

return $data;

}





//echo get_Paid_months('2624');





function cellColor($cells,$color){

	



    global $objPHPExcel;



    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(

        'type' => PHPExcel_Style_Fill::FILL_SOLID,

        'startcolor' => array(

             'rgb' => $color

        )

    ));

}



function cellBorder($cells,$style){

    global $objPHPExcel;	

	

	if($style=='all'){

    $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray(

    array('borders' => array(

        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),

        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),

        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),

        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)

    )

)

);



	}

	

	

		if($style=='bottom'){

			

$objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray(

    array('borders' => array(

        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)    )

)

);







}

		

		

}







function get_Monthly_Payment($id,$year){

	include("../../incluidos/db_config/config.php");

		$sql = "SELECT * FROM presupuestocobro WHERE miembro_mie_id='$id' AND precobro_year='$year'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		

		$data= $row['precobro_valor'];       



        return $data;



}









function get_total_dues($id){

	include("../../incluidos/db_config/config.php");

		$sql = "SELECT * FROM presupuestocobro WHERE miembro_mie_id='$id'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		

		$pre_cobro_id = $row['precobro_id'];







//Computing DUES//

$s = "SELECT sum(detalleprecobro_valor) AS DUE FROM detallepresupuestocobro WHERE estado_presupuesto_est_pre_id='1' AND presupuestocobro_precobro_id='$pre_cobro_id'";	

$r = mysqli_query($con,$s);

$p = mysqli_fetch_array($r);



$total=$p['DUE'];



if($total){

	$data = $total;

}else{

    $data = '0';	

}



return $data;



}



function get_status_info($id){

	include("../../incluidos/db_config/config.php");

		$sql = "SELECT * FROM member_status WHERE mem_sta_id='$id'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		$data=$row['mem_sta_codigo'];

		return $data;



	

}

//echo get_status_info(4);







function get_user_details($memid,$type){

include("../../incluidos/db_config/config.php");



		$sql = "SELECT * FROM miembro WHERE mie_id='$memid'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		if($type=='country'){

			$data = $row['pai_nombre'];

		}

		if($type=='member_code'){

			$data = $row['mie_codigo'];

		}

		

		return $data;

		

}



function get_country_by_user($user_id){

include("../../incluidos/db_config/config.php");

	    $sql = "SELECT * FROM usuario WHERE usu_id='$user_id'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		

		$sede_id=$row['sede_id'];

		

		$s = "SELECT * FROM sede WHERE sede_id='$sede_id'";	

		$r = mysqli_query($con,$s);

		$per = mysqli_fetch_array($r);

		

		$pais_pai_id=$per['pais_pai_id'];

		

		$e = "SELECT * FROM pais WHERE pai_id='$pais_pai_id'";	

		$es = mysqli_query($con,$e);

		$country = mysqli_fetch_array($es);

		

		return utf8_encode($country['pai_nombre']);	

}





function get_forumleader($id){

include("../../incluidos/db_config/config.php");

	    $sql = "SELECT * FROM grupos WHERE gru_id='$id'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		

		$usu_id = $row['gru_forum'];

		

		

        $s = "SELECT * FROM usuario WHERE usu_id='$usu_id'";	

		$r = mysqli_query($con,$s);

		$per = mysqli_fetch_array($r);

		

		$per_id = $per['Persona_per_id'];



		

		$e = "SELECT * FROM persona WHERE per_id='$per_id'";	

		$es = mysqli_query($con,$e);

		$p = mysqli_fetch_array($es);

		

		

		return strtoupper($p['per_nombre'].' '.$p['per_apellido']);	

}











function get_IBU($id){

include("../../incluidos/db_config/config.php");

	    $sql = "SELECT * FROM grupos WHERE gru_id_usuario='$id'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		

		$sede_id = $row['sede_id'];

		

        $s = "SELECT * FROM ciudad WHERE sede_id='$sede_id'";	

		$r = mysqli_query($con,$s);

		$p = mysqli_fetch_array($r);

		

		return strtoupper($p['nombre_IBU']);	

}



function get_admin_details($id,$field){

include("../../incluidos/db_config/config.php");

	    $sql = "SELECT * FROM usuario WHERE usu_id='$id'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		if($field=='user'){

			$data = $row['usu_user'];

		}

		if($field=='email'){

			$data = $row['usu_email'];

		}

		

		if($field=='fullname'){

			$data = get_Persona_name($row['Persona_per_id']);

		}



       return utf8_encode($data);	

}



function get_profile_name($id){

include("../../incluidos/db_config/config.php");

	    $sql = "SELECT * FROM perfil WHERE per_id='$id'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		

		return strtoupper($row['per_descripcion']);	

}



function get_Persona_name($id){

include("../../incluidos/db_config/config.php");

	    $sql = "SELECT * FROM persona WHERE per_id='$id'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);

		

		return strtoupper($row['per_nombre'].' '.$row['per_apellido']);	

}







function get_details_by_user($id){

include("../../incluidos/db_config/config.php");

	    $sql = "SELECT * FROM persona WHERE per_id='$id'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);



       return utf8_encode($row['per_nombre'].' '.$row['per_apellido']);	

}



function get_company_details_by_user($id){

include("../../incluidos/db_config/config.php");

	    $sql = "SELECT * FROM empresalocal WHERE emp_id='$id'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);



       return utf8_encode($row['emp_nombre']);	

}



function get_status_details_by_user($id){

include("../../incluidos/db_config/config.php");

	    $sql = "SELECT * FROM estadoprospecto WHERE estpro_id='$id'";	

		$res = mysqli_query($con,$sql);

		$row = mysqli_fetch_array($res);



       return utf8_encode($row['estpro_descripcion']);	

}





function calculate_status_total($xmonth,$type,$year,$userid){

include("../../incluidos/db_config/config.php");

if($xmonth==0){ $month='01'; }

if($xmonth==1){ $month='02'; }

if($xmonth==2){ $month='03'; }

if($xmonth==3){ $month='04'; }

if($xmonth==4){ $month='05'; }

if($xmonth==5){ $month='06'; }

if($xmonth==6){ $month='07'; }

if($xmonth==7){ $month='08'; }

if($xmonth==8){ $month='09'; }

if($xmonth==9){ $month='10'; }

if($xmonth==10){ $month='11'; }

if($xmonth==11){ $month='12'; }



if($type=="imi"){

$array = array("7","8");

$sql="SELECT count(*) AS total FROM prospecto WHERE estadoprospecto_estpro_id='1' AND MONTH(prosp_fechamodificacion)='$month' AND YEAR(prosp_fechamodificacion)='$year'

";

}

if($type=="en2"){

$sql="SELECT count(*) AS total FROM prospecto WHERE estadoprospecto_estpro_id='3' AND MONTH(prosp_fechamodificacion)='$month' AND YEAR(prosp_fechamodificacion)='$year'

";

}

$res = mysqli_query($con,$sql);

$row = mysqli_fetch_array($res);





return $row['total'];

	

}



//echo calculate_status_total(3,'imi',2017,1);





//Membership Reports//

function get_active_members($type,$status,$year,$month,$country){

include("../../incluidos/db_config/config.php");

//Enero: miembros con fecha ingreso <= Enero y fecha egreso null o fecha egreso > Enero //fecha de modificacion es fecha de egreso

if($month==9){ $month='01'; }

if($month==10){ $month='02'; }

if($month==11){ $month='03'; }

if($month==12){ $month='04'; }

if($month==13){ $month='05'; }

if($month==14){ $month='06'; }

if($month==15){ $month='07'; }

if($month==16){ $month='08'; }

if($month==17){ $month='09'; }

if($month==18){ $month='10'; }

if($month==19){ $month='11'; }

if($month==20){ $month='12'; }

$extra_logic="MONTH(mie_fecharegistro)<='$month' AND MONTH(mie_fecha_cambio_status)>'$month'";	

$array = array("1");

//$xmonth=strtotime('01/'.$month.'/'.$year);

$xmonth=$year.'-'.$month.'-1';

if($month=="02"){

//$fmonth=strtotime('28/'.$month.'/'.$year);

$fmonth=$year.'-'.$month.'-28';

}else if(($month==12)||($month==14)||($month==16)||($month==18)||($month==20)||($month==22)){

//$fmonth=strtotime('31/'.$month.'/'.$year);

$fmonth=$year.'-'.$month.'-31';

}else{

$fmonth=strtotime('30/'.$month.'/'.$year);

$fmonth=$year.'-'.$month.'-30';

}



if($type=='top'){

//$sql = "SELECT count(mie_id) AS active_members FROM miembro WHERE MONTH(mie_fecharegistro)='$month' AND YEAR(mie_fecharegistro)='$year' AND status_member_id='1'".$extra_logic;

//$sql="SELECT miembro.*, miembro_inscripcion.*, count(miembro.mie_id) AS active_members FROM miembro, miembro_inscripcion WHERE miembro_inscripcion.mie_ins_fecha_ingreso<='$xmonth' OR miembro_inscripcion.mie_ins_fechamodificacion>='$fmonth' AND miembro.status_member_id='1' AND miembro.status_member_id<>'2' AND YEAR(miembro_inscripcion.mie_ins_fechamodificacion)='$year' AND miembro.mie_id = miembro_inscripcion.miembro_id";

$sql="SELECT COUNT(*) AS active_members

FROM miembro_inscripcion AS t0

LEFT OUTER JOIN miembro AS t1 ON(t1.mie_id = t0.miembro_id)

JOIN grupos AS t2 ON (t2.gru_id = t1.grupo_id)

WHERE(((t1.status_member_id = '$status')

AND(t0.mie_ins_fecha_ingreso <= '$xmonth')) 

AND(t2.agrup not in ('C'))

AND((t1.status_member_id <> 2) AND (t1.categoria_cat_id<>4) OR(t1.mie_fecha_cambio_status >=$fmonth)))

";

}else{

//$sql = "SELECT count(mie_id) AS active_members FROM miembro WHERE MONTH(mie_fecharegistro)='$month' AND YEAR(mie_fecharegistro)='$year' AND status_member_id='1' AND categoria_cat_id='4'".$extra_logic;	

$sql="SELECT COUNT(*) AS active_members

FROM miembro_inscripcion AS t0

LEFT OUTER JOIN miembro AS t1 ON(t1.mie_id = t0.miembro_id)

JOIN grupos AS t2 ON (t2.gru_id = t1.grupo_id)

WHERE(((t1.status_member_id = '$status')

AND(t0.mie_ins_fecha_ingreso <= '$xmonth')) 

AND(t2.agrup not in ('C'))

AND((t1.status_member_id <> 2) OR(t1.mie_fecha_cambio_status >=$fmonth)))

AND (((t1.categoria_cat_id = 4)))

";

}





/*

SELECT COUNT(*)

FROM miembro_inscripcion AS t0

LEFT OUTER JOIN miembro AS t1 ON(t1.mie_id = t0.miembro_id)

WHERE(((t1.status_member_id = 1)

AND(t0.mie_ins_fecha_ingreso <= '$xmonth')) 

AND((t1.status_member_id <> 2) OR(t1.mie_fecha_cambio_status >=$fmonth)))

*/







$res = mysqli_query($con,$sql);

$act = mysqli_fetch_array($res);



if($act){

	$active_members_count=$act['active_members'];

}else{

	$active_members_count=0;

}



return $active_members_count;

	

}

//echo get_active_members('top','1','2017','04','Pe');

//echo get_active_members('executive','1','2017','04','Pe');



function get_sp_members($type,$year,$month,$country){

include("../../incluidos/db_config/config.php");

if($month==9){ $month='01'; }

if($month==10){ $month='02'; }

if($month==11){ $month='03'; }

if($month==12){ $month='04'; }

if($month==13){ $month='05'; }

if($month==14){ $month='06'; }

if($month==15){ $month='07'; }

if($month==16){ $month='08'; }

if($month==17){ $month='09'; }

if($month==18){ $month='10'; }

if($month==19){ $month='11'; }

if($month==20){ $month='12'; }



if($type=='top'){

$sql2 = "SELECT count(mie_id) AS sp_members FROM miembro WHERE MONTH(mie_fecharegistro)='$month' AND YEAR(mie_fecharegistro)='$year' AND status_member_id='4'";	

}else{

$sql2 = "SELECT count(mie_id) AS sp_members FROM miembro WHERE MONTH(mie_fecharegistro)='$month' AND YEAR(mie_fecharegistro)='$year' AND status_member_id='4' AND categoria_cat_id='4'";	

}



$res2 = mysqli_query($con,$sql2);

$sp = mysqli_fetch_array($res2);



if($sp){

	$sp_members_count=$sp['sp_members'];

}else{

	$sp_members_count=0;

}



return $sp_members_count;





}



function get_ms_members($type,$year,$month,$country){

include("../../incluidos/db_config/config.php");

if($month==9){ $month='01'; }

if($month==10){ $month='02'; }

if($month==11){ $month='03'; }

if($month==12){ $month='04'; }

if($month==13){ $month='05'; }

if($month==14){ $month='06'; }

if($month==15){ $month='07'; }

if($month==16){ $month='08'; }

if($month==17){ $month='09'; }

if($month==18){ $month='10'; }

if($month==19){ $month='11'; }

if($month==20){ $month='12'; }



if($type=='top'){

$sql3 = "SELECT count(mie_id) AS ms_members FROM miembro WHERE MONTH(mie_fecharegistro)='$month' AND YEAR(mie_fecharegistro)='$year' AND status_member_id='3'";	

}else{

$sql3 = "SELECT count(mie_id) AS ms_members FROM miembro WHERE MONTH(mie_fecharegistro)='$month' AND YEAR(mie_fecharegistro)='$year' AND status_member_id='3' AND categoria_cat_id='4'";	

}	

$res3 = mysqli_query($con,$sql3);

$sc = mysqli_fetch_array($res3);



if($sc){

	$sc_members_count=$sc['ms_members'];

}else{

	$sc_members_count=0;

}



return $sc_members_count;



}







function get_member_by_status_changed($type,$category,$year,$month,$country){

include("../../incluidos/db_config/config.php");

if($month==9){ $month='01'; }

if($month==10){ $month='02'; }

if($month==11){ $month='03'; }

if($month==12){ $month='04'; }

if($month==13){ $month='05'; }

if($month==14){ $month='06'; }

if($month==15){ $month='07'; }

if($month==16){ $month='08'; }

if($month==17){ $month='09'; }

if($month==18){ $month='10'; }

if($month==19){ $month='11'; }

if($month==20){ $month='12'; }

$xmonth=$year.'-'.$month.'-1';

if($month=="02"){

//$fmonth=strtotime('28/'.$month.'/'.$year);

$fmonth=$year.'-'.$month.'-28';

}else if(($month==12)||($month==14)||($month==16)||($month==18)||($month==20)||($month==22)){

//$fmonth=strtotime('31/'.$month.'/'.$year);

$fmonth=$year.'-'.$month.'-31';

}else{

$fmonth=strtotime('30/'.$month.'/'.$year);

$fmonth=$year.'-'.$month.'-30';

}



if(($category=='key')&&($type=='cancels')){

$sql = "SELECT count(mie_id) AS sp_members FROM miembro WHERE mie_fecha_cambio_status >= '$xmonth' AND mie_fecha_cambio_status <='$fmonth' AND status_member_id='2' AND categoria_cat_id='4' AND YEAR(mie_fecha_cambio_status)='$year'";	

}



if(($category=='key')&&($type=='adds')){

$sql = "SELECT count(mie_id) AS sp_members FROM miembro WHERE mie_fecha_cambio_status >= '$xmonth' AND mie_fecha_cambio_status <='$fmonth' AND status_member_id='1' AND categoria_cat_id='4' AND YEAR(mie_fecha_cambio_status)='$year'";	

}



	



	

if(($category=='top')&&($type=='cancels')){

$sql = "SELECT count(mie_id) AS sp_members FROM miembro WHERE mie_fecha_cambio_status >= '$xmonth' AND mie_fecha_cambio_status <='$fmonth' AND status_member_id='2' AND categoria_cat_id<>'4' AND YEAR(mie_fecha_cambio_status)='$year'";	

}

if(($category=='top')&&($type=='adds')){

$sql = "SELECT count(mie_id) AS sp_members FROM miembro WHERE mie_fecha_cambio_status >= '$xmonth' AND mie_fecha_cambio_status <='$fmonth' AND status_member_id='1' AND categoria_cat_id<>'4' AND YEAR(mie_fecha_cambio_status)='$year'";	

}



$res2 = mysqli_query($con,$sql);

$sp = mysqli_fetch_array($res2);



	

	$data = $sp_members_count=$sp['sp_members'];

	if(!$data){

		$data = '0';

	}





return $data;





}



//echo get_member_by_status_changed('adds','2017','04',$country);



function comment_members($type,$status,$cell,$year,$month,$country){

include("../../incluidos/db_config/config.php");

if($month==9){ $month='01'; }

if($month==10){ $month='02'; }

if($month==11){ $month='03'; }

if($month==12){ $month='04'; }

if($month==13){ $month='05'; }

if($month==14){ $month='06'; }

if($month==15){ $month='07'; }

if($month==16){ $month='08'; }

if($month==17){ $month='09'; }

if($month==18){ $month='10'; }

if($month==19){ $month='11'; }

if($month==20){ $month='12'; }







$array = array("1");

//$xmonth=strtotime('01/'.$month.'/'.$year);

$xmonth=$year.'-'.$month.'-1';

if($month=="02"){

//$fmonth=strtotime('28/'.$month.'/'.$year);

$fmonth=$year.'-'.$month.'-28';

}else if(($month==12)||($month==14)||($month==16)||($month==18)||($month==20)||($month==22)){

//$fmonth=strtotime('31/'.$month.'/'.$year);

$fmonth=$year.'-'.$month.'-31';

}else{

$fmonth=strtotime('30/'.$month.'/'.$year);

$fmonth=$year.'-'.$month.'-30';

}





if($type=='top'){

//$sql = "SELECT count(mie_id) AS active_members FROM miembro WHERE MONTH(mie_fecharegistro)='$month' AND YEAR(mie_fecharegistro)='$year' AND status_member_id='1'".$extra_logic;

//$sql="SELECT miembro.*, miembro_inscripcion.*, count(miembro.mie_id) AS active_members FROM miembro, miembro_inscripcion WHERE miembro_inscripcion.mie_ins_fecha_ingreso<='$xmonth' OR miembro_inscripcion.mie_ins_fechamodificacion>='$fmonth' AND miembro.status_member_id='1' AND miembro.status_member_id<>'2' AND YEAR(miembro_inscripcion.mie_ins_fechamodificacion)='$year' AND miembro.mie_id = miembro_inscripcion.miembro_id";

$sql="SELECT *

FROM miembro_inscripcion AS t0

LEFT OUTER JOIN miembro AS t1 ON(t1.mie_id = t0.miembro_id)

WHERE(((t1.status_member_id = '$status')

AND(t0.mie_ins_fecha_ingreso <= '$xmonth')) 

AND((t1.status_member_id <> 2) OR(t1.mie_fecha_cambio_status >=$fmonth)))

";

}else{

//$sql = "SELECT count(mie_id) AS active_members FROM miembro WHERE MONTH(mie_fecharegistro)='$month' AND YEAR(mie_fecharegistro)='$year' AND status_member_id='1' AND categoria_cat_id='4'".$extra_logic;	

$sql="SELECT *

FROM miembro_inscripcion AS t0

LEFT OUTER JOIN miembro AS t1 ON(t1.mie_id = t0.miembro_id)

WHERE(((t1.status_member_id = '$status')

AND(t0.mie_ins_fecha_ingreso <= '$xmonth')) 

AND((t1.status_member_id <> 2) OR(t1.mie_fecha_cambio_status >=$fmonth)))

AND (((t1.categoria_cat_id = 4)))

";

}







//Cancels and Adds//

if(($type=='cancels')&&($cell=='N')){



//$sql = "SELECT * FROM miembro WHERE mie_fecha_cambio_status >= '$xmonth' AND mie_fecha_cambio_status <='$fmonth' AND status_member_id='2'";	

	$sql = "SELECT * FROM miembro WHERE mie_fecha_cambio_status BETWEEN '$xmonth' AND '$fmonth' AND status_member_id='2' AND categoria_cat_id<>'4' AND YEAR(mie_fecha_cambio_status)='$year'";



}



if(($type=='adds')&&($cell=='P')){

//	$sql = "SELECT * FROM miembro WHERE mie_fecha_cambio_status >= '$xmonth' AND mie_fecha_cambio_status <='$fmonth' AND status_member_id='1'";

	$sql = "SELECT * FROM miembro WHERE mie_fecha_cambio_status BETWEEN '$xmonth' AND '$fmonth' AND status_member_id='1' AND categoria_cat_id<>'4' AND YEAR(mie_fecha_cambio_status)='$year'";



}





if(($type=='cancels')&&($cell=='O')){



//$sql = "SELECT * FROM miembro WHERE mie_fecha_cambio_status >= '$xmonth' AND mie_fecha_cambio_status <='$fmonth' AND status_member_id='2'";	

	$sql = "SELECT * FROM miembro WHERE mie_fecha_cambio_status BETWEEN '$xmonth' AND '$fmonth' AND status_member_id='2' AND categoria_cat_id='4' AND YEAR(mie_fecha_cambio_status)='$year'";



}



if(($type=='adds')&&($cell=='Q')){

//	$sql = "SELECT * FROM miembro WHERE mie_fecha_cambio_status >= '$xmonth' AND mie_fecha_cambio_status <='$fmonth' AND status_member_id='1'";

	$sql = "SELECT * FROM miembro WHERE mie_fecha_cambio_status BETWEEN '$xmonth' AND '$fmonth' AND status_member_id='1' AND categoria_cat_id='4' AND YEAR(mie_fecha_cambio_status)='$year'";



}





$res = mysqli_query($con,$sql);

//$row = mysqli_fetch_array($res);

$members='';

$i=1;

while($row = mysqli_fetch_array($res)) {

	

$members.=' '.get_details_by_user($row['Persona_per_id']).', ';



}//end loop





return substr($members,0,-2);

	

}



//echo comment_active_members('top','2017','9','EC');



$report_country = strtoupper(substr('ecuador',0,2));







?>