<?php

function generadorMiniVentanasCheck($titulo, $icono,$idFiltro,$funcion, $arrayFiltro, $arrayOpcion, $arrayPermiso) {
$html='';   
$html.='<div class="col-md-12">';
$html.='<div class=" ">';
$html.='<div class="box-body">';
$html.='<div class="form-group">'; 
$html.='<label for="" class="col-sm-3 control-label"><h4 class="box-title">Filtre por Perfiles</h4></label>'; 
$html.='<div class="col-sm-9">';     
$html.='<select id="'.$idFiltro.'" onChange="'.$funcion.'" class="form-control select2">'; 
 foreach ($arrayFiltro as $option => $val) {
     $html.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
 }           
$html.=' </select>';          
$html.=' </div>'; 
$html.='</div>';
$html.='</div>';   
$html.='</div>';
$html.='</div>';


$html.='<div class="row">';
foreach ($arrayOpcion as $valores => $valor) {
    
    $html.='<div class="col-md-4" style="height: 325px;">';
    $html.='<div class="box box-info">';
    $html.='<div class="box-header with-border">';
    $html.='<h3 class="box-title">'.$valor['opcion'].'</h3>';
    $html.='</div>';
    $html.='<div class="box-body">';
    $html.='<div class="form-group">';
    foreach ($arrayPermiso as $permisos => $permiso) {
        if($permiso['opcion']==$valor['opcion']){      
            $html.='<div class="checkbox">';
            $html.='<label><input type="checkbox" id="'.$permiso['id_checked'].'" '.$permiso['checked'].' onclick="'.$permiso['funcion'].'">'.$permiso['permiso'].'</label>';
            $html.='</div>';
        }
         
    }
  
    $html.='</div>';
    $html.='</div>';   
    $html.='</div>';
    $html.='</div>';
   
}
 $html.='</div>';
return $html;
}


function generadorRow($titulo, $boton, $contenido) {
$html='';  
$html.='<br>';
$html.='<div class="row">';
 $html.='<div class="col-xs-12">';
      $html.='<h2 class="page-header">';
         $html.='<i class=""></i>'.$titulo;
       $html.=$boton;
     $html.='</h2>';
     $html.=$contenido;

 $html.='</div>';

$html.='</div>';
return $html;
}

function generadorMenuColor1($titulo, $array= array()) {
$html='';
$html.='<div class="box box-solid">';
$html.='<div class="box-header with-border">';
$html.='<h4 class="box-title">'.$titulo.'</h4>';
$html.='</div>';
$html.='<div class="box-body">';  
foreach ($array as $option => $val) {
    $html.='<div class="external-event '.$val['texto_color'].'" id="'.$val['id'].'" name="'.$val['codigo_color'].'"  onclick="'.$val['funcion'].'">'.$val['texto'].'</div>';
}    
$html.='</div>';
$html.='</div>';
return $html;
}

function generadorMenuColor2($titulo, $xfunction) {
$html='';
$html.='<div class="box box-solid">';
$html.='<div class="box-header with-border">';
$html.='<h4 class="box-title">'.$titulo.'</h4>';
$html.='</div>';
$html.='<div class="box-body">';  
    $html.="<select id='month' class='form-control'>
    <option selected value=''>--Seleccione Mes--</option>
    <option value='01'>Enero</option>
    <option value='02'>Febrero</option>
    <option value='03'>Marzo</option>
    <option value='04'>Abril</option>
    <option value='05'>Mayo</option>
    <option value='06'>Junio</option>
    <option value='07'>Julio</option>
    <option value='08'>Agosto</option>
    <option value='09'>Septiembre</option>
    <option value='10'>Octubre</option>
    <option value='11'>Noviembre</option>
    <option value='12'>Diciembre</option>
    </select> ";    
	$html.='<p></p>';
    $html.='<div  id="excel_btn"><button class="external-event bg-blue" onclick="'.$xfunction.'" style="cursor:pointer;">Generar Reporte</button></div>';    
$html.='</div>';
$html.='</div>';
return $html;
}


function generadorMenuColor3($titulo, $xfunction) {
$html='';
$html.='<div class="box box-solid">';
$html.='<div class="box-header with-border">';
$html.='<h4 class="box-title">'.$titulo.'</h4>';
$html.='</div>';
$html.='<div class="box-body">';  
    $html.="<select id='month2' class='form-control'>
    <option selected value=''>--Seleccione Mes--</option>
    <option value='01'>Enero</option>
    <option value='02'>Febrero</option>
    <option value='03'>Marzo</option>
    <option value='04'>Abril</option>
    <option value='05'>Mayo</option>
    <option value='06'>Junio</option>
    <option value='07'>Julio</option>
    <option value='08'>Agosto</option>
    <option value='09'>Septiembre</option>
    <option value='10'>Octubre</option>
    <option value='11'>Noviembre</option>
    <option value='12'>Diciembre</option>
    </select> ";    
	$html.='<p></p>';
    $html.='<div  id="excel_btn2"><button class="external-event bg-blue" onclick="'.$xfunction.'" style="cursor:pointer;">Generar Reporte</button></div>';    
$html.='</div>';
$html.='</div>';
return $html;
}



function generadorEtiquetaVVertical($form=array()){        
 $msg='';  
    foreach ($form as $accion => $valor) {

           if($valor['elemento']=='combo'){
               $msg.='<div class="form-group">'; 
               $msg.='<label>'.$valor['titulo'].'</label>'; 
               $msg.='<select id="'.$valor['id'].'"  onChange="'.$valor['change'].'" class="form-control select2" style="width: 100%;">'; 
               if(count($valor['option']) > 0){
                    foreach ($valor['option'] as $option => $val) {
                        $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
                    } 
               }
               $msg.=' </select>';          

               $msg.='</div>';            
           } 
           if($valor['elemento']=='combo+name'){
               $msg.='<div class="form-group">'; 
               $msg.='<label>'.$valor['titulo'].'</label>'; 
               $msg.='<select id="'.$valor['id'].'" name="'.$valor['name'].'" onChange="'.$valor['change'].'" class="form-control select2" style="width: 100%;">'; 
               if(count($valor['option']) > 0){
                foreach ($valor['option'] as $option => $val) {
                    $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
                }   
               }
               $msg.=' </select>';          

               $msg.='</div>';            
           } 
           
           if($valor['elemento']=='caja'){//$disabled
                $msg.='<div class="form-group">'; 
                $msg.='<label>'.$valor['titulo'].'</label>'; 
            
                $msg.='<input type="'.$valor['tipo'].'"  class="form-control" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'" required="required" value="'.$valor['reemplazo'].'">'; 
               
                $msg.='</div>';            
            }
            if($valor['elemento']=='caja - oculta'){
                $msg.='<input type="hidden" id="'.$valor['id'].'" value="'.$valor['reemplazo'].'">'; 
                 
            }
            if($valor['elemento']=='lista-multiple'){
                   $msg.='<div class="form-group">';     
                   $msg.='<label>'.$valor['titulo'].'</label>';
                   $msg.='<select id="'.$valor['id'].'" class="form-control select2" multiple="multiple" data-placeholder="Seleccione..." style="width: 100%;">'; 
                   if(count($valor['option']) > 0){
                    foreach ($valor['option'] as $option => $val) {
                        $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
                    }      
                   }
                   $msg.=' </select>'; 
                   $msg.='</div>';            
               } 
    
     } 
    return $msg;
} 
function generadorEtiquetaVVertical2($form=array()){        
    $msg='<div class="modal-body" id="">';
    foreach ($form as $accion => $valor) {

           if($valor['elemento']=='combo'){
               $msg.='<div class="form-group">'; 
               $msg.='<label>'.$valor['titulo'].'</label>'; 
               $msg.='<select id="'.$valor['id'].'" '.$valor['disabled'].' onChange="'.$valor['change'].'" class="form-control select2" style="width: 100%;">'; 
               if(count($valor['option']) > 0){
                foreach ($valor['option'] as $option => $val) {
                    $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
                }           
               }
               $msg.=' </select>';          

               $msg.='</div>';            
           } 
           
           if($valor['elemento']=='caja'){//$disabled
                $msg.='<div class="form-group">'; 
                $msg.='<label>'.$valor['titulo'].'</label>'; 
            
                $msg.='<input type="'.$valor['tipo'].'" '.$valor['disabled'].' class="form-control" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'" required="required" value="'.$valor['reemplazo'].'">'; 
               
                $msg.='</div>';            
            }
            if($valor['elemento']=='caja - oculta'){
                $msg.='<input type="hidden" id="'.$valor['id'].'" value="'.$valor['reemplazo'].'">'; 
                 
            }
           
    
     } 
     $msg.='</div>';
    return $msg;
} 

function generadorAlertaEstatica($titulo,$subTitulo,$color) {
//    callout-info
//    callout-danger
//    callout-warning
//    callout-success
    $html='';
    //$html.='<div class="box-body">';
    $html.='<div class="callout callout-'.$color.'">';
    $html.='<h4>'.$titulo.'</h4>';
    $html.='<p>'.$subTitulo.'</p>';
    //$html.='</div>';  
    $html.='</div>';
    return $html;
    



}
function generadorAlertaDinamica($titulo, $subTitulo, $color ='info', $icono ='fa-info') {
//    callout-info
//    callout-danger
//    callout-warning
//    callout-success
    $html='';
    $html.='<div class="alert alert-'.$color.' alert-dismissible">';
    $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    $html.='<h4> <i class="icon fa '.$icono.'"></i>'.$titulo.'</h4>';
    $html.='<p>'.$subTitulo.'</p>';
    //$html.='</div>';  
    $html.='</div>';
    return $html;
    



}

                


function generadorModal($titulo,$idModal,$cuerpo, $botones) {
    $html='';
    $html.='<div class="modal fade" id="'.$idModal.'"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">';
    $html.='<div class="modal-dialog">';
        $html.='<div class="modal-content">';
            $html.='<div class="modal-header">';
                $html.='<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                $html.='<h4 class="modal-title" id="myModalLabel">'.$titulo.'</h4>';      
                $html.='</div>';
                $html.='<div class="modal-body" id="">';            
                    $html.='<div id="" class="form-medium">';

                    $html.=$cuerpo;

                    $html.='</div>';    
                $html.='</div>';
                $html.=$botones;
                //$html.='<div class="modal-footer">';
                //$html.='<button type="button" id="btnGuardarPresupuesto" class="btn btn-primary" data-dismiss="modal" onclick="setAgregarPresupuesto()">Guardar</button>';
            //$html.='</div>';
        $html.='</div>';
  $html.='</div>';
$html.='</div>';
    
return $html;
    



}


 function generadorBotonVModal($botones = array()) {
    $msg='';
    if(!empty($botones)){
        $msg.='<div class="modal-footer">';
            foreach ($botones as $boton => $val2) {
                $msg.='<button type="button" id="'.$val2['id'].'"  class="btn '.$val2['color'].'"  onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
            }        
        $msg.='</div>';
    }
    return $msg;
 }
  function generadorResaltador($color="success", $texto="") {
   
    return '<span class="label label-'.$color.'">'.$texto.'</span>';
 }
  function generadorContenedorColor($color="success", $texto="") {
   
    return '<div class="callout callout-'.$color.'" style="margin-bottom: 0!important;">'.$texto.' </div>';
 }

function generadorEtiquetaHorizontal($form=array()){ 
          
    $msg='';
    $msg.='<form class="form-horizontal">';
    $msg.='<div class="box-body">';
         foreach ($form as $accion => $valor) {
           
         
               if($valor['elemento']=='textarea'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div class="col-sm-9">'; 
                    $msg.='<textarea class="form-control" '.$valor['disabled'].' id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'"  value="'.$valor['reemplazo'].'"></textarea>'; 
                    $msg.=' </div>'; 
                    $msg.='</div>';            
               }
               
               if($valor['elemento']=='caja'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div class="col-sm-9">'; 
                    $msg.='<input type="'.$valor['tipo'].'" '.$valor['disabled'].' class="form-control" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'" required="required" value="'.$valor['reemplazo'].'">'; 
                    $msg.=' </div>'; 
                    $msg.='</div>';            
               }
               
                          
               if($valor['elemento']=='combo'){
                   $msg.='<div class="form-group">'; 
                   $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                   $msg.='<div class="col-sm-9">';     
                   $msg.='<select id="'.$valor['id'].'" '.$valor['disabled'].' onChange="'.$valor['change'].'" class="form-control select2" style="width: 100%;">'; 
                   if(count($valor['option']) > 0){
                    foreach ($valor['option'] as $option => $val) {
                        $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
                    }          
                   }
                   $msg.=' </select>';          
                   $msg.=' </div>'; 
                   $msg.='</div>';            
               } 
               if($valor['elemento']=='lista-multiple'){
                   $msg.='<div class="form-group">'; 
                   $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                   $msg.='<div class="col-sm-9">';     
                   $msg.='<select id="'.$valor['id'].'" '.$valor['disabled'].' class="form-control select2" multiple="multiple" data-placeholder="Seleccione..." style="width: 100%;">'; 
                   if(count($valor['option']) > 0){
                    foreach ($valor['option'] as $option => $val) {
                        $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
                    }      
                   }
                   $msg.=' </select>';          
                   $msg.=' </div>'; 
                   $msg.='</div>';            
               }    
               
              if($valor['elemento']=='combo + boton'){
                   $msg.='<div class="form-group">'; 
                   $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                   $msg.='<div class="col-sm-7">';     
                   $msg.='<select id="'.$valor['id'].'" '.$valor['disabled'].' onChange="'.$valor['change'].'" class="form-control select2" style="width: 100%;">'; 
                   if(count($valor['option']) > 0){
                    foreach ($valor['option'] as $option => $val) {
                        $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
                    } 
                   }
                   $msg.=' </select>';          
                   $msg.=' </div>';
                    $msg.='<div class="col-sm-2">'; 
                        $msg.=' <span class="input-group-btn"><button type="button" data-toggle="modal" data-target="'.$valor['modal'].'" class="btn '.$valor['boton_tipo'].' btn-flat" title="'.$valor['boton_title'].'" onclick="'.$valor['boton_click'].'"><i class="'.$valor['boton_icono'].'"></i>'.$valor['boton_nombre'].'</button></span>';
                        
                    $msg.=' </div>'; 
                   $msg.='</div>'; 
              }
              if($valor['elemento']=='lista + boton'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div id="contenedor_lista" class="col-sm-7">'; 
                    $msg.='<select multiple id="'.$valor['id_list'].'" class="form-control select2" data-placeholder="Seleccionar..." onChange="'.$valor['change'].'" '.$valor['disabled'].' style="width: 100%;">'; 
                        foreach ($valor['option_list'] as $option => $val) {
                            $msg.='<option value="'.$val['value_list'].'" '.$val['select_list'].'>'.$val['texto_list'].'</option>';
                        }           
                    $msg.=' </select>'; 
                    $msg.=' </div>';
                    $msg.='<div class="col-sm-2">'; 
                        $msg.=' <span class="input-group-btn"><button type="button" data-toggle="modal" data-target="'.$valor['modal'].'" class="btn '.$valor['boton_tipo'].' btn-flat" title="'.$valor['boton_title'].'" onclick="'.$valor['boton_click'].'"><i class="'.$valor['boton_icono'].'"></i>'.$valor['boton_nombre'].'</button></span>';
                        
                    $msg.=' </div>'; 
                     
                    $msg.='</div>';            
               }
         }  
        $msg.='</div>';
        $msg.='</form>';
        return $msg;
    }   

function generadorTablaTranparente($tab=array()){   
    $msg='';
     $msg.='<div class="row">';
        $msg.='<div class="col-xs-12 table-responsive">';
          $msg.='<table style="table-layout:fixed"; class="table">';
              foreach ($tab as $accion => $valor) {
                      $msg.='<tr>';       
                        $msg.='<td >'.$valor['t_1'].'</td> ';             
                        $msg.='<td >'.$valor['t_2'].'</td>';
                      $msg.='</tr>';    
            } 
          $msg.='</table>';
        $msg.='</div>';
      $msg.='</div>'; 
    return $msg;
} 


         
function generadorBotonMenu($botones = array(), $color, $titulo) {
    $msg='';
    $msg.='';
     $msg.='<div class="btn-group">';
     $msg.='<button type="button" class="btn '.$color.' btn-sm dropdown-toggle" data-toggle="dropdown">';
      $msg.='<i class="fa fa-bars"></i>&nbsp;&nbsp;'.$titulo.'</button>';
      $msg.='<ul class="dropdown-menu pull-right" role="menu">';
        foreach ($botones as $boton => $val2) {
            $msg.='<li><a type="button" data-toggle="modal" data-target="'.$val2['modal'].'"  onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</a></li>';
        }
      $msg.='</ul>';
    $msg.='</div>';
    return $msg;
}