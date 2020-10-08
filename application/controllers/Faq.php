<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

	private static $solapa = "faq";

	public function __construct()
	{
		parent::__construct();

		if($this->session->userdata('idi_code') == "")
		{
			if(getUserLanguage() == "")
			{
				$this->session->set_userdata('idi_code',"en");
			}
			else
			{
				$this->session->set_userdata('idi_code',getUserLanguage());
			}
		}

		$this->config->set_item('language', $this->session->userdata('idi_code'));
		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->model('idiomas_model');
		$this->load->model('paises_model');
		$this->load->model('palabras_model');
		$this->load->model('user_model');
		$this->load->model('faq_model');
		$this->load->model('mensajes_model');
	}

	public function index()
	{
		$data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['faqs'] = $this->faq_model->get_items($this->session->userdata('idi_code'));
		if(!$data['faqs'])
		{
			$data['faqs'] = $this->faq_model->get_items();
		}

		$data['description'] = mostrar_palabra(118, $data['palabras']);
		$data['keywords'] = mostrar_palabra(52, $data['palabras']).",".mostrar_palabra(53, $data['palabras']).",".mostrar_palabra(54, $data['palabras']).",".mostrar_palabra(55, $data['palabras']).",".mostrar_palabra(107, $data['palabras']).",".mostrar_palabra(50, $data['palabras']).",".mostrar_palabra(51, $data['palabras']).",".mostrar_palabra(93, $palabras);
		$data['error'] = "";
		
		$this->load->view(self::$solapa.'/index', $data);
	}

}
