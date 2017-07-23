<script src="public/framework/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
    $('.textarea').wysihtml5();

  $(document).ready(function() {
        

        if (sessionStorage._recargado_aplicantes) {   
            console.log('es verdadero');
            if (sessionStorage._estado) {
                $('#_estado').val(sessionStorage._estado);
            }
    
            if (sessionStorage._forum) {
                $('#_forum').val(sessionStorage._forum);
            }                        

            if (sessionStorage.llave) {   
                var parametros = {
                    KEY: sessionStorage.llave,
                    _key_filtro: sessionStorage._key_filtro,
                    _filtro: sessionStorage._filtro
                };             
                sessionStorage._recargado_aplicantes = false;
                $(".select2").select2();
                getFiltroWithParams(parametros);                                
            }
        }
    });

</script>