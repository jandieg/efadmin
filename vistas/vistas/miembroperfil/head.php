<?php 
require_once MODELO.'Correo.php';
require_once MODELO.'Telefono.php';
require_once MODELO.'RedSocialMiembro.php';
require_once MODELO.'Direccion.php';
require_once MODELO.'EmpresaLocal.php';
require_once(LENGUAJE."/lenguaje_1.php");
require_once MODELO.'Grupo.php';
require_once MODELO.'Miembro.php';
include(HTML."/html.php");
include(HTML."/html_2.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):   
            case 'KEY_SHOW_FORM_ACTUALIZAR'://///////////////////////////////////////////////////////// 
              if(!empty($_POST['id_miembro']) ){ 
                  echo getDetalleUpdate($_POST['id_miembro'],FALSE);
              }
              break; 
                
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}     
}
$disabled=TRUE;
$idpersona='';
$user='';
$objMiembro= new Miembro();
$id_Miembro= $objMiembro->getMiembroIdWithIdUser($_SESSION['user_id_ben']);  
$objMiembro= new Miembro();
$resultset= $objMiembro->getMiembro1($id_Miembro);  
if($row = $resultset->fetch_assoc()) {  
    $prefijoPais='';        
    $idpersona=$row['per_id'];
    $titulo=$row['per_nombre'].' '.$row['per_apellido'];
    $empresa=$row['emp_nombre'];
    $direcionsql= new Direccion();
    $resultset_direcionsql= $direcionsql->getDireccion($row['per_id']); 

    if ($row_direcionsql = $resultset_direcionsql->fetch_assoc()) {
        $prefijoPais=$row_direcionsql['pai_prefijo'];
    }

    $user = $row['mie_codigo'];
    $objCorreo= new Correo();
    $correo_1= $objCorreo->getCorreoPersonalSecundario($idpersona, 'Personal');
    $correo_2= $objCorreo->getCorreoPersonalSecundario($idpersona, NULL);

    $objTelefono= new Telefono();
    $t_fijo= $objTelefono->getTelefonoTipo($idpersona, 'C');
    $t_movil= $objTelefono->getTelefonoTipo($idpersona, 'M');

    $objRedSocial= new RedSocialMiembro();
    $redSkype=$objRedSocial->getNombreRedSocial($row['mie_id'], "skype");
    $redTwitter=$objRedSocial->getNombreRedSocial($row['mie_id'], "twitter");


    $tabla['t_1'] = array("t_1" => generadorNegritas("Código"), "t_2" => $row['mie_codigo']);
    $tabla['t_2'] = array("t_1" => generadorNegritas($lblNombre), "t_2" => $titulo);
    $tabla['t_3'] = array("t_1" => generadorNegritas($lblFNacimiento), "t_2" => getFormatoFechadmy( $row['per_fechanacimiento']));
    $tabla['t_4'] = array("t_1" => generadorNegritas($lblTitulo), "t_2" => $row['prof_descripcion']);
    $tabla['t_8'] = array("t_1" => generadorNegritas($lblCorreo), "t_2" => $correo_1);
    $tabla['t_9'] = array("t_1" => generadorNegritas($lblCorreoSecundario), "t_2" => $correo_2);
    $tabla['t_11'] = array("t_1" => generadorNegritas($lblTF), "t_2" => "(". $prefijoPais.") ".$t_fijo);
    $tabla['t_12'] = array("t_1" => generadorNegritas($lblTM), "t_2" => "(". $prefijoPais.") ".$t_movil);
    $tabla['t_13'] = array("t_1" => generadorNegritas($lblSkype), "t_2" => $redSkype);
    $tabla['t_14'] = array("t_1" => generadorNegritas($lblTwitter), "t_2" => $redTwitter);


    $tabla2['t_4'] = array("t_1" => generadorNegritas($lblEmpresa), "t_2" => $row['emp_nombre']);
    $tabla2['t_5'] = array("t_1" => generadorNegritas($lblCategoría), "t_2" => $row['cat_descripcion']);
    $tabla2['t_6'] = array("t_1" => generadorNegritas($lblSitioWeb), "t_2" => $row['emp_sitio_web']);
    $tabla2['t_7'] = array("t_1" => generadorNegritas($lblNEmpleados), "t_2" => $row['emp_num_empleados']);
    $tabla2['t_8'] = array("t_1" =>generadorNegritas($lblIngresosAnuales), "t_2" => $row['emp_imgresos']);
    $tabla2['t_9'] = array("t_1" => generadorNegritas($lblFax), "t_2" => $row['emp_fax']);

    $objEmpresaLocal= new EmpresaLocal();
    $resultset2= $objEmpresaLocal->getEmpresaLocalIndustrias($row['emp_id']);              
    $con=1;
    while ($row2 = $resultset2->fetch_assoc()) { 
        if($con == 1){
            $tabla2['t_10'.$con] = array("t_1" => generadorNegritas($lblSectores), "t_2" => $row2['ind_descripcion']);
        }else{
            $tabla2['t_10'.$con] = array("t_1" => "", "t_2" => $row2['ind_descripcion']);
        }     
      $con=$con+1;
    }  
    $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "#modal_getCrearUserClave" ,"color" => "btn-info" ,"click" => "" ,"titulo" => $lblActualizarUsuario ,"lado" => "pull-right" ,"icono" => "fa-user");
//    $boton['boton_1'] = array("elemento" => "boton" ,"modal" => ""  ,"color" => "btn-info" ,"click" => "getUserEditar(".$id_Miembro.")" ,"titulo" => "Editar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
//    $boton['boton_3'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");

    $resultado = str_replace("{contenedor_3}", generadorTabla_2($tabla, "table-striped"), getPage('page_detalle') ); 
    $resultado = str_replace("{contenedor_4}", generadorTabla_2($tabla2, "table-striped"), $resultado); 
    $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);

    $t=  $resultado;

} 

