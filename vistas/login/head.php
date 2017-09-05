<?php
require_once MODELO.'Usuario.php'; 
require_once MODELO.'Permiso.php'; 
require_once MODELO.'Correo.php';
include(HTML."/html_2.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{      
        if(isset($_POST['usua_usuario']) && isset($_POST['usua_clave'])){
            ////////////////////////////////////////////////////////////////////
            //Asigno la conexión por defaul la cual es la principal donde se manejan los sp 
            //para el login global
            setDatosConexion('');
            //la opción --base-- es para establecer un array de todos los nombres de las bases
            setDatosConexion('bases');
            //Para establecer las variables de sesion para los filtro
            $_SESSION['global_databases_temporales']='x';
            $_SESSION['global_pais_temporales']='x';
            $_SESSION['global_have_perfil_regional_temporales']='0';
			
			$_SESSION['user_selected_country'] = $_POST['pais'];
            
            $objUsuario= new Usuario();
            $resultset= $objUsuario->getRouterLogin($_POST['usua_usuario']);
            if($row = $resultset->fetch_assoc()) {  
                if (testPassword($_POST['usua_clave'], $row['usu_salt'], $row['usu_pass']) == TRUE) {   
                    $_SESSION['user_id_ben'] = $row["usu_id"];
                    $_SESSION['user_name'] = $row["per_nombre"]." ".$row["per_apellido"];
                    $_SESSION['user_user'] = $row["usu_user"];
                    $_SESSION['user_perfil'] = $row["perfil_descripcion"];
                    $_SESSION['user_correo']= $row["correo"];
                    $_SESSION['user_id_perfil'] = $row["perfil_id"];
					$_SESSION['sede_id'] = $row["sede_id"];
					$_SESSION['pais_id'] = $row["pais_id"];
					
					if($row["usu_user"]=='ibpadmin'){
						$_SESSION['user_country'] = '*';
					}
					if($row["usu_user"]=='admin'){
						$_SESSION['user_country'] = '*';
					}
					
                    ////////////////////////////////////////////////////////////////////
                    //Conexión Remota
                    //La variable de sesion $_SESSION['user_subasedatos'], 
                    //establece la conexion de la cual pertenece el user logeado 
                    $_SESSION['user_subasedatos'] =  $row["db"];
                    setDatosConexion($row["db"]);
                    
                    //permisos
                    $seguridadPermiso= array();
                    $cont= 1;
                    $permiso= new Permiso();
                    $resultset_permiso= $permiso->getPermisos($row["perfil_id"]);
                    while($row_permiso = $resultset_permiso->fetch_assoc()) { 
                        $seguridadPermiso['usu_permiso_'.$cont]=$row_permiso['id_permiso'];
                        $cont= $cont + 1;
                    }
                    if (in_array($perPrivilegioLiderRegionalOp1, $_SESSION['usu_permiso'])) {
                        $_SESSION['global_have_perfil_regional_temporales']='1';
                    }

                    $_SESSION['usu_permiso'] = $seguridadPermiso;
                    if (in_array($perConfiguracionesGeneralesOp5, $_SESSION['usu_permiso'])){
                         redirect("sede");
						// redirect("prospectos?_esaplicante=0");
                    }elseif (in_array($perVerPerfilMiembroOp12, $_SESSION['usu_permiso'])) {    
                        redirect("miembroperfil");  
                    }else{
                    //    redirect("perfil");
					 redirect("/");
                    }


                }  else {
                    $_SESSION['OK']="NO";
                    $_SESSION['E_MSG']="¡Su usuario o contraseña son incorrectos!";  
                }         
            } else{
                $_SESSION['OK']="NO";
                $_SESSION['E_MSG']="¡Su usuario o contraseña son incorrectos!";   
            }
        }

    } catch (Exception $exc) { 
        echo getError($exc);
        exit(); 
    }    
     
}
////////////////////////////////////////////////////////////////////////////////
//Para la sede
//$objPais= new Pais();
//$listapais= $objPais->getListaPais();

$lista['1'] = array("value" => "1",  "select" => "selected" ,"texto" => "Sede Guayaquil");
$lista['2'] = array("value" => "2",  "select" => "selected" ,"texto" => "Sede Lima");

$form['form_1'] = array("elemento" => "combo+name", "change" => "","titulo" => "Sedes", "id" => "_sede", "name" => "_sede", "option" => $lista);

$listaSedes= generadorEtiquetaVVertical($form);