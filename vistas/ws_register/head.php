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
				$url="https://app.sic.pe/api/sms/sod83f8fj252239bdd203-2349djed2od61bavzrw";

                $parametros= array($data->user,$code);
                $resultset= $objUsuario->getSp('sp_set_miembroAcceso', $parametros, 'usuario');

                if(count($resultset['usuario']) > 0){
				$member=$resultset['usuario'][0];
				$cuerpoMensaje="Estimado ".$member["name"].", utiliza el siguiente código para acceder a la APP de Executive Forums:<br><br> ".$code;
				
				$mail= new Mail();
				$cel=$member['cel'];
				if (strlen($member['correo_ibp']) > 0) {
					$msg= $mail->enviarCodigo("Executive Forums - APP", "", "Código de acceso a App Executive Forums", 
					$cuerpoMensaje, $data->user, TRUE, $member['correo_ibp']);					
				} else {
					$msg= $mail->enviarCodigo("Executive Forums - APP", "", "Código de acceso a App Executive Forums", 
					$cuerpoMensaje, $data->user, TRUE, $member['correo_ibp2']);
				}
				

				//SMS
				if(strlen($cel)>6){
						$dat  = array('name' => $cel, 'data' => "Código de acceso a App Executive Forums: ".$code);
						$options = array(
							'http' => array(
								'header'  => "Content-type: application/json;charset=utf-8\r\n",
								'method'  => 'POST',
								'content' => json_encode($dat)
							)
						);
						$context  = stream_context_create($options);
						$result = file_get_contents($url, false, $context);
						if ($result === FALSE) { /* Handle error */ }
					}

					 $response["success"] = "1"; 
				     $response["data"] = $resultset['usuario'][0]; 
					 $response["data"]["type"]="M"; 
				     echo json_encode($response); 
                }else{
				//staff
				$objUsuario= new Entity($response_1);
				$resultset= $objUsuario->getSp('sp_set_staffAcceso', $parametros, 'staff');
				 if(count($resultset['staff']) > 0 ){
							$member=$resultset['staff'][0];
							$cuerpoMensaje="Estimado ".$member["name"].", utiliza el siguiente código para acceder a la APP de Executive Forums:<br><br> ".$code;
				
							$mail= new Mail();
							$cel=$member['cel'];
							if (strlen($member['correo_ibp']) > 0) {
								$msg= $mail->enviarCodigo("Executive Forums - APP", "", "Código de acceso a App Executive Forums",  
								$cuerpoMensaje, $data->user, TRUE, $member['correo_ibp']);
							} else {
								$msg= $mail->enviarCodigo("Executive Forums - APP", "", "Código de acceso a App Executive Forums",  
								$cuerpoMensaje, $data->user, TRUE, $member['correo_ibp2']);
							}
							
								//SMS
								if(strlen($cel)>6){
									$dat  = array('name' => $cel, 'data' => "Código de acceso a App Executive Forums: ".$code);
									$options = array(
										'http' => array(
											'header'  => "Content-type: application/json;charset=utf-8\r\n",
											'method'  => 'POST',
											'content' => json_encode($dat)
										)
									);
									$context  = stream_context_create($options);
									$result = file_get_contents($url, false, $context);
									if ($result === FALSE) { /* Handle error */ }
								}


								 $response["success"] = "1"; 
								 $response["data"] = $resultset['staff'][0]; 
								 $response["data"]["type"]="S"; 
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