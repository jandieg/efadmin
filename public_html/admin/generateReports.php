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
$year=$_GET['year'];
$sede_id=$_GET['sede_id'];
$email=$_GET['email'];
//Running Report//

generate_enrollment_fees($userid,$year,$sede_id,$email); //This function will run The 1st report//	
//generate_Dues($userid,$year,$sede_id,$email); //This function will run The 1st report//	

function generate_enrollment_fees($userid,$year,$sedeid,$email){
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
$objPHPExcel->getActiveSheet()->setCellValue('N3', set_report_date($year));
$objPHPExcel->getActiveSheet()->setCellValue('D3', $report_name_for_excel);
$objPHPExcel->getActiveSheet()->setCellValue('A72', $nextyear);
//Consulting DataBase
for ($i = 1; $i <= 12; $i++) {
$sql = "SELECT * FROM miembro_inscripcion WHERE MONTH(mie_ins_fecha_cobro)='$i' AND YEAR(mie_ins_fecha_cobro)='$year'"; // AND YEAR(mie_ins_fecha_ingreso)='$year'	
$res = mysqli_query($con,$sql);
//$row = mysqli_fetch_array($res);
//$response["result"] = array();
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
//Getting custom values from timestamp in executiveforums db//
$this_month =  date('m', $sql_date);
//End Getting time and date//
if(($this_month=='01')||($this_month=='05')||($this_month=='09')){
 $objPHPExcel->getActiveSheet()->setCellValue('A'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('B'.$n, convert_datetime($row['mie_ins_fecha_cobro'],''));
 $objPHPExcel->getActiveSheet()->setCellValue('C'.$n, $row['mie_ins_valor']);
	}
if(($this_month=='02')||($this_month=='06')||($this_month=='10')){
 $objPHPExcel->getActiveSheet()->setCellValue('E'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('F'.$n, convert_datetime($row['mie_ins_fecha_cobro'],''));
 $objPHPExcel->getActiveSheet()->setCellValue('G'.$n, $row['mie_ins_valor']);
	}
if(($this_month=='03')||($this_month=='07')||($this_month=='11')){
 $objPHPExcel->getActiveSheet()->setCellValue('I'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('J'.$n, convert_datetime($row['mie_ins_fecha_cobro'],''));
 $objPHPExcel->getActiveSheet()->setCellValue('K'.$n, $row['mie_ins_valor']);
	}
if($this_month=='04'){
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, convert_datetime($row['mie_ins_fecha_cobro'],''));
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$n, $row['mie_ins_valor']);
	}
if($this_month=='08'){
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, convert_datetime($row['mie_ins_fecha_cobro'],''));
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$n, $row['mie_ins_valor']);
	}
if($this_month=='12'){
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, convert_datetime($row['mie_ins_fecha_cobro'],''));
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$n, $row['mie_ins_valor']);
	}

$n++;
}//end loop

}//end for


//Computing Next Year//

for ($i = 1; $i <= 4; $i++) {
$sql = "SELECT * FROM miembro_inscripcion WHERE MONTH(mie_ins_fecha_cobro)='$i' AND YEAR(mie_ins_fecha_cobro)='$nextyear'";	
$res = mysqli_query($con,$sql);
//$row = mysqli_fetch_array($res);
//$response["result"] = array();
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
//Getting custom values from timestamp in executiveforums db//
$this_month =  date('m', $sql_date);
//End Getting time and date//
if(($this_month=='01') /*||($this_month=='05')||($this_month=='09')*/){
 $objPHPExcel->getActiveSheet()->setCellValue('A'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('B'.$n, convert_datetime($row['mie_ins_fecha_cobro'],''));
 $objPHPExcel->getActiveSheet()->setCellValue('C'.$n, $row['mie_ins_valor']);
	}
if(($this_month=='02')/*||($this_month=='06')||($this_month=='10')*/){
 $objPHPExcel->getActiveSheet()->setCellValue('E'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('F'.$n, convert_datetime($row['mie_ins_fecha_cobro'],''));
 $objPHPExcel->getActiveSheet()->setCellValue('G'.$n, $row['mie_ins_valor']);
	}
if(($this_month=='03')/*||($this_month=='07')||($this_month=='11')*/){
 $objPHPExcel->getActiveSheet()->setCellValue('I'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('J'.$n, convert_datetime($row['mie_ins_fecha_cobro'],''));
 $objPHPExcel->getActiveSheet()->setCellValue('K'.$n, $row['mie_ins_valor']);
	}
if($this_month=='04'){
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, convert_datetime($row['mie_ins_fecha_cobro'],''));
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$n, $row['mie_ins_valor']);
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
if($CY==$year){

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

}else{

if($year < date('Y')){
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
}

}//end if

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

generate_Memberships($userid,$year,$sedeid); //Generating 2nd Report//
}//END REPORT


function generate_Memberships($userid,$year,$sedeid){
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
$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, get_active_members('top',1,$year,$i,$report_country));
$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, get_active_members('top',4,$year,$i,$report_country));
$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, get_active_members('top',3,$year,$i,$report_country));

$B=get_active_members('top',1,$year,$i,$report_country);
$C=get_active_members('top',4,$year,$i,$report_country);
$D=get_active_members('top',3,$year,$i,$report_country);
if($B>0){
$objPHPExcel->getActiveSheet()->getComment('B'.$i)->setHeight("auto")->setWidth("200px")->getText()->createTextRun(comment_members('top',1,'B',$year,$i,$report_country)); 
}
if($C>0){
$objPHPExcel->getActiveSheet()->getComment('C'.$i)->setHeight("auto")->setWidth("200px")->getText()->createTextRun(comment_members('top',4,'C',$year,$i,$report_country)); 
}
if($D>0){
$objPHPExcel->getActiveSheet()->getComment('D'.$i)->setHeight("auto")->setWidth("200px")->getText()->createTextRun(comment_members('top',3,'D',$year,$i,$report_country)); 
}

}//end for


for ($i = 9; $i <= 20; $i++) {
$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, get_active_members('executive',1,$year,$i,$report_country));
$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, get_active_members('executive',4,$year,$i,$report_country));
$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, get_active_members('executive',3,$year,$i,$report_country));

$G=get_active_members('executive',1,$year,$i,$report_country);
$H=get_active_members('executive',4,$year,$i,$report_country);
$I=get_active_members('executive',3,$year,$i,$report_country);

if($G>0){
$objPHPExcel->getActiveSheet()->getComment('G'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('executive',1,'G',$year,$i,$report_country)); 
}
if($H>0){
$objPHPExcel->getActiveSheet()->getComment('H'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('executive',4,'H',$year,$i,$report_country)); 
}
if($I>0){
$objPHPExcel->getActiveSheet()->getComment('I'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('executive',3,'I',$year,$i,$report_country)); 
}


}//end for


for ($i = 9; $i <= 20; $i++) {
	//cell N for Cancels
	//cell P for adds

$N=get_member_by_status_changed('cancels','top',$year,$i,$report_country); //Top Cancels
$P=get_member_by_status_changed('adds','top',$year,$i,$report_country);    //Top Adds
$O=get_member_by_status_changed('cancels','key',$year,$i,$report_country); //Key Cancels
$Q=get_member_by_status_changed('adds','key',$year,$i,$report_country);    //Key Adds

$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $N);
$objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $P);
$objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $O);
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $Q);


if($N>0){
$objPHPExcel->getActiveSheet()->getComment('N'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('cancels',0,'N',$year,$i,$report_country)); 
}
if($P>0){
$objPHPExcel->getActiveSheet()->getComment('P'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('adds',0,'P',$year,$i,$report_country)); 
}

if($O>0){
$objPHPExcel->getActiveSheet()->getComment('O'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('cancels',0,'O',$year,$i,$report_country)); 
}
if($Q>0){
$objPHPExcel->getActiveSheet()->getComment('Q'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('adds',0,'Q',$year,$i,$report_country)); 
}



}//end for


//Computing Next nextyear//
for ($i = 22; $i <= 33; $i++) {
$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, get_active_members('top',1,$nextyear,$i,$report_country));
$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, get_active_members('top',4,$nextyear,$i,$report_country));
$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, get_active_members('top',3,$nextyear,$i,$report_country));

$B=get_active_members('top',1,$nextyear,$i,$report_country);
$C=get_active_members('top',4,$nextyear,$i,$report_country);
$D=get_active_members('top',3,$nextyear,$i,$report_country);
if($B>0){
$objPHPExcel->getActiveSheet()->getComment('B'.$i)->setHeight("auto")->setWidth("200px")->getText()->createTextRun(comment_members('top',1,'B',$nextyear,$i,$report_country)); 
}
if($C>0){
$objPHPExcel->getActiveSheet()->getComment('C'.$i)->setHeight("auto")->setWidth("200px")->getText()->createTextRun(comment_members('top',4,'C',$nextyear,$i,$report_country)); 
}
if($D>0){
$objPHPExcel->getActiveSheet()->getComment('D'.$i)->setHeight("auto")->setWidth("200px")->getText()->createTextRun(comment_members('top',3,'D',$nextyear,$i,$report_country)); 
}



}//end for


for ($i = 22; $i <= 33; $i++) {
$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, get_active_members('executive',1,$nextyear,$i,$report_country));
$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, get_active_members('executive',4,$nextyear,$i,$report_country));
$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, get_active_members('executive',3,$nextyear,$i,$report_country));

$G=get_active_members('executive',1,$nextyear,$i,$report_country);
$H=get_active_members('executive',4,$nextyear,$i,$report_country);
$I=get_active_members('executive',3,$nextyear,$i,$report_country);

if($G>0){
$objPHPExcel->getActiveSheet()->getComment('G'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('executive',1,'G',$nextyear,$i,$report_country)); 
}
if($H>0){
$objPHPExcel->getActiveSheet()->getComment('H'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('executive',4,'H',$nextyear,$i,$report_country)); 
}
if($I>0){
$objPHPExcel->getActiveSheet()->getComment('I'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('executive',3,'I',$nextyear,$i,$report_country)); 
}


}//end for


for ($i = 22; $i <= 33; $i++) {
	//cell N for Cancels
	//cell P for adds

$N=get_member_by_status_changed('cancels','top',$nextyear,$i,$report_country); //Top Cancels
$P=get_member_by_status_changed('adds','top',$nextyear,$i,$report_country);    //Top Adds
$O=get_member_by_status_changed('cancels','key',$nextyear,$i,$report_country); //Key Cancels
$Q=get_member_by_status_changed('adds','key',$nextyear,$i,$report_country);    //Key Adds

$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $N);
$objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $P);
$objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $O);
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $Q);


if($N>0){
$objPHPExcel->getActiveSheet()->getComment('N'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('cancels',0,'N',$nextyear,$i,$report_country)); 
}
if($P>0){
$objPHPExcel->getActiveSheet()->getComment('P'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('adds',0,'P',$nextyear,$i,$report_country)); 
}

if($O>0){
$objPHPExcel->getActiveSheet()->getComment('O'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('cancels',0,'O',$nextyear,$i,$report_country)); 
}
if($Q>0){
$objPHPExcel->getActiveSheet()->getComment('Q'.$i)->setHeight("auto")->setWidth("150px")->getText()->createTextRun(comment_members('adds',0,'Q',$nextyear,$i,$report_country)); 
}



}//end for

//End Next nextyear//


$CM=date('m');
$CY=date('Y');
//Removing and Computing Next Year
$del = 31 - $CM;
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
generate_Dues($userid,$year,$sedeid);

}





// Dues //

function generate_Dues($userid,$year,$sedeid){
	include('../../incluidos/db_config/config.php');
//	include('./PHPExcel/Classes/PHPExcel.php');
//POR ALGUNA RAZON NO LAS ESTA INCLUYENDO LAS LIBRERIAS EL SCRIPT Y POR ESO EN ALGUNAS FUNCIONES LA VUELVO A LLAMAR PARA QUE FUNCIONE//
//FOR SOME REASON LIBRARIES ARE NOT INCLUDED IN THE SCRIPT AND WE'LL NEED TO RECALL ONCE AGAIN, IN ORDER TO MAKE THE SCRIPT WORKS//
//	include('custom.php');
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
$s="SELECT * FROM grupos WHERE sede_id='$sedeid'";
$r = mysqli_query($con,$s);
while($xrow = mysqli_fetch_array($r)) {
$objPHPExcel->setActiveSheetIndex($xSheet);

$objPHPExcel->getActiveSheet()->setCellValue('D3', $xrow['gru_descripcion']);
$objPHPExcel->getActiveSheet()->setCellValue('D4', get_admin_details($xrow['gru_forum'],'fullname'));
//$objPHPExcel->getActiveSheet()->setCellValue('S3', '1/1/'.$year);
$objPHPExcel->getActiveSheet()->setCellValue('S3', set_report_date($year));
$objPHPExcel->getActiveSheet()->setCellValue('U6', $year+1);
$xgroup=substr($xrow['gru_descripcion'], -7, 0);
$sheetTitle = $xrow['gru_descripcion'];
$array = array("1","2","3","4");
$sql="SELECT miembro.*, miembro_inscripcion.* FROM miembro, miembro_inscripcion WHERE miembro.grupo_id=".$xrow['gru_id']." AND miembro.status_member_id IN (".implode(',', $array).") AND miembro.mie_id = miembro_inscripcion.miembro_id ORDER By miembro.mie_codigo ASC";// AND miembro_inscripcion.mie_ins_year='$year'
$res = mysqli_query($con,$sql);
$rcount = mysqli_num_rows($res);
$i=8;
$CM=date('m'); //Current Month
$CY=date('Y'); //Current Year
/****** BODY ******/
$dues = true; 
while($row = mysqli_fetch_array($res)) {
	
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
$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, get_Monthly_Payment($row['mie_id'],$year));
$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setWrapText(true);
$this_status_member=get_status_info($row['status_member_id']);
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
}else if($this_status_member=='M'){
$color='ffffff';
$g_color='ffff00';
}else if($this_status_member=='MC'){
$color='CCCCCC';
$g_color='CCCCCC';
}else{
$color='CCCCCC';
$g_color='CCCCCC';
}

if (! $dues && $this_status_member != "MS") {
    $color='CCCCCC';
    $g_color='CCCCCC';
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
             'rgb' => $color
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


//Paiting FM //
if(($first_FM_m=='01')&&($first_FM_y==$year)){$x1='H'; $x2='H';    $ins_color=$COLOR1; }else
if(($first_FM_m=='02')&&($first_FM_y==$year)){$x1='H'; $x2='H';    $ins_color=$COLOR1; }else
if(($first_FM_m=='03')&&($first_FM_y==$year)){$x1='H'; $x2='I';    $ins_color=$COLOR1; }else
if(($first_FM_m=='04')&&($first_FM_y==$year)){$x1='H'; $x2='J';    $ins_color=$COLOR1; }else
if(($first_FM_m=='05')&&($first_FM_y==$year)){$x1='H'; $x2='K';    $ins_color=$COLOR1; }else
if(($first_FM_m=='06')&&($first_FM_y==$year)){$x1='H'; $x2='L';    $ins_color=$COLOR1; }else
if(($first_FM_m=='07')&&($first_FM_y==$year)){$x1='H'; $x2='M';    $ins_color=$COLOR1; }else
if(($first_FM_m=='08')&&($first_FM_y==$year)){$x1='H'; $x2='N';    $ins_color=$COLOR1; }else
if(($first_FM_m=='09')&&($first_FM_y==$year)){$x1='H'; $x2='O';    $ins_color=$COLOR1; }else
if(($first_FM_m=='10')&&($first_FM_y==$year)){$x1='H'; $x2='P';    $ins_color=$COLOR1; }else
if(($first_FM_m=='11')&&($first_FM_y==$year)){$x1='H'; $x2='Q';    $ins_color=$COLOR1; }else
if(($first_FM_m=='12')&&($first_FM_y==$year)){$x1='H'; $x2='R';    $ins_color=$COLOR1; }else{$x1='H'; $x2='S';  $ins_color=''; }



if ($dues) {
if($ins_color){
	 $objPHPExcel->getActiveSheet()->getStyle($x1.$i.':'.$x2.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $ins_color
        )
    ));


	 $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $ins_color
        )
    ));
}else{
    if ($this_status_member == "MS") {
        $objPHPExcel->getActiveSheet()->getStyle($x1.$i.':'.$x2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR3
            )
        ));


        $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR3
            )
        ));
    } elseif ($this_status_member == "MC") {
        $objPHPExcel->getActiveSheet()->getStyle($x1.$i.':'.$x2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR1
            )
        ));


        $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR1
            )
        ));
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
    if ($this_status_member != "MS") {
        $objPHPExcel->getActiveSheet()->getStyle($x1.$i.':'.$x2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR1
            )
        ));


        $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
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

        $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR3
            )
        ));
    }
}

//Next Year//

if(($first_FM_m=='01')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='U';  $ins_color2=$COLOR1; }else
if(($first_FM_m=='02')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='U';  $ins_color2=$COLOR1; }else
if(($first_FM_m=='03')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='V';  $ins_color2=$COLOR1; }else
if(($first_FM_m=='04')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='W';  $ins_color2=$COLOR1; }/*else
if(($first_FM_m=='05')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='X';  $ins_color2=$COLOR1; }else
if(($first_FM_m=='06')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='Y';  $ins_color2=$COLOR1; }else
if(($first_FM_m=='07')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='Z';  $ins_color2=$COLOR1; }else
if(($first_FM_m=='08')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='AA'; $ins_color2=$COLOR1; }else
if(($first_FM_m=='09')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='AB'; $ins_color2=$COLOR1; }else
if(($first_FM_m=='10')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='AC'; $ins_color2=$COLOR1; }else
if(($first_FM_m=='11')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='AD'; $ins_color2=$COLOR1; }else
if(($first_FM_m=='12')&&($first_FM_y==$nextyear)){ $xx1='U'; $xx2='AE'; $ins_color2=$COLOR1; }else { $xx1='U'; $xx2='AF'; $ins_color2=''; }*/

	
	if ($dues) {

    
if($ins_color2){
	

	 $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $ins_color2
        )
    ));
}else{
	
	


	 $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $COLOR2
        )
    ));
	
}

} else {
    if ($this_status_member != "MS") {
        $objPHPExcel->getActiveSheet()->getStyle($x1.$i.':'.$x2.$i)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $COLOR1
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle($xx1.$i.':'.$xx2.$i)->getFill()->applyFromArray(array(
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
		
$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, get_paid_month_info($row['mie_id'],'01',$year));
$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, get_paid_month_info($row['mie_id'],'02',$year));
$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, get_paid_month_info($row['mie_id'],'03',$year));
$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, get_paid_month_info($row['mie_id'],'04',$year));
$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, get_paid_month_info($row['mie_id'],'05',$year));
$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, get_paid_month_info($row['mie_id'],'06',$year));
$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, get_paid_month_info($row['mie_id'],'07',$year));
$objPHPExcel->getActiveSheet()->setCellValue('O'.$i, get_paid_month_info($row['mie_id'],'08',$year));
$objPHPExcel->getActiveSheet()->setCellValue('P'.$i, get_paid_month_info($row['mie_id'],'09',$year));
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, get_paid_month_info($row['mie_id'],'10',$year));
$objPHPExcel->getActiveSheet()->setCellValue('R'.$i, get_paid_month_info($row['mie_id'],'11',$year));
$objPHPExcel->getActiveSheet()->setCellValue('S'.$i, get_paid_month_info($row['mie_id'],'12',$year));


//NEXT YEAR//
$objPHPExcel->getActiveSheet()->setCellValue('U'.$i, get_paid_month_info($row['mie_id'],'01',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('V'.$i, get_paid_month_info($row['mie_id'],'02',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('W'.$i, get_paid_month_info($row['mie_id'],'03',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('X'.$i, get_paid_month_info($row['mie_id'],'04',$nextyear));
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
$I = get_paid_month_info($row['mie_id'],'02',$year);
$J = get_paid_month_info($row['mie_id'],'03',$year);
$K = get_paid_month_info($row['mie_id'],'04',$year);
$L = get_paid_month_info($row['mie_id'],'05',$year);
$M = get_paid_month_info($row['mie_id'],'06',$year);
$N = get_paid_month_info($row['mie_id'],'07',$year);
$O = get_paid_month_info($row['mie_id'],'08',$year);
$P = get_paid_month_info($row['mie_id'],'09',$year);
$Q = get_paid_month_info($row['mie_id'],'10',$year);
$R = get_paid_month_info($row['mie_id'],'11',$year);
$S = get_paid_month_info($row['mie_id'],'12',$year);
//NEXT YEAR//
$U = get_paid_month_info($row['mie_id'],'01',$nextyear);
$V = get_paid_month_info($row['mie_id'],'02',$nextyear);
$W = get_paid_month_info($row['mie_id'],'03',$nextyear);
$X = get_paid_month_info($row['mie_id'],'04',$nextyear);
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

$countPayments = countPayments($row['mie_id'],$m,$year,$i);
if($countPayments >= 1){
$objPHPExcel->getActiveSheet()->getComment($cell.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(comment_months_literal($row['mie_id'],$m,$year,$i)); 



$commenting=comment_months($row['mie_id'],$m,$year,$i);
//cellColor($cell.$i, 'ffff00');

$color='ffff00';

//cellColor($cell.$i, $color);
if (strpos($commenting, 'ENERO'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'FEBRERO'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'MARZO'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

if (strpos($commenting, 'ABRIL'.$year) !== false) {
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
if (strpos($commenting, 'OCTUBRE'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'NOVIEMBRE'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('R'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'DICIEMBRE'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'ENERO'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'FEBRERO'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('V'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting, 'MARZO'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

if (strpos($commenting, 'ABRIL'.$nextyear) !== false) {
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
}*/




 
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

$NYcountPayments = countPayments($row['mie_id'],$m,$nextyear,$i);
if($NYcountPayments >= 1 ){

$objPHPExcel->getActiveSheet()->getComment($cell.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(comment_months_literal_nextyear($row['mie_id'],$m,$nextyear,$i)); //substr($members,0,-2);
$commenting_next_year=comment_months($row['mie_id'],$m,$nextyear,$i);
$color='ffff00';

//cellColor($cell.$i, $color);

//Comenting Next Year and Old Year//
if (strpos($commenting_next_year, 'ENERO'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'FEBRERO'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('V'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'MARZO'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

if (strpos($commenting_next_year, 'ABRIL'.$nextyear) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('X'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
/*if (strpos($commenting_next_year, 'MAYO'.$nextyear) !== false) {
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
*/
if (strpos($commenting_next_year, 'ENERO'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'FEBRERO'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )

    ));
}
if (strpos($commenting_next_year, 'MARZO'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

if (strpos($commenting_next_year, 'ABRIL'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
/*
if (strpos($commenting_next_year, 'MAYO'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'JUNIO'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'JULIO'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'AGOSTO'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('O'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'SEPTIEMBRE'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('P'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'OCTUBRE'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'NOVIEMBRE'.$year) !== false) {
    $objPHPExcel->getActiveSheet()->getStyle('R'.$i)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}
if (strpos($commenting_next_year, 'DICIEMBRE'.$year) !== false) {
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
//END//
$objPHPExcel->getActiveSheet()->setCellValue('T'.$i, "=SUM(H".$i.":S".$i.")");
$i++;
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

unset($xSheet);
//$objPHPExcel->removeSheetByIndex(0);
mysqli_close($con);
$callStartTime = microtime(true);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('./reportesgenerados/'.$report_name, __FILE__);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
generate_Summary($userid,$year,$sedeid);
}

function generate_Summary($userid,$year,$sedeid){
	include("../../incluidos/db_config/config.php");

$nextyear = $year + 1;
$country = get_country_by_user($userid);	
$report_country = strtoupper(substr($country,0,2));
$report_name="Summary-".$userid.'.xlsx';
$report_name_for_excel="GROSS REVENUE REPORT FOR: ".get_IBU($userid).' ('.get_admin_details($userid,'fullname').')';

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
$objPHPExcel->getActiveSheet()->setCellValue('P5', set_report_date($year));
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
$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, calculate_summary_value($m,$year,'enrollment'));  //Computing Enrollment Fees
$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, calculate_summary_value($m,$year,'dues'));  //Computing Dues
$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, calculate_summary_value($m,$year,'other'));  //Computing Other Activity
$objPHPExcel->getActiveSheet()->setCellValue('R'.$i, calculate_summary_value($m,$year,'price'));  //Computing Price
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
$objPHPExcel->getActiveSheet()->setCellValue('D'.$n, calculate_summary_value($m2,$nextyear,'enrollment'));  //Computing Enrollment Fees
$objPHPExcel->getActiveSheet()->setCellValue('B'.$n, calculate_summary_value($m2,$nextyear,'dues'));  //Computing Dues
$objPHPExcel->getActiveSheet()->setCellValue('F'.$n, calculate_summary_value($m2,$nextyear,'other'));  //Computing Other Activity
$objPHPExcel->getActiveSheet()->setCellValue('R'.$n, calculate_summary_value($m2,$nextyear,'price'));  //Computing Price

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
$del = (44 - $CM)-3 ;
if($CY==$year){

for($i = 26; $i <= 44; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}

}else{


for($i = $del; $i <=44 ; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}
	


}//end if


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