<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	private static $solapa = "usuarios";

	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->view('templates/validate_login');
		$this->load->library('grocery_CRUD');
		$this->load->model('usuarios_model');
		$this->load->model('mails_model');
		$this->load->model('mails_info_model');
		$this->load->model('palabras_model');
	}

	public function index()
	{
		$crud = new grocery_CRUD();

		$crud->unset_bootstrap();
		$crud->set_table('Usuarios');
		$crud->set_subject('usuario');
		$crud->required_fields('usr_usuario','usr_clave','usr_mail');
		$crud->columns('usr_id','usr_nombre','usr_apellido','usr_estado','usr_mail','usr_pais');

		$crud->display_as('usr_id','ID');
		$crud->display_as('usr_nombre','Nombre');
		$crud->display_as('usr_apellido','Apellido');
		$crud->display_as('usr_usuario','Usuario');
		$crud->display_as('usr_estado','Estado');
		$crud->display_as('usr_mail','Mail');
		$crud->display_as('usr_pais','Pais');
		$crud->display_as('usr_fecha','Fecha de alta');
		$crud->display_as('usr_newsletter','Newsletter');

		$crud->field_type('usr_clave', 'password');

		$crud->set_field_upload('usr_imagen','../images/usuarios');

		$crud->add_action('Productos', '', site_url().'productos/usuario/', 'fa fa-shopping-cart fa-2x');
		$crud->add_action('Mail registro', '', site_url().'usuarios/mail_registro/', 'fa fa-envelope fa-2x');

		$output = $crud->render();

		$this->load->view(self::$solapa.'/index', $output);
	}
	
	public function mail_registro($usr_id)
	{
		$usuario_aux = $this->usuarios_model->get_items($usr_id);

        $mail = $this->mails_model->get_item_user($usuario_aux['usr_id'], $usuario_aux['usr_mail']);
        $codigo = $mail['mail_codigo'];

        $this->session->set_userdata('idi_code', $usuario_aux['idi_code']);

        $palabras = $this->palabras_model->get_items($usuario_aux['idi_code']);

        $this->load->helper('mails');

        $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'),1);
        
        $titulo = str_replace("[USER MAIL]", "<a href='mailto:".$usuario_aux['usr_mail']."' style='color:#FFFFFF;'>".$usuario_aux['usr_mail']."</a>", $mail_info['mi_titulo']);
        //$mensaje1 = str_replace("[BOTON]", "<a href='".site_url("login/activar/".$usr_id."/".$codigo)."' style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'>VALIDAR MAIL</a>", $mail_info['mi_cuerpo1']);
        $mensaje2 = str_replace("[LINK]", "<div style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'><a href='".site_url("login/activar/".$usr_id."/".$codigo)."' style='color:#C30D00;'>".$palabras[1]['pal_desc']."</a></div>", $mail_info['mi_cuerpo2']);
        $mensaje2 = str_replace("[HTTP/:]", site_url("login/activar/".$usr_id."/".$codigo), $mensaje2);
        $mensaje2 = str_replace("[USER MAIL]", $usuario_aux['usr_mail'], $mensaje2);
        $mensaje2 = str_replace("[CLAVE]", $codigo, $mensaje2);

        $result = mail_base($usuario_aux['usr_mail'], $mail_info['mi_asunto'], $titulo, nl2br($mail_info['mi_cuerpo1']), nl2br($mensaje2));
        if($result)
        {
        	$data['error'] = FALSE;
        	$data['data'] = "El email fue enviado.";
        }
        else
        {
        	$data['error'] = TRUE;
        	$data['data'] = "Ocurrio un error al enviar el mail.";
        }

        $this->load->view(self::$solapa.'/mail_registro', $data);
	}
}
