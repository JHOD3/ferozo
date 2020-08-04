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
	<section class="container">
		
		<div class="row">
			<?php
			$this->load->view('templates/sidebar_left');
			?>
			<div class="col-md-6">
				<div class="panel panel-danger">
					<div class="panel-body">
						<h2 class="texto-bordo"><?=mostrar_palabra(178, $palabras)?></h2><br>
						<?=mostrar_palabra(179, $palabras)?><br>
						<?=mostrar_palabra(180, $palabras)?> U$S 20.-<br>
						<br>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="8HVDXBHY4BMMC">
							<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
							<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
						</form>
						<br>
						
					</div>
				</div>
			</div>
			<?php
			$this->load->view('templates/sidebar_right');
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