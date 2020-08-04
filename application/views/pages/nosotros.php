<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<body>

<?php
$this->load->view('templates/analytics');
$this->load->view('pages/header2');
?>
	

<!-- Content -->
<main class="">

	<!-- Lead -->
	<section class="container space-before space-after">
		<div class="row">
			<div class="col-sm-10 col-sm-push-1">
				<h1 class="text-center">Sistema</h1>
				<p class="lead text-center">
					<?=nl2br(mostrar_palabra(102, $palabras))?>
				</p>
			</div>
		</div>
	</section>
	<!-- /Lead -->

	<!-- Features -->
	<section class="container-fluid space-before" style="background:#f2f2f2;">
		
		<div class="container">
			<div class="row featurelist space-after">
				<div class="col-md-5 col-sm-6 col-md-push-1 ">
					<img class="img-feature img-responsive" src="<?=base_url()?>assets/images/nosotros.jpg" alt="Mision">
				</div>
				<div class="col-md-5 col-md-push-1 col-sm-6">
					<h2 class="space-before"><?=mostrar_palabra(104, $palabras)?><span class="text-muted"></span></h2>
					<p style="font-size:24px;"><?=mostrar_palabra(105, $palabras)?></p>
				</div>
			</div>
		</div>

	</section>
	<!-- /Features -->

	<!-- Features -->
	<section class="container space-before">
		
		<div class="row featurelist space-after">
			<div class="col-xs-12 text-center space-after">
				<h2><?=mostrar_palabra(106, $palabras)?><span class="text-muted"></span></h2>
			</div>
			<div class="col-sm-3 text-center equipo">
				<div class="imagen-equipo">
					<img class="img-feature img-responsive img-circle" src="<?=base_url()?>assets/images/flavio.jpg" alt="Flavio">
				</div>
				<b>Flavio Gariglio</b><br>
				<?=mostrar_palabra(107, $palabras)?><br>
				<?=mostrar_palabra(110, $palabras)?>
				<!--<a href="mailto: contact@Sistema.com">contact@Sistema.com</a>-->
			</div>
			<div class="col-sm-3 text-center equipo">
				<div class="imagen-equipo">
					<img class="img-feature img-responsive img-circle" src="<?=base_url()?>assets/images/fabian.jpg" alt="Fabian">
				</div>
				<b>Fabian Mayoral</b><br>
				<?=mostrar_palabra(108, $palabras)?><br>
				<?=mostrar_palabra(110, $palabras)?>
			</div>
			<div class="col-sm-3 text-center equipo">
				<div class="imagen-equipo">
					<img class="img-feature img-responsive img-circle" src="<?=base_url()?>assets/images/gonzalo.jpg" alt="Gonzalo">
				</div>
				<b>Gonzalo Mayoral</b><br>
				<?=mostrar_palabra(109, $palabras)?>
			</div>
			<div class="col-sm-3 text-center equipo">
				<div class="imagen-equipo">
					<img class="img-feature img-responsive img-circle" src="<?=base_url()?>assets/images/fede.jpg" alt="Federico">
				</div>
				<b>Federico Quintana</b><br>
				<?=mostrar_palabra(109, $palabras)?>
			</div>
		</div>
		
	</section>
	<!-- /Features -->

</main>

<?php
$this->load->view('templates/menu_footer');
$this->load->view('templates/footer');
?>

</body>
</html>