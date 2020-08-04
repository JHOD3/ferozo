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
				    <img src="<?=base_url('assets/images/cobranza/icono2.png')?>" width="80px">
				  </div>
				  <div class="media-body texto-rojo">
				    <div class="media-heading-cobranza"><?=mostrar_palabra(680, $palabras)?></div>
				  </div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12" style="margin-bottom:20px;">
				<p class=""><?=mostrar_palabra(670, $palabras)?></p> 
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

				<form action="<?=site_url('cobranzas/joinOperation')?>" method="POST" enctype="multipart/form-data">
				    <div class="form-group">
				      <label for="codigo"><?=mostrar_palabra(671, $palabras)?>:</label>
				      <input type="text" class="form-control" id="codigo" placeholder="XXXX-XXXX-XXXX-XXXX" value="<?php echo set_value('codigo'); ?>" name="codigo" required>
				    </div>
					 <?php if(!empty(form_error('codigo'))) { ?> <span class="error"><?php echo form_error('codigo');?></span><?php } ?>
					 
				    <a href="<?=site_url('cobranzas/options')?>" class="btn btn-default"><?=mostrar_palabra(29, $palabras)?></a>
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