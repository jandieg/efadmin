<body class="hold-transition login-page">
    <div class="login-box">
        <div class="modal fade" id="modal_recordarPass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!--Para que aparesca el rectangulo-->
                    <div class="modal-header">
                        <!--Para que tenga un margen-->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Recordar Clave</h4>
	            </div>
                    <div class="modal-body" id="modal_recordarPass_body">
                        <div id="frm_perfilUsuario" class="form-medium" >
                            <div class="form-group">
                                <label for="email_usuario">Email del usuario</label>
                                <input type="email" class="form-control" name="email_usuario" id="email_usuario" placeholder="Email del usuario" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onClick="recordarClave()">Enviar</button>
		    </div>
                </div>
           </div>
	</div> 
        <div class="login-logo">
            <a href="#"><b>Renaissance</b><br>Executive Forums</a>
        </div>
        <div class="login-box-body">
            <h3><p class="login-box-msg">Ingreso al Sistema</p></h3>    
            <form class="form-signin" action="login" method="post" enctype="multipart/form-data">

            <?php 
            if (isset($_SESSION['OK']) && $_SESSION['OK']=="NO") { ?>
                    <div class="alert alert-warning" role="alert">
                            <label><?php echo $_SESSION['E_MSG'];?></label>
                    </div>
            <?php
                    session_destroy();
                    unset($_SESSION);
            }	
                    
            ?>
                <div class="form-group has-feedback">
                    <input type="text" name="usua_usuario" id="usua_usuario" class="form-control" placeholder="Usuario" required autofocus>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" id="usua_clave" name="usua_clave" class="form-control" placeholder="Contraseña" required value="">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <?php 
                    //echo $listaSedes;
					//echo $listapais;
                ?> 
                <!--
                <div class="form-group has-feedback" ">
<?php

$select_status = "<select class='form-control' name='pais' id='pais' required>\n";
$select_status .= "<option value=''>-- Seleccione Pais--</option>\n";
$dataset = "SELECT * FROM pais  ORDER By pai_nombre ASC";
$res = mysqli_query($con,$dataset);
while($row2=mysqli_fetch_array($res)) {
  $select_status .= "<option value='".$row2['pai_id']."'";
  if (strtolower($row2['pai_id']) == strtolower($row['pai_id'])) {
    $select_status .= " selected='selected'>".utf8_encode($row2['pai_nombre']).''."</option>\n";
  } else {
    $select_status .= ">".utf8_encode($row2['pai_nombre']).''."</option>\n";
  }
} 
$select_status .= "</select>\n";

echo $select_status;


?>	



                  
                </div>
                -->
                
                <div class="social-auth-links text-center">
                    <button class="btn btn-block btn-social btn-facebook btn-flat" type="submit" ><i class="fa fa-user"></i>Ingresar</button>	
                </div>
            </form>
            <!--<a href="#" aria-hidden='true' data-toggle='modal' data-target='#modal_recordarPass'>Recordar contraseña</a><br>-->
      </div>
    </div>
  

