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
<main class="content fondo-derecha">

	<!-- Features -->
	<section class="container-fluid">
		
		<div class="row">

			<div class="col-md-12 col-lg-6">
				<div class="panel panel-danger">
				  <div class="panel-heading">
				    <h3 class="panel-title"><?=mostrar_palabra(45, $palabras)?></h3>
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

				    <form method="POST" action="<?=site_url()?>user/password">

              <div class="form-group <?php if(form_error('clave_ant')) echo 'has-error';?>">
                <label for="clave_ant"><?=mostrar_palabra(46, $palabras)?></label>
                <?php echo form_error('clave_ant'); ?>
                <input type='password' class='form-control' name='clave_ant' placeholder='<?=mostrar_palabra(46, $palabras)?>' value=''>
              </div>

              <div class="form-group <?php if(form_error('clave')) echo 'has-error';?>">
                <label for="clave"><?=mostrar_palabra(47, $palabras)?></label>
                <?php echo form_error('clave'); ?>
                <input type='password' class='form-control' name='clave' placeholder='<?=mostrar_palabra(47, $palabras)?>' value=''>
              </div>

              <div class="form-group <?php if(form_error('clave2')) echo 'has-error';?>">
                <label for="clave2"><?=mostrar_palabra(48, $palabras)?></label>
                <?php echo form_error('clave2'); ?>
                <input type='password' class='form-control' name='clave2' placeholder='<?=mostrar_palabra(48, $palabras)?>' value=''>
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
$this->load->view('templates/footer');
?>

<script type="text/javascript">
function ver_edit(id)
{
  $('#prod_'+id+' .media-right').show();
}

function sacar_edit(id)
{
  $('#prod_'+id+' .media-right').hide();
}

function cuenta_caracteres()
{
  var num = 255 - $('#descripcion').val().length;
  $('#caracteres').html(num + " caracteres");
}

cuenta_caracteres();
</script>

</body>
</html>