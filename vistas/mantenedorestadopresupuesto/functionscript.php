<script> 
var getDetalle = function(id){
     $.post("mantenedorestadopresupuesto", {
            KEY: 'KEY_SHOW_FORM_ACTUALIZAR',
            id: id.toString()
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
         });
};
var setActualizar = function(id){
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
        var parametros = {
                KEY: 'KEY_ACTUALIZAR',
                _id: id.toString(),        
                _descripcion: $("#_descripcion").val().toString()
               // _estado: $("#_estado").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'mantenedorestadopresupuesto',
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

var getRecargar = function(){
    location.reload();
    //window.open(url, 'perfil');
}; 
</script>
 
