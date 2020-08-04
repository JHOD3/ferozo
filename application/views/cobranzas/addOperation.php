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
<main class="content">

	<!-- Features -->
	<section class="container-fluid">
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h3 class="panel-title"><?=mostrar_palabra(646, $palabras)?></h3>
					</div>
				</div>
			</div>

		</div>
	</section>
	<!-- /Features -->

	<!-- Lead -->
	<section class="container-fluid">
		<div class="row space-after">
			<div class="col-md-12">
				<div class="media">
				  <div class="media-left media-middle">
				    <img src="<?=base_url('assets/images/cobranza/icono1.png')?>" width="80px">
				  </div>
				  <div class="media-body">
				    <div class="media-heading-cobranza"><?=mostrar_palabra(672, $palabras)?></div>
				  </div>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-sm-12" style="margin-bottom:20px;">
				<p class=""><?=mostrar_palabra(659, $palabras)?></p> 
			</div>
		</div>

		
		<div class="row">
			<div class="col-md-12 col-lg-6">
				<?php if($this->session->flashdata('error') != "") { ?>
				  <div class="alert alert-danger">
					<?php echo $this->session->flashdata('error'); ?>
				  </div>
				<?php } ?>
				<?php if($this->session->flashdata('success') != "") { ?>
				  <div class="alert alert-success">
					<?php echo $this->session->flashdata('success'); ?>
				  </div>
				<?php } ?>

				<form action="<?=site_url('cobranzas/addOperation')?>" method="POST" enctype="multipart/form-data">
				    <div class="form-group">
				      <label for="email"><?=mostrar_palabra(673, $palabras)?>:</label>
				      <input type="text" class="form-control" id="email" placeholder="" value="<?php echo set_value('name'); ?>" name="name" required>
				    </div>
					<?php if((form_error('name'))) { ?> <span class="error"><?php echo form_error('name');?></span><?php } ?>
					 
					<div class="form-group">
				      <label for="email"><?=mostrar_palabra(674, $palabras)?>:</label>
				      <textarea  class="form-control" placeholder="" name="description" ><?php echo set_value('description'); ?></textarea>
				    </div>

				    <div class="form-group">
				      <label for="email">Detalle documentación obligatoria y opcional:</label>
				      <textarea  class="form-control" placeholder="" name="detalle_documentacion" ><?php echo set_value('detalle_documentacion'); ?></textarea>
				    </div>

				    <div class="form-group">
				      <label for="email">Acciones requeridas (inspección preembarque):</label>
				      <textarea  class="form-control" placeholder="" name="acciones_requeridas" ><?php echo set_value('acciones_requeridas'); ?></textarea>
				    </div>

				    <?php
				    echo '<div class="form-group">
			                <label for="moneda0">'.mostrar_palabra(630, $palabras).'</label>
			                <div class="input-group" style="width:100%;">
			                  <select class="form-control" name="moneda" id="moneda">';
			                    foreach ($monedas as $moneda)
				                {
				                    echo '<option value="'.$moneda['mon_code'].'">'.$moneda['mon_code'].' - '.$moneda['mon_simbolo'].'</option>';
				                }
			                  echo '</select>
			                </div>
			            </div>';
				    ?>

				    <hr>

					<div class="row">
						<div class="col-md-12">
						  	<?php
							echo '<div class="row">';
								echo '<div class="col-xs-12">';
									echo form_label('Terminos y condiciones', '', array('class' => 'control-label'));
									echo '<textarea class="form-control" rows="10" readonly="readonly"></textarea>';
								echo '</div>';
								echo '<div class="col-xs-12">';
									input_checkbox('Acepto los terminos y condiciones', 'tyc', 'tyc', '1');
								echo '</div>';
							echo '</div>';
						  	?>
						</div>
					</div>
					 
				    <a href="<?=site_url('cobranzas/user_type')?>" class="btn btn-default"><?=mostrar_palabra(29, $palabras)?></a>
				    <button type="submit" class="btn btn-danger"><?=mostrar_palabra(316, $palabras)?></button>
				</form>
		  	</div>
		</div>


	</section>
	<!-- /Lead -->

</main>

<?php
$this->load->view('templates/footer');
?>

</body>
</html>