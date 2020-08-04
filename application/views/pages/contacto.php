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
<main class="content2">

	<!-- Lead -->
	<section class="container space-before space-after">
		<div class="row">
			<div class="col-sm-10 col-sm-push-1">
				<h1 class="text-center"><?=mostrar_palabra(38, $palabras)?></h1>
				<p class="lead text-center">
					<?php
					$texto = str_replace ( "X@X.com" , '<a href="mailto: contact@Sistema.com">contact@Sistema.com</a>' , mostrar_palabra(115, $palabras) );
					echo $texto;
					?>
				</p> 
			</div>
		</div>
	</section>
	<!-- /Lead -->

</main>

<?php
$this->load->view('templates/menu_footer');
$this->load->view('templates/footer');
$this->load->view('pages/header_scripts');
?>

</body>
</html>