<script> 
var getDetalle = function(id){
     $.post("mantenedordireccion", {
            KEY: 'KEY_SHOW_FORM_ACTUALIZAR',
            id: id.toString()
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
            $(".select2").select2();
         });
};
var getCrear = function(){
     $.post("mantenedordireccion", {
            KEY: 'KEY_SHOW_FORM_GUARDAR'
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
            $(".select2").select2();
         });
};
var setActualizar = function(id){
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
        var parametros = {
                KEY: 'KEY_ACTUALIZAR',
                _id: id.toString(),        
                _ciudad: $("#_ciudad").val().toString(),
                _tipo: $("#_tipo").val().toString(),
                _direccion: $("#_direccion").val().toString(),
                _estado: $("#_estado").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'mantenedordireccion',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) {
                $.msg('unblock');
                if(mensaje.success == "true"){
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

var setCrear = function(op){
    $.msg({content : '<img src="public/images/loanding.gif"/>', autoUnblock: false});
    $('#btnGuardar').attr("disabled", true);
    $('#btnGuardarNuevo').attr("disabled", true);
    var parametros = {
            KEY: 'KEY_GUARDAR',
            key_operacion: op.toString(),        
            _ciudad: $("#_ciudad").val().toString(),
            _tipo: $("#_tipo").val().toString(),
            _direccion: $("#_direccion").val().toString()

    };
    $.ajax({
        data:  parametros,
        url:   'mantenedordireccion',
        type:  'post',
        dataType : 'json',
        success:  function (mensaje) {
            $.msg('unblock');
            if(mensaje.success == "true_gn"){
                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                getCrear();
                $('#btnGuardar').attr("disabled", false);
                $('#btnGuardarNuevo').attr("disabled", false);

            }else if(mensaje.success == "true_g"){
                getRecargar();
            }else if(mensaje.success == "false"){
                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                $('#btnGuardar').attr("disabled", false);
                $('#btnGuardarNuevo').attr("disabled", false);
            }
        },error : function(xhr, status) {
            $.msg('unblock');
            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
        }
    });
  
};
var getRecargar = function(){
    location.reload();
    //window.open(url, 'perfil');
}; 

</script>
 
