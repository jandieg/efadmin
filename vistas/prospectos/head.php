<?php

require_once MODELO.'Industria.php';
require_once MODELO.'Hobby.php';
require_once MODELO.'Prospecto.php';
require_once MODELO.'ForumLeader.php';
require_once MODELO.'Usuario.php';
require_once MODELO.'Profesion.php';
require_once MODELO.'Fuente.php';
require_once MODELO.'Pais.php';
require_once MODELO.'Provincia.php';
require_once MODELO.'Direccion.php';
require_once MODELO.'Ciudad.php';
require_once MODELO.'EstadoProspecto.php';
require_once MODELO.'Categoria.php';

require_once MODELO.'Desafio.php';
require_once MODELO.'EmpresaLocal.php';
require_once MODELO.'StatusMember.php';
require_once MODELO.'EmpresaLocal.php';
require_once MODELO.'PAMAsistente.php';
include(HTML."/html.php");
include(HTML."/html_filtros.php");
include(HTML."/html_combos.php");
require_once(LENGUAJE."/lenguaje_1.php");
require_once E_LIB.'Mail.php';

$objProspesto;$objProfesion;$objFuente;$objEstadoProspecto;$objIndustria;$objCategoria;$objPais;$objProvincia;$objCiudad;
$objDesafio;$objRedSocial;$objUsuario;$objForum;$objDireccion;$objEmpresaLocal;$idDireccion='';$idCiudad='';$idEstado='';
$idPais='';$direccion= '';$titulo='';$idpersona='';$empresa='';$msg='';$ciudad='';$estado='';$pais='';$direcion='';$prefijoPais='';


function getDetalleUpdate($id, $recargar) {
    global $idDireccion,$idCiudad,$idEstado,$idPais,$direccion,$titulo,$idpersona,$empresa,$msg,$ciudad,$estado,$pais,$direcion,$prefijoPais;

    $objProspesto= new Prospecto();
    $resultset= $objProspesto->getProspecto($id);  
    if($row = $resultset->fetch_assoc()) { 
  
        $idpersona=$row['per_id'];
      
        $objProfesion= new Profesion();                
        $listaprofe=  $objProfesion->getListaprofesion($row['Profesion_prof_id']);

        $objFuente= new Fuente();   
        $listafuente=  $objFuente->getListaFuentes($row['fuente_fue_id']);
        
        $listaEP['lista_'] = array("value" => "0",  "select" => "" ,"texto" => "Seleccionar...");
        $objEstadoProspecto= new EstadoProspecto();
        $listaestadoprospecto=  $objEstadoProspecto->getListaEstadoProspecto($row['estadoprospecto_estpro_id'],$listaEP);  

        $objCategoria= new Categoria();                    
        $listacategoria=  $objCategoria->getListaCategoria($row['categoria_cat_id']);
        
        $objForum= new ForumLeader();
        $listaForumLeader= $objForum->getListaForumLeaders($row['forum_usu_id']);
        
        $estadoprospecto='';
         if($_SESSION['_esaplicante'] == '1'){
            $listaStatus['lista_'] = array("value" => "x",  "select" => "" ,"texto" => "Seleccionar...");
            $objStatus= new StatusMember();
            $listaStatus= $objStatus->getListaAplicante($listaStatus);
            $estadoprospecto='Estado del Aplicante';
         }else{
            $listaStatus['lista_'] = array("value" => "x",  "select" => "" ,"texto" => "Seleccionar...");
            $objStatus= new StatusMember();
            $listaStatus= $objStatus->getListaAplicante($listaStatus);
            $estadoprospecto='Estado del Prospecto';
         }
        
        $direcionsql= new Direccion();
        $resultset_direcionsql= $direcionsql->getDireccion($row['per_id']);
        if ($row_direcionsql = $resultset_direcionsql->fetch_assoc()) {
            $idDireccion=$row_direcionsql['dir_id'];
            $idCiudad=$row_direcionsql['ciu_id'];
            $idEstado=$row_direcionsql['est_id'];
            $idPais=$row_direcionsql['pai_id'];
            $direccion= $row_direcionsql['dir_calleprincipal'];
            $prefijoPais=$row_direcionsql['pai_prefijo'];
        }

        //Direccion 
        $objPais= new Pais();
        $listapais= $objPais->getListaPaisAplicante($_SESSION['pais_id'],NULL);

        $objProvincia=new Provincia();
        $objProvincia->setIdPais($objPais->getIdPais());
        $listaprov=  $objProvincia->getListaProvincia($idEstado);

        $objCiudad= new Ciudad();
        $objCiudad->setIdProvincia($objProvincia->getIdProvincia());
        $listaciudad=$objCiudad->getListaCiudad($idCiudad);
        
        $objProspesto= new Prospecto();
        $listadesafio= $objProspesto->getMultiListaDesafios($id);
        $objProspesto= new Prospecto();
        $listahobby= $objProspesto->getMultiListaHobbies($id);
        
		
        $objEmpresaLocal= new EmpresaLocal();
		
        $listaEmpresas= $objEmpresaLocal->getListaEmpresa($row['emp_id']);
        
        $correo_1= $row['correo']; 
        $correo_2= $row['correo2']; 
        $t_fijo= $row['movil2']; 
        $t_movil= $row['movil'];
        $redSkype= $row['skype']; 
        $redTwitter= $row['twitter'];
                                                                                    
        global $lblForumLeader,$lblNombre, $lblApellido , $lblTipoPersona, $lblIdentificacion, $lblGenero,
                $lblTitulo,$lblFNacimiento, $lblCorreo, $lblCorreoSecundario, $lblTF, $lblTM, $lblEmpresa,
                $lblIngresosAnuales,$lblNEmpleados,$lblNEmpleados,$lblIndustria,$lblFax, $lblSitioWeb, $lblCategoría, $lblFuente, $lblEstadoProspecto,
                $lblSkype,$lblTwitter,$lblParticipacionCorreo,$lblCiudad, $lblCalle, $lblPais, $lblProvincia, $lblDescDesafios, $lblListaDesafios,
                $lblbtnGuardar, $lblbtnRegresar,$lblListaHobbies, $lblEmpresa;
        //Formularios
        //$form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Código", "id" => "_codigo" ,"reemplazo" => $row['prosp_codigo']);
        $form['form_2'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblNombre), "id" => "_nombre" ,"reemplazo" => $row['per_nombre']);
        $form['form_3'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblApellido), "id" => "_apellido" ,"reemplazo" => $row['per_apellido']);
        $form['form_4'] = array("elemento" => "caja", "titulo" => generadorAsterisco($lblEmpresa), "id" => "_id_empresa", "reemplazo" => "");
        if($_SESSION['_esaplicante'] == '1'){
        $form7['form_4'] = array("elemento" => "caja" ,"tipo" => "hidden" ,  "id" => "_tipo_p" ,"reemplazo" => $row['per_tipo']);      
        $form['form_5'] = array("elemento" => "caja" ,"tipo" => "hidden" ,  "id" => "_identificacion" ,"reemplazo" => $row['per_identificacion']);      
        //$form['form_6'] = array("elemento" => "combo","change" => "", "titulo" => $lblGenero, "id" => "_genero", "option" => generadorComboGenero($row['per_genero']));
        
        $form['form_7'] = array("elemento" => "caja", "tipo" => "hidden","id" => "_titulo", "reemplazo" => "1");
        //$form['form_8'] = array("elemento" => "caja" ,"tipo" => "date" , "titulo" => $lblFNacimiento, "id" => "_fn" ,"reemplazo" => $row['per_fechanacimiento']);
        $form_1= generadorEtiqueta($form);
        
        $form7['form_9'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCorreo, "id" => "_correo" ,"reemplazo" => $correo_1);
        $form7['form_10'] = array("elemento" => "caja" ,"tipo" => "hidden", "id" => "_correo_2" ,"reemplazo" => $correo_2);
        
        if($row['participacion_correo']=='1'){
              $form7['form_12'] = array("elemento" => "Checkbox-color" ,"tipo" => "" ,"chec" => "checked", "titulo" => $lblParticipacionCorreo, "id" => "_participacion" ,"reemplazo" => '');
        }  else {
             $form7['form_12'] = array("elemento" => "Checkbox-color" ,"tipo" => "" ,"chec" => "", "titulo" => $lblParticipacionCorreo, "id" => "_participacion" ,"reemplazo" => '');
      
        }
        $form_7= generadorEtiqueta($form7);
        $form8['form_13'] = array("elemento" => "caja pequeña + caja" ,"titulo" => $lblTF
                                                       ,"disabled_1" => "disabled","tipo_1" => "text" , "titulo_1" => "Prefijo", "id_1" => "_prefijo_telefono" ,"reemplazo_1" => $prefijoPais
                                                       ,"disabled_2" => "","tipo_2" => "text" , "titulo_2" => $lblTF, "id_2" => "_telefono" ,"reemplazo_2" => $t_fijo);
                    
        $form8['form_14'] = array("elemento" => "caja pequeña + caja" ,"titulo" => $lblTM
                                           ,"disabled_1" => "disabled","tipo_1" => "text" , "titulo_1" => "Prefijo", "id_1" => "_prefijo_celular" ,"reemplazo_1" => $prefijoPais
                                           ,"disabled_2" => "","tipo_2" => "text" , "titulo_2" => $lblTM, "id_2" => "_celular" ,"reemplazo_2" => $t_movil);
		if($_SESSION['_esaplicante'] == '1'){
        $form8['form_15'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_id_skype" ,"reemplazo" => $redSkype);
        $form8['form_16'] = array("elemento" => "caja" ,"tipo" => "hidden" ,  "id" => "_id_Twitter" ,"reemplazo" => $redTwitter);
		}else{
        $form8['form_15'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblSkype, "id" => "_id_skype" ,"reemplazo" => $redSkype);
        $form8['form_16'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblTwitter, "id" => "_id_Twitter" ,"reemplazo" => $redTwitter);
		}
        $form_8= generadorEtiqueta($form8);
		}else{
			//Ocultando Datos//
//	$form['form_4'] = array("elemento" => "combo","change" => "", "titulo" => $lblTipoPersona, "id" => "_tipo_p", "option" => generadorComboTipoPersona_($row['per_tipo']));          
        $form7['form_4'] = array("elemento" => "caja" ,"tipo" => "hidden" ,  "id" => "_tipo_p" ,"reemplazo" => $row['per_tipo']);      
        $form['form_5'] = array("elemento" => "caja" ,"tipo" => "hidden" ,  "id" => "_identificacion" ,"reemplazo" => $row['per_identificacion']);      
        //$form['form_6'] = array("elemento" => "caja","tipo" => "hidden",  "id" => "_genero", "reemplazo" => $row['per_genero']);
        
        $form['form_7'] = array("elemento" => "caja", "tipo" => "hidden", "id" => "_titulo", "reemplazo" => "1");
        //$form['form_8'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_fn" ,"reemplazo" => $row['per_fechanacimiento']);
        $form_1= generadorEtiqueta($form);       
        $form7['form_9'] = array("elemento" => "caja" ,"tipo" => "hidden" ,  "id" => "_correo" ,"reemplazo" => $correo_1);
        $form7['form_10'] = array("elemento" => "caja" ,"tipo" => "hidden" ,  "id" => "_correo_2" ,"reemplazo" => $correo_2);
        
        if($row['participacion_correo']=='1'){
        //      $form7['form_12'] = array("elemento" => "Checkbox-color" ,"tipo" => "" ,"chec" => "checked", "titulo" => $lblParticipacionCorreo, "id" => "_participacion" ,"reemplazo" => '');
        }  else {
          //   $form7['form_12'] = array("elemento" => "Checkbox-color" ,"tipo" => "" ,"chec" => "", "titulo" => $lblParticipacionCorreo, "id" => "_participacion" ,"reemplazo" => '');
      
        }
        $form_7= generadorEtiqueta($form7);
        $form8['form_13'] = array("elemento" => "caja pequeña + caja" ,"titulo" => $lblTF
                                                       ,"disabled_1" => "disabled","tipo_1" => "hidden" ,  "id_1" => "_prefijo_telefono" ,"reemplazo_1" => $prefijoPais
                                                       ,"disabled_2" => "","tipo_2" => "hidden" ,  "id_2" => "_telefono" ,"reemplazo_2" => $t_fijo);
                    
        $form8['form_14'] = array("elemento" => "caja pequeña + caja" ,"titulo" => $lblTM
                                           ,"disabled_1" => "disabled","tipo_1" => "hidden" , "id_1" => "_prefijo_celular" ,"reemplazo_1" => $prefijoPais
                                           ,"disabled_2" => "","tipo_2" => "hidden" ,  "id_2" => "_celular" ,"reemplazo_2" => $t_movil);
		if($_SESSION['_esaplicante'] == '1'){
        $form8['form_15'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_id_skype" ,"reemplazo" => $redSkype);
        $form8['form_16'] = array("elemento" => "caja" ,"tipo" => "hidden" ,  "id" => "_id_Twitter" ,"reemplazo" => $redTwitter);
		}else{
     //   $form8['form_15'] = array("elemento" => "caja" ,"tipo" => "hidden" , "titulo" => $lblSkype, "id" => "_id_skype" ,"reemplazo" => $redSkype);
	 $form8['form_15'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_id_empresa" ,"reemplazo" => ""); 
        $form8['form_16'] = array("elemento" => "caja" ,"tipo" => "hidden" , "titulo" => $lblTwitter, "id" => "_id_Twitter" ,"reemplazo" => $redTwitter);
		}
        $form_8= generadorEtiqueta($form8);
		
		
}//end ocultar
       
 
        if($_SESSION['_esaplicante'] == '1'){
       $form2['form_1'] = array("elemento" => "combo","change" => "", "titulo" => generadorAsterisco($lblForumLeader), "id" => "_propietario", "option" => $listaForumLeader);
	   
        }else{
       $form2['form_1'] = array("elemento" => "caja","tipo" => "hidden", "id" => "_propietario", "reemplazo" => "57");
			
		}

        
        $form2['form_2'] = array("elemento" => "combo","change" => "","titulo" => generadorAsterisco($estadoprospecto), "id" => "_status", "option" => $listaStatus);
        $form2['form_3'] = array("elemento" => "combo", "change" => "",  "titulo" => generadorAsterisco($lblFuente), "id" => "_fuente", "option" => $listafuente);
        $form2['form_4'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Persona que Refiere", "id" => "_lafuente" ,"reemplazo" => '');
        if($_SESSION['_esaplicante'] == '1'){
         //   $form2['form_5'] = array("elemento" => "combo", "change" => "",  "titulo" => generadorAsterisco($lblEstadoProspecto), "id" => "_estado_propietario", "option" => $listaestadoprospecto); 
			$form2['form_5'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_estado_propietario" ,"reemplazo" => '1');
         
//        $form2['form_7'] = array("elemento" => "combo","combo","change" => "", "titulo" => "Empresa", "id" => "_id_empresa", "option" => $listaEmpresas);
        
		
		
			 
		//Cargos//
        $form2['form_8'] = array("elemento" => "caja","tipo" => "hidden", "id" => "_categoria", "reemplazo" => "1");
        //$form2['form_9'] = array("elemento" => "textarea" ,"tipo" => "text" , "titulo" => "Comentario", "id" => "_observacion" ,"reemplazo" => $row['prosp_observacion']);
        $form_2= generadorEtiqueta($form2);
		 }else{
 $form2['form_6'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Empresa", "id" => "_id_skype" ,"reemplazo" => $redSkype);       
 
 
	   //Cargos//
        $form2['form_8'] = array("elemento" => "caja","tipo" => "hidden", "id" => "_categoria", "reemplazo" => "1");
        //$form2['form_9'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_observacion" ,"reemplazo" => $row['prosp_observacion']);
		 //$form2['form_9'] = array("elemento" => "textarea" ,"tipo" => "text" , "titulo" => "Comentario", "id" => "_observacion" ,"reemplazo" => $row['prosp_observacion']);
        $form_2= generadorEtiqueta($form2);
		 }

        $form3['form_8'] = array("elemento" => "combo","change" => "", "titulo" =>$lblCiudad, "id" => "_ciudad", "option" => $listaciudad);
        $form3['form_9'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCalle, "id" => "_calle" ,"reemplazo" => $direccion);
        $form_3= generadorEtiqueta($form3);

        $form4['form_2'] = array("elemento" => "combo", "change" => "getCargarPaises()",  "titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
        $form4['form_9'] = array("elemento" => "combo","change" => "getCargarProvincias()","titulo" => $lblProvincia, "id" => "_provincia", "option" => $listaprov);
        $form_4= generadorEtiqueta($form4);

        $form5['form_2'] = array("elemento" => "lista-multiple",                   "titulo" => $lblListaHobbies, "id" => "_lista_hobbies", "option" => $listahobby);
        $form_5=generadorEtiqueta($form5);
                
        $form6['form_2'] = array("elemento" => "lista-multiple",                   "titulo" => $lblListaDesafios, "id" => "_lista_desafio", "option" => $listadesafio);
        $form_6= generadorEtiqueta($form6);

        $boton['boton_2'] = array("elemento" => "boton" ,"modal" => ""  ,"color" => "btn-info" ,"click" => "setUserActualizar(".$id.",".$idpersona.",'".$_SESSION['_esaplicante']."')" ,"titulo" => $lblbtnGuardar ,"lado" => "pull-right" ,"icono" => "fa-pencil");
        if($recargar){
            $boton['boton_1'] = array("elemento" => "boton" ,"modal" => ""  ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");
        }else{
            $boton['boton_1'] = array("elemento" => "boton" ,"modal" => ""  ,"color" => "btn-info" ,"click" => "getDetalle(".$id.")" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");
     
        }
       
        //$resultado = str_replace("{contenedor_1}", $form_1,  getPage('page_detalle_update'));
		if($_SESSION['_esaplicante'] == '1'){
        $resultado = str_replace("{contenedor_1}", $form_1,  getPage('page_detalle_update_aplicante'));
	   }else{
		   $resultado = str_replace("{contenedor_1}", $form_1,  getPage('page_detalle_update')); 
	   }
        $resultado = str_replace("{contenedor_2}", $form_2, $resultado); 
        $resultado = str_replace("{contenedor_3}", $form_4, $resultado); 
        $resultado = str_replace("{contenedor_4}", $form_3, $resultado); 
        $resultado = str_replace("{contenedor_5}", $form_6, $resultado); 
        $resultado = str_replace("{contenedor_6}", $form_5, $resultado);
        $resultado = str_replace("{contenedor_11}", $form_7, $resultado); 
        $resultado = str_replace("{contenedor_12}",$form_8, $resultado);
        $resultado = str_replace("{boton}",  generadorBoton($boton), $resultado);
        if($_SESSION['_esaplicante'] == '0'){
            $resultado = str_replace("{cabecera}",'Información del Prospecto', $resultado);
        }else{
            $resultado = str_replace("{cabecera}",'Información del Aplicante', $resultado);
        }
        return $resultado;
    }
    

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']): 
            case 'KEY_SHOW_FORM_ACTUALIZAR'://///////////////////////////////////////////////////////// 
                if(!empty($_POST['id']) ){ 
                    echo getDetalleUpdate($_POST['id'],FALSE);
                }
                break;     
            case 'KEY_SHOW_FORM_DETALLE'://///////////////////////////////////////////////////////// 
                if(!empty($_POST['id']) ){ 
                    $objProspesto= new Prospecto();
                    $resultset= $objProspesto->getProspecto($_POST['id']);  
                    if($row = $resultset->fetch_assoc()) {  
    
                        $idpersona=$row['per_id'];
                        $titulo= $row['per_nombre'].' '.$row['per_apellido'];

                        $objDireccion= new Direccion();
                        $resultset_direccion= $objDireccion->getDireccion($idpersona);
                        if ($row_direccion = $resultset_direccion->fetch_assoc()) { // `cor_id`, `cor_descripcion`
                            $direcion=$row_direccion['dir_calleprincipal'];
                            $ciudad=$row_direccion['ciu_nombre'];
                            $estado= $row_direccion['est_nombre'];
                            $pais= $row_direccion['pai_nombre'];
                            $prefijoPais=$row_direccion['pai_prefijo'];
                        }
                         $estadoprospecto=''; 
                        if($_SESSION['_esaplicante'] == '1'){
                           $estadoprospecto='Estado del Aplicante';
                        }else{
                           $estadoprospecto='Estado del Prospecto';
                        }

                        $tabla_desafios= array();
                        $objProspesto= new Prospecto();
                        $tabla_desafios= $objProspesto->getDesafios($_POST['id'],$tabla_desafios);   
                        
                        $objProspesto= new Prospecto();
                        $tabla_hobbies= $objProspesto->getListaDetalleHobbies($_POST['id']);
                        
                        /*$objEmpresaLocal= new EmpresaLocal();
                        $listaEmpresas= $objEmpresaLocal->getListaEmpresa($row['emp_id']);
                       */
                        //$tabla['t_0'] = array("t_1" => generadorNegritas("Código"), "t_2" => $row['prosp_codigo']);
                        $tabla['t_1'] = array("t_1" => generadorNegritas($lblNombre), "t_2" => $titulo );
			if($_SESSION['_esaplicante'] == '1'){
                        //$tabla['t_2'] = array("t_1" => generadorNegritas($lblFNacimiento), "t_2" => getFormatoFechadmy($row['per_fechanacimiento']));
                     //   $tabla['t_3'] = array("t_1" => generadorNegritas($lblTitulo), "t_2" => $row['prof_descripcion']);
						if($_SESSION['_esaplicante'] == '1'){
                      //  $tabla['t_4'] = array("t_1" => generadorNegritas($lblIdentificacion), "t_2" => $row['per_identificacion']);
                       // if($row['per_tipo']=='J'){$tabla['t_5'] = array("t_1" => generadorNegritas($lblTipoPersona), "t_2" => "Jurídica");} 
                         //if($row['per_tipo']=='N'){$tabla['t_5'] = array("t_1" => generadorNegritas($lblTipoPersona), "t_2" => "Natural");} 
						}
                        //$tabla['t_6'] = array("t_1" => generadorNegritas($lblGenero), "t_2" => $row['per_genero']);
                        $tabla['t_7'] = array("t_1" => generadorNegritas($lblEmpresa), "t_2" => $row['prosp_empresa']);
                        $tabla['t_10'] = array("t_1" => generadorNegritas($lblEstadoProspecto), "t_2" => $row['estpro_descripcion']);  
                        
                        
                        //$tabla5['t_7'] = array("t_1" => generadorNegritas($lblCorreo), "t_2" => $row['correo']);
                   //     $tabla5['t_8'] = array("t_1" => generadorNegritas($lblCorreoSecundario), "t_2" => $row['correo2']);
                         
                        if($row['participacion_correo']=='1'){
                          $tabla5['t_10'] = array("t_1" => generadorNegritas($lblParticipacionCorreo), "t_2" => 'SI');
                        }  else {
                          $tabla5['t_10'] = array("t_1" => generadorNegritas($lblParticipacionCorreo), "t_2" => 'NO');
                        }
/*
                        $tabla6['t_11'] = array("t_1" => generadorNegritas($lblTF), "t_2" => "(". $prefijoPais.") ".$row['movil2']);
                        $tabla6['t_12'] = array("t_1" => generadorNegritas($lblTM), "t_2" => "(". $prefijoPais.") ".$row['movil']);
*/						
                     //   $tabla6['t_14'] = array("t_1" => generadorNegritas($lblSkype), "t_2" => $row['skype']);
                    //    $tabla6['t_15'] = array("t_1" => generadorNegritas($lblTwitter), "t_2" => $row['twitter']);
				}
                        if($_SESSION['_esaplicante'] == '1'){
                            $tabla2['t_1'] = array("t_1" => generadorNegritas($lblAprobado), "t_2" => $row['prosp_aprobado']);
                            $tabla2['t_2'] = array("t_1" => generadorNegritas($lblForumLeader), "t_2" => $row['nombre_forum']);
                        }else{
                         //   $tabla2['t_2'] = array("t_1" => generadorNegritas($lblForumLeader), "t_2" => $row['nombre_forum']);
                         //   $tabla2['t_3'] = array("t_1" => generadorNegritas("Última Fecha de asignación de Forum Leader"), "t_2" => getFormatoFechadmyhis($row['prosp_fechacambioforum']) );
                        }
                        if($_SESSION['_esaplicante'] == '0'){
                        $tabla2['t_4'] = array("t_1" => generadorNegritas($estadoprospecto), "t_2" => $row['status']);
                        }
                        
                        $tabla2['t_5'] = array("t_1" => generadorNegritas($lblFuente), "t_2" => $row['fue_descripcion']);
                        $tabla2['t_6'] = array("t_1" => generadorNegritas('Persona que Refiere'), "t_2" => $row['prosp_txtadicional']);
                        
                        if($_SESSION['_esaplicante'] == '0'){  //Llenar empresa
					$tabla2['t_7'] = array("t_1" => generadorNegritas($lblEmpresa), "t_2" => $row['skype']);
						}
				if($_SESSION['_esaplicante'] == '1'){
					
                        //$tabla2['t_8'] = array("t_1" => generadorNegritas($lblRUC), "t_2" => $row['emp_ruc']);
				
						$objEmpresaLocal= new EmpresaLocal();
                        $tabla2= $objEmpresaLocal->getMultiListaIndustria2($row['emp_id'],$tabla2, generadorNegritas($lblSectores));
                        
                        //$tabla2['t_9'] = array("t_1" => generadorNegritas($lblCategoría), "t_2" => $row['cat_descripcion']);
						
					}
						
                        if($_SESSION['_esaplicante'] == '1'){
							
                            
                        }
				
                       // $tabla2['t_11'] = array("t_1" => generadorNegritas("Comentario"), "t_2" => $row['prosp_observacion']);
				
                 
                        $tabla3['t_1'] = array("t_1" => generadorNegritas($lblPais),            "t_2" => $pais);
                        $tabla3['t_2'] = array("t_1" => generadorNegritas($lblProvincia),       "t_2" => $estado);
                        $tabla3['t_3'] = array("t_1" => generadorNegritas($lblCiudad),          "t_2" => $ciudad);
                        //$tabla3['t_4'] = array("t_1" => generadorNegritas($lblDireccion),       "t_2" => $direcion);
                        
                        $tabla4['t_8'] = array("t_1" => generadorNegritas($lblFRegistro), "t_2" => getFormatoFechadmyhis($row['prosp_fecharegistro']));
                        $tabla4['t_9'] = array("t_1" => generadorNegritas($lblFModificacion), "t_2" => getFormatoFechadmyhis($row['prosp_fechamodificacion']));
                        $tabla4['t_10'] = array("t_1" => generadorNegritas($lblUModificar), "t_2" =>  $row['modificador']);

                        if($_SESSION['_esaplicante'] == '0'){
                            if($row['prosp_esprospectoaplicante'] != '1'){
                                if($row['prosp_aprobado'] == 'NO'){
									//Permisos segun admin//
		
                                    if (in_array($perAprobarCandidatoOp2, $_SESSION['usu_permiso'])) {
                                        $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "#modal_getAprobarCan"  ,"color" => "btn-info" ,"click" => "getAprobarCan(".$_POST['id'].",'".$row['correo']."','".$titulo."')" ,"titulo" => $lblbtnAprobar ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                                    }     
			
                                }else{
			
                                    if (in_array($perAsignarCandidatoOp2, $_SESSION['usu_permiso'])) {
                                       $boton['boton_2'] = array("elemento" => "boton" ,"modal" => "#modal_getAsignarCan" ,"color" => "btn-info" ,"click" => "getAsignarCan(".$_POST['id'].",'".$row['correo']."','".$titulo."')" ,"titulo" => $lblbtnAsignar,"lado" => "pull-right" ,"icono" => "fa-pencil");
                                    }   
			
                                } 
                                if (in_array($perActualizarCandidatoOp2, $_SESSION['usu_permiso'])) {
                                    $boton['boton_4'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getUserEditar(".$_POST['id'].")" ,"titulo" => $lblbtnEditar ,"lado" => "pull-right" ,"icono" => "fa-pencil"); 
                                }
                            }
                        }else{
                            if($row['prosp_esaplicanteesmiembro'] != '1'){
                                if (in_array($perCovertirProspectoOp3, $_SESSION['usu_permiso'])) {
                                    $boton['boton_3'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getConvertirProspecto(".$_POST['id'].",'".$row['status']."',".$row['forum_usu_id'].",'".$row['nombre_forum']."','".$titulo."')" ,"titulo" => $lblbtnConvertir ,"lado" => "pull-right" ,"icono" => "");
                                }
                                if (in_array($perEnviarCorreoOp3, $_SESSION['usu_permiso'])) {
                                    $boton['boton_4'] = array("elemento" => "boton" ,"modal" => "#modal_enviarCorreo"  ,"color" => "btn-info" ,"click" => "getEnviarCorreoIndividual('".$row['correo']."','".$titulo."')" ,"titulo" => $lblbtnEnviarCorreo,"lado" => "pull-right" ,"icono" => "");
                                }

                                if (in_array($perActualizarProspectoOp3, $_SESSION['usu_permiso'])) {
                                    $boton['boton_5'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getUserEditar(".$_POST['id'].")" ,"titulo" => $lblbtnEditar ,"lado" => "pull-right" ,"icono" => "");        
                                }
                            }
                        }
                        
                        
                        $objEmpresaLocal= new EmpresaLocal();
                        $tablaDetalleEmpresas=$objEmpresaLocal->getTabla($_POST['id'],'2');
                        //PAMAsistente
                
                        $objPAMAsistente= new PAMAsistente();
                        $tablaDetalleAsistente= $objPAMAsistente->getTabla($_POST['id'],'2');
                        
                        
                        $_SESSION['_ultimo_id_miembro_prospecto']= $_POST['id'];
                        $_SESSION['_ultimo_id_miembro_prospecto_bandera']= '2';
                        $boton_empresas['boton_1'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getPAMEmpresaModal('2')" ,"titulo" => "Crear Relacionar Empresa","lado" => "pull-right" ,"icono" => "fa-plus");
                        $boton_empresas['boton_6'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getAgregarEmpresa(".$_POST['id'].")" ,"titulo" => "Relacionar Empresa Existente","lado" => "pull-right" ,"icono" => "fa-link");
                        $boton_asistente['boton_6'] = array("elemento" => "boton" ,"modal" => "#modal_getPAMCrearAsistente" ,"color" => "btn-info" ,"click" => "getPAMAgregarAsistente(".$_POST['id'].")" ,"titulo" => "Agregar Asistente","lado" => "pull-right" ,"icono" => "fa-plus");
                        
                        
                        $boton['boton_6'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");
                        
                        //$resultado = str_replace("{contenedor_1}", "",  getPage('page_detalle') );
						if($_SESSION['_esaplicante'] == '1'){
        $resultado = str_replace("{contenedor_1}", $form_1,  getPage('page_detalle_aplicante'));
	   }else{
		   $resultado = str_replace("{contenedor_1}", $form_1,  getPage('page_detalle')); 
	   }
                        $resultado = str_replace("{contenedor_2}", "", $resultado); 
                        $resultado = str_replace("{contenedor_3}", generadorTabla_2($tabla, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_4}", generadorTabla_2($tabla2, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_5}", generadorTabla_2( $tabla3, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_6}", generadorTabla_2($tabla4, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_7}", generadorTabla_2( $tabla_hobbies, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_8}", generadorTabla_2($tabla_desafios, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_9}", $tablaDetalleEmpresas, $resultado);
                        $resultado = str_replace("{contenedor_10}", $tablaDetalleAsistente, $resultado);
                        $resultado = str_replace("{contenedor_11}", generadorTabla_2($tabla5, "table-striped"), $resultado);
                        $resultado = str_replace("{contenedor_12}", generadorTabla_2($tabla6, "table-striped"), $resultado);
                        $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);
                        if($_SESSION['_esaplicante'] == '0'){
                            $resultado = str_replace("{cabecera}",'Información del Prospecto', $resultado);
                        }else{
                            $resultado = str_replace("{cabecera}",'Información del Aplicante', $resultado);
                        }
                        $resultado = str_replace("{boton_empresas}", generadorBoton($boton_empresas), $resultado);
                        $resultado = str_replace("{boton_asistente}", generadorBoton($boton_asistente), $resultado);
                        
                        
                        
                        echo $resultado;

                    }  else {
                            echo getDetalleUpdate($_POST['id'], TRUE );
                    }
                    exit();
                }
                break;
            case 'KEY_SHOW_FORM_GUARDAR'://///////////////////////////////////////////////////////// 

                 $objProfesion= new Profesion();                
                 $listaprofe=  $objProfesion->getListaprofesion(NULL);

                 $objFuente= new Fuente();   
                 $listafuente=  $objFuente->getListaFuentes(NULL);
                 $listaEP['lista_'] = array("value" => "0",  "select" => "" ,"texto" => "Seleccionar...");
                 $objEstadoProspecto= new EstadoProspecto();
                 $listaestadoprospecto=  $objEstadoProspecto->getListaEstadoProspecto(NULL,$listaEP);  

                 $objIndustria= new Industria();               
                 $listaIndustria= $objIndustria->getListaIndustrias(NULL);

                 $objCategoria= new Categoria();                    
                 $listacategoria=  $objCategoria->getListaCategoria(NULL);

                  $objForum= new ForumLeader();
                  $listaPerfil= $objForum->getListaForumLeaders(NULL);
    
                 //Direccion 
                 $objPais= new Pais();
                 $listapais= $objPais->getListaPaisAplicante($_SESSION['pais_id'],NULL);
                 $prefijoPais= $objPais->getPrefijoPais();
                 $objProvincia=new Provincia();
                 $objProvincia->setIdPais($objPais->getIdPais());
                 $listaprov=  $objProvincia->getListaProvincia(NULL);

                 $objCiudad= new Ciudad();
                 $objCiudad->setIdProvincia($objProvincia->getIdProvincia());
                 $listaciudad=$objCiudad->getListaCiudad();

                 $objDesafio= new Desafio();
                 $listadesafio=$objDesafio->getListaDesafios();
                 
                 $objHobby= new Hobby();
                 $listadehobbies= $objHobby->getLista();
                 
                 $lis['lista_'] = array("value" => "0",  "select" => "" ,"texto" => "Seleccionar...");
                 $objEmpresaLocal= new EmpresaLocal();
                 $listaEmpresas= $objEmpresaLocal->getListaEmpresa2(NULL, $lis);
                 
                  $estadoprospecto='';
                 //$listaStatus['lista_'] = array("value" => "x",  "select" => "" ,"texto" => "Seleccionar...");
                 if($_SESSION['_esaplicante'] == '1'){
                    $objStatus= new StatusMember();
                    $listaStatus= $objStatus->getListaAplicante();
                    $estadoprospecto='Estado del Aplicante';
                 }/*else{
                    $objStatus= new StatusMember();
                    $listaStatus= $objStatus->getListaAplicante();
                    $estadoprospecto='Estado del Prospecto';
                 }*/
                 //Formularios
                 //$form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Código", "id" => "_codigo" ,"reemplazo" => '');
                 $form['form_2'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblNombre), "id" => "_nombre" ,"reemplazo" => "");
                 $form['form_3'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblApellido), "id" => "_apellido" ,"reemplazo" => "");
                 $form['form_4'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblEmpresa), "id" => "_id_empresa" ,"reemplazo" => "");

if($_SESSION['_esaplicante'] == '1'){
//$form['form_4'] = array("elemento" => "caja" ,"tipo" => "hidden", "id" => "_tipo_p", "reemplazo" => generadorComboTipoPersona_('J'));                 
$form['form_5'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_identificacion" ,"reemplazo" => "");
                 //$form['form_6'] = array("elemento" => "combo","change" => "", "titulo" => $lblGenero, "id" => "_genero", "option" => generadorComboGenero('MASCULINO'));

$form['form_7'] = array("elemento" => "caja","tipo" => "hidden", "id" => "_titulo", "reemplazo" => "1");
//$form['form_8'] = array("elemento" => "caja" ,"tipo" => "date" , "titulo" => $lblFNacimiento, "id" => "_fn" ,"reemplazo" => "");
                 $form7['form_9'] = array("elemento" => "caja" ,"tipo" => "hidden" , "titulo" => $lblCorreo, "id" => "_correo" ,"reemplazo" => "");
                 $form7['form_10'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_correo_2" ,"reemplazo" => "");
                 $form7['form_11'] = array("elemento" => "Checkbox-color" ,"tipo" => "", "chec" => "checked" , "titulo" => $lblParticipacionCorreo, "id" => "_participacion" ,"reemplazo" => "");
                 $form_7= generadorEtiqueta($form7);
                $form8['form_12'] = array("elemento" => "caja" ,"tipo" => "hidden","titulo" => $lblTF
                                                       ,"disabled_1" => "disabled","tipo_1" => "text" , "titulo_1" => "Prefijo", "id_1" => "_prefijo_telefono" ,"reemplazo_1" => $prefijoPais
                                                       ,"disabled_2" => "","tipo_2" => "text" , "titulo_2" => $lblTF, "id_2" => "_telefono" ,"reemplazo_2" => "");
                    
                $form8['form_13'] = array("elemento" => "caja" ,"tipo" => "hidden", "titulo" => $lblTM
                                                   ,"disabled_1" => "disabled","tipo_1" => "text" , "titulo_1" => "Prefijo", "id_1" => "_prefijo_celular" ,"reemplazo_1" => $prefijoPais
                                                   ,"disabled_2" => "","tipo_2" => "text" , "titulo_2" => $lblTM, "id_2" => "_celular" ,"reemplazo_2" => "");
}else{


$form['form_4'] = array("elemento" => "caja" ,"tipo" => "hidden", "id" => "_tipo_p", "reemplazo" => generadorComboTipoPersona_('J'));                 
$form['form_5'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_identificacion" ,"reemplazo" => "");
//$form['form_6'] = array("elemento" => "caja","tipo" => "hidden", "id" => "_genero", "reemplazo" => generadorComboGenero('MASCULINO'));
$form['form_7'] = array("elemento" => "caja","tipo" => "hidden", "id" => "_titulo", "reemplazo" => "1");
$form['form_8'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_fn" ,"reemplazo" => "");
$form7['form_9'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_correo" ,"reemplazo" => "");
$form7['form_10'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_correo_2" ,"reemplazo" => "");
$form7['form_11'] = array("elemento" => "caja" ,"tipo" => "hidden",  "id" => "_participacion" ,"reemplazo" => "");
$form_7= generadorEtiqueta($form7);
$form8['form_12'] = array("elemento" => "caja pequeña + caja" ,"titulo" => $lblTF
                                                       ,"disabled_1" => "disabled","tipo_1" => "text" , "titulo_1" => "Prefijo", "id_1" => "_prefijo_telefono" ,"reemplazo_1" => $prefijoPais
                                                       ,"disabled_2" => "","tipo_2" => "text" , "titulo_2" => $lblTF, "id_2" => "_telefono" ,"reemplazo_2" => "");
                    
                $form8['form_13'] = array("elemento" => "caja pequeña + caja" ,"titulo" => $lblTM
                                                   ,"disabled_1" => "disabled","tipo_1" => "text" , "titulo_1" => "Prefijo", "id_1" => "_prefijo_celular" ,"reemplazo_1" => $prefijoPais
                                                   ,"disabled_2" => "","tipo_2" => "text" , "titulo_2" => $lblTM, "id_2" => "_celular" ,"reemplazo_2" => "");



}
               
				
				if($_SESSION['_esaplicante'] == '1'){
                $form8['form_14'] = array("elemento" => "caja" ,"tipo" => "hidden", "id" => "_id_skype" ,"reemplazo" => "");
                $form8['form_15'] = array("elemento" => "caja" ,"tipo" => "hidden", "id" => "_id_Twitter" ,"reemplazo" => "");
				}else{
           //     $form8['form_14'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblSkype, "id" => "_id_skype" ,"reemplazo" => "");
		   $form8['form_14'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_id_empresa" ,"reemplazo" => "");	
                $form8['form_15'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblTwitter, "id" => "_id_Twitter" ,"reemplazo" => "");
				}

                $form_8= generadorEtiqueta($form8);

                $form_1= generadorEtiqueta($form);
                //Formularios
                if($_SESSION['_esaplicante'] == '1'){
                                     $form2['form_1'] = array("elemento" => "combo","change" => "","titulo" => $lblForumLeader, "id" => "_propietario", "option" => $listaPerfil);

}else{
                                     $form2['form_1'] = array("elemento"  => "caja" ,"tipo" => "hidden", "id" => "_propietario", "reemplazo" => "57");
	
	
}
                 $form2['form_2'] = array("elemento" => "combo","change" => "","titulo" => $estadoprospecto, "id" => "_status", "option" => $listaStatus);
                 
                 $form2['form_3'] = array("elemento" => "combo","change" => "","titulo" => $lblFuente, "id" => "_fuente", "option" => $listafuente);
                 $form2['form_4'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Persona que Refiere", "id" => "_lafuente" ,"reemplazo" => '');
            
                 $form2['form_5'] = array("elemento" => "caja","tipo" => "hidden", "id" => "_estado_propietario", "reemplazo" => $listaestadoprospecto);
                 if($_SESSION['_esaplicante'] == '1'){


                 $form2['form_8'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_categoria" ,"reemplazo" => "1");	

}else{
				 
	$form2['form_6'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Empresa", "id" => "_id_skype" ,"reemplazo" => "");
	//$form2['form_8'] = array("elemento" => "combo","change" => "","titulo" => $lblCategoría, "id" => "_categoria", "option" => $listacategoria);   
	 $form2['form_8'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_categoria" ,"reemplazo" => "1");	

				 }
                 
                 
                 
                 //$form2['form_7'] = array("elemento" => "combo","combo","change" => "", "titulo" =>  generadorAsterisco("Empresa"), "id" => "_id_empresa", "option" => $listaEmpresas); 
           //      $form2['form_8'] = array("elemento" => "combo","change" => "","titulo" => $lblCategoría, "id" => "_categoria", "option" => $listacategoria);             
                 //$form2['form_9'] = array("elemento" => "textarea" ,"tipo" => "text" , "titulo" => "Comentario", "id" => "_observacion" ,"reemplazo" => '');

                 

                 $form_2= generadorEtiqueta($form2);

                  //Formularios
                 $form3['form_8'] = array("elemento" => "caja","tipo"=>"hidden", "change" => "", "titulo" => $lblCiudad, "id" => "_ciudad", "option" => $listaciudad, "reemplazo" => "");
                 $form3['form_9'] = array("elemento" => "caja" ,"tipo" => "hidden" , "titulo" =>$lblCalle, "id" => "_calle" ,"reemplazo" => "");
                 $form_3= generadorEtiqueta($form3);


                
                 $form4['form_2'] = array("elemento" => "combo","change" => "getCargarPaises()","titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
                 $form4['form_9'] = array("elemento" => "combo", "change" => "getCargarProvincias()", "titulo" => $lblProvincia, "id" => "_provincia", "option" => $listaprov);
                 $form_4= generadorEtiqueta($form4);

                 $form5['form_2'] = array("elemento" => "lista-multiple",                   "titulo" => $lblListaHobbies, "id" => "_lista_hobbies", "option" => $listadehobbies);
                 $form_5= generadorEtiqueta($form5);

                 $form6['form_2'] = array("elemento" => "lista-multiple",                   "titulo" => $lblListaDesafios, "id" => "_lista_desafio", "option" => $listadesafio);
                 $form_6= generadorEtiqueta($form6);
                 
                 
                 $boton['boton_2'] = array("elemento" => "boton" ,"modal" => "" ,"id" => "btnGuardar" ,"color" => "btn-info" ,"click" => "setUserCrear('g','".$_SESSION['_esaplicante']."')" ,"titulo" => $lblbtnGuardar ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                 $boton['boton_3'] = array("elemento" => "boton" ,"modal" => ""  ,"id" => "btnGuardarNuevo" ,"color" => "btn-info" ,"click" => "setUserCrear('gn','".$_SESSION['_esaplicante']."')" ,"titulo" => $lblbtnGuardarNuevo ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                 $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "" ,"id" => ""  ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");

                 //$resultado = str_replace("{contenedor_1}", $form_1,  getPage('page_detalle_update'));
				 if($_SESSION['_esaplicante'] == '1'){
        $resultado = str_replace("{contenedor_1}", $form_1,  getPage('page_detalle_update_aplicante'));
	   }else{
		   $resultado = str_replace("{contenedor_1}", $form_1,  getPage('page_detalle_update')); 
	   }
                 $resultado = str_replace("{contenedor_2}", $form_2, $resultado); 
                 $resultado = str_replace("{contenedor_3}", $form_4, $resultado); 
                 $resultado = str_replace("{contenedor_4}", $form_3, $resultado); 
                 $resultado = str_replace("{contenedor_5}", $form_5, $resultado); 
                 $resultado = str_replace("{contenedor_6}",$form_6, $resultado);
                 $resultado = str_replace("{contenedor_11}",$form_7, $resultado);
                 $resultado = str_replace("{contenedor_12}",$form_8, $resultado);
                 $resultado = str_replace("{boton}",  generadorBoton2($boton), $resultado); 
                 if($_SESSION['_esaplicante'] == '0'){
                    $resultado = str_replace("{cabecera}",'Información del Prospecto', $resultado);
                 }else{
                    $resultado = str_replace("{cabecera}",'Información del Aplicante', $resultado);
                 }
                 echo $resultado;
                 exit();

                break;


            case 'KEY_ACTUALIZAR':
                 if(  !empty($_POST['_nombre'] )  && !empty($_POST['_apellido'] )){     
                    
                    $listaHobbies="";
                    if(isset($_POST['_lista_hobbies'])){
                        foreach($_POST['_lista_hobbies'] as $valor){
                            $listaHobbies.= $valor.",";
                        }
                    }
                    
                    $listadesafios="";
                    if(isset($_POST['_lista_desafio'])){
                        foreach($_POST['_lista_desafio'] as $valor){
                            $listadesafios.= $valor.",";
                        } 
                    }
                     $objProspesto= new Prospecto();
                     $comp= $objProspesto->setActualizarProspecto($_POST['_id_prospecto'],$_POST['_id_persona'],$_POST['_propietario'], $_POST['_nombre'], $_POST['_apellido'], $_POST['_titulo'], $_POST['_correo'] 
                                                                   ,$_POST['_correo_2'], $_POST['_telefono'] , $_POST['_celular'] ,$_POST['_participacion'], $_POST['_fn'], $_POST['_fuente'], 
                                                                   $_POST['_estado_propietario'],$_POST['_id_skype'] ,  $_POST['_id_Twitter'], $_POST['_calle'],$_POST['_ciudad'] , $_POST['_categoria'],  
                                                                   $_POST['_identificacion'],$_POST['_genero'],$_POST['_tipo_p'],$_SESSION['user_id_ben'] ,$listaHobbies, $listadesafios,
                                                                    $_POST['_status'],$_POST['_observacion'],$_POST['_codigo'],$_POST['_lafuente'],$_POST['_id_empresa']);  
//                 

                    if($comp == "OK"){
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Prospecto se creo actualizó correctamente!');  
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
            case 'KEY_SET_ESTADO':
                if(  !empty($_POST['_id_prospecto'] )  && !empty($_POST['_estado'] )){     
                    
                    
                     $objProspesto= new Prospecto();
                     $comp= $objProspesto->setEstadoProspecto($_POST['_id_prospecto'],$_POST['_estado']);  
//                 
                    if($comp == "OK"){
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El estado del Prospecto se actualizo correctamente!');  
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
            case 'KEY_GUARDAR':

                 if(!empty($_POST['key_operacion']) && !empty($_POST['_nombre']) 
                         && !empty($_POST['_apellido']) ){ 
					/* if($_POST['_id_empresa'] == '0'){
                        $data = array("success" => "false", "priority"=>'info', "msg" => 'Debes seleccionar una Empresa!');  
                     	echo json_encode($data); 
						 exit();
                    }*/
                     
                    $listaHobbies="";
                    if(isset($_POST['_lista_hobbies'])){
                        foreach($_POST['_lista_hobbies'] as $valor){
                            $listaHobbies.= $valor.",";
                        }
                    }
                    
                    $listadesafios="";
                    if(isset($_POST['_lista_desafio'])){
                        foreach($_POST['_lista_desafio'] as $valor){
                            $listadesafios.= $valor.",";
                        } 
                    }
              
                
                     $objProspesto= new Prospecto();
                     $comp= $objProspesto->setGrabarProspecto($_SESSION['_esaplicante'],$_POST['_propietario'], $_POST['_nombre'], $_POST['_apellido'], $_POST['_titulo'], $_POST['_correo'] 
                                                                   ,$_POST['_correo_2'], $_POST['_telefono'] , $_POST['_celular'] ,$_POST['_participacion'], $_POST['_fn'], $_POST['_fuente'], 
                                                                   $_POST['_estado_propietario'],$_POST['_id_skype'] ,  $_POST['_id_Twitter'], $_POST['_calle'],$_POST['_ciudad'] , $_POST['_categoria'],  
                                                                   $_POST['_identificacion'],$_POST['_genero'],$_POST['_tipo_p'],$_SESSION['user_id_ben'] ,$listaHobbies, $listadesafios,
                                                                    $_POST['_status'],$_POST['_observacion'],$_POST['_codigo'],$_POST['_lafuente'],$_POST['_id_empresa']); 

                    if($comp == "OK"){
                        if($_POST['key_operacion']=='gn'){
                            $data = array("success" => "true_gn", "priority"=>'success',"msg" => 'El Prospecto se creo correctamente!');  
                            echo json_encode($data);              
                        }  else {
                           $data = array("success" => "true_g", "priority"=>'success',"msg" => 'El Prospecto se creo correctamente!');  
                           echo json_encode($data); 
                        }
                    }else{
                        $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                        echo json_encode($data);
                    }

                 }  else {
                     $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                     echo json_encode($data); 
                 }

                 break;
            case 'KEY_CONVERTIR_APLICANTE':    
//                $data = array("success" => "false", "priority"=>'info',"msg" => "sdfsdf"); 
//                        echo json_encode($data);
//                        exit();
                 if(!empty($_POST['_id']) ){        

                     $objAplicante= new Prospecto();
                     $comp= $objAplicante->setAplicanteConvertir($_POST['_id'],$_SESSION['user_id_ben'],NULL,NULL,NULL);  
                      //( $id_prospecto= '',  $id_user= '', $grupo= '', $membresia= '', $status= '')
                     if($comp == "OK"){
                        $correo_forum='';
                        $objForum= new ForumLeader(); 
                        try {
                        $correo_forum= $objForum->getCorreo( $_POST['_convertir_id_forum'], 'Personal');
                        } catch (Exception $ex) { 
                            $correo_forum='';
                        }
                        
                        $destinatarios= array();
                        $destinatarios[1]= $correo_forum; 
                    //    $destinatarios[2]= $_SESSION['user_correo'];
                        try {
                            $asunto= "Renaissance Executive Forum";
                            $msg="Se convirtió el aplicante ".$_POST['_convertir_nombre']." a miembro, y se asigno al Forum Leader ".$_POST['_convertir_nombre_forum'];
                            //$mail= new Mail();
                            //$mail->enviarMultiple($_SESSION['user_name'],$_SESSION['user_correo'],$asunto,$msg, FALSE, $destinatarios);  
                        } catch (Exception $ex) { }
                        
                        
                        
                        
                        
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Miembro se creo correctamente!');  
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
            case 'KEY_SHOW_MODAL_FILTRO':       
                $objEmpresaLocal= new EmpresaLocal();//getEmpresasLocal   SELECT emp_id, emp_nombre as 'nombre_empresa',
                $cuerpo='';
                $resultset= $objEmpresaLocal->getEmpresasLocal(NULL);
                 while($row = $resultset->fetch_assoc()) { 
                     $nombre=$row['nombre_empresa'];
                     $cuerpo.= generadorTablaFilas(array(
                         getCheck( $row['emp_id'], $nombre), 
                         $nombre));                                                                            
                }    
                $t= generadorTablaModal(1, "Empresas",'', array( "Acción","Empresa" ), $cuerpo);
                echo $t;
                exit();        
               break; 
            case 'KEY_ENVIAR_CORREO_INDIVIDUAL'://///////////////////////////////////////////////////////// 
                if(!empty($_POST['_correo_receptor']) && !empty($_POST['_email_asunto']) && !empty($_POST['_email_mensaje'])) {
                    $mail= new Mail();
                    $msg= $mail->enviar($_SESSION['user_name'],$_SESSION['user_correo'],$_POST['_email_asunto'],$_POST['_email_mensaje'], $_POST['_correo_receptor'], FALSE); 
                    $data = array("success" => "true", "priority"=>'success', "msg" => $msg);  
                    echo json_encode($data);
                }else{
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data);
                }      

                break; 
            case 'KEY_SHOW_FILTRO':

                if(!empty($_POST['_key_filtro']) && !empty($_POST['_filtro'])){ 
                           
                    if($_POST['_filtro'] == "x"){
                        $tabla= getTablaFiltrada("","", $_SESSION['_esaplicante']);
                    }else{
                        $tabla= getTablaFiltrada($_POST['_filtro'], $_POST['_key_filtro'], $_SESSION['_esaplicante']);
                    }                    
                   
                                           
                    $data = array("success" => "true", 
                        "tabla" => $tabla);  
                    echo json_encode($data); 
                
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'No existen datos!');  
                    echo json_encode($data); 
                }

            break;
            case 'KEY_APROBAR_PROSPECTO':
                if(!empty($_POST['_id'])){   
                    $objProspecto= new Prospecto();
                    $comp= $objProspecto->setAprobarProspecto($_POST['_id'], $_SESSION['user_id_ben']); 
                     if($comp == "OK"){
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Candidato fue aprobado correctamente!');  
                        echo json_encode($data);    
                    }else{
                        $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                        echo json_encode($data);
                    }
                                            
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Vuelve a intentarlo!');  
                    echo json_encode($data); 
                }                  
            break;
            case 'KEY_CONVERTIR_PROSPECTO':

                if(!empty($_POST['id']) && !empty($_POST['iduserforum'])){    

                    $objProspecto= new Prospecto();
                    $comp= $objProspecto->setConvertirProspecto($_POST['id'], $_POST['iduserforum'], $_SESSION['user_id_ben']); 

                    if($comp=="OK"){
                        $objForum= new ForumLeader();         
                        $correo_forum= $objForum->getCorreo( $_POST['iduserforum'], 'Personal');
                        $destinatarios= array();
                        $destinatarios[1]= $correo_forum; 
                        $destinatarios[2]= $_SESSION['user_correo'];
                        try {
                            $asunto= "Renaissance Executive Forum";
                            $msg="Se asigna el prospecto ".$_POST['asignar_nombre']."  al Forum Leader ".$_POST['nombre_forum'];
                          //  $mail= new Mail();
                          //  $mail->enviarMultiple($_SESSION['user_name'],$_SESSION['user_correo'],$asunto,$msg, FALSE, $destinatarios);  
                        } catch (Exception $ex) { }
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Prospecto fue convertido correctamente!');  
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

//function getCheck($id,$nombre) {
//    $msg='';
//    $msg='<center><input  type="checkbox" onclick="getAdd('.$id.',\''.$nombre.'\')"/></center>'; 
//    return $msg;
//}


function setSeleccionadoAplicante($lista = array(), $idSeleccionado = "") {
    $listaAux = array();
    $listaAux = $lista;

    foreach ($lista as $k => $l) {
        if ($l['value'] == $idSeleccionado) {
            $listaAux[$k]['select'] = "selected";
        }
    }

    return $listaAux;

}


function getTablaFiltrada($id, $key, $esaplicante) {
   global $perCrearProspectoOp3, $perVerProspectoOp3, $perVerCandidatoOp2;
   $objProspesto= new Prospecto();
    $cuerpo='';
    $cont=1;
    $resultset= $objProspesto->getProspectosFiltros($id, $key, $esaplicante);
    $objStatus= new StatusMember();
    $listaStatus2= array();
    $listaStatus2= $objStatus->getListaAplicante($listaStatus2);
    while($row = $resultset->fetch_assoc()) { 
        
        //prospecto.prosp_esaplicante,  prospecto.prosp_esaplicanteesmiembro, prospecto.prospecto_id, prospecto.prosp_aprobado
        if($_SESSION['_esaplicante'] == '0'){
            $verDetalle='';
            if (in_array($perVerCandidatoOp2, $_SESSION['usu_permiso'])) {
               $verDetalle='getDetalle('.$row['_id_prospecto'].')';
            }
            $cuerpo.= generadorTablaFilas(array(
                "<center>".$cont."</center>",	
                generadorLink($row['per_apellido'].' '.$row['per_nombre'],$verDetalle),
                $row['aprobado'],
                $row['mem_sta_codigo']));
               
        }else{
             $verDetalle='';
             $listaTemp = array();
             $listaTemp = setSeleccionadoAplicante($listaStatus2, $row['mem_sta_id']);
            if (in_array($perVerProspectoOp3, $_SESSION['usu_permiso'])) {
               $verDetalle='getDetalle('.$row['_id_prospecto'].')';
            }
            //print_r($listaTemp);
            
            $arreglo = array("change" => "setEstado(".$row['_id_prospecto'].")", 
            "id" => "_".$row['_id_prospecto'], "option" => $listaTemp); 
            $cuerpo.= generadorTablaFilas(array(
                "<center>".$cont."</center>",
                generadorLink($row['per_apellido'].' '.$row['per_nombre'],$verDetalle),
                $row['nombre_forum'],generadorEtiquetasFiltroTabla($arreglo) ));
        }
        $cont=$cont + 1; 
    } 
    $funcion='';
    if (in_array($perCrearProspectoOp3, $_SESSION['usu_permiso'])) {
       $funcion='getCrear()';
    }
    if($_SESSION['_esaplicante'] == '0'){
        $tabla= generadorTabla_(1, "Prospecto",$funcion, array( "N°","Nombre","Aprobado"), $cuerpo);
    }else{
        $tabla= generadorTabla_(1, "Aplicante",$funcion, array( "N°","Nombre","Forum Leader", "Estado"), $cuerpo);
    }
   return $tabla;
    
}

////////////////////////////////////////////////////////////////////////////////
function getFiltros() {
    
    $lista['lista_0'] = array( "value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");
    
	
	if($_GET['_esaplicante'] == '1'){
       
	   //En caso de restring
    
    }
	
	    $objForum = new ForumLeader();
        $listaForum=$objForum->getListaForumLeaders2(NULL,$lista);
        $form['form_2'] = array("elemento" => "combo","change" => "getFiltro('2')", "titulo" => "Forum Leader", "id" => "_forum", "option" => $listaForum); 
    /*
    $objEmpresaLocal= new EmpresaLocal();
    $listaEmpresa=$objEmpresaLocal->getListaEmpresa2(NULL, $lista);
    $form['form_3'] = array("elemento" => "combo","change" => "getFiltro('3')", "titulo" => "Empresas", "id" => "_empresa", "option" => $listaEmpresa); 
    
    $objIndustria = new Industria();
    $listaIndustrias=$objIndustria->getListaIndustrias2(NULL, $lista);
    $form['form_4'] = array("elemento" => "combo","change" => "getFiltro('4')", "titulo" => "Industrias", "id" => "_industria", "option" => $listaIndustrias); 
*/

   // $objEstado = new Estado();
   // $listaEstados=$objEstado->getListaEstadoProspecto(NULL, $lista);
	//    $objEstadoProspecto= new EstadoProspecto();
      //  $listaestadoprospecto=  $objEstadoProspecto->getListaEstadoProspecto2(NULL, $lista); 
		         if($_SESSION['_esaplicante'] == '1'){
            $listaStatus['lista_'] = array("value" => "x",  "select" => "" ,"texto" => "Seleccionar...");
            $objStatus= new StatusMember();
            $listaStatus= $objStatus->getListaAplicante($listaStatus);
            $form['form_5'] = array("elemento" => "combo","change" => "getFiltro('5')", "titulo" => "Estado del Aplicante", "id" => "_estado", "option" => $listaStatus); 
         }else{
           $listaStatus['lista_'] = array("value" => "x",  "select" => "" ,"texto" => "Seleccionar...");			
			$objStatus= new StatusMember();
            $listaStatus= $objStatus->getListaAplicante($listaStatus);
            $form['form_5'] = array("elemento" => "combo","change" => "getFiltro('5')", "titulo" => "Estado del Prospecto", "id" => "_estado", "option" => $listaStatus); 
         }

//        $listaEP['lista_'] = array("value" => "0",  "select" => "" ,"texto" => "Seleccionar...");
  //      $objEstadoProspecto= new EstadoProspecto();
    //    $listaestadoprospecto=  $objEstadoProspecto->getListaEstadoProspecto($row['estadoprospecto_estpro_id'],$listaEP);  


    return $form;
    
}
$t='';
if(isset($_GET['_esaplicante'])){
    if($_GET['_esaplicante'] == '1' || $_GET['_esaplicante'] == '0'){
        $_SESSION['_esaplicante']= $_GET['_esaplicante'];

        $tabla= getTablaFiltrada("","",$_SESSION['_esaplicante']);
        $resultado = str_replace("{fitros}", generadorEtiquetasFiltro(getFiltros()), generadorFiltro('Filtros','ben_contenedor_filtro')); 
        $resultado = str_replace("{cuerpo}", $tabla, $resultado);  
        $t=$resultado;
    }else{
        $t= getAlertNoPage();
    }

} else {
    $t= getAlertNoPage();
}



$objForum= new ForumLeader();
$forum_Leader= $objForum->getListaComboForumLeader();

$objCargo= new Categoria();
$lista= $objCargo->getListaCategoria("");
$listaFuncion = generadorComboSelectOption("_funcion_asistente", "",$lista);
$listaFuncion2 = generadorComboSelectOption("_funcion_asistente_u", "",$lista);