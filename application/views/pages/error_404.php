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
				<img src="<?=base_url('assets/images/error.png')?>" class="img-responsive" style="margin:auto">
				<p class="lead text-center">
					Oops!
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