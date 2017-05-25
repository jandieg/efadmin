<?php
    function getMsg($msg){
        switch ($msg) {
                case 'ok':
                    return getExito();
                break;
                case 'no':
                    return getFallo();
                break;
                case 'error':
                    return getError();
                break;
                default:
                    return getNull();
                break;

        }
               
    }
    

    function getNull(){
        $response["success"] = "4";
        $response["msg"] = "No enviaste datos";
        return json_encode($response);
     
    }
      function getError(){
        $response["success"] = "3";
        $response["msg"] = "Error al conectar";
        return json_encode($response);
    }

    function getFallo(){
        $response["success"] = "2";
        $response["msg"] = "Respuesta NULL";
        return json_encode($response);       
    }

    function getExito(){
        $response["success"] = "1";
        $response["msg"] = "Creación éxitosa";
        return json_encode($response);
    }