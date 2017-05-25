<?php 
require_once MODELO.'Candidato.php';
require_once MODELO.'ForumLeader.php';
require_once MODELO.'Correo.php';
require_once E_LIB.'Mail.php';
$data = json_decode(file_get_contents("php://input")); 
if (isset($data)) {
    try{
        switch ($data->KEY):
            case 'KEY_LISTA':
                setDatosConexion($data->_base);
                setDatosConexion('bases'); 
                $objCandidato= new Candidato();
                $resultset= $objCandidato->getCandidatosFiltros("","");
                $response["prospecto"] = array();
                while($row = $resultset->fetch_assoc()) {
                   array_push($response["prospecto"], $row); 
                }
                if(count($response["prospecto"]) > 0) { 
                    $response["success"] = "1"; 
                    echo json_encode($response);                                          
                }  else {
                    $response["success"] = "2"; 
                    $response["msg"] = "No se encontraron datos!"; 
                    echo json_encode($response);             
                }
                break;
		case 'KEY_APROBAR':
                    setDatosConexion($data->_base);
                    setDatosConexion('bases');
                    $objCandidato= new Candidato();
                    $comp= $objCandidato->setActualizarAprobadoCandidato($data->_id_prospecto, $data->_id); 
                     if($comp == "OK"){
                        $response["success"] = "1"; 
                        $response["msg"] = "El Candidato fue aprobado correctamente!";
						echo json_encode($response);
                        
                    }else{
                        $response["success"] = "2"; 
                        $response["msg"] = "El Candidato no fue aprobado!"; 
                        echo json_encode($response);
                    }
                
            break;
		 case 'KEY_LISTA_FORUM':
                setDatosConexion($data->_base);
                setDatosConexion('bases'); 
                $objForum= new ForumLeader();
                $resultset= $objForum->getForumLeader(NULL);
                $response["forum"] = array();
                while($row = $resultset->fetch_assoc()) {
                   array_push($response["forum"], $row); 
                }
                if(count($response["forum"]) > 0) { 
                    $response["success"] = "1"; 
                    echo json_encode($response);                                          
                }  else {
                    $response["success"] = "2"; 
                    $response["msg"] = "No se encontraron datos!"; 
                    echo json_encode($response);             
                }
                break;
		case 'KEY_CONVERTIR': 
		            setDatosConexion($data->_base);
                    setDatosConexion('bases');


                    $objCandidato= new Candidato();
                    $comp= $objCandidato->setActualizarConvertirCandidato($data->_id_prospecto, $data->_id_forum, $data->_id );  
                    if($comp=="OK"){
                        $objForum= new ForumLeader();         
                        $correo_forum= $objForum->getCorreo( $data->_id_forum, 'Personal');
                        $destinatarios= array();
                        $destinatarios[1]= $correo_forum; 
                        $destinatarios[2]= $data->_user_correo;
                        try {
                            $asunto= "Renaissance Executive Forum";
                            $msg="Se asigna el prospecto ".$data->_nombre_prospecto."  al Forum Leader ".$data->_nombre_forum;
                            $mail= new Mail();
                            $mail->enviarMultiple($data->_user_name,$data->_user_correo,$asunto,$msg, FALSE, $destinatarios);  
                        } catch (Exception $ex) { }
                        
                        $response["success"] = "1"; 
                        $response["msg"] = "El prospecto fue asignado con exito!"; 
                        
                        echo json_encode($response);    
                    }else{
                        $response["success"] = "2"; 
                        $response["msg"] = "No se encontraron datos!"; 
                        echo json_encode($response);    
                    }
                  
           break; 



        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
} else { 
    echo getNull();
}  
exit();
