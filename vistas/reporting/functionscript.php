<script> 


var goToImprimir = function(){
    
    window.open("imprimir?_id_grupo="+$("#_grupo").val()+"&_estado="+$("#_estado_presupuesto").val()+"&_año="+$("#_año").val());
    //windows.open("nuevaPagina.php?varA='" + valor1 + "'&varB='"+ valor2 +"' "); 


};

var getDetalleFiltroGrupo = function(){

        var parametros = {
                KEY: 'KEY_DETALLE_FILTRO_GRUPO',
                idGrupo: $("#_grupo").val(),
                _estado_presupuesto: $("#_estado_presupuesto").val(),
                _año: $("#_año").val()
        };
        $.ajax({
            data:  parametros,
            url:   'reportes',
            type:  'post',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                $.msg('unblock');
                    $("#ben_contenedor_tabla").html(mensaje);
                    getConfTabla();
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });
};
var getRecargar = function(){
    location.reload();
};

</script>

        