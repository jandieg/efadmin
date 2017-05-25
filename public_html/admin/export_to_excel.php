<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
include_once("../../incluidos/db_config/config.php");
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';
//include_once("./PHPExcel/Classes/PHPExcel.php");

$page = $_REQUEST['page'];


if($page=='export'){

define('DB_HOST','localhost');
	define('DB_USER','execforum');
	define('DB_PASS','Ex3cF0rumS2017%8');
	define('DB_NAME','execforums');

$source = $_REQUEST['source'];
$folder='excel/';
$filename=$source.date('d-m-Y');
$rows='id';
$dbname='prospecto';

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

$setCounter = 0;
$setExcelName = "download_excal_file";
$setSql = "SELECT $rows FROM $dbname";
$setRec = mysql_query($setSql);
$setCounter = mysql_num_fields($setRec);
for ($i = 0; $i < $setCounter; $i++) {
    $setMainHeader .= mysql_field_name($setRec, $i)."\t";
}
while($rec = mysql_fetch_row($setRec))  {
  $rowLine = '';
  foreach($rec as $value)       {
    if(!isset($value) || $value == "")  {
      $value = "\t";
    }   else  {
//It escape all the special charactor, quotes from the data.
      $value = strip_tags(str_replace('"', '""', $value));
      $value = '"' . $value . '"' . "\t";
    }
    $rowLine .= $value;
  }
  $setData .= trim($rowLine)."\n";
}
  $setData = str_replace("\r", "", $setData);
if ($setData == "") {
  $setData = "\nno matching records found\n";
}
$setCounter = mysql_num_fields($setRec);
//This Header is used to make data download instead of display the data
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$setExcelName."_Reoprt.xls");
header("Pragma: no-cache");
header("Expires: 0");
//It will print all the Table row as Excel file row with selected column name as header.
$thedata = ucwords($setMainHeader)."\n".$setData."\n";

  	$fp = fopen($folder.$filename.".xls","wb");
    fwrite($fp,$thedata);
    fclose($fp);
?>

<a class="btn btn-info pull-right"href="./excel/<?php echo $filename.".xls"; ?>" download>  
DESCARGAR
</a>
<?php }else if($page=='exporting'){


// Create new PHPExcel object
//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
//echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
							 
// Add some data, we will use printing features
//echo date('H:i:s') , " Add some data" , EOL;
// Create a first sheet
//echo date('H:i:s') , " Add data" , EOL;
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', "ID");
$objPHPExcel->getActiveSheet()->setCellValue('B1', "NOMBRE");

        if($_REQUEST['source']=='Prospecto'){
		 $sql = "SELECT * FROM prospecto WHERE prosp_esaplicante='0' ORDER By pro_id ASC";	
		}else{
			 $sql = "SELECT * FROM prospecto WHERE prosp_esaplicante='1' ORDER By pro_id ASC";	
		}
       		
		$res = mysqli_query($con,$sql);
		//$row = mysqli_fetch_array($res);
       // $response["result"] = array();
	   

 $n=2;
while($row = mysqli_fetch_array($res)) {
	
	$qwery = "SELECT * FROM persona WHERE per_id=".$row['Persona_per_id']." ORDER By per_id ASC";			
		     $xres = mysqli_query($con,$qwery);
			 $xrow = mysqli_fetch_array($xres);
			 $fullname = $xrow['per_nombre'].' '.$xrow['per_apellido'];
			 
 $objPHPExcel->getActiveSheet()->setCellValue('A'.$n, $row['pro_id']);
 $objPHPExcel->getActiveSheet()->setCellValue('B'.$n, $fullname);
 $n++;
}

// echoing JSON response
//echo json_encode($response);
mysqli_close($con);
/*

for ($i = 1; $i < 200; $i++) {
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, 'Test value');
}

*/


// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
//echo date('H:i:s') , " Set header/footer" , EOL;
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
$objPHPExcel->getActiveSheet()->setTitle('Printing');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
//echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
//echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Save Excel 95 file
//echo date('H:i:s') , " Write to Excel5 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(str_replace('.php', '.xls', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
//echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
//echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Echo memory peak usage
//echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
//echo date('H:i:s') , " Done writing files" , EOL;
//echo 'Files have been created in ' , getcwd() , EOL;
//$output_excel='Files have been created in ' , getcwd() , EOL;
?>

<script>
//alert('<?php echo 'Files have been created in ' , getcwd() , EOL; ?>');
</script>
<a class="btn btn-info pull-right"href="export_to_excel.xls" download>  
DESCARGAR
</a>

<?php }else if($page=='eventReport'){
$month = $_REQUEST['month'];

// Create new PHPExcel object
//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();
// Set document properties
//echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
							 
// Add some data, we will use printing features
//echo date('H:i:s') , " Add some data" , EOL;
// Create a first sheet
//echo date('H:i:s') , " Add data" , EOL;
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', "Forum Leader");
$objPHPExcel->getActiveSheet()->setCellValue('B1', "Nombre del Evento");
$objPHPExcel->getActiveSheet()->setCellValue('C1', "Grupos");
$objPHPExcel->getActiveSheet()->setCellValue('D1', "Ubicacion");
$objPHPExcel->getActiveSheet()->setCellValue('E1', "Fecha Inicio");
$objPHPExcel->getActiveSheet()->setCellValue('F1', "Fecha Fin");
$objPHPExcel->getActiveSheet()->setCellValue('G1', "Casos del Mes");
$objPHPExcel->getActiveSheet()->setCellValue('H1', "Compononente Educacional");
$objPHPExcel->getActiveSheet()->setCellValue('J1', "Mes");

 
$sql = "SELECT * FROM evento WHERE DATE_FORMAT(eve_fecharegistro, '%m')='$month'";	
$res = mysqli_query($con,$sql);
		//$row = mysqli_fetch_array($res);
       // $response["result"] = array();
$n=2;
 
 function search_in_DB($db,$field,$selector,$id){
	         $qwery = "SELECT * FROM $db WHERE $selctor='$id'";			
		     $xres = mysqli_query($con,$qwery);
			 $xrow = mysqli_fetch_array($xres); 
			 $data = $xrow[$field];
			 return $data;
 }
 
 if(mysqli_num_rows($res)<=0){
	   $result_Excel =0;

 }else{
	 
	   $result_Excel =1;

 
while($row = mysqli_fetch_array($res)) {
	
	         $qwery = "SELECT * FROM grupos WHERE gru_id=".$row['eve_mis_grupos']."";			
		     $xres = mysqli_query($con,$qwery);
			 $xrow = mysqli_fetch_array($xres); 
			 
			 $qwery = "SELECT * FROM direccion WHERE dir_id=".$row['direccion_id']."";			
		     $xres = mysqli_query($con,$qwery);
			 $dir = mysqli_fetch_array($xres); 
			 
			 $qwery = "SELECT * FROM evento_empresario_mes WHERE evento_eve_id=".$row['eve_id']."";			
		     $xres = mysqli_query($con,$qwery);
			 $emp = mysqli_fetch_array($xres); 
			 
			 if($emp){
			 //-->
			 $q = "SELECT * FROM miembro WHERE mie_id=".$emp['miembro_mie_id']."";			
		     $x = mysqli_query($con,$q);
			 $miem = mysqli_fetch_array($x);					 
			 //-->
			 $qwery = "SELECT * FROM persona WHERE per_id=".$miem['Persona_per_id']."";			
		     $xres = mysqli_query($con,$qwery);
			 $caso = mysqli_fetch_array($xres);
			 $nombre=$caso['per_nombre'].' '.$caso['per_apellido'];
			 }else{
				$nombre='No aplicable'; 
				 
			 }
			 
if (($timestamp = strtotime($row['eve_fecharegistro'])) !== false)
{
  $php_date = getdate($timestamp);
  // or if you want to output a date in year/month/day format:
  $date = date("m", $timestamp); // see the date manual page for format options    
}
else
{
  $date= 'invalid timestamp!';
}


			 
			 
 $objPHPExcel->getActiveSheet()->setCellValue('A'.$n, $row['eve_responsable']);
 $objPHPExcel->getActiveSheet()->setCellValue('B'.$n, $row['eve_nombre']);
 $objPHPExcel->getActiveSheet()->setCellValue('C'.$n, $xrow['gru_descripcion']);
 $objPHPExcel->getActiveSheet()->setCellValue('D'.$n, $dir['dir_calleprincipal']);
 $objPHPExcel->getActiveSheet()->setCellValue('E'.$n, $row['eve_fechainicio']);
 $objPHPExcel->getActiveSheet()->setCellValue('F'.$n, $row['eve_fechafin']);
 $objPHPExcel->getActiveSheet()->setCellValue('G'.$n, $row['eve_descripcion']);
 //$objPHPExcel->getActiveSheet()->setCellValue('H'.$n, $caso['per_nombre'].' '.$caso['per_apellido']);
  $objPHPExcel->getActiveSheet()->setCellValue('H'.$n, $nombre);
  $objPHPExcel->getActiveSheet()->setCellValue('J'.$n, $date);
  
   
 $n++;
}

 }
// echoing JSON response
//echo json_encode($response);
mysqli_close($con);
/*

for ($i = 1; $i < 200; $i++) {
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, 'Test value');
}

*/


// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
//echo date('H:i:s') , " Set header/footer" , EOL;
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
$objPHPExcel->getActiveSheet()->setTitle('Printing');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file
//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
//echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
//echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Save Excel 95 file
//echo date('H:i:s') , " Write to Excel5 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(str_replace('.php', '.xls', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

//echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
//echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
//echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Echo memory peak usage
//echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
//echo date('H:i:s') , " Done writing files" , EOL;
//echo 'Files have been created in ' , getcwd() , EOL;
//$output_excel='Files have been created in ' , getcwd() , EOL;
?>

<script>
//alert('<?php echo 'Files have been created in ' , getcwd() , EOL; ?>');
</script>
<?php
  
if($result_Excel ==1){
?>
<a class="btn btn-info pull-left bg-green" href="export_to_excel.xls" download>  
DESCARGAR
</a>
<?php
}else{
	
	?>
<div class="external-event bg-red">No se encontraron datos</div>
<p>
<button class="external-event bg-blue" onclick="eventReport();return false;" style="cursor:pointer;">Generar Nuevo</button></p>

    <?php } ?>
    
    
<?php }else if($page=='faReport'){
$month = $_REQUEST['month'];
$report_name='Facilitation Activity -'.$month.'.xlsx';

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
$objPHPExcel = PHPExcel_IOFactory::load("./excels_templates/FA.xlsx");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('C4', date('Y'));
//Consulting DataBase

$array = array("1","3","4");
//$sql = "SELECT * FROM miembro WHERE grupo_id='$group' AND status_member_id IN (".implode(',', $array).")";  AND miembro_inscripcion.mie_ins_year='$year' 
//$sql="SELECT miembro.*, miembro_inscripcion.* FROM miembro, miembro_inscripcion WHERE miembro.grupo_id='$group' AND miembro.status_member_id IN (".implode(',', $array).") AND miembro.mie_id = miembro_inscripcion.miembro_id ";
$sql = "SELECT * FROM evento WHERE DATE_FORMAT(eve_fecharegistro, '%m')='$month'";		
$res = mysqli_query($con,$sql);
$rcount = mysqli_num_rows($res);
$i=7;
$ID=1;
 if(mysqli_num_rows($res)<=0){
	   $result_Excel =0;

 }else{
	 
	   $result_Excel =1;
	   
 }
while($row = mysqli_fetch_array($res)) {
$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$ID);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$row['eve_descripcion']);  //Caso del mes
//$m++;
$ID++;
}//end for

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
$objPHPExcel->getActiveSheet()->setTitle('FacilitationActivity');
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


<?php
if($result_Excel ==1){
?>
<a class="btn btn-info"href="reportesgenerados/<?php echo $report_name; ?>" download>  
DESCARGAR
</a>
<?php
}else{
	
	?>
<div class="external-event bg-red">No se encontraron datos</div>
<p>
<button class="external-event bg-blue" onclick="eventReport();return false;" style="cursor:pointer;">Generar Nuevo</button></p>

    <?php } ?>


<?php }else if($page=='loadforumgroups'){ 
include("../../incluidos/db_config/config.php");

$forum_id=$_REQUEST['forum_id'];

		$sql = "SELECT * FROM usuario WHERE Persona_per_id='$forum_id' OR usu_id='$forum_id' ";	
		$res = mysqli_query($con,$sql);
		$row = mysqli_fetch_array($res);
		$sede_id = $row['usu_id'];



$select_status = "<option value=''> SELECCIONE GRUPO</option>\n";
		$dataset = "SELECT * FROM grupos WHERE gru_forum=".$sede_id." ";	
		$r = mysqli_query($con,$dataset);
while($row2 = mysqli_fetch_array($r)) {
$select_status .= "<option value='".$row2['gru_id']."'";
$select_status .= ">".utf8_encode($row2['gru_descripcion']).''."</option>\n";
} 
echo $select_status;

mysqli_close($con);
?>



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