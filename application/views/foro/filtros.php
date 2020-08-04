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
				    <form class="form" action="<?=site_url('foro/filtros')?>" method="POST">

              <!--<input type="hidden" name="enviar" value="enviar">-->
              
              <div class="form-group">
                <label for="search" class="control-label"><?=mostrar_palabra(36, $palabras)?></label>
                
                  <input class="form-control" name="search" id="search" value="<?=$search?>">
                
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

</body>
</html>