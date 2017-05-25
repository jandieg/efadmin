<script>
    //http://www.jqueryscript.net/demo/jQuery-Bootstrap-Based-Toast-Notification-Plugin-toaster/?
var getActualizar = function(){
     $.post("principal", {
            KEY: 'KEY_SHOW_FORM_ACTUALIZAR'
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
         });
};

var getRecargar = function(){
    location.reload();
    
};

var setActualizar  = function(){ 
    
       var parametros = {
                KEY: 'KEY_ACTUALIZAR', 
                id: $("#c_id").val().toString(),
                nombre: $("#c_empresa").val().toString(),
                empleados: $("#c_reencuentro").val().toString(),
                tel: $("#c_telefono").val().toString(),
                movil: $("#c_movil").val().toString(),
                fax: $("#c_fax").val().toString(),
                sweb: $("#c_sitioweb").val().toString(),
                admin: $("#c_admin").val().toString(),
                descripcion: $("#c_descrpcion").val().toString(),
                codigop: $("#c_codigopostal").val().toString(),
                pais: $("#c_pais").val().toString(),
                ciudad: $("#c_ciudad").val().toString(),
                calle: $("#c_calle").val().toString()
        };
        $.ajax({
            data:  parametros,
            url:   'principal',
            type:  'post',
            dataType : 'json',
            beforeSend: function () {
                //$.blockUI({ message: '<h3>Esperé un momento...</h3>'}); 
                $.msg({content : '<img src="public/images/loanding.gif" />', autoUnblock: false});
            }, success:  function (mensaje) {  
                //$.unblockUI();
                 $.msg('unblock');
                
                if(mensaje.success == "true"){
                    $.toaster({ priority : 'success', title : 'Alerta', message : mensaje.msj});
                    getRecargar();
                 }else if(mensaje.success == "false"){
                    $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                 }         
                    
            },error : function(xhr, status) {
                //$.unblockUI();
                 $.msg('unblock');
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
                //alert('Disculpe, existió un problema');
            }
        }); 
  
};
var getProgress = function(){
    var p  = '<div class="progress active">';
        p += '<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">'
        p += '<span class="sr-only">50% Complete (success)</span>' ;
        p += '</div>';
        p += '</div>';
    return p.toString();
};
</script>

<!--<script>
function setContenedor(o) {
    var opcion= o.toString();
    switch(opcion){
        case 'cnt_empresa':
            getAjax('cnt', 'cnt_empresa')
            break;
        case 'cnt_usuario':
            getAjax('cnt', 'cnt_usuario')
            break; 
        case 'cnt_control_seguridad':
            getAjax('cnt', 'cnt_control_seguridad')
            break;
        case 'cnt_mant_perfil':
            getAjax('cnt', 'cnt_mant_perfil')
            break;
    }
};
function getAjax(key, opcion){
        $.post("principal", {
            KEY: key.toString(),
            opcion: opcion.toString()
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
         });
};

var setActualizar = function(id,opcion){
     $.post("principal", {
            KEY: 'upd',
            opcion: opcion.toString(),
            id: id.toString()
        }, function(mensaje) {
            $("#ben_contenedor").html(mensaje);
         });
};

//function getAjax2(key, opcion, id){
//        $.post("principal", {
//            KEY: key.toString(),
//            opcion: opcion.toString(),
//            id: id.toString()
//        }, function(mensaje) {
//            $("#ben_contenedor").html(mensaje);
//         });
//};






function setContenedor2(o) {
    var opcion= o.toString();
    switch(opcion){
        case 'crearEmpresa':
            $.post("principal", {
                KEY: 'page',
                opcion: 'crearEmpresa'
            }, function(mensaje) {
                $("#ben_contenedor").html(mensaje);
            }); 
            break;
        case 'cnt_usuario':
            $.post("principal", {
                KEY: 'page',
                opcion: 'cntUsuario'
            }, function(mensaje) {
                $("#ben_contenedor").html(mensaje);
            });
            break;
        case 'cnt_controlseguridad':
            $.post("principal", {
                KEY: 'page',
                opcion: 'cntControlSeguridad'
            }, function(mensaje) {
                $("#ben_contenedor").html(mensaje);
            });
            break;
        case 'cnt_empresa':
            $.post("principal", {
                KEY: 'page',
                opcion: 'cnt_empresa'
            }, function(mensaje) {
                $("#ben_contenedor").html(mensaje);
            });
            break;    
    }
    
};
function setActualizar(o) {
    var opcion= o.toString();
    var id= $("#c_id").val();
    var empresa= $("#c_empresa").val();
    var alias= $("#c_alias").val();
    var reencuentro= $("#c_reencuentro").val();
    var telefono= $("#c_telefono").val();
    var movil= $("#c_movil").val();
    var fax= $("#c_fax").val();
    var sitioweb= $("#c_sitioweb").val();
    var descrpcion= $("#c_descrpcion").val();
    var calle= $("#c_calle").val();
    var ciudad= $("#c_ciudad").val();
    switch(opcion){
        case 'upd_empresa':
            $.post("principal", {
                KEY: 'page',
                t_i_codigo: codigo,
                t_i_descripcion: descripcion,
                t_i_tipo: tipo,
                t_i_orden: orden
            }, function(mensaje) {
                $("#ben_respuesta").html(mensaje);
            }); 
            break;
         
    }
    
};

function cargalistaInfoTramite(nodo) {
    var codigo = setExtraerContenidoTablaFila(nodo, 0); 
    var descripcion = setExtraerContenidoTablaFila(nodo, 1); 
    $.post("principal", {
        KEY: 'LI',
        t_codigo: codigo
    }, function(mensaje) {
        $("#cuerpoTramite").html(mensaje);
     }); 
     
};
function setTramiteInformaciónTabla(nodo){  
    var codigo = setExtraerContenidoTablaFila(nodo, 0); 
    $("#cod_t_traminfo").val(codigo.toString());
};

function setTramiteInformacion() {
     var codigo= $("#cod_t_traminfo").val();
     var descripcion= $("#desc_i_registrar").val();
     var tipo= $("#combo_i_Tipo").val();
//     var orden= $("#combo_i_Orden").val();
     var orden= "";
        switch(tipo){
        case "D":
             orden="1";
            break;
        case "P":
             orden="3";
            break;
        case "R":
             orden="2";
            break;
       case "S":
            orden="4";
            break;
            
    }

     
     if (descripcion != "" && tipo!="X" && orden!="0") {
        $.post("principal", {
            KEY: 'CTI',
            t_i_codigo: codigo,
            t_i_descripcion: descripcion,
            t_i_tipo: tipo,
            t_i_orden: orden
        }, function(mensaje) {
            $("#respuesta_info").html(mensaje);
            //location.reload();
         }); 
     } else { 
        //$("#respuesta").html('<p>JQUERY VACIO</p>');
        alert("Debes llenar los campos!");
     };
};
    
    
function setEliminarTramiteTabla(nodo){  
    var codigo = setExtraerContenidoTablaFila(nodo, 0); 
    var descripcion = setExtraerContenidoTablaFila(nodo, 1); 
    $("#cod_t_eliminar").val(codigo.toString());
    var msg= '<p>Esta seguro que desea eliminar el tramite:<b>' +codigo+ ' - ' +descripcion+ ' </b></p> \n\
<p><b>Importante!</b> Se eliminaran toda la información asociada a este tramite </p><br>';
    $("#msg").html(msg.toString());


};



function setEditarTramiteTabla(nodo){  
    var codigo = setExtraerContenidoTablaFila(nodo, 0); 
    var descripcion = setExtraerContenidoTablaFila(nodo, 1); 
    var ruta = setExtraerContenidoTablaFila(nodo, 2); 
    $("#cod_t_editar").val(codigo.toString());
    $("#des_t_editar").val(descripcion.toString());
    //$("#desc_t_ruta_editar").val(ruta.toString());
    
};

function setEditarFotoTabla(nodo){  
    var codigo = setExtraerContenidoTablaFila(nodo, 0); 
   
    $("#cod_t_foto2").val(codigo.toString());

    
};
function setVerFotoTabla(nodo){  
    var codigo = setExtraerContenidoTablaFila(nodo, 0); 
   
    //$(".showImage").html("<img src='foto_tramite/Prueb.png' />");
    $(".showImage").html("<center><img src='foto_tramite/"+codigo+".png' /></center>");

    
};

function setExtraerContenidoTablaFila(nodo, indice){  
    var nodoTd = nodo.parentNode; //Nodo TD
    var nodoTr = nodoTd.parentNode; //Nodo TR
    var nodosEnTr = nodoTr.getElementsByTagName('td');
    var valor = nodosEnTr[indice].textContent; 
    return valor;
};


function setCrearTramite2() {
     var descripcion= $("#desc_t_registrar").val();  
     if (descripcion != "") {
        $.post("principal", {
            KEY: 'C',
            t_descripcion: descripcion
            
        }, function(mensaje) {
            $("#respuesta").html(mensaje);
            //location.reload();
         }); 
     } else { 
        //$("#respuesta").html('<p>JQUERY VACIO</p>');
        alert("Debes llenar el campo!");
     };
};
var READY_STATE_COMPLETE=4;
function setCrearTramite(){
	var tipoArchivo = document.getElementById('imagen').files[0].type;
        var descripcion= $("#desc_t_registrar").val();  
        if (descripcion != "") {         
            if(tipoArchivo == 'image/png'){
                    var url = 'principal';

                    var xhr = (window.XMLHttpRequest)? new XMLHttpRequest() : new ActiveObject("Microsoft.XMLHTTP");
                    var data = new FormData();
                    data.append('KEY', 'C');	
                    data.append('t_descripcion',descripcion);
                    data.append('archivo', document.getElementById('imagen').files[0]);

                    xhr.open('POST', url, true);
                    xhr.onreadystatechange = function(){
                            if (xhr.readyState==READY_STATE_COMPLETE && xhr.status==200){

                                    $("#respuesta").html(xhr.responseText);
                            } 	
                    }
                    xhr.send(data);
            }else{
                    alert('El formato del archivo no es el correcto, solo se acepta .png');
            }
         } else { 
        //$("#respuesta").html('<p>JQUERY VACIO</p>');
        alert("Debes llenar el campo!");
     }
}


function setEditarTramite(){  
     var cod= $("#cod_t_editar").val();
     var descripcion= $("#des_t_editar").val();
     if (descripcion != "" ) {
        $.post("principal", {
            KEY: 'E',
            t_codigo: cod,
            t_descripcion: descripcion,
        }, function(mensaje) {
            var conf = confirm("El tramite se actualizo correctamente!");
            if (conf == true){
                location.reload();
            }else{
                 location.reload();
            }
            //$("#respuesta").html(mensaje);
            
         }); 
     } else { 
        //$("#respuesta").html('<p>JQUERY VACIO</p>');
        alert("Debes llenar el campo!");
     };
};

function setEliminarTramite(){  
    var cod= $("#cod_t_eliminar").val();
    $.post("principal", {
        KEY: 'ELI',
        t_codigo: cod,
    }, function(mensaje) {
        var conf = confirm("El tramite se elimino correctamente!");
        if (conf == true){
            location.reload();
        }else{
             location.reload();
        }
        //$("#respuesta").html(mensaje);

     }); 

};


function getRecargar() {
     location.reload();
};








var READY_STATE_COMPLETE=4;
function setActualizarImagen(){
	var tipoArchivo = document.getElementById('imagen2').files[0].type;
	 if(tipoArchivo == 'image/png'){
                var url = 'principal';

		var xhr = (window.XMLHttpRequest)? new XMLHttpRequest() : new ActiveObject("Microsoft.XMLHTTP");
		var data = new FormData();
		data.append('KEY', 'AF');	
		data.append('t_codigo', $('#cod_t_foto2').val());
		data.append('archivo', document.getElementById('imagen2').files[0]);

		xhr.open('POST', url, true);
		xhr.onreadystatechange = function(){
			if (xhr.readyState==READY_STATE_COMPLETE && xhr.status==200){
				//alert(xhr.responseText);
				//cargaDatos() // Para que actualice la tabla de las operaciones
                                 var conf = confirm("El imagen se actualizo correctamente!");
                                    if (conf == true){
                                        location.reload();
                                    }else{
                                         location.reload();
                                    }
			} 	
		}
		xhr.send(data);
	}else{
		 alert('El formato del archivo no es el correcto, solo se acepta .png');
	}
}



</script>
 
 <button onClick="stopStart()" id="time">Start</button>
<input type="text" id="minutes" value="0" />
 //Aquí los minutos 
 // <input type="text" id="seconds" value="0" />
 // Aquí los segundos -->
