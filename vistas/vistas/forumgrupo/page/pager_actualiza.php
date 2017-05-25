<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#activity" data-toggle="tab">Datos Personales</a></li>
      <li><a href="#timeline" data-toggle="tab">Comunicación</a></li>
      <li><a href="#settings" data-toggle="tab">Accesos</a></li>
    </ul>
    <div class="tab-content">
      <div class="active tab-pane" id="activity">
        <!-- Post -->  
        <form class="form-horizontal">
                <div class="box-body">

            <div class="form-group">
              <label for="" class="col-sm-3 control-label">Nombre</label>
              <div class="col-sm-9">
                  <input type="text" class="form-control" id="c_nombre" placeholder="Nombre" required="required" value="{nombre}">
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-3 control-label">Apellido</label>
              <div class="col-sm-9">
                  <input type="text" class="form-control" id="c_apellido" placeholder="Apellido" required="required" value="{apellido}">
              </div>
            </div>

            <div class="form-group">
               <label for="" class="col-sm-3 control-label">Tipo de Persona</label>
               <div class="col-sm-9">
                <select id="c_tipopersona" class="form-control">
                    <option value="N" {N}>Natural</option>
                    <option value="J" {J}>Juridica</option>
                </select>
               </div>
           </div>

            <div class="form-group">
              <label for="" class="col-sm-3 control-label">Identificación</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="c_identificacion" placeholder="Identificación" required="required" value="{identificacion}">
              </div>
            </div>

              <div class="form-group">
              <label for="" class="col-sm-3 control-label">Fecha de Nacimiento</label>
              <div class="col-sm-9">
                  <input type="date" class="form-control" id="c_fn" placeholder="Fecha de Nacimiento" value="{fn}">
              </div>
            </div>
            <div class="form-group">
               <label for="" class="col-sm-3 control-label">Género</label>
               <div class="col-sm-9">
                <select id="c_genero" class="form-control">
                    <option value="M" {M}>Masculino</option>
                    <option value="F" {F}>Femenino</option>
                </select>
               </div>
           </div>

            <div class="form-group">
               <label for="" class="col-sm-3 control-label">Perfil</label>
               <div class="col-sm-9">
                <select id="c_perfil" class="form-control">
                    {perfil}
                </select>
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
               <label for="" class="col-sm-3 control-label">Estado</label>
               <div class="col-sm-9">
                <select id="c_estado" class="form-control">
                    <option value="A" {a}>Activo</option>
                    <option value="I" {i}>Inactivo</option>
                </select>
               </div>
           </div>

          </div>
          <!-- /.box-body -->
          <div class="box-footer">
              <button type="button" class="btn btn-primary" onclick="getRecargar()"><i class="fa fa-mail-reply"></i> Regresar</button>
              <button type="button" class="btn btn-primary pull-right" onclick="setActualizar()"><i class="fa fa-pencil"></i>  Guardar</button>
          </div>
          <!-- /.box-footer -->
        </form>
      
        <!-- /.post -->
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="timeline"> <!------------------------------------------------------------------------------------->
         
        <!-- left column -->
      
             <!-- TO DO List -->
             <!------------------------------------------------------------------------------------->
             <!------------------------------------------------------------------------------------->
            <!--<div class="box box-info">-->
              <div class="box-header">
                <i class="ion ion-clipboard"></i>
                <h3 class="box-title">Correos</h3>
                <div class="box-tools pull-right">
                <button type="submit" title="Nuevo" class="btn btn-info pull-right" onclick=""> <i class="fa fa-plus"></i> Agregar</button> 
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
             
               <ul class="list-group ">
                <li class="list-group-item">
                  <div class="input-group input-group-sm">
                      <div class="col-md-12"><input type="text" class="form-control"></div>
                          <span class="input-group-btn"><button type="button" class="btn btn-danger btn-flat"><i class="fa fa-times"></i></button></span>
                   </div>
                </li>
                 <li class="list-group-item">
                  <div class="input-group input-group-sm">
                      <div class="col-md-12"><input type="text" class="form-control"></div>
                          <span class="input-group-btn"><button type="button" class="btn btn-danger btn-flat"><i class="fa fa-times"></i></button></span>
                   </div>
                </li>
         
              </ul>
              </div>
   
            <!--</div>-->
    
      
            <!------------------------------------------------------------------------------------->
             <!------------------------------------------------------------------------------------->
       
            <div class="box-header">
              <i class="ion ion-clipboard"></i>
              <h3 class="box-title">Telefono</h3>
               <div class="box-tools pull-right">
                <button type="submit" title="Nuevo" class="btn btn-info pull-right" onclick=""> <i class="fa fa-plus"></i> Agregar</button> 
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                
             <ul class="list-group ">
                <li class="list-group-item">
                        <div class="input-group input-group-sm">
                        
                        
                        <div class="col-md-4">
                        <div class="">
                         <select id="c_estado" class="form-control">
                             <option value="A" {a}>Móvil</option>
                             <option value="I" {i}>Tel. Convencional</option>
                         </select>
                        </div>
                        </div>
                        <div class="col-md-8">
                        <input type="text" class="form-control">
                       
                        
                        
                         </div>
                        
                     <span class="input-group-btn">
                            <button type="button" class="btn btn-danger btn-flat"><i class="fa fa-times"></i></button>
                        
                        </span>
                        
                    </div>
                </li>
         
              </ul>
                
                
          
            
     
          </div> 
     
        
    
            

      </div>
      <!-- /.tab-pane -->

      <div class="tab-pane" id="settings"><!------------------------------------------------------------------------------------->

        <form class="form-horizontal">
            <div class="box-body">


          <div class="form-group">
          <label for="" class="col-sm-3 control-label">User</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="c_user" placeholder="User" value="{user}">
          </div>
        </div>
          <div class="form-group">
          <label for="" class="col-sm-3 control-label">Contraseña</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="c_fax" placeholder="Fax" value="{fax}">
          </div>
        </div>



      </div>
      <!-- /.box-body -->
      <div class="box-footer">
          <button type="button" class="btn btn-primary" onclick="getRecargar()"><i class="fa fa-mail-reply"></i> Regresar</button>
          <button type="button" class="btn btn-primary pull-right" onclick="setActualizar()"><i class="fa fa-pencil"></i>  Guardar</button>
      </div>
      <!-- /.box-footer -->
    </form>

    </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>

   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  