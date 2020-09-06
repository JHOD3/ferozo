<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    private static $solapa = "login";

	public function __construct()
	{
		parent::__construct();

        if($this->session->userdata('idi_code') == "")
        {
            $this->session->set_userdata('idi_code',"en");
        }

        $this->config->set_item('language', $this->session->userdata('idi_code'));
        date_default_timezone_set('America/Argentina/Buenos_Aires');

        header("Access-Control-Allow-Origin: *");
        //header("Content-Type: application/json; charset=UTF-8");

		$this->load->model('user_model');
        $this->load->model('idiomas_model');
        $this->load->model('paises_model');
        $this->load->model('palabras_model');
        $this->load->model('mails_model');
        $this->load->model('mails_info_model');
        $this->load->model('productos_model');
        
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

    public function login_ajax()
    {
        //$_POST['mail'] = "latam@staibyo.com";
        //$_POST['clave'] = "Staibyo2017";
        
        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $this->form_validation->set_rules('mail', mostrar_palabra(4, $palabras), 'required|valid_email');
        $this->form_validation->set_rules('clave', mostrar_palabra(5, $palabras), 'required');

        if ($this->form_validation->run() !== FALSE)
        //if($this->input->post('mail') != "" && $this->input->post('clave') != "")
        {
            $user = $this->user_model->login($this->input->post('mail'), $this->input->post('clave'));
            if($user)
            {
                if($user['usr_estado'] == 1)
                {
                    if($user['usr_ads_estado'] == 1)
                    {
                        $this->session->set_userdata('ads_id', $user['usr_id']);
                    }

                    $this->session->set_userdata('usr_id', $user['usr_id']);
                    $this->session->set_userdata('usr_nombre', $user['usr_nombre']);
                    $this->session->set_userdata('usr_apellido', $user['usr_apellido']);
                    $this->session->set_userdata('usr_mail', $user['usr_mail']);
                    $this->session->set_userdata('idi_code', $user['idi_code']);
                    $this->session->set_userdata('usr_pais', $user['usr_pais']);
                    $this->session->set_userdata('usr_provincia', $user['usr_provincia']);
                    $this->session->set_userdata('tu_id', $user['tu_id']);

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
                    $return['data'] = "ok";
                }
                else
                {
					
                    $return['error'] = TRUE;
                    $return['data'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(202, $palabras).'</div>';
                }
            }
            else
            {
                $return['error'] = TRUE;
                $return['data'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(100, $palabras).'</div>';
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
        /*
        $_POST['mail'] = "asd@asd33.com";
        $_POST['clave'] = "1234";
        $_POST['clave2'] = "1234";
        $_POST['idioma'] = "es";
        $_POST['pais'] = "ARG";
        */
        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $this->form_validation->set_rules('mail', mostrar_palabra(4, $palabras), 'trim|required|valid_email');
        $this->form_validation->set_rules('clave', mostrar_palabra(5, $palabras), 'trim|required');
        $this->form_validation->set_rules('clave2', mostrar_palabra(6, $palabras).' '.mostrar_palabra(5, $palabras), 'trim|required|matches[clave]');
        $this->form_validation->set_rules('pais', mostrar_palabra(2, $palabras), 'required');
        $this->form_validation->set_rules('idioma', mostrar_palabra(3, $palabras), 'required');
        $this->form_validation->set_rules('acepto', mostrar_palabra(170, $palabras), 'required');

        if ($this->form_validation->run() !== FALSE)
        //if($this->input->post('mail') != "" && $this->input->post('clave') != "")
        {
            $palabras = $this->palabras_model->get_items($this->input->post('idioma'));
            
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

                    $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'),1);
                    
                    $titulo = str_replace("[USER MAIL]", "<a href='mailto:".$this->input->post('mail')."' style='color:#FFFFFF;'>".$this->input->post('mail')."</a>", $mail_info['mi_titulo']);
                    //$mensaje1 = str_replace("[BOTON]", "<a href='".site_url("login/activar/".$user_id."/".$codigo)."' style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'>VALIDAR MAIL</a>", $mail_info['mi_cuerpo1']);
                    $mensaje2 = str_replace("[LINK]", "<div style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'><a href='".site_url("login/activar/".$user_id."/".$codigo)."' style='color:#C30D00;'>".site_url("login/activar/".$user_id."/".$codigo)."</a></div>", $mail_info['mi_cuerpo2']);
                    $mensaje2 = str_replace("[HTTP/:]", site_url("login/activar/".$user_id."/".$codigo), $mensaje2);
                    $mensaje2 = str_replace("[USER MAIL]", $this->input->post('mail'), $mensaje2);
                    $mensaje2 = str_replace("[CLAVE]", $codigo, $mensaje2);

                    $result = mail_base($this->input->post('mail'), $mail_info['mi_asunto'], $titulo, $mail_info['mi_cuerpo1'], $mensaje2);
                    //$result = mail_base_sendgrid($this->input->post('mail'), $mail_info['mi_asunto'], $titulo, $mail_info['mi_cuerpo1'], $mensaje2);

                    $return['error'] = FALSE;
                    $return['data'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(198, $palabras)."<br>".mostrar_palabra(236, $palabras).'</div>';
                }
                else
                {
                    $return['error'] = TRUE;
                    $return['data'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(101, $palabras).'</div>';
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
                    
                    $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'),1);
                    
                    $titulo = str_replace("[USER MAIL]", $this->input->post('mail'), $mail_info['mi_titulo']);
                    //$mensaje1 = str_replace("[BOTON]", "<a href='".site_url("login/activar/".$user_id."/".$codigo)."' style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'>VALIDAR MAIL</a>", $mail_info['mi_cuerpo1']);
                    $mensaje2 = str_replace("[LINK]", "<div style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'><a href='".site_url("login/activar/".$user_id."/".$codigo)."' style='color:#C30D00;'>".site_url("login/activar/".$user_id."/".$codigo)."</a></div>", $mail_info['mi_cuerpo2']);
                    $mensaje2 = str_replace("[HTTP/:]", site_url("login/activar/".$user_id."/".$codigo), $mensaje2);
                    $mensaje2 = str_replace("[USER MAIL]", $this->input->post('mail'), $mensaje2);
                    $mensaje2 = str_replace("[CLAVE]", $codigo, $mensaje2);

                    $result = mail_base($this->input->post('mail'), $mail_info['mi_asunto'], $titulo, $mail_info['mi_cuerpo1'], $mensaje2);
                    //$result = mail_base_sendgrid($this->input->post('mail'), $mail_info['mi_asunto'], $titulo, $mail_info['mi_cuerpo1'], $mensaje2);

                    $return['error'] = FALSE;
                    $return['data'] = '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(198, $palabras)."<br>".mostrar_palabra(236, $palabras).'</div>';
                }
                else
                {
                    $return['error'] = TRUE;
                    $return['data'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.mostrar_palabra(223, $palabras).'</div>';
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

    public function login_facebook()
    {
        $data['solapa'] = "user";
        $data['title'] = 'Login Facebook';
        $data['error'] = "";
        $data['success'] = "";

        $this->load->library('facebook');

        if ($this->facebook->is_authenticated())
        {
            $user_profile = $this->facebook->request('get', '/me?fields=id,name,email,gender,first_name,last_name');
            //print_r($user_profile);
            //die();
            if(!isset($user_profile['error']))
            {
                $user = $this->user_model->login_facebook($user_profile['id']);
                if($user)
                {
                    $this->session->set_userdata('usr_id', $user['usr_id']);
                    $this->session->set_userdata('usr_nombre', $user['usr_nombre']);
                    $this->session->set_userdata('usr_apellido', $user['usr_apellido']);
                    $this->session->set_userdata('usr_mail', $user['usr_mail']);
                    $this->session->set_userdata('idi_code', $user['idi_code']);
                    $this->session->set_userdata('usr_pais', $user['usr_pais']);
                    $this->session->set_userdata('usr_provincia', $user['usr_provincia']);
                    $this->session->set_userdata('tu_id', $user['tu_id']);

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
                    $return['data'] = "ok";

                    redirect('resultados');
                }
                else
                {
                    if($this->user_model->existe_mail($user_profile['email']))
                    {
                        //UNIR USUARIOS
                        $this->user_model->update_facebook($user_profile['email'], $user_profile['id']);
                        $user = $this->user_model->login_facebook($user_profile['id']);
                        if($user)
                        {
                            $this->session->set_userdata('usr_id', $user['usr_id']);
                            $this->session->set_userdata('usr_nombre', $user['usr_nombre']);
                            $this->session->set_userdata('usr_apellido', $user['usr_apellido']);
                            $this->session->set_userdata('usr_mail', $user['usr_mail']);
                            $this->session->set_userdata('idi_code', $user['idi_code']);
                            $this->session->set_userdata('usr_pais', $user['usr_pais']);
                            $this->session->set_userdata('usr_provincia', $user['usr_provincia']);
                            $this->session->set_userdata('tu_id', $user['tu_id']);

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
                            $return['data'] = "ok";

                            redirect('resultados');
                        }
                        else
                        {
                            $data['error'] = "No se pudo registrar el usuario.";
                            //$this->load->view('login/registro', $data);
                            redirect('resultados');
                        }
                    }
                    else
                    {
                        $sexo_aux = "f";
                        $phone_aux = "";
                        if($user_profile['gender'] == "male")
                        {
                            $sexo_aux = "m";
                        }
                        /*
                        if(array_key_exists("mobile_phone",$user_profile))
                        {
                            $phone_aux = $user_profile['mobile_phone'];
                        }
                        */
                        $user_id = $this->user_model->set_item_facebook($user_profile['first_name'], $user_profile['last_name'], $user_profile['email'], $this->session->userdata('idi_code'), $user_profile['id'], $this->session->userdata('usr_pais'));
                        if($user_id)
                        {
                            $user = $this->user_model->get_items($user_id);

                            $this->session->set_userdata('usr_id', $user['usr_id']);
                            $this->session->set_userdata('usr_nombre', $user['usr_nombre']);
                            $this->session->set_userdata('usr_apellido', $user['usr_apellido']);
                            $this->session->set_userdata('usr_mail', $user['usr_mail']);
                            $this->session->set_userdata('idi_code', $user['idi_code']);
                            $this->session->set_userdata('usr_pais', $user['usr_pais']);
                            $this->session->set_userdata('usr_provincia', $user['usr_provincia']);
                            $this->session->set_userdata('tu_id', $user['tu_id']);

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
                            $return['data'] = "ok";

                            //$this->load->helper('mails');
                            //mail_bienvenida($user_profile['email'], $user_profile['first_name']);

                            redirect('resultados');
                        }
                        else
                        {
                            //$data['error'] = "No se pudo registrar el usuario.";
                            //$this->load->view('login/registro', $data);
                            $this->session->set_flashdata('error', "No se pudo registrar el usuario.");
                            redirect();
                        }
                    }
                }
            }
            else
            {
                //$data['error'] = "Ocurrió un error en el login de facebook. 2<br>Por favor vuelva a intentarlo.";
                //$this->load->view('login/registro', $data);
                $this->session->set_flashdata('error', "Ocurrió un error en el login de facebook.<br>".$user_profile['error']."<br>Por favor vuelva a intentarlo.");
                redirect();
            }
        }
        elseif($this->input->get('code') != "")
        {
            //$data['error'] = ;
            //$this->load->view('login/registro', $data);
            $this->session->set_flashdata('error', "Ocurrió un error en el login de facebook.<br>Por favor vuelva a intentarlo.");
            redirect();
        }
        else 
        {
            $url = $this->facebook->login_url();
            //$url = "https://www.facebook.com/v2.8/dialog/oauth?client_id=2020830071527458&state=8ea9135c28f89dec2ed88dc8efade918&response_type=code&sdk=php-sdk-5.4.4&redirect_uri=https%3A%2F%2Fwww.nocnode.com%2Flogin%2Flogin_facebook&scope=public_profile%2Cemail";
            /*
            foreach ($_SESSION as $k=>$v)
            {                    
                if(strpos($k, "FBRLH_")!==FALSE)
                {
                    if(!setcookie($k, $v))
                    {
                        //what??
                    } else
                    {
                        $_COOKIE[$k]=$v;
                    }
                }
            }*/
            //var_dump($_COOKIE);
            //echo $url;
            //die();
            redirect($url);
        }
    }

    public function activar($user_id = FALSE, $codigo = FALSE)
    {
        $data['error'] = "";

        $data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));
        $data['idiomas_completos'] = $this->idiomas_model->get_items_completos();
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
                    $data['conversion'] = '<!-- Google Code for Registro Conversion Page -->
                    <script type="text/javascript"> /* <![CDATA[ */ var google_conversion_id = 855185616; var google_conversion_language = "en"; var google_conversion_format = "3"; var google_conversion_color = "ffffff"; var google_conversion_label = "GLtUCOaUzXAQ0LHklwM"; var google_remarketing_only = false;/* ]]> */</script>
                    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
                    <noscript><div style="display:inline;"><img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/855185616/?label=GLtUCOaUzXAQ0LHklwM&amp;guid=ON&amp;script=0"/></div></noscript>';
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
        $data['success'] = "";
        $data['codigo'] = $codigo;

        $data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        if($user_id == FALSE || $codigo == FALSE)
        {
            if($this->input->post('mail') != "" && $this->input->post('codigo') != "")
            {
                $user = $this->mails_model->get_items_byMail($this->input->post('mail'));
                if($user)
                {
                    $mail = $this->mails_model->get_item_user_codigo($user['usr_id'], $this->input->post('codigo'));
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
                else
                {
                    $this->load->view('pages/validar', $data);
                }
            }
            else
            {
                $this->load->view('pages/validar', $data);
            }
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
                        $mensaje2 = str_replace("[NOCNODE MAIL]", "contact@nocnode.com", $mail_info['mi_cuerpo2']);
                        
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
        //$_POST['mail'] = "fabianmayoral@hotmail.com";
    	$this->form_validation->set_rules('mail', mostrar_palabra(4, $palabras), 'required|valid_email');

    	if ($this->form_validation->run() !== FALSE)
        //if ($this->input->post('mail') != "")
    	{
    	    $user = $this->user_model->get_items_byMail($this->input->post('mail'));
    		if($user)
            {
                $mail = $this->mails_model->get_item_user($user['usr_id'], $this->input->post('mail'));
                $this->load->helper('mails');

                $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'), 2);
                
                $titulo = str_replace("[USER MAIL]", $this->input->post('mail'), $mail_info['mi_titulo']);
                $mensaje1 = $mail_info['mi_cuerpo1'];
                //https://www.nocnode.com/login/reset/13940/pEgA
                $mensaje2 = str_replace("[LINK]", site_url()."login/reset/".$user['usr_id']."/".$mail['mail_codigo'], $mail_info['mi_cuerpo2']);
                $mensaje2 = str_replace("[HOURS]", date('h:i'), $mensaje2);
                $fecha = date('Y-m-d');
                $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
                $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
                $mensaje2 = str_replace("[DAYS]", $nuevafecha, $mensaje2);
                $mensaje2 = str_replace("[NOCNODE MAIL]", "contact@nocnode.com", $mensaje2);

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
        $data['solapa'] = self::$solapa;
    	$data['title'] = 'Logout';
        /*
        if($this->session->userdata('usr_facebook') != "")
        {
            $this->load->library('facebook', array('appId' => '702849006490399', 'secret' => '220d56fc2cde507af2f6409deb2fb290', 'cookie' => false));
            $this->session->unset_userdata('usr_facebook');
            //$this->$facebook->destroySession();
            $data['logout_url'] = $this->facebook->getLogoutUrl(array('next' => site_url() . 'login/logout'));
            redirect($data['logout_url']);
        }
        */
    	$this->session->unset_userdata('usr_id');
        //$this->session->unset_userdata('google_token');
        $this->session->sess_destroy();

        redirect('/pages', 'refresh');
    }
	
	

}