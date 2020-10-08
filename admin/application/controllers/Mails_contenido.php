<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mails_contenido extends CI_Controller {

	private static $solapa = "mails_contenido";

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
		$crud->set_table('mails_info_codigo');
		$crud->set_subject('mail tipo');
		$crud->required_fields('mi_codigo','mi_descripcion');
		$crud->columns('mi_codigo','mi_descripcion');

		$crud->display_as('mi_codigo','Id');
		$crud->display_as('mi_descripcion','Descripcion');

		$crud->unset_delete();

		$crud->add_action('Mails', '', site_url().'mails_contenido/index_tipo/', 'fa fa-envelope fa-2x');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}

	public function index2()
	{
		$crud = new grocery_CRUD();

		$crud->unset_bootstrap();
		$crud->set_table('mails_info');
		$crud->set_subject('mail');
		$crud->required_fields('mi_id','mi_codigo','idi_code','mi_asunto');
		$crud->columns('mi_id','mi_codigo','idi_code','mi_asunto','mi_titulo','mi_cuerpo1','mi_cuerpo2');

		$crud->display_as('mi_id','Id');
		$crud->display_as('mi_codigo','codigo');
		$crud->display_as('idi_code','Idioma');
		$crud->display_as('mi_asunto','Asunto');
		$crud->display_as('mi_titulo','Titulo');
		$crud->display_as('mi_cuerpo1','Cuerpo 1');
		$crud->display_as('mi_cuerpo2','Cuerpo 2');

		$crud->set_relation('mi_codigo','mails_info_codigo','mi_descripcion');

		//$crud->add_action('Trabajos', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', site_url().'trabajos/cliente/');
		//$crud->add_action('Saldo', base_url().'assets/images/pesos.png', site_url().'clientes/saldo/');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}

	public function index_tipo($mi_codigo)
	{
		$crud = new grocery_CRUD();

		$crud->unset_bootstrap();
		$crud->where('mails_info.mi_codigo',$mi_codigo);
		$crud->set_table('mails_info');
		$crud->set_subject('mail');
		$crud->required_fields('mi_id','mi_codigo','idi_code','mi_asunto');
		$crud->columns('mi_id','idi_code','mi_asunto','mi_titulo','mi_cuerpo1','mi_cuerpo2');

		$crud->display_as('mi_id','Id');
		$crud->display_as('mi_codigo','codigo');
		$crud->display_as('idi_code','Idioma');
		$crud->display_as('mi_asunto','Asunto');
		$crud->display_as('mi_titulo','Titulo');
		$crud->display_as('mi_cuerpo1','Cuerpo 1');
		$crud->display_as('mi_cuerpo2','Cuerpo 2');

		$crud->unset_texteditor('mi_cuerpo1','mi_cuerpo2','mi_texto_crudo');

		$crud->field_type('mi_codigo', 'hidden', $mi_codigo);

		$crud->set_relation('idi_code','Idiomas','idi_desc_es');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}
	
}
