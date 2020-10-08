<?php
class Login extends CI_Controller {

    private static $solapa = "login";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('administradores_model');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

    public function index()
    {
        $data['solapa'] = self::$solapa;
        $data['title'] = 'Login';
        $data['error'] = "";
        $data['success'] = "";

        $this->form_validation->set_rules('usuario', 'usuario', 'required');
        $this->form_validation->set_rules('clave', 'clave', 'required');

        if ($this->form_validation->run() === FALSE)
        {
          if($this->session->userdata('admin_id')) // Ya esta logueado
          {
            redirect('pages');
          }
          else // no esta logueado
          {
            $this->load->view(self::$solapa.'/index', $data);
          }
        }
        else
        {
            $user = $this->administradores_model->login($this->input->post('usuario'), $this->input->post('clave'));
            if($user)
            {
                $this->session->set_userdata('admin_id', $user['admin_id']);
                $this->session->set_userdata('usr_id', $user['admin_id']);
                $this->session->set_userdata('usr_nombre', $user['admin_nombre']);
                $this->session->set_userdata('usr_apellido', $user['admin_apellido']);
                $this->session->set_userdata('usr_usuario', $user['admin_usuario']);

                redirect('pages');
            }
            else
            {
                $data['error'] = "El usuario o la contrase&ntilde;a son incorrectos.";
                $this->load->view(self::$solapa.'/index', $data);
            }
        }
    }

    public function logout()
    {
    	$this->session->unset_userdata('admin_id');
        $this->session->sess_destroy();

        redirect(self::$solapa.'/index', 'refresh');
    }

}