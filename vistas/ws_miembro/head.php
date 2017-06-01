<?php 
require_once MODELO.'Entity.php'; 
require_once MODELO.'EntityGrupo.php';
$data = json_decode(file_get_contents("php://input")); 

if (isset($data)) {
    try{
        switch ($data->KEY):
            case 'GRUPOS':
                setDatosConexion(''); 
                
                $response_1= array();
                $objMiembro= new Entity($response_1);
                $resultset= array();
              
				$parametros= array();
				$resultset= $objMiembro->getSp('sp_appGetGroups', $parametros, 'grupos');
                
                if(count($resultset['grupos']) > 0 ){
					$result["data"]=$resultset['grupos'];
                    $result["success"] = "1"; 
                    echo json_encode($result); 
                }else{
                    $result["success"] = "2"; 
                    $result["data"] = "No existe Información!"; 
                    echo json_encode($result); 
                }

                exit();
                
                break;
		case 'MIEMBROS':
                setDatosConexion(''); 
                
                $response_1= array();
                $response_2= array();
                $objMiembro= new Entity($response_1);
                $objMiembro2= new Entity($response_2);
                $resultset= array();
                $resultset2= array();
              
				$parametros= array($data->idGrupo);
				$resultset= $objMiembro->getSp('sp_appGetMiembros', $parametros, 'miembros');
				$resultset2= $objMiembro2->getSp('app_getGroupLeader', $parametros, 'leader');
                
                if(count($resultset['miembros']) > 0 ){
				$res= array();
					$res["list"]=$resultset['miembros'];
					$res["leader"]=$resultset2['leader'][0];

					$result["data"]=$res;
                    $result["success"] = "1"; 
                    echo json_encode($result); 
                }else{
                    $result["success"] = "2"; 
                    $result["data"] = "No existe Información!"; 
                    echo json_encode($result); 
                }

                exit();
                
                break;
	case 'BUSCAR':
                setDatosConexion(''); 
                
                $response_1= array();
                $objMiembro= new Entity($response_1);
                $resultset= array();
              
				$parametros= array($data->filter, $data->pais);
				$resultset= $objMiembro->getSp('sp_appGetMiembrosBuscar', $parametros, 'miembros');
                
                if(count($resultset['miembros']) > 0 ){
					$result["data"]=$resultset['miembros'];
                    $result["success"] = "1"; 
                    echo json_encode($result); 
                }else{
                    $result["success"] = "1"; 
                    $result["data"] = []; 
                    echo json_encode($result); 
                }

                exit();
                
                break;

	case 'BUSCARHOBBIE':
                setDatosConexion(''); 
                
                $response_1= array();
                $objMiembro= new Entity($response_1);
                $resultset= array();
              
				$parametros= array($data->filter, $data->pais);
				$resultset= $objMiembro->getSp('sp_appGetMiembrosHobbies', $parametros, 'miembros');
                
                if(count($resultset['miembros']) > 0 ){
					$result["data"]=$resultset['miembros'];
                    $result["success"] = "1"; 
                    echo json_encode($result); 
                }else{
                    $result["success"] = "1"; 
                    $result["data"] = []; 
                    echo json_encode($result); 
                }

                exit();
                
                break;
				
       case 'DETALLE':
                setDatosConexion('');			
				
                
                $_id_empresa='';
                //Miembro
                $response_1= array();             
                $objMiembro= new Entity($response_1);
                $parametros= array($data->id);
                $resultset= $objMiembro->getSp('sp_selectMiembro1', $parametros, 'detalle_miembro');
                foreach ($resultset['detalle_miembro'] as $rows => $row){
                    $_id_empresa= $row['emp_id'];
                }
                //Direccion
                $response_2=  $objMiembro->getResponse();      
                $objDireccion= new Entity($response_2);
                $parametros= array($data->id);
                $resultset= $objDireccion->getSp('sp_selectDireccion', $parametros, 'direccion');

                //Industrias
                $response_3= $objDireccion->getResponse();    
                $objEmpresa= new Entity($response_3);
                $parametros= array($_id_empresa);
                $resultset= $objEmpresa->getSp('sp_selectEmpresaIndustrias', $parametros, 'sectores');
    
			 //Intereses
                $response_4= $objEmpresa->getResponse();    
                $objHobbies= new Entity($response_4);
                $parametros= array($data->id);
                $resultset= $objHobbies->getSp('sp_appGetMyHobbies', $parametros, 'hobbies');

                if(count($resultset['detalle_miembro']) > 0 ){
				    $resultset['detalle_miembro'][0]["ind"]=$resultset['sectores'][0];//industria
				    $resultset['detalle_miembro'][0]["hobbies"]=$resultset['hobbies'];//hobbies
					$result["data"]=$resultset['detalle_miembro'][0];
                    $result["success"] = "1"; 
                    echo json_encode($result);                          
                }else{
                    $resultset["success"] = "0"; 
                    $resultset["data"] = "No existe Información!"; 
                    echo json_encode($resultset); 
                }

                exit();

                break;
		 case 'KEY_FILTROS_GRUPO':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases'); 
		
				$per='';
		
				if($data->_permiso == $perGlobalMiembrosOp12){
					$per=$perFiltroVerTodoslosMiembrosOp6;
                }elseif ($data->_permiso == $perFiltroVerTodoslosMiembrosOp6) {    
					$per=$perFiltroVerTodoslosMiembrosOp6;
                }elseif ($data->_permiso == $perFiltroVerMiembrosForumOp6) {
                    $per=$perFiltroVerMiembrosForumOp6;
                }
  		
                $resultset= array();
                $response_1= array();
                $objGrupo= new EntityGrupo($response_1);
                $resultset= $objGrupo->getFiltro('grupos', $data->_id, $per, $perFiltroVerTodoslosMiembrosOp6, $perFiltroVerMiembrosForumOp6);

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
		case 'KEY_SELECT_MIEMBROS_GRUPOS':
                validarHash($data->_hash, $data->_id . $data->_user . $data->_id);
                setDatosConexion($data->_base);
                setDatosConexion('bases'); 
                
                $response_1= array();
                $objMiembro= new Entity($response_1);
                $resultset= array();
				$parametros= array( $data->_grupo );
                $resultset= $objMiembro->getSp('sp_appSelectMiembroFiltros2', $parametros, 'miembros');   
         
                
                if(count($resultset['miembros']) > 0 ){
                    $resultset["success"] = "1"; 
                    echo json_encode($resultset); 
                }else{
                    $resultset["success"] = "2"; 
                    $resultset["msg"] = "No existe Información!"; 
                    echo json_encode($resultset); 
                }

                exit();
                
                break;

	case 'UPDATE':
				$memberCode=$data->code;
				$encodedString=$data->foto;
				$encodedString=str_replace(' ','+',$encodedString);
				$decoded=base64_decode($encodedString);

				file_put_contents('../../public_html/i/'.$memberCode.'.jpg',$decoded);

				$resultset["success"] = "1"; 
				$resultset["data"] = "Foto actualizada!"; 
				echo json_encode($resultset); 

				exit();

				break;

        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
} else { 
    echo getNull();
}  
exit();