<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

	private static $solapa = "productos";

	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->view('templates/validate_login');
		$this->load->library('grocery_CRUD');
		//$this->load->model('usuarios_model');
	}

	public function index()
	{
		$crud = new grocery_CRUD();

		$this->load->config('grocery_crud');
    	$this->config->set_item('grocery_crud_file_upload_allow_file_types', 'gif|jpeg|jpg|png');

		$crud->unset_bootstrap();

		$crud->set_table('Productos');
		$crud->set_subject('producto');
		$crud->required_fields('ara_id','prod_descripcion','tp_id');
		$crud->columns('prod_id','ara_id','prod_descripcion','tp_id');

		$crud->set_relation('tp_id','Tipo_Productos','tp_desc_es');
		$crud->set_relation('ara_id','Aranceles','ara_code');
		$crud->set_relation('ctry_code','Country','ctry_nombre_es');
		$crud->set_relation('city_id','City','city_nombre_es');
		$crud->set_relation('usr_id','Usuarios','{usr_id} - {usr_mail}');

		$crud->display_as('prod_id','ID');
		$crud->display_as('ara_id','Arancel');
		$crud->display_as('prod_descripcion','Descripcion');
		$crud->display_as('tp_id','Tipo prod.');

		$crud->unset_texteditor('prod_descripcion');

		$crud->field_type('prod_fecha', 'hidden', date("Y-m-d H:i:s"));
		$crud->field_type('prod_nombre', 'hidden', '');
		//$crud->set_field_upload('prod_imagen','../images/productos');

		$crud->callback_after_upload(array($this,'callback_after_upload'));

		//$crud->add_action('Trabajos', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', site_url().'trabajos/cliente/');
		//$crud->add_action('Saldo', base_url().'assets/images/pesos.png', site_url().'clientes/saldo/');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}

	function callback_after_upload($uploader_response, $field_info, $files_to_upload)
	{
	    //$this->load->library('image_moo');
	 
	    //Is only one file uploaded so it ok to use it with $uploader_response[0].
	    //$file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 
	 
	    //$this->image_moo->load($file_uploaded)->resize(245,115)->save($file_uploaded,true);

	 	$config['image_library'] = 'gd2';
		$config['source_image']	= $field_info->upload_path.'/'.$uploader_response[0]->name;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['width']	= 420;
		$config['height']	= 220;

		$this->load->library('image_lib', $config); 

		if ( ! $this->image_lib->resize())
		{
		    echo $this->image_lib->display_errors();
		    return FALSE;
		}

	    return true;
	}

	public function usuario($usr_id)
	{
		$crud = new grocery_CRUD();

		$this->load->config('grocery_crud');
    	$this->config->set_item('grocery_crud_file_upload_allow_file_types', 'gif|jpeg|jpg|png');

		$crud->unset_bootstrap();
		$crud->where('Productos.usr_id',$usr_id);
		$crud->set_table('Productos');
		$crud->set_subject('producto');
		$crud->required_fields('ara_id','prod_descripcion','tp_id');
		$crud->columns('prod_id','ara_id','prod_descripcion','tp_id');

		$crud->set_relation('tp_id','Tipo_Productos','tp_desc_es');
		$crud->set_relation('ara_id','Aranceles','ara_code');
		$crud->set_relation('ctry_code','Country','ctry_nombre_es');
		$crud->set_relation('city_id','City','city_nombre_es');

		$crud->display_as('prod_id','ID');
		$crud->display_as('ara_id','Arancel');
		$crud->display_as('prod_descripcion','Descripcion');
		$crud->display_as('tp_id','Tipo prod.');

		$crud->unset_texteditor('prod_descripcion');

		$crud->field_type('prod_fecha', 'hidden', date("Y-m-d H:i:s"));
		$crud->field_type('usr_id', 'hidden', $usr_id);
		$crud->field_type('prod_nombre', 'hidden', '');
		//$crud->set_field_upload('prod_imagen','../images/productos');

		$crud->callback_after_upload(array($this,'callback_after_upload'));

		//$crud->add_action('Trabajos', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', site_url().'trabajos/cliente/');
		//$crud->add_action('Saldo', base_url().'assets/images/pesos.png', site_url().'clientes/saldo/');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}
	
}
