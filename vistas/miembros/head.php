<?php
require_once MODELO.'Grupo.php';
require_once MODELO.'Miembro.php';
require_once MODELO.'Hobby.php';
require_once MODELO.'Prospecto.php';
require_once MODELO.'Industria.php';
require_once MODELO.'ForumLeader.php';
require_once MODELO.'Usuario.php';
require_once MODELO.'Perfil.php';
require_once MODELO.'Profesion.php';
require_once MODELO.'Fuente.php';
require_once MODELO.'Pais.php';
require_once MODELO.'Provincia.php';
require_once MODELO.'EstadoProspecto.php';
require_once MODELO.'Categoria.php';
require_once MODELO.'Correo.php';
require_once MODELO.'Telefono.php';
require_once MODELO.'RedSocialMiembro.php';
require_once MODELO.'Direccion.php';
require_once MODELO.'Ciudad.php';
require_once MODELO.'Desafio.php';
require_once MODELO.'EmpresaLocal.php';
require_once MODELO.'TipoPresupuesto.php';
require_once MODELO.'EstadoPresupuesto.php';
require_once MODELO.'PresupuestoCobro.php';
require_once MODELO.'Periodo.php';
require_once MODELO.'Membresia.php';
require_once MODELO.'Inscripcion.php';
require_once MODELO.'Usuario.php';
require_once MODELO.'StatusMember.php';
require_once MODELO.'PlantillaEmail.php';


require_once MODELO.'EmpresaLocal.php';
require_once MODELO.'PAMAsistente.php';
require_once MODELO.'TipoEmpresaPAM.php';
require_once '../../public_html/admin/sendEmail.php';
include_once(HTML."/html.php");
include_once(HTML."/html_2.php");
include_once(HTML."/html_combos.php");
include_once(HTML."/html_filtros.php");
require_once(LENGUAJE."/lenguaje_1.php");
require_once E_LIB.'Mail.php';
$settings = parse_ini_file(E_LIB."settings.ini.php");            

require_once MODELO2.'GlobalMiembro.php';
require_once MODELO2.'GlobalSede.php';

error_reporting(0);
$objProfesion; $objFuente; $objEstadoProspecto;$objIndustria;$objCategoria;$objPais;$objProvincia;$objCiudad;$objDesafio;$objRedSocial;
$objUsuario;$objForum;$objHobby;$objMiembro;$tabla_desafios=array();$objEmpresaLocal;$objDireccion;$objStatus;$prefijoPais="";$codigoMiembro='';
$titulo='';$idpersona='';$empresa='';$direcion='';$ciudad='';$estado='';$pais='';$nombreGrupo='';


function getDetalleUpdate($id, $recargar) {
    $objMiembro= new Miembro();
	if(isset($_GET['id_miembro'])){
	$resultset= $objMiembro->getMiembro2($id);	
	}else{
	$resultset= $objMiembro->getMiembro1($id);	
	}
    $lamembresia = "";
    if($row = $resultset->fetch_assoc()) {         
        $idpersona=$row['per_id'];
         
        $objProfesion= new Profesion();                
        $listaprofe=  $objProfesion->getListaprofesion($row['Profesion_prof_id']);
        $objCategoria= new Categoria();                    
        $listacategoria=  $objCategoria->getListaCategoria($row['categoria_cat_id']);
        
        $objForum= new ForumLeader();
        $listaForumLeader= $objForum->getListaForumLeaders($row['forum_usu_id']);
 
        $idDireccion='';        $idCiudad='';        $idEstado='';        $idPais='';        $direccion= ''; $prefijoPais='';
        
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
        $listapais= $objPais->getListaPais($idPais, NULL);

        $objProvincia=new Provincia();
        $objProvincia->setIdPais($objPais->getIdPais());
        $listaprov=  $objProvincia->getListaProvincia($idEstado);

        $objCiudad= new Ciudad();
        $objCiudad->setIdProvincia($objProvincia->getIdProvincia());
        $listaciudad=$objCiudad->getListaCiudad($idCiudad);

        
        $objMiembro= new Miembro();
        $listadesafio= $objMiembro->getMultiListaDesafiosMiembros($id);   
        
        $objMiembro= new Miembro();
        $listahobby=$objMiembro->getMultiListaHobbies($id);
        
        $objGrupo= new Grupo();
        $listaGrupos= $objGrupo->getListaGruposForum_by_Sede($_SESSION['sede_id'], $row['grupo_id'], NULL);
        $listacod = array();
        if ($recargar) {
            $objGrupo3 = new Grupo();
            $resultset4 = $objGrupo3->getGruposForumSede($_SESSION['sede_id']);
            if ($row4 = $resultset4->fetch_assoc()) {
                $listacod = explode('-',$row4['gru_descripcion']);
            }
        }
               // $listaGrupos= $objGrupo->getListaGruposForum($_SESSION['sede_id'], $row['grupo_id'], '6');
				
        $listaStatus['lista_'] = array("value" => "x",  "select" => "" ,"texto" => "Seleccionar...");
        $objStatus= new StatusMember();
        $listaStatus= $objStatus->getLista($row['status_member_id'],$listaStatus, '1');
        $lamembresia = $row['membresia_id'];
        $objMembresia= new Membresia();
        $listaM= array();
        $listaM['lista_'] = array("value" => "x",  "select" => "" ,"texto" => "Seleccione...");
        $listaM= $objMembresia->getListaMembresias($row['membresia_id'],$listaM, $_SESSION['user_id_ben']);
        $valorMembresiaOculto = 0;
        foreach($listaM as $d) {
            if (strlen($d['select']) > 0) {
                $valorMembresiaOculto = $d['value'];
            }
        }
        
        $objEmpresaLocal= new EmpresaLocal();
        $listaEmpresas= $objEmpresaLocal->getListaEmpresa($row['emp_id']);
                                                                                    
        global $lblForumLeader,$lblNombre, $lblApellido , $lblTipoPersona, $lblIdentificacion, $lblGenero,
                $lblTitulo,$lblFNacimiento, $lblCorreo, $lblCorreoSecundario, $lblTF, $lblTM, $lblEmpresa,
                $lblIngresosAnuales,$lblNEmpleados,$lblNEmpleados,$lblIndustria,$lblFax, $lblSitioWeb, $lblCategoría, $lblFuente, $lblEstadoProspecto,
                $lblSkype,$lblTwitter,$lblParticipacionCorreo,$lblCiudad, $lblCalle, $lblPais, $lblProvincia, $lblDescDesafios, $lblListaDesafios,$lblListaHobbies,
                $lblbtnGuardar, $lblbtnRegresar;
        //Formularios
  //      $form['form_0'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco("Código"), "id" => "_codigo" ,"reemplazo" => $row['mie_codigo']);
  $codigo_usuario = $row['mie_codigo'];
  
list($c1, $c2, $c3, $c4) = split('[/.-]', $codigo_usuario);
  $cod1 = $c1;
  $cod2 =$c2;
  $cod3 =$c3;
  $cod4 =$c4;
$form['form_0'] = array("elemento" => "subir-imagen", "valor" => $cod1."-".$cod2."-". $cod3. "-". $cod4);

  if ($recargar) {
      $form['form_1'] = array("elemento" => "smallcode" ,"titulo" => generadorAsterisco("Código")
            ,"disabled_1" => "","tipo_1" => "text" , "id_1" => "_cod_1" ,"reemplazo_1" => $listacod[0]
            ,"disabled_2" => "","tipo_2" => "text" , "id_2" => "_cod_2" ,"reemplazo_2" => $listacod[1]
            ,"disabled_3" => "","tipo_3" => "text" , "id_3" => "_cod_3" ,"reemplazo_3" => ""
            ,"disabled_4" => "","tipo_4" => "text" , "id_4" => "_cod_4" ,"reemplazo_4" => "");
  
  } else {
      $form['form_1'] = array("elemento" => "smallcode" ,"titulo" => generadorAsterisco("Código")
            ,"disabled_1" => "","tipo_1" => "text" , "id_1" => "_cod_1" ,"reemplazo_1" => $cod1
            ,"disabled_2" => "","tipo_2" => "text" , "id_2" => "_cod_2" ,"reemplazo_2" => $cod2
            ,"disabled_3" => "","tipo_3" => "text" , "id_3" => "_cod_3" ,"reemplazo_3" => $cod3
            ,"disabled_4" => "","tipo_4" => "text" , "id_4" => "_cod_4" ,"reemplazo_4" => $cod4);
  
  }
              
		
        $form['form_3'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblNombre), "id" => "_nombre" ,"reemplazo" => $row['per_nombre']);
        $form['form_4'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblApellido), "id" => "_apellido" ,"reemplazo" => $row['per_apellido']);
        $form['form_5'] = array("elemento" => "caja" ,"tipo" => "date" , "titulo" => $lblFNacimiento, "id" => "_fn" ,"reemplazo" => $row['per_fechanacimiento']);
        /*
        $form['form_4'] = array("elemento" => "combo","change" => "","titulo" => $lblTipoPersona, "id" => "_tipo_p", "option" => generadorComboTipoPersona_($row['per_tipo']));        $form['form_5'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblIdentificacion, "id" => "_identificacion" ,"reemplazo" => $row['per_identificacion']);       */
      $form['form_6'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_tipo_p" ,"reemplazo" => $row['per_tipo']);
      $form['form_7'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_identificacion" ,"reemplazo" => $row['per_identificacion']);
		
		//$form['form_6'] = array("elemento" => "combo","change" => "","titulo" => $lblGenero, "id" => "_genero", "option" => generadorComboGenero($row['per_genero']));
        
      
		//$form['form_7'] = array("elemento" => "combo","change" => "", "titulo" => $lblTitulo, "id" => "_titulo", "option" => $listaprofe);
        
        $form['form_8'] = array("elemento" => "caja", "tipo" => "hidden","id" => "_titulo", "reemplazo" => "1");
        if (isset($_GET['email'])) {
            //si se activo que se enviara mail de bienvenida 
            $form['form_9'] = array("elemento" => "caja", "tipo" => "hidden","id" => "_enviar_mail", "reemplazo" => $row['mie_id']);
        }
        $form_1= generadorEtiqueta($form);
        
        //Formularios
        
 //$form2['form_0'] = array("elemento" => "combo","change" => "Show_Esp_Price()", 'deshabilitado' => true, "titulo" => generadorAsterisco("Precio"), "id" => "_membresia", "option" => $listaM);
	   
		$form2['form_0'] = array("elemento" => "combo","change" => "","titulo" => generadorAsterisco("Asignar Grupo"), "id" => "_grupo_asignar", "option" => $listaGrupos);
        $form2['form_1'] = array("elemento" => "combo","change" => "getComboCargarGrupos()","titulo" => generadorAsterisco($lblForumLeader), "id" => "_propietario", "option" => $listaForumLeader);
       // $form2['form_2'] = array("elemento" => "combo","change" => "","titulo" => generadorAsterisco("Asignar Grupo"), "id" => "_grupo_asignar", "option" => $listaGrupos);
        $form2['form_2'] = array("elemento" => "combo","change" => "cambioMembresia()","titulo" => generadorAsterisco("Estado del Miembro"), "id" => "_status", "option" => $listaStatus);
        $form2['form_3'] = array("elemento" => "combo + boton","change" => "",                   "titulo" => "Empresa", "id" => "_id_empresa", "option" => $listaEmpresas, 
                                            "modal" => "","boton_click" => "getPAMEmpresaModal('1')", "boton_icono" => "fa fa-industry","boton_nombre" => "", "boton_title" =>"Crear Empresa"
                                            ,"boton_tipo" => "btn-info");
//        $form2['form_6'] = array("elemento" => "combo","combo","change" => "", "titulo" => "Empresa", "id" => "_id_empresa", "option" => $listaEmpresas); 
        $form2['form_4'] = array("elemento" => "combo","change" => "", "titulo" => $lblCategoría, "id" => "_categoria", "option" => $listacategoria);    
        $form2['form_5'] = array("elemento" => "caja" ,"tipo" => "hidden" , "titulo" => "", "id" => "_observacion" ,"reemplazo" => $row['mie_observacion']);
        $form2['form_6'] = array("elemento" => "caja", "tipo" => "hidden","id" => "_membresia", "reemplazo" => $valorMembresiaOculto);
        $form2['form_7'] = array("elemento" => "caja" ,"tipo" => "hidden" , "titulo" => " ","id" => "_precio_esp","reemplazo" => $row['precio_esp']);
        $form_2= generadorEtiqueta($form2);
        if (isset($_GET['id_miembro'])) {
            $form7['form_18'] = array('elemento' => "Checkbox-color", "tipo" => "", "chec" => "", "titulo" => "Enviar Mail de Bienvenida", "id" => "_email_bienvenida" ,"reemplazo" => '');
        }
        $form7['form_10'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCorreo, "id" => "_correo" ,"reemplazo" => $row['correo']);
       // $form7['form_11'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCorreoSecundario, "id" => "_correo_2" ,"reemplazo" => $row['correo2']);
	    $form7['form_11'] = array("elemento" => "caja" ,"tipo" => "hidden" ,"id" => "_correo_2" ,"reemplazo" => $row['correo2']);

        if($row['mie_participacion_correo']=='1'){
            $form7['form_12'] = array("elemento" => "Checkbox-color" ,"tipo" => "" ,"chec" => "checked", "titulo" => $lblParticipacionCorreo, "id" => "_participacion" ,"reemplazo" => '');
        }  else {
            $form7['form_12'] = array("elemento" => "Checkbox-color" ,"tipo" => "" ,"chec" => "", "titulo" => $lblParticipacionCorreo, "id" => "_participacion" ,"reemplazo" => '');
        }

        $form7['form_17'] = array("elemento" => "caja" ,"tipo" => "hidden" ,"id" => "_id_miembro_cancel", "reemplazo" => $row['mie_id']);
        $form_7= generadorEtiqueta($form7);
        
        $form8['form_13'] = array("elemento" => "caja pequeña + caja" ,"titulo" => $lblTF
                                                       ,"disabled_1" => "disabled","tipo_1" => "text" , "titulo_1" => "Prefijo", "id_1" => "_prefijo_telefono" ,"reemplazo_1" => $prefijoPais
                                                       ,"disabled_2" => "","tipo_2" => "text" , "titulo_2" => $lblTF, "id_2" => "_telefono" ,"reemplazo_2" => $row['movil2']);           
        $form8['form_14'] = array("elemento" => "caja pequeña + caja" ,"titulo" => $lblTM ,"disabled_1" => "disabled","tipo_1" => "text" , "titulo_1" => "Prefijo", "id_1" => "_prefijo_celular" ,"reemplazo_1" => $prefijoPais
                                           ,"disabled_2" => "","tipo_2" => "text" , "titulo_2" => $lblTM, "id_2" => "_celular" ,"reemplazo_2" => $row['movil']);
     //   $form8['form_15'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblSkype, "id" => "_id_skype" ,"reemplazo" => $row['skype']);
     //   $form8['form_16'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblTwitter, "id" => "_id_Twitter" ,"reemplazo" => $row['twitter']);  
	 
	    $form8['form_15'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Nombre de Pareja", "id" => "_id_skype" ,"reemplazo" => $row['skype']);
        $form8['form_16'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Nombre de hijos", "id" => "_id_Twitter" ,"reemplazo" => $row['twitter']);
		
		
        $form_8= generadorEtiqueta($form8);
        
        $form3['form_8'] = array("elemento" => "combo", "change" => "","titulo" =>$lblCiudad, "id" => "_ciudad", "option" => $listaciudad);
        $form3['form_9'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCalle, "id" => "_calle" ,"reemplazo" => $direccion);
        $form_3= generadorEtiqueta($form3);

        $form4['form_2'] = array("elemento" => "combo","change" => "getCargarPaises()", "titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
        $form4['form_9'] = array("elemento" => "combo","change" => "getCargarProvincias()", "titulo" => $lblProvincia, "id" => "_provincia", "option" => $listaprov);
        $form_4= generadorEtiqueta($form4);

        $form5['form_1'] = array("elemento" => "textarea" ,"tipo" => "text" , "titulo" => $lblDescDesafios, "id" => "_desafios" ,"reemplazo" => $row['mie_descripcion_desafio']);
        $form5['form_2'] = array("elemento" => "lista-multiple", "titulo" => "Lista de Desafíos", "id" => "_lista_desafio", "option" => $listadesafio);
        $form_5= generadorEtiqueta($form5);
        

//        $form6['form_2'] = array("elemento" => "lista-multiple", "titulo" => $lblListaHobbies, "id" => "_lista_hobbies", "option" => $listahobby);
 //       $form_6= generadorEtiqueta($form6);
        
        $boton['boton_2'] = array("elemento" => "boton" ,"modal" => ""  ,"color" => "btn-info" ,"click" => "setUserActualizar(".$idpersona.",".$row['mie_id'].")" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
        if($recargar){
            $boton['boton_1'] = array("elemento" => "boton" ,"modal" => ""  ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");
        }else{
            $boton['boton_1'] = array("elemento" => "boton" ,"modal" => ""  ,"color" => "btn-info" ,"click" => "getDetalle(".$id.")" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");
     
        }
		
		if(isset($_GET['id_miembro'])){ 
		 $objEmpresaLocal= new EmpresaLocal();
                        $tablaDetalleEmpresas=$objEmpresaLocal->getTabla($_GET['id_miembro'],'1');                      
                        //PAMAsistente
                
                        $objPAMAsistente= new PAMAsistente();
                        $tablaDetalleAsistente= $objPAMAsistente->getTabla($_GET['id_miembro'],'1');
						
						$boton_empresas['boton_1'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getPAMEmpresaModal('2')" ,"titulo" => "Crear Empresa","lado" => "pull-right" ,"icono" => "fa-plus");
                        $boton_empresas['boton_2'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getAgregarEmpresa(".$_GET['id_miembro'].")" ,"titulo" => "Relacionar Empresa","lado" => "pull-right" ,"icono" => "fa-link");
                        $boton_asistente['boton_6'] = array("elemento" => "boton" ,"modal" => "#modal_getPAMCrearAsistente" ,"color" => "btn-info" ,"click" => "getPAMAgregarAsistente(".$_GET['id_miembro'].")" ,"titulo" => "Agregar Asistente","lado" => "pull-right" ,"icono" => "fa-plus");
						
						
		}else{
			 $objEmpresaLocal= new EmpresaLocal();
                        $tablaDetalleEmpresas=$objEmpresaLocal->getTabla($_POST['id_miembro'],'1');                      
                        //PAMAsistente
                
                        $objPAMAsistente= new PAMAsistente();
                        $tablaDetalleAsistente= $objPAMAsistente->getTabla($_POST['id_miembro'],'1');
						
						$boton_empresas['boton_1'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getPAMEmpresaModal('2')" ,"titulo" => "Crear Empresa","lado" => "pull-right" ,"icono" => "fa-plus");
                        $boton_empresas['boton_2'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getAgregarEmpresa(".$_POST['id_miembro'].")" ,"titulo" => "Relacionar Empresa","lado" => "pull-right" ,"icono" => "fa-link");
                        $boton_asistente['boton_6'] = array("elemento" => "boton" ,"modal" => "#modal_getPAMCrearAsistente" ,"color" => "btn-info" ,"click" => "getPAMAgregarAsistente(".$_POST['id_miembro'].")" ,"titulo" => "Agregar Asistente","lado" => "pull-right" ,"icono" => "fa-plus");
			
		}


        //presupuesto

                 $objMiembro2 = new Miembro();
                 $result_presupuestocobro= $objMiembro2->getPresupuesto($_POST['id_miembro'],date('Y'));  
                
                 $periodo_perio_id = "";
                 $id_presupuesto = 0;
                 $objMembresia2 = new Membresia();
                 $listaMemb = $objMembresia2->getListaComboMembresiaValor($lamembresia, $_SESSION['user_id_ben']);
                 if ($row_precobro = $result_presupuestocobro->fetch_assoc()) {
                     $id_presupuesto = $row_precobro['precobro_id'];
                     $periodo_perio_id = $row_precobro['periodo_perio_id'];
                 }
                 $objPresupuestoCobro2 = new PresupuestoCobro();
                 $objPeriodo = new Periodo();
                 $listaP['lista_'] = array("value" => "x",  "select" => "" ,"texto" => "Seleccione...");
                 $listaP = $objPeriodo->getListaPeriodos($periodo_perio_id);

                
                
                
                
                 if (strlen($id_presupuesto) > 0 && $id_presupuesto != "0") {
                     $form9['form_2'] = array("elemento" => "caja","tipo" => "hidden", "titulo" => "", "id" => "_periodo_presupuesto", "reemplazo" => 1);
                    $form9['form_1'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_id_presup" ,"reemplazo" => $id_presupuesto);
                    $form10['form_1'] = array("elemento" => "combo","change" => "", "titulo" => "Precio Mensual", "id" => "_membresia_presupuesto", "option" => $listaMemb);
                 } else {
                     $listam2 = array();                     
                     foreach ($listaMemb as $k=>$v) {                         
                        $listam2[$k] = $v;
                        $listam2[$k]['select'] = "";
                     }
                    $listam2['100000'] = array("value" => "x",  "select" => "Selected" ,"texto" => "Seleccione...");
                    $listaP['lista_'] = array("value" => "x",  "select" => "Selected" ,"texto" => "Seleccione...");
                    krsort($listam);
                    $form10['form_1'] = array("elemento" => "combo","change" => "", "titulo" => "Precio Mensual", "id" => "_membresia_presupuesto", "option" => $listam2);
                    $form9['form_1'] = array("elemento" => "caja","tipo" => "hidden", "titulo" => "", "id" => "_periodo_presupuesto", "reemplazo" => 1);
                    $form9['form_2'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_id_presup" ,"reemplazo" => 0);
                 }

                 
                
                $form_9 = generadorEtiqueta($form10);
                $form_10 = generadorEtiqueta($form9);
                $id_inscripcion = 0;
                $objMembresia3 = new Membresia();
                $tieneinscripcion = false;
                $listaMembValor = $objMembresia3->getListaComboMembresiaValorValor();
                        //inscripcion
                        $objInscripcion= new Inscripcion();
                        $resultset= $objInscripcion->getInscripcion($_POST['id_miembro']);  
                        if($row4 = $resultset->fetch_assoc()) {
                            $id_inscripcion = $row4['mie_ins_id'];                              
                            $fecha_ingreso= $row4['mie_ins_fecha_ingreso'];                      
                            $fecha_cobro= date('Y-m-d',strtotime($row4['mie_ins_fecha_cobro']));
                            if ( date_format(date_create($row4['mie_ins_fecha_ingreso']),'Y') == date('Y')) {
                                $tieneinscripcion = true;
                                       
                                $id_estado_cobro= $row4['estado_cobro_id'];
                                $valor_ins ="$ ".$row4['mie_ins_valor'];
                                $id_valor = "";
                                $objEstadoPresupuesto= new EstadoPresupuesto();
                                $objMembresia4 = new Membresia();
                                $resultset5 = $objMembresia4->getMembresiaByValor($row4['mie_ins_valor']);
                                if ($row5 = $resultset5->fetch_assoc()) {
                                    $id_valor = $row5['memb_id'];
                                }

                                $listam3 = array();                     
                                foreach ($listaMemb as $k=>$v) {                         
                                    $listam3[$k] = $v;
                                    $listam3[$k]['select'] = "";
                                    if ($listam3[$k]['value'] == $id_valor) {
                                        $listam3[$k]['select'] = "selected";
                                    }
                                }
                                $estado_presup = "";
                                $listaEP= array();
                                $listaEP['lista_'] = array("value" => "x",  "select" => "" ,"texto" => "Seleccione...");
                                $listaEP= $objEstadoPresupuesto->getListaEstadoPresupuestos($id_estado_cobro,NULL);                             
                                $form11['form_0'] = array("elemento" => "caja" ,"tipo" => "date", "titulo" => "Fecha de Registro", "id" => "_fecha_registro", "reemplazo" => $fecha_ingreso);                        
                                //$form11['form_1'] = array("elemento" => "combo","change" => "", "titulo" => "Estado", "id" => "_estado_presupuesto", "option" => $listaEP);
                                $form11['form_1'] = array("elemento" => "caja","tipo" => "hidden", "titulo" => "", "id" => "_estado_presupuesto", "reemplazo" => 2);
                                $form11['form_2'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_id_insc" ,"reemplazo" => $row4['mie_ins_id']);
                                
                                
                                $form12['form_0'] = array("elemento" => "caja" ,"tipo" => "hidden" , "titulo" => "", "id" => "_ins_valor" ,"reemplazo" => $id_valor);
                                $form12['form_1'] = array("elemento" => "combo", "deshabilitado" => true, "titulo" => "Precio",  "id" => "_ins_valor2" ,"option" => $listam3);
                                $form12['form_2'] = array("elemento" => "caja" ,"tipo" => "date", "titulo" => "Fecha de Cobro", "id" => "_fecha_cobro", "reemplazo" => $fecha_cobro);                        
                                
                            } else {
                                $objEstadoPresupuesto= new EstadoPresupuesto();
                                $listaEP= array();
                                $listaEP['lista_'] = array("value" => "x",  "select" => "" ,"texto" => "Seleccione...");
                                $listaEP= $objEstadoPresupuesto->getListaEstadoPresupuestos("",NULL);                             
                                $form11['form_0'] = array("elemento" => "caja" ,"tipo" => "date", "titulo" => "Fecha de Registro", "id" => "_fecha_registro", "reemplazo" => $fecha_ingreso);                            
                                //$form11['form_1'] = array("elemento" => "combo","change" => "", "titulo" => "Estado", "id" => "_estado_presupuesto", "option" => $listaEP);
                                $form11['form_1'] = array("elemento" => "caja","tipo" => "hidden", "titulo" => "", "id" => "_estado_presupuesto", "reemplazo" => 2);
                                $form11['form_2'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_id_insc" ,"reemplazo" => $row4['mie_ins_id']);
                                $form12['form_0'] = array("elemento" => "combo", "change" => "", "titulo" => "Precio",  "id" => "_ins_valor" ,"option" => $listaMemb);
                                //$form12['form_1'] = array("elemento" => "caja" ,"tipo" => "date", "titulo" => "Fecha de Cobro", "id" => "_fecha_cobro", "reemplazo" => $fecha_cobro);                        
                                                                $form12['form_2'] = array("elemento" => "caja" ,"tipo" => "date", "titulo" => "Fecha de Cobro", "id" => "_fecha_cobro", "reemplazo" => $fecha_cobro);                        
                                //$form12['form_1'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_ins_valor" ,"reemplazo" => 1);    
                            }                             
                        } else {
                            $objEstadoPresupuesto= new EstadoPresupuesto();
                            $listaEP= array();
                            $listaEP['lista_'] = array("value" => "x",  "select" => "" ,"texto" => "Seleccione...");
                            $listaEP= $objEstadoPresupuesto->getListaEstadoPresupuestos("",NULL);                             
                            $form11['form_0'] = array("elemento" => "caja" ,"tipo" => "date", "titulo" => "Fecha de Registro", "id" => "_fecha_registro", "reemplazo" => date('Y-m-d'));                            
                            //$form11['form_1'] = array("elemento" => "combo","change" => "", "titulo" => "Estado", "id" => "_estado_presupuesto", "option" => $listaEP);
                            $form11['form_1'] = array("elemento" => "caja","tipo" => "hidden", "titulo" => "", "id" => "_estado_presupuesto", "reemplazo" => 1);
                            $form11['form_2'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_id_insc" ,"reemplazo" => 0);
                            //$form12['form_0'] = array("elemento" => "combo", "change" => "", "titulo" => "Valor en base al Precio Mensual",  "id" => "_ins_valor" ,"option" => $$listaMemb);                            
                            $form12['form_0'] = array("elemento" => "combo", "change" => "", "titulo" => "Precio",  "id" => "_ins_valor" ,"option" => $listaMemb);
                            //$form12['form_1'] = array("elemento" => "caja" ,"tipo" => "date", "titulo" => "Fecha de Cobro", "id" => "_fecha_cobro", "reemplazo" => date('Y-m-d'));                        
                            $form12['form_1'] = array("elemento" => "caja" ,"tipo" => "date", "titulo" => "Fecha de Cobro", "id" => "_fecha_cobro", "reemplazo" => "");                        
                        }

                        $form_11= generadorEtiqueta($form11);
                        $form_12= generadorEtiqueta($form12);
                        $form_22 = generadorEtiqueta($form_20);
                             
                             


                        //end inscripcion
		               
						
						
        
        $resultado = str_replace("{contenedor_1}", $form_1,  getPage('page_detalle_update'));
        $resultado = str_replace("{contenedor_2}", $form_2, $resultado);         
        $resultado = str_replace("{contenedor_3}", $form_4, $resultado); 
        $resultado = str_replace("{contenedor_4}", $form_3, $resultado); 
        $resultado = str_replace("{contenedor_5}", $form_6, $resultado); 
        $resultado = str_replace("{contenedor_6}",$form_5, $resultado);
        $resultado = str_replace("{contenedor_5}", $form_6, $resultado); 
        $resultado = str_replace("{contenedor_6}",$form_5, $resultado);
		                        $resultado = str_replace("{contenedor_9}", $tablaDetalleEmpresas, $resultado);
                        $resultado = str_replace("{contenedor_10}", $tablaDetalleAsistente, $resultado);
        $resultado = str_replace("{contenedor_11}", $form_7, $resultado); 
        $resultado = str_replace("{contenedor_12}",$form_8, $resultado);
        $resultado = str_replace("{contenedor_13}",$form_11, $resultado);
        $resultado = str_replace("{contenedor_14}",$form_12, $resultado);
        $resultado = str_replace("{contenedor_15}",$form_9, $resultado);
        $resultado = str_replace("{contenedor_16}",$form_10, $resultado);
        $resultado = str_replace("{boton}",  generadorBoton($boton), $resultado); 
		$resultado = str_replace("{boton_empresas}", generadorBoton($boton_empresas), $resultado);
                        $resultado = str_replace("{boton_asistente}", generadorBoton($boton_asistente), $resultado);
        if (strlen($lamembresia) == 0 || $lamembresia == "0") {
            
            $msg= "Edita y agrega una Precio Mensual.";
            $alerta = str_replace("{contendor_1}", generadorAlertaEstatica("Alerta!",$msg,"info")  , getPage('pager_row')); 
            $resultado = str_replace("{contenedor_2}", $resultado, $alerta); 
        } else{
            
            if($id_inscripcion == "0" || !$tieneinscripcion){  
                $msg="Registra la Inscripción del Miembro.</br>";
            }     
            if(strlen($id_presupuesto) == 0 || $id_presupuesto == "0" ){
                $msg.= "Agrega un presupuesto.";   
            } 
            if(strlen($id_presupuesto) == 0 || $id_presupuesto == "0" || $id_inscripcion == "0"){
                $alerta = str_replace("{contenedor_1}", generadorAlertaEstatica("Alerta!",$msg,"info")  , getPage('pager_row')); 
                $resultado = str_replace("{contenedor_2}", $resultado, $alerta);   
            } 
            
        }
        
		
		
        return $resultado;
    }
    

}


function setSeleccionadoMiembro($lista = array(), $idSeleccionado = "") {
    $listaAux = array();
    $listaAux = $lista;

    foreach ($lista as $k => $l) {
        if ($l['value'] == $idSeleccionado) {
            $listaAux[$k]['select'] = "selected";
        }
    }

    return $listaAux;

}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']): 

            case 'KEY_ENVIAR_MAIL_BIENVENIDA':
                $objMiembro = new Miembro();
                $resultset = $objMiembro->getDataMiembroMailById($_POST['_id_miembro']);
                
                $mailfl = "";
                $datos = array();
                if ($row = $resultset->fetch_assoc()) {
                    $datos['nombre'] = $row['per_nombre'];
                    $datos['apellido'] = $row['per_apellido'];
                    $datos['cod_miembro'] = $row['mie_codigo'];
                    $datos['nombre_grupo'] = $row['gru_descripcion'];
                    $datos['forum_leader'] = $row['forum_leader'];
                    $datos['email'] = $row['cor_descripcion'];
                    if (strlen($row['mail_asistente']) > 0) {
                        $mailfl = $row['mail_asistente'];
                    } else {
                        $mailfl = $row['mail_forum_leader'];
                    }                    
                }

                $objPlantillaEmail = new PlantillaEmail();
                $resultset2 = $objPlantillaEmail->getPlantillaById(1);
                $plantilla = array();
                if ($row2 = $resultset2->fetch_assoc()) {
                    $plantilla['plantilla_html'] = $row2['plantilla_html'];
                    $plantilla['plantilla_asunto'] = $row2['plantilla_asunto'];
                }
                foreach ($datos as $k => $v) {
                    $plantilla['plantilla_html'] = str_replace("%".$k."%", $v, $plantilla['plantilla_html']);
                }

                
                enviarCorreo($datos['email'],$mailfl,$plantilla['plantilla_asunto'],$plantilla['plantilla_html']);
                

            break;
            case 'KEY_SHOW_FORM_ACTUALIZAR'://///////////////////////////////////////////////////////// 
			
			if(isset($_GET['id_miembro'])){ 
			 if(!empty($_GET['id_miembro']) ){ 
                    echo getDetalleUpdate($_GET['id_miembro'],FALSE);
                }
			}else{
			 if(!empty($_POST['id_miembro']) ){ 
                    echo getDetalleUpdate($_POST['id_miembro'],FALSE);
                }	
			}
               
                break;     
            case 'KEY_ARCHIVO':
                
                
                if(is_array($_FILES)) {
                if(is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                $sourcePath = $_FILES['archivo']['tmp_name'];                
                $targetPath = "../../public_html/i/".$_POST['codigo'].".jpg";
                move_uploaded_file($sourcePath,$targetPath);
                }}
                
                
                //echo '<img class="image-preview" src="'."../../public_html/i/".$_POST['codigo'].".jpg".'" class="upload-preview" />';
            break;
            case 'KEY_CANCELAR_MEMBRESIA_MIEMBRO':

             if( !empty($_POST['_id_miembro']) && !empty($_POST['_mes_elegido'])){

                    $objPresupuestoCobro = new PresupuestoCobro();
                    $data = explode('/',$_POST['_mes_elegido']);
                    $comp = $objPresupuestoCobro->cancelarPresupuestoCobroMiembro($_POST['_id_miembro'], intval($data[0]), $data[1]);                               
                        if($comp == "OK"){
                            $data = array("success" => "true", "priority"=>'success',"msg" => 'Los Cobros fueron cancelados exitosamente');
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

            case 'KEY_VERIFICAR_CODIGO':
                
             if( !empty($_POST['_id_miembro']) && !empty($_POST['_codigo'])){
                    $objMiembro = new Miembro();
                    $estaRepetido = $objMiembro->isCodigoRepetido($_POST['_id_miembro'], $_POST['_codigo']);                    
                    if (! $estaRepetido) {
                        $data = array("success" => "true", "priority"=>'success',"msg" => '');
                        echo json_encode($data);
                    } else {
                        $data = array("success" => "false", "priority"=>'info',"msg" => 'Disculpe el codigo esta repetido'); 
                        echo json_encode($data);
                    }
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data); 
                }
                                
            break;

            case 'KEY_SET_ESTADO_MIEMBRO':
                if (! empty($_POST['_id_miembro']) && ! empty($_POST['_id_status'])) {
                    $objMiembro = new Miembro();
                    $comp=$objMiembro->setEstadoMiembro($_POST['_id_miembro'], $_POST['_id_status'], $_SESSION['user_id_ben']);
                    if ($comp == "OK") {
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Estado del miembro fue actualizado exitosamente');
                        echo json_encode($data);
                    } else {
                        $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                        echo json_encode($data);
                    }
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data); 
                }                            
            break;
            case 'KEY_SHOW_FORM_DETALLE'://///////////////////////////////////////////////////////// 
                 if( !empty($_POST['id_miembro'])){ 
                    //Para asignar la base a la cual corresponde el miembro
                    // Si la variable $_POST['base'] esta vacia quiere decir que 
                    // el usuario logeado no tiene perfil de Lider Regional
                    if(!empty($_POST['base'])){
                       setDatosConexion($_POST['base']); 
                    }
                    
                    
                    $objMiembro= new Miembro();
                    $resultset= $objMiembro->getMiembro1($_POST['id_miembro']);  
                    if($row = $resultset->fetch_assoc()) {  
                    
                        $idpersona=$row['per_id'];
                        $titulo=$row['per_nombre'].' '.$row['per_apellido'];

                        $direccion= new Direccion();
                        $resultset_direccion= $direccion->getDireccion($idpersona);
                        if ($row_direccion = $resultset_direccion->fetch_assoc()) {
                            $direcion=$row_direccion['dir_calleprincipal'];
                            $ciudad=$row_direccion['ciu_nombre'];
                            $estado= $row_direccion['est_nombre'];
                            $pais= $row_direccion['pai_nombre'];
                            $prefijoPais=$row_direccion['pai_prefijo'];
                        }
/*
                        $objMiembro= new Miembro();
                        $tabla_desafios= array();
                        $tabla_desafios['b_'] = array("t_1" => generadorNegritas($lblDescDesafios), "t_2" => $row['mie_descripcion_desafio']);
                        $tabla_desafios= $objMiembro->getDetalleDesafios($_POST['id_miembro'], $tabla_desafios);


                        $objMiembro= new Miembro();
                        $tabla_hobbies= array();
                        $tabla_hobbies= $objMiembro->getDetalleHobbies($_POST['id_miembro']);
						
*/
                    
//                        if($row['modificado_global'] == '1'){
////                          setDatosConexion();
//                            setDatosConexion($_SESSION['user_subasedatos']);
//                            $objMiembro= new Miembro();
//                            $nombreGrupo= $objMiembro->getNombreGrupo($_POST['id_miembro']);
////                          setDatosConexion($_SESSION['user_subasedatos']);
//                            if(!empty($_POST['base'])){
//                                setDatosConexion($_POST['base']); 
//                            }
//                        }else{  
//                            $objMiembro= new Miembro();
//                            $nombreGrupo= $objMiembro->getNombreGrupo($_POST['id_miembro']);
//                        }
                        
                   
                        if (strlen($row['mie_codigo']) == 11 && file_exists("../../public_html/i/".$row['mie_codigo'].".jpg")) {
                            $tabla['t_0'] = array("t_1" => cargarImagen("../../i/".$row['mie_codigo'].".jpg"), "t_2" => "");                            
                        } else {
                            $tabla['t_0'] = array("t_1" => cargarImagen(""), "t_2" => "");
                            
                        }
                      
                        $tabla['t_1'] = array("t_1" => generadorNegritas("Código"), "t_2" => $row['mie_codigo']);
						$tabla['t_2'] = array("t_1" => generadorNegritas("Grupo"), "t_2" => $row['gru_descripcion']);
                        $tabla['t_3'] = array("t_1" => generadorNegritas($lblNombre), "t_2" => $titulo);
                        $tabla['t_4'] = array("t_1" => generadorNegritas($lblFNacimiento), "t_2" => getFormatoFechadmy($row['per_fechanacimiento']));
                  //      $tabla['t_4'] = array("t_1" => generadorNegritas($lblTitulo), "t_2" => $row['prof_descripcion']);
                   //     $tabla['t_5'] = array("t_1" => generadorNegritas($lblIdentificacion), "t_2" => $row['per_identificacion']);

                       // if($row['per_tipo']=='J'){$tabla['t_6'] = array("t_1" => generadorNegritas($lblTipoPersona), "t_2" => "Jurídica");} 
                       // if($row['per_tipo']=='N'){$tabla['t_6'] = array("t_1" => generadorNegritas($lblTipoPersona), "t_2" => "Natural");} 
                        //$tabla['t_7'] = array("t_1" => generadorNegritas($lblGenero), "t_2" => $row['per_genero']);

                        
                    //    $tabla2['t_1'] = array("t_1" => generadorNegritas("Precio Mensual"), "t_2" => $row['memb_descripcion']);
                        $tabla2['t_2'] = array("t_1" => generadorNegritas($lblForumLeader), "t_2" => $row['nombre_forum']);
                      //  $tabla2['t_3'] = array("t_1" => generadorNegritas("Grupo"), "t_2" => $row['gru_descripcion']);
                            //                        empresalocal.emp_id, 
                            //empresalocal.emp_nombre, 
                            //empresalocal.emp_ruc, 
                        
                        $tabla2['t_4'] = array("t_1" => generadorNegritas($lblEmpresa), "t_2" => $row['emp_nombre']);
                        $tabla2['t_5'] = array("t_1" => generadorNegritas($lblRUC), "t_2" => $row['emp_ruc']);
                        
                        $objEmpresaLocal= new EmpresaLocal();
                        $tabla2= $objEmpresaLocal->getMultiListaIndustria2($row['emp_id'],$tabla2, generadorNegritas($lblSectores));
                        
                        
                        
                        $tabla2['t_6'] = array("t_1" => generadorNegritas($lblCategoría), "t_2" => $row['cat_descripcion']);
                        $tabla2['t_7'] = array("t_1" => generadorNegritas("Estado del miembro"), "t_2" => $row['status']);
                        $tabla2['t_8'] = array("t_1" => generadorNegritas("Comentario"), "t_2" => $row['mie_observacion']);
                        
                        
                        $tabla3['t_1'] = array("t_1" => generadorNegritas($lblPais), "t_2" => $pais);
                        $tabla3['t_2'] = array("t_1" => generadorNegritas($lblProvincia), "t_2" => $estado);
                        $tabla3['t_3'] = array("t_1" => generadorNegritas($lblCiudad), "t_2" => $ciudad);
                        $tabla3['t_4'] = array("t_1" => generadorNegritas($lblDireccion), "t_2" => $direcion);

                        $tabla4['t_8'] = array("t_1" => generadorNegritas($lblFRegistro), "t_2" => getFormatoFechadmyhis($row['mie_fecharegistro']));
                        $tabla4['t_9'] = array("t_1" => generadorNegritas($lblFModificacion), "t_2" => getFormatoFechadmyhis($row['mie_fechamodificacion']));
                        $tabla4['t_10'] = array("t_1" => generadorNegritas($lblUModificar), "t_2" =>  $row['modificador']);
                          
                        $tabla5['t_8'] = array("t_1" => generadorNegritas($lblCorreo), "t_2" => $row['correo']);
                      //  $tabla5['t_9'] = array("t_1" => generadorNegritas($lblCorreoSecundario), "t_2" => $row['correo2']);
                        if($row['mie_participacion_correo']=='1'){
                          $tabla5['t_10'] = array("t_1" => generadorNegritas($lblParticipacionCorreo), "t_2" => 'SI');
                        }  else {
                          $tabla5['t_10'] = array("t_1" => generadorNegritas($lblParticipacionCorreo), "t_2" => 'NO');
                        }
                        $tabla6['t_11'] = array("t_1" => generadorNegritas($lblTF), "t_2" => "(". $prefijoPais.") ".$row['movil2']);
                        $tabla6['t_12'] = array("t_1" => generadorNegritas($lblTM), "t_2" => "(". $prefijoPais.") ".$row['movil']);
                        
                      //  $tabla6['t_13'] = array("t_1" => generadorNegritas($lblSkype), "t_2" => $row['skype']);
                      //  $tabla6['t_14'] = array("t_1" => generadorNegritas($lblTwitter), "t_2" => $row['twitter']);
                          $tabla6['t_13'] = array("t_1" => generadorNegritas("Nombre de Pareja"), "t_2" => $row['skype']);
                        $tabla6['t_14'] = array("t_1" => generadorNegritas("Hijos"), "t_2" => $row['twitter']);
                      
                        ////////////////////////////////////////////////////////
                        //Empresas

                      
                        $objEmpresaLocal= new EmpresaLocal();
                        $tablaDetalleEmpresas=$objEmpresaLocal->getTabla($_POST['id_miembro'],'1');
                        
                        
                        //PAMAsistente
                
                        $objPAMAsistente= new PAMAsistente();
                        $tablaDetalleAsistente= $objPAMAsistente->getTabla($_POST['id_miembro'],'1');
                       

                        ////////////////////////////////////////////////////////
                        //presupuesto
                        $objMiembro= new Miembro();
                        $resultset= $objMiembro->getPresupuesto($_POST['id_miembro'],date('Y'));  
                        if($row2 = $resultset->fetch_assoc()) {  

                            $nombre= $row['per_nombre'].' '.$row['per_apellido'];
                            $id_presupuesto= (empty($row2['precobro_id']) ? "0" : $row2['precobro_id']);
                            $id_periodo= (empty($row2['periodo_perio_id']) ? "0" : $row2['periodo_perio_id']);
                           
                            $fecha_registro_cobros= (empty($row2['precobro_fechainiciomiembro']) ? date('Y-m-d',strtotime($row['mie_fecharegistro'])) : date('Y-m-d',strtotime($row2['precobro_fechainiciomiembro'])));
                            $id_membresia= (empty($row['membresia_id']) ? "0" : $row['membresia_id']);
                            
                            //para cuando desee actualizar y ya existan cobros en base a ese presupuesto
                            $ultimaFechaXPagar= (empty($row2['ultima_fecha_x_pagar']) ? "0" : $row2['ultima_fecha_x_pagar']);
                            $fechaXPagar= (empty($row2['fecha_x_pagar']) ? "0" : date('Y-m-d',strtotime($row2['fecha_x_pagar'])));
                            if($fechaXPagar != "0"){
                                if($fechaXPagar <= $fecha_registro_cobros){
                                    $fechaXPagar= "0";
                                }
                            }
                            ///////////////////////////////////////////////////////////////////
                           
                            $funcion= "getInscripcion(".$row['mie_id'].",'".$nombre."','".date('Y-m-d',strtotime($row['mie_fecharegistro']))."','".$id_membresia."')";
                            $funcion_1= "getAgregarPresupuesto(".$id_presupuesto.",".$row['mie_id'].",".$id_membresia.",'".$nombre."',".$id_periodo.",'".$fecha_registro_cobros."','".$fechaXPagar."','".$ultimaFechaXPagar."')";
                            $funcion_2="getDetallePresupuesto(".$id_presupuesto.")";
                            
                            
                        }

                        $objPresupuestoCobro = new PresupuestoCobro();
                        $resultset_presupuestocobro = $objPresupuestoCobro->getPresupuestoMiembro($id_presupuesto);
                        if ($row3 = $resultset_presupuestocobro->fetch_assoc()) {
                            $tabla9['t_0'] = array("t_1" => generadorNegritas("Periodo"), "t_2" => $row3['perio_descripcion']);
                            $tabla10['t_0'] = array("t_1" => generadorNegritas("Precio Mensual"), "t_2" => "$ " . $row3['precobro_valor']);
                        } else {
                            $tabla9['t_0'] = array("t_1" => generadorNegritas("Periodo"), "t_2" => "---");
                            $tabla10['t_0'] = array("t_1" => generadorNegritas("Precio Mensual"), "t_2" => "---");
                        }

                        //inscripcion
                        $objInscripcion= new Inscripcion();
                        $tieneinscripcion = false;
                        $resultset= $objInscripcion->getInscripcion($_POST['id_miembro']);  
                        if($row4 = $resultset->fetch_assoc()) { 
                            $fecha_ingreso= $row4['mie_ins_fecha_ingreso'];   
                            $fecha_cobro= date('Y-m-d',strtotime($row4['mie_ins_fecha_cobro'])); 
                            if ( date_format(date_create($row4['mie_ins_fecha_ingreso']),'Y') == date('Y')) {
                                $tieneinscripcion = true;
                                                          
                                $id_estado_cobro= $row4['estado_cobro_id'];
                                $valor_ins ="$ ".$row4['mie_ins_valor'];
                                
                                $objEstadoPresupuesto= new EstadoPresupuesto();
                                $estado_presup = "";
                                $listaEP= array();
                                $listaEP= $objEstadoPresupuesto->getListaEstadoPresupuestos($id_estado_cobro,NULL);
                                foreach($listaEP as $l) {
                                    if (strlen($l['select'])) {
                                        $estado_presup = $l['texto'];
                                    }
                                }
                                $tabla7['t_0'] = array("t_1" => generadorNegritas("Fecha de Registro"), "t_2" => getFormatoFechadmy($fecha_ingreso));
                                $tabla7['t_1'] = array("t_1" => generadorNegritas("Estado"), "t_2" => $estado_presup);
                                $tabla8['t_0'] = array("t_1" => generadorNegritas("Precio"), "t_2" => $valor_ins);
                                $tabla8['t_1'] = array("t_1" => generadorNegritas("Fecha de Cobro"), "t_2" => getFormatoFechadmy($fecha_cobro));
                            } else {
                                $tabla7['t_0'] = array("t_1" => generadorNegritas("Fecha de Registro"), "t_2" => getFormatoFechadmy($fecha_ingreso));
                                $tabla7['t_1'] = array("t_1" => generadorNegritas("Estado"), "t_2" => "---");
                                $tabla8['t_0'] = array("t_1" => generadorNegritas("Precio"), "t_2" => "---");
                                $tabla8['t_1'] = array("t_1" => generadorNegritas("Fecha de Cobro"), "t_2" => getFormatoFechadmy($fecha_cobro));    
                            }
                             
                        } else {
                            $tabla7['t_0'] = array("t_1" => generadorNegritas("Fecha de Registro"), "t_2" => "---");
                            $tabla7['t_1'] = array("t_1" => generadorNegritas("Estado"), "t_2" => "---");
                            $tabla8['t_0'] = array("t_1" => generadorNegritas("Precio"), "t_2" => "---");
                            $tabla8['t_1'] = array("t_1" => generadorNegritas("Fecha de Cobro"), "t_2" => "---");
                        }
                             
                             


                        //end inscripcion
                        


                        $boton=array();
                        if($id_membresia != "0"){
                         /*   if (in_array($perEditarInscripcionOp6, $_SESSION['usu_permiso'])) {
                                $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "#modal_inscripcion"  ,"color" => "btn-info" ,"click" => $funcion ,"titulo" => "Inscripción","lado" => "pull-right" ,"icono" => "");
                            }*/
                            /*if (in_array($perVerDetallePresupuestoOp6, $_SESSION['usu_permiso'])) {
                                $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "#modal_detallePresupuesto"  ,"color" => "btn-info" ,"click" => $funcion_2 ,"titulo" => "Cuotas","lado" => "pull-right" ,"icono" => "");
                            }*/
                            /*
                            if (in_array($perAgregarPresupuestoOp6, $_SESSION['usu_permiso'])) {
                                $boton['boton_3'] = array("elemento" => "boton" ,"modal" => "#modal_agregarPresupuesto"  ,"color" => "btn-info" ,"click" => $funcion_1 ,"titulo" => "Presupuesto","lado" => "pull-right" ,"icono" => "");
                            }*/
                        }                     
                        ////////////////////////////////////////////////////////
                        $user= $row['mie_codigo'];
                        if($row['user'] != ''){
                            $user= $row['user'];
                        }

                        if (in_array($perEnviarCorreoOp6, $_SESSION['usu_permiso'])) {
                            
                            //$boton['boton_2'] = array("elemento" => "boton" ,"modal" => "#modal_enviarCorreo"  ,"color" => "btn-info" ,"click" => "getEnviarCorreoIndividual('".$row['correo']."','".$titulo."')" ,"titulo" => $lblbtnEnviarCorreo,"lado" => "pull-right" ,"icono" => "");
                            $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "#modal_enviarCorreo"  ,"color" => "btn-info" ,"click" => "getEnviarCorreoIndividual('".$row['correo']."','".$titulo."')" ,"titulo" => $lblbtnEnviarCorreo,"lado" => "pull-right" ,"icono" => "fa-pencil");
                        }
                        /*
                        if (in_array($perAsignarUserOp6, $_SESSION['usu_permiso'])) {
                            $boton['boton_5'] = array("elemento" => "boton" ,"modal" => "#modal_getCrearUserClave" ,"color" => "btn-info" ,"click" => "getAsignarUserClave(".$idpersona.",'".$user."','".$row['correo']."' )" ,"titulo" => $lblActualizarUsuario,"lado" => "pull-right" ,"icono" => "");
                        }*/
                        $_SESSION['_ultimo_id_miembro_prospecto']= $_POST['id_miembro'];
                        $_SESSION['_ultimo_id_miembro_prospecto_bandera']= '1';
                        $boton_empresas['boton_1'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getPAMEmpresaModal('2')" ,"titulo" => "Crear Relacionar Empresa","lado" => "pull-right" ,"icono" => "fa-plus");
                        $boton_empresas['boton_2'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getAgregarEmpresa(".$_POST['id_miembro'].")" ,"titulo" => "Relacionar Empresa Existente","lado" => "pull-right" ,"icono" => "fa-link");
                        $boton_asistente['boton_6'] = array("elemento" => "boton" ,"modal" => "#modal_getPAMCrearAsistente" ,"color" => "btn-info" ,"click" => "getPAMAgregarAsistente(".$_POST['id_miembro'].")" ,"titulo" => "Agregar Asistente","lado" => "pull-right" ,"icono" => "fa-plus");
                             
                        $boton1=array();
                        if (in_array($perActualizarMiembroOp6, $_SESSION['usu_permiso'])) {
                            $boton1['boton_1'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getUserEditar(".$_POST['id_miembro'].")" ,"titulo" => $lblbtnEditar ,"lado" => "pull-right" ,"icono" => "fa-pencil");        
                        }
                        
                        $acciones= "";
                        if($_SESSION['user_subasedatos'] == $_SESSION['db']){
//                            if($_SESSION['user_subasedatos'] == $_POST['base'] || empty($_POST['base'])){
                            $acciones= generadorBotonSinLado($boton) 
                                . generadorBotonSinLado($boton1);
                        }
                        $boton2['boton_1'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");
                        
                        $botones= '<div class="box-tools pull-right">'
                                . $acciones
                                . generadorBotonSinLado($boton2)
                                .'</div>';
                        //table-hover
                        $resultado = str_replace("{contenedor_1}", "",  getPage('page_detalle') );//generadorContMultipleRow($colum)); 
                        $resultado = str_replace("{contenedor_2}", "", $resultado);   
                        
                        $resultado = str_replace("{contenedor_3}", generadorTabla_2($tabla, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_4}", generadorTabla_2($tabla2, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_5}", generadorTabla_2( $tabla3, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_6}", generadorTabla_2($tabla4, "table-striped"), $resultado); 
                        //$resultado = str_replace("{contenedor_7}", generadorTabla_2( $tabla_hobbies, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_7}", "", $resultado); 
                        $resultado = str_replace("{contenedor_8}", generadorTabla_2($tabla_desafios, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_9}", $tablaDetalleEmpresas, $resultado);
                        $resultado = str_replace("{contenedor_10}", $tablaDetalleAsistente, $resultado);
                        $resultado = str_replace("{contenedor_11}", generadorTabla_2($tabla5, "table-striped"), $resultado);
                        $resultado = str_replace("{contenedor_12}", generadorTabla_2($tabla6, "table-striped"), $resultado);
                        $resultado = str_replace("{contenedor_13}", generadorTabla_2($tabla7, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_14}", generadorTabla_2($tabla8, "table-striped"), $resultado);
                        $resultado = str_replace("{contenedor_15}", generadorTabla_2($tabla9, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_16}", generadorTabla_2($tabla10, "table-striped"), $resultado);
                        $resultado = str_replace("{boton}", $botones, $resultado);
                        $resultado = str_replace("{boton_empresas}", generadorBoton($boton_empresas), $resultado);
                        $resultado = str_replace("{boton_asistente}", generadorBoton($boton_asistente), $resultado);
                        $alert="";
                        $msg="";
                        if($id_membresia == "0"){
                            $msg= "Edita y agrega una Precio Mensual.";
                            $alerta = str_replace("{contenedor_1}", generadorAlertaEstatica("Alerta!",$msg,"info")  , getPage('pager_row')); 
                            $resultado = str_replace("{contenedor_2}", $resultado, $alerta); 
                        }else{
                            if($row['inscripcion'] == "" || !$tieneinscripcion){  
                                $msg="Registra la Inscripción del Miembro.</br>";
                            }     
                            if($id_presupuesto == "0" ){
                                $msg.= "Agrega un presupuesto.";   
                            } 
                            if($id_presupuesto == "0" || $row['inscripcion'] == ""){
                                
                                $alerta = str_replace("{contenedor_1}", generadorAlertaEstatica("Alerta!",$msg,"info")  , getPage('pager_row')); 
                                $resultado = str_replace("{contenedor_2}", $resultado, $alerta);   
                            } 
                           
                        }
                        
                        echo $resultado;

                    }  else {
						if(isset($_GET['id_miembro'])){
							echo getDetalleUpdate($_GET['id_miembro'], TRUE );
						}else{
							echo getDetalleUpdate($_POST['id_miembro'], TRUE );
						}
                            
                    }
                    setDatosConexion($_SESSION['user_subasedatos']);
                    exit();
                }
                break;    
            case 'KEY_ACTUALIZAR'://
                 if( !empty($_POST['_propietario']) && !empty($_POST['_nombre'] ) && !empty($_POST['_apellido'] )
                         && !empty($_POST['_grupo_asignar'] ) && !empty($_POST['_codigo'] )
                         && !empty($_POST['_id_empresa'] )){ 
                    if($_POST['_membresia'] == "x"){
                        $data = array("success" => "false", "priority"=>'info',"msg" => "Debes seleccionar una Precio Mensual!");
                        echo json_encode($data);
                        exit();
                    }
                    if($_POST['_status'] == "x"){
                        $data = array("success" => "false", "priority"=>'info',"msg" => "Debes seleccionar un Member Status!");
                        echo json_encode($data);
                        exit();
                    }
                    $listaDesafios="";
                    if(isset($_POST['_lista_desafio'])){
                        foreach($_POST['_lista_desafio'] as $valor){
                            $listaDesafios.= $valor.",";
                        }
                    }
                    $listaHobbies="";
                    if(isset($_POST['_lista_hobbies'])){
                        foreach($_POST['_lista_hobbies'] as $valor){
                            $listaHobbies.= $valor.",";
                        }
                    }
                     
                     
                     $objMiembro= new Miembro();
                     $comp= $objMiembro->setActualizarMiembro($_POST['_id_miembro'],$_POST['_id_persona'],$_POST['_propietario'], $_POST['_nombre'], 
                                                            $_POST['_apellido'], $_POST['_titulo'], $_POST['_correo'] ,$_POST['_correo_2'], 
                                                            $_POST['_telefono'] , $_POST['_celular'] ,$_POST['_participacion'], $_POST['_fn'],
                                                            $_POST['_id_skype'] ,  $_POST['_id_Twitter'],$_POST['_calle'],$_POST['_ciudad'] ,
                                                            $_POST['_categoria']  , $_POST['_desafios'], $_POST['_identificacion'],$_POST['_genero'],
                                                            $_POST['_tipo_p'],$listaHobbies,$listaDesafios,$_POST['_grupo_asignar'],
                                                            $_POST['_codigo'],  $_SESSION['user_id_ben'] ,$_POST['_membresia'],$_POST['_status'],
                                                            $_SESSION['global_have_perfil_regional_temporales'],$_POST['_observacion'],$_POST['_id_empresa'],$_POST['_precio_esp']);  
                    if($comp == "OK"){
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Miembro se actualizó correctamente!');  
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
            case 'KEY_SHOW_COMBO_GRUPOS':
                if(!empty($_POST['_propietario'])){    
    
                    $objGrupo= new Grupo();
                    $listaGrupos= $objGrupo->getListaComboGruposForum($_POST['_propietario']);
      
                    $data = array("success" => "true", 
                        "grupos" => $listaGrupos);  
                    echo json_encode($data); 
                
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'El combo no tiene datos!');  
                    echo json_encode($data); 
                }

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

                if(!empty($_POST['_key_filtro']) 
                && !empty($_POST['_filtro'])  
                && strlen($_POST['_canceladas']) > 0){ 
                    $permiso= "";                    
                    if (in_array($perFiltroVerMiembrosForumOp6, $_SESSION['usu_permiso'])) {
                        //if ($_SESSION['user_id_ben'] != 94) {
                            $permiso= $_SESSION['user_id_ben'];
                        //}
                       
                    }
                    
                    
                    $id="";           
                    if($_POST['_filtro'] == "x"){
                        $tabla= getTablaFiltrada("","",$permiso, $_POST['_canceladas']);
                    }else{
                        $tabla= getTablaFiltrada($_POST['_filtro'], $_POST['_key_filtro'],$permiso, $_POST['_canceladas']);
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
                        //+++++++++++++++++++++++++++++++++++++++++++++++++++++
                        $lista["0"]= array("value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");                                
                        $objGrupo= new Grupo();
                        if ($_POST['_filtro'] == "x") {
                            $listaGrupos= $objGrupo->getListaGrupos2(NULL,$lista);                   
                        } else {
                            $listaGrupos= $objGrupo->getListaGruposForum($_POST['_filtro'],NULL, $lista);                   
                        }
                        
                        $gruposfiltro= generadorComboSelectOption("_grupo", "getFiltro('1')",$listaGrupos);
                        $data = array("success" => "true", 
                        "tabla" => $tabla,
                        "gruposfiltro" => $gruposfiltro,
                        "id" => $id);  
                        echo json_encode($data); 
                        exit();
                        //+++++++++++++++++++++++++++++++++++++++++++++++++++++
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
            ////////////////////////////////////////////////////////////////////
            //presupuesto
            case 'KEY_GUARDAR_PRESUPUESTO':  


                  if( !empty($_POST['_id_miembro']) && !empty($_POST['_id_periodo']) && !empty($_POST['_id_membresia']) && !empty($_POST['_fecha_registro'])  ){     
                     /*if(date('Y',strtotime($_POST['_fecha_registro'])) > date("Y") || date('Y',strtotime($_POST['_fecha_registro'])) < date("Y")){
                         $data = array("success" => "false", "priority"=>'info',"msg" => "La fecha debe estar en el rango de este año!");
                         echo json_encode($data);
                         exit();
                     }*/
                     ////////////////////////////////////////////////////////////
                     $objPerido = new Periodo();
                     $periodoMeses= $objPerido->getPeriodoMes($_POST['_id_periodo']);

                     $objMembresia = new Membresia();
                     $membresiaValor= $objMembresia->getMembresiaValor($_POST['_id_membresia']);


                     $objPresupuestoCobro3 = new PresupuestoCobro();
                     $objPresupuestoCobro4 = new PresupuestoCobro();
                     $listaFechasCuotasEnCero = array();
                     $listaFechasCuotasEnCero = $objPresupuestoCobro3->getFechasConCuotasEnCero($_POST['_id_presupuesto']);
                     $listaFechasCuotasPagas = array();
                     $listaFechasCuotasPagas = $objPresupuestoCobro4->getFechasConCuotasPagas($_POST['_id_presupuesto']);
                     $objMiembro3 = new Miembro();
                     $resultsetm = $objMiembro3->getMiembro1($_POST['_id_miembro']);
                     $miembroCancelled = 0;
                     $fechaCambioStatus = "";
                     if ($row6 = $resultsetm->fetch_assoc()) {
                        $miembroCancelled = $row6['cancelled'];
                        $fechaCambioStatus = date_format(date_create($row6['mie_fecha_cambio_status']),'Y-m-d');
                     }

                     ////////////////////////////////////////////////////////////
                     //Obtener las fechas del primer período
                     $multiplicadorPeriodo= 0;
                     $listaFechaLetrasPeriodos="";
                     $fechaPrimeraVuelta="";

                     $multiplicadorLetrasFaltantes= 0;
                     $listaFechaLetrasFaltantes="";

                     $fechaRegistroPresupuesto= date('Y-m-d',strtotime($_POST['_fecha_registro']));
                     if (date('Y') ==  date('Y',strtotime($_POST['_fecha_registro']))) {
                        $fechaPrimerDia_Registro= getPrimerDiaMes(date("Y"), date('m',strtotime($_POST['_fecha_registro'])));
                     } else {
                         $fechaPrimerDia_Registro= getPrimerDiaMes(date('Y',strtotime($_POST['_fecha_registro'])), date('m',strtotime($_POST['_fecha_registro'])));
                         //$fechaPrimerDia_Registro= getPrimerDiaMes(date("Y"), '01');
                     }
                     
                     for ($index = $periodoMeses; $index <= 12; $index = $index + $periodoMeses) {
                             $fecha = getPrimerDiaMes(date('Y',strtotime($_POST['_fecha_registro'])), ($index - $periodoMeses) + 1);
                             if ($fecha >= $fechaPrimerDia_Registro) { //ojo, parte siempre y cuando sea mayor
                                 if ($fechaPrimeraVuelta == "") {
                                     $fechaPrimeraVuelta= $fecha;
                                 }
                                 if (! in_array($fecha, $listaFechasCuotasEnCero) && ! in_array($fecha, $listaFechasCuotasPagas)) {
                                    $listaFechaLetrasPeriodos.= $fecha.",";
                                    $multiplicadorPeriodo= $multiplicadorPeriodo + 1;
                                 }                                 
                             }
                     }
                     ////////////////////////////////////////////////////////////
                     //Obtener meses que falten de pagar, que no hayan caído en el período  
                     $numMes_DelRegistro= date("m", strtotime($fechaRegistroPresupuesto)); //2 febrero  1
                     $numMes_DelPrimeraVuelta= date("m", strtotime($fechaPrimeraVuelta)); //3 abril  
                     if($listaFechaLetrasPeriodos == ""){
                         $numMes_DelPrimeraVuelta= $numMes_DelPrimeraVuelta + 1;
                     }                      

                     $numMesesFaltantes= $numMes_DelPrimeraVuelta - $numMes_DelRegistro;
                     if($numMesesFaltantes > 0){
                         for ($index = $numMes_DelRegistro; $index < $numMes_DelPrimeraVuelta; $index = $index + 1) {
                             $fecha= getPrimerDiaMes(date('Y',strtotime($_POST['_fecha_registro'])),$index); 
                             if (! in_array($fecha, $listaFechasCuotasEnCero) && ! in_array($fecha, $listaFechasCuotasEnCero)) {
                                $listaFechaLetrasFaltantes.= $fecha.",";
                                $multiplicadorLetrasFaltantes= $multiplicadorLetrasFaltantes + 1;
                             }
                             
                         }    
                     }
                     ////////////////////////////////////////////////////////////
                     $numCuotasEnCero = 0;
                     $numCuotasEnCero = count($listaFechasCuotasEnCero);
                     $valorCobrarPeriodo= $membresiaValor * ($periodoMeses - $numCuotasEnCero);  
                     $valorCobrarLetrasFaltantes= $membresiaValor;

                     $totalCobrar= ($valorCobrarPeriodo * $multiplicadorPeriodo) + ($valorCobrarLetrasFaltantes * $multiplicadorLetrasFaltantes);
                     $objTipoPresupuesto = new TipoPresupuesto();
                     $idTipo= $objTipoPresupuesto->getPrimerIDTipo();
                     
                     if($_POST['_id_presupuesto'] != "0"){
                         $objPresupuestoCobro= new PresupuestoCobro();   
                         $comp= $objPresupuestoCobro->actualizarPresupuestoCobroMiembro($_POST['_id_presupuesto'], $valorCobrarPeriodo,
                                 $totalCobrar,$_POST['_id_periodo'], $_SESSION['user_id_ben'],$listaFechaLetrasPeriodos, $_POST['_id_membresia'],
                                 $_POST['_id_miembro'],$listaFechaLetrasFaltantes, $valorCobrarLetrasFaltantes,
                                 $idTipo, $miembroCancelled, $fechaCambioStatus, date('Y',strtotime($_POST['_fecha_registro']))); 
                         $msg='El Presupuesto se actualizo correctamente!';
                      }else{

                         $objPresupuestoCobro= new PresupuestoCobro();
                         $comp= $objPresupuestoCobro->grabarPresupuestoCobroMiembro( $valorCobrarPeriodo, $fechaRegistroPresupuesto, $_POST['_id_miembro'],
                                 $totalCobrar,$_POST['_id_periodo'], $_SESSION['user_id_ben'],$listaFechaLetrasPeriodos, $_POST['_id_membresia'],
                                  $listaFechaLetrasFaltantes, $valorCobrarLetrasFaltantes, $idTipo, $miembroCancelled, $fechaCambioStatus, date('Y',strtotime($_POST['_fecha_registro']))); 
                         $msg='El Presupuesto se creo correctamente!';
                      }


                     if($comp == "OK"){
                         $data = array("success" => "true", "priority"=>'success',"msg" => $msg);
                         
                     }else{                         
                         $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                         
                     }   
                     //$data = array("success" => "true", "priority"=>'success',"msg" => "mensaje");
                     echo json_encode($data);             

                 }  else {
                     $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                     echo json_encode($data); 
                 }

                break;
            case 'KEY_DETALLE_PRESUPUESTO':
                 if(!empty($_POST['id_presupuesto']) ){         
                     $cuerpo='';
                     $cont=1;
                     $objPresupuestoCobro= new PresupuestoCobro();
                     $resultset= $objPresupuestoCobro->getDetallePresupuestoMiembro($_POST['id_presupuesto']);
                     while ($row = $resultset->fetch_assoc()) {  
                        $fecha= getFormatoFechadmy($row['detalleprecobro_fechavencimiento']);
                        $cuerpo.= generadorTablaColoresFilas("" ,
                                array(
                                    $cont,
                                    $row['detalleprecobro_valor'],
                                    $fecha,
                                    $row['detalleprecobro_estado']));
                         $cont=$cont + 1;
                      }
                     $tablaDetalle= generadorTablaDetalleEstadoCuenta(
                         array( 
                             generadorNegritas("N°"),
                             generadorNegritas("Valor"),
                             generadorNegritas("Fecha"),
                             generadorNegritas("Estado")), $cuerpo);  
                     echo $tablaDetalle;
                 }
                 break;
            case 'KEY_INSCRIPCION':
                 if(!empty($_POST['id_miembro']) ){         

                         $id_inscripcion="0";
                         $id_estado_cobro="0";
                         $valor="";
                         $fecha_ingreso= $_POST['fecha_registro'];
                         $fecha_cobro= date('Y-m-d') ; 
                         $objInscripcion= new Inscripcion();
                         $resultset= $objInscripcion->getInscripcion($_POST['id_miembro']);  
                         if($row = $resultset->fetch_assoc()) {  
                             $fecha_ingreso= $row['mie_ins_fecha_ingreso'];
                             $id_inscripcion= $row['mie_ins_id'];
                             $id_estado_cobro= $row['estado_cobro_id'];
                             $valor="$ ".$row['mie_ins_valor'];
                             $fecha_cobro= date('Y-m-d',strtotime($row['mie_ins_fecha_cobro'])) ; 
                         }
                             $objMembresia= new Membresia();
                             $lista= array();
                             $lista= $objMembresia->getListaMembresias($_POST['membresia'],NULL, $_SESSION['user_id_ben']);

                             $objEstadoPresupuesto= new EstadoPresupuesto();
                             $listaEP= array();
                             $listaEP= $objEstadoPresupuesto->getListaEstadoPresupuestos($id_estado_cobro,NULL);


                             $formModal['form_1'] = array("elemento" => "caja - oculta","id" => "_id_inscripcion" ,"reemplazo" => $id_inscripcion);
                             $formModal['form_2'] = array("elemento" => "caja - oculta","id" => "_id_miembro_inscripcion" ,"reemplazo" => $_POST['id_miembro']);   

                             $formModal['form_3'] = array("elemento" => "caja" ,"disabled" => "" ,"tipo" => "text" , "titulo" => "Miembro", "id" => "_nombre_inscripcion" ,"reemplazo" => $_POST['nombre']); 
                             $formModal['form_4'] = array("elemento" => "caja" ,"disabled" => "","tipo" => "date" , "titulo" => "Fecha de Registro", "id" => "_fecha_inscripcion" ,"reemplazo" => $fecha_ingreso);  
                             if($id_estado_cobro == "1" || $id_estado_cobro == "0") {
                                 $formModal['form_5'] = array("elemento" => "combo" ,"disabled" => "", "change" => "","titulo" => "Precio Mensual", "id" => "_membresia_inscripcion", "option" => $lista); 
                             }  else {
                                  $formModal['form_6'] = array("elemento" => "caja" ,"disabled" => "disabled","tipo" => "text" , "titulo" => "Valor en base a la Precio Mensual", "id" => "_valor" ,"reemplazo" => $valor);
                             }

                             $formModal['form_7'] = array("elemento" => "combo" ,"disabled" => "","change" => "","titulo" => "Estado", "id" => "_estado_inscripcion", "option" => $listaEP);  
                             $formModal['form_8'] = array("elemento" => "caja" ,"disabled" => "","tipo" => "date" , "titulo" => "Fecha de Cobro", "id" => "_fecha_cobro" ,"reemplazo" => $fecha_cobro);  
                             $botonModal ="";
                             if($id_inscripcion != "0") {
                                 if($id_estado_cobro != "2" ) {
                                     $botonModal['boton_1'] = array("id" => "btnGuardarInscripcion" ,"color" => "btn-primary" ,"click" => "setAgregarInscripcion()" ,"titulo" => "Actualizar" ,"icono" => "fa-pencil");
                                  }
                              }else{
                                 $botonModal['boton_1'] = array("id" => "btnGuardarInscripcion" ,"color" => "btn-primary" ,"click" => "setAgregarInscripcion()" ,"titulo" => "Guardar" ,"icono" => "fa-pencil");
                              }

                             $modal= generadorEtiquetaVVertical2($formModal).generadorBotonVModal($botonModal);
                             echo $modal;

                 }
                 break;
            case 'KEY_GUARDAR_INSCRIPCION':  

                  if( !empty($_POST['_id_miembro_inscripcion']) && !empty($_POST['_fecha_inscripcion']) && !empty($_POST['_membresia_inscripcion']) && !empty($_POST['_estado_inscripcion'])){     
 //                    if($_POST['_estado_inscripcion'] == "2"){
 //                        $data = array("success" => "false", "priority"=>'info',"msg" => "La Inscripción ya fue cobrada!");
 //                        echo json_encode($data);
 //                        exit();
 //                    }

                     $objMembresia = new Membresia();
                     $membresiaValor= $objMembresia->getMembresiaValor($_POST['_membresia_inscripcion']);


                      if($_POST['_id_inscripcion'] != "0"){
                         $objInscripcion= new Inscripcion();   
                         $comp= $objInscripcion->setActualizar($_POST['_id_inscripcion'],$membresiaValor,$_SESSION['user_id_ben'],$_POST['_fecha_inscripcion'],$_POST['_estado_inscripcion'],$_POST['_fecha_cobro']); 
                         $msg='La Inscripción se actualizo correctamente!';
                      }else{

                         $objInscripcion= new Inscripcion();
                         $comp= $objInscripcion->setGrabar( $membresiaValor, $_POST['_id_miembro_inscripcion'], $_SESSION['user_id_ben'],
                                 $_POST['_fecha_inscripcion'],$_POST['_estado_inscripcion'], $_POST['_fecha_cobro']); 

                         $msg='La Inscripción se creo correctamente!';
                      }


                     if($comp == "OK"){
                         $data = array("success" => "true", "priority"=>'success',"msg" => $msg);
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
            case 'KEY_ACTUALIZAR_CREDENCIALES':///////////////////////////////////////////////////////////       
                      if(!empty($_POST['_id']) && !empty($_POST['_user']) && !empty($_POST['_contraseña']) && !empty($_POST['_confirmar'])){ 
                          if(isset($_POST['_contraseña'])){
                                 if($_POST['_contraseña'] != $_POST['_confirmar'] ){
                                    $data = array("success" => "false", "priority"=>'info',"msg" => 'El user no coincide con la confirmación!');  
                                    echo json_encode($data); 
                                    exit();
                                }
                          }

                         $salt = generateSalt();
                         $hash = hash_hmac("sha256", trim($_POST['_contraseña']), $salt);


                         $objMiembro= new Miembro();
                         $comp= $objMiembro->setMiembroUserPass($_POST['_id'] ,$_POST['_user'], $hash, $_SESSION['user_id_ben'],$salt);     
                          if($comp == "OK"){

                             $asunto= 'Renaissance Executive Forums';
                             $msg= 'Estimado miembro:<br>'
                                     . 'A continuación se incluye información para acceder al sistema Renaissance Executive Forums </br>'
                                     . '<p>Link: '.$settings["sitio"].'</p></br>'
                                     . '<p>User: '.$_POST['_user'].'</p></br>'
                                     . '<p>Contraseña: '.$_POST['_contraseña'].'</p></br></br>';
                             //correo
                             $mail= new Mail();
                             $mail->enviar($_SESSION['user_name'],$_SESSION['user_correo'], $asunto, $msg, $_POST['_correo_credenciales'], FALSE); 

                             $data = array("success" => "true", "priority"=>'success',"msg" => 'El usuario se actualizó correctamente!');  
                             echo json_encode($data);

                         }else{
                             $msg='El user ya existe, por favor cambialo!';
                             $data = array("success" => "false", "priority"=>'info',"msg" => $msg); 
                             echo json_encode($data);
                         }

                     }  else {
                         $data = array("success" => "false", "priority"=>'info',"msg" => 'Faltan campos por llenar!');  
                         echo json_encode($data);
                     }


                     break;
            case 'KEY_GLOBAL_SHOW_FILTRO':
                if(!empty($_POST['_key_filtro']) && !empty($_POST['_filtro'])){
                    //Reestablesco la conexión
      
                    setDatosConexion($_SESSION['user_subasedatos']);
                    setDatosConexion('bases');
                    
                    $lista['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");
                    $listaNone['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "-None-");
                    $bandera = FALSE;
                    
                    switch ($_POST['_key_filtro']) {
                        case '1': //Para pais
                            //Esta variable de sesion es para que cuando el usuario refresque toda la pantalla muestre la info ya guardada
                            $_SESSION['global_pais_temporales']= $_POST['_filtro'];
                            if($_POST['_filtro'] == "x"){
                                $bandera = TRUE;
                                $tabla= getGlobalTablaFiltrada("","","");
                                $comboSede= generadorComboSelectOption("_sedes", "getGlobalFiltro(2)",$listaNone);
                                $comboForum= generadorComboSelectOption("_forum", "getGlobalFiltro(3)",$listaNone);
                                $comboGrupos= generadorComboSelectOption("_grupo", "getGlobalFiltro(4)",$listaNone);
                                $comboEmpresa= generadorComboSelectOption("_empresa", "getGlobalFiltro(5)",$listaNone);
                                $comboIndustria= generadorComboSelectOption("_industria", "getGlobalFiltro(6)",$listaNone);   
                            }  else {                      
                                $objGlobalSede = new GlobalSede();
                                $objGlobalSede->setIdPais($_SESSION['global_pais_temporales']);
                                $listaSedes= $objGlobalSede->getLista(NULL, $lista);
                                //Consulta solo los miembros del pais seleccionado
                                if( $objGlobalSede->getSedesBasesDatos() == ''){
                                    $bandera = TRUE;
                                    $tabla= getGlobalTablaFiltrada("","","");
                                    $comboSede= generadorComboSelectOption("_sedes", "getGlobalFiltro(2)",$listaNone);
                                    $comboForum= generadorComboSelectOption("_forum", "getGlobalFiltro(3)",$listaNone);
                                    $comboGrupos= generadorComboSelectOption("_grupo", "getGlobalFiltro(4)",$listaNone);
                                    $comboEmpresa= generadorComboSelectOption("_empresa", "getGlobalFiltro(5)",$listaNone);
                                    $comboIndustria= generadorComboSelectOption("_industria", "getGlobalFiltro(6)",$listaNone);   
                                }  else {
                                    $bandera = TRUE;
                                    $tabla= getGlobalTablaFiltrada("","", $objGlobalSede->getSedesBasesDatos());
                                    $_SESSION['global_databases_temporales']= $objGlobalSede->getSedesBasesDatos();
                                    $comboSede= generadorComboSelectOption("_sedes", "getGlobalFiltro(2)",$listaSedes);
                                    $comboForum= generadorComboSelectOption("_forum", "getGlobalFiltro(3)",$listaNone);
                                    $comboGrupos= generadorComboSelectOption("_grupo", "getGlobalFiltro(4)",$listaNone);
                                    $comboEmpresa= generadorComboSelectOption("_empresa", "getGlobalFiltro(5)",$listaNone);
                                    $comboIndustria= generadorComboSelectOption("_industria", "getGlobalFiltro(6)",$listaNone); 
                                }
                            }
                            
                            break;
                        case '2': // Para Sedes
                            if($_POST['_filtro'] == "x"){
                                    $bandera = TRUE;
                                    $tabla= getGlobalTablaFiltrada("","",$_SESSION['global_databases_temporales']);
                                    $comboSede= generadorComboSelectOption("_sedes", "getGlobalFiltro(2)",$listaNone);
                                    $comboForum= generadorComboSelectOption("_forum", "getGlobalFiltro(3)",$listaNone);
                                    $comboGrupos= generadorComboSelectOption("_grupo", "getGlobalFiltro(4)",$listaNone);
                                    $comboEmpresa= generadorComboSelectOption("_empresa", "getGlobalFiltro(5)",$listaNone);
                                    $comboIndustria= generadorComboSelectOption("_industria", "getGlobalFiltro(6)",$listaNone); 
                            }  else {                      
                                    $bandera = TRUE;
                                    $tabla= getGlobalTablaFiltrada("","", $_POST['_base'].",");
                                    $comboSede= "";
                                    
                                    setDatosConexion($_POST['_base']);
      
                                    $objForum = new ForumLeader();
                                    $listaForum=$objForum->getListaForumLeaders7(NULL,$lista, $_SESSION['user_id_ben']);
                                    $comboForum= generadorComboSelectOption("_forum", "getGlobalFiltro(3)",$listaForum);
                                    
                                    $objGrupo= new Grupo();
                                    $listaGrupos= $objGrupo->getListaGrupos2(NULL,$lista);
                                    $comboGrupos= generadorComboSelectOption("_grupo", "getGlobalFiltro(4)",$listaGrupos);
                                    
                                    $objEmpresaLocal= new EmpresaLocal();
                                    $listaEmpresa=$objEmpresaLocal->getListaEmpresa2(NULL, $lista);
                                    $comboEmpresa= generadorComboSelectOption("_empresa", "getGlobalFiltro(5)",$listaEmpresa);
                                    
                                    $objIndustria = new Industria();
                                    $listaIndustrias=$objIndustria->getListaIndustrias2(NULL, $lista);
                                    $comboIndustria= generadorComboSelectOption("_industria", "getGlobalFiltro(6)",$listaIndustrias); 
                                    setDatosConexion($_SESSION['user_subasedatos']);
//                                    setDatosConexion('');
                            }
                            break;
                        case '3'://Para Forum
                             if($_POST['_filtro'] != "x"){
                                setDatosConexion($_POST['_base']);
                                $tabla= getTablaFiltrada($_POST['_filtro'], '2',"",0);
                                $objGrupo= new Grupo();
                                $resultset= $objGrupo->getIDForumxGrupo($_POST['_filtro']);
                                if($row = $resultset->fetch_assoc()) { 
                                  $id= $row["gru_id"];
                                }
                                //+++++++++++++++++++++++++++++++++++++++++++++++++++++
                                
                                $listagrupos["0"]= array("value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");                                
                                $objGrupo= new Grupo();
                                $listaGrupos= $objGrupo->getListaGruposForum($_POST['_filtro'],NULL, $listagrupos);                   
                                $gruposfiltro= generadorComboSelectOption("_grupo", "getGlobalFiltro('4')",$listaGrupos);
                                //+++++++++++++++++++++++++++++++++++++++++++++++++++++
                                
                                
                                
                                


                                $data = array("success" => "true", 
                                    "tabla" => $tabla,
                                    "gruposfiltro" => $gruposfiltro,
                                    "id" => $id);  
                                echo json_encode($data); 
                                setDatosConexion($_SESSION['user_subasedatos']);
                            }else{
                                $data = array("success" => "x");  
                                echo json_encode($data);
                            }
                            exit();
                            break;
                        case '4': // Para Grupos
                            if($_POST['_filtro'] != "x"){
                                setDatosConexion($_POST['_base']);
                                $tabla= getTablaFiltrada($_POST['_filtro'], '1',"",0);
                                $objGrupo= new Grupo();
                                $resultset= $objGrupo->getIDGrupoxForum($_POST['_filtro']);
                                if($row = $resultset->fetch_assoc()) { 
                                  $id= $row["gru_forum"];
                                }

        
                                $data = array("success" => "true", 
                                    "tabla" => $tabla,
                                    "id" => $id);  
                                echo json_encode($data); 
                                setDatosConexion($_SESSION['user_subasedatos']);
                            }else{
                                $data = array("success" => "x");  
                                echo json_encode($data);
                            }
                            exit();
                            break;
                        case '5': //Para empresas
                            if($_POST['_filtro'] != "x"){
                                setDatosConexion($_POST['_base']);
                                $tabla= getTablaFiltrada($_POST['_filtro'], '3',"",0);
                                $data = array("success" => "true", 
                                    "tabla" => $tabla);  
                                echo json_encode($data); 
                                setDatosConexion($_SESSION['user_subasedatos']);
                            }else{
                                $data = array("success" => "x");  
                                echo json_encode($data);
                            }
                            exit();
                            break;
                        case '6': //Para industrias
                            if($_POST['_filtro'] != "x"){
                                setDatosConexion($_POST['_base']);
                                $tabla= getTablaFiltrada($_POST['_filtro'], '4',"",0);
                                $data = array("success" => "true", 
                                    "tabla" => $tabla);  
                                echo json_encode($data);
                                setDatosConexion($_SESSION['user_subasedatos']);
                            }else{
                                $data = array("success" => "x");  
                                echo json_encode($data);
                            }
                            exit();
                            break;

                        default:
                            break;
                    }
                    
                    if($bandera){
                        $data = array("success" => "true", 
                                        "comboSede"=>$comboSede,
                                        "comboForum"=>$comboForum,
                                        "comboGrupos" => $comboGrupos,
                                        "comboEmpresa" => $comboEmpresa,
                                        "comboIndustria" => $comboIndustria,
                                        "tabla" => $tabla);  
                        echo json_encode($data); 
                    }  else {
                        $data = array("success" => "false", "priority"=>'warning', "msg" => 'No existen datos!');  
                        echo json_encode($data);
                    }

                
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'No existen datos!');  
                    echo json_encode($data); 
                }

            break;
            case 'KEY_GUARDAR_ASISTENTE':///////////////////////////////////////////////////////////   
                 if( !empty($_POST['_id_asistente']) && !empty($_POST['_nombre_asistente'])   && !empty($_POST['_apellido_asistente']) ){ 
                    $objPAMAsistente= new PAMAsistente();
                    $comp= $objPAMAsistente->setCrearAsistente( $_POST['_id_asistente'], $_POST['_nombre_asistente'], $_POST['_apellido_asistente'],
                            $_SESSION['user_id_ben'],$_POST['_correo_asistente'],$_POST['_movil_asistente'], $_POST['_funcion_asistente'], $_POST['_fijo_asistente'], $_POST['_bandera']);     
                        if($comp == "OK"){
                            $data = array("success" => "true", "priority"=>'success',"msg" => 'El Asistente se creo correctamente!');
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
            case 'KEY_ACTUALIZAR_ASISTENTE': 
       
                if( !empty($_POST['_id_asistente']) && !empty($_POST['_nombre_asistente']) && !empty($_POST['_apellido_asistente']) ){ 
             
                    $objPAMAsistente= new PAMAsistente();
                    $comp= $objPAMAsistente->setActualizarAsistente( $_POST['_id_asistente'], $_POST['_nombre_asistente'], $_POST['_apellido_asistente'],
                            $_SESSION['user_id_ben'],$_POST['_correo_asistente'],$_POST['_movil_asistente'], $_POST['_funcion_asistente'], $_POST['_fijo_asistente'], $_POST['_bandera']);  
                        if($comp == "OK"){
                            $data = array("success" => "true", "priority"=>'success',"msg" => 'El Asistente se actualizo correctamente!');
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
            case 'KEY_DELETE_ASISTENTE':///////////////////////////////////////////////////////////   

                 if( !empty($_POST['_id_persona']) ){ 
                    $objPAMAsistente= new PAMAsistente();
                    $comp= $objPAMAsistente->setDeleteAsistente($_POST['_id_persona'], $_POST['_bandera'], $_POST['_id_tabla']);     
                        if($comp == "OK"){
                            $data = array("success" => "true", "priority"=>'success',"msg" => 'El Asistente fue eliminado correctamente!');
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
            case 'KEY_SHOW_COMBO_EMPRESAS':
                if(!empty($_POST['_id_miembro'])){  
                    $_id_empresa= "_empresas";
                    $_id_tipo= "_tipo_empresas_pam";
                    if(isset($_POST['_is_actualizacion'])){
                        $_id_empresa= "_empresas_u";
                        $_id_tipo= "_tipo_empresas_pam_u";
                    }
                    
                    $lista["0"]= array("value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");
                    $objEmpresaLocal= new EmpresaLocal();
                    $listaEmpresa=$objEmpresaLocal->getListaEmpresa2(NULL, $lista);
                    $empresas= generadorComboSelectOption($_id_empresa, "",$listaEmpresa);
                    
                    $objTipoEmpresaPAM = new TipoEmpresaPAM();
                    $listaTipos= $objTipoEmpresaPAM->getLista(NULL, $lista);
                    $tipos= generadorComboSelectOption($_id_tipo, "",$listaTipos);
                    
                    $data = array("success" => "true", 
                        "_lista_empresa" => $empresas,
                        "_lista_tipo_empresa" => $tipos); 
                    echo json_encode($data); 
                
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'El combo no tiene datos!');  
                    echo json_encode($data); 
                }

            break;
            case 'KEY_ADD_EMPRESA':///////////////////////////////////////////////////////////  
                
                

                 if( !empty($_POST['_id_miembro']) && !empty($_POST['_empresas']) && !empty($_POST['_bandera'])){ 
                     
                    if($_POST['_tipo'] == 'x'){
                       $data = array("success" => "false", "priority"=>'info', "msg" => 'Debes seleccionar un tipo de empresa!');  
                       echo json_encode($data); 
                       exit(); 
                    }
                    if($_POST['_empresas'] == 'x'){
                       $data = array("success" => "false", "priority"=>'info', "msg" => 'Debes seleccionar una empresa!');  
                       echo json_encode($data); 
                       exit(); 
                    }
                     
                    $objEmpresaLocal= new EmpresaLocal();
                    $comp= $objEmpresaLocal->setAdd( $_POST['_id_miembro'], $_POST['_empresas'], $_POST['_descripcion_empresa'],
                            $_SESSION['user_id_ben'],$_POST['_bandera'],$_POST['_tipo']);     
                        if($comp == "OK"){
                            $data = array("success" => "true", "priority"=>'success',"msg" => 'La Empresa se agrego correctamente!');
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
            case 'KEY_ACTUALIZAR_MIEMBRO_EMPRESA':///////////////////////////////////////////////////////////   
//                 $data = array("success" => "false", "priority"=>'info', "msg" => $_POST['_tipo']);  
//                    echo json_encode($data); 
//                    exit();
                    
                 if( !empty($_POST['_id_miembro_empresa']) && !empty($_POST['_empresas']) && !empty($_POST['_bandera'])){
                    if($_POST['_tipo'] == 'x'){
                       $data = array("success" => "false", "priority"=>'info', "msg" => 'Debes seleccionar un tipo de empresa!');  
                       echo json_encode($data); 
                       exit(); 
                    }
                    if($_POST['_empresas'] == 'x'){
                       $data = array("success" => "false", "priority"=>'info', "msg" => 'Debes seleccionar una empresa!');  
                       echo json_encode($data); 
                       exit(); 
                    }
                    $objEmpresaLocal= new EmpresaLocal();
                    $comp= $objEmpresaLocal->setActualizar( $_POST['_id_miembro_empresa'], $_POST['_empresas'], $_POST['_descripcion_empresa'],
                            $_SESSION['user_id_ben'],$_POST['_bandera'],$_POST['_tipo']);     
                        if($comp == "OK"){
                            $data = array("success" => "true", "priority"=>'success',"msg" => 'La Empresa se agrego correctamente!');
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
            case 'KEY_DELETE_EMPRESA':///////////////////////////////////////////////////////////   

                 if( !empty($_POST['_id_miembro_empresa']) && !empty($_POST['_bandera'])){ 
                    $objEmpresaLocal= new EmpresaLocal();
                    $comp= $objEmpresaLocal->setDelete($_POST['_id_miembro_empresa'],$_POST['_bandera']);     
                        if($comp == "OK"){
                            $data = array("success" => "true", "priority"=>'success',"msg" => 'La Empresa fue eliminada correctamente!');
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
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
     exit(); 
}


////////////////////////////////////////////////////////////////////////////////
//Restablesco la conexión con la cual el usuario inicio en el login
setDatosConexion($_SESSION['user_subasedatos']);
setDatosConexion('bases');

$t='';
if (in_array($perFiltroVerTodoslosMiembrosOp6, $_SESSION['usu_permiso'])) {
    $tabla= getTablaFiltrada("","","",0);
    $resultado = str_replace("{fitros}", generadorEtiquetasFiltro(getFiltros()), generadorFiltro('Filtros','ben_contenedor_filtro')); 
    $resultado = str_replace("{cuerpo}", $tabla, $resultado);  
    
    $t=$resultado;
      
 }  elseif (in_array($perFiltroVerMiembrosForumOp6, $_SESSION['usu_permiso'])) {
   
    $tabla= getTablaFiltrada("","",$_SESSION['user_id_ben'],0);
    $resultado = str_replace("{fitros}", generadorEtiquetasFiltro(getFiltros()), generadorFiltro('Filtros','ben_contenedor_filtro')); 
    $resultado = str_replace("{cuerpo}", $tabla, $resultado);  
    
    $t=$resultado;
}elseif (in_array($perGlobalMiembrosOp12, $_SESSION['usu_permiso'])) {
    $bases= '';
    //Esta variable se encuantra declarada en el login
    if($_SESSION['global_databases_temporales'] != 'x'){
        $bases= $_SESSION['global_databases_temporales'];
    }                    
    $tabla= getGlobalTablaFiltrada("","",$bases,0);
    $resultado = str_replace("{fitros}", generadorEtiquetasFiltro(getGlobalFiltros()), generadorFiltro('Filtros','ben_contenedor_filtro')); 
    $resultado = str_replace("{cuerpo}", $tabla, $resultado);  
    
    $t=$resultado;
}


function getFiltros() {
    global $perFiltroVerTodoslosMiembrosOp6;
  
    $lista['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");
    if (in_array($perFiltroVerTodoslosMiembrosOp6, $_SESSION['usu_permiso'])) {
		
		
		
		$objForum = new ForumLeader();
        $listaForum=$objForum->getListaForumLeaders7(NULL,$lista, $_SESSION['user_id_ben']);
        $form['form_1'] = array("elemento" => "combo","change" => "getFiltro('2')", "titulo" => "Forum Leader", "id" => "_forum", "option" => $listaForum); 


        
        $objGrupo= new Grupo();
        $listaGrupos= $objGrupo->getListaGrupos7(NULL,$lista, $_SESSION['user_id_ben']);
        $form['form_2'] = array("elemento" => "combo","change" => "getFiltro('1')", "titulo" => "Grupos", "id" => "_grupo", "option" => $listaGrupos); 

       
    }
    $objEmpresaLocal= new EmpresaLocal();
    $listaEmpresa=$objEmpresaLocal->getListaEmpresa3(NULL, $lista, $_SESSION['user_id_ben']);
    $form['form_3'] = array("elemento" => "combo","change" => "getFiltro('3')", "titulo" => "Empresas", "id" => "_empresa", "option" => $listaEmpresa); 
    
    $objIndustria = new Industria();
    $listaIndustrias=$objIndustria->getListaIndustrias2(NULL, $lista);
    $form['form_4'] = array("elemento" => "combo","change" => "getFiltro('4')", "titulo" => "Industrias", "id" => "_industria", "option" => $listaIndustrias); 

    $objStatusMember = new StatusMember();
    $listaStatusMember = $objStatusMember->getListaMiembroStatus($lista);
    $form['form_5'] = array("elemento" => "combo","change" => "getFiltro('5')", "titulo" => "Estado del Miembro", "id" => "_status_memb", "option" => $listaStatusMember); 

    //$form['form_6'] = array("elemento" => "Checkbox-comun", "chec" => "onChange='setCanceladas()'", "id" => "_canceladas", "titulo" => "Incluir Canceladas");
    
    $objGrupo2 = new Grupo();
    $listaAgrup = $objGrupo2->getListaByAgrup($lista);
    $form['form_7'] = array("elemento" => "combo","change" => "getFiltro('6')", "titulo" => "Tipo Miembro", "id" => "_memb_type", "option" => $listaAgrup); 

    return $form;
    
}

function getTablaFiltrada($id, $key, $idForum, $incluyecanceladas) {
    global $perVerMiembroOp6;
    $objMiembro= new Miembro();
    $cuerpo='';
    $cont=1;
    $t='';
    $lista = array();
    $objStatusMember = new StatusMember();
    $listaStatusMember = $objStatusMember->getListaMiembroStatus2($lista);
    if (strlen($idForum) > 0) {
        $objUsuario3 = new Usuario();
        $sede = 0;
        $resultset4 = $objUsuario3->getDatosUsuario($idForum);
        if ($row7 = $resultset4->fetch_assoc()) {
            $sede = $row7['sede_id'];
        }        
    } else {
        $objUsuario3 = new Usuario();
        $sede = 2;
        $resultset4 = $objUsuario3->getDatosUsuario($_SESSION['user_id_ben']);
        if ($row7 = $resultset4->fetch_assoc()) {
            $sede = $row7['sede_id'];
        }
        
    }
    

    $resultset= $objMiembro->getFiltros2($id,$key,$idForum, $incluyecanceladas, $sede);
    
    while($row = $resultset->fetch_assoc()) { 
        $verDetalle='';
        if (in_array($perVerMiembroOp6, $_SESSION['usu_permiso'])) {
            $verDetalle="getDetalle(".$row['mie_id'].",'')";
        }        
        //empieza
        $listaTemp = array();
        $listaTemp = setSeleccionadoMiembro($listaStatusMember, $row['mem_sta_id']);
        $arreglo = array("change" => "setEstado(".$row['mie_id'].")", 
        "id" => "_".$row['mie_id'], "option" => $listaTemp); 
        //termina
        $cuerpo.= generadorTablaFilas(array(
             $row['mie_codigo'],
             generadorLink($row['per_apellido'].' '.$row['per_nombre'],$verDetalle),
             $row['nombre_empresa'],
             $row['nombre_forum'],
             generadorEtiquetasFiltroTabla($arreglo)
        ));
        $cont=$cont + 1;                                                                          
    }    
    $tabla= generadorTablaConBotonesMiembros(1, "Miembros",'', array(
         "Código&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", 
         "Nombre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
        "Empresa","Forum_Leader", "Estado"), $cuerpo,null, $incluyecanceladas);

   return $tabla;
    
}

$objPerido= new Periodo();
$listaPeriodos= $objPerido->getListaComboPeriodo("");

$objMembresia= new Membresia();
$listaMembresia= $objMembresia->getListaComboMembresia("");

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

function getGlobalTablaFiltrada($id, $key, $bases) {
    
    $objMiembro= new GlobalMiembro();
    $cuerpo='';
    $cont=1;
    $resultset= $objMiembro->getGlobalFiltros($id, $key, $bases);
      while($row = $resultset->fetch_assoc()) { 
        $verDetalle='';
        $verDetalle="getDetalle(".$row['mie_id'].",'".$row['base']."')";
        $cuerpo.= generadorTablaFilas(array(
            $row['mie_codigo'],
            generadorLink($row['per_apellido'].' '.$row['per_nombre'],$verDetalle),
            $row['nombre_empresa'],
            $row['nombre_forum'],
            $row['mem_sta_descripcion']));
        $cont=$cont + 1;                                                                          
     }    
    $tabla= generadorTablaConBotonesMiembros(1, "Miembros",'', array(
        "Código"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", 
        "Nombre",
        "Empresa",
        "Forum Leader",
        "Estado"), $cuerpo,null,0);

   return $tabla;
    
}

function getGlobalFiltros() {

    $lista['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");
    $listaNone['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "-None-");
    $listaSedes['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "-None-");
            
            
			
    $objPais= new Pais();
    $listapais= $objPais->getListaPais($_SESSION['global_pais_temporales'],$lista); 
    //Esta variable se encuentra declarada en el login
    if($_SESSION['global_pais_temporales'] != 'x'){
        $objGlobalSede = new GlobalSede();
        $objGlobalSede->setIdPais($_SESSION['global_pais_temporales']);
        $listaSedes= $objGlobalSede->getLista(NULL, $lista);
    }
    
	if (($_SESSION['user_user']=='admin')||($_SESSION['user_country']=='*')) {
    $form['form_1'] = array("elemento" => "combo","change" => "getGlobalFiltro('1')", "titulo" => "País", "id" => "_pais", "option" => $listapais); 
	$form['form_2'] = array("elemento" => "combo","change" => "getGlobalFiltro('2')", "titulo" => "IBP", "id" => "_sedes", "option" => $listaSedes);
    $form['form_3'] = array("elemento" => "combo","change" => "getGlobalFiltro('3')", "titulo" => "Forum Leader", "id" => "_forum", "option" => $listaNone);
    $form['form_4'] = array("elemento" => "combo","change" => "getGlobalFiltro('4')", "titulo" => "Grupos", "id" => "_grupo", "option" => $listaNone);
    $form['form_5'] = array("elemento" => "combo","change" => "getGlobalFiltro('5')", "titulo" => "Empresas", "id" => "_empresa", "option" => $listaNone);
    $form['form_6'] = array("elemento" => "combo","change" => "getGlobalFiltro('6')", "titulo" => "Industrias", "id" => "_industria", "option" => $listaNone);
    }else{
	
	
	    $objForum = new ForumLeader();
        $listaForum=$objForum->getListaForumLeaders7(NULL,$lista, $_SESSION['user_id_ben']);
        $form['form_1'] = array("elemento" => "combo","change" => "getFiltro('2')", "titulo" => "Forum Leader", "id" => "_forum", "option" => $listaForum); 
        
        $objGrupo= new Grupo();
        $listaGrupos= $objGrupo->getListaGrupos2(NULL,$lista);
        $form['form_2'] = array("elemento" => "combo","change" => "getFiltro('1')", "titulo" => "Grupos", "id" => "_grupo", "option" => $listaGrupos); 
		
		  $objEmpresaLocal= new EmpresaLocal();
    $listaEmpresa=$objEmpresaLocal->getListaEmpresa2(NULL, $lista);
    $form['form_3'] = array("elemento" => "combo","change" => "getFiltro('3')", "titulo" => "Empresas", "id" => "_empresa", "option" => $listaEmpresa); 
    

    $objIndustria = new Industria();
    $listaIndustrias=$objIndustria->getListaIndustrias2(NULL, $lista);
    $form['form_4'] = array("elemento" => "combo","change" => "getFiltro('4')", "titulo" => "Industrias", "id" => "_industria", "option" => $listaIndustrias); 

    $objStatusMember = new StatusMember();
    $listaStatusMember = $objStatusMember->getListaMiembroStatus();
    $form['form_5'] = array("elemento" => "combo","change" => "getFiltro('5')", "titulo" => "Estado del Miembro", "id" => "_status_memb", "option" => $listaStatusMember); 

    //$form['form_6'] = array("elemento" => "Checkbox-comun", "chec" => "onChange='setCanceladas()'", "id" => "_canceladas", "titulo" => "Incluir Canceladas");
    $objGrupo2 = new Grupo();
    $listaAgrup = $objGrupo2->getListaByAgrup();
    $form['form_7'] = array("elemento" => "combo","change" => "getFiltro('6')", "titulo" => "Tipo Miembro", "id" => "_memb_type", "option" => $listaAgrup); 
    
    


	}
    return $form;
    
}
   

$objCargo= new Categoria();
$lista= $objCargo->getListaCategoria("");
$listaFuncion = generadorComboSelectOption("_funcion_asistente", "",$lista);
$listaFuncion2 = generadorComboSelectOption("_funcion_asistente_u", "",$lista);


//CUSTOM LOAD//

if(isset($_GET['id_miembro'])){ 
/*  echo '<script>alert("Test")</script>';    */
if(!empty($_GET['id_miembro']) ){ 
include(HTML."/cabecera.php");
echo getDetalleUpdate($_GET['id_miembro'],TRUE);

 }
}
