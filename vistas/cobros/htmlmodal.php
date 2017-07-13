
 <div class="modal fade" id="modal_detalleCobro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
     <div class="modal-dialog" id="mi_modal_personalizado">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cobrar Cuotas</h4>            
            </div>
            <div id="respuesta_modal" class="form-medium" >           
                   
  
                    </div>
        </div>
   </div>
</div> 

 <div class="modal fade" id="modal_InscripcionCobro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
     <div class="modal-dialog" id="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cobrar Inscripción</h4>            
            </div>
            <div class="modal-body" id=""> 
                <input type="hidden" class="form-control" id="_id_inscripcion_miembro">
                <div id="respuesta_modal_inscripcion" class="form-medium" >           


                </div>
                <label for="fechacob">Fecha de cobro</label>
                <input type="date" name="fechacob" class="datepicker" id="_fecha_cobro" value="<?php echo date('Y-m-d'); ?>"/>
          
            </div>
            <div class="modal-footer">
                <button type="button" id="btnGuardarInscrición" class="btn btn-primary" onclick="setCobrarInscripcion()">Cobrar</button>
            </div>
        </div>
   </div>
</div>