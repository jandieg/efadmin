<?php 
require_once MODELO.'Entity.php';


$data = json_decode(file_get_contents("php://input")); 

if (isset($data)) {
    try{
        switch ($data->KEY):
		
		 case 'KEY_FILTROS_ASISTENCIA':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases'); 
  				$resultset= array();
                $response_1= array();
                $objTipoE= new Entity($response_1);
                $parametros= array( '' );
                $resultset= $objTipoE->getSp('sp_selectTipoEvento', $parametros, 'tipoeventos');

                $objGrupo= new Entity($objTipoE->getResponse());
                  if ($data->_permiso == $perVerTodosFiltrosAsistenciaOp17){ 
                    $parametros= array();
                    $resultset= $objGrupo->getSp('sp_selectGrupos', $parametros, 'grupos');
                 }  elseif ($data->_permiso == $perVerFiltrosIDForumAsistenciaOp17) {   
                    $parametros= array($data->_id, '4');
                    $resultset= $objGrupo->getSp('sp_selectGrupoKey', $parametros, 'grupos');
                 }
				$a_actual= date('Y');
				$a_partida= 2010;
				$a= array();
				for ($index = $a_actual; $index >= $a_partida;  $index= $index - 1 ) {
					$y= $index;
					$a[] = array('y' =>$y);
				}
				$resultset['year']= $a; 
			
                if(count($resultset['grupos']) > 0 ){
                    $resultset["success"] = "1"; 
                    echo json_encode($resultset); 
                }else{
                    $resultset["success"] = "2"; 
                    $resultset["msg"] = "No existe Información!"; 
                    echo json_encode($resultset); 
                }
                 exit();
                
                break; 
            case 'KEY_LISTA':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases'); 
                
                $fecha_inicio = $data->_fi;
                $fecha_fin = $data->_ff;    
                
                if($fecha_inicio == '' || $fecha_fin == ''){
                    $fecha_inicio = getPrimerDiaMes(date('Y'),'1');
                    $fecha_fin= getUltimoDiaMes(date('Y'),'12');
                }else{
					$fecha_inicio = getPrimerDiaMes( $data->_fi,'1');
                    $fecha_fin= getUltimoDiaMes( $data->_ff,'12');
				}
                $resultset= array();
                $response_1= array();
                $objAsistencia= new Entity($response_1);
                $parametros= array($data->_grupo, $fecha_inicio, $fecha_fin, $data->_tipo_evento );
                $resultset= $objAsistencia->getSp('sp_appSelectAsistencia', $parametros, 'asistencia');

                $corte= '';
                $cabeceras= array();
                $cuerpo= array();
                
                foreach ($resultset['asistencia'] as $rows => $row){
                    if($corte != $row['eve_id']){
                      $cabeceras[]= array( 
                                        "eve_id" => $row['eve_id'],
                                        "eve_nombre" => $row['eve_nombre'],
                                        "eve_fechainicio" => $row['eve_fechainicio'],
                                        "eve_fechafin" => $row['eve_fechafin'],
                                        "eve_descripcion" => $row['eve_descripcion'],
                                        "eve_responsable" => $row['eve_responsable'],
                                        "direccion" => $row['direccion']); 
                    }  
                    $corte = $row['eve_id'];
                }

 
             foreach ($cabeceras as $c_rows =>  $c_row){
                    $data= array();
                    foreach ($resultset['asistencia'] as $rows => $row){
                        if($c_row['eve_id'] == $row['eve_id']){
							$estado= ($row['asis_estado'] == 1) ? FALSE : TRUE;
                            $data[]= array("nombre" => $row['nombre'],"asis_id" => $row['asis_id'], "estado" => $estado); 
                        }  
                    }
                    
                    $cuerpo[]=array( 
                                    "eve_id" => $c_row['eve_id'],
                                    "eve_nombre" => $c_row['eve_nombre'],
									"mes" => date('F',strtotime($c_row['eve_fechainicio'])),
                                    "eve_fechainicio" => getFormatoFechadmyhis( $c_row['eve_fechainicio']),
                                    "eve_fechafin" => getFormatoFechadmyhis($c_row['eve_fechafin']),
                                    "eve_descripcion" => $c_row['eve_descripcion'],
                                    "eve_responsable" => $c_row['eve_responsable'],
                                    "direccion" => $c_row['direccion'], 
						 			"icon" => 'ios-add-circle-outline',
									"showDetails" => false,
                                    "miembros" => $data);
                }
                
                $res['asistencia']= $cuerpo;
                
                if(count($res['asistencia']) > 0 ){
                    $res["success"] = "1"; 
                    echo json_encode($res); 
                }else{
                    $res["success"] = "2"; 
                    $res["msg"] = "No existe Información!"; 
                    echo json_encode($res); 
                }
                 exit();

                break; 
		case 'KEY_REGISTRAR_ASISTENCIA':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases'); 
                
                $resultset= array();
                $objAsistencia= new Entity(NULL);
                $parametros= array( $data->_lista_asistencia, $data->_id, $data->_lista_deseleccionados);
                $res= $objAsistencia->setSp('sp_appUpdateAsistencia', $parametros);
                
                if($res == 'OK' ){
                    $resultset["success"] = "1"; 
                    $resultset["msg"] = "La Asistencia se registro correctamente! ". $data->_lista_asistencia;
                    echo json_encode($resultset); 
                }else{
                    $resultset["success"] = "2"; 
                    $resultset["msg"] = "La Asistencia NO se regitro! ". $data->_lista_asistencia; 
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
