<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificaciones extends CI_Controller {

	private static $solapa = "notificaciones";

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
		$this->load->model('mensajes_model');
		
		$this->load->view('templates/validate_login');
	}

	public function index()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		
		$this->load->view(self::$solapa.'/index', $data);
	}

	public function view($prod_id = FALSE)
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$this->load->view(self::$solapa.'/view', $data);
	}

	public function buscar_ajax($offset = 0, $limit = 20)
	{
		$aux = "";
		$palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$resultados = $this->notificaciones_model->get_items_usuario($this->session->userdata('usr_id'), $this->session->userdata('idi_code'), $offset, $limit);
		foreach ($resultados as $key => $value)
		{
			$this->notificaciones_model->estado_item($value['not_id'], NOTI_ESTADO_VISTA);
		}
		$data['result'] = $resultados;
		//print_r($data);
		echo json_encode($data);
	}

}
