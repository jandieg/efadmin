  <!-- Modal de Registro-->
    <div class="modal fade" id="modal_crear_cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="getRecargar()"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Crear Tramite</h4>
          </div>
          <div class="modal-body" id="modal_recordarPass_body">
              <div id="frmCodigo" class="form-medium" >
                        <div class="form-group">
                            <label for="codigo">Nombre</label>
                            <input type="text" class="form-control" name="c_nombre" id="c_nombre" placeholder="Nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Usuario</label>
                            <input type="text" class="form-control" name="c_usuario" id="c_usuario" placeholder="Usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Comtraseña</label>
                            <input type="text" class="form-control" name="c_contraseña" id="c_contraseña" placeholder="Contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Correo</label>
                            <input type="text" class="form-control" name="c_correo" id="c_correo" placeholder="Correo" required>
                        </div>
                        <div class="form-group">
                            <label for="disabledSelect">Tipo</label>
                            <select id="c_tipo" class="form-control">
                                <option value="X">Seleccione...</option>
                                <option value="C">Cliente</option>
                                <option value="A">Empleado</option>
                            </select>
                       </div>
                      
                  <div id="c_respuesta"></div>
              </div>
         
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="getRecargar()">Cancelar</button>
            <button type="button"  class="btn btn-primary" onclick="setCrear();">Enviar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de actualizar-->
    <div class="modal fade" id="modal_actualizar_cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="getRecargar()"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Crear Tramite</h4>
          </div>
          <div class="modal-body" id="modal_recordarPass_body">
              <div id="frmCodigo" class="form-medium" >
                        <div class="form-group">
                            <label for="codigo">Codigo</label>
                            <input type="text" readonly class="form-control" name="a_codigo" id="a_codigo" placeholder="Codigo" required>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Nombre</label>
                            <input type="text" class="form-control" name="a_nombre" id="a_nombre" placeholder="Nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Usuario</label>
                            <input type="text" class="form-control" name="a_usuario" id="a_usuario" placeholder="Usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Comtraseña</label>
                            <input type="text" class="form-control" name="a_contraseña" id="a_contraseña" placeholder="Contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Correo</label>
                            <input type="text" class="form-control" name="a_correo" id="a_correo" placeholder="Correo" required>
                        </div>
                        <div class="form-group">
                            <label for="disabledSelect">Tipo</label>
                            <select id="a_tipo" class="form-control">
                                <option value="X">Seleccione...</option>
                                <option value="C">Cliente</option>
                                <option value="A">Empleado</option>
                            </select>
                       </div>
                      
                  <div id="a_respuesta"></div>
              </div>
         
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="getRecargar();">Cancelar</button>
            <button type="button"  class="btn btn-primary" onclick="setActualizar();">Enviar</button>
          </div>
        </div>
      </div>
    </div>