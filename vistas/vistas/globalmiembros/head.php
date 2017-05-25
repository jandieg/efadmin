<?php
require_once MODELO.'Grupo.php';
require_once MODELO.'Miembro.php';
require_once MODELO.'Hobby.php';
require_once MODELO.'Prospecto.php';
require_once MODELO.'Candidato.php';
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

//require_once MODELO.'Metodos.php';
//require_once MODELO.'MetodosListas.php';
include(HTML."/html.php");
include(HTML."/html_2.php");
include(HTML."/html_combos.php");
include(HTML."/html_filtros.php");
require_once(LENGUAJE."/lenguaje_1.php");
require_once E_LIB.'Mail.php';
$settings = parse_ini_file(E_LIB."settings.ini.php");            


require_once MODELO2.'GlobalMiembro.php';
require_once MODELO2.'GlobalRouter.php';
require_once MODELO2.'GlobalSede.php';


$objProfesion; $objFuente; $objEstadoProspecto;$objIndustria;$objCategoria;$objPais;$objProvincia;$objCiudad;$objDesafio;$objRedSocial;
$objUsuario;$objForum;$objHobby;$objMiembro;$tabla_desafios=array();$objEmpresaLocal;$objDireccion;$objStatus;$prefijoPais="";$codigoMiembro='';
$titulo='';$idpersona='';$empresa='';$direcion='';$ciudad='';$estado='';$pais='';$nombreGrupo='';

function getDetalleUpdate($id, $recargar) {

    $objMiembro= new Miembro();
    $resultset= $objMiembro->getMiembro1($id);
    if($row = $resultset->fetch_assoc()) { //$row['per_nombre']
  
        $idpersona=$row['per_id'];
        $objProfesion= new Profesion();                
        $listaprofe=  $objProfesion->getListaprofesion($row['Profesion_prof_id']);
        $objCategoria= new Categoria();                    
        $listacategoria=  $objCategoria->getListaCategoria($row['categoria_cat_id']);
        
        $objForum= new ForumLeader();
        $listaForumLeader= $objForum->getListaForumLeaders($row['forum_usu_id']);// getGlobalAllForumLeaderSeleccionada($row['forum_usu_id']);
 
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
        $listapais= $objPais->getListaPais($idPais,NULL);

        $objProvincia=new Provincia();
        $objProvincia->setIdPais($objPais->getIdPais());
        $listaprov=  $objProvincia->getListaProvincia($idEstado);

        $objCiudad= new Ciudad();
        $objCiudad->setIdProvincia($objProvincia->getIdProvincia());
        $listaciudad=$objCiudad->getListaCiudad($idCiudad);

   
        $objEmpresaLocal= new EmpresaLocal();
        //$listaIndustria= $objEmpresaLocal->getMultiListaIndustria($row['emp_id']);
        $listaEmpresas= $objEmpresaLocal->getListaEmpresa($row['emp_id']);
        
        $objMiembro= new Miembro();
        $listadesafio= $objMiembro->getMultiListaDesafiosMiembros($id);
        
        $objCorreo= new Correo();
        $correo_1= $objCorreo->getCorreoPersonalSecundario($idpersona, 'Personal');
        $correo_2= $objCorreo->getCorreoPersonalSecundario($idpersona, NULL);

        $objTelefono= new Telefono();
        $t_fijo= $objTelefono->getTelefonoTipo($idpersona, 'C');
        $t_movil= $objTelefono->getTelefonoTipo($idpersona, 'M');
        
        $objRedSocial= new RedSocialMiembro();
        $redSkype=$objRedSocial->getNombreRedSocial($id, "skype");
        $redTwitter=$objRedSocial->getNombreRedSocial($id, "twitter");
        
        
        $objMiembro= new Miembro();//`hob_id`, `hob_descripcion` FROM `hobbies`
        $listahobby=$objMiembro->getMultiListaHobbies($id);
        
        $objGrupo= new Grupo();
        $listaGrupos= $objGrupo->getListaGruposForum($row['forum_usu_id'], $row['grupo_id'], NULL);
        
        
        $listaStatus['lista_'] = array("value" => "x",  "select" => "" ,"texto" => "Seleccionar...");
        $objStatus= new StatusMember();
        $listaStatus= $objStatus->getLista($row['status_member_id'],$listaStatus, '1');
 
                                                                                    
        global $lblForumLeader,$lblNombre, $lblApellido , $lblTipoPersona, $lblIdentificacion, $lblGenero,
                $lblTitulo,$lblFNacimiento, $lblCorreo, $lblCorreoSecundario, $lblTF, $lblTM, $lblEmpresa,
                $lblIngresosAnuales,$lblNEmpleados,$lblNEmpleados,$lblIndustria,$lblFax, $lblSitioWeb, $lblCategoría, $lblFuente, $lblEstadoProspecto,
                $lblSkype,$lblTwitter,$lblParticipacionCorreo,$lblCiudad, $lblCalle, $lblPais, $lblProvincia, $lblDescDesafios, $lblListaDesafios,$lblListaHobbies,
                $lblbtnGuardar, $lblbtnRegresar;
        //Formularios
        //$form['form_0'] = array("elemento" => "combo","change" => "getComboCargarGrupos()","titulo" => generadorAsterisco($lblForumLeader), "id" => "_propietario", "option" => $listaForumLeader);
        $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Código", "id" => "_codigo" ,"reemplazo" => $row['mie_codigo']);
        $form['form_2'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblNombre), "id" => "_nombre" ,"reemplazo" => $row['per_nombre']);
        $form['form_3'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblApellido), "id" => "_apellido" ,"reemplazo" => $row['per_apellido']);
        
        $form['form_4'] = array("elemento" => "combo","change" => "","titulo" => $lblTipoPersona, "id" => "_tipo_p", "option" => generadorComboTipoPersona_($row['per_tipo']));                
        $form['form_5'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblIdentificacion), "id" => "_identificacion" ,"reemplazo" => $row['per_identificacion']);      
        $form['form_6'] = array("elemento" => "combo","change" => "","titulo" => $lblGenero, "id" => "_genero", "option" => generadorComboGenero($row['per_genero']));
        
        $form['form_7'] = array("elemento" => "combo","change" => "", "titulo" => generadorAsterisco($lblTitulo), "id" => "_titulo", "option" => $listaprofe);
        $form['form_8'] = array("elemento" => "caja" ,"tipo" => "date" , "titulo" => $lblFNacimiento, "id" => "_fn" ,"reemplazo" => $row['per_fechanacimiento']);
        $form['form_9'] = array("elemento" => "combo","change" => "","titulo" => generadorAsterisco("Member Status"), "id" => "_status", "option" => $listaStatus);  
        

        $form_1= generadorEtiqueta($form);
        
        $objMembresia= new Membresia();
        $listaM= array();
        $listaM['lista_'] = array("value" => "x",  "select" => "" ,"texto" => "Seleccione...");
        $listaM= $objMembresia->getListaMembresias($row['membresia_id'],$listaM);
          //Formularios
        $form2['form_0'] = array("elemento" => "combo","change" => "getComboCargarGrupos()","titulo" => generadorAsterisco("Membresía"), "id" => "_membresia", "option" => $listaM);
        $form2['form_1'] = array("elemento" => "combo","change" => "getComboCargarGrupos()","titulo" => generadorAsterisco($lblForumLeader), "id" => "_propietario", "option" => $listaForumLeader);
        $form2['form_2'] = array("elemento" => "combo","change" => "","titulo" => generadorAsterisco("Asignar Grupo"), "id" => "_grupo_asignar", "option" => $listaGrupos);
        $form2['form_3'] = array("elemento" => "combo","combo","change" => "", "titulo" => "Empresa", "id" => "_id_empresa", "option" => $listaEmpresas); 
        $form2['form_4'] = array("elemento" => "combo","change" => "", "titulo" => generadorAsterisco($lblCategoría), "id" => "_categoria", "option" => $listacategoria);

        $form2['form_10'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblCorreo), "id" => "_correo" ,"reemplazo" => $correo_1);
        $form2['form_11'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCorreoSecundario, "id" => "_correo_2" ,"reemplazo" => $correo_2);
        if($row['mie_participacion_correo']=='1'){
            $form2['form_12'] = array("elemento" => "Checkbox-color" ,"tipo" => "" ,"chec" => "checked", "titulo" => $lblParticipacionCorreo, "id" => "_participacion" ,"reemplazo" => '');
        }  else {
            $form2['form_12'] = array("elemento" => "Checkbox-color" ,"tipo" => "" ,"chec" => "", "titulo" => $lblParticipacionCorreo, "id" => "_participacion" ,"reemplazo" => '');
      
        }
        
        $form2['form_13'] = array("elemento" => "caja pequeña + caja" ,"titulo" => generadorAsterisco($lblTF)
                                                       ,"disabled_1" => "disabled","tipo_1" => "number" , "titulo_1" => "Prefijo", "id_1" => "_prefijo_telefono" ,"reemplazo_1" => $prefijoPais
                                                       ,"disabled_2" => "","tipo_2" => "number" , "titulo_2" => generadorAsterisco($lblTF), "id_2" => "_telefono" ,"reemplazo_2" => $t_fijo);
                    
        $form2['form_14'] = array("elemento" => "caja pequeña + caja" ,"titulo" => generadorAsterisco($lblTM)
                                           ,"disabled_1" => "disabled","tipo_1" => "number" , "titulo_1" => "Prefijo", "id_1" => "_prefijo_celular" ,"reemplazo_1" => $prefijoPais
                                           ,"disabled_2" => "","tipo_2" => "number" , "titulo_2" => generadorAsterisco($lblTM), "id_2" => "_celular" ,"reemplazo_2" => $t_movil);

        
        
        $form2['form_15'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblSkype, "id" => "_id_skype" ,"reemplazo" => $redSkype);
        $form2['form_16'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblTwitter, "id" => "_id_Twitter" ,"reemplazo" => $redTwitter);
       
       
        $form_2= generadorEtiqueta($form2);

        $form3['form_8'] = array("elemento" => "combo", "change" => "","titulo" =>$lblCiudad, "id" => "_ciudad", "option" => $listaciudad);
        $form3['form_9'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCalle, "id" => "_calle" ,"reemplazo" => $direccion);
        $form_3= generadorEtiqueta($form3);


        $form4['form_2'] = array("elemento" => "combo","change" => "getCargarPaises()", "titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
        $form4['form_9'] = array("elemento" => "combo","change" => "getCargarProvincias()", "titulo" => $lblProvincia, "id" => "_provincia", "option" => $listaprov);
        $form_4= generadorEtiqueta($form4);

        $form5['form_1'] = array("elemento" => "textarea" ,"tipo" => "text" , "titulo" => $lblDescDesafios, "id" => "_desafios" ,"reemplazo" => $row['mie_descripcion_desafio']);
        $form5['form_2'] = array("elemento" => "lista-multiple",                   "titulo" => "Lista de Desafíos", "id" => "_lista_desafio", "option" => $listadesafio);
        
        $form_5= generadorEtiqueta($form5);

        $form6['form_2'] = array("elemento" => "lista-multiple",                   "titulo" => $lblListaHobbies, "id" => "_lista_hobbies", "option" => $listahobby);
        $form_6= generadorEtiqueta($form6);
        
  
        $boton['boton_2'] = array("elemento" => "boton" ,"modal" => ""  ,"color" => "btn-info" ,"click" => "setUserActualizar(".$idpersona.",".$id.")" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
        if($recargar){
            $boton['boton_1'] = array("elemento" => "boton" ,"modal" => ""  ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");
        }else{
            $boton['boton_1'] = array("elemento" => "boton" ,"modal" => ""  ,"color" => "btn-info" ,"click" => "getDetalle(".$id.")" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");
     
        }
        
        $resultado = str_replace("{contenedor_1}", $form_1,  getPage('page_detalle_update'));
        $resultado = str_replace("{contenedor_2}", $form_2, $resultado); 
        $resultado = str_replace("{contenedor_3}", $form_4, $resultado); 
        $resultado = str_replace("{contenedor_4}", $form_3, $resultado); 
        $resultado = str_replace("{contenedor_5}", $form_6, $resultado); 
        $resultado = str_replace("{contenedor_6}",$form_5, $resultado);
        $resultado = str_replace("{boton}",  generadorBoton($boton), $resultado); 

        return $resultado;
    }
    

}
function getDetalleDesafios($idMiembro, $tabla_desafios=array()) {
    global $lblDesafios;
    $objMiembro= new Miembro();
    $resultset_desafios= $objMiembro->getMiembroDesafios($idMiembro);     
    $con=1;

    while ($row_desafios = $resultset_desafios->fetch_assoc()) {
        if($con==1){
            $tabla_desafios['b_'.$con] = array("t_1" =>generadorNegritas($lblDesafios) , "t_2" => $row_desafios['des_descripcion']);
        }  else {
            $tabla_desafios['b_'.$con] = array("t_1" =>"" ,                "t_2" => $row_desafios['des_descripcion']);
        }

        $con=$con+1;
    } 
    return $tabla_desafios;
}
function getDetalleHobbies($idMiembro) {
    global $lblHobbies;
    $objMiembro = new Miembro();
    $resultset_hobbies= $objMiembro->getMiembroHobbies($idMiembro);     
    $tabla_hobbies= array();
    $con=1;
    while ($row_hobbies = $resultset_hobbies->fetch_assoc()) {
        if($con==1){
            $tabla_hobbies['b_'.$con] = array("t_1" =>  generadorNegritas($lblHobbies) , "t_2" => $row_hobbies['hob_descripcion']);
        }  else {
            $tabla_hobbies['b_'.$con] = array("t_1" =>"" ,                "t_2" => $row_hobbies['hob_descripcion']);
        }

        $con=$con+1;
    } 
    return $tabla_hobbies;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']): 
            case 'KEY_SHOW_FORM_ACTUALIZAR'://///////////////////////////////////////////////////////// 
                if(!empty($_POST['id_miembro']) ){ 
                    echo getDetalleUpdate($_POST['id_miembro'],FALSE);
                }
                break;     
            case 'KEY_SHOW_FORM_DETALLE'://///////////////////////////////////////////////////////// 
                 if( !empty($_POST['id_miembro'])){ 
                    $objMiembro= new Miembro();
                    $resultset= $objMiembro->getMiembro1($_POST['id_miembro']);  
                    if($row = $resultset->fetch_assoc()) {  
                                 
                        $idpersona=$row['per_id'];
                        $titulo=$row['per_nombre'].' '.$row['per_apellido'];
                        $empresa=$row['emp_nombre'];

                        $direccion= new Direccion();
                        $resultset_direccion= $direccion->getDireccion($idpersona);
                        if ($row_direccion = $resultset_direccion->fetch_assoc()) {
                            $direcion=$row_direccion['dir_calleprincipal'];
                            $ciudad=$row_direccion['ciu_nombre'];
                            $estado= $row_direccion['est_nombre'];
                            $pais= $row_direccion['pai_nombre'];
                            $prefijoPais=$row_direccion['pai_prefijo'];
                        }

                        $objCorreo= new Correo();
                        $correo_1= $objCorreo->getCorreoPersonalSecundario($idpersona, 'Personal');
                        $correo_2= $objCorreo->getCorreoPersonalSecundario($idpersona, NULL);

                        $objTelefono= new Telefono();
                        $t_fijo= $objTelefono->getTelefonoTipo($idpersona, 'C');
                        $t_movil= $objTelefono->getTelefonoTipo($idpersona, 'M');

                        $objRedSocial= new RedSocialMiembro();
                        $redSkype=$objRedSocial->getNombreRedSocial($row['mie_id'], "skype");
                        $redTwitter=$objRedSocial->getNombreRedSocial($row['mie_id'], "twitter");

                        $objUsuario= new Usuario();
                        $modificador= $objUsuario->getNombreUser($row['mie_id_usuario']);
                     
                    
                        $tabla_desafios= array();
                        $tabla_desafios['b_'] = array("t_1" => generadorNegritas($lblDescDesafios), "t_2" => $row['mie_descripcion_desafio']);
                        $tabla_desafios= getDetalleDesafios($_POST['id_miembro'], $tabla_desafios);
                         
                        $tabla_hobbies= array();
                        $tabla_hobbies= getDetalleHobbies($_POST['id_miembro']);
                    
                        
                        $objMiembro= new Miembro();
                        $nombreGrupo= $objMiembro->getNombreGrupo($_POST['id_miembro']);
                   

                        $tabla['t_1'] = array("t_1" => generadorNegritas("Código"), "t_2" => $row['mie_codigo']);
                        $tabla['t_2'] = array("t_1" => generadorNegritas($lblNombre), "t_2" => $titulo);
                        $tabla['t_3'] = array("t_1" => generadorNegritas($lblFNacimiento), "t_2" => $row['per_fechanacimiento']);
                        $tabla['t_4'] = array("t_1" => generadorNegritas($lblTitulo), "t_2" => $row['prof_descripcion']);
                        $tabla['t_5'] = array("t_1" => generadorNegritas($lblIdentificacion), "t_2" => $row['per_identificacion']);

                        if($row['per_tipo']=='J'){$tabla['t_6'] = array("t_1" => generadorNegritas($lblTipoPersona), "t_2" => "Jurídica");} 
                        if($row['per_tipo']=='N'){$tabla['t_6'] = array("t_1" => generadorNegritas($lblTipoPersona), "t_2" => "Natural");} 
                        $tabla['t_11'] = array("t_7" => generadorNegritas($lblGenero), "t_2" => $row['per_genero']);

                        $tabla['t_8'] = array("t_1" => generadorNegritas($lblCorreo), "t_2" => $correo_1);
                        $tabla['t_9'] = array("t_1" => generadorNegritas($lblCorreoSecundario), "t_2" => $correo_2);
                        if($row['mie_participacion_correo']=='1'){
                          $tabla['t_10'] = array("t_1" => generadorNegritas($lblParticipacionCorreo), "t_2" => 'SI');
                        }  else {
                          $tabla['t_10'] = array("t_1" => generadorNegritas($lblParticipacionCorreo), "t_2" => 'NO');
                        }
                        $tabla['t_11'] = array("t_1" => generadorNegritas($lblTF), "t_2" => "(". $prefijoPais.") ".$t_fijo);
                        $tabla['t_12'] = array("t_1" => generadorNegritas($lblTM), "t_2" => "(". $prefijoPais.") ".$t_movil);
                        $tabla['t_20'] = array("t_1" => generadorNegritas("Member Status"), "t_2" => $row['status']);
                        $tabla['t_13'] = array("t_1" => generadorNegritas($lblSkype), "t_2" => $redSkype);
                        $tabla['t_14'] = array("t_1" => generadorNegritas($lblTwitter), "t_2" => $redTwitter);

                        $tabla2['t_1'] = array("t_1" => generadorNegritas("Membresía"), "t_2" => $row['memb_descripcion']);
                        $tabla2['t_2'] = array("t_1" => generadorNegritas($lblForumLeader), "t_2" => $row['nombre_forum']);
                        $tabla2['t_3'] = array("t_1" => generadorNegritas("Grupo"), "t_2" => $nombreGrupo);
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
                        $tabla3['t_1'] = array("t_1" => generadorNegritas($lblPais), "t_2" => $pais);
                        $tabla3['t_2'] = array("t_1" => generadorNegritas($lblProvincia), "t_2" => $estado);
                        $tabla3['t_3'] = array("t_1" => generadorNegritas($lblCiudad), "t_2" => $ciudad);
                        $tabla3['t_4'] = array("t_1" => generadorNegritas($lblDireccion), "t_2" => $direcion);

                        $tabla5['t_8'] = array("t_1" => generadorNegritas($lblFRegistro), "t_2" => $row['mie_fecharegistro']);
                        $tabla5['t_9'] = array("t_1" => generadorNegritas($lblFModificacion), "t_2" => $row['mie_fechamodificacion']);
                        $tabla5['t_10'] = array("t_1" => generadorNegritas($lblUModificar), "t_2" =>  $modificador);

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
                            
                            //getAgregarPresupuesto = function(id_presupuesto, id_miembro,id_membresia, nombre_miembro, id_periodo,  fecha_registro)
                                $funcion= "getInscripcion(".$row['mie_id'].",'".$nombre."','".date('Y-m-d',strtotime($row['mie_fecharegistro']))."','".$id_membresia."')";
                                $funcion_1= "getAgregarPresupuesto(".$id_presupuesto.",".$row['mie_id'].",".$id_membresia.",'".$nombre."',".$id_periodo.",'".$fecha_registro_cobros."','".$fechaXPagar."','".$ultimaFechaXPagar."')";
                                $funcion_2="getDetallePresupuesto(".$id_presupuesto.")";
                            
                            
                        }
                        if($id_membresia != "0"){
                            $boton['boton_'] = array("elemento" => "boton" ,"modal" => "#modal_inscripcion"  ,"color" => "btn-info" ,"click" => $funcion ,"titulo" => "Inscripción","lado" => "pull-right" ,"icono" => "");
                            $boton['boton_0'] = array("elemento" => "boton" ,"modal" => "#modal_detallePresupuesto"  ,"color" => "btn-info" ,"click" => $funcion_2 ,"titulo" => "Cuotas","lado" => "pull-right" ,"icono" => "");
                            $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "#modal_agregarPresupuesto"  ,"color" => "btn-info" ,"click" => $funcion_1 ,"titulo" => "Presupuesto","lado" => "pull-right" ,"icono" => "");
                        }                        
                        ////////////////////////////////////////////////////////
                        $user= $row['mie_codigo'];
                        if($row['user'] != ''){
                            $user= $row['user'];
                        }

                        if (in_array($perEnviarCorreoOp6, $_SESSION['usu_permiso'])) {
                            $boton['boton_2'] = array("elemento" => "boton" ,"modal" => "#modal_enviarCorreo"  ,"color" => "btn-info" ,"click" => "getEnviarCorreoIndividual('".$correo_1."','".$titulo."')" ,"titulo" => $lblbtnEnviarCorreo,"lado" => "pull-right" ,"icono" => "");
                        }
                        if (in_array($perAsignarUserOp6, $_SESSION['usu_permiso'])) {
                            $boton['boton_3'] = array("elemento" => "boton" ,"modal" => "#modal_getCrearUserClave" ,"color" => "btn-info" ,"click" => "getAsignarUserClave(".$idpersona.",'".$user."','".$correo_1."' )" ,"titulo" => $lblActualizarUsuario,"lado" => "pull-right" ,"icono" => "");
                        }
                        if (in_array($perActualizarMiembroOp6, $_SESSION['usu_permiso'])) {
                            $boton1['boton_4'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getUserEditar(".$_POST['id_miembro'].")" ,"titulo" => $lblbtnEditar ,"lado" => "pull-right" ,"icono" => "fa-pencil");        
                        }
                        
                        $boton2['boton_5'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");
                        
                        $botones= '<div class="box-tools pull-right">'
                                .generadorBotonMenu($boton, 'btn-info', 'Más Opciones') 
                                . generadorBotonSinLado($boton1)
                                . generadorBotonSinLado($boton2)
                                .'</div>';
                        //table-hover
                        $resultado = str_replace("{contenedor_1}", "",  getPage('page_detalle') );//generadorContMultipleRow($colum)); 
                        $resultado = str_replace("{contenedor_2}", "", $resultado); 
                        $resultado = str_replace("{contenedor_3}", generadorTabla_2($tabla, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_4}", generadorTabla_2($tabla2, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_5}", generadorTabla_2( $tabla3, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_6}", generadorTabla_2($tabla5, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_7}", generadorTabla_2( $tabla_hobbies, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_8}", generadorTabla_2($tabla_desafios, "table-striped"), $resultado); 
                        $resultado = str_replace("{contenedor_9}", "", $resultado);
                        $resultado = str_replace("{contenedor_10}", "", $resultado);
                        $resultado = str_replace("{boton}", $botones, $resultado);
                        $alert="";
                        $msg="";
                        if($id_membresia == "0"){
                            $msg= "Edita y agrega una Membresía.";
                            $alerta = str_replace("{contenedor_1}", generadorAlertaEstatica("Alerta!",$msg,"info")  , getPage('pager_row')); 
                            $resultado = str_replace("{contenedor_2}", $resultado, $alerta); 
                        }else{
                            if($row['inscripcion'] == ""){  
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
                            echo getDetalleUpdate($_POST['id_miembro'], TRUE );
                    }
                    exit();
                }
                break;    
            case 'KEY_ACTUALIZAR'://
                 if( !empty($_POST['_propietario']) && !empty($_POST['_nombre'] ) 
                         && !empty($_POST['_apellido'] )&& !empty($_POST['_titulo'] )&& !empty($_POST['_correo'] )
                         && !empty($_POST['_telefono'] )&& !empty($_POST['_celular'] )  
                         && !empty($_POST['_id_empresa'] ) && !empty($_POST['_categoria'] )&& !empty($_POST['_identificacion'] )
                         && !empty($_POST['_grupo_asignar'] ) && !empty($_POST['_codigo'] )&& !empty($_POST['_membresia'] )){ 
                    if($_POST['_membresia'] == "x"){
                        $data = array("success" => "false", "priority"=>'info',"msg" => "Debes seleccionar una Membresía!");
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
                                                              $_POST['_categoria']  , $_POST['_desafios'],  
                                                             $_POST['_identificacion'],$_POST['_genero'],$_POST['_tipo_p'],$listaHobbies,$_POST['_id_empresa'],
                                                              $listaDesafios,$_POST['_grupo_asignar'],$_POST['_codigo'],  $_SESSION['user_id_ben'] ,$_POST['_membresia'],$_POST['_status']);  
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

            
            
            
            case 'KEY_GLOBAL_SHOW_FILTRO':
                if(!empty($_POST['_key_filtro']) && !empty($_POST['_filtro'])){
                    
                    $lista['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");
                    $listaNone['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "-None-");
                    $bandera = FALSE;
                    
                    switch ($_POST['_key_filtro']) {
                        case '1': //Para pais
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
                                $objGlobalSede->setIdPais($_POST['_filtro']);
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
                                    $_SESSION['databases_temporales']= $objGlobalSede->getSedesBasesDatos();
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
                                    $tabla= getGlobalTablaFiltrada("","",$_SESSION['databases_temporales']);
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
                                    $listaForum=$objForum->getListaForumLeaders2(NULL,$lista);
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
                                    
                                    setDatosConexion('');
                            }
                            break;
                        case '3'://Para Forum
                             if($_POST['_filtro'] != "x"){
                                setDatosConexion($_POST['_base']);
                                $tabla= getTablaFiltrada($_POST['_filtro'], '2',"");
                                $objGrupo= new Grupo();
                                $resultset= $objGrupo->getIDForumxGrupo($_POST['_filtro']);
                                if($row = $resultset->fetch_assoc()) { 
                                  $id= $row["gru_id"];
                                }
                                $objGrupo= new Grupo();
                                $listaGrupos= $objGrupo->getListaGrupos2($id,$lista);
                                $comboGrupos= generadorComboSelectOption("_grupo", "getGlobalFiltro(4)",$listaGrupos);


                                $data = array("success" => "true", 
                                    "tabla" => $tabla,
                                    "comboGrupos" => $comboGrupos,
                                    "id" => $id);  
                                echo json_encode($data); 
                                setDatosConexion('');
                            }else{
                                $data = array("success" => "x");  
                                echo json_encode($data);
                            }
                            exit();
                            break;
                        case '4': // Para Grupos
                            if($_POST['_filtro'] != "x"){
                                setDatosConexion($_POST['_base']);
                                $tabla= getTablaFiltrada($_POST['_filtro'], '1',"");
                                $objGrupo= new Grupo();
                                $resultset= $objGrupo->getIDGrupoxForum($_POST['_filtro']);
                                if($row = $resultset->fetch_assoc()) { 
                                  $id= $row["gru_forum"];
                                }
                                $objForum = new ForumLeader();
                                $listaForum=$objForum->getListaForumLeaders2($id,$lista);
                                $comboForum= generadorComboSelectOption("_forum", "getGlobalFiltro(3)",$listaForum);



                                $data = array("success" => "true", 
                                    "tabla" => $tabla,
                                    "comboForum"=>$comboForum,
                                    "id" => $id);  
                                echo json_encode($data); 
                                setDatosConexion('');
                            }else{
                                $data = array("success" => "x");  
                                echo json_encode($data);
                            }
                            exit();
                            break;
                        case '5': //Para empresas
                            if($_POST['_filtro'] != "x"){
                                setDatosConexion($_POST['_base']);
                                $tabla= getTablaFiltrada($_POST['_filtro'], '3',"");
                                $data = array("success" => "true", 
                                    "tabla" => $tabla);  
                                echo json_encode($data); 
                                setDatosConexion('');
                            }else{
                                $data = array("success" => "x");  
                                echo json_encode($data);
                            }
                            exit();
                            break;
                        case '6': //Para industrias
                            if($_POST['_filtro'] != "x"){
                                setDatosConexion($_POST['_base']);
                                $tabla= getTablaFiltrada($_POST['_filtro'], '4',"");
                                $data = array("success" => "true", 
                                    "tabla" => $tabla);  
                                echo json_encode($data);
                                setDatosConexion('');
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
            ////////////////////////////////////////////////////////////////////
            //presupuesto
            case 'KEY_GUARDAR_PRESUPUESTO':  


                  if( !empty($_POST['_id_miembro']) && !empty($_POST['_id_periodo']) && !empty($_POST['_id_membresia']) && !empty($_POST['_fecha_registro'])  ){     
                     if(date('Y',strtotime($_POST['_fecha_registro'])) > date("Y") || date('Y',strtotime($_POST['_fecha_registro'])) < date("Y")){
                         $data = array("success" => "false", "priority"=>'info',"msg" => "La fecha debe estar en el rango de este año!");
                         echo json_encode($data);
                         exit();
                     }
                     ////////////////////////////////////////////////////////////
                     $objPerido = new Periodo();
                     $periodoMeses= $objPerido->getPeriodoMes($_POST['_id_periodo']);

                     $objMembresia = new Membresia();
                     $membresiaValor= $objMembresia->getMembresiaValor($_POST['_id_membresia']);




                     ////////////////////////////////////////////////////////////
                     //Obtener las fechas del primer período
                     $multiplicadorPeriodo= 0;
                     $listaFechaLetrasPeriodos="";
                     $fechaPrimeraVuelta="";

                     $multiplicadorLetrasFaltantes= 0;
                     $listaFechaLetrasFaltantes="";

                     $fechaRegistroPresupuesto= date('Y-m-d',strtotime($_POST['_fecha_registro']));
                     $fechaPrimerDia_Registro= getPrimerDiaMes(date("Y"), date('m',strtotime($_POST['_fecha_registro'])));

                     for ($index = $periodoMeses; $index <= 12; $index = $index + $periodoMeses) {

                             $fecha= getPrimerDiaMes(date("Y"),($index - $periodoMeses) + 1);
                             if($fecha >= $fechaPrimerDia_Registro){ //ojo, parte siempre y cuando sea mayor
                                 if($fechaPrimeraVuelta == ""){
                                     $fechaPrimeraVuelta= $fecha;
                                 }
                                 $listaFechaLetrasPeriodos.= $fecha.",";
                                 $multiplicadorPeriodo= $multiplicadorPeriodo + 1;
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
                             $fecha= getPrimerDiaMes(date("Y"),$index); 
                             $listaFechaLetrasFaltantes.= $fecha.",";
                             $multiplicadorLetrasFaltantes= $multiplicadorLetrasFaltantes + 1;
                         }    
                     }
                     ////////////////////////////////////////////////////////////

                     $valorCobrarPeriodo= $membresiaValor * $periodoMeses;  
                     $valorCobrarLetrasFaltantes= $membresiaValor;

                     $totalCobrar= ($valorCobrarPeriodo * $multiplicadorPeriodo) + ($valorCobrarLetrasFaltantes * $multiplicadorLetrasFaltantes);
                     $objTipoPresupuesto = new TipoPresupuesto();
                     $idTipo= $objTipoPresupuesto->getPrimerIDTipo();
                      if($_POST['_id_presupuesto'] != "0"){
                         $objPresupuestoCobro= new PresupuestoCobro();   
                         $comp= $objPresupuestoCobro->actualizarPresupuestoCobroMiembro($_POST['_id_presupuesto'], $valorCobrarPeriodo,
                                 $totalCobrar,$_POST['_id_periodo'], $_SESSION['user_id_ben'],$listaFechaLetrasPeriodos, $_POST['_id_membresia'],
                                 $_POST['_id_miembro'],$listaFechaLetrasFaltantes, $valorCobrarLetrasFaltantes,$idTipo); 
                         $msg='El Presupuesto se actualizo correctamente!';
                      }else{

                         $objPresupuestoCobro= new PresupuestoCobro();
                         $comp= $objPresupuestoCobro->grabarPresupuestoCobroMiembro( $valorCobrarPeriodo, $fechaRegistroPresupuesto, $_POST['_id_miembro'],
                                 $totalCobrar,$_POST['_id_periodo'], $_SESSION['user_id_ben'],$listaFechaLetrasPeriodos, $_POST['_id_membresia'],
                                  $listaFechaLetrasFaltantes, $valorCobrarLetrasFaltantes, $idTipo); 
                         $msg='El Presupuesto se creo correctamente!';
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
            case 'KEY_DETALLE_PRESUPUESTO':
                 if(!empty($_POST['id_presupuesto']) ){         
                     $cuerpo='';
                     $cont=1;
                     $objPresupuestoCobro= new PresupuestoCobro();
                     $resultset= $objPresupuestoCobro->getDetallePresupuestoMiembro($_POST['id_presupuesto']);
                     while ($row = $resultset->fetch_assoc()) {  
                        $fecha= date('Y-m-d',strtotime($row['detalleprecobro_fechavencimiento']));
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
                         $objInscripcion= new Inscripcion();
                         $resultset= $objInscripcion->getInscripcion($_POST['id_miembro']);  
                         if($row = $resultset->fetch_assoc()) {  
                             $fecha_ingreso= $row['mie_ins_fecha_ingreso'];
                             $id_inscripcion= $row['mie_ins_id'];
                             $id_estado_cobro= $row['estado_cobro_id'];
                             $valor="$ ".$row['mie_ins_valor'];
                         }
                             $objMembresia= new Membresia();
                             $lista= array();
                             $lista= $objMembresia->getListaMembresias($_POST['membresia'],NULL);

                             $objEstadoPresupuesto= new EstadoPresupuesto();
                             $listaEP= array();
                             $listaEP= $objEstadoPresupuesto->getListaEstadoPresupuestos($id_estado_cobro,NULL);


                             $formModal['form_1'] = array("elemento" => "caja - oculta","id" => "_id_inscripcion" ,"reemplazo" => $id_inscripcion);
                             $formModal['form_2'] = array("elemento" => "caja - oculta","id" => "_id_miembro_inscripcion" ,"reemplazo" => $_POST['id_miembro']);   

                             $formModal['form_3'] = array("elemento" => "caja" ,"disabled" => "" ,"tipo" => "text" , "titulo" => "Miembro", "id" => "_nombre_inscripcion" ,"reemplazo" => $_POST['nombre']); 
                             $formModal['form_4'] = array("elemento" => "caja" ,"disabled" => "","tipo" => "date" , "titulo" => "Fecha de Registro", "id" => "_fecha_inscripcion" ,"reemplazo" => $fecha_ingreso);  
                             if($id_estado_cobro == "1" || $id_estado_cobro == "0") {
                                 $formModal['form_5'] = array("elemento" => "combo" ,"disabled" => "", "change" => "","titulo" => "Membresía", "id" => "_membresia_inscripcion", "option" => $lista); 
                             }  else {
                                  $formModal['form_6'] = array("elemento" => "caja" ,"disabled" => "disabled","tipo" => "text" , "titulo" => "Valor en base a la Membresía", "id" => "_valor" ,"reemplazo" => $valor);
                             }

                             $formModal['form_7'] = array("elemento" => "combo" ,"disabled" => "","change" => "","titulo" => "Estado", "id" => "_estado_inscripcion", "option" => $listaEP);  
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

                  if( !empty($_POST['_id_miembro_inscripcion']) && !empty($_POST['_fecha_inscripcion']) && !empty($_POST['_membresia_inscripcion']) && !empty($_POST['_estado_inscripcion'])  ){     
 //                    if($_POST['_estado_inscripcion'] == "2"){
 //                        $data = array("success" => "false", "priority"=>'info',"msg" => "La Inscripción ya fue cobrada!");
 //                        echo json_encode($data);
 //                        exit();
 //                    }

                     $objMembresia = new Membresia();
                     $membresiaValor= $objMembresia->getMembresiaValor($_POST['_membresia_inscripcion']);


                      if($_POST['_id_inscripcion'] != "0"){
                         $objInscripcion= new Inscripcion();   
                         $comp= $objInscripcion->setActualizar($_POST['_id_inscripcion'],$membresiaValor,$_SESSION['user_id_ben'],$_POST['_fecha_inscripcion'],$_POST['_estado_inscripcion']); 
                         $msg='La Inscripción se actualizo correctamente!';
                      }else{

                         $objInscripcion= new Inscripcion();
                         $comp= $objInscripcion->setGrabar( $membresiaValor, $_POST['_id_miembro_inscripcion'], $_SESSION['user_id_ben'],
                                 $_POST['_fecha_inscripcion'],$_POST['_estado_inscripcion']); 

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
            case 'KEY_ACTUALIZAR_CREDENCIALES_GLOBALES':///////////////////////////////////////////////////////////    

                    $con= '';
                    $objMiembro= new Miembro();
                    $resultset= $objMiembro->gettMiembroActualizarUserPassCorreos('');  
                    while($row = $resultset->fetch_assoc()) { 
                         $user='';
                         $pass= generaPass(4).generaPass(4);

                         $salt = generateSalt();
                         $hash = hash_hmac("sha256", $pass, $salt);
                         if($row['mie_codigo'] != ''){
                             $user= $row['mie_codigo'];
                         }  else {
                             $user= $row['per_identificacion'];
                         }


                         $objMiembro= new Miembro();
                         $comp= $objMiembro->setMiembroUserPass($row['per_id'] ,$user, $hash, $_SESSION['user_id_ben'],$salt); 
                         if($comp == "OK"){

                             $asunto= 'Renaissance Executive Forums';
                             $msg= 'Estimado miembro:<br>'
                                     . 'A continuación se incluye información para acceder al sistema Renaissance Executive Forums </br>'
                                     . '<p>Link: '.$settings["sitio"].'</p></br>'
                                     . '<p>User: '.$user.'</p></br>'
                                     . '<p>Contraseña: '.$pass.'</p></br></br>';
                             //correo
                             $mail= new Mail();
                             $mail->enviar($_SESSION['user_name'],$_SESSION['user_correo'], $asunto, $msg, $row['correo'], FALSE); 

                         }
                         $con = $user;

                    }
                    $data = array("success" => "false", "priority"=>'success',"msg" => 'OK');  
                    echo json_encode($data);
                    exit();

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
            
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
     exit(); 
}
////////////////////////////////////////////////////////////////////////////////



function getGlobalFiltros() {

    
    $lista['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");
    $listaNone['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "-None-");
    $objPais= new Pais();
    $listapais= $objPais->getListaPais(NUll,$lista); 
    
    $form['form_1'] = array("elemento" => "combo","change" => "getGlobalFiltro('1')", "titulo" => "País", "id" => "_pais", "option" => $listapais); 
    $form['form_2'] = array("elemento" => "combo","change" => "getGlobalFiltro('2')", "titulo" => "Sedes", "id" => "_sedes", "option" => $listaNone);
    $form['form_3'] = array("elemento" => "combo","change" => "getGlobalFiltro('3')", "titulo" => "Forum Leader", "id" => "_forum", "option" => $listaNone);
    $form['form_4'] = array("elemento" => "combo","change" => "getGlobalFiltro('4')", "titulo" => "Grupos", "id" => "_grupo", "option" => $listaNone);
    $form['form_5'] = array("elemento" => "combo","change" => "getGlobalFiltro('5')", "titulo" => "Empresas", "id" => "_empresa", "option" => $listaNone);
    $form['form_6'] = array("elemento" => "combo","change" => "getGlobalFiltro('6')", "titulo" => "Industrias", "id" => "_industria", "option" => $listaNone);
    return $form;
    
}


function getGlobalTablaFiltrada($id, $key, $bases) {
    
    $objMiembro= new GlobalMiembro();
    $cuerpo='';
    $cont=1;
    $resultset= $objMiembro->getGlobalFiltros($id, $key, $bases);
      while($row = $resultset->fetch_assoc()) { 
        $verDetalle='';
        $verDetalle='getDetalle('.$row['mie_id'].')';
        $cuerpo.= generadorTablaFilas(array(
            "<center>".$cont."</center>",
            $row['mie_codigo'],
            generadorLink($row['per_apellido'].' '.$row['per_nombre'],$verDetalle),
            $row['correo'],
            $row['movil']));
        $cont=$cont + 1;                                                                          
     }    
    $tabla= generadorTablaConBotones(1, "Miembros",'', array( "N",
        "Código"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", 
        "Nombre",
        "Correo",
        "Móvil"), $cuerpo,null);

   return $tabla;
    
}
function getTablaFiltrada($id, $key, $idForum) {
    global $perVerMiembroOp6;
    $objMiembro= new Miembro();
    $cuerpo='';
    $cont=1;
    $t='';
    $resultset= $objMiembro->getFiltros($id,$key,$idForum);
      while($row = $resultset->fetch_assoc()) { 
        $verDetalle='';
        if (in_array($perVerMiembroOp6, $_SESSION['usu_permiso'])) {
           $verDetalle='getDetalle('.$row['mie_id'].')';
        }
         $cuerpo.= generadorTablaFilas(array(
             "<center>".$cont."</center>",
             $row['mie_codigo'],
             generadorLink($row['per_apellido'].' '.$row['per_nombre'],$verDetalle),
             $row['nombre_empresa'],
             $row['nombre_forum']));
        $cont=$cont + 1;                                                                          
     }    
    $tabla= generadorTablaConBotones(1, "Miembros",'', array( "N",
         "Código&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", 
         "Nombre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
        . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
        "Empresa","Forum_Leader"), $cuerpo,null);

   return $tabla;
    
}
//setDatosConexion(1);
$t='';
$tabla= getGlobalTablaFiltrada("","","");
$resultado = str_replace("{fitros}", generadorEtiquetasFiltro(getGlobalFiltros()), generadorFiltro('Filtros','ben_contenedor_filtro')); 
$resultado = str_replace("{cuerpo}", $tabla, $resultado);  
$t=$resultado;
//setDatosConexion(2);