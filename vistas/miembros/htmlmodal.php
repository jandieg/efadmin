 <div class="modal fade" id="modal_getCrearUserClave"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Actualizar User</h4>            
            </div>
            <div class="modal-body" id="">
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
                <button type="button" id="btnActualizarUserClave" class="btn btn-primary" onclick="setActualizarUserPass()">Guardar</button>
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
            <div class="modal-body" id="">
            
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
                            <label>Precio Mensual</label>
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


  <div class="modal fade" id="modal_getPAMCrearAsistente" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
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
                            <input type="hidden" id="_funcion_asistente" value="1" >
                         </div>
                        
                        <div class="form-group">
                            <label for="codigo">Correo</label>
                            <input type="text" class="form-control" name="" id="_correo_asistente" placeholder="Correo" required value="">
                        </div>
                        <div class="form-group">
                            <label for="codigo">Teléfono Móvil</label>
                            <input type="text" class="form-control" name="" id="_movil_asistente" placeholder="Teléfono Móvil" required value="">
                        </div>
                        <div class="form-group">
                            <label for="codigo">Teléfono Fijo</label>
                            <input type="text" class="form-control" name="" id="_fijo_asistente" placeholder="Teléfono Móvil" required value="">
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnAddAsistente" class="btn btn-primary"  onclick="setPAMAgregarAsistente(1)">Guardar</button>
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
                            <input type="hidden" id ="_funcion_asistente" value="1">
                         </div>
                         
                        <div class="form-group">
                            <label for="codigo">Correo</label>
                            <input type="text" class="form-control" name="" id="_correo_asistente_u" placeholder="Correo" required value="">
                        </div>
                        <div class="form-group">
                            <label for="codigo">Teléfono Móvil</label>
                            <input type="text" class="form-control" name="" id="_movil_asistente_u" placeholder="Teléfono Móvil" required value="">
                        </div>                      
                        <div class="form-group">
                            <label for="codigo">Teléfono Fijo</label>
                            <input type="text" class="form-control" name="" id="_movil_fijo_asistente_u" placeholder="Teléfono Fijo" required value="">
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnActAsistente" onclick="setPAMActualizarAsistente(1)">Guardar</button>
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
                <button type="button" class="btn btn-primary" id="btnAddEmpresa" onclick="setAddEmpresa(1)">Guardar</button>
            </div>
        </div>
   </div>
</div> 

<div class="modal fade" id="modal_getCancelarMiembro" role="dialog" area-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cancelar Miembro</h4>
            </div>
            <div class="modal-body">
             <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="_seleccion_del_mes" value="<?php echo date('m/Y',strtotime('-1 month')); ?>">
                            <input type="hidden" class="form-control" id="_id_miembro_cancelar" value="0">
                        </div>                                          
                         <div class="form-group">      
                         <label>Indicar la fecha en la cual el miembro es cancelado:</label>                    
                            <div class="date-picker-meses" id="_seleccion_mes" /></div>
                            
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="_chequea_cancelacion" onclick="checkCancel()"/><label> Se eliminar&aacute;n los cobros no pagados a partir del mes de 
                          <span id="mesact">
                          <?php 
                          $meses = array();
                          $meses[1]  = "Enero";
                          $meses[2]  = "Febrero";
                          $meses[3]  = "Marzo";
                          $meses[4]  = "Abril";
                          $meses[5]  = "Mayo";
                          $meses[6]  = "Junio";
                          $meses[7]  = "Julio";
                          $meses[8]  = "Agosto";
                          $meses[9]  = "Septiembre";
                          $meses[10] = "Octubre";
                          $meses[11] = "Noviembre";
                          $meses[12] = "Diciembre";
                          $elmes = intval(date('m'));
                          if ($elmes-2 < 1) {
                              $elmes = $elmes + 10;
                          } else {
                              $elmes = $elmes - 2;
                          }
                          echo $meses[1] . " (incluido " . $meses[1] . ")"; ?></span></label>
                        </div>                                                                                    
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnActualizarCancelacion" disabled="true" onclick="setGuardarCancelacion()">Guardar</button>
            </div>
        </div>
    </div>
    <style>
        .ui-datepicker-calendar, .ui-datepicker-next, .ui-datepicker-prev{
            display: none;
        }

        .ui-widget.ui-widget-content{
            border: 0px;
        }
        .ui-datepicker-header{
            background: white;
            border: 0px;
        }
        .ui-datepicker-title{
            margin-left: 0px !important;
            margin-right: 0px !important;
        }
        .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
            width: 110px;
            height: 30px;
        }
        .ui-datepicker select.ui-datepicker-month b, .ui-datepicker select.ui-datepicker-year b{
            border-color: #888;
        }
    </style>
</div>

<div class="modal fade" id="modal_getCancelarMiembro2" role="dialog" area-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cancelar Miembro</h4>
            </div>
            <div class="modal-body">
             <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="_seleccion_del_mes2" value="<?php echo date('m/Y',strtotime('-1 month')); ?>">
                            <input type="hidden" class="form-control" id="_id_miembro_cancelar2" value="0">
                        </div>                                          
                         <div class="form-group">      
                         <label>Indicar la fecha en la cual el miembro es cancelado:</label>                    
                            <div class="date-picker-meses" id="_seleccion_mes" /></div>                            
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="_chequea_cancelacion2" onclick="checkCancel2()"/><label> Se eliminar&aacute;n los cobros no pagados a partir del mes de 
                          <span id="mesact2">
                          <?php 
                          $meses = array();
                          $meses[1]  = "Enero";
                          $meses[2]  = "Febrero";
                          $meses[3]  = "Marzo";
                          $meses[4]  = "Abril";
                          $meses[5]  = "Mayo";
                          $meses[6]  = "Junio";
                          $meses[7]  = "Julio";
                          $meses[8]  = "Agosto";
                          $meses[9]  = "Septiembre";
                          $meses[10] = "Octubre";
                          $meses[11] = "Noviembre";
                          $meses[12] = "Diciembre";
                          $elmes = intval(date('m'));
                          if ($elmes-2 < 1) {
                              $elmes = $elmes + 10;
                          } else {
                              $elmes = $elmes - 2;
                          }
                          echo $meses[1] . " (incluido " . $meses[1] . ")"; ?></span></label>
                        </div>                                                                                    
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnActualizarCancelacion2" disabled="true" onclick="setActualizarCancelacion2()">Guardar</button>
            </div>
        </div>
    </div>
    <style>
        .ui-datepicker-calendar, .ui-datepicker-next, .ui-datepicker-prev{
            display: none;
        }

        .ui-widget.ui-widget-content{
            border: 0px;
        }
        .ui-datepicker-header{
            background: white;
            border: 0px;
        }
        .ui-datepicker-title{
            margin-left: 0px !important;
            margin-right: 0px !important;
        }
        .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
            width: 110px;
            height: 30px;
        }
        .ui-datepicker select.ui-datepicker-month b, .ui-datepicker select.ui-datepicker-year b{
            border-color: #888;
        }
    </style>
</div>



<div class="modal fade" id="modal_getCancelarMiembro3" role="dialog" area-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cobrar miembro</h4>
            </div>
            <div class="modal-body">
             <div id="frm_perfilUsuario" class="form-medium" >
                    <div id="respuesta_modal" class="form-medium" >
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="_seleccion_del_mes3" value="<?php echo date('m/Y',strtotime('-1 month')); ?>">
                            <input type="hidden" class="form-control" id="_id_miembro_cancelar3" value="0">
                        </div>                                          
                         <div class="form-group">      
                         <label>Indicar la fecha en la cual el miembro es liquidado:</label>                    
                            <div class="date-picker-meses" id="_seleccion_mes" /></div>                            
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="_chequea_cancelacion3" onclick="checkCancel3()"/><label> Se eliminar&aacute;n los cobros no pagados a partir del mes de 
                          <span id="mesact3">
                          <?php 
                          $meses = array();
                          $meses[1]  = "Enero";
                          $meses[2]  = "Febrero";
                          $meses[3]  = "Marzo";
                          $meses[4]  = "Abril";
                          $meses[5]  = "Mayo";
                          $meses[6]  = "Junio";
                          $meses[7]  = "Julio";
                          $meses[8]  = "Agosto";
                          $meses[9]  = "Septiembre";
                          $meses[10] = "Octubre";
                          $meses[11] = "Noviembre";
                          $meses[12] = "Diciembre";
                          $elmes = intval(date('m'));
                          if ($elmes-2 < 1) {
                              $elmes = $elmes + 10;
                          } else {
                              $elmes = $elmes - 2;
                          }
                          echo $meses[1] . " (incluido " . $meses[1] . ")"; ?></span></label>
                        </div>                                                                                    
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnActualizarCancelacion3" disabled="true" onclick="setActualizarCancelacion3()">Guardar</button>
            </div>
        </div>
    </div>
    <style>
        .ui-datepicker-calendar, .ui-datepicker-next, .ui-datepicker-prev{
            display: none;
        }

        .ui-widget.ui-widget-content{
            border: 0px;
        }
        .ui-datepicker-header{
            background: white;
            border: 0px;
        }
        .ui-datepicker-title{
            margin-left: 0px !important;
            margin-right: 0px !important;
        }
        .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
            width: 110px;
            height: 30px;
        }
        .ui-datepicker select.ui-datepicker-month b, .ui-datepicker select.ui-datepicker-year b{
            border-color: #888;
        }
    </style>
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
                <button type="button" class="btn btn-primary" id="btnActualizarEmpresa" onclick="setActualizarEmpresa(1)">Guardar</button>
            </div>
        </div>
   </div>
</div> 


<!-- Modal cropper -->
  <div class="modal fade" id="modal-cropper" aria-labelledby="modalLabel" role="dialog" tabindex="-1" data-width="400" style="z-index: 9999;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: 1px solid #e5e5e5;padding: 18px 30px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h5 class="modal-title" id="modalLabel">Recortar la foto</h5>
        </div>
        <div class="modal-body">
          <div style="width:80%;margin:0px auto;">
            <img id="cropper-image" src="">
          </div>
          <div class="docs-data" style="display:none;">
            <div style="display:flex;">
              <div class="input-group input-group-sm options-left col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <label class="input-group-addon" for="dataX">X</label>
                <input type="text" class="form-control" id="dataX" placeholder="x">
                <span class="input-group-addon">px</span>
              </div>
              <div class="input-group input-group-sm options-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <label class="input-group-addon" for="dataWidth">W</label>
                <input type="text" class="form-control" id="dataWidth" placeholder="width">
                <span class="input-group-addon">px</span>
              </div>
            </div>
            <div style="display:flex;">
              <div class="input-group input-group-sm options-left col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <label class="input-group-addon" for="dataY">Y</label>
                <input type="text" class="form-control" id="dataY" placeholder="y">
                <span class="input-group-addon">px</span>
              </div>
              <div class="input-group input-group-sm options-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <label class="input-group-addon" for="dataHeight">H</label>
                <input type="text" class="form-control" id="dataHeight" placeholder="height">
                <span class="input-group-addon">px</span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="cropper-confirm">Confirmar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <!--a data-toggle="modal" id="btn-cropper" href="#modal-cropper" style="display:none;"-->



<div id="respuesta_modal_pame">

</div>