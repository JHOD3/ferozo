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
		<div class="row">
			<div class="col-sm-12 col-md-6">
				<p class="lead" style="padding:40px 0px 20px;"><?=mostrar_palabra(647, $palabras)?></p>
				<!-- <p class="text-center"><?=mostrar_palabra(647, $palabras)?></p>  -->
				<a class="btn btn-rojo2" href="<?=site_url('cobranzas/options')?>"><?=mostrar_palabra(518, $palabras)?></a>
				<a class="btn btn-rojo2" href="<?=site_url('cobranzas/dashboard')?>"><?=mostrar_palabra(679, $palabras)?></a>
			</div>
			<div class="col-sm-12 col-md-6">
				<img src="<?=base_url('assets/images/cobranza/ini.png')?>" class="img-responsive">
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