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
						<h3 class="panel-title"><?=mostrar_palabra(646, $palabras)?></h3>
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
				    <img src="<?=base_url('assets/images/cobranza/dashboard.png')?>" width="80px">
				  </div>
				  <div class="media-body texto-rojo">
				    <a class="btn btn-rojo2 pull-right" href="<?=site_url('cobranzas/options')?>"><?=mostrar_palabra(672, $palabras)?></a>
				    <div class="media-heading" style="margin-top: 20px; font-family: 'Gotham-Bold'; font-size: 24px;"><?=mostrar_palabra(679, $palabras)?></div>
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
			
			<h5><?=mostrar_palabra(727, $palabras)?></h5>
			<table class="table table-dashboard table-striped">
			    <thead>
			      <tr>
			        <th><?=mostrar_palabra(726, $palabras)?></th>
			        <th><?=mostrar_palabra(673, $palabras)?></th>
			        <th><?=mostrar_palabra(723, $palabras)?></th>
			        <th><?=mostrar_palabra(724, $palabras)?></th>
			        <th><?=mostrar_palabra(725, $palabras)?></th>
					<th><?=mostrar_palabra(369, $palabras)?></th>
			      </tr>
			    </thead>
			    <tbody>
				<?php 
				$i=1;
				foreach($operation as $operations)
				{
					if($operations['cob_est_id'] < COBRANZA_ESTADO_APROBADO)
					{
						echo '<tr>';
					        echo '<td>'.$i.'</td>';
					        //echo '<td>'.$operations['cob_codigo'].'</td>';
					        echo '<td>'.ucwords($operations['cob_nombre']).'</td>';
					        echo '<td>'.$operations['cob_usr_tipo_desc'].'</td>';
					        echo '<td>';
					        	echo '<span class="est-color est-color-'.$operations['cob_est_color'].'">'.$operations['cob_est_desc'].'</span>';
								/*
								echo '<div class="btn-group">';
									echo '<button type="button" class="btn '.$operations['cob_est_color'].'" id="btn_estado_'.$operations['cob_id'].'">'.$operations['cob_est_desc'].'</button>';
									  echo '<button type="button" class="btn '.$operations['cob_est_color'].' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <span class="caret"></span>
									    <span class="sr-only">Toggle Dropdown</span>
									  </button>';
									  echo '<ul class="dropdown-menu">';
									  foreach ($estados as $key => $value)
									  {
									  	if($operations['cob_est_id'] != $value['cob_est_id'])
									  	{
									  		echo '<li><a href="javascript: cambiar_estado('.$operations['cob_id'].', '.$value['cob_est_id'].');">'.$value['cob_est_desc'].'</a></li>';
									  	}
									  }
								  echo '</ul>';
								echo '</div>';
								*/
							echo '</td>';
							echo '<td>'.$operations['cob_fecha_modif'].'</td>';
					        echo '<td align="right">';
					        	$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 1, $operations['cob_usr_tipo_id'], 1);
					        	if($permiso_ver && $permiso_ver['cob_per_activo'])
					        	{
									echo '<a href="'.site_url('cobranzas/editPermisos/'.$operations['cob_id']).'" class="btn btn-gris-chico btn-xs"><i class="fas fa-unlock fa-lg" aria-hidden="true"></i></a> ';
								}
								//echo '<a href="javascript:;" class="btn btn-gris-chico btn-xs"><i class="fas fa-envelope fa-lg" aria-hidden="true"></i></a> ';
								$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 3, $operations['cob_usr_tipo_id'], 1);
					        	if($permiso_ver && $permiso_ver['cob_per_activo'])
					        	{
									echo '<a href="'.site_url('cobranzas/documentation/'.$operations['cob_id']).'" class="btn btn-gris-chico btn-xs"><i class="fas fa-file-alt fa-lg" aria-hidden="true"></i></a> ';
								}
								if($operations['usr_id'] == $this->session->userdata('usr_id'))
								{
									echo '<a href="'.site_url('cobranzas/editOperation/'.$operations['cob_id']).'" class="btn btn-gris-chico btn-xs"><i class="fas fa-edit fa-lg" aria-hidden="true"></i></a> ';
								}
								echo '<a href="'.site_url('cobranzas/beginOperation/'.$operations['cob_id']).'" class="btn btn-gris-chico btn-xs"><i class="fas fa-eye fa-lg" aria-hidden="true"></i></a> ';
								echo '<a href="javascript: confirm_eliminar('.$operations['cob_id'].');" class="btn btn-gris-chico btn-xs"><i class="fas fa-trash fa-lg" aria-hidden="true"></i></a> ';
							echo '</td>';
			      		echo '</tr>';
			    		$i++;
					}
				}
				?>
			    </tbody>
			  </table>
			  
			  <br>

			  <h5><?=mostrar_palabra(728, $palabras)?></h5>
			  <table class="table table-dashboard table-striped">
			    <thead>
			      <tr>
			        <th><?=mostrar_palabra(726, $palabras)?></th>
			        <th><?=mostrar_palabra(673, $palabras)?></th>
			        <th><?=mostrar_palabra(723, $palabras)?></th>
			        <th><?=mostrar_palabra(724, $palabras)?></th>
			        <th><?=mostrar_palabra(725, $palabras)?></th>
					<th><?=mostrar_palabra(369, $palabras)?></th>
			      </tr>
			    </thead>
			    <tbody>
				<?php 
				$i=1; 
				foreach($operation as $operations)
				{ 
					if($operations['cob_est_id'] == COBRANZA_ESTADO_APROBADO)
					{
						echo '<tr>';
					        echo '<td>'.$i.'</td>';
					        echo '<td>'.$operations['cob_codigo'].'</td>';
					        echo '<td>'.$operations['cob_usr_tipo_desc'].'</td>';
					        echo '<td>'.ucwords($operations['cob_nombre']).'</td>';
					        echo '<td>'.$operations['cob_fecha_modif'].'</td>';
					        echo '<td>';
								echo '<div class="btn-group">
									  <button type="button" class="btn '.$operations['cob_est_color'].'" id="btn_estado_'.$operations['cob_id'].'">'.$operations['cob_est_desc'].'</button>
									  <button type="button" class="btn '.$operations['cob_est_color'].' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <span class="caret"></span>
									    <span class="sr-only">Toggle Dropdown</span>
									  </button>';
									  echo '<ul class="dropdown-menu">';
									  foreach ($estados as $key => $value)
									  {
									  	if($operations['cob_est_id'] < $value['cob_est_id'])
									  	{
									  		echo '<li><a href="javascript: cambiar_estado('.$operations['cob_id'].', '.$value['cob_est_id'].');">'.$value['cob_est_desc'].'</a></li>';
									  	}
									  }
								  echo '</ul>';
								echo '</div>';
							echo '</td>';
					    echo '</tr>';
						$i++;
					}
				}
				?>
			    </tbody>
			  </table>

			  <br>

			  <h5><?=mostrar_palabra(729, $palabras)?></h5>
			  <table class="table table-dashboard table-striped">
			    <thead>
			      <tr>
			        <th><?=mostrar_palabra(726, $palabras)?></th>
			        <th><?=mostrar_palabra(673, $palabras)?></th>
			        <th><?=mostrar_palabra(723, $palabras)?></th>
			        <th><?=mostrar_palabra(724, $palabras)?></th>
			        <th><?=mostrar_palabra(725, $palabras)?></th>
					<th><?=mostrar_palabra(369, $palabras)?></th>
			      </tr>
			    </thead>
			    <tbody>
				<?php 
				$i=1; 
				foreach($operation as $operations)
				{ 
					if($operations['cob_est_id'] == COBRANZA_ESTADO_FINALIDAZA)
					{
						echo '<tr>';
					        echo '<td>'.$i.'</td>';
					        echo '<td>'.$operations['cob_codigo'].'</td>';
					        echo '<td>'.$operations['cob_usr_tipo_desc'].'</td>';
					        echo '<td>'.ucwords($operations['cob_nombre']).'</td>';
					        echo '<td>'.$operations['cob_fecha_modif'].'</td>';
					        echo '<td>';
								echo '<span class="est-color est-color-'.$operations['cob_est_color'].'" id="btn_estado_'.$operations['cob_id'].'">'.$operations['cob_est_desc'].'</span>';
							echo '</td>';
					    echo '</tr>';
						$i++;
					}
				}
				?>
			    </tbody>
			  </table>

		  	</div>
		</div>



	</section>
	<!-- /Lead -->

</main>

<?php
$this->load->view('templates/footer');
?>

<script type="text/javascript">
function cambiar_estado(cob_id, est_id)
{
	$('#btn_estado_'+cob_id).button('loading');
    $.ajax({
      url: SITE_URL+'cobranzas/cambiar_estado_operacion_ajax',
      type: 'POST',
      data: jQuery.param({cob_id: cob_id, est_id: est_id}),
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
        $('#loading').hide();
      },
      error: function(x, status, error){
            alert("An error occurred: " + status + " nError: " + error);
      }
    });
}

function confirm_eliminar(id)
{
	if (confirm('Are you sure you want to delete this item?')) {
		// Save it!
		location.href = '<?=site_url('cobranzas/deleteOperation/')?>'+id;
	} else {
		// Do nothing!
	}
}
</script>

</body>
</html>