 <div class="modal fade" id="modal_agregarPresupuesto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Presupuesto</h4>            
            </div>
            <div class="modal-body" id="modal_recordarPass_body">
            
                    <div id="" class="form-medium" >
            
                            <input type="hidden" class="form-control" id="_id_presupuesto">
                            <input type="hidden" class="form-control" id="_id_miembro_presupuesto">                  
                        <div class="form-group">
                            <label for="">Miembro</label>
                            <input type="text" class="form-control" name="" id="_nombre_presupuesto" placeholder="Miembro" required value="{miembro}">
                        </div>
                        <div class="form-group">
                            <label for="">Fecha de Registro</label>
                            <input type="date" class="form-control" name="" id="_fecha_registro_miembro_presupuesto" placeholder="" required value="{fecha_registro}">
                        </div>
                        <div class="form-group">
                            <label>Período</label>
                            <select id="_periodo_presupuesto" onchange="" class="form-control">
                                 {presupuesto}
                            </select> 
                        </div>
                        <div class="form-group">
                            <label for="">Valor</label>
                            <input type="number" class="form-control" name="" id="_valor_presupuesto" placeholder="Valor" required value="">
                        </div>
  
                    </div>
              
            </div>
            <div class="modal-footer">
                <button type="button" id="btnGuardarPresupuesto" class="btn btn-primary" data-dismiss="modal" onclick="setAgregarPresupuesto()">Guardar</button>
            </div>
        </div>
   </div>
</div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  