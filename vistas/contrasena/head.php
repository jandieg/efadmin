<?php
require_once MODELO.'Miembro.php';
require_once MODELO.'Usuario.php';

include_once(HTML."/html.php");
include_once(HTML."/html_2.php");
include_once(HTML."/html_combos.php");
include_once(HTML."/html_filtros.php");
require_once(LENGUAJE."/lenguaje_1.php");
require_once E_LIB.'funciones.php';
error_reporting(E_ALL);

$settings = parse_ini_file(E_LIB."settings.ini.php");  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']): 

            case 'KEY_ACTUALIZAR_CONTRASENA':
                if ($_POST['_contrasena'] == $_POST['_confirmacion']) {
                    $salt = generateSalt();
                    $hash = hash_hmac("sha256", trim($_POST['_contrasena']), $salt);                    
                    $objUsuario= new Usuario();
                    $comp= $objUsuario->setActualizarUserPassUsuario($_POST['_persona'], $_POST['_usu_user'], $hash, $_SESSION['user_id_ben'],$salt);                                                                 
                    if ($comp == "OK") {
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'La clave fue actualizada exitosamente');
                        echo json_encode($data);
                    }else{
                        $data = array("success" => "false", "priority"=>'info',"msg" => 'No se pudo actualizar la clave'); 
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




if (isset($_GET['user']) && isset($_GET['cod'])) {
    $objMiembro = new Miembro();
    $resultset = $objMiembro->verificarCodigoMiembro($_GET['user'],$_GET['cod']);
    if ($row = $resultset->fetch_assoc()) {
        if (strlen($row['usu_user']) > 0) {
            $username = $row['usu_user'];
            $persona = $row['Persona_per_id'];

            $form1['form_1'] = array("elemento" => "caja" ,"tipo" => "password" , "titulo" => "Contraseña", "id" => "_contrasena" ,"reemplazo" => "");
            $form2['form_1'] = array("elemento" => "caja" ,"tipo" => "password" , "titulo" => "Repita Contraseña", "id" => "_confirmacion" ,"reemplazo" => "");
            $form_1 = generadorEtiqueta($form1);
            $form_2 = generadorEtiqueta($form2);
            $boton['boton_1'] = array("elemento" => "boton" ,"modal" => ""  ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");
            $boton['boton_2'] = array("elemento" => "boton" ,"modal" => ""  ,"color" => "btn-info" ,"click" => "actualizarContrasena()" ,"titulo" => "Actualizar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
            $resultado = str_replace("{contenedor_1}", $form_1,  getPage('page_detalle_update'));
            $resultado = str_replace("{contenedor_2}", $form_2, $resultado);         
            $resultado = str_replace("{boton}",  generadorBoton($boton), $resultado); 
            $t = $resultado;
        } else {
            $t = "Disculpe el codigo es invalido";
        }
    } else {
        $t= "Disculpe codigo no encontrado";
    }
} else {
    $t= "Faltan datos por llenar";
}


?>