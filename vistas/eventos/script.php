<script src='public/fullcalendar-2.2.7-yearview/lib/moment.min.js'></script>
<script src='public/fullcalendar-2.2.7-yearview/fullcalendar.min.js'></script>
<script src="public/framework/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="public/framework/plugins/datatables/extensions/FixedColumns/js/dataTables.fixedColumns.min.js"></script>
 

<script>
$('.textarea').wysihtml5();

$(document).ready(function() {
    ////////////////////////////////////////////////////////////////////////////
    //evento para llamar los eventos
    ////////////////////////////////////////////////////////////////////////////
    var json_events;
    var ultima_fecha;
    $.ajax({
        url: 'eventos',
        type: 'POST', // Send post data
        data: 'KEY=KEY_DATA_CALENDARIO',
        async: false,
        dataType: 'json',
        success: function(s){
            json_events = s;
        }
    }); 
    $.ajax({
        url: 'eventos',
        type: 'POST', // Send post data
        data: 'KEY=KEY_ULTIMA_FECHA',
        async: false,
        success: function(s){
            ultima_fecha = s;
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
//      alert('id: ' + calEvent.hora_fin);
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
     },
     defaultDate : ultima_fecha,
     eventDataTransform: function(event) {                                                                                                                                
        if(event.allDay) {                                                                                                                                               
          event.end = moment(event.end).add(1, 'days')                                                                                                                 
        }
        return event;  
      }   
    });

     $('#latabla').datatable( {
        scrollY:        "300px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   {
            leftColumns: 2
        }
    } );

    

    
  });

/*var $table = $('.tabla');
var $fixedColumn = $table.clone().insertBefore($table).addClass('fixed-column');
$fixedColumn.find('th:not(:nth-child(-n+2)),td:not(:nth-child(-n+2))').remove();
$fixedColumn.find('tr').each(function (i, elem) {
    $(this).height($table.find('tr:eq(' + i + ')').height());
});*/
  

</script>
