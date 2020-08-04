<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadisticas extends CI_Controller {

	private static $solapa = "estadisticas";

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
		$this->load->model('aranceles_model');
		$this->load->model('favoritos_model');
		$this->load->model('foro_model');
		$this->load->model('palabras_model');
		$this->load->model('comtrade_model');
		$this->load->model('mensajes_model');
		
		$this->load->view('templates/validate_login');
	}

	public function index()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		
		$data['pais'] = $this->paises_model->get_items($this->session->userdata('idi_code'), $this->session->userdata('usr_pais'));
		$data['principales_ofertas'] = $this->comtrade_model->get_principales_pais_crecimiento($this->session->userdata('idi_code'), $data['pais']['ctry_code'], "WLD", 2);
	    $data['principales_demandas'] = $this->comtrade_model->get_principales_pais_crecimiento($this->session->userdata('idi_code'), $data['pais']['ctry_code'], "WLD", 1);

		$this->load->view(self::$solapa.'/index', $data);
	}

	public function index_productos()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		
		$data['principales_demandas'] = $this->productos_model->get_max_x_tipo($this->session->userdata('idi_code'), TP_DEMANDA, 5);
		$data['principales_ofertas'] = $this->productos_model->get_max_x_tipo($this->session->userdata('idi_code'), TP_OFERTA, 5);

		$this->load->view(self::$solapa.'/index_productos', $data);
	}

	public function comtrade($ctry_code_origen = FALSE, $ctry_code_destino = "WLD", $tipo = 1)
	{
		$data['ctry_code_origen'] = $ctry_code_origen;
		$data['ctry_code_destino'] = $ctry_code_destino;
		$data['tipo'] = $tipo;

		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['pais'] = $this->paises_model->get_items($this->session->userdata('idi_code'), $ctry_code_origen);
		if($tipo == 2)
		{
			$data['title'] = mostrar_palabra(145, $data['palabras']);
		}
		else
		{
			$data['title'] = mostrar_palabra(148, $data['palabras']);
		}
		$data['title2'] = $data['pais']['ctry_nombre'];
	    $data['resultados'] = $this->comtrade_model->get_pais_crecimiento($this->session->userdata('idi_code'), $data['pais']['ctry_code'], $ctry_code_destino, $tipo, 0, 1);

		$this->load->view(self::$solapa.'/comtrade', $data);
	}

	public function productos($tipo = 1)
	{
		$data['tipo'] = $tipo;

		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		
		if($tipo == TP_DEMANDA)
		{
			$data['title2'] = mostrar_palabra(20, $data['palabras']);
		}
		else
		{
			$data['title2'] = mostrar_palabra(19, $data['palabras']);
		}
		$data['title'] = mostrar_palabra(240, $data['palabras']);
	    $data['resultados'] = $this->productos_model->get_max_x_tipo($this->session->userdata('idi_code'), $tipo);

		$this->load->view(self::$solapa.'/productos', $data);
	}

	public function buscar_generales_ajax($ctry_code_origen = FALSE, $ctry_code_destino = "WLD", $tipo = 1, $offset = 0, $limit = 10)
	{
	    $data['result'] = $this->comtrade_model->get_pais_crecimiento($this->session->userdata('idi_code'), $ctry_code_origen, $ctry_code_destino, $tipo, $offset, $limit);
	    foreach ($data['result'] as $key => $resultado)
	    {
	        $valor = redondear_millones($resultado['comc_valor_fin']);
	        $data['result'][$key]['comc_valor_fin'] = number_format($valor);
	        $data['result'][$key]['comc_porcentaje'] = number_format(($resultado['comc_porcentaje']),0);
	    }
	    $data['cant'] = count($data['result']);

		echo json_encode($data);
	}

	public function producto_ajax()
	{
		$rg = $this->input->post('rg');
		$lang = $this->session->userdata('idi_code');
		$usr_id = $this->session->userdata('usr_id');
		$ctry_code_origen = $this->input->post('ctry_code_origen');
		$ara = $this->input->post('ara');
		$cat = $this->input->post('cat');
		$prod_id = $this->input->post('prod_id');

		$palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		/*
		$rg = 2;
		$ctry_code_origen = "CHN";
		$prod_id = 67301;
		$ara = 220421;
		$cat = 22;
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

			        if($this->buscar_comtrade($ctry_code_origen, $ctry_code_destino, $rg2, $ara, $cat))
			        {
			        	$max = $this->comtrade_model->get_item_max($lang, $ara, $ctry_code_origen, $ctry_code_destino, $rg2);
			        }

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

}
