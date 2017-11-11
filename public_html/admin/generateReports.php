<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
	ini_set('memory_limit', '3500M'); 
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes
require_once dirname(__FILE__) ."/db_config/config.php";
require_once dirname(__FILE__) ."/custom.php";
require_once dirname(__FILE__) ."/sendEmail.php";
/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';
//Running Report #1 (Enrollment Fees)//
//Getting Mandatory Variables: User ID + Year + Sede ID//
$userid=$_GET['userid'];
//$year=$_GET['year'];
$sede_id=$_GET['sede_id'];
$email=$_GET['email'];
$corte= $_GET['corte'];



$year = getYearByCorte($corte);

function getYearByCorte($corte) {
    $fecha = date_create($corte);
    $anhoactual = date('Y');
    $mesdia = date_format($fecha,'md');
    if (intval($mesdia) <= 430) {
        return intval($anhoactual)-1;
    }
    return $anhoactual;
}


//Running Report//

generate_enrollment_fees($userid,$year,$sede_id,$email, $corte); //This function will run The 1st report//	
//generate_Dues($userid,$year,$sede_id,$email); //This function will run The 1st report//	

function generate_enrollment_fees($userid,$year,$sedeid,$email, $corte){
		include("../../incluidos/db_config/config.php");

//$group = $_REQUEST['group'];
$_SESSION['admin_email'] = $email;
$nextyear = $year+1;
$country = get_country_by_user($userid);	

$report_name="EnrollmentFees-".$userid.'.xlsx';
$report_name_for_excel=get_IBU($userid);

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
$objPHPExcel = PHPExcel_IOFactory::load("./excels_templates/enrollment_fees.xlsx");
$objPHPExcel->setActiveSheetIndex(0);
//$objPHPExcel->getActiveSheet()->setCellValue('N3', "1/1/".$year);
$objPHPExcel->getActiveSheet()->setCellValue('N3', set_report_date($corte));
$objPHPExcel->getActiveSheet()->setCellValue('D3', $report_name_for_excel);
$objPHPExcel->getActiveSheet()->setCellValue('A72', $nextyear);
//Consulting DataBase
for ($i = 1; $i <= 12; $i++) {
$sql = "SELECT * FROM miembro_inscripcion, miembro, grupos  
WHERE MONTH(miembro_inscripcion.mie_ins_fecha_cobro)='$i' 
AND YEAR(miembro_inscripcion.mie_ins_fecha_cobro)='$year' 
and date(miembro_inscripcion.mie_ins_fecha_cobro) <= '$corte'
and miembro_inscripcion.miembro_id = miembro.mie_id 
and grupos.gru_id = miembro.grupo_id 
and grupos.sede_id = '$sedeid' 
"; // AND YEAR(mie_ins_fecha_ingreso)='$year'	
$res = mysqli_query($con,$sql);
//$row = mysqli_fetch_array($res);
//$response["result"] = array();
$cor1 = 0;
$cor2 = 0;
$cor3 = 0;
$cor4 = 0;
$cor5 = 0;
$cor6 = 0;
if(($i=='01')||($i=='02')||($i=='03')||($i=='04')){
$n=10;
$limit=8;
}
if(($i=='05')||($i=='06')||($i=='07')||($i=='08')){
$n=31;
$limit=8;
}
if(($i=='09')||($i=='10')||($i=='11')||($i=='12')){
$n=52;
$limit=8;
}

if(mysqli_num_rows($res)){
	
}else{
	
}

while($row = mysqli_fetch_array($res)) {
$sql_date = strtotime($row['mie_ins_fecha_cobro']);
$fecha_cobro = "-";
if ($row['estado_cobro_id'] == 2) {
    $fecha_cobro = convert_datetime($row['mie_ins_fecha_cobro'],'');
}
//Getting custom values from timestamp in executiveforums db//
$this_month =  date('m', $sql_date);
//End Getting time and date//
if((($this_month=='01')||($this_month=='05')||($this_month=='09'))) {
 if ($row['mie_ins_valor']!="0" && $fecha_cobro != "-"){
    $val1 = $n + $cor1;
 $objPHPExcel->getActiveSheet()->setCellValue('A'.$val1, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('B'.$val1, $fecha_cobro);
 $objPHPExcel->getActiveSheet()->setCellValue('C'.$val1, $row['mie_ins_valor']);
	} else {
        $cor1--;
    }
}

if((($this_month=='02')||($this_month=='06')||($this_month=='10'))) {
 if ($row['mie_ins_valor']!="0" && $fecha_cobro != "-"){
    $val2 = $n + $cor2;
 $objPHPExcel->getActiveSheet()->setCellValue('E'.$val2, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('F'.$val2, $fecha_cobro);
 $objPHPExcel->getActiveSheet()->setCellValue('G'.$val2, $row['mie_ins_valor']);
	} else {
        $cor2--;
    }
}
if((($this_month=='03')||($this_month=='07')||($this_month=='11'))) {
    if ($row['mie_ins_valor']!="0" && $fecha_cobro != "-"){
    $val3 = $n + $cor3;
 $objPHPExcel->getActiveSheet()->setCellValue('I'.$val3 , get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('J'.$val3, $fecha_cobro);
 $objPHPExcel->getActiveSheet()->setCellValue('K'.$val3, $row['mie_ins_valor']);
	} else {
        $cor3--;
    }
}
if(($this_month=='04')) {
 if ($row['mie_ins_valor']!="0" && $fecha_cobro != "-"){
    $val4 = $n + $cor4;
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$val4, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$val4, $fecha_cobro);
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$val4, $row['mie_ins_valor']);
	} else if ($this_month=='04') {
        $cor4--;
    }
}
if(($this_month=='08')) { 
    if ($row['mie_ins_valor']!="0" && $fecha_cobro != "-"){
    $val5 = $n + $cor5;
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$val5, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$val5, $fecha_cobro);
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$val5, $row['mie_ins_valor']);
	} else {
        $cor5--;
    }
}
if(($this_month=='12')) { 
    if ($row['mie_ins_valor']!="0" && $fecha_cobro != "-"){
    $val6 = $n - $cor6;
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$val6, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$val6, $fecha_cobro);
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$val6, $row['mie_ins_valor']);
	} else if ($this_month=='12') {
        $cor6--;
    }
}

$n++;
}//end loop

}//end for


//Computing Next Year//

for ($i = 1; $i <= 4; $i++) {
$sql = "SELECT * FROM miembro_inscripcion WHERE MONTH(mie_ins_fecha_cobro)='$i' AND YEAR(mie_ins_fecha_cobro)='$nextyear' AND DATE(mie_ins_fecha_cobro) <= '$corte'";	
$res = mysqli_query($con,$sql);
//$row = mysqli_fetch_array($res);
//$response["result"] = array();
$cor1 = 0;
$cor2 = 0;
$cor3 = 0; 
$cor4 = 0;
if(($i=='01')||($i=='02')||($i=='03')||($i=='04')){
$n=77;
$limit=8;
}/*
if(($i=='05')||($i=='06')||($i=='07')||($i=='08')){
$n=98;
$limit=8;
}
if(($i=='09')||($i=='10')||($i=='11')||($i=='12')){
$n=119;
$limit=8;
}*/

if(mysqli_num_rows($res)){
	
}else{
	
}

while($row = mysqli_fetch_array($res)) {
$sql_date = strtotime($row['mie_ins_fecha_cobro']);
$fecha_cobro = "-";
if ($row['estado_cobro_id'] == 2) {
    $fecha_cobro = convert_datetime($row['mie_ins_fecha_cobro'],'');
}

//Getting custom values from timestamp in executiveforums db//
$this_month =  date('m', $sql_date);
//End Getting time and date//
if(($this_month=='01')) { 
    if ($row['mie_ins_valor']!="0" && $fecha_cobro != "-"){
    $val1 = $n + $cor1;
 $objPHPExcel->getActiveSheet()->setCellValue('A'.$val1, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('B'.$val1, $fecha_cobro);
 $objPHPExcel->getActiveSheet()->setCellValue('C'.$val1, $row['mie_ins_valor']);
	} else {
        $cor1--;
    }
}
if(($this_month=='02')) { 
    if ($row['mie_ins_valor']!="0" && $fecha_cobro != "-"){
    $val2 = $n + $cor2;
 $objPHPExcel->getActiveSheet()->setCellValue('E'.$val2, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('F'.$val2, $fecha_cobro);
 $objPHPExcel->getActiveSheet()->setCellValue('G'.$val2, $row['mie_ins_valor']);
	} else {
        $cor2--;
    }
}
if(($this_month=='03')) { 
    if ($row['mie_ins_valor']!="0" && $fecha_cobro != "-"){
    $val3 = $n + $cor3;
 $objPHPExcel->getActiveSheet()->setCellValue('I'.$val3, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('J'.$val3, $fecha_cobro);
 $objPHPExcel->getActiveSheet()->setCellValue('K'.$val3, $row['mie_ins_valor']);
	} else {
        $cor3--;
    }
}
if(($this_month=='04')) { 
    if ($row['mie_ins_valor']!="0" && $fecha_cobro != "-"){
    $val4 = $n + $cor4;
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$val4, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$val4, $fecha_cobro);
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$val4, $row['mie_ins_valor']);
	} else {
        $cor4--;
    }
}
    /*
if($this_month=='08'){
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, convert_datetime($row['mie_ins_fecha_cobro'],''));
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$n, $row['mie_ins_valor']);
	}
if($this_month=='12'){
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, convert_datetime($row['mie_ins_fecha_cobro'],''));
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$n, $row['mie_ins_valor']);
	}*/

$n++;
}//end loop

}//end for
//End Next Year//



$CM=date('m');
$CY=date('Y');
//Removing and Computing Next Year
//$del = 135 - ($CM * 4); //may jun jul sep
//$del = 135 - ($CM * 4); //
/*if($CY==$year){

for($i = 72; $i <= 135; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}

if(($CM==01)||($CM==02)||($CM==03)||($CM==04)||($CM==05)){
		for($i = 27; $i <=69 ; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}
	}
	
	if(($CM==06)||($CM==07)||($CM==08)||($CM==09)){
	for($i = 48; $i <=69 ; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}
	}

}else{*/

//if($year < date('Y')){
	//do nothing
	if(($CM==01)||($CM==02)||($CM==03)||($CM==04)||($CM==05)){
		for($i = 94; $i <=135 ; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}
	}
	
	if(($CM==06)||($CM==07)||($CM==08)||($CM==09)){
	for($i = 115; $i <=135 ; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}
	}
//}

//}//end if

mysqli_close($con);

$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPlease treat this document as confidential!');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(70);
$objPHPExcel->getActiveSheet()->setTitle('EnrollmentFees');
$objPHPExcel->setActiveSheetIndex(0);
$callStartTime = microtime(true);
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('./reportesgenerados/'.$report_name, __FILE__);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

generate_Memberships($userid,$year,$sedeid, $corte); //Generating 2nd Report//
}//END REPORT


function generate_Memberships($userid,$year,$sedeid, $corte){
	include("../../incluidos/db_config/config.php");

$nextyear=$year+1;
$country = get_country_by_user($userid);	
$report_country = strtoupper(substr($country,0,2));
$report_name="Memberships-".$userid.'.xlsx';
$report_name_for_excel=get_IBU($userid);
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
$objPHPExcel = PHPExcel_IOFactory::load("./excels_templates/membership.xlsx");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', $report_name_for_excel);
$objPHPExcel->getActiveSheet()->setCellValue('B4', $year);
$objPHPExcel->getActiveSheet()->setCellValue('N4', $year.' - '.date('d/m/Y'));
$objPHPExcel->getActiveSheet()->setCellValue('A21', $nextyear);
//Consulting DataBase
//Getting MEmber status count
//Status codes 1=acive 4=Sp 3=Scholar
for ($i = 9; $i <= 20; $i++) {
$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, get_active_members('top',1,$year,$i,$sedeid, $corte));
$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, get_active_members('top',4,$year,$i,$sedeid, $corte));
$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, get_active_members('top',3,$year,$i,$sedeid, $corte));

$B=get_active_members('top',1,$year,$i,$sedeid, $corte);
$C=get_active_members('top',4,$year,$i,$sedeid, $corte);
$D=get_active_members('top',3,$year,$i,$sedeid, $corte);
if($B>0){
$objPHPExcel->getActiveSheet()->getComment('B'.$i)->setHeight("auto")->setWidth("200px")->getText()->createTextRun(comment_members('top',1,'B',$year,$i,$sedeid, $corte)); 
}
if($C>0){
$objPHPExcel->getActiveSheet()->getComment('C'.$i)->setHeight("auto")->setWidth("200px")->getText()->createTextRun(comment_members('top',4,'C',$year,$i,$sedeid, $corte)); 
}
if($D>0){
$objPHPExcel->getActiveSheet()->getComment('D'.$i)->setHeight("auto")->setWidth("200px")->getText()->createTextRun(comment_members('top',3,'D',$year,$i,$sedeid, $corte)); 
}

}//end for


for ($i = 9; $i <= 20; $i++) {
$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, get_active_members('executive',1,$year,$i,$sedeid, $corte));
$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, get_active_members('executive',4,$year,$i,$sedeid, $corte));
$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, get_active_members('executive',3,$year,$i,$sedeid, $corte));

$G=get_active_members('executive',1,$year,$i,$sedeid, $corte);
$H=get_active_members('executive',4,$year,$i,$sedeid, $corte);
$I=get_active_members('executive',3,$year,$i,$sedeid, $corte);

if($G>0){
$objPHPExcel->getActiveSheet()->getComment('G'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('executive',1,'G',$year,$i,$sedeid, $corte)); 
}
if($H>0){
$objPHPExcel->getActiveSheet()->getComment('H'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('executive',4,'H',$year,$i,$sedeid, $corte)); 
}
if($I>0){
$objPHPExcel->getActiveSheet()->getComment('I'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('executive',3,'I',$year,$i,$sedeid, $corte)); 
}


}//end for


for ($i = 9; $i <= 20; $i++) {
	//cell N for Cancels
	//cell P for adds

$N=get_member_by_status_changed('cancels','top',$year,$i,$sedeid, $corte); //Top Cancels
$P=get_member_by_status_changed('adds','top',$year,$i,$sedeid, $corte);    //Top Adds
$O=get_member_by_status_changed('cancels','key',$year,$i,$sedeid, $corte); //Key Cancels
$Q=get_member_by_status_changed('adds','key',$year,$i,$sedeid, $corte);    //Key Adds

$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $N);
$objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $P);
$objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $O);
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $Q);


if($N>0){
$objPHPExcel->getActiveSheet()->getComment('N'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('cancels',0,'N',$year,$i,$sedeid, $corte)); 
}
if($P>0){
$objPHPExcel->getActiveSheet()->getComment('P'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('adds',0,'P',$year,$i,$sedeid, $corte)); 
}

if($O>0){
$objPHPExcel->getActiveSheet()->getComment('O'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('cancels',0,'O',$year,$i,$sedeid, $corte)); 
}
if($Q>0){
$objPHPExcel->getActiveSheet()->getComment('Q'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('adds',0,'Q',$year,$i,$sedeid, $corte)); 
}



}//end for


//Computing Next nextyear//
for ($i = 22; $i <= 25; $i++) {
$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, get_active_members('top',1,$nextyear,$i,$sedeid, $corte));
$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, get_active_members('top',4,$nextyear,$i,$sedeid, $corte));
$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, get_active_members('top',3,$nextyear,$i,$sedeid, $corte));

$B=get_active_members('top',1,$nextyear,$i,$sedeid, $corte);
$C=get_active_members('top',4,$nextyear,$i,$sedeid, $corte);
$D=get_active_members('top',3,$nextyear,$i,$sedeid, $corte);
if($B>0){
$objPHPExcel->getActiveSheet()->getComment('B'.$i)->setHeight("auto")->setWidth("200px")->getText()->createTextRun(comment_members('top',1,'B',$nextyear,$i,$sedeid, $corte)); 
}
if($C>0){
$objPHPExcel->getActiveSheet()->getComment('C'.$i)->setHeight("auto")->setWidth("200px")->getText()->createTextRun(comment_members('top',4,'C',$nextyear,$i,$sedeid, $corte)); 
}
if($D>0){
$objPHPExcel->getActiveSheet()->getComment('D'.$i)->setHeight("auto")->setWidth("200px")->getText()->createTextRun(comment_members('top',3,'D',$nextyear,$i,$sedeid, $corte)); 
}



}//end for


for ($i = 22; $i <= 25; $i++) {
$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, get_active_members('executive',1,$nextyear,$i,$sedeid, $corte));
$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, get_active_members('executive',4,$nextyear,$i,$sedeid, $corte));
$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, get_active_members('executive',3,$nextyear,$i,$sedeid, $corte));

$G=get_active_members('executive',1,$nextyear,$i,$sedeid, $corte);
$H=get_active_members('executive',4,$nextyear,$i,$sedeid, $corte);
$I=get_active_members('executive',3,$nextyear,$i,$sedeid, $corte);

if($G>0){
$objPHPExcel->getActiveSheet()->getComment('G'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('executive',1,'G',$nextyear,$i,$sedeid, $corte)); 
}
if($H>0){
$objPHPExcel->getActiveSheet()->getComment('H'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('executive',4,'H',$nextyear,$i,$sedeid, $corte)); 
}
if($I>0){
$objPHPExcel->getActiveSheet()->getComment('I'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('executive',3,'I',$nextyear,$i,$sedeid, $corte)); 
}


}//end for


for ($i = 22; $i <= 25; $i++) {
	//cell N for Cancels
	//cell P for adds

$N=get_member_by_status_changed('cancels','top',$nextyear,$i,$report_country, $corte); //Top Cancels
$P=get_member_by_status_changed('adds','top',$nextyear,$i,$report_country, $corte);    //Top Adds
$O=get_member_by_status_changed('cancels','key',$nextyear,$i,$report_country, $corte); //Key Cancels
$Q=get_member_by_status_changed('adds','key',$nextyear,$i,$report_country, $corte);    //Key Adds

$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $N);
$objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $P);
$objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $O);
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $Q);


if($N>0){
$objPHPExcel->getActiveSheet()->getComment('N'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('cancels',0,'N',$nextyear,$i,$sedeid, $corte)); 
}
if($P>0){
$objPHPExcel->getActiveSheet()->getComment('P'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('adds',0,'P',$nextyear,$i,$sedeid, $corte)); 
}

if($O>0){
$objPHPExcel->getActiveSheet()->getComment('O'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('cancels',0,'O',$nextyear,$i,$sedeid, $corte)); 
}
if($Q>0){
$objPHPExcel->getActiveSheet()->getComment('Q'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('adds',0,'Q',$nextyear,$i,$sedeid, $corte)); 
}



}//end for

//End Next nextyear//


$CM=date('m');
$CY=date('Y');
//Removing and Computing Next Year
//$del = 32 - $CM;
$del = 26;
if($CY==$year){

for($i = $del; $i <= 33; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}



}else{


if($year < '2016'){
	//do nothing
}else{
for($i = $del; $i <=33 ; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}
}



}


mysqli_close($con);

$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPlease treat this document as confidential!');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->setTitle('Memberships');
$objPHPExcel->setActiveSheetIndex(0);
$callStartTime = microtime(true);
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('./reportesgenerados/'.$report_name, __FILE__);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
generate_Dues($userid,$year,$sedeid, $corte);

}





// Dues //

function generate_Dues($userid,$year,$sedeid, $corte){
	include('../../incluidos/db_config/config.php');
//	include('./PHPExcel/Classes/PHPExcel.php');
//POR ALGUNA RAZON NO LAS ESTA INCLUYENDO LAS LIBRERIAS EL SCRIPT Y POR ESO EN ALGUNAS FUNCIONES LA VUELVO A LLAMAR PARA QUE FUNCIONE//
//FOR SOME REASON LIBRARIES ARE NOT INCLUDED IN THE SCRIPT AND WE'LL NEED TO RECALL ONCE AGAIN, IN ORDER TO MAKE THE SCRIPT WORKS//
//	include('custom.php');

$valorcorte = intval(date_format(date_create($corte),'Ym'));
$nextyear=$year + 1;
$country = get_country_by_user($userid);	
$report_country = strtoupper(substr($country,0,2));
$report_name="Dues-".$userid.'.xlsx';

$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_sqlite;
PHPExcel_Settings::setCacheStorageMethod($cacheMethod); 

$objPHPExcel = new PHPExcel();
$xSheet=0; //First Index for each sheet
$CM=date('m'); //Current Month
$CY=date('Y'); //Current Year
$objPHPExcel = PHPExcel_IOFactory::load("./excels_templates/dues_template_2.xlsx");
$objPHPExcel->setActiveSheetIndex($xSheet);
//First sheet
$objPHPExcel->getActiveSheet();
$s="SELECT * FROM grupos WHERE sede_id='$sedeid' order by gru_descripcion asc";
$r = mysqli_query($con,$s);
$curagrup = "";
$totalagrup = array();
while($xrow = mysqli_fetch_array($r)) {
    $curagrup = $xrow['agrup'];
    $totalagrup[$curagrup]['sheet'] = $xSheet; //guardo el ultimo index de cada grupo.    
$objPHPExcel->setActiveSheetIndex($xSheet);
$objPHPExcel->getActiveSheet()->setCellValue('D3', $xrow['gru_descripcion']);
$objPHPExcel->getActiveSheet()->setCellValue('D4', get_admin_details($xrow['gru_forum'],'fullname'));
//$objPHPExcel->getActiveSheet()->setCellValue('S3', '1/1/'.$year);
$objPHPExcel->getActiveSheet()->setCellValue('S3', set_report_date($corte));
$objPHPExcel->getActiveSheet()->setCellValue('U6', $year+1);
$xgroup=substr($xrow['gru_descripcion'], -7, 0);
$sheetTitle = $xrow['gru_descripcion'];
$array = array("1","2","3","4");
$sql="SELECT miembro.*, miembro_inscripcion.* FROM miembro, miembro_inscripcion 
WHERE miembro.grupo_id=".$xrow['gru_id']." 
AND miembro.status_member_id IN (".implode(',', $array).") 
AND miembro.mie_id = miembro_inscripcion.miembro_id  
AND (miembro.mie_id not in (select t0.mie_id from miembro t0 
    where t0.cancelled = 1 
    and year(t0.mie_fecha_cambio_status)<'$year'
    and t0.mie_id not in 
        (select t1.miembro_mie_id 
            from presupuestocobro t1, detallepresupuestocobro t2
            where t1.precobro_id = t2.presupuestocobro_precobro_id
            and year(detalleprecobro_fechavencimiento) < '$year' 
            and t2.estado_presupuesto_est_pre_id <> 2 )
        )    
    )
AND miembro_inscripcion.mie_ins_fecha_ingreso <= '$corte'  
ORDER By miembro.mie_codigo ASC";

// AND miembro_inscripcion.mie_ins_year='$year'
$res = mysqli_query($con,$sql);
$rcount = mysqli_num_rows($res);
$i=8;
$CM=date('m'); //Current Month
$CY=date('Y'); //Current Year
/****** BODY ******/
$dues = true; 
$miembroActual = "";
while($row = mysqli_fetch_array($res)) {
    if ($row['mie_id'] != $miembroActual) {
        $miembroActual = $row['mie_id'];
    
	
//cellColor('H'.$i.':'.'S'.$i, 'CCCCCC');
//cellColor('U'.$i.':'.'Z'.$i, 'CCCCCC');
//cellColor('AA'.$i.':'.'AF'.$i, 'CCCCCC');		
$codigo_usuario = $row['mie_codigo'];
 
list($c1, $c2, $c3, $c4) = split('[/.-]', $codigo_usuario);
$cod1 = $c1;  $cod2 =$c2;  $cod3 =$c3;  $cod4 =$c4;

$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $cod3);
$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $cod4);
$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('C'.$i)->setWidth("25");
//$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, get_details_by_user($row['Persona_per_id']));
$lasfechas = old_dues_comment($row['mie_id'], $year);
if (count($lasfechas) > 0) {
    $objPHPExcel->getActiveSheet()->getComment('C'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun("Deuda mes: " . implode(', ', $lasfechas)); 
}

$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, getInscription_info($row['mie_id'],'cob'));
$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, getInscription_info($row['mie_id'],'ins'));
$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setWrapText(true);
//Computing Dues//
if (strlen(trim(get_Monthly_Payment($row['mie_id'],$year))) > 0) {
    $dues = true;
} else {
    $dues = false;
}
if (strlen(trim(get_Monthly_Payment($row['mie_id'],$nextyear))) > 0) {
    $duesnextyear = true;
} else {
    $duesnextyear = false;
}

if ($row['cancelled'] == 1 && strlen($row['mie_fecha_cambio_status']) > 0 
&& intval(date_format(date_create($corte),'Ymd')) > intval(date_format(date_create($row['mie_fecha_cambio_status']),'Ymd'))  ) {
    $this_status_member="MC";
} else {
    $this_status_member=get_status_info($row['status_member_id']);
}
if (in_array($this_status_member, array("MS","MC"))) {
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, "");
    $objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setWrapText(true);
} else {
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, get_Monthly_Payment($row['mie_id'], date_format(date_create($corte),'Y')));
    $objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setWrapText(true);
}

$objPHPExcel->getActiveSheet()->getColumnDimension('G'.$i)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('G'.$i)->setWidth("15");
$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $this_status_member);

//$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setWrapText(true);

if($this_status_member=='SC'){
$color='ffffff';
$g_color='ffff00';
}else if($this_status_member=='MS'){
$color='92D050';
$g_color='92D050';   
}else if(trim($this_status_member)=='M'){
$color='ffffff';
$g_color='ffff00';
}else if($this_status_member=='MC'){
    if (strlen($row['mie_fecha_cambio_status']) > 0) {
        $color='CCCCCC';
        $g_color='CCCCCC';
    } else {
        $color='FFFFFF';
        $g_color='CCCCCC';
    }
}else{
$color='CCCCCC';
$g_color='CCCCCC';
}

$color_ny = $color;
$g_color_ny= $g_color;
if (! $dues && $this_status_member != "MS") {
    $color='CCCCCC';
   // $g_color='CCCCCC';
    if (! $duesnextyear) {
        $color_ny = "CCCCCC";
       // $g_color_ny = "CCCCCC";
    }
}



$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $g_color
        )
    ));

//Painting cell background//
	 $objPHPExcel->getActiveSheet()->getStyle('H'.$i.':'.'S'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
 $objPHPExcel->getActiveSheet()->getStyle('U'.$i.':'.'X'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color_ny
        )
    ));
  /*$objPHPExcel->getActiveSheet()->getStyle('U'.$i.':'.'Z'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    )); este se cambia*/
  /*
   $objPHPExcel->getActiveSheet()->getStyle('AA'.$i.':'.'AF'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
	*/


$first_FM_m=getInscription_info($row['mie_id'],'ins_month');
$first_FM_y=getInscription_info($row['mie_id'],'ins_year');


$COLOR1='CCCCCC';
$COLOR2='FFFFFF';
$COLOR3='92D050';
$letramc = "H";


//Paiting FM //
if(($first_FM_m=='01')&&($first_FM_y==$year)){$x1='H'; $x2='H'; $letramc= 'H';   $ins_color='A6A6A6'; }else
if(($first_FM_m=='02')&&($first_FM_y==$year)){$x1='H'; $x2='H'; $letramc= 'I';   $ins_color='A6A6A6'; }else
if(($first_FM_m=='03')&&($first_FM_y==$year)){$x1='H'; $x2='I'; $letramc= 'J';   $ins_color='A6A6A6'; }else
if(($first_FM_m=='04')&&($first_FM_y==$year)){$x1='H'; $x2='J'; $letramc= 'K';   $ins_color='A6A6A6'; }else
if(($first_FM_m=='05')&&($first_FM_y==$year)){$x1='H'; $x2='K'; $letramc= 'L';   $ins_color='A6A6A6'; }else
if(($first_FM_m=='06')&&($first_FM_y==$year)){$x1='H'; $x2='L'; $letramc= 'M';   $ins_color='A6A6A6'; }else
if(($first_FM_m=='07')&&($first_FM_y==$year)){$x1='H'; $x2='M'; $letramc= 'N';   $ins_color='A6A6A6'; }else
if(($first_FM_m=='08')&&($first_FM_y==$year)){$x1='H'; $x2='N'; $letramc= 'O';   $ins_color='A6A6A6'; }else
if(($first_FM_m=='09')&&($first_FM_y==$year)){$x1='H'; $x2='O'; $letramc= 'P';   $ins_color='A6A6A6'; }else
if(($first_FM_m=='10')&&($first_FM_y==$year)){$x1='H'; $x2='P'; $letramc= 'Q';   $ins_color='A6A6A6'; }else
if(($first_FM_m=='11')&&($first_FM_y==$year)){$x1='H'; $x2='Q'; $letramc= 'R';   $ins_color='A6A6A6'; }else
if(($first_FM_m=='12')&&($first_FM_y==$year)){$x1='H'; $x2='R'; $letramc= 'S';  $ins_color='A6A6A6'; }else{ $x1='H'; $x2='S';  $ins_color='';}



if ($dues) {
if ($ins_color || intval($first_FM_y) > intval($year)) {
    
    if (intval($first_FM_y) > intval($year)) {
        $objPHPExcel->getActiveSheet()->getStyle($x1.$i.':'.$x2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'A6A6A6'
            )
        ));
    } else {
        $objPHPExcel->getActiveSheet()->getStyle($x1.$i.':'.$x2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $ins_color
            )
        ));
    }
	 
     //si es miembro cancelado
if ($this_status_member == "MC") {
        //se pinta todo en blanco primero
        $objPHPExcel->getActiveSheet()->getStyle($letramc.$i.':S'.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR2
            )
        ));


        $objPHPExcel->getActiveSheet()->getStyle("U".$i.':X'.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR2
            )
        ));

        //se pregunta si tiene fecha_cambio_status
         if (strlen($row['mie_fecha_cambio_status']) > 0) {
            $elmes = date_format(date_create($row['mie_fecha_cambio_status']), 'm');
            $elanho = date_format(date_create($row['mie_fecha_cambio_status']), 'Y');
            $pos = getColorPintar($elmes,$elanho, $year);
            if (is_array($pos)) {
                if ($pos['primeranho']) {
                    $objPHPExcel->getActiveSheet()->getStyle($pos['value'].$i.':S'.$i)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => $COLOR1
                        )
                    ));

                    $objPHPExcel->getActiveSheet()->getStyle("U".$i.':X'.$i)->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                'rgb' => $COLOR1
                            )
                        ));
        
                    
                } else {
                    $objPHPExcel->getActiveSheet()->getStyle($pos['value'].$i.':X'.$i)->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                'rgb' => $COLOR1
                            )
                        ));
                }
            }
         }
}
/*

	 $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $ins_color
        )
    ));
*/
    
}else{
    if ($this_status_member == "MS") {
        $objPHPExcel->getActiveSheet()->getStyle($x1.$i.':'.$x2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR3
            )
        ));

/*
        $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR3
            )
        ));
        */
    } elseif ($this_status_member == "MC") {
        //se pinta todo en blanco primero
        $objPHPExcel->getActiveSheet()->getStyle("H".$i.':S'.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR2
            )
        ));


        $objPHPExcel->getActiveSheet()->getStyle("U".$i.':X'.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR2
            )
        ));

        //se pregunta si tiene fecha_cambio_status
         if (strlen($row['mie_fecha_cambio_status']) > 0) {
            $elmes = date_format(date_create($row['mie_fecha_cambio_status']), 'm');
            $elanho = date_format(date_create($row['mie_fecha_cambio_status']), 'Y');
            $pos = getColorPintar($elmes,$elanho, $year);
            if (is_array($pos)) {
                if ($pos['primeranho']) {
                    $objPHPExcel->getActiveSheet()->getStyle($pos['value'].$i.':S'.$i)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => $COLOR1
                        )
                    ));

                    $objPHPExcel->getActiveSheet()->getStyle("U".$i.':X'.$i)->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                'rgb' => $COLOR1
                            )
                        ));
        
                    
                } else {
                    $objPHPExcel->getActiveSheet()->getStyle($pos['value'].$i.':X'.$i)->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                'rgb' => $COLOR1
                            )
                        ));
                }
            }
         }
    } else {
        $objPHPExcel->getActiveSheet()->getStyle($x1.$i.':'.$x2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR2
            )
        ));


        $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR2
            )
        ));
    }
	
	 
	
}

} else {
    if (intval($first_FM_y) > intval($year)) {
        $objPHPExcel->getActiveSheet()->getStyle($x1.$i.':'.$x2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'A6A6A6'
            )
        ));
    } else {
        if ($this_status_member != "MS") {
            $objPHPExcel->getActiveSheet()->getStyle($x1.$i.':'.$x2.$i)->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => $COLOR1
                )
            ));
        } else {
            $objPHPExcel->getActiveSheet()->getStyle($x1.$i.':'.$x2.$i)->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => $COLOR3
                )
            ));
        }
    }
    
}

//Next Year//

if(($first_FM_m=='01')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='U';  $ins_color2='A6A6A6'; }else
if(($first_FM_m=='02')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='U';  $ins_color2='A6A6A6'; }else
if(($first_FM_m=='03')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='V';  $ins_color2='A6A6A6'; }else
if(($first_FM_m=='04')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='W';  $ins_color2='A6A6A6'; } else {
    $xx1='U'; $xx2='X'; $ins_color2='';
} /*else
if(($first_FM_m=='05')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='X';  $ins_color2=$COLOR1; }else
if(($first_FM_m=='06')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='Y';  $ins_color2=$COLOR1; }else
if(($first_FM_m=='07')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='Z';  $ins_color2=$COLOR1; }else
if(($first_FM_m=='08')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='AA'; $ins_color2=$COLOR1; }else
if(($first_FM_m=='09')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='AB'; $ins_color2=$COLOR1; }else
if(($first_FM_m=='10')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='AC'; $ins_color2=$COLOR1; }else
if(($first_FM_m=='11')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='AD'; $ins_color2=$COLOR1; }else
if(($first_FM_m=='12')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='AE'; $ins_color2=$COLOR1; }else { $xx1='U'; $xx2='AF'; $ins_color2=''; }*/

	
	if ($duesnextyear || $dues || $ins_color2) {

    
if($ins_color2){
	

	 $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $ins_color2
        )
    ));
}else{

    if (! in_array($this_status_member, array("MC", "MS"))) {
        $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR2
            )
        ));
    }
}

} else  {
    if ($this_status_member != "MS") {        

        $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR1
            )
        ));
    } else {

        $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR3
            )
        ));
    }

} 
	
		
		  



 
 
//Formating Cells for current year//

 $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('M'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);$objPHPExcel->getActiveSheet()->getStyle('O'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('P'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('R'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('T'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('V'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

$objPHPExcel->getActiveSheet()->getStyle('W'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

$objPHPExcel->getActiveSheet()->getStyle('X'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

/*
$objPHPExcel->getActiveSheet()->getStyle('Y'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('Z'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

$objPHPExcel->getActiveSheet()->getStyle('AA'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('AB'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('AC'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('AD'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('AE'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

$objPHPExcel->getActiveSheet()->getStyle('AF'.$i)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);*/
//end
		
        if ($valorcorte >= intval($year.'01') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, get_paid_month_info($row['mie_id'],'01',$year));
        }

        if ($valorcorte >= intval($year.'02') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, get_paid_month_info($row['mie_id'],'02',$year));
        }
        if ($valorcorte >= intval($year.'03') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, get_paid_month_info($row['mie_id'],'03',$year));
        }
        if ($valorcorte >= intval($year.'04') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, get_paid_month_info($row['mie_id'],'04',$year));
        }
        if ($valorcorte >= intval($year.'05') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, get_paid_month_info($row['mie_id'],'05',$year));
        }
        if ($valorcorte >= intval($year.'06') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, get_paid_month_info($row['mie_id'],'06',$year));
        }
        if ($valorcorte >= intval($year.'07') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, get_paid_month_info($row['mie_id'],'07',$year));
        }
        if ($valorcorte >= intval($year.'08') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, get_paid_month_info($row['mie_id'],'08',$year));
        }
        if ($valorcorte >= intval($year.'09') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, get_paid_month_info($row['mie_id'],'09',$year));
        }
        if ($valorcorte >= intval($year.'10') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, get_paid_month_info($row['mie_id'],'10',$year));
        }
        if ($valorcorte >= intval($year.'11') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, get_paid_month_info($row['mie_id'],'11',$year));
        }
        if ($valorcorte >= intval($year.'12') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$i, get_paid_month_info($row['mie_id'],'12',$year));
        }
        if ($valorcorte >= intval($nextyear.'01') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$i, get_paid_month_info($row['mie_id'],'01',$nextyear));
        }
        if ($valorcorte >= intval($nextyear.'02') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$i, get_paid_month_info($row['mie_id'],'02',$nextyear));
        }
        if ($valorcorte >= intval($nextyear.'03') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('W'.$i, get_paid_month_info($row['mie_id'],'03',$nextyear));
        }
        if ($valorcorte >= intval($nextyear.'04') ) {
            $objPHPExcel->getActiveSheet()->setCellValue('X'.$i, get_paid_month_info($row['mie_id'],'04',$nextyear));
        }

//NEXT YEAR//




/*$objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, get_paid_month_info($row['mie_id'],'05',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, get_paid_month_info($row['mie_id'],'06',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('AA'.$i, get_paid_month_info($row['mie_id'],'07',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('AB'.$i, get_paid_month_info($row['mie_id'],'08',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('AC'.$i, get_paid_month_info($row['mie_id'],'09',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('AD'.$i, get_paid_month_info($row['mie_id'],'10',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('AE'.$i, get_paid_month_info($row['mie_id'],'11',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('AF'.$i, get_paid_month_info($row['mie_id'],'12',$nextyear));*/
//END NEXT YEAR//


//COMMENTING PAYS//
$H = get_paid_month_info($row['mie_id'],'01',$year);
if (strlen($H) > 0 && $valorcorte >= intval($year.'01')) {
    $objPHPExcel->getActiveSheet()->getComment('H'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'01',$year)); 
}
$I = get_paid_month_info($row['mie_id'],'02',$year);
if (strlen($I) > 0 && $valorcorte >= intval($year.'02')) {
    $objPHPExcel->getActiveSheet()->getComment('I'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'02',$year)); 
}
$J = get_paid_month_info($row['mie_id'],'03',$year);
if (strlen($J) > 0 && $valorcorte >= intval($year.'03')) {
    $objPHPExcel->getActiveSheet()->getComment('J'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'03',$year)); 
}
$K = get_paid_month_info($row['mie_id'],'04',$year);
if (strlen($K) > 0 && $valorcorte >= intval($year.'04')) {
    $objPHPExcel->getActiveSheet()->getComment('K'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'04',$year)); 
}
$L = get_paid_month_info($row['mie_id'],'05',$year);
if (strlen($L) > 0 && $valorcorte >= intval($year.'05')) {
    $objPHPExcel->getActiveSheet()->getComment('L'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'05',$year)); 
}
$M = get_paid_month_info($row['mie_id'],'06',$year);
if (strlen($M) > 0 && $valorcorte >= intval($year.'06')) {
    $objPHPExcel->getActiveSheet()->getComment('M'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'06',$year)); 
}
$N = get_paid_month_info($row['mie_id'],'07',$year);
if (strlen($N) > 0 && $valorcorte >= intval($year.'07')) {
    $objPHPExcel->getActiveSheet()->getComment('N'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'07',$year)); 
}
$O = get_paid_month_info($row['mie_id'],'08',$year);
if (strlen($O) > 0 && $valorcorte >= intval($year.'08')) {
    $objPHPExcel->getActiveSheet()->getComment('O'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'08',$year)); 
}
$P = get_paid_month_info($row['mie_id'],'09',$year);
if (strlen($P) > 0 && $valorcorte >= intval($year.'09')) {
    $objPHPExcel->getActiveSheet()->getComment('P'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'09',$year)); 
}
$Q = get_paid_month_info($row['mie_id'],'10',$year);
if (strlen($Q) > 0 && $valorcorte >= intval($year.'10')) {
    $objPHPExcel->getActiveSheet()->getComment('Q'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'10',$year)); 
}
$R = get_paid_month_info($row['mie_id'],'11',$year);
if (strlen($R) > 0 && $valorcorte >= intval($year.'11')) {
    $objPHPExcel->getActiveSheet()->getComment('R'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'11',$year)); 
}
$S = get_paid_month_info($row['mie_id'],'12',$year);
if (strlen($S) > 0 && $valorcorte >= intval($year.'12')) {
    $objPHPExcel->getActiveSheet()->getComment('S'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'12',$year)); 
}
//NEXT YEAR//
$U = get_paid_month_info($row['mie_id'],'01',$nextyear);
if (strlen($U) > 0 && $valorcorte >= intval($nextyear.'01')) {
    $objPHPExcel->getActiveSheet()->getComment('U'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'01',$nextyear)); 
}
$V = get_paid_month_info($row['mie_id'],'02',$nextyear);
if (strlen($V) > 0 && $valorcorte >= intval($nextyear.'02')) {
    $objPHPExcel->getActiveSheet()->getComment('V'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'02',$nextyear)); 
}
$W = get_paid_month_info($row['mie_id'],'03',$nextyear);
if (strlen($W) > 0 && $valorcorte >= intval($nextyear.'03')) {
    $objPHPExcel->getActiveSheet()->getComment('W'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'03',$nextyear)); 
}
$X = get_paid_month_info($row['mie_id'],'04',$nextyear);
if (strlen($X) > 0 && $valorcorte >= intval($nextyear.'04')) {
    $objPHPExcel->getActiveSheet()->getComment('X'.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(get_meses_cobros($row['mie_id'],'04',$nextyear)); 
}
/*$Y = get_paid_month_info($row['mie_id'],'05',$nextyear);
$Z = get_paid_month_info($row['mie_id'],'06',$nextyear);
$AA = get_paid_month_info($row['mie_id'],'07',$nextyear);
$AB = get_paid_month_info($row['mie_id'],'08',$nextyear);
$AC = get_paid_month_info($row['mie_id'],'09',$nextyear);
$AD = get_paid_month_info($row['mie_id'],'10',$nextyear);
$AE = get_paid_month_info($row['mie_id'],'11',$nextyear);
$AF = get_paid_month_info($row['mie_id'],'12',$nextyear);
*/

$fee=get_Monthly_Payment($row['mie_id']);

for ($m = 1; $m <= 12; $m++) {
$marker=detectPayment($row['mie_id'],$m,$year,$i);
if($marker==1){ $cell='H'; }
if($marker==2){ $cell='I'; }
if($marker==3){ $cell='J'; }
if($marker==4){ $cell='K'; }
if($marker==5){ $cell='L'; }
if($marker==6){ $cell='M'; }
if($marker==7){ $cell='N'; }
if($marker==8){ $cell='O'; }
if($marker==9){ $cell='P'; }
if($marker==10){ $cell='Q'; }
if($marker==11){ $cell='R'; }
if($marker==12){ $cell='S'; }
$pagosMes = tiene_pagos($row['mie_id'],$m,$year);
//$countPayments = countPayments($row['mie_id'],$m,$year,$i);
if($pagosMes > 0){
//$objPHPExcel->getActiveSheet()->getComment($cell.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(comment_months_literal($row['mie_id'],$m,$year,$i)); 



$commenting=comment_months($row['mie_id'],$m,$year,$i, $corte);
//cellColor($cell.$i, 'ffff00');

$color='ffff00';

//cellColor($cell.$i, $color);
if (strpos($commenting, 'ENERO'.$year) !== false  && $valorcorte >= intval($year.'01')) {
    $objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'FEBRERO'.$year) !== false  && $valorcorte >= intval($year.'02')) {
    $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'MARZO'.$year) !== false  && $valorcorte >= intval($year.'03')) {
    $objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

if (strpos($commenting, 'ABRIL'.$year) !== false  && $valorcorte >= intval($year.'04')) {
    $objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'MAYO'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'JUNIO'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'JULIO'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'AGOSTO'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('O'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'SEPTIEMBRE'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('P'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'OCTUBRE'.$year) !== false  ) {
    $objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'NOVIEMBRE'.$year) !== false ) {
    $objPHPExcel->getActiveSheet()->getStyle('R'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'DICIEMBRE'.$year) !== false ) {
    $objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'ENERO'.$nextyear) !== false  && $valorcorte >= intval($nextyear.'01')) {
    $objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'FEBRERO'.$nextyear) !== false  && $valorcorte >= intval($nextyear.'02')) {
    $objPHPExcel->getActiveSheet()->getStyle('V'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'MARZO'.$nextyear) !== false  && $valorcorte >= intval($nextyear.'03')) {
    $objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

if (strpos($commenting, 'ABRIL'.$nextyear) !== false && $valorcorte >= intval($nextyear.'04')) {
    $objPHPExcel->getActiveSheet()->getStyle('X'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
/*
if (strpos($commenting, 'MAYO'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('Y'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'JUNIO'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('Z'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'JULIO'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('AA'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'AGOSTO'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('AB'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'SEPTIEMBRE'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('AC'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'OCTUBRE'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('AD'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'NOVIEMBRE'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('AE'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'DICIEMBRE'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('AF'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
*/



 
	}
//NEXT YEAR//
if ($m<5) {
$marker2=detectPayment($row['mie_id'],$m,$nextyear,$i);
if($marker2==1){ $cell='U'; }
if($marker2==2){ $cell='V'; }
if($marker2==3){ $cell='W'; }
if($marker2==4){ $cell='X'; }
/*if($marker2==5){ $cell='Y'; }
if($marker2==6){ $cell='Z'; }
if($marker2==7){ $cell='AA'; }
if($marker2==8){ $cell='AB'; }
if($marker2==9){ $cell='AC'; }
if($marker2==10){ $cell='AD'; }
if($marker2==11){ $cell='AE'; }
if($marker2==12){ $cell='AF'; }
*/
$pagosMesNY = tiene_pagos($row['mie_id'],$m,$nextyear);
//$NYcountPayments = countPayments($row['mie_id'],$m,$nextyear,$i);
if($pagosMesNY >  0){

//$objPHPExcel->getActiveSheet()->getComment($cell.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(comment_months_literal($row['mie_id'],$m,$nextyear,$i)); //substr($members,0,-2);
$commenting_next_year=comment_months($row['mie_id'],$m,$nextyear,$i, $corte);
$color='ffff00';

//cellColor($cell.$i, $color);

//Comenting Next Year and Old Year//
if (strpos($commenting_next_year, 'ENERO'.$nextyear) !== false && $valorcorte >= intval($nextyear.'01')) {
    $objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'FEBRERO'.$nextyear) !== false && $valorcorte >= intval($nextyear.'02')) {
    $objPHPExcel->getActiveSheet()->getStyle('V'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'MARZO'.$nextyear) !== false && $valorcorte >= intval($nextyear.'03')) {
    $objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

if (strpos($commenting_next_year, 'ABRIL'.$nextyear) !== false && $valorcorte >= intval($nextyear.'04')) {
    $objPHPExcel->getActiveSheet()->getStyle('X'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
/*
if (strpos($commenting_next_year, 'MAYO'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('Y'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'JUNIO'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('Z'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'JULIO'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('AA'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'AGOSTO'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('AB'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'SEPTIEMBRE'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('AC'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'OCTUBRE'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('AD'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'NOVIEMBRE'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('AE'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'DICIEMBRE'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('AF'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

if (strpos($commenting_next_year, 'ENERO'.$year) !== false  && $valorcorte >= intval($year.'01')) {
    $objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'FEBRERO'.$year) !== false  && $valorcorte >= intval($year.'02')) {
    $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )

    ));
}
if (strpos($commenting_next_year, 'MARZO'.$year) !== false  && $valorcorte >= intval($year.'03')) {
    $objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

if (strpos($commenting_next_year, 'ABRIL'.$year) !== false  && $valorcorte >= intval($year.'04')) {
    $objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

if (strpos($commenting_next_year, 'MAYO'.$year) !== false  && $valorcorte >= intval($year.'05')) {
    $objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'JUNIO'.$year) !== false  && $valorcorte >= intval($year.'06')) {
    $objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'JULIO'.$year) !== false  && $valorcorte >= intval($year.'07')) {
    $objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'AGOSTO'.$year) !== false  && $valorcorte >= intval($year.'08')) {
    $objPHPExcel->getActiveSheet()->getStyle('O'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'SEPTIEMBRE'.$year) !== false && $valorcorte >= intval($year.'09')) {
    $objPHPExcel->getActiveSheet()->getStyle('P'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'OCTUBRE'.$year) !== false  && $valorcorte >= intval($year.'10')) {
    $objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'NOVIEMBRE'.$year) !== false  && $valorcorte >= intval($year.'11')) {
    $objPHPExcel->getActiveSheet()->getStyle('R'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'DICIEMBRE'.$year) !== false  && $valorcorte >= intval($year.'12')) {
    $objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
*/

}
}

	
}//end for

$exonerados=comment_months_exonerados($row['mie_id'], $corte);

    
if (strpos($exonerados, 'ENERO'.$year) !== false  && $valorcorte >= intval($year.'01')) {
    $objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
}
if (strpos($exonerados, 'FEBRERO'.$year) !== false  && $valorcorte >= intval($year.'02')) {
    $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )

    ));
}
if (strpos($exonerados, 'MARZO'.$year) !== false  && $valorcorte >= intval($year.'03')) {
    $objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
}

if (strpos($exonerados, 'ABRIL'.$year) !== false  && $valorcorte >= intval($year.'04')) {
    $objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
    
}

if (strpos($exonerados, 'MAYO'.$year) !== false  && $valorcorte >= intval($year.'05')) {
    $objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
}
if (strpos($exonerados, 'JUNIO'.$year) !== false  && $valorcorte >= intval($year.'06')) {
    $objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
}
if (strpos($exonerados, 'JULIO'.$year) !== false  && $valorcorte >= intval($year.'07')) {
    $objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
}
if (strpos($exonerados, 'AGOSTO'.$year) !== false  && $valorcorte >= intval($year.'08')) {
    $objPHPExcel->getActiveSheet()->getStyle('O'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
}
if (strpos($exonerados, 'SEPTIEMBRE'.$year) !== false && $valorcorte >= intval($year.'09')) {
    $objPHPExcel->getActiveSheet()->getStyle('P'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
}
if (strpos($exonerados, 'OCTUBRE'.$year) !== false  && $valorcorte >= intval($year.'10')) {
    $objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
}
if (strpos($exonerados, 'NOVIEMBRE'.$year) !== false  && $valorcorte >= intval($year.'11')) {
    $objPHPExcel->getActiveSheet()->getStyle('R'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
}
if (strpos($exonerados, 'DICIEMBRE'.$year) !== false  && $valorcorte >= intval($year.'12')) {
    $objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
}




    if (strpos($exonerados, 'ENERO'.$nextyear) !== false && $valorcorte >= intval($nextyear.'01')) {
    $objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
}
if (strpos($exonerados, 'FEBRERO'.$nextyear) !== false && $valorcorte >= intval($nextyear.'02')) {
    $objPHPExcel->getActiveSheet()->getStyle('V'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
}
if (strpos($exonerados, 'MARZO'.$nextyear) !== false && $valorcorte >= intval($nextyear.'03')) {
    $objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
}

if (strpos($exonerados, 'ABRIL'.$nextyear) !== false && $valorcorte >= intval($nextyear.'04')) {
    $objPHPExcel->getActiveSheet()->getStyle('X'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => '92d050'
        )
    ));
}

//END//
$objPHPExcel->getActiveSheet()->setCellValue('T'.$i, "=SUM(H".$i.":S".$i.")");
$i++;
}
}//end loop
$final_count=$rcount+9;
//$objPHPExcel->getActiveSheet()->getColumnDimension('G'.$final_count)->setWidth(50)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('G'.$final_count)->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('G'.$final_count)->setWidth("15");
$objPHPExcel->getActiveSheet()->setCellValue('G'.$final_count, "Sub-Totals: ");
$objPHPExcel->getActiveSheet()->setCellValue('H'.$final_count, "=SUM(H8:H".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('I'.$final_count, "=SUM(I8:I".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('J'.$final_count, "=SUM(J8:J".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('K'.$final_count, "=SUM(K8:K".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('L'.$final_count, "=SUM(L8:L".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('M'.$final_count, "=SUM(M8:M".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('N'.$final_count, "=SUM(N8:N".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('O'.$final_count, "=SUM(O8:O".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('P'.$final_count, "=SUM(P8:P".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$final_count, "=SUM(Q8:Q".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('R'.$final_count, "=SUM(R8:R".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('S'.$final_count, "=SUM(S8:S".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('T'.$final_count, "=SUM(T8:T".($final_count-2).")");
//NEXT YEAR//
$objPHPExcel->getActiveSheet()->setCellValue('U'.$final_count, "=SUM(U8:U".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('V'.$final_count, "=SUM(V8:V".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('W'.$final_count, "=SUM(W8:W".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('X'.$final_count, "=SUM(X8:X".($final_count-2).")");






/*$objPHPExcel->getActiveSheet()->setCellValue('Y'.$final_count, "=SUM(Y8:Y".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('Z'.$final_count, "=SUM(Z8:Z".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('AA'.$final_count, "=SUM(AA8:AA".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('AB'.$final_count, "=SUM(AB8:AB".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('AC'.$final_count, "=SUM(AC8:AC".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('AD'.$final_count, "=SUM(AD8:AD".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('AE'.$final_count, "=SUM(AE8:AE".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('AF'.$final_count, "=SUM(AF8:AF".($final_count-2).")");
*/














//NEXT YEAR//

$proxfila = intval($final_count)+1;
$totalagrup[$curagrup]['G']['pos'] = 'G'.$proxfila;
$totalagrup[$curagrup]['G']['value'] = "Totals: ";
$totalagrup[$curagrup]['H']['pos'] = 'H'.$proxfila;
$totalagrup[$curagrup]['I']['pos'] = 'I'.$proxfila;
$totalagrup[$curagrup]['J']['pos'] = 'J'.$proxfila;
$totalagrup[$curagrup]['K']['pos'] = 'K'.$proxfila;
$totalagrup[$curagrup]['L']['pos'] = 'L'.$proxfila;
$totalagrup[$curagrup]['M']['pos'] = 'M'.$proxfila;
$totalagrup[$curagrup]['N']['pos'] = 'N'.$proxfila;
$totalagrup[$curagrup]['O']['pos'] = 'O'.$proxfila;
$totalagrup[$curagrup]['P']['pos'] = 'P'.$proxfila;
$totalagrup[$curagrup]['Q']['pos'] = 'Q'.$proxfila;
$totalagrup[$curagrup]['R']['pos'] = 'R'.$proxfila;
$totalagrup[$curagrup]['S']['pos'] = 'S'.$proxfila;
$totalagrup[$curagrup]['T']['pos'] = 'T'.$proxfila;
$totalagrup[$curagrup]['U']['pos'] = 'U'.$proxfila;
$totalagrup[$curagrup]['V']['pos'] = 'V'.$proxfila;
$totalagrup[$curagrup]['W']['pos'] = 'W'.$proxfila;
$totalagrup[$curagrup]['X']['pos'] = 'X'.$proxfila;

if (strlen($totalagrup[$curagrup]['H']['value'])) {
    $totalagrup[$curagrup]['H']['value'] += $objPHPExcel->getActiveSheet()->getCell('H'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['H']['value'] = $objPHPExcel->getActiveSheet()->getCell('H'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['I']['value'])) {
    $totalagrup[$curagrup]['I']['value'] += $objPHPExcel->getActiveSheet()->getCell('I'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['I']['value'] = $objPHPExcel->getActiveSheet()->getCell('I'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['J']['value'])) {
    $totalagrup[$curagrup]['J']['value'] += $objPHPExcel->getActiveSheet()->getCell('J'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['J']['value'] = $objPHPExcel->getActiveSheet()->getCell('J'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['K']['value'])) {
    $totalagrup[$curagrup]['K']['value'] += $objPHPExcel->getActiveSheet()->getCell('K'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['K']['value'] = $objPHPExcel->getActiveSheet()->getCell('K'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['L']['value'])) {
    $totalagrup[$curagrup]['L']['value'] += $objPHPExcel->getActiveSheet()->getCell('L'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['L']['value'] = $objPHPExcel->getActiveSheet()->getCell('L'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['M']['value'])) {
    $totalagrup[$curagrup]['M']['value'] += $objPHPExcel->getActiveSheet()->getCell('M'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['M']['value'] = $objPHPExcel->getActiveSheet()->getCell('M'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['N']['value'])) {
    $totalagrup[$curagrup]['N']['value'] += $objPHPExcel->getActiveSheet()->getCell('N'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['N']['value'] = $objPHPExcel->getActiveSheet()->getCell('N'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['O']['value'])) {
    $totalagrup[$curagrup]['O']['value'] += $objPHPExcel->getActiveSheet()->getCell('O'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['O']['value'] = $objPHPExcel->getActiveSheet()->getCell('O'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['P']['value'])) {
    $totalagrup[$curagrup]['P']['value'] += $objPHPExcel->getActiveSheet()->getCell('P'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['P']['value'] = $objPHPExcel->getActiveSheet()->getCell('P'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['Q']['value'])) {
    $totalagrup[$curagrup]['Q']['value'] += $objPHPExcel->getActiveSheet()->getCell('Q'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['Q']['value'] = $objPHPExcel->getActiveSheet()->getCell('Q'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['R']['value'])) {
    $totalagrup[$curagrup]['R']['value'] += $objPHPExcel->getActiveSheet()->getCell('R'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['R']['value'] = $objPHPExcel->getActiveSheet()->getCell('R'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['S']['value'])) {
    $totalagrup[$curagrup]['S']['value'] += $objPHPExcel->getActiveSheet()->getCell('S'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['S']['value'] = $objPHPExcel->getActiveSheet()->getCell('S'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['T']['value'])) {
    $totalagrup[$curagrup]['T']['value'] += $objPHPExcel->getActiveSheet()->getCell('T'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['T']['value'] = $objPHPExcel->getActiveSheet()->getCell('T'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['U']['value'])) {
    $totalagrup[$curagrup]['U']['value'] += $objPHPExcel->getActiveSheet()->getCell('U'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['U']['value'] = $objPHPExcel->getActiveSheet()->getCell('U'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['V']['value'])) {
    $totalagrup[$curagrup]['V']['value'] += $objPHPExcel->getActiveSheet()->getCell('V'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['V']['value'] = $objPHPExcel->getActiveSheet()->getCell('V'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['W']['value'])) {
    $totalagrup[$curagrup]['W']['value'] += $objPHPExcel->getActiveSheet()->getCell('W'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['W']['value'] = $objPHPExcel->getActiveSheet()->getCell('W'.$final_count)->getCalculatedValue();
}

if (strlen($totalagrup[$curagrup]['X']['value'])) {
    $totalagrup[$curagrup]['X']['value'] += $objPHPExcel->getActiveSheet()->getCell('X'.$final_count)->getCalculatedValue();
} else {
    $totalagrup[$curagrup]['X']['value'] = $objPHPExcel->getActiveSheet()->getCell('X'.$final_count)->getCalculatedValue();
}

$objPHPExcel->getActiveSheet()->getStyle('H'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

$objPHPExcel->getActiveSheet()->getStyle('I'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

$objPHPExcel->getActiveSheet()->getStyle('J'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('K'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('L'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('M'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('N'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);$objPHPExcel->getActiveSheet()->getStyle('O'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('P'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('Q'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('R'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('S'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('T'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('U'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('V'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

$objPHPExcel->getActiveSheet()->getStyle('W'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

$objPHPExcel->getActiveSheet()->getStyle('X'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

/*
$objPHPExcel->getActiveSheet()->getStyle('Y'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('Z'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

$objPHPExcel->getActiveSheet()->getStyle('AA'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('AB'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('AC'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('AD'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);


$objPHPExcel->getActiveSheet()->getStyle('AE'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);

$objPHPExcel->getActiveSheet()->getStyle('AF'.$final_count)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
*/
//Removing and Computing Next Year
$CNAMES='U,V,W,X';//,Y,Z,AA,AB,AC,AD,AE,AF';
$del = 5-$CM; //13 - $CM;
if($CY==$year){
//$objPHPExcel->getActiveSheet()->removeColumn('AF', 12);
//$objPHPExcel->getActiveSheet()->setCellValue('U6', " ");
$objPHPExcel->getActiveSheet()->removeColumn('AF', $del);	

}else{
	if($year < '2016'){
	//do nothing
}else{
$objPHPExcel->getActiveSheet()->removeColumn('AF', $del);	

  }
}
/****** END BODY ******/
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPlease treat this document as confidential!');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
// Set page orientation and size
//echo date('H:i:s') , " Set page orientation and size" , EOL;
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// Rename worksheet
//echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle($sheetTitle);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex($xSheet);
$xSheet++;
}
foreach ($totalagrup as $t) {
    $objPHPExcel->setActiveSheetIndex($t['sheet']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['G']['pos'], $t['G']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['H']['pos'], $t['H']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['I']['pos'], $t['I']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['J']['pos'], $t['J']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['K']['pos'], $t['K']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['L']['pos'], $t['L']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['M']['pos'], $t['M']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['N']['pos'], $t['N']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['O']['pos'], $t['O']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['P']['pos'], $t['P']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['Q']['pos'], $t['Q']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['R']['pos'], $t['R']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['S']['pos'], $t['S']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['T']['pos'], $t['T']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['U']['pos'], $t['U']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['V']['pos'], $t['V']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['W']['pos'], $t['W']['value']);
    $objPHPExcel->getActiveSheet()->setCellValue($t['X']['pos'], $t['X']['value']);

    $objPHPExcel->getActiveSheet()->getStyle($t['H']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['I']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['J']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['K']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['L']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['M']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['N']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['O']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['P']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['Q']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['R']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['S']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['T']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['U']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['V']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['W']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
    $objPHPExcel->getActiveSheet()->getStyle($t['X']['pos'])->applyFromArray(
        array('borders' => array(
            'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
            'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        )
    );
    
}

unset($xSheet);
//$objPHPExcel->removeSheetByIndex(0);
mysqli_close($con);
$callStartTime = microtime(true);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('./reportesgenerados/'.$report_name, __FILE__);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
generate_Summary($userid,$year,$sedeid, $corte);
}

function generate_Summary($userid,$year,$sedeid, $corte){
	include("../../incluidos/db_config/config.php");

$nextyear = $year + 1;
$country = get_country_by_user($userid);	
$report_country = strtoupper(substr($country,0,2));
$report_name="Summary-".$userid.'.xlsx';
//$report_name_for_excel="GROSS REVENUE REPORT FOR: ".get_IBU($userid).' ('.get_admin_details($userid,'fullname').')';
$report_name_for_excel="GROSS REVENUE REPORT FOR:  (".get_IBU($userid).")";

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
$objPHPExcel = PHPExcel_IOFactory::load("./excels_templates/summary.xlsx");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A3', $report_name_for_excel);
$objPHPExcel->getActiveSheet()->setCellValue('E5', get_IBU($userid));
$objPHPExcel->getActiveSheet()->setCellValue('P5', set_report_date($corte));
$objPHPExcel->getActiveSheet()->setCellValue('A26', $nextyear);
//Consulting DataBase
//Getting MEmber status count
//Status codes 1=acive 4=Sp 3=Scholar
$m=1;
for ($i = 12; $i <= 23; $i++) {
	if($i==13){
		$x_day='28';
	}else if(($i==12)||($i==14)||($i==16)||($i==18)||($i==20)||($i==22)){
		$x_day='31';
	}else{
		$x_day='30';
	}

$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $m."/".$x_day."/".$year);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, calculate_summary_value($m,$year,'enrollment', $corte, $sedeid));  //Computing Enrollment Fees
$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, calculate_summary_value($m,$year,'dues', $corte, $sedeid));  //Computing Dues
$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, calculate_summary_value($m,$year,'other', $corte, $sedeid));  //Computing Other Activity
$objPHPExcel->getActiveSheet()->setCellValue('R'.$i, calculate_summary_value($m,$year,'price', $corte, $sedeid));  //Computing Price
$m++;

}//end for 1

$m2=1;
for ($n = 32; $n <= 43; $n++) {
	if($n==33){
		$x_day='28';
	}else if(($n==32)||($n==34)||($n==36)||($n==38)||($n==40)||($n==42)){
		$x_day='31';
	}else{
		$x_day='30';
	}

$objPHPExcel->getActiveSheet()->setCellValue('A'.$n, $m2."/".$x_day."/".$nextyear);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$n, calculate_summary_value($m2,$nextyear,'enrollment', $corte, $sedeid));  //Computing Enrollment Fees
$objPHPExcel->getActiveSheet()->setCellValue('D'.$n, calculate_summary_value($m2,$nextyear,'dues', $corte, $sedeid));  //Computing Dues
$objPHPExcel->getActiveSheet()->setCellValue('F'.$n, calculate_summary_value($m2,$nextyear,'other', $corte, $sedeid));  //Computing Other Activity
$objPHPExcel->getActiveSheet()->setCellValue('R'.$n, calculate_summary_value($m2,$nextyear,'price', $corte, $sedeid));  //Computing Price

$m2++;

}//end for 2



$c=50;
$sql = "SELECT * FROM grupos WHERE sede_id='$sedeid'";	
//$sql = "SELECT grupos.*, usuario.* FROM grupos, usuario WHERE grupos.gru_forum=usuario.usu_id AND grupos.sede_id='$sede_id'";
$res = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($res)){
	
//$objPHPExcel->getActiveSheet()->setCellValue('A'.$c, get_profile_name($row['perfil_per_id']));
$objPHPExcel->getActiveSheet()->setCellValue('A'.$c, $row['gru_descripcion']);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$c, get_admin_details($row['gru_forum'],'fullname'));
//$objPHPExcel->getActiveSheet()->setCellValue('B'.$c, $year);
$objPHPExcel->getActiveSheet()->getStyle('A'.$c)->applyFromArray(
    array('borders' => array(
        'left'      => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'top'       => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)
    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('B'.$c)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)    )
)
);
$objPHPExcel->getActiveSheet()->getStyle('C'.$c)->applyFromArray(
    array('borders' => array(
        'bottom'    => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM),
        'right'     => array('style' =>PHPExcel_Style_Border::BORDER_MEDIUM)    )
)
);
$c++;
}



$CM=date('m');
$CY=date('Y');
//Removing and Computing Next Year
//$del = (44 - $CM)-2 ;
$del = 36;
/*if($CY==$year){

for($i = 26; $i <= 44; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}

}else{

*/
for($i = $del; $i <=44 ; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}
	


//}//end if


mysqli_close($con);

$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPlease treat this document as confidential!');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

// Rename worksheet
//echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle("Summary");
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('./reportesgenerados/'.$report_name, __FILE__);
//$objWriter->save(str_replace(__FILE__,'/./reportesgenerados/'.$report_name,__FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

$admin_email = $_SESSION['admin_email'];

compile_all_reports($userid,$admin_email);

}

function compile_all_reports($userid,$admin_email){

$report_name="FullReport-".$userid.'.xlsx';
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
// Files are loaded to PHPExcel using the IOFactory load() method
$objPHPExcel1 = PHPExcel_IOFactory::load('./reportesgenerados/Summary-'.$userid.'.xlsx');
$objPHPExcel2 = PHPExcel_IOFactory::load('./reportesgenerados/EnrollmentFees-'.$userid.'.xlsx');
$objPHPExcel3 = PHPExcel_IOFactory::load('./reportesgenerados/Dues-'.$userid.'.xlsx');
$objPHPExcel4 = PHPExcel_IOFactory::load('./reportesgenerados/Memberships-'.$userid.'.xlsx');


// Copy worksheets from $objPHPExcel2 to $objPHPExcel1
foreach($objPHPExcel1->getAllSheets() as $sheet) {
    $objPHPExcel->addExternalSheet($sheet);
}
foreach($objPHPExcel2->getAllSheets() as $sheet) {
    $objPHPExcel->addExternalSheet($sheet);
}
foreach($objPHPExcel3->getAllSheets() as $sheet) {
    $objPHPExcel->addExternalSheet($sheet);
}
foreach($objPHPExcel4->getAllSheets() as $sheet) {
    $objPHPExcel->addExternalSheet($sheet);
}


$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPlease treat this document as confidential!');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getSheetByName('Worksheet')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_VERYHIDDEN);
$objPHPExcel->setActiveSheetIndex(1);
//$objPHPExcel->removeSheetByIndex(0);
$callStartTime = microtime(true);
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('./reportesgenerados/'.$report_name, __FILE__);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
//Sending Notification to the logged user//
sendEmail($userid,$admin_email);
}

?>