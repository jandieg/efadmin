  <?php include(HTML."/cabecera.php"); ?>
  <div class="content-wrapper">
    <div class="container">
       <section class="content">
            <?php 
                if (in_array($perCrearEventoOp10, $_SESSION['usu_permiso'])) {
            ?> 
                <div class="row">
                  <div id="ben_contenedor">
                    <div class="col-md-3">
                      <?php echo $contenido; ?> 
                    </div>  
                      <div class="col-md-9">
                          <div id="ben_contenedor">      
                            <div class="box box-primary">
                            <div class="box-body no-padding">

                              <div id="calendar"></div>
                            </div>

                          </div>
                      </div>
                  </div>
                </div>
              </div>
           
            <?php 
                }else{
            ?> 
                <div class="row">
                      <div id="ben_contenedor">  
                          <div class="col-md-12">
                              <div id="ben_contenedor">      
                                <div class="box box-primary">
                                <div class="box-body no-padding">

                                  <div id="calendar"></div>
                                </div>

                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
           
           <?php 
                }
            ?> 
           
        </section>
      </div>
  </div>

