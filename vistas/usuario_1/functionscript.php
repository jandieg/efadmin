<script>
var getActualizar = function(id){
     $.post("usuario", {
            KEY: 'KEY_SHOW_FORM_ACTUALIZAR',
            id: id.toString()
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
         });
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
var setActualizarDatos = function(id){
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var parametros = {
            KEY: 'KEY_ACTUALIZAR',  
            _id: id.toString(),
            _nombre: $("#_nombre").val().toString(),
            _apellido: $("#_apellido").val().toString(),
            _tipo_p: $("#_tipo_p").val().toString(),
            _identificacion: $("#_identificacion").val().toString(),
            _fn: $("#_fn").val().toString(),
            _genero: $("#_genero").val().toString(),
            _perfil: $("#_perfil").val().toString(),
            _estado: $("#_estado").val().toString(),        
            _correo: $("#_correo").val().toString(), 
            _telefono: $("#_telefono").val().toString(), 
            _celular: $("#_celular").val().toString()
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
                _identificacion: $("#_identificacion").val().toString(),
                _fn: $("#_fn").val().toString(),
                _genero: $("#_genero").val().toString(),
                _perfil: $("#_perfil").val().toString(),
                _user: $("#_user").val().toString(),
                _contraseña: $("#_contraseña").val().toString(),
                _confirmar: $("#_confirmar").val().toString(),
                _estado: $("#_estado").val().toString(),        
                _correo: $("#_correo").val().toString(), 
                _telefono: $("#_telefono").val().toString(), 
                _celular: $("#_celular").val().toString()
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
 
