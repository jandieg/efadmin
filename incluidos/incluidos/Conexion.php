<?php
class Conexion {
    private $host;
    private $user;
    private $pass;
    private $db;
    private $mysqli;
    public function __construct() { 
            //$settings = parse_ini_file(E_LIB."settings.ini.php");            
            $this->host = $_SESSION['host'];
            $this->user = $_SESSION['user'];
            $this->pass = $_SESSION['pass'];
            $this->db = $_SESSION['db'];
            $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db);
            

            
            
            
        }
    function setSqlSentence($commando){
        try {
            if ($this->mysqli->connect_errno) {
                echo "FALLO LA CONEXIÓN: ". $this->mysqli->connect_error;
                exit();
            }else {
                $this->mysqli->set_charset("utf8");
//                date_default_timezone_set ("America/Guayaquil");
                $this->mysqli->multi_query($commando);
                //si no se ingresa retorna o caso contrario >0
                return $this->mysqli->affected_rows;
            }
            $this->mysqli->close();
        } catch (Exception $exc) {
            echo "FALLO LA CONEXIÓN: ".$exc->getTraceAsString();
            exit();
        }
    }
    function setSqlSp($commando){
        try {
            if ($this->mysqli->connect_errno) {
                echo "FALLO LA CONEXIÓN: ". $this->mysqli->connect_error;
                exit();
            }else {
                $this->mysqli->set_charset("utf8");
//                date_default_timezone_set ("America/Guayaquil");
                if(!$this->mysqli->multi_query($commando)){
                    return "Falló CALL: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
                }else{
                    return "OK";
                }
                //si no se ingresa retorna o caso contrario >0
                
            }
            $this->mysqli->close();
        } catch (Exception $exc) {
        echo "FALLO LA CONEXIÓN: ".$exc->getTraceAsString();
        exit();
        }
    }
    function getConsultar($commando){
        try {
            //retorna null si no encuentra nada
            if ($this->mysqli->connect_errno) {
                echo("FALLO LA CONEXIÓN: ". $this->mysqli->connect_error);
                exit();
            }  else {
                $this->mysqli->set_charset("utf8");
//                date_default_timezone_set ("America/Guayaquil");
                if ($this->mysqli->multi_query($commando)) {
                    return $this->mysqli->store_result();
                }    
            }        
            $this->mysqli->close();
        } catch (Exception $exc) {
            echo "FALLO LA CONEXIÓN: ".$exc->getTraceAsString();
            exit();
        }
    }
    public function __destruct(){
        unset($this->host);
        unset($this->user);
        unset($this->pass);
        unset($this->db);
        unset($this->mysqli);
    }
}
