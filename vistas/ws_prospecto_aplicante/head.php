<?php 
require_once MODELO.'Entity.php';
require_once E_LIB.'Mail.php';
$data = json_decode(file_get_contents("php://input")); 
if (isset($data)) {
    try{
        switch ($data->KEY):
            case 'KEY_LISTA':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases'); 
                
                $response_1= array();
                $objProspectoAplicante= new Entity($response_1);
                $parametros= array('','',$data->_esaplicante);
                $resultset= $objProspectoAplicante->getSp('sp_selectProspectoFiltros', $parametros, 'aplicante');

                if(count($resultset['aplicante']) > 0 ){
                    $resultset["success"] = "1"; 
                    echo json_encode($resultset); 
                }else{
                    $resultset["success"] = "2"; 
                    $resultset["msg"] = "No existe Información!"; 
                    echo json_encode($resultset); 
                }
                break;
            case 'KEY_APROBAR_PROSPECTO':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                
                setDatosConexion($data->_base);
                setDatosConexion('bases');
                
                $response_1= array();   
                $objProspecto= new Entity($response_1);
                $parametros= array( $data->_id_prospecto, $data->_id);
                $resultset= $objProspecto->setSp('sp_updateProspectoAprobar', $parametros);
                if($resultset == 'OK'){
                    $response_1["success"] = "1"; 
                    $response_1["msg"] = "El Prospecto fue aprobado correctamente!"; 
                    echo json_encode($response_1); 
                         
                }else{
                    $response_1["success"] = "2"; 
                    $response_1["msg"] = "El Prospecto no fue aprobado!"; 
                    echo json_encode($response_1); 
                }
                
            break;
            case 'KEY_CONVERTIR_PROSPECTO':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases');
                
                $response_1= array();   
                $objProspecto= new Entity($response_1);
                $parametros= array( $data->_id_prospecto,date("Y-m-d H:i:s"), $data->_id, $data->_id_forum);
                $resultset= $objProspecto->setSp('sp_updateProspectoConvertir', $parametros);
                
                if($resultset == 'OK'){
                        $response_2= array(); 
                        $objForum= new Entity($response_2);
                        $parametros= array($data->_id_forum, 'Personal');    
                        $resultset_correo_forum= $objForum->getSp('sp_selectUsuarioCorreo', $parametros,'correo');
                        $correo=((count($resultset_correo_forum['correo']) > 0) ? $resultset_correo_forum['correo'][0]['correo_forum'] : '');
         
                        $destinatarios= array();
                        $destinatarios[1]= $correo;
                        $destinatarios[2]= $data->_user_correo;
                        
                        try {
                            $asunto= "Renaissance Executive Forums";
                            $msg="Se asigna el prospecto ".$data->_nombre_prospecto."  al Forum Leader ".$data->_nombre_forum;
                            $mail= new Mail();
                            $mail->enviarMultiple($data->_user_name,$data->_user_correo,$asunto,$msg, FALSE, $destinatarios);  
                        } catch (Exception $ex) { }
                        
                    $response_1["success"] = "1"; 
                    $response_1["msg"] = "El Prospecto fue asignado con exito!"; 
                    echo json_encode($response_1); 
                         
                }else{
                    $response_1["success"] = "2"; 
                    $response_1["msg"] = "El Prospecto no fue convertido!"; 
                    echo json_encode($response_1); 
                }
                
                        
                break;     
            case 'KEY_CONVERTIR_APLICANTE':    
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases');
                $response_1= array();   
                $objAplicante= new Entity($response_1);
                $parametros= array( $data->_id_aplicante,date("Y-m-d H:i:s"), $data->_id, '','','');
                $resultset= $objAplicante->setSp('sp_updateAplicanteConvertir', $parametros);
                
                if($resultset == 'OK'){
                        $response_2= array(); 
                        $objForum= new Entity($response_2);
                        $parametros= array($data->_id_forum, 'Personal');    
                        $resultset_correo_forum= $objForum->getSp('sp_selectUsuarioCorreo', $parametros,'correo');
                        $correo=((count($resultset_correo_forum['correo']) > 0) ? $resultset_correo_forum['correo'][0]['correo_forum'] : '');
         
                        $destinatarios= array();
                        $destinatarios[1]= $correo;
                        $destinatarios[2]= $data->_user_correo;
                        
                        try {
                           
                            $asunto= "Renaissance Executive Forums";
                            $msg="Se convirtió el aplicante ".$data->_name_aplicante." a miembro, y se asigno al Forum Leader ".$data->_name_forum;
                            $mail= new Mail();
                            $mail->enviarMultiple($data->_user_name,$data->_user_correo,$asunto,$msg, FALSE, $destinatarios);  
                            
                        } catch (Exception $ex) { }
                        
                    $response_1["success"] = "1"; 
                    $response_1["msg"] = "El Miembro se creo correctamente!"; 
                    echo json_encode($response_1); 
                         
                }else{
                    $response_1["success"] = "2"; 
                    $response_1["msg"] = "El Miembro no se creo!"; 
                    echo json_encode($response_1); 
                }
                break;  
            
            case 'KEY_LISTA_FORUM':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases'); 
                
                $response_1= array();
                $objForum= new Entity($response_1);
                $parametros= array('');
                $resultset= $objForum->getSp('sp_selectForumLeader', $parametros, 'forum');

                if(count($resultset['forum']) > 0 ){
                    $resultset["success"] = "1"; 
                    echo json_encode($resultset); 
                }else{
                    $resultset["success"] = "2"; 
                    $resultset["msg"] = "No existe Información!"; 
                    echo json_encode($resultset); 
                }
				exit();
				break;
			case 'KEY_DETALLE_PROSPECTO_APLICANTE':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases');
                
                $_id_empresa='';
                //Miembro
                $response_1= array();             
                $objProspecto= new Entity($response_1);
                $parametros= array($data->_id_prospecto);
                $resultset= $objProspecto->getSp('sp_selectProspecto1', $parametros, 'detalle_prospecto');
                foreach ($resultset['detalle_prospecto'] as $rows => $row){
                    $_id_empresa= $row['emp_id'];
                }
		
                //Direccion
                $response_2= $objProspecto->getResponse();         
                $objDireccion= new Entity($response_2);
                $parametros= array($data->_id_persona);
                $resultset= $objDireccion->getSp('sp_selectDireccion', $parametros, 'direccion');
                //Industrias
                $response_3= $objDireccion->getResponse();            
                $objEmpresa= new Entity($objDireccion->getResponse());
                $parametros= array($_id_empresa);
                $resultset= $objEmpresa->getSp('sp_selectEmpresaIndustrias', $parametros, 'sectores');
    
                if(count($resultset['detalle_prospecto']) > 0 ){
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
        exit();
    } catch (Exception $exc) { echo getError($exc);}  
} else { 
    echo getNull();
}  
exit();
