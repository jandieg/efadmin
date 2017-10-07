<script src="public/framework/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
    $('.textarea').wysihtml5();
    
(function() {
 
/*
 * Natural Sort algorithm for Javascript - Version 0.7 - Released under MIT license
 * Author: Jim Palmer (based on chunking idea from Dave Koelle)
 * Contributors: Mike Grier (mgrier.com), Clint Priest, Kyle Adams, guillermo
 * See: http://js-naturalsort.googlecode.com/svn/trunk/naturalSort.js
 */
function naturalSort (a, b, html) {
    var re = /(^-?[0-9]+(\.?[0-9]*)[df]?e?[0-9]?%?$|^0x[0-9a-f]+$|[0-9]+)/gi,
        sre = /(^[ ]*|[ ]*$)/g,
        dre = /(^([\w ]+,?[\w ]+)?[\w ]+,?[\w ]+\d+:\d+(:\d+)?[\w ]?|^\d{1,4}[\/\-]\d{1,4}[\/\-]\d{1,4}|^\w+, \w+ \d+, \d{4})/,
        hre = /^0x[0-9a-f]+$/i,
        ore = /^0/,
        htmre = /(<([^>]+)>)/ig,
        // convert all to strings and trim()
        x = a.toString().replace(sre, '') || '',
        y = b.toString().replace(sre, '') || '';
        // remove html from strings if desired
        if (!html) {
            x = x.replace(htmre, '');
            y = y.replace(htmre, '');
        }
        // chunk/tokenize
    var xN = x.replace(re, '\0$1\0').replace(/\0$/,'').replace(/^\0/,'').split('\0'),
        yN = y.replace(re, '\0$1\0').replace(/\0$/,'').replace(/^\0/,'').split('\0'),
        // numeric, hex or date detection
        xD = parseInt(x.match(hre), 10) || (xN.length !== 1 && x.match(dre) && Date.parse(x)),
        yD = parseInt(y.match(hre), 10) || xD && y.match(dre) && Date.parse(y) || null;
 
    // first try and sort Hex codes or Dates
    if (yD) {
        if ( xD < yD ) {
            return -1;
        }
        else if ( xD > yD ) {
            return 1;
        }
    }
 
    // natural sorting through split numeric strings and default strings
    for(var cLoc=0, numS=Math.max(xN.length, yN.length); cLoc < numS; cLoc++) {
        // find floats not starting with '0', string or 0 if not defined (Clint Priest)
        var oFxNcL = !(xN[cLoc] || '').match(ore) && parseFloat(xN[cLoc], 10) || xN[cLoc] || 0;
        var oFyNcL = !(yN[cLoc] || '').match(ore) && parseFloat(yN[cLoc], 10) || yN[cLoc] || 0;
        // handle numeric vs string comparison - number < string - (Kyle Adams)
        if (isNaN(oFxNcL) !== isNaN(oFyNcL)) {
            return (isNaN(oFxNcL)) ? 1 : -1;
        }
        // rely on string comparison if different types - i.e. '02' < 2 != '02' < '2'
        else if (typeof oFxNcL !== typeof oFyNcL) {
            oFxNcL += '';
            oFyNcL += '';
        }
        if (oFxNcL < oFyNcL) {
            return -1;
        }
        if (oFxNcL > oFyNcL) {
            return 1;
        }
    }
    return 0;
}
if ($.fn.dataTableExt != undefined) {
    $.extend( $.fn.dataTableExt.oSort, {
        
        "natural-asc": function ( a, b ) {
            console.log('entra en natural');
            return naturalSort(a,b,true);
        },
    
        "natural-desc": function ( a, b ) {
            return naturalSort(a,b,true) * -1;
        },
    
        "natural-nohtml-asc": function( a, b ) {
            return naturalSort(a,b,false);
        },
    
        "natural-nohtml-desc": function( a, b ) {
            return naturalSort(a,b,false) * -1;
        },
    
        "natural-ci-asc": function( a, b ) {
            a = a.toString().toLowerCase();
            b = b.toString().toLowerCase();
    
            return naturalSort(a,b,true);
        },
    
        "natural-ci-desc": function( a, b ) {
            a = a.toString().toLowerCase();
            b = b.toString().toLowerCase();
    
            return naturalSort(a,b,true) * -1;
        }
    });
}

 
}());

    var getConfTabla2= function (){
    console.log('entra en este');
    
    $(function () {
        var table = $('#tipo_personalizada2').DataTable();
        table.destroy();
        $('#tipo_personalizada2').DataTable({            
            "aLengthMenu": [[ 15, 50,75,100, -1], [ 15, 50,75,100, "All"]],
            "iDisplayLength": 15, 
            "iDisplayStart": 0,
            "aoColumns": [null, {"sType": "natural"}],
            "language": {
                "sProcessing":    "Procesando...",
                "sLengthMenu":    "Mostrar _MENU_ registros",
                "sZeroRecords":   "No se encontraron resultados",
                "sEmptyTable":    "Ningún dato disponible en esta tabla",
                "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":   "",
                "sSearch":        "Buscar:",
                "sUrl":           "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":    "Último",
                    "sNext":    "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                
            }
        });          
    });                                            
};


    $(document).ready(function() {

        if ($("#tipo_personalizada2") != undefined) {
            getConfTabla2();
        }
        

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