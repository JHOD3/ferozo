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
				    <h3 class="panel-title">
              <?php
              if($tipo_producto['tp_id'] == TP_OFERTA)
              {
                echo mostrar_palabra(23, $palabras);
              }
              else
              {
                echo mostrar_palabra(24, $palabras);
              }
              ?>
            </h3>
				  </div>
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

				    <form id="form_nuevo" method="POST" action="<?=site_url()?>productos/nuevo/<?=$tipo_producto['tp_id']?>" enctype='multipart/form-data'>

              <div class="form-group <?php if(form_error('arancel')) echo 'has-error';?>">
                <div id="area_error_arancel"></div>
                <label for="arancel"><i class="fa fa-code fa-lg texto-bordo2"></i> <?=mostrar_palabra(255, $palabras)?></label>
                <?php echo form_error('arancel[]'); ?>
                <?php echo form_error('arancel_select'); ?>
                <button type='button' data-toggle="modal" data-target="#modal-search" class='btn btn-danger btn-xs pull-right flip'><i class='fa fa-search'></i></button>
                <!--<button type="button" data-toggle="modal" data-target="#modal-search" class="btn btn-danger btn-xs pull-right flip"><i class="fa fa-search"></i></button>-->
                <div class="input-group">
                  <!--<input type="text" class="form-control" id="buscar" name="buscar" placeholder="Search for...">-->
                  <select data-placeholder="<?=mostrar_palabra(245, $palabras)?>..." class="chosen-select form-control" name="arancel_select" id="arancel">
                    <?php
                    if($arancel_precargado)
                    {
                      echo '<option value="'.$arancel_precargado['ara_id'].'">'.$arancel_precargado['ara_code'].' - '.$arancel_precargado['ara_desc'].'</option>';
                    }
                    else
                    {
                      echo '<option value=""></option>';
                    }
                    /*
                    foreach ($secciones as $seccion)
                    {
                      echo "<optgroup label='".$seccion['sec_desc']."'>\n";
                      foreach ($seccion['aranceles'] as $key_arancel => $arancel)
                      {
                        $selected = "";
                        if($this->input->post('arancel_select') == $arancel['ara_id'])
                        {
                          $selected = "selected";
                        }
                        echo "<option value='".$arancel['ara_id']."' ".$selected.">".$arancel['ara_code']." - ".$arancel['ara_desc']."</option>\n";
                      }
                      echo "</optgroup>\n";
                    }*/
                    ?>
                  </select>
                  
                  <span class="input-group-btn">
                    <button class="btn btn-danger" type="button" onclick="nuevo_arancel()"><i class="fa fa-plus"></i></button>
                  </span>
                  
                </div>
              </div>

              <div id="area-aranceles">
                <?php
                if($this->input->post('arancel[]') != "")
                {
                  $aranceles_texto = $this->input->post('arancel_texto[]');
                  foreach($this->input->post('arancel[]') as $key => $arancel)
                  {
                    echo '<div class="form-group" id="area_arancel_'.$key.'">';
                      echo '<div id="area_mail_1">';
                        echo '<div class="input-group">';
                          echo '<input type="hidden" name="arancel[]" value="'.$arancel.'">';
                          echo '<input type="text" class="form-control" name="arancel_texto[]" placeholder="" value="'.$aranceles_texto[$key].'" readonly="readonly">';
                          echo '<div class="input-group-addon" style="cursor:pointer;" onclick="borrar_arancel('.$key.')">';
                            echo '<i class="fa fa-minus"></i>';
                          echo '</div>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                  }
                }
                ?>
              </div>

              <div class="cortar-texto" style="margin-bottom:10px; font-size:12px;"><i class="fa fa-question-circle fa-lg"></i> <?=mostrar_palabra(338, $palabras)?></div>

              <div class="form-group <?php if(form_error('pais')) echo 'has-error';?>">
                <label for="pais"><i class="fa fa-map-marker-alt fa-lg texto-bordo2"></i> <?=mostrar_palabra(2, $palabras)?></label>
                <?php echo form_error('pais'); ?>
                <select class="form-control" name="pais" id="pais" onchange="cargar_ciudades(this.value);">
                  <option disabled style='display:none;'><?=mostrar_palabra(161, $palabras)?></option>
                  <?php
                  foreach ($paises as $pais)
                  {
                    $selected = "";
                    if($comparar_pais == $pais['ctry_code'])
                    {
                      $selected = "selected";
                    }
                    echo "<option value='".$pais['ctry_code']."' ".$selected.">".$pais['ctry_nombre']."</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group <?php if(form_error('ciudad')) echo 'has-error';?>">
                <label for="ciudad"><i class="fa fa-map-marker-alt fa-lg texto-bordo2"></i> <?=mostrar_palabra(32, $palabras)?></label>
                <?php echo form_error('ciudad'); ?>
                <select class="form-control" name="ciudad" id="ciudad">
                  <option disabled><?=mostrar_palabra(165, $palabras)?></option>
                  <?php
                  foreach ($ciudades as $ciudad)
                  {
                    $selected = "";
                    if($comparar_ciudad == $ciudad['city_id'])
                    {
                      $selected = "selected";
                    }
                    echo "<option value='".$ciudad['city_id']."' ".$selected.">";
                    if($ciudad['city_nombre'] == $ciudad['toponymName'])
                    {
                      echo $ciudad['city_nombre'];
                    }
                    else
                    {
                      echo $ciudad['city_nombre']." / ".$ciudad['toponymName'];
                    }
                    echo "</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group <?php if(form_error('descripcion')) echo 'has-error';?>">
                <div id="area_error_descripcion"></div>
                <label for="descripcion"><i class="fa fa-pencil-alt fa-lg texto-bordo2"></i> <?=mostrar_palabra(27, $palabras)?></label> <small id="caracteres">255 <?=mostrar_palabra(26, $palabras)?></small>
                <?php 
                echo form_error('descripcion'); 
                
                $placeholder = mostrar_palabra(85, $palabras);
                if($tipo_producto['tp_id'] == TP_OFERTA)
                {
                  $placeholder = mostrar_palabra(83, $palabras);
                }
                ?>
                <textarea class="form-control" rows="3" id="descripcion" name="descripcion" maxlength="255" onKeyUp="cuenta_caracteres()" placeholder="<?=$placeholder?>"><?=$this->input->post('descripcion')?></textarea>
              </div>

              <div class="form-group <?php if(form_error('mail')) echo 'has-error';?>" id="area_mails">
                <div id="area_error_mail"></div>
                <label for="mail"><i class="fa fa-envelope fa-lg texto-bordo2"></i> <?=mostrar_palabra(4, $palabras)?></label> <button type='button' onclick='nuevo_mail()' class="btn btn-danger btn-xs pull-right flip"><i class="fa fa-plus"></i></button>
                <?php echo form_error('mail[]'); ?>
                <div id='area_mail_1'>
                  <div class='input-group'>
                    <input type="email" class="form-control" id="mail" name="mail[]" placeholder="Email" value="<?=$this->session->userdata('usr_mail')?>">
                    <div class='input-group-addon' style='cursor:pointer;' onclick='borrar_mail(1)'>
                      <i class='fa fa-minus'></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group <?php if(form_error('idioma')) echo 'has-error';?>" id="area_idiomas">
                <div id="area_error_idioma"></div>
                <label for="idioma"><i class="fa fa-language fa-lg texto-bordo2"></i> <?=mostrar_palabra(3, $palabras)?></label> <button type='button' onclick='nuevo_idioma()' class='btn btn-danger btn-xs pull-right flip'><i class='fa fa-plus'></i></button>
                <?php echo form_error('idioma[]'); ?>
                <div id='area_idioma_1'>
                  <div class='input-group'>
                    <select class="form-control" name="idioma[]" id="idioma">
                      <option selected disabled style='display:none;'><?=mostrar_palabra(3, $palabras)?></option>
                      <?php
                      foreach ($idiomas as $idioma)
                      {
                        if($this->session->userdata('idi_code') == $idioma['idi_code'])
                          echo "<option value='".$idioma['idi_code']."' selected>".ucfirst($idioma['idi_desc'])."</option>";
                        else
                          echo "<option value='".$idioma['idi_code']."'>".ucfirst($idioma['idi_desc'])."</option>";
                      }
                      ?>
                    </select>
                    <div class='input-group-addon' style='cursor:pointer;' onclick='borrar_idioma(1)'>
                      <i class='fa fa-minus'></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group <?php if(form_error('imagen')) echo 'has-error';?>" id="area_imagenes">
                <label for="imagen"><i class="fa fa-camera fa-lg texto-bordo2"></i> <?=mostrar_palabra(303, $palabras)?> (jpg, png, gif) 10MB</label> <button type='button' onclick='nuevo_imagen()' class="btn btn-danger btn-xs pull-right flip"><i class="fa fa-plus"></i></button>
                <?php echo form_error('imagen[]'); ?>
                <div id='area_imagen_1'>
                  <div class='input-group'>
                    <input type="file" class="form-control" id="imagen" name="imagen[]" placeholder="Imagen">
                    <div class='input-group-addon' style='cursor:pointer;' onclick='borrar_imagen(1)'>
                      <i class='fa fa-minus'></i>
                    </div>
                  </div>
                </div>
              </div>

              <?php
                echo "<div class='form-group' id='area_referencias'>";
                echo "<label><span class='icon-relacion texto-bordo2' style='font-size:18px;'></span> ".mostrar_palabra(314, $palabras)."</label> ";
                //echo '<a href="'.site_url("faq").'" target="_blank" style="color:#000;"><i class="fa fa-question-circle fa-lg" style="margin-left:10px;"></i></a> ';
                echo "<button type='button' onclick='nueva_referencia()' class='btn btn-danger btn-xs pull-right flip'><i class='fa fa-plus'></i></button>";

                $cant_referencias = 0;
                  foreach ($referencias as $key_ref => $referencia)
                  {
                    $cant_referencias++;
                    echo "<div id='area_referencia_".$cant_referencias."' style='margin-bottom:5px;'>";
                        echo '<div class="input-group">';
                          echo '<input type="hidden" class="form-control" id="ref_id_'.$cant_referencias.'" name="ref_id[]" value="'.$referencia['ref_id'].'">';
                          echo '<input type="hidden" class="form-control" id="ref_est_id_'.$cant_referencias.'" name="ref_est_id[]" value="'.$referencia['ref_est_id'].'">';
                          echo '<input type="email" class="form-control" name="ref_mail[]" value="'.$referencia['ref_mail'].'" readonly="readonly">';
                          echo '<span class="input-group-btn">';
                            if($referencia['ref_est_id'] == REFERENCIA_PENDIENTE)
                            {
                              echo '<button class="btn btn-warning" type="button"><i class="fa fa-clock"></i></button>';
                            }
                            elseif($referencia['ref_est_id'] == REFERENCIA_VALIDADA)
                            {
                              echo '<button class="btn btn-success" type="button"><span class="icon-relacion"></span></button>';
                            }
                            elseif($referencia['ref_est_id'] == REFERENCIA_RECHAZADA)
                            {
                              echo '<button class="btn btn-danger" type="button"><i class="fa fa-ban"></i></button>';
                            }
                            echo '<button class="btn btn-default" type="button" onclick="borrar_referencia('.$cant_referencias.')"><i class="fa fa-minus"></i></button>';
                          echo '</span>';
                        echo '</div>';

                    echo "</div>";
                  }

                  echo "<div class='clearfix'></div>";
                echo "</div>";
              ?>

              <button type="submit" class="btn btn-danger"><?=mostrar_palabra(17, $palabras)?></button>
              <a href="<?=site_url()?>productos/index/<?=$tipo_producto['tp_id']?>" class="btn btn-default"><?=mostrar_palabra(29, $palabras)?></a>

            </form>
				  </div>
				</div>
			</div>
			<?php
			//$this->load->view('templates/sidebar_right');
			?>
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

        <div class="cortar-texto" style="margin-bottom:10px; font-size:12px;"><i class="fa fa-question-circle fa-lg"></i> <?=mostrar_palabra(338, $palabras)?></div>
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
var cant_idiomas = 1;
var cant_mails = 1;
var cant_imagenes = 1;
var cant_aranceles = 0;
var cant_referencias = <?=$cant_referencias?>;

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
  
  function nuevo_arancel()
  {
    if($('#arancel').val() != "")
    {
      var repetido = false;
      $('#form_nuevo input[name="arancel[]"]').each(function() {
          if($(this).val() == $('#arancel').val())
          {
            repetido = true;
          }
      });

      if(!repetido)
      {
        cant_aranceles++;
        var htmlData = '';
        htmlData += '<div class="form-group" id="area_arancel_'+cant_aranceles+'">';
            htmlData += '<div class="input-group">';
              htmlData += '<input type="hidden" name="arancel[]" value="'+$('#arancel').val()+'">';
              htmlData += '<input type="text" data-toggle="tooltip" data-placement="top" title="'+$('#arancel option:selected').text()+'" class="form-control" name="arancel_texto[]" placeholder="" value="'+$('#arancel option:selected').text()+'" readonly="readonly">';
              htmlData += '<div class="input-group-addon" style="cursor:pointer;" onclick="borrar_arancel('+cant_aranceles+')">';
                htmlData += '<i class="fa fa-minus"></i>';
              htmlData += '</div>';
            htmlData += '</div>';
        htmlData += '</div>';

        $('#area-aranceles').append(htmlData);

        $('#area_arancel_'+cant_aranceles+' input[name="arancel_texto[]"]').tooltip({delay: { "show": 1000 }});
      }

      $('#arancel').val("");
      $("#arancel").trigger("chosen:updated");
    }
    else
    {
      $('#modal-search').modal('show');
    }
  }

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
      $('#area_arancel').html('<img src="'+BASE_URL+'assets/images/loading.png" width="50px">');

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

  function cargar_ciudades(ctry_code)
  {
    $.get('<?=site_url()?>productos/cargar_ciudades_noajax/'+ctry_code, function(resp){
      $('#ciudad').html(resp);
    });
  }

  function nuevo_mail()
  {
    cant_mails++;
    $.get('<?=site_url()?>productos/nuevo_mail_noajax/'+cant_mails, function(resp){
      $('#area_mails').append(resp);
    });
  }

  function nuevo_imagen()
  {
    cant_imagenes++;
    $.get('<?=site_url()?>productos/nuevo_imagen_noajax/'+cant_mails, function(resp){
      $('#area_imagenes').append(resp);
    });
  }

  function nuevo_idioma()
  {
    cant_idiomas++;
    $.get('<?=site_url()?>productos/nuevo_idioma_noajax/'+cant_idiomas, function(resp){
      $('#area_idiomas').append(resp);
    });
  }

  function borrar_arancel(id)
  {
    $('#area_arancel_'+id).remove();
  }

  function borrar_mail(id)
  {
    $('#area_mail_'+id).remove();
  }

  function borrar_imagen(id)
  {
    $('#area_imagen_'+id).remove();
  }

  function borrar_idioma(id)
  {
    $('#area_idioma_'+id).remove();
  }

  function nueva_referencia()
  {
    cant_referencias++;
    $.get('<?=site_url()?>user/nueva_referencia_noajax/'+cant_referencias, function(resp){
      $('#area_referencias').append(resp);
    });
  }

  function borrar_dato(id)
  {
    $('#area_dato_'+id).remove();
    cant_datos--;
  }

  function borrar_referencia(id)
  {
    if($('#ref_id_'+id).val() != "")
    {
      $('#area_referencia_'+id).hide();
      $('#ref_est_id_'+id).val(<?=REFERENCIA_ELIMINAR?>);
    }
    else
    {
      $('#area_referencia_'+id).remove();
      cant_referencias--;
    }
  }

  /*
  function buscar()
  {
    $('#area_resultados').html("<img src='<?=base_url('assets/images/loading.png')?>' width='50px'>");

    $.ajax({
      type: 'POST',
      url: SITE_URL+'productos/buscar_posiciones_ajax',
      data: jQuery.param({buscar: $('#buscar').val()}),
      dataType: 'json',
      success: function(data) {
        var htmlData = "";
        if(data.error == false)
        {
          $.each(data.resultados, function(i, item) {
            htmlData += "<b>"+item.ara_code+"</b> - "+item.ara_desc+"<br>";
          });
        }
        else
        {
          htmlData += data.data;
        }

        $('#area_resultados').html(htmlData);
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        $('#area_resultados').html(htmlData);
      }
    });
  }
  */
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

  $('#form_nuevo').submit(function(event){
    var hay_posicion = false;
    if($('#arancel').val() == "")
    {
      $('#form_nuevo input[name="arancel[]"]').each(function() {
        if($(this).val() != "")
        {
          hay_posicion = true;
        }
      });
    }
    else
    {
      hay_posicion = true;
    }

    var hay_mail = false;
    $('#form_nuevo input[name="mail[]"]').each(function() {
      if($(this).val() != "")
      {
        hay_mail = true;
      }
    });

    var hay_idioma = false;
    $('#form_nuevo select[name="idioma[]"]').each(function() {
      if($(this).val() != "")
      {
        hay_idioma = true;
      }
    });

    if(hay_posicion == false)
    {
      $('#area_error_arancel').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?=$error_arancel?></div>');
    }
    else
    {
      $('#area_error_arancel').html("");
    }

    if(hay_mail == false)
    {
      $('#area_error_mail').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?=$error_mail?></div>');
    }
    else
    {
      $('#area_error_mail').html("");
    }

    if(hay_idioma == false)
    {
      $('#area_error_idioma').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?=$error_idioma?></div>');
    }
    else
    {
      $('#area_error_idioma').html("");
    }

    if($('#descripcion').val() == "")
    {
      $('#area_error_descripcion').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?=$error_descripcion?></div>');
    }
    else
    {
      $('#area_error_descripcion').html("");
    }

    if($('#descripcion').val() == "" || hay_posicion == false)
    {
      event.preventDefault();
      return false;
    }
    else
    {
      return true;
    }
  });

  $('.reportar').tooltip();
</script>

</body>
</html>