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
                                    echo validation_errors();
                                    ?>
                                </div>
                                <!-- BEGIN checkout-message -->
                                <div class="checkout-message">
                                    <h1><?=mostrar_palabra(549, $palabras)?>! <small><?=mostrar_palabra(550, $palabras)?></small></h1>
                                    <div class="table-responsive2">
                                        <table class="table table-payment-summary">
                                            <tbody>
                                                <tr>
                                                    <td class="field"><?=mostrar_palabra(551, $palabras)?></td>
                                                    <td class="value"><?=$pago['pago_est_descripcion']?></td>
                                                </tr>
                                                <tr>
                                                    <td class="field"><?=mostrar_palabra(552, $palabras)?></td>
                                                    <td class="value"><?=$pago['pago_codigo']?></td>
                                                </tr>
                                                <tr>
                                                    <td class="field"><?=mostrar_palabra(553, $palabras)?></td>
                                                    <td class="value"><?=$pago['pago_fecha']?></td>
                                                </tr>
                                                <tr>
                                                    <td class="field"><?=mostrar_palabra(554, $palabras)?></td>
                                                    <td class="value product-summary">
                                                        <div class="product-summary-img">
                                                            <img src="<?=base_url($producto['img'])?>" alt="" width="100px" />
                                                        </div>
                                                        <div class="product-summary-info">
                                                            <div class="title"><?=$producto['title']?></div>
                                                            <div class="desc"><?=$producto['desc']?></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="field"><?=mostrar_palabra(555, $palabras)?> (USD)</td>
                                                    <td class="value">$ <?=$pago['pago_cantidad']?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
