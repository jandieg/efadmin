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
        var table = $('#tipo_personalizada').DataTable();
        table.destroy();
        $('#tipo_personalizada').DataTable({            
            "aLengthMenu": [[ 15, 50,75,100, -1], [ 15, 50,75,100, "All"]],
            "iDisplayLength": 15, 
            "iDisplayStart": 0,
            "aoColumns": [{"sType": "natural"}, null, null, null, null],
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
    if ($("#tipo_personalizada") != undefined) {
        getConfTabla2();
    }
    if (sessionStorage._recargado) {
        if (sessionStorage._memb_type) {
         $('#_memb_type').val(sessionStorage._memb_type);
        }
        
        if (sessionStorage._status_memb) {
            $('#_status_memb').val(sessionStorage._status_memb);
        }

        if (sessionStorage._industria) {
            $('#_industria').val(sessionStorage._industria);
        }
        
        if (sessionStorage._grupo) {
            $('#_grupo').val(sessionStorage._grupo);
        }

        if (sessionStorage._forum) {
            $('#_forum').val(sessionStorage._forum);
        }
        
        if (sessionStorage._empresa) {
            $('#_empresa').val(sessionStorage._empresa);
        }

        if (sessionStorage.llave) {
            var parametros = {
                KEY: sessionStorage.llave,
                _key_filtro: sessionStorage._key_filtro,
                _filtro: sessionStorage._filtro,
                _canceladas: sessionStorage._canceladas
            };
            sessionStorage._recargado = false;
            getFiltroWithParams(parametros);
        }
    }
    
    
    
});

var datosimg;

$('#cropper-confirm').on('click', function () {
    // Crop
    var h = parseInt($('#dataHeight').val());
    var w = parseInt($('#dataWidth').val());
    var cropper = $('#cropper-image').cropper('getCroppedCanvas');

    var croppedCanvas;
    thumbWidth = 400;
    
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext("2d");
        newWidth = thumbWidth;        
        newHeight = Math.floor(h/w*newWidth);
        canvas.width = newWidth;
        canvas.height = newHeight;

        ctx.drawImage(cropper, 0, 0, newWidth, newHeight);
        datosimg = canvas.toDataURL("image/jpeg");
        $('#cropper-image').cropper('clear');
        $('#cropper-image').cropper('destroy');
        $('#cropper-image').cropper('reset');
        $('#cropper-image').removeAttr('src');
    
       /* $('.upload-image-lost-preview .preview-img').css('background-image', 'url(' + datosimg + ')');
        $('.upload-image-lost-preview').show();
        $('#lost_pet_file').parent().hide();*/
        $('#modal-cropper .modal-header button').trigger('click');
        
    /*} else {
        $('.upload-image-lost-preview .preview-img').css('background-image', 'url(' + cropper.toDataURL() + ')');
        $('.upload-image-lost-preview').show();
        $('#lost_pet_file').parent().hide();
        $('#modal-cropper .modal-header button').trigger('click');
    }*/
    
});

$('#modal-cropper').on('shown.bs.modal', function () {
    var $dataX = $('#dataX');
    var $dataY = $('#dataY');
    var $dataHeight = $('#dataHeight');
    var $dataWidth = $('#dataWidth');
    $('#cropper-image').cropper({
        crop: function (e) {
            $dataX.val(Math.round(e.x));
            $dataY.val(Math.round(e.y));
            $dataHeight.val(Math.round(e.height));
            $dataWidth.val(Math.round(e.width));
        },
        done: function (data) {
            $('#cropper-image').cropper('destroy');
            // Output the result data for cropping image.
        }
    });
    
}).on('hidden.bs.modal', function () {
    // cropBoxData = $image.cropper('getCropBoxData');
    // canvasData = $image.cropper('getCanvasData');
    $('#cropper-image').cropper('unbuild');
});

function cropper_Modal() {
    console.log('entra en el cropper modal');
    $("#modal-cropper").modal().show();
}

var upload_flag = 0;
var previewImage = function (input) {
    console.log('esta entrando');
    if (input.files && input.files[0]) {
        console.log('entra en files');
        var reader = new FileReader();
        reader.onload = function (e) {     
            console.log('entra en el reader');
            $('#cropper-image').attr('src', e.target.result);     
            cropper_Modal();     
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$('.upload-image-lost-preview .fileopen-img').click(function () {
    $('.upload-image-lost-preview .lost-upload').trigger('click');
});
var procesarCrop = function() {
    console.log("se hizo click");
    console.log(this);
    upload_flag = 1;
    previewImage(document.getElementById('lost_pet_file'));
}

/*$(".lost-upload").click(function () {
    console.log("se hizo click");
    upload_flag = 1;
    previewImage(this);
});*/

</script>