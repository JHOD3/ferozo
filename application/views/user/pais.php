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
	

<!-- Content -->
<main class="content">

	<!-- Features -->
	<section class="container-fluid">
		
		<div class="row">
			<?php
			//$this->load->view('templates/sidebar_left');
			?>
			<div class="col-md-6 col-md-push-2">
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

				    <form method="POST" action="<?=site_url()?>user/pais" enctype="multipart/form-data">

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
              </div>

              <button type="submit" class="btn btn-danger"><?=mostrar_palabra(17, $palabras)?></button>

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

<?php
$this->load->view('templates/footer');
?>

</body>
</html>