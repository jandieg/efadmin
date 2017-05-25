<?php
class FormaPago extends Conexion{ 

   
    private $id= '';
    public function __construct(){
        parent:: __construct();        
    }
    
    public function getIDFormapago() {
        return $this->id;
    }

    public function getFormaPago($estado) {
        $sql="call sp_selectFormasPago('$estado')";
        return parent::getConsultar($sql);   
    }
    
     public function getListaFormaPago($idSeleccionado='') {   
        $resultset= $this->getFormaPago('A'); 
        $lista=array();
        if($idSeleccionado!=''){
            while ($row = $resultset->fetch_assoc()) {
                if($this->id == ''){
                    $this->id=$row['emp_id'];
                }
                if($row['for_pag_id']==$idSeleccionado){
                     $lista['lista_'.$row['for_pag_id']] = array("value" => $row['for_pag_id'],  "select" => "Selected" ,"texto" => $row['for_pag_descripcion']);
                     
                }else{
                     $lista['lista_'.$row['for_pag_id']] = array("value" => $row['for_pag_id'],  "select" => "" ,"texto" => $row['for_pag_descripcion']);
                }

            }
        }  else {
            while ($row = $resultset->fetch_assoc()) { 
                if($this->id == ''){
                    $this->id=$row['for_pag_id'];
                }
                  $lista['lista_'.$row['for_pag_id']] = array("value" => $row['for_pag_id'],  "select" => "" ,"texto" => $row['for_pag_descripcion']);

           }
          
          }
        return $lista;
    }
   public function setGrabar($descripcion, $user) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createFormaPago('$descripcion', '$user','$fecha')";
        return parent::setSqlSp($sql);   
    }
    public function get($id) {
        $sql="call sp_selectFormaPago('$id')";
        return parent::getConsultar($sql);   
    }
    public function setActualizar($id, $descripcion, $user, $estado) {
        $sql="call sp_updateFormaPago('$id','$descripcion','$user', '$estado')";
        return parent::setSqlSp($sql);   
    }
    //sp_updateFormaPago(IN _id INT ,IN _descripcion VARCHAR(200), IN _usuario INT,  IN _estado VARCHAR(10)) 

}
