<?php 
require_once MODELO.'Entity.php';
$data = json_decode(file_get_contents("php://input")); 

if (isset($data)) {
    try{
        switch ($data->KEY):
		
            case 'ALL':
                setDatosConexion(''); 
                
  				$resultset= array();
                $response_1= array();
                
                $objMiembro= new Entity($response_1);
                $parametros= array( );
                $resultset= $objMiembro->getSp('sp_appGetHobbies', $parametros, 'hobbies');	
                
				if(count($resultset['hobbies']) > 0 ){
					$result["data"]=$resultset['hobbies'];
                    $result["success"] = "1"; 
                    echo json_encode($result); 
                }else{
                    $result["success"] = "2"; 
                    $result["data"] = "No existe Información!"; 
                    echo json_encode($result); 
                }

                 exit();
                
                break; 

case 'MY':
                setDatosConexion(''); 
                
  				$resultset= array();
                $response_1= array();
                
                $objMiembro= new Entity($response_1);
                $parametros= array($data->user );
                $resultset= $objMiembro->getSp('sp_appGetMyHobbies', $parametros, 'myhobbies');	
                
				if(count($resultset['myhobbies']) > 0 ){
					$result["data"]=$resultset['myhobbies'];
                    $result["success"] = "1"; 
                    echo json_encode($result); 
                }else{
                    $result["success"] = "2"; 
                    $result["data"] = "No existe Información!"; 
                    echo json_encode($result); 
                }

                 exit();
                
                break; 

		case 'ADD':
                setDatosConexion(''); 
                
  				$resultset= array();
                $response_1= array();
                
                $objMiembro= new Entity($response_1);
                $parametros= array($data->id,$data->user );
                $resultset= $objMiembro->getSp('sp_appAddHobbie', $parametros, 'myhobbies');	
                
				$result["data"]=$resultset["myhobbies"][0];
                $result["success"] = "1"; 
                echo json_encode($result); 

                 exit();
                
                break; 

		case 'DEL':
                setDatosConexion(''); 
                
  				$resultset= array();
                $response_1= array();
                
                $objMiembro= new Entity($response_1);
                $parametros= array($data->id );
                $resultset= $objMiembro->getSp('sp_appDeleteHobbie', $parametros, 'myhobbies');	
                
				$result["data"]="ok";
                $result["success"] = "1"; 
                echo json_encode($result); 

                 exit();
                
                break; 
       
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
} else { 
    echo getNull();
}  
exit();

