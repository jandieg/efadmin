<div class="modal fade" id="modal_enviarCorreo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" id="mi_modal_personalizado">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Renaissance Executive Forum</h4>            
          </div>
          <div class="modal-body" id="">
              <div id="frm_perfilUsuario" class="form-medium" >
                  <div id="respuesta_modal" class="form-medium" >

                  <div class="box-body">
                    <form action="" method="">
                      <input type="hidden" class="form-control" id="_email_key">
                      <div class="form-group">
                          <input type="hidden" class="form-control" id="_email_receptor" placeholder="Email to:">
                      </div>
                      <div class="form-group">
                          <input type="text" Disabled class="form-control" id="_email_receptor_nombre" placeholder="Para">
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
              <button type="button" id="btnEnviarCorreo" class="btn btn-primary" data-dismiss="" onclick="setEnviarCorreoIndividual()">Enviar</button>
          </div>
      </div>
 </div>
</div> 