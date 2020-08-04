<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muestras extends CI_Controller {

	private static $solapa = "muestras";

	public function __construct()
	{
		parent::__construct();
		/*
		$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', $last_update).' GMT');
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
		*/
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
		$this->load->model('foro_model');
		$this->load->model('palabras_model');
		$this->load->model('mails_model');
        $this->load->model('mails_info_model');
        $this->load->model('comtrade_model');
        $this->load->model('referencias_model');
        $this->load->model('tipo_datos_model');
        $this->load->model('ads_model');
        $this->load->model('mensajes_model');
        
        $this->session->set_userdata('search', $this->input->post('search'));
		
		$this->load->view('templates/validate_login');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

    public function productos_index($tp_id = 1)
    {
        $data['usr_id'] = 13940;
        $data['usr_nombre'] = "Nicolas";
        $data['usr_apellido'] = "Bianchetti";
        $data['usr_mail'] = "XXXX@trinpex.com";
        $data['usr_imagen'] = "perfil2.jpg";

        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        $data['tipo_producto'] = $this->productos_model->get_tipos($this->session->userdata('idi_code'), $tp_id);
        $data['resultados'] = $this->productos_model->get_items($this->session->userdata('idi_code'), $data['usr_id'], $tp_id);
        $data['referencias_validadas'] = $this->referencias_model->get_cant_validados($data['usr_id']);

        if($data['tipo_producto'])
        {
            if($data['tipo_producto']['tp_id'] == TP_OFERTA)
            {
                $data['tipo_producto']['tp_desc'] = mostrar_palabra(82, $data['palabras']);
                $data['tipo_producto']['imagen'] = "oferta2.png";
                $data['texto_agregar'] = mostrar_palabra(342, $data['palabras']);
            }
            elseif($data['tipo_producto']['tp_id'] == TP_DEMANDA)
            {
                $data['tipo_producto']['tp_desc'] = mostrar_palabra(84, $data['palabras']);
                $data['tipo_producto']['imagen'] = "demanda2.png";
                $data['texto_agregar'] = mostrar_palabra(343, $data['palabras']);
            }
        }

        $nuevos = $this->session->flashdata();
        if($nuevos)
        {
            $data['matchs'] = 0;
            foreach ($nuevos as $key => $value)
            {
                $matchs = $this->resultados_model->get_matchs_producto($value);
                $data['matchs'] += count($matchs);
            }
        }

        $this->load->view(self::$solapa.'/productos/index', $data);
    }

    public function productos_nuevo($tp_id = 1, $ara_precargado = FALSE)
    {
        $data['usr_id'] = 13940;
        $data['usr_nombre'] = "Nicolas";
        $data['usr_apellido'] = "Bianchetti";
        $data['usr_mail'] = "XXXX@trinpex.com";
        $data['usr_imagen'] = "perfil2.jpg";

        $data['error'] = "";
        $data['success'] = "";

        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['tipo_producto'] = $this->productos_model->get_tipos($this->session->userdata('idi_code'), $tp_id);
        $data['secciones'] = $this->secciones_model->get_items($this->session->userdata('idi_code'));
        /*foreach ($data['secciones'] as $key => $seccion)
        {
            $data['secciones'][$key]['aranceles'] = $this->aranceles_model->get_items_seccion($this->session->userdata('idi_code'), $seccion['sec_id']);
        }*/
        $data['arancel_precargado'] = array();
        if($ara_precargado != FALSE)
        {
            $data['arancel_precargado'] = $this->aranceles_model->get_items($this->session->userdata('idi_code'), $ara_precargado);
        }

        $data['paises'] = $this->paises_model->get_items($this->session->userdata('idi_code'));
        $data['ciudades'] = array();
        $data['comparar_pais'] = $this->session->userdata('usr_pais');
        if($this->input->post('pais') != "")
        {
            $data['comparar_pais'] = $this->input->post('pais');
        }
        $data['ciudades'] = $this->paises_model->get_provincias_ciudad($this->session->userdata('idi_code'), $data['comparar_pais']);
        $data['comparar_ciudad'] = $this->session->userdata('usr_provincia');
        if($this->input->post('ciudad') != "")
        {
            $data['comparar_ciudad'] = $this->input->post('ciudad');
        }

        $data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));

        $data['referencias'] = $this->referencias_model->get_items($data['usr_id']);
        $this->load->view(self::$solapa.'/productos/nuevo', $data);
    }

    public function user_profile()
    {
        $data['usr_id'] = 13940;
        $data['usr_nombre'] = "Nicolas";
        $data['usr_apellido'] = "Bianchetti";
        $data['usr_mail'] = "XXXX@trinpex.com";
        $data['usr_imagen'] = "perfil2.jpg";

        $data['error'] = "";
        $data['success'] = "";

        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['user'] = $this->user_model->get_items($data['usr_id']);
        $data['paises'] = $this->paises_model->get_items($this->session->userdata('idi_code'));
        $data['ciudades'] = $this->paises_model->get_provincias_ciudad($this->session->userdata('idi_code'), $data['user']['usr_pais']);
        $data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));
        $data['tipo_datos'] = $this->tipo_datos_model->get_items($this->session->userdata('idi_code'));
        foreach($data['tipo_datos'] as $key_td => $tipo_dato)
        {
            $data['tipo_datos'][$key_td]['categorias'] = $this->tipo_datos_model->get_categorias($this->session->userdata('idi_code'), $tipo_dato['td_id']);
            $data['tipo_datos'][$key_td]['datos'] = $this->user_model->get_tipo_datos($data['usr_id'], $tipo_dato['td_id']);
        }
        $data['referencias'] = $this->referencias_model->get_items($data['usr_id']);

        $this->load->view(self::$solapa.'/user/profile', $data);
    }

    public function resultados_index()
    {
        $data['usr_id'] = 13940;
        $data['usr_nombre'] = "Nicolas";
        $data['usr_apellido'] = "Bianchetti";
        $data['usr_mail'] = "XXXX@trinpex.com";
        $data['usr_imagen'] = "perfil2.jpg";

        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        
        $this->load->view(self::$solapa.'/resultados/index', $data);
    }

    public function estadisticas_index()
    {
        $data['usr_id'] = 13940;
        $data['usr_nombre'] = "Nicolas";
        $data['usr_apellido'] = "Bianchetti";
        $data['usr_mail'] = "XXXX@trinpex.com";
        $data['usr_imagen'] = "perfil2.jpg";

        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        
        $data['pais'] = $this->paises_model->get_items($this->session->userdata('idi_code'), $this->session->userdata('usr_pais'));
        $data['principales_ofertas'] = $this->comtrade_model->get_principales_pais_crecimiento($this->session->userdata('idi_code'), $data['pais']['ctry_code'], "WLD", 2);
        $data['principales_demandas'] = $this->comtrade_model->get_principales_pais_crecimiento($this->session->userdata('idi_code'), $data['pais']['ctry_code'], "WLD", 1);

        $this->load->view(self::$solapa.'/estadisticas/index', $data);
    }


    public function buscar_resultados_ajax($offset = 0, $limit = 10)
    {
        $data['usr_id'] = 13940;
        $data['usr_nombre'] = "Nicolas";
        $data['usr_apellido'] = "Bianchetti";
        $data['usr_mail'] = "XXXX@trinpex.com";
        $data['usr_imagen'] = "perfil2.jpg";

        $aux = "";
        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        $resultados = $this->resultados_model->get_items($this->session->userdata('idi_code'), $data['usr_id'], $offset, $limit);
        if($resultados)
        {
            $ids = array();
            foreach ($resultados as $key => $resultado)
            {
                $ids[] = $resultado['prod_id'];
            }
            $ids_string = implode(', ',$ids);
            $resultados = $this->resultados_model->get_data_items($this->session->userdata('idi_code'), $ids_string);
            
            foreach ($resultados as $key => $resultado)
            {
                //$resultados[$key]['usr_ult_acceso'] = interval_date($resultado['usr_ult_acceso'], date('Y-m-d H:i:s'));
                $dias_aux = diferencia_dias($resultado['usr_ult_acceso'], date('Y-m-d H:i:s'));
                $ult_acceso = "";
                if($dias_aux < 1)
                {
                    $ult_acceso = str_replace("00.00", substr($resultado['usr_ult_acceso'],11,5), $palabras[167]['pal_desc']);
                }
                elseif($dias_aux < 2)
                {
                    $ult_acceso = str_replace("00.00", substr($resultado['usr_ult_acceso'],11,5), $palabras[168]['pal_desc']);
                }
                else
                {
                    $ult_acceso = str_replace("21", substr($resultado['usr_ult_acceso'],8,2), $palabras[169]['pal_desc']);
                    $ult_acceso = str_replace("12", substr($resultado['usr_ult_acceso'],5,2), $ult_acceso);
                    $ult_acceso = str_replace("2015", substr($resultado['usr_ult_acceso'],0,4), $ult_acceso);
                }
                $resultados[$key]['usr_ult_acceso'] = $ult_acceso;
                if($this->session->userdata('idi_code') != "zh")
                {
                    //$resultados[$key]['ara_desc'] = cortarTexto($resultado['ara_desc'],100);
                    //$resultados[$key]['ara_desc'] = cortarTextoArabe($resultado['ara_desc'],100);
                }
                
                if($offset == 0) //Traigo todos los ADS solo la primera vez
                {
                    $data['ads'] = $this->ads_model->get_items_match($this->session->userdata('idi_code'));
                }
            }
            $data['cant'] = count($resultados);
        }
        else
        {
            $productos = $this->productos_model->get_cant_items($data['usr_id']);
            if($productos && $productos['cant'] > 0)
            {
                if($this->hay_filtros())
                {
                    $data['cant'] = -2;
                }
                else
                {
                    $data['cant'] = 0;
                }
            }
            else
            {
                $data['cant'] = -1;
            }
        }
        $data['result'] = $resultados;
        //print_r($data);
        echo json_encode($data);
    }

}
