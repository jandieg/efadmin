<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container" >
        <div class="navbar-header">
     
            <a href="" class="navbar-brand"><b>Renaissance Executive Forum</b></a>
 
                
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
             <ul class="nav navbar-nav">
               
                
                <li><a href="globalmiembros">Miembros</a></li>
                </ul>
          
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
           
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
      
                <a  href=""><i class="fa fa-gears fa-fw"></i></a>
             
   
            </li>
            
            <li class="dropdown user user-menu">     
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="public/images/u2.png" class="img-circle" alt="User Image">
                <p><?php echo $_SESSION['user_name'] . ' '.$_SESSION['db'];?></p>
                <p><?php echo $_SESSION['user_perfil'] ;?></p>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                    <a href="perfil" class="btn btn-default btn-flat">Perfil</a>
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