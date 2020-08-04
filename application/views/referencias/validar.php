<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<body>

<!-- Header -->
<?php
$this->load->view('templates/analytics');
$this->load->view('pages/header2');
?>
<!-- /Header -->
	

<!-- Content -->
<main class="content">

	<!-- Features -->
	<section class="container">
		
		<div class="row">

			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-danger">
				  <div class="panel-heading">
            		<h3 class="panel-title" style="margin-top:2px;">Validar</h3>
				  </div>

				  <div class="panel-body">

		            <?php
		            if($success)
		            {
		              echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		                echo $success;
		              echo '</div>';
		            }

		            if($error)
		            {
		              echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		                echo $error;
		              echo '</div>';
		            }
		            ?>

				  </div>

				</div>
			</div>

		</div>
	</section>
	<!-- /Features -->

</main>

<?php
$this->load->view('templates/footer');
?>


</body>
</html>