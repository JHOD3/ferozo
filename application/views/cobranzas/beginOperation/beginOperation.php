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
				<div class="media" style="overflow:visible;">
				  <div class="media-left media-middle">
				    <img src="<?=base_url('assets/images/cobranza/icono1.png')?>" width="80px">
				  </div>
				  <div class="media-body">
				    <div class="media-heading-cobranza">
				    	<?=$operations['cob_nombre']?><br>
				    	<span style="font-size:14px; color:#999;"><?=$operations['cob_descripcion']?></span>
					</div>
				  </div>
				  <div class="media-right" style="width:450px;">
				  	<a class="btn btn-rojo2 pull-right" href="<?=site_url('cobranzas/dashboard')?>" style="padding-top:10px; margin-bottom:10px;"><?=mostrar_palabra(679, $palabras)?></a>
				    <?php
					echo '<div class="btn-group pull-right">
						  <button type="button" class="btn '.$operations['cob_est_color'].'" id="btn_estado_'.$operations['cob_id'].'">'.$operations['cob_est_desc'].'</button>
						  <button type="button" class="btn '.$operations['cob_est_color'].' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    <span class="caret"></span>
						    <span class="sr-only">Toggle Dropdown</span>
						  </button>';
						  echo '<ul class="dropdown-menu">';
						  foreach ($estados as $key => $value)
						  {
						  	if($operations['cob_est_id'] < $value['cob_est_id'] && $value['cob_est_id'] < ($operations['cob_est_id']+2))
						  	{
						  		//if($value['cob_est_id'])
						  		echo '<li><a href="javascript: cambiar_estado('.$operations['cob_id'].', '.$value['cob_est_id'].');">'.$value['cob_est_desc'].'</a></li>';
						  	}
						  }
					  echo '</ul>';
					echo '</div>';
					?>
				  </div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
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
			</div>
		</div>

		<form id="form" action="#" method="POST">

		<div class="row">
			<div class="col-md-12">
				<div>

				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				  	<?php
				  	foreach ($tipos as $key => $tipo)
					{
						// $permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 24, $operations['cob_usr_tipo_id'], 1);
						// if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
						// {
						// }
						
						$active = "";
						if($key == 0)
						{
							$active = "active";
						}
						echo '<li role="presentation" class="'.$active.'">';
							echo '<a href="#type_'.$tipo['cob_usr_tipo_id'].'" aria-controls="type_'.$tipo['cob_usr_tipo_id'].'" role="tab" data-toggle="tab">'.$tipo['cob_usr_tipo_desc'].' ';
							if($tipo['usuario'])
							{
								echo '('.$tipo['usuario']['usr_mail'].')';
							}
							else
							{
								echo ' &nbsp; <button class="btn btn-xs btn-rojo2" onclick="ver_modal_invitar('.$tipo['cob_usr_tipo_id'].',\''.$tipo['cob_usr_tipo_desc'].'\')" style="padding:2px 3px 1px;"><i class="fas fa-user-plus"></i></button>';
							}
							echo '</a>';
						echo '</li>';
					}
				  	?>
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
				  	<?php
				  	foreach ($tipos as $key => $tipo)
					{
						$active = "";
						if($key == 0)
						{
							$active = "active";
						}
						echo '<div role="tabpanel" class="tab-pane '.$active.'" id="type_'.$tipo['cob_usr_tipo_id'].'">';
						if($tipo['cob_usr_tipo_id'] == 1)
						{
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(610, $palabras).'</div>';
								
										$data_empresa['num_empresa'] = 0;
										$data_empresa['num_empresa_offset'] = 0;
										$data_empresa['key'] = $key;
										$data_empresa['tipo'] = $tipo;
										$data_empresa['title'] = mostrar_palabra(617, $palabras);
										$data_empresa['permiso'] = 8;
										$this->load->view('cobranzas/poner_empresa', $data_empresa);
								
										$data_empresa['num_empresa'] = 1;
										$data_empresa['num_empresa_offset'] = 1;
										$data_empresa['key'] = $key;
										$data_empresa['tipo'] = $tipo;
										$data_empresa['title'] = mostrar_palabra(621, $palabras);
										$data_empresa['permiso'] = 9;
										$this->load->view('cobranzas/poner_empresa', $data_empresa);
								
							echo '</div>';
							$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 11, $operations['cob_usr_tipo_id'], 1);
							if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
							{
								echo '<div class="row" style="margin-left:0px;">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(611, $palabras).'</div>';
										$data_empresa['num_empresa'] = 2;
										$data_empresa['num_empresa_offset'] = 2;
										$data_empresa['key'] = $key;
										$data_empresa['tipo'] = $tipo;
										$data_empresa['title'] = mostrar_palabra(624, $palabras);
										$data_empresa['permiso'] = 11;
										$this->load->view('cobranzas/poner_empresa', $data_empresa);
								echo '</div>';
							}
							$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 21, $operations['cob_usr_tipo_id'], 1);
							if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
							{
								echo '<div class="row" style="margin-left:0px;">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(612, $palabras).'</div>';
										$data_empresa['num_empresa'] = 3;
										$data_empresa['num_empresa_offset'] = 3;
										$data_empresa['key'] = $key;
										$data_empresa['tipo'] = $tipo;
										$data_empresa['title'] = mostrar_palabra(627, $palabras);
										$data_empresa['permiso'] = 21;
										$this->load->view('cobranzas/poner_empresa', $data_empresa);
								echo '</div>';
							}
						}
						elseif($tipo['cob_usr_tipo_id'] == 2)
						{
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(610, $palabras).'</div>';
									
									$data_empresa['num_empresa'] = 0;
									$data_empresa['num_empresa_offset'] = 4;
									$data_empresa['key'] = $key;
									$data_empresa['tipo'] = $tipo;
									$data_empresa['title'] = mostrar_palabra(618, $palabras);
									$data_empresa['permiso'] = 14;
									$this->load->view('cobranzas/poner_empresa', $data_empresa);
								
									$data_empresa['num_empresa'] = 1;
									$data_empresa['num_empresa_offset'] = 5;
									$data_empresa['key'] = $key;
									$data_empresa['tipo'] = $tipo;
									$data_empresa['title'] = mostrar_palabra(622, $palabras);
									$data_empresa['permiso'] = 17;
									$this->load->view('cobranzas/poner_empresa', $data_empresa);
								
									$data_empresa['num_empresa'] = 2;
									$data_empresa['num_empresa_offset'] = 6;
									$data_empresa['key'] = $key;
									$data_empresa['tipo'] = $tipo;
									$data_empresa['title'] = mostrar_palabra(623, $palabras);
									$data_empresa['permiso'] = 18;
									$this->load->view('cobranzas/poner_empresa', $data_empresa);
								
							echo '</div>';
							$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 19, $operations['cob_usr_tipo_id'], 1);
							if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
							{
								echo '<div class="row" style="margin-left:0px;">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(611, $palabras).'</div>';
										$data_empresa['num_empresa'] = 3;
										$data_empresa['num_empresa_offset'] = 7;
										$data_empresa['key'] = $key;
										$data_empresa['tipo'] = $tipo;
										$data_empresa['title'] = mostrar_palabra(625, $palabras);
										$data_empresa['permiso'] = 19;
										$this->load->view('cobranzas/poner_empresa', $data_empresa);
								echo '</div>';
							}
							$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 22, $operations['cob_usr_tipo_id'], 1);
							if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
							{
								echo '<div class="row" style="margin-left:0px;">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(612, $palabras).'</div>';
										$data_empresa['num_empresa'] = 4;
										$data_empresa['num_empresa_offset'] = 8;
										$data_empresa['key'] = $key;
										$data_empresa['tipo'] = $tipo;
										$data_empresa['title'] = mostrar_palabra(627, $palabras);
										$data_empresa['permiso'] = 22;
										$this->load->view('cobranzas/poner_empresa', $data_empresa);
								echo '</div>';
							}
						}
						elseif($tipo['cob_usr_tipo_id'] == 3)
						{
							$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 15, $operations['cob_usr_tipo_id'], 1);
							if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
							{
								echo '<div class="row" style="margin-left:0px;">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(610, $palabras).'</div>';
										$data_empresa['num_empresa'] = 0;
										$data_empresa['num_empresa_offset'] = 9;
										$data_empresa['key'] = $key;
										$data_empresa['tipo'] = $tipo;
										$data_empresa['title'] = mostrar_palabra(619, $palabras);
										$data_empresa['permiso'] = 15;
										$this->load->view('cobranzas/poner_empresa', $data_empresa);
								echo '</div>';
							}
							$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 12, $operations['cob_usr_tipo_id'], 1);
							if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
							{
								echo '<div class="row" style="margin-left:0px;">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(611, $palabras).'</div>';
										$data_empresa['num_empresa'] = 1;
										$data_empresa['num_empresa_offset'] = 10;
										$data_empresa['key'] = $key;
										$data_empresa['tipo'] = $tipo;
										$data_empresa['title'] = mostrar_palabra(624, $palabras);
										$data_empresa['permiso'] = 12;
										$this->load->view('cobranzas/poner_empresa', $data_empresa);
								echo '</div>';
							}
							$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 23, $operations['cob_usr_tipo_id'], 1);
							if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
							{
								echo '<div class="row" style="margin-left:0px;">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(612, $palabras).'</div>';
										$data_empresa['num_empresa'] = 2;
										$data_empresa['num_empresa_offset'] = 11;
										$data_empresa['key'] = $key;
										$data_empresa['tipo'] = $tipo;
										$data_empresa['title'] = mostrar_palabra(627, $palabras);
										$data_empresa['permiso'] = 23;
										$this->load->view('cobranzas/poner_empresa', $data_empresa);
								echo '</div>';
							}
						}
						elseif($tipo['cob_usr_tipo_id'] == 4)
						{
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(610, $palabras).'</div>';
								
									$data_empresa['num_empresa'] = 0;
									$data_empresa['num_empresa_offset'] = 12;
									$data_empresa['key'] = $key;
									$data_empresa['tipo'] = $tipo;
									$data_empresa['title'] = mostrar_palabra(619, $palabras);
									$data_empresa['permiso'] = 16;
									$this->load->view('cobranzas/poner_empresa', $data_empresa);
								
								
									$data_empresa['num_empresa'] = 1;
									$data_empresa['num_empresa_offset'] = 13;
									$data_empresa['key'] = $key;
									$data_empresa['tipo'] = $tipo;
									$data_empresa['title'] = mostrar_palabra(621, $palabras);
									$data_empresa['permiso'] = 10;
									$this->load->view('cobranzas/poner_empresa', $data_empresa);
								
							echo '</div>';
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(611, $palabras).'</div>';
								
									$data_empresa['num_empresa'] = 2;
									$data_empresa['num_empresa_offset'] = 14;
									$data_empresa['key'] = $key;
									$data_empresa['tipo'] = $tipo;
									$data_empresa['title'] = mostrar_palabra(624, $palabras);
									$data_empresa['permiso'] = 13;
									$this->load->view('cobranzas/poner_empresa', $data_empresa);
								
									$data_empresa['num_empresa'] = 3;
									$data_empresa['num_empresa_offset'] = 15;
									$data_empresa['key'] = $key;
									$data_empresa['tipo'] = $tipo;
									$data_empresa['title'] = mostrar_palabra(625, $palabras);
									$data_empresa['permiso'] = 20;
									$this->load->view('cobranzas/poner_empresa', $data_empresa);
								
							echo '</div>';
							$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 24, $operations['cob_usr_tipo_id'], 1);
							if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
							{
								echo '<div class="row" style="margin-left:0px;">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(612, $palabras).'</div>';
										$data_empresa['num_empresa'] = 4;
										$data_empresa['num_empresa_offset'] = 16;
										$data_empresa['key'] = $key;
										$data_empresa['tipo'] = $tipo;
										$data_empresa['title'] = mostrar_palabra(627, $palabras);
										$data_empresa['permiso'] = 24;
										$this->load->view('cobranzas/poner_empresa', $data_empresa);
								echo '</div>';
							}
						}
						echo '</div>';
					}
				  	?>
				  </div>

				</div>
			</div>
		</div>

		<hr>

		<div class="row">
			<div class="col-md-12">
				<div>

				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				  	<?php
					  	$active1="";
					  	$active2="";
					  	$active3="";
					  	$active4="";
				  		$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 4, $operations['cob_usr_tipo_id'], 1);
						if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
						{
							$active1="active";
						  	echo '<li role="presentation" class="active"><a href="#tipo_1" aria-controls="tipo_1" role="tab" data-toggle="tab">';
								echo mostrar_palabra(613, $palabras);
							echo '</a></li>';
						}
						$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 25, $operations['cob_usr_tipo_id'], 1);
						if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
						{
							if($active1=="")
							{
								$active2='active';
							}
							echo '<li role="presentation" class=""><a href="#tipo_5" aria-controls="tipo_5" role="tab" data-toggle="tab">';
								echo mostrar_palabra(669, $palabras);
							echo '</a></li>';
						}
						$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 5, $operations['cob_usr_tipo_id'], 1);
						if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
						{
							if($active1=="" && $active2=="")
							{
								$active3='active';
							}
							echo '<li role="presentation" class=""><a href="#tipo_2" aria-controls="tipo_2" role="tab" data-toggle="tab">';
								echo mostrar_palabra(614, $palabras);
							echo '</a></li>';
						}
						$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 6, $operations['cob_usr_tipo_id'], 1);
						if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
						{
							if($active1=="" && $active2=="" && $active3=="")
							{
								$active4='active';
							}
							echo '<li role="presentation" class=""><a href="#tipo_3" aria-controls="tipo_3" role="tab" data-toggle="tab">';
								echo mostrar_palabra(615, $palabras);
							echo '</a></li>';
						}
				  	?>
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
				  	<?php
				  		echo '<div role="tabpanel" class="tab-pane '.$active1.'" id="tipo_1">';
				  			$this->load->view('cobranzas/beginOperation/beginOperation_productos');
						echo '</div>';

						echo '<div role="tabpanel" class="tab-pane '.$active2.'" id="tipo_5">';
							$this->load->view('cobranzas/beginOperation/beginOperation_otros_servicios');
						echo '</div>';

						echo '<div role="tabpanel" class="tab-pane '.$active3.'" id="tipo_2">';
				  			$this->load->view('cobranzas/beginOperation/beginOperation_transporte');
						echo '</div>';

						echo '<div role="tabpanel" class="tab-pane '.$active4.'" id="tipo_3">';
				  			$this->load->view('cobranzas/beginOperation/beginOperation_seguro');
						echo '</div>';
				  	?>
				  </div>

				</div>
			</div>
		</div>

		<hr>

		<div class="row">
			<div class="col-md-12">
				<div>

				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				  	<?php
				  		$active1="";
					  	$active2="";
					  	$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 26, $operations['cob_usr_tipo_id'], 1);
						if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
						{
							$active1='active';
							echo '<li role="presentation" class="active"><a href="#tipo_6" aria-controls="tipo_6" role="tab" data-toggle="tab">';
								echo mostrar_palabra(656, $palabras);
							echo '</a></li>';
						}
						$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 7, $operations['cob_usr_tipo_id'], 1);
						if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
						{
							if($active1=="")
							{
								$active2='active';
							}
							echo '<li role="presentation" class=""><a href="#tipo_4" aria-controls="tipo_4" role="tab" data-toggle="tab">';
								echo mostrar_palabra(616, $palabras);
							echo '</a></li>';
						}
				  	?>
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
				  	<?php
						echo '<div role="tabpanel" class="tab-pane '.$active1.'" id="tipo_6">';
				  			$this->load->view('cobranzas/beginOperation/beginOperation_comision');
						echo '</div>';
						
						echo '<div role="tabpanel" class="tab-pane '.$active2.'" id="tipo_4">';
				  			$this->load->view('cobranzas/beginOperation/beginOperation_pagos');
				  			$this->load->view('cobranzas/beginOperation/beginOperation_pagos_comisiones');
						echo '</div>';
				  	?>
				  </div>

				</div>
			</div>
		</div>

		<br>

	    <a href="<?=site_url('cobranzas/user_type')?>" class="btn btn-default">Cancelar</a>
	    <button type="submit" class="btn btn-rojo2 pull-right" style="color:#FFF; font-size:14px;">Continuar</button>

	    </form>

	</section>
	<!-- /Lead -->

</main>


<?php
$this->load->view('templates/footer');
?>

<!-- Choosen -->
<link href="<?=base_url()?>assets/css/chosen.min.css" rel="stylesheet">
<script src="<?=base_url()?>assets/js/chosen.jquery.mobile.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/chosen.ajaxaddition.jquery.js"></script>
<style type="text/css">
.chosen-container-single .chosen-single{
  height: 34px;
  line-height: 30px;
}
</style>

<script type="text/javascript">
var subtotal_general = 0;

function cargar_ciudades(num, ctry_code)
{
    $.get('<?=site_url()?>productos/cargar_ciudades_noajax/'+ctry_code, function(resp){
    	$('#ciudad'+num).html(resp);
    });
}

function cargar_ciudades_empresa(ctry_code, usr, emp)
{
    $.get('<?=site_url()?>productos/cargar_ciudades_noajax/'+ctry_code, function(resp){
    	$('#usr_'+usr+'_emp_'+emp+'_item_3').html(resp);
    });
}

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
        	location.href = SITE_URL+'cobranzas/dashboard';
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


function input_text(num=0, display='', id='', name='', type='text', extra='')
{
	var htmlData = '';
	htmlData += '<div class="form-group">';
		htmlData += '<label class="control-label" style="font-weight:normal;">'+display+'</label>';
		htmlData += '<div class="input-group">';
			htmlData += '<input class="form-control" type="'+type+'" value="" id="'+id+'" name="'+name+'" '+extra+'>';
            htmlData += comentarios(0,0,0,0);
        htmlData += '</div>';
    htmlData += '</div>';

    return htmlData;
}

function comentarios(tipo=0, item_id=0, num=0, estado=0, usar_div_group=1)
{
	var disabled = 'disabled';
    if(item_id>0)
    {
        disabled = '';
    }

    var color = '';
    var icono_interno = '';
    if(estado==1)
    {
        color = 'btn-success';
        icono_interno = '<i class="fas fa-check fa-stack-1x" style="color:Tomato"></i>';
    }
    else if(estado==2)
    {
        color = 'btn-rojo2';
        icono_interno = '<i class="fas fa-times fa-stack-1x" style="color:Tomato"></i>';
    }

	var htmlData = '';
	if(usar_div_group == 1)
	{
		htmlData += '<div class="input-group-btn">';
	}
		htmlData += '<button type="button" class="btn '+color+' dropdown-toggle" '+disabled+' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="" data-loading-text="<i class=\'fas fa-sync fa-spin\'></i>">';
			htmlData += '<span class="fa-stack fa-1x" style="font-size:10px;">';
	            htmlData += '<i class="fas fa-comment fa-stack-2x" style="color:#FFF;"></i>';
	            htmlData += icono_interno;
	        htmlData += '</span>';
		htmlData += '</button>';
           //  htmlData += '<ul class="dropdown-menu dropdown-menu-right">';
           //    htmlData += '<li><a href="javascript:abrir_comentar('+num+');"><i class="fas fa-comment"></i> Comentarios</a></li>';
	          // htmlData += '<li><a href="javascript:set_estado_comentario('+num+',1);"><i class="fas fa-thumbs-up"></i> Aprobado</a></li>';
	          // htmlData += '<li><a href="javascript:set_estado_comentario('+num+',2);"><i class="fas fa-thumbs-down"></i> Rechazar</a></li>';
           //  htmlData += '</ul>';
    if(usar_div_group == 1)
	{
    	htmlData += '</div>';
    }

    return htmlData;
}
</script>

<?php
$this->load->view('cobranzas/modal_invitar');
$this->load->view('cobranzas/modal_comentar');
$this->load->view('cobranzas/modal_permisos');
$this->load->view('cobranzas/beginOperation/beginOperation_productos_scripts');
$this->load->view('cobranzas/beginOperation/beginOperation_otros_servicios_scripts');
$this->load->view('cobranzas/beginOperation/beginOperation_transporte_scripts');
$this->load->view('cobranzas/beginOperation/beginOperation_seguro_scripts');
$this->load->view('cobranzas/beginOperation/beginOperation_comision_scripts');
$this->load->view('cobranzas/beginOperation/beginOperation_pagos_scripts');
$this->load->view('cobranzas/beginOperation/beginOperation_pagos_comisiones_scripts');
?>

<script type="text/javascript">
	actualizar_subtotal_productos();
</script>

</body>
</html>