<script> 
var getDetalleFiltro = function(_key_filtro){
        var id=""; 
        switch(_key_filtro){
        case "EMPRESA":        
            id= $("#_empresa").val().toString();
//            $('#_miembros option[value="x"]').prop('selected', true);
//            $('#_grupos option[value="x"]').prop('selected', true);
            
            $("#_miembros").val("x");
            $("#_grupos").val("x");
            $(".select2").select2();
            break;
        case "MIEMBRO":
            id= $("#_miembros").val().toString();
//            $('#_empresa option[value="x"]').prop('selected', true);
//            $('#_grupos option[value="x"]').prop('selected', true);
            $("#_empresa").val("x");
            $("#_grupos").val("x");
            $(".select2").select2();
            break;
        case "GRUPO":
            id= $("#_grupos").val().toString();
//            $('#_miembros option[value="x"]').prop('selected', true);
//            $('#_empresa option[value="x"]').prop('selected', true);
            $("#_miembros").val("x");
            $("#_empresa").val("x");
            $(".select2").select2();
            break;    
        }
   
        var parametros = {
            KEY: 'KEY_DETALLE_FILTRO_EMPRESA',
            _id: id.toString(),
            _key_filtro: _key_filtro.toString(),
            _año: $("#_año").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'cobros',
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



var getGenerarDetalleCobro = function(nombre, id_presupuesto, id_miembro){
        var parametros = {
                KEY: 'KEY_DETALLE_PRESUPUESTO_COBRO',
                _id_presupuesto: id_presupuesto,
                _nombre:nombre,
                id_miembro:id_miembro
        };
        $.ajax({
            data:  parametros,
            url:   'cobros',
            type:  'post',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                    $.msg('unblock');
                    $("#respuesta_modal").html(mensaje);
                    //getConfTabla();
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });
};

var getRecargar = function(){
    location.reload();
};

var getSeleccionarTodos = function(){
    var checkAll = $("#selectall").prop('checked');
    if (checkAll) {
        $(".case").prop("checked", true);
        $(".case2").prop("checked", true);
    } else {
        $(".case2").prop("checked", false);
        $(".case").prop("checked", false);
    }
    var total = 0;
    var total2 = 0;
    var reversa = false;
    $(".case").each(function(){
        if ($(this).is(":checked")) {
            total += Number($(this).val());
        }
    });
    $(".case2").each(function(){
        reversa = true;
        if ($(this).is(":checked")) {
            total2 += Number($(this).val());
        }
    });
    if (reversa) {
        $("#_montoreversado").val(total2*-1);
    }

    $("#_montopagado").val(total);
};

var getSeleccionarCobro = function(){
    
    var total = 0;
    $(".case").each(function(){
        if ($(this).is(":checked")) {
            total += Number($(this).val());
        }
    });
    var total2 = 0;
    var reversa = false;
    $(".case2").each(function(){
        reversa = true;
        if ($(this).is(":checked")) {
            total2 += Number($(this).val());
        }
    });
    $("#_montopagado").val(total);
    if (reversa) {
        $("#_montoreversado").val(total2*-1);
    }
    if (! reversa) {
        if($(".case").length == $(".case:checked").length) {
            $("#selectall").prop("checked", true);
        } else {
            $("#selectall").prop("checked", false);
        }
    } else {
        if(($(".case").length + $(".case2").length) == $(".case:checked").length) {
            $("#selectall").prop("checked", true);
        } else {
            $("#selectall").prop("checked", false);
        }
    }     
    
};

var setReversarCobros = function(){
    var cont= $("#selectall").attr("name");
    var listaIDDetalle = [];

    $(".case2").each(function() {
        if ($(this).prop('checked')) {
            listaIDDetalle.push($(this).attr("name"));
        }
    });
    
 
    $('#btnGuardar').attr("disabled", true);
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var parametros = {
                KEY: 'KEY_REVERSAR_COBRO',  
                _lista_id_detalle_presupuesto: listaIDDetalle,
                _id_presupuesto: $("#_id_presupuesto_cobro").val().toString(),
                _formapago: $("#_formapago").val().toString(),
                _id_miembro:$("#_id_miembro_cobro").val().toString()                
        };

    
        $.ajax({
            data:  parametros,
            url:   'cobros',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) { 
                if(mensaje.success == "true"){
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    $('#modal_detalleCobro').modal('toggle'); 
                    $.msg('unblock');
                    $('#btnGuardar').attr("disabled", false);
                    //getRecargar();
                }else{
                    $.msg('unblock');
                    $('#btnGuardar').attr("disabled", false);
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
               
    
                  
            },error : function(xhr, status) {
               $.msg('unblock');
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};

var setCobrar = function(){
    var cont= $("#selectall").attr("name");
    var listaIDDetalle = [];
    var montopagar = Number($("#_montopagado").val());
    var banderacredito = 0;
    var resto = 0;
    
    if ($("#_credito").is(":checked")) {
        banderacredito = 1;
        montopagar += Number($("#_credito").val());
    }


    
    $(".case").each(function() {
        if (Number($(this).val()) <= montopagar) {
            
            montopagar -= $(this).val();
            listaIDDetalle.push($(this).attr("name"));
            
        }
    });
    
    /*
    for (var i=0; i < cont; i++) {
        if($("#" + (i + 1)).prop('checked') ) {
            listaIDDetalle.push($("#" + (i + 1)).attr("name"));
            //alert($("#" + (i + 1)).attr("name"));            
        }     
    }*/
 
    $('#btnGuardar').attr("disabled", true);
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var parametros = {
                KEY: 'KEY_GUARDAR_COBRO',  
                _lista_id_detalle_presupuesto: listaIDDetalle,
                _id_presupuesto: $("#_id_presupuesto_cobro").val().toString(),
                _formapago: $("#_formapago").val().toString(),
                _id_miembro:$("#_id_miembro_cobro").val().toString(),
                _resto: montopagar,
                _bandera_credito: banderacredito
        };

    
        $.ajax({
            data:  parametros,
            url:   'cobros',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) { 
                if(mensaje.success == "true"){
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    $('#modal_detalleCobro').modal('toggle'); 
                    $.msg('unblock');
                    $('#btnGuardar').attr("disabled", false);
                    //getRecargar();
                }else{
                    $.msg('unblock');
                    $('#btnGuardar').attr("disabled", false);
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
               
    
                  
            },error : function(xhr, status) {
               $.msg('unblock');
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};

var getGenerarInscripcionCobro = function(msg, id_miembro){

    $("#_id_inscripcion_miembro").val(id_miembro);
    $("#respuesta_modal_inscripcion").text(msg.toString());    
};
var setCobrarInscripcion = function(){

    $('#btnGuardarInscrición').attr("disabled", true);
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var parametros = {
                KEY: 'KEY_GUARDAR_COBRO_INSCRIPCION',  
                _id_inscripcion_miembro: $("#_id_inscripcion_miembro").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'cobros',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) { 
                if(mensaje.success == "true"){
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    $('#modal_InscripcionCobro').modal('toggle'); 
                    $.msg('unblock');
                    $('#btnGuardarInscrición').attr("disabled", false);
                    getRecargar(); 
                }else{
                    $.msg('unblock');
                    $('#btnGuardarInscrición').attr("disabled", false);
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }

    
                  
            },error : function(xhr, status) {
               $.msg('unblock');
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};

</script>

        