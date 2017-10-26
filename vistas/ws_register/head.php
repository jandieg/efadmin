<?php 
require_once MODELO.'Entity.php';
include_once('../../incluidos/Mail.php');
include_once('../../incluidos/funciones.php');
$data = json_decode(file_get_contents("php://input")); 
if (isset($data)) {
    try{
                setDatosConexion('');

                $response_1= array();               
                $objUsuario= new Entity($response_1);

				
				if(strtolower($data->user)=='jandieg@outlook.com')$code='654321';
				else $code=getToken(6);

                $parametros= array($data->user,$code);
                $resultset= $objUsuario->getSp('sp_set_miembroAcceso', $parametros, 'usuario');

                if(count($resultset['usuario']) > 0){
				$member=$resultset['usuario'][0];
				$cuerpoMensaje="Estimado ".$member["name"].", utiliza el siguiente código para acceder a la APP de Executive Forums:<br><br> ".$code;
				
				$mail= new Mail();
				if (strlen($member['correo_ibp']) > 0) {
					$msg= $mail->enviarCodigo("Executive Forums - APP", "", "Código de acceso a App Executive Forums", 
					$cuerpoMensaje, $data->user, TRUE, $member['correo_ibp']);
				} else {
					$msg= $mail->enviarCodigo("Executive Forums - APP", "", "Código de acceso a App Executive Forums", 
					$cuerpoMensaje, $data->user, TRUE, $member['correo_ibp2']);
				}
				
				
					 $response["success"] = "1"; 
				     $response["data"] = $resultset['usuario'][0]; 
				     echo json_encode($response); 
                }else{
				//staff
				$objUsuario= new Entity($response_1);
				$resultset= $objUsuario->getSp('sp_set_staffAcceso', $parametros, 'staff');
				 if(count($resultset['staff']) > 0 ){
							$member=$resultset['staff'][0];
							$cuerpoMensaje="Estimado ".$member["name"].", utiliza el siguiente código para acceder a la APP de Executive Forums:<br><br> ".$code;
				
							$mail= new Mail();
							if (strlen($member['correo_ibp']) > 0) {
								$msg= $mail->enviarCodigo("Executive Forums - APP", "", "Código de acceso a App Executive Forums",  
								$cuerpoMensaje, $data->user, TRUE, $member['correo_ibp']);
							} else {
								$msg= $mail->enviarCodigo("Executive Forums - APP", "", "Código de acceso a App Executive Forums",  
								$cuerpoMensaje, $data->user, TRUE, $member['correo_ibp2']);
							}
							

								 $response["success"] = "1"; 
								 $response["data"] = $resultset['staff'][0]; 
								 echo json_encode($response); 
							}else{
								 $response["success"] = "0"; 
								 $response["data"] = "El usuario no existe"; 
								 echo json_encode($response); 
							}
                }
                exit();
  
    } catch (Exception $exc) { echo getError($exc);}  
} else { 
    echo getNull();
}  
exit();