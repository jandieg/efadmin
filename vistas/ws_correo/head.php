<?php 
require_once MODELO.'Entity.php';
require_once E_LIB.'Mail.php';
$data = json_decode(file_get_contents("php://input")); 
if (isset($data)) {
    try{
        switch ($data->KEY):
            case 'KEY_ENVIAR_CORREO':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
				$mail= new Mail();
                $msg= $mail->enviar($data->_full_name,$data->_correo, $data->_asunto, $data->_mensaje, $data->_correo_receptor, FALSE); 

               // if(count($resultset['aplicante']) > 0 ){
                    $resultset["success"] = "1"; 
					$resultset["msg"] = $msg; 
                    echo json_encode($resultset); 
					exit();
              /*  }else{
                    $resultset["success"] = "2"; 
                    $resultset["msg"] = "No existe Información!"; 
                    echo json_encode($resultset); 
                }*/
                break; 
        endswitch; 
        exit();
    } catch (Exception $exc) { echo getError($exc);}  
} else { 
    echo getNull();
}  
exit();
