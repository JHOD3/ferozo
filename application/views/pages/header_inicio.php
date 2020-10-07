<?php
$pal_ids = array(93, 0, 2, 3, 4, 5, 6, 41, 1, 94, 95, 96, 97, 98, 99, 171);
$palabras_header = $this->palabras_model->get_items_especificos($this->session->userdata('idi_code'), $pal_ids);
?>
<!-- Header -->
<header>
    <nav class="navbar navbar-expand-lg navbar-light container-nocnode align-items-start">
        <a class="navbar-brand" href="#">
            <img id="logo" src='<?=base_url()?>assets/images/logo.png' alt='Sistema'>
        </a>
        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#area_login" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars text-white" style="font-size: 27px;"></i>
        </button>
        <div class="collapse navbar-collapse ml-md-auto py-2" id="area_login">
            <form id="form_login" class="navbar-form align-items-start d-md-flex d-block ml-auto" role="form" action="#">
                <div class="form-group mb-md-0 mt-4 mt-md-0">
                    <input type="text" class="form-control form-control-sm" name="mail" placeholder="<?=mostrar_palabra(4, $palabras_header)?>">
                    <p class="small mt-1 mb-md-0"><?=mostrar_palabra(96, $palabras_header)?> <a onclick="ver_registro()" style="color:#FFFFFF"><?=mostrar_palabra(97, $palabras_header)?></a></p>
                </div>
                <div class="form-group mb-md-0 mx-md-3">
                    <input type="password" class="form-control form-control-sm" name="clave" placeholder="<?=mostrar_palabra(5, $palabras_header)?>">
                    <p class="small mt-1 mb-md-0"><?=mostrar_palabra(94, $palabras_header)?> <a onclick="ver_olvide()" style="color:#FFFFFF"><?=mostrar_palabra(95, $palabras_header)?></a></p>
                </div>
                <div class="form-group mb-md-0 d-flex">
                    <button type="submit" id="btn_login" class="btn btn-light h-25 btn-sm-a" data-loading-text="<?=mostrar_palabra(41, $palabras_header)?>..."><?=mostrar_palabra(1, $palabras_header)?></button>
                    <a href="<?=site_url('login_google')?>" id="btn_login_google" class="btn btn-google-plus ml-2 h-25 d-flex btn-sm-a" data-loading-text="<?=mostrar_palabra(41, $palabras_header)?>...">
                        <i class="fab fa-lg fa-google-plus-square align-items-center d-flex mr-2"></i> 
                        <?=mostrar_palabra(1, $palabras_header)?>
                    </a>
                    <div class="ml-3 idiomas-btn btn-sm-a" >
                        <select class="cs-select cs-skin-elastic" name="idioma[]" id="idioma" onchange="location.href=SITE_URL+'pages/idioma/'+this.value">
                            <?php
                                foreach ($idiomas_completos as $idioma){
                                    if($this->session->userdata('idi_code') == $idioma['idi_code'])
                                        $selected = "selected";
                                    else
                                        $selected = "";
                                        echo "<option value='".$idioma['idi_code']."' data-link='".site_url('pages/idioma/'.$idioma['idi_code'])."' data-class='flag-".$idioma['idi_code']."' ".$selected.">".ucfirst($idioma['idi_code'])."</option>";
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
                </div>
            </form>
        </div>
    </nav>

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
		</div>
	</div>
</header>
<!-- /Header -->
