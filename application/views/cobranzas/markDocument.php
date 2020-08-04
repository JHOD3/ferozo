<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.image-marker.css">

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
				    <img src="<?=base_url('assets/images/cobranza/doc.png')?>" width="80px">
				  </div>
				  <div class="media-body">
				    <div class="media-heading-cobranza">
				    	<?=$documento['cob_doc_nombre']?><br>
				    	<span style="font-size:14px; color:#999;"><?=$operations['cob_nombre']?></span>
				    </div>
				  </div>
				</div>
			</div>
		</div>


		
		
		<div class="row">
			<div class="col-md-12">
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

				<div id="add_neg_marker" class="btn btn-rojo2"><i class="fas fa-plus"></i> <i class="fas fa-sticky-note"></i></div>
				
				<br>
				<br>

				<div id="element"></div>

				<br>

			    <a href="<?=site_url('cobranzas/documentation/'.$documento['cob_id'])?>" class="btn btn-default"><?=mostrar_palabra(29, $palabras)?></a>
			    <button id="btn_save" class="btn btn-rojo2" onclick="guardar()"><?=mostrar_palabra(17, $palabras)?></button>
		  	</div>
		</div>



	</section>
	<!-- /Lead -->

</main>

<?php
$this->load->view('templates/footer');
?>

<script src="<?=base_url()?>assets/js/jquery-ui.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery.image-marker.js"></script>
<script type="text/javascript">
var imageMarker = $("#element").imageMarker({
	src: '<?=base_url('images/cobranza/'.$documento['cob_doc_ruta'])?>',
	drag_disabled: false
});

$('#add_neg_marker').click(function() {
	var clase = 'warning';
	var cob_doc_not_tipo = '<?=$user_details['cob_usr_tipo_id']?>';
	if(cob_doc_not_tipo==2)
	{
		clase = 'success';
	}
	else if(cob_doc_not_tipo==3)
	{
		clase = 'info';
	}
	else if(cob_doc_not_tipo==4)
	{
		clase = 'danger';
	}

  	$(imageMarker).trigger('add_marker', {
	  	title: '<?=mostrar_nombre($this->session->userdata('usr_nombre'), $this->session->userdata('usr_apellido'), $this->session->userdata('usr_mail'))?>',
	    content: 'Content',
	    className: clase,
	    tipo: cob_doc_not_tipo,
  	});
});

function guardar()
{
	$('#btn_save').attr('disabled','disabled');
	$('#btn_save').html('loading...');
  	$(imageMarker).trigger('get_markers', function(data) {
	  	//alert(JSON.stringify(data));
	    //window.localStorage.markers = JSON.stringify(data);
	    $.ajax({
	      url: SITE_URL+'cobranzas/guardar_notas_ajax',
	      type: 'POST',
	      data: jQuery.param({cob_doc_id: <?=$documento['cob_doc_id']?>, items:JSON.stringify(data)}),
	      dataType: 'json',
	      success: function(data) {
	        if(data.error == false)
	        {
	        	location.reload();
	        }
	        else
	        {
	        	alert(data.data);
	        }
	        $('#btn_save').attr('disabled',false);
			$('#btn_save').html('Submit');
	      },
	      error: function(x, status, error){
	            alert("An error occurred: " + status + " nError: " + error);
	            $('#btn_save').attr('disabled',false);
				$('#btn_save').html('Submit');
	      }
	    });
  	});
}

function buscar()
{
  $('#loading').show();
  
    $.ajax({
      	url: SITE_URL+'cobranzas/get_notas_ajax',
      	type: 'POST',
      	data: jQuery.param({cob_doc_id: <?=$documento['cob_doc_id']?>}),
      	dataType: 'json',
      	success: function(data) {
	        if(data.error == false)
	        {
	        	//alert(JSON.stringify(data.data));
	        	$.each( data.data, function( key, value ) {
	        		var clase = 'warning';
	        		if(value.cob_doc_not_tipo==2)
	        		{
	        			clase = 'success';
	        		}
	        		else if(value.cob_doc_not_tipo==3)
	        		{
	        			clase = 'info';
	        		}
	        		else if(value.cob_doc_not_tipo==4)
					{
						clase = 'danger';
					}
					$(imageMarker).trigger('add_marker', {
						className: clase,
						tipo: value.cob_doc_not_tipo,
						id: value.cob_doc_not_id,
						title: value.cob_doc_not_titulo,
						content: value.cob_doc_not_texto,
						pos: {x: value.cob_doc_not_pos_x, y: value.cob_doc_not_pos_y}
					});
				});
	        }
	        else
	        {
	        	alert(data.data);
	        }
	        $('#loading').hide();
      	},
      	error: function(x, status, error){
            alert("An error occurred: " + status + " nError: " + error);
      	}
    });
}

buscar();
</script>

</body>
</html>