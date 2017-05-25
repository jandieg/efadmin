<script> 
////////////////////////////////////////////////////////////////////////////////
//Pago Forum Grupo
var getPagoForumGrupo = function( id_tipo_pago,  fi, ff, forum, _id_porcentaje, _porcentaje){
        var parametros = {
                KEY: 'KEY_DETALLE_PAGO_FORUM_GRUPO',
                id_tipo_pago: id_tipo_pago,
                fi: fi,
                ff: ff,
                forum:forum,
                _id_porcentaje:_id_porcentaje,
                _porcentaje:_porcentaje
        };
        $.ajax({
            data:  parametros,
            url:   'pagos',
            type:  'post',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                $.msg('unblock');
                $("#respuesta_forum_grupo").html(mensaje);
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema ' + status.toString()+" "+ xhr.toString()});
            }
       });
};
var setPagarForumGrupo = function(){
    if( $("#_validar_pago_fg").val() == "SI"){
        if( $("#_porcentaje_pagar_fg").val() != "x"){
            $('#btnGuardarForumGrupo').attr("disabled", true);
            //$.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            var _lista_grupos = [];
            var cont= $("#selectall").attr("name");
            for (var i=0; i < cont; i++) {
                if($("#" + (i + 1)).prop('checked') ) {
                    _lista_grupos.push($("#" + (i + 1)).attr("name"));
                    //alert($("#" + (i + 1)).attr("name"));            
                }     
            }
            var _porcentaje = $("#_porcentaje_pagar_fg option:selected").text();
            _porcentaje= _porcentaje.replace(' %','');
            var parametros = {
                        KEY: 'KEY_GUARDAR_PAGO_FORUM_GRUPO',  
                        _fg_id_tipo_pago: $("#_fg_id_tipo_pago").val().toString(),
                        _fg_id_forum: $("#_fg_id_forum").val().toString(),
                        _fg_ff: $("#_fg_ff").val().toString(),
                        _fg_fi: $("#_fg_fi").val().toString(),
                        _porcentaje: _porcentaje,
                        _id_porcentaje: $("#_porcentaje_pagar_fg").val().toString(),
                        _nota: $("#_fg_nota").val().toString(),
                        _lista_grupos:_lista_grupos
                };

                $.ajax({
                    data:  parametros,
                    url:   'pagos',
                    type:  'post',
                    dataType : 'json',
                    success:  function (mensaje) { 
                        if(mensaje.success == "true"){
                            $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                            $('#modal_PagarForumGrupos').modal('toggle'); 
                            //$.msg('unblock');
                            $('#btnGuardarForumGrupo').attr("disabled", false);
                            //getRecargar(); 
                        }else{
                            //$.msg('unblock');
                            $('#btnGuardarForumGrupo').attr("disabled", false);
                            $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        }                 
                    },error : function(xhr, status) {
                       //$.msg('unblock');
                       $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                    }
                });
            }else{
                $.toaster({ priority : 'warning', title : 'Alerta', message : 'Debes seleccionar un porcentaje de pago!'});
            }
    }
};

var getPorcentajeForumGrupo = function( _tope){
   if( $("#_porcentaje_pagar_fg").val() != "x"){
        
        var _porcentaje = $("#_porcentaje_pagar_fg option:selected").text();
        _porcentaje= _porcentaje.replace(' %','');
        
        var cont= _tope;
        for (var i=0; i < cont; i++) { 
            var _valor= $("#_valor_recaudado_"+ (i + 1)).html();
            _valor= _valor.replace('$ ','');
            var new_valor= ( parseFloat(_valor) *  parseFloat(_porcentaje))/ 100;
            $("#_valor_pagar_"+ (i + 1)).html("$ " + new_valor.toFixed(2));
        }
    
   }else{
        //$("#_valor").val($("#_valor_sinrebate").val().toString());
   }
      
};

var getSeleccionarTodos = function(){
    var checkAll = $("#selectall").prop('checked');
    if (checkAll) {
        $(".case").prop("checked", true);
    } else {
        $(".case").prop("checked", false);
    }
};

var getSeleccionarCobro = function(){
    if($(".case").length == $(".case:checked").length) {
        $("#selectall").prop("checked", true);
    } else {
        $("#selectall").prop("checked", false);
    }
};




////////////////////////////////////////////////////////////////////////////////
//Pagar Franquicia
var getAplicarRebate = function(){
   if( $("#_descuento").val() != "x"){
        var _descuento = $("#_descuento option:selected").text();
        _descuento= _descuento.replace(' %','');
        var _valor= $("#_valor_sinrebate").val().toString();
        _valor= _valor.replace('$ ','');
        var new_valor= parseFloat(_valor) - (( parseFloat(_valor) *  parseFloat(_descuento))/ 100);
        $("#_valor_franquicia").val("$ " + new_valor.toFixed(2));
   }else{
        $("#_valor_franquicia").val($("#_valor_sinrebate").val().toString());

   }
      
};

var getAplicarPorcentaje = function(_tipo){
    if($("#_porcentaje_pagar").val() != "x"){
        if(_tipo == '1'){
            var _porcentaje = $("#_porcentaje_pagar option:selected").text();
            _porcentaje= _porcentaje.replace(' %','');
            var _valor= $("#_base_total").val().toString();
            _valor= _valor.replace('$ ','');
            var new_valor= ( parseFloat(_valor) *  parseFloat(_porcentaje))/ 100;
            $("#_valor_sinrebate").val("$ " + new_valor.toFixed(2));
            getAplicarRebate();
        }else{
            getAplicarRebate();
        }
    }else{
        $("#_valor_sinrebate").val($("#_base_total").val().toString());
        getAplicarRebate();
    }
      
};



var setPagarFranquicia = function(_id_tipo, fi,ff){
    //$.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    $('#btnGuardarPF').attr("disabled", true);
    var _valor= $("#_valor_franquicia").val().toString();
    _valor= _valor.replace('$ ','');
    
    var _base_total= $("#_base_total").val().toString();
    _base_total= _base_total.replace('$ ','');
    
    var parametros = {
                KEY: 'KEY_GUARDAR_PAGO_FRANQUICIA',  
                _descuento: $("#_descuento").val().toString(),
                _base_total: _base_total,
                _fg_ff: ff,
                _fg_fi: fi,
                _valor: _valor,
                _nota: $("#_nota_franquicia").val().toString(),
                _id_tipo:_id_tipo,
                _porcentaje_pagar:$("#_porcentaje_pagar").val().toString()
        };

        $.ajax({
            data:  parametros,
            url:   'pagos',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) { 
                if(mensaje.success == "true"){
                    //$.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    //$.msg('unblock');
                    
                    getRecargar(); 
                    $('#btnGuardarPF').attr("disabled", false);
                }else{
                    //$.msg('unblock');
                    $('#btnGuardarPF').attr("disabled", false);
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }

    
                  
            },error : function(xhr, status) {
               //$.msg('unblock');
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};



////////////////////////////////////////////////////////////////////////////////
//Pagar Forum Miembros o otros 
//var getSeleccionarTodosMiembros = function(){
//    var checkAll = $("#selectallmiembros").prop('checked');
//    if (checkAll) {
//        $(".casemiembros").prop("checked", true);
//        var cont= $("#selectallmiembros").attr("name");
//        for (var i=0; i < cont; i++) {
//            if($("#_id" + (i + 1)).prop('checked') ) {
//                var _id_miembro_= $("#_id" + (i + 1)).val();
//                $('#_miembros_grupos').append('<option value="' + _id_miembro_+ '" selected>' + $("#_id" + (i + 1)).attr("name") + '</option>');   
//            }     
//        }  
//    } else {
//        $(".casemiembros").prop("checked", false);
//        $('#_miembros_grupos option[value!="0"]').remove();
//    }
//};
//
//var getSeleccionarMiembros = function(_id , _miembro){
//    if($(".casemiembros").length == $(".casemiembros:checked").length) {
//        $("#selectallmiembros").prop("checked", true);
//    } else {
//        $("#selectallmiembros").prop("checked", false);
//    }     
//    var bandera = false;    
//    $('#_miembros_grupos :selected').each(function(i, selected){//en caso de que se repita en la lista ya no se ingresa        
//      if( _id == $(selected).val()){  
//          bandera = true;
//          $("#_miembros_grupos option[value='" + $(selected).val() + "']").remove(); //para cuando lo deschekee
//      }
//    });   
//    if(bandera == false){
//        $('#_miembros_grupos').append('<option value="' + _id + '" selected>' + _miembro + '</option>');     
//    }  
//};

//var getBusquedaEvento_ = function(identificador, forum){
//        $.post("pagos", {
//            KEY: 'KEY_SHOW_MODAL_FILTRO',
//              identificador: identificador,
//              forum:forum
//        }, function(mensaje) {
//            $("#respuesta_modal_miembros").html(mensaje);
//            //getConfTabla();
//        });
//    
//};
var setPagarForumMO = function(_id_tipo, forum,identificador){
    //$.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    //alert($("#_valor").val().toString());
    $('#btnGuardarF').attr("disabled", true);
    var _lista_miembros = []; 
    if(identificador == "1"){
        $('#_miembros_grupos :selected').each(function(i, selected){ 
          _lista_miembros[i] = $(selected).val();
        });
    }
    
    var parametros = {
                KEY: 'KEY_GUARDAR_PAGO_FORUM_MO',  
                _valor: $("#_valor_mo").val().toString(),
                _forum: forum,
                _identificador: identificador,
                _lista_miembros: _lista_miembros,
                _nota: $("#_nota_mo").val().toString(),
                _id_tipo:_id_tipo
        };

        $.ajax({
            data:  parametros,
            url:   'pagos',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) { 
                if(mensaje.success == "true"){
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    //$.msg('unblock');
                     $('#modal_PagarForum').modal('toggle'); 
                    //getRecargar(); 
                    $('#btnGuardarF').attr("disabled", false);
                }else{
                    //$.msg('unblock');
                    $('#btnGuardarF').attr("disabled", false);
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }

    
                  
            },error : function(xhr, status) {
               //$.msg('unblock');
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};
var getPagoForum = function( id_tipo_pago, forum,identificador,  nombre){
        var parametros = {
                KEY: 'KEY_DETALLE_PAGO_FORUM',
                id_tipo_pago: id_tipo_pago,
                forum:forum,
                identificador:identificador,
                nombre:nombre
        };
        $.ajax({
            data:  parametros,
            url:   'pagos',
            type:  'post',
            beforeSend: function () {
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            },
            success:  function (mensaje) {
                $.msg('unblock');
                $("#respuesta_forum").html(mensaje);
                $(".select2").select2();
                //getBusquedaEvento_(identificador, forum);
                
                
              
                
                
                
                
                
                
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema ' + status.toString()+" "+ xhr.toString()});
            }
       });
};
////////////////////////////////////////////////////////////////////////////////
//pago varios
var setPagarVarios = function(_id_tipo){
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    $('#btnGuardarPFVarios').attr("disabled", true);

    var parametros = {
                KEY: 'KEY_GUARDAR_PAGO_VARIOS',  
                _valor: $("#_valor_varios").val().toString(),
                _nota: $("#_nota_varios").val().toString(),
                _id_tipo:_id_tipo
        };

        $.ajax({
            data:  parametros,
            url:   'pagos',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) { 
                if(mensaje.success == "true"){
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    $.msg('unblock');
                    $("#_valor_varios").val('');
                    $("#_nota_varios").val('');
                    $('#btnGuardarPFVarios').attr("disabled", false);
                }else{
                    $.msg('unblock');
                    $('#btnGuardarPFVarios').attr("disabled", false);
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                }
      
            },error : function(xhr, status) {
               //$.msg('unblock');
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
};
/////////////////////////////////////////////////////////////////////////////////
var getTope = function( _tope){
  $("#_tope_calculo_porcentaje").val(_tope);   
};

var setAgregarPorcentaje = function(_tipo){
    $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
    if(_tipo == "1"){
        var porc=  $("#_porcentaje_crear").val().toString();
    }else{
        var porc=  $("#_rebate_crear").val().toString();
    }
    var parametros = {
                KEY: 'KEY_GUARDAR_PORCENTAJE',
                _porcentaje: porc,
                _tipo:_tipo
        };
        $.ajax({
            data:  parametros,
            url:   'pagos',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) { 
                $.msg('unblock');
                if(mensaje.success == "true"){
                    if(_tipo == "1"){
                        $('#modal_getCrearPorcentaje').modal('toggle');
                        
                        if($("#_tope_calculo_porcentaje").val() == ""){ 
                            $("#_porcentaje_pagar").html(mensaje.lista_porcentajes);
                            getAplicarPorcentaje(1);
                        }else{
                            $("#_porcentaje_pagar_fg").html(mensaje.lista_porcentajes);
                            getPorcentajeForumGrupo($("#_tope_calculo_porcentaje").val());
                        }
                        
                    }else{
                        $('#modal_getCrearRebate').modal('toggle');
                        $("#_descuento").html(mensaje.lista_porcentajes);
                        getAplicarPorcentaje(2);
                    }
                    $("#_porcentaje_crear").val("");
                    $("#_rebate_crear").val("");
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
    location.reload();
};
</script>

        