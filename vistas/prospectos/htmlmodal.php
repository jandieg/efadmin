<div class="modal fade" id="modal_getConvertirProspecto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="mi_modal_personalizado">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Convertir Prospecto</h4>            
            </div>
            <div class="modal-body" id="">
            
                    <div id="convertir_respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="convertir_id">
                            <input type="hidden" class="form-control" id="convertir_id_forum">
                            <input type="hidden" class="form-control" id="convertir_nombre_forum">
                        </div>
                        <div class="form-group">
                            <label for="email">Enviar Email de Bienvenida</label>
                            <input type="checkbox" id="_email" name="email" checked/>
                        </div>
                     
                        <div class="form-group">
                            <label for="codigo">Crear nuevo miembro</label>
                            <input type="text" disabled class="form-control" name="convertir_nombre" id="pro_prospecto" placeholder="Nombre" required value="">
                         </div>
                        

<!--                        <div class="form-group">
                            <div id="respuesta_modal" class="form-medium">

                            </div>
                        </div>  -->
                        
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setConvertirAplicante()">SI</button>
            </div>
        </div>
   </div>
</div> 
<div class="modal fade" id="modal_getSeleccionarStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Renaissance Executive Forum</h4>            
            </div>
            <div class="modal-body" id="">
            
                    <div id="convertir_respuesta_modal" class="form-medium" >
                        <center><h1>Debes cambiar el Estado del Aplicante a "Applicant"!</h1></center>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
   </div>
</div>

<?php include(HTML."/html_modal_correo.php");?>




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
                            <input type="hidden" class="form-control" id="asignar_correo">
                            <input type="hidden" class="form-control" id="asignar_nombre">
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
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setConvertirProspecto()">SI</button>
            </div>
        </div>
   </div>
</div> 



<div class="modal fade" id="modal_getAddEmpresa"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar Empresa</h4>            
            </div>
            <div class="modal-body" id="">
                <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="_id_miembro_empresa">
                        </div>
                  
<!--                        <div class="form-group">
                            <label for="codigo">Descripción</label>
                            <input type="text" class="form-control" name="" id="_descripcion_empresa" placeholder="Descripción" required value="">
                         </div>-->
<!--                        <div class="form-group">
                          <label>Tipo de Empresa</label>
                            <div id="_lista_tipo_empresa">
                                
                            </div>
                        </div>-->
                         <div class="form-group">
                          <label>Empresa</label>
                            <div id="_lista_empresa">

                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnAddEmpresa" onclick="setAddEmpresa(2)">Guardar</button>
            </div>
        </div>
   </div>
</div> 

<div class="modal fade" id="modal_getActualizarEmpresa"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Actualizar Empresa</h4>            
            </div>
            <div class="modal-body" id="">
                <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="_id_miembro_empresa_u">
                            <input type="hidden" class="form-control" id="_id_mie_emp_empresa_u">
                        </div>
                  
<!--                        <div class="form-group">
                            <label for="codigo">Descripción</label>
                            <input type="text" class="form-control" name="" id="_descripcion_empresa_u" placeholder="Descripción" required value="">
                         </div>-->
<!--                        <div class="form-group">
                          <label>Tipo de Empresa</label>
                            <div id="_lista_tipo_empresa_u">
                                
                            </div>
                        </div>-->
                        
                         <div class="form-group">
                          <label>Empresa</label>
                            <div id="_lista_empresa_u">

                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnActualizarEmpresa" onclick="setActualizarEmpresa(2)">Guardar</button>
            </div>
        </div>
   </div>
</div> 


<div class="modal fade" id="modal_getPAMCrearAsistente"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar Asistente</h4>            
            </div>
            <div class="modal-body" id="">
                <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="_id_asistente">
                        </div>
                        
     
                        <div class="form-group">
                            <label for="codigo">Nombre</label>
                            <input type="text" class="form-control" name="" id="_nombre_asistente" placeholder="Nombre" required value="">
                         </div>
                        <div class="form-group">
                            <label for="codigo">Apellido</label>
                            <input type="text" class="form-control" name="" id="_apellido_asistente" placeholder="Apellido" required value="">
                         </div>
                        <div class="form-group">
                          <label>Función</label>
                          <!--<select id="_funcion_asistente" onchange="" class="form-control">-->
                               <?php echo $listaFuncion;?>
                          <!--</select>--> 
                        </div>
                        <div class="form-group">
                            <label for="codigo">Correo</label>
                            <input type="text" class="form-control" name="" id="_correo_asistente" placeholder="Correo" required value="">
                        </div>
                        <div class="form-group">
                            <label for="codigo">Teléfono Móvil</label>
                            <input type="number" class="form-control" name="" id="_movil_asistente" placeholder="Teléfono Móvil" required value="">
                        </div>
                        <div class="form-group">
                            <label for="codigo">Teléfono Fijo</label>
                            <input type="number" class="form-control" name="" id="_fijo_asistente" placeholder="Teléfono Móvil" required value="">
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnAddAsistente" class="btn btn-primary"  onclick="setPAMAgregarAsistente(2)">Guardar</button>
            </div>
        </div>
   </div>
</div> 


 <div class="modal fade" id="modal_getPAMActualizarAsistente"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Actualizar Asistente</h4>            
            </div>
            <div class="modal-body" id="">
                <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="_id_asistente_u">
                            <input type="hidden" class="form-control" id="_id_miembro_u">
                        </div>
                  
                        <div class="form-group">
                            <label for="codigo">Nombre</label>
                            <input type="text" class="form-control" name="" id="_nombre_asistente_u" placeholder="Nombre" required value="">
                         </div>
                        <div class="form-group">
                            <label for="codigo">Apellido</label>
                            <input type="text" class="form-control" name="" id="_apellido_asistente_u" placeholder="Apellido" required value="">
                         </div>
                         <div class="form-group">
                          <label>Función</label>
                          <!--<select id="_funcion_asistente" onchange="" class="form-control">-->
                               <?php echo $listaFuncion2;?>
                          <!--</select>--> 
                        </div>
                        <div class="form-group">
                            <label for="codigo">Correo</label>
                            <input type="text" class="form-control" name="" id="_correo_asistente_u" placeholder="Correo" required value="">
                        </div>
                        <div class="form-group">
                            <label for="codigo">Teléfono Móvil</label>
                            <input type="number" class="form-control" name="" id="_movil_asistente_u" placeholder="Teléfono Móvil" required value="">
                        </div>                      
                        <div class="form-group">
                            <label for="codigo">Teléfono Fijo</label>
                            <input type="number" class="form-control" name="" id="_movil_fijo_asistente_u" placeholder="Teléfono Fijo" required value="">
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnActAsistente" onclick="setPAMActualizarAsistente(2)">Guardar</button>
            </div>
        </div>
   </div>
</div> 


<div id="respuesta_modal_pame">

</div>