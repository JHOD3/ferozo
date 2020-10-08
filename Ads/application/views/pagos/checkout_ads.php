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
                                        <div class="step active">
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
                                        <div class="step">
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
                                    //echo validation_errors();
                                    ?>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-cart">
                                        <?php
                                        $hidden = '';
                                        if($producto['pago_destino'] == PAGO_DESTINO_ADS)
                                        {
                                            $hidden = 'style="display:none"';
                                        }

                                        echo '<thead>';
                                            echo '<tr>';
                                                echo '<th>'.mostrar_palabra(412, $palabras).'</th>';
                                                echo '<th '.$hidden.'>'.mostrar_palabra(544, $palabras).'</th>';
                                                echo '<th class="text-center">'.mostrar_palabra(555, $palabras).' (USD)</th>';
                                            echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                            echo '<tr>';
                                                echo '<td class="cart-product">
                                                    <div class="product-img">
                                                        <img src="'.base_url($producto['img']).'" alt="" width="100px" />
                                                    </div>
                                                    <div class="product-info">
                                                        <div class="title">'.$producto['title'].'</div>
                                                        <div class="desc">'.$producto['desc'].'</div>
                                                    </div>
                                                </td>';

                                                echo '<input type="hidden" name="pago_destino" value="'.$producto['pago_destino'].'" id="pago_destino" />';
                                                echo '<input type="hidden" name="producto" value="'.$producto['desc'].'" id="producto" />';

                                                echo '<td class="cart-qty text-center" '.$hidden.'>';
                                                    echo '<div class="cart-qty-input">';
                                                        $class_error = '';
                                                        if(form_error('cantidad'))
                                                        {
                                                            $class_error = 'parsley-error';
                                                        }
                                                        echo '<input type="number" name="cantidad" id="cantidad" step="1" value="'.$producto['cantidad'].'" class="form-control '.$class_error.'" placeholder="1" onchange="calcular_total()" onkeyup="calcular_total()"/>';
                                                    echo '</div>';
                                                echo '</td>';
                                                echo '<td class="cart-qty text-center">';
                                                    echo '<div class="cart-qty-input">';
                                                        $class_error = '';
                                                        if(form_error('amount'))
                                                        {
                                                            $class_error = 'parsley-error';
                                                        }
                                                        echo '<input type="text" name="amount" id="amount" value="'.$producto['price'].'" class="form-control '.$class_error.'" placeholder="100" '.$producto['readonly'].' onchange="calcular_total()" onkeyup="calcular_total()"/>';
                                                    echo '</div>';
                                                echo '</td>';
                                            echo '</tr>';
                                            
                                            echo '<tr>
                                                <td class="cart-summary" colspan="4">
                                                    <div class="summary-container">
                                                        <div class="summary-row total">
                                                            <div class="field">'.mostrar_palabra(546, $palabras).'</div>
                                                            <div class="value" id="total">$ 0</div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>';
                                            
                                        echo '</tbody>';
                                        ?>
                                    </table>
                                </div>
                            </div>
                            <!-- END checkout-body -->
                            <!-- BEGIN checkout-footer -->
                            <div class="checkout-footer">
                                <!--<a href="#" class="btn btn-white btn-lg pull-left">Continue Shopping</a>-->
                                <button type="submit" class="btn btn-inverse btn-lg p-l-30 p-r-30 m-l-10"><?=mostrar_palabra(518, $palabras)?></button>
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

<script type="text/javascript">
    function calcular_total()
    {
        var total = 0;
        total = parseInt($('#cantidad').val()) * parseFloat($('#amount').val());
        if(!$.isNumeric(total))
        {
            total = 0;
        }
        $('#total').html('$ '+parseFloat(total));
    }

    calcular_total();
</script>

</body>
</html>
