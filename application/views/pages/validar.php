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
<main class="">

	<!-- Features -->
	<section class="container">
		
		<div class="row">

			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-danger">
				  <div class="panel-heading">
				    <h3 class="panel-title"></h3>
				  </div>

				  <div class="panel-body">
                    <?php 
                        if($error != "")
                        {
                            echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                            echo $error;
                            echo '</div>';
                        }
                        if($success != "")
                        {
                            echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                            echo $success;
                            echo '</div>';
                        }
                    ?>

				    <form method="POST" action="<?=site_url('login/validar_mail')?>">

                      <div class="form-group <?php if(form_error('mail')) echo 'has-error';?>">
                        <label for="mail"><?=mostrar_palabra(4, $palabras)?></label>
                        <?php echo form_error('mail'); ?>
                        <input type='email' class='form-control' name='mail' placeholder='<?=mostrar_palabra(4, $palabras)?>' value=''>
                      </div>

                      <div class="form-group <?php if(form_error('codigo')) echo 'has-error';?>">
                        <label for="codigo"></label>
                        <?php echo form_error('codigo'); ?>
                        <input type='text' class='form-control' name='codigo' placeholder='XXXX' value=''>
                      </div>

                      <button type="submit" class="btn btn-danger"><?=mostrar_palabra(17, $palabras)?></button>

                    </form>

				  </div>
				</div>
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