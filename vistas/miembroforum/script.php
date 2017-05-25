<script src='public/fullcalendar-2.2.7-yearview/lib/moment.min.js'></script>
<script src='public/fullcalendar-2.2.7-yearview/fullcalendar.min.js'></script>
<script>
$(document).ready(function() {
    ////////////////////////////////////////////////////////////////////////////
    //evento para llamar los eventos
    ////////////////////////////////////////////////////////////////////////////
    var json_events;
    $.ajax({
        url: 'miembroforum',
        type: 'POST', // Send post data
        data: 'KEY=KEY_DATA_CALENDARIO',
        async: false,
        success: function(s){
            json_events = s;
        }
    });          
    $('#calendar').fullCalendar({
       header: {
            left: 'prev,next today',
            center: 'title',
            right: 'year,month,agendaWeek,agendaDay'
        },
      buttonText: {
        today: 'today',
        month: 'month',
        week: 'week',
        day: 'day'
      },
      events: JSON.parse(json_events), 
      defaultView: 'month',
      yearColumns: 2,
      editable: false,
      droppable: false, // this allows things to be dropped onto the calendar !!!
      eventClick: function(calEvent, jsEvent, view) {
        //alert('id: ' + calEvent.hora_inicio);
        //$('#modal_get_detalle_evento').modal('show'); 
        
        var parametros = {
                KEY: 'KEY_DETALLE_EVENTO',
                _id: calEvent.id        
        };
        $.ajax({
            data:  parametros,
            url:   'eventos',
            type:  'post',
            dataType : 'json',
            success:  function (mensaje) {
                    if(mensaje.success == "true"){
                        //$.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                        
                        $("#_id_evento_detalle").val(calEvent.id);
                        $("#respuesta_modal_detalle_evento").html(mensaje.contenido);
                        $('#modal_get_detalle_evento').modal('show'); 
                        $("#_url_google_calendar").val(mensaje.urlGoogleCalendar);
                    }else{
                        $.toaster({ priority : mensaje.priority, title : 'Alerta', message : mensaje.msg});
                    }
            },error : function(xhr, status) {
                $.toaster({ priority : 'danger', title : 'Alerta', message : 'Disculpe, existió un problema'});
            }
        });
     }
    });
  });
  

</script>
