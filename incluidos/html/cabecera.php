<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container" >
        <div class="navbar-header">
             <?php if (in_array($perVerMenúVerticalOp4, $_SESSION['usu_permiso'])) { ?>
                <a href="sede" class="navbar-brand"><b>Renaissance Executive Forums</b></a>
              <?php } else { ?>
                <a href="" class="navbar-brand"><b>Renaissance Executive Forums</b></a>
                <!--<a href="perfil" class="navbar-brand"><b>Renaissance Executive Forum</b></a>-->
              <?php }// if (in_array($perVerPerfilMiembroOp12, $_SESSION['usu_permiso'])) { ?>
                <!--<a href="" class="navbar-brand"><b>Renaissance Executive Forum</b></a>-->
              <?php // }  ?>
                
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
             <ul class="nav navbar-nav">
                  <?php /*if (in_array($perCandidatoOp4, $_SESSION['usu_permiso'])) { ?>
                  <li><a href="prospectos?_esaplicante=0">Prospectos</a></li>
                  
                  <?php }*/ if (in_array($perProspectoOp4, $_SESSION['usu_permiso'])) { ?>
                  <li><a href="prospectos?_esaplicante=1">Aplicantes</a></li>
                  
                  <?php } if (in_array($perMiembroOp4, $_SESSION['usu_permiso'])) { ?>
                  <li><a href="miembros">Miembros</a></li>
                  
                  <?php } if (in_array($perEmpresaOp4, $_SESSION['usu_permiso'])) { ?>
                  <li><a href="empresas">Empresas</a></li>
                  
                  <?php } if (in_array($perGruposOp4, $_SESSION['usu_permiso'])) { ?>
                   <li><a href="forumgrupo">Grupos</a></li>
                   
                   <?php } if (in_array($perActividadesOp4, $_SESSION['usu_permiso'])) { ?>
                  <!--<li><a href="actividades">Actividades</a></li>-->
                   
            
                    <?php } if (in_array($perEventosOp4, $_SESSION['usu_permiso'])) { ?>
                   <li><a href="eventos">Eventos</a></li>
                  
                  <?php }  ?>
                  <!--El menú del Candidato--> 
                  <?php  if (in_array($perMiembroCalendarioOp4, $_SESSION['usu_permiso'])) { ?>
                    <li><a href="miembroforum">Mi Calendario</a></li>
                  <?php } if (in_array($perMiembroGrupoOp4, $_SESSION['usu_permiso'])) { ?>
                    <li><a href="miembrogrupo">Mi Grupo</a></li>
                  
                  <?php } if (in_array($perMiembroEstadoCuentaOp4, $_SESSION['usu_permiso'])) { ?>
                    <li><a href="miembromembresia">Mi Estado de Cuenta</a></li>

                 <?php } if (in_array($perFinancieroOp11, $_SESSION['usu_permiso'])) { ?>
                    <li><a href="financiero">Financiero</a></li>
                 <?php } if (in_array($perAsistenciaOp11, $_SESSION['usu_permiso'])) { ?>
                    <li><a href="asistencia">Asistencia</a></li>
                 <?php } ?>
                    
                    <!--Para los permisos del usuario Lider Regional-->
                    <?php if (in_array($perGlobalMiembrosOp12, $_SESSION['usu_permiso'])) { ?>
                  <!--<li><a href="globalmiembros">Miembros</a></li>-->
                  
                  <?php } ?>

                </ul>
          
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
           
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
             <?php if (in_array($perVerMenúVerticalOp4, $_SESSION['usu_permiso'])) { ?>
                <a  href="sede"><i class="fa fa-gears fa-fw"></i></a>
             <?php } else { ?>
                <a  href=""><i class="fa fa-gears fa-fw"></i></a>
             <?php } ?>
   
            </li>
            
            <li class="dropdown user user-menu">     
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="public/images/u2.png" class="img-circle" alt="User Image">
                <p><?php echo $_SESSION['user_name'];//$_SESSION['user_subasedatos'];?></p>
                <p><?php echo $_SESSION['user_perfil'] ;?></p>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                     <?php if (in_array($perVerPerfilOp4, $_SESSION['usu_permiso'])) { ?>
                        <a href="perfil" class="btn btn-default btn-flat">Perfil</a>
                      <?php } if (in_array($perVerPerfilMiembroOp12, $_SESSION['usu_permiso'])) { ?>
                        <a href="miembroperfil" class="btn btn-default btn-flat">Perfil</a>

                    <?php }  ?>
                </div>
                <div class="pull-right">
                  <div class="btn btn-default btn-falt" onclick="cambiarClave()">Cambiar contraseña</div>
                </div>
                <div class="pull-right">
                  <a href="logout" class="btn btn-default btn-flat">Cerrar Sesión</a>
                </div>
              </li>
            </ul>
          </li>
          
          </ul>
            
            
        </div>
        
      </div>
  
    </nav>
</header>