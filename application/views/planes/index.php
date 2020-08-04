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
						<h3 class="panel-title"><?=mostrar_palabra(505, $palabras)?></h3>
					</div>
				</div>
			</div>

		</div>
	</section>
	<!-- /Features -->

	<!-- Lead -->
	<section class="container-fluid space-before space-after">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-8 col-lg-offset-2">
				<div class="col-sm-12" style="margin-bottom:20px;">
					<p class="lead text-center"><?=mostrar_palabra(506, $palabras)?></p> 
				</div>

				<div class="col-sm-12 col-md-4 plan plan-target">
					<div class="img"></div>
					<div class="title"><?=mostrar_palabra(508, $palabras)?></div>
					<!--<div class="pack">Pack 1</div>-->
					<div class="descripcion"><?=mostrar_palabra(509, $palabras)?></div>
					<a href="<?=site_url('planes/target')?>" class="btn btn-gris"><?=mostrar_palabra(151, $palabras)?></a>
				</div>
				<div class="col-sm-12 col-md-4 plan plan-market">
					<div class="img"></div>
					<div class="title"><?=mostrar_palabra(511, $palabras)?></div>
					<!--<div class="pack">Pack 2</div>-->
					<div class="descripcion"><?=mostrar_palabra(512, $palabras)?></div>
					<a href="<?=site_url('planes/market')?>" class="btn btn-gris"><?=mostrar_palabra(151, $palabras)?></a>
				</div>
				<div class="col-sm-12 col-md-4 plan plan-premium">
					<div class="img"></div>
					<div class="title"><?=mostrar_palabra(514, $palabras)?></div>
					<!--<div class="pack">Pack 3</div>-->
					<div class="descripcion"><?=mostrar_palabra(515, $palabras)?></div>
					<a href="<?=site_url('planes/premium')?>" class="btn btn-gris"><?=mostrar_palabra(151, $palabras)?></a>
				</div>

				<div class="col-sm-12" style="margin-top:80px;">
					<p class="text-center"><?=mostrar_palabra(507, $palabras)?></p> 
				</div>
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