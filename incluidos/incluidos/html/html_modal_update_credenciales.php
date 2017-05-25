 <div class="modal fade" id="modal_getCrearUserClave"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $lblActualizarUsuario; ?></h4>            
            </div>
            <div class="modal-body" id="modal_recordarPass_body">
                <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="_id_credenciales" value="<?php echo $idpersona; ?>">
                        </div>
                        <!--<p id="convertir_prospecto_msg"></p>-->
                        <div class="form-group">
                            <label for="codigo"><?php echo $lblUsuario; ?></label>
                            <?php if($disabled){ ?>
                                <input type="text" class="form-control" disabled maxlength="15" name="" id="_user_credenciales" placeholder="User" required value="<?php echo $user; ?>">
                            <?php }else{ ?>
                                <input type="text" class="form-control"  maxlength="15" name="" id="_user_credenciales" placeholder="User" required value="<?php echo $user; ?>">
                            <?php } ?>
                         </div>
                        <div class="form-group">
                            <label for="codigo"><?php echo $lblContraseña; ?></label>
                            <input type="password" class="form-control" maxlength="15" name="" id="_clave_credenciales" placeholder="Clave" required value="">
                        </div>
                        <div class="form-group">
                            <label for="codigo"><?php echo $lblConfirmarContraseña; ?></label>
                            <input type="password" class="form-control" maxlength="15" name="" id="_confirmar_credenciales" placeholder="Confirmar" required value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnActualizarUserClave" class="btn btn-primary" onclick="setPerfilActualizarUserPass()">Guardar</button>
            </div>
        </div>
   </div>
</div> 