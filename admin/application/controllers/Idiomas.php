<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Idiomas extends CI_Controller {

	private static $solapa = "idiomas";

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
		$crud->set_table('Idiomas');
		$crud->set_subject('idioma');
		$crud->required_fields('idi_code','idi_desc_es');
		$crud->columns('idi_code','idi_desc_zh','idi_desc_es','idi_desc_en','idi_desc_ar','idi_desc_pt','idi_desc_ru','idi_desc_ja','idi_desc_de','idi_desc_fr','idi_desc_ko','idi_desc_it');

		$crud->display_as('Codigo','Id');
		$crud->display_as('idi_desc_zh','Chino');
		$crud->display_as('idi_desc_es','Español');
		$crud->display_as('idi_desc_en','Ingles');
		$crud->display_as('idi_desc_hi','Hindi');
		$crud->display_as('idi_desc_ar','Arabe');
		$crud->display_as('idi_desc_pt','Portugues');
		$crud->display_as('idi_desc_ru','Ruso');
		$crud->display_as('idi_desc_ja','Japones');
		$crud->display_as('idi_desc_de','Aleman');
		$crud->display_as('idi_desc_fr','Frances');
		$crud->display_as('idi_desc_ko','Coreano');
		$crud->display_as('idi_desc_it','Italiano');

		//$crud->set_field_upload('mar_imagen','../assets/images/marcas');

		//$crud->add_action('Trabajos', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', site_url().'trabajos/cliente/');
		//$crud->add_action('Saldo', base_url().'assets/images/pesos.png', site_url().'clientes/saldo/');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}
	
}
