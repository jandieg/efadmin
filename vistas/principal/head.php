<?php 
require_once MODELO.'Empresa.php';
include(HTML."/html.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):   
                case 'KEY_SHOW_FORM_ACTUALIZAR':///////////////////////////////////////////////////////////             
//                    if(isset($_POST['id'])){ 
                        $empresa= new Empresa();
                        $resultset= $empresa->getEmpresa();
                        $resultado='';    
                        if($row = $resultset->fetch_assoc()) { 
                            $resultado = str_replace("{nombre_empresa}", $row['emp_razonsocial'], getPage("pager_empresa_actualiza"));
                            $resultado = str_replace("{id}", $row['emp_id'], $resultado);
                            $resultado = str_replace("{telefono}", $row['emp_telefono'], $resultado);
                            $resultado = str_replace("{celular}", $row['emp_movil'], $resultado);
                            $resultado = str_replace("{sitio_web}", $row['emp_sitioweb'], $resultado);
                            $resultado = str_replace("{pais}", $row['emp_pais'], $resultado);
                            $resultado = str_replace("{fax}", $row['emp_fax'], $resultado);
                            $resultado = str_replace("{descripcion}", $row['emp_descripcion'], $resultado);
                            $resultado = str_replace("{calle}", $row['emp_calle'], $resultado);
                            $resultado = str_replace("{ciudad}", $row['emp_ciudad'], $resultado);
                            $resultado = str_replace("{reencuentro}", $row['emp_empleados'], $resultado); 
                            $resultado = str_replace("{admin}", $row['emp_administrador'], $resultado); 
                            $resultado = str_replace("{codigop}", $row['emp_codigopostal'], $resultado); 
                            
                        }
                        echo $resultado; 
                        exit();
                        
//                    }
                    break;
                 case 'KEY_ACTUALIZAR'://///////////////////////////////////////////////////////// 
            
//                    if(!empty($_POST['nombre']) && !empty($_POST['empleados']) && !empty($_POST['tel']) && !empty($_POST['movil']) && 
//                            !empty($_POST['fax']) && !empty($_POST['admin'])){ 
                     if(!empty($_POST['id'])){ 
                        $empresa= new Empresa();
                        $comp= $empresa->setActualizarEmpresa($_POST['id'] ,$_POST['nombre'],$_POST['empleados'],$_POST['tel'],
                                $_POST['movil'], $_POST['fax'], $_POST['sweb'], $_POST['descripcion'], $_POST['pais'],
                                $_POST['calle'], $_POST['codigop'], $_POST['ciudad'], $_POST['admin'], $_SESSION['user_id_ben']);    
                        if($comp == "OK"){
                            $data = array("success" => "true", "msj" => 'La empresa se actualizó correctamente!');
                            echo json_encode($data);
                        }else{
                            $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                            echo json_encode($data);
                        }

                    }  else {
//                        echo generadorAlertaOperacion('alert-info', 'Faltan campos por llenar!');
                        $data = array("success" => "false", "msj" => generadorAlertaOperacion('alert-info', 'Faltan campos por llenar!'));  
                        echo json_encode($data); 
                    }
                   exit();
                   break;
            
           
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
    
     
}

////////////////////////////////////////////////////////////////////////////////
$empresa= new Empresa();
$resultset= $empresa->getEmpresa();
$resultado='';    
if($row = $resultset->fetch_assoc()) { 
    /*
     SELECT `emp_id`, `emp_razonsocial`, `emp_empleados`, `emp_telefono`, `emp_movil`, `emp_fax`, 
     * `emp_sitioweb`, `emp_descripcion`, `emp_pais`, `emp_calle`, `emp_codigopostal`, `emp_ciudad`, 
     * `emp_administrador`, 
     * `emp_fechamodificacion`, `emp_fecharegistro`, `emp_usu_id` FROM `empresa` WHERE 1
     * 
     *  */
    $resultado = str_replace("{nombre_empresa}", $row['emp_razonsocial'], getPage("page_empresa_cnt"));
    $resultado = str_replace("{admin}", "Super Administrador: ".$row['emp_administrador'], $resultado);
    $resultado = str_replace("{telefono}", "Teléfono: ".$row['emp_telefono'], $resultado);
    $resultado = str_replace("{celular}", "Móvil: ".$row['emp_movil'], $resultado);
    $resultado = str_replace("{fax}", "Fax: ".$row['emp_fax'], $resultado);
    $resultado = str_replace("{sitio_web}", "Sitio Web: ".$row['emp_sitioweb'], $resultado);
                                                                          
}   
$t=$resultado;
     



 
 
//require_once MODELO.'Empresa.php';
//include(HTML."/html.php");
//if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
//    try{
//        switch ($_POST['KEY']):   
//                case 'show_upd':///////////////////////////////////////////////////////////             
////                    if(isset($_POST['id'])){ 
//                        $empresa= new Empresa();
//                        $resultset= $empresa->getEmpresa();
//                        $resultado='';    
//                        /*
//     SELECT `emp_id`, `emp_razonsocial`, `emp_empleados`, `emp_telefono`, `emp_movil`, `emp_fax`, 
//     * `emp_sitioweb`, `emp_descripcion`, `emp_pais`, `emp_calle`, `emp_codigopostal`, `emp_ciudad`, 
//     * `emp_administrador`, 
//     * `emp_fechamodificacion`, `emp_fecharegistro`, `emp_usu_id` FROM `empresa` WHERE 1
//     * 
//     *  */
//                        if($row = $resultset->fetch_assoc()) { 
//                            $resultado = str_replace("{nombre_empresa}", $row['emp_razonsocial'], getPage("pager_empresa_actualiza"));
//                            $resultado = str_replace("{id}", $row['emp_id'], $resultado);
//                            $resultado = str_replace("{telefono}", $row['emp_telefono'], $resultado);
//                            $resultado = str_replace("{celular}", $row['emp_movil'], $resultado);
//                            $resultado = str_replace("{sitio_web}", $row['emp_sitioweb'], $resultado);
//                            $resultado = str_replace("{fax}", $row['emp_fax'], $resultado);
//                            $resultado = str_replace("{descripcion}", $row['emp_descripcion'], $resultado);
//                            $resultado = str_replace("{calle}", $row['emp_calle'], $resultado);
//                            $resultado = str_replace("{ciudad}", $row['emp_ciudad'], $resultado);
//                            $resultado = str_replace("{reencuentro}", $row['emp_empleados'], $resultado); 
//                            $resultado = str_replace("{admin}", $row['emp_administrador'], $resultado); 
//                            $resultado = str_replace("{codigop}", $row['emp_codigopostal'], $resultado); 
//                            
//                        } else {
//                            $resultado = str_replace("{nombre_empresa}", '', getPage("pager_empresa_actualiza"));
//                            $resultado = str_replace("{id}", '', $resultado);
//                            $resultado = str_replace("{telefono}", '', $resultado);
//                            $resultado = str_replace("{celular}", '', $resultado);
//                            $resultado = str_replace("{sitio_web}", '', $resultado);
//                            $resultado = str_replace("{fax}", '', $resultado);
//                            $resultado = str_replace("{descripcion}", '', $resultado);
//                            $resultado = str_replace("{calle}",'', $resultado);
//                            $resultado = str_replace("{ciudad}", '', $resultado);
//                            $resultado = str_replace("{reencuentro}", '', $resultado); 
//                            $resultado = str_replace("{admin}", '', $resultado); 
//                            $resultado = str_replace("{codigop}", '', $resultado); 
//                        } 
//                        echo $resultado; 
//                        exit();
//                        
////                    }
//                    break;
//                 case 'c'://///////////////////////////////////////////////////////// 
//                           
//               /*
//                * KEY: 'c', 
//                *  nombre: $("#c_empresa").val().toString(),
//                * empleados: $("#c_reencuentro").val().toString(),
//                tel: $("#c_telefono").val().toString(),
//                movil: $("#c_movil").val().toString(),
//                fax: $("#c_fax").val().toString(),
//                sweb: $("#c_sitioweb").val().toString(),
//                admin: $("#c_admin").val().toString(),
//                descripcion: $("#c_descrpcion").val().toString(),
//                codigop: $("#c_codigopostal").val().toString(),
//                ciudad: $("#c_ciudad").val().toString(),
//                calle: $("#c_calle").val().toString()
//                */
//                
//                         
//                    if(!empty($_POST['nombre']) && !empty($_POST['empleados']) && !empty($_POST['tel']) && !empty($_POST['movil']) && 
//                            !empty($_POST['fax']) && !empty($_POST['admin'])){ 
//                        $perfil= new Perfil();
//                        $comp= $perfil->setCrearPerfil( $_POST['descripcion'], $_POST['estado'],  $_SESSION['user_id_ben']);    
//                        if($comp > 0){
//                            $data = array("success" => "true_gn", "msj" => generadorAlertaOperacion('alert-success', 'La empresa se creo correctamente!'));                           
//                            
//                        }else{
//                            //echo generadorAlertaOperacion('alert-danger', 'Error!');
//                            $data = array("success" => "false", "msj" => generadorAlertaOperacion('alert-danger', 'Error!'));  
//                            echo json_encode($data); 
//                        } 
//                    }  else {
////                        echo generadorAlertaOperacion('alert-info', 'Faltan campos por llenar!');
//                        $data = array("success" => "false", "msj" => generadorAlertaOperacion('alert-info', 'Faltan campos por llenar!'));  
//                        echo json_encode($data); 
//                    }
//                   
//                    break;
//            
//           
//        endswitch;    
//    } catch (Exception $exc) { echo getError($exc);}  
//    
//     
//}
//
//////////////////////////////////////////////////////////////////////////////////
//$empresa= new Empresa();
//$resultset= $empresa->getEmpresa();
//$resultado='';    
//if($row = $resultset->fetch_assoc()) { 
//    /*
//     SELECT `emp_id`, `emp_razonsocial`, `emp_empleados`, `emp_telefono`, `emp_movil`, `emp_fax`, 
//     * `emp_sitioweb`, `emp_descripcion`, `emp_pais`, `emp_calle`, `emp_codigopostal`, `emp_ciudad`, 
//     * `emp_administrador`, 
//     * `emp_fechamodificacion`, `emp_fecharegistro`, `emp_usu_id` FROM `empresa` WHERE 1
//     * 
//     *  */
//    $resultado = str_replace("{nombre_empresa}", $row['emp_razonsocial'], getPage("page_empresa_cnt"));
//    $resultado = str_replace("{admin}", "Super Administrador: ".$row['emp_administrador'], $resultado);
//    $resultado = str_replace("{telefono}", "Telefono: ".$row['emp_telefono'], $resultado);
//    $resultado = str_replace("{celular}", "Móvil: ".$row['emp_movil'], $resultado);
//    $resultado = str_replace("{fax}", "Fax: ".$row['emp_fax'], $resultado);
//    $resultado = str_replace("{sitio_web}", "Sitio Web: ".$row['emp_sitioweb'], $resultado);
//                                                                          
//}  else {
//    $resultado = str_replace("{nombre_empresa}", 'Titulo', getPage("page_empresa_cnt"));
//    $resultado = str_replace("{admin}", "Super Administrador: Root", $resultado);
//    $resultado = str_replace("{telefono}", "Telefono: 0999999999", $resultado);
//    $resultado = str_replace("{celular}", "Móvil: 0999999999", $resultado);
//    $resultado = str_replace("{fax}", "Fax: 0999999999", $resultado);
//    $resultado = str_replace("{sitio_web}", "Sitio Web: www.mysitio.com", $resultado);
//}    
//$t=$resultado;
//
