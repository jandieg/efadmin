 <div class="modal fade" id="modal_getCrearContacto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar Contacto</h4>            
            </div>
            <div class="modal-body" id="modal_recordarPass_body">
                <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="_id_contacto_empresa">
                        </div>
                  
                        <div class="form-group">
                            <label for="codigo">Nombre</label>
                            <input type="text" class="form-control" name="" id="_nombre_contacto_empresa" placeholder="Nombre" required value="">
                         </div>
                        <div class="form-group">
                            <label for="codigo">Apellido</label>
                            <input type="text" class="form-control" name="" id="_apellido_contacto_empresa" placeholder="Apellido" required value="">
                         </div>
                        <div class="form-group">
                          <label>Función</label>
                          <!--<select id="_funcion_contacto_empresa" onchange="" class="form-control">-->
                               <?php echo $listaFuncion;?>
                          <!--</select>--> 
                        </div>
                        <div class="form-group">
                            <label for="codigo">Correo</label>
                            <input type="text" class="form-control" name="" id="_correo_contacto_empresa" placeholder="Correo" required value="">
                        </div>
                        <div class="form-group">
                            <label for="codigo">Teléfono Móvil</label>
                            <input type="number" class="form-control" name="" id="_movil_contacto_empresa" placeholder="Teléfono Móvil" required value="">
                        </div>
                        <div class="form-group">
                            <label for="codigo">Teléfono Fijo</label>
                            <input type="number" class="form-control" name="" id="_fijo_contacto_empresa" placeholder="Teléfono Móvil" required value="">
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnAddContacto" class="btn btn-primary"  onclick="setAgregarContacto()">Guardar</button>
            </div>
        </div>
   </div>
</div> 


 <div class="modal fade" id="modal_getActualizarContacto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Actualizar Contacto</h4>            
            </div>
            <div class="modal-body" id="modal_recordarPass_body">
                <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="_id_contacto_u">
                            <input type="hidden" class="form-control" id="_id_empresa_u">
                        </div>
                  
                        <div class="form-group">
                            <label for="codigo">Nombre</label>
                            <input type="text" class="form-control" name="" id="_nombre_contacto_empresa_u" placeholder="Nombre" required value="">
                         </div>
                        <div class="form-group">
                            <label for="codigo">Apellido</label>
                            <input type="text" class="form-control" name="" id="_apellido_contacto_empresa_u" placeholder="Apellido" required value="">
                         </div>
                         <div class="form-group">
                          <label>Función</label>
                          <!--<select id="_funcion_contacto_empresa" onchange="" class="form-control">-->
                               <?php echo $listaFuncion2;?>
                          <!--</select>--> 
                        </div>
                        <div class="form-group">
                            <label for="codigo">Correo</label>
                            <input type="text" class="form-control" name="" id="_correo_contacto_empresa_u" placeholder="Correo" required value="">
                        </div>
                        <div class="form-group">
                            <label for="codigo">Teléfono Móvil</label>
                            <input type="number" class="form-control" name="" id="_movil_contacto_empresa_u" placeholder="Teléfono Móvil" required value="">
                        </div>
                         <div class="form-group">
                            <label for="codigo">Teléfono Fijo</label>
                            <input type="number" class="form-control" name="" id="_fijo_contacto_empresa_u" placeholder="Teléfono Fijo" required value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"  onclick="setActualizarContacto()">Guardar</button>
            </div>
        </div>
   </div>
</div> 