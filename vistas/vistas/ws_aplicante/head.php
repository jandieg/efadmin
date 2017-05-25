<?php 
require_once MODELO.'Prospecto.php';

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
                
                $objProspesto= new Prospecto();
                $resultset= $objProspesto->getProspectosFiltros("", ""); 
                $response["aplicante"] = array();
                while($row = $resultset->fetch_assoc()) {
                   array_push($response["aplicante"], $row); 
                }
                if(count($response["aplicante"]) > 0) { 
                    $response["success"] = "1"; 
                    echo json_encode($response);                                          
                }  else {
                    $response["success"] = "2"; 
                    $response["msg"] = "No se encontraron datos!"; 
                    echo json_encode($response);             
                }
                break;
		   case 'KEY_CONVERTIR':    
//                 if(!empty($data->_id_aplicante) ){   
//                     
//                    setDatosConexion($data->_base);
//                    setDatosConexion('bases'); 
//                    
//                    $ingresos=''; $numero_empleados= ''; $fax= '';  $sitio_web= ''; $categoria= '';  $id_persona= '';
//                    $id_forum= ''; $id_profesion= ''; $participacion_correo= ''; $descripcion_desafio= ''; $twitter=''; $skype='';
//
//                    $objProspesto= new Prospecto();
//                    $resultset= $objProspesto->getIDSProspecto($data->_id_aplicante);  
//                    if($row = $resultset->fetch_assoc()) {  
//                        $ingresos=$row['ingreso'];
//                        $numero_empleados= $row['numero_empleado'];
//                        $fax= $row['fax'];
//                        $sitio_web= $row['sitio_web'];
//                        $categoria= $row['categoria_cat_id'];
//                        $id_persona= $row['Persona_per_id'];
//                        $id_forum= $row['forum_usu_id'];
//                        $id_profesion= $row['Profesion_prof_id'];
//                        $participacion_correo= $row['participacion_correo'];
//                        $descripcion_desafio= $row['prosp_descripcion_desafio'];
//                     
//                    } 
//
//                    $listadesafios="";
//                    $objProspesto= new Prospecto();
//                    $resultset= $objProspesto->getIDSProspectoDesafios($data->_id_aplicante);  
//                    while($row = $resultset->fetch_assoc()) {  
//                        $listadesafios.= $row['desafio_des_id'].","; 
//                    }                                    
//                    
//                    $listaInsdustria="";
//                    $objProspesto= new Prospecto();
//                    $resultset= $objProspesto->getIDSProspectoIndustrias($data->_id_aplicante);  
//                    while($row = $resultset->fetch_assoc()) {  
//                        $listaInsdustria.= $row['industria_ind_id'].","; 
//                    }
//                   
//                    if($listaInsdustria != ''){
//                     
//                     $pros= new Prospecto();
//                     $comp= $pros->setProspectoConvertir ($data->_id_empresa, $data->_id_aplicante, $data->_empresa, $data->_id, $ingresos, $numero_empleados, 
//                             $fax, $sitio_web, $listaInsdustria, $categoria, $id_persona, $id_forum, $id_profesion, 
//                             $participacion_correo, $descripcion_desafio, $listadesafios);  
//                      
//                     if($comp == "OK"){
//                        $objForum= new ForumLeader();         
//                        $correo_forum= $objForum->getCorreo($id_forum, 'Personal');
//                   
//                        
//                        $destinatarios= array();
//                        $destinatarios[1]= $correo_forum; 
//                        $destinatarios[2]= $data->_user_correo;
//                        try {
//                            $asunto= "Renaissance Executive Forum";
//                            $msg="Se convirtió el aplicante ".$data->_name_aplicante." a miembro, y se asigno al Forum Leader ".$data->_name_forum;
//                            $mail= new Mail();
//                            $mail->enviarMultiple($data->_user_name,$data->_user_correo,$asunto,$msg, FALSE, $destinatarios);  
//                        } catch (Exception $ex) { }
//   
//                        $response["success"] = "1"; 
//                        $response["msg"] = "El Miembro se creo correctamente!"; 
//                        echo json_encode($response);
//                     }else{
//                        $response["success"] = "2"; 
//                        $response["msg"] = "No se encontraron datos! ". $comp; 
//                        echo json_encode($response);
//                     }
//                        
//                    }else{
//                     
//						$response["success"] = "3"; 
//                        $response["msg"] = "Para convertir al Aplicante a Miembro debes agregar información obligatoria en el Sistema Web!"; 
//                        echo json_encode($response);
//                    }
//                 }  else {
//       
//                    $response["success"] = "3"; 
//                    $response["msg"] = "Faltan campos por llenar!"; 
//                    echo json_encode($response); 
//                 }                  
                 break; 



        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
} else { 
    echo getNull();
}  
exit();

