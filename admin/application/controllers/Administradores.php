<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administradores extends CI_Controller {

	private static $solapa = "administradores";

	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->view('templates/validate_login');
		$this->load->library('grocery_CRUD');
		$this->load->model('administradores_model');
	}

	public function index()
	{
		$crud = new grocery_CRUD();

		$crud->unset_bootstrap();
		$crud->set_table('administradores');
		$crud->set_subject('administrador');
		$crud->required_fields('admin_nombre','admin_apellido','admin_usuario','admin_mail','admin_clave');
		$crud->columns('admin_id','admin_nombre','admin_apellido','admin_usuario','admin_mail');

		$crud->display_as('admin_id','ID');
		$crud->display_as('admin_nombre','Nombre');
		$crud->display_as('admin_apellido','Apellido');
		$crud->display_as('admin_usuario','Usuario');
		$crud->display_as('admin_mail','Mail');
		$crud->display_as('admin_clave','Clave');

		$crud->field_type('admin_clave', 'password');

		//$crud->add_action('Trabajos', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', site_url().'trabajos/cliente/');
		//$crud->add_action('Saldo', base_url().'assets/images/pesos.png', site_url().'clientes/saldo/');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}
	
}
