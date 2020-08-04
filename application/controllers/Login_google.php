<?php
class Login_google extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        date_default_timezone_set ( "America/Argentina/Buenos_Aires" );
		$this->load->model('user_model');
        $this->load->model('idiomas_model');
        $this->load->model('paises_model');
        $this->load->model('palabras_model');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

    public function index() 
    {
        // Include two files from google-php-client library in controller
        include_once APPPATH . 'libraries/google-api-php-client-master/src/Google/autoload.php';
        include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Client.php";
        include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Service/Oauth2.php";

        // Store values in variables from project created in Google Developer Console
        $client_id = '264174611569-v9k86tcsgmdvl7gm7pgkcon9rbp775k4.apps.googleusercontent.com';
        $client_secret = 'WqCCq7LnWiHoYcmRO89gwLbv';
        $redirect_uri = site_url()."login_google";
        $simple_api_key = 'AIzaSyDTN2bD-JhU0juAWZRw569qj9Jk7R80H7k';

        // Create Client Request to access Google API
        $client = new Google_Client();
        $client->setApplicationName("EnBandeja");
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->setDeveloperKey($simple_api_key);
        $client->addScope("https://www.googleapis.com/auth/userinfo.email");

        // Send Client Request
        $objOAuthService = new Google_Service_Oauth2($client);

        // Add Access Token to Session
        if (isset($_GET['code']))
        {
            $client->authenticate($_GET['code']);
            $this->session->set_userdata('google_token', $client->getAccessToken());
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }

        // Set Access Token to make Request
        if ($this->session->userdata('google_token')!= "")
        {
            $client->setAccessToken($this->session->userdata('google_token'));
        }

        // Get User Data from Google and store them in $data
        if ($client->getAccessToken())
        {
            $userData = $objOAuthService->userinfo->get();
            $this->session->set_userdata('google_token', $client->getAccessToken());

            $user = $this->user_model->login_google($userData->id);
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
                if($this->user_model->existe_mail($userData->email))
                {
                    //UNIR USUARIOS
                    $this->user_model->update_google($userData->email, $userData->id);
                    $user = $this->user_model->login_google($userData->id);
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
                        $this->load->view('login/registro', $data);
                    }
                }
                else
                {
                    $sexo_aux = "f";
                    $phone_aux = "";
                    if($userData->gender == "male")
                    {
                        $sexo_aux = "m";
                    }

                    $user_id = $this->user_model->set_item_google($userData->given_name, $userData->family_name, $userData->email, $this->session->userdata('idi_code'), $userData->id, $this->session->userdata('usr_pais'));
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
                        $data['error'] = "No se pudo registrar el usuario.";
                        $this->load->view('login/registro', $data);
                    }
                }
            }
        } 
        else
        {
            $data['login_url'] = $client->createAuthUrl();
            redirect($data['login_url']);
        }
    }

    public function validar_ajax()
    {
        /*
        $_POST['mail'] = "fabianmayoral@hotmail.com";
        $_POST['clave'] = "1234";
        */
        $return['error'] = FALSE;
        $return['data'] = "";

        $this->lang->load('form_validation', $this->session->userdata('idi_code'));

        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        if($this->input->post('pais') != "" && $this->input->post('idioma') != "")
        {
            $this->session->set_userdata('idi_code', $this->input->post('idioma'));
            $this->session->set_userdata('usr_pais', $this->input->post('pais'));

            $return['error'] = FALSE;
            $return['data'] = "ok";
        }
        else
        {
            $return['error'] = TRUE;

            if($this->input->post('pais') == "")
            {
                $return['data'] = '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.str_replace('{field}', $palabras[2]['pal_desc'], $this->lang->line('form_validation_required')).'</div>';
            }

            if($this->input->post('idioma') == "")
            {
                $return['data'] .= '<br><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.str_replace('{field}', $palabras[3]['pal_desc'], $this->lang->line('form_validation_required')).'</div>';
            }
        }

        echo json_encode($return);
    }

}