<?php
require_once('PHPMailerAutoload.php');
require_once('class.phpmailer.php');
require_once('class.smtp.php');

 
class correo22 {

	static function enviar($from="",$fromName="", $cuerpoMensaje="", $titulo="", $html=false, $destinatarios){
		$mensaje = "";
		try{
		$mail = new PHPMailer();
	        $mail->isSMTP();
	        $mail->SMTPDebug = 0; // No debug
	        $mail->SMTPAuth = true;
	        $mail->SMTPSecure = "ssl";
	        $mail->Host = 'smtp.gmail.com'; //aqui va el Outgoing Server de tu sitio
	        $mail->Port = 465;
	        $mail->Username = 'bgauria316@gmail.com'; //usuario con el que ingresas al cpanel ingresas al cpanel 
	        $mail->Password = ''; //contrase���a con la que inicias el cpanel
	        $mail->From = $from; //correo de tu dominio para que sepa donde debe hacer una pregunta o sepa que es de la empresa
	        $mail->FromName = $fromName;
	        $mail->Subject = $titulo;
	        $mail->isHTML($html);  
	        $mail->MsgHTML($cuerpoMensaje);
	       // foreach ($destinatarios as $email => $nombres) {
	        //	$mail->AddAddress($email, $nombres);	
	        //}
	        $mail->AddAddress($destinatarios,"");
	        if(!$mail->send()){
	          $mensaje .= "\n Error al enviar el correo: ".$mail->ErrorInfo;  
	        }else{
	          $mensaje .= "\n Correo enviado!";
	        }
		}catch(Exception $e){
			$mensaje .= "\n ".$e->getMessage();
		}
		return $mensaje;
	}
}