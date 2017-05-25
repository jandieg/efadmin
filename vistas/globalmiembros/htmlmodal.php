 <div class="modal fade" id="modal_getCrearUserClave"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Actualizar User</h4>            
            </div>
            <div class="modal-body" id="modal_recordarPass_body">
                <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="_id_credenciales">
                            <input type="hidden" class="form-control" id="_bandera_credenciales">
                            <input type="hidden" class="form-control" id="_correo_credenciales">
                        </div>
                        <!--<p id="convertir_prospecto_msg"></p>-->
                        <div class="form-group">
                            <label for="codigo">User</label>
                            <input type="text" disabled class="form-control" name="" id="_user_credenciales" placeholder="User" required value="">
                         </div>
                        <div class="form-group">
                            <label for="codigo">Nueva Clave</label>
                            <input type="password" class="form-control" name="" id="_clave_credenciales" placeholder="Clave" required value="">
                        </div>
                        <div class="form-group">
                            <label for="codigo">Confirmar Clave</label>
                            <input type="password" class="form-control" name="" id="_confirmar_credenciales" placeholder="Confirmar" required value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="setActualizarUserPass()">Guardar</button>
            </div>
        </div>
   </div>
</div> 

<?php include(HTML."/html_modal_correo.php");?>

 <div class="modal fade" id="modal_detallePresupuesto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detalle del Presupuesto</h4>            
            </div>
            <div class="modal-body" id=""> 
                    <div id="respuesta_detalle_presupuesto" class="form-medium" >           
                   
  
                    </div>
          
            </div>
            <div class="modal-footer">
                <button type="button" id="" class="btn btn-primary" data-dismiss="modal" onclick="">Cancelar</button>
            </div>
        </div>
   </div>
</div>

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
                        <!--<input type="text" class="form-control" id="_id_membresia">-->
                 
                  
                        <div class="form-group">
                            <label for="">Miembro</label>
                            <input type="text" class="form-control" name="" id="_nombre_presupuesto" placeholder="Miembro" required value="">
                        </div>
                        <div class="form-group">
                            <label for="">Fecha de Registro</label>
                            <input type="date" class="form-control" name="" id="_fecha_registro_miembro_presupuesto" placeholder="" required value="">
                        </div>
                        <div class="form-group">
                            <label>Período</label>
                            <select id="_periodo_presupuesto" onchange="" class="form-control">
                                 <?php echo $listaPeriodos;?>
                            </select> 
                        </div>
                        <div class="form-group">
                            <label>Membresía</label>
                            <select id="_membresia_presupuesto" onchange="" class="form-control">
                                 <?php echo $listaMembresia;?>
                            </select> 
                        </div>    

                    </div>
              
            </div>
            <div class="modal-footer">
                <button type="button" id="btnGuardarPresupuesto" class="btn btn-primary" data-dismiss="modal" onclick="setAgregarPresupuesto()">Guardar</button>
            </div>
        </div>
   </div>
</div>




 <div class="modal fade" id="modal_inscripcion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Inscripción</h4>            
            </div>
                <div id="respuesta_inscrpcion" class="form-medium" ></div>
        </div>
   </div>
</div>



<div class="modal fade" id="modal_actualizarCredencialesGlobales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Renaissance Executive Forums</h4>            
            </div>
            <div class="modal-body" id=""> 
                    <div id="" class="form-medium" >           
                        <p>Esta seguro que desea actualizar Usuario y Contraseña de todos los miembros!</p>
  
                    </div>
          
            </div>
            <div class="modal-footer">
                <button type="button" id="" class="btn btn-primary" data-dismiss="modal" onclick="setActualizarCredencialesGlobales()">Si</button>
                <button type="button" id="" class="btn btn-primary" data-dismiss="modal" onclick="">NO</button>
            </div>
        </div>
   </div>
</div>