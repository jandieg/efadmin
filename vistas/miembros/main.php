 
 <?php
 
 if(!isset($_GET['id_miembro'])){ 
 
 ?>
 
  <?php include(HTML."/cabecera.php"); ?>
   <div class="content-wrapper">
    <div class="container">
     <!-- Main content -->
        <section class="content">            
          <div class="row">
            <div class="col-md-12">
                  <div id="ben_contenedor">   
                    <?php echo $t; ?>
                  </div>
                  </div>
                  <div id="ben_contenedor2" style="display: none;">
                  </div>
            </div>
          </div>
        </section>
      </div>
  </div>
  <?php }else{ ?>
<?php include(HTML."/cabecera.php"); ?>
   <div class="content-wrapper">
<div class="container">
     <!-- Main content -->
        <section class="content">            
          <div class="row">
            <div class="col-md-12">
                  <div id="ben_contenedor" style="display: none;">   
                    <?php echo $t; ?> 
                  </div>
                  </div>
                  <div id="ben_contenedor2" >
                   <?php echo $t2; ?>
                  </div>
            </div>
          </div>
        </section>
      </div>
  </div> 
  
  <?php }?>

