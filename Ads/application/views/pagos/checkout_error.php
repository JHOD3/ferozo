<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<?php
$this->load->view('templates/head');
?>

<body>
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<?php
		$this->load->view('templates/header');
		$this->load->view('templates/menu');
		?>
		
		<!-- begin #content -->
        <div id="content" class="content">
            <?php
            $this->load->view('templates/title');
            ?>

            <!-- BEGIN #checkout-cart -->
            <div class="section-container" id="checkout-cart">
                <!-- BEGIN container -->
                <div class="container-fluid">
                    <!-- BEGIN checkout -->
                    <div class="col-lg-8 col-lg-offset-2 checkout" style="padding:0px;">
                        <form action="#" method="POST" name="form_checkout" id="paymentFrm">
                            <!-- BEGIN checkout-header -->
                            <div class="checkout-header">
                                <!-- BEGIN row -->
                                <div class="row">
                                    <!-- BEGIN col-3 -->
                                    <div class="col-md-3 col-sm-3">
                                        <div class="step">
                                            <a href="#">
                                                <div class="number">1</div>
                                                <div class="info">
                                                    <div class="title"><?=ucfirst(mostrar_palabra(540, $palabras))?></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END col-3 -->
                                    <!-- BEGIN col-3 -->
                                    <div class="col-md-3 col-sm-3">
                                        <div class="step">
                                            <a href="#">
                                                <div class="number">2</div>
                                                <div class="info">
                                                    <div class="title"><?=ucfirst(mostrar_palabra(541, $palabras))?></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END col-3 -->
                                    <!-- BEGIN col-3 -->
                                    <div class="col-md-3 col-sm-3">
                                        <div class="step">
                                            <a href="#">
                                                <div class="number">3</div>
                                                <div class="info">
                                                    <div class="title"><?=ucfirst(mostrar_palabra(542, $palabras))?></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END col-3 -->
                                    <!-- BEGIN col-3 -->
                                    <div class="col-md-3 col-sm-3">
                                        <div class="step active">
                                            <a href="#">
                                                <div class="number">4</div>
                                                <div class="info">
                                                    <div class="title"><?=ucfirst(mostrar_palabra(543, $palabras))?></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END col-3 -->
                                </div>
                                <!-- END row -->
                            </div>
                            <!-- END checkout-header -->
                            <!-- BEGIN checkout-body -->
                            <div class="checkout-body">
                                <div id="area_errores">
                                    <?php
                                    if($error)
                                    {
                                        echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                        echo $error;
                                        echo '</div>';
                                    }
                                    if($this->session->flashdata('error') != "")
                                    {
                                        echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                        echo $this->session->flashdata('error');
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                                <!-- BEGIN checkout-message -->
                                <div class="checkout-message">
                                    <h1><?=mostrar_palabra(557, $palabras)?>! <small><?=mostrar_palabra(558, $palabras)?></small></h1>
                                    <p class="text-muted text-center m-b-0"><?=str_replace('X@X.com', 'contact@nocnode.com', mostrar_palabra(115, $palabras))?></p>
                                </div>
                                <!-- END checkout-message -->
                            </div>
                            <!-- END checkout-body -->
                            <!-- BEGIN checkout-footer -->
                            <div class="checkout-footer text-center">
                                <a href="<?=site_url('pagos')?>" class="btn btn-white btn-lg p-l-30 p-r-30 m-l-10"><?=ucfirst(mostrar_palabra(556, $palabras))?></a>
                            </div>
                            <!-- END checkout-footer -->
                        </form>
                    </div>
                    <!-- END checkout -->
                    <div class="col-lg-8 col-lg-offset-2" style="padding:20px 0px">
                        <a href="https://www.nocnode.com/pages/servicio" target="_blank"><?=mostrar_palabra(170, $palabras)?></a><br>
                        <a href="https://www.nocnode.com/pages/privacidad" target="_blank"><?=mostrar_palabra(117, $palabras)?></a>
                    </div>
                </div>
                <!-- END container -->
            </div>
            <!-- END #checkout-cart -->
        
        </div>
        <!-- end #content -->
		
		<?php
		$this->load->view('templates/footer');
		?>
	</div>
	<!-- end page container -->
	
	<?php
	$this->load->view('templates/scripts');
	?>

</body>
</html>
