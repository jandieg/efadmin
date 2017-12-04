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


var getDetalleFiltroAnho = function(){
    //todo
    var _key_filtro = "";
    var id = "";
    if ($("#_empresa").val() != null && $("#_empresa").val().toString() != "x") {
        _key_filtro = "EMPRESA";
        id = $("#_empresa").val().toString();
    }

    if ($("#_grupos").val() != null && $("#_grupos").val().toString() != "x") {
        _key_filtro = "GRUPO";
        id = $("#_grupos").val().toString();
    }

    if ($("#_miembros").val() != null && $("#_miembros").val().toString() != "x") {
        _key_filtro = "MIEMBRO";
        id = $("#_miembros").val().toString();
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


var getDetalleFiltroEmpresa = function(){
        
        var parametrosMiembro = {
            KEY: 'KEY_ACTUALIZA_FILTRO_MIEMBRO_EMPRESA',
            _id: $("#_empresa").val().toString()
        }

        $.ajax({
            data:  parametrosMiembro,
            url:   'cobros',
            type:  'post',
            async: false,
            success:  function (mensaje) {
                    $("#_miembros").html(mensaje);
            },error : function(xhr, status) {                
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });

        var parametrosGrupo = {
            KEY: 'KEY_ACTUALIZA_FILTRO_GRUPO_EMPRESA',
            _id: $("#_empresa").val().toString()
        }

        $.ajax({
            data:  parametrosGrupo,
            url:   'cobros',
            type:  'post',
            async: false,
            success:  function (mensaje) {
                    $("#_grupos").html(mensaje);
            },error : function(xhr, status) {                
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });
        

        
   
        var parametros = {
            KEY: 'KEY_DETALLE_FILTRO_EMPRESA',
            _id: $("#_empresa").val().toString(),
            _key_filtro: "EMPRESA",
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

var getDetalleFiltroMiembro = function(){
     
   
        var parametros = {
            KEY: 'KEY_DETALLE_FILTRO_EMPRESA',
            _id: $("#_miembros").val().toString(),
            _key_filtro: "MIEMBRO",
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

var getDetalleFiltroGrupo = function(){
        var id=""; 
         var parametrosMiembro = {
            KEY: 'KEY_ACTUALIZA_FILTRO_MIEMBRO_GRUPO',
            _id: $("#_grupos").val().toString()
        }

        $.ajax({
            data:  parametrosMiembro,
            url:   'cobros',
            type:  'post',
            async: false,
            success:  function (mensaje) {
                    $("#_miembros").html(mensaje);
            },error : function(xhr, status) {                
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema' + status.toString()+" "+ xhr.toString()});
            }
        });
        id= $("#_grupos").val().toString();

        $(".select2").select2();
        
   
        var parametros = {
            KEY: 'KEY_DETALLE_FILTRO_EMPRESA',
            _id: id.toString(),
            _key_filtro: "GRUPO",
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




var cambioAnhoCobro = function() {
    var parametros = {
        KEY: 'KEY_DETALLE_COBRO_ANHO',
        _id_miembro: $("#_id_miembro_cobro").val().toString(),
        _anho: $("#_anho_cobro").val().toString()
    };
    $.ajax({
        data: parametros,
        url: 'cobros',
        type: 'post',
        beforeSend: function() {
            $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
        },
        success: function (mensaje) {
            $.msg('unblock');
            
            $("#_montopagado").val(0);
            $("#_montoreversado").val(0);
            $("#detalleCuenta").html(mensaje);
        },error : function(xhr, status) {
            
            $.msg('unblock');
            $("#_montopagado").val(0);
            $("#_montoreversado").val(0);
            $("#detalleCuenta").html("Disculpe hubo un error al procesar la data");
        }
    });
}

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

var estanSalteados = function() {
    var resp = false;
    var actual = 0; 
    //0 => iniclal
    //1 => vacio/sin seleccionar
    //2 => seleccionado
    var el = document.getElementsByClassName('case');
    for (var i=0; i<el.length; i++) {
        if (el[i].checked) {
            if (actual == 1) {
                //si selecciono 
                //y el anterior 
                //no esta seleccionado 
                //estoy saltandome
                resp = true;
            }
            actual = 2;
        } else {
            actual = 1;
        }
    }
    
    return resp;
}

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
                _formapago: 1,
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

var fillModalEditarCobro = function(id_precobro) {
    var datos = $('input[name='+id_precobro+']').val();
    $("#_id_valor_precobro").val(id_precobro);
    $("#_valor_cobro").val(datos);
};

var setEditarCobro = function() {
    var precobro_id = $("#_id_valor_precobro").val();
    var cobro = $("#_valor_cobro").val();
    

      $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var parametros = {
        KEY: 'KEY_ACTUALIZAR_DETALLE_COBRO',  
        _id: precobro_id,
        _cobro: cobro
    };

    
    $.ajax({
        data:  parametros,
        url:   'cobros',
        type:  'post',
        dataType : 'json',
        success:  function (mensaje) { 
            if(mensaje.success == "true"){
                $("#_" + precobro_id).html("$ " + cobro);
                $('input[name='+precobro_id+']').val(cobro);                
                $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                $('#modal_editarCobro').modal('toggle');  
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

var setCobrarAdminReg = function(){
    var cont= $("#selectall").attr("name");
    var listaIDDetalle = [];
    var montopagar = Number($("#_montopagado").val());
    var banderacredito = 0;
    var resto = 0;
    
    if ($("#_credito").is(":checked")) {
        banderacredito = 1;
        montopagar += Number($("#_credito").val());
    }

    var bandera = true;
    
    $(".case").each(function() {
        if (Number($(this).val()) <= montopagar && bandera) {            
            montopagar -= $(this).val();
            listaIDDetalle.push($(this).attr("name"));            
        } else {
            bandera = false;
        }
    });
    
    console.log('El monto a pagar es: ' + montopagar);

    if (! estanSalteados()) {
        
    
    $('#btnGuardar').attr("disabled", true);
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var parametros = {
                KEY: 'KEY_GUARDAR_COBRO_ADMIN_REG',  
                _lista_id_detalle_presupuesto: listaIDDetalle,
                _id_presupuesto: $("#_id_presupuesto_cobro").val().toString(),
                _formapago: 1,
                _id_miembro:$("#_id_miembro_cobro").val().toString(),
                _resto: montopagar,
                _fecha: $("#_fecha_cobro").val().toString(),
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
    } else {
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, debe seleccionar los cobros en orden sin saltarse ninguno'});
    }
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
    if (! estanSalteados()) {
    $('#btnGuardar').attr("disabled", true);
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    var parametros = {
                KEY: 'KEY_GUARDAR_COBRO',  
                _lista_id_detalle_presupuesto: listaIDDetalle,
                _id_presupuesto: $("#_id_presupuesto_cobro").val().toString(),
                _formapago: 1,
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
        } else {
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, debe seleccionar los cobros en orden sin saltarse ninguno'});
        }
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
                _id_inscripcion_miembro: $("#_id_inscripcion_miembro").val().toString(),
                _fecha_cobro: $("#_fecha_cobro").val().toString()
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

        