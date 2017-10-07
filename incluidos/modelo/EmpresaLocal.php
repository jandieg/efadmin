<?php

class EmpresaLocal extends Conexion{ 



    private $objIndustrias;

    private $primerEmpresa= '';

    public function __construct(){

        parent:: __construct();        

    }

    

    public function getPrimerEmpresa() {

        return $this->primerEmpresa;

    }


    public function getResenaDeMiembro($idEmpresa) {
        $sql="call sp_selectResenaEmpresaMiembro('$idEmpresa');";
        
        return parent::getConsultar($sql);
    }

    public function getEmpresasLocal($idForum='') {

        $sql="call sp_selectEmpresas('$idForum')";

        return parent::getConsultar($sql);   

    }

    public function getEmpresasLocal2($idForum='', $idUser) {

        $sql="call sp_selectEmpresas2('$idForum', '$idUser')";

        return parent::getConsultar($sql);   

    }


    public function getEmpresasLocal3($idForum='', $idUser) {

        $sql="call sp_selectEmpresas3('$idForum', '$idUser')";

        return parent::getConsultar($sql);   

    }


    public function setCrearEmpresaLocal($bandera = '1', $nombre, $est, $id_user, $ingreso, $ruc, $numEmpleado, $listaIndustrias, $fax, $sitioweb,$correo1, $movil, $ciudad, $calle,  $adicional_2,$resena)  {

        $fecha= date("Y-m-d H:i:s");

        $sql="call sp_createEmpresaLocal('$nombre','$est','$fecha','$id_user', '$ingreso', '$ruc', '$numEmpleado', '$listaIndustrias', '$fax', '$sitioweb','$correo1', '$movil', '$ciudad', '$calle',  '$adicional_2','$resena')";

        if($bandera == '1'){

            return parent::setSqlSp($sql);

        }else{

            $resultset= parent::getConsultar($sql);

            $idMaximo="0";

            if($row = $resultset->fetch_assoc()) { 

                $idMaximo=$row['emp_id'];

            }



            return $idMaximo; 

        }

           

    }

    

    public function getEmpresaLocal($idEmpresa='') {

        $sql="call sp_selectEmpresaLocal('$idEmpresa')";

        return parent::getConsultar($sql);   

    }  

    public function getEmpresaLocalMasMiembros($idEmpresa='') {

        $sql="call sp_selectEmpresaLocalMasMiembros('$idEmpresa')";

        return parent::getConsultar($sql);   

    } 

//      $_POST['_correo1'], $_POST['_movil'],$_POST['_ciudad'], $_POST['_calle'],'',''); 

    public function setActualizarEmpresaLocal($id, $nombre, $est, $id_user, $ingreso, $ruc, $numEmpleado, $listaIndustrias, $fax, $sitioweb,$correo1, $movil, $ciudad, $calle,  $adicional_2,$resena)  {

        $fecha= date("Y-m-d H:i:s");

        $sql="call sp_updateEmpresaLocal('$id','$nombre','$est','$id_user', '$ingreso', '$ruc', '$numEmpleado', '$listaIndustrias', '$fax', '$sitioweb','$correo1', '$movil', '$ciudad', '$calle', '$adicional_2','$resena')";

        return parent::setSqlSp($sql);   

    }

    public function getEmpresaLocalIndustrias($idEmpresa='') {

        $sql="call sp_selectEmpresaIndustrias('$idEmpresa')";

        return parent::getConsultar($sql);   

    } 

    

    

     public function getIndustriasSeleccionadas($id) {

        $sql="call sp_selectIDEmpresaIndustrias('$id')";

        return parent::getConsultar($sql);   

    } 

    

    function getMultiListaIndustria($idEmpresa) {

        $resultset_industria_selecionadas= $this->getIndustriasSeleccionadas($idEmpresa); 

        $lista_ind_selecionadas=array();

        while ($row_industria_selecionada = $resultset_industria_selecionadas->fetch_assoc()) { 

            $lista_ind_selecionadas[$row_industria_selecionada['industria_ind_id']]=$row_industria_selecionada['industria_ind_id'];        

       

         }

        $this->objIndustrias= new Industria();

        $resultset_industria= $this->objIndustrias->getIndustrias('A'); 

        $listaIndustria=array();

        $bandera=FALSE;

        while ($row_industria = $resultset_industria->fetch_assoc()) {      

            foreach ($lista_ind_selecionadas as $val){

                if($row_industria['ind_id']==$val){

                            $bandera=TRUE;

                 }

            }



            if($bandera){

                $listaIndustria['lista_'.$row_industria['ind_id']] = array("value" => $row_industria['ind_id'],  "select" => "selected" ,"texto" => $row_industria['ind_descripcion']);

            }  else {

                $listaIndustria['lista_'.$row_industria['ind_id']] = array("value" => $row_industria['ind_id'],  "select" => "" ,"texto" => $row_industria['ind_descripcion']);

            }

            $bandera=FALSE;

        }

        return $listaIndustria;

        

    }

    

  

     public function getEmpresaIndustrias($id) {

        $sql="SELECT i.ind_descripcion  FROM  empresa_industria  pi, industria  i "

                . "WHERE pi.empresalocal_emp_id='$id' and pi.industria_ind_id= i.ind_id";

        return parent::getConsultar($sql);   

    }

    

    

     public function getListaEmpresa($id='') {   

        $resultset= $this->getEmpresasLocal(""); 

        $lista=array();

        if($id!=''){

            while ($row = $resultset->fetch_assoc()) {

                if($this->primerEmpresa == ''){

                    $this->primerEmpresa=$row['emp_id'];

                }

                if($row['emp_id']==$id){

                     $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "Selected" ,"texto" => $row['nombre_empresa']);

                     

                }else{

                     $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "" ,"texto" => $row['nombre_empresa']);

                }



            }

        }  else {

            while ($row = $resultset->fetch_assoc()) { 

                if($this->primerEmpresa == ''){

                    $this->primerEmpresa=$row['emp_id'];

                }

                  $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "" ,"texto" => $row['nombre_empresa']);



           }

          

          }

        return $lista;

    }

       public function getListaEmpresa3($id='', $lista= array(), $idUser) {   

        $resultset= $this->getEmpresasLocal2("", $idUser); 

    

        if($id!=''){

            while ($row = $resultset->fetch_assoc()) {

                if($this->primerEmpresa == ''){

                    $this->primerEmpresa=$row['emp_id'];

                }

                if($row['emp_id']==$id){

                     $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "Selected" ,"texto" => $row['nombre_empresa']);

                     

                }else{

                     $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "" ,"texto" => $row['nombre_empresa']);

                }



            }

        }  else {

            while ($row = $resultset->fetch_assoc()) { 

                if($this->primerEmpresa == ''){

                    $this->primerEmpresa=$row['emp_id'];

                }

                  $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "" ,"texto" => $row['nombre_empresa']);



           }

          

          }

        return $lista;

    }

     public function getListaEmpresa5($id='', $lista= array(), $idUser) {   

        $resultset= $this->getEmpresasLocal3("", $idUser); 

    

        if($id!=''){

            while ($row = $resultset->fetch_assoc()) {

                if($this->primerEmpresa == ''){

                    $this->primerEmpresa=$row['emp_id'];

                }

                if($row['emp_id']==$id){

                     $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "Selected" ,"texto" => $row['nombre_empresa']);

                     

                }else{

                     $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "" ,"texto" => $row['nombre_empresa']);

                }



            }

        }  else {

            while ($row = $resultset->fetch_assoc()) { 

                if($this->primerEmpresa == ''){

                    $this->primerEmpresa=$row['emp_id'];

                }

                  $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "" ,"texto" => $row['nombre_empresa']);



           }

          

          }

        return $lista;

    }

  public function getListaEmpresa4($id='', $lista= array(), $idUser) {   

        $resultset= $this->getEmpresasLocal2("", $idUser); 

    

        if($id!=''){

            while ($row = $resultset->fetch_assoc()) {

                if($this->primerEmpresa == ''){

                    $this->primerEmpresa=$row['emp_id'];

                }

                if($row['emp_id']==$id){

                     $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "Selected" ,"texto" => $row['nombre_empresa']);

                     

                }else{

                     $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "" ,"texto" => $row['nombre_empresa']);

                }



            }

        }  else {

            while ($row = $resultset->fetch_assoc()) { 

                if($this->primerEmpresa == ''){

                    $this->primerEmpresa=$row['emp_id'];

                }

                  $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "" ,"texto" => $row['nombre_empresa']);



           }

          

          }

        return $lista;

    }

       public function getListaEmpresa2($id='', $lista= array()) {   

        $resultset= $this->getEmpresasLocal(""); 

    

        if($id!=''){

            while ($row = $resultset->fetch_assoc()) {

                if($this->primerEmpresa == ''){

                    $this->primerEmpresa=$row['emp_id'];

                }

                if($row['emp_id']==$id){

                     $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "Selected" ,"texto" => $row['nombre_empresa']);

                     

                }else{

                     $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "" ,"texto" => $row['nombre_empresa']);

                }



            }

        }  else {

            while ($row = $resultset->fetch_assoc()) { 

                if($this->primerEmpresa == ''){

                    $this->primerEmpresa=$row['emp_id'];

                }

                  $lista['lista_'.$row['emp_id']] = array("value" => $row['emp_id'],  "select" => "" ,"texto" => $row['nombre_empresa']);



           }

          

          }

        return $lista;

    }

    public function getFiltros($id, $key, $permiso) {

        $sql="call sp_selectEmpresaLocalFiltros('$id','$key', '$permiso')";

        return parent::getConsultar($sql);   

    }

    public function setCreateUpdateEmpresa($emp_nombre, $id_industria) {
        $sql = "call sp_createUpdateEmpresa('$emp_nombre', '$id_industria')";
        return parent::setSqlSp($sql);
    }

    public function getFiltros2($id, $key, $permiso, $todas) {
        $sql="call sp_selectEmpresaLocalFiltros2('$id','$key', '$permiso','$todas')";
        return parent::getConsultar($sql);   
    }

    



    public function setCrearEmpresaContacto($idEmpresa, $nombre, $apellido, $id_user, $correo, $celular, $funcion,$convencional) {

        $fecha= date("Y-m-d H:i:s");

        $sql="call sp_createEmpresaContacto('$idEmpresa','$nombre','$apellido','$fecha','$id_user', '$correo', '$celular', '$funcion','$convencional')";

        return parent::setSqlSp($sql);   

    }

    

    public function getEmpresaContactos($id) {

        $sql="call sp_selectEmpresaContacto('$id')";

        return parent::getConsultar($sql);   

    } 

    

    public function setActualizarEmpresaContacto($idEmpresaContacto, $nombre, $apellido, $id_user, $correo, $celular, $funcion,$convencional) {     

        $sql="call sp_updateEmpresaContacto('$idEmpresaContacto','$nombre','$apellido','$id_user', '$correo', '$celular', '$funcion', '$convencional')";

        return parent::setSqlSp($sql);   

    } 

    public function getEmpresaTodosContactos($estado) {

        $sql="call sp_selectEmpresaContactos('$estado')";

        return parent::getConsultar($sql);   

    } 

       public function getListaContacto($id='', $lista= array()) {   

        $resultset= $this->getEmpresaTodosContactos("A"); 

        if($id!=''){

            while ($row = $resultset->fetch_assoc()) {

                if($row['conta_id']==$id){

                    $lista['lista_'.$row['conta_id']] = array("value" => $row['conta_id'],  "select" => "Selected" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);     

                }else{

                    $lista['lista_'.$row['conta_id']] = array("value" => $row['conta_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

                }

            }

        }  else {

            while ($row = $resultset->fetch_assoc()) { 

                $lista['lista_'.$row['conta_id']] = array("value" => $row['conta_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

           }

          }

        return $lista;

    }

    

    

    

    

    

    

    

    

    

    //Para propecto, aplicante y miembro

     public function get($_id_empresa= '' , $_id='',$bandera= '1') {

        $sql="call sp_selectPAMEmpresa('$_id_empresa', '$_id','$bandera')";

        return parent::getConsultar($sql);   

    }

    public function setAdd($_id, $empresa, $descripcion, $id_user,$bandera= '1', $tipo) {

        $fecha= date("Y-m-d H:i:s");

        $sql="call sp_createPAMEmpresa('$_id','$empresa','$descripcion','$fecha','$id_user','$bandera', '$tipo')";

        return parent::setSqlSp($sql);   

    }

    public function setActualizar($_id, $empresa, $descripcion, $id_user,$bandera= '1',$tipo) {

        $sql="call sp_updatePAMEmpresa('$_id','$empresa','$descripcion','$id_user','$bandera', '$tipo')";

        return parent::setSqlSp($sql);   

    }

    public function setDelete($_id_tabla_empresa, $bandera= '1') {

        $sql="call sp_deletePAMEmpresa('$_id_tabla_empresa','$bandera')";

        return parent::setSqlSp($sql);   

    }

//     tipo_empresa_pam.tip_emp_id,

//            tipo_empresa_pam.tip_emp_descripcion

    public function getTabla($_id, $bandera= '1') {

                        $cuerpo='';

                        $cont= 1;

                        $resultset= $this->get(NULL, $_id,$bandera);

                        while ($row_me = $resultset->fetch_assoc()) {                     

                           $cuerpo.= generadorTablaColoresFilas("" ,

                                   array(

                                       $row_me['emp_ruc'],

                                       $row_me['emp_nombre'],

                                       $row_me['emp_txtadicional_1'],

                                       $row_me['emp_movil'],

                                       getAccionesParametrizadas(

                                               "getActualizarEmpresa(".$_id.",".$row_me['pam_id'].",".$row_me['emp_id'].",'".$row_me['descripcion']."',".$row_me['tip_emp_id'].")",

                                               "",

                                               "Actualizar",

                                               "fa fa-pencil").

                                       getAccionesParametrizadas(

                                               "setEliminarEmpresa(".$row_me['pam_id'].",".$_id.",".$bandera.")",

                                               "",

                                               "Eliminar",

                                               "fa fa-trash")));     

                             $cont= $cont + 1; 

                         }



//`emp_correo_principal`,

//            `emp_movil`,

//            `emp_txtadicional_1`,

//            `emp_txtadicional_2`, 

//            `ciudad_id`,

                        $tablaDetalleEmpresas= generadorTablaDetalleEstadoCuenta(

                            array( generadorNegritas("RUC"),

                                generadorNegritas("Nombre"),

                                generadorNegritas("Dirección"),

                                generadorNegritas("Teléfono Móvil"),

                                generadorNegritas("Acción")), $cuerpo);

                            return $tablaDetalleEmpresas;

    }

    

   

    

    function getMultiListaIndustria2($idEmpresa, $tabla_emp_ind = array(), $titulo) {

        $resultset_emp_ind= $this->getEmpresaLocalIndustrias($idEmpresa);     

        $con=1;

        while ($row_emp_ind = $resultset_emp_ind->fetch_assoc()) {

            if($con==1){

                $tabla_emp_ind['b_'.$con] = array("t_1" =>$titulo , "t_2" => $row_emp_ind['ind_descripcion']);

            }  else {

                $tabla_emp_ind['b_'.$con] = array("t_1" =>"" ,                "t_2" => $row_emp_ind['ind_descripcion']);

            }



            $con=$con+1;

        }

        

        return $tabla_emp_ind;

        

    }

}

