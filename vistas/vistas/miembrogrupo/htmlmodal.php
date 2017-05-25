<div class="modal fade" id="modal_enviarContacto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" id="mi_modal_personalizado">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Renaissance Executive Forum</h4>            
          </div>
          <div class="modal-body" id="">
                 
                  <div class="box-body">
                      <input type="hidden" class="form-control" id="_email_withadjuntos_key">
                    <form action="" method="">
                      <div class="form-group">
                          <input type="hidden" class="form-control" id="_email_withadjuntos_receptor" placeholder="Email to:">
                      </div>
                      <div class="form-group">
                          <input type="text" Disabled class="form-control" id="_email_withadjuntos_receptor_nombre" placeholder="Para">
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" id="_email_withadjuntos_asunto" placeholder="Asunto">
                      </div>
 
                      <div class="form-group">
                        <textarea class="textarea" placeholder="Message" id="_email_withadjuntos_mensaje" style="width: 100%; height: 250px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                      </div>
                        <div class="box-tools">
                             <button type="button" id="btnAddMisDatos" class="btn btn-default btn-flat" title="" onclick="setAdd(1)"><i class="fa fa-user"></i>&nbsp; Agregar Mis Datos</button>
                             &nbsp;<button type="button" data-toggle="modal" data-target="#modal_buscarMiembro" class="btn btn-default btn-flat" title="" onclick=""><i class="fa fa-user"></i>&nbsp; Agregar Miembro</button>
                             &nbsp;<button type="button" data-toggle="modal" data-target="#modal_buscarContacto" class="btn btn-default btn-flat" title="" onclick=""><i class="fa fa-user"></i>&nbsp; Agregar Contacto</button>
                        </div>
                      
                     
                    </form>
                  </div>                     
         
           
          </div>
          <div class="modal-footer">
              <button type="button" id="btnEnviarWithAdjuntosCorreo" class="btn btn-primary" data-dismiss="" onclick="setEnviarCorreoWhithAdjunto()">Enviar</button>
          </div>
      </div>
 </div>
</div> 

<?php include(HTML."/html_modal_correo_1.php");?>

<div class="modal fade" id="modal_buscarMiembro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" id="">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Renaissance Executive Forum</h4>            
          </div>
          <div class="modal-body" id=""> 
                <div class="box-body">  
                  <form action="" method="">
                    <?php echo $html_lista_miembros; ?>
                  </form>
                </div>                             
          </div>
          <div class="modal-footer">
              <button type="button" id="btnAddMiembro" class="btn btn-primary" data-dismiss="" onclick="setAdd(2)">OK</button>
          </div>
      </div>
 </div>
</div> 

<div class="modal fade" id="modal_buscarContacto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" id="">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Renaissance Executive Forum</h4>            
          </div>
          <div class="modal-body" id=""> 
                <div class="box-body">  
                  <form action="" method="">
                    <?php echo $html_lista_contacto; ?>
                  </form>
                </div>                             
          </div>
          <div class="modal-footer">
              <button type="button" id="btnAddContacto" class="btn btn-primary" data-dismiss="" onclick="setAdd(3)">OK</button>
          </div>
      </div>
 </div>
</div>