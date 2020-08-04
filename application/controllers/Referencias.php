<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referencias extends CI_Controller {

	private static $solapa = "referencias";

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
		$this->load->model('user_model');
        $this->load->model('palabras_model');
        $this->load->model('mails_model');
        $this->load->model('referencias_model');
        $this->load->model('mails_info_model');
        $this->load->model('mensajes_model');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

    public function validar($ref_id = FALSE, $usr_id = FALSE)
    {
        if($usr_id == FALSE)
        {
            redirect();
        }

        $data['error'] = FALSE;
        $data['success'] = FALSE;

        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        $data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));

        $data['referencia'] = $this->referencias_model->get_items($usr_id, $ref_id);
        if($data['referencia'] && $data['referencia']['ref_est_id'] == REFERENCIA_PENDIENTE)
        {
            $result = $this->referencias_model->validar_item($usr_id, $ref_id);
            if($result)
            {
                $data['error'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(331, $data['palabras']).'</div>';
            }
            else
            {
                $data['error'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(331, $data['palabras']).'</div>';
            }
        }
        else
        {
            $data['error'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(331, $data['palabras']).'</div>';
        }

        $this->load->view('pages/index', $data);
    }

    public function referenciar_ajax()
    {
        $data['error'] = FALSE;
        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        
        if($this->input->post('mail') != "")
        {
            $viejo = $this->referencias_model->check_item($this->session->userdata('usr_id'), $this->input->post('mail'));
            if(!$viejo)
            {
                $ref_id = $this->referencias_model->set_item($this->session->userdata('usr_id'), $this->input->post('mail'));
                
                //ENVIAR MAIL
                $this->load->helper('mails');
                $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'),21);

                $mensaje1 = str_replace("[USER MAIL]", $this->session->userdata('usr_mail'), $mail_info['mi_cuerpo1']);
                $mensaje1 = str_replace("[USER COMPLETE NAME]", $this->session->userdata('usr_nombre')." ".$this->session->userdata('usr_apellido'), $mensaje1);
                $mensaje2 = str_replace("[LINK]", "<div style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'><a href='".site_url("referencias/validar/".$ref_id."/".$this->session->userdata('usr_id'))."' style='color:#C30D00;'>".mostrar_palabra(6, $palabras)."</a></div>", $mail_info['mi_cuerpo2']);

                mail_base($this->input->post('mail'), $mail_info['mi_asunto'], $mail_info['mi_titulo'], $mensaje1, $mensaje2);
                
                $data['data'] = "OK";
            }
            else
            {
                $data['error'] = TRUE;
                $data['data'] = mostrar_palabra(223, $palabras);
            }
        }
        else
        {
            $data['error'] = TRUE;
            $data['data'] = mostrar_palabra(223, $palabras);
        }

        echo json_encode($data);
    }

}
