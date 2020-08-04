<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ads extends CI_Controller {

	private static $solapa = "ads";

	public function __construct()
	{
		parent::__construct();

		$this->config->set_item('language', $this->session->userdata('idi_code'));
		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->model('idiomas_model');
		$this->load->model('paises_model');
		$this->load->model('resultados_model');
		$this->load->model('productos_model');
		$this->load->model('user_model');
		$this->load->model('palabras_model');
		$this->load->model('aranceles_model');
		$this->load->model('favoritos_model');
		$this->load->model('foro_model');
		$this->load->model('comtrade_model');
		$this->load->model('referencias_model');
		$this->load->model('ads_model');
		$this->load->model('notificaciones_model');
		$this->load->model('mensajes_model');
		
		$this->load->view('templates/validate_login');
	}

	public function view($prod_id = FALSE)
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['producto'] = $this->ads_model->get_items($this->session->userdata('idi_code'), $prod_id);
		//$data['producto_mails'] = $this->productos_model->get_item_mails($prod_id);
		//$data['producto_idiomas'] = $this->productos_model->get_item_idiomas($this->session->userdata('idi_code'), $prod_id);
		//$data['tipo_producto'] = $this->productos_model->get_tipos($this->session->userdata('idi_code'), $data['producto']['tp_id']);
		$data['imagenes'] = $this->ads_model->get_item_imagenes($prod_id);
		$data['referencias_validadas'] = $this->referencias_model->get_items_validados($data['producto']['usr_id']);

		////// PARA REDES //////////
		$data['title'] = cortarTexto($data['producto']['ads_titulo'], 55);
		$data['description'] = cortarTexto($data['producto']['ads_texto_corto'], 150);
		$data['keywords'] = cortarTexto($data['producto']['ads_texto_corto'], 150);
		$data['meta_og_title'] = cortarTexto($data['producto']['ads_titulo'], 30);
		$data['meta_og_url'] = current_url();
		$data['meta_og_description'] = cortarTexto($data['producto']['ads_texto_corto'], 60);
		if($data['producto'] && $data['producto']['ads_imagen'])
		{
			$data['meta_og_image'] = base_url('images/ads/'.$data['producto']['ads_imagen']);
		}
		$data['meta_og_type'] = "website";
		//$data['meta_og_locale'] = $data['producto']['idi_code'];
		////////////////////////////

		//$data['favorito'] = $this->favoritos_model->buscar_usuario_favorito($this->session->userdata('usr_id'), $data['producto']['usr_id']);

		$ads_imp_id = $this->ads_model->set_item_click($prod_id, $this->session->userdata('usr_id'));
		
		$this->load->view(self::$solapa.'/view', $data);
	}

	public function set_ads_impresion_ajax()
	{
		//$_POST['ads_id'] = 1;
		$data['error'] = FALSE;

		if($this->input->post('ads_id') != "")
		{
			$ads_imp_id = $this->ads_model->set_item_impresion($this->input->post('ads_id'), $this->session->userdata('usr_id'));
			if($ads_imp_id)
			{
				$data['error'] = FALSE;
				$data['data'] = "Impreso";
			}
			else
			{
				$data['error'] = TRUE;
				$data['data'] = "Error insert";
			}
		}
		else
		{
			$data['error'] = TRUE;
			$data['data'] = "Faltan datos";
		}

		echo json_encode($data);
	}

	public function set_ads_click_ajax()
	{
		//$_POST['ads_id'] = 1;
		$data['error'] = FALSE;

		if($this->input->post('ads_id') != "")
		{
			$ads_imp_id = $this->ads_model->set_item_click($this->input->post('ads_id'), $this->session->userdata('usr_id'));
			if($ads_imp_id)
			{
				$data['error'] = FALSE;
				$data['data'] = "Impreso";
			}
			else
			{
				$data['error'] = TRUE;
				$data['data'] = "Error insert";
			}
		}
		else
		{
			$data['error'] = TRUE;
			$data['data'] = "Faltan datos";
		}

		echo json_encode($data);
	}

	public function set_form_ajax()
	{
		//$_POST['ads_id'] = 1;
		$data['error'] = FALSE;

		$palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $this->form_validation->set_rules('mail', $palabras[4]['pal_desc'], 'required|valid_email');
        $this->form_validation->set_rules('nombre', $palabras[11]['pal_desc'], 'required');

        if($this->form_validation->run() !== FALSE)
        {
			$ads_imp_id = $this->ads_model->set_item_form($this->input->post('ads_id'), $this->session->userdata('usr_id'), $this->input->post('nombre'), $this->input->post('mail'), $this->input->post('telefono'), $this->input->post('consulta'));
			if($ads_imp_id)
			{
				$ads = $this->ads_model->get_items($this->session->userdata('idi_code'), $this->input->post('ads_id'));
				$not_id = $this->notificaciones_model->set_item($this->session->userdata('usr_id'), $ads['usr_id'], NULL, NULL, NOTIFICACION_ADS_NUEVO_FORM, NOTI_ESTADO_PENDIENTE, $ads_imp_id);

				$texto = $this->input->post('nombre')."<br>";
				$texto .= $this->input->post('mail')."<br>";
				$texto .= $this->input->post('telefono')."<br><br>";
				$texto .= $this->input->post('consulta')."<br>";

				$this->load->helper('mails');
				$usuario = $this->user_model->get_items($ads['usr_id']);
				$result_mail = mail_base($ads['ads_forms_mail'], "Nuevo formulario", "Completaron un nuevo formulario de contacto", nl2br($texto), "");

				$data['error'] = FALSE;
				$data['data'] = "La consulta fue enviada";
			}
			else
			{
				$data['error'] = TRUE;
				$data['data'] = "Ocurrio un error al enviar la consulta";
			}
		}
		else
        {
            $data['error'] = TRUE;
            $data['data'] = validation_errors();
        }

		echo json_encode($data);
	}

}
