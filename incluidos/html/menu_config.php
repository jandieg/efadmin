    <?php  if (in_array($perConfiguracionesGeneralesOp5, $_SESSION['usu_permiso'])) { ?>
        <div class="box box-info">
            <div class="box-header with-border">
              <h4 class="box-title">Configuraciones Generales</h4>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
              <!-- the events -->
          
               <div class="external-events">
                <ul class="nav">
                  <?php if (in_array($perConfiguracionesGeneralesOp5, $_SESSION['usu_permiso'])) { ?>
                  <li><a href="sede"> IBP</a></li>
                  
                  <?php // } if (in_array($perGrupoOp5, $_SESSION['usu_permiso'])) { ?>
                  <li><a href="usuario?_tipo_usuario=3"> Forum Leader</a></li>
                  <li><a href="grupos"> Grupo</a></li>
                  
                  <?php // } ?>
                   <?php // if (in_array($perMantenedorIndustriasOp5, $_SESSION['usu_permiso'])) { ?>
                    <li><a href="industrias"> Industria</a></li>
                    <?php }  ?>
                  <!--<li><a href="mantenedorleaderregional">Leader Regional</a></li>-->
                </ul>
               </div>
            </div>
            <!-- /.box-body -->       
          </div>
    <?php  } ?>      
    <?php  if (in_array($perConfiguracionesOp5, $_SESSION['usu_permiso'])) { ?>
         <div class="box box-info">
            <div class="box-header with-border">
              <h4 class="box-title">Configuraciones</h4>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
 

              <div class="list-group">
                  <ul class="nav">
                    <?php if (in_array($perMantenedorPerfilOp5, $_SESSION['usu_permiso'])) { ?>
                    <li><a href="mantenedorperfil"> Perfil</a></li>
                    <?php } if (in_array($perPermisosOp5, $_SESSION['usu_permiso'])) { ?>
                    <li><a href="controlseguridad"> Control Seguridad</a></li>
                    <?php } if (in_array($perMantenedorUsuarioOp5, $_SESSION['usu_permiso'])) { ?>
                    <li><a href="usuario?_tipo_usuario=1"> Usuario</a></li>
                    <?php } ?>
                    <li><a href="mantenedorcargo">Cargo del Miembro</a></li>
                    <li><a href="mantenedorciudad">Ciudad</a></li>
                    <li><a href="mantenedordireccion">Dirección</a></li>
                    
                   
                    <li><a href="mantenedorprovincia">Estado / Provincia</a></li>
                    <!--<li><a href="mantenedorestadoprospecto">Estado Prospecto</a></li>-->
                    <li><a href="mantenedorestadopresupuesto">Estado Monetario</a></li>
                    <li><a href="mantenedorformapago">Forma Pago</a></li>
                    <li><a href="mantenedormembresia">Membresia</a></li>
                    <!--<li><a href="mantenedorstatusmember">Status Member</a></li>-->                   
                    <!--<li><a href="mantenedorfuente">Fuentes</a></li>-->
                    
                    
                  </ul>
              </div>
            </div>    

          </div>
      
    <?php  } ?>