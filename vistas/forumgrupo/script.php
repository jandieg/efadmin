<script src="public/framework/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
    $('.textarea').wysihtml5();

    $(document).ready(function() {
        

        if (sessionStorage._recargado_empresas) {   
            console.log('es verdadero');
            if (sessionStorage._industria) {
                $('#_industria').val(sessionStorage._industria);
            }
    
            if (sessionStorage._forum_leader) {
                $('#_forum_leader').val(sessionStorage._forum_leader);
            }
            
            if (sessionStorage._empresa) {
                $('#_empresa').val(sessionStorage._empresa);
            }

            if (sessionStorage.llave) {                
                sessionStorage._recargado_empresas = false;
                $(".select2").select2();
                if (sessionStorage.llave == 'KEY_FILTRO_EMPRESA') {
                    console.log('la empresa');
                    getFiltroEmpresa();
                } else if (sessionStorage.llave == 'KEY_FILTRO_FORUM_LEADER') {
                    console.log('el forum leader');
                    getFiltroForumLeader();
                } else {
                    console.log('la industria');
                    getFiltroIndustria();
                }
            }
        }
    });
</script>