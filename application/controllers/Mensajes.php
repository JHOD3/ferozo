<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensajes extends CI_Controller {

	private static $solapa = "mensajes";

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
		$this->load->model('mensajes_model');
		$this->load->model('palabras_model');
		$this->load->model('comtrade_model');
		$this->load->model('notificaciones_model');
		
		$this->load->view('templates/validate_login');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

	public function index()
	{
		$data['solapa'] = self::$solapa;
	    $data['chats'] = $this->mensajes_model->get_conversaciones();

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

		$this->form_validation->set_rules('mail', mostrar_palabra(4, $data['palabras']), 'required');
		$this->form_validation->set_rules('descripcion', mostrar_palabra(294, $data['palabras']), 'required');

		if ($this->form_validation->run() === FALSE)
        {
        	$this->load->view(self::$solapa.'/nuevo', $data);
        }
        else
        {
        	$usuario = $this->user_model->get_items_byMail($this->input->post('mail'));
        	if($usuario)
        	{
	        	$result = $this->mensajes_model->set_item($this->session->userdata('usr_id'), $usuario['usr_id'], $this->input->post('descripcion'));
	        	if($result)
	        	{
	        		$data['success'] = "El mensaje fue enviado con exito.";
	        		redirect(self::$solapa.'/view/'.$usuario['usr_id']);
	        	}
	        	else
	        	{
	        		$data['error'] = "Se produjo un error al enviar el mensaje.";
	        		$this->load->view(self::$solapa.'/nuevo', $data);
	        	}
	        }
	        else
	        {
	        	$data['error'] = "El usuario no existe.";
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

		$data['usuario'] = $this->user_model->get_items($id);

		$this->form_validation->set_rules('comentario', mostrar_palabra(207, $data['palabras']), 'required');

		if ($this->form_validation->run() === FALSE)
        {
        	$this->mensajes_model->estado_chat($id, 3);
        }
        else
        {
        	$result = $this->mensajes_model->set_mensaje($this->input->post('comentario'), $this->session->userdata('usr_id'), $id);
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

        $data['mensajes'] = $this->mensajes_model->get_items($id);

        $this->load->view(self::$solapa.'/view', $data);
	}

	public function enviar_ajax()
	{
		$data['error'] = FALSE;

		if($this->input->post('emisor') != "" && $this->input->post('receptor') != "" && $this->input->post('mensaje') != "")
        {
        	$result = $this->mensajes_model->set_item($this->input->post('emisor'), $this->input->post('receptor'), $this->input->post('mensaje'));
        	if($result)
        	{
        		$data['error'] = FALSE;
        		$data['data'] = "El mensaje fue enviado con exito.";
        	}
        	else
        	{
        		$data['error'] = TRUE;
        		$data['data'] = "Se produjo un error al enviar el mensaje.";
        	}
        }
        else
        {
        	$data['error'] = TRUE;
        	$data['data'] = "Debe completar todos los campos. ".$this->input->post('mensaje');
        }

		echo json_encode($data);
	}

}
