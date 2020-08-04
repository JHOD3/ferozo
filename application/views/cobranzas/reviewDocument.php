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
			<div class="col-md-12 col-lg-6">
				<div class="media">
				  <div class="media-left media-middle">
				    <img src="<?=base_url('assets/images/target2.png')?>" width="80px">
				  </div>
				  <div class="media-body texto-rojo">
				    <div class="media-heading" style="margin-top: 20px; font-family: 'Gotham-Bold'; font-size: 24px;">View operation</div>
				  </div>
				</div>
			</div>
		</div>


		
<h2 class="alert alert-success"><?php echo $title; ?></h2>
<div class="row">

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

<form action="" method="POST" enctype="multipart/form-data">
   <div class="form-group">
      <label for="email">Operation Unique Code:</label>
      <input type="text" class="form-control" " value="<?php echo $documents['operation_code']; ?>"  readonly>
    </div>


    <div class="form-group">
      <label for="email">Document Name:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter name" value="<?php echo $documents['name']; ?>" name="" readonly>
    </div>
	
	 
	  <div class="form-group">
	 <a href="<?php echo base_url($documents['file']); ?>" target="_blank" class="btn btn-info" > View document in new tab</a>
	 </div>


	<?php
	  $ext = pathinfo($documents['file'], PATHINFO_EXTENSION); 
	  if( $ext=='docx' || $ext=='pdf' ){
	?>
		 <iframe src="https://docs.google.com/gview?url=<?php echo base_url($documents['file']); ?>&embedded=true"></iframe>
	
	<?php } else { ?>

		<img src="<?php echo base_url($documents['file']); ?>" width="200px" height="200px">

	<?php } ?>

		<div class="form-group">
	      <label for="email">Change Status:</label>
	      <select  class="form-control" name="status" required>
	      		<option value=""> Selcet Status</option>
	      		<option value="2"> Revision/Re-upload</option>
	      		<option value="3"> Rejected</option>
	      </select>
	    </div>

	  <div class="form-group">
	      <label for="email">Add Comments:</label>
	      <textarea  class="form-control" name="comments" ></textarea>
	    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  
</div>



	</section>
	<!-- /Lead -->

</main>

<?php
$this->load->view('templates/footer');
?>

</body>
</html>