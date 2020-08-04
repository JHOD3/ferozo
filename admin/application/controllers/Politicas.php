<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Politicas extends CI_Controller {

	private static $solapa = "politicas";

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
		$crud->set_table('politicas_tipos');
		$crud->set_subject('politicas tipo');
		$crud->required_fields('pol_tipo_id','pol_tipo_nombre');
		$crud->columns('pol_tipo_id','pol_tipo_nombre');

		$crud->display_as('pol_tipo_id','Id');
		$crud->display_as('pol_tipo_nombre','Nombre');

		$crud->unset_delete();
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_read();

		$crud->add_action('Mails', '', site_url().'politicas/index_tipo/', 'fa fa-edit fa-2x');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}

	public function index_tipo($mi_codigo)
	{
		$crud = new grocery_CRUD();

		$crud->unset_bootstrap();
		$crud->where('politicas.pol_tipo_id',$mi_codigo);
		$crud->set_table('politicas');
		$crud->set_subject('politicas');
		$crud->required_fields('pol_id','idi_code','pol_titulo','pol_texto');
		$crud->columns('pol_id','idi_code','pol_titulo','pol_texto');

		$crud->display_as('pol_id','Id');
		//$crud->display_as('pol_tipo_id','Tipo');
		$crud->display_as('idi_code','Idioma');
		$crud->display_as('pol_titulo','Titulo');
		$crud->display_as('pol_texto','Texto');

		//$crud->unset_texteditor('pol_texto');

		$crud->field_type('pol_tipo_id', 'hidden', $mi_codigo);

		$crud->set_relation('idi_code','Idiomas','idi_desc_es');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}
	
}
