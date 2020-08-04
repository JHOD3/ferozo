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
				<a class="btn btn-danger pull-right" href="<?=site_url('cobranzas/dashboard')?>"><?=mostrar_palabra(679, $palabras)?></a>
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
				    <img src="<?=base_url('assets/images/cobranza/icono2.png')?>" width="80px">
				  </div>
				  <div class="media-body">
				    <div class="media-heading-cobranza">
				    	<?=mostrar_palabra(773, $palabras)?>
				    	<br>
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

				<form action="<?=site_url('cobranzas/editPermisos/'.$operations['cob_id'])?>" method="POST">
					<input type="hidden" value="1" name="nada">
					<table class="table">
						<?php
						echo '<tr>';
							echo '<th></th>';
							foreach ($tipos as $key => $tipo)
							{
								echo '<th>'.$tipo['cob_usr_tipo_desc'].'</th>';
							}
						echo '</tr>';

						foreach ($tipos_permisos as $key_tipo_per => $tipo_permiso)
						{
							echo '<tr>';
								echo '<th>';
									echo $tipo_permiso['pal_desc'];
									if($tipo_permiso['cob_per_tipo_id'] == 9)
									{
										echo '('.mostrar_palabra(654, $palabras).')';
									}
									elseif($tipo_permiso['cob_per_tipo_id'] == 10)
									{
										echo '('.mostrar_palabra(620, $palabras).')';
									}
									elseif($tipo_permiso['cob_per_tipo_id'] == 11)
									{
										echo '('.mostrar_palabra(654, $palabras).')';
									}
									elseif($tipo_permiso['cob_per_tipo_id'] == 12)
									{
										echo '('.mostrar_palabra(619, $palabras).')';
									}
									elseif($tipo_permiso['cob_per_tipo_id'] == 13)
									{
										echo '('.mostrar_palabra(620, $palabras).')';
									}
									elseif($tipo_permiso['cob_per_tipo_id'] == 15)
									{
										echo '('.mostrar_palabra(619, $palabras).')';
									}
									elseif($tipo_permiso['cob_per_tipo_id'] == 16)
									{
										echo '('.mostrar_palabra(620, $palabras).')';
									}
									elseif($tipo_permiso['cob_per_tipo_id'] == 19)
									{
										echo '('.mostrar_palabra(655, $palabras).')';
									}
									elseif($tipo_permiso['cob_per_tipo_id'] == 20)
									{
										echo '('.mostrar_palabra(620, $palabras).')';
									}
									elseif($tipo_permiso['cob_per_tipo_id'] == 21)
									{
										echo '('.mostrar_palabra(654, $palabras).')';
									}
									elseif($tipo_permiso['cob_per_tipo_id'] == 22)
									{
										echo '('.mostrar_palabra(655, $palabras).')';
									}
									elseif($tipo_permiso['cob_per_tipo_id'] == 23)
									{
										echo '('.mostrar_palabra(619, $palabras).')';
									}
									elseif($tipo_permiso['cob_per_tipo_id'] == 24)
									{
										echo '('.mostrar_palabra(620, $palabras).')';
									}
								echo '</th>';
								foreach ($tipo_permiso['tipos_usuarios'] as $key => $tipo)
								{
									$disabled = "";
									if($tipo_permiso['cob_per_tipo_id'] == 1 && $tipo['cob_usr_tipo_id'] == $usuario['cob_usr_tipo_id'])
									{
										$disabled = "disabled";
									}
									if(!$permiso_editar || $permiso_editar['cob_per_activo'] == 0)
									{
										$disabled = "disabled";
									}

									echo '<td>';
									if($tipo['permisos'])
									{
										foreach ($tipo['permisos'] as $key_per => $permiso)
										{
											$checked = "";
											if($permiso['cob_per_activo']==1)
											{
												$checked = "checked";
											}

											if($disabled == "disabled")
											{
												echo '<input type="hidden" name="per_'.$permiso['cob_per_id'].'" value="'.$permiso['cob_per_activo'].'">';
											}
											
											echo '<div class="checkbox '.$disabled.'">
												    <label>
												      <input type="checkbox" '.$checked.' name="per_'.$permiso['cob_per_id'].'" value="1" '.$disabled.'> '.$permiso['cob_per_acc_descripcion'].'
												    </label>
												  </div>';
										}
									}
									else
									{
										//echo '<td></td>';
									}
									echo '</td>';
								}
							echo '</tr>';
						}
						?>
					</table>

					<a href="<?=site_url('cobranzas/dashboard')?>" class="btn btn-default"><?=mostrar_palabra(29, $palabras)?></a>
					<?php
					if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
					{
						echo '<button type="submit" class="btn btn-rojo2">'.mostrar_palabra(17, $palabras).'</button>';
					}
					?>
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