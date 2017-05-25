<?php 
require_once MODELO.'Entity.php';
$data = json_decode(file_get_contents("php://input")); 

if (isset($data)) {
    try{
        switch ($data->KEY):
		
            case 'KEY_SELECT_GRUPO_MIEMBROS':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases'); 
                
  		$resultset= array();
                $response_1= array();
                
                $objGrupoMiembro= new Entity($response_1);
                $parametros= array( $data->_id );
                $resultset= $objGrupoMiembro->getSp('sp_appSelectSmMiembrosxGrupo', $parametros, 'grupo_miembros');	
                if(count($resultset['grupo_miembros']) > 0 ){
                    $resultset["success"] = "1"; 
                    echo json_encode($resultset); 
                }else{
                    $resultset["success"] = "2"; 
                    $resultset["msg"] = "No existe Información!"; 
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

