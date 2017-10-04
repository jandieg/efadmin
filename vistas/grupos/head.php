<?php 
require_once MODELO.'ForumLeader.php';
require_once MODELO.'Grupo.php';
require_once MODELO.'Miembro.php';
require_once MODELO.'Sede.php';

include(HTML."/html.php");
include(HTML."/html_filtros.php");
//require_once 'public/phpmailer/correo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):  
            case 'KEY_SHOW_FORM_GUARDAR'://///////////////////////////////////////////////////////// 
                $objForum= new ForumLeader();
                $lista=array();
                $lista=$objForum->getListaForumLeaders(); 

                $boton['boton_2'] = array("click" => "setCrear('g')" ,"id" => "btnGuardar","modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_3'] = array("click" => "setCrear('gn')" ,"id" => "btnGuardarNuevo","modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar y Nuevo" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_4'] = array("click" => "getRecargar()" ,"id" => "","modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                //Formularios
                $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Grupo", "id" => "_grupo" ,"reemplazo" => "");
                $form['form_8'] = array("elemento" => "combo","change" => "",  "titulo" => "Forum Leader", "id" => "_forum", "option" => $lista);

                $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );//generadorContMultipleRow($colum)); 
                $resultado = str_replace("{cabecera}", "Crear Grupo", $resultado);
                $resultado = str_replace("{boton}", generadorBoton2($boton), $resultado);

                echo $resultado;
                exit();

               break;
            case 'KEY_SHOW_FORM_ACTUALIZAR'://///////////////////////////////////////////////////////// 
               if(!empty($_POST['id']) ){    
                    $grupo= new Grupo();
                    $resultset= $grupo->getNombreGrupos($_POST['id']); 
                
                    if ($row = $resultset->fetch_assoc()) { //usuario.usu_id , persona.per_nombre, persona.per_apellido
                    $objForum= new ForumLeader();
                    $lista=array();
                    $lista=$objForum->getListaForumLeaders3($row['gru_forum'], '',NULL); 
                    
                               
                    $boton['boton_2'] = array("click" => "setActualizar(".$row['gru_id'].")" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");

                    $boton['boton_3'] = array("click" => "getRecargar()" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");
                   
                    //Formularios
                    $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Grupo", "id" => "_grupo" ,"reemplazo" => $row['gru_descripcion']);
                    $form['form_8'] = array("elemento" => "combo", "change" => "", "titulo" => "Forum Leader", "id" => "_forum", "option" => $lista);
     
                    $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );//generadorContMultipleRow($colum)); 
                    $resultado = str_replace("{cabecera}", "Crear Grupo", $resultado);
                    $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);
                   
                    echo $resultado;
                    }
                    exit();
               }
                   break;
            case 'KEY_GUARDAR':///////////////////////////////////////////////////////////         
                if(!empty($_POST['_grupo']) && !empty($_POST['_forum']) && !empty($_POST['key_operacion'] ) ){ 

                    $grupo= new Grupo();
                    $objSede = new Sede();
                    $datasede = $objSede->getSedeByUser($_SESSION['user_id_ben']);
                    $lasede = 1;
                    if ($row = $datasede->fetch_assoc()) {
                        $lasede = $row['sede_id'];
                    }
                    $comp= $grupo->setGrabarGrupo($_POST['_forum'], $_POST['_grupo'], $_SESSION['user_id_ben'], $lasede);  
                    if($comp == "OK"){
                         if($_POST['key_operacion']=='gn'){
                           $data = array("success" => "true_gn", "priority"=>'success',"msg" => 'El Grupo se creo correctamente!');  
                           echo json_encode($data);              
                        }  else {
                           $data = array("success" => "true_g", "priority"=>'success',"msg" => 'El Grupo se creo correctamente!');  
                           echo json_encode($data); 
                        }
                    }else{
                        $data = array("success" => "false", "priority"=>'danger',"msg" => $comp); 
                        echo json_encode($data);
                    }


                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data); 
                }

                break;
            case 'KEY_ACTUALIZAR':///////////////////////////////////////////////////////////   
                 if(!empty($_POST['_grupo']) && !empty($_POST['_forum']) && !empty($_POST['_id'] ) ){ 

                    $grupo= new Grupo();
                    $comp= $grupo->setActualizarGrupo($_POST['_id'],$_POST['_forum'], $_POST['_grupo'], $_SESSION['user_id_ben']);  
                    if($comp == "OK"){
                         $data = array("success" => "true", "priority"=>'success',"msg" => 'El Grupo se actualizó correctamente!');  
                           echo json_encode($data);
                    }else{
                        $data = array("success" => "false", "priority"=>'danger',"msg" => $comp); 
                        echo json_encode($data);
                    }


                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data); 
                }

                break;         
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}    
    exit(); 
}

$grupo= new Grupo();
$cuerpo='';
$cont=1;
$resultset= $grupo->getGrupos3($_SESSION['user_id_ben']);

while($row = $resultset->fetch_assoc()) { 
     $cuerpo.= generadorTablaFilas(array(
         "<center>".$cont."</center>",
         generadorLink($row['gru_descripcion'],'getDetalle('.$row['gru_id'].')'),
         $row['per_nombre'].' '.$row['per_apellido'],
         date_format(date_create($row['gru_fecharegistro']), 'd/m/Y H:i:s'),
         date_format(date_create($row['gru_fechamodificacion']), 'd/m/Y H:i:s'),
         $row['modificador'])); 
     $cont=$cont + 1;   
 }    
 $t= generadorTabla_(1, "Grupos",'getCrear()', array("N°", "Descripción","Forum Leader","Fecha de Registro","Última Modificación", 'Ultimó en Modificar'), $cuerpo);

 function getNombreGrupo($param) {
    $grupo= new Grupo();
    $nombre_grupo='';
     $resultset= $grupo->getNombreGrupos($param);
     if($row = $resultset->fetch_assoc()) { 
        $nombre_grupo= $row['gru_descripcion'];                                                                    
     } 
     return $nombre_grupo;
}