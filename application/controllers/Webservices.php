<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webservices extends CI_Controller {

    private static $solapa = "webservices";

	public function __construct()
	{
		parent::__construct();

        if($this->input->post('lang') == "")
        {
            $this->session->set_userdata('idi_code',"en");
            $this->session->set_userdata('lang',"en");
        }
        else
        {
            $this->session->set_userdata('idi_code',$this->input->post('lang'));
            $this->session->set_userdata('lang',$this->input->post('lang'));
        }

        if($this->input->post('usr_id') != "")
        {
            $this->session->set_userdata('usr_id',$this->input->post('usr_id'));
        }

        $this->config->set_item('language', $this->session->userdata('idi_code'));
        date_default_timezone_set('America/Argentina/Buenos_Aires');

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

		$this->load->model('user_model');
        $this->load->model('idiomas_model');
        $this->load->model('paises_model');
        $this->load->model('palabras_model');
        $this->load->model('mails_model');
        $this->load->model('mails_info_model');
        $this->load->model('productos_model');
        $this->load->model('resultados_model');
        $this->load->model('comtrade_model');
        $this->load->model('favoritos_model');
        $this->load->model('tipo_datos_model');
        $this->load->model('prices_model');
        $this->load->model('mensajes_model');
        
        //$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

    /****************
    CARGA INDEX
    ****************/

    public function buscar_actualizaciones()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$fecha = $request->fecha;

        $query = $this->db->query("SELECT * 
                                    FROM Configuracion
                                    WHERE conf_fecha > '".$fecha."'");

        $return['error'] = FALSE;
        $return['data'] = $query->result_array();

        echo json_encode($return);
    }

    public function cargar_idiomas()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$lang = $request->lang;

        if($request == "")
        {
            extract($_POST);
        }

        $return['error'] = FALSE;
        $return['data'] = $this->idiomas_model->get_items($lang);

        echo json_encode($return);
    }

    public function cargar_palabras()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$lang = $request->lang;

        if($request == "")
        {
            extract($_POST);
        }

        $return['error'] = FALSE;
        $return['data'] = $this->palabras_model->get_items($lang);

        echo json_encode($return);
    }

    /****************
    LOGIN
    ****************/

    public function mail_registro($user_id)
    {
        $usuario = $this->user_model->get_items($user_id);
        $codigo = RandomString(4);
        $mail_id = $this->mails_model->set_item($user_id, $usuario['usr_mail'], $codigo, 0);

        $this->load->helper('mails');
        
        $mail_info = $this->mails_info_model->get_item($usuario['idi_code'],1);
        $palabras = $this->palabras_model->get_items($usuario['idi_code']);
        
        $titulo = str_replace("[USER MAIL]", $usuario['usr_mail'], $mail_info['mi_titulo']);
        //$mensaje1 = str_replace("[BOTON]", "<a href='".site_url("login/activar/".$user_id."/".$codigo)."' style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'>VALIDAR MAIL</a>", $mail_info['mi_cuerpo1']);
        //$mensaje2 = str_replace("[LINK]", "<a href='".site_url("login/activar/".$user_id."/".$codigo)."' style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'>".mostrar_palabra(1, $palabras)."</a>", $mail_info['mi_cuerpo2']);
        $mensaje2 = str_replace("[LINK]", "<div style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'><a href='".site_url("login/activar/".$user_id."/".$codigo)."' style='color:#C30D00;'>".mostrar_palabra(1, $palabras)."</a></div>", $mail_info['mi_cuerpo2']);
        $mensaje2 = str_replace("[HTTP/:]", site_url("login/activar/".$user_id."/".$codigo), $mensaje2);
        $mensaje2 = str_replace("[USER MAIL]", $usuario['usr_mail'], $mensaje2);
        $mensaje2 = str_replace("[CLAVE]", $codigo, $mensaje2);

        $result = mail_base($usuario['usr_mail'], $mail_info['mi_asunto'], $titulo, nl2br($mail_info['mi_cuerpo1']), nl2br($mensaje2));

        $return['error'] = FALSE;
        $return['data'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(198, $palabras)."<br>".mostrar_palabra(236, $palabras).'</div>';
    }

    public function login_ajax()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$mail = $request->mail;
        @$clave = $request->clave;
        @$lang = $request->lang;
        
        if($request == "")
        {
            extract($_POST);
        }

        if($lang == "")
        {
            $_POST['lang'] = "en";
        }
        
        $palabras = $this->palabras_model->get_items($this->input->post('lang'));

        $this->form_validation->set_rules('mail', mostrar_palabra(4, $palabras), 'required|valid_email');
        $this->form_validation->set_rules('clave', mostrar_palabra(5, $palabras), 'required');

        if ($this->form_validation->run() !== FALSE)
        {
            $user = $this->user_model->login($this->input->post('mail'), $this->input->post('clave'));
            if($user)
            {
                if($user['usr_estado'] == 1)
                {
                    $this->session->set_userdata('usr_id', $user['usr_id']);
                    $this->session->set_userdata('usr_nombre', $user['usr_nombre']);
                    $this->session->set_userdata('usr_apellido', $user['usr_apellido']);
                    $this->session->set_userdata('usr_mail', $user['usr_mail']);
                    $this->session->set_userdata('idi_code', $user['idi_code']);
                    $this->session->set_userdata('usr_pais', $user['usr_pais']);

                    $idioma = $this->idiomas_model->get_items($user['idi_code'], $user['idi_code']);
                    $this->session->set_userdata('idi_desc', $idioma['idi_desc']);

                    $pais = $this->paises_model->get_items($user['idi_code'], $user['usr_pais']);
                    $this->session->set_userdata('usr_pais_desc', $pais['ctry_nombre']);

                    if($user['usr_imagen'] != "")
                    {
                        $this->session->set_userdata('usr_imagen', $user['usr_imagen']);
                    }
                    else
                    {
                        $this->session->set_userdata('usr_imagen', "perfil.jpg");
                    }

                    if($this->session->userdata('usr_nombre') == "" && $this->session->userdata('usr_apellido') == "")
                    {
                        $this->session->set_userdata('usr_nombre', substr($this->session->userdata('usr_mail'),0,strpos($this->session->userdata('usr_mail'), '@')));
                    }

                    $this->user_model->update_ultimo_acceso($this->session->userdata('usr_id'));

                    $return['error'] = FALSE;
                    $return['data'] = $user;
                }
                else
                {
                    $return['error'] = TRUE;
                    $return['data'] = mostrar_palabra(202, $palabras);
                }
            }
            else
            {
                $return['error'] = TRUE;
                $return['data'] = mostrar_palabra(100, $palabras);
            }
        }
        else
        {
            $return['error'] = TRUE;
            $return['data'] = validation_errors();
        }
        echo json_encode($return);
    }

    public function registro_ajax()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$mail = $request->mail;
        @$clave = $request->clave;
        @$clave2 = $request->clave2;
        @$pais = $request->pais;
        @$idioma = $request->idioma;
        @$lang = $request->lang;
        @$acepto = $request->acepto;
        
        if($request == "")
        {
            extract($_POST);
        }
        /*
        $_POST['mail'] = "asd@asd3.com";
        $_POST['clave'] = "asd";
        $_POST['clave2'] = "asd";
        $_POST['idioma'] = "es";
        $_POST['pais'] = "asd";
        */
        if($lang == "")
        {
            $_POST['lang'] = "en";
        }
        $palabras = $this->palabras_model->get_items($this->input->post('lang'));

        $this->form_validation->set_rules('mail', mostrar_palabra(4, $palabras), 'trim|required|valid_email');
        $this->form_validation->set_rules('clave', mostrar_palabra(5, $palabras), 'trim|required');
        $this->form_validation->set_rules('clave2', mostrar_palabra(6, $palabras).' '.mostrar_palabra(5, $palabras), 'trim|required|matches[clave]');
        $this->form_validation->set_rules('pais', mostrar_palabra(2, $palabras), 'required');
        $this->form_validation->set_rules('idioma', mostrar_palabra(3, $palabras), 'required');
        $this->form_validation->set_rules('acepto', mostrar_palabra(170, $palabras), 'required');

        if ($this->form_validation->run() !== FALSE)
        {
            if($this->user_model->existe_mail($this->input->post('mail')))
            {
                $usuario_aux = $this->user_model->get_items_byMail($this->input->post('mail'));
                if($usuario_aux['usr_estado'] == 0)
                {
                    $user_id = $usuario_aux['usr_id'];

                    $this->user_model->update_item($user_id, '', '', $this->input->post('idioma'), 0, "perfil.jpg", NULL, $this->input->post('pais'), NULL, NULL, NULL, NULL);
                    $this->user_model->update_clave($user_id, $this->input->post('clave'));

                    //Tengo que traer el mail que ya existe para enviar el codigo
                    $mail = $this->mails_model->get_item_user($usuario_aux['usr_id'], $this->input->post('mail'));
                    $codigo = $mail['mail_codigo'];

                    $this->session->set_userdata('idi_code', $this->input->post('idioma'));

                    $this->load->helper('mails');

                    $mail_info = $this->mails_info_model->get_item($this->input->post('idioma'),1);
                    
                    $titulo = str_replace("[USER MAIL]", $this->input->post('mail'), $mail_info['mi_titulo']);
                    //$mensaje1 = str_replace("[BOTON]", "<a href='".site_url("login/activar/".$user_id."/".$codigo)."' style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'>VALIDAR MAIL</a>", $mail_info['mi_cuerpo1']);
                    //$mensaje2 = str_replace("[LINK]", "<a href='".site_url("login/activar/".$user_id."/".$codigo)."' style='color:#FFFFFF; text-decoration:none;'>".mostrar_palabra(1, $palabras)."</a>", $mail_info['mi_cuerpo2']);
                    $mensaje2 = str_replace("[LINK]", "<div style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'><a href='".site_url("login/activar/".$user_id."/".$codigo)."' style='color:#C30D00;'>".mostrar_palabra(1, $palabras)."</a></div>", $mail_info['mi_cuerpo2']);
                    $mensaje2 = str_replace("[HTTP/:]", site_url("login/activar/".$user_id."/".$codigo), $mensaje2);
                    $mensaje2 = str_replace("[USER MAIL]", $this->input->post('mail'), $mensaje2);
                    $mensaje2 = str_replace("[CLAVE]", $codigo, $mensaje2);

                    $result = mail_base($this->input->post('mail'), $mail_info['mi_asunto'], $titulo, $mail_info['mi_cuerpo1'], $mensaje2);

                    $return['error'] = FALSE;
                    $return['data'] = mostrar_palabra(198, $palabras)."<br>".mostrar_palabra(236, $palabras);
                }
                else
                {
                    $return['error'] = TRUE;
                    $return['data'] = mostrar_palabra(101, $palabras);
                }
            }
            else
            {
                $user_id = $this->user_model->set_item($this->input->post('mail'), $this->input->post('clave'), $this->input->post('idioma'), $this->input->post('pais'), 0, "perfil.jpg");
                if($user_id)
                {
                    $codigo = RandomString(4);
                    $mail_id = $this->mails_model->set_item($user_id, $this->input->post('mail'), $codigo, 0);

                    $this->session->set_userdata('idi_code', $this->input->post('idioma'));

                    $this->load->helper('mails');
                    
                    $mail_info = $this->mails_info_model->get_item($this->input->post('idioma'),1);
                    
                    $titulo = str_replace("[USER MAIL]", $this->input->post('mail'), $mail_info['mi_titulo']);
                    //$mensaje1 = str_replace("[BOTON]", "<a href='".site_url("login/activar/".$user_id."/".$codigo)."' style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'>VALIDAR MAIL</a>", $mail_info['mi_cuerpo1']);
                    //$mensaje2 = str_replace("[LINK]", "<a href='".site_url("login/activar/".$user_id."/".$codigo)."' style='color:#FFFFFF; text-decoration:none;'>".mostrar_palabra(1, $palabras)."</a>", $mail_info['mi_cuerpo2']);
                    $mensaje2 = str_replace("[LINK]", "<div style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'><a href='".site_url("login/activar/".$user_id."/".$codigo)."' style='color:#C30D00;'>".mostrar_palabra(1, $palabras)."</a></div>", $mail_info['mi_cuerpo2']);
                    $mensaje2 = str_replace("[HTTP/:]", site_url("login/activar/".$user_id."/".$codigo), $mensaje2);
                    $mensaje2 = str_replace("[USER MAIL]", $this->input->post('mail'), $mensaje2);
                    $mensaje2 = str_replace("[CLAVE]", $codigo, $mensaje2);

                    $result = mail_base($this->input->post('mail'), $mail_info['mi_asunto'], $titulo, $mail_info['mi_cuerpo1'], $mensaje2);

                    $return['error'] = FALSE;
                    $return['data'] = mostrar_palabra(198, $palabras)."<br>".mostrar_palabra(236, $palabras);
                }
                else
                {
                    $return['error'] = TRUE;
                    $return['data'] = mostrar_palabra(223, $palabras);
                }
            }
        }
        else
        {
            $return['error'] = TRUE;
            $return['data'] = validation_errors();
        }

        echo json_encode($return);
    }

    public function activar($user_id = FALSE, $codigo = FALSE)
    {
        $data['error'] = "";

        $data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        if($user_id == FALSE || $codigo == FALSE)
        {
            $data['url'] = "pages";
            $this->load->view('pages/index', $data);
        }
        else
        {
            $mail = $this->mails_model->get_item_user_codigo($user_id, $codigo);
            if($mail)
            {
                //Borro todos los productos en caso de que fueran cargados por nosotros
                $this->productos_model->delete_items_usuario($user_id);

                $result2 = $this->mails_model->estado_item($mail['mail_id'], 1);
                $result = $this->user_model->estado_item($user_id, 1);
                if($result && $result2)
                {
                    $data['error'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(199, $data['palabras']).'</div>';
                    $this->load->view('pages/index', $data);
                }
                else
                {
                    $data['error'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(223, $data['palabras']).'</div>';
                    $this->load->view('pages/index', $data);
                }
            }
            else
            {
                $data['url'] = "pages";
                $this->load->view('pages/index', $data);
            }
        }
    }

    public function validar_mail($user_id = FALSE, $codigo = FALSE)
    {
        $data['error'] = "";

        $data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        if($user_id == FALSE || $codigo == FALSE)
        {
            $data['url'] = "pages";
            $this->load->view('pages/index', $data);
        }
        else
        {
            $mail = $this->mails_model->get_item_user_codigo($user_id, $codigo);
            if($mail)
            {
                $result = $this->mails_model->estado_item($mail['mail_id'], 1);
                if($result)
                {
                    $data['error'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(199, $data['palabras']).'</div>';
                    $this->load->view('pages/index', $data);
                }
                else
                {
                    $data['error'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(223, $data['palabras']).'</div>';
                    $this->load->view('pages/index', $data);
                }
            }
        }
    }

    public function reset($usr_id = FALSE, $codigo = FALSE)
    {
        $data['error'] = "";
        $data['success'] = "";

        $data['usr_id'] = $usr_id;
        $data['codigo'] = $codigo;

        //$data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        if($usr_id == FALSE || $codigo == FALSE)
        {
            redirect('pages/index');
        }
        else
        {
            $mail = $this->mails_model->get_item_user_codigo($usr_id, $codigo);
            if($mail)
            {
                $this->form_validation->set_rules('clave', mostrar_palabra(47, $data['palabras']), 'trim|required');
                $this->form_validation->set_rules('clave2', mostrar_palabra(48, $data['palabras']), 'trim|required|matches[clave]');

                if ($this->form_validation->run() !== FALSE)
                {
                    $result = $this->user_model->update_clave($usr_id, $this->input->post('clave'));
                    if($result)
                    {
                        $this->load->helper('mails');

                        $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'), 3);
                        
                        $titulo = str_replace("[USER MAIL]", $mail['mail_direccion'], $mail_info['mi_titulo']);
                        $mensaje1 = $mail_info['mi_cuerpo1'];
                        $mensaje2 = str_replace("[SISTEMA MAIL]", "contact@Sistema.com", $mail_info['mi_cuerpo2']);
                        
                        mail_base($mail['mail_direccion'], $mail_info['mi_asunto'], $titulo, $mensaje1, $mensaje2);

                        $data['success'] = mostrar_palabra(222, $data['palabras']);
                    }
                    else
                    {
                        $data['error'] = mostrar_palabra(223, $data['palabras']);
                    }
                }
            }
            else
            {
                redirect('pages/index');
            }
        }

        $this->load->view('pages/reset', $data);
    }

    public function olvide_ajax()
    {
        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        //$_POST['mail'] = "fabianmayoral@gmail.com";
    	$this->form_validation->set_rules('mail', mostrar_palabra(4, $palabras), 'required|valid_email');

    	if ($this->form_validation->run() !== FALSE)
    	{
    	    $user = $this->user_model->get_items_byMail($this->input->post('mail'));
    		if($user)
            {
                $mail = $this->mails_model->get_item_user($user['usr_id'], $this->input->post('mail'));
                $this->load->helper('mails');

                $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'), 2);
                
                $titulo = str_replace("[USER MAIL]", $this->input->post('mail'), $mail_info['mi_titulo']);
                $mensaje1 = $mail_info['mi_cuerpo1'];
                $mensaje2 = str_replace("[LINK]", site_url()."login/reset/".$user['usr_id']."/".$mail['mail_codigo'], $mail_info['mi_cuerpo2']);
                $mensaje2 = str_replace("[HOURS]", date('h:i'), $mensaje2);
                $fecha = date('Y-m-d');
                $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
                $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
                $mensaje2 = str_replace("[DAYS]", $nuevafecha, $mensaje2);
                $mensaje2 = str_replace("[SISTEMA MAIL]", "contact@Sistema.com", $mensaje2);

                $result = mail_base($this->input->post('mail'), $mail_info['mi_asunto'], $titulo, $mensaje1, $mensaje2);

                $return['error'] = FALSE;
                $return['data'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(200, $palabras).'</div>';
            }
    		else
            {
                $return['error'] = TRUE;
                $return['data'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(201, $palabras).'</div>';
            }
    	}
        else
        {
            $return['error'] = TRUE;
            $return['data'] = validation_errors();
        }

        echo json_encode($return);
    }

    public function logout()
    {
        $data['error'] = FALSE;

    	$this->session->unset_userdata('usr_id');
        //$this->session->unset_userdata('google_token');
        $this->session->sess_destroy();

        echo json_encode($data);
    }


    /******************
    USUARIO
    *******************/

    public function actualizar_acceso()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$usr_id = $request->usr_id;
        
        if($request == "")
        {
            extract($_POST);
        }

        $data['error'] = FALSE;

        $this->user_model->update_ultimo_acceso($this->session->userdata('usr_id'));

        echo json_encode($data);
    }

    public function buscar_perfil()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$usr_id = $request->usr_id;
        
        if($request == "")
        {
            extract($_POST);
        }
        
        $data['user'] = $this->user_model->get_otro_item($this->session->userdata('idi_code'), $usr_id);
        $query = $this->db->query("SELECT UD.ud_id, UD.ud_descripcion, TD.td_id, CTD.ctd_id
                                    FROM Usuarios_Datos AS UD
                                    INNER JOIN Tipo_Datos AS TD ON UD.td_id = TD.td_id
                                    LEFT JOIN Categoria_Tipo_Dato AS CTD ON UD.ctd_id = CTD.ctd_id
                                    WHERE usr_id=".$usr_id);
        $data['user']['datos'] = $query->result_array();

        $data['error'] = FALSE;

        echo json_encode($data);
    }

    public function actualizar_perfil()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$nombre = $request->nombre;
        @$apellido = $request->apellido;
        @$idioma = $request->idioma;
        @$pais = $request->pais;
        @$provincia = $request->provincia;
        @$imagen_ant = $request->imagen_ant;
        
        if($request == "")
        {
            extract($_POST);
        }

        //$_POST['pais'] = "ARG";
        //$_POST['idioma'] = "es";

        $data['error'] = FALSE;

        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $this->form_validation->set_rules('pais', mostrar_palabra(2, $palabras), 'required');
        $this->form_validation->set_rules('idioma', mostrar_palabra(3, $palabras), 'required');

        if ($this->form_validation->run() !== FALSE)
        {
            $result = $this->user_model->update_item($this->session->userdata('usr_id'), $this->input->post('nombre'), $this->input->post('apellido'), $this->input->post('idioma'), $this->input->post('publica'), $this->input->post('imagen_ant'), $this->input->post('empresa'), $this->input->post('pais'), $this->input->post('provincia'), $this->input->post('ciudad'), $this->input->post('direccion'), $this->input->post('cp'));
            if($result)
            {
                if($this->input->post('idioma') != $this->session->userdata('idi_code'))
                {
                    $this->session->set_userdata('idi_code', $this->input->post('idioma'));
                    $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));
                }

                $this->user_model->delete_datos($this->session->userdata('usr_id'));
                $ctd = $this->input->post('dato_ctd[]');
                $desc = $this->input->post('dato_desc[]');
                if($this->input->post('dato_td[]') != "")
                {
                    foreach ($this->input->post('dato_td[]') as $key => $dato)
                    {
                        if($desc[$key] != "")
                        {
                            $this->user_model->set_dato($this->session->userdata('usr_id'), $dato, $ctd[$key], $desc[$key]);
                            
                            if($dato == 2) // VALIDAR MAIL
                            {
                                if(!$this->mails_model->existe_mail_usuario($desc[$key], $this->session->userdata('usr_id')))
                                {
                                    $codigo = RandomString(4);
                                    $mail_id = $this->mails_model->set_item($this->session->userdata('usr_id'), $desc[$key], $codigo, 0);

                                    $this->load->helper('mails');
                                    $this->lang->load('email', $this->session->userdata('idi_code'));
                                    
                                    $mensaje1 = str_replace("[BOTON]", "<a href='".site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo)."' style='padding:20px 40px; background:#FFFFFF; width:auto; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'>VALIDAR MAIL</a>", $this->lang->line('email_mail_mensaje1'));
                                    $mensaje1 = str_replace("[MAIL]", $desc[$key], $mensaje1);
                                    $mensaje2 = str_replace("[LINK]", "<a href='".site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo)."' style='color:#FFFFFF; text-decoration:none;'>".site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo)."</a>", $this->lang->line('email_mail_mensaje2'));
                                    $mensaje2 = str_replace("[MAIL]", $desc[$key], $mensaje2);
                                    $mensaje2 = str_replace("[CODIGO]", $codigo, $mensaje2);

                                    mail_base($desc[$key], $this->lang->line('email_mail_asunto'), $this->lang->line('email_mail_titulo'), $mensaje1, $mensaje2);
                                }
                            }
                        }
                    }
                }

                $data['user'] = $this->user_model->get_otro_item($this->session->userdata('idi_code'), $this->session->userdata('usr_id'));
                $query = $this->db->query("SELECT UD.ud_id, UD.ud_descripcion, TD.td_id, CTD.ctd_id
                                            FROM Usuarios_Datos AS UD
                                            INNER JOIN Tipo_Datos AS TD ON UD.td_id = TD.td_id
                                            LEFT JOIN Categoria_Tipo_Dato AS CTD ON UD.ctd_id = CTD.ctd_id
                                            WHERE usr_id=".$this->session->userdata('usr_id'));
                $data['user']['datos'] = $query->result_array();

                $data['error'] = FALSE;
                $data['data'] = mostrar_palabra(222, $palabras);
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
            $data['data'] = validation_errors();
        }

        echo json_encode($data);
    }

    public function password()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$clave_ant = $request->clave_ant;
        @$clave = $request->clave;
        @$clave2 = $request->clave2;
        
        if($request == "")
        {
            extract($_POST);
        }

        $data['error'] = FALSE;
        $data['data'] = "";

        $user = $this->user_model->get_items($this->input->post('usr_id'));
        $palabras = $this->palabras_model->get_items($user['idi_code']);

        $this->form_validation->set_rules('clave_ant', mostrar_palabra(46, $palabras), 'required');
        $this->form_validation->set_rules('clave', mostrar_palabra(46, $palabras), 'required');
        $this->form_validation->set_rules('clave2', mostrar_palabra(48, $palabras), 'required|matches[clave]');

        if ($this->form_validation->run() === FALSE)
        {
            $data['error'] = TRUE;
            $data['data'] = validation_errors();
        }
        else
        {
            if($this->input->post('clave_ant') == $user['usr_clave'])
            {
                $result = $this->user_model->update_clave($this->input->post('usr_id'), $this->input->post('clave'));
                if($result)
                {
                    /*
                    $this->load->helper('mails');
                    $this->lang->load('email', $this->session->userdata('idi_code'));

                    mail_base($data['user']['usr_mail'], $this->lang->line('email_clave_asunto'), $this->lang->line('email_clave_titulo'), $this->lang->line('email_clave_mensaje1'), $this->lang->line('email_clave_mensaje2'));
                    */
                    $return['error'] = FALSE;
                    $data['data'] = mostrar_palabra(222, $palabras);
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
                $data['data'] = mostrar_palabra(223, $palabras).': '.mostrar_palabra(46, $palabras);
            }
        }
        echo json_encode($data);
    }

    /*************
    OTRO USUARIO
    ***************/

    public function buscar_usuario_ajax()
    {
        $usr_id = $this->input->post('usr_id');
        $lang = $this->input->post('lang');

        if($usr_id == FALSE)
        {
            $data['error'] = TRUE;
        }
        else
        {
            $data['error'] = FALSE;
            $data['user'] = $this->user_model->get_otro_item($lang, $usr_id);
            $data['tipo_datos'] = $this->tipo_datos_model->get_items($lang);
            foreach($data['tipo_datos'] as $key_td => $tipo_dato)
            {
                $data['tipo_datos'][$key_td]['categorias'] = $this->tipo_datos_model->get_categorias($lang, $tipo_dato['td_id']);
                $data['tipo_datos'][$key_td]['datos'] = $this->user_model->get_tipo_datos($data['user']['usr_id'], $tipo_dato['td_id']);
            }
        }

        echo json_encode($data);
    }

    public function buscar_productos_usuario()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$usr_id = $request->usr_id;
        
        if($request == "")
        {
            extract($_POST);
        }

        $data['error'] = FALSE;
        $data['resultados'] = $this->productos_model->get_items($this->session->userdata('idi_code'), $usr_id, FALSE);

        echo json_encode($data);
    }

    /*************
    RESULTADOS
    ***************/

    public function buscar_resultados_ajax()
    {
        $usr_id = $this->input->post('usr_id');
        $lang = $this->input->post('lang');
        $limit = $this->input->post('limit');
        $offset = $this->input->post('offset');
        $nombre = $this->input->post('nombre');
        $ofertas = $this->input->post('ofertas');
        $demandas = $this->input->post('demandas');
        $favoritos = $this->input->post('favoritos');
        $orden = $this->input->post('orden');

        $productos = $this->input->post('productos');
        $servicios = $this->input->post('servicios');
        $arancel = $this->input->post('arancel');
        $pais = $this->input->post('pais');
        $ciudad = $this->input->post('ciudad');

        $palabras = $this->palabras_model->get_items($lang);
        /*
        $lang = "es";
        $usr_id = 1;
        $limit = 10;
        $offset = 0;
        */
        $this->session->set_userdata('search',$nombre);
        $this->session->set_userdata('filtro_productos',$productos);
        $this->session->set_userdata('filtro_servicios',$servicios);
        $this->session->set_userdata('filtro_arancel',$arancel);
        $this->session->set_userdata('filtro_pais',$pais);
        $this->session->set_userdata('filtro_ciudad',$ciudad);
        $this->session->set_userdata('filtro_ofertas',$ofertas);
        $this->session->set_userdata('filtro_demandas',$demandas);
        $this->session->set_userdata('filtro_orden',$orden);
        $this->session->set_userdata('filtro_favoritos',$favoritos);

        $resultados = $this->resultados_model->get_items($lang, $usr_id, $offset, $limit);
        if($resultados)
        {
            foreach ($resultados as $key => $resultado)
            {
                $dias_aux = diferencia_dias($resultado['usr_ult_acceso'], date('Y-m-d H:i:s'));
                $ult_acceso = "";
                if($dias_aux < 1)
                {
                    $ult_acceso = str_replace("00.00", substr($resultado['usr_ult_acceso'],10,5), mostrar_palabra(167, $palabras));
                }
                elseif($dias_aux < 2)
                {
                    $ult_acceso = str_replace("00.00", substr($resultado['usr_ult_acceso'],10,5), mostrar_palabra(168, $palabras));
                }
                else
                {
                    $ult_acceso = str_replace("21", substr($resultado['usr_ult_acceso'],8,2), mostrar_palabra(169, $palabras));
                    $ult_acceso = str_replace("12", substr($resultado['usr_ult_acceso'],5,2), $ult_acceso);
                    $ult_acceso = str_replace("2015", substr($resultado['usr_ult_acceso'],0,4), $ult_acceso);
                }
                //$resultados[$key]['usr_ult_acceso'] = interval_date($resultado['usr_ult_acceso'], date('Y-m-d H:i:s'));
                $resultados[$key]['usr_ult_acceso'] = $ult_acceso;
            }
            $data['cant'] = count($resultados);
        }
        else
        {
            $data['cant'] = 0;
        }
        $data['result'] = $resultados;
        $data['error'] = FALSE;
        //$data['data'] = $favoritos;

        echo json_encode($data);
    }

    public function buscar_resultado()
    {
        //$_POST['prod_id'] = 53967;
        //$_POST['lang'] = "de";

        $prod_id = $this->input->post('prod_id');
        $lang = $this->input->post('lang');

        $data['error'] = FALSE;

        $data['producto'] = $this->productos_model->get_item($lang, $prod_id);
        $data['producto_mails'] = $this->productos_model->get_item_mails($prod_id);
        $data['producto_idiomas'] = $this->productos_model->get_item_idiomas($lang, $prod_id);
        $data['tipo_producto'] = $this->productos_model->get_tipos($lang, $data['producto']['tp_id']);
        $data['favoritos'] = $this->favoritos_model->buscar_puntaje_usuario($data['producto']['usr_id']);

        echo json_encode($data);
    }


    /*************
    FAVORITOS
    ***************/

    public function buscar_producto_favorito_ajax()
    {
        $prod_id = $this->input->post('prod_id');
        $usr_id = $this->input->post('usr_id');

        $data['data'] = $this->favoritos_model->buscar_producto_favorito($usr_id, $prod_id);
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

    public function marcar_producto_favorito_ajax()
    {
        $prod_id = $this->input->post('prod_id');
        $usr_id = $this->input->post('usr_id');
        $puntaje = $this->input->post('puntaje');

        $result = $this->favoritos_model->set_producto_favorito($usr_id, $prod_id, $puntaje);
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

    public function borrar_producto_favorito_ajax()
    {
        $prod_id = $this->input->post('prod_id');
        $usr_id = $this->input->post('usr_id');

        $result = $this->favoritos_model->delete_producto_favorito($usr_id, $prod_id);
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

    public function buscar_usuario_favorito_ajax()
    {
        $usr_favorito = $this->input->post('usr_favorito');
        $usr_id = $this->input->post('usr_id');

        $data['data'] = $this->favoritos_model->buscar_usuario_favorito($usr_id, $usr_favorito);
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

    public function marcar_usuario_favorito_ajax()
    {
        $usr_favorito = $this->input->post('usr_favorito');
        $usr_id = $this->input->post('usr_id');
        $puntaje = $this->input->post('puntaje');

        $result = $this->favoritos_model->set_usuario_favorito($usr_id, $usr_favorito, $puntaje);
        if($result)
        {
            $data['error'] = FALSE;
            $data['data'] = $this->favoritos_model->buscar_puntaje_usuario($usr_favorito);
        }
        else
        {
            $data['error'] = TRUE;
            $data['data'] = "Surgio un error al grabar el favorito.";
        }

        echo json_encode($data);
    }

    public function borrar_usuario_favorito_ajax()
    {
        $usr_favorito = $this->input->post('usr_favorito');
        $usr_id = $this->input->post('usr_id');

        $result = $this->favoritos_model->delete_usuario_favorito($usr_id, $usr_favorito);
        if($result)
        {
            $data['error'] = FALSE;
            $data['data'] = $this->favoritos_model->buscar_puntaje_usuario($usr_favorito);
        }
        else
        {
            $data['error'] = TRUE;
            $data['data'] = "Surgio un error al borrar el favorito.";
        }

        echo json_encode($data);
    }

    public function buscar_perfil_favorito_ajax()
    {
        $usr_id = $this->input->post('usr_id');

        $data['data'] = $this->favoritos_model->buscar_puntaje_usuario($usr_id);
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


    /************
    ESTADISTICAS
    *************/

    public function producto_ajax()
    {
        $rg = $this->input->post('rg');
        $lang = $this->input->post('lang');
        $usr_id = $this->input->post('usr_id');
        $ctry_code_origen = $this->input->post('ctry_code_origen');
        $ara = $this->input->post('ara');
        $cat = $this->input->post('cat');
        $prod_id = $this->input->post('prod_id');

        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        /*
        $rg = TP_DEMANDA;
        $ctry_code_origen = "AFG";
        $prod_id = 3;
        $ara = 10121;
        $cat = 1;
        $lang = "en";
        $usr_id = 1;
        */
        //http://comtrade.un.org/api/get?type=C&freq=A&px=HS&ps=recent&r=32&p=156&rg=2&cc=020130&fmt=json
        
        if($ara < 100000)
        {
            $ara_comtrade = strval("0".$ara);
        }
        else
        {
            $ara_comtrade = strval($ara);
        }
        
        $aux = [];

        if($rg == TP_OFERTA)
        {
            $rg2 = EXPORTACION;
        }
        else
        {
            $rg2 = IMPORTACION;
        }

        /*
        Año 2015:
        Argentina exporto (producto - posicion) a China USD 1000 (formatear valor con puntos)

        Entre 2011-2015: refleja un crecimiento del 22%
        */

        if($ctry_code_origen == "" || $rg == "" || $ara == "")
        {
            $return['error'] = TRUE;
            $return['data'] = "Debe completar todos los campos.";
        }
        else
        {
            $producto = $this->productos_model->get_item($lang, $prod_id);
            $destinos_array = $this->resultados_model->get_paises_match($lang, $usr_id, $ara);

            $aux['texto1'] = "";
            $aux['texto3'] = "";

            foreach ($destinos_array as $key_destinos => $destino_item)
            {
                $ctry_code_destino = $destino_item['ctry_code'];

                $max = $this->comtrade_model->get_item_max($lang, $ara, $ctry_code_origen, $ctry_code_destino, $rg2);
                if(!$max)
                {
                    /*
                    if($this->buscar_comtrade($ctry_code_origen, $ctry_code_destino, $rg2, $ara, $cat))
                    {
                        $max = $this->comtrade_model->get_item_max($lang, $ara, $ctry_code_origen, $ctry_code_destino, $rg2);
                    }
                    */
                }

                if($max)
                {
                    $min = $this->comtrade_model->get_item_min($lang, $ara, $ctry_code_origen, $ctry_code_destino, $rg2);
                    $valor = redondear_millones($max['com_valor']);

                    if($rg2 == EXPORTACION)
                    {
                        $texto1 = "<div class='estadistica1'>".mostrar_palabra(88, $palabras)."<br>USD ".number_format($valor)."<br>".str_replace('2014', $max['com_anio'], mostrar_palabra(232, $palabras))."</div>";
                        $texto1 = str_replace("[PaisA]", $max['ctry_nombre_origen'], $texto1);
                        $texto1 = str_replace("[producto]", "(".$max['ara_code'].") ".$max['ara_desc'], $texto1);
                        $texto1 = str_replace("[PaisB]", $max['ctry_nombre_destino'], $texto1);
                        $texto1 .= "<br>";
                    }
                    else
                    {
                        $texto1 = "<div class='estadistica1'>".mostrar_palabra(89, $palabras)."<br>USD ".number_format($valor)."<br>".str_replace('2014', $max['com_anio'], mostrar_palabra(232, $palabras))."</div>";
                        $texto1 = str_replace("[PaisA]", $max['ctry_nombre_origen'], $texto1);
                        $texto1 = str_replace("[producto]", "(".$max['ara_code'].") ".$max['ara_desc'], $texto1);
                        $texto1 = str_replace("[PaisB]", $max['ctry_nombre_destino'], $texto1);
                        $texto1 .= "<br>";
                    }
                    $aux['texto1'] .= $texto1;

                    if($max['com_anio'] != $min['com_anio'])
                    {
                        if($max['com_valor'] < $min['com_valor'])
                        {
                            $aux['decrecimiento'] = round(($max['com_valor'] - $min['com_valor']) / $max['com_valor'] * -100);
                            $texto2 = "<div class='estadistica2'>".str_replace("[XXX]", $aux['decrecimiento']."%", mostrar_palabra(63, $palabras))." <i class='fa fa-2x fa-arrow-down' style='background:#c6211a;'></i><br>".mostrar_palabra(66, $palabras)." ".$min['com_anio']."-".$max['com_anio']."</div>";
                            $texto2 .= "<br>";
                        }
                        else
                        {
                            $aux['crecimiento'] = round(($min['com_valor'] - $max['com_valor']) / $min['com_valor'] * -100);
                            $texto2 = "<div class='estadistica2'>".str_replace("[XXX]", $aux['crecimiento']."%", mostrar_palabra(62, $palabras))." <i class='fa fa-2x fa-arrow-up' style='background:#51af1e;'></i><br>".mostrar_palabra(66, $palabras)." ".$min['com_anio']."-".$max['com_anio']."</div>";
                            $texto2 .= "<br>";
                        }
                    }
                    $aux['texto1'] .= $texto2;
                }
            }
        
            // BUSCO LA INFORMACION AL RESTO DEL MUNDO

            $max_resto = $this->comtrade_model->get_item_crecimiento($lang, $ara, $ctry_code_origen, "WLD", $rg2);
            if($max_resto)
            {
                $valor = redondear_millones($max_resto['comc_valor_fin']);

                if($rg2 == IMPORTACION)
                {
                    $texto3 = "<div class='estadistica1'>".mostrar_palabra(91, $palabras)."<br>USD ".number_format($valor)."<br>".str_replace('2014', $max_resto['comc_anio_fin'], mostrar_palabra(232, $palabras))."</div>";
                    $texto3 = str_replace("[PaisA]", $max_resto['ctry_nombre_origen'], $texto3);
                    $texto3 = str_replace("[producto]", "(".$max_resto['ara_code'].") ".$max_resto['ara_desc'], $texto3);
                    $texto3 .= "<br>";
                }
                else
                {
                    $texto3 = "<div class='estadistica1'>".mostrar_palabra(90, $palabras)."<br>USD ".number_format($valor)."<br>".str_replace('2014', $max_resto['comc_anio_fin'], mostrar_palabra(232, $palabras))."</div>";
                    $texto3 = str_replace("[PaisA]", $max_resto['ctry_nombre_origen'], $texto3);
                    $texto3 = str_replace("[producto]", "(".$max_resto['ara_code'].") ".$max_resto['ara_desc'], $texto3);
                    $texto3 .= "<br>";
                }
                $aux['texto3'] .= $texto3;

                if($max_resto['comc_porcentaje'] < 0)
                {
                    $aux['decrecimiento'] = round($max_resto['comc_porcentaje']*-1);
                    $texto4 = "<div class='estadistica2'>".str_replace("[XXX]", $aux['decrecimiento']."%", mostrar_palabra(63, $palabras))." <i class='fa fa-2x fa-arrow-down' style='background:#c6211a;'></i><br>".mostrar_palabra(66, $palabras)." ".$max_resto['comc_anio_ini']."-".$max_resto['comc_anio_fin']."</div>";
                    $texto4 .= "<br>";
                }
                else
                {
                    $aux['crecimiento'] = round($max_resto['comc_porcentaje']);
                    $texto4 = "<div class='estadistica2'>".str_replace("[XXX]", $aux['crecimiento']."%", mostrar_palabra(62, $palabras))." <i class='fa fa-2x fa-arrow-up' style='background:#51af1e;'></i><br>".mostrar_palabra(66, $palabras)." ".$max_resto['comc_anio_ini']."-".$max_resto['comc_anio_fin']."</div>";
                    $texto4 .= "<br>";
                }
                $aux['texto3'] .= $texto4;
            }

            
            if($max['com_valor'] > 0 || $max_resto['comc_porcentaje'] != 0)
            {
                $return['error'] = FALSE;
                $return['data'] = $aux;
            }
            else
            {
                $return['error'] = TRUE;
                $return['data'] = mostrar_palabra(233, $palabras);
            }
            
        }

        echo json_encode($return);
    }

    /*
    r = reporter = origen
    p = partner = destino
    freq = frecuencia
    ps = time period -> recent = ultimos 5
    px = classification -> HS = Harmonized System
    rg = trade regime -> 1 = import, 2 = export, all = all
    cc = classification code -> 101010
    ejemplo http://comtrade.un.org/api/get?type=C&freq=A&px=HS&ps=recent&r=826&p=0&rg=1&cc=TOTAL&fmt=json

    BUSCAR
    valor de exportaciones sobre la posicion arancelaria del ultimo año con registro entre los paises coincidentes
    porcentaje de crecimiento o decrecimiento del valor con respecto a los ultimos 5 años
    */

    public function buscar_comtrade($ctry_code_origen, $ctry_code_destino, $rg, $ara, $cat)
    {
        $lang = $this->session->userdata('idi_code');

        if($ara < 100000)
        {
            $ara_comtrade = strval("0".$ara);
        }
        else
        {
            $ara_comtrade = strval($ara);
        }

        
        if($ctry_code_origen != "0")
        {
            $row_pais = $this->paises_model->get_items($lang, $ctry_code_origen);
            $origen = $row_pais['ctry_code3'];
            //$destino_descripcion = $row_pais['ctry_nombre'];
        }
        else
        {
            $origen = 0;
        }

        if($ctry_code_destino != "0")
        {
            $row_pais2 = $this->paises_model->get_items($lang, $ctry_code_destino);
            $destino = $row_pais2['ctry_code3'];
            //$origen_descripcion = $row_pais2['ctry_nombre'];
        }
        else
        {
            $destino = 0;
        }


        // BUSCO LA INFORMACION CON EL CODIGO DE 6 DIGITOS (ARANCEL)
        //echo "http://comtrade.un.org/api/get?type=C&freq=A&px=HS&ps=recent&r=".$origen."&p=".$destino."&rg=".$rg."&cc=".$ara_comtrade."&fmt=json";
        $json = file_get_contents("http://comtrade.un.org/api/get?type=C&freq=A&px=HS&ps=recent&r=".$origen."&p=".$destino."&rg=".$rg."&cc=".$ara_comtrade."&fmt=json");
        $data = json_decode($json);

        if(count($data->dataset)>0)
        {
            foreach($data->dataset as $key => $value)
            {
                $this->comtrade_model->set_item($value->yr, $ctry_code_origen, $ctry_code_destino, $rg, $ara, $value->TradeQuantity, $value->TradeValue);
            }

            return TRUE;
        }
        /*else
        {
            // BUSCO LA INFORMACION CON EL CODIGO DE 2 DIGITOS (CATEGORIA)
            $json = file_get_contents("http://comtrade.un.org/api/get?type=C&freq=A&px=HS&ps=recent&r=".$origen."&p=".$destino."&rg=".$rg."&cc=".$cat."&fmt=json");
            $data = json_decode($json);
            
            if(count($data->dataset)>0)
            {
                foreach($data->dataset as $key => $value)
                {
                    $this->comtrade_model->set_item($value->yr, $ctry_code_origen, $ctry_code_destino, $rg, $cat, $value->TradeQuantity, $value->TradeValue);
                }

                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }*/

        return FALSE;
    }


    /**************
    PRODUCTOS
    **************/

    public function buscar_productos()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$tp_id = $request->tp_id;
        
        if($request == "")
        {
            extract($_POST);
        }

        $data['error'] = FALSE;
        $data['resultados'] = $this->productos_model->get_items($this->session->userdata('idi_code'), $this->session->userdata('usr_id'), $tp_id);

        echo json_encode($data);
    }

    public function cargar_producto()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$prod_id = $request->prod_id;
        @$tp_id = $request->tp_id;
        
        if($request == "")
        {
            extract($_POST);
        }

        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['error'] = FALSE;

        $data['producto'] = $this->productos_model->get_item($this->session->userdata('idi_code'), $prod_id);
        $data['producto_mails'] = $this->productos_model->get_item_mails($prod_id);
        $data['producto_idiomas'] = $this->productos_model->get_item_idiomas($this->session->userdata('idi_code'), $prod_id);

        echo json_encode($data);
    }

    public function producto_nuevo()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$tp_id = $request->tp_id;
        @$seccion = $request->seccion;
        @$categoria = $request->categoria;
        @$arancel = $request->arancel;
        @$nombre = $request->nombre;
        @$descripcion = $request->descripcion;
        
        if($request == "")
        {
            extract($_POST);
        }
        
        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['error'] = FALSE;

        $this->form_validation->set_rules('seccion', mostrar_palabra(76, $palabras), 'required');
        $this->form_validation->set_rules('categoria', mostrar_palabra(25, $palabras), 'required');
        $this->form_validation->set_rules('arancel', mostrar_palabra(157, $palabras), 'required');
        $this->form_validation->set_rules('pais', mostrar_palabra(2, $palabras), 'required');
        $this->form_validation->set_rules('ciudad', mostrar_palabra(32, $palabras), 'required');
        $this->form_validation->set_rules('descripcion', mostrar_palabra(27, $palabras), 'required');
        $this->form_validation->set_rules('mail[]', mostrar_palabra(4, $palabras), 'required|valid_email');
        $this->form_validation->set_rules('idioma[]', mostrar_palabra(3, $palabras), 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $data['error'] = TRUE;
            $data['data'] = validation_errors();
        }
        else
        {
            $result = $this->productos_model->set_item($tp_id, $this->session->userdata('usr_id'), $this->input->post('seccion'), $this->input->post('categoria'), $this->input->post('arancel'), $this->input->post('descripcion'), $this->input->post('pais'), $this->input->post('ciudad'), 1);
            if($result)
            {
                foreach ($this->input->post('mail[]') as $key => $mail)
                {
                    // VALIDAR MAIL
                    $mailAux = $this->mails_model->existe_mail_usuario($mail, $this->session->userdata('usr_id'));
                    if($mailAux == FALSE)
                    {
                        $codigo = RandomString(4);
                        $mail_id = $this->mails_model->set_item($this->session->userdata('usr_id'), $mail, $codigo, 0);
                        
                        $this->load->helper('mails');

                        $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'), 4);
                        
                        $titulo = str_replace("[USER MAIL]", $this->session->userdata('usr_mail'), $mail_info['mi_titulo']);
                        $mensaje1 = str_replace("[USER MAIL 2]", $mail, $mail_info['mi_cuerpo1']);
                        $mensaje2 = str_replace("[LINK]", "<a href='".site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo)."' style='color:#FFFFFF; text-decoration:none;'>".mostrar_palabra(1, $palabras)."</a>", $mail_info['mi_cuerpo2']);
                        $mensaje2 = str_replace("[HTTP/:]", site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo), $mensaje2);
                        $mensaje2 = str_replace("[USER MAIL]", $mail, $mensaje2);
                        $mensaje2 = str_replace("[CLAVE]", $codigo, $mensaje2);
                        
                        mail_base($mail, $mail_info['mi_asunto'], $titulo, $mensaje1, $mensaje2);
                    }
                    else
                    {
                        $mail_id = $mailAux['mail_id'];
                    }

                    $this->productos_model->set_item_mail($result, $mail_id);
                }

                foreach ($this->input->post('idioma[]') as $key => $idioma)
                {
                    $this->productos_model->set_item_idioma($result, $idioma);
                }

                $data['error'] = FALSE;
                $data['data'] = mostrar_palabra(222, $palabras);
            }
            else
            {
                $data['error'] = TRUE;
                $data['data'] = mostrar_palabra(223, $palabras);
            }
        }
        echo json_encode($data);
    }

    public function actualizar_producto()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$prod_id = $request->prod_id;
        @$tp_id = $request->tp_id;
        @$seccion = $request->seccion;
        @$categoria = $request->categoria;
        @$arancel = $request->arancel;
        @$nombre = $request->nombre;
        @$descripcion = $request->descripcion;
        
        if($request == "")
        {
            extract($_POST);
        }

        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['error'] = FALSE;

        $this->form_validation->set_rules('seccion', mostrar_palabra(76, $palabras), 'required');
        $this->form_validation->set_rules('categoria', mostrar_palabra(25, $palabras), 'required');
        $this->form_validation->set_rules('arancel', mostrar_palabra(157, $palabras), 'required');
        $this->form_validation->set_rules('pais', mostrar_palabra(2, $palabras), 'required');
        $this->form_validation->set_rules('ciudad', mostrar_palabra(32, $palabras), 'required');
        $this->form_validation->set_rules('descripcion', mostrar_palabra(27, $palabras), 'required');
        $this->form_validation->set_rules('mail[]', mostrar_palabra(4, $palabras), 'required|valid_email');
        $this->form_validation->set_rules('idioma[]', mostrar_palabra(3, $palabras), 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $data['error'] = TRUE;
            $data['data'] = validation_errors();
        }
        else
        {
            $result = $this->productos_model->update_item($prod_id, $this->session->userdata('usr_id'), $this->input->post('seccion'), $this->input->post('categoria'), $this->input->post('arancel'), $this->input->post('descripcion'), $this->input->post('pais'), $this->input->post('ciudad'));
            if($result)
            {
                $this->productos_model->delete_item_mails($prod_id);
                
                foreach ($this->input->post('mail[]') as $key => $mail)
                {
                    //$this->productos_model->set_item_mail($data['producto']['prod_id'], $mail);
                    // VALIDAR MAIL
                    $mailAux = $this->mails_model->existe_mail_usuario($mail, $this->session->userdata('usr_id'));
                    if($mailAux == FALSE)
                    {
                        $codigo = RandomString(4);
                        $mail_id = $this->mails_model->set_item($this->session->userdata('usr_id'), $mail, $codigo, 0);

                        $this->load->helper('mails');

                        $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'), 4);
                        
                        $titulo = str_replace("[USER MAIL]", $this->session->userdata('usr_mail'), $mail_info['mi_titulo']);
                        $mensaje1 = str_replace("[USER MAIL 2]", $mail, $mail_info['mi_cuerpo1']);
                        $mensaje2 = str_replace("[LINK]", "<a href='".site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo)."' style='color:#FFFFFF; text-decoration:none;'>".mostrar_palabra(1, $palabras)."</a>", $mail_info['mi_cuerpo2']);
                        $mensaje2 = str_replace("[HTTP/:]", site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo), $mensaje2);
                        $mensaje2 = str_replace("[USER MAIL]", $mail, $mensaje2);
                        $mensaje2 = str_replace("[CLAVE]", $codigo, $mensaje2);
                        
                        mail_base($mail, $mail_info['mi_asunto'], $titulo, $mensaje1, $mensaje2);
                    }
                    else
                    {
                        $mail_id = $mailAux['mail_id'];
                    }

                    $this->productos_model->set_item_mail($prod_id, $mail_id);
                }
                
                $this->productos_model->delete_item_idiomas($prod_id);
                foreach ($this->input->post('idioma[]') as $key => $idioma)
                {
                    $this->productos_model->set_item_idioma($prod_id, $idioma);
                }
                
                $data['error'] = FALSE;
                $data['data'] = mostrar_palabra(222, $palabras);
            }
            else
            {
                $data['error'] = TRUE;
                $data['data'] = mostrar_palabra(223, $palabras);
            }
        }

        echo json_encode($data);
    }

    public function eliminar_producto()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$prod_id = $request->prod_id;
        
        if($request == "")
        {
            extract($_POST);
        }

        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['error'] = FALSE;
        $data['data'] = mostrar_palabra(222, $palabras);

        $this->productos_model->delete_item_mails($prod_id);
        $this->productos_model->delete_item_idiomas($prod_id);
        $this->productos_model->delete_item($prod_id, $this->session->userdata('usr_id'));

        echo json_encode($data);
    }

    public function click_contacto_ajax()
    {
        $this->load->model('click_contacto_model');

        $result = $this->click_contacto_model->set_item($this->input->post('origen'), $this->input->post('destino'), $this->input->post('contenido'), $this->input->post('tipo'));
        if($result)
        {
            $data['error'] = FALSE;
            $data['data'] = "Ok";
        }
        else
        {
            $data['error'] = FALSE;
            $data['data'] = "Error";
        }

        echo json_encode($data);
    }

}