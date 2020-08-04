<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<body>

<!-- Header -->
<?php
$this->load->view('templates/analytics');
$this->load->view('templates/header');
?>
<!-- /Header -->
	
<?php
$this->load->view('templates/sidebar_left');
?>

<!-- Content -->
<main class="content fondo-derecha">

	<!-- Features -->
	<section class="container-fluid">
		
		<div class="row">

			<div class="col-md-12 col-lg-6">
				<div class="panel panel-danger">
				  <div class="panel-heading">
				    <h3 class="panel-title"><?=mostrar_palabra(308, $palabras)?></h3>
				  </div>
        </div>

        <div class="panel">
				  <div class="panel-body">
            <?php 
                if($error != "")
                {
                    echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    echo $error;
                    echo '</div>';
                }
                if($success != "")
                {
                    echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    echo $success;
                    echo '</div>';
                }
            ?>

				    <form method="POST" action="<?=site_url()?><?=$solapa?>/nuevo">
              
              <div class="form-group <?php if(form_error('mail')) echo 'has-error';?>">
                <label for="mail"><?=mostrar_palabra(4, $palabras)?></label>
                <?php echo form_error('mail'); ?>
                <input type="text" class="form-control" rows="3" id="mail" name="mail" value="<?=$this->input->post('mail')?>">
              </div>
              
              <div class="form-group <?php if(form_error('descripcion')) echo 'has-error';?>">
                <label for="descripcion"><?=mostrar_palabra(294, $palabras)?></label>
                <?php echo form_error('descripcion'); ?>
                <textarea class="form-control" rows="3" id="descripcion" name="descripcion" placeholder="<?=mostrar_palabra(321, $palabras)?>"><?=$this->input->post('descripcion')?></textarea>
              </div>

              <button type="submit" class="btn btn-danger"><?=mostrar_palabra(17, $palabras)?></button>
              <a href="<?=site_url()?><?=$solapa?>/index" class="btn btn-default"><?=mostrar_palabra(29, $palabras)?></a>

            </form>
				  </div>
				</div>
			</div>

		</div>
	</section>
	<!-- /Features -->

</main>


<!-- Modal -->
<div class="modal fade" id="modal-search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=mostrar_palabra(36, $palabras)?></h4>
      </div>
      <div class="modal-body">

        <div class="form-group <?php if(form_error('seccion')) echo 'has-error';?>">
          <label for="seccion"><?=mostrar_palabra(76, $palabras)?></label> &nbsp; <a href="javascript: reportar_texto(1, $('#seccion').val());" id="reportar_seccion" class="reportar" style="display:none;" data-toggle="tooltip" data-placement="top" title="<?=mostrar_palabra(92, $palabras)?>"><i class="fa fa-lg fa-exclamation-triangle"></i></a>
          <select class="form-control" name="seccion" id="seccion" onchange="cargar_categorias(this.value);">
            <option value="" selected disabled style='display:none;'><?=mostrar_palabra(153, $palabras)?></option>
            <?php
            foreach ($secciones as $seccion)
            {
              echo "<option value='".$seccion['sec_id']."'>".$seccion['sec_code']." - ".$seccion['sec_desc']."</option>";
            }
            ?>
          </select>
        </div>

        <div class="form-group <?php if(form_error('categoria')) echo 'has-error';?>" id="area_categorias">
        </div>

        <div class="form-group <?php if(form_error('arancel')) echo 'has-error';?>" id="area_arancel">
        </div>

        <div style="margin-top:20px;" id="area_resultados"></div>
        <div style="clear:both;"></div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(29, $palabras)?></button>
        <button type="button" class="btn btn-danger" onclick="seleccion_detallada()"><?=mostrar_palabra(17, $palabras)?></button>
      </div>
    </div>
  </div>
</div>


<?php
$this->load->view('templates/footer');
?>

<!-- Choosen -->
<link href="<?=base_url()?>assets/css/chosen.min.css" rel="stylesheet">
<script src="<?=base_url()?>assets/js/chosen.jquery.mobile.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/chosen.ajaxaddition.jquery.js"></script>
<style type="text/css">
.chosen-container-single .chosen-single{
  height: 34px;
  line-height: 30px;
}
</style>

<script type="text/javascript">
$('.chosen-select').ajaxChosen({
  dataType: 'json',
  type: 'POST',
  url:'<?=site_url()?>productos/buscar_posiciones_ajax'
},{
  loadingImg: '<?=base_url()?>assets/js/loading.png',
  minLength: 2
},{
  no_results_text: "<?=mostrar_palabra(246, $palabras)?> <i class='fa fa-search'></i>"
});

$('#seccion').chosen({disable_search_threshold: 100});

$('#modal-search').on('shown.bs.modal', function () {
  $('#seccion').chosen('destroy').chosen({disable_search_threshold: 100});
});



  function cargar_final(ara_id)
  {
    if(ara_id != "")
    {
      $('#reportar_arancel').show();
    }
    else
    {
      $('#reportar_arancel').hide();
    }
  }

  function seleccion_detallada()
  {
    var htmlData = "<option value='"+$('#arancel_modal option:selected').val()+"' selected>"+$('#arancel_modal option:selected').text()+"</option>";
    $('#arancel').html( htmlData );
    $('#arancel').val( $('#arancel_modal').val() ).trigger("chosen:updated");
    $('#modal-search').modal('hide');
  }

  function cuenta_caracteres()
  {
    var num = 255 - $('#descripcion').val().length;
    $('#caracteres').html(num + " <?=mostrar_palabra(26, $palabras)?>");
  }
</script>

</body>
</html>