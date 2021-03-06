<script>
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
            url:   'prospectos',
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
};
var getUserEditar = function(id){
     $.post("prospectos", {
            KEY: 'KEY_SHOW_FORM_ACTUALIZAR',
            id: id
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
            $(".select2").select2();
             
         });
};
var getDetalle = function(id){
     $.post("prospectos", {
            KEY: 'KEY_SHOW_FORM_DETALLE',
            id: id
        }, function(mensaje) {
            $("#ben_contenedor").hide();
            $("#ben_contenedor2").show();
            $("#ben_contenedor2").html(mensaje);            
            $(".select2").select2();
         });
};
var getCrear = function(){
     $.post("prospectos", {
            KEY: 'KEY_SHOW_FORM_GUARDAR'
        }, function(mensaje) {
            $("#ben_contenedor").hide();            
            $("#ben_contenedor2").html(mensaje);
            $("#ben_contenedor2").show();
            $(".select2").select2();
         });
};
var setUserCrear = function(op, _esaplicante){
    $('#btnGuardar').attr("disabled", true);
    $('#btnGuardarNuevo').attr("disabled", true);
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    
     var _lista_hobbies = []; 
    $('#_lista_hobbies :selected').each(function(i, selected){ 
      _lista_hobbies[i] = $(selected).val();
    });
    
    var _lista_desafio = []; 
    $('#_lista_desafio :selected').each(function(i, selected){ 
      _lista_desafio[i] = $(selected).val();
    });
    var participacion='0';
    if( $('#_participacion').prop('checked') ) {
        participacion="1";
    }
    var forum='';
    var estadoaplicante='';
    if(_esaplicante == '1'){
        estadoaplicante= $("#_estado_propietario").val().toString();
    }
	        forum= $("#_propietario").val().toString();

   
        var parametros = {
                KEY: 'KEY_GUARDAR',
                key_operacion: op.toString(),  
                _id_empresa: $("#_id_empresa").val().toString(),
                 _codigo: '',
                _propietario: forum,
                _nombre: $("#_nombre").val().toString(),
                _apellido: $("#_apellido").val().toString(),
                _titulo: $("#_titulo").val().toString(),
                _fn: '0000-00-00',
                _correo: 'test@test.com',
                _correo_2: 'test@test.com',
                _telefono: '555', 
                _celular: '5555', 
                _tipo_p: '5555',
                _identificacion: $("#_identificacion").val().toString(),
                _genero: 'M',
                _fuente: $("#_fuente").val().toString(),
                _estado_propietario: '0',
                _id_skype: 'abcd',
                _id_Twitter: 'abcd',
                _observacion:'',
                _calle: '',
                _ciudad: '22',
                _categoria: '1',
                _participacion: participacion,
                _lista_desafio:_lista_desafio,
                _status:  $("#_status").val().toString(),
                _lista_hobbies:_lista_hobbies,
                _lafuente:$("#_lafuente").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'prospectos',
            type:  'post',
            success:  function (mensaje) {
               mensaje = JSON.parse(mensaje);
               console.log(mensaje);
                if(mensaje.success == "true_gn"){
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    getCrear(); 
                    $.msg('unblock');
                }else if(mensaje.success == "true_g"){
                    console.log('estas entrando aca'); 
                    getRecargar();
                    $.msg('unblock');
                    
                }else if(mensaje.success == "false"){
                    $.msg('unblock');
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
                
                $('#btnGuardar').attr("disabled", false);
                $('#btnGuardarNuevo').attr("disabled", false);
            },error : function(xhr, status, error) {
                $.msg('unblock');
                getRecargar();
                /*$.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' 
                + xhr.toString() + status.toString()+ error.toString()});*/
            }
        });

};
var setUserActualizar = function(id_prospecto,  id_persona,_esaplicante){
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var forum='';
    var estadoaplicante='';
    if(_esaplicante == '1'){
        estadoaplicante= $("#_estado_propietario").val().toString();
    }
	        forum= $("#_propietario").val().toString();

    var _lista_hobbies = []; 
    $('#_lista_hobbies :selected').each(function(i, selected){ 
      _lista_hobbies[i] = $(selected).val();
    });
    
    var _lista_desafio = []; 
    $('#_lista_desafio :selected').each(function(i, selected){ 
      _lista_desafio[i] = $(selected).val();
    });
    var participacion='0';
    if( $('#_participacion').prop('checked') ) {
        participacion="1";
    }
console.log("la empresa es" + $("#_id_empresa").val().toString());
        var parametros = {
                KEY: 'KEY_ACTUALIZAR', 
                _id_empresa: $("#_id_empresa").val().toString(),
                _codigo:'',
                _id_prospecto: id_prospecto.toString(),
                _id_persona: id_persona.toString(),
                _propietario: forum,
                _nombre: $("#_nombre").val().toString(),
                _apellido: $("#_apellido").val().toString(),
                _titulo: $("#_titulo").val().toString(),
                _fn: '',
                _correo: '',
                _correo_2: '',
                _telefono: '', 
                _celular: '', 
                _tipo_p: '',
                _identificacion: $("#_identificacion").val().toString(),
                _genero: 'M',
                _fuente: $("#_fuente").val().toString(),
                _estado_propietario:estadoaplicante,
                _id_skype: '',
                _id_Twitter: '',
                _observacion:'',
                _calle: '',
                _ciudad: 22,
                _categoria: 1,
                _participacion: participacion,
                _lista_desafio:_lista_desafio,
                _status:  $("#_status").val().toString(),
                _lista_hobbies:_lista_hobbies,
                _lafuente:$("#_lafuente").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'prospectos',
            type:  'post',
            success:  function (mensaje) {
                console.log('entra aca');
                $.msg('unblock');
                getDetalle(id_prospecto);
                    if(mensaje.success == "true"){
                        console.log('entra aca tambien');
                       getDetalle(id_prospecto);
                    }else if(mensaje.success == "false"){
                       $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }
            },error : function(xhr, status) {
                //$.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' +xhr.toString() + status.toString()});
            }
        });

};
var getConvertirProspecto = function(id, estado_aplicante, forum, nombre_forum, nombre_pa){
    //alert(id + estado_aplicante + forum + nombre_forum);
    
    var msg = ''; 
    $("#convertir_id").val(id);
    $("#pro_prospecto").val(nombre_pa);
    $("#convertir_id_forum").val(forum);
    $("#convertir_nombre_forum").val(nombre_forum);
    

    if(estado_aplicante == 'AC - Applicant Cancel'){
        //$("#convertir_respuesta_modal").html('<center><h1>Debes cambiar el Member Status a Applicant!</h1></center>');
        $('#modal_getSeleccionarStatus').modal('toggle');
    }else{
        $('#modal_getConvertirProspecto').modal('toggle');
    }   
};

var setEstado = function(_id_prospecto) {
    var estado = $("#_"+_id_prospecto).val().toString();
    var parametros = {
        KEY: 'KEY_SET_ESTADO',
        _id_prospecto: _id_prospecto,
        _estado: estado
    };
    $.ajax({
            data:  parametros,
            url:   'prospectos',
             type:  'post',
            dataType : 'json',
            beforeSend: function () {
                    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },success:  function (mensaje) {
                    $.msg('unblock');
                    if(mensaje.success == "true"){
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : "Se cambio el estado del aplicante exitosamente"});
                    }else{
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });

}

var setConvertirAplicante = function(){
        var parametros = {
                KEY: 'KEY_CONVERTIR_APLICANTE',
                _id:  $("#convertir_id").val(),
                _convertir_id_forum:$("#convertir_id_forum").val(),
                _convertir_nombre:$("#pro_prospecto").val(),
                _convertir_nombre_forum: $("#convertir_nombre_forum").val()
        };
        $.ajax({
            data:  parametros,
            url:   'prospectos',
             type:  'post',
            dataType : 'json',
            async: false,
            beforeSend: function () {
                    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },success:  function (mensaje) {
                    $.msg('unblock');
                    if(mensaje.success == "true"){
                  //      load_miembro($("#convertir_id").val());
                  if ($("#_email").is(":checked")) {
                    	window.location.replace("http://"+ window.location.hostname + "/admin/miembros?id_miembro="+$("#convertir_id").val()+"&email=1");	                                                          
                  } else {
                    	window.location.replace("http://"+ window.location.hostname + "/admin/miembros?id_miembro="+$("#convertir_id").val());	                                        
                        //window.location.replace("http://efadmin.localhost:3000/admin/miembros?id_miembro="+$("#convertir_id").val());	                                              
                  }
				
                    }else{
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }
            },error : function(xhr, status) {
                $.msg('unblock');
                window.location.replace("http://"+ window.location.hostname + "/admin/miembros?id_miembro="+$("#convertir_id").val());	                                        
                
                //$.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'+ xhr.toString() + status.toString()});
            }
        });
};
var getRecargar = function(){
    $("#ben_contenedor2").hide();
    $("#ben_contenedor").show();
    location.reload();
    /*
    sessionStorage._recargado_aplicantes = true;
   location.reload();*/
    //window.open(url, 'perfil');
	//window.open('miembros', '?id=54');
	
	
};





function load_miembro(id){
var parametros = {
                KEY: 'KEY_SHOW_FORM_DETALLE', 
                _id_miembro:19,
				base: 'execforums'
        };
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
                       getDetalle( id_miembro,'');
                       //$.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }else if(mensaje.success == "false"){
                       $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
            },error : function(xhr, status) {
//                $.unblockUI();
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });


}


var getAdd = function( id, nombre){
    $('#convertir_id_empresa').val(id.toString());
    $('#pro_empresa').val(nombre.toString());
    $("#respuesta_modal").html("");
  
};
function getBusquedaFiltro() {
    $.post("prospectos", {
        KEY: 'KEY_SHOW_MODAL_FILTRO'
    }, function(mensaje) {
        $("#respuesta_modal").html(mensaje);
        getConfTabla();
    });
};

var getFiltroWithParams = function(parametros) {
    $.ajax({
            data:  parametros,
            url:   'prospectos',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                //$.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                //$.msg('unblock');
                    if(mensaje.success == "true"){
                        $("#ben_contenedor_filtro").html( mensaje.tabla);
                        getConfTabla();
                    }else{
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
            },error : function(xhr, status) {
                //$.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + xhr.toString() + status.toString()});
            }
        });    
};
var getFiltro = function(key){ 
    var filtro= "";
    switch(key){
        case "2":
            filtro= $("#_forum").val().toString();

            $('#_estado').val('x');
            $(".select2").select2();
            break;
        case "3":
            filtro= $("#_empresa").val().toString();
            $('#_forum').val('x');
            $('#_industria').val('x');
            $(".select2").select2();
            break;

        case "4":
            filtro= $("#_industria").val().toString();
            $('#_forum').val('x');
            $('#_empresa').val('x');
            break;    

        case "5":
            filtro= $("#_estado").val().toString();
            $('#_forum').val('x');
    
            break;    
}


    
    sessionStorage._forum = $('#_forum').val().toString();
    sessionStorage._estado = $('#_estado').val().toString();    
    sessionStorage.llave = 'KEY_SHOW_FILTRO';
    sessionStorage._key_filtro = key;
    sessionStorage._filtro = filtro;
    
      var parametros = {
            KEY: 'KEY_SHOW_FILTRO',
            _key_filtro: key,
            _filtro: filtro
        };
        $.ajax({
            data:  parametros,
            url:   'prospectos',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                //$.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                //$.msg('unblock');
                    if(mensaje.success == "true"){
                        $("#ben_contenedor_filtro").html( mensaje.tabla);
                        getConfTabla();
                    }else{
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
            },error : function(xhr, status) {
                //$.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + xhr.toString() + status.toString()});
            }
        });    
}; 
var getAprobarCan = function(id, correo, nombre){
    var msg = ''; 
    $("#aprobar_id").val(id);
    $("#aprobar_msg").text("¿Está completamente seguro de aprobar el Prospecto?"); 
    
    //Para la asignación
    $("#asignar_id").val(id);
    $("#asignar_correo").val(correo); 
    $("#asignar_nombre").val(nombre);
};
var getAsignarCan = function(id, correo, nombre){
    
    $("#asignar_id").val(id);
    $("#asignar_correo").val(correo); 
    $("#asignar_nombre").val(nombre);
    
}; 
var setAprobarCan = function(){
        $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
        var parametros = {
                KEY: 'KEY_APROBAR_PROSPECTO',
                _id: $("#aprobar_id").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'prospectos',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) {
                $.msg('unblock');
                if(mensaje.success == "true"){
                    getDetalle($("#aprobar_id").val().toString());
                    $('#modal_getAsignarCan').modal('toggle');
                }else{
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};
var setConvertirProspecto = function(){
 
    if($("#asignar_user").val() != "0"){
     
//        if($("#asignar_correo").val() != ''){
            $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
              var parametros = {
                    KEY: 'KEY_CONVERTIR_PROSPECTO',
                    id: $("#asignar_id").val().toString(),
                    iduserforum: $("#asignar_user").val().toString(),
                    correo_candidato: $("#asignar_correo").val().toString(),
                    asignar_nombre: $("#asignar_nombre").val().toString(),
                    nombre_forum:$("#asignar_user option:selected").text()
            };
            $.ajax({
                data:  parametros,
                url:   'prospectos',
                type:  'post',
                dataType : 'json',
                success:  function (mensaje) {
                        $.msg('unblock');
                        if(mensaje.success == "true"){
                            getRecargar();
                        }else{
                            $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        }
                },error : function(xhr, status) {
                    $.msg('unblock');
                    $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                }
            });
//        }else{
//            $.toaster({ priority : 'info', title : 'Alerta', message : 'Debes agregar un correo!'});
//        }
        }else{
            $.toaster({ priority : 'info', title : 'Alerta', message : 'Debes seleccionar un usuario!'});
        }
};

</script>
 
<?php include(SCRIPT."/script_modal_empresa.php");?>