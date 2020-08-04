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
				<h1 class="text-center"></h1>
				<p class="lead text-center">
					<?=$mensaje?>
				</p> 
			</div>
		</div>
	</section>

</main>


<?php
$this->load->view('templates/menu_footer');
$this->load->view('templates/footer');
$this->load->view('pages/header_scripts');
?>

</body>
</html>