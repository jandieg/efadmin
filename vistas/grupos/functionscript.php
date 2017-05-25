<script>
var getDetalle = function(id){
     $.post("grupos", {
            KEY: 'KEY_SHOW_FORM_ACTUALIZAR',
            id: id.toString()
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
         });
};
var getCrear = function(){
     $.post("grupos", {
            KEY: 'KEY_SHOW_FORM_GUARDAR'
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
         });
};
var setActualizar = function(id){
    if($("#_forum").val().toString()=='0'){
          $.toaster({ priority : 'info', title : 'Alerta', message : 'Debes seleccionar un Forum Leader'});
    }else{
        var parametros = {
                KEY: 'KEY_ACTUALIZAR',
                _id: id.toString(),        
                _grupo: $("#_grupo").val().toString(),
                _forum: $("#_forum").val().toString()
       
        };
        $.ajax({
            data:  parametros,
            url:   'grupos',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                $('#btnGuardar').attr("disabled", true);
                $('#btnGuardarNuevo').attr("disabled", true);
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                
            },
            success:  function (mensaje) {
                $.msg('unblock');
                if(mensaje.success == "true"){
                    getRecargar();
                }else if(mensaje.success == "false"){
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
                
                $('#btnGuardar').attr("disabled", false);
                $('#btnGuardarNuevo').attr("disabled", false);
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
        }
};
var setCrear = function(op){
    if($("#_forum").val().toString()=='0'){
          $.toaster({ priority : 'info', title : 'Alerta', message : 'Debes seleccionar un Forum Leader'});
    }else{
        var parametros = {
                KEY: 'KEY_GUARDAR',
                key_operacion: op.toString(),        
                _grupo: $("#_grupo").val().toString(),
                _forum: $("#_forum").val().toString()
       
        };
        $.ajax({
            data:  parametros,
            url:   'grupos',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                $.msg('unblock');
                    if(mensaje.success == "true_gn"){
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        getCrear();
                
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
        }
};
var getRecargar = function(){
    location.reload();
    //window.open(url, 'perfil');
}; 
</script>
 
