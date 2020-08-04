<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posiciones extends CI_Controller {

	private static $solapa = "posiciones";

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
		$crud->set_table('Aranceles');
		$crud->set_subject('arancel');
		$crud->required_fields('ara_id','ara_code','cat_id');
		$crud->columns('ara_id','ara_code','cat_id','ara_desc_zh','ara_desc_es','ara_desc_en','ara_desc_ar','ara_desc_pt','ara_desc_ru','ara_desc_ja','ara_desc_de','ara_desc_fr','ara_desc_ko','ara_desc_it');

		$crud->display_as('ara_id','Id');
		$crud->display_as('ara_code','Codigo');
		$crud->display_as('cat_id','Categoria');
		$crud->display_as('ara_desc_zh','Chino');
		$crud->display_as('ara_desc_es','Español');
		$crud->display_as('ara_desc_en','Ingles');
		$crud->display_as('ara_desc_hi','Hindi');
		$crud->display_as('ara_desc_ar','Arabe');
		$crud->display_as('ara_desc_pt','Portugues');
		$crud->display_as('ara_desc_ru','Ruso');
		$crud->display_as('ara_desc_ja','Japones');
		$crud->display_as('ara_desc_de','Aleman');
		$crud->display_as('ara_desc_fr','Frances');
		$crud->display_as('ara_desc_ko','Coreano');
		$crud->display_as('ara_desc_it','Italiano');

		$crud->unset_texteditor('ara_desc_zh','ara_desc_es','ara_desc_en','ara_desc_hi','ara_desc_ar','ara_desc_pt','ara_desc_ru','ara_desc_ja','ara_desc_de','ara_desc_fr','ara_desc_ko','ara_desc_it');

		$crud->set_relation('cat_id','Categorias','{cat_code} - {cat_desc_es}');

		//$crud->add_action('Trabajos', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', site_url().'trabajos/cliente/');
		//$crud->add_action('Saldo', base_url().'assets/images/pesos.png', site_url().'clientes/saldo/');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}

	public function aranceles_categoria($cat_id)
	{
		$crud = new grocery_CRUD();

		$crud->unset_bootstrap();
		$crud->where('Aranceles.cat_id',$cat_id);
		$crud->set_table('Aranceles');
		$crud->set_subject('arancel');
		$crud->required_fields('ara_id','ara_code','cat_id');
		$crud->columns('ara_id','ara_code','cat_id','ara_desc_zh','ara_desc_es','ara_desc_en','ara_desc_ar','ara_desc_pt','ara_desc_ru','ara_desc_ja','ara_desc_de','ara_desc_fr','ara_desc_ko','ara_desc_it');

		$crud->display_as('ara_id','Id');
		$crud->display_as('ara_code','Codigo');
		$crud->display_as('cat_id','Categoria');
		$crud->display_as('ara_desc_zh','Chino');
		$crud->display_as('ara_desc_es','Español');
		$crud->display_as('ara_desc_en','Ingles');
		$crud->display_as('ara_desc_hi','Hindi');
		$crud->display_as('ara_desc_ar','Arabe');
		$crud->display_as('ara_desc_pt','Portugues');
		$crud->display_as('ara_desc_ru','Ruso');
		$crud->display_as('ara_desc_ja','Japones');
		$crud->display_as('ara_desc_de','Aleman');
		$crud->display_as('ara_desc_fr','Frances');
		$crud->display_as('ara_desc_ko','Coreano');
		$crud->display_as('ara_desc_it','Italiano');

		$crud->unset_texteditor('ara_desc_zh','ara_desc_es','ara_desc_en','ara_desc_hi','ara_desc_ar','ara_desc_pt','ara_desc_ru','ara_desc_ja','ara_desc_de','ara_desc_fr','ara_desc_ko','ara_desc_it');

		$crud->set_relation('cat_id','Categorias','{cat_code} - {cat_desc_es}');

		//$crud->add_action('Trabajos', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', site_url().'trabajos/cliente/');
		//$crud->add_action('Saldo', base_url().'assets/images/pesos.png', site_url().'clientes/saldo/');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}

	public function secciones()
	{
		$crud = new grocery_CRUD();

		$crud->unset_bootstrap();
		$crud->set_table('Secciones');
		$crud->set_subject('seccion');
		$crud->required_fields('sec_id','sec_code');
		$crud->columns('sec_id','sec_code','sec_desc_zh','sec_desc_es','sec_desc_en','sec_desc_ar','sec_desc_pt','sec_desc_ru','sec_desc_ja','sec_desc_de','sec_desc_fr','sec_desc_ko','sec_desc_it');

		$crud->display_as('sec_id','Id');
		$crud->display_as('sec_code','Codigo');
		$crud->display_as('sec_desc_zh','Chino');
		$crud->display_as('sec_desc_es','Español');
		$crud->display_as('sec_desc_en','Ingles');
		$crud->display_as('sec_desc_hi','Hindi');
		$crud->display_as('sec_desc_ar','Arabe');
		$crud->display_as('sec_desc_pt','Portugues');
		$crud->display_as('sec_desc_ru','Ruso');
		$crud->display_as('sec_desc_ja','Japones');
		$crud->display_as('sec_desc_de','Aleman');
		$crud->display_as('sec_desc_fr','Frances');
		$crud->display_as('sec_desc_ko','Coreano');
		$crud->display_as('sec_desc_it','Italiano');

		$crud->unset_texteditor('sec_desc_zh','sec_desc_es','sec_desc_en','sec_desc_hi','sec_desc_ar','sec_desc_pt','sec_desc_ru','sec_desc_ja','sec_desc_de','sec_desc_fr','sec_desc_ko','sec_desc_it');

		$crud->add_action('Categorias', '', site_url().'posiciones/categorias_seccion/', 'fa fa-arrow-right fa-2x');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/secciones', $output);
	}

	public function categorias()
	{
		$crud = new grocery_CRUD();

		$crud->unset_bootstrap();
		$crud->set_table('Categorias');
		$crud->set_subject('categoria');
		$crud->required_fields('cat_id','cat_code','cat_id');
		$crud->columns('cat_id','cat_code','sec_id','cat_desc_zh','cat_desc_es','cat_desc_en','cat_desc_ar','cat_desc_pt','cat_desc_ru','cat_desc_ja','cat_desc_de','cat_desc_fr','cat_desc_ko','cat_desc_it');

		$crud->display_as('cat_id','Id');
		$crud->display_as('cat_code','Codigo');
		$crud->display_as('sec_id','Seccion');
		$crud->display_as('cat_desc_zh','Chino');
		$crud->display_as('cat_desc_es','Español');
		$crud->display_as('cat_desc_en','Ingles');
		$crud->display_as('cat_desc_hi','Hindi');
		$crud->display_as('cat_desc_ar','Arabe');
		$crud->display_as('cat_desc_pt','Portugues');
		$crud->display_as('cat_desc_ru','Ruso');
		$crud->display_as('cat_desc_ja','Japones');
		$crud->display_as('cat_desc_de','Aleman');
		$crud->display_as('cat_desc_fr','Frances');
		$crud->display_as('cat_desc_ko','Coreano');
		$crud->display_as('cat_desc_it','Italiano');

		$crud->unset_texteditor('cat_desc_zh','cat_desc_es','cat_desc_en','cat_desc_hi','cat_desc_ar','cat_desc_pt','cat_desc_ru','cat_desc_ja','cat_desc_de','cat_desc_fr','cat_desc_ko','cat_desc_it');

		$crud->set_relation('sec_id','Secciones','{sec_code} - {sec_desc_es}');

		$crud->add_action('Aranceles', '', site_url().'posiciones/aranceles_categoria/', 'fa fa-arrow-right fa-2x');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/categorias', $output);
	}

	public function categorias_seccion($sec_id)
	{
		$crud = new grocery_CRUD();

		$crud->unset_bootstrap();
		$crud->where('Categorias.sec_id',$sec_id);
		$crud->set_table('Categorias');
		$crud->set_subject('categoria');
		$crud->required_fields('cat_id','cat_code','cat_id');
		$crud->columns('cat_id','cat_code','sec_id','cat_desc_zh','cat_desc_es','cat_desc_en','cat_desc_ar','cat_desc_pt','cat_desc_ru','cat_desc_ja','cat_desc_de','cat_desc_fr','cat_desc_ko','cat_desc_it');

		$crud->display_as('cat_id','Id');
		$crud->display_as('cat_code','Codigo');
		$crud->display_as('sec_id','Seccion');
		$crud->display_as('cat_desc_zh','Chino');
		$crud->display_as('cat_desc_es','Español');
		$crud->display_as('cat_desc_en','Ingles');
		$crud->display_as('cat_desc_hi','Hindi');
		$crud->display_as('cat_desc_ar','Arabe');
		$crud->display_as('cat_desc_pt','Portugues');
		$crud->display_as('cat_desc_ru','Ruso');
		$crud->display_as('cat_desc_ja','Japones');
		$crud->display_as('cat_desc_de','Aleman');
		$crud->display_as('cat_desc_fr','Frances');
		$crud->display_as('cat_desc_ko','Coreano');
		$crud->display_as('cat_desc_it','Italiano');

		$crud->unset_texteditor('cat_desc_zh','cat_desc_es','cat_desc_en','cat_desc_hi','cat_desc_ar','cat_desc_pt','cat_desc_ru','cat_desc_ja','cat_desc_de','cat_desc_fr','cat_desc_ko','cat_desc_it');

		$crud->set_relation('sec_id','Secciones','{sec_code} - {sec_desc_es}');

		$crud->add_action('Aranceles', '', site_url().'posiciones/aranceles_categoria/', 'fa fa-arrow-right fa-2x');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/categorias', $output);
	}
	
}
