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
                echo mostrar_palabra(33, $palabras);
              }
              else
              {
                echo mostrar_palabra(34, $palabras);
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

				    <form method="POST" action="<?=site_url()?>productos/edit/<?=$producto['prod_id']?>" enctype='multipart/form-data'>

              <div class="form-group <?php if(form_error('arancel')) echo 'has-error';?>">
                <label for="arancel"><i class="fa fa-code fa-lg texto-bordo2"></i> <?=mostrar_palabra(255, $palabras)?></label>
                <?php echo form_error('arancel'); ?>
                <button type='button' data-toggle="modal" data-target="#modal-search" class='btn btn-danger btn-xs pull-right flip'><i class='fa fa-search'></i></button>
                <!--<button type="button" data-toggle="modal" data-target="#modal-search" class="btn btn-danger btn-xs pull-right flip"><i class="fa fa-search"></i></button>-->
                <div class="input-group">
                  <!--<input type="text" class="form-control" id="buscar" name="buscar" placeholder="Search for...">-->
                  <select data-placeholder="<?=mostrar_palabra(245, $palabras)?>..." class="chosen-select form-control" name="arancel" id="arancel">
                    <option value=""></option>
                    <?php
                    echo "<option value='".$producto['ara_id']."' selected>".$producto['ara_code']." - ".$producto['ara_desc']."</option>\n";
                    /*
                    foreach ($secciones as $seccion)
                    {
                      echo "<optgroup label='".$seccion['sec_desc']."'>\n";
                      foreach ($seccion['aranceles'] as $arancel)
                      {
                        $selected = "";
                        if($producto['ara_id'] == $arancel['ara_id'])
                        {
                          $selected = "selected";
                        }
                        echo "<option value='".$arancel['ara_id']."' ".$selected.">".$arancel['ara_code']." - ".$arancel['ara_desc']."</option>\n";
                      }
                      echo "</optgroup>\n";
                    }
                    */
                    ?>
                  </select>
                  <!--
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="button" onclick="nuevo_arancel()"><i class="fa fa-plus"></i></button>
                  </span>
                  -->
                </div>
              </div>

              <div class="cortar-texto" style="margin-bottom:10px; font-size:12px;"><i class="fa fa-question-circle fa-lg"></i> <?=mostrar_palabra(338, $palabras)?></div>

              <div class="form-group <?php if(form_error('pais')) echo 'has-error';?>">
                <label for="pais"><i class="fa fa-map-marker-alt fa-lg texto-bordo2"></i> <?=mostrar_palabra(2, $palabras)?></label>
                <?php echo form_error('pais'); ?>
                <select class="form-control" name="pais" id="pais" onchange="cargar_ciudades(this.value);">
                  <option selected disabled style='display:none;'><?=mostrar_palabra(161, $palabras)?></option>
                  <?php
                  foreach ($paises as $pais)
                  {
                    if($pais['ctry_code'] == $producto['ctry_code'])
                      echo "<option value='".$pais['ctry_code']."' selected>".$pais['ctry_nombre']."</option>";
                    else
                      echo "<option value='".$pais['ctry_code']."'>".$pais['ctry_nombre']."</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group <?php if(form_error('ciudad')) echo 'has-error';?>">
                <label for="ciudad"><i class="fa fa-map-marker-alt fa-lg texto-bordo2"></i> <?=mostrar_palabra(32, $palabras)?></label>
                <?php echo form_error('ciudad'); ?>
                <select class="form-control" name="ciudad" id="ciudad">
                  <?php
                  foreach ($ciudades as $ciudad)
                  {
                    if($ciudad['city_id'] == $producto['city_id'])
                    {
                      echo "<option value='".$ciudad['city_id']."' selected>";
                      if($ciudad['city_nombre'] == $ciudad['toponymName'])
                        echo $ciudad['city_nombre'];
                      else
                        echo $ciudad['city_nombre'] ." / ".$ciudad['toponymName'];
                      echo "</option>";
                    }
                    else
                    {
                      echo "<option value='".$ciudad['city_id']."'>";
                      if($ciudad['city_nombre'] == $ciudad['toponymName'])
                        echo $ciudad['city_nombre'];
                      else
                        echo $ciudad['city_nombre'] ." / ".$ciudad['toponymName'];
                      echo "</option>";
                    }
                  }
                  ?>
                </select>
              </div>


              <div class="form-group <?php if(form_error('descripcion')) echo 'has-error';?>">
                <label for="descripcion"><i class="fa fa-pencil-alt fa-lg texto-bordo2"></i> <?=mostrar_palabra(27, $palabras)?></label> <small id="caracteres">255 <?=mostrar_palabra(26, $palabras)?></small>
                <?php 
                echo form_error('descripcion'); 

                $placeholder = mostrar_palabra(85, $palabras);
                if($tipo_producto['tp_id'] == TP_OFERTA)
                {
                  $placeholder = mostrar_palabra(83, $palabras);
                }
                ?>
                <textarea class="form-control" rows="3" id="descripcion" name="descripcion" maxlength="255" onKeyUp="cuenta_caracteres()" placeholder="<?=$placeholder?>"><?=$producto['prod_descripcion']?></textarea>
              </div>


              <div class="form-group <?php if(form_error('mail')) echo 'has-error';?>" id="area_mails">
                <label for="mail"><i class="fa fa-envelope fa-lg texto-bordo2"></i> <?=mostrar_palabra(4, $palabras)?></label> <button type='button' onclick='nuevo_mail()' class="btn btn-danger btn-xs pull-right flip"><i class="fa fa-plus"></i></button>
                <?php
                echo form_error('mail[]');

                $key_mail = 0;
                foreach ($producto_mails as $key_mail => $mail)
                {
                  echo "<div id='area_mail_".$key_mail."'>";
                    echo "<div class='input-group'>";
                      echo "<input type='email' class='form-control' name='mail[]' placeholder='Email' value='".$mail['mail_direccion']."'>";
                      echo "<div class='input-group-addon' style='cursor:pointer;' onclick='borrar_mail(".$key_mail.")'>";
                        echo "<i class='fa fa-minus'></i>";
                      echo "</div>";
                    echo "</div>";
                  echo "</div>";
                }
                echo "<script>cant_mails=".$key_mail.";</script>";
                ?>
              </div>


              <div class="form-group <?php if(form_error('idioma')) echo 'has-error';?>" id="area_idiomas">
                <label for="idioma"><i class="fa fa-language fa-lg texto-bordo2"></i> <?=mostrar_palabra(3, $palabras)?></label> <button type='button' onclick='nuevo_idioma()' class='btn btn-danger btn-xs pull-right flip'><i class='fa fa-plus'></i></button>
                <?php
                echo form_error('idioma[]'); 

                $key_idioma = 0;
                foreach ($producto_idiomas as $key_idioma => $prod_idioma)
                {
                  echo "<div id='area_idioma_".$key_idioma."'>";
                    echo "<div class='input-group'>";
                      echo "<select class='form-control' name='idioma[]'>";
                        foreach ($idiomas as $idioma)
                        {
                          if($prod_idioma['idi_code'] == $idioma['idi_code'])
                            echo "<option value='".$idioma['idi_code']."' selected>".ucfirst($idioma['idi_desc'])."</option>";
                          else
                            echo "<option value='".$idioma['idi_code']."'>".ucfirst($idioma['idi_desc'])."</option>";
                        }
                      echo "</select>";
                      echo "<div class='input-group-addon' style='cursor:pointer;' onclick='borrar_idioma(".$key_idioma.")'>";
                        echo "<i class='fa fa-minus'></i>";
                      echo "</div>";
                    echo "</div>";
                  echo "</div>";
                }
                echo "<script>cant_idiomas=".$key_idioma.";</script>";
                ?>
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

              <div class="col-xs-12" style="margin-bottom:15px;">
              <?php
              foreach ($producto_imagenes as $key => $imagen)
              {
                echo "<div class='col-xs-3' id='imagen_vieja_".$key."' style='position:relative; margin-bottom:10px; background:#FFF; border:1px solid #CCC; margin:0px 2px;'>";
                  echo "<img src='".base_url('images/productos/'.$imagen['pi_ruta'])."' class='img-responsive'>";
                  echo "<button type='button' style='position:absolute; top:0px; right:0px;' class='btn btn-danger' onclick='eliminar_imagen(".$imagen['pi_id'].", ".$key.")'><i class='fa fa-trash'></i></button>";
                echo "</div>";
              }
              ?>
              </div>

              <input type="hidden" value="" name="imagenes_borrar" id="imagenes_borrar">

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
              <a href="<?=site_url("productos/delete/".$producto['prod_id'])?>" class="btn btn-warning"><?=mostrar_palabra(234, $palabras)?></a>
              <a href="<?=site_url()?>productos/index/<?=$tipo_producto['tp_id']?>" class="btn btn-default"><?=mostrar_palabra(29, $palabras)?></a>

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
var cant_idiomas = 0;
var cant_mails = 0;
var cant_imagenes = 1;
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

  function borrar_mail(id)
  {
    $('#area_mail_'+id).remove();
    cant_mails--;
  }

  function borrar_imagen(id)
  {
    $('#area_imagen_'+id).remove();
  }

  function borrar_idioma(id)
  {
    $('#area_idioma_'+id).remove();
    cant_idiomas--;
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

  function eliminar_imagen(id, num)
  {
    $('#imagen_vieja_'+num).remove();
    if($('#imagenes_borrar').val() == "")
    {
      $('#imagenes_borrar').val( id );
    }
    else
    {
      $('#imagenes_borrar').val( $('#imagenes_borrar').val()+"|"+id );
    }
  }

  function seleccion_detallada()
  {
    var htmlData = "<option value='"+$('#arancel_modal option:selected').val()+"' selected>"+$('#arancel_modal option:selected').text()+"</option>";
    $('#arancel').html( htmlData );
    $('#arancel').val( $('#arancel_modal').val() ).trigger("chosen:updated");;
    $('#modal-search').modal('hide');
  }


function ver_edit(id)
{
  $('#prod_'+id+' .media-right').show();
}

function sacar_edit(id)
{
  $('#prod_'+id+' .media-right').hide();
}

function cuenta_caracteres()
{
  var num = 255 - $('#descripcion').val().length;
  $('#caracteres').html(num + " caracteres");
}

$('.reportar').tooltip();

cuenta_caracteres();
</script>

</body>
</html>