<?php
session_start();
?>
<div class="box box-info">
<section class="content">
      <!-- title row -->
      <div class="row">
        <div class="col-md-12">
          <h2 class="page-header">
            <i class="fa fa-user"></i> {cabecera}
              {boton}
          </h2>
          
        </div>
       
      </div>

      <div class="row">    
        <div class="col-md-6">
             {contenedor_1}
        </div>     
        <div class="col-md-6">
          {contenedor_2}
        </div> 
          
      </div>
      
       <div class="row">
        <div class="col-md-6">
            
            <h2 class="page-header">                
                Correos</h2>    
             {contenedor_11}
        </div>
        <div class="col-md-6">
            <h2 class="page-header">                
                Teléfono</h2> 
            {contenedor_12}
        </div>      
      </div>
      
       <div class="row">
            <div class="col-md-12">
            <h2 class="page-header">
              Dirección 
            </h2>

          </div>
        <div class="col-md-6">
             {contenedor_3}
        </div>
        <div class="col-md-6">
            {contenedor_4}
        </div>      
      </div>
       <div class="row" style="visibility:hidden;">    

        <div class="col-md-6">
            <h2 class="page-header">
              Lista de Hobbies 
            </h2>
             {contenedor_5}
        </div>
       
        <div class="col-md-6">
            <h2 class="page-header">
              Lista de Desafíos 
            </h2>
             {contenedor_6}
        </div>    
      </div>
     
   
    </section>  
    </div> 