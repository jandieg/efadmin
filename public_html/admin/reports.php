<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
include_once("../../incluidos/db_config/config.php");
include_once("custom.php");
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
	ini_set('memory_limit', '3500M'); 
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes

date_default_timezone_set('Europe/London');
/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';
//include_once("./PHPExcel/Classes/PHPExcel.php");

$page = $_REQUEST['page'];


if($page=='enrollment'){
$userid = $_REQUEST['userid'];
$year = $_REQUEST['year'];
$group = $_REQUEST['group'];
$nextyear = $year+1;
$country = get_country_by_user($userid);	


//$report_name='Reporte '.$country.'-'.$group.'-'.'2017.xlsx';
//$report_name_for_excel='Reporte '.$country.'-'.$group.'-'.'2017';
$report_name="EnrollmentFees ".get_IBU($group).'-'.$year.'.xlsx';
$report_name_for_excel=get_IBU($group);

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
$objPHPExcel->getActiveSheet()->setCellValue('N3', "1/1/".$year);
$objPHPExcel->getActiveSheet()->setCellValue('D3', $report_name_for_excel);
$objPHPExcel->getActiveSheet()->setCellValue('A72', $nextyear);
//Consulting DataBase
for ($i = 1; $i <= 12; $i++) {
$sql = "SELECT * FROM miembro_inscripcion WHERE MONTH(mie_ins_fecharegistro)='$i' AND mie_ins_year='$year'";	
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
$sql_date = strtotime($row['mie_ins_fecharegistro']);
//Getting custom values from timestamp in executiveforums db//
$this_month =  date('m', $sql_date);
//End Getting time and date//
if(($this_month=='01')||($this_month=='05')||($this_month=='09')){
 $objPHPExcel->getActiveSheet()->setCellValue('A'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('B'.$n, convert_datetime($row['mie_ins_fecha_cobro']));
 $objPHPExcel->getActiveSheet()->setCellValue('C'.$n, $row['mie_ins_valor']);
	}
if(($this_month=='02')||($this_month=='06')||($this_month=='10')){
 $objPHPExcel->getActiveSheet()->setCellValue('E'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('F'.$n, convert_datetime($row['mie_ins_fecha_cobro']));
 $objPHPExcel->getActiveSheet()->setCellValue('G'.$n, $row['mie_ins_valor']);
	}
if(($this_month=='03')||($this_month=='07')||($this_month=='11')){
 $objPHPExcel->getActiveSheet()->setCellValue('I'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('J'.$n, convert_datetime($row['mie_ins_fecha_cobro']));
 $objPHPExcel->getActiveSheet()->setCellValue('K'.$n, $row['mie_ins_valor']);
	}
if($this_month=='04'){
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, convert_datetime($row['mie_ins_fecha_cobro']));
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$n, $row['mie_ins_valor']);
	}
if($this_month=='08'){
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, convert_datetime($row['mie_ins_fecha_cobro']));
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$n, $row['mie_ins_valor']);
	}
if($this_month=='12'){
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, convert_datetime($row['mie_ins_fecha_cobro']));
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$n, $row['mie_ins_valor']);
	}

$n++;
}//end loop

}//end for


//Computing Next Year//

for ($i = 1; $i <= 12; $i++) {
$sql = "SELECT * FROM miembro_inscripcion WHERE MONTH(mie_ins_fecharegistro)='$i' AND mie_ins_year='$nextyear'";	
$res = mysqli_query($con,$sql);
//$row = mysqli_fetch_array($res);
//$response["result"] = array();
if(($i=='01')||($i=='02')||($i=='03')||($i=='04')){
$n=77;
$limit=8;
}
if(($i=='05')||($i=='06')||($i=='07')||($i=='08')){
$n=98;
$limit=8;
}
if(($i=='09')||($i=='10')||($i=='11')||($i=='12')){
$n=119;
$limit=8;
}

if(mysqli_num_rows($res)){
	
}else{
	
}

while($row = mysqli_fetch_array($res)) {
$sql_date = strtotime($row['mie_ins_fecharegistro']);
//Getting custom values from timestamp in executiveforums db//
$this_month =  date('m', $sql_date);
//End Getting time and date//
if(($this_month=='01')||($this_month=='05')||($this_month=='09')){
 $objPHPExcel->getActiveSheet()->setCellValue('A'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('B'.$n, convert_datetime($row['mie_ins_fecha_cobro']));
 $objPHPExcel->getActiveSheet()->setCellValue('C'.$n, $row['mie_ins_valor']);
	}
if(($this_month=='02')||($this_month=='06')||($this_month=='10')){
 $objPHPExcel->getActiveSheet()->setCellValue('E'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('F'.$n, convert_datetime($row['mie_ins_fecha_cobro']));
 $objPHPExcel->getActiveSheet()->setCellValue('G'.$n, $row['mie_ins_valor']);
	}
if(($this_month=='03')||($this_month=='07')||($this_month=='11')){
 $objPHPExcel->getActiveSheet()->setCellValue('I'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('J'.$n, convert_datetime($row['mie_ins_fecha_cobro']));
 $objPHPExcel->getActiveSheet()->setCellValue('K'.$n, $row['mie_ins_valor']);
	}
if($this_month=='04'){
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, convert_datetime($row['mie_ins_fecha_cobro']));
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$n, $row['mie_ins_valor']);
	}
if($this_month=='08'){
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, convert_datetime($row['mie_ins_fecha_cobro']));
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$n, $row['mie_ins_valor']);
	}
if($this_month=='12'){
 $objPHPExcel->getActiveSheet()->setCellValue('M'.$n, get_user_details($row['miembro_id'],'member_code'));
 $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, convert_datetime($row['mie_ins_fecha_cobro']));
 $objPHPExcel->getActiveSheet()->setCellValue('O'.$n, $row['mie_ins_valor']);
	}

$n++;
}//end loop

}//end for
//End Next Year//



$CM=date('m');
$CY=date('Y');
//Removing and Computing Next Year
$del = 135 - ($CM * 4);
if($CY==$year){

for($i = 72; $i <= 135; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}



}else{

if($year < '2016'){
	//do nothing
}else{
for($i = $del; $i <=135 ; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}
	
}

}//end if

mysqli_close($con);

$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPlease treat this document as confidential!');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
// Add a drawing to the header
//echo date('H:i:s') , " Add a drawing to the header" , EOL;
$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
$objDrawing->setName('PHPExcel logo');
$objDrawing->setPath('./images/phpexcel_logo.gif');
$objDrawing->setHeight(36);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);
// Set page orientation and size
//echo date('H:i:s') , " Set page orientation and size" , EOL;
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// Rename worksheet
//echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('EnrollmentFees');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($report_name);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
$callStartTime = microtime(true);
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('reportesgenerados/'.$report_name, __FILE__);
//$objWriter->save(str_replace(__FILE__,'/reportesgenerados/'.$report_name,__FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
?>

<a class="btn btn-info"href="reportesgenerados/<?php echo $report_name; ?>" download>  
DESCARGAR
</a>


<?php }else if($page=='memberships'){
$userid = $_REQUEST['userid'];
$year = $_REQUEST['year'];
$group = $_REQUEST['group'];
$nextyear=$year+1;
$country = get_country_by_user($userid);	
$report_country = strtoupper(substr($country,0,2));
//$report_name='Reporte '.$country.'-'.$group.'-'.'2017.xlsx';
//$report_name_for_excel='Membership Report - '.$country.'-'.$group.'-'.'2017';
$report_name="Memberships -".get_IBU($group).'-'.$year.'.xlsx';
$report_name_for_excel=get_IBU($group);
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
$del = 32 - $CM;
if($CY==$year){

for($i = 21; $i <= 33; $i++) {
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
// Add a drawing to the header
//echo date('H:i:s') , " Add a drawing to the header" , EOL;
$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
$objDrawing->setName('PHPExcel logo');
$objDrawing->setPath('./images/phpexcel_logo.gif');
$objDrawing->setHeight(36);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);
// Set page orientation and size
//echo date('H:i:s') , " Set page orientation and size" , EOL;
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// Rename worksheet
//echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Memberships');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($report_name);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
$callStartTime = microtime(true);

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('reportesgenerados/'.$report_name, __FILE__);
//$objWriter->save(str_replace(__FILE__,'/reportesgenerados/'.$report_name,__FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
?>
<a class="btn btn-info"href="reportesgenerados/<?php echo $report_name; ?>" download>  
DESCARGAR
</a>


<?php }else if($page=='dues'){
$userid = $_REQUEST['userid'];
$year = $_REQUEST['year'];
$nextyear=$year + 1;
$group = $_REQUEST['group'];

$country = get_country_by_user($userid);	
$report_country = strtoupper(substr($country,0,2));
$report_name="Dues-".$year.'.xlsx';

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
$s="SELECT * FROM grupos WHERE gru_id_usuario='$userid'";
$r = mysqli_query($con,$s);
$SHEETS_COUNT = mysqli_num_rows($r);
$print1 = 'Hojas: '.$SHEETS_COUNT;
//echo '<script>$("#dues").html("'.$print1.'");</scrip>';

while($xrow = mysqli_fetch_array($r)) {
$objPHPExcel->setActiveSheetIndex($xSheet);
//echo 'Procesando: '.$xSheet.'/'.$SHEETS_COUNT;	
$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_sqlite;
PHPExcel_Settings::setCacheStorageMethod($cacheMethod); 

$report_name_for_excel=get_IBU($xrow['gru_id']);
$objPHPExcel->getActiveSheet()->setCellValue('D3', $report_name_for_excel);
$objPHPExcel->getActiveSheet()->setCellValue('D4', get_forumleader($xrow['gru_id']));
$objPHPExcel->getActiveSheet()->setCellValue('S3', '1/1/'.$year);
$objPHPExcel->getActiveSheet()->setCellValue('U6', $year+1);	
$sheetTitle = $xrow['gru_descripcion'];
$array = array("1","3","4");
$sql="SELECT miembro.*, miembro_inscripcion.* FROM miembro, miembro_inscripcion WHERE miembro.grupo_id=".$xrow['gru_id']." AND miembro.status_member_id IN (".implode(',', $array).") AND miembro.mie_id = miembro_inscripcion.miembro_id";
$res = mysqli_query($con,$sql);
$rcount = mysqli_num_rows($res);
$i=8;
$CM=date('m'); //Current Month
$CY=date('Y'); //Current Year
/****** BODY ******/
while($row = mysqli_fetch_array($res)) {
	
cellColor('H'.$i.':'.'S'.$i, 'CCCCCC');
cellColor('U'.$i.':'.'Z'.$i, 'CCCCCC');
cellColor('AA'.$i.':'.'AF'.$i, 'CCCCCC');
		
		
$codigo_usuario = $row['mie_codigo'];
 
list($c1, $c2, $c3, $c4) = split('[/.-]', $codigo_usuario);
  $cod1 = $c1;
  $cod2 =$c2;
  $cod3 =$c3;
  $cod4 =$c4;

$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $cod3);
$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $cod4);
$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, get_details_by_user($row['Persona_per_id']));
$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, getInscription_info($row['mie_id'],'cob'));
$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, getInscription_info($row['mie_id'],'ins'));
$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setWrapText(true);
//Computing Dues//
$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, get_Monthly_Payment($row['mie_id'],$year));
$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setWrapText(true);
$this_status_member=get_status_info($row['status_member_id']);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $this_status_member);
if($this_status_member=='SC'){
$color='ffff00';
}else
if($this_status_member=='MS'){
$color='006600';
cellColor('H'.$i.':'.'S'.$i, $color);
cellColor('U'.$i.':'.'Z'.$i, $color);
cellColor('AA'.$i.':'.'AF'.$i, $color);
}else
if($this_status_member=='M'){
$color='ffff00';
}else{
$color='CCCCCC';
}
//cellColor('H'.$i.':'.'S'.$i, $color);
cellColor('G'.$i, $color);

//Formating Cells for current year//
cellBorder('A'.$i, "all");
cellBorder('B'.$i, "all");
cellBorder('C'.$i, "all");
cellBorder('D'.$i, "all");
cellBorder('E'.$i, "all");
cellBorder('F'.$i, "all");
cellBorder('G'.$i, "all");
cellBorder('H'.$i, "all");
cellBorder('I'.$i, "all");
cellBorder('J'.$i, "all");
cellBorder('K'.$i, "all");
cellBorder('L'.$i, "all");
cellBorder('M'.$i, "all");
cellBorder('N'.$i, "all");
cellBorder('O'.$i, "all");
cellBorder('P'.$i, "all");
cellBorder('Q'.$i, "all");
cellBorder('R'.$i, "all");
cellBorder('S'.$i, "all");
cellBorder('T'.$i, "all");
cellBorder('U'.$i, "all");
cellBorder('V'.$i, "all");
cellBorder('W'.$i, "all");
cellBorder('X'.$i, "all");
cellBorder('Y'.$i, "all");
cellBorder('Z'.$i, "all");
cellBorder('AA'.$i, "all");
cellBorder('AB'.$i, "all");
cellBorder('AC'.$i, "all");
cellBorder('AD'.$i, "all");
cellBorder('AE'.$i, "all");
cellBorder('AF'.$i, "all");
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
$objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, get_paid_month_info($row['mie_id'],'05',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, get_paid_month_info($row['mie_id'],'06',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('AA'.$i, get_paid_month_info($row['mie_id'],'07',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('AB'.$i, get_paid_month_info($row['mie_id'],'08',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('AC'.$i, get_paid_month_info($row['mie_id'],'09',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('AD'.$i, get_paid_month_info($row['mie_id'],'10',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('AE'.$i, get_paid_month_info($row['mie_id'],'11',$nextyear));
$objPHPExcel->getActiveSheet()->setCellValue('AF'.$i, get_paid_month_info($row['mie_id'],'12',$nextyear));
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
$Y = get_paid_month_info($row['mie_id'],'05',$nextyear);
$Z = get_paid_month_info($row['mie_id'],'06',$nextyear);
$AA = get_paid_month_info($row['mie_id'],'07',$nextyear);
$AB = get_paid_month_info($row['mie_id'],'08',$nextyear);
$AC = get_paid_month_info($row['mie_id'],'09',$nextyear);
$AD = get_paid_month_info($row['mie_id'],'10',$nextyear);
$AE = get_paid_month_info($row['mie_id'],'11',$nextyear);
$AF = get_paid_month_info($row['mie_id'],'12',$nextyear);


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
$objPHPExcel->getActiveSheet()->getComment($cell.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(comment_months($row['mie_id'],$m,$year,$i)); 
//cellColor($cell.$i, 'ffff00');
if($this_status_member == 'MC'){
$color='CCCCCC';
}else{
$color='ffff00';
}
cellColor($cell.$i, $color);
	}
//NEXT YEAR//

$marker2=detectPayment($row['mie_id'],$m,$nextyear,$i);
if($marker2==1){ $cell='U'; }
if($marker2==2){ $cell='V'; }
if($marker2==3){ $cell='W'; }
if($marker2==4){ $cell='X'; }
if($marker2==5){ $cell='Y'; }
if($marker2==6){ $cell='Z'; }
if($marker2==7){ $cell='AA'; }
if($marker2==8){ $cell='AB'; }
if($marker2==9){ $cell='AC'; }
if($marker2==10){ $cell='AD'; }
if($marker2==11){ $cell='AE'; }
if($marker2==12){ $cell='AF'; }


$NYcountPayments = countPayments($row['mie_id'],$m,$nextyear,$i);
if($NYcountPayments >= 1){
$objPHPExcel->getActiveSheet()->getComment($cell.$i)->setHeight("50px")->setWidth("250px")->getText()->createTextRun(comment_months($row['mie_id'],$m,$nextyear,$i)); 
//cellColor($cell.$i, 'ffff00');
if($this_status_member == 'MC'){
$color='CCCCCC';
}else{
$color='ffff00';
}
cellColor($cell.$i, $color);
}




	
	
	
}//end for
//END//
$objPHPExcel->getActiveSheet()->setCellValue('T'.$i, "=SUM(H".$i.":S".$i.")");
$i++;
}//end loop
$final_count=$rcount+9;
$objPHPExcel->getActiveSheet()->getColumnDimension('G'.$final_count)->setWidth(50)->setAutoSize(false);
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
$objPHPExcel->getActiveSheet()->setCellValue('Y'.$final_count, "=SUM(Y8:Y".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('Z'.$final_count, "=SUM(Z8:Z".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('AA'.$final_count, "=SUM(AA8:AA".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('AB'.$final_count, "=SUM(AB8:AB".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('AC'.$final_count, "=SUM(AC8:AC".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('AD'.$final_count, "=SUM(AD8:AD".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('AE'.$final_count, "=SUM(AE8:AE".($final_count-2).")");
$objPHPExcel->getActiveSheet()->setCellValue('AF'.$final_count, "=SUM(AF8:AF".($final_count-2).")");

cellBorder('H'.$final_count, "all");
cellBorder('I'.$final_count, "all");
cellBorder('J'.$final_count, "all");
cellBorder('K'.$final_count, "all");
cellBorder('L'.$final_count, "all");
cellBorder('M'.$final_count, "all");
cellBorder('N'.$final_count, "all");
cellBorder('O'.$final_count, "all");
cellBorder('P'.$final_count, "all");
cellBorder('Q'.$final_count, "all");
cellBorder('R'.$final_count, "all");
cellBorder('S'.$final_count, "all");
cellBorder('T'.$final_count, "all");
cellBorder('U'.$final_count, "all");
cellBorder('V'.$final_count, "all");
cellBorder('W'.$final_count, "all");
cellBorder('X'.$final_count, "all");
cellBorder('Y'.$final_count, "all");
cellBorder('Z'.$final_count, "all");
cellBorder('AA'.$final_count, "all");
cellBorder('AB'.$final_count, "all");
cellBorder('AC'.$final_count, "all");
cellBorder('AD'.$final_count, "all");
cellBorder('AE'.$final_count, "all");
cellBorder('AF'.$final_count, "all");

//Removing and Computing Next Year
$CNAMES='U,V,W,X,Y,Z,AA,AB,AC,AD,AE,AF';
$del = 12 - $CM;
if($CY==$year){
$objPHPExcel->getActiveSheet()->removeColumn('AF', 12);
$objPHPExcel->getActiveSheet()->setCellValue('U6', " ");
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
$objPHPExcel->getActiveSheet()->setTitle("$sheetTitle");
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex($xSheet);
$xSheet++;
}

unset($xSheet);

//$objPHPExcel->removeSheetByIndex(0);
mysqli_close($con);
$callStartTime = microtime(true);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('reportesgenerados/'.$report_name, __FILE__);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
?>
<a class="btn btn-info"href="reportesgenerados/<?php echo $report_name; ?>" download>  
DESCARGAR
</a>

<?php }else if($page=='summary'){
$userid = $_REQUEST['userid'];
$year = $_REQUEST['year'];
$group = $_REQUEST['group'];
$sede_id = $_SESSION['sede_id'];
$nextyear = $year + 1;
$country = get_country_by_user($userid);	
$report_country = strtoupper(substr($country,0,2));
//$report_name='Reporte Summary '.$country.'-'.$group.'-'.'2017.xlsx';
//$report_name_for_excel='GROSS REVENUE REPORT FOR:  '.$country.'-'.$group.' '.get_forumleader($userid);
$report_name="Summary - ".get_IBU($group).'-'.$year.'.xlsx';
$report_name_for_excel="GROSS REVENUE REPORT FOR: ".get_IBU($group).' ('.$_SESSION['user_name'].')';

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
$objPHPExcel->getActiveSheet()->setCellValue('E5', get_IBU($group));
$objPHPExcel->getActiveSheet()->setCellValue('P5', "1/1/".$year);
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
$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, calculate_summary_value($m,$year,'enrollment'));  //Computing Enrollment Fees
$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, calculate_summary_value($m,$year,'dues'));  //Computing Dues
$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, calculate_summary_value($m,$year,'other'));  //Computing Other Activity
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
$m2++;

}//end for 2



$c=50;
$sql = "SELECT * FROM grupos WHERE gru_id_usuario='$userid' AND sede_id='$sede_id'";	
$res = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($res)){
	
$objPHPExcel->getActiveSheet()->setCellValue('A'.$c, $row['gru_descripcion']);
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
$del = 42 - $CM;
if($CY==$year){

for($i = 26; $i <= 43; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}

}else{

if($year < '2016'){
	//do nothing
}else{
for($i = $del; $i <=43 ; $i++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setVisible(FALSE);
}
	
}

}//end if


mysqli_close($con);

$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPlease treat this document as confidential!');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
// Add a drawing to the header
//echo date('H:i:s') , " Add a drawing to the header" , EOL;
$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
$objDrawing->setName('PHPExcel logo');
$objDrawing->setPath('./images/phpexcel_logo.gif');
$objDrawing->setHeight(36);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_LEFT);
// Set page orientation and size
//echo date('H:i:s') , " Set page orientation and size" , EOL;
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// Rename worksheet
//echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle($page);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($report_name);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
$callStartTime = microtime(true);

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('reportesgenerados/'.$report_name, __FILE__);
//$objWriter->save(str_replace(__FILE__,'/reportesgenerados/'.$report_name,__FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
?>

<a class="btn btn-info"href="reportesgenerados/<?php echo $report_name; ?>" download>  
DESCARGAR
</a>
<?php }else if($page=='ActivityReport'){
	
$userid = $_REQUEST['userid'];
$year = $_REQUEST['year'];
$group = $_REQUEST['group'];
$sede_id=$_SESSION['sede_id'];

$country = get_country_by_user($userid);	
$report_country = strtoupper(substr($country,0,2));
//$report_name='Reporte Summary '.$country.'-'.$group.'-'.'2017.xlsx';
//$report_name_for_excel='GROSS REVENUE REPORT FOR:  '.$country.'-'.$group.' '.get_forumleader($userid);
$report_name="Activity Report - ".get_IBU($group).'-'.$year.'.xlsx';

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
$objPHPExcel = PHPExcel_IOFactory::load("./excels_templates/ActivityReport.xlsx");

//Consulting DataBase
//Getting MEmber status count
//Status codes Enrollment1 = 5 : Enrollment2 = 6 : PreIMI= 7 : PostIMI=8


for ($i = 0; $i <= 11; $i++) {
$objPHPExcel->setActiveSheetIndex($i);
$objPHPExcel->getActiveSheet()->setCellValue('C5', calculate_status_total($i,'imi',$year,$userid));
$objPHPExcel->getActiveSheet()->setCellValue('C6', calculate_status_total($i,'en2',$year,$userid));
$array = array("1","2","3");
if($i==0){ $month='01'; }
if($i==1){ $month='02'; }
if($i==2){ $month='03'; }
if($i==3){ $month='04'; }
if($i==4){ $month='05'; }
if($i==5){ $month='06'; }
if($i==6){ $month='07'; }
if($i==7){ $month='08'; }
if($i==8){ $month='09'; }
if($i==9){ $month='10'; }
if($i==10){ $month='11'; }
if($i==11){ $month='12'; }
$sql = "SELECT * FROM prospecto WHERE estadoprospecto_estpro_id IN (".implode(',', $array).") AND MONTH(prosp_fechamodificacion)='$month' AND YEAR(prosp_fechamodificacion)='$year'";	
$res = mysqli_query($con,$sql);
$c=11;
while($row = mysqli_fetch_array($res)){
	
$objPHPExcel->getActiveSheet()->setCellValue('B'.$c, get_details_by_user($row['Persona_per_id']));
$objPHPExcel->getActiveSheet()->setCellValue('C'.$c, get_company_details_by_user($row['empresalocal_emp_id']));
$objPHPExcel->getActiveSheet()->setCellValue('D'.$c, get_status_details_by_user($row['estadoprospecto_estpro_id']));



$c++;
  }//end while
  
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPlease treat this document as confidential!');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
// Set page orientation and size
//echo date('H:i:s') , " Set page orientation and size" , EOL;
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
// Rename worksheet
//echo date('H:i:s') , " Rename worksheet" , EOL;
//$objPHPExcel->getActiveSheet()->setTitle($page);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex($i);

}//end for



mysqli_close($con);


// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($report_name);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
$callStartTime = microtime(true);

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('reportesgenerados/'.$report_name, __FILE__);
//$objWriter->save(str_replace(__FILE__,'/reportesgenerados/'.$report_name,__FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
?>


<a class="btn btn-info"href="reportesgenerados/<?php echo $report_name; ?>" download>  
DESCARGAR
</a>


<?php }else if($page=='ResetReports'){ 

$report = $_REQUEST['id'];
$user_id = $_SESSION['user_id_ben'];
?>

<?php if($report==1){ ?>
  <div class="col-6 col-md-6" id="fullReport"><a class="btn btn-info" onClick=do_report("fullReport","<?php echo $user_id; ?>"); style="cursor:pointer;">  
GENERAR REPORTE COMPLETO
</a> </div>
    <div class="col-6 col-md-6" ><a class="btn btn-info" onClick=do_report("ActivityReport","<?php echo $user_id; ?>"); style="cursor:pointer;" id="ActivityReport">  
GENERAR REPORTE DE ACTIVIDAD
</a></div>
<?php } ?>

<?php if($report==2){ ?>

<?php } ?>


<?php }else if($page=='fullReport'){ 
$userid = $_REQUEST['userid'];
$year = $_REQUEST['year'];
$group = $_REQUEST['group'];
$sede_id=$_SESSION['sede_id'];
$email=$_SESSION['user_correo'];

$corte = $_REQUEST['fechacorte'];


//exec("php /public_html/admin/cron/sendEmail.php");
/*
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://www.executiveforums.la/admin/cron/index.php?task=fullreport&userid=$userid&year=$year&sede_id=$sede_id");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);
//echo "<pre>$output</pre>";
*/

$x=escapeshellarg($userid);

exec("nohup /usr/bin/php -f generateReports.php userid='$userid' year='$year' sede_id='$sede_id' email='$email' corte='$corte'> /dev/null 2>&1 &");
?>

<script>
alert('Reporte en progreso, recibira un email cuando el reporte se haya finalizado');
</script>

<a class="btn btn-danger">  
<i class="fa fa-clock-o" aria-hidden="true"></i>
REPORTE EN PROGRESO!
</a>


<?php
}else {
?>
			<div id="error_alert" align="left">
			ERROR IN FORM<br />
			<br />
</div>
<?php
}
?>