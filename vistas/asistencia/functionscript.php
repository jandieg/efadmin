<script> 

var goToImprimir = function(){
    var _name_grupo = $("#_grupos option:selected").text();
    var _name_tipo_evento = $("#_tipos_eventos option:selected").text();
    
    var _name_tipo_asistencia = $("#_tipo_asistencia option:selected").text();
    
    window.open("imprimirasistencia?_id_grupo="+$("#_grupos").val() 
                                    + "&_año=" + $("#_año").val() 
                                    + "&_id_tipo_evento=" + $("#_tipos_eventos").val()
                                    + "&_name_grupo=" + _name_grupo
                                    + "&_name_tipo_evento=" + _name_tipo_evento
                                    + "&_name_tipo_asistencia=" + _name_tipo_asistencia
                                    + "&_tipo_asistencia=" + $("#_tipo_asistencia").val());
   
};
var getEventosPeriodos = function(){
     $.post("asistencia", {
            KEY: 'KEY_FILTRO_EVENTO_PERIODO',
           _tipo_asistencia:$("#_tipo_asistencia").val().toString()
        }, function(mensaje) {
            $("#_tipos_eventos").html(mensaje);
         });              
};

var getGrupos = function(){
    var parametros = {
        KEY: 'KEY_FILTRO_TIPO_EVENTO',
        _tipo_evento: $("#_tipos_eventos").val().toString()
    };
    
    $.ajax({
        data: parametros,
        url: 'asistencia',
        type: 'post',
        success: function (mensaje) {
            $("#_grupos").html(mensaje);
        }
    });
       
};

var getDetalleFiltro = function(){
//    alert('dfsf');
        var parametros = {
            KEY: 'KEY_DETALLE_FILTRO',
            _id_grupos: $("#_grupos").val().toString(),
//            _fi: $("#_fi").val().toString(),
//            _ff: $("#_ff").val().toString(),
            _año:$("#_año").val().toString(),
            _id_tipo_evento: $("#_tipos_eventos").val().toString()
            //_tipo_asistencia:$("#_tipo_asistencia").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'asistencia',
            type:  'post',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                $.msg('unblock');
                $("#ben_contenedor_tabla").html(mensaje);
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });
};


var setAsistencia = function(_id_asistencia){
    var _checked="1";
    if($('#'+ _id_asistencia.toString()).prop('checked') ) {
        _checked="0";
    }

    //alert(_checked +'  '+ _id_asistencia);
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var parametros = {
                KEY: 'KEY_GUARDAR_ASISTENCIA',  
                _id_asistencia: _id_asistencia,
                _checked: _checked
        };
        $.ajax({
            data:  parametros,
            url:   'asistencia',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) { 
                if(mensaje.success == "true"){
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    $.msg('unblock');
                    //getDetalleFiltro();
                }else{
                    $.msg('unblock');
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }   
            },error : function(xhr, status) {
               $.msg('unblock');
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};
//var setAsistenciaCasos = function(_id_empresario_mes){
//    var _checked="0";
//    if($('#'+ _id_empresario_mes.toString()).prop('checked') ) {
//        _checked="1";
//    }
//
//    //alert(_checked +'  '+ _id_asistencia);
//    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
//    var parametros = {
//                KEY: 'KEY_GUARDAR_ASISTENCIA_CASO',  
//                _id_empresario_mes: _id_empresario_mes,
//                _checked: _checked
//        };
//        $.ajax({
//            data:  parametros,
//            url:   'asistencia',
//            type:  'post',
//            dataType : 'json',
//            success:  function (mensaje) { 
//                if(mensaje.success == "true"){
//                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
//                    $.msg('unblock');
//                }else{
//                    $.msg('unblock');
//                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
//                }   
//            },error : function(xhr, status) {
//               $.msg('unblock');
//               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
//            }
//        });
//};
var getDetalleEvento = function(_nombre, _responsable, _fi, _ff, _direccion, _descripcion){
    var detalle='<p><b>Evento:</b> '+_nombre+'<br>';
    detalle   +='<b>Responsable:</b> '+_responsable+'<br>';
    detalle   +='<b>Fecha Inicio:</b> '+_fi+'<br>';
    detalle   +='<b>Fecha Fin:</b> '+_ff+'<br>';
    detalle   +='<b>Dirección:</b> '+_direccion+'<br>';
    detalle   +='<b>Descripción:</b> '+_descripcion+'<br></p>';
    
    $("#respuesta_modal").html(detalle);      
};
var getRecargar = function(){
    location.reload();
};
window.onload = getGrupos;

</script>

        