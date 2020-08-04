<!-- Modal -->
<div class="modal fade" id="modal_invitar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?=mostrar_palabra(675, $palabras)?></h4>
      </div>

      <form id="form_invitar" method="POST" action="#">
        <div class="modal-body">
          <div id="mensaje_invitar"></div>
          <input type="hidden" value="<?=$operations['cob_id']?>" name="cob_id" id="invitar_cob_id">
          <input type="hidden" value="" name="cob_usr_tipo_id" id="invitar_cob_usr_tipo_id">
          <input type="text" class="form-control" value="" name="mail" id="invitar_mail" placeholder="<?=mostrar_palabra(4, $palabras)?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(29, $palabras)?></button>
          <button type="submit" class="btn btn-danger" id="btn_referenciar"><?=mostrar_palabra(17, $palabras)?></button>
        </div>
      </form>

    </div>
  </div>
</div>


<script type="text/javascript">
function ver_modal_invitar(tipo, tipo_desc = "")
{
	$('#invitar_cob_usr_tipo_id').val(tipo);
  $('#modal_invitar .modal-title').html('<?=mostrar_palabra(675, $palabras)?> ('+tipo_desc+')');
	$('#modal_invitar').modal('show');
}

$( "#form_invitar" ).submit(function( event ) {
  event.preventDefault();
  $("#mensaje_invitar").html("");
  $('#btn_referenciar').button('loading');
  $.ajax({
     type: 'post',
     dataType: "json",
     data: $(event.target).serialize(),
     cache: false,
     url: SITE_URL+"cobranzas/invitar_ajax",
     success: function(data){
        if(data.error == false)
        {
          var htmlData = '<div class="alert with-icon alert-success" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
          htmlData += data.data;
          htmlData += '</div>';
          $("#mensaje_invitar").html(htmlData);
        }
        else
        {
          var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
          htmlData += data.data;
          htmlData += '</div>';
          $("#mensaje_invitar").html(htmlData);
        }
        $('#btn_referenciar').button('reset');
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        $("#mensaje_invitar").html(htmlData);
        $('#btn_referenciar').button('reset');
      }
  });
});
</script>