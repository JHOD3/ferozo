<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errores extends CI_Controller {

	private static $solapa = "errores";

	public function __construct()
	{
		parent::__construct();

		if($this->session->userdata('idi_code') == "")
		{
			$this->session->set_userdata('idi_code',"en");
		}

		$this->config->set_item('language', $this->session->userdata('idi_code'));
		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->model('idiomas_model');
		$this->load->model('palabras_model');
		$this->load->model('secciones_model');
		$this->load->model('categorias_model');
		$this->load->model('aranceles_model');
		$this->load->model('errores_model');
	}

	public function cargar_modal_ajax()
	{
		$return['error'] = FALSE;

		if($this->input->post('tipo_id') != "" && $this->input->post('idi_code') != "" && $this->input->post('pal_id') != "")
		{
			if($this->input->post('tipo_id') == 1)
			{
				$item = $this->secciones_model->get_items($this->input->post('idi_code'), $this->input->post('pal_id'));
				$return['data'] = $item['sec_desc'];
			}
			elseif($this->input->post('tipo_id') == 2)
			{
				$item = $this->categorias_model->get_items($this->input->post('idi_code'), $this->input->post('pal_id'));
				$return['data'] = $item['cat_desc'];
			}
			elseif($this->input->post('tipo_id') == 3)
			{
				$item = $this->aranceles_model->get_items($this->input->post('idi_code'), $this->input->post('pal_id'));
				$return['data'] = $item['ara_desc'];
			}
		}
		else
		{
			$return['error'] = TRUE;
			$return['data'] = "Debe completar todos los campos.";
		}

		echo json_encode($return);
	}

	public function grabar_error_ajax()
	{
		$return['error'] = FALSE;

		//$_POST['tipo_id'] = 1;
		//$_POST['descripcion'] = "errorrrrrr";

		if($this->input->post('tipo_id') != "")
		{
			$usr_id = $this->input->post('usr_id');
			if($this->input->post('usr_id') == "")
			{
				$usr_id = $this->session->userdata('usr_id');
			}
			$err_id = $this->errores_model->set_item($this->input->post('tipo_id'), $this->input->post('descripcion'), $usr_id, $this->input->post('pal_id'), $this->input->post('idi_code'));
			if($err_id)
			{
				$return['error'] = FALSE;
				$return['data'] = "Gracias por ayudarnos a mejorar.";
			}
			else
			{
				$return['error'] = TRUE;
				$return['data'] = "Ocurrio un error al enviar el error.";
			}
		}
		else
		{
			$return['error'] = TRUE;
			$return['data'] = "Debe completar todos los campos.";
		}

		echo json_encode($return);
	}

}
