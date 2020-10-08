<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paises extends CI_Controller {

	private static $solapa = "paises";

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
		$crud->set_table('Country');
		$crud->set_subject('pais');
		$crud->required_fields('ctry_code','ctry_code2','ctry_code3');
		$crud->columns('ctry_code','idi_code','ctry_nombre_zh','ctry_nombre_es','ctry_nombre_en','ctry_nombre_ar','ctry_nombre_pt','ctry_nombre_ru','ctry_nombre_ja','ctry_nombre_de','ctry_nombre_fr','ctry_nombre_ko','ctry_nombre_it');

		$crud->display_as('ctry_code','Codigo');
		$crud->display_as('idi_code','Idioma');
		$crud->display_as('ctry_nombre_zh','Chino');
		$crud->display_as('ctry_nombre_es','Español');
		$crud->display_as('ctry_nombre_en','Ingles');
		$crud->display_as('ctry_nombre_hi','Hindi');
		$crud->display_as('ctry_nombre_ar','Arabe');
		$crud->display_as('ctry_nombre_pt','Portugues');
		$crud->display_as('ctry_nombre_ru','Ruso');
		$crud->display_as('ctry_nombre_ja','Japones');
		$crud->display_as('ctry_nombre_de','Aleman');
		$crud->display_as('ctry_nombre_fr','Frances');
		$crud->display_as('ctry_nombre_ko','Coreano');
		$crud->display_as('ctry_nombre_it','Italiano');

		$crud->set_relation('idi_code','Idiomas','idi_desc_es');

		$crud->add_action('Ciudades', '', site_url().'ciudades/pais/', 'fa fa-globe fa-2x');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}
	
}
