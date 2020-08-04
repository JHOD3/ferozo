<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<body>

<!-- Header -->
<?php
$this->load->view('templates/analytics');
$this->load->view('muestras/templates/header');
?>
<!-- /Header -->
	
<?php
$this->load->view('muestras/templates/sidebar_left');
?>

<!-- Content -->
<main class="content fondo-derecha">

	<!-- Features -->
	<section class="container-fluid">
		
		<div class="row">

			<div class="col-md-12 col-lg-6">
				<div class="panel panel-danger">
				  <div class="panel-heading">
				    <h3 class="panel-title"><?=mostrar_palabra(8, $palabras)?></h3>
				  </div>
				  <div class="panel-body">
            <div id="area_mensajes">
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
            </div>

				    <form method="POST" action="<?=site_url()?>user/profile" enctype="multipart/form-data">

              <div class="form-group col-xs-12 col-sm-6">
                <div id="preview">
                <?php
                  echo "<img id='img_user' src='".base_url()."images/usuarios/".$usr_imagen."' class='img-circle img-user img-responsive'>";
                ?>
                </div>
                <input type="file" name="imagen" id="imagen" class="input-class" accept="image/*" style="display:none" capture/>
                <input type="hidden" name="imagen_ant" id="imagen_ant" value="<?=$usr_imagen?>"/>
                <input type="hidden" name="nueva_imagen" id="nueva_imagen" value=""/>
                <a href='#' id='cambiar_img_user' class='btn btn-danger'><?=mostrar_palabra(304, $palabras)?></a>
                <?php
                  if($usr_imagen != "perfil.jpg")
                  {
                    echo '<button type="button" onclick="eliminar_imagen_perfil()" class="btn btn-danger" id="btn-eliminar-foto"><i class="fas fa-trash"></i></button>';
                  }
                ?>
              </div>

              <div class="form-group col-xs-12 col-sm-6" style="text-align:center;">
                <div id="qr"></div>
              </div>

              <div style="clear:both;"></div>

              <hr style="border-color:#980521; clear:both;">

              <div class="form-group <?php if(form_error('apellido')) echo 'has-error';?>">
                <label for="apellido"><i class='fa fa-user fa-lg texto-bordo2'></i> <?=mostrar_palabra(297, $palabras)?></label>
                <?php echo form_error('apellido'); ?>
                <input type='text' class='form-control' name='apellido' placeholder='<?=mostrar_palabra(10, $palabras)?>' value='<?=$user['usr_apellido']?>'>
                <?php echo form_error('nombre'); ?>
                <input type='text' class='form-control' name='nombre' placeholder='<?=mostrar_palabra(11, $palabras)?>' value='<?=$user['usr_nombre']?>'>
              </div>

              <div class="form-group <?php if(form_error('empresa')) echo 'has-error';?>">
                <label for="empresa"><i class='fa fa-building fa-lg texto-bordo2'></i> <?=mostrar_palabra(13, $palabras)?></label>
                <?php echo form_error('empresa'); ?>
                <input type='text' class='form-control' name='empresa' placeholder='<?=mostrar_palabra(289, $palabras)?>' value='<?=$user['usr_empresa']?>'>
              </div>

              <div class="form-group <?php if(form_error('pais')) echo 'has-error';?>">
                <label for="ubicacion" class='control-label'><i class='fa fa-map-marker-alt fa-lg texto-bordo2'></i> <?=mostrar_palabra(14, $palabras)?></label>
                <?php echo form_error('pais'); ?>
                <select class="form-control" name="pais" id="pais" onchange="cargar_ciudades(this.value);">
                  <option selected disabled style='display:none;'><?=mostrar_palabra(161, $palabras)?></option>
                  <?php
                  foreach ($paises as $pais)
                  {
                    if($pais['ctry_code'] == $user['usr_pais'])
                      echo "<option value='".$pais['ctry_code']."' selected>".$pais['ctry_nombre']."</option>";
                    else
                      echo "<option value='".$pais['ctry_code']."'>".$pais['ctry_nombre']."</option>";
                  }
                  ?>
                </select>
                <?php echo form_error('ciudad'); ?>
                <select class="form-control" name="ciudad" id="ciudad">
                  <option selected disabled style='display:none;'><?=mostrar_palabra(300, $palabras)?></option>
                  <?php
                  foreach ($ciudades as $ciudad)
                  {
                    if($ciudad['city_id'] == $user['usr_provincia'])
                      echo "<option value='".$ciudad['city_id']."' selected>".$ciudad['city_nombre']."</option>";
                    else
                      echo "<option value='".$ciudad['city_id']."'>".$ciudad['city_nombre']."</option>";
                  }
                  ?>
                </select>
                <input type='text' class='form-control' name='cp' placeholder='<?=mostrar_palabra(130, $palabras)?>' value='<?=$user['usr_cp']?>'>
                <!--<input type='text' class='form-control' name='localidad' placeholder='Localidad' value='<?=$user['usr_ciudad']?>'>-->
                <input type='text' class='form-control' name='direccion' placeholder='<?=mostrar_palabra(131, $palabras)?>' value='<?=$user['usr_direccion']?>'>
              </div>

              <?php
              $cant_datos = 0;
              foreach ($tipo_datos as $key_td => $tipo_dato)
              {
                echo "<div class='form-group' id='area_datos_".$tipo_dato['td_id']."'>";
                  echo "<label><i class='fa ".$tipo_dato['td_icono']." fa-lg texto-bordo2'></i> ".$tipo_dato['td_desc']."</label> <button type='button' onclick='nuevo_dato(".$tipo_dato['td_id'].")' class='btn btn-danger btn-xs pull-right flip'><i class='fa fa-plus'></i></button>";

                  foreach ($tipo_dato['datos'] as $key_dato => $dato)
                  {
                    $cant_datos++;
                    echo "<div id='area_dato_".$cant_datos."'>";
                      if(count($tipo_dato['categorias']) > 0)
                      {
                        /*
                        echo "<div class='col-xs-5'>";
                          echo "<select class='form-control' name='dato_ctd[]'>";
                            foreach ($tipo_dato['categorias'] as $categoria)
                            {
                              if($dato['ctd_id'] == $categoria['ctd_id'])
                                echo "<option value='".$categoria['ctd_id']."' selected>".$categoria['ctd_desc']."</option>";
                              else
                                echo "<option value='".$categoria['ctd_id']."'>".$categoria['ctd_desc']."</option>";
                            }
                          echo "</select>";
                        echo "</div>";
                        echo "<div class='col-xs-6'>";
                          echo "<input type='text' class='form-control' name='dato_desc[]' value='".$dato['ud_descripcion']."'>";
                        echo "</div>";
                        */
                        echo '<div class="input-group">';
                          echo '<div class="input-group-btn">';
                            echo "<select class='btn btn-default dropdown-toggle' name='dato_ctd[]' style='height:35px;'>";
                            foreach ($tipo_dato['categorias'] as $categoria)
                            {
                              if($dato['ctd_id'] == $categoria['ctd_id'])
                                echo "<option value='".$categoria['ctd_id']."' selected>".$categoria['ctd_desc']."</option>";
                              else
                                echo "<option value='".$categoria['ctd_id']."'>".$categoria['ctd_desc']."</option>";
                            }
                          echo "</select>";
                          echo '</div><!-- /btn-group -->
                          <input type="text" class="form-control" name="dato_desc[]" value="'.$dato['ud_descripcion'].'">
                          <span class="input-group-btn">
                            <button class="btn" type="button" onclick="borrar_dato('.$cant_datos.')"><i class="fa fa-minus"></i></button>
                          </span>';
                        echo '</div><!-- /input-group -->';
                      }
                      else
                      {
                        echo "<input type='hidden' class='form-control' name='dato_ctd[]' value='0'>";
                        /*
                        echo "<div class='col-xs-11'>";
                          echo "<input type='text' class='form-control' name='dato_desc[]' value='".$dato['ud_descripcion']."'>";
                        echo "</div>";
                        */
                        echo '<div class="input-group">';
                          echo '<input type="text" class="form-control" name="dato_desc[]" value="'.$dato['ud_descripcion'].'">
                          <span class="input-group-btn">
                            <button class="btn" type="button" onclick="borrar_dato('.$cant_datos.')"><i class="fa fa-minus"></i></button>
                          </span>';
                        echo '</div><!-- /input-group -->';
                      }
                      echo "<input type='hidden' class='form-control' name='dato_td[]' value='".$tipo_dato['td_id']."'>";
                      /*
                      echo "<div class='col-xs-1'>";
                        echo "<button type='button' class='btn' onclick='borrar_dato(".$cant_datos.")'><i class='fa fa-minus'></i></button>";
                      echo "</div>";
                      */
                    echo "</div>";
                  }
                  echo "<div class='clearfix'></div>";
                echo "</div>";
              }
              echo "<script>cant_datos=".$cant_datos.";</script>";

              echo '<br>';

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
                          echo '<input type="email" class="form-control" name="ref_mail[]" value="'.$referencia['ref_mail'].'" readonly="readonly" placeholder="'.mostrar_palabra(4, $palabras).'" placeholder="'.mostrar_palabra(4, $palabras).'">';
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

                echo '<br>';
              ?>


              <div class="form-group <?php if(form_error('mail')) echo 'has-error';?>">
                <label for="nombre"><?=mostrar_palabra(12, $palabras)?></label>
                <?php echo form_error('mail'); ?>
                <input type='text' class='form-control' name='mail' placeholder='Email de registro' value='<?=$user['usr_mail']?>' disabled>
              </div>

              <div class="form-group <?php if(form_error('idioma')) echo 'has-error';?>">
                <label for="idioma" class='control-label'><i class='fa fa-language fa-lg texto-bordo2'></i> <?=mostrar_palabra(132, $palabras)?></label>
                <?php echo form_error('idioma'); ?>
                <select class="form-control" name="idioma" id="idioma">
                  <option selected disabled style='display:none;'><?=mostrar_palabra(3, $palabras)?></option>
                  <?php
                  foreach ($idiomas as $idioma)
                  {
                    if($idioma['idi_code'] == $user['idi_code'])
                      echo "<option value='".$idioma['idi_code']."' selected>".ucfirst($idioma['idi_desc'])."</option>";
                    else
                      echo "<option value='".$idioma['idi_code']."'>".ucfirst($idioma['idi_desc'])."</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group <?php if(form_error('publica')) echo 'has-error';?>">
                <label for="nombre"><?=mostrar_palabra(16, $palabras)?></label><br>
                <?php echo form_error('publica'); ?>
                <input type='checkbox' name='publica' value='1' <?php if($user['usr_publica'] == 1) echo "checked";?>>
                <?=mostrar_palabra(264, $palabras)?>
              </div>

              <button type="submit" class="btn btn-danger"><?=mostrar_palabra(17, $palabras)?></button>

            </form>
				  </div>
				</div>


			</div>

		</div>
	</section>
	<!-- /Features -->

</main>

<?php
$this->load->view('templates/footer');
?>

<script src="<?=base_url()?>assets/js/jquery-qrcode-0.14.0.min.js"></script>

<script type="text/javascript">
var cant_datos = 0;
var cant_referencias = <?=$cant_referencias?>;

function cargar_ciudades(ctry_code)
{
  $.get('<?=site_url()?>productos/cargar_ciudades_noajax/'+ctry_code, function(resp){
    $('#ciudad').html(resp);
  });
}

function nuevo_dato(td_id)
{
  cant_datos++;
  $.get('<?=site_url()?>user/nuevo_dato_noajax/'+td_id+'/'+cant_datos, function(resp){
    $('#area_datos_'+td_id).append(resp);
  });
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

function eliminar_imagen_perfil()
{
  $('#btn-eliminar-foto').button('loading');
  $('#area_mensajes').html("");

  $.ajax({
    url: SITE_URL+'user/eliminar_imagen_ajax',
    dataType: 'json',
    success: function(data) {
      if(data.error == false)
      {
        location.reload();
      }
      else
      {
        htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
        htmlData += data.data;
        htmlData += '</div>';
        $('#area_mensajes').html(htmlData);
      }
      $('#btn-eliminar-foto').button('reset');
    },
    error: function(x, status, error){
      var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
      htmlData += "An error occurred: " + status + " nError: " + error;
      htmlData += '</div>';
      $('#area_mensajes').html(htmlData);
      $('#btn-eliminar-foto').button('reset');
    }
  });
}


function ver_edit(id)
{
  $('#prod_'+id+' .media-right').show();
}

function sacar_edit(id)
{
  $('#prod_'+id+' .media-right').hide();
}

$("#cambiar_img_user").click(function(e){
  e.preventDefault();
  $("#imagen").trigger("click");
});

$("#imagen").change(function(){
  var file = $("#imagen")[0].files[0];            
  $("#preview").empty();
  displayAsImage3(file, "preview");
  $('#nueva_imagen').val(1);
});

function displayAsImage3(file, containerid)
{
  if (typeof FileReader !== "undefined") {
    var container = document.getElementById(containerid),
        img = document.createElement("img"),
        reader;
    container.appendChild(img);
    reader = new FileReader();
    reader.onload = (function (theImg) {
      return function (evt) {
        theImg.src = evt.target.result;
      };
    }(img));
    reader.readAsDataURL(file);
  }
}


var options = {
            // render method: 'canvas', 'image' or 'div'
            render: 'canvas',

            // version range somewhere in 1 .. 40
            minVersion: 1,
            maxVersion: 40,

            // error correction level: 'L', 'M', 'Q' or 'H'
            ecLevel: 'H',

            // offset in pixel if drawn onto existing canvas
            left: 0,
            top: 0,

            // size in pixel
            size: 150,

            // code color or image element
            fill: '#000',

            // background color or image element, null for transparent background
            background: '#FFF',

            // content
            text: "<?=site_url()?>user_free/index/<?=$usr_id?>",

            // corner radius relative to module width: 0.0 .. 0.5
            radius: 0,

            // quiet zone in modules
            quiet: 1,

            // modes
            // 0: normal
            // 1: label strip
            // 2: label box
            // 3: image strip
            // 4: image box
            mode: 0,

            mSize: 0.1,
            mPosX: 0.5,
            mPosY: 0.5,

            label: 'no label',
            fontname: 'sans',
            fontcolor: '#000',

            image: null
        };

        $('#qr').qrcode(options);
</script>

</body>
</html>