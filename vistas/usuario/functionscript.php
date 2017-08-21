<script>
var getDetalle = function(id){
 $.post("usuario", {
        KEY: 'KEY_SHOW_FORM_DETALLE',
        id: id.toString()
    }, function(mensaje) {
        $("#ben_contenedor").html(mensaje);
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
};

var setEnviarCorreoIndividual = function(){

        var parametros = {
                KEY: 'KEY_ENVIAR_CORREO_INDIVIDUAL',
                _correo_receptor: $("#_email_receptor").val().toString(),
                _email_asunto: $("#_email_asunto").val().toString(),
                _email_mensaje: $("#_email_mensaje").val().toString(),
                _email_key: $("#_email_key").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'usuario',
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
var getActualizar = function(id){
     $.post("usuario", {
            KEY: 'KEY_SHOW_FORM_ACTUALIZAR',
            id: id.toString()
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
         });
    if ($("#_perfil").val() != undefined 
    && $("#_perfil").val().toString() != "2" 
    && $("#_perfil").val().toString() != "3") {
        $("._esposa").hide();
        $("._hijos").hide();
        $(".imagen").hide();
    }       
};
var getCrear = function(){
     $.post("usuario", {
            KEY: 'KEY_SHOW_FORM_GUARDAR'
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
         });
};
var setActualizarUserPass = function(){
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
                getRecargar();
            }else{
                $("#btnActualizarUserClave").html('Guardar');
                $('#btnActualizarUserClave').attr("disabled", false);
                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
            }
          
        },error : function(xhr, status) { 
            $.msg('unblock');
            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
        }
    });
};
var setActualizarDatos = function(id){
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var esposa = "";
    var hijos = "";
    var telefonofijo = "";
    if ($("#_telefono").val() != undefined) {
        telefonofijo = $("#_telefono").val().toString();
    }
    if ($("#_esposa").val() != undefined) {
        esposa = $("#_esposa").val().toString();
    }
    if ($("#_hijos").val() != undefined) {
        hijos = $("#_hijos").val().toString();
    }
    var parametros = {
            KEY: 'KEY_ACTUALIZAR',  
            _id: id.toString(),
            _nombre: $("#_nombre").val().toString(),
            _apellido: $("#_apellido").val().toString(),
            _tipo_p: $("#_tipo_p").val().toString(),
            _identificacion: 'a',
            _fn: $("#_fn").val().toString(),
            _genero: $("#_genero").val().toString(),
            _perfil: $("#_perfil").val().toString(),
            _estado: $("#_estado").val().toString(),        
            _correo: $("#_correo").val().toString(), 
            _telefono: telefonofijo, 
            _celular: $("#_celular").val().toString(),
			_pais: $("#_pais").val().toString(),
            _esposa: esposa,
            _hijos: hijos
//            _sede: $("#_sede").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'usuario',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) { 
                 $.msg('unblock');
                if(mensaje.success == "true"){
                    getRecargar();
                }else{
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};
var setUserCrear = function(op){
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var parametros = {
                KEY: 'KEY_GUARDAR',
                key_operacion: op.toString(),        
                _nombre: $("#_nombre").val().toString(),
                _apellido: $("#_apellido").val().toString(),
                _tipo_p: $("#_tipo_p").val().toString(),
                _identificacion: 'a',
                _fn: $("#_fn").val().toString(),
                _genero: $("#_genero").val().toString(),
                _perfil: $("#_perfil").val().toString(),
                _user: $("#_user").val().toString(),
                _contraseña: $("#_contraseña").val().toString(),
                _confirmar: $("#_confirmar").val().toString(),
                _estado: $("#_estado").val().toString(),        
                _correo: $("#_correo").val().toString(), 
                _telefono: $("#_telefono").val().toString(), 
                _celular: $("#_celular").val().toString(),
				_pais: $("#_pais").val().toString()
//                _sede: $("#_sede").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'usuario',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) {
                    $.msg('unblock');
                    if(mensaje.success == "true_gn"){
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        $.post("usuario", {
                             KEY: 'KEY_SHOW_FORM_GUARDAR'
                        }, function(mensaje) {
                             $("#ben_contenedor").html(mensaje);
                        });
                       
                    }else if(mensaje.success == "true_g"){
                        getRecargar();
                    }else if(mensaje.success == "false"){
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });

};

var subirFoto = function() {
    console.log('si esta cargando');
    
    $("#el_codigo").val($("#_usu_id").val().toString());
        var reader = new FileReader();

        reader.readAsDataURL(document.getElementById('archivo').files[0]);
        var parametros= {
            codigo: $("#el_codigo").val(),
            archivo: reader
        };

        var data = new FormData();

            

        reader.onloadend = function () {
            $("#targetLayer").css('background-image', 'url('+reader.result+')');
            $("#targetLayer").css('background-size', '100px 110px');
            $("#targetLayer").css('background-repeat', 'no-repeat');        

            //$("#foto").attr("src", reader.result);
            //var blob = new Blob(document.getElementById('archivo').files[0], {type: 'image/jpeg'});
            data.append("codigo", $("#_usu_id").val().toString());
            data.append("archivo", document.getElementById('archivo').files[0]);
            data.append("KEY", "KEY_ARCHIVO");
            $.ajax({
                url: "usuario",
                type: "POST",
                data:  data,
                contentType: false,
                cache: false,
                processData:false,
                success: function(data)
                {
                    console.log(data);
                },
                error: function() 
                {
                } 	        
            });

        }

    
}

var cambioPerfil = function() {
    var perfil = $("#_perfil").val().toString();
    if (perfil == "2" || perfil == "3") {
        //es ibp o forum 
        $("._esposa").show();
        $("._hijos").show();
        $(".imagen").show();        
    } else {
        $(".imagen").hide();
        $("._esposa").hide();
        $("._hijos").hide();
    }
}

var getAsignarUserClave = function(id, user){
    $("#_id_credenciales").val(id.toString());
    $("#_user_credenciales").val(user.toString());   
    $("#_clave_credenciales").val('');  
    $("#_confirmar_credenciales").val('');  
};
var getRecargar = function(){
    location.reload();
    //window.open(url, 'perfil');
};
</script>
 
<?php include(SCRIPT."/script_correo_adjunto.php");?>