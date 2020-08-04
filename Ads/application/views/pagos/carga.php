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

            <form action="#" id="paymentFrm" class="form-horizontal" method="POST">

            <!-- begin row -->
            <div class="row">
                <!-- begin col-md-6 -->
                <div class="col-md-6">
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
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">Nueva carga</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-horizontal">
                                <?php
                                input_text('Cantidad', 'amount', 'number');
                                input_text('Metodo', 'metodo', 'number', 1);
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->

                    <div style="margin:20px 0px;">
                        <button type="button" onclick="cambiar_metodo(1)"><img src="<?=base_url('assets/img/stripe.jpg')?>" width="100px"></button>
                        <button type="button" onclick="cambiar_metodo(2)"><img src="<?=base_url('assets/img/paypal.jpg')?>" width="100px"></button>
                        <button type="button" onclick="cambiar_metodo(3)"><img src="<?=base_url('assets/img/mercadopago.jpg')?>" width="100px"></button>
                    </div>

                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">Stripe</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-horizontal">
                                <?php
                                input_text('Credit card number', 'cardnumber', 'text');
                                input_text('Name on card', 'cardname', 'text');
                                input_text('Exp Month', 'expmonth', 'text');
                                input_text('Exp Year', 'expyear', 'text');
                                input_text('CVV', 'cvv', 'text');
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->

                </div>
                <!-- end col-6 -->

            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-md-12">
                    <button type="submit" id="payBtn" class="btn btn-lg btn-success"><?=$palabras[17]['pal_desc']?></button>
                </div>
            </div>
            
            </form>
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

$(document).ready(function() {
    // On form submit
    $("#paymentFrm").submit(function() {

        if($('#metodo').val() == 1)
        {
            if($('#amount').val() > 0)
            {
                $('#payBtn').button("loading");
                // Create single-use token to charge the user
                Stripe.createToken({
                    number: $('#cardnumber').val(),
                    exp_month: $('#expmonth').val(),
                    exp_year: $('#expyear').val(),
                    cvc: $('#cvv').val()
                }, stripeResponseHandler);
            }
            else
            {
                var htmlData = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                htmlData += 'El valor debe ser mayor que 0';
                htmlData += '</div>';
                $("#area_errores").html(htmlData);
            }
            // Submit from callback
            return false;
        }
        else
        {
            
        }
    });
});
</script>

</body>
</html>
