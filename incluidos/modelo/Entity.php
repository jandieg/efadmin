<?php
class Entity extends Conexion{ 

    private $sql;
    private $parametros= array();
    private $response= array();
    
    public function __construct($response= array()){
        parent:: __construct();  
        $this->response= $response;
    }
    
    public function getSp($sql = '', $parametros = array(), $etiqueta_response) {
        try {
            $this->sql= $sql;
            $this->parametros= $parametros;
            $resultset= parent::getConsultar($this->getQuery());
            $this->response[$etiqueta_response] = array();
            //if(!empty($resultset)){   
                while($row = $resultset->fetch_assoc()) {  
                  array_push($this->response[$etiqueta_response], $row); 
                } 
            //}
            return $this->response;
        } catch (Exception $ex) {
            $this->response[$etiqueta_response] = array();
            return $this->response; //$ex.getMessage();
        }
        
        
    }
	 public function getSpResultse($sql = '', $parametros = array()) {
        try {
            $this->sql= $sql;
            $this->parametros= $parametros;
            return parent::getConsultar($this->getQuery());
     
        } catch (Exception $ex) {
            $this->response[$etiqueta_response] = array();
            return $this->response; //$ex.getMessage();
        }
        
        
    }
    
    public function setSp($sql = '', $parametros = array()) {
        $this->sql= $sql;
        $this->parametros= $parametros;
        $resultset= parent::setSqlSp($this->getQuery()); 
        return $resultset;
    }
    
    private function getQuery() {
        $query = "Call ";
        $query .= $this->sql . "(";
        
        if(count($this->parametros) > 0) { 
            foreach($this->parametros as $param){
               $query .= "'" . $param . "',";
            }
            $query = substr($query, 0, -1);
        }
       
        $query .= ")";
        return $query;
    }
    
    public function getResponse() {
        return $this->response;
    }
 
}

