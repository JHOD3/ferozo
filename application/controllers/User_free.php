<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_free extends CI_Controller {

	private static $solapa = "user_free";

	public function __construct()
	{
		parent::__construct();

        if($this->session->userdata('idi_code') == "")
        {
            if(getUserLanguage() == "")
            {
                $this->session->set_userdata('idi_code',"en");
            }
            else
            {
                $this->session->set_userdata('idi_code',getUserLanguage());
            }
        }

        $this->config->set_item('language', $this->session->userdata('idi_code'));
		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->model('idiomas_model');
		$this->load->model('paises_model');
		$this->load->model('resultados_model');
		$this->load->model('productos_model');
		$this->load->model('user_model');
		$this->load->model('secciones_model');
		$this->load->model('categorias_model');
		$this->load->model('aranceles_model');
        $this->load->model('tipo_datos_model');
        $this->load->model('foro_model');
        $this->load->model('palabras_model');
        $this->load->model('mails_model');
        $this->load->model('comtrade_model');
        $this->load->model('favoritos_model');
        $this->load->model('mensajes_model');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

    public function index($usr_id = false)
    {
        if($usr_id == FALSE)
        {
            redirect();
        }
        
        if($this->session->userdata('usr_id') != "")
        {
            redirect('user/view/'.$usr_id);
        }
        
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['user'] = $this->user_model->get_otro_item($this->session->userdata('idi_code'), $usr_id);
        if($data['user'])
        {
            $data['tipo_datos'] = $this->tipo_datos_model->get_items($this->session->userdata('idi_code'));
            foreach($data['tipo_datos'] as $key_td => $tipo_dato)
            {
                $data['tipo_datos'][$key_td]['categorias'] = $this->tipo_datos_model->get_categorias($this->session->userdata('idi_code'), $tipo_dato['td_id']);
                $data['tipo_datos'][$key_td]['datos'] = $this->user_model->get_tipo_datos($data['user']['usr_id'], $tipo_dato['td_id']);
            }

            $data['resultados'] = $this->productos_model->get_items_free($this->session->userdata('idi_code'), $usr_id, FALSE);
        }
        else
        {
            redirect();
        }

        $this->load->view(self::$solapa.'/index', $data);
    }

    public function buscar_usuario_favorito_ajax($usr_id = FALSE)
    {
        $data['data'] = $this->favoritos_model->buscar_usuario_favorito($this->session->userdata('usr_id'), $usr_id);
        if($data['data'])
        {
            $data['error'] = FALSE;
        }
        else
        {
            $data['error'] = TRUE;
        }

        echo json_encode($data);
    }

    public function marcar_usuario_favorito_ajax($usr_id = FALSE, $puntaje = 0)
    {
        $result = $this->favoritos_model->set_usuario_favorito($this->session->userdata('usr_id'), $usr_id, $puntaje);
        if($result)
        {
            $data['error'] = FALSE;
        }
        else
        {
            $data['error'] = TRUE;
            $data['data'] = "Surgio un error al grabar el favorito.";
        }

        echo json_encode($data);
    }

    public function borrar_usuario_favorito_ajax($usr_id = FALSE)
    {
        $result = $this->favoritos_model->delete_usuario_favorito($this->session->userdata('usr_id'), $usr_id);
        if($result)
        {
            $data['error'] = FALSE;
        }
        else
        {
            $data['error'] = TRUE;
            $data['data'] = "Surgio un error al borrar el favorito.";
        }

        echo json_encode($data);
    }

}
