<?php
//session_start();
error_reporting(E_ERROR | E_PARSE);
include_once("./db_config/config.php");
$ssl=false; // set the Web connection to true if is using a SSL certificate


function list_countries(){
	
	    $sql = "SELECT * FROM pais";			
		$res = mysqli_query($con,$sql);
		//$row = mysqli_fetch_array($res);
        $response["result"] = array();
		 
if (mysqli_num_rows($res) > 0) {
    while($row = mysqli_fetch_array($res)) {
		     
		     
		    $item = array();
            $item["id"] = $row["pai_id"];
            $item["item_name"] = utf8_decode($row['pai_nombre']);
            // push ordered items into response array 
            array_push($response["result"], $item);
           }	 
} 

$select_status =  json_encode($response);
mysqli_close($con);

return $select_status;

}




?>