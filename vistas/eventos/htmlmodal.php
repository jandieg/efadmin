 <div class="modal fade" id="modal_get_busqueda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="mi_modal_personalizado">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Renaissance Executive Forums</h4>            
            </div>
            <div class="modal-body" id="">
                <div id="" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                   
                    <?php echo $filtro; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="">OK</button>
            </div>
        </div>
   </div>
</div> 





 <div class="modal fade" id="modal_getCrearParticipante" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar</h4>            
            </div>
            <div class="modal-body" id="">
                <div id="" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="_tipo_participante">
                        </div>
                  
                        <div class="form-group">
                            <label for="codigo">Nombre</label>
                            <input type="text" class="form-control" name="" id="_nombre_participante" placeholder="Nombre" required value="">
                         </div>
                        <div class="form-group">
                            <label for="codigo">Apellido</label>
                            <input type="text" class="form-control" name="" id="_apellido_participante" placeholder="Apellido" required value="">
                         </div>
                        <div class="form-group">
                            <label for="codigo">Correo</label>
                            <input type="text" class="form-control" name="" id="_correo_participante" placeholder="Correo" required value="">
                        </div>
                        <div class="form-group">
                            <label for="codigo">Teléfono Móvil</label>
                            <input type="number" class="form-control" name="" id="_movil_participante" placeholder="Teléfono Móvil" required value="">
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="" onclick="setAgregarParticipante()">Guardar</button>
            </div>
        </div>
   </div>
</div> 
<?php include(HTML."/html_modal_detalle_evento.php");?>
<!-- <div class="modal fade" id="modal_get_detalle_evento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" id="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Renaissance Executive Forums</h4>            
            </div>
            <div class="modal-body" id="">
                <div id="" class="form-medium" >
                    <input type="hidden" class="form-control" id="_url_google_calendar">
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
                
                <button type="button" id="btnSincronizarEventoWhithGoogle" class="btn btn-primary" data-dismiss="modal" onclick="getSincronizarEventoWhithGoogle()">Añadir a Google Calendar</button>
                <button type="button"  class="btn btn-primary" data-dismiss="modal" onclick="">Cancelar</button>
            </div>
        </div>
   </div>
</div> -->

<div class="modal fade" id="modal_getCrearDireccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar Dirección</h4>            
            </div>
            <div class="modal-body" id="">
                <div id="" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="_tipo_direccion">
                        </div>
                        <?php 
                            echo $listaDireccion;
                        ?> 
                        <div class="form-group">
                            <label for="">Dirección</label>
                            <!--<input type="text" class="form-control" name="" id="_direccion" placeholder="Dirección" required value="">-->
                            <textarea class="form-control" rows="3" placeholder="Enter ..." id="_descripcion_direccion" value=""></textarea>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="" onclick="setAgregarDireccion()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php //include(HTML."/html_modal_correo_1.php");?>
<div class="modal fade" id="modal_enviarCorreo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" id="mi_modal_personalizado">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Renaissance Executive Forums</h4>            
          </div>
          <div class="modal-body" id="">
              <div id="frm_perfilUsuario" class="form-medium" >
                  <div id="respuesta_modal" class="form-medium" >

                  <div class="box-body">
                    <form action="" method="">
                      <div class="form-group">
                          <input type="text"  class="form-control" id="_email_receptor_nombre" placeholder="Para">
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" id="_email_asunto" placeholder="Asunto">
                      </div>
                      <div>
                        <textarea class="textarea" placeholder="Message" id="_email_mensaje" style="width: 100%; height: 250px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                      </div>
                    </form>
                  </div>                     
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" id="btnRecordatorioEnviarCorreo" class="btn btn-primary" data-dismiss="" onclick="setEnviarCorreoIndividual()">Recordar</button>
          </div>
      </div>
 </div>
</div> 

