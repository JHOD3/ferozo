<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formularios extends CI_Controller {

	private static $solapa = "formularios";

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ads_model');
        $this->load->model('paises_model');
        $this->load->model('palabras_model');
        $this->load->model('aranceles_model');
        $this->load->model('productos_model');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

	public function index()
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['titulo'] = $data['palabras'][356]['pal_desc'];
        $data['subtitulo'] = "";
        $data['breadcum'] = array( array('link' => 'javascript:;', 'texto' => $data['palabras'][356]['pal_desc']), array('link' => '', 'texto' => $data['palabras'][370]['pal_desc']) );
        
        $data['items'] = $this->ads_model->get_formularios($this->session->userdata('usr_id'));

        $this->load->view(self::$solapa.'/index', $data);
    }

    public function publicacion($ads_id)
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['titulo'] = $data['palabras'][356]['pal_desc'];
        $data['subtitulo'] = "";
        $data['breadcum'] = array( array('link' => 'javascript:;', 'texto' => $data['palabras'][356]['pal_desc']), array('link' => '', 'texto' => $data['palabras'][370]['pal_desc']) );
        
        $data['items'] = $this->ads_model->get_item_formularios($ads_id);

        $this->load->view(self::$solapa.'/index', $data);
    }

	public function view($form_id)
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['titulo'] = $data['palabras'][356]['pal_desc'];
        $data['subtitulo'] = $data['palabras'][311]['pal_desc'];
        $data['breadcum'] = array( array('link' => site_url('formularios'), 'texto' => $data['palabras'][356]['pal_desc']), array('link' => '', 'texto' => $data['palabras'][311]['pal_desc']) );

        $data['item'] = $this->ads_model->get_formulario($this->session->userdata('idi_code'), $form_id);

        $this->load->view(self::$solapa.'/view', $data);
    }

}
