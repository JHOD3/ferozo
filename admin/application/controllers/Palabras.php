<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Palabras extends CI_Controller {

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
		$crud->set_table('palabras');
		$crud->set_subject('palabra');
		$crud->required_fields('pal_id','pal_desc_es');
		$crud->columns('pal_id','pal_desc_zh','pal_desc_es','pal_desc_en','pal_desc_ar','pal_desc_pt','pal_desc_ru','pal_desc_ja','pal_desc_de','pal_desc_fr','pal_desc_ko','pal_desc_it');

		$crud->display_as('pal_id','Id');
		$crud->display_as('pal_desc_zh','Chino');
		$crud->display_as('pal_desc_es','Español');
		$crud->display_as('pal_desc_en','Ingles');
		$crud->display_as('pal_desc_hi','Hindi');
		$crud->display_as('pal_desc_ar','Arabe');
		$crud->display_as('pal_desc_pt','Portugues');
		$crud->display_as('pal_desc_ru','Ruso');
		$crud->display_as('pal_desc_ja','Japones');
		$crud->display_as('pal_desc_de','Aleman');
		$crud->display_as('pal_desc_fr','Frances');
		$crud->display_as('pal_desc_ko','Coreano');
		$crud->display_as('pal_desc_it','Italiano');

		$crud->unset_texteditor('pal_desc_zh','pal_desc_es','pal_desc_en','pal_desc_hi','pal_desc_ar','pal_desc_pt','pal_desc_ru','pal_desc_ja','pal_desc_de','pal_desc_fr','pal_desc_ko','pal_desc_it');

		//$crud->add_action('Trabajos', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', site_url().'trabajos/cliente/');
		//$crud->add_action('Saldo', base_url().'assets/images/pesos.png', site_url().'clientes/saldo/');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}
	
}
