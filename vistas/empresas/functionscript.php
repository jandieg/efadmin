<script>  
var getDetalle = function(id){
    $.post("empresas", {
        KEY: 'KEY_SHOW_FORM_DETALLE',
        id: id
    }, function(mensaje) {
        $("#ben_contenedor").html(mensaje);
    });              
};
var getActualizar = function(id){
     $.post("empresas", {
            KEY: 'KEY_SHOW_FORM_ACTUALIZAR',
            id: id.toString()
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
            $(".select2").select2();
        });
}; 
var getCrear = function(){
     $.post("empresas", {
            KEY: 'KEY_SHOW_FORM_GUARDAR'
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
            $(".select2").select2();
         });
};
var setCrear = function(op, _bandera){
        $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
        
        var _arrayIndustria = []; 
        $('#_industria :selected').each(function(i, selected){ 
          _arrayIndustria[i] = $(selected).val();
        });
        var parametros = {
                KEY: 'KEY_GUARDAR',
                key_operacion: op.toString(),        
                _empresa: $("#_empresa").val().toString(),
//                _estado: $("#_estado").val().toString(),
                _ruc: $("#_ruc").val().toString(),
                _ingresos: '0',//$("#_ingresos").val().toString(),
                _numero_empleados: 0,//$("#_numero_empleados").val().toString(),
                _industria:_arrayIndustria,
                _fax: '5555',//$("#_fax").val().toString(),
                _sitio_web: $("#_sitio_web").val().toString(),
                _correo1: 'test@test.com',//$("#_correo1").val().toString(),
                _movil: '5555',//$("#_movil").val().toString(),
                _ciudad: $("#_ciudad").val().toString(),
                _calle: $("#_calle").val().toString(),
                _bandera:_bandera
               
        };
        $.ajax({
            data:  parametros,
            url:   'empresas',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) {
                if(mensaje.success == "true_gn"){
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        getCrear();

                }else if(mensaje.success == "true_g"){
                    getRecargar();
                }else if(mensaje.success == "false"){
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
                $.msg('unblock');
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });

};
var setActualizar = function(id){
   
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    
     var _arrayIndustria = []; 
        $('#_industria :selected').each(function(i, selected){ 
        _arrayIndustria[i] = $(selected).val();
    });
    
    var parametros = {
            KEY: 'KEY_ACTUALIZAR',
            _id: id,
            _empresa: $("#_empresa").val().toString(),
//            _estado: $("#_estado").val().toString(),
            _ruc: $("#_ruc").val().toString(),
            _ingresos: '0',//$("#_ingresos").val().toString(),
            _numero_empleados: '0',//$("#_numero_empleados").val().toString(),
            _industria:_arrayIndustria,
            _fax: '5555',//$("#_fax").val().toString(),
            _sitio_web: $("#_sitio_web").val().toString(),
            _correo1: 'test@test.com',//$("#_correo1").val().toString(),
            _movil: '5555',//$("#_movil").val().toString(),
            _ciudad: $("#_ciudad").val().toString(),
            _calle: $("#_calle").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'empresas',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) {
                $.msg('unblock');
                if(mensaje.success == "true"){
                     getDetalle(id);
                }else{
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
    
                  
            },error : function(xhr, status) {
               $.msg('unblock');
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};
var getRecargar = function(){
    sessionStorage._recargado_empresas2 = true;
    location.reload();
};
var getAgregarContacto = function(id){
    $("#_id_contacto_empresa").val(id.toString()); 
};
var getLimpiar = function(){
    $("#_id_contacto_empresa").val('');
    $("#_nombre_contacto_empresa").val('');
    $("#_correo_contacto_empresa").val('');
    $("#_movil_contacto_empresa").val('');
    $("#_apellido_contacto_empresa").val('');
    
    $("#_fijo_contacto_empresa").val('');
    $('#btnAddContacto').attr("disabled", false);
};
var setAgregarContacto = function(){
    //$("#btnAddContacto").html('Enviando correo ...');
    $('#btnAddContacto').attr("disabled", true);
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
 
    var parametros = {
                KEY: 'KEY_GUARDAR_CONTACTO',
                _id_contacto_empresa: $("#_id_contacto_empresa").val().toString(),
                _nombre_contacto_empresa: $("#_nombre_contacto_empresa").val().toString(),
                _correo_contacto_empresa: $("#_correo_contacto_empresa").val().toString(),
                _movil_contacto_empresa: $("#_movil_contacto_empresa").val().toString(),
                _apellido_contacto_empresa: $("#_apellido_contacto_empresa").val().toString(),
                _funcion_contacto_empresa: $("#_funcion_contacto_empresa").val().toString(),
                _fijo_contacto_empresa: $("#_fijo_contacto_empresa").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'empresas',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) { 
                $.msg('unblock');
                if(mensaje.success == "true"){
                      $('#modal_getCrearContacto').modal('toggle');
                      getDetalle($("#_id_contacto_empresa").val().toString());
                      getLimpiar();
                      
                }else{
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    $('#btnAddContacto').attr("disabled", false);
                }
               
                  
            },error : function(xhr, status) {
               $.msg('unblock');
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};
var getActualizarContacto = function(id_empresa, id, nombre, apellido, movil, correo, funcion, fijo){
 
    
    $("#_id_empresa_u").val(id_empresa.toString());
    $("#_id_contacto_u").val(id.toString());
    $("#_nombre_contacto_empresa_u").val(nombre.toString());
    $("#_apellido_contacto_empresa_u").val(apellido.toString());
    $("#_correo_contacto_empresa_u").val(correo.toString());
    $("#_movil_contacto_empresa_u").val(movil.toString());
    $("#_fijo_contacto_empresa_u").val(fijo.toString());
    $('#_funcion_contacto_empresa_u option[value="' + funcion + '"]').prop('selected', true);
};
var setActualizarContacto = function(){

    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
 
    var parametros = {
                KEY: 'KEY_ACTUALIZAR_CONTACTO',
                _id_contacto_empresa: $("#_id_contacto_u").val().toString(),
                _nombre_contacto_empresa: $("#_nombre_contacto_empresa_u").val().toString(),
                _correo_contacto_empresa: $("#_correo_contacto_empresa_u").val().toString(),
                _movil_contacto_empresa: $("#_movil_contacto_empresa_u").val().toString(),
                _apellido_contacto_empresa: $("#_apellido_contacto_empresa_u").val().toString(),
                _funcion_contacto_empresa: $("#_funcion_contacto_empresa_u").val().toString(),
                _fijo_contacto_empresa: $("#_fijo_contacto_empresa_u").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'empresas',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) { 
                    $.msg('unblock');
                    if(mensaje.success == "true"){
                        $('#modal_getActualizarContacto').modal('toggle');
                        getDetalle($("#_id_empresa_u").val().toString());
                    }else{
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }
                    
            },error : function(xhr, status) {
               $.msg('unblock');
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};

var getMostrarTodas = function() {
    var key = 9;
    var filtro = "x";
    var _mostrar_todas = 0;
    
    if ($("#_mostrar_todas").is(":checked")) {
        _mostrar_todas = 1;
    }
    if ($("#_forum").val().toString() != "x") {
        key = 2;
        filtro = $("#_forum").val().toString();
    }

    if ($("#_industria").val().toString() != "x") {
        key = 4;
        filtro = $("#_industria").val().toString();
    }

    sessionStorage._forum = $('#_forum').val().toString();
    sessionStorage._industria = $('#_industria').val().toString();    
    sessionStorage.llave = 'KEY_SHOW_FILTRO';
    sessionStorage._key_filtro = key;
    sessionStorage._filtro = filtro;
    sessionStorage._mostrar_todas = _mostrar_todas;

    var parametros = {
            KEY: 'KEY_SHOW_FILTRO',
            _key_filtro: key,
            _filtro: filtro,
            _mostrar_todas: _mostrar_todas
        };
        $.ajax({
            data:  parametros,
            url:   'empresas',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) {
                    if(mensaje.success == "true"){
                        if(key == "1"){
                            $('#_forum option[value="'+mensaje.id+'"]').prop('selected', true);
                        }
                       /* if(key == "2"){
                             $('#_grupo option[value="'+mensaje.id+'"]').prop('selected', true);
                        }*/
 
                        $("#ben_contenedor_filtro").html( mensaje.tabla);
                        getConfTabla();
                    }else{
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
            },error : function(xhr, status) {
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + xhr.toString() + status.toString()});
            }
        });
};
	
var getFiltroWithParams = function(parametros) {
    $.ajax({
            data:  parametros,
            url:   'empresas',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) {
                    if(mensaje.success == "true"){
                        if(parametros._key_filtro == "1"){
                            $('#_forum option[value="'+mensaje.id+'"]').prop('selected', true);
                        }

                        $("#ben_contenedor_filtro").html( mensaje.tabla);
                        getConfTabla();
                    }else{
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
            },error : function(xhr, status) {
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + xhr.toString() + status.toString()});
            }
        });
};
var getFiltro = function(key){
   
     var _mostrar_todas = 0;
     if ($("#_mostrar_todas").is(":checked")) {
         _mostrar_todas = 1;
     }
    var filtro= "";
    switch(key){
        /*case "1":        
            filtro= $("#_grupo").val().toString();
            $('#_forum option[value="x"]').prop('selected', true);
            $('#_industria option[value="x"]').prop('selected', true);
            break;*/
        case "2":
            filtro= $("#_forum").val().toString();
            //$('#_grupo option[value="x"]').prop('selected', true);
            $('#_industria option[value="x"]').prop('selected', true);
            break;
        case "4":
            filtro= $("#_industria").val().toString();
            //$('#_grupo option[value="x"]').prop('selected', true);
            $('#_forum option[value="x"]').prop('selected', true);
            break;                      
    }

    sessionStorage._forum = $('#_forum').val().toString();
    sessionStorage._industria = $('#_industria').val().toString();    
    sessionStorage.llave = 'KEY_SHOW_FILTRO';
    sessionStorage._key_filtro = key;
    sessionStorage._filtro = filtro;
    sessionStorage._mostrar_todas = _mostrar_todas;
    
   
      var parametros = {
            KEY: 'KEY_SHOW_FILTRO',
            _key_filtro: key,
            _filtro: filtro,
            _mostrar_todas: _mostrar_todas
        };
        $.ajax({
            data:  parametros,
            url:   'empresas',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) {
                    if(mensaje.success == "true"){
                        if(key == "1"){
                            $('#_forum option[value="'+mensaje.id+'"]').prop('selected', true);
                        }
                       /* if(key == "2"){
                             $('#_grupo option[value="'+mensaje.id+'"]').prop('selected', true);
                        }*/
 
                        $("#ben_contenedor_filtro").html( mensaje.tabla);
                        getConfTabla();
                    }else{
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
            },error : function(xhr, status) {
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + xhr.toString() + status.toString()});
            }
        });    
};

</script>

        