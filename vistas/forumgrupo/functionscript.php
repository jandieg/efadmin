<script>
var getDetalleFiltroGrupo = function(id){
    var parametros = {
            KEY: 'KEY_DETALLE_FILTRO_GRUPO',
            idGrupo: id
    };
    $.ajax({
        data:  parametros,
        url:   'forumgrupo',
        type:  'post',
        beforeSend: function () {
            $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
        },
        success:  function (mensaje) {
            $.msg('unblock');
                $("#ben_contenedor").html(mensaje);
                getConfTabla();
        },error : function(xhr, status) {
            $.msg('unblock');
            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
        }
    });
};


var getFiltroEmpresa = function() {
    if ($("#_empresa").val().toString() != "x") {
        $("#_forum_leader").val("x");
        $("#_industria").val("x");
        sessionStorage._industria = $("#_industria").val().toString();
        sessionStorage._forum_leader = $("#_forum_leader").val().toString();            
        sessionStorage._empresa = $("#_empresa").val().toString();
        sessionStorage.llave = 'KEY_FILTRO_EMPRESA';
        sessionStorage._id = $("#_empresa").val().toString();
        var parametros = {
            KEY: 'KEY_FILTRO_EMPRESA',
            _id: $("#_empresa").val().toString()
        };
        console.log(sessionStorage);

        $.ajax({
            data:  parametros,
            url:   'forumgrupo',
            type:  'post',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                $.msg('unblock');
                    $("#ben_contenedor").html(mensaje);
                    getConfTabla();
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });
    }
};

var getFiltroForumLeader = function() {
    if ($("#_forum_leader").val().toString() != "x") {
        $("#_empresa").val("x");
        $("#_industria").val("x");
        sessionStorage._industria = $("#_industria").val().toString();
        sessionStorage._forum_leader = $("#_forum_leader").val().toString();            
        sessionStorage._empresa = $("#_empresa").val().toString();
        sessionStorage.llave = 'KEY_FILTRO_FORUM_LEADER';
        sessionStorage._id = $("#_forum_leader").val().toString();
        var parametros = {
            KEY: 'KEY_FILTRO_FORUM_LEADER',
            _id: $("#_forum_leader").val().toString()
        };

        $.ajax({
            data:  parametros,
            url:   'forumgrupo',
            type:  'post',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                $.msg('unblock');
                    $("#ben_contenedor").html(mensaje);
                    getConfTabla();
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });
    }
};

var getFiltroIndustria = function() {
    if ($("#_industria").val().toString() != "x") {
        $("#_forum_leader").val("x");
        $("#_empresa").val("x");
        sessionStorage._industria = $("#_industria").val().toString();
        sessionStorage._forum_leader = $("#_forum_leader").val().toString();            
        sessionStorage._empresa = $("#_empresa").val().toString();
        sessionStorage.llave = 'KEY_FILTRO_INDUSTRIA';
        sessionStorage._id = $("#_industria").val().toString();
        var parametros = {
            KEY: 'KEY_FILTRO_INDUSTRIA',
            _id: $("#_industria").val().toString()
        };

        $.ajax({
            data:  parametros,
            url:   'forumgrupo',
            type:  'post',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                $.msg('unblock');
                    $("#ben_contenedor").html(mensaje);
                    getConfTabla();
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });
    }
};

var setEnviarCorreoIndividual = function(){

        var parametros = {
                KEY: 'KEY_ENVIAR_CORREO_INDIVIDUAL',
                _correo_receptor: $("#_email_receptor").val().toString(),
                _email_asunto: $("#_email_asunto").val().toString(),
                _email_mensaje: $("#_email_mensaje").val().toString(),
                _email_key: $("#_email_key").val().toString(),
                _grupo: $("#_grupo").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'forumgrupo',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                $("#btnEnviarCorreo").html('Enviando correo ...');
                $('#btnEnviarCorreo').attr("disabled", true);
            },
            success:  function (mensaje) {
                    if(mensaje.success == "true"){
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        $('#modal_enviarCorreo').modal('toggle'); 
                        setLimpiar();
                        
                    }else{
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        $("#btnEnviarCorreo").html('Enviar');
                        $('#btnEnviarCorreo').attr("disabled", false);
                    }
            },error : function(xhr, status) {
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });

};
var setLimpiar = function (){
    $('iframe').contents().find('.wysihtml5-editor').html('');
    $("#_email_receptor").val("");
    $("#_email_asunto").val("");
    $("#_email_mensaje").val("");
    $("#btnEnviarCorreo").html('Enviar');
    $('#btnEnviarCorreo').attr("disabled", false);
    $("#_email_receptor_nombre").val("");
     $("#_email_key").val("");
};
var getEnviarCorreoIndividual = function( correo_receptor,_nombre_receptor,_email_key){
   setLimpiar();
   $("#_email_receptor").val(correo_receptor.toString());
   $("#_email_receptor_nombre").val(_nombre_receptor.toString());
   $("#_email_key").val(_email_key.toString());
   
   if(_email_key == '2'){
       $("#_email_receptor_nombre").val($("#_grupo option:selected").text());
   }
   
};
//var getEnviarCorreoWithAdjunto = function( correo_receptor,_nombre_receptor,_email_key){
//   setLimpiar2();
//   $("#_email_withadjuntos_receptor").val(correo_receptor.toString());
//   $("#_email_withadjuntos_receptor_nombre").val(_nombre_receptor.toString());
//   $("#_email_withadjuntos_key").val(_email_key.toString());
//   
//};
//
//var setAdd = function(_key){
//    var _controler='1';
//    var _id= '';
//    if(_key == 1){
//        $("#btnAddMisDatos").html('Agregando Datos ...');
//        $('#btnAddMisDatos').attr("disabled", true);
//    }
//    if(_key == 2){
//        _id= $("#_lista_miembros").val().toString();
//        $("#btnAddMiembro").html('Agregando Datos ...');
//        $('#btnAddMiembro').attr("disabled", true);
//    }
//    if(_key == 3){
//        if($("#_lista_contacto").val() == 'x'){
//            _controler= '2';
//        }else{
//            _id= $("#_lista_contacto").val().toString();
//            $("#btnAddContacto").html('Agregando Datos ...');
//            $('#btnAddContacto').attr("disabled", true);
//        }
//       
//    }
//    
//    if(_controler == '1'){
//        $.post("forumgrupo", {
//            KEY: 'KEY_ADD_DATOS_MIEMBRO',
//            _id: _id,
//            _key: _key
//        }, function(mensaje) {
//            var resp= $("#_email_withadjuntos_mensaje").val().toString();
//            $('iframe').contents().find('.wysihtml5-editor').html(resp + mensaje);
//            if(_key == 2){
//                $('#modal_buscarMiembro').modal('toggle');
//                $("#btnAddMiembro").html('OK');
//                $('#btnAddMiembro').attr("disabled", false);
//            }
//            if(_key == 3){
//                $('#modal_buscarContacto').modal('toggle');
//                $("#btnAddContacto").html('OK');
//                $('#btnAddContacto').attr("disabled", false);
//            }   
//            if(_key == 1){
//                $("#btnAddMisDatos").html('<i class="fa fa-user"></i>&nbsp; Agregar Mis Datos');
//                $('#btnAddMisDatos').attr("disabled", false);
//            }
//        });  
//    }
//};

var getDetalle = function( id_miembro){
     $.post("miembrogrupo", {
            KEY: 'KEY_SHOW_FORM_DETALLE',
            id_miembro:id_miembro
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
           
         });
};
var getRecargar = function(){
    sessionStorage._recargado_empresas = true;
    location.reload();
    //window.open(url, 'perfil');
};

var getDetalleGrupo = function(id) {
    var parametros = {
        KEY: 'KEY_DETALLE_GRUPO',
        _id: id
    }

    $.ajax({
        data:  parametros,
        url:   'forumgrupo',
        type:  'post',
        beforeSend: function () {
            $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
        },
        success:  function (mensaje) {
            $.msg('unblock');
                $("#ben_contenedor").html(mensaje);
                getConfTabla();
        },error : function(xhr, status) {
            $.msg('unblock');
            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
        }
    });
}
//
//var setLimpiar2 = function (){
//    $('iframe').contents().find('.wysihtml5-editor').html('');
//    $("#_email_withadjuntos_receptor").val("");
//    $("#_email_withadjuntos_asunto").val("");
//    $("#_email_withadjuntos_mensaje").val("");
//    $("#btnEnviarWithAdjuntosCorreo").html('Enviar');
//    $('#btnEnviarWithAdjuntosCorreo').attr("disabled", false);
//    $("#_email_withadjuntos_receptor_nombre").val("");
//    $("#_email_withadjuntos_key").val("");
//};
//
//var setEnviarCorreoWhithAdjunto = function(){
//
//        var parametros = {
//                KEY: 'KEY_ENVIAR_CORREO_ADJUNTO',
//                _correo_receptor: $("#_email_withadjuntos_receptor").val().toString(),
//                _email_asunto: $("#_email_withadjuntos_asunto").val().toString(),
//                _email_mensaje: $("#_email_withadjuntos_mensaje").val().toString(),
//                _email_key: $("#_email_withadjuntos_key").val().toString()
//        };
//        $.ajax({
//            data:  parametros,
//            url:   'miembrogrupo',
//            type:  'post',
//            dataType : 'json',
//            beforeSend: function () {
//                $("#btnEnviarWithAdjuntosCorreo").html('Enviando correo ...');
//                $('#btnEnviarWithAdjuntosCorreo').attr("disabled", true);
//            },
//            success:  function (mensaje) {
//                    if(mensaje.success == "true"){
//                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
//                        $('#modal_enviarContacto').modal('toggle'); 
//                        setLimpiar2();
//                        
//                    }else{
//                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
//                        $("#btnEnviarWithAdjuntosCorreo").html('Enviar');
//                        $('#btnEnviarWithAdjuntosCorreo').attr("disabled", false);
//                    }
//            },error : function(xhr, status) {
//                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
//            }
//        });
//
//};

</script>
 
<?php include(SCRIPT."/script_correo_adjunto.php");?>