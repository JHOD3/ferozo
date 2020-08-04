<!-- Modal -->
<div class="modal fade" id="modal_comentar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Comentar</h4>
      </div>

      <form id="form_comentar" method="POST" action="#">
        <div class="modal-body">
          <div id="mensaje_comentar"></div>
          <input type="hidden" name="cob_id" value="<?=$operations['cob_id']?>" id="cob_id_comentar">
          <input type="hidden" name="item_tipo_id" value="0" id="tipo_item_id_comentar">
          <input type="hidden" name="item_id" value="0" id="item_id_comentar">
          <input type="hidden" name="sub_item_id" value="0" id="sub_item_id_comentar">
          <input type="hidden" name="estado" value="0" id="estado_comentar">
          <textarea class="form-control" name="texto" id="texto_comentar"></textarea>
          <div id="area_mensajes_comentar"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btns_comentario btn-default" data-dismiss="modal" data-loading-text="<i class='fas fa-sync fa-spin'></i>"><?=mostrar_palabra(29, $palabras)?></button>
          <button type="button" class="btn btns_comentario btn-danger" id="btn_comentar_down" data-loading-text="<i class='fas fa-sync fa-spin'></i>" value="2" name="estado2" onclick="comentar_up(2)"><i class="fas fa-thumbs-down"></i> Rechazar</a></button>
          <button type="button" class="btn btns_comentario btn-success" id="btn_comentar_up" data-loading-text="<i class='fas fa-sync fa-spin'></i>" value="1" name="estado1" onclick="comentar_up(1)"><i class="fas fa-thumbs-up"></i> Aprobado</button>
          <button type="button" class="btn btns_comentario btn-warning" id="btn_comentar" data-loading-text="<i class='fas fa-sync fa-spin'></i>" value="0" name="estado0" onclick="comentar_up(0)">Enviar</button>
        </div>
      </form>

    </div>
  </div>
</div>


<script type="text/javascript">
function abrir_comentar(tipo, item, sub_item_id, permiso_confirmar=1)
{
  $("#mensaje_comentar").html("");
  $('#texto_comentar').val('');
  $('#item_id_comentar').val(item);
  $('#sub_item_id_comentar').val(sub_item_id);
  $('#tipo_item_id_comentar').val(tipo);
  get_comentarios();

  if(permiso_confirmar == 1)
  {
    $('#btn_comentar_down').show();
    $('#btn_comentar_up').show();
  }
  else
  {
    $('#btn_comentar_down').hide();
    $('#btn_comentar_up').hide();
  }

  $('#modal_comentar').modal('show');
}

$( "#form_comentar" ).submit(function( event ) {
  event.preventDefault();
  $("#mensaje_comentar").html("");
  $('.btns_comentario').button('loading');
  $.ajax({
     type: 'post',
     dataType: "json",
     data: $(event.target).serialize(),
     cache: false,
     url: SITE_URL+"cobranzas/comentar_ajax",
     success: function(data){
        if(data.error == false)
        {
          var htmlData = '<div class="alert with-icon alert-success" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
          htmlData += data.data;
          htmlData += '</div>';
          $("#mensaje_comentar").html(htmlData);
          $('#modal_comentar').modal('hide');

          if(data['cob_com_est_id'] == 1)
          {
            $('#btn_comentar_item_'+$('#tipo_item_id_comentar').val()+'_'+$('#item_id_comentar').val()+'_'+$('#sub_item_id_comentar').val()).removeClass('btn-danger');
            $('#btn_comentar_item_'+$('#tipo_item_id_comentar').val()+'_'+$('#item_id_comentar').val()+'_'+$('#sub_item_id_comentar').val()).addClass('btn-success');
          }
          else if(data['cob_com_est_id'] == 2)
          {
            $('#btn_comentar_item_'+$('#tipo_item_id_comentar').val()+'_'+$('#item_id_comentar').val()+'_'+$('#sub_item_id_comentar').val()).removeClass('btn-success');
            $('#btn_comentar_item_'+$('#tipo_item_id_comentar').val()+'_'+$('#item_id_comentar').val()+'_'+$('#sub_item_id_comentar').val()).addClass('btn-danger');
          }
        }
        else
        {
          var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
          htmlData += data.data;
          htmlData += '</div>';
          $("#mensaje_comentar").html(htmlData);
        }
        $('.btns_comentario').button('reset');
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        $("#mensaje_comentar").html(htmlData);
        $('.btns_comentario').button('reset');
      }
  });
});

function comentar_up(estado)
{
  $('#estado_comentar').val(estado);
  $( "#form_comentar" ).submit();
}

function get_comentarios()
{
  $("#area_mensajes_comentar").html("Loading");
  $.ajax({
     type: 'post',
     dataType: "json",
     data: jQuery.param({cob_id:$('#cob_id_comentar').val(), item_tipo_id:$('#tipo_item_id_comentar').val(), item_id:$('#item_id_comentar').val(), sub_item_id:$('#sub_item_id_comentar').val()}),
     cache: false,
     url: SITE_URL+"cobranzas/get_comentarios_ajax",
     success: function(data){
        if(data.error == false)
        {
          var htmlData = '';
          if(data.data)
          {
            htmlData += '<table class="table">';
              $( data.data ).each(function( i, item ) {
                htmlData += '<tr>';
                  htmlData += '<td>'+item.cob_com_fecha+'</td>';
                  htmlData += '<td>'+item.usr_mail+'</td>';
                  htmlData += '<td>'+nl2br(item.cob_com_texto)+'</td>';
                  htmlData += '<td>';
                  if(item.cob_com_est_id == 1)
                  {
                    htmlData += 'Aprobado';
                  }
                  else if(item.cob_com_est_id == 2)
                  {
                    htmlData += 'Rechazado';
                  }
                  htmlData += '</td>';
                htmlData += '</tr>';
              });
            htmlData += '</table>';
          }
          $("#area_mensajes_comentar").html(htmlData);
        }
        else
        {
          var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
          htmlData += data.data;
          htmlData += '</div>';
          $("#area_mensajes_comentar").html(htmlData);
        }
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        $("#area_mensajes_comentar").html(htmlData);
      }
  });
}


function set_estado_comentario(tipo, id, sub_item_id, estado)
{
  $('#btn_comentar_item_'+tipo+'_'+id+'_'+sub_item_id).button('loading');
  $.ajax({
     type: 'post',
     dataType: "json",
     data: jQuery.param({cob_id:<?=$operations['cob_id']?>, item_tipo_id:tipo, item_id:id, sub_item_id:sub_item_id, estado:estado}),
     cache: false,
     url: SITE_URL+"cobranzas/comentar_estado_ajax",
     success: function(data){
        if(data.error == false)
        {
          if(data['cob_com_est_id'] == 1)
          {
            $('#btn_comentar_item_'+tipo+'_'+id+'_'+sub_item_id).removeClass('btn-danger');
            $('#btn_comentar_item_'+tipo+'_'+id+'_'+sub_item_id).addClass('btn-success');
          }
          else if(data['cob_com_est_id'] == 2)
          {
            $('#btn_comentar_item_'+tipo+'_'+id+'_'+sub_item_id).removeClass('btn-success');
            $('#btn_comentar_item_'+tipo+'_'+id+'_'+sub_item_id).addClass('btn-danger');
          }
        }
        else
        {
          alert(data.data);
        }
        $('#btn_comentar_item_'+tipo+'_'+id+'_'+sub_item_id).button('reset');
      },
      error: function(x, status, error){
        alert("An error occurred: " + status + " nError: " + error);
        $('#btn_comentar_item_'+tipo+'_'+id+'_'+sub_item_id).button('reset');
      }
  });
}
</script>