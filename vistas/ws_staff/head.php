<?php 
require_once MODELO.'Entity.php'; 
require_once MODELO.'EntityGrupo.php';
include_once("../../incluidos/db_config/config.php");
		

$data = json_decode(file_get_contents("php://input")); 

if (isset($data)) {
    try{
        switch ($data->KEY):
           
       case 'DETALLE':
                setDatosConexion('');			
				
                //Staff
                $response_1= array();             
                $objMiembro= new Entity($response_1);
                $parametros= array($data->id);
                $resultset= $objMiembro->getSp('sp_appGetStaff', $parametros, 'detalle_staff');
               
                if(count($resultset['detalle_staff']) > 0 ){
					$result["data"]=$resultset['detalle_staff'][0];
                    $result["success"] = "1"; 
                    echo json_encode($result);                          
                }else{
                    $resultset["success"] = "0"; 
                    $resultset["data"] = "No existe Información!"; 
                    echo json_encode($resultset); 
                }

                exit();

                break;

        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
} else { 
    echo getNull();
}  
exit();