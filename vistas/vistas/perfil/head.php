<?php 
require_once MODELO.'Usuario.php';
require_once MODELO.'Correo.php';
require_once MODELO.'Telefono.php';
require_once(LENGUAJE."/lenguaje_1.php");
include(HTML."/html_2.php");
include(HTML."/html.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):   
            case 'x':          

                break;   
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
    
     
}

////////////////////////////////////////////////////////////////////////////////

$disabled=FALSE;
$idpersona='';
$user='';
$t='';
$usu= new Usuario();
$resultset= $usu->getUser($_SESSION['user_id_ben'], 'A'); 
if($row = $resultset->fetch_assoc()) {  
    
    $idpersona=$row['per_id'];
    $titulo=$row['per_nombre'].' '.$row['per_apellido'];
    $user= $row['usu_user'];
    $objCorreo= new Correo();
    $correo_1= $objCorreo->getCorreoPersonalSecundario($idpersona, 'Personal');
    $correo_2= $objCorreo->getCorreoPersonalSecundario($idpersona, NULL);

    $objTelefono= new Telefono();
    $t_fijo= $objTelefono->getTelefonoTipo($idpersona, 'C');
    $t_movil= $objTelefono->getTelefonoTipo($idpersona, 'M');


    $tabla['t_2'] = array("t_1" => generadorNegritas($lblNombre), "t_2" => $titulo);
    $tabla['t_3'] = array("t_1" => generadorNegritas("Perfil"), "t_2" => $row['perfil_des']);
    $tabla['t_4'] = array("t_1" => generadorNegritas($lblIdentificacion), "t_2" => $row['per_identificacion']);
    $tabla['t_5'] = array("t_1" => generadorNegritas($lblFNacimiento), "t_2" => getFormatoFechadmy($row['per_fechanacimiento']));
    $tabla['t_6'] = array("t_1" => generadorNegritas($lblGenero), "t_2" => $row['per_genero']);
    $tabla['t_7'] = array("t_1" => generadorNegritas($lblTipoPersona), "t_2" => ($row['per_tipo'] == 'J') ? 'Jurídica' : 'Natural');
    
    $tabla2['t_5'] = array("t_1" => generadorNegritas($lblCorreo), "t_2" => $correo_1);
    $tabla2['t_6'] = array("t_1" => generadorNegritas($lblCorreoSecundario), "t_2" => $correo_2);
    $tabla2['t_7'] = array("t_1" => generadorNegritas($lblTF), "t_2" => $t_fijo);
    $tabla2['t_8'] = array("t_1" => generadorNegritas($lblTM), "t_2" => $t_movil);
    $tabla2['t_9'] = array("t_1" => generadorNegritas($lblEstado), "t_2" => ($row['usu_estado'] == 'A') ? 'ACTIVO' : 'INACTIVO');


    $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "#modal_getCrearUserClave" ,"color" => "btn-info" ,"click" => "" ,"titulo" => $lblActualizarUsuario ,"lado" => "pull-right" ,"icono" => "fa-user");
//    $boton['boton_1'] = array("elemento" => "boton" ,"modal" => ""  ,"color" => "btn-info" ,"click" => "getUserEditar(".$id_Miembro.")" ,"titulo" => "Editar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
//    $boton['boton_3'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");

    $resultado = str_replace("{contenedor_3}", generadorTabla_2($tabla, "table-striped"), getPage('page_detalle') ); 
    $resultado = str_replace("{contenedor_4}", generadorTabla_2($tabla2, "table-striped"), $resultado); 
    $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);

    $t=  $resultado;

} 

