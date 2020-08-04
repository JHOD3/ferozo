<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ciudades extends CI_Controller {

	private static $solapa = "ciudades";

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
		$crud->set_table('City');
		$crud->set_subject('ciudad');
		$crud->required_fields('city_id','city_countryCode','city_nombre_es');
		$crud->columns('city_id','city_countryCode','city_nombre_zh','city_nombre_es','city_nombre_en','city_nombre_ar','city_nombre_pt','city_nombre_ru','city_nombre_ja','city_nombre_de','city_nombre_fr','city_nombre_ko','city_nombre_it');

		$crud->display_as('city_id','Id');
		$crud->display_as('city_countryCode','Pais');
		$crud->display_as('city_nombre_zh','Chino');
		$crud->display_as('city_nombre_es','Español');
		$crud->display_as('city_nombre_en','Ingles');
		$crud->display_as('city_nombre_hi','Hindi');
		$crud->display_as('city_nombre_ar','Arabe');
		$crud->display_as('city_nombre_pt','Portugues');
		$crud->display_as('city_nombre_ru','Ruso');
		$crud->display_as('city_nombre_ja','Japones');
		$crud->display_as('city_nombre_de','Aleman');
		$crud->display_as('city_nombre_fr','Frances');
		$crud->display_as('city_nombre_ko','Coreano');
		$crud->display_as('city_nombre_it','Italiano');

		$crud->set_relation('city_countryCode','Country','ctry_nombre_es');

		//$crud->set_field_upload('mar_imagen','../assets/images/marcas');

		//$crud->add_action('Trabajos', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', site_url().'trabajos/cliente/');
		//$crud->add_action('Saldo', base_url().'assets/images/pesos.png', site_url().'clientes/saldo/');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}

	public function pais($ctry_code)
	{
		$crud = new grocery_CRUD();

		$crud->unset_bootstrap();
		$crud->where('city_countryCode',$ctry_code);
		$crud->set_table('City');
		$crud->set_subject('ciudad');
		$crud->required_fields('city_id','city_countryCode','city_nombre_es');
		$crud->columns('city_id','city_countryCode','city_nombre_zh','city_nombre_es','city_nombre_en','city_nombre_ar','city_nombre_pt','city_nombre_ru','city_nombre_ja','city_nombre_de','city_nombre_fr','city_nombre_ko','city_nombre_it');

		$crud->display_as('city_id','Id');
		$crud->display_as('city_countryCode','Pais');
		$crud->display_as('city_nombre_zh','Chino');
		$crud->display_as('city_nombre_es','Español');
		$crud->display_as('city_nombre_en','Ingles');
		$crud->display_as('city_nombre_hi','Hindi');
		$crud->display_as('city_nombre_ar','Arabe');
		$crud->display_as('city_nombre_pt','Portugues');
		$crud->display_as('city_nombre_ru','Ruso');
		$crud->display_as('city_nombre_ja','Japones');
		$crud->display_as('city_nombre_de','Aleman');
		$crud->display_as('city_nombre_fr','Frances');
		$crud->display_as('city_nombre_ko','Coreano');
		$crud->display_as('city_nombre_it','Italiano');

		$crud->field_type('city_countryCode', 'hidden', $ctry_code);

		//$crud->add_action('Trabajos', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', site_url().'trabajos/cliente/');
		//$crud->add_action('Saldo', base_url().'assets/images/pesos.png', site_url().'clientes/saldo/');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}
	
}
