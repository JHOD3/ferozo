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
              <!--
              <div class="form-group <?php if(form_error('titulo')) echo 'has-error';?>">
                <label for="titulo"><?=mostrar_palabra(203, $palabras)?></label>
                <?php echo form_error('titulo'); ?>
                <input type="text" class="form-control" rows="3" id="titulo" name="titulo" value="<?=$this->input->post('titulo')?>">
              </div>
              -->
              <div class="form-group <?php if(form_error('descripcion')) echo 'has-error';?>">
                <label for="descripcion"><?=mostrar_palabra(294, $palabras)?></label> <small id="caracteres">255 <?=mostrar_palabra(26, $palabras)?></small>
                <?php echo form_error('descripcion'); ?>
                <textarea class="form-control" rows="3" id="descripcion" name="descripcion" maxlength="255" onKeyUp="cuenta_caracteres()" placeholder="<?=mostrar_palabra(321, $palabras)?>"><?=$this->input->post('descripcion')?></textarea>
              </div>

              <div class="form-group <?php if(form_error('arancel')) echo 'has-error';?>">
                <label for="arancel"><?=mostrar_palabra(49, $palabras)?></label>
                <?php echo form_error('arancel[]'); ?>
                <?php echo form_error('arancel_select'); ?>
                <button type='button' data-toggle="modal" data-target="#modal-search" class='btn btn-danger btn-xs pull-right flip'><i class='fa fa-search'></i></button>
                <!--<button type="button" data-toggle="modal" data-target="#modal-search" class="btn btn-danger btn-xs pull-right flip"><i class="fa fa-search"></i></button>-->
                <div class="input-group" style="width:100%;">
                  <!--<input type="text" class="form-control" id="buscar" name="buscar" placeholder="Search for...">-->
                  <select data-placeholder="<?=mostrar_palabra(245, $palabras)?>..." class="chosen-select form-control" name="arancel_select" id="arancel">
                    <option value=""></option>
                    <?php
                    /*
                    foreach ($secciones as $seccion)
                    {
                      echo '<optgroup label="'.$seccion['sec_desc'].'">';
                      foreach ($seccion['aranceles'] as $arancel)
                      {
                        $selected = "";
                        if($this->input->post('arancel_select') == $arancel['ara_id'])
                        {
                          $selected = "selected";
                        }
                        echo '<option value="'.$arancel['ara_id'].'" '.$selected.'>'.$arancel['ara_code'].' - '.$arancel['ara_desc'].'</option>';
                      }
                      echo '</optgroup>';
                    }*/
                    ?>
                  </select>

                </div>
              </div>

              <div class="form-group <?php if(form_error('pais')) echo 'has-error';?>">
                <label for="pais"><?=mostrar_palabra(2, $palabras)?></label>
                <?php echo form_error('pais'); ?>
                <select class="form-control" name="pais" id="pais">
                  <option selected disabled style='display:none;'><?=mostrar_palabra(161, $palabras)?></option>
                  <?php
                  foreach ($paises as $pais)
                  {
                    $selected="";
                    if($this->input->post('pais') == $pais['ctry_code'])
                    {
                      $selected="selected";
                    }
                    echo "<option value='".$pais['ctry_code']."' ".$selected.">".$pais['ctry_nombre']."</option>";
                  }
                  ?>
                </select>
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

  function cargar_categorias(sec_id)
  {
    if(sec_id != "")
    {
      $('#reportar_seccion').show();
      $('#area_categorias').html('<img src="'+BASE_URL+'assets/images/loading.png" width="50px">');
      $('#area_arancel').html("");

      $.get('<?=site_url()?>productos/cargar_categorias_noajax/'+sec_id, function(resp){
        var htmlData = '<label for="categoria"><?=mostrar_palabra(77, $palabras)?></label> &nbsp; <a href="javascript: reportar_texto(2, $(\'#categoria\').val());" id="reportar_categoria" class="reportar" style="display:none;" data-toggle="tooltip" data-placement="top" title="<?=mostrar_palabra(92, $palabras)?>"><i class="fa fa-lg fa-exclamation-triangle"></i></a>';
        htmlData += '<select class="form-control" name="categoria" id="categoria" onchange="cargar_aranceles(this.value);">';
          htmlData += resp;
        htmlData += '</select>';
        $('#area_categorias').html(htmlData);
        $('#categoria').chosen({disable_search_threshold: 100});
        $('#reportar_categoria').tooltip();
      });
    }
    else
    {
      $('#reportar_seccion').hide();
    }
  }

  function cargar_aranceles(cat_id)
  {
    if(cat_id != "")
    {
      $('#reportar_categoria').show();
      $('#area_arancel').html('<img src="'+BASE_URL+'assets/images/loading.png"> width="50px"');

      $.get('<?=site_url()?>productos/cargar_aranceles_noajax/'+cat_id, function(resp){
        if($('#seccion').val() == 22)
        {
          var htmlData = '<label for="arancel"><?=mostrar_palabra(158, $palabras)?></label>';
        }
        else
        {
          var htmlData = '<label for="arancel"><?=mostrar_palabra(157, $palabras)?></label>';
        }
        htmlData += ' &nbsp; <a href="javascript: reportar_texto(3, $(\'#arancel_modal\').val());" id="reportar_arancel" class="reportar" style="display:none;" data-toggle="tooltip" data-placement="top" title="<?=mostrar_palabra(92, $palabras)?>"><i class="fa fa-lg fa-exclamation-triangle"></i></a>';
        htmlData += '<select class="form-control" name="arancel" id="arancel_modal" onchange="cargar_final(this.value);">';
          htmlData += resp;
        htmlData += '</select>';
        $('#area_arancel').html(htmlData);
        $('#arancel_modal').chosen({disable_search_threshold: 100});
        $('#reportar_arancel').tooltip();
      });
    }
    else
    {
      $('#reportar_categoria').hide();
    }
  }

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