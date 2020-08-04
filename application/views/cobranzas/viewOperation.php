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
						<a class="btn btn-danger pull-right" href="<?=site_url('cobranzas/dashboard')?>" style="color:#FFF; font-size:14px;">Dashboard</a>
						<h3 class="panel-title">Cobranza Documentaria</h3>
					</div>
				</div>
				
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
				    <div class="media-heading" style="margin-top: 20px; font-family: 'Gotham-Bold'; font-size: 24px;">
				    	<?=$operations['cob_nombre']?><br>
				    	<span style="font-size:14px; color:#999;"><?=$operations['cob_descripcion']?></span>
				    </div>
				  </div>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-md-12">
				<div>

				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				  	<?php
				  	foreach ($tipos as $key => $tipo)
					{
						$active = "";
						if($key == 0)
						{
							$active = "active";
						}
						echo '<li role="presentation" class="'.$active.'"><a href="#type_'.$tipo['cob_usr_tipo_id'].'" aria-controls="type_'.$tipo['cob_usr_tipo_id'].'" role="tab" data-toggle="tab">'.$tipo['cob_usr_tipo_desc'].' ';
						if($tipo['usuario'])
						{
							echo '('.$tipo['usuario']['usr_mail'].')';
						}
						else
						{
							echo ' &nbsp; <button class="btn btn-xs btn-danger" onclick="ver_modal_invitar('.$tipo['cob_usr_tipo_id'].')">Invitar</button>';
						}
						echo '</a></li>';
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
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(617, $palabras).' <button class="btn btn-xs btn-default" onclick="abrir_permisos();"><i class="fas fa-unlock" aria-hidden="true"></i></button></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 1);"');
									echo '<div class="form-group" id="ciudad_1"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '', '', 'has-success');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '', '', 'has-error');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '', '', 'has-warning');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(621, $palabras).' <button class="btn btn-xs btn-default" onclick="abrir_permisos();"><i class="fas fa-unlock" aria-hidden="true"></i></button></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 2);"');
									echo '<div class="form-group" id="ciudad_2"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(611, $palabras).'</div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(624, $palabras).' <button class="btn btn-xs btn-default" onclick="abrir_permisos();"><i class="fas fa-unlock" aria-hidden="true"></i></button></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 3);"');
									echo '<div class="form-group" id="ciudad_3"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(612, $palabras).'</div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(627, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 4);"');
									echo '<div class="form-group" id="ciudad_4"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
						}
						elseif($tipo['cob_usr_tipo_id'] == 2)
						{
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(610, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(618, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 5);"');
									echo '<div class="form-group" id="ciudad_5"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(622, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 6);"');
									echo '<div class="form-group" id="ciudad_6"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(623, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 7);"');
									echo '<div class="form-group" id="ciudad_7"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(611, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(625, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 8);"');
									echo '<div class="form-group" id="ciudad_8"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(612, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(627, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 9);"');
									echo '<div class="form-group" id="ciudad_9"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
						}
						elseif($tipo['cob_usr_tipo_id'] == 3)
						{
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(610, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(619, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 10);"');
									echo '<div class="form-group" id="ciudad_10"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(611, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(624, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 11);"');
									echo '<div class="form-group" id="ciudad_11"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(612, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(627, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 12);"');
									echo '<div class="form-group" id="ciudad_12"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
						}
						elseif($tipo['cob_usr_tipo_id'] == 4)
						{
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(610, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(619, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 13);"');
									echo '<div class="form-group" id="ciudad_13"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(621, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 14);"');
									echo '<div class="form-group" id="ciudad_14"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(611, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(624, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 15);"');
									echo '<div class="form-group" id="ciudad_15"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(625, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 16);"');
									echo '<div class="form-group" id="ciudad_16"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
							echo '<div class="row" style="margin-left:0px;">';
								echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(612, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
								echo '<div class="col-xs-3">';
									echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(627, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 13, $palabras), 'nombre', 'text', '');
									input_select(mostrar_palabra(  2, $palabras), 'ctry_code', $paises, '', 'ctry_code', 'ctry_nombre', 'onchange="cargar_ciudades(this.value, 17);"');
									echo '<div class="form-group" id="ciudad_17"></div>';
									input_text(mostrar_palabra(130, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(131, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
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
				  	echo '<li role="presentation" class="active"><a href="#tipo_1" aria-controls="tipo_1" role="tab" data-toggle="tab">';
						echo mostrar_palabra(613, $palabras);
					echo '</a></li>';
					echo '<li role="presentation" class=""><a href="#tipo_2" aria-controls="tipo_2" role="tab" data-toggle="tab">';
						echo mostrar_palabra(614, $palabras);
					echo '</a></li>';
					echo '<li role="presentation" class=""><a href="#tipo_3" aria-controls="tipo_3" role="tab" data-toggle="tab">';
						echo mostrar_palabra(615, $palabras);
					echo '</a></li>';
					echo '<li role="presentation" class=""><a href="#tipo_4" aria-controls="tipo_4" role="tab" data-toggle="tab">';
						echo mostrar_palabra(616, $palabras);
					echo '</a></li>';
				  	?>
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
				  	<?php
				  		echo '<div role="tabpanel" class="tab-pane active" id="tipo_1">';
				  			echo '<div class="row" style="margin-left:0px; margin-top:20px;">';
								//echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(613, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
				  				echo '<div class="col-xs-12">';
				  					echo '<button class="btn btn-success"><i class="fas fa-plus"></i></button>';
				  				echo '</div>';
								echo '<div class="col-xs-3">';
								?>
								<div class="form-group <?php if(form_error('arancel')) echo 'has-error';?>">
					                <label for="arancel"><i class="fa fa-code fa-lg texto-bordo2"></i> <?=mostrar_palabra(22, $palabras)?></label>
					                <!--<button type='button' data-toggle="modal" data-target="#modal-search" class='btn btn-danger btn-xs pull-right flip'><i class='fa fa-search'></i></button>-->
					                <div class="input-group" style="width:100%;">
					                  <select data-placeholder="<?=mostrar_palabra(245, $palabras)?>..." class="chosen-select form-control" name="arancel" id="arancel">
					                    <option value=""></option>
					                  </select>
					                </div>
					            </div>
								<?php
									//echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(627, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra( 27, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(628, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(629, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(249, $palabras), 'mail', 'text', '');
									input_text(mostrar_palabra(417, $palabras), 'mail', 'text', '');
									input_text(mostrar_palabra(630, $palabras), 'mail', 'text', '');
									input_text(mostrar_palabra(631, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
						echo '</div>';
						echo '<div role="tabpanel" class="tab-pane" id="tipo_2">';
				  			echo '<div class="row" style="margin-left:0px; margin-top:20px;">';
								//echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(614, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
								echo '<div class="col-xs-3">';
									//echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(627, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra(632, $palabras), 'nombre', 'text', '');
									input_text(mostrar_palabra(633, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(634, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(635, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(636, $palabras), 'mail', 'text', '');
									input_text(mostrar_palabra(637, $palabras), 'mail', 'text', '');
									input_text(mostrar_palabra(638, $palabras), 'mail', 'text', '');
									input_text(mostrar_palabra(639, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
						echo '</div>';
						echo '<div role="tabpanel" class="tab-pane" id="tipo_3">';
				  			echo '<div class="row" style="margin-left:0px; margin-top:20px;">';
								//echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(615, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
								echo '<div class="col-xs-3">';
									//echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(627, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra(626, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(640, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(641, $palabras), 'telefono', 'text', '');
									input_text(mostrar_palabra(642, $palabras), 'mail', 'text', '');
									input_text(mostrar_palabra(133, $palabras), 'mail', 'text', '');
									input_text(mostrar_palabra(  4, $palabras), 'mail', 'text', '');
								echo '</div>';
							echo '</div>';
						echo '</div>';
						echo '<div role="tabpanel" class="tab-pane" id="tipo_4">';
				  			echo '<div class="row" style="margin-left:0px; margin-top:20px;">';
								//echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(616, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
								echo '<div class="col-xs-3">';
									//echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(627, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
									input_text(mostrar_palabra(643, $palabras), 'cp', 'text', '');
									input_text(mostrar_palabra(542, $palabras), 'direccion', 'text', '');
									input_text(mostrar_palabra(644, $palabras), 'telefono', 'text', '');

									input_text('Flete internacional', 'telefono', 'text', '');
									input_text('Seguro internacional', 'telefono', 'text', '');
									input_text('Inland origen', 'telefono', 'text', '');
									input_text('Inland destino', 'telefono', 'text', '');
									input_text('Servicios adicionales', 'telefono', 'text', '');
								echo '</div>';
							echo '</div>';
						echo '</div>';
				  	?>
				  </div>

				</div>
			</div>
		</div>

	</section>
	<!-- /Lead -->

</main>


<!-- Modal -->
<div class="modal fade" id="modal_invitar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Invitar</h4>
      </div>

      <form id="form_invitar" method="POST" action="#">
        <div class="modal-body">
          <div id="mensaje_referenciar"></div>
          <input type="hidden" value="<?=$operations['cob_id']?>" name="cob_id" id="invitar_cob_id">
          <input type="hidden" value="" name="cob_usr_tipo_id" id="invitar_cob_usr_tipo_id">
          <input type="text" class="form-control" value="" name="mail" id="invitar_mail">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(29, $palabras)?></button>
          <button type="submit" class="btn btn-danger" id="btn_referenciar"><?=mostrar_palabra(17, $palabras)?></button>
        </div>
      </form>

    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_comentar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Comentar</h4>
      </div>

      <form id="form_invitar" method="POST" action="#">
        <div class="modal-body">
          <div id="mensaje_referenciar"></div>
          <textarea class="form-control" value="" name="" id=""></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(29, $palabras)?></button>
          <button type="submit" class="btn btn-danger" id="btn_referenciar"><?=mostrar_palabra(17, $palabras)?></button>
        </div>
      </form>

    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_permisos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Permisos</h4>
      </div>

      <form id="form_permisos" method="POST" action="#">
        <div class="modal-body">
          <table class="table">
          	<?php
          	echo '<tr>';
				echo '<th></th>';
				foreach ($tipos as $key => $tipo)
				{
					echo '<th>'.$tipo['cob_usr_tipo_desc'].'</th>';
				}
			echo '</tr>';
			echo '<tr>';
				echo '<td>Ver</td>';
				foreach ($tipos as $key => $tipo)
				{
					echo '<td><input type="checkbox"></td>';
				}
			echo '</tr>';
			echo '<tr>';
				echo '<td>Comentar</td>';
				foreach ($tipos as $key => $tipo)
				{
					echo '<td><input type="checkbox"></td>';
				}
			echo '</tr>';
			echo '<tr>';
				echo '<td>Editar</td>';
				foreach ($tipos as $key => $tipo)
				{
					echo '<td><input type="checkbox"></td>';
				}
			echo '</tr>';
          	?>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(29, $palabras)?></button>
          <button type="submit" class="btn btn-danger" id="btn_referenciar"><?=mostrar_palabra(17, $palabras)?></button>
        </div>
      </form>

    </div>
  </div>
</div>


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
$('.chosen-select').ajaxChosen({
  dataType: 'json',
  type: 'POST',
  url:'<?=site_url()?>productos/buscar_posiciones_ajax'
},{
  loadingImg: '<?=base_url()?>assets/js/loading.png',
  minLength: 2
},{
  no_results_text: "<?=mostrar_palabra(246, $palabras)?> <i class='fa fa-search'></i>"
});

function cargar_ciudades(ctry_code, num)
{
	$.get('<?=site_url()?>productos/cargar_ciudades_noajax/'+ctry_code, function(resp){
		var htmlData = "<label style='font-weight:normal;'><?=mostrar_palabra( 32, $palabras)?></label>";
		htmlData += "<select class='form-control'>";
		htmlData += resp;
		htmlData += "</select>";
		$('#ciudad_'+num).html(htmlData);
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

function ver_modal_invitar(tipo)
{
	$('#invitar_cob_usr_tipo_id').val(tipo);
	$('#modal_invitar').modal('show');
}

$( "#form_invitar" ).submit(function( event ) {
  event.preventDefault();
  $("#mensaje_referenciar").html("");
  $('#btn_referenciar').button('loading');
  $.ajax({
     type: 'post',
     dataType: "json",
     data: $(event.target).serialize(),
     cache: false,
     url: SITE_URL+"cobranzas/invitar_ajax",
     success: function(data){
        if(data.error == false)
        {
          var htmlData = '<div class="alert with-icon alert-success" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
          htmlData += data.data;
          htmlData += '</div>';
          $("#mensaje_referenciar").html(htmlData);
        }
        else
        {
          var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
          htmlData += data.data;
          htmlData += '</div>';
          $("#mensaje_referenciar").html(htmlData);
        }
        $('#btn_referenciar').button('reset');
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        $("#mensaje_referenciar").html(htmlData);
        $('#btn_referenciar').button('reset');
      }
  });
});

function abrir_permisos()
{
	$('#modal_permisos').modal('show');
}

function abrir_comentar()
{
	$('#modal_comentar').modal('show');
}
</script>

</body>
</html>