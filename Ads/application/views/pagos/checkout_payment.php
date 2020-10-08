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
                                            <a href="<?=site_url('pagos/checkout_ads')?>">
                                                <div class="number">1</div>
                                                <div class="info">
                                                    <div class="title"><?=mostrar_palabra(539, $palabras)?></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END col-3 -->
                                    <!-- BEGIN col-3 -->
                                    <div class="col-md-3 col-sm-3">
                                        <div class="step">
                                            <a href="<?=site_url('pagos/checkout_info')?>">
                                                <div class="number">2</div>
                                                <div class="info">
                                                    <div class="title"><?=mostrar_palabra(540, $palabras)?></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END col-3 -->
                                    <!-- BEGIN col-3 -->
                                    <div class="col-md-3 col-sm-3">
                                        <div class="step active">
                                            <a href="#">
                                                <div class="number">3</div>
                                                <div class="info">
                                                    <div class="title"><?=mostrar_palabra(541, $palabras)?></div>
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
                                                    <div class="title"><?=mostrar_palabra(542, $palabras)?></div>
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
                                    echo validation_errors();
                                    ?>
                                </div>
                                <h4 class="checkout-title">Choose a payment method</h4>
                                <input type="hidden" name="amount" id="amount" value="<?=$this->session->userdata('amount')?>">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-lg-right">Payment Types <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <ul class="list-inline payment-type">
                                            <li class="active"><a href="#" data-click="set-payment" data-value="Stripe" data-toggle="tooltip" data-title="Stripe" data-placement="top" data-trigger="hover"><i class="fab fa-cc-stripe"></i></a></li>
                                            <li><a href="<?=site_url('pagos/paypal_payment')?>" data-click="set-payment" data-value="Paypal" data-toggle="tooltip" data-title="Paypal" data-placement="top" data-trigger="hover"><i class="fab fa-cc-paypal"></i></a></li>
                                            <!--
                                            <li><a href="#" data-click="set-payment" data-value="Visa" data-toggle="tooltip" data-title="Visa" data-placement="top" data-trigger="hover"><i class="fab fa-cc-visa"></i></a></li>
                                            <li><a href="#" data-click="set-payment" data-value="Master Card" data-toggle="tooltip" data-title="Master Card" data-placement="top" data-trigger="hover"><i class="fab fa-cc-mastercard"></i></a></li>
                                            <li><a href="#" data-click="set-payment" data-value="Credit Card" data-toggle="tooltip" data-title="Credit Card" data-placement="top" data-trigger="hover"><i class="fab fa-cc-discover"></i></a></li>
                                            -->
                                        </ul>
                                        <input type="hidden" name="payment_type" value="" data-id="payment-type" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-lg-right">Cardholder Name <span class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control required" name="cardholder" placeholder="John Doe" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-lg-right">Card Number <span class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control required" name="cardnumber" id="cardnumber" placeholder="1111222233334444" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-lg-right">Expiration Date <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="width-100">
                                            <div class="row row-space-0">
                                                <div class="col-xs-5">
                                                    <input type="text" name="expmonth" id="expmonth" placeholder="MM" class="form-control required p-l-5 p-r-5 text-center" />
                                                </div>
                                                <div class="col-xs-2 text-center">
                                                    <div class="text-muted p-t-5 m-t-2">/</div>
                                                </div>
                                                <div class="col-xs-5">
                                                    <input type="text" name="expyear" id="expyear" placeholder="YY" class="form-control required p-l-5 p-r-5 text-center" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-lg-right">CVV <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <div class="width-100 pull-left m-r-10">
                                            <input type="text" name="cvv" id="cvv" placeholder="123" class="form-control required p-l-5 p-r-5 text-center" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END checkout-body -->
                            <!-- BEGIN checkout-footer -->
                            <div class="checkout-footer">
                                <a href="<?=site_url('pagos/checkout_info')?>" class="btn btn-white btn-lg pull-left">Back</a>
                                <button type="submit" id="payBtn" class="btn btn-inverse btn-lg p-l-30 p-r-30 m-l-10">Proceed</button>
                            </div>
                            <!-- END checkout-footer -->
                        </form>
                    </div>
                    <!-- END checkout -->
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

<script src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
function cambiar_metodo(id)
{
    $('#metodo').val(id);
}

// Set your publishable key
Stripe.setPublishableKey('<?php echo stripe_publishable_key;?>');

// Callback to handle the response from stripe
function stripeResponseHandler(status, response) {
    if (response.error) {
        // Enable the submit button
        $('#payBtn').button("reset");
        // Display the errors on the form
        var htmlData = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        htmlData += response.error.message;
        htmlData += '</div>';
        $("#area_errores").html(htmlData);
    } else {
        var form$ = $("#paymentFrm");
        // Get token id
        var token = response.id;
        // Insert the token into the form
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        // Submit form to the server
        form$.get(0).submit();
    }
}

// On form submit
$("#paymentFrm").submit(function(){
    $('#payBtn').button("loading");
    // Create single-use token to charge the user
    Stripe.createToken({
        number: $('#cardnumber').val(),
        exp_month: $('#expmonth').val(),
        exp_year: $('#expyear').val(),
        cvc: $('#cvv').val()
    }, stripeResponseHandler);

    // Submit from callback
    return false;
});
</script>

</body>
</html>
