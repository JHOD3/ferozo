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

				<form action="<?=site_url('cobranzas/user_type_invite/'.$operations['cob_id'].'/'.$operations['cob_codigo'])?>" method="POST">
					<?php
					foreach ($tipos as $key => $tipo)
					{
						echo '<div class="col-sm-12 col-md-3 plan">';
							echo '<img src="'.base_url('assets/images/cobranza/user_type'.$tipo['cob_usr_tipo_id'].'.png').'">';
							echo '<div class="title">'.$tipo['cob_usr_tipo_desc'].'</div>';
							//echo '<div class="pack">Pack 1</div>';
							echo '<div class="descripcion"></div>';
							if(!$tipo['usuario'])
							{
								echo '<button type="submit" value="'.$tipo['cob_usr_tipo_id'].'" name="type" id="type_'.$tipo['cob_usr_tipo_id'].'" class="btn btn-gris">'.mostrar_palabra(151, $palabras).'</button>';
							}
						echo '</div>';
					}

					
						// echo '<div class="col-sm-12 col-md-4 plan plan-target">';
						// 	echo '<div class="img"></div>';
						// 	echo '<div class="title">User Type 1</div>';
						// 	echo '<!--<div class="pack">Pack 1</div>-->';
						// 	echo '<div class="descripcion">'.mostrar_palabra(509, $palabras).'</div>';
						// 	if(!$usuarios[0])
						// 	{
						// 		echo '<button type="submit" value="1" name="type" id="type_1" class="btn btn-gris">Unirme</button>';
						// 	}
						// echo '</div>';
					
						// echo '<div class="col-sm-12 col-md-4 plan plan-market">';
						// 	echo '<div class="img"></div>';
						// 	echo '<div class="title">User Type 2</div>';
						// 	echo '<!--<div class="pack">Pack 2</div>-->';
						// 	echo '<div class="descripcion">'.mostrar_palabra(512, $palabras).'</div>';
						// 	if(!$usuarios[1])
						// 	{
						// 		echo '<button type="submit" value="2" name="type" id="type_2" class="btn btn-gris">Unirme</button>';
						// 	}
						// echo '</div>';
					
						// echo '<div class="col-sm-12 col-md-4 plan plan-premium">';
						// 	echo '<div class="img"></div>';
						// 	echo '<div class="title">User Type 3</div>';
						// 	echo '<!--<div class="pack">Pack 3</div>-->';
						// 	echo '<div class="descripcion">'.mostrar_palabra(515, $palabras).'</div>';
						// 	if(!$usuarios[2])
						// 	{
						// 		echo '<button type="submit" value="3" name="type" id="type_3" class="btn btn-gris">Unirme</button>';
						// 	}
						// echo '</div>';
					?>
				</form>

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