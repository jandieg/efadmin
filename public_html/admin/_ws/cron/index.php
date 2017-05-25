<?php
error_reporting(E_ERROR | E_PARSE);
include_once("../../../incluidos/db_config/config.php");
include_once("generateReports.php");
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//Getting Mandatory Variables: User ID + Year + Sede ID//
$userid=$_GET['userid'];
$year=$_GET['year'];
$sede_id=$_GET['sede_id'];
$email=$_GET['email'];
//Running Report//

generate_enrollment_fees($userid,$year,$sede_id,$email); //This function will run The 1st report//	

?>