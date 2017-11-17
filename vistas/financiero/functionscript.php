<script>  
var cambioAnho = function () {
    var anho = $("#_anho").val();
    var parametros = {
        KEY: 'KEY_GET_CAMBIO2',
        _anho: anho
    };

    $.ajax({
            data:  parametros,
            url:   'financiero',
            type:  'post',
            success:  function (mensaje) { 
                
                $("#contenedor_cambio").html(mensaje);
                                 
            },error : function(xhr, status) {                
               console.log(xhr);
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'+status.toString()});
            }
        });

}
var getTipoCambio = function() {
    console.log('entra al tipo de cambio');
    var parametros = {
        KEY: 'KEY_GET_CAMBIO'        
    };

    $.ajax({
            data:  parametros,
            url:   'financiero',
            type:  'post',
            success:  function (mensaje) { 
                
                $("#contenedor_cambio").html(mensaje);
                                 
            },error : function(xhr, status) {                
               console.log(xhr);
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'+status.toString()});
            }
        });


    $("#modal_getTipoCambio").modal('toggle');
};

var setGuardarCambio = function() {
    var parametros={
        KEY: 'KEY_GUARDAR_CAMBIO',
        _anho: $("#_anho").val(),
        _mes_1: $("#mes_1").val(),
        _mes_2: $("#mes_2").val(),
        _mes_3: $("#mes_3").val(),
        _mes_4: $("#mes_4").val(),
        _mes_5: $("#mes_5").val(),
        _mes_6: $("#mes_6").val(),
        _mes_7: $("#mes_7").val(),
        _mes_8: $("#mes_8").val(),
        _mes_9: $("#mes_9").val(),
        _mes_10: $("#mes_10").val(),
        _mes_11: $("#mes_11").val(),
        _mes_12: $("#mes_12").val(),
        _moneda_1: $("#moneda_1").val(),
        _moneda_2: $("#moneda_2").val(),
        _moneda_3: $("#moneda_3").val(),
        _moneda_4: $("#moneda_4").val(),
        _moneda_5: $("#moneda_5").val(),
        _moneda_6: $("#moneda_6").val(),
        _moneda_7: $("#moneda_7").val(),
        _moneda_8: $("#moneda_8").val(),
        _moneda_9: $("#moneda_9").val(),
        _moneda_10: $("#moneda_10").val(),
        _moneda_11: $("#moneda_11").val(),
        _moneda_12: $("#moneda_12").val(),
        _sede: $("#_la_sede").val(),        
    };

        $.ajax({
            data:  parametros,
            url:   'financiero',
            type:  'post',
            success:  function (mensaje) { 
                
               $.toaster({ priority : 'success', title : 'Alerta', message : 'Se guardo el cambio exitosamente'});
                                 
            },error : function(xhr, status) {                
               console.log(xhr);
               $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'+status.toString()});
            }
        });



  $("#modal_getTipoCambio").modal('toggle');
};
</script>

        