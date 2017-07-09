<script src="public/framework/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
$('.textarea').wysihtml5();

$.extend( $.fn.dataTableExt.oSort, {
    //pre-processing
    "numchar-pre": function(str){
        var patt = /^([0-9]+)([a-zA-Z]+)$/;    //match data like 1a, 2b, 1ab, 100k etc.
        var matches = patt.exec($.trim(str));
        var number = parseInt(matches[1]);     //extract the number part
        var str = matches[2].toLowerCase();    //extract the "character" part and make it case-insensitive
        var dec = 0;
        for (i=0; i<str.length; i++)
        {
        dec += (str.charCodeAt(i)-96)*Math.pow(26, -(i+1));  //deal with the character as a base-26 number
        }
        return number + dec;       //combine the two parts
    },

    //sort ascending
    "numchar-asc": function(a, b){
        return a-b;
    },

    //sort descending
    "numchar-desc": function(a, b){
        return b-a;
    }
});


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
 
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "natural-asc": function ( a, b ) {
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
} );
 
}());

var getConfTabla2= function (){
    $(function () {
        $('#tipo_personalizada').DataTable({
            "aLengthMenu": [[ 15, 50,75,100, -1], [ 15, 50,75,100, "All"]],
            "iDisplayLength": 15, 
            "iDisplayStart": 0,
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
                "aoColumns": [{"sType": "natural"}, null, null, null, null]
            }
        });          
    });                                            
};

</script>