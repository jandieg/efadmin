<?php   
 function generadorTablaFilas($columnas=array()){
    $t='<tr>'; 
    foreach($columnas as $valor){
        $t.= '<th>'.$valor.'</th>';
    }
    $t.= '</tr>';
    return $t ;
}

function generadorTablaFilasGrupos($columnas=array()){
    $t='<tr>'; 
    $i = 0;
    foreach($columnas as $valor){
        if ($i=0) {
            $t.= '<th style="width: 10%;">'.$valor.'</th>';
        } else {
            $t.= '<th>'.$valor.'</th>';
        }
        $i++;
        
    }
    $t.= '</tr>';
    return $t ;
}


function generadorTabla_($tipo, $titulo,$funcion='', $columnas=array(), $filas){
    $t='<div class="box box-info">';
    $t.='<div class="box-header">';
    $t.='<h3 class="box-title">'.$titulo. '</h3>';
	$custom_js="export_to_excel('".$titulo."');return false;";
    if($funcion != ''){
    $t.='<div class="box-tools pull-right"> '
            . '<button type="submit" title="Nuevo" class="btn btn-info pull-right" onclick="'.$funcion.'"> <i class="fa fa-plus"></i></button> '
            . '<div id="excel" style="float:left;"><button type="submit" title="Exportar" class="btn btn-info pull-right" onclick="'.$custom_js.'"> Exportar Datos </button> </div>'
            . '</div>';
    }
    $t.='</div>';
	//fa-file-excel-o
    if($tipo==1){
        $tipoDatatable='tipo_personalizada';
    }  else {
        $tipoDatatable='normal';
    }
    $t.='<div class="box-body">';  
    $t.='<table id="'.$tipoDatatable.'" class="table table-bordered table-striped">';
    ////////////////////////////////////////////////////////////////////////////
    $t.='<thead><tr>'; 
    foreach($columnas as $valor){
        $t.= '<th>'.$valor.'</th>';
    }
    $t.= '</tr></thead>';
    $t.='<tbody>';
    $t.=$filas;
    $t.=' </tbody>';
    $t.='</tr></thead>';  
    $t.='<tbody>';
    $t.=' </table>';
    $t.='</div>';
    $t.='</div>';
    return $t ;
}
function generadorTablaModal($tipo, $titulo,$funcion='', $columnas=array(), $filas){
    $t='';
    
    if($tipo==1){
        $tipoDatatable='tipo_personalizada';
    }  else {
        $tipoDatatable='normal';
    }
    
    $t.='<div class="box-body">';  
    $t.='<table id="'.$tipoDatatable.'" class="table table-bordered table-striped">';
    ////////////////////////////////////////////////////////////////////////////
    $t.='<thead><tr>'; 
    foreach($columnas as $valor){
        $t.= '<th>'.$valor.'</th>';
    }
    $t.= '</tr></thead>';
    $t.='<tbody>';
    $t.=$filas;
    $t.=' </tbody>';
    $t.='</tr></thead>';  
    $t.='<tbody>';
    $t.=' </table>';
    $t.='</div>';
 
    return $t ;
}

function cargarImagen($src) {
    $msg="";
    $msg.='
    <div class="form-group">
        
            <div class="col-sm-5">
                <div id="targetLayer"><img src="'.$src.'" id="foto" height="90" alt="FOTO..."></div>
            </div>
        
    </div>
     ';

     return $msg;
}

function getFormImagen() {
    $msg = "";
   
    $msg .= '
            <div class="col-sm-3">
            <div id="targetLayer"><img src="" id="foto" height="90" alt="FOTO..."></div>
            </div>
            <div class="col-sm-9">
        <form id="uploadForm" action="" method="post" enctype="multipart/form-data">                        
            <div id="uploadFormLayer">
            <input name="codigo" id="el_codigo" type="hidden" />
            <input name="userImage" type="file" id="archivo" class="inputFile" /><br/>
            </div>
        </form>
        <div class="btn btn-primary" onClick="subirFoto()">Cargar Foto</div>
        
        </div>            
    ';
    return $msg;
}

function generadorTablaConBotones($tipo, $titulo,$funcion='', $columnas=array(), $filas,$botones=array()){
    $t='<div class="box box-info">';
    $t.='<div class="box-header">';
    $t.='<h3 class="box-title">'.$titulo. '</h3>';
    if($funcion != ''){
    $t.='<div class="box-tools pull-right">';
     foreach ($botones as $boton => $val2) {
           $t.='&nbsp;&nbsp;<button type="button"  class="btn '.$val2['color'].' " onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
       
           }
        $t.='</div>';
    }
    
    $t.='</div>';
    if($tipo==1){
        $tipoDatatable='tipo_personalizada';
    }  else {
        $tipoDatatable='normal';
    }
    $t.='<div class="box-body">';  
    $t.='<table id="'.$tipoDatatable.'" class="table table-bordered table-striped">';
    ////////////////////////////////////////////////////////////////////////////
    $t.='<thead><tr>'; 
    foreach($columnas as $valor){
        $t.= '<th>'.$valor.'</th>';
    }
    $t.= '</tr></thead>';
    $t.='<tbody>';
    $t.=$filas;
    $t.=' </tbody>';
    $t.='</tr></thead>';  
    $t.='<tbody>';
    $t.=' </table>';
    $t.='</div>';
    $t.='</div>';
    return $t ;
}

function generadorTablaConBotonesMiembros($tipo, $titulo,$funcion='', $columnas=array(), $filas,$botones=array(), $checkcancel){
    $t='<div class="box box-info">';
    $t.='<div class="box-header">';
    $t.='<h3 class="box-title">'.$titulo. '</h3>';
    
    
    if($tipo==1){
        $tipoDatatable='tipo_personalizada';
    }  else {
        $tipoDatatable='normal';
    }
    $t.='<div class="box-body">';  
    $t.='<table id="'.$tipoDatatable.'" class="table table-bordered table-striped">';
    ////////////////////////////////////////////////////////////////////////////
    $t.='<thead><tr>'; 
    foreach($columnas as $valor){
        $t.= '<th>'.$valor.'</th>';
    }
    $t.= '</tr></thead>';
    $t.='<tbody>';
    $t.=$filas;
    $t.=' </tbody>';
    $t.='</tr></thead>';  
    $t.='<tbody>';
    $t.=' </table>';
    $t.='</div>';
    $t.='</div>';
    return $t ;
}
function generadorTablaConBotones2($tipo, $titulo,$funcion='', $columnas=array(), $filas,$botones=array()){
    $t='<div class="box box-info">';
    $t.='<div class="box-header">';
    $t.='<h3 class="box-title">'.$titulo. '</h3>';
    if($funcion != ''){
    $t.='<div class="box-tools pull-right">';
     foreach ($botones as $boton => $val2) {
           $t.='&nbsp;&nbsp;<button type="button"  class="btn '.$val2['color'].' " onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
       
           }
        $t.='</div>';
    }
    
    $t.='</div>';
    if($tipo==1){
        $tipoDatatable='tipo_personalizada2';
    }  else {
        $tipoDatatable='normal';
    }
    $t.='<div class="box-body">';  
    $t.='<table id="'.$tipoDatatable.'" class="table table-bordered table-striped">';
    ////////////////////////////////////////////////////////////////////////////
    $t.='<thead><tr>'; 
    foreach($columnas as $valor){
        $t.= '<th>'.$valor.'</th>';
    }
    $t.= '</tr></thead>';
    $t.='<tbody>';
    $t.=$filas;
    $t.=' </tbody>';
    $t.='</tr></thead>';  
    $t.='<tbody>';
    $t.=' </table>';
    $t.='</div>';
    $t.='</div>';
    return $t ;
}

function generadorTablaConBotones_Grupos($tipo, $titulo,$funcion='', $columnas=array(), $filas,$botones=array()){
    $t='<div class="box box-info">';
    $t.='<div class="box-header">';
    $t.='<h3 class="box-title">'.$titulo. '</h3>';
    if($funcion != ''){
    $t.='<div class="box-tools pull-right">';
     foreach ($botones as $boton => $val2) {
           $t.='&nbsp;&nbsp;<button type="button"  data-toggle="modal" data-target="'.$val2['modal'].'" class="btn '.$val2['color'].' " onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
        //$msg.='&nbsp;&nbsp;<button type="button" data-toggle="modal" data-target="'.$val2['modal'].'" class="btn '.$val2['color'].' btn-sm" onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
           }
        $t.='</div>';
    }
    
    $i=0;
    
    
    $t.='</div>';
    if($tipo==1){
        $tipoDatatable='tipo_personalizada';
    }  else {
        $tipoDatatable='normal';
    }
    $t.='<div class="box-body">';  
    $t.='<table id="'.$tipoDatatable.'" class="table table-bordered table-striped">';
    ////////////////////////////////////////////////////////////////////////////
    $t.='<thead><tr>'; 
    foreach($columnas as $valor){
        if ($i==0) {
            $t.= '<th style="width: 10%;">'.$valor.'</th>';
        } else {
            $t.= '<th>'.$valor.'</th>';
        }
        $i++;
        
    }
    $t.= '</tr></thead>';
    $t.='<tbody>';
    $t.=$filas;
    $t.=' </tbody>';
    $t.='</tr></thead>';  
    $t.='<tbody>';
    $t.=' </table>';
    $t.='</div>';
    $t.='</div>';
    return $t ;
}



function generadorTablaConBotones_($tipo, $titulo,$funcion='', $columnas=array(), $filas,$botones=array()){
    $t='<div class="box box-info">';
    $t.='<div class="box-header">';
    $t.='<h3 class="box-title">'.$titulo. '</h3>';
    if($funcion != ''){
    $t.='<div class="box-tools pull-right">';
     foreach ($botones as $boton => $val2) {
           $t.='&nbsp;&nbsp;<button type="button"  data-toggle="modal" data-target="'.$val2['modal'].'" class="btn '.$val2['color'].' " onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
        //$msg.='&nbsp;&nbsp;<button type="button" data-toggle="modal" data-target="'.$val2['modal'].'" class="btn '.$val2['color'].' btn-sm" onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
           }
        $t.='</div>';
    }
    
    
    
    $t.='</div>';
    if($tipo==1){
        $tipoDatatable='tipo_personalizada';
    }  else {
        $tipoDatatable='normal';
    }
    $t.='<div class="box-body">';  
    $t.='<table id="'.$tipoDatatable.'" class="table table-bordered table-striped">';
    ////////////////////////////////////////////////////////////////////////////
    $t.='<thead><tr>'; 
    foreach($columnas as $valor){
        $t.= '<th>'.$valor.'</th>';
    }
    $t.= '</tr></thead>';
    $t.='<tbody>';
    $t.=$filas;
    $t.=' </tbody>';
    $t.='</tr></thead>';  
    $t.='<tbody>';
    $t.=' </table>';
    $t.='</div>';
    $t.='</div>';
    return $t ;
}



function generadorTabla($tipo, $titulo, $columnas=array(), $filas){
    $t='<div class="box box-info">';
    $t.='<div class="box-header"><h3 class="box-title">';
    $t.=$titulo;
    $t.='</h3></div>';
    if($tipo==1){
        $tipoDatatable='tipo_personalizada';
    }  else {
        $tipoDatatable='normal';
    }
    $t.='<div class="box-body">';  
    $t.='<table id="'.$tipoDatatable.'" class="table table-bordered table-striped">';
    ////////////////////////////////////////////////////////////////////////////
    $t.='<thead><tr>'; 
    foreach($columnas as $valor){
        $t.= '<th>'.$valor.'</th>';
    }
    $t.= '</tr></thead>';
    $t.='<tbody>';
    $t.=$filas;
    $t.=' </tbody>';
    $t.='</tr></thead>';  
    $t.='<tbody>';
    $t.=' </table>';
    $t.='</div>';
    $t.='</div>';
    return $t ;
}


function generadorTablaAcciones($acciones=array()){
            if(count($acciones)>0){
                // OPCIONES O FUNCIONALIDADES POR FILA
                $tabla = "";
                foreach ($acciones as $accion => $valor) {
                    $attrSpan = array();
                    if(array_key_exists('modal', $valor)){ $attrSpan['aria-hidden'] = "true"; $attrSpan['data-toggle'] = "modal"; $attrSpan['data-target'] = "#".$valor['modal']; }
                    if(array_key_exists('tooltip', $valor)){ 
                        $attrSpan['title'] = (array_key_exists('titulo', $valor['tooltip'])? $valor['tooltip']['titulo'] : $accion);
                        $attrSpan['data-placement'] = (array_key_exists('posicion', $valor['tooltip'])? $valor['tooltip']['posicion'] : 'top'); 
                    }else{ 
                        $attrSpan['title'] = $accion;
                        $attrSpan['data-placement'] = 'top';
                    }
                    $attrSpan['class'] = "glyphicon glyphicon-".(array_key_exists('icono', $valor)? ($valor['icono']!=''? $valor['icono'] : 'edit' ) : 'edit' )." cursorlink";
                    $attrSpan['onclick'] = (array_key_exists('funcion', $valor)? $valor['funcion'] : "");
                    $attrSpan['style'] = 'cursor:pointer;';

                    $tabla .= span('&nbsp;', $attrSpan);
                }
      
            }
   
        return $tabla;
    }
    
    function span($contenido='', $atributos=array()){
        $attr = "";
        foreach($atributos as $atributo => $valor){
            $attr .= $atributo . "='" . $valor . "' ";
        }
        return "<span $attr>$contenido</span>";
    }
    function generadorLink($mensaje, $funcion){
        
        return '<a href="javascript:void(0)" onclick="'.$funcion.'"> '.$mensaje.'</a>';
    }
                                   
    /*
      
     */                            

    function generadorAlertaOperacion($tipoAlerta, $m){
        $msg='';
        $msg.='<div class="alert '.$tipoAlerta.' alert-dismissible" role="alert">';
        $msg.='<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        $msg.='<strong>Alerta! </strong>'. $m .'</div>'; 
        return $msg;
    }
    
 ///////////////////////////////////////////////////////////////////////////////
 function generadorTabVertical($tab=array()){ 
        $msg='';
        $msg.='<div class="nav-tabs-custom">'; 
         $msg.='<div class="col-xs-3">'; 
        $msg.='<ul class="nav nav-tabs tabs-left">';
        $bandera= TRUE;
         foreach ($tab as $accion => $valor) {
             if($bandera){
                  $msg.='<li class="active"><a href="#'.$valor['id'].'" data-toggle="tab">'.$valor['titulo'].'</a></li>'; 
             }  else {
                  $msg.='<li class=""><a href="#'.$valor['id'].'" data-toggle="tab">'.$valor['titulo'].'</a></li>'; 
             }
             $bandera= FALSE;
            
         }
        
        $msg.='</ul>'; 
        $msg.='</div>';
        $msg.='<div class="col-xs-9">';
        $msg.='<div class="tab-content">'; 
        $bandera= TRUE;
        foreach ($tab as $accion => $valor) {
             if($bandera){
                    $msg.='<div class="active tab-pane" id="'.$valor['id'].'">'; 
                    $msg.='<div>' .$valor['reemplazo'].'</div>'; 
                    $msg.='</div>';
             }  else {
                    $msg.='<div class="tab-pane" id="'.$valor['id'].'">'; 
                    $msg.='<div>' .$valor['reemplazo'].'</div>'; 
                    $msg.='</div>';
             }
             $bandera= FALSE;
           
         }
        $msg.='</div>';
        $msg.='</div>';
        $msg.='</div>';
        return $msg;
    }
 function generadorTab($tab=array()){ 
        $msg='';
        $msg.='<div class="nav-tabs-custom">'; 
        $msg.='<ul class="nav nav-tabs">';
        $bandera= TRUE;
         foreach ($tab as $accion => $valor) {
             if($bandera){
                  $msg.='<li class="active"><a href="#'.$valor['id'].'" data-toggle="tab">'.$valor['titulo'].'</a></li>'; 
             }  else {
                  $msg.='<li class=""><a href="#'.$valor['id'].'" data-toggle="tab">'.$valor['titulo'].'</a></li>'; 
             }
             $bandera= FALSE;
            
         }
        
        $msg.='</ul>'; 
        $msg.='<div class="tab-content">'; 
        $bandera= TRUE;
        foreach ($tab as $accion => $valor) {
             if($bandera){
                    $msg.='<div class="active tab-pane" id="'.$valor['id'].'">'; 
                    $msg.='<div>' .$valor['reemplazo'].'</div>'; 
                    $msg.='</div>';
             }  else {
                    $msg.='<div class="tab-pane" id="'.$valor['id'].'">'; 
                    $msg.='<div>' .$valor['reemplazo'].'</div>'; 
                    $msg.='</div>';
             }
             $bandera= FALSE;
           
         }
  
        $msg.='</div>';
        $msg.='</div>';
        return $msg;
    }
    

              
             
                  
             
            
                
function generadorFormularios($id_oculto = '', $valor_oculto= '', $tab=array(), $botones=array(), $cabecera=array()){ 
          
    $msg='';
    if(count($cabecera)> 0){
        
    
         foreach ($cabecera as $cab => $valor) {
            $msg.='<div class="box '.$valor['color'].'">'; 
            $msg.='<div class="box-header with-border">'; 
            $msg.='<h3 class="box-title">'.$valor['titulo'].'</h3>'; 
            $msg.='<div class="box-tools pull-right">'; 
            $msg.='<input type="text" style="visibility:hidden;" class="" id="'.$valor['id_oculto'].'" value="'.$valor['valor_oculto'].'">'; 
            $msg.='</div>';
            $msg.='</div>';   
         }
 }
        $msg.='<form class="form-horizontal">'; 
        $msg.='<div class="box-body">';
        
        if($id_oculto != ''){
            $msg.='<input type="hidden" class="" id="'.$id_oculto.'" value="'.$valor_oculto.'">'; 
        }
  
         foreach ($tab as $accion => $valor) {
              if($valor['elemento']=='lista'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div class="col-sm-9">'; 
                            $msg.='<ul class="list-group ">';
                            foreach ($valor['contenido'] as $l => $val) {
                               $msg.='<li class="list-group-item">';
                               $msg.='<div class="input-group input-group-sm">';
                               $msg.='<div class="col-md-12">'
                                       . '<input type="'.$val['tipo'].'" class="form-control" id="'.$val['id'].'" placeholder="'.$val['titulo'].'"  value="'.$val['reemplazo'].'">'
                                       . '</div>';
                               $msg.=' <span class="input-group-btn"><button type="button" class="btn btn-danger btn-flat" onclick="'.$val['click'].'"><i class="fa fa-times"></i></button></span>&nbsp;';
                                $msg.='<span class="input-group-btn"><button type="button" class="btn btn-danger btn-flat" onclick="'.$val['click'].'"><i class="fa fa-times"></i></button></span>';
                               $msg.='</div>';
                               $msg.='</li>';
                             }
                            $msg.='</ul>';
                    $msg.=' </div>';
                    $msg.='</div>';            
               }
               
               if($valor['elemento']=='Checkbox-color'){
   
                    $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label"></label>'; 
                    $msg.='<div class="col-sm-9">'; 
                    $msg.='<div class="checkbox">'; 
                    $msg.='<label>'; 
                    $msg.='<input type="checkbox" id="'.$valor['id'].'" class="flat-red">'; 
                    $msg.=$valor['titulo']; 
                    $msg.='</label>';
                    $msg.=' </div>'; 
                    $msg.=' </div>';
                    $msg.='</div>'; 
               }
                
               
               
               
               if($valor['elemento']=='caja'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div class="col-sm-9">'; 
                    $msg.='<input type="'.$valor['tipo'].'" class="form-control" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'" required="required" value="'.$valor['reemplazo'].'">'; 
                    $msg.=' </div>'; 
                    $msg.='</div>';            
               }
                if($valor['elemento']=='caja + boton'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div class="col-sm-7">'; 
                    $msg.='<input type="'.$valor['tipo'].'" class="form-control" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'" required="required" value="'.$valor['reemplazo'].'">'; 
                    $msg.=' </div>'; 
                    
                    $msg.='<div class="col-sm-2">'; 
                        $msg.=' <span class="input-group-btn"><button type="button" class="btn '.$valor['boton_tipo'].' btn-flat" title="Actualizar" onclick="'.$valor['boton_click'].'"><i class="'.$valor['boton_icono'].'"></i>'.$valor['boton_nombre'].'</button></span>';
                    
                    $msg.=' </div>'; 
                     
                    $msg.='</div>';            
               }
               if($valor['elemento']=='caja pequeña'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div class="col-sm-7">'; 
                    $msg.='<input type="'.$valor['tipo'].'" class="form-control" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'" required="required" value="'.$valor['reemplazo'].'">'; 
                    $msg.=' </div>'; 
             
                     
                    $msg.='</div>';            
               }
               if($valor['elemento']=='combo'){
                   $msg.='<div class="form-group">'; 
                   $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                   $msg.='<div class="col-sm-9">';     
                   $msg.='<select id="'.$valor['id'].'" class="form-control select2">'; 
                   if(count($valor['option']) > 0){
                    foreach ($valor['option'] as $option => $val) {
                        $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
                    }   
                   }
                   $msg.=' </select>';          
                   $msg.=' </div>'; 
                   $msg.='</div>';            
               } 
               if($valor['elemento']=='combo-select2'){
                   $msg.='<div class="form-group">'; 
                   $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                   $msg.='<div class="col-sm-9">';     
                   $msg.='<select id="'.$valor['id'].'" class="form-control select2" style="width: 100%;">'; 
                   if(count($valor['option']) > 0){
                    foreach ($valor['option'] as $option => $val) {
                        $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
                    }    
                   }
                   $msg.=' </select>';          
                   $msg.=' </div>'; 
                   $msg.='</div>';            
               } 
         }  

           
        $msg.='<div class="box-footer">';
         foreach ($botones as $boton => $val2) {
             if($val2['lado']!='pull-right'){
                 $msg.='<button type="button" class="btn btn-primary '.$val2['lado'].'" onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
             }
             
        }
        $msg.='<div class="box-tools pull-right">';
        foreach ($botones as $boton => $val2) {
             if($val2['lado']=='pull-right'){
                 $msg.='&nbsp;<button type="button" class="btn btn-primary " onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
 
             }
            
        }
        $msg.='</div>'; 
        $msg.='</div>';
                   
        $msg.='</div>';
        $msg.='</form>';
        if(count($cabecera)> 0){
            $msg.='</div>';
        }
        return $msg;
    }   


function generadorEtiqueta($tab=array()){ 
          
    $msg='';
    $msg.='<form class="form-horizontal">';
    $msg.='<div class="box-body">';
         foreach ($tab as $accion => $valor) {
           
               
               if($valor['elemento']=='Checkbox-color'){
   
                    $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label"></label>'; 
                    $msg.='<div class="col-sm-9">'; 
                    $msg.='<div class="checkbox">'; 
                    $msg.='<label>'; 
                    $msg.='<input type="checkbox" '.$valor['chec'].' id="'.$valor['id'].'" class="flat-red">'; 
                    $msg.=$valor['titulo']; 
                    $msg.='</label>';
                    $msg.=' </div>'; 
                    $msg.=' </div>';
                    $msg.='</div>'; 
               }

               if($valor['elemento']=='subir-imagen'){
                    $msg.='<div class="form-group">'; 
                    $msg.=getFormImagen(); 
                    $msg.="</div>";
               }

               if($valor['elemento']=='Checkbox-comun'){
   
                    $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label"></label>'; 
                    $msg.='<div class="col-sm-9">'; 
                    $msg.='<div class="checkbox">'; 
                    $msg.='<label>'; 
                    $msg.='<input type="checkbox" '.$valor['chec'].' id="'.$valor['id'].'" >'; 
                    $msg.=$valor['titulo']; 
                    $msg.='</label>';
                    $msg.=' </div>'; 
                    $msg.=' </div>';
                    $msg.='</div>'; 
               }
                
               if($valor['elemento']=='fecha + tiempo'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo_date'].'</label>'; 
                    $msg.='<div class="col-sm-6">'; 
                    $msg.='<input type="'.$valor['tipo_date'].'" class="form-control " id="'.$valor['id_date'].'" placeholder="'.$valor['titulo_date'].'" required="required" value="'.$valor['reemplazo_date'].'">'; 
                    $msg.=' </div>'; 
                    $msg.='<div class="col-sm-3">'; 
                    $msg.='<input type="'.$valor['tipo_time'].'" class="form-control " id="'.$valor['id_time'].'" placeholder="'.$valor['titulo_time'].'" required="required" value="'.$valor['reemplazo_time'].'">'; 
                    $msg.=' </div>'; 
                    $msg.='</div>';            
               }
			   
               if($valor['elemento']=='caja pequeña + caja'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div class="col-sm-3">'; 
                    $msg.='<input type="'.$valor['tipo_1'].'" '.$valor['disabled_1'].'  class="form-control " id="'.$valor['id_1'].'" placeholder="'.$valor['titulo_1'].'" required="required" value="'.$valor['reemplazo_1'].'">'; 
                    $msg.=' </div>'; 
                    $msg.='<div class="col-sm-6">'; 
                    $msg.='<input type="'.$valor['tipo_2'].'" '.$valor['disabled_2'].' class="form-control " id="'.$valor['id_2'].'" placeholder="'.$valor['titulo_2'].'" required="required" value="'.$valor['reemplazo_2'].'">'; 
                    $msg.=' </div>'; 
                    $msg.='</div>';            
               }
			   
			   if($valor['elemento']=='smallcode'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div class="col-sm-2">'; 
                    $msg.='<input type="'.$valor['tipo_1'].'" '.$valor['disabled_1'].'  class="form-control " id="'.$valor['id_1'].'" placeholder="'.$valor['titulo_1'].'" required="required" value="'.$valor['reemplazo_1'].'">'; 
                    $msg.=' </div>'; 
                    $msg.='<div class="col-sm-2">'; 
                    $msg.='<input type="'.$valor['tipo_2'].'" '.$valor['disabled_2'].' class="form-control " id="'.$valor['id_2'].'" placeholder="'.$valor['titulo_2'].'" required="required" value="'.$valor['reemplazo_2'].'">'; 
                    $msg.=' </div>'; 
                    $msg.='<div class="col-sm-2">'; 
                    $msg.='<input type="'.$valor['tipo_3'].'" '.$valor['disabled_3'].' class="form-control " id="'.$valor['id_3'].'" placeholder="'.$valor['titulo_3'].'" required="required" value="'.$valor['reemplazo_3'].'">'; 
                    $msg.=' </div>'; 
                    $msg.='<div class="col-sm-2">'; 
                    $msg.='<input type="'.$valor['tipo_4'].'" '.$valor['disabled_4'].' class="form-control " id="'.$valor['id_4'].'" placeholder="'.$valor['titulo_4'].'" required="required" value="'.$valor['reemplazo_4'].'">'; 
                    $msg.=' </div>'; 
                    $msg.='</div>';            
               }
//                <div class="form-group">
//                  <label>Textarea</label>
//                  <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
//                </div>
               if($valor['elemento']=='textarea'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div class="col-sm-9">'; 
                    $msg.='<textarea class="form-control" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'"  value="">'.$valor['reemplazo'].'</textarea>'; 
                    $msg.=' </div>'; 
                    $msg.='</div>';            
               }
               
               if($valor['elemento']=='caja'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div class="col-sm-9">'; 
                    $msg.='<input type="'.$valor['tipo'].'" class="form-control" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'" required="required" value="'.$valor['reemplazo'].'">'; 
                    $msg.=' </div>'; 
                    $msg.='</div>';            
               }
			   
			    if($valor['elemento']=='disabled'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div class="col-sm-9">'; 
                    $msg.='<input type="'.$valor['tipo'].'" class="form-control" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'" required="required" value="'.$valor['reemplazo'].'" disabled="disabled">'; 
                    $msg.=' </div>'; 
                    $msg.='</div>';            
               }

               if($valor['elemento']=='readonly'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div class="col-sm-9">'; 
                    $msg.='<input type="'.$valor['tipo'].'" class="form-control" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'" required="required" value="'.$valor['reemplazo'].'" readonly="true">'; 
                    $msg.=' </div>'; 
                    $msg.='</div>';            
               }
			   
			   
                if($valor['elemento']=='caja + boton'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div class="col-sm-7">'; 
                    $msg.='<input type="'.$valor['tipo'].'" class="form-control" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'" required="required" value="'.$valor['reemplazo'].'">'; 
                    $msg.=' </div>';     
                    $msg.='<div class="col-sm-2">'; 
                    $msg.=' <span class="input-group-btn"><button type="button" data-toggle="modal" data-target="'.$valor['modal'].'" class="btn '.$valor['boton_tipo'].' btn-flat" title="Buscar" onclick="'.$valor['boton_click'].'"><i class="'.$valor['boton_icono'].'"></i>'.$valor['boton_nombre'].'</button></span>';   
                    $msg.=' </div>'; 
                     
                    $msg.='</div>';            
               } 
               
               if($valor['elemento']=='combo + boton'){
                   $msg.='<div class="form-group">'; 
                   $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                   $msg.='<div class="col-sm-7">';     
                   $msg.='<select id="'.$valor['id'].'" onChange="'.$valor['change'].'" class="form-control select2" style="width: 100%;">'; 
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
               
               
               if($valor['elemento']=='combo + caja + boton'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div id="contenedor_lista" class="col-sm-7">'; 
                    $msg.='<select multiple id="'.$valor['id_list'].'" class="form-control select2" data-placeholder="Seleccionar..." onChange="'.$valor['change'].'" '.$valor['disabled'].'>'; 
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
               

               
               if($valor['elemento']=='caja pequeña'){
                   $msg.='<div class="form-group">'; 
                    $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                    $msg.='<div class="col-sm-7">'; 
                    $msg.='<input type="'.$valor['tipo'].'" class="form-control" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'" required="required" value="'.$valor['reemplazo'].'">'; 
                    $msg.=' </div>'; 
             
                     
                    $msg.='</div>';            
               }

                if($valor['elemento']=='combo normal'){
                   $msg.='<div class="form-group">'; 
                   $msg.='<label for="" >'.$valor['titulo'].'</label>'; 
             
                   $msg.='<select id="'.$valor['id'].'" class="form-control">'; 
                   if(count($valor['option']) > 0){
                    foreach ($valor['option'] as $option => $val) {
                        $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
                    }    
                   }
                   $msg.=' </select>';          
                 
                   $msg.='</div>';            
               }         
                          
               if($valor['elemento']=='combo'){
                   $msg.='<div class="form-group">'; 
                   $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                   $msg.='<div class="col-sm-9">';  
                   if (isset($valor['deshabilitado'])) {                      
                        $msg.='<select id="'.$valor['id'].'" onChange="'.$valor['change'].'" disabled="true" class="form-control select2" style="width: 100%;">'; 
                   } else {
                        $msg.='<select id="'.$valor['id'].'" onChange="'.$valor['change'].'" class="form-control select2" style="width: 100%;">'; 
                   }
                   
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
                   $msg.='<select id="'.$valor['id'].'" class="form-control select2" multiple="multiple" data-placeholder="Seleccione..." style="width: 100%;">'; 
                   if(count($valor['option']) > 0){
                    foreach ($valor['option'] as $option => $val) {
                        $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
                    }       
                   }
                   $msg.=' </select>';          
                   $msg.=' </div>'; 
                   $msg.='</div>';            
               }    
               
               if($valor['elemento']=='combo-select2'){
                   $msg.='<div class="form-group">'; 
                   $msg.='<label for="" class="col-sm-3 control-label">'.$valor['titulo'].'</label>'; 
                   $msg.='<div class="col-sm-9">';     
                   $msg.='<select id="'.$valor['id'].'" class="form-control select2" style="width: 100%;">'; 
                   if(count($valor['option']) > 0){
                    foreach ($valor['option'] as $option => $val) {
                        $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
                    }    
                   }
                   $msg.=' </select>';          
                   $msg.=' </div>'; 
                   $msg.='</div>';            
               } 
         }  
        $msg.='</div>';
        $msg.='</form>';
        return $msg;
    }   
      
function generadorLista($id_lista_ul='' ,$id_oculto = '', $valor_oculto= '',$titulo, $titulo_boton, $evento_boton, $lista=array()){ 
     
              
     $msg='';
     $msg.='<div class="box-header">';
     $msg.='<i class="ion ion-clipboard"></i>';
     $msg.='<h3 class="box-title">'.$titulo.'</h3>';
     $msg.='<div class="box-tools pull-right">';
     if($id_oculto != ''){
            $msg.='<input type="hidden" class="" id="'.$id_oculto.'" value="'.$valor_oculto.'">'; 
     }
     $msg.='<button type="button" title="Nuevo" class="btn btn-info pull-right" onclick="'.$evento_boton.'"> <i class="fa fa-plus"></i> '.$titulo_boton.'</button> ';
     $msg.='</div>';
     $msg.='</div>';
     $msg.=' <div class="box-body">';
     $msg.='<ul id="'.$id_lista_ul.'" class="list-group ">';
     foreach ($lista as $l => $valor) {
        $msg.='<li class="list-group-item">';
        $msg.='<div class="input-group input-group-sm">';
        $msg.='<div class="col-md-12">'
                . '<input type="'.$valor['tipo'].'" class="form-control" name="'.$valor['name'].'" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'"  value="'.$valor['reemplazo'].'">'
                . '</div>';
        $msg.=' <span class="input-group-btn"><button type="button" class="btn btn-danger btn-flat" onclick="'.$valor['click'].'"><i class="fa fa-times"></i></button></span>';
        $msg.='</div>';
        $msg.='</li>';
      }
     $msg.='</ul>';
     $msg.='</div>';
    
        return $msg;
    }
    
function generadorListaOpcion($id_lista_ul='',$id_oculto = '', $valor_oculto= '',$titulo, $titulo_boton, $evento_boton, $lista=array()){ 
     
              
     $msg='';
     $msg.='<div class="box-header">';
     $msg.='<i class="ion ion-clipboard"></i>';
     $msg.='<h3 class="box-title">'.$titulo.'</h3>';
     $msg.='<div class="box-tools pull-right">';
     if($id_oculto != ''){
            $msg.='<input type="hidden" class="" id="'.$id_oculto.'" value="'.$valor_oculto.'">'; 
     }
     $msg.='<button type="button" title="Nuevo" class="btn btn-info pull-right" onclick="'.$evento_boton.'"> <i class="fa fa-plus"></i> '.$titulo_boton.'</button> ';
     $msg.='</div>';
     $msg.='</div>';
     $msg.=' <div class="box-body">';
     $msg.='<ul id="'.$id_lista_ul.'" class="list-group ">';
     foreach ($lista as $l => $valor) {
        $msg.='<li class="list-group-item">';
        $msg.='<div class="input-group input-group-sm">';                  
        $msg.='<div class="col-md-4">';
        $msg.='<div class="">';
        $msg.='<select id="'.$valor['id_combo'].'" class="form-control">';
        if(count($valor['option']) > 0){
         foreach ($valor['option'] as $option => $val) {
               $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
           } 
        }
        $msg.='</select>';
        $msg.='</div>';
        $msg.='</div>';                         
        $msg.='<div class="col-md-8">'
                . '<input type="'.$valor['tipo'].'" class="form-control" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'"  value="'.$valor['reemplazo'].'">'
                . '</div>';
        $msg.=' <span class="input-group-btn"><button type="button" class="btn btn-danger btn-flat" onclick="'.$valor['click'].'"><i class="fa fa-times"></i></button></span>';   
        $msg.='</div>';
        $msg.='</li>';     
        
      }
     $msg.='</ul>';
     $msg.='</div>';
    
        return $msg;
    }
function generadorLista3Opcion($id_lista_ul='',$id_oculto = '', $valor_oculto= '',$titulo, $titulo_boton, $evento_boton, $lista=array()){ 
     
              
     $msg='';
     $msg.='<div class="box-header">';
     $msg.='<i class="ion ion-clipboard"></i>';
     $msg.='<h3 class="box-title">'.$titulo.'</h3>';
     $msg.='<div class="box-tools pull-right">';
     if($id_oculto != ''){
            $msg.='<input type="hidden" class="" id="'.$id_oculto.'" value="'.$valor_oculto.'">'; 
     }
     $msg.='<button type="button" title="Nuevo" class="btn btn-info pull-right" onclick="'.$evento_boton.'"> <i class="fa fa-plus"></i> '.$titulo_boton.'</button> ';
     $msg.='</div>';
     $msg.='</div>';
     $msg.=' <div class="box-body">';
     $msg.='<ul id="'.$id_lista_ul.'" class="list-group ">';
     foreach ($lista as $l => $valor) {
        $msg.='<li class="list-group-item">';
        $msg.='<div class="input-group input-group-sm">';  
        
        $msg.='<div class="col-md-4">'
                . '<input type="'.$valor['tipo'].'" class="form-control" id="'.$valor['id'].'" placeholder="'.$valor['titulo'].'"  value="'.$valor['reemplazo'].'">'
                . '</div>';
        
          $msg.='<div class="col-md-4">'
                . '<input type="'.$valor['tipo_2'].'" class="form-control" id="'.$valor['id_2'].'" placeholder="'.$valor['titulo_2'].'"  value="'.$valor['reemplazo_2'].'">'
                . '</div>';
        
        
        $msg.='<div class="col-md-4">';
                $msg.='<div class="">';
                        $msg.='<select id="'.$valor['id_combo'].'" class="form-control">';
                        if(count($valor['option']) > 0){
                         foreach ($valor['option'] as $option => $val) {
                               $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
                           } 
                        }
                        $msg.='</select>';
                $msg.='</div>';
        $msg.='</div>';                         
        $msg.=' <span class="input-group-btn"><button type="button" class="btn btn-danger btn-flat" onclick="'.$valor['click'].'"><i class="fa fa-times"></i></button></span>';   
        $msg.='</div>';
        $msg.='</li>';     
        
      }
     $msg.='</ul>';
     $msg.='</div>';
    
        return $msg;
    }
    
    
 
function generadorContenedorRow( $colum=array(),$botones=array()){     
      $msg=''; 
      $bandera= TRUE;
      $msg.='<div class="box box-info">';
      foreach ($colum as $accion => $valor) {
        $msg.='<div class="box-header ">';
        $msg.='<h3 class="box-title">'.$valor['titulo'].'</h3>';
        
        if($bandera){
        $msg.='<div class="box-tools pull-right">';
//        $msg.='<input type="text" style="" class="" id="'.$id_oculto.'" value="'.$valor_oculto.'">'; 
           
        foreach ($botones as $boton => $val2) {
           $msg.='&nbsp;&nbsp;<button type="button" class="btn '.$val2['color'].' " onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
       
           }
           
        $msg.='</div>';
        $bandera= FALSE;
        }
      $msg.='</div>';
      $msg.='<div class="box-body">';
      $msg.='<div class="row">';
      $msg.='<div class="col-md-6">';
      $msg.=$valor['reemplazo_1']; 
      $msg.='</div>';
      $msg.='<div class="col-md-6">';
      $msg.=$valor['reemplazo_2']; 
      $msg.='</div>';
      $msg.='</div>';
      $msg.='</div>';
      }
     
      $msg.='</div>';  
      return $msg;
    }

 function generadorContMultipleRow($colum=array()){     
      $msg=''; 
      $bandera= TRUE;
      $msg.='<div class="box box-info">';
      foreach ($colum as $accion => $valor) {
          if($valor['row']=='2'){
                $msg.='<div class="box-header '.$valor['bor'].'">';
                $msg.='<h3 class="box-title"><i class="fa '.$valor['icono'].'"></i> '.$valor['titulo'].'</h3>';

                if($valor['hayboton']=='si'){
                    $msg.='<div class="box-tools pull-right">';
                    foreach ($valor['boton'] as $boton => $val2) {
                       $msg.='&nbsp;&nbsp;<button type="button" data-toggle="modal" data-target="'.$val2['modal'].'" class="btn '.$val2['color'].' " onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
                    }
                    $msg.='</div>';
               
                  
                    
                }
              $msg.='</div>';
              $msg.='<div class="box-body">';
              $msg.='<div class="row">';
              $msg.='<div class="col-md-6">';
              $msg.=$valor['reemplazo_1']; 
              $msg.='</div>';
              $msg.='<div class="col-md-6">';
              $msg.=$valor['reemplazo_2']; 
              $msg.='</div>';
              $msg.='</div>';
              $msg.='</div>';
          }
          
           if($valor['row']=='3'){
                $msg.='<div class="box-header '.$valor['bor'].'">';
                $msg.='<h3 class="box-title">'.$valor['titulo'].'</h3>';

                 if($valor['hayboton']=='si'){
                $msg.='<div class="box-tools pull-right">';
                foreach ($valor['boton'] as $boton => $val2) {
                   $msg.='&nbsp;&nbsp;<button type="button" class="btn '.$val2['color'].' " onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
                }
                $msg.='</div>';
                
                }
              $msg.='</div>';
              $msg.='<div class="box-body">';
              $msg.='<div class="row">';
              $msg.='<div class="col-md-4">';
              $msg.=$valor['reemplazo_1']; 
              $msg.='</div>';
              $msg.='<div class="col-md-4">';
              $msg.=$valor['reemplazo_2']; 
              $msg.='</div>';
              $msg.='<div class="col-md-4">';
              $msg.=$valor['reemplazo_3']; 
              $msg.='</div>';
              $msg.='</div>';
              $msg.='</div>';
          }
          if($valor['row']=='1'){
                $msg.='<div class="box-header '.$valor['bor'].'">';
                $msg.='<h3 class="box-title">'.$valor['titulo'].'</h3>';

                 if($valor['hayboton']=='si'){
                $msg.='<div class="box-tools pull-right">';
                foreach ($valor['boton'] as $boton => $val2) {
                   $msg.='&nbsp;&nbsp;<button type="button" class="btn '.$val2['color'].' " onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
                }
                $msg.='</div>';
                
                }
              $msg.='</div>';
              $msg.='<div class="box-body">';
              $msg.='<div class="row">';
              $msg.='<div class="col-md-12">';
              $msg.=$valor['reemplazo_1']; 
              $msg.='</div>';
              
              $msg.='</div>';
              $msg.='</div>';
          }
          
      }

        
        
        
        
        
      $msg.='</div>';  
     


        return $msg;
    }
    
    
function generadorTabla_2($tab=array(),$tipo){ 
    
    
    $msg='';
     $msg.='<div class="row">';
        $msg.='<div class="col-md-12 table-responsive">';
          $msg.='<table style="table-layout:fixed"; class="table '.$tipo.'">';
           $msg.='<tbody>';
       
              foreach ($tab as $accion => $valor) {
           
               
                      $msg.='<tr>';       
                        $msg.='<td >'.$valor['t_1'].'</td> ';             
                        $msg.='<td >'.$valor['t_2'].'</td>';
                      $msg.='</tr>';
   
              
        
                
            }
        
            $msg.='</tbody>';
          $msg.='</table>';
        $msg.='</div>';
      $msg.='</div>';
                  
 
      
        return $msg;
    }   

    function generadorBloqueTexto($tab=array()){ 

    $msg='';
    $msg.='<div class="col-sm-12 invoice-col">';
         
    foreach ($tab as $accion => $valor) {        
               $msg.=$valor['t_1'].' '.$valor['t_2'].'<br>'; 
            }
        $msg.='</div>';
  
        return $msg;
    } 
    
    function generadorBoton($botones = array()) {
       $msg='';
            $msg.='<div class="box-tools pull-right">';
            foreach ($botones as $boton => $val2) {
               $msg.='&nbsp;&nbsp;<button type="button" data-toggle="modal" data-target="'.$val2['modal'].'" class="btn '.$val2['color'].' btn-sm" onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
         }
            $msg.='</div>';
    
        return $msg;
    }
    function generadorBoton2($botones = array()) {
       $msg='';
            $msg.='<div class="box-tools pull-right">';
            foreach ($botones as $boton => $val2) {
               $msg.='&nbsp;&nbsp;<button type="button" id="'.$val2['id'].'" data-toggle="modal" data-target="'.$val2['modal'].'" class="btn '.$val2['color'].' btn-sm" onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
         }
            $msg.='</div>';
    
        return $msg;
    }
    function generadorBoton3($botones = array()) {
       $msg='';
            $msg.='<div class="box-tools pull-right">';
            foreach ($botones as $boton => $val2) {
               $msg.='&nbsp;&nbsp;<button type="button" id="'.$val2['id'].'" data-toggle="modal" data-target="'.$val2['modal'].'" class="btn '.$val2['color'].'" onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
            }
            $msg.='</div>';
    
        return $msg;
    }
    function generadorBotonSinLado($botones = array()) {
       $msg='';
           
            foreach ($botones as $boton => $val2) {
               $msg.='&nbsp;&nbsp;<button type="button" data-toggle="modal" data-target="'.$val2['modal'].'" class="btn '.$val2['color'].' btn-sm" onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
         }
           
    
        return $msg;
    }
function generadorEspacios($espacios) {
    $msg='';
    for ($index = 0; $index < $espacios; $index++) {
         $msg.='&ensp;';
    }
     return $msg;
}

function generadorDetalleLista($lista=array(), $titulo, $botones=array()){ 
        $msg='';
        $msg.='<div class="box box-primary">';
        $msg.='<div class="box-header with-border">';
        $msg.='<h3 class="box-title">'.$titulo.'</h3>';
        $msg.='<div class="box-tools pull-right">';
        foreach ($botones as $boton => $val2) {
           $msg.='&nbsp;&nbsp;<button type="button" data-toggle="modal" data-target="'.$val2['modal'].'" class="btn '.$val2['color'].' btn-sm" onclick="'.$val2['click'].'"><i class="fa '.$val2['icono'].'"></i> '.$val2['titulo'].'</button>';
        }
        $msg.='</div>';
        $msg.='</div>';
        $msg.='<div class="box-body">';

         foreach ($lista as $accion => $valor) {
             if($valor['num_filas']=='3'){
                $msg.='<h4><strong><i class="fa fa-file-text-o margin-r-5"></i>'.$valor['titulo'].'</strong></h4>';
                
                $msg.='<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$valor['sub_titulo_descripcion_1'].'</b> '.$valor['sub_titulo_1']           .          '<a class="pull-right"><b>'.$valor['sub_titulo_derecho_descripcion_1'].'</b>'.$valor['sub_titulo_derecho_1'].'</a>'.'<br>'; 
                $msg.='<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$valor['sub_titulo_descripcion_2'].'</b> '.$valor['sub_titulo_2']           .          '<a class="pull-right"><b>'.$valor['sub_titulo_derecho_descripcion_2'].'</b>'.$valor['sub_titulo_derecho_2'].'</a>'.'<br>'; 
                $msg.='<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$valor['sub_titulo_descripcion_3'].'</b> '.$valor['sub_titulo_3']           .          '<a class="pull-right"><b>'.$valor['sub_titulo_derecho_descripcion_3'].'</b>'.$valor['sub_titulo_derecho_3'].'</a>'.'<br>'; 
                $msg.='<hr>';
             }
             if($valor['num_filas']=='4'){
                $msg.='<strong><i class="fa fa-file-text-o margin-r-5"></i>'.$valor['titulo'].'</strong>';

                $msg.='<p class="text-muted">'.$valor['sub_titulo_1'].'</p>';
                $msg.='<p class="text-muted">'.$valor['sub_titulo_2'].'</p>';
                $msg.='<p class="text-muted">'.$valor['sub_titulo_3'].'</p>';
                $msg.='<p class="text-muted">'.$valor['sub_titulo_4'].'</p>';
                $msg.='<hr>';
             }
         }
      $msg.='</div>';
      $msg.='</div>';
        
        
        
       
        return $msg;
    }
    
function generadorAPullRight($titulo) {
    $msg='<a class="pull-right">'.$titulo.'</a>';
    return $msg;
}

function getAccionesParametrizadas($funcion,$modal,$title,$icono) {
    $msg='';
    $msg='<span aria-hidden="true" data-toggle="modal" data-target="#'.$modal.'" title="'.$title.'" data-placement="top" class="'.$icono.' cursorlink" onclick="'.$funcion.'" style="cursor:pointer;">&nbsp;</span>';
    return $msg;
}

function generadorTablaDetalleEstadoCuenta($columnas= array(),$filas ) {
        $msg='';
        $msg.='<div class="row">';
        $msg.='<div class="col-xs-12 table-responsive">';
        $msg.='<table class="table table-striped">';         
        $msg.='<thead>';
        $msg.='<tr>';
        foreach($columnas as $valor){
            $msg.='<th>'.$valor.'</th>';
        }
        $msg.='</tr>';
        $msg.='</thead>';
        $msg.='<tbody>';
        $msg.=$filas;
        $msg.='</tbody>';
        $msg.='</table>';
        $msg.='</div>';
        $msg.='</div>';
        return $msg;

}

function generadorTablaDetalleEstadoCuentaAdminReg($columnas= array(),$filas ) {
        $msg='';
        $msg.='<div class="row" id="detalleCuenta">';
        $msg.='<div class="col-xs-12 table-responsive">';
        $msg.='<table class="table table-striped">';         
        $msg.='<thead>';
        $msg.='<tr>';
        foreach($columnas as $valor){
            $msg.='<th>'.$valor.'</th>';
        }
        $msg.='</tr>';
        $msg.='</thead>';
        $msg.='<tbody>';
        $msg.=$filas;
        $msg.='</tbody>';
        $msg.='</table>';
        $msg.='</div>';
        $msg.='</div>';
        return $msg;

}

function generadorTablaDetalleContenidoEstadoCuentaAdminReg($columnas= array(),$filas ) {
        $msg='';        
        $msg.='<div class="col-xs-12 table-responsive">';
        $msg.='<table class="table table-striped">';         
        $msg.='<thead>';
        $msg.='<tr>';
        foreach($columnas as $valor){
            $msg.='<th>'.$valor.'</th>';
        }
        $msg.='</tr>';
        $msg.='</thead>';
        $msg.='<tbody>';
        $msg.=$filas;
        $msg.='</tbody>';
        $msg.='</table>';
        $msg.='</div>';
        return $msg;
}

function generadorTablaDetalleBloques($columnas= array(),$filas,  $bloques) {
        $msg='';
        $msg.='<div class="row">';
        $msg.='<div class="col-xs-'.$bloques.' table-responsive">';
        $msg.='<table class="table table-striped">';         
        $msg.='<thead>';
        $msg.='<tr>';
        foreach($columnas as $valor){
            $msg.='<th>'.$valor.'</th>';
        }
        $msg.='</tr>';
        $msg.='</thead>';
        $msg.='<tbody>';
        $msg.=$filas;
        $msg.='</tbody>';
        $msg.='</table>';
        $msg.='</div>';
        $msg.='</div>';
        return $msg;

}
 function generadorTablaColoresFilas($color, $columnas=array()){
    $t='<tr>'; 
    foreach($columnas as $valor){
        $t.= '<td class="'.$color.'">'.$valor.'</td>';
    }
    $t.= '</tr>';
    return $t ;
}
 function generadorNegritas($palabra){
    return "<b>".$palabra."</b>" ;
}
function generadorAsterisco($palabra){
    return "* ".$palabra ;
}

function generadorComboSelectOption($id, $funcion, $lista= array()){
    $msg_1='';
    $msg_1.='<select id="'.$id.'" onChange="'.$funcion.'" class="form-control select2" style="width: 100%;">'; 
    foreach ($lista as $option => $val) {
        $msg_1.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
    }           
    $msg_1.=' </select>';
    return $msg_1;
}


function generadorMultiListSelectOption($id, $disabled, $lista= array()){
    $msg='';
    $msg.='<select multiple id="'.$id.'" class="form-control select2" '.$disabled.' >'; 
        foreach ($lista as $option => $val) {
            $msg.='<option value="'.$val['value_list'].'" '.$val['select_list'].'>'.$val['texto_list'].'</option>';
        }           
    $msg.=' </select>'; 
    return $msg;
}

 

 