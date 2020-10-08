<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	private static $solapa = "pages";

	public function __construct()
	{
		parent::__construct();

		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->model('usuarios_model');
		$this->load->model('accesos_model');
		$this->load->model('productos_model');
		$this->load->model('resultados_model');
		$this->load->view('templates/validate_login');
	}

	public function index()
	{
		$data['solapa'] = self::$solapa;

		$fecha = date('Y-m-j');
		$nuevafecha = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-j' , $nuevafecha );

		$data['cant_usuarios_activos'] = $this->usuarios_model->get_cantidad(1);
		$data['cant_usuarios'] = $this->usuarios_model->get_cantidad();

		$data['ultimos_accesos'] = $this->accesos_model->get_items_x_fecha($nuevafecha);

		$data['cant_productos'] = $this->productos_model->get_cantidad_productos_x_tipo();
		$data['cant_productos_oferta'] = $this->productos_model->get_cantidad_productos_x_tipo(TP_OFERTA);
		$data['cant_productos_demanda'] = $this->productos_model->get_cantidad_productos_x_tipo(TP_DEMANDA);
		$data['cant_servicios'] = $this->productos_model->get_cantidad_servicios_x_tipo();
		$data['cant_servicios_oferta'] = $this->productos_model->get_cantidad_servicios_x_tipo(TP_OFERTA);
		$data['cant_servicios_demanda'] = $this->productos_model->get_cantidad_servicios_x_tipo(TP_DEMANDA);

		$data['cant_matchs'] = $this->resultados_model->get_cant_items();
		$data['cant_matchs_reales'] = $this->resultados_model->get_cant_items_reales();
		$data['cant_usuarios_match'] = $this->resultados_model->get_cant_usuarios();
		$data['cant_usuarios_match_reales'] = $this->resultados_model->get_cant_usuarios_reales();

		$data['posiciones_match'] = $this->resultados_model->get_aranceles_cant_items();
		$data['paises_match'] = $this->resultados_model->get_paises_cant_items();

		$this->load->view(self::$solapa.'/index', $data);
	}

	public function grafico_usuarios_ajax()
	{
		$data['error'] = false;
		$fecha = date('Y-m-01');
		$fecha = strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
		$fecha = date ( 'Y-m-j' , $fecha );

		for($i=0; $i<12; $i++)
		{
			$nuevafecha_fin = strtotime ( '-'.($i-1).' month' , strtotime ( $fecha ) ) ;
			$nuevafecha_fin = date ( 'Y-m-j' , $nuevafecha_fin );

			$nuevafecha_ini = strtotime ( '-'.($i).' month' , strtotime ( $fecha ) ) ;
			$nuevafecha_ini = date ( 'Y-m-j' , $nuevafecha_ini );

			$usuarios = $this->usuarios_model->get_items_x_fecha($nuevafecha_ini, $nuevafecha_fin, 1);
			$productos = $this->productos_model->get_item_x_fecha($nuevafecha_ini, $nuevafecha_fin);

			$aux['period'] = $nuevafecha_ini;
			$aux['usuarios'] = count($usuarios);
			$aux['productos'] = $productos['cant'];
			//$aux['gastos'] = 0;
			$array[] = $aux;
		}
		
		$data['data'] = $array;
		echo json_encode($data);
	}
	
}
