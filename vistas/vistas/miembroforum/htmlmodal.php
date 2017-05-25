<!-- <div class="modal fade" id="modal_get_detalle_evento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" id="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Renaissance Executive Forum</h4>            
            </div>
            <div class="modal-body" id="modal_recordarPass_body">
                <div id="frm_perfilUsuario" class="form-medium" >
                    <input type="hidden" class="form-control" id="_id_evento_detalle">
                    <div id="respuesta_modal_detalle_evento" class="form-medium" >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php 
                    if (in_array($perActualizarEventoOp10, $_SESSION['usu_permiso'])) {
                ?>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="getActualizarEvento()">Editar</button>
                <?php 
                    } if (in_array($perRecordarEventoOp10, $_SESSION['usu_permiso'])) {
                ?>
                <button type="button" id="btnEnviarCorreo" class="btn btn-primary" data-dismiss="modal" onclick="getRecordarEvento()">Recordar</button>
                <?php 
                    } if (in_array($perEliminarEventoOp10, $_SESSION['usu_permiso'])) {
                ?>
                <button type="button" id="btnEliminarEvento" class="btn btn-primary" data-dismiss="modal" onclick="getEliminarEvento()">Eliminar</button>
                <?php 
                    }
                ?>
                <button type="button"  class="btn btn-primary" data-dismiss="modal" onclick="">Cancelar</button>
            </div>
        </div>
   </div>
</div> -->
<?php include(HTML."/html_modal_detalle_evento.php");?>