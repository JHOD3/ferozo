<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

	private static $solapa = "faq";

	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->view('templates/validate_login');
		$this->load->library('grocery_CRUD');
		//$this->load->model('generos_model');
	}

	public function index()
	{
		$crud = new grocery_CRUD();

		$crud->unset_bootstrap();
		$crud->set_table('faq');
		$crud->set_subject('pregunta');
		$crud->required_fields('faq_id','faq_numero','idi_code','faq_pregunta','faq_respuesta');
		$crud->columns('faq_numero','faq_orden','idi_code','faq_pregunta','faq_respuesta');

		$crud->display_as('faq_id','Id');
		$crud->display_as('faq_numero','Codigo');
		$crud->display_as('faq_orden','Orden');
		$crud->display_as('idi_code','Idioma');
		$crud->display_as('faq_pregunta','Pregunta');
		$crud->display_as('faq_respuesta','Respuesta');

		$crud->set_relation('idi_code','Idiomas','idi_desc_es');

		$crud->unset_texteditor('faq_respuesta');

		//$crud->add_action('Mails', '', site_url().'mails_contenido/index_tipo/', 'fa fa-envelope fa-2x');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}
	
}
