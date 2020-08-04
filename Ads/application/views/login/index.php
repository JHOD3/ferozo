<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<?php
$this->load->view('templates/head');
?>
<body class="pace-top" style="background-color:#333">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<div class="login-cover">
	    <div class="login-cover-image"><img src="<?=base_url('assets/img/header.jpg')?>" data-id="login-cover-image" alt="" /></div>
	    <!--<div class="login-cover-bg"></div>-->
	</div>

    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login login-v2" data-pageload-addclass="animated fadeIn">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <span class="logo"><img src="<?=base_url('assets/img/logo.png')?>" style="width: 210px;"></span> Ads
                </div>
            </div>
            <!-- end brand -->
            <div class="login-content">
                <?php 
                    echo validation_errors();
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
                <form action="<?=site_url('login')?>" method="POST" class="margin-bottom-0">
                    <div class="form-group m-b-20">
                        <input type="text" class="form-control input-lg" placeholder="Usuario" name="usuario" value="<?=$this->input->post('usuario')?>" />
                    </div>
                    <div class="form-group m-b-20">
                        <input type="password" class="form-control input-lg" placeholder="Contraseña" name="clave" />
                    </div>
                    <!--
                    <div class="checkbox m-b-20">
                        <label>
                            <input type="checkbox" /> Remember Me
                        </label>
                    </div>
                    -->
                    <div class="login-buttons">
                        <button type="submit" class="btn btn-default btn-block btn-lg">Ingresar</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end login -->
    </div>
    <!-- end page container -->
	
	<?php
	$this->load->view('templates/scripts');
	?>
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="<?=base_url()?>assets/js/login-v2.demo.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->

	<script>
		$(document).ready(function() {
			LoginV2.init();
		});
	</script>
</body>
</html>