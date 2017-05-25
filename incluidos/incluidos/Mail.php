<?php
require_once 'public/phpmailer/PHPMailerAutoload.php';
require_once 'public/phpmailer/class.phpmailer.php';
require_once 'public/phpmailer/class.smtp.php';

class Mail {

	static function enviar($nombreEmisor="", $correoEmisor="", $asunto="",  $cuerpoMensaje="",  $correoReceptor, $html= FALSE){
                $settings = parse_ini_file(E_LIB."settings.ini.php");  
                $mensaje = "";
				$firma="<br><br>Saludos cordiales,<br>El Staff de Executive Forums<br>http://executiveforums.la";
		try{
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
	        $mail->FromName = $nombreEmisor;
	        $mail->Subject = $asunto;
	        $mail->isHTML($html);  
	        $mail->MsgHTML($cuerpoMensaje.$firma);
	       // foreach ($destinatarios as $email => $nombres) {
	        //	$mail->AddAddress($email, $nombres);	
	        //}
	        $mail->AddAddress($correoReceptor,"");
                $mail->CharSet = 'UTF-8';
	        if(!$mail->send()){
	          $mensaje = "\n Error al enviar el correo: ".$mail->ErrorInfo;  
	        }else{
	          $mensaje = "\n Correo enviado!";
	        }
		}catch(Exception $e){
			$mensaje = "\n ".$e->getMessage();
		}
		return $mensaje;
	}
        
        static function enviarMultiple($nombreEmisor="", $correoEmisor="", $asunto="",$cuerpoMensaje="",$html=false, $destinatarios=array()){
		$settings = parse_ini_file(E_LIB."settings.ini.php");  
                $mensaje = "";
				$firma="<br><br>Saludos cordiales,<br>El Staff de Executive Forums<br>http://executiveforums.la";
		try{
			
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
	        $mail->FromName = $nombreEmisor;
	        $mail->Subject = $asunto;
	        $mail->isHTML($html);  
	        $mail->MsgHTML($cuerpoMensaje.$firma);
			


	        foreach ($destinatarios as $email ) {
	        	$mail->AddAddress($email, "");		
	        }
                $mail->CharSet = 'UTF-8';
	        
	        if(!$mail->send()){
	          $mensaje .= "\n Error al enviar el correo: ".$mail->ErrorInfo;  
	        }else{
	          $mensaje .= "\n Correos enviados!";
	        }
		}catch(Exception $e){
			$mensaje .= "\n ".$e->getMessage();
		}
		return $mensaje;
	}

}