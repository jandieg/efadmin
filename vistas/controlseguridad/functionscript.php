<script>
var setPermiso = function(idPerfil, idPermiso,comprobador ){
    var checked='I';
        if($('#id_'+ idPermiso.toString()).prop('checked') ) {
            checked="A";
        }     
    if(comprobador.toString() == "true"){
        var parametros = {
            KEY: 'KEY_ACTUALIZAR_ROL_PERMISO',        
            _id_Perfil: idPerfil.toString(),
            _id_Permiso: idPermiso.toString(),
            _estado: checked
        };
    }else{
        var parametros = {
            KEY: 'KEY_GUARDAR_ROL_PERMISO',        
            _id_Perfil: idPerfil.toString(),
            _id_Permiso: idPermiso.toString(),
            _estado: checked
        };
    } 
    $.ajax({
        data:  parametros,
        url:   'controlseguridad',
        type:  'post',
        dataType : 'json',
        beforeSend: function () {
            $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
        },
        success:  function (mensaje) {
            $.msg('unblock');
            if(mensaje.success == "true"){
                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
            }else{
                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
            }
        },error : function(xhr, status) {
            $.msg('unblock');
            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
        }
    });
};
var getComboCargarPermisos = function(){
      var parametros = {
            KEY: 'KEY_SHOW_COMBO_PERFIL',
            _id_Perfil: $("#_id_Perfil").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'controlseguridad',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                
            },
            success:  function (mensaje) {
                //$.msg('unblock');
                    if(mensaje.success == "true"){
                        $("#ben_contenedor").html( mensaje.permisos);
                        //$(".select2").select2();
                    }else{
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }
            },error : function(xhr, status) {
//                $.unblockUI();
                //$.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });    
};

</script>

