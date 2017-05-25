<?php
error_reporting(E_ERROR | E_PARSE);

	define('HOST','localhost');
	define('USER','execforum');
	define('PASS','Ex3cF0rumS2017%8');
	define('DB','execforums');
	
	$con = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to Connect to the DB');


?>
