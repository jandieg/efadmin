<?php 
require_once MODELO.'Entity.php';
$data = json_decode(file_get_contents("php://input")); 


if (isset($data)) {
    try{
        switch ($data->KEY):
            case 'KEY_LISTA':
                setDatosConexion(''); 
                
                $response_1= array();
                $objEmpresaLocal= new Entity($response_1);
                if($data->_permiso == $perVerTodosEmpresasOp8 ){
                    $parametros= array('','','', $data->_min, $data->_max );
                    $resultset= $objEmpresaLocal->getSp('sp_appSelectEmpresaLocalFiltros', $parametros, 'empresas');
                }elseif ($data->_permiso == $perVerEmpresasIDForumOp8) {
                    $parametros= array('','',$data->_id , $data->_min, $data->_max );
                    $resultset= $objEmpresaLocal->getSp('sp_appSelectEmpresaLocalFiltros', $parametros, 'empresas');   
                }
           
                if(count($resultset['empresas']) > 0 ){
                    $resultset["success"] = "1"; 
                    echo json_encode($resultset); 
                }else{
                    $resultset["success"] = "2"; 
                    $resultset["msg"] = "No existe Información!"; 
                    echo json_encode($resultset); 
                }
                 exit();
                
                break; 
		case 'BUSCAR':
                setDatosConexion(''); 
				$txtBuscar='';
				if($data->filter != ''){
					$txtBuscar= $data->filter;
				}
                
                $response_1= array();
                $objEmpresaLocal= new Entity($response_1);
              

                    $parametros= array($txtBuscar,'',$data->_min, $data->_max, $data->pais);
                    $resultset= $objEmpresaLocal->getSp('sp_appSelectEmpresaLocalBuscar', $parametros, 'empresas');
      

                if(count($resultset['empresas']) > 0 ){
					$result["data"]=$resultset['empresas'];
                    $result["success"] = "1"; 
                    echo json_encode($result); 
                }else{
                    $resultset["success"] = "1"; 
                    $resultset["data"] = []; 
                    echo json_encode($resultset); 
                }
                 exit();
                
                break; 
		
		case 'DETALLE':
                setDatosConexion(''); 
                
                $response_1= array();
                $objEmpresaLocal= new Entity($response_1);
				$parametros= array( $data->id );
				$resultset= $objEmpresaLocal->getSp('sp_selectEmpresaLocal', $parametros, 'empresa');
				
				//Industrias            
                $objEmpresaLocal= new Entity($objEmpresaLocal->getResponse());
                $parametros= array($data->id);
                $resultset= $objEmpresaLocal->getSp('sp_selectEmpresaIndustrias', $parametros, 'sectores');
             
				//Miembros
                $response_2= $objEmpresaLocal->getResponse();               
                $objMiembro= new Entity($response_2);
                $parametros= array($data->id);
                $resultset= $objMiembro->getSp('sp_selectEmpresaLocalMasMiembros', $parametros, 'miembros');
           
                if(count($resultset['empresa']) > 0 ){
					$result["data"]=$resultset;
                    $result["success"] = "1"; 
                    echo json_encode($result); 
                }else{
                    $resultset["success"] = "2"; 
                    $resultset["data"] = "No existe Información!"; 
                    echo json_encode($resultset); 
                }
                 exit();
                
                break; 
            case 'KEY_DETALLE':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases');
                
                //Empresas
                $response_1= array();               
                $objEmpresaLocal= new Entity($response_1);
                $parametros= array($data->_id_empresa);
                $resultset= $objEmpresaLocal->getSp('sp_selectEmpresaLocal', $parametros, 'detalle_empresa');

                //Miembros
                $response_2= $objEmpresaLocal->getResponse();               
                $objMiembro= new Entity($response_2);
                $parametros= array($data->_id_empresa);
                $resultset= $objMiembro->getSp('sp_selectEmpresaLocalMasMiembros', $parametros, 'miembros');
                //Contactos
                $response_3= $objMiembro->getResponse();              
                $objContacto= new Entity($response_3);
                $parametros= array($data->_id_empresa);
                $resultset= $objContacto->getSp('sp_selectEmpresaContacto', $parametros, 'contactos');
    
                if(count($resultset['detalle_empresa']) > 0 ){
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
