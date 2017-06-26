  <?php include(HTML."/cabecera.php"); ?>
  <div class="content-wrapper">
    <div class="container">
     <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-3">     
               <?php // include(HTML."/menu_config.php");?>
            </div>
            <div class="center-block col-md-12">
               
                <!--<div class="box box-danger">-->
        
                    
                    </br></br></br></br></br>
                 <div class="box-body no-padding  ">
                  <ul class="users-list clearfix">
                 
                    <?php  if (in_array($perCobrosOp11, $_SESSION['usu_permiso'])) { ?>
                        <li>
                          <img src="public/images/cobro.jpg" alt="User Image">
                          <h2><a class="users-list-name" href="cobros">Cobros</a></h2>
                        </li>
                    <?php } /*if (in_array($perPagosOp11, $_SESSION['usu_permiso'])) { ?>
                        <li>
                          <img src="public/images/pago.jpg" alt="User Image">
                          <h2><a class="users-list-name" href="pagos">Pagos</a></h2>
                        </li>
                    <?php }*/ if (in_array($perReportesOp11, $_SESSION['usu_permiso'])) { ?>
                        <li>
                          <img src="public/images/reportes.jpg" alt="User Image">
                          <h2><a class="users-list-name" href="reporting">Reportes</a></h2>
                        </li>
                        
                    <?php } if (in_array($perPresupuestoOp11, $_SESSION['usu_permiso'])) { ?>
                    <li>
                      <img src="public/images/presupuesto.jpg" alt="User Image">
                      <h2><a class="users-list-name" href="presupuesto">Presupuesto</a></h2>
                    </li>   
                        
                        
                    <?php } ?>    
                  </ul>
                  <!-- /.users-list -->
                </div>

              <!--</div>-->
            <!--</div>-->
          </div>
        </section>
      </div>
  </div>

