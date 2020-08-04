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
				    <h3 class="panel-title"><?=mostrar_palabra(35, $palabras)?></h3>
				  </div>
				  <div class="panel-body">
				    <form class="form" action="<?=site_url()?>resultados/filtros" method="POST">

              <!--<input type="hidden" name="enviar" value="enviar">-->
              
              <div class="form-group">
                <label for="search" class="control-label"><?=mostrar_palabra(36, $palabras)?></label>
                
                  <input class="form-control" name="search" id="search" value="<?=$search?>">
                
              </div>

              <div class="form-group">
                <label for="productos" class="control-label"><?=mostrar_palabra(227, $palabras)?></label>
              
                  <select class="form-control" name="productos" id="productos">
                    <option value="si" <?php if($productos=="si" || $productos=="") echo "selected"?>><?=mostrar_palabra(216, $palabras)?></option>
                    <option value="no" <?php if($productos=="no") echo "selected"?>><?=mostrar_palabra(217, $palabras)?></option>
                  </select>
               
              </div>

              <div class="form-group">
                <label for="servicios" class=" control-label"><?=mostrar_palabra(226, $palabras)?></label>
               
                  <select class="form-control" name="servicios" id="servicios">
                    <option value="si" <?php if($servicios=="si" || $servicios=="") echo "selected"?>><?=mostrar_palabra(216, $palabras)?></option>
                    <option value="no" <?php if($servicios=="no") echo "selected"?>><?=mostrar_palabra(217, $palabras)?></option>
                  </select>
             
              </div>

              <div class="form-group">
                <label for="ofertas" class="control-label"><?=mostrar_palabra(19, $palabras)?></label>
                
                  <select class="form-control" name="ofertas" id="ofertas">
                    <option value="si" <?php if($ofertas=="si" || $ofertas=="") echo "selected"?>><?=mostrar_palabra(216, $palabras)?></option>
                    <option value="no" <?php if($ofertas=="no") echo "selected"?>><?=mostrar_palabra(217, $palabras)?></option>
                  </select>
                
              </div>

              <div class="form-group">
                <label for="demandas" class="control-label"><?=mostrar_palabra(20, $palabras)?></label>
               
                  <select class="form-control" name="demandas" id="demandas">
                    <option value="si" <?php if($demandas=="si" || $demandas=="") echo "selected"?>><?=mostrar_palabra(216, $palabras)?></option>
                    <option value="no" <?php if($demandas=="no") echo "selected"?>><?=mostrar_palabra(217, $palabras)?></option>
                  </select>
              
              </div>

              <div class="form-group">
                <label for="favoritos" class="control-label"><?=mostrar_palabra(37, $palabras)?></label>
                
                  <select class="form-control" name="favoritos" id="favoritos">
                    <option value="si" <?php if($favoritos=="si") echo "selected"?>><?=mostrar_palabra(216, $palabras)?></option>
                    <option value="no" <?php if($favoritos=="no" || $favoritos=="") echo "selected"?>><?=mostrar_palabra(217, $palabras)?></option>
                  </select>
                
              </div>

              <div class="form-group">
                <label for="arancel" class="control-label"><?=mostrar_palabra(206, $palabras)?></label>
              
                  <select class="form-control" name="arancel" id="arancel">
                    <option value=""><?=mostrar_palabra(159, $palabras)?></option>
                    <?php
                    foreach ($aranceles as $arancel)
                    {
                      $selected = "";
                      if($arancel['ara_id'] == $arancel_aux)
                      {
                        $selected = "selected";
                      }
                      echo "<option value='".$arancel['ara_id']."' ".$selected.">".$arancel['ara_code']." - ".$arancel['ara_desc']."</option>";
                    }
                    ?>
                  </select>
               
              </div>

              <div class="form-group">
                <label for="pais" class="control-label"><?=mostrar_palabra(2, $palabras)?></label>
                
                  <select class="form-control" name="pais" id="pais" onchange="cargar_ciudades(this.value);">
                    <option value=""><?=mostrar_palabra(161, $palabras)?></option>
                    <?php
                    foreach ($paises as $pais)
                    {
                      $selected = "";
                      if($pais_aux == $pais['ctry_code'])
                      {
                        $selected = "selected";
                      }
                      echo "<option value='".$pais['ctry_code']."' ".$selected.">".$pais['ctry_nombre']."</option>";
                    }
                    ?>
                  </select>
                
              </div>

              <div class="form-group">
                <label for="ciudad" class="control-label"><?=mostrar_palabra(299, $palabras)?></label>
                
                  <select class="form-control" name="ciudad" id="ciudad">
                    <option value=''><?=mostrar_palabra(300, $palabras)?></option>
                    <?php
                    if($ciudades)
                    {
                      foreach ($ciudades as $ciudad)
                      {
                        $selected = "";
                        if($ciudad_aux == $ciudad['city_id'])
                        {
                          $selected = "selected";
                        }

                        echo "<option value='".$ciudad['city_id']."' ".$selected.">";
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

              <div class="form-group">
                <label for="orden" class="control-label"><?=mostrar_palabra(218, $palabras)?></label>
                
                  <select class="form-control" name="orden" id="orden">
                    <option value="acceso" <?php if($orden=="acceso") echo "selected"?>><?=mostrar_palabra(219, $palabras)?></option>
                    <option value="creacion" <?php if($orden=="creacion" || $orden=="") echo "selected"?>><?=mostrar_palabra(220, $palabras)?></option>
                    <option value="arancel" <?php if($orden=="arancel") echo "selected"?>><?=mostrar_palabra(157, $palabras)?></option>
                    <option value="pais" <?php if($orden=="pais") echo "selected"?>><?=mostrar_palabra(2, $palabras)?></option>
                  </select>
                
              </div>

              <div class="form-group">
                  <button type="submit" class="btn btn-danger" value="enviar" name="enviar"><?=mostrar_palabra(17, $palabras)?></button>
                  <button type="submit" class="btn btn-default" value="reset" name="enviar"><?=mostrar_palabra(298, $palabras)?></button>
              </div>

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

<script type="text/javascript">
function cargar_ciudades(ctry_code)
{
  $.get('<?=site_url()?>productos/cargar_ciudades_noajax/'+ctry_code, function(resp){
    $('#ciudad').html("<option value=''><?=mostrar_palabra(165, $palabras)?></option>"+resp);
  });
}
</script>

</body>
</html>