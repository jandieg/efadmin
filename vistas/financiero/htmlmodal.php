  <div class="modal fade" id="modal_getTipoCambio" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tipo de Cambio</h4>            
            </div>
            <div class="modal-body" id="">
                <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <select name="anho" id="_anho" onChange= "cambioAnho()">
                                <option value="<?php echo intval(date('Y'))-1; ?>"><?php echo intval(date('Y'))-1; ?></option>
                                <option value="<?php echo date('Y'); ?>" selected><?php echo date('Y'); ?></option>
                                <option value="<?php echo intval(date('Y'))+1; ?>"><?php echo intval(date('Y'))+1; ?></option>
                            </select>
                            <input type="hidden" class="form-control" id="_id_asistente">
                        </div>
                        
     
                        <div class="form-group">
                            <div id="contenedor_cambio"></div>
                         </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <?php if (in_array(trim($_SESSION['user_perfil']), array('Administrador Regional'))) : ?>
                <button type="button" id="btnGuardarCambio" class="btn btn-primary"  onclick="setGuardarCambio()">Guardar</button>
            <?php endif; ?>
            </div>
        </div>
   </div>
</div> 
