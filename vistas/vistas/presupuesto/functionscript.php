<script> 
var setLimpiar = function (){
    $("#_id_presupuesto").val("");
    $("#_id_miembro_presupuesto").val("");
    //$("#_valor_presupuesto").val("");
    
    $("#btnGuardarPresupuesto").html('Guardar');
    $('#btnGuardarPresupuesto').attr("disabled", false);
};
var getAgregarPresupuesto = function(id_presupuesto, id_miembro,id_membresia, nombre_miembro, id_periodo,  fecha_registro, fechaXPagar, ultimaFechaPagada){
   
    setLimpiar();
    $("#_fecha_registro_miembro_presupuesto").prop('disabled', false);
    $('#_membresia_presupuesto option[value="' + id_membresia + '"]').prop('selected', true);
    $("#_id_presupuesto").val(id_presupuesto.toString());
    $("#_id_miembro_presupuesto").val(id_miembro.toString());
    $('#_periodo_presupuesto option[value="' + id_periodo + '"]').prop('selected', true);
    
    if(fechaXPagar != "0"){
        $("#_fecha_registro_miembro_presupuesto").val(fechaXPagar.toString());
        $("#_fecha_registro_miembro_presupuesto").prop('disabled', true);
    }else{
        $("#_fecha_registro_miembro_presupuesto").val(fecha_registro.toString());
    }
    $("#_nombre_presupuesto").val(nombre_miembro.toString());
    $("#btnGuardarPresupuesto").html('Guardar');
    if(id_presupuesto != "0"){     
       
        $("#btnGuardarPresupuesto").html('Actualizar');
    }
    if(ultimaFechaPagada != "0" && fechaXPagar == "0"){
         $('#btnGuardarPresupuesto').attr("disabled", true);
    }
   
};
var setAgregarPresupuesto = function(){

        var parametros = {
                KEY: 'KEY_GUARDAR_PRESUPUESTO',
                _id_presupuesto: $("#_id_presupuesto").val().toString(),
                _id_miembro: $("#_id_miembro_presupuesto").val().toString(),
                _id_periodo: $("#_periodo_presupuesto").val().toString(),
                //_valor: $("#_valor_presupuesto").val().toString(),
                _fecha_registro: $("#_fecha_registro_miembro_presupuesto").val().toString(),
                _id_membresia: $("#_membresia_presupuesto").val().toString()
                
        };
        $.ajax({
            data:  parametros,
            url:   'presupuesto',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                $("#btnGuardarPresupuesto").html('Guardando ...');
                $('#btnGuardarPresupuesto').attr("disabled", true);
            },
            success:  function (mensaje) {
                    if(mensaje.success == "true"){
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        $('#modal_agregarPresupuesto').modal('toggle'); 
                        getDetalleFiltroGrupo();
                        setLimpiar();
                        
                    }else{
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        $("#btnGuardarPresupuesto").html('Guardar');
                        $('#btnGuardarPresupuesto').attr("disabled", false);
                    }
            },error : function(xhr, status) {
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });

};

var getDetalleFiltroGrupo = function(){
        var parametros = {
                KEY: 'KEY_DETALLE_FILTRO_GRUPO',
                idGrupo: $("#_grupo").val()
        };
        $.ajax({
            data:  parametros,
            url:   'presupuesto',
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


var getDetallePresupuesto = function(id_presupuesto){
    //alert(id_presupuesto.toString());
        var parametros = {
                KEY: 'KEY_DETALLE_PRESUPUESTO',
                id_presupuesto: id_presupuesto
        };
        $.ajax({
            data:  parametros,
            url:   'presupuesto',
            type:  'post',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                $.msg('unblock');
                if(id_presupuesto != "0"){
                   $("#respuesta_modal").html(mensaje);
                }else{
                   $("#respuesta_modal").html("<center><h1>Debes agregar el presupuesto!</h1></center>");
                }
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

        