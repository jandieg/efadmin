<?php 
require_once MODELO.'Perfil.php';
require_once MODELO.'Permiso.php';
include(HTML."/html.php");
include(HTML."/html_2.php");
include(HTML."/html_combos.php");
$objPermiso;
$objMantenedorPerfil;
function getPermisos($idPerifl) {
    $objMantenedorPerfil= new Perfil();
    $listaPerfil= $objMantenedorPerfil->getListaPerfiles($idPerifl,NULL,'1');

    $objPermiso= new Permiso();
    $cuerpo='';
    $resultset= $objPermiso->getPermisosGlobales($idPerifl);
    $arrayOpcion= array();
    $arrayPermisos= array();
    $banderaDescripcionOpcion='';
    $cont= 1;
     while($row = $resultset->fetch_assoc()) { 
        $idPermiso= $row['id_permiso'];
        $checked= '';
        if($row['existe_permiso_ingresado'] == "A"){
            $comprobador= "true";
            $checked= 'checked';
        }elseif ($row['existe_permiso_ingresado'] == "I") {
            $comprobador= "true";
        }  else {
            $comprobador= "false";
        }
        $arrayPermisos[$cont] =  array("opcion" => $row['descripcion_opcion'],
                                       "permiso" => $row['descripcion_permiso'],
                                       "checked" => $checked,
            
                                       "id_checked" => "id_".$idPermiso,
                                       "funcion" => "setPermiso($idPerifl, $idPermiso,$comprobador)",
                                       "comprobador" => $comprobador);

        if($banderaDescripcionOpcion != $row['descripcion_opcion']){
           $arrayOpcion[$cont] = array("opcion" => $row['descripcion_opcion']);
        }

        $banderaDescripcionOpcion=$row['descripcion_opcion'];

        $cont= $cont + 1;         
    }

    $resultado = str_replace("{contenedor_1}", generadorMiniVentanasCheck("Establecer Permisos","fa-unlock","_id_Perfil","getComboCargarPermisos()",$listaPerfil, $arrayOpcion, $arrayPermisos),
                            getPage('page_detalle_update') );    
    $resultado = str_replace("{boton}", '', $resultado);  
    $resultado = str_replace("{cabecera}", "Establecer Permisos", $resultado);   
    $resultado = str_replace("{icono}", "fa-unlock", $resultado); 
    return $resultado;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):
            case 'KEY_SHOW_COMBO_PERFIL':
                if(!empty($_POST['_id_Perfil'])){    
                    $permisos= getPermisos($_POST['_id_Perfil']);
                    $data = array("success" => "true", "permisos" => $permisos);  
                    echo json_encode($data);
                
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'El combo no tiene datos!');  
                    echo json_encode($data); 
                }
            break;        
            case 'KEY_GUARDAR_ROL_PERMISO':    
                if(!empty($_POST['_id_Perfil']) && !empty($_POST['_id_Permiso']) && !empty($_POST['_estado'])){      
                    $objPermiso= new Permiso();
                    $comp= $objPermiso->setEstablecerPermisoPerfil($_POST['_id_Perfil'], $_POST['_id_Permiso'],$_POST['_estado'], $_SESSION['user_id_ben']);  
                    if($comp=="OK"){
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Permiso fue actualizadó correctamente!');    
                        echo json_encode($data);   
                    }else{
                        $data = array("success" => "false", "priority"=>'danger',"msg" => $comp);  
                        echo json_encode($data);  
                    }

                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Vuelve a intentarlo!');  
                    echo json_encode($data); 
                }                  
           break; 
            case 'KEY_ACTUALIZAR_ROL_PERMISO':   //($idPerfil, $idPermiso,$estado, $idModificador)  
                if(!empty($_POST['_id_Perfil']) && !empty($_POST['_id_Permiso']) && !empty($_POST['_estado'])){      
                    $objPermiso= new Permiso();
                    $comp= $objPermiso->setActualizarPermisoPerfil($_POST['_id_Perfil'], $_POST['_id_Permiso'],$_POST['_estado'], $_SESSION['user_id_ben']);  
                    if($comp=="OK"){
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Permiso fue actualizadó correctamente!');  
                        echo json_encode($data);   
                    }else{
                        $data = array("success" => "false", "priority"=>'danger',"msg" => $comp);  
                        echo json_encode($data);  
                    }

                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Vuelve a intentarlo!');  
                    echo json_encode($data); 
                }                  
           break; 
           
           
           
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
    
exit();  
}
$objMantenedorPerfil= new Perfil();
$listaPerfil= $objMantenedorPerfil->getListaPerfiles(NULL,NULL,'1');
$t= getPermisos($objMantenedorPerfil->getIdPrimero());
     
