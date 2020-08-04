<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Foro extends CI_Controller {

	private static $solapa = "foro";

	public function __construct()
	{
		parent::__construct();

		$this->config->set_item('language', $this->session->userdata('idi_code'));
		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->model('idiomas_model');
		$this->load->model('paises_model');
		$this->load->model('resultados_model');
		$this->load->model('productos_model');
		$this->load->model('user_model');
		$this->load->model('aranceles_model');
		$this->load->model('secciones_model');
		$this->load->model('favoritos_model');
		$this->load->model('foro_model');
		$this->load->model('palabras_model');
		$this->load->model('comtrade_model');
		$this->load->model('notificaciones_model');
		$this->load->model('mensajes_model');
		
		$this->load->view('templates/validate_login');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

	public function index()
	{
		$data['solapa'] = self::$solapa;
	    $data['foros'] = $this->foro_model->get_items($this->session->userdata('idi_code'));

	    $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$this->load->view(self::$solapa.'/index', $data);
	}

	public function filtros()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$this->form_validation->set_rules('enviar', 'enviar', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$data['paises'] = $this->foro_model->get_paises($this->session->userdata('idi_code'), $this->session->userdata('usr_id'));

			$data['aranceles'] = $this->foro_model->get_aranceles($this->session->userdata('idi_code'), $this->session->userdata('usr_id'));

			$data['search'] = $this->session->userdata('foro_search');
			$data['arancel_aux'] = $this->session->userdata('foro_arancel');
			$data['pais_aux'] = $this->session->userdata('foro_pais');
			$data['orden'] = $this->session->userdata('foro_orden');
			
			$this->load->view(self::$solapa.'/filtros', $data);
		}
		else
		{
			if($this->input->post('enviar')=="enviar")
			{
				$this->session->set_userdata('foro_search', $this->input->post('search'));
				$this->session->set_userdata('foro_arancel', $this->input->post('arancel'));
				$this->session->set_userdata('foro_pais', $this->input->post('pais'));
				$this->session->set_userdata('foro_orden', $this->input->post('orden'));
			}

			if($this->input->post('enviar')=="reset")
			{
				$this->session->set_userdata('foro_search', "");
				$this->session->set_userdata('foro_arancel', "");
				$this->session->set_userdata('foro_pais', "");
				$this->session->set_userdata('foro_orden', "");
			}

			redirect(self::$solapa);
		}
	}

	public function nuevo()
	{
		$data['solapa'] = self::$solapa;
		$data['error'] = "";
		$data['success'] = "";

		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['secciones'] = $this->secciones_model->get_items($this->session->userdata('idi_code'));
        foreach ($data['secciones'] as $key => $seccion)
        {
            $data['secciones'][$key]['aranceles'] = $this->aranceles_model->get_items_seccion($this->session->userdata('idi_code'), $seccion['sec_id']);
        }
		$data['paises'] = $this->paises_model->get_items($this->session->userdata('idi_code'));

		//$this->form_validation->set_rules('titulo', mostrar_palabra(203, $data['palabras']), 'required');
		$this->form_validation->set_rules('descripcion', mostrar_palabra(294, $data['palabras']), 'required');
		$this->form_validation->set_rules('arancel_select', mostrar_palabra(157, $data['palabras']), 'required');
		$this->form_validation->set_rules('pais', mostrar_palabra(2, $data['palabras']), 'required');

		if ($this->form_validation->run() === FALSE)
        {
        	$this->load->view(self::$solapa.'/nuevo', $data);
        }
        else
        {
        	$result = $this->foro_model->set_item($this->input->post('titulo'), $this->input->post('descripcion'), $this->session->userdata('usr_id'), $this->input->post('arancel_select'), $this->input->post('pais'), 1);
        	if($result)
        	{
        		$data['success'] = "El foro se ha creado con exito.";
        		redirect(self::$solapa);
        	}
        	else
        	{
        		$data['error'] = "Se produjo un error al crear el foro.";
        		$this->load->view(self::$solapa.'/nuevo', $data);
        	}
        }
	}

	public function view($id)
	{
		$data['solapa'] = self::$solapa;
		$data['error'] = "";
		$data['success'] = "";

		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$data['foro'] = $this->foro_model->get_items($this->session->userdata('idi_code'), $id);

		$this->form_validation->set_rules('comentario', mostrar_palabra(207, $data['palabras']), 'required');

		if ($this->form_validation->run() === FALSE)
        {
        	$this->foro_model->set_item_visitado($id, $this->session->userdata('usr_id'));
        }
        else
        {
        	$result = $this->foro_model->set_mensaje($this->input->post('comentario'), $this->session->userdata('usr_id'), $id);
        	if($result)
        	{
        		if($this->session->userdata('usr_id') != $data['foro']['usr_id'])
        		{
        			$not_id = $this->notificaciones_model->set_item($this->session->userdata('usr_id'), $data['foro']['usr_id'], NULL, NULL, NOTIFICACION_NUEVO_COMENTARIO_FORO, NOTI_ESTADO_PENDIENTE, $data['foro']['foro_id']);
        		}
        		
        		$data['success'] = "El mensaje se ha enviado con exito.";
        	}
        	else
        	{
        		$data['error'] = "Se produjo un error al enviar el mensaje.";
        	}
        }

        $data['mensajes'] = $this->foro_model->get_mensajes($id);
        $this->load->view(self::$solapa.'/view', $data);
	}

	public function buscar_foros_ajax($offset = 0, $limit = 10)
	{
		$aux = "";
		$palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$resultados = $this->foro_model->buscar_items($this->session->userdata('idi_code'), $offset, $limit);
		if(!$resultados)
		{
			$data['cant'] = 0;
		}
		$data['result'] = $resultados;
		//print_r($data);
		echo json_encode($data);
	}

}
