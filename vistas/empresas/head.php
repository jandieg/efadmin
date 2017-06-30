<?php
require_once MODELO.'Categoria.php';
require_once MODELO.'Grupo.php';
require_once MODELO.'EmpresaLocal.php';
require_once MODELO.'Industria.php';
require_once MODELO.'Usuario.php';

require_once MODELO.'Pais.php';
require_once MODELO.'Provincia.php';
require_once MODELO.'Direccion.php';
require_once MODELO.'Ciudad.php';


include(HTML."/html_filtros.php");
require_once MODELO.'Industria.php';
require_once MODELO.'ForumLeader.php';
require_once MODELO.'PAMAsistente.php';
include(HTML."/html.php");
include(HTML."/html_2.php");

include(HTML."/html_combos.php");
//require_once 'public/phpmailer/correo.php';
$objEmpresaLocal;
$objIndustria;
$tabla= array();
include(LENGUAJE."/lenguaje_1.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']): 
            case 'KEY_SHOW_FORM_DETALLE':
                if(!empty($_POST['id']) ){ 
                    $objEmpresaLocal2 = new EmpresaLocal();
                    $resultset2 = $objEmpresaLocal2->getResenaDeMiembro($_POST['id']);
                    $resena = "";
                    $miembro_id = "0";
                    if ($row2 = $resultset2->fetch_assoc()) {
                        $resena = $row2['mie_observacion'];
                        $miembro_id = $row2['mie_id'];
                    }
                    $objEmpresaLocal= new EmpresaLocal();
                    $resultset= $objEmpresaLocal->getEmpresaLocal($_POST['id']);
                    if($row = $resultset->fetch_assoc()) {                     
                        $objUsuario= new Usuario();
                        $modificador= $objUsuario->getNombreUser($row['emp_id_usuario']);        
                        $tabla['t_1'] = array("t_1" => generadorNegritas($lblNombre), "t_2" => $row['emp_nombre']);
                        $tabla['t_2'] = array("t_1" => generadorNegritas($lblRUC), "t_2" => $row['emp_ruc']);
                       // $tabla['t_3'] = array("t_1" => generadorNegritas($lblIngresosAnuales), "t_2" => $row['emp_imgresos']);
                        //$tabla['t_4'] = array("t_1" => generadorNegritas($lblNEmpleados), "t_2" => $row['emp_num_empleados']);
                      // $tabla['t_5'] = array("t_1" => generadorNegritas($lblFax), "t_2" => $row['emp_fax']);
                        $tabla['t_6'] = array("t_1" => generadorNegritas($lblSitioWeb), "t_2" => $row['emp_sitio_web']);
//                        $tabla['t_7'] = array("t_1" => generadorNegritas($lblEstado), "t_2" => ($row['emp_estado']=="A" ? "Activo" : "Inactivo"));
                        //$tabla['t_8'] = array("t_1" => generadorNegritas($lblCorreo), "t_2" => getFormatoFechadmyhis($row['emp_correo_principal']));
                      //  $tabla['t_9'] = array("t_1" => generadorNegritas($lblTM), "t_2" =>getFormatoFechadmyhis($row['emp_movil']));
                        $tabla['t_16'] = array("t_1" => generadorNegritas($lblResena), "t_2" => $resena);

//                        
                        $tabla3['t_12'] = array("t_1" => generadorNegritas($lblPais), "t_2" => $row['pai_nombre']);
                        $tabla3['t_13'] = array("t_1" => generadorNegritas($lblProvincia), "t_2" => $row['est_nombre']);
                        $tabla3['t_14'] = array("t_1" => generadorNegritas($lblCiudad), "t_2" => $row['ciu_nombre']);
                        $tabla3['t_15'] = array("t_1" => generadorNegritas($lblDireccion), "t_2" => $row['emp_txtadicional_1']);
                        
                        $tabla4['t_8'] = array("t_1" => generadorNegritas($lblFRegistro), "t_2" => getFormatoFechadmyhis($row['emp_fecharegistro']));
                        $tabla4['t_9'] = array("t_1" => generadorNegritas($lblFModificacion), "t_2" =>getFormatoFechadmyhis($row['emp_fechamodificacion']));
                        $tabla4['t_10'] = array("t_1" => generadorNegritas($lblUModificar), "t_2" =>$modificador);
                        
//                         `direccion_id`, `emp_correo_principal`, `emp_movil`, `emp_txtadicional_1`, `emp_txtadicional_2`
                        
                     }
                     
                    $objEmpresaLocal= new EmpresaLocal();
                    $tabla_emp_ind = array();
                    $tabla_emp_ind= $objEmpresaLocal->getMultiListaIndustria2($_POST['id'], NULL, generadorNegritas($lblSectores));     

                     
                    $cuerpo='';
                    $cont= 1;
                    $objEmpresaLocal= new EmpresaLocal();
                    $resultset= $objEmpresaLocal->getEmpresaLocalMasMiembros($_POST['id']);
                    while ($row = $resultset->fetch_assoc()) {                     
                       $cuerpo.= generadorTablaColoresFilas("" ,
                               array(
                                   $cont,
                                   $row['per_nombre'] ." ". $row['per_apellido'],
                                   $row['movil'],
                                   $row['correo']));   
                         $cont= $cont + 1; 
                     }
  

                    $tablaDetalleMiembros= generadorTablaDetalleEstadoCuenta(
                        array( "N°",
                            generadorNegritas($lblNombre),
                            generadorNegritas($lblTM),
                            generadorNegritas($lblCorreo)), $cuerpo);
                    
                    $cuerpo='';
                    $cont= 1;
                    $objPAMAsistente = new PAMAsistente();
                    $tablaDetalleContactos = "";
                    $tablaDetalleContactos = $objPAMAsistente->getTablaSinEdicion($miembro_id, '1');
                    /*$objEmpresaLocal= new EmpresaLocal();
                    $resultset= $objEmpresaLocal->getEmpresaContactos($_POST['id']);
                    while ($row = $resultset->fetch_assoc()) { 
                       //$acciones='';
                       //$acciones= str_replace("*", "'", generadorTablaAcciones(getAction($row['conta_id'],$row['per_nombre'],$row['per_apellido'],$row['movil'],$row['correo']))); 
                       $cuerpo.= generadorTablaColoresFilas("" ,
                               array(
                                   $cont,
                                   $row['per_nombre'] ." ". $row['per_apellido'],
                                   $row['cargo'],
                                   $row['movil'],
                                   $row['fijo'],
                                   $row['correo'],
                                   getAccionesParametrizadas(
                                           "getActualizarContacto(".$_POST['id'].",".$row['conta_id'].",'".$row['per_nombre']."','".$row['per_apellido']."','".$row['movil']."','".$row['correo']."',".$row['cargo_id'].",'".$row['fijo']."')",
                                           "modal_getActualizarContacto",
                                           "Actualizar",
                                           "fa fa-pencil")));   
                         $cont= $cont + 1; 
                     }//($codigo='', $nombre, $apellido, $movil, $correo)
   

                    $tablaDetalleContactos= generadorTablaDetalleEstadoCuenta(
                        array( "N°",
                            generadorNegritas($lblNombre),
                            generadorNegritas($lblCategoría),
                            generadorNegritas($lblTM),
                            generadorNegritas($lblTF),
                            generadorNegritas($lblCorreo),
                            generadorNegritas("Acción")), $cuerpo);*/
      
                    $boton_agregar_contacto='';
                    if (in_array($perCrearContactoOp8, $_SESSION['usu_permiso'])) {
                      /*  $boton2['boton_3'] = array("elemento" => "boton" ,"modal" => "#modal_getCrearContacto"  ,"color" => "btn-info" ,"click" => "getAgregarContacto(".$_POST['id'].")" ,"titulo" => $lblAgregarContacto ,"lado" => "pull-right" ,"icono" => "fa-user");
                        $boton_agregar_contacto= generadorBoton($boton2);*/
                        
                    }                                           
                    if (in_array($perActualizarEmpresaOp8, $_SESSION['usu_permiso'])) {
                       $boton['boton_4'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getActualizar(".$_POST['id'].")" ,"titulo" => $lblbtnEditar ,"lado" => "pull-right" ,"icono" => "fa-pencil"); 
                    }
                    $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");
                    if($boton2 != '' ){
                        
                    }
                    $resultado = str_replace("{contenedor_1}", generadorTabla_2($tabla, "table-striped"), getPage('page_detalle'));//generadorContMultipleRow($colum)); 
                    $resultado = str_replace("{contenedor_2}", generadorTabla_2($tabla_emp_ind, "table-striped"), $resultado); 
                    $resultado = str_replace("{contenedor_5}", generadorTabla_2($tabla3, "table-striped"), $resultado); 
                    $resultado = str_replace("{contenedor_6}", generadorTabla_2($tabla4, "table-striped"), $resultado);
                    $resultado = str_replace("{contenedor_3}", $tablaDetalleMiembros, $resultado); 
                    $resultado = str_replace("{contenedor_4}", $tablaDetalleContactos, $resultado); 
                    $resultado = str_replace("{boton}", generadorBoton($boton), $resultado); 
                    $resultado = str_replace("{boton_contactos}", $boton_agregar_contacto, $resultado); 
                    echo $resultado;
                }
             break;
            case 'KEY_SHOW_FORM_ACTUALIZAR'://///////////////////////////////////////////////////////// 
                if(!empty($_POST['id']) ){ 
                    
                    $objEmpresaLocal= new EmpresaLocal();
                    $resultset= $objEmpresaLocal->getEmpresaLocal($_POST['id']);
                    if($row = $resultset->fetch_assoc()) {    
                        $boton['boton_4'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "setActualizar(".$_POST['id'].")" ,"titulo" => $lblbtnGuardar ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                        $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getDetalle(".$_POST['id'].")" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");     
                        
                         //$objIndustria= new Industria();
                        $listaIndustria= array();
                        $objEmpresaLocal= new EmpresaLocal();
                        $listaIndustria= $objEmpresaLocal->getMultiListaIndustria($_POST['id']);
                        
                          //Direccion 
                        $objPais= new Pais();
                        $listapais= $objPais->getListaPais($row['pai_id'],NULL);

                        $objProvincia=new Provincia();
                        $objProvincia->setIdPais($objPais->getIdPais());
                        $listaprov=  $objProvincia->getListaProvincia($row['est_id']);

                        $objCiudad= new Ciudad();
                        $objCiudad->setIdProvincia($objProvincia->getIdProvincia());
                        $listaciudad=$objCiudad->getListaCiudad($row['ciu_id']);
                        
                        //Formularios
                        $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblEmpresa), "id" => "_empresa" ,"reemplazo" => $row['emp_nombre']);
                        $form['form_2'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => "RUC", "id" => "_ruc" ,"reemplazo" => $row['emp_ruc']);
                        //$form['form_3'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => $lblIngresosAnuales, "id" => "_ingresos" ,"reemplazo" => $row['emp_imgresos']);
                        //$form['form_4'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => $lblNEmpleados, "id" => "_numero_empleados" ,"reemplazo" =>  $row['emp_num_empleados']);
                        //$form['form_5'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblFax, "id" => "_fax" ,"reemplazo" => $row['emp_fax']);
                        $form['form_6'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblSitioWeb, "id" => "_sitio_web" ,"reemplazo" => $row['emp_sitio_web']);
                        $form['form_7'] = array("elemento" => "lista-multiple",                   "titulo" => generadorAsterisco($lblIndustria), "id" => "_industria", "option" => $listaIndustria);
                        //$form['form_8'] = array("elemento" => "combo","change" => "",  "titulo" => "Estado", "id" => "_estado", "option" => generadorComboEstado(($row['emp_estado']=="A" ? "Activo" : "Inactivo"))); 
                        //$form['form_8'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCorreo, "id" => "_correo1" ,"reemplazo" => $row['emp_correo_principal']);
                        //$form['form_9'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblTM, "id" => "_movil" ,"reemplazo" => $row['emp_movil']);
                        //$form['form_16'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblResena, "id" => "_resena" ,"reemplazo" => $row['emp_resena']);


                        $form['form_12'] = array("elemento" => "combo","change" => "getCargarPaises()","titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
                        $form['form_13'] = array("elemento" => "combo", "change" => "getCargarProvincias()", "titulo" => $lblProvincia, "id" => "_provincia", "option" => $listaprov);
                        $form['form_14'] = array("elemento" => "combo","change" => "", "titulo" => $lblCiudad, "id" => "_ciudad", "option" => $listaciudad);
                        $form['form_15'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" =>$lblCalle, "id" => "_calle" ,"reemplazo" => $row['emp_txtadicional_1']);
                        
                        $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );    
                        $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);  
                        $resultado = str_replace("{cabecera}", "Editar Empresa", $resultado);  
                    }                 
                   echo $resultado; 
               }
                  break;
            case 'KEY_SHOW_FORM_GUARDAR':  
                
                $objIndustria= new Industria();               
                $listaIndustria= $objIndustria->getListaIndustrias(NULL);
                
                 //Direccion 
                 $objPais= new Pais();
                 $listapais= $objPais->getListaPais(NUll,NULL);
                 $prefijoPais= $objPais->getPrefijoPais();
                 $objProvincia=new Provincia();
                 $objProvincia->setIdPais($objPais->getIdPais());
                 $listaprov=  $objProvincia->getListaProvincia(NULL);

                 $objCiudad= new Ciudad();
                 $objCiudad->setIdProvincia($objProvincia->getIdProvincia());
                 $listaciudad=$objCiudad->getListaCiudad();
                 
                $boton['boton_2'] = array("click" => "setCrear('g',1)" ,"modal" => ""  ,"color" => "btn-info" ,"titulo" =>$lblbtnGuardar ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_3'] = array("click" => "setCrear('gn',1)" ,"modal" => ""  ,"color" => "btn-info" ,"titulo" => $lblbtnGuardarNuevo ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_4'] = array("click" => "getRecargar()" ,"modal" => ""  ,"color" => "btn-info" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");

                //Formularios
                $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblEmpresa), "id" => "_empresa" ,"reemplazo" => "");
                $form['form_2'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => "RUC", "id" => "_ruc" ,"reemplazo" => "");
                
                //$form['form_4'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => $lblIngresosAnuales, "id" => "_ingresos" ,"reemplazo" => "");
                //$form['form_5'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => $lblNEmpleados, "id" => "_numero_empleados" ,"reemplazo" => "");
                $form['form_6'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblFax, "id" => "_fax" ,"reemplazo" => "");
                $form['form_7'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblSitioWeb, "id" => "_sitio_web" ,"reemplazo" => "");
                $form['form_8'] = array("elemento" => "lista-multiple","titulo" => generadorAsterisco($lblIndustria), "id" => "_industria", "option" => $listaIndustria);
                //$form['form_9'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCorreo, "id" => "_correo1" ,"reemplazo" => "");
                //$form['form_10'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblTM, "id" => "_movil" ,"reemplazo" => "");
                //$form['form_16'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblResena, "id" => "_resena" ,"reemplazo" => "");

                
                $form['form_12'] = array("elemento" => "combo","change" => "getCargarPaises()","titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
                $form['form_13'] = array("elemento" => "combo", "change" => "getCargarProvincias()", "titulo" => $lblProvincia, "id" => "_provincia", "option" => $listaprov);
                $form['form_14'] = array("elemento" => "combo","change" => "", "titulo" => $lblCiudad, "id" => "_ciudad", "option" => $listaciudad);
                $form['form_15'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" =>$lblCalle, "id" => "_calle" ,"reemplazo" => "");
 
                //$form['form_9'] = array("elemento" => "combo","change" => "",  "titulo" => "Estado", "id" => "_estado", "option" => generadorComboEstado("Activo"));  
                $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );//generadorContMultipleRow($colum));      
                $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);  
                $resultado = str_replace("{cabecera}", "Crear Empresa", $resultado);   
                echo $resultado;
                break;
            case 'KEY_SHOW_FORM_GUARDAR_MODAL':  
                
                $objIndustria= new Industria();               
                $listaIndustria= $objIndustria->getListaIndustrias(NULL);

                 
                $boton['boton_2'] = array("id" => 'btnCrearPAME',"click" => "setCrearPAME('".$_POST['_tipo']."')" ,"modal" => ""  ,"color" => "btn-primary" ,"titulo" =>$lblbtnGuardar ,"lado" => "pull-right" ,"icono" => "");

                //Formularios
                $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblEmpresa), "id" => "_empresa_modal_empresa" ,"reemplazo" => "");
                $form['form_2'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => "RUC", "id" => "_ruc_modal_empresa" ,"reemplazo" => "");
                
                $form['form_8'] = array("elemento" => "lista-multiple","titulo" => generadorAsterisco($lblIndustria), "id" => "_industria_modal_empresa", "option" => $listaIndustria);
				//  $form['form_9'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblResena, "id" => "_resena_modal_empresa" ,"reemplazo" => "");
				  
                //$form['form_16'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_correo1_modal_empresa" ,"reemplazo" => "");
                //$form['form_10'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_movil_modal_empresa" ,"reemplazo" => "");
                $form['form_15'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_calle_modal_empresa" ,"reemplazo" => "");
				
				
       //         $form['form_9'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCorreo, "id" => "_correo1_modal_empresa" ,"reemplazo" => "");
       //         $form['form_10'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblTM, "id" => "_movil_modal_empresa" ,"reemplazo" => "");
       //         $form['form_15'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" =>$lblCalle, "id" => "_calle_modal_empresa" ,"reemplazo" => "");
                //$form['form_9'] = array("elemento" => "combo","change" => "",  "titulo" => "Estado", "id" => "_estado", "option" => generadorComboEstado("Activo"));  
//                $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );//generadorContMultipleRow($colum));      
//                $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);  
//                $resultado = str_replace("{cabecera}", "Crear Empresa", $resultado);   
                echo generadorModal('Agregar Empresa', 'modalPAMAgregarEmpresa', generadorEtiquetaVVertical($form), generadorBotonVModal($boton));
                break;
            case 'KEY_GUARDAR': 
//                $data = array("success" => "false", "priority"=>'info',"msg" => $_POST['_tipo']); 
//                                 echo json_encode($data);
//                                exit();
                if(!empty($_POST['_industria'])   && !empty($_POST['_empresa'])  && !empty($_POST['key_operacion'])){ 

                    $lista="";
                    foreach($_POST['_industria'] as $valor){
                        $lista.= $valor.",";
                    }

         
                    $objEmpresaLocal= new EmpresaLocal();
                    $comp= $objEmpresaLocal->setCrearEmpresaLocal($_POST['_bandera'], $_POST['_empresa'], 'A',  $_SESSION['user_id_ben'],$_POST['_ingresos'],$_POST['_ruc'] ,
                            $_POST['_numero_empleados'], $lista,$_POST['_fax'], $_POST['_sitio_web'],$_POST['_correo1'], $_POST['_movil'],
                            $_POST['_ciudad'], $_POST['_calle'],'',$_POST['_resena']);  
                    if($_POST['_bandera'] == '1'){

                        if($comp == "OK"){
                            if($_POST['key_operacion']=='gn'){
                              $data = array("success" => "true_gn", "priority"=>'success',"msg" => 'La Empresa se creo correctamente!');  
                              echo json_encode($data);              
                           }  else {
                              $data = array("success" => "true_g", "priority"=>'success',"msg" => 'La Empresa se creo correctamente!');  
                              echo json_encode($data); 
                           }
                        }else{
                            $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                            echo json_encode($data);
                        }
                    }else{
                        if($comp != "0"){    
                            //Cuando se crea y enlaza una empresa con un miembro o prosecto
                            
                            if($_POST['_tipo'] == '2'){
                                $objEmpresaLocal= new EmpresaLocal();
                                $comp= $objEmpresaLocal->setAdd( $_SESSION['_ultimo_id_miembro_prospecto'], $comp, '',
                                        $_SESSION['user_id_ben'],$_SESSION['_ultimo_id_miembro_prospecto_bandera'],'1');     
                                    if($comp == "OK"){//_ultimo_id_miembro_prospecto
                                        $data = array("success" => "true", "priority"=>'success',"_ultimo_id_miembro_prospecto" => $_SESSION['_ultimo_id_miembro_prospecto']);
                                        echo json_encode($data);
                                    }else{
                                        $data = array("success" => "false", "priority"=>'success',"_ultimo_id_miembro_prospecto" => $_SESSION['_ultimo_id_miembro_prospecto']);
                                        echo json_encode($data);
                                    }
//                                 $data = array("success" => "false", "priority"=>'info',"msg" => $_POST['_tipo']); 
//                                 echo json_encode($data);
                                exit();
                                
                            }
                        
                            
                            $objEmpresaLocal= new EmpresaLocal();
                            $listaEmpresas= $objEmpresaLocal->getListaEmpresa($comp);
                            $data = array("success" => "true", "lista_empresas"=> generadorComboSelectOption("_id_empresa", "",$listaEmpresas));  
                            echo json_encode($data); 

                        }else{
                            $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                            echo json_encode($data);
                        }
                    }
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data); 
                }
                break;  
            case 'KEY_ACTUALIZAR':
                if(!empty($_POST['_industria'])   && !empty($_POST['_empresa']) ){ 
                    $lista="";
                    foreach($_POST['_industria'] as $valor){
                        $lista.= $valor.",";
                    } 
                    $objEmpresaLocal= new EmpresaLocal();
                    $comp= $objEmpresaLocal->setActualizarEmpresaLocal( $_POST['_id'], $_POST['_empresa'], 'A',  $_SESSION['user_id_ben'],
                            $_POST['_ingresos'],$_POST['_ruc'] ,$_POST['_numero_empleados'], $lista, $_POST['_fax'],$_POST['_sitio_web'],
                            $_POST['_correo1'], $_POST['_movil'],$_POST['_ciudad'], $_POST['_calle'],'',$_POST['_resena']);   
                        if($comp == "OK"){
                            $data = array("success" => "true", "priority"=>'success',"msg" => 'La Empresa se actualizo correctamente!');
                            echo json_encode($data);
                        }else{
                            $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                            echo json_encode($data);
                        }
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data); 
                }
  
               break;
            case 'KEY_GUARDAR_CONTACTO':///////////////////////////////////////////////////////////   

                 if( !empty($_POST['_id_contacto_empresa']) && !empty($_POST['_nombre_contacto_empresa'])  && !empty($_POST['_funcion_contacto_empresa']) 
                        && !empty($_POST['_apellido_contacto_empresa']) ){ 
                    $objEmpresaLocal= new EmpresaLocal();
                    $comp= $objEmpresaLocal->setCrearEmpresaContacto( $_POST['_id_contacto_empresa'], $_POST['_nombre_contacto_empresa'], $_POST['_apellido_contacto_empresa'],
                            $_SESSION['user_id_ben'],$_POST['_correo_contacto_empresa'],$_POST['_movil_contacto_empresa'], $_POST['_funcion_contacto_empresa'], $_POST['_fijo_contacto_empresa']);     
                        if($comp == "OK"){
                            $data = array("success" => "true", "priority"=>'success',"msg" => 'El Contacto se creo correctamente!');
                            echo json_encode($data);
                        }else{
                            $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                            echo json_encode($data);
                        }
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data); 
                }
  
               break;
            case 'KEY_ACTUALIZAR_CONTACTO': 
                if( !empty($_POST['_id_contacto_empresa']) && !empty($_POST['_nombre_contacto_empresa']) && !empty($_POST['_funcion_contacto_empresa']) 
                         && !empty($_POST['_apellido_contacto_empresa']) ){ 
             
                    $objEmpresaLocal= new EmpresaLocal();
                    $comp= $objEmpresaLocal->setActualizarEmpresaContacto( $_POST['_id_contacto_empresa'], $_POST['_nombre_contacto_empresa'], $_POST['_apellido_contacto_empresa'],
                            $_SESSION['user_id_ben'],$_POST['_correo_contacto_empresa'],$_POST['_movil_contacto_empresa'], $_POST['_funcion_contacto_empresa'], $_POST['_fijo_contacto_empresa']);  
                        if($comp == "OK"){
                            $data = array("success" => "true", "priority"=>'success',"msg" => 'El Contacto se actualizo correctamente!');
                            echo json_encode($data);
                        }else{
                            $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                            echo json_encode($data);
                        }
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data); 
                }
  
               break;
               
            case 'KEY_SHOW_FILTRO':
                if(!empty($_POST['_key_filtro']) && !empty($_POST['_filtro']) && strlen($_POST['_mostrar_todas']) > 0){ 
                    $permiso= $_SESSION['user_id_ben'];                    
                    if (in_array($perVerTodosEmpresasOp8, $_SESSION['usu_permiso'])) {
                       $permiso= '';
                    }
                    
                    
                    $id="";           
                    if($_POST['_filtro'] == "x"){
                         $tabla= getTablaFiltrada("","",$permiso,$_POST['_mostrar_todas']);
                    }else{
                        $tabla= getTablaFiltrada($_POST['_filtro'], $_POST['_key_filtro'],$permiso,$_POST['_mostrar_todas']);
                    }                    
                    if($_POST['_key_filtro'] == "1"){
                        $objGrupo= new Grupo();
                        $resultset= $objGrupo->getIDGrupoxForum($_POST['_filtro']);
                        if($row = $resultset->fetch_assoc()) { 
                          $id= $row["gru_forum"];
                        }
                    }
                    if($_POST['_key_filtro'] == "2"){
                        $objGrupo= new Grupo();
                        $resultset= $objGrupo->getIDForumxGrupo($_POST['_filtro']);
                        if($row = $resultset->fetch_assoc()) { 
                          $id= $row["gru_id"];
                        }
                    }
                                           
                    $data = array("success" => "true", 
                        "tabla" => $tabla,
                        "id" => $id);  
                    echo json_encode($data); 
                
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'No existen datos!');  
                    echo json_encode($data); 
                }

            break;

        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
    
     exit(); 
}

            
            
//function getTablaEmpresasForum($idForum) {
//    
//    global $lblEmpresa,$lblFRegistro,$lblFModificacion;
//    global $perCrearEmpresaOp8, $perVerDetalleOp8;
//    
//    $objEmpresaLocal= new EmpresaLocal();
//    $cuerpo='';
//    $cont=1;
//    $resultset= $objEmpresaLocal->getEmpresasLocal($idForum);
//    while($row = $resultset->fetch_assoc()) { 
//        $verDetalle='';
//        if (in_array($perVerDetalleOp8, $_SESSION['usu_permiso'])) {
//           $verDetalle='getDetalle('.$row['emp_id'].')';
//        }
//        $cuerpo.= generadorTablaFilas(array(
//            "<center>".$cont."</center>",
//            generadorLink($row['nombre_empresa'],$verDetalle),
//            $row['fecha_registro'],
//            $row['fecha_modificación']));   
//        $cont=$cont + 1;
//    }    
//    $funcion='';
//    if (in_array($perCrearEmpresaOp8, $_SESSION['usu_permiso'])) {
//       $funcion='getCrear()';
//    }
//    $t= generadorTabla_(1, $lblEmpresa,$funcion, array( "<center>N°</center>",$lblEmpresa,$lblFRegistro,$lblFModificacion), $cuerpo);
//    return $t;
//}
//
//$t="";
//if (in_array($perVerTodosEmpresasOp8, $_SESSION['usu_permiso'])) {
//    $t= getTablaEmpresasForum(NULL);
//    
//}  elseif (in_array($perVerEmpresasIDForumOp8, $_SESSION['usu_permiso'])) {
//    $t= getTablaEmpresasForum($_SESSION['user_id_ben']);
//    
//}


////////////////////////////////////////////////////////////////////////////////
$t='';
if (in_array($perVerTodosEmpresasOp8, $_SESSION['usu_permiso'])) {
    $tabla= getTablaFiltrada("","","",0);
    $resultado = str_replace("{fitros}", generadorEtiquetasFiltro(getFiltros()), generadorFiltro('Filtros','ben_contenedor_filtro')); 
    $resultado = str_replace("{cuerpo}", $tabla, $resultado);  
    $t=$resultado;
      
}  elseif (in_array($perVerEmpresasIDForumOp8, $_SESSION['usu_permiso'])) {
   
    $tabla= getTablaFiltrada("","",$_SESSION['user_id_ben'],0);
    $resultado = str_replace("{fitros}", generadorEtiquetasFiltro(getFiltros()), generadorFiltro('Filtros','ben_contenedor_filtro')); 
    $resultado = str_replace("{cuerpo}", $tabla, $resultado);  
    $t=$resultado;
}


function getFiltros() {
    global  $perVerTodosEmpresasOp8;
    $lista['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");
    if (in_array($perVerTodosEmpresasOp8, $_SESSION['usu_permiso'])) {
        
        $objForum = new ForumLeader();
        $listaForum=$objForum->getListaForumLeaders2(NULL,$lista);
        $form['form_2'] = array("elemento" => "combo","change" => "getFiltro('2')", "titulo" => "Forum Leader", "id" => "_forum", "option" => $listaForum); 
        
      /*  $objGrupo= new Grupo();
        $listaGrupos= $objGrupo->getListaGrupos2(NULL,$lista);
        $form['form_1'] = array("elemento" => "combo","change" => "getFiltro('1')", "titulo" => "Grupos", "id" => "_grupo", "option" => $listaGrupos); 
*/
       
    }
   
    $objIndustria = new Industria();
    $listaIndustrias=$objIndustria->getListaIndustrias2(NULL, $lista);
    $form['form_4'] = array("elemento" => "combo","change" => "getFiltro('4')", "titulo" => "Industrias", "id" => "_industria", "option" => $listaIndustrias); 
    $form['form_5'] = array("elemento" => "Checkbox-comun", "id" => "_mostrar_todas", 
    "chec" => "onChange='getMostrarTodas()'", "titulo" => "Mostrar todas las empresas");
    
    return $form;
    
}


function getTablaFiltrada($id, $key, $idForum, $mostrarTodas) {
    global $lblEmpresa,$lblFRegistro,$lblFModificacion;
    global $perCrearEmpresaOp8, $perVerDetalleOp8;
    
    $objEmpresaLocal= new EmpresaLocal();
    $cuerpo='';
    $cont=1;
    $resultset= $objEmpresaLocal->getFiltros2($id, $key,$idForum,$mostrarTodas);//getFiltros($id, $key, $permiso)
    while($row = $resultset->fetch_assoc()) { 
        $verDetalle='';
        if (in_array($perVerDetalleOp8, $_SESSION['usu_permiso'])) {
           $verDetalle='getDetalle('.$row['emp_id'].')';
        }
        $cuerpo.= generadorTablaFilas(array(
            "<center>".$cont."</center>",
            generadorLink($row['nombre_empresa'],$verDetalle)));   
        $cont=$cont + 1;
    }    
    $funcion='';
    if (in_array($perCrearEmpresaOp8, $_SESSION['usu_permiso'])) {
       $funcion='getCrear()';
    }
    $tabla= generadorTabla_(1, $lblEmpresa,$funcion, array( "<center>N°</center>",$lblEmpresa), $cuerpo);
    return $tabla;
    
}

$objCargo= new Categoria();
$lista= $objCargo->getListaCategoria("");
$listaFuncion = generadorComboSelectOption("_funcion_contacto_empresa", "",$lista);
$listaFuncion2 = generadorComboSelectOption("_funcion_contacto_empresa_u", "",$lista);
