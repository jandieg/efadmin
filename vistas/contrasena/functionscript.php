<script>
var actualizarContrasena = function() {
    var contrasena = $("#_contrasena").val();
    var confirmacion = $("#_confirmacion").val();    
        var parametros =  {
            KEY: 'KEY_ACTUALIZAR_CONTRASENA',
            _contrasena: contrasena,
            _confirmacion: confirmacion,
            _usu_user: $("#_usu_user").val(),
            _persona: $("#_persona").val()          
        };
        $.ajax({
            data:  parametros,
            url:   'contrasena',
            type:  'post',
            dataType: 'json',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                console.log(mensaje);
                $.msg('unblock');
                    if(mensaje.success == "true"){
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        getRecargar();
                    }
                    if(mensaje.success == "false"){
                       $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }
            },error : function(xhr, status) {
                console.log(xhr);
                $.unblockUI();
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + xhr.toString() + status.toString()});
            }
        });  
    
};
var getRecargar = function() {
    window.location.replace("http://"+ window.location.hostname + "/admin");	                                                          
};
</script>