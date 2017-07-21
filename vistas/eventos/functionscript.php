<script>

var loadgroups = function(){
   /* var forum_id  = $("#_titular").val().toString();
	//alert("Forum ID: " +forum_id);
	
	if(forum_id!=1){
		var dataString = "forum_id=" + forum_id + "&page=loadforumgroups";
	$.ajax({  
		type: "POST",  
		url: "http://www.executiveforums.la/admin/export_to_excel.php",  
		data: dataString, 
		beforeSend: function() 
		{
		$('html, body').animate({scrollTop:0}, 'slow');
			$("#_miembrosGrupos").html('Cargando....');
		},
		success: function(response)
		{
		//	$("#excel").html('Descargar');
			$("#_miembrosGrupos").html(response);
		}
	});
	
	}*/
    console.log($("#_titular").val().toString());
    var parametros = {
        KEY: 'KEY_GRUPO_FORUM_LEADER',
        _id: $("#_titular").val().toString()
    };

    $.ajax({  
		type: "POST",  
		url: "eventos",  
		data: parametros,
		success: function(response)
		{
		//	$("#excel").html('Descargar');
            
			$("#_miembrosGrupos").html(response);
            setCambioGrupos();
		},error : function(xhr, status) {
            
            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' +" "+ xhr.responseText});
        }
	});
    
	
};


var setCambioGrupos = function() {
    var parametros = {
        KEY: 'KEY_MIEMBROS_GRUPOS',
        _id: $("#_miembrosGrupos").val().toString()
    };
    $.ajax({  
		type: "POST",  
		url: "eventos",  
		data: parametros,
		beforeSend: function() 
		{
		$.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
		},
		success: function(response)
		{
		//	$("#excel").html('Descargar');
            $.msg('unblock');
			$("#_empresarios_mes").html(response);
		},error : function(xhr, status) {
            $.msg('unblock');
            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' +" "+ xhr.toString()});
        }
	});
};

var getComponenteEducacional = function () {
    var parametros = {
        KEY: 'KEY_COMPONENTE_EDUCACIONAL'
    };

    $.ajax({
        type: "POST",
        url: 'eventos',
        data: parametros,
        async: false,
        beforeSend: function () {
            $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
        },
        success:  function (mensaje) {
            $.msg('unblock');
                $("#ben_contenedor").html(mensaje);                    
        },error : function(xhr, status) {
            $.msg('unblock');
            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
        }                
    });
}


var getFiltroForumLeader = function() {
    var parametros =  {
        KEY: 'KEY_DETALLE_GRUPO_FORUM_LEADER',
        _id: $("#_forum_leader").val().toString()
    };

    $.ajax({
        data:  parametros,
        url:   'eventos',
        type:  'post',
        async: false,
        success:  function (mensaje) {
                $("#_grupos").html(mensaje);
        },error : function(xhr, status) {                
            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
        }
    });

}

var getRecargar = function(){
    location.reload();
    //window.open(url, 'perfil');
};
////////////////////////////////////////////////////////////////////////////////
//Eventos
////////////////////////////////////////////////////////////////////////////////
var getCrearEvento = function(id_evento){
    
     $.post("eventos", {
            KEY: 'KEY_SHOW_FORM_GUARDAR_EVENTO',
            _id_te: id_evento.toString()          
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
            $(".select2").select2();
        });
};

var getCasoDelMes = function(id) {
    var parametros = {
        KEY: 'KEY_CASO_DEL_MES',
        _id: id
    };
      $.ajax({
            data:  parametros,
            url:   'eventos',
            type:  'post',
            success:  function (mensaje) { 
                
                $("#ben_contenedor").html(mensaje);
               
                  
            },error : function(xhr, status) {                
               
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'+status.toString()});
            }
        });

}
var getAddListaEvento = function( id, nombre){
    var bandera = false; 
     
    $('#_miembros_grupos :selected').each(function(i, selected){//en caso de que se repita en la lista ya no se ingresa        
      if( id == $(selected).val()){  
          bandera = true;
          $("#_miembros_grupos option[value='" + $(selected).val() + "']").remove(); //para cuando lo deschekee
      }
    });
    
    if(bandera == false){
        $('#_miembros_grupos').append('<option value="' + id + '" selected>' + nombre + '</option>');
          
    }

    
};
var getBusquedaEvento_ = function(){

        $.post("eventos", {
            KEY: 'KEY_SHOW_MODAL_FILTRO_EVENTO'
        }, function(mensaje) {
            $("#respuesta_modal").html(mensaje);
            getConfTabla();
        });
    
};
function getBusquedaFiltroEvento() {
    var codigo= $("#_busqueda_dirigida").val();
    if(codigo!="0"){
       $.post("actividades", {
            KEY: 'KEY_SHOW_MODAL_FILTRO_EVENTO',
            id: codigo
        }, function(mensaje) {
            $("#respuesta_modal").html(mensaje);
            getConfTabla();
        });
    }

};
var setAgregarParticipante = function(){
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var parametros = {
                KEY: 'KEY_GUARDAR_PARTICIPANTE',
                _nombre_participante: $("#_nombre_participante").val().toString(),
                _correo_participante: $("#_correo_participante").val().toString(),
                _movil_participante: $("#_movil_participante").val().toString(),
                _apellido_participante: $("#_apellido_participante").val().toString(),
                _tipo:$('#_tipo_participante').val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'eventos',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) { 
                $.msg('unblock');
                if(mensaje.success == "true"){
                      //getDetalle($("#_id_participante").val().toString());
                      $('#modal_getCrearParticipante').modal('toggle');
                      $("#_nombre_participante").val("");
                      $("#_correo_participante").val("");
                      $("#_movil_participante").val("");
                      $("#_apellido_participante").val("");
                      
                      if($('#_tipo_participante').val().toString()=="Invitado"){
                        
                          $("#_participantes").html( mensaje.lista_participantes);
                      }else{
                           $("#_contacto").html( mensaje.lista_participantes);
                      }
                      $('#_tipo_participante').val("");
                      //$('#_participantes').append('<option value="' + id + tipo + '" selected>' + nombre + '</option>'); 
                      $(".select2").select2();
                      
                }else{
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
               
                  
            },error : function(xhr, status) {
               $.msg('unblock');
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};
var getEliminarNoSeleccionados = function(){
    $('#_miembros_grupos option').each(function(i, selected){ 
         if (!this.selected){
            $("#_miembros_grupos option[value='" + $(selected).val() + "']").remove(); 
         }
    });
};

var getActualizarEvento = function(){
    //alert("En Construcción!");
      var parametros = {
             KEY: 'KEY_SHOW_FORM_ACTUALIZAR_EVENTO',
             id: $('#_id_evento_detalle').val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'eventos',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) {
                //$.msg('unblock');
                    if(mensaje.success == "true"){
                        $("#ben_contenedor").html(mensaje.form);
                        $("#respuesta_modal").html(mensaje.modal);
                        $(".select2").select2();
                        getConfTabla();

                    }else{
                        $("#ben_contenedor").html(mensaje.form);
                    }
            },error : function(xhr, status) {
                //$.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });    
};
var setCrearEvento = function(op, id_tipo_evento,opcion_contacto,opcion_acompanado,opcion_invitado,opcion_empresario_mes){ 
    $('#btnGuardar').attr("disabled", true);
    $('#btnGuardarNuevo').attr("disabled", true);
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    
    var _arrayParticipantes = []; 
    if(opcion_invitado.toString() == "1"){
        $('#_participantes :selected').each(function(i, selected){ 
          _arrayParticipantes[i] = $(selected).val();
        });
    }
    var _arrayContactos = [];
    if(opcion_contacto.toString() == "1"){
        $('#_contacto :selected').each(function(i, selected){ 
          _arrayContactos[i] = $(selected).val();
        });
    }

    var _arrayMiembrosGrupos = []; 
    $('#_miembros_grupos :selected').each(function(i, selected){ 
      _arrayMiembrosGrupos[i] = $(selected).val();
    });
    
    
    var _arrayEmpresariosMes = []; 
    if(opcion_empresario_mes.toString() == "1"){
        $('#_empresarios_mes :selected').each(function(i, selected){ 
          _arrayEmpresariosMes[i] = $(selected).val();
        });
    }
    var acompanado="";
    if(opcion_acompanado.toString() == "1"){
        acompanado=$("#_acompanado").val().toString();
    }
    
    //$("#_descripcion").val().toString();

    var fecha_hora_inicio= $("#_f_inicio").val().toString()+' '+ $("#_time_inicio").val().toString();
    var fecha_hora_fin = "";
    if (id_tipo_evento == 3) {
        // si es offsite si maneja fecha fin, en caso contrario no. 
        fecha_hora_fin= $("#_f_fin").val().toString()+' '+ $("#_time_fin").val().toString(); 
    } else {
        fecha_hora_fin= $("#_f_inicio").val().toString()+' '+ $("#_time_fin").val().toString(); 
    }    

    var _all_day='0';
    if( $('#_all_day').prop('checked') ) {
        _all_day="1";
    } 
    
    var parametros = {
            KEY: 'KEY_GUARDAR_EVENTO',
            key_operacion: op.toString(), 
            _id_tipo_evento: id_tipo_evento.toString(), 
            _titular: $("#_titular").val().toString(),
            _nombre: $("#_nombre").val().toString(),
            _fi: fecha_hora_inicio,
            _ff: fecha_hora_fin,
            _id_ubicacion: $("#_ubicacion").val().toString(),
            _ubicacion: 'aaa', 
            _descripcion: $("#_descripcion").val().toString(),           
            _participantes_adicionales: _arrayParticipantes,
		     _mis_grupos: $("#_miembrosGrupos").val().toString(),
		    _miembrosGrupos: $("#_miembrosGrupos").val().toString(),  
            _all_day:_all_day,
            _empresariosMes:_arrayEmpresariosMes,
            _acompanado:acompanado,
            _contactos:_arrayContactos

    };

    console.log($("#_miembrosGrupos").val().toString());
    $.ajax({
        data:  parametros,
        url:   'eventos',
        type:  'post',
        dataType : 'json',

        success:  function (mensaje) {
            $.msg('unblock');
            console.log('entra principal');
            console.log(mensaje.success);
            if(mensaje.success == "true_gn"){
                console.log('entra 1');
                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                getCrearEvento(id_tipo_evento.toString());
                getBusquedaEvento_();
                
            }else if(mensaje.success == "true_g"){
                console.log('entra 2');
                getRecargar();
            }else if(mensaje.success == "false"){
                console.log('entra 3');
                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
            }
            $('#btnGuardar').attr("disabled", false);
            $('#btnGuardarNuevo').attr("disabled", false);
            
            
        },error : function(xhr, status) {
            $.msg('unblock');
            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
        }
    });

};

var setActualizarEvento = function( id_evento,opcion_contacto,opcion_acompanado,opcion_invitado,opcion_empresario_mes){ 

    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    
    var _arrayParticipantes = []; 
    if(opcion_invitado.toString() == "1"){
        $('#_participantes :selected').each(function(i, selected){ 
          _arrayParticipantes[i] = $(selected).val();
        });
    }
    var _arrayContactos = [];
    if(opcion_contacto.toString() == "1"){
        $('#_contacto :selected').each(function(i, selected){ 
          _arrayContactos[i] = $(selected).val();
        });
    }

    var _arrayMiembrosGrupos = []; 
    console.log('el miembro grupo es ' + $("#_miembrosGrupos").val().toString());
    _arrayMiembrosGrupos[0] = $("#_miembrosGrupos").val().toString();
    /*$('#_miembros_grupos :selected').each(function(i, selected){ 
      _arrayMiembrosGrupos[i] = $(selected).val();
    });*/
    
    
    var _arrayEmpresariosMes = []; 
    if(opcion_empresario_mes.toString() == "1"){
        $('#_empresarios_mes :selected').each(function(i, selected){ 
          _arrayEmpresariosMes[i] = $(selected).val();
        });
    }
    var acompanado="";
    if(opcion_acompanado.toString() == "1"){
        acompanado=$("#_acompanado").val().toString();
    }
    
    $("#_descripcion").val().toString()

    var fecha_hora_inicio= $("#_f_inicio").val().toString()+' '+ $("#_time_inicio").val().toString();
    var fecha_hora_fin= $("#_f_fin").val().toString()+' '+ $("#_time_fin").val().toString(); 

    var _all_day='0';
    if( $('#_all_day').prop('checked') ) {
        _all_day="1";
    } 
    if ($("#_puntaje").val() != undefined &&  $("#_puntaje").val().toString().length > 0) {
        var parametros = {
            KEY: 'KEY_ACTUALIZAR_EVENTO',
            _id: id_evento.toString(), 
            _titular: $("#_titular").val().toString(),
            _nombre: $("#_nombre").val().toString(),
            _fi: fecha_hora_inicio,
            _ff: fecha_hora_fin,
            _id_ubicacion: $("#_ubicacion").val().toString(),
            _ubicacion: 'aaa', 
            _descripcion: $("#_descripcion").val().toString(),           
            _participantes_adicionales: _arrayParticipantes,
          //  _miembrosGrupos: _arrayMiembrosGrupos,
		    _miembrosGrupos: $("#_miembrosGrupos").val().toString(), 
            _all_day:_all_day,
            _empresariosMes:_arrayEmpresariosMes,
            _acompanado:acompanado,
            _contactos:_arrayContactos,
            _puntaje: $("#_puntaje").val().toString()
        };
    } else {
        var parametros = {
            KEY: 'KEY_ACTUALIZAR_EVENTO',
            _id: id_evento.toString(), 
            _titular: $("#_titular").val().toString(),
            _nombre: $("#_nombre").val().toString(),
            _fi: fecha_hora_inicio,
            _ff: fecha_hora_fin,
            _id_ubicacion: $("#_ubicacion").val().toString(),
            _ubicacion: 'aaa', 
            _descripcion: $("#_descripcion").val().toString(),           
            _participantes_adicionales: _arrayParticipantes,
          //  _miembrosGrupos: _arrayMiembrosGrupos,
		    _miembrosGrupos: $("#_miembrosGrupos").val().toString(), 
            _all_day:_all_day,
            _empresariosMes:_arrayEmpresariosMes,
            _acompanado:acompanado,
            _contactos:_arrayContactos

        };
    }
    
    $.ajax({
        data:  parametros,
        url:   'eventos',
        type:  'post',
        dataType : 'json',
        success:  function (mensaje) {
            $.msg('unblock');
            if(mensaje.success == "true"){
                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                getRecargar();
            }else{
                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
            }
        },error : function(xhr, status) {
            $.msg('unblock');
            $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
        }
    });

};
var getTipoParticipante = function(tipo){
    $('#_tipo_participante').val(tipo);
    //alert(tipo + 'dsfsfs');
};

var getRecordarEvento = function(){
      var parametros = {
             KEY: 'KEY_RECORDAR_EVENTO',
             id: $('#_id_evento_detalle').val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'eventos',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                $("#btnEnviarCorreo").html('Enviando recordatorio ...');
                $('#btnEnviarCorreo').attr("disabled", true);
            },
            success:  function (mensaje) {
                    if(mensaje.success == "true"){
//                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        
                        getEnviarCorreoIndividual( mensaje.receptores, mensaje.msg,mensaje.asunto);
                        $('#modal_enviarCorreo').modal('toggle');
                           
                    }else{
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }
                    $("#btnEnviarCorreo").html('Recordatorio');
                    $('#btnEnviarCorreo').attr("disabled", false);
            },error : function(xhr, status) {
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });    
};
var getEliminarEvento = function(){
      var parametros = {
             KEY: 'KEY_ELIMINAR_EVENTO',
             _id: $('#_id_evento_detalle').val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'eventos',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                $("#btnEliminarEvento").html('Eliminando ...');
                $('#btnEliminarEvento').attr("disabled", true);
            },
            success:  function (mensaje) {
                        getRecargar();
            },error : function(xhr, status) {
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });    
};
////////////////////////////////////////////////////////////////////////////////
//Dirección
////////////////////////////////////////////////////////////////////////////////
var getTipoDireccion = function(tipo_direccion){
    //alert(tipo_direccion);
    $('#_tipo_direccion').val(tipo_direccion); 
};


var setAgregarDireccion = function(){
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var parametros = {
                KEY: 'KEY_GUARDAR_DIRECCION',
                _ciudad: $("#_ciudad").val().toString(),
                _tipo_direccion: $("#_tipo_direccion").val().toString(),
                _descripcion_direccion: $("#_descripcion_direccion").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'eventos',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) { 
                $.msg('unblock');
                if(mensaje.success == "true"){
                      $('#modal_getCrearDireccion').modal('toggle');
                      $("#_descripcion_direccion").val("");
                      $("#_ubicacion").html(mensaje.lista_direccion);
                      $(".select2").select2();
                      
                }else{
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
               
                  
            },error : function(xhr, status) {
               $.msg('unblock');
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};


var getSincronizarEventoWhithGoogle = function(){
    window.open($("#_url_google_calendar").val().toString());
};












var setLimpiarCorreo = function (){
    $('iframe').contents().find('.wysihtml5-editor').html('');
    $("#_email_asunto").val("");
    $("#_email_mensaje").val("");
    $("#btnRecordatorioEnviarCorreo").html('Recordar');
    $('#btnRecordatorioEnviarCorreo').attr("disabled", false);
    $("#_email_receptor_nombre").val("");
};
var setEnviarCorreoIndividual = function(){

        var parametros = {
                KEY: 'KEY_ENVIAR_CORREO_INDIVIDUAL',
                _email_asunto: $("#_email_asunto").val().toString(),
                _email_mensaje: $("#_email_mensaje").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'eventos',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                $("#btnRecordatorioEnviarCorreo").html('Enviando correo ...');
                $('#btnRecordatorioEnviarCorreo').attr("disabled", true);
            },
            success:  function (mensaje) {
                    if(mensaje.success == "true"){
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        $('#modal_enviarCorreo').modal('toggle'); 
                        setLimpiarCorreo();
                        
                    }else{
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        $("#btnRecordatorioEnviarCorreo").html('Enviar');
                        $('#btnRecordatorioEnviarCorreo').attr("disabled", false);
                    }
            },error : function(xhr, status) {
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });

};

var getEnviarCorreoIndividual = function( _nombre_receptor, _mensaje, _asunto){
   setLimpiarCorreo();
   $("#_email_receptor_nombre").val(_nombre_receptor.toString());
   $("#_email_asunto").val(_asunto);
   $('iframe').contents().find('.wysihtml5-editor').html(_mensaje);
   
};


var getFiltro = function(key){
   
     
    var filtro= "";
    switch(key){
        case "1":        
            filtro= $("#_grupo").val().toString();
            //$('#_forum option[value="x"]').prop('selected', true);
//            $('#_empresa option[value="x"]').prop('selected', true);
//            $('#_industria option[value="x"]').prop('selected', true);
            
            $('#_empresa').val('x');
            $('#_industria').val('x');
            $(".select2").select2();
            
            break;
        case "2":
            filtro= $("#_forum").val().toString();
            //$('#_grupo option[value="x"]').prop('selected', true);
//            $('#_empresa option[value="x"]').prop('selected', true);
//            $('#_industria option[value="x"]').prop('selected', true);
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
            $('#_forum').val('x');
            $('#_empresa').val('x');
            $(".select2").select2();
            break;
            
          
    }
    
      var parametros = {
            KEY: 'KEY_SHOW_FILTRO',
            _key_filtro: key,
            _filtro: filtro
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

</script>
 
