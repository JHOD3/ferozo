<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bloqueos extends CI_Controller {

	private static $solapa = "bloqueos";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ads_model');
        $this->load->model('paises_model');
        $this->load->model('palabras_model');
        $this->load->model('aranceles_model');
        $this->load->model('usuarios_model');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

	public function index()
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['titulo'] = ucfirst(mostrar_palabra(560, $data['palabras']));
        $data['subtitulo'] = "";
        $data['breadcum'] = array( array('link' => 'javascript:;', 'texto' => ucfirst(mostrar_palabra(560, $data['palabras']))), array('link' => '', 'texto' => $data['palabras'][370]['pal_desc']) );
        
        $data['items'] = $this->ads_model->get_bloqueos($this->session->userdata('usr_id'));

        $this->load->view(self::$solapa.'/index', $data);
    }

    public function nuevo()
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['titulo'] = "Nuevo bloqueo";
        $data['subtitulo'] = 'usuario';
        $data['breadcum'] = array( array('link' => site_url(self::$solapa), 'texto' => 'Bloqueos'), array('link' => '', 'texto' => $data['palabras'][362]['pal_desc']) );
        
        $data['error'] = FALSE;
        $data['success'] = FALSE;

        $this->form_validation->set_rules('mail', 'Mails', 'required|valid_email');

        if($this->form_validation->run() !== FALSE)
        {
            $usuario = $this->usuarios_model->get_items_byMail($this->input->post('mail'));
            if($usuario)
            {
                $bloqueado = $this->ads_model->get_usuario_bloqueado($this->session->userdata('usr_id'), $usuario['usr_id']);
                if(!$bloqueado)
                {
                    $ads_blo_id = $this->ads_model->set_bloqueo($this->session->userdata('usr_id'), $usuario['usr_id']);
                    if($ads_blo_id)
                    {
                        $data['success'] .= "El email '".$this->input->post('mail')."' fue bloqueado.<br>";
                    }
                    else
                    {
                        $data['error'] = "Ocurrio un error al bloquear el email '".$this->input->post('mail')."'<br>";
                    }
                }
                else
                {
                    $data['error'] .= "El email '".$this->input->post('mail')."'' ya se encuentra bloqueado<br>";
                }
            }
            else
            {
                $data['error'] .= "No existe ningun usuario con el email '".$this->input->post('mail')."'<br>";
            }
        }

        $this->load->view(self::$solapa.'/nuevo', $data);
    }

    public function eliminar_ajax()
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        $data['error'] = FALSE;

        if($this->input->post('id') != "")
        {
            $result = $this->ads_model->delete_bloqueo($this->input->post('id'));
            if($result)
            {
                $data['data'] = "El item fue eliminado.";
            }
            else
            {
                $data['error'] = TRUE;
                $data['data'] = "Ocurrio un error al eliminar el item.";
            }
        }
        else
        {
            $data['error'] = TRUE;
            $data['data'] = "Debe completar todos los campos.";
        }

        echo json_encode($data);
    }

}
