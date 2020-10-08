<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mails extends CI_Controller {

	private static $solapa = "mails";

	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->view('templates/validate_login');
		$this->load->library('grocery_CRUD');
		$this->load->model('mails_info_model');
		$this->load->model('idiomas_model');
	}

	public function index()
	{
		$crud = new grocery_CRUD();

		$crud->unset_bootstrap();
		$crud->set_table('Mails');
		$crud->set_subject('mail');
		$crud->required_fields('mail_id','usr_id','mail_direccion');
		$crud->columns('mail_id','usr_id','mail_direccion');

		//$crud->display_as('mar_id','ID');
		//$crud->display_as('mar_nombre','Nombre');

		//$crud->set_field_upload('mar_imagen','../assets/images/marcas');

		//$crud->add_action('Trabajos', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', site_url().'trabajos/cliente/');
		//$crud->add_action('Saldo', base_url().'assets/images/pesos.png', site_url().'clientes/saldo/');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}

	public function info()
	{
		$crud = new grocery_CRUD();

		$crud->unset_bootstrap();
		$crud->set_table('mails_info');
		$crud->set_subject('mail');
		$crud->required_fields('mi_codigo','idi_code','mi_asunto','mi_titulo');
		$crud->columns('mi_id','mi_codigo','idi_code','mi_asunto','mi_titulo');

		//$crud->display_as('mar_id','ID');
		//$crud->display_as('mar_nombre','Nombre');

		//$crud->set_field_upload('mar_imagen','../assets/images/marcas');

		//$crud->add_action('Trabajos', 'http://www.grocerycrud.com/assets/uploads/general/smiley.png', site_url().'trabajos/cliente/');
		//$crud->add_action('Saldo', base_url().'assets/images/pesos.png', site_url().'clientes/saldo/');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}

	public function enviar()
	{
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

		$data['mails'] = $this->mails_info_model->get_codigos('es');
		$data['idiomas'] = $this->idiomas_model->get_items('es');

		$data['error'] = FALSE;
		$data['success'] = FALSE;

		$this->session->set_userdata('idi_code', 'en');

		$this->form_validation->set_rules('destino', 'destinos', 'required');
        $this->form_validation->set_rules('asunto', 'asunto', 'required');
        $this->form_validation->set_rules('crudo', 'texto crudo', 'required');
        //$this->form_validation->set_rules('titulo', 'titulo', 'required');
        //$this->form_validation->set_rules('cuerpo1', 'cuerpo1', 'required');
        //$this->form_validation->set_rules('cuerpo2', 'cuerpo2', 'required');

        if ($this->form_validation->run() !== FALSE)
        {
        	$this->load->helper('mails');

        	$destinos = explode(';', $this->input->post('destino'));
        	if($destinos)
        	{
	        	foreach ($destinos as $key => $value)
	        	{
	        		//$data['success'] .= trim($value).'<br>';
	        		$result = mail_base($value, $this->input->post('asunto'), $this->input->post('crudo'), $this->input->post('titulo'), $this->input->post('cuerpo1'), $this->input->post('cuerpo2'));
	                if($result)
	                {
	                    $data['success'] .= "El email a ".$value." fue enviado.<br>";
	                }
	                else
	                {
	                    $data['error'] .= "El email a ".$value." no pudo ser enviado.<br>";
	                }
	        	}
        	}
        	else
        	{
        		$data['error'] = "No hay ningun mail para enviar.";
        	}
        }

		$this->load->view(self::$solapa.'/enviar', $data);
	}

	public function buscar_mail_ajax()
	{
		$data['error'] = FALSE;

		if($this->input->post('idioma') != "" && $this->input->post('mail') != "")
		{
			$data['data'] = $this->mails_info_model->get_item($this->input->post('idioma'), $this->input->post('mail'));
			if(!$data['data'])
			{
				$data['error'] = TRUE;
				$data['data'] = "El mail buscado no existe.";
			}
		}
		else
		{
			$data['error'] = TRUE;
			$data['data'] = "Debe completar todos los campos";
		}

		echo json_encode($data);
	}
	
}
