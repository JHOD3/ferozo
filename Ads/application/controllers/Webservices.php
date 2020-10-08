<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/stripe_payment/vendor/autoload.php';

class Webservices extends CI_Controller {

	private static $solapa = "webservices";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ads_model');
        $this->load->model('paises_model');
        $this->load->model('palabras_model');
        $this->load->model('aranceles_model');
        $this->load->model('pagos_model');
        $this->load->model('usuarios_model');

        //$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

    // REVISAR ESTO CUANDO HABILITEMOS LA CUENTA DE STRIPE
    // NO ESTA HABILITADA PORQUE FALTA LA CUENTA BANCARIA
    //https://www.nocnode.com/Ads/index.php/webservices/ipn_stripe
    public function ipn_stripe()
    {
        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = 'whsec_0V19ENKNkRghU4r0SWafRD3dKLSmZ9y9';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400); // PHP 5.4 or greater
            exit();
        } catch(\Stripe\Error\SignatureVerification $e) {
            // Invalid signature
            http_response_code(400); // PHP 5.4 or greater
            exit();
        }

        if ($event->type == "payment_intent.succeeded") {
            $intent = $event->data->object;
            printf("Succeeded: %s", $intent->id);
            http_response_code(200);
            exit();
        } elseif ($event->type == "payment_intent.payment_failed") {
            $intent = $event->data->object;
            $error_message = $intent->last_payment_error ? $intent->last_payment_error->message : "";
            printf("Failed: %s, %s", $intent->id, $error_message);
            http_response_code(200);
            exit();
        }
    }

    public function paypal_ipn()
    {
        $this->load->library('paypal_lib');
        /*
        $_POST['custom']        = 20842;
        $_POST['item_number']   = 2;
        $_POST['item_name']     = 'algo';
        $_POST['txn_id']         = '4AA74613D1846705H';
        $_POST['payment_gross']  = 35;
        $_POST['mc_currency']   = 'USD';
        $_POST['payer_email']   = 'fabianmayoral@hotmail.com';
        $_POST['payment_status'] = 'Approved';
        $_POST['quantity']      = 1;
        */
        // Paypal posts the transaction data
        $paypalInfo = $this->input->post();
        if(!empty($paypalInfo))
        {
            // Validate and get the ipn response
            $ipnCheck = $this->paypal_lib->validate_ipn($paypalInfo);
            //$ipnCheck = TRUE;

            // Check whether the transaction is valid
            if($ipnCheck)
            {
                // Insert the transaction data in the database
                $data['user_id']        = $paypalInfo["custom"];
                $data['item_number']    = $paypalInfo["item_number"];
                $data['item_name']      = $paypalInfo['item_name'];
                $data['txn_id']         = $paypalInfo["txn_id"];
                $data['payment_gross']  = $paypalInfo["payment_gross"];
                $data['currency_code']  = $paypalInfo["mc_currency"];
                $data['payer_email']    = $paypalInfo["payer_email"];
                $data['status']         = $paypalInfo["payment_status"];
                $data['quantity']       = $paypalInfo["quantity"];

                $pago = $this->pagos_model->get_transaction($data['txn_id']);
                if(!$pago)
                {
                    $pago_id = $this->pagos_model->set_item($data['user_id'], $data['payment_gross'], PAGO_METODO_PAYPAL, $data['txn_id'], PAGO_DESTINO_ADS);
                }
                else
                {
                    $pago_id = $pago['pago_id'];
                }

                if($pago_id)
                {
                    if($data['status'] == "Pending")
                    {
                        $estado = PAGO_PENDIENTE;
                    }
                    elseif($data['status'] == "Approved")
                    {
                        if($data['item_number'] == PAGO_DESTINO_PREMIUM_USER)
                        {
                            $pago_sus_id = $this->pagos_model->set_suscripcion($pago_id, $data['quantity']);
                            $update = $this->usuarios_model->update_tipo_item($data['user_id'], TU_PREMIUM);
                        }
                        
                        $estado = PAGO_APROBADO;
                    }
                    else
                    {
                        $estado = PAGO_RECHAZADO;
                    }

                    $pago_act_id = $this->pagos_model->set_actualizacion($pago_id, $estado);

                    echo "Ok";
                }
                else
                {
                    echo "No se pudo registrar el pago.";
                }
            }
        }
        else
        {
            echo "No se envio nada";
        }
    }

}
