<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resultados extends CI_Controller {

	private static $solapa = "resultados";

	public function __construct()
	{
		parent::__construct();

		$this->config->set_item('language', $this->session->userdata('idi_code'));
		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->model('idiomas_model');
		$this->load->model('paises_model');
		$this->load->model('resultados_model');
		$this->load->model('productos_model');
		$this->load->model('user_model');
		$this->load->model('palabras_model');
		$this->load->model('aranceles_model');
		$this->load->model('favoritos_model');
		$this->load->model('foro_model');
		$this->load->model('comtrade_model');
		$this->load->model('referencias_model');
		$this->load->model('ads_model');
		$this->load->model('mensajes_model');
		
		$this->load->view('templates/validate_login');
	}

	public function index()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		
		$cant_resultados = $this->resultados_model->get_cant_items($this->session->userdata('usr_id'));
		if($cant_resultados && $cant_resultados['cant'] > 0)
		{
			$this->load->view(self::$solapa.'/index', $data);
		}
		else
		{
			$productos = $this->productos_model->get_cant_items($this->session->userdata('usr_id'));
			if($productos && $productos['cant'] > 0)
			{
				$this->load->view(self::$solapa.'/sin_resultados', $data);
			}
			else
			{
				$this->load->view(self::$solapa.'/sin_productos', $data);
			}
		}
	}

	public function otros()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		//$data['resultados'] = $this->resultados_model->get_items($this->session->userdata('idi_code'), $this->session->userdata('usr_id'));
		
		if (!empty($this->session->userdata('search'))){
			$data= $this->highlightWords($data, $this->session->userdata('search'));
		} 

		$this->load->view(self::$solapa.'/otros', $data);
	}

	public function filtros()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		/*
		$this->form_validation->set_rules('ofertas', 'ofertas', 'required');
		$this->form_validation->set_rules('demandas', 'demandas', 'required');
		$this->form_validation->set_rules('favoritos', 'favoritos', 'required');
		*/
		$this->form_validation->set_rules('enviar', 'enviar', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$data['paises'] = $this->resultados_model->get_paises($this->session->userdata('idi_code'), $this->session->userdata('usr_id'));
			if($this->session->userdata('filtro_pais') != "")
			{
				$data['ciudades'] = $this->paises_model->get_provincias_ciudad($this->session->userdata('idi_code'), $this->session->userdata('filtro_pais'));
			}
			else
			{
				$data['ciudades'] = array();
			}

			$data['aranceles'] = $this->resultados_model->get_aranceles($this->session->userdata('idi_code'), $this->session->userdata('usr_id'));

			$data['search'] = $this->session->userdata('search');
			$data['productos'] = $this->session->userdata('filtro_productos');
			$data['servicios'] = $this->session->userdata('filtro_servicios');
			$data['ofertas'] = $this->session->userdata('filtro_ofertas');
			$data['demandas'] = $this->session->userdata('filtro_demandas');
			$data['favoritos'] = $this->session->userdata('filtro_favoritos');
			$data['arancel_aux'] = $this->session->userdata('filtro_arancel');
			$data['pais_aux'] = $this->session->userdata('filtro_pais');
			$data['ciudad_aux'] = $this->session->userdata('filtro_ciudad');
			$data['orden'] = $this->session->userdata('filtro_orden');
			
			$this->load->view(self::$solapa.'/filtros', $data);
		}
		else
		{
			if($this->input->post('enviar')=="enviar")
			{
				$this->session->set_userdata('search', $this->input->post('search'));
				$this->session->set_userdata('filtro_productos', $this->input->post('productos'));
				$this->session->set_userdata('filtro_servicios', $this->input->post('servicios'));
				$this->session->set_userdata('filtro_ofertas', $this->input->post('ofertas'));
				$this->session->set_userdata('filtro_demandas', $this->input->post('demandas'));
				$this->session->set_userdata('filtro_favoritos', $this->input->post('favoritos'));
				$this->session->set_userdata('filtro_arancel', $this->input->post('arancel'));
				$this->session->set_userdata('filtro_pais', $this->input->post('pais'));
				$this->session->set_userdata('filtro_ciudad', $this->input->post('ciudad'));
				$this->session->set_userdata('filtro_orden', $this->input->post('orden'));
			}

			if($this->input->post('enviar')=="reset")
			{
				$this->session->set_userdata('search', "");
				$this->session->set_userdata('filtro_productos', "si");
				$this->session->set_userdata('filtro_servicios', "si");
				$this->session->set_userdata('filtro_ofertas', "si");
				$this->session->set_userdata('filtro_demandas', "si");
				$this->session->set_userdata('filtro_favoritos', "no");
				$this->session->set_userdata('filtro_arancel', "");
				$this->session->set_userdata('filtro_pais', "");
				$this->session->set_userdata('filtro_ciudad', "");
				$this->session->set_userdata('filtro_orden', "");
			}

			redirect(self::$solapa);
		}
	}

	public function view($prod_id = FALSE)
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['producto'] = $this->productos_model->get_item($this->session->userdata('idi_code'), $prod_id);
		$data['producto_mails'] = $this->productos_model->get_item_mails($prod_id);
		$data['producto_idiomas'] = $this->productos_model->get_item_idiomas($this->session->userdata('idi_code'), $prod_id);
		$data['tipo_producto'] = $this->productos_model->get_tipos($this->session->userdata('idi_code'), $data['producto']['tp_id']);
		$data['imagenes'] = $this->productos_model->get_item_imagenes($prod_id);
		$data['referencias_validadas'] = $this->referencias_model->get_items_validados($data['producto']['usr_id']);

		////// PARA REDES //////////
		$data['title'] = cortarTexto($data['tipo_producto']['tp_desc'], 55);
		$data['description'] = cortarTexto($data['producto']['prod_descripcion'], 150);
		$data['keywords'] = cortarTexto($data['producto']['prod_descripcion'], 150);
		$data['meta_og_title'] = cortarTexto($data['producto']['prod_descripcion'], 30);
		$data['meta_og_url'] = current_url();
		$data['meta_og_description'] = cortarTexto($data['producto']['prod_descripcion'], 60);
		if($data['imagenes'] && count($data['imagenes']))
		{
			$data['meta_og_image'] = base_url('images/productos/'.$data['imagenes'][0]['pi_ruta']);
		}
		$data['meta_og_type'] = "website";
		$data['meta_og_locale'] = $data['producto']['idi_code'];
		////////////////////////////

		$data['favorito'] = $this->favoritos_model->buscar_usuario_favorito($this->session->userdata('usr_id'), $data['producto']['usr_id']);

		$this->productos_model->set_item_visitado($prod_id, $this->session->userdata('usr_id'));
		
		/*$texto_final=json_encode($data);
		$texto_final = !empty($this->session->userdata('search'))?$this->highlightWords($texto_final, $this->session->userdata('search')):$texto_final;
		$data=json_decode($texto_final, true);*/

		if (!empty($this->session->userdata('search'))){
			$data= $this->highlightWords($data, $this->session->userdata('search'));
		} 
		$this->load->view(self::$solapa.'/view', $data);
	}

	public function view_otro($prod_id = FALSE)
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['producto'] = $this->productos_model->get_item($this->session->userdata('idi_code'), $prod_id);
		$data['producto_mails'] = $this->productos_model->get_item_mails($prod_id);
		$data['producto_idiomas'] = $this->productos_model->get_item_idiomas($this->session->userdata('idi_code'), $prod_id);
		$data['tipo_producto'] = $this->productos_model->get_tipos($this->session->userdata('idi_code'), $data['producto']['tp_id']);
		$data['imagenes'] = $this->productos_model->get_item_imagenes($prod_id);
		$data['referencias_validadas'] = $this->referencias_model->get_items_validados($data['producto']['usr_id']);

		////// PARA REDES //////////
		$data['title'] = cortarTexto($data['tipo_producto']['tp_desc'], 55);
		$data['description'] = cortarTexto($data['producto']['prod_descripcion'], 150);
		$data['keywords'] = cortarTexto($data['producto']['prod_descripcion'], 150);
		$data['meta_og_title'] = cortarTexto($data['producto']['prod_descripcion'], 30);
		$data['meta_og_url'] = current_url();
		$data['meta_og_description'] = cortarTexto($data['producto']['prod_descripcion'], 60);
		if($data['imagenes'] && count($data['imagenes']))
		{
			$data['meta_og_image'] = base_url('images/productos/'.$data['imagenes'][0]['pi_ruta']);
		}
		$data['meta_og_type'] = "website";
		$data['meta_og_locale'] = $data['producto']['idi_code'];
		////////////////////////////

		$data['favorito'] = $this->favoritos_model->buscar_usuario_favorito($this->session->userdata('usr_id'), $data['producto']['usr_id']);

		$this->productos_model->set_item_visitado($prod_id, $this->session->userdata('usr_id'));
		
		if (!empty($this->session->userdata('search'))){
			$data= $this->highlightWords($data, $this->session->userdata('search'));
		} 
		
		if (!empty($this->session->userdata('search'))){
			$data= $this->highlightWords($data, $this->session->userdata('search'));
		} 

		$this->load->view(self::$solapa.'/view_otro', $data);
	}

	public function buscar_producto_favorito_ajax($prod_id = FALSE)
	{
		$data['data'] = $this->favoritos_model->buscar_producto_favorito($this->session->userdata('usr_id'), $prod_id);
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

	public function marcar_producto_favorito_ajax($prod_id = FALSE, $puntaje = 0)
	{
		$result = $this->favoritos_model->set_producto_favorito($this->session->userdata('usr_id'), $prod_id, $puntaje);
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

	public function borrar_producto_favorito_ajax($prod_id = FALSE)
	{
		$result = $this->favoritos_model->delete_producto_favorito($this->session->userdata('usr_id'), $prod_id);
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

	public function buscar_resultados_ajax($offset = 0, $limit = 10)
	{
		$aux = "";
		$palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$resultados = $this->resultados_model->get_items($this->session->userdata('idi_code'), $this->session->userdata('usr_id'), $offset, $limit);
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
			$productos = $this->productos_model->get_cant_items($this->session->userdata('usr_id'));
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

		if (!empty($this->session->userdata('search'))){
			$data= $this->highlightWords($data, $this->session->userdata('search'));
		} 
		echo json_encode($data);
	}

	public function buscar_ultimos_ajax($offset = 0, $limit = 10)
	{
		$aux = "";
		$palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		if($offset == 0) //Traigo todos los ADS solo la primera vez
		{
			$data['ads'] = $this->ads_model->get_items_match($this->session->userdata('idi_code'));
		}
		$resultados = $this->resultados_model->get_ultimos($this->session->userdata('idi_code'), $offset, $limit);
		if($resultados)
		{
			$ids = array();
			$ads = array();
			foreach ($resultados as $key => $resultado)
			{
				if($resultado['tp_id'] > 0)
				{
					$ids[] = $resultado['prod_id'];
				}
				else
				{
					$ads[] = $resultado['prod_id'];
				}
			}
			$ids_string = implode(', ',$ids);
			$ads_string = implode(', ',$ads);
			$resultados = $this->resultados_model->get_data_items($this->session->userdata('idi_code'), $ids_string/*, $ads_string*/);

			foreach ($resultados as $key => $resultado)
			{
				//$resultados[$key] = $this->resultados_model->get_data_item($this->session->userdata('idi_code'), $resultado['prod_id']);
				$dias_aux = diferencia_dias($resultados[$key]['usr_ult_acceso'], date('Y-m-d H:i:s'));
				$ult_acceso = "";
				if($dias_aux < 1)
				{
					$ult_acceso = str_replace("00.00", substr($resultados[$key]['usr_ult_acceso'],11,5), $palabras[167]['pal_desc']);
				}
				elseif($dias_aux < 2)
				{
					$ult_acceso = str_replace("00.00", substr($resultados[$key]['usr_ult_acceso'],11,5), $palabras[168]['pal_desc']);
				}
				else
				{
					$ult_acceso = str_replace("21", substr($resultados[$key]['usr_ult_acceso'],8,2), $palabras[169]['pal_desc']);
					$ult_acceso = str_replace("12", substr($resultados[$key]['usr_ult_acceso'],5,2), $ult_acceso);
					$ult_acceso = str_replace("2015", substr($resultados[$key]['usr_ult_acceso'],0,4), $ult_acceso);
				}
				$resultados[$key]['usr_ult_acceso'] = $ult_acceso;
			}
			$data['cant'] = count($resultados);
		}
		else
		{
			$data['cant'] = 0;
		}
		
		$data['result'] = $resultados;
		
		echo json_encode($data);
	}

	public function hay_filtros()
	{
		if($this->session->userdata('filtro_ofertas') == "no" || $this->session->userdata('filtro_demandas') == "no")
		{
			return TRUE;
		}
		if($this->session->userdata('filtro_pais') != "" || $this->session->userdata('filtro_ciudad') != "")
		{
			return TRUE;
		}
		if($this->session->userdata('filtro_arancel') != "")
		{
			return TRUE;
		}
		if($this->session->userdata('filtro_productos') == "no" || $this->session->userdata('filtro_servicios') == "no")
        {
            return TRUE;
        }
        if($this->session->userdata('filtro_favoritos') == "si")
        {
        	return TRUE;
        }
        if($this->session->userdata('search') != "")
        {
        	return TRUE;
        }

		return FALSE;
	}

	public function set_demandas_ajax()
	{
		$this->session->set_userdata('filtro_demandas',"si");
		$this->session->set_userdata('filtro_ofertas',"no");

		$data['error'] = FALSE;

		echo json_encode($data);
	}

	public function set_ofertas_ajax()
	{
		$this->session->set_userdata('filtro_demandas',"no");
		$this->session->set_userdata('filtro_ofertas',"si");

		$data['error'] = FALSE;

		echo json_encode($data);
	}

	public function reset_filtros_ajax()
	{
		$this->session->set_userdata('search', "");
		$this->session->set_userdata('filtro_productos', "si");
		$this->session->set_userdata('filtro_servicios', "si");
		$this->session->set_userdata('filtro_ofertas', "si");
		$this->session->set_userdata('filtro_demandas', "si");
		$this->session->set_userdata('filtro_favoritos', "no");
		$this->session->set_userdata('filtro_arancel', "");
		$this->session->set_userdata('filtro_pais', "");
		$this->session->set_userdata('filtro_ciudad', "");
		$this->session->set_userdata('filtro_orden', "");

		$data['error'] = FALSE;

		echo json_encode($data);
	}
	
	/*robert*/
	//Funcion para resaltar el texto
	function highlightWords($text, $word){
		$isarray=is_array($text);
		$text = ($isarray==true) ? json_encode($text) : $text;
	    $text = preg_replace('#'. preg_quote($word) .'#i', '<span style=\"background-color: #F9F902;\">\0</span>', $text);
		$text = ($isarray==true) ? json_decode($text,true) : $text;
		return $text;
	}
	/*robert*/	

}
