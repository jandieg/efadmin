 <div class="modal fade" id="modal_getAprobarCan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Renaissance Executive Forum</h4>            
            </div>
            <div class="modal-body" id="modal_recordarPass_body">
                <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="aprobar_id">
                        </div>
                        <p id="aprobar_msg"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setAprobarCan()">SI</button>
            </div>
        </div>
   </div>
</div> 




 <div class="modal fade" id="modal_getAsignarCan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Renaissance Executive Forum</h4>            
            </div>
            <div class="modal-body" id="modal_recordarPass_body">
                <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="asignar_id">
                        </div>
                        <!--<p id="asignar_msg"></p>-->
                         <div class="form-group" >
                            <label for="disabledSelect">Asignar Forum Leader</label>
                            <select  id="asignar_user" class="form-control">
                                <option value="0">Seleccione...</option>
                                <?php echo $forum_Leader;?>
                            </select>
                          </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setConvertirCandidato()">SI</button>
            </div>
        </div>
   </div>
</div> 