<?php 
require_once MODELO.'Entity.php';
$data = json_decode(file_get_contents("php://input"));
header("Content-type: application/json"); 
if (isset($data)) {
    try{
	    setDatosConexion('');
                setDatosConexion('bases');

                $response_1= array();               
                $objUsuario= new Entity($response_1);
                $parametros= array($data->token,$data->user);
				$endpoint=$data->type=="M"?'sp_miembroLogin':'sp_staffLogin';
                $resultset= $objUsuario->getSp($endpoint, $parametros, 'rs');

                if(count($resultset['rs']) > 0 ){
					 $response["success"] = "1"; 
					 $response["data"] =$resultset['rs'][0]; 
				     echo json_encode($response); 
                }else{
					 $response["success"] = "0"; 
				     $response["data"] = "Permiso denegado"; 
                     echo json_encode($response); 
                }
                exit();  
     
    } catch (Exception $exc) { echo getError($exc);}  
} else { 
    echo getNull();
}  
exit();