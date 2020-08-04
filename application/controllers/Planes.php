<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Planes extends CI_Controller {

	private static $solapa = "planes";

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
		$this->load->model('aranceles_model');
		$this->load->model('favoritos_model');
		$this->load->model('ads_model');
		$this->load->model('palabras_model');
		$this->load->model('mensajes_model');
		
		$this->load->view('templates/validate_login');
	}

	public function index()
	{
		$data['solapa'] = self::$solapa;

		$pal_ids = array(505, 506, 507, 508, 509, 511, 512, 514, 515, 151);
		$data['palabras'] = $this->palabras_model->get_items_especificos($this->session->userdata('idi_code'), $pal_ids);

		$this->load->view(self::$solapa.'/index', $data);
	}

	public function target()
	{
		$data['solapa'] = self::$solapa;

		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$this->load->view(self::$solapa.'/target', $data);
	}

	public function market()
	{
		$data['solapa'] = self::$solapa;

		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$this->load->view(self::$solapa.'/market', $data);
	}

	public function publicitar()
	{
		$data['solapa'] = self::$solapa;

		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$this->load->view(self::$solapa.'/publicitar', $data);
	}

	public function premium()
	{
		$data['solapa'] = self::$solapa;

		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$this->load->view(self::$solapa.'/premium', $data);
	}

	public function contratar_ajax()
	{
		$data['error'] = FALSE;

		$pal_ids = array(223);
		$palabras = $this->palabras_model->get_items_especificos($this->session->userdata('idi_code'), $pal_ids);

		$usuario = $this->ads_model->get_user_ads($this->session->userdata('usr_id'));
		if(!$usuario)
		{
			$result = $this->ads_model->set_user_ads($this->session->userdata('usr_id'));
			if($result)
			{
				$data['error'] = FALSE;
				$data['error'] = "Bienvenido a Ads.";
				$this->session->set_userdata('ads_id', $this->session->userdata('usr_id'));
			}
			else
			{
				$data['error'] = TRUE;
				$data['error'] = mostrar_palabras(223, $palabras);
			}
		}
		else
		{
			$data['error'] = FALSE;
			$data['error'] = "El usuario ya esta registrado.";
			$this->session->set_userdata('ads_id', $this->session->userdata('usr_id'));
		}

		echo json_encode($data);
	}

}
