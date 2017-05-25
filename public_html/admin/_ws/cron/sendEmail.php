<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
include_once("../../../incluidos/db_config/config.php");
include_once("custom.php");
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require_once '../public/phpmailer/PHPMailerAutoload.php';
require_once '../public/phpmailer/class.phpmailer.php';
require_once '../public/phpmailer/class.smtp.php';



function sendEmail($userid,$email){
//	sleep(10);
$html=false;
$body='Haga click en el siguiente enlace para descargar: <a href="http://executiveforums.la/admin/reportesgenerados/FullReport-'.$userid.'.xlsx" download>Descargar Reporte</a>';
$TO='davidcabreram@gmail.com';
$mail = new PHPMailer();
	        $mail->isSMTP();
			$mail->SMTPDebug = 0;
            $mail->Host='in-v3.mailjet.com';
            $mail->SMTPAuth=true;
         //   $mail->SMTPSecure = 'tls';
            $mail->Port = 80;
	        $mail->Username = '9198ce4c0a23ad0d51628e6f5c62c68d';
	        $mail->Password = '427f36aba4d2bf1e16a0a4e26f49b4a2';
	        $mail->From = 'mail@executiveforums.la'; //correo de tu dominio para que sepa donde debe hacer una pregunta o sepa que es de la empresa
	        $mail->FromName = 'Reporte Generado';
	        $mail->Subject = 'Reporte Del Sistema en fecha: '.date('d-m-Y');
	        $mail->isHTML($html);  
	        $mail->MsgHTML($body);
	       // foreach ($destinatarios as $email => $nombres) {
	        //	$mail->AddAddress($email, $nombres);	
	        //}
	        $mail->AddAddress($TO,"");
                $mail->CharSet = 'UTF-8';
	        if(!$mail->send()){
	          $mensaje = "\n Error al enviar el correo: ".$mail->ErrorInfo;  
	        }else{
	          $mensaje = "\n Correo enviado!";
	        }
			
	//echo $mail;	
}

?>