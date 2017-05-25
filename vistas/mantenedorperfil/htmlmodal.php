 <div class="modal fade" id="modal_eliminar_Perfil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Inactivar Perfil</h4>            
            </div>
            <div class="modal-body" id="modal_recordarPass_body">
                <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="frm_eliminacionMarca" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="e_id">
                        </div>
                        <p id="e_msg"></p>
                        <p id="e_error"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setEliminar()">Enviar</button>
            </div>
        </div>
   </div>
</div> 