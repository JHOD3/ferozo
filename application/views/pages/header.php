<?php
$pal_ids = array(93, 0, 2, 3, 4, 5, 6, 41, 1, 94, 95, 96, 97, 98, 99, 171);
$palabras_header = $this->palabras_model->get_items_especificos($this->session->userdata('idi_code'), $pal_ids);
?>
<!-- Header -->
<header class="header">
	<div class="container">
		<div class="row">

			<?php
			if($this->session->flashdata('error') != "")
			{
				echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					echo $this->session->flashdata('error');
				echo '</div>';
			}
			?>

			<div class="" id="area_idiomas_index">
					<select class="cs-select cs-skin-elastic" name="idioma[]" id="idioma" onchange="location.href=SITE_URL+'pages/idioma/'+this.value">
						<?php
	                      foreach ($idiomas_completos as $idioma)
	                      {
	                        if($this->session->userdata('idi_code') == $idioma['idi_code'])
	                          $selected = "selected";
	                        else
	                          $selected = "";
	                      	echo "<option value='".$idioma['idi_code']."' data-link='".site_url('pages/idioma/'.$idioma['idi_code'])."' data-class='flag-".$idioma['idi_code']."' ".$selected.">".ucfirst($idioma['idi_desc_'.$idioma['idi_code']])."</option>";
	                      }
	                    ?>
					</select>
					<script src="<?=base_url()?>assets/js/classie.min.js"></script>
					<script src="<?=base_url()?>assets/js/selectFx.min.js"></script>
					<script>
						(function() {
							[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {	
								new SelectFx(el);
							} );
						})();
					</script>
            </div>

			<div class="col-lg-8 col-lg-push-2 text-center">
				
				<a href="<?=site_url()?>"><img id="logo" src='<?=base_url()?>assets/images/logo.png' alt='Sistema'></a>
				<!--<h2></h2>-->
				<p class="lead">
					<?=mostrar_palabra(93, $palabras_header)?>
				</p>

				<div id="result_login">
					<?php
					if($error != "")
						echo $error;
					else
						echo "<br>";
					?>
				</div>

				<div id="area_login">
					<form id="form_login" class="form-inline" role="form" action="#">
						<div class="form-group"><input type="text" class="form-control input-lg" name="mail" placeholder="<?=mostrar_palabra(4, $palabras_header)?>"></div>
						<div class="form-group"><input type="password" class="form-control input-lg" name="clave" placeholder="<?=mostrar_palabra(5, $palabras_header)?>"></div>
						<button type="submit" id="btn_login" class="btn btn-lg btn-default" data-loading-text="<?=mostrar_palabra(41, $palabras_header)?>..."><?=mostrar_palabra(1, $palabras_header)?></button>
						<br><br>
						<!--<a href="<?=site_url('login/login_facebook')?>" id="btn_login_facebook" class="btn btn-lg btn-facebook" data-loading-text="<?=mostrar_palabra(41, $palabras_header)?>..."><i class="fab fa-lg fa-facebook-square"></i> <?=mostrar_palabra(1, $palabras_header)?></a>-->
						<a href="<?=site_url('login_google')?>" id="btn_login_google" class="btn btn-lg btn-google-plus" data-loading-text="<?=mostrar_palabra(41, $palabras_header)?>..."><i class="fab fa-lg fa-google-plus-square"></i> <?=mostrar_palabra(1, $palabras_header)?></a>
					</form>
					<p class="small"><?=mostrar_palabra(94, $palabras_header)?> <a onclick="ver_olvide()" style="color:#FFFFFF"><?=mostrar_palabra(95, $palabras_header)?></a></p>
					<p class="small"><?=mostrar_palabra(96, $palabras_header)?> <a onclick="ver_registro()" style="color:#FFFFFF"><?=mostrar_palabra(97, $palabras_header)?></a></p>
				</div>

				<div id="area_olvide" style="display:none">
					<form id="form_olvide" class="form-inline" role="form" action="#">
						<div class="form-group"><input type="text" class="form-control input-lg" name="mail" placeholder="<?=mostrar_palabra(4, $palabras_header)?>"></div>
						<button type="submit" id="btn_olvide" class="btn btn-lg btn-default" data-loading-text="<?=mostrar_palabra(41, $palabras_header)?>..."><?=mostrar_palabra(6, $palabras_header)?></button>
					</form>
					<p class="small"><?=mostrar_palabra(96, $palabras_header)?> <a onclick="ver_registro()" style="color:#FFFFFF"><?=mostrar_palabra(97, $palabras_header)?></a></p>
				</div>

				<div id="area_registro" style="display:none">
					<form id="form_registro" class="form-horizontal col-sm-offset-2 col-sm-8" role="form" action="#">
						<div class="form-group" style="margin-bottom:10px;">
							<div class="col-sm-6">
								<select class="form-control input-lg" name='pais' id="pais_registro">
									<?php
									echo "<option value='' selected disabled style='display:none;'>".mostrar_palabra(2, $palabras_header)."</option>";
									foreach ($paises as $key => $pais)
									{
										echo "<option value='".$pais['ctry_code']."'>".$pais['ctry_nombre']."</option>";
									}
									?>
								</select>
							</div>
							<div class="col-sm-6">
								<select class="form-control input-lg" name='idioma' id="idioma_registro">
									<?php
									echo "<option value='' selected disabled style='display:none;'>".mostrar_palabra(3, $palabras_header)."</option>";
									foreach ($idiomas as $key => $idioma)
									{
										if($this->session->userdata('idi_code') == $idioma['idi_code'])
				                          $selected = "selected";
				                        else
				                          $selected = "";
										echo "<option value='".$idioma['idi_code']."' ".$selected.">".ucfirst($idioma['idi_desc'])."</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group" style="margin-bottom:10px;">
							<div class="col-sm-12">
								<input type="text" class="form-control input-lg" name="mail" placeholder="<?=mostrar_palabra(4, $palabras_header)?>">
							</div>
						</div>
						<div class="form-group" style="margin-bottom:10px;">
							<div class="col-sm-6">
								<input type="password" class="form-control input-lg" name="clave" placeholder="<?=mostrar_palabra(5, $palabras_header)?>">
							</div>
							<div class="col-sm-6">
								<input type="password" class="form-control input-lg" name="clave2" placeholder="<?=mostrar_palabra(6, $palabras_header)?> <?=mostrar_palabra(5, $palabras_header)?>">
							</div>
						</div>
						<div class="form-group" style="margin-bottom:5px;">
    						<div class="col-sm-12">
								<div class="checkbox" style="margin-bottom:10px;">
								    <label>
								    	<input type="checkbox" name="acepto"> <a href="<?=site_url()?>pages/servicio" style="color:#FFFFFF"><?=mostrar_palabra(171, $palabras_header)?></a>
								    </label>
								</div>
							</div>
						</div>
						<div class="form-group" style="margin-bottom:5px;">
							<button type="submit" id="btn_registro" class="btn btn-lg btn-default" data-loading-text="<?=mostrar_palabra(41, $palabras_header)?>..."><?=mostrar_palabra(0, $palabras_header)?></button>
							<!--<a href="<?=site_url('login/login_facebook')?>" id="btn_login_facebook" class="btn btn-lg btn-facebook" data-loading-text="<?=mostrar_palabra(41, $palabras_header)?>..."><i class="fab fa-lg fa-facebook-square"></i> <?=mostrar_palabra(0, $palabras_header)?></a>-->
							<a href="javascript: validar_google();" id="btn_registro_google" class="btn btn-lg btn-google-plus" data-loading-text="<?=mostrar_palabra(41, $palabras_header)?>..."><i class="fab fa-lg fa-google-plus-square"></i> <?=mostrar_palabra(0, $palabras_header)?></a>
						</div>
					</form>
					<p class="col-xs-12 small"><?=mostrar_palabra(98, $palabras_header)?> <a onclick="ver_login()" style="color:#FFFFFF"><?=mostrar_palabra(99, $palabras_header)?></a></p>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- /Header -->
