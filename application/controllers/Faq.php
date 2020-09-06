<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

	private static $solapa = "faq";

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
		$this->load->model('palabras_model');
		$this->load->model('user_model');
		$this->load->model('faq_model');
		$this->load->model('mensajes_model');
	}

	public function index()
	{
		$data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['faqs'] = $this->faq_model->get_items($this->session->userdata('idi_code'));
		if(!$data['faqs'])
		{
			$data['faqs'] = $this->faq_model->get_items();
		}

		$data['description'] = mostrar_palabra(118, $data['palabras']);
		$data['keywords'] = mostrar_palabra(52, $data['palabras']).",".mostrar_palabra(53, $data['palabras']).",".mostrar_palabra(54, $data['palabras']).",".mostrar_palabra(55, $data['palabras']).",".mostrar_palabra(107, $data['palabras']).",".mostrar_palabra(50, $data['palabras']).",".mostrar_palabra(51, $data['palabras']).",".mostrar_palabra(93, $data['palabras']);
		$data['error'] = "";
		
		$this->load->view(self::$solapa.'/index', $data);
	}
	
	
	public function retiro_motivo()
	{
		$resultado= array('code'=>400,'message' => "Debe ingresar como usuario para realizar este proceso...");
		if($this->session->userdata('usr_id') != "")
		{
			$this->db->trans_begin();
			$usr_id=$this->session->userdata('usr_id');

			$data = array(
					'usr_id' => $usr_id, 
					'fecha_proceso' => date("Y-m-d H:i:s"),
					'pal_id' => $this->input->post('pal_id'),
					'comentarios_usuario' => $this->input->post('comentarios_usuario'),
					'estado' => $this->input->post('estado'),
					'activo' => 'Si'
			);

			$this->db->insert('usuarios_retiros', $data);					
				
			if ($this->input->post('estado')=="Suspender")
				{
					//$this->db->query("update Usuarios set  usr_estado=0 WHERE usr_id = {$usr_id}");
				}else{// elimina
					$this->db->query("update Usuarios set  usr_estado=0, usr_mail=CONCAT('**',usr_mail,'**'), usr_mail2=CONCAT('**',usr_mail2,'**'), usr_mail3=CONCAT('**',usr_mail3,'**') WHERE usr_id = {$usr_id}");
			}
			
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
					$resultado= array('code'=>200,'message' => "Proceso realizado correctamente...");		
				}else{
					$this->db->trans_rollback();
					$resultado= array('code'=>400,'message' => "Proceso no ejecutado correctamente...");		
				}	
		}
		echo json_encode($resultado);
	}

	public function retiro_motivo_activar()
	{
		$resultado= array('code'=>400,'message' => "Proceso no ejecutado correctamente...");
		if($this->session->userdata('usr_id') != "")
		{
			$usr_id=$this->session->userdata('usr_id');
			$this->db->set('activo','No');
            $this->db->where('usr_id',$usr_id);
            $this->db->update('usuarios_retiros');
			
			$resultado= array('code'=>200,'message' => "Proceso realizado correctamente...");		
		}
		echo json_encode($resultado);
	}

}
