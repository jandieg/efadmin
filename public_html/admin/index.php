<?php
if(!isset($_SESSION)){
    session_set_cookie_params(0);
    session_start();  
}
//session_destroy();
//unset($_SESSION);
define ("E_RAIZ","../../");
define("E_LIB",E_RAIZ."incluidos/");
define("E_VISTAS",E_RAIZ."vistas/");
define("MODELO",E_LIB."modelo/");
define("MODELO2",E_LIB."modelo2/");
define("HTML",E_LIB."html/");
define("LENGUAJE",E_LIB."lenguaje/");
define("PERMISOS",E_LIB."permisos/");
define("SCRIPT",E_LIB."script/");
require_once E_LIB.'Conexion.php';
require_once E_LIB.'msg.php';
require_once E_LIB.'funciones.php';
require_once E_LIB.'Bases.php';
include(PERMISOS."/permisos.php");
include(LENGUAJE."/lenguaje_2.php");
include(E_LIB."custom_functions.php");
date_default_timezone_set ("America/Guayaquil");
include_once("../../incluidos/db_config/config.php");
$_SITE_PAGES = listaDir(E_VISTAS,"dir");
                   
if(isset($_REQUEST['url'])){
    if(in_array($_REQUEST['url'],$_SITE_PAGES)){
        //Para verificar que a iniciado sesion
        if($_REQUEST['url'] != 'login' && !isset($_SESSION['user_id_ben'])){
            redirect("login");
	}elseif ($_REQUEST['url'] == 'login' && isset($_SESSION['user_id_ben'])){//en caso que este iniciada la sesion e ingrese la url login
            redirect("sede");
        }else {
            define("E_PAGE", $_REQUEST['url']);
        }
		
		define("E_PAGE", $_REQUEST['url']);
     }  else {//en caso que la url no exista
         isset($_SESSION['user_id_ben'])? redirect("sede") : redirect("login");
     }
}else {//cuando escribe la url /
    isset($_SESSION['user_id_ben'])? redirect("sede") : redirect("login");       
}
if(file_exists(E_VISTAS.E_PAGE."/head.php")){
            include(E_VISTAS.E_PAGE."/head.php");
}
?>
<!DOCTYPE html>
<html>
   <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">     
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Executive Forum</title>
        <!--Librerias-->
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="public/framework/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="public/framework/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="public/framework/plugins/iCheck/square/blue.css">  
        <!-- iCheck for checkboxes and radio inputs -->
        <!--<link rel="stylesheet" href="public/framework/plugins/iCheck/all.css">-->
        <!-- Select2 -->
        <link rel="stylesheet" href="public/framework/plugins/select2/select2.min.css">
        <!-- Datepicker -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="public/framework/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="public/css/jquery.msg.css">
        <link rel="stylesheet" href="public/framework/plugins/cropper/cropper.min.css">
        <link rel="stylesheet" href="public/tabverticales/bootstrap.vertical-tabs.css">
       
        <link rel="stylesheet" href="public/framework/dist/css/skins/_all-skins.min.css">  
        <link rel="stylesheet" href="public/framework/plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" href="public/framework/plugins/datatables/extensions/FixedColumns/css/dataTables.fixedColumns.min.css" />
        
        <?php
            if(file_exists(E_VISTAS.E_PAGE."/css.php")){
                include(E_VISTAS.E_PAGE."/css.php");
            }
             if(file_exists(E_VISTAS.E_PAGE."/functionscript.php")){
                include(E_VISTAS.E_PAGE."/functionscript.php");
            }
        ?>
        
                  <!-- jQuery 2.1.4 -->
        <script src="public/framework/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="public/framework/plugins/jQueryUI/jquery-ui.min.js"></script>
        <script src="public/framework/plugins/cropper/cropper.min.js"></script>

        <!-- Bootstrap 3.3.5 -->
        <script src="public/framework/bootstrap/js/bootstrap.min.js"></script>

        <script>
		
		//alert('USER ID:' + <?php echo $_SESSION['user_id_ben']; ?>);
function export_to_excel(sourceid){
	//var sourceid = $('#xtitle').val();
	if (confirm("Esta seguro de exportar los datos de: "+ sourceid +" al excel?")) {
	var dataString = "source=" + sourceid + "&page=exporting";
	$.ajax({  
		type: "POST",  
		url: "export_to_excel.php",  
		data: dataString,
		beforeSend: function() 
		{
		$('html, body').animate({scrollTop:0}, 'slow');
			$("#excel").html('<button type="submit" title="Exportar" class="btn btn-info pull-right" >Exportando...</button> ');
		},  
		success: function(response)
		{
		//	$("#excel").html('Descargar');
			$("#excel").html(response);
		}
	});
}
	
}
function eventReport(){
    if ($("#month").val() != 'cdm') {
        var month = $('#month').val();
        if (confirm("Esta seguro de generar un reporte del mes seleccionado?")) {
            var dataString = "month=" + month + "&page=eventReport";
            $.ajax({  
                type: "POST",  
                url: "export_to_excel.php",  
                data: dataString,
                beforeSend: function() 
                {
                $('html, body').animate({scrollTop:0}, 'slow');
                    $("#excel_btn").html('Generando....');
                },  
                success: function(response)
                {
                //	$("#excel").html('Descargar');
                    $("#excel_btn").html(response);
                }
            });
        }
    } else {
        if ($("#_grupos").val() != null) {        
            var parametros = {
                KEY: 'KEY_CASO_DEL_MES',
                _id: $("#_grupos").val().toString()
            };
            $.ajax({
                type: "POST",
                url: 'eventos',
                data: parametros,
                beforeSend: function () {
                    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                },
                success:  function (mensaje) {
                    $.msg('unblock');
                        $("#ben_contenedor").html(mensaje);                    
                },error : function(xhr, status) {
                    $.msg('unblock');
                    $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
                }                
            });
        } else {
            alert("disculpe debe seleccionar un grupo");
        }
    }
	
	
}
function faReport(){
	var month = $('#month2').val();
	if (confirm("Esta seguro de generar un reporte del mes seleccionado?")) {
	var dataString = "month=" + month + "&page=faReport";
	$.ajax({  
		type: "POST",  
		url: "export_to_excel.php",  
		data: dataString,
		beforeSend: function() 
		{
		$('html, body').animate({scrollTop:0}, 'slow');
			$("#excel_btn2").html('Generando....');
		},  
		success: function(response)
		{
		//	$("#excel").html('Descargar');
			$("#excel_btn2").html(response);
		}
	});
}
	
}
function do_report(type,userid){
	var year = $('#_año').val();
	var group = $('#_grupo').val();
    var fecha_corte = $("#_fecha_corte").val().toString();
	
		var page=type;
        var dataString = "";
        if (type == "fullReport") {
            dataString =  "userid=" + userid + "&group=" + group + "&page=" + page + "&fechacorte=" + fecha_corte;
        } else {
            dataString = "year=" + year + "&userid=" + userid + "&group=" + group + "&page=" + page;
        }
	
	$.ajax({  
		type: "POST",  
		url: "reports.php",  
		data: dataString,
		beforeSend: function() 
		{
		$('html, body').animate({scrollTop:0}, 'slow');
			$("#"+type).html('<a class="btn btn-info">Generando...</a>');
		},  
		success: function(response)
		{
		//	$("#excel").html('Descargar');
		//$("#"+type).html('Generando....');
			$("#"+type).html(response);
		},
		 timeout: 30000,
    async: false
	});
}
function ResetReports(id){
	
	var dataString = "id=" + id + "&page=ResetReports";
	$.ajax({  
		type: "POST",  
		url: "reports.php",  
		data: dataString,
		success: function(response)
		{
			$("#report"+id).html(response);
			$("#ActivityReport").html("GENERAR REPORTE DE ACTIVIDAD");
			
		}
	});
}
	
		</script>
       <script>
            var getCargarCiudades = function(){
                  var parametros = {
                        KEY: 'KEY_SHOW_COMBO_CIUDAD',
                        _id_ciudad: $("#_ciudad").val().toString()
                    };
                    $.ajax({
                        data:  parametros,
                        url:   'mantenedordireccion',
                        type:  'post',
                        dataType : 'json',
                        beforeSend: function () {
                            //$.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                        },
                        success:  function (mensaje) {
                            //$.msg('unblock');
                                if(mensaje.success == "true"){
                                    $("#_sede").html( mensaje.sede);
                                    $(".select2").select2();
                                }else{
                                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                            }
                        },error : function(xhr, status) {
                            //$.unblockUI();
                            //$.msg('unblock');
                            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                        }
                    });    
            };
            var getCargarProvincias = function(){
                  var parametros = {
                        KEY: 'KEY_SHOW_COMBO_PROVINCIA',
                        _id_provincia: $("#_provincia").val().toString()
                    };
                    $.ajax({
                        data:  parametros,
                        url:   'mantenedordireccion',
                        type:  'post',
                        dataType : 'json',
                        beforeSend: function () {
                            //$.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                        },
                        success:  function (mensaje) {
                            //$.msg('unblock');
                                if(mensaje.success == "true"){
                                    $("#_ciudad").html( mensaje.ciudad);
                                    //$("#_sede").html( mensaje.sede);
                                    $(".select2").select2();
                                }else{
                                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                            }
                        },error : function(xhr, status) {
                            //$.unblockUI();
                            //$.msg('unblock');
                            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                        }
                    });    
            };
            var getCargarPaises = function(){
                  var parametros = {
                        KEY: 'KEY_SHOW_COMBO_PAIS',
                        _id_pais: $("#_pais").val().toString()
                    };
                    $.ajax({
                        data:  parametros,
                        url:   'mantenedordireccion',
                        type:  'post',
                        dataType : 'json',
                        beforeSend: function () {
                            //$.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                        },
                        success:  function (mensaje) {
                            //$.msg('unblock');
                                if(mensaje.success == "true"){
                                    $("#_provincia").html( mensaje.provincia);
                                    $("#_ciudad").html( mensaje.ciudad);
                                    $("#_prefijo_telefono").val( mensaje.prefijo);
                                    $("#_prefijo_celular").val( mensaje.prefijo);
                                    //$("#_sede").html( mensaje.sede);
                                    $(".select2").select2();
                                }else{
                                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                            }
                        },error : function(xhr, status) {
                            //$.unblockUI();
                            //$.msg('unblock');
                            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                        }
                    });    
            };

            var getConfTablaFixed = function() {
                $('#latabla').DataTable( {
                    scrollY:        "500px",
                    scrollX:        true,
                    scrollCollapse: true,
                    ordering: false,
                    paging:         false,
                    fixedColumns:   {
                        leftColumns: 2
                    }
                }); 
            };

       
            var getConfTabla= function (){
                $(function () {
                    if ( $.fn.dataTable.isDataTable( '#tipo_personalizada' ) ) {
                        $('#tipo_personalizada').DataTable({
                                 "aLengthMenu": [[ 15, 50,75,100, -1], [ 15, 50,75,100, "All"]],
                                 "iDisplayLength": 15, 
                                 "iDisplayStart": 0,
                                 "language": {
                                     "sProcessing":    "Procesando...",
                                     "sLengthMenu":    "Mostrar _MENU_ registros",
                                     "sZeroRecords":   "No se encontraron resultados",
                                     "sEmptyTable":    "Ningún dato disponible en esta tabla",
                                     "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                                     "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
                                     "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
                                     "sInfoPostFix":   "",
                                     "sSearch":        "Buscar:",
                                     "sUrl":           "",
                                     "sInfoThousands":  ",",
                                     "sLoadingRecords": "Cargando...",
                                     "oPaginate": {
                                         "sFirst":    "Primero",
                                         "sLast":    "Último",
                                         "sNext":    "Siguiente",
                                         "sPrevious": "Anterior"
                                     },
                                     "oAria": {
                                         "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                         "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                     }
                                 }
                             });
                    }
                    else {
                        $('#tipo_personalizada').DataTable({
                                 "aLengthMenu": [[ 15, 50,75,100, -1], [ 15, 50,75,100, "All"]],
                                 "iDisplayLength": 15, 
                                 "iDisplayStart": 0,
                                 "paging": false,
                                 "language": {
                                     "sProcessing":    "Procesando...",
                                     "sLengthMenu":    "Mostrar _MENU_ registros",
                                     "sZeroRecords":   "No se encontraron resultados",
                                     "sEmptyTable":    "Ningún dato disponible en esta tabla",
                                     "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                                     "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
                                     "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
                                     "sInfoPostFix":   "",
                                     "sSearch":        "Buscar:",
                                     "sUrl":           "",
                                     "sInfoThousands":  ",",
                                     "sLoadingRecords": "Cargando...",
                                     "oPaginate": {
                                         "sFirst":    "Primero",
                                         "sLast":    "Último",
                                         "sNext":    "Siguiente",
                                         "sPrevious": "Anterior"
                                     },
                                     "oAria": {
                                         "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                         "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                     }
                                 }
                             });
                    }
                              
                });
            };                        
            
            var setPerfilActualizarUserPass = function(){
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                var parametros = {
                        KEY: 'KEY_ACTUALIZAR_CREDENCIALES',  
                        _id: $("#_id_credenciales").val().toString(),
                        _user: $("#_user_credenciales").val().toString(),
                        _contraseña: $("#_clave_credenciales").val().toString(),
                        _confirmar: $("#_confirmar_credenciales").val().toString()
                    };
                $.ajax({
                    data:  parametros,
                    url:   'usuario',
                    type:  'post',
                    dataType : 'json',
                     beforeSend: function () {
                        $("#btnActualizarUserClave").html('Actualizando ...');
                        $('#btnActualizarUserClave').attr("disabled", true);
                    },
                    success:  function (mensaje) {  
                        $.msg('unblock');
                        if(mensaje.success == "true"){
                            $("#_clave_credenciales").val('');
                            $("#_confirmar_credenciales").val('');
                            $('#modal_getCrearUserClave').modal('toggle');
                            $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                            //getRecargar();
                        }else{
                            $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        }
                        $("#btnActualizarUserClave").html('Guardar');
                        $('#btnActualizarUserClave').attr("disabled", false);
                    },error : function(xhr, status) { 
                        $.msg('unblock');
                        $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                    }
                });
            };
            ////////////////////////////////////////////////////////////////////
            //Agregar empresas a prospecto, aplicante y miembro 
            var getAgregarEmpresa = function(_id_miembro){
                $("#_id_miembro_empresa").val(_id_miembro);
                  var parametros = {
                        KEY: 'KEY_SHOW_COMBO_EMPRESAS',
                        _id_miembro: _id_miembro
                    };
                    $.ajax({
                        data:  parametros,
                        url:   'miembros',
                        type:  'post',
                        dataType : 'json',
                        success:  function (mensaje) {
                                if(mensaje.success == "true"){
                                    $("#_lista_empresa").html( mensaje._lista_empresa);
//                                    $("#_lista_tipo_empresa").html( mensaje._lista_tipo_empresa);
                                    $(".select2").select2();
                                    
                                    $('#modal_getAddEmpresa').modal('toggle');
                                    $(".select2").select2();
                                }else{
                                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                            }
                        },error : function(xhr, status) {
                            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                        }
                    });    
            };
            var setAddEmpresa = function(_bandera){
                $("#btnAddEmpresa").html('Agregando Empresa ...');
                $('#btnAddEmpresa').attr("disabled", true);
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                var parametros = {
                            KEY: 'KEY_ADD_EMPRESA',
                            _id_miembro: $("#_id_miembro_empresa").val().toString(),
                            _descripcion_empresa: '',
                            _empresas: $("#_empresas").val().toString(),
                            _bandera:_bandera,
                            _tipo: '1'//$("#_tipo_empresas_pam").val().toString()
                    };
                    $.ajax({
                        data:  parametros,
                        url:   'miembros',
                        type:  'post',
                        dataType : 'json',
                        success:  function (mensaje) { 
                                $.msg('unblock');
                                if(mensaje.success == "true"){
                                    $('#modal_getAddEmpresa').modal('toggle');
                                    $('#btnAddEmpresa').attr("disabled", false);
                                    $("#btnAddEmpresa").html('Guardar');
                                    getDetalle($("#_id_miembro_empresa").val().toString());
                                }else{
                                    $('#btnAddEmpresa').attr("disabled", false);
                                    $("#btnAddEmpresa").html('Guardar');
                                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                                }
                        },error : function(xhr, status) {
                           $.msg('unblock');
                           $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                        }
                    });
            };                     
            var getActualizarEmpresa = function(_id_miembro, _mie_emp_id, _id_empresa, _descripcion, _id_tipo){
         
                $("#_id_miembro_empresa_u").val(_id_miembro);
                $("#_id_mie_emp_empresa_u").val(_mie_emp_id);
                $("#_descripcion_empresa_u").val(_descripcion);
                  var parametros = {
                        KEY: 'KEY_SHOW_COMBO_EMPRESAS',
                        _id_miembro: _id_miembro,
                        _is_actualizacion:'x'
                    };
                    $.ajax({
                        data:  parametros,
                        url:   'miembros',
                        type:  'post',
                        dataType : 'json',
                        success:  function (mensaje) {
                                if(mensaje.success == "true"){
//                                    $("#_lista_tipo_empresa_u").html( mensaje._lista_tipo_empresa);
//                                    $("#_tipo_empresas_pam_u").val(_id_tipo);
                                    
                                    $("#_lista_empresa_u").html( mensaje._lista_empresa);
                                    $("#_empresas_u").val(_id_empresa);
                                    $(".select2").select2();
                                    $('#modal_getActualizarEmpresa').modal('toggle');
                                }else{
                                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                            }
                        },error : function(xhr, status) {
                            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                        }
                    });    
            };
            var setActualizarEmpresa = function(_bandera){
                $("#setActualizarEmpresa").html('Actualizar Empresa ...');
                $('#setActualizarEmpresa').attr("disabled", true);
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                var parametros = {
                            KEY: 'KEY_ACTUALIZAR_MIEMBRO_EMPRESA',
                            _id_miembro_empresa: $("#_id_mie_emp_empresa_u").val().toString(),
                            _descripcion_empresa: '',
                            _empresas: $("#_empresas_u").val().toString(),
                            _bandera:_bandera,
                            _tipo: '1'//$("#_tipo_empresas_pam_u").val().toString()
                    };
                    $.ajax({
                        data:  parametros,
                        url:   'miembros',
                        type:  'post',
                        dataType : 'json',
                        success:  function (mensaje) { 
                                $.msg('unblock');
                                if(mensaje.success == "true"){
                                    $('#modal_getActualizarEmpresa').modal('toggle');
                                    $('#setActualizarEmpresa').attr("disabled", false);
                                    $("#setActualizarEmpresa").html('Guardar');
                                    getDetalle($("#_id_miembro_empresa_u").val().toString());
                                }else{
                                    $('#setActualizarEmpresa').attr("disabled", false);
                                    $("#setActualizarEmpresa").html('Guardar');
                                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                                }
                        },error : function(xhr, status) {
                           $.msg('unblock');
                           $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                        }
                    });
            };
            var setEliminarEmpresa = function(_id_miembro_empresa,_id_miembro,_bandera){
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                var parametros = {
                            KEY: 'KEY_DELETE_EMPRESA',
                            _id_miembro_empresa: _id_miembro_empresa,
                            _bandera:_bandera
                    };
                    $.ajax({
                        data:  parametros,
                        url:   'miembros',
                        type:  'post',
                        dataType : 'json',
                        success:  function (mensaje) { 
                                $.msg('unblock');
                                if(mensaje.success == "true"){
                                    getDetalle(_id_miembro);
                                }else{
                                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                                }
                        },error : function(xhr, status) {
                           $.msg('unblock');
                           $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                        }
                    });
                };    
            var getPAMAgregarAsistente = function(id){
    
                    $("#_id_asistente").val(id.toString()); 
                };
            var getPAMLimpiar = function(){
                $("#_id_asistente").val('');
                $("#_nombre_asistente").val('');
                $("#_correo_asistente").val('');
                $("#_movil_asistente").val('');
                $("#_apellido_asistente").val('');
                $("#_fijo_asistente").val('');
                $('#btnAddAsistente').attr("disabled", false);
                $("#btnAddAsistente").html('Guardar');
            };
            var setPAMAgregarAsistente = function(_bandera){
            //    alert($("#_id_asistente").val().toString()+ $("#_nombre_asistente").val().toString());
                $("#btnAddAsistente").html('Agregando Asistente ...');
                $('#btnAddAsistente').attr("disabled", true);
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                var parametros = {
                            KEY: 'KEY_GUARDAR_ASISTENTE',
                            _id_asistente: $("#_id_asistente").val().toString(),
                            _nombre_asistente: $("#_nombre_asistente").val().toString(),
                            _correo_asistente: $("#_correo_asistente").val().toString(),
                            _movil_asistente: $("#_movil_asistente").val().toString(),
                            _apellido_asistente: $("#_apellido_asistente").val().toString(),
                            _funcion_asistente: $("#_funcion_asistente").val().toString(),
                            _fijo_asistente: $("#_fijo_asistente").val().toString(),
                            _bandera:_bandera
                    };
                    $.ajax({
                        data:  parametros,
                        url:   'miembros',
                        type:  'post',
                        dataType : 'json',
                        success:  function (mensaje) { 
                            $.msg('unblock');
                            if(mensaje.success == "true"){
                                  $('#modal_getPAMCrearAsistente').modal('toggle');
                                  getDetalle($("#_id_asistente").val().toString());
                                  getPAMLimpiar();
                            }else{
                                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                                $('#btnAddAsistente').attr("disabled", false);
                                $("#btnAddAsistente").html('Guardar');
                            }
                        },error : function(xhr, status) {
                           $.msg('unblock');
                           $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                        }
                    });
            };
            var getPAMActualizarAsistente = function(id_miembro, id, nombre, apellido, movil, correo, funcion, fijo){
                $("#_id_miembro_u").val(id_miembro.toString());
                $("#_id_asistente_u").val(id.toString());
                $("#_nombre_asistente_u").val(nombre.toString());
                $("#_apellido_asistente_u").val(apellido.toString());
                $("#_correo_asistente_u").val(correo.toString());
                $("#_movil_asistente_u").val(Number(movil.toString().split(')')[1].trim()));
                $("#_movil_fijo_asistente_u").val(Number(fijo.toString().split(')')[1].trim()));
                
            //    $('#_funcion_asistente_u option[value="' + funcion + '"]').prop('selected', true);
                $("#_funcion_asistente_u").val(funcion);
                $(".select2").select2();
            };
            var setPAMActualizarAsistente = function(_bandera){
                $("#btnActAsistente").html('Actualizando Asistente ...');
                $('#btnActAsistente').attr("disabled", true);
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                
                var parametros = {
                            KEY: 'KEY_ACTUALIZAR_ASISTENTE',
                            _id_asistente: $("#_id_asistente_u").val().toString(),
                            _nombre_asistente: $("#_nombre_asistente_u").val().toString(),
                            _correo_asistente: $("#_correo_asistente_u").val().toString(),
                            _movil_asistente: $("#_movil_asistente_u").val().toString(),
                            _apellido_asistente: $("#_apellido_asistente_u").val().toString(),
                            _funcion_asistente: 1,
                            _fijo_asistente: $("#_movil_fijo_asistente_u").val().toString(),
                            _bandera:_bandera
                    };
                    $.ajax({
                        data:  parametros,
                        url:   'miembros',
                        type:  'post',
                        dataType : 'json',
                        success:  function (mensaje) { 
                                $.msg('unblock');
                                if(mensaje.success == "true"){
                                    $('#modal_getPAMActualizarAsistente').modal('toggle');
                                    $('#btnActAsistente').attr("disabled", false);
                                    $("#btnActAsistente").html('Guardar');
                                    getDetalle($("#_id_miembro_u").val().toString());
                                }else{
                                    $('#btnActAsistente').attr("disabled", false);
                                    $("#btnActAsistente").html('Guardar');
                                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                                }
                        },error : function(xhr, status) {
                           $.msg('unblock');
                           $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                        }
                    });
            };
            var setPAMEliminarAsistente = function(_id_miembro, _id_persona, _bandera, _id_tabla){
            //alert(_id_persona);
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                var parametros = {
                            KEY: 'KEY_DELETE_ASISTENTE',
                            _id_persona: _id_persona,
                            _bandera:_bandera,
                            _id_tabla: _id_tabla
                    };
                    $.ajax({
                        data:  parametros,
                        url:   'miembros',
                        type:  'post',
                        dataType : 'json',
                        success:  function (mensaje) { 
                                $.msg('unblock');
                                if(mensaje.success == "true"){
                                    getDetalle(_id_miembro);
                                }else{
                                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                                }
                        },error : function(xhr, status) {
                           $.msg('unblock');
                           $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                        }
                    });
            };
   
        </script>
        
        <style>
		.circle
    {
    width:220px;
    height:220px;
    border-radius:220px;
	border:#666 2px solid;
    font-size:50px;
    line-height:220px;
    text-align:center;
    background:#FFF;
	color:#666;
	font-size:22px;
    }
	</style>

    </head>
    <!--<body>-->      
        <!--<h1>Probando esta vaina</h1>-->
        <?php 
            if(file_exists(E_VISTAS.E_PAGE."/main.php")){
                include(E_VISTAS.E_PAGE."/main.php");
            }  
            if(file_exists(E_VISTAS.E_PAGE."/htmlmodal.php")){
                include(E_VISTAS.E_PAGE."/htmlmodal.php");
            }  
        ?>
        
         <!-- Select2 -->
        <!--<script src="public/framework/plugins/select2/select2.min.js"></script>-->
        <!-- Select2 -->
        <script src="public/framework/plugins/select2/select2.full.min.js"></script>
        
        <!-- iCheck -->
        <script src="public/framework/plugins/iCheck/icheck.min.js"></script>
        
        <script src="public/framework/plugins/slimScroll/jquery.slimscroll.min.js"></script>  
        <!-- iCheck 1.0.1 -->
        <!--<script src="public/framework/plugins/iCheck/icheck.min.js"></script>-->
        <!-- FastClick -->
        <script src="public/framework/plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="public/framework/dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="public/framework/dist/js/demo.js"></script>
        
        <script src="public/js/jquery.blockUI.js"></script>
        <script src="public/js/jquery.toaster.js"></script>
        <script src="public/js/msg/jquery.center.min.js"></script>
        <script src="public/js/msg/jquery.msg.min.js"></script>
        
        <script src="public/framework/plugins/datatables/jquery.dataTables.min.js"></script>
        
        <script src="public/framework/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>

        
        <?php
            if(file_exists(E_VISTAS.E_PAGE."/script.php")){
                include(E_VISTAS.E_PAGE."/script.php");
            }
        ?>
  
        <script>
           $(".select2").select2();
           getConfTabla();
        </script>
   
    </body>
</html>