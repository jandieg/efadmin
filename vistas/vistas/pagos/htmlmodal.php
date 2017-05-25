 <div class="modal fade" id="modal_PagarForumGrupos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog" id="mi_modal_personalizado">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Pago a Forum Leader</h4>            
            </div>
            <div class="modal-body" id=""> 
                    <div id="respuesta_forum_grupo" class="form-medium" >           
                   
  
                    </div>
          
            </div>
            <div class="modal-footer">
                <button type="button" id="btnGuardarForumGrupo" class="btn btn-primary" onclick="setPagarForumGrupo()">Autorizar</button>
            </div>
        </div>
   </div>
</div>

 <div class="modal fade" id="modal_PagarForum" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog" id="mi_modal_personalizado">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Pago a Forum Leader</h4>            
            </div>
            <div id="respuesta_forum" class="form-medium" >           
                   
  
            </div>
        </div>
   </div>
</div>


<div class="modal fade" id="modal_getCrearPorcentaje" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar Porcentaje</h4>            
            </div>
            <div class="modal-body" id="">
                <div id="" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <input type="hidden" class="form-control" name="" id="_tope_calculo_porcentaje" placeholder="" required value="">
                        <div class="form-group">
                            <label for="">Porcentaje</label>
                            <input type="number" class="form-control" name="" id="_porcentaje_crear" placeholder="Porcentaje" required value="">   
                        </div>
    
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="" onclick="setAgregarPorcentaje(1)">Guardar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_getCrearRebate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar Rebate</h4>            
            </div>
            <div class="modal-body" id="">
                <div id="" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <label for="">Rebate</label>
                            <input type="number" class="form-control" name="" id="_rebate_crear" placeholder="Rebate" required value="">   
                        </div>
    
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="" onclick="setAgregarPorcentaje(2)">Guardar</button>
            </div>
        </div>
    </div>
</div>

 <div class="modal fade" id="modal_get_busqueda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="mi_modal_personalizado">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Renaissance Executive Forum</h4>            
            </div>
            <div class="modal-body" id="modal_recordarPass_body">
                <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal_miembros" class="form-medium" >
                   
                    <?php // echo $filtro; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="">OK</button>
            </div>
        </div>
   </div>
</div>