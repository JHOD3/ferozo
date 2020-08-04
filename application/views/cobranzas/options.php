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
						<a class="btn btn-danger pull-right" href="<?=site_url('cobranzas/dashboard')?>" style="color:#FFF; font-size:14px;"><?=mostrar_palabra(679, $palabras)?></a>
						<h3 class="panel-title"><?=mostrar_palabra(646, $palabras)?></h3>
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
					<p class="lead text-center"><?=mostrar_palabra(648, $palabras)?></p> 
				</div>
				
				<div class="col-sm-12 col-md-4 plan plan-cobranza1" onclick="location.href='<?=site_url('cobranzas/user_type')?>'">
					<div class="img"></div>
					<div class="title"><?=mostrar_palabra(680, $palabras)?></div>
					<!--<div class="pack">Pack 1</div>-->
					<div class="descripcion"><?=mostrar_palabra(650, $palabras)?></div>
					<a href="javascript:;" class="btn btn-gris"><?=mostrar_palabra(151, $palabras)?></a>
				</div>
				<div class="col-sm-12 col-md-4 plan plan-cobranza2" onclick="location.href='<?=site_url('cobranzas/joinOperation')?>'">
					<div class="img"></div>
					<div class="title"><?=mostrar_palabra(681, $palabras)?></div>
					<!--<div class="pack">Pack 2</div>-->
					<div class="descripcion"><?=mostrar_palabra(651, $palabras)?></div>
					<a href="javascript:;" class="btn btn-gris"><?=mostrar_palabra(151, $palabras)?></a>
				</div>
				<div class="col-sm-12 col-md-4 plan plan-cobranza3">
					<div class="img"></div>
					<div class="title"><?=mostrar_palabra(170, $palabras)?></div>
					<!--<div class="pack">Pack 3</div>-->
					<div class="descripcion"><?=mostrar_palabra(652, $palabras)?></div>
					<a href="javascript:;" class="btn btn-gris"><?=mostrar_palabra(151, $palabras)?></a>
				</div>

				<div class="col-sm-12" style="margin-top:80px;">
					<p class="text-center"><?=mostrar_palabra(649, $palabras)?></p> 
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