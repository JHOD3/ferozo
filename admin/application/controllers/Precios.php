<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Precios extends CI_Controller {

	private static $solapa = "precios";

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
		$crud->set_table('ads_importes');
		$crud->set_subject('precio');
		$crud->required_fields('ads_imp_id','ads_imp_nombre','ads_imp_valor');
		$crud->columns('ads_imp_id','ads_imp_nombre','ads_imp_valor');

		$crud->display_as('ads_imp_id','Id');
		$crud->display_as('ads_imp_nombre','Nombre');
		$crud->display_as('ads_imp_valor','Valor');

		$crud->unset_delete();
		$crud->unset_add();
		//$crud->unset_edit();
		$crud->unset_read();

		//$crud->add_action('Mails', '', site_url().'politicas/index_tipo/', 'fa fa-edit fa-2x');

		$output = $crud->render();

		$this->load->view('templates/grocery', $output);
	}
	
}
