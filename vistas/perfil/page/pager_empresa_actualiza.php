 <div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Datos de la Empresa</h3>
        <input type="hidden" id="c_id"   value="{id}">
      </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal">
        <div class="box-body">
           
    <div class="form-group">
      <label for="" class="col-sm-3 control-label">Razón Social</label>
      <div class="col-sm-9">
          <input type="text" class="form-control" id="c_empresa" placeholder="Razón Socia" required="required" value="{nombre_empresa}">
      </div>
    </div>

      <div class="form-group">
      <label for="" class="col-sm-3 control-label">Número de Empleados</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="c_reencuentro" placeholder="Número de Empreados" required="required" value="{reencuentro}">
      </div>
    </div>
      <div class="form-group">
      <label for="" class="col-sm-3 control-label">Tel.</label>
      <div class="col-sm-9">
          <input type="number" class="form-control" id="c_telefono" placeholder="Telefono" value="{telefono}">
      </div>
    </div>
      <div class="form-group">
      <label for="" class="col-sm-3 control-label">Móvil</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="c_movil" placeholder="Móvil" value="{celular}">
      </div>
    </div>
      <div class="form-group">
      <label for="" class="col-sm-3 control-label">Fax</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="c_fax" placeholder="Fax" value="{fax}">
      </div>
    </div>
      <div class="form-group">
      <label for="" class="col-sm-3 control-label">Sitio Web</label>
      <div class="col-sm-9">
        <input type="phone" class="form-control" id="c_sitioweb" placeholder="Sitio Web" value="{sitio_web}">
      </div>
    </div>
      <div class="form-group">
      <label for="" class="col-sm-3 control-label">Descripción</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="c_descrpcion" placeholder="Descripción" value="{descripcion}">
      </div>
    </div>
     <div class="form-group">
      <label for="" class="col-sm-3 control-label">Administrador</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="c_admin" placeholder="Administrador" value="{admin}">
      </div>
    </div>
    <div class="form-group">
      <label for="" class="col-sm-3 control-label">Código Postal</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="c_codigopostal" placeholder="Codigo Postal" value="{codigop}">
      </div>
    </div>
    <div class="form-group">
      <label for="" class="col-sm-3 control-label">País</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="c_pais" placeholder="Pais" value="{pais}">
      </div>
    </div>
  <div class="form-group">
      <label for="" class="col-sm-3 control-label">Ciudad</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="c_ciudad" placeholder="Ciudad" value="{ciudad}">
      </div>
    </div>
       <div class="form-group">
      <label for="" class="col-sm-3 control-label">Calle</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="c_calle" placeholder="Calle" value="{calle}">
      </div>
    </div>
     
<!--               <div class="form-group">
      <label for="" class="col-sm-3 control-label">Estado</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="c_estado" placeholder="Estado" value="{estado}">
      </div>
    </div>-->

  </div>
  <!-- /.box-body -->
  <div class="box-footer">
      <button type="button" class="btn btn-primary" onclick="getRecargar()"><i class="fa fa-mail-reply"></i> Regresar</button>
      <button type="button" class="btn btn-primary pull-right" onclick="setActualizar()"><i class="fa fa-pencil"></i>  Guardar</button>
  </div>
  <!-- /.box-footer -->
</form>
</div>
<div id="ben_respuesta_operacion"></div>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
<!-- <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#empresa" data-toggle="tab">Empresa</a></li>
      <li><a href="#horario" data-toggle="tab">Horario de Atención</a></li>
    </ul>
    <div class="tab-content">
      <div class="active tab-pane" id="empresa">
         Post 
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Crear Empresa</h3>
              </div>
             /.box-header 
             form start 
            <form class="form-horizontal">
                <div class="box-body">
            <div class="form-group">
              <label for="" class="col-sm-3 control-label">Razón Socia</label>
              <div class="col-sm-9">
                  <input type="text" class="form-control" id="c_empresa" placeholder="Razón Socia" required="required">
              </div>
            </div>
              <div class="form-group">
              <label for="" class="col-sm-3 control-label">Alias</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="c_alias" placeholder="Alias" required="required">
              </div>
            </div>
              <div class="form-group">
              <label for="" class="col-sm-3 control-label">Reencuentro de Empreados</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="c_reencuentro" placeholder="Reencuentro de Empreados" required="required">
              </div>
            </div>
              <div class="form-group">
              <label for="" class="col-sm-3 control-label">Tel.</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="c_telefono" placeholder="Telefono">
              </div>
            </div>
              <div class="form-group">
              <label for="" class="col-sm-3 control-label">Móvil</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="c_movil" placeholder="Móvil">
              </div>
            </div>
              <div class="form-group">
              <label for="" class="col-sm-3 control-label">Fax</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="c_fax" placeholder="Fax">
              </div>
            </div>
              <div class="form-group">
              <label for="" class="col-sm-3 control-label">Sitio Web</label>
              <div class="col-sm-9">
                <input type="phone" class="form-control" id="c_sitioweb" placeholder="Sitio Web">
              </div>
            </div>
              <div class="form-group">
              <label for="" class="col-sm-3 control-label">Descripción</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="c_descrpcion" placeholder="Descripción">
              </div>
            </div>
              <div class="form-group">
                <label for="" id="c_superadmin" class="col-sm-3 control-label">Superadministrador</label>
                <div class="col-sm-9">
                  <select class="form-control select2" style="width: 100%;">
                    <option selected="selected">Alabama</option>
                    <option>Alaska</option>
                    <option>California</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                  </select>
                </div>
              </div>

               <div class="form-group">
              <label for="" class="col-sm-3 control-label">Calle</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="c_calle" placeholder="Calle">
              </div>
            </div>
               <div class="form-group">
              <label for="" class="col-sm-3 control-label">Ciudad</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="c_ciudad" placeholder="Ciudad">
              </div>
            </div>
               <div class="form-group">
              <label for="" class="col-sm-3 control-label">Estado</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="c_estado" placeholder="Estado">
              </div>
            </div>

          </div>
           /.box-body 
          <div class="box-footer">
            <button type="submit" class="btn btn-default">Cancel</button>
            <button type="submit" class="btn btn-info pull-right">Enviar</button>
          </div>
           /.box-footer 
        </form>
        </div>


         /.post 
      </div>
       /.tab-pane 
      <div class="tab-pane" id="horario">
          
          
                Post 
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Crear Empresa</h3>
            </div>
             /.box-header 
             form start 
            <form class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                      <label for="" class="col-sm-3 control-label">Nombre</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="c_empresa" placeholder="Nombre" required="required">
                      </div>
                    </div>
                    <div class="form-group">
                     <label for="" id="c_superadmin" class="col-sm-3 control-label">Zona Horaria</label>
                     <div class="col-sm-9">
                       <select class="form-control select2" style="width: 100%;">
                         <option selected="selected">Alabama</option>
                         <option>Alaska</option>
                         <option>California</option>
                         <option>Delaware</option>
                         <option>Tennessee</option>
                         <option>Texas</option>
                         <option>Washington</option>
                       </select>
                     </div>
                   </div>
              <div class="form-group">
                  
              <label for="" class="col-sm-3 control-label">Alias</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" id="c_alias" placeholder="Alias" required="required">
              </div>
              
              <label for="" class="col-sm-3 control-label">Alias</label>
              
              <div class="col-sm-3">
                <input type="text" class="form-control" id="c_alias" placeholder="Alias" required="required">
              </div>
            </div>
              
            </div>
            </form>
          </div>
           /.box-body 
          <div class="box-footer">
            <button type="submit" class="btn btn-default">Cancel</button>
            <button type="submit" class="btn btn-info pull-right">Enviar</button>
          </div>
           /.box-footer 
        </form>
        </div>
          


      </div>
       /.tab-pane 
    </div>
     /.tab-content 
    </div>-->
