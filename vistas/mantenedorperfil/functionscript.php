<script>
var getActualizar = function(id){
     $.post("mantenedorperfil", {
            KEY: 'KEY_SHOW_FORM_ACTUALIZAR',
            id: id.toString()
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
         });
};
var getCrear = function(){
     $.post("mantenedorperfil", {
            KEY: 'KEY_SHOW_FORM_GUARDAR'
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
         });
};
var setActualizar = function(id_perfil){
    var parametros = {
            KEY: 'KEY_ACTUALIZAR',
            id: id_perfil,
            descripcion: $("#c_descrpcion").val().toString(),
            estado: $("#c_estado").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'mantenedorperfil',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
               $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                    //$.blockUI({ message: '<h3>Esperé un momento...</h3>'}); 
            },
            success:  function (mensaje) {  
                   // $.unblockUI();
                   $.msg('unblock');
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
            },error : function(xhr, status) {
               // $.unblockUI();
               $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};
var setCrear = function(op){
        var parametros = {
                KEY: 'KEY_GUARDAR',
                key_operacion: op.toString(),        
                descripcion: $("#c_descrpcion").val().toString(),
                estado: $("#c_estado").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'mantenedorperfil',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                    //$.blockUI({ message: '<h3>Esperé un momento...</h3>'}); 
            },
            success:  function (mensaje) {
                $.msg('unblock');
                //$.unblockUI();
                    if(mensaje.success == "true_gn"){
                        $("#c_descrpcion").val("");
                        $("#c_estado option[value=A]").attr("selected",true);
                    }else if(mensaje.success == "true_g"){
                        getRecargar();
                    }
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
            },error : function(xhr, status) {
//                $.unblockUI();
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });

};
var setEliminar = function(){
        var parametros = {
                KEY: 'KEY_ELIMINAR',
                id: $("#e_id").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'mantenedorperfil',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                    //$.blockUI({ message: '<h3>Esperé un momento...</h3>'}); 
            },success:  function (mensaje) {
                    //$("#ben_respuesta_operacion").html(mensaje.msj);
                    //$.unblockUI();
                    $.msg('unblock');
                    if(mensaje.success == "true"){
                        getRecargar();
                    }else{
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }
            },error : function(xhr, status) {
                //$.unblockUI();
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });

};
var getEliminar = function(id){
    $("#e_id").val(id);
    $("#e_msg").text("¿Está completamente seguro de inactivar el perfil?");
};
var getRecargar = function(){
    location.reload();
    //window.open(url, 'mantenedorperfil');
};
</script>
 
