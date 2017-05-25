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
};


var getComboCargarGrupos = function(){
      var parametros = {
            KEY: 'KEY_SHOW_COMBO_GRUPOS',
            _propietario: $("#_propietario").val().toString()
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
         });
};
var getDetalle = function( id_miembro){
     $.post("miembros", {
            KEY: 'KEY_SHOW_FORM_DETALLE',
            id_miembro:id_miembro
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
           
         });
};

var setUserCrear = function(op){
    
      var _lista_hobbies = []; 
    $('#_lista_hobbies :selected').each(function(i, selected){ 
      _lista_hobbies[i] = $(selected).val();
    });
    
     var _lista_desafio = []; 
    $('#_lista_desafio :selected').each(function(i, selected){ 
      _lista_desafio[i] = $(selected).val();
    //  alert($(selected).val().toString());
    });

    var _arrayIndustria = []; 
    $('#_industria :selected').each(function(i, selected){ 
      _arrayIndustria[i] = $(selected).val();
    //  alert($(selected).val().toString());
    });
    var participacion='0';
    if( $('#_participacion').prop('checked') ) {
        participacion="1";
     }

        var parametros = {
                KEY: 'c_insert',
                key_operacion: op.toString(),  
                _propietario: $("#_propietario").val().toString(),
                _nombre: $("#_nombre").val().toString(),
                _apellido: $("#_apellido").val().toString(),
                _titulo: $("#_titulo").val().toString(),
                _fn: $("#_fn").val().toString(),
                _correo: $("#_correo").val().toString(),
                _correo_2: $("#_correo_2").val().toString(),
                _telefono: $("#_telefono").val().toString(), 
                _celular: $("#_celular").val().toString(),
                
                _tipo_p: $("#_tipo_p").val().toString(),
                _identificacion: $("#_identificacion").val().toString(),
                _genero: $("#_genero").val().toString(),
                
                _fuente: $("#_fuente").val().toString(),
                _empresa: $("#_empresa").val().toString(),
                _ingresos: $("#_ingresos").val().toString(),
                _numero_empleados: $("#_numero_empleados").val().toString(),
                _industria:_arrayIndustria,
                _fax: $("#_fax").val().toString(),
                _sitio_web: $("#_sitio_web").val().toString(),
                _estado_propietario: $("#_estado_propietario").val().toString(),
                _id_skype: $("#_id_skype").val().toString(),
                _id_Twitter: $("#_id_Twitter").val().toString(),
                
                _calle: $("#_calle").val().toString(),
                _ciudad: $("#_ciudad").val().toString(),
                _pais: $("#_pais").val().toString(),
                _provincia: $("#_provincia").val().toString(),
                _desafios: $("#_desafios").val().toString(),
                _categoria: $("#_categoria").val().toString(),
                _codigo: $("#_codigo").val().toString(),
                _participacion: participacion,
                _lista_desafio:_lista_desafio,
                _lista_hobbies:_lista_hobbies
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
                    if(mensaje.success == "true_gn"){
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                            getCrear();      
                    }else if(mensaje.success == "true_g"){
                        getRecargar();
                    }else if(mensaje.success == "false"){
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
            },error : function(xhr, status) {
//                $.unblockUI();
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });

};
var setUserActualizar = function(  id_persona, id_miembro){

    var _lista_hobbies = []; 
    $('#_lista_hobbies :selected').each(function(i, selected){ 
      _lista_hobbies[i] = $(selected).val();
    });
    
     var _lista_desafio = []; 
    $('#_lista_desafio :selected').each(function(i, selected){ 
      _lista_desafio[i] = $(selected).val();
      //alert($(selected).val().toString());
    });

//    var _arrayIndustria = []; 
//    $('#_industria :selected').each(function(i, selected){ 
//      _arrayIndustria[i] = $(selected).val();
//    //  alert($(selected).val().toString());
//    });
    var participacion='0';
    if( $('#_participacion').prop('checked') ) {
        participacion="1";
     }

        var parametros = {
                KEY: 'KEY_ACTUALIZAR', 
                _id_miembro:id_miembro.toString(),
                _id_empresa: $("#_id_empresa").val().toString(),
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
                 _codigo: $("#_codigo").val().toString(),
                _tipo_p: $("#_tipo_p").val().toString(),
                _identificacion: $("#_identificacion").val().toString(),
                _genero: $("#_genero").val().toString(),
                 _status: $("#_status").val().toString(),
                
                _membresia: $("#_membresia").val().toString(),
//                _ingresos: $("#_ingresos").val().toString(),
//                _numero_empleados: $("#_numero_empleados").val().toString(),
//                _industria:_arrayIndustria,
//                _fax: $("#_fax").val().toString(),
//                _sitio_web: $("#_sitio_web").val().toString(),
                _id_skype: $("#_id_skype").val().toString(),
                _id_Twitter: $("#_id_Twitter").val().toString(),
                
                _calle: $("#_calle").val().toString(),
                _ciudad: $("#_ciudad").val().toString(),
                _desafios: $("#_desafios").val().toString(),
                _categoria: $("#_categoria").val().toString(),
                _participacion: participacion,
                _lista_desafio:_lista_desafio,
                _lista_hobbies:_lista_hobbies,
                _grupo_asignar:$("#_grupo_asignar").val().toString()
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
                       getDetalle( id_miembro);
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

};
var getConvertirProspecto = function(id){

    var msg = ''; 
    $("#convertir_id").val(id);
    $("#pro_prospecto").val($("#oculto_nombre_prospecto").val().toString());
    $("#pro_empresa").val($("#oculto_empresa_nombre").val().toString());
 
};
var setConvertirProspecto = function(){
        var parametros = {
                KEY: 'u_convertir',
                _id:  $("#convertir_id").val(),
                _empresa:$("#pro_empresa").val()
        };
        $.ajax({
            data:  parametros,
            url:   'miembros',
             type:  'post',
            dataType : 'json',
            beforeSend: function () {
                    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },success:  function (mensaje) {
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
}
var getRecargar = function(){
    location.reload();
    //window.open(url, 'perfil');
};

var getGlobalFiltro = function(key){
    var base= $("#_sedes").val().toString();
    
    var filtro= "";
    switch(key){
        case "1":        
            filtro= $("#_pais").val().toString();          
            break;
        case "2":
            filtro= $("#_sedes").val().toString();
            break;
        case "3":
            filtro= $("#_forum").val().toString();
            break;
        case "4":
            filtro= $("#_grupo").val().toString();
            break;
        case "5":
            filtro= $("#_empresa").val().toString();
            break;
        case "6":
            filtro= $("#_industria").val().toString();
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
            url:   'globalmiembros',
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
                                    $("#_grupo").html( mensaje.comboGrupos);
                                }   

                                break;
                            case "4":
                                if(filtro != 'x'){
                                    $("#_forum").html( mensaje.comboForum);
                                }
//                              $('#_forum option[value="'+mensaje.id+'"]').prop('selected', true);
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
                        getDetalle($("#_id_miembro_presupuesto").val().toString());
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

var setAgregarInscripcion = function(){
        var parametros = {
                KEY: 'KEY_GUARDAR_INSCRIPCION',
                _id_inscripcion: $("#_id_inscripcion").val().toString(),
                _id_miembro_inscripcion: $("#_id_miembro_inscripcion").val().toString(),
                _fecha_inscripcion: $("#_fecha_inscripcion").val().toString(),
                _membresia_inscripcion: $("#_membresia_inscripcion").val().toString(),
                _estado_inscripcion: $("#_estado_inscripcion").val().toString()
                
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
                        getDetalle($("#_id_miembro_inscripcion").val());
//                        $("#btnGuardarInscripcion").html('Guardar');
//                        $('#btnGuardarInscripcion').attr("disabled", false);

                    }else{
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        $("#btnGuardarInscripcion").html('Guardar');
                        $('#btnGuardarInscripcion').attr("disabled", false);
                    }
            },error : function(xhr, status) {
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
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
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
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
};
var setActualizarCredencialesGlobales = function(){
     $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var parametros = {
            KEY: 'KEY_ACTUALIZAR_CREDENCIALES_GLOBALES'
        };
    $.ajax({
        data:  parametros,
        url:   'miembros',
        type:  'post',
        dataType : 'json',
        success:  function (mensaje) {  
            $.msg('unblock');
            if(mensaje.success == "true"){
                getRecargar();
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

</script>
 
