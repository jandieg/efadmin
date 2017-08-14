<?php 
require_once MODELO.'Entity.php';
$data = json_decode(file_get_contents("php://input")); 

if (isset($data)) {
    try{
        switch ($data->KEY):
            case 'KEY_LISTA':
                setDatosConexion(''); 
                
                $fecha_inicio = $data->_fi;
                $fecha_fin = $data->_ff;    
                
                if($fecha_inicio == '' || $fecha_fin == ''){
                    $fecha_inicio = getPrimerDiaMes(date('Y'),'1');
                    $fecha_fin= getUltimoDiaMes(date('Y'),'12');
                }else{
                    $fecha_inicio = $data->_fi;
                    $fecha_fin= $data->_ff;
                }
                
                
                $resultset= array();
                $response_1= array();
                $objEmpresaLocal= new Entity($response_1);
		
					$user=$data->_all==FALSE ?$data->user:-1;

                    $parametros= array($user , $fecha_inicio, $fecha_fin);
                    $resultset= $objEmpresaLocal->getSp('sp_appSelectMiembroEventosCalendarioForum', $parametros, 'eventos');
           
					$response["data"] = $resultset['eventos']; 
                    $response["success"] = "1"; 
                    echo json_encode($response); 

                exit();               
                break; 
			case 'DETALLE':
                setDatosConexion(''); 
                
                $resultset= array();
                $response_1= array();
                $objEmpresaLocal= new Entity($response_1);
		
                    $parametros= array($data->id);
                    $resultset= $objEmpresaLocal->getSp('sp_appSelectEvento', $parametros, 'evento');

           if(count($resultset['evento']) > 0 ){
					$result["data"]=$resultset['evento'][0];
                    $result["success"] = "1"; 
                    echo json_encode($result); 
                }else{
                    $result["success"] = "0"; 
                    $result["data"] = "No existe el evento."; 
                    echo json_encode($result); 
                }

                exit();               
                break; 
		case 'KEY_MAS_INFORMACION_':
                setDatosConexion('bases'); 
                
                $resultset= array();
                
                $response_1= array();
                $objEvento= new Entity($response_1);
                $parametros= array($data->_id_evento);
                $resultset= $objEvento->getSp('sp_appSelectEventoGrupMiemEmprPart', $parametros, 'evento');
                if(count($resultset['evento']) > 0 ){
                    $resultset["success"] = "1"; 
                    echo json_encode($resultset); 
                }else{
                    $resultset["success"] = "0"; 
                    $resultset["data"] = "No existe Información!"; 
                    echo json_encode($resultset); 
                }
                 exit();

                break;
		  case 'KEY_MAS_INFORMACION':
                setDatosConexion('bases'); 
                
                $resultset= array();
                
                $response_1= array();
                $objEvento= new Entity($response_1);
                $parametros= array($data->_id_evento);
                $resultset= $objEvento->getSp('sp_appSelectEventoGrupMiemEmprPart', $parametros, 'evento');
                
                
                
                $corte= '';
                $cabeceras= array();
                $cuerpo= array();
                
                foreach ($resultset['evento'] as $rows => $row){
                    if($corte != $row['key']){
                      $cabeceras[]= array("key" => $row['key']); 
                    }  
                    $corte = $row['key'];   
                } 
                
                
                foreach ($cabeceras as $c_rows =>  $c_row){
                    $data= array();
                    foreach ($resultset['evento'] as $rows => $row){
                        if($c_row['key'] == $row['key']){
                            $data[]= array("id" => $row['id'],"nombre" => $row['nombre'], "apellido" => $row['apellido']); 
                        }  
                    }
                    
                    $cuerpo[]=array( "key" => $c_row['key'], "data" => $data);
                }
                
                $res['evento']= $cuerpo;
                if(count($res['evento']) > 0 ){
                    $res["success"] = "1"; 
                    echo json_encode($res); 
                }else{
                    $res["success"] = "2"; 
                    $res["msg"] = "No existe Información!"; 
                    echo json_encode($res); 
                }
                 exit();

                break; 
		
		
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
} else { 
    echo getNull();
}  
exit();