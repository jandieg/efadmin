<script> 
var getDetalle = function(id, base){

 $.post("sede", {
        KEY: 'KEY_SHOW_FORM_DETALLE',
        id: id.toString(),
        base:base
    }, function(mensaje) {
        $("#ben_contenedor").html(mensaje);
     });
};
var getActualizar = function(id){
     $.post("sede", {
            KEY: 'KEY_SHOW_FORM_ACTUALIZAR',
            id: id.toString()
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
            $(".select2").select2();
         });
};
var getCrear = function(){
     $.post("sede", {
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
                _razon_social: $("#_razon_social").val().toString(),
                _num_empleados: $("#_num_empleados").val().toString(),
                _correo: $("#_correo").val().toString(),
                _correo_2: $("#_correo_2").val().toString(),
                _fax: $("#_fax").val().toString(),
                _sitio_web: $("#_sitio_web").val().toString(),
                _descripcion: $("#_descripcion").val().toString(),
                _administrador: $("#_administrador").val().toString(),
                _cp: $("#_cp").val().toString(),
                _pais: $("#_pais").val().toString(),
                _ciudad: $("#_ciudad").val().toString(),
                _telefono: $("#_telefono").val().toString(),
                _celular: $("#_celular").val().toString(),
                _direccion:$("#_direccion").val().toString(),
                _estado: $("#_estado").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'sede',
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
            _razon_social: $("#_razon_social").val().toString(),
            _num_empleados: $("#_num_empleados").val().toString(),
            _correo: $("#_correo").val().toString(),
            _correo_2: $("#_correo_2").val().toString(),
            _fax: $("#_fax").val().toString(),
            _sitio_web: $("#_sitio_web").val().toString(),
            _descripcion: $("#_descripcion").val().toString(),
            _administrador: $("#_administrador").val().toString(),
            _cp: $("#_cp").val().toString(),
            _pais: $("#_pais").val().toString(),
            _ciudad: $("#_ciudad").val().toString(),
            _telefono: $("#_telefono").val().toString(),
            _celular: $("#_celular").val().toString(),
            _direccion:$("#_direccion").val().toString()
    };
   
    $.ajax({
        data:  parametros,
        url:   'sede',
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
}; 

</script>
 
