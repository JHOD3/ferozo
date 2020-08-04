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
	<section class="container-fluid">
		<div class="row space-after">
			<div class="col-md-12">
				<div class="media">
				  <div class="media-left media-middle">
				    <img src="<?=base_url('assets/images/cobranza/doc.png')?>" width="80px">
				  </div>
				  <div class="media-body">
				    <div class="media-heading-cobranza">
				    	<?=mostrar_palabra(761, $palabras)?><br>
				    	<span style="font-size:14px; color:#999;"><?=$operations['cob_nombre']?></span>
				    </div>
				  </div>
				</div>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-md-12 col-lg-6">
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

				<form action="<?=site_url('cobranzas/uploadDocument/'.$operations['cob_id'])?>" method="POST" enctype="multipart/form-data">
				    <div class="form-group">
				      <label for="email"><?=mostrar_palabra(758, $palabras)?></label>
				      <input type="text" class="form-control" id="email" placeholder="XXXXXXXXXXX" value="<?php echo set_value('name'); ?>" name="name" required>
				    </div>
					<?php 
					if(form_error('name'))
					{ 
						echo '<span class="error">'.form_error('name').'</span>';
					} 
					?>
					<div class="form-group">
				      <label for="file"><?=mostrar_palabra(763, $palabras)?></label>
				      <input type="file" class="form-control" id="file" name="file[]" multiple="multiple" required>
				    </div>
				   
				   	<a href="<?=site_url('cobranzas/documentation/'.$operations['cob_id'])?>" class="btn btn-default"><?=mostrar_palabra(29, $palabras)?></a>
				    <button type="submit" class="btn btn-rojo2"><?=mostrar_palabra(17, $palabras)?></button>
				</form>
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