<?php
function generadorComboTipoDireccion($select= 'Dirección'){
        if($select == 'Dirección'){
            $direccion['genero_1'] = array("value" => "Dirección",  "select" => "selected" ,"texto" => "Dirección");
            $direccion['genero_2'] = array("value" => "Playas" , "select" => "" ,"texto" => "Playas");

        }else{
             $direccion['genero_1'] = array("value" => "Dirección",  "select" => "" ,"texto" => "Dirección");
             $direccion['genero_2'] = array("value" => "Playas" , "select" => "selected" ,"texto" => "Playas");

        }
 
       return $direccion;
}
 function generadorComboGenero($select){
        if($select == 'MASCULINO'){
            $genero['genero_1'] = array("value" => "M",  "select" => "selected" ,"texto" => "Masculino");
            $genero['genero_2'] = array("value" => "F" , "select" => "" ,"texto" => "Femenino");

        }else{
             $genero['genero_1'] = array("value" => "M",  "select" => "" ,"texto" => "Masculino");
             $genero['genero_2'] = array("value" => "F" , "select" => "selected" ,"texto" => "Femenino");

        }
 
       return $genero;
}

 function generadorComboTipoPersona($select){
        if($select == 'Natural'){
                $tipo_p['tipo_p_2'] = array("value" => "J" , "select" => "" ,"texto" => "Jurídica");
                $tipo_p['tipo_p_1'] = array("value" => "N" , "select" => "selected" ,"texto" => "Natural");
                

           }else{
               
                $tipo_p['tipo_p_2'] = array("value" => "J" , "select" => "selected" ,"texto" => "Jurídica");
                $tipo_p['tipo_p_1'] = array("value" => "N" , "select" => "" ,"texto" => "Natural");

           }
 
       return $tipo_p;
}
 function generadorComboTipoPersona_($select){
        if($select == 'N'){
                $tipo_p['tipo_p_2'] = array("value" => "J" , "select" => "" ,"texto" => "Jurídica");
                $tipo_p['tipo_p_1'] = array("value" => "N" , "select" => "selected" ,"texto" => "Natural");
                

           }else{
               
                $tipo_p['tipo_p_2'] = array("value" => "J" , "select" => "selected" ,"texto" => "Jurídica");
                 $tipo_p['tipo_p_1'] = array("value" => "N" , "select" => "" ,"texto" => "Natural");

           }
 
       return $tipo_p;
}

 function generadorComboEstado($select){
     $select= strtoupper($select);
        if($select == 'ACTIVO'){
                $estado['estado_1'] = array("value" => "A" , "select" => "selected" ,"texto" => "Activo");
                $estado['estado_2'] = array("value" => "I" , "select" => "" ,"texto" => "Inactivo");

          }else{
              $estado['estado_1'] = array("value" => "A" , "select" => "" ,"texto" => "Activo");
              $estado['estado_2'] = array("value" => "I" , "select" => "selected" ,"texto" => "Inactivo");

          }
 
       return $estado;
}
 function generadorComboTipoTelefono($select){
        if($select == 'Movil'){
                $tel['tel_1'] = array("value" => "M" , "select" => "selected" ,"texto" => "Móvil");
                $tel['tel_2'] = array("value" => "T" , "select" => "" ,"texto" => "Convencional");

          }else{
              $tel['tel_1'] = array("value" => "M" , "select" => "" ,"texto" => "Móvil");
              $tel['tel_2'] = array("value" => "T" , "select" => "selected" ,"texto" => "Convencional");

          }
 
       return $tel;
}

 function generadorComboPrioridad($select){
    $prioridad['p_1'] = array("value" => "Alto" , "select" => "selected" ,"texto" => "Alto");
    $prioridad['p_2'] = array("value" => "Muy Alto" , "select" => "" ,"texto" => "Muy Alto");
    $prioridad['p_3'] = array("value" => "Bajo" , "select" => "" ,"texto" => "Bajo");
    $prioridad['p_4'] = array("value" => "Más Bajo" , "select" => "" ,"texto" => "Más Bajo");
    $prioridad['p_5'] = array("value" => "Normal" , "select" => "" ,"texto" => "Normal");
   return $prioridad;
}

 function generadorComboAños($a){//selected
    $año_actual= $a ;//2016
    $año_partida= 2010;
    for ($index = $año_actual; $index >= $año_partida;  $index= $index - 1 ) {
        $año[$index] = array("value" => $index , "select" => "" ,"texto" => $index);
    } 
    return $año;
}
 function generadorComboDirigido($select){
     if ($select=="1"){
        $estado['p_1'] = array("value" => "1" , "select" => "selected" ,"texto" => "Prospectos");
        $estado['p_2'] = array("value" => "2" , "select" => "" ,"texto" => "Miembros");
     }else{
         $estado['p_1'] = array("value" => "1" , "select" => "" ,"texto" => "Prospectos");
         $estado['p_2'] = array("value" => "2" , "select" => "selected" ,"texto" => "Miembros");
     }

   return $estado;
}

 function generadorComboDirigidoEvento($select){
     if ($select=="1"){
        $estado['p_1'] = array("value" => "1" , "select" => "selected" ,"texto" => "Grupos");
        $estado['p_2'] = array("value" => "2" , "select" => "" ,"texto" => "Miembros");
     }else{
         $estado['p_1'] = array("value" => "1" , "select" => "" ,"texto" => "Grupos");
         $estado['p_2'] = array("value" => "2" , "select" => "selected" ,"texto" => "Miembros");
     }

   return $estado;
}