<?php 
session_start();

?>

<script>


var cambioMembresia = function () {
    if ($("#_status").val() == 2) {
        generarRangoFechas();        
        $("#modal_getCancelarMiembro").modal('toggle');
    }
}

var checkCancel = function() {
    if ($("#_chequea_cancelacion").is(":checked")) {
        $("#btnActualizarCancelacion").attr("disabled", false);
    } else {
        $("#btnActualizarCancelacion").attr("disabled", true);
    }
}


var setCanceladas = function() {

    var canceladas = 0;
    var key = 'x';
    if ($("#_canceladas").is(":checked")) {
        canceladas = 1;
    }
    var filtro= "x";
    if ($("#_grupo").val().toString() != "x") {
        filtro = $("#_grupo").val().toString();
        key = 1;
    }

    if ($("#_empresa").val().toString() != "x") {
        filtro = $("#_empresa").val().toString();
        key = 3;
    }

    if ($("#_status_memb").val().toString() != "x") {
        filtro = $("#_status_memb").val().toString();
        key = 5;
    }

    if ($("#_memb_type").val().toString() != "x") {
        filtro = $("#_memb_type").val().toString();
        key = 6;
    }

    if ($("#_forum").val().toString() != "x") {
        filtro = $("#_memb_type").val().toString();
        key = 2;
    }

    if ($("#_industria").val().toString() != "x") {
        filtro = $("#_industria").val().toString();
        key = 4;
    }
    
      var parametros = {
            KEY: 'KEY_SHOW_FILTRO',
            _key_filtro: key,
            _filtro: filtro,
            _canceladas: canceladas
        };
        $.ajax({
            data:  parametros,
            url:   'miembros',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                //$.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                //$.msg('unblock');
                    if(mensaje.success == "true"){
                        if(key == "1"){
                            //$('#_forum option[value="'+mensaje.id+'"]').prop('selected', true);
                            $('#_forum').val(mensaje.id);
                            $(".select2").select2();
                        }
                        if(key == "2"){
                             //$('#_grupo option[value="'+mensaje.id+'"]').prop('selected', true);
//                             $('#_grupo').val(mensaje.id);
                             $('#_grupo').html(mensaje.gruposfiltro);
                             $(".select2").select2();
                             
                             
                        }
//                        
                        
                        $("#ben_contenedor_filtro").html( mensaje.tabla);
                        getConfTabla();
                    }else{
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
            },error : function(xhr, status) {
//                $.unblockUI();
                //$.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + xhr.toString() + status.toString()});
            }
        });

}

var generarRangoFechas = function () {
    var date2 = new Date().toISOString().substr(0,19).replace('T', ' ');
    var month = date2.substr(5,2);
    var year  = date2.substr(0,4);
    if (month == "01") {
        month = month + 10;
        year  = year - 1;
    } else {
        month = month - 2;
    }
    var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    var fechaInicial = new Date(year, month, 1);

    $('.date-picker-meses').datepicker(
    {
        dateFormat: "mm/yy",
        monthNamesShort: meses,
        changeMonth: true,
        changeYear: true,
        showButtonPanel: false,
        minDate: fechaInicial,
        defaultDate: fechaInicial,
        onChangeMonthYear: function(y,m,i) {
            if (year == y && month > m) {
                //se valida que no caiga en bug del datepicker
                
                if (month+1 == 12) {
                    $("#mesact").html(meses[0]+" (incluido " + meses[0] + ")");
                } else {
                    $("#mesact").html(meses[month+1]+" (incluido " + meses[month+1] + ")");
                }
                $("#_seleccion_del_mes").val( (month+1) + '/' + y);
            } else {
                if (m.length < 2) { 
                    $("#mesact").html(meses[m]+" (incluido " + meses[m] + ")");
                    $("#_seleccion_del_mes").val('0' + m.toString() + '/' + y);
                } else {
                    if (m == 12) {  
                        $("#mesact").html(meses[0]+" (incluido " + meses[0] + ")");
                    } else {
                        $("#mesact").html(meses[m]+" (incluido " + meses[m] + ")");
                    }
                    
                    $("#_seleccion_del_mes").val(m + '/' + y);
                }
            }
            
            
        },
       
    });



    
}



var setLimpiar = function (){
    $('iframe').contents().find('.wysihtml5-editor').html('');
    $("#_email_receptor").val("");
    $("#_email_asunto").val("");
    $("#_email_mensaje").val("");
    $("#btnEnviarCorreo").html('Enviar');
    $('#btnEnviarCorreo').attr("disabled", false);
};
var setEnviarCorreoIndividual = function(){

        var parametros = {
                KEY: 'KEY_ENVIAR_CORREO_INDIVIDUAL',
                _correo_receptor: $("#_email_receptor").val().toString(),
                _email_asunto: $("#_email_asunto").val().toString(),
                _email_mensaje: $("#_email_mensaje").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'miembros',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                $("#btnEnviarCorreo").html('Enviando correo ...');
                $('#btnEnviarCorreo').attr("disabled", true);
            },
            success:  function (mensaje) {
                    if(mensaje.success == "true"){
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        $('#modal_enviarCorreo').modal('toggle'); 
                        setLimpiar();
                        
                    }else{
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }
            },error : function(xhr, status) {
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });

};
var getEnviarCorreoIndividual = function( correo_receptor,_nombre_receptor){
   setLimpiar();
   $("#_email_receptor").val(correo_receptor.toString());
   $("#_email_receptor_nombre").val(_nombre_receptor.toString());
    $("#_precio_esp").show();
   
};

var Show_Esp_Price = function(){
        //$("#_precio_esp").show();
		var membresia = $("#_membresia").val().toString();
		
		//alert('selected: '+membresia);
		if(membresia==2){
	    $("#_precio_esp").removeAttr( "type" );
		$("#_precio_esp").attr( "type", "text" );
		$("#_precio_esp").removeAttr( "titulo" );
		$("#_precio_esp").attr( "titulo", "Precio Especial" );
		$("#_precio_esp").attr( "placeholder", "Introducir Precio Especial" );
		}else{
			 $("#_precio_esp").removeAttr( "type" );
		$("#_precio_esp").attr( "type", "hidden" );
		}
         // alert('123');
};
var Hidde_Esp_Price = function(){
        //$("#_precio_esp").show();
	    $("#_precio_esp").removeAttr( "type" );
		$("#_precio_esp").attr( "type", "hidden" );
         // alert('123');
};

var getComboCargarGrupos = function(){
	
      var parametros = {
            KEY: 'KEY_SHOW_COMBO_GRUPOS',
            _propietario: $("#_propietario").val().toString(),
        };
        $.ajax({
            data:  parametros,
            url:   'miembros',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                //$.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                //$.msg('unblock');
                    if(mensaje.success == "true"){
                        
                        $("#_grupo_asignar").html( mensaje.grupos);
                        $(".select2").select2();
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
var getUserEditar = function(id){
     $.post("miembros", {
            KEY: 'KEY_SHOW_FORM_ACTUALIZAR',
            id_miembro: id
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
            $(".select2").select2();
            $("#alertas").html("");
         });
};
var getDetalle = function( id_miembro, base){
    
    $.post("miembros", {
        KEY: 'KEY_SHOW_FORM_DETALLE',
        id_miembro:id_miembro,
        base: base
    }, function(mensaje) {
        $("#ben_contenedor").html(mensaje);
        $("#alertas").html("");

    });
};
var getDetalleWithAlerts = function( id_miembro, alertas){
    var base = '';
    $.post("miembros", {
        KEY: 'KEY_SHOW_FORM_DETALLE',
        id_miembro:id_miembro,
        base: base
    }, function(mensaje) {
        $("#ben_contenedor").html(mensaje);
        
        $("#alertas").html(alertas);
    });
};

var setGuardarCancelacion = function() {
    $("#_id_miembro_cancelar").val($("#_id_miembro_cancel").val());
    $('#modal_getCancelarMiembro').modal('toggle');
}

var setActualizarCancelacion = function(){
    var respuesta = '';
    if ($("#_id_miembro_cancelar").val() > 0) {
        $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
        var parametros = {
                KEY: 'KEY_CANCELAR_MEMBRESIA_MIEMBRO',
                _id_miembro: $("#_id_miembro_cancelar").val().toString(),
                _mes_elegido: $("#_seleccion_del_mes").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'miembros',
            type:  'post',
            async: false,
            dataType : 'json',
            success:  function (mensaje) { 
                    $("#_id_miembro_cancelar").val(0);
                    
                    $.msg('unblock');
                    if(mensaje.success == "true"){                        
                        respuesta = "<div class='col-md-3'><div class='callout callout-success'><h4>Alerta:</h4><p>"+mensaje.msg+"</p></div></div>";
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }else{
                        respuesta = "<div class='col-md-3'><div class='callout callout-info'><h4>Alerta:</h4><p>"+mensaje.msg+"</p></div></div>";
                        //$.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }

            },error : function(xhr, status) {
                $.msg('unblock');
                respuesta = "<div class='col-md-3'><div class='callout callout-danger'><h4>Alerta:</h4><p>Disculpe, existió un problema</p></div></div>";
                //$.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
        
    }

    return respuesta;
    
};

var setUserActualizar = function(  id_persona, id_miembro){

    var textoalertas = '';
    
    var _lista_hobbies = []; 
    $('#_lista_hobbies :selected').each(function(i, selected){ 
      _lista_hobbies[i] = $(selected).val();
    });
    
     var _lista_desafio = []; 
    $('#_lista_desafio :selected').each(function(i, selected){ 
      _lista_desafio[i] = $(selected).val();
      //alert($(selected).val().toString());
    });

    var participacion='0';
    if( $('#_participacion').prop('checked') ) {
        participacion="1";
     }
        var parametros = {
                KEY: 'KEY_ACTUALIZAR', 
                _id_empresa: $("#_id_empresa").val().toString(),
				_precio_esp: $("#_precio_esp").val().toString(),
                _id_miembro:id_miembro.toString(),
                _id_persona: id_persona.toString(),
                _propietario: $("#_propietario").val().toString(),
                _nombre: $("#_nombre").val().toString(),
                _apellido: $("#_apellido").val().toString(),
                _titulo: $("#_titulo").val().toString(),
                _fn: $("#_fn").val().toString(),
                _correo: $("#_correo").val().toString(),
                _correo_2: $("#_correo_2").val().toString(),
                _telefono: $("#_telefono").val().toString(), 
                _celular: $("#_celular").val().toString(),
                //_codigo: $("#_codigo").val().toString(),
				_codigo: $("#_cod_1").val().toString() +"-"+ $("#_cod_2").val().toString() +"-"+ $("#_cod_3").val().toString() +"-"+ $("#_cod_4").val().toString() ,
                _tipo_p: $("#_tipo_p").val().toString(),
                _identificacion: $("#_identificacion").val().toString(),
                _genero: $("#_genero").val().toString(),
                _status: $("#_status").val().toString(),
                
                _membresia: $("#_membresia").val().toString(),
                _id_skype: $("#_id_skype").val().toString(),
                _id_Twitter: $("#_id_Twitter").val().toString(),
                _observacion:$("#_observacion").val().toString(),
                _calle: $("#_calle").val().toString(),
                _ciudad: $("#_ciudad").val().toString(),
                _desafios: $("#_desafios").val().toString(),
                _categoria: $("#_categoria").val().toString(),
                _participacion: participacion,
                _lista_desafio:_lista_desafio,
                _lista_hobbies:_lista_hobbies,
                _grupo_asignar:$("#_grupo_asignar").val().toString()
        };

        textoalertas += setAgregarInscripcionEnPrincipal(
            $("#_id_insc").val().toString(), 
            id_miembro.toString(), 
            $("#_fecha_registro").val().toString(), 
            $("#_ins_valor").val().toString(), 
            $("#_estado_presupuesto").val().toString(), 
            $("#_fecha_cobro").val().toString()
        );
       
    

        if ($("#_periodo_presupuesto").val().toString() != "x" && $("#_membresia_presupuesto").val().toString() != "x") {
            textoalertas += setAgregarPresupuestoEnPrincipal(
                $("#_id_presup").val().toString(), 
                id_miembro.toString(), 
                $("#_periodo_presupuesto").val().toString(), 
                $("#_fecha_registro").val().toString(), 
                $("#_membresia_presupuesto").val().toString()
            );        
        }

     
        
        if ($("#_status").val() == 2) {
            textoalertas += setActualizarCancelacion();
        } 
        
            $.ajax({
                data:  parametros,
                url:   'miembros',
                type:  'post',
                dataType : 'json',
                beforeSend: function () {
                    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
                        //$.blockUI({ message: '<h3>Esperé un momento...</h3>'}); 
                },
                success:  function (mensaje) {
                    $.msg('unblock');
                    //$.unblockUI();
                        if(mensaje.success == "true"){
                       textoalertas += "<div class='col-md-3'><div class='callout callout-success'><h4>Alerta:</h4><p>"+mensaje.msg+"</p></div></div>";
                       
                        getDetalleWithAlerts( id_miembro, textoalertas);
                        //$.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        }else if(mensaje.success == "false"){
                        $("#alertas").append(textoalertas + "<div class='col-md-3'><div class='callout callout-info'><h4>Alerta:</h4><p>"+mensaje.msg+"</p></div></div>");
                        //$.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }
                },error : function(xhr, status) {
        //                $.unblockUI();
                    $.msg('unblock');
                    $("#alertas").append(textoalertas + "<div class='col-md-3'><div class='callout callout-danger'><h4>Alerta:</h4><p>Disculpe, existió un problema</p></div></div>");
                    //$.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                }
            }); 
        

               

};


var getRecargar = function(){
    //location.reload();
	window.location.replace(window.location.origin+"/admin/miembros");	
};
var getFiltro = function(key){
   
     var canceladas = 0;
     if ($("#_status_memb").val() != null && $("#_status_memb").val().toString() == "2") {
         canceladas = 1;
         console.log('incluir cancelados');
     }
     
    var filtro= "";
    switch(key){
        case "1":        
            filtro= $("#_grupo").val().toString();
            //$('#_forum option[value="x"]').prop('selected', true);
//            $('#_empresa option[value="x"]').prop('selected', true);
//            $('#_industria option[value="x"]').prop('selected', true);
            
            $('#_empresa').val('x');
            $('#_status_memb').val('x');
            $('#_memb_type').val('x');
            $('#_industria').val('x');
            $(".select2").select2();
            
            break;
        case "2":
            filtro= $("#_forum").val().toString();
            //$('#_grupo option[value="x"]').prop('selected', true);
//            $('#_empresa option[value="x"]').prop('selected', true);
//            $('#_industria option[value="x"]').prop('selected', true);
            $('#_grupo').val('x');
            $('#_status_memb').val('x');
            $('#_memb_type').val('x');
            $('#_empresa').val('x');
            $('#_industria').val('x');
            $(".select2").select2();
            break;
        case "3":
            filtro= $("#_empresa").val().toString();
//            $('#_grupo option[value="x"]').prop('selected', true);
//            $('#_forum option[value="x"]').prop('selected', true);
//            $('#_industria option[value="x"]').prop('selected', true);
            
            $('#_grupo').val('x');
            $('#_status_memb').val('x');
            $('#_memb_type').val('x');
            $('#_forum').val('x');
            $('#_industria').val('x');
            $(".select2").select2();
            break;

        case "4":
            filtro= $("#_industria").val().toString();
//            $('#_grupo option[value="x"]').prop('selected', true);
//            $('#_forum option[value="x"]').prop('selected', true);
//            $('#_empresa option[value="x"]').prop('selected', true);
            $('#_grupo').val('x');
            $('#_status_memb').val('x');
            $('#_memb_type').val('x');
            $('#_forum').val('x');
            $('#_empresa').val('x');
            $(".select2").select2();
            break;
        case "5":
        //_status_memb
        //_memb_type
        filtro= $('#_status_memb').val().toString();
//            $('#_grupo option[value="x"]').prop('selected', true);
//            $('#_forum option[value="x"]').prop('selected', true);
//            $('#_empresa option[value="x"]').prop('selected', true);
            $("#_industria").val("x");
            $('#_grupo').val('x');
            $('#_memb_type').val('x');
            $('#_forum').val('x');
            $('#_empresa').val('x');
            $(".select2").select2();
            break;
        case "6":
        filtro= $('#_memb_type').val().toString();
//            $('#_grupo option[value="x"]').prop('selected', true);
//            $('#_forum option[value="x"]').prop('selected', true);
//            $('#_empresa option[value="x"]').prop('selected', true);
            $('#_status_memb').val("x");
            $("#_industria").val("x");
            $('#_grupo').val('x');
            $('#_forum').val('x');
            $('#_empresa').val('x');
            $(".select2").select2();
            
            break;
            
          
    }
    
      var parametros = {
            KEY: 'KEY_SHOW_FILTRO',
            _key_filtro: key,
            _filtro: filtro,
            _canceladas: canceladas
        };
        $.ajax({
            data:  parametros,
            url:   'miembros',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                //$.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                //$.msg('unblock');
                    if(mensaje.success == "true"){
                        if(key == "1"){
                            //$('#_forum option[value="'+mensaje.id+'"]').prop('selected', true);
                            $('#_forum').val(mensaje.id);
                            $(".select2").select2();
                        }
                        if(key == "2"){
                             //$('#_grupo option[value="'+mensaje.id+'"]').prop('selected', true);
//                             $('#_grupo').val(mensaje.id);
                             $('#_grupo').html(mensaje.gruposfiltro);
                             $(".select2").select2();
                             
                             
                        }
//                        
                        
                        $("#ben_contenedor_filtro").html( mensaje.tabla);
                        getConfTabla();
                    }else{
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
            },error : function(xhr, status) {
//                $.unblockUI();
                //$.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + xhr.toString() + status.toString()});
            }
        });    
};

////////////////////////////////////////////////////////////////////////////////
//presupuesto

var setLimpiarPresupuesto = function (){
    $("#_id_presupuesto").val("");
    $("#_id_miembro_presupuesto").val("");
    //$("#_valor_presupuesto").val("");
    
    $("#btnGuardarPresupuesto").html('Guardar');
    $('#btnGuardarPresupuesto').attr("disabled", false);
};
var getAgregarPresupuesto = function(id_presupuesto, id_miembro,id_membresia, nombre_miembro, id_periodo,  fecha_registro, fechaXPagar,ultimaFechaPagada){

    setLimpiarPresupuesto();
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
var setAgregarPresupuestoEnPrincipal = function(id_presupuesto, id_miembro, id_periodo, fecha_registro, id_membresia) {
    var respuesta = '';
        var parametros = {
                KEY: 'KEY_GUARDAR_PRESUPUESTO',
                _id_presupuesto: id_presupuesto,
                _id_miembro: id_miembro,
                _id_periodo: id_periodo,
                _fecha_registro: fecha_registro,
                _id_membresia: id_membresia
        };
        $.ajax({
            data:  parametros,
            url:   'miembros',
            type:  'post',
            async: false,
            dataType : 'json',
            beforeSend: function () {
               
            },
            success:  function (mensaje) {
                    if(mensaje.success == "true"){
                        respuesta = "<div class='col-md-3'><div class='callout callout-success'><h4>Alerta:</h4><p>"+mensaje.msg+"</p></div></div>";
                        //$.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});               
                    }else{
                        respuesta = "<div class='col-md-3'><div class='callout callout-info'><h4>Alerta:</h4><p>"+mensaje.msg+"</p></div></div>";
                        //$.toaster({ priority : mensaje.priority, title : 'Alerta Membresia', message : mensaje.msg});               
                    }
            },error : function(xhr, status) {
                respuesta = "<div class='col-md-3'><div class='callout callout-danger'><h4>Alerta:</h4><p>Disculpe, existió un problema " 
                + status.toString()+" "+ xhr.toString()+ "</p></div></div>";
                //$.toaster({ priority : 'danger', title : 'Alerta Membresia', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });


        return respuesta;

}
var setAgregarPresupuesto = function(){
        var parametros = {
                KEY: 'KEY_GUARDAR_PRESUPUESTO',
                _id_presupuesto: $("#_id_presupuesto").val().toString(),
                _id_miembro: $("#_id_miembro_presupuesto").val().toString(),
                _id_periodo: $("#_periodo_presupuesto").val().toString(),
                _fecha_registro: $("#_fecha_registro_miembro_presupuesto").val().toString(),
                _id_membresia: $("#_membresia_presupuesto").val().toString()                
        };
        $.ajax({
            data:  parametros,
            url:   'miembros',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                $("#btnGuardarPresupuesto").html('Guardando ...');
                $('#btnGuardarPresupuesto').attr("disabled", true);
            },
            success:  function (mensaje) {
                    if(mensaje.success == "true"){
                        //$.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        $('#modal_agregarPresupuesto').modal('toggle'); 
                        getDetalle($("#_id_miembro_presupuesto").val().toString(),'');
                        setLimpiarPresupuesto();

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
var getDetallePresupuesto = function(id_presupuesto){
        var parametros = {
                KEY: 'KEY_DETALLE_PRESUPUESTO',
                id_presupuesto: id_presupuesto
        };
        $.ajax({
            data:  parametros,
            url:   'miembros',
            type:  'post',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                $.msg('unblock');
                if(id_presupuesto != "0"){
                   $("#respuesta_detalle_presupuesto").html(mensaje);
                }else{
                   $("#respuesta_detalle_presupuesto").html("<center><h1>Debes agregar el presupuesto!</h1></center>");
                }
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });
};
var getInscripcion = function(id_miembro, nombre, fecha_registro, membresia){
        var parametros = {
                KEY: 'KEY_INSCRIPCION',
                id_miembro: id_miembro,
                nombre: nombre,
                fecha_registro: fecha_registro,
                membresia: membresia
        };
        $.ajax({
            data:  parametros,
            url:   'miembros',
            type:  'post',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                $.msg('unblock');
                $("#respuesta_inscrpcion").html(mensaje);
        
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });
};

var setAgregarInscripcionEnPrincipal = function(id_inscripcion, id_miembro_inscripcion, fecha_inscripcion, membresia_inscripcion, estado_inscripcion, fecha_cobro){
    var respuesta = '';
        var parametros = {
                KEY: 'KEY_GUARDAR_INSCRIPCION',
                _id_inscripcion: id_inscripcion,
                _id_miembro_inscripcion: id_miembro_inscripcion,
                _fecha_inscripcion: fecha_inscripcion,
                _membresia_inscripcion: membresia_inscripcion,
                _estado_inscripcion: estado_inscripcion,
                _fecha_cobro: fecha_cobro
                
        };
        $.ajax({
            data:  parametros,
            url:   'miembros',
            type:  'post',
            async: false,
            dataType : 'json',
            beforeSend: function () {
                
            },
            success:  function (mensaje) {
                    if(mensaje.success == "true"){
                        respuesta = "<div class='col-md-3'><div class='callout callout-success'><h4>Alerta:</h4><p>"+mensaje.msg+"</p></div></div>";
                        //$.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});                
                    }else{
                        respuesta = "<div class='col-md-3'><div class='callout callout-info'><h4>Alerta:</h4><p>"+mensaje.msg+"</p></div></div>";
                        //$.toaster({ priority : mensaje.priority, title : 'Alerta Inscripcion', message : mensaje.msg});
                    }
            },error : function(xhr, status) {
              //  $.toaster({ priority : 'danger', title : 'Alerta Inscripcion', message : 'Disculpe, existió un problema ' + status.toString()+" "+ xhr.toString()});
            }
        });
        return respuesta;
};

var setAgregarInscripcion = function(){
        var parametros = {
                KEY: 'KEY_GUARDAR_INSCRIPCION',
                _id_inscripcion: $("#_id_inscripcion").val().toString(),
                _id_miembro_inscripcion: $("#_id_miembro_inscripcion").val().toString(),
                _fecha_inscripcion: $("#_fecha_inscripcion").val().toString(),
                _membresia_inscripcion: $("#_membresia_inscripcion").val().toString(),
                _estado_inscripcion: $("#_estado_inscripcion").val().toString(),
                _fecha_cobro: $("#_fecha_cobro").val().toString()
                
        };
        $.ajax({
            data:  parametros,
            url:   'miembros',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                $("#btnGuardarInscripcion").html('Guardando ...');
                $('#btnGuardarInscripcion').attr("disabled", true);
            },
            success:  function (mensaje) {
                    if(mensaje.success == "true"){
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        $('#modal_inscripcion').modal('toggle'); 
                        getDetalle($("#_id_miembro_inscripcion").val(),'');
//                        $("#btnGuardarInscripcion").html('Guardar');
//                        $('#btnGuardarInscripcion').attr("disabled", false);

                    }else{
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        $("#btnGuardarInscripcion").html('Guardar');
                        $('#btnGuardarInscripcion').attr("disabled", false);
                    }
            },error : function(xhr, status) {
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema ' + status.toString()+" "+ xhr.toString()});
            }
        });

};
var getAsignarUserClave = function(id, user,correo){
    $("#_id_credenciales").val(id.toString());
    $("#_user_credenciales").val(user.toString());   
    $("#_correo_credenciales").val(correo.toString());
    $("#_clave_credenciales").val('');  
    $("#_confirmar_credenciales").val('');  
    if(user != ''){
        $("#_bandera_credenciales").val('1'); 
    }else{
        $("#_bandera_credenciales").val('2');
    }
};
var setActualizarUserPass = function(){
    //$.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var parametros = {
            KEY: 'KEY_ACTUALIZAR_CREDENCIALES',  
            _id: $("#_id_credenciales").val().toString(),
            _user: $("#_user_credenciales").val().toString(),
            _contraseña: $("#_clave_credenciales").val().toString(),
            _confirmar: $("#_confirmar_credenciales").val().toString(),
            _bandera_credenciales: $("#_bandera_credenciales").val().toString(),
            _correo_credenciales: $("#_correo_credenciales").val().toString()
        };
    $.ajax({
        data:  parametros,
        url:   'miembros',
        type:  'post',
        dataType : 'json',
        beforeSend: function () {
                $("#btnActualizarUserClave").html('Actualizando ...');
                $('#btnActualizarUserClave').attr("disabled", true);
            },
        success:  function (mensaje) {  
            //$.msg('unblock');
            if(mensaje.success == "true"){
                getRecargar();
            }else{
                $("#btnActualizarUserClave").html('Guardar');
                $('#btnActualizarUserClave').attr("disabled", false);
                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
            }
            
        },error : function(xhr, status) { 
            //$.msg('unblock');
            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
        }
    });
};


//getGlobalFiltro('1');
var getGlobalFiltro = function(key){
    var base= $("#_sedes").val().toString();
    
    var filtro= "";
    switch(key){
        case "1":    
            filtro= $("#_pais").val().toString();  
			//filtro= '<?php echo $_SESSION['global_pais_temporales']; ?>';  
            break;
        case "2":
            filtro= $("#_sedes").val().toString();
            break;
        case "3":
            filtro= $("#_forum").val().toString();
            $('#_industria').val('x');
            $('#_empresa').val('x');
            $(".select2").select2();
            break;
        case "4":
            filtro= $("#_grupo").val().toString();
            $('#_industria').val('x');
            $('#_empresa').val('x');
            $(".select2").select2();
            break;
        case "5":
            filtro= $("#_empresa").val().toString();
            $('#_grupo').val('x');
            $("#_forum").val('x');
            $('#_industria').val('x');
            $(".select2").select2();
            break;
        case "6":
            filtro= $("#_industria").val().toString();
            $('#_grupo').val('x');
            $("#_forum").val('x');
            $('#_empresa').val('x');
            $(".select2").select2();
            break; 
    }
      var parametros = {
            KEY: 'KEY_GLOBAL_SHOW_FILTRO',
            _key_filtro: key,
            _filtro: filtro,
            _base: base
        };
        $.ajax({
            data:  parametros,
            url:   'miembros',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                $.msg('unblock');
                    if(mensaje.success == "true"){

                        switch(key){
                            case "1":        
                                $("#_sedes").html( mensaje.comboSede);
                                $("#_forum").html( mensaje.comboForum);
                                $("#_grupo").html( mensaje.comboGrupos);
                                $("#_empresa").html( mensaje.comboEmpresa);
                                $("#_industria").html( mensaje.comboIndustria);
                                break;
                            case "2":
                                $("#_forum").html( mensaje.comboForum);
                                $("#_grupo").html( mensaje.comboGrupos);
                                $("#_empresa").html( mensaje.comboEmpresa);
                                $("#_industria").html( mensaje.comboIndustria);
                                break;
                            case "3":
                                if(filtro != 'x'){
//                                    $('#_grupo').val(mensaje.id);
                                    $('#_grupo').html(mensaje.gruposfiltro);   
                                    $(".select2").select2();
                                }   

                                break;
                            case "4":
                                if(filtro != 'x'){         
                                    $("#_forum").val(mensaje.id);
                                    $(".select2").select2();
                                }
                                
                                break;
                            case "5":
                                
                                break;
                            case "6":
                                
                                break;

                        }
           
                        $("#ben_contenedor_filtro").html( mensaje.tabla);
                        getConfTabla();
                    }
                    if(mensaje.success == "false"){
                       $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }
            },error : function(xhr, status) {
                $.unblockUI();
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + xhr.toString() + status.toString()});
            }
        });  
};





////////////////////////////////////////////////////////////////////////////////
//var getAgregarAsistente = function(id){
//    
//    $("#_id_asistente").val(id.toString()); 
//};
//var getLimpiar = function(){
//    $("#_id_asistente").val('');
//    $("#_nombre_asistente").val('');
//    $("#_correo_asistente").val('');
//    $("#_movil_asistente").val('');
//    $("#_apellido_asistente").val('');
//    
//    $("#_fijo_asistente").val('');
//    $('#btnAddAsistente').attr("disabled", false);
//    $("#btnAddAsistente").html('Guardar');
//};
//var setAgregarAsistente = function(){
////    alert($("#_id_asistente").val().toString()+ $("#_nombre_asistente").val().toString());
//    $("#btnAddAsistente").html('Agregando Asistente ...');
//    $('#btnAddAsistente').attr("disabled", true);
//    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
// 
//    var parametros = {
//                KEY: 'KEY_GUARDAR_ASISTENTE',
//                _id_asistente: $("#_id_asistente").val().toString(),
//                _nombre_asistente: $("#_nombre_asistente").val().toString(),
//                _correo_asistente: $("#_correo_asistente").val().toString(),
//                _movil_asistente: $("#_movil_asistente").val().toString(),
//                _apellido_asistente: $("#_apellido_asistente").val().toString(),
//                _funcion_asistente: $("#_funcion_asistente").val().toString(),
//                _fijo_asistente: $("#_fijo_asistente").val().toString()
//        };
//        $.ajax({
//            data:  parametros,
//            url:   'miembros',
//            type:  'post',
//            dataType : 'json',
//            success:  function (mensaje) { 
//                $.msg('unblock');
//                if(mensaje.success == "true"){
//                      $('#modal_getCrearAsistente').modal('toggle');
//                      getDetalle($("#_id_asistente").val().toString());
//                      getLimpiar();
//                      
//                }else{
//                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
//                    $('#btnAddAsistente').attr("disabled", false);
//                    $("#btnAddAsistente").html('Guardar');
//                }
//               
//                  
//            },error : function(xhr, status) {
//               $.msg('unblock');
//               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
//            }
//        });
//};
//var getActualizarAsistente = function(id_miembro, id, nombre, apellido, movil, correo, funcion, fijo){
// 
//    $("#_id_miembro_u").val(id_miembro.toString());
//    $("#_id_asistente_u").val(id.toString());
//    $("#_nombre_asistente_u").val(nombre.toString());
//    $("#_apellido_asistente_u").val(apellido.toString());
//    $("#_correo_asistente_u").val(correo.toString());
//    $("#_movil_asistente_u").val(movil.toString());
//    $("#_movil_fijo_asistente_u").val(fijo.toString());
////    $('#_funcion_asistente_u option[value="' + funcion + '"]').prop('selected', true);
//    $("#_funcion_asistente_u").val(funcion);
//    $(".select2").select2();
//};
//var setActualizarAsistente = function(){
//    $("#btnActAsistente").html('Actualizando Asistente ...');
//    $('#btnActAsistente').attr("disabled", true);
//    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
// 
//    var parametros = {
//                KEY: 'KEY_ACTUALIZAR_ASISTENTE',
//                _id_asistente: $("#_id_asistente_u").val().toString(),
//                _nombre_asistente: $("#_nombre_asistente_u").val().toString(),
//                _correo_asistente: $("#_correo_asistente_u").val().toString(),
//                _movil_asistente: $("#_movil_asistente_u").val().toString(),
//                _apellido_asistente: $("#_apellido_asistente_u").val().toString(),
//                _funcion_asistente: $("#_funcion_asistente_u").val().toString(),
//                _fijo_asistente: $("#_movil_fijo_asistente_u").val().toString()
//        };
//        $.ajax({
//            data:  parametros,
//            url:   'miembros',
//            type:  'post',
//            dataType : 'json',
//            success:  function (mensaje) { 
//                    $.msg('unblock');
//                    if(mensaje.success == "true"){
//                        $('#modal_getActualizarAsistente').modal('toggle');
//                        $('#btnActAsistente').attr("disabled", false);
//                        $("#btnActAsistente").html('Guardar');
//                        getDetalle($("#_id_miembro_u").val().toString());
//                    }else{
//                        $('#btnActAsistente').attr("disabled", false);
//                        $("#btnActAsistente").html('Guardar');
//                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
//                    }
//                    
//            },error : function(xhr, status) {
//               $.msg('unblock');
//               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
//            }
//        });
//};
//
//var setEliminarAsistente = function(_id_miembro, _id_persona){
////alert(_id_persona);
//    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
// 
//    var parametros = {
//                KEY: 'KEY_DELETE_ASISTENTE',
//                _id_persona: _id_persona
//        };
//        $.ajax({
//            data:  parametros,
//            url:   'miembros',
//            type:  'post',
//            dataType : 'json',
//            success:  function (mensaje) { 
//                    $.msg('unblock');
//                    if(mensaje.success == "true"){
//                        getDetalle(_id_miembro);
//                    }else{
//                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
//                    }
//                    
//            },error : function(xhr, status) {
//               $.msg('unblock');
//               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
//            }
//        });
//};
//var getAgregarEmpresa = function(_id_miembro){
//    $("#_id_miembro_empresa").val(_id_miembro);
//      var parametros = {
//            KEY: 'KEY_SHOW_COMBO_EMPRESAS',
//            _id_miembro: _id_miembro
//        };
//        $.ajax({
//            data:  parametros,
//            url:   'miembros',
//            type:  'post',
//            dataType : 'json',
//            success:  function (mensaje) {
//                    if(mensaje.success == "true"){
//                        $("#_lista_empresa").html( mensaje._lista_empresa);
//                        $(".select2").select2();
//                        $('#modal_getAddEmpresa').modal('toggle');
//                    }else{
//                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
//                }
//            },error : function(xhr, status) {
//                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
//            }
//        });    
//};
//var setAddEmpresa = function(){
//    $("#btnAddEmpresa").html('Agregando Empresa ...');
//    $('#btnAddEmpresa').attr("disabled", true);
//    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
// 
//    var parametros = {
//                KEY: 'KEY_ADD_EMPRESA',
//                _id_miembro: $("#_id_miembro_empresa").val().toString(),
//                _descripcion_empresa: $("#_descripcion_empresa").val().toString(),
//                _empresas: $("#_empresas").val().toString()
//
//        };
//        $.ajax({
//            data:  parametros,
//            url:   'miembros',
//            type:  'post',
//            dataType : 'json',
//            success:  function (mensaje) { 
//                    $.msg('unblock');
//                    if(mensaje.success == "true"){
//                        $('#modal_getAddEmpresa').modal('toggle');
//                        $('#btnAddEmpresa').attr("disabled", false);
//                        $("#btnAddEmpresa").html('Guardar');
//                        getDetalle($("#_id_miembro_empresa").val().toString());
//                    }else{
//                        $('#btnAddEmpresa').attr("disabled", false);
//                        $("#btnAddEmpresa").html('Guardar');
//                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
//                    }
//                    
//            },error : function(xhr, status) {
//               $.msg('unblock');
//               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
//            }
//        });
//};                     
//var getActualizarEmpresa = function(_id_miembro, _mie_emp_id, _id_empresa, _descripcion){
//    $("#_id_miembro_empresa_u").val(_id_miembro);
//    $("#_id_mie_emp_empresa_u").val(_mie_emp_id);
//    $("#_descripcion_empresa_u").val(_descripcion);
//      var parametros = {
//            KEY: 'KEY_SHOW_COMBO_EMPRESAS',
//            _id_miembro: _id_miembro,
//            _is_actualizacion:'x'
//        };
//        $.ajax({
//            data:  parametros,
//            url:   'miembros',
//            type:  'post',
//            dataType : 'json',
//            success:  function (mensaje) {
//                    if(mensaje.success == "true"){
//                        $("#_lista_empresa_u").html( mensaje._lista_empresa);
//                        $("#_empresas_u").val(_id_empresa);
//                                   
//                        $(".select2").select2();
//                        $('#modal_getActualizarEmpresa').modal('toggle');
//                    }else{
//                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
//                }
//            },error : function(xhr, status) {
//                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
//            }
//        });    
//};
//var setActualizarEmpresa = function(){
//    $("#setActualizarEmpresa").html('Actualizar Empresa ...');
//    $('#setActualizarEmpresa').attr("disabled", true);
//    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
// 
//    var parametros = {
//                KEY: 'KEY_ACTUALIZAR_MIEMBRO_EMPRESA',
//                _id_miembro_empresa: $("#_id_mie_emp_empresa_u").val().toString(),
//                _descripcion_empresa: $("#_descripcion_empresa_u").val().toString(),
//                _empresas: $("#_empresas_u").val().toString()
//
//        };
//        $.ajax({
//            data:  parametros,
//            url:   'miembros',
//            type:  'post',
//            dataType : 'json',
//            success:  function (mensaje) { 
//                    $.msg('unblock');
//                    if(mensaje.success == "true"){
//                        $('#modal_getActualizarEmpresa').modal('toggle');
//                        $('#setActualizarEmpresa').attr("disabled", false);
//                        $("#setActualizarEmpresa").html('Guardar');
//                        getDetalle($("#_id_miembro_empresa_u").val().toString());
//                    }else{
//                        $('#setActualizarEmpresa').attr("disabled", false);
//                        $("#setActualizarEmpresa").html('Guardar');
//                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
//                    }
//                    
//            },error : function(xhr, status) {
//               $.msg('unblock');
//               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
//            }
//        });
//};
//var setEliminarEmpresa = function(_id_miembro_empresa,_id_miembro){
//    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
// 
//    var parametros = {
//                KEY: 'KEY_DELETE_EMPRESA',
//                _id_miembro_empresa: _id_miembro_empresa
//        };
//        $.ajax({
//            data:  parametros,
//            url:   'miembros',
//            type:  'post',
//            dataType : 'json',
//            success:  function (mensaje) { 
//                    $.msg('unblock');
//                    if(mensaje.success == "true"){
//                        getDetalle(_id_miembro);
//                    }else{
//                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
//                    }
//                    
//            },error : function(xhr, status) {
//               $.msg('unblock');
//               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
//            }
//        });
//};

//getDetalle(19,'');

    
	
	

</script>

 
<?php include(SCRIPT."/script_modal_empresa.php");?>