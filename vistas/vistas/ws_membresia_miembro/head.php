<?php 
require_once MODELO.'Entity.php';
$data = json_decode(file_get_contents("php://input")); 

if (isset($data)) {
    try{
        switch ($data->KEY):
		
            case 'KEY_SELECT_EC':
                 validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases'); 
                setlocale(LC_MONETARY, 'en_US');
                $cuerpo1= array();
                $cuerpo2= array();
  		$resultset= array();
                $objEc= new Entity(NULL);
                $parametros= array( $data->_id, date('Y'));
                $resultset= $objEc->getSpResultse('sp_selectMiembroDatosEstadoCuenta', $parametros);
                while($row = $resultset->fetch_assoc()) { 
                    $cuerpo1[]=array( 
                        "per_nombre" => $row['per_nombre'],
                        "per_apellido" => $row['per_apellido'],
                        "mie_fecharegistro" => getFormatoFechadmy( $row['mie_fecharegistro']),
                        "gru_descripcion" => $row['gru_descripcion'],
                        "nombre_forum" => $row['nombre_forum'],
                        "memb_descripcion" => $row['memb_descripcion'],
                        "memb_valor" =>money_format('%(#2n', $row['memb_valor'])  ,
                        "periodo" => $row['periodo']);
                }
                
                $objEc= new Entity(NULL);
                $parametros= array( $data->_id, date('Y'), 1 );
                $resultset= $objEc->getSpResultse('sp_selectMiembroEstadoCuenta', $parametros);
                $cont= 1;
                while($row = $resultset->fetch_assoc()) { 
                    $cuerpo2[]=array( 
                        "cont" => $cont,
                        "key" => $row['key'],
                        "valor" => money_format('%(#2n',$row['valor']) ,
                        "fecha" => getFormatoFechadmy( $row['fecha']));
                    $cont= $cont + 1;
                }

                $res= array();
                $res['cabecera_estado_cuenta']= $cuerpo1;
                $res['estado_cuenta']= $cuerpo2;
			
                if(count($res['cabecera_estado_cuenta']) > 0 ){
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