<script>  

var setCrearPAME = function(_tipo){
    
    
    $("#btnCrearPAME").html('Agregando Empresa ...');
    $('#btnCrearPAME').attr("disabled", true);
        $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
        
        var _arrayIndustria = []; 
        $('#_industria_modal_empresa :selected').each(function(i, selected){ 
          _arrayIndustria[i] = $(selected).val();
        });
        var parametros = {
                KEY: 'KEY_GUARDAR',
                key_operacion: 'g',        
                _empresa: $("#_empresa_modal_empresa").val().toString(),
                _ruc: $("#_ruc_modal_empresa").val().toString(),
                _ingresos: '',
                _numero_empleados: '',
                _industria:_arrayIndustria,
                _fax: '',
                _sitio_web: '',
                _correo1: $("#_correo1_modal_empresa").val().toString(),
                _movil: $("#_movil_modal_empresa").val().toString(),
                _ciudad: '',
                _calle: $("#_calle_modal_empresa").val().toString(),
                _bandera:'2',
                _tipo: _tipo
               
        };
       
        $.ajax({
            data:  parametros,
            url:   'empresas',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) {
                $.msg('unblock');
                if(mensaje.success == "true"){
                    if(_tipo == '2'){
                        $('#modalPAMAgregarEmpresa').modal('toggle');
                        getDetalle(mensaje._ultimo_id_miembro_prospecto);
                        
                    }else{
                      
                      $("#_id_empresa").html(mensaje.lista_empresas);
                      $(".select2").select2();
                      $('#modalPAMAgregarEmpresa').modal('toggle');
                  } 
                }else{
                    
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    $("#btnCrearPAME").html('Guardar');
                    $('#btnCrearPAME').attr("disabled", false);
                }
            },error : function(xhr, status) {
                $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });

};

var getPAMEmpresaModal = function(_tipo){

     $.post("empresas", {
            KEY: 'KEY_SHOW_FORM_GUARDAR_MODAL',
            _tipo: _tipo
        }, function(mensaje) {
            $("#respuesta_modal_pame").html(mensaje);
             $('#modalPAMAgregarEmpresa').modal('toggle');
            $(".select2").select2();
         });
};

</script>

        