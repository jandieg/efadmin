<?php
 function generadorFiltro($titilo, $id){    
    $msg='';
    $msg.='<div class="col-md-3">';     
    $msg.='<div class="box box-info">';
    $msg.='<div class="box-header with-border">';
    $msg.='<h4 class="box-title">'.$titilo.'</h4>';
    $msg.='</div>';
    $msg.='<div class="box-body">';
    $msg.='{fitros}';
    $msg.='</div>';
    $msg.='</div>';
    $msg.='</div>';
    $msg.='<div class="col-md-9">';
    $msg.='<div id="'.$id.'">';
    $msg.='{cuerpo}';
    $msg.='</div>';
    $msg.='</div>';
    return $msg;
} 
    

function generadorEtiquetasFiltro($tab=array()){ 
    
    $msg='';
    foreach ($tab as $accion => $valor) {
        if($valor['elemento']=='combo'){
            $msg.='<div class="external-events">'; 
            $msg.='<div class="form-group">'; 
            $msg.='<label>'.$valor['titulo'].'</label>';       
            $msg.='<select id="'.$valor['id'].'" name="'.$valor['id'].'" onChange="'.$valor['change'].'" class="form-control select2" style="width: 100%;">'; 
        if(count($valor['option'] ) > 0){
            foreach ($valor['option'] as $option => $val) {
                $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
            } 
        }
            $msg.=' </select>';          
            $msg.=' </div>'; 
            $msg.='</div>'; 
        }  
        if($valor['elemento']=='lista'){
            $msg.='<div class="external-events">'; 
            $msg.='<div class="form-group">';  
            foreach ($valor['botones'] as $option => $val) {
                $msg.='<label><a href="'.$val['lin'].'"> '.$val['texto'].'</a></label>'; 
            }  
            $msg.=' </div>'; 
            $msg.='</div>'; 
            }
        if($valor['elemento']=='boton'){
            $msg.='<button type="button" class="btn '.$valor['color'].' btn-block margin-bottom" onclick="'.$valor['click'].'" data-toggle="modal" data-target="'.$valor['modal'].'" >'.$valor['titulo'].'</button>'; 
        }
         
    }
    return $msg;
} 
    
function generadorEtiquetasFiltroSencillo($tab=array()){ 
    $msg='';
    foreach ($tab as $accion => $valor) {
        if($valor['elemento']=='combo'){
            $msg.='<select id="'.$valor['id'].'" onChange="'.$valor['change'].'" class="form-control select2" style="width: 100%;">'; 
            if(count($valor['option'] ) > 0){
            foreach ($valor['option'] as $option => $val) {
                $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
            }  
            }
            $msg.=' </select>';          
        }
        if($valor['elemento']=='combo - 50'){
            $msg.='<select id="'.$valor['id'].'" onChange="'.$valor['change'].'" class="" style="width: 50%; border: 0px;">'; 
            if(count($valor['option'] ) > 0){
            foreach ($valor['option'] as $option => $val) {
                $msg.='<option value="'.$val['value'].'" '.$val['select'].'>'.$val['texto'].'</option>';
            }           
            }              
            $msg.=' </select>';          
        }
    }
    return $msg;
}