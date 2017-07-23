<script>
$(document).ready(function() {
    if (sessionStorage._recargado_empresas2) {
        if (sessionStorage._forum) {
            $('#_forum').val(sessionStorage._forum);
        }

        if (sessionStorage._industria) {
            $('#_industria').val(sessionStorage._industria);
        }
    
        if (sessionStorage.llave) {
            var parametros = {
                KEY: sessionStorage.llave,
                _key_filtro: sessionStorage._key_filtro,
                _filtro: sessionStorage._filtro,
                _mostrar_todas: sessionStorage._mostrar_todas
            };
            sessionStorage._recargado_empresas2 = false;
            $(".select2").select2();
            getFiltroWithParams(parametros);
        }
    }
    
    
    
});
</script>