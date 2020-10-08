<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/stripe_payment/vendor/autoload.php';

class Pagos extends CI_Controller {

	private static $solapa = "pagos";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ads_model');
        $this->load->model('paises_model');
        $this->load->model('palabras_model');
        $this->load->model('aranceles_model');
        $this->load->model('pagos_model');
        $this->load->model('usuarios_model');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

	public function index()
    {
        //echo $this->session->userdata('usr_id');
        //die();
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['titulo'] = ucfirst(mostrar_palabra(559, $data['palabras']));
        $data['subtitulo'] = "";
        $data['breadcum'] = array( array('link' => 'javascript:;', 'texto' => mostrar_palabra(559, $data['palabras'])), array('link' => '', 'texto' => mostrar_palabra(370, $data['palabras'])) );
        
        $data['saldo'] = $this->pagos_model->get_credito_restante($this->session->userdata('usr_id'));
        $data['suscripcion'] = $this->pagos_model->get_ultima_suscripcion_activa($this->session->userdata('usr_id'));
        $data['pagos'] = $this->pagos_model->get_items_usuario($this->session->userdata('usr_id'));
        $data['facturas'] = $this->pagos_model->get_facturas_usuario($this->session->userdata('usr_id'));

        $this->load->view(self::$solapa.'/index', $data);
    }

    public function factura($fac_id = FALSE)
    {
        if($fac_id == FALSE)
        {
            redirect('pagos');
        }

        $data['factura'] = $this->pagos_model->get_facturas_usuario($this->session->userdata('usr_id'), $fac_id);

        // GENERAR PDF
        $this->load->library('pdf');
        $this->pdf->set_paper('A4','portrait');
        $this->pdf->load_view(self::$solapa.'/factura', $data);
        $this->pdf->render();
        //$this->pdf->stream("recibo_".$data_pdf['factura']['rec_id'].".pdf");
        $output = $this->pdf->output();
        //file_put_contents('assets/recibos/recibo_'.$data['factura']['fac_id'].'.pdf', $output);

        $this->load->view(self::$solapa.'/factura', $data);
    }

    public function pdf($rec_id)
    {
        $data['factura'] = $this->recibos_model->get_items($rec_id);
        $data['usuario'] = $this->usuarios_model->get_items($data['factura']['usr_id']);
        $data['valores'] = $this->recibos_model->get_subitems_recibo($data['factura']['rec_id']);
        $data['padre'] = $this->usuarios_model->get_items($data['factura']['padre_id']);

        $data['nota_credito'] = $this->recibos_model->get_nota_credito_x_recibo($rec_id);

        $this->load->view(self::$solapa.'/pdf', $data);
    }

    public function checkout_ads($pago_destino = 1)
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        if($pago_destino == PAGO_DESTINO_ADS)
        {
            $data['producto'] = array('img' => 'assets/img/market2.png', 'title' => mostrar_palabra(505, $data['palabras']), 'desc' => mostrar_palabra(545, $data['palabras']), 'price' => '', 'readonly' => '', 'cantidad' => 1, 'pago_destino' => PAGO_DESTINO_ADS);
        }
        elseif($pago_destino == PAGO_DESTINO_PREMIUM_USER)
        {
            $data['producto'] = array('img' => 'assets/img/premium2.png', 'title' => 'Nocnode', 'desc' => mostrar_palabra(514, $data['palabras']), 'price' => 35, 'readonly' => 'readonly="readonly"', 'cantidad' => 1, 'pago_destino' => PAGO_DESTINO_PREMIUM_USER);
        }
        $this->session->set_userdata('producto_imagen', base_url($data['producto']['img']));

        $data['titulo'] = ucfirst(mostrar_palabra(540, $data['palabras']));
        $data['subtitulo'] = "";
        $data['breadcum'] = array( array('link' => site_url(self::$solapa), 'texto' => mostrar_palabra(559, $data['palabras'])), array('link' => '', 'texto' => mostrar_palabra(540, $data['palabras'])) );

        $data['error'] = FALSE;

        $this->form_validation->set_rules('amount', 'Importe', 'required|greater_than[0]');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|greater_than[0]');
        if($this->form_validation->run() !== FALSE)
        {
            $this->session->set_userdata('amount', $this->input->post('amount'));
            $this->session->set_userdata('producto', $this->input->post('producto'));
            $this->session->set_userdata('cantidad', $this->input->post('cantidad'));
            $this->session->set_userdata('pago_destino', $this->input->post('pago_destino'));

            redirect(self::$solapa.'/checkout_info');
        }
        else
        {
            $this->load->view(self::$solapa.'/checkout_ads', $data);
        }
    }

    public function checkout_info()
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['titulo'] = ucfirst(mostrar_palabra(541, $data['palabras']));
        $data['subtitulo'] = "";
        $data['breadcum'] = array( array('link' => site_url(self::$solapa), 'texto' => mostrar_palabra(559, $data['palabras'])), array('link' => '', 'texto' => mostrar_palabra(541, $data['palabras'])) );

        $datos_facturacion = $this->usuarios_model->get_datos_facturacion($this->session->userdata('usr_id'));
        $data['paises'] = $this->paises_model->get_items($this->session->userdata('idi_code'));

        $data['error'] = FALSE;

        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('apellido', 'Apellido', 'required');
        $this->form_validation->set_rules('pais', 'Country', 'required');
        $this->form_validation->set_rules('telefono', 'Telefono', 'required');
        $this->form_validation->set_rules('direccion', 'Direccion', 'required');
        $this->form_validation->set_rules('cp', 'CP', 'required');

        if($this->form_validation->run() !== FALSE)
        {
            if($datos_facturacion)
            {
                //UPDATE
                $result = $this->usuarios_model->update_datos_facturacion($this->session->userdata('usr_id'), $this->input->post('nombre'), $this->input->post('apellido'), $this->input->post('empresa'), $this->input->post('id'), $this->input->post('pais'), $this->input->post('telefono'), $this->input->post('direccion'), $this->input->post('cp'));
            }
            else
            {
                //INSERT
                $result = $this->usuarios_model->set_datos_facturacion($this->session->userdata('usr_id'), $this->input->post('nombre'), $this->input->post('apellido'), $this->input->post('empresa'), $this->input->post('id'), $this->input->post('pais'), $this->input->post('telefono'), $this->input->post('direccion'), $this->input->post('cp'));
            }

            if($result)
            {
                redirect(self::$solapa.'/paypal_payment');
            }
            else
            {
                $data['error'] = "Ocurrio un error al registrar los datos.";
                $this->load->view(self::$solapa.'/checkout_info', $data);
            }
        }
        else
        {
            $_POST['nombre'] = $datos_facturacion['usr_dat_fac_nombre'];
            $_POST['apellido'] = $datos_facturacion['usr_dat_fac_apellido'];
            $_POST['pais'] = $datos_facturacion['ctry_code'];
            $_POST['telefono'] = $datos_facturacion['usr_dat_fac_telefono'];
            $_POST['empresa'] = $datos_facturacion['usr_dat_fac_empresa'];
            $_POST['id'] = $datos_facturacion['usr_dat_fac_id'];
            $_POST['direccion'] = $datos_facturacion['usr_dat_fac_direccion'];
            $_POST['cp'] = $datos_facturacion['usr_dat_fac_cp'];

            $this->load->view(self::$solapa.'/checkout_info', $data);
        }
    }

    public function checkout_payment()
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['titulo'] = ucfirst(mostrar_palabra(542, $data['palabras']));
        $data['subtitulo'] = "";
        $data['breadcum'] = array( array('link' => site_url(self::$solapa), 'texto' => mostrar_palabra(559, $data['palabras'])), array('link' => '', 'texto' => mostrar_palabra(542, $data['palabras'])) );

        $data['error'] = FALSE;

        $this->form_validation->set_rules('amount', 'Creditos', 'required');
        $this->form_validation->set_rules('cardholder', 'Card holder', 'required');
        $this->form_validation->set_rules('cardnumber', 'Card number', 'required');
        $this->form_validation->set_rules('expmonth', 'Expiration month', 'required');
        $this->form_validation->set_rules('expyear', 'Expiration year', 'required');
        $this->form_validation->set_rules('cvv', 'CVV', 'required');

        if($this->form_validation->run() !== FALSE)
        {
            \Stripe\Stripe::setApiKey(stripe_secret_key);

            try
            {
                $payment = \Stripe\Charge::create([
                  "amount" => (integer)$this->input->post('amount')*100,
                  "currency" => "usd",
                  "source" => $this->input->post('stripeToken'), // obtained with Stripe.js
                  "description" => "Nocnode Ads credit"
                ]);

                //print_r($payment);
                //die();

                $pago_id = $this->pagos_model->set_item($this->session->userdata('usr_id'), ($payment->amount/100), PAGO_METODO_STRIPE, $payment->id, PAGO_DESTINO_ADS);
                if($pago_id)
                {
                    if($payment->status == "Pending") // No se si existe este en stripe
                    {
                        $estado = PAGO_PENDIENTE;
                    }
                    elseif($payment->status == "succeeded")
                    {
                        $estado = PAGO_APROBADO;
                    }
                    else
                    {
                        $estado = PAGO_RECHAZADO;
                    }

                    $pago_act_id = $this->pagos_model->set_actualizacion($pago_id, $estado);

                    redirect(self::$solapa.'/checkout_complete/'.$pago_id);
                }
                else
                {
                    $data['error'] = "Ocurrio un error al registrar el pago.";
                    $this->load->view(self::$solapa.'/checkout_payment', $data);
                }
            }
            catch(Exception $e)
            { 
                $data['error'] = $e->getMessage();
                $this->load->view(self::$solapa.'/checkout_payment', $data);
            }
        }
        else
        {
            $this->load->view(self::$solapa.'/checkout_payment', $data);
        }
    }

    public function checkout_complete($id = FALSE)
    {
        if($id == FALSE)
        {
            echo "error";
            die();
        }

        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['titulo'] = ucfirst(mostrar_palabra(543, $data['palabras']));
        $data['subtitulo'] = "";
        $data['breadcum'] = array( array('link' => site_url(self::$solapa), 'texto' => mostrar_palabra(559, $data['palabras'])), array('link' => '', 'texto' => mostrar_palabra(543, $data['palabras'])) );

        $data['error'] = FALSE;

        $data['pago'] = $this->pagos_model->get_items_usuario($this->session->userdata('usr_id'), $id);
        if($data['pago'])
        {
            if($data['pago']['pago_destino'] == PAGO_DESTINO_ADS)
            {
                $data['producto'] = array('img' => 'assets/img/market2.png', 'title' => mostrar_palabra(505, $data['palabras']), 'desc' => mostrar_palabra(545, $data['palabras']));
            }
            else
            {
                $data['producto'] = array('img' => 'assets/img/premium2.png', 'title' => 'Nocnode', 'desc' => mostrar_palabra(514, $data['palabras']));
            }
        }

        $this->load->view(self::$solapa.'/checkout_complete', $data);
    }

    public function checkout_error()
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['titulo'] = ucfirst(mostrar_palabra(543, $data['palabras']));
        $data['subtitulo'] = "";
        $data['breadcum'] = array( array('link' => site_url(self::$solapa), 'texto' => mostrar_palabra(559, $data['palabras'])), array('link' => '', 'texto' => mostrar_palabra(543, $data['palabras'])) );

        $data['error'] = FALSE;

        $this->load->view(self::$solapa.'/checkout_error', $data);
    }

    /***************
    PAYPAL
    ***************/

    public function paypal_payment()
    {
        $this->load->library('paypal_lib');

        $returnURL = site_url(self::$solapa."/paypal_success");
        $cancelURL = site_url(self::$solapa."/paypal_cancel");
        $notifyURL = site_url("webservices/paypal_ipn");

        // Add fields to paypal form
        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('item_name', $this->session->userdata('producto'));
        $this->paypal_lib->add_field('custom', $this->session->userdata('usr_id'));
        $this->paypal_lib->add_field('item_number',  $this->session->userdata('pago_destino'));
        //$this->paypal_lib->add_field('amount',  ($this->session->userdata('amount')*$this->session->userdata('cantidad')));
        $this->paypal_lib->add_field('quantity',  $this->session->userdata('cantidad'));
        $this->paypal_lib->add_field('amount',  $this->session->userdata('amount'));
        $this->paypal_lib->image($this->session->userdata('producto_imagen'));
        
        // Render paypal form
        $this->paypal_lib->paypal_auto_form();
    }

    public function paypal_cancel()
    {
        $this->load->library('paypal_lib');

        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $this->session->set_flashdata('error', 'Your transaction was canceled');

        redirect(self::$solapa.'/checkout_error');
    }

    public function paypal_success()
    {
        $this->load->library('paypal_lib');

        if($this->input->post())
        {
            $paypalInfo = $this->input->post();
            //print_r($paypalInfo);
            //die();
            
            $data['user_id']        = $paypalInfo["custom"];
            $data['item_number']     = $paypalInfo["item_number"];
            $data['item_name']      = $paypalInfo['item_name'];
            $data['txn_id']         = $paypalInfo["txn_id"];
            $data['payment_gross']  = $paypalInfo["payment_gross"];
            $data['currency_code']  = $paypalInfo["mc_currency"];
            $data['payer_email']    = $paypalInfo["payer_email"];
            $data['status']         = $paypalInfo["payment_status"];
            $data['quantity']       = $paypalInfo["quantity"];

            $pago_id = FALSE;
            $pago = $this->pagos_model->get_transaction($data['txn_id']);
            if(!$pago)
            {
                $pago_id = $this->pagos_model->set_item($this->session->userdata('usr_id'), $data['payment_gross'], PAGO_METODO_PAYPAL, $data['txn_id'], $this->session->userdata('pago_destino'));
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
                        $update = $this->user_model->update_tipo_item($this->session->userdata('usr_id'), TU_PREMIUM);
                    }
                    
                    $estado = PAGO_APROBADO;
                }
                else
                {
                    $estado = PAGO_RECHAZADO;
                }

                $pago_act_id = $this->pagos_model->set_actualizacion($pago_id, $estado);

                redirect(self::$solapa.'/checkout_complete/'.$pago_id);
            }
            else
            {
                $this->session->set_flashdata('error', 'No se pudo registrar el pago');
                redirect(self::$solapa.'/checkout_payment');
            }
        }
        else
        {
            $this->session->set_flashdata('error', 'No se recibio informacion');
            redirect(self::$solapa.'/checkout_payment');
        }
    }

}
