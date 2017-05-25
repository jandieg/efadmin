<?php 
require_once MODELO.'TipoEvento.php';
require_once MODELO.'Miembro.php';
require_once MODELO.'Grupo.php';
require_once MODELO.'Participante.php';
require_once MODELO.'Evento.php';
require_once MODELO.'Aconpanamiento.php';
require_once MODELO.'EmpresariosMes.php';
include(HTML."/html_2.php");
include(HTML."/html.php");

//Respuestas AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):
            case 'KEY_DATA_CALENDARIO'://///////////////////////////////////////////////////////// 
                $objMiembro= new Miembro();
                echo $objMiembro->getJSONEventosCalendar($_SESSION['user_id_ben']); 
  
                break;

//            case 'KEY_DETALLE_EVENTO'://///////////////////////////////////////////////////////// 
//                if(!empty($_POST['_id'])){    
//
//                    $objEvento= new Evento();
//                    $resultset= $objEvento->getEventosDetalle($_POST['_id']);
//                    if($row = $resultset->fetch_assoc()) {
//                                 
//                        $tabla['t_1'] = array("t_1" => generadorNegritas("Responsable"), "t_2" => $row['eve_responsable']);
//                        $tabla['t_2'] = array("t_1" => generadorNegritas("Evento"), "t_2" => $row['eve_nombre']);
//                        $tabla['t_3'] = array("t_1" => generadorNegritas("Dirección"), "t_2" => $row['direccion']);
//                        
//                        $cont=10;
//                        $objEvento = new Evento();
//                        $resultset= $objEvento->getEventosDetalleGrupos($_POST['_id']);
//                        while($row_g = $resultset->fetch_assoc()) {
//                            if($cont == 10){
//                                $tabla['t_'.$cont] = array("t_1" => generadorNegritas("Grupos"), "t_2" => $row_g['gru_descripcion']);
//                            }else{
//                                $tabla['t_'.$cont] = array("t_1" => "", "t_2" => $row_g['gru_descripcion']);
//                            }
//                            $cont=$cont + 1;
//                        }
//                        
//                        if($row['eve_mis_grupos']== "1"){
//                            $tabla['t_21'] = array("t_1" => generadorNegritas("Grupos"), "t_2" => "Mis Grupos");
//                        }
//                        if($row['eve_todos_grupos']== "1"){
//                            $tabla['t_22'.$cont] = array("t_1" => generadorNegritas("Grupos"), "t_2" => "Todos los Grupos");
//                        }
//                        
//                        $cont=30;
//                        $objEvento = new Evento();
//                        $resultset= $objEvento->getEventosDetalleMiembros($_POST['_id']);
//                        while($row_m = $resultset->fetch_assoc()) {
//                            if($cont == 30){
//                                $tabla['t_'.$cont] = array("t_1" => generadorNegritas("Miembros"), "t_2" => $row_m['per_apellido']." ".$row_m['per_nombre']);
//                            }else{
//                                $tabla['t_'.$cont] = array("t_1" => "", "t_2" => $row_m['per_apellido']." ".$row_m['per_nombre']);
//                            }
//                            $cont=$cont + 1;
//                        }
// 
//                        $tabla['t_41'] = array("t_1" => generadorNegritas("Fecha Inicio"), "t_2" => $row['eve_fechainicio']);
//                        $tabla['t_42'] = array("t_1" => generadorNegritas("Fecha Fin"), "t_2" => $row['eve_fechafin']); 
//                        
//                        
//                        if($row['tip_eve_opcion_empresario_mes'] == "1"){
//                            $cont=50;
//                            $objEmpresariosMes = new EmpresariosMes();
//                            $resultset= $objEmpresariosMes->getEventosEmpresariosMes($_POST['_id']);
//                            while($row_em = $resultset->fetch_assoc()) {
//                                if($cont == 50){
//                                    $tabla['t_'.$cont] = array("t_1" => generadorNegritas("Empresarios Del Mes"), "t_2" => $row_em['per_apellido']." ".$row_em['per_nombre']);
//                                }else{
//                                    $tabla['t_'.$cont] = array("t_1" => "", "t_2" => $row_em['per_apellido']." ".$row_em['per_nombre']);
//                                }
//                                $cont=$cont + 1;
//                            }
//                        }
//                        if($row['tip_eve_opcion_acompanado'] == "1"){
//                            $tabla['t_20'] = array("t_1" => generadorNegritas("Acompañado por:"), "t_2" => $row['acompanado']);
//                        }
//                        
//                        if($row['tip_eve_opcion_contacto'] == "1"){
//                            $cont=60;
//                            $objParticipante = new Evento();
//                            $resultset= $objParticipante->getParticipantesEventoInvitadoOContacto($_POST['_id'] , "Contacto");
//                            while($row_pc = $resultset->fetch_assoc()) {
//                                if($cont == 60){
//                                    $tabla['t_'.$cont] = array("t_1" => generadorNegritas("Contactos"), "t_2" => $row_pc['per_apellido']." ".$row_pc['per_nombre']);
//                                }else{
//                                    $tabla['t_'.$cont] = array("t_1" => "", "t_2" => $row_pc['per_apellido']." ".$row_pc['per_nombre']);
//                                }
//                                $cont=$cont + 1;
//                            }
//                        }
//                        
//                        
//                        if($row['tip_eve_opcion_invitado'] == "1"){
//                            $cont=70;
//
//                            $objParticipante = new Evento();
//                            $resultset= $objParticipante->getParticipantesEventoInvitadoOContacto($_POST['_id'] , "Invitado");
//                            while($row_pi = $resultset->fetch_assoc()) {
//                                if($cont == 70){
//                                    $tabla['t_'.$cont] = array("t_1" => generadorNegritas("Invitados"), "t_2" => $row_pi['per_apellido']." ".$row_pi['per_nombre']);
//                                }else{
//                                    $tabla['t_'.$cont] = array("t_1" => "", "t_2" => $row_pi['per_apellido']." ".$row_pi['per_nombre']);
//                                }
//                                $cont=$cont + 1;
//                            }
//                        }
//                        $tabla['t_81'] = array("t_1" => generadorNegritas("Descripción"), "t_2" => $row['eve_descripcion']);
//                        
//                        $resultado = str_replace("{contenedor_1}", generadorTabla_2($tabla, "table-striped"), getPage('page_detalle_evento')); 
//                        $data = array("success" => "true", 
//                            "contenido"=> $resultado);  
//                       echo json_encode($data);
//
//                    }else{
//                        $data = array("success" => "true", "contenido"=> "<h1>No hay datos!</h1>");  
//                        echo json_encode($data);
//                    }
//                        
//                }
//                break;

               
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}    
     exit(); 
}






