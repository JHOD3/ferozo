<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	private static $solapa = "pages";

	public function __construct()
	{
		parent::__construct();

		if($this->session->userdata('idi_code') == "")
		{
			if(getUserLanguage() == "")
			{
				$this->session->set_userdata('idi_code',"en");
			}
			else
			{
				$this->session->set_userdata('idi_code',getUserLanguage());
			}
		}

		$this->config->set_item('language', $this->session->userdata('idi_code'));
		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->model('idiomas_model');
		$this->load->model('paises_model');
		$this->load->model('comtrade_model');
		$this->load->model('palabras_model');
		$this->load->model('user_model');
		$this->load->model('mails_model');
		$this->load->model('productos_model');
		$this->load->model('unsubscribe_model');
		$this->load->model('ads_model');
		$this->load->model('resultados_model');
		$this->load->model('mensajes_model');
		/*
		if($this->session->userdata('usr_id') != "")
		{
		    redirect('resultados', 'refresh');
		    exit();
		}
		*/
		//$this->detect_mobile();
	}

	public function idioma($lang = "en")
	{
		$this->session->set_userdata('idi_code',$lang);
		redirect(self::$solapa);
	}

	public function index()
	{
		$data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));
		$data['idiomas_completos'] = $this->idiomas_model->get_items_completos();
		$data['paises'] = $this->paises_model->get_items($this->session->userdata('idi_code'));
		//$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$pal_ids = array(118, 52, 53, 54, 55, 107, 50, 51, 93, 119, 482, 493, 339, 56, 24, 23, 274, 243, 19, 20, 21, 22);
		$data['palabras'] = $this->palabras_model->get_items_especificos($this->session->userdata('idi_code'), $pal_ids);

		$data['description'] = mostrar_palabra(118, $data['palabras']);
		$data['keywords'] = mostrar_palabra(52, $data['palabras']).",".mostrar_palabra(53, $data['palabras']).",".mostrar_palabra(54, $data['palabras']).",".mostrar_palabra(55, $data['palabras']).",".mostrar_palabra(107, $data['palabras']).",".mostrar_palabra(50, $data['palabras']).",".mostrar_palabra(51, $data['palabras']).",".mostrar_palabra(93, $data['palabras']);
		$data['error'] = "";

		//echo $data['keywords'];
		
		$this->load->view(self::$solapa.'/index', $data);
	}

	public function nosotros()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['title'] = mostrar_palabra(103, $data['palabras']);
		$data['description'] = mostrar_palabra(118, $data['palabras']);
		$data['keywords'] = mostrar_palabra(52, $data['palabras']).",".mostrar_palabra(53, $data['palabras']).",".mostrar_palabra(54, $data['palabras']).",".mostrar_palabra(55, $data['palabras']).",".mostrar_palabra(107, $data['palabras']).",".mostrar_palabra(50, $data['palabras']).",".mostrar_palabra(51, $data['palabras']).",".mostrar_palabra(93, $data['palabras']);
		
		$this->load->view(self::$solapa.'/nosotros', $data);
	}

	public function sitemap()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		
		$this->load->view(self::$solapa.'/sitemap', $data);
	}

	public function mundo()
	{
		$data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));
		$data['paises'] = $this->paises_model->get_items($this->session->userdata('idi_code'));
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['title'] = mostrar_palabra(112, $data['palabras']);
		$data['description'] = mostrar_palabra(118, $data['palabras']);
		$data['keywords'] = mostrar_palabra(52, $data['palabras']).",".mostrar_palabra(53, $data['palabras']).",".mostrar_palabra(54, $data['palabras']).",".mostrar_palabra(55, $data['palabras']).",".mostrar_palabra(107, $data['palabras']).",".mostrar_palabra(50, $data['palabras']).",".mostrar_palabra(51, $data['palabras']).",".mostrar_palabra(93, $data['palabras']);
		
		$data['cant_usuarios'] = $this->user_model->get_cantidad();
		$data['cant_ofertas'] = $this->productos_model->get_cant_items(FALSE, TP_OFERTA);
		$data['cant_demandas'] = $this->productos_model->get_cant_items(FALSE, TP_DEMANDA);
		
		
		$this->load->view(self::$solapa.'/mundo', $data);
	}

	public function mundo_ajax()
	{
		$data['error'] = FALSE;

		$this->load->model('accesos_model');
		$this->load->model('productos_model');
		
		$data['accesos'] = $this->accesos_model->get_items_mapa();
		$data['productos'] = $this->productos_model->get_items_mapa();
		
		echo json_encode($data);
	}

	public function privacidad()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['title'] = mostrar_palabra(117, $data['palabras']);
		$data['description'] = mostrar_palabra(118, $data['palabras']);
		$data['keywords'] = mostrar_palabra(52, $data['palabras']).",".mostrar_palabra(53, $data['palabras']).",".mostrar_palabra(54, $data['palabras']).",".mostrar_palabra(55, $data['palabras']).",".mostrar_palabra(107, $data['palabras']).",".mostrar_palabra(50, $data['palabras']).",".mostrar_palabra(51, $data['palabras']).",".mostrar_palabra(93, $data['palabras']);
		
		$tipo = 2;
		$this->load->model('politicas_model');
		$data['politicas'] = $this->politicas_model->get_items($this->session->userdata('idi_code'), $tipo);
		if(!$data['politicas'])
		{
			$data['politicas'] = $this->politicas_model->get_items('en', $tipo);
		}

		$this->load->view(self::$solapa.'/servicio', $data);
	}

	public function servicio()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['title'] = mostrar_palabra(116, $data['palabras']);
		$data['description'] = mostrar_palabra(118, $data['palabras']);
		$data['keywords'] = mostrar_palabra(52, $data['palabras']).",".mostrar_palabra(53, $data['palabras']).",".mostrar_palabra(54, $data['palabras']).",".mostrar_palabra(55, $data['palabras']).",".mostrar_palabra(107, $data['palabras']).",".mostrar_palabra(50, $data['palabras']).",".mostrar_palabra(51, $data['palabras']).",".mostrar_palabra(93, $data['palabras']);
		
		$tipo = 1;
		$this->load->model('politicas_model');
		$data['politicas'] = $this->politicas_model->get_items($this->session->userdata('idi_code'), $tipo);
		if(!$data['politicas'])
		{
			$data['politicas'] = $this->politicas_model->get_items('en', $tipo);
		}
		
		$this->load->view(self::$solapa.'/servicio', $data);
	}

	public function contacto()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['title'] = mostrar_palabra(38, $data['palabras']);
		$data['description'] = mostrar_palabra(118, $data['palabras']);
		$data['keywords'] = mostrar_palabra(52, $data['palabras']).",".mostrar_palabra(53, $data['palabras']).",".mostrar_palabra(54, $data['palabras']).",".mostrar_palabra(55, $data['palabras']).",".mostrar_palabra(107, $data['palabras']).",".mostrar_palabra(50, $data['palabras']).",".mostrar_palabra(51, $data['palabras']).",".mostrar_palabra(93, $data['palabras']);
		
		$this->load->view(self::$solapa.'/contacto', $data);
	}

	public function unsubscribe($mail_id, $mail_codigo)
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['title'] = mostrar_palabra(38, $data['palabras']);
		$data['description'] = mostrar_palabra(118, $data['palabras']);
		$data['keywords'] = mostrar_palabra(52, $data['palabras']).",".mostrar_palabra(53, $data['palabras']).",".mostrar_palabra(54, $data['palabras']).",".mostrar_palabra(55, $data['palabras']).",".mostrar_palabra(107, $data['palabras']).",".mostrar_palabra(50, $data['palabras']).",".mostrar_palabra(51, $data['palabras']).",".mostrar_palabra(93, $data['palabras']);
		
		$mail = $this->mails_model->get_item_id_codigo($mail_id, $mail_codigo);
		if($mail)
		{
			$result = $this->unsubscribe_model->set_item($mail_id);
			if($result)
			{
				$data['mensaje'] = "You are no longer receiving this email.";
			}
			else
			{
				$data['mensaje'] = "We can not unsuscribe this email.<br>Please try again later.";
			}
		}
		else
		{
			$data['mensaje'] = "This mail no longer exist.";
		}

		$this->load->view(self::$solapa.'/mensaje', $data);
	}

	public function publicidad($mail_id)
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['title'] = mostrar_palabra(38, $data['palabras']);
		$data['description'] = mostrar_palabra(118, $data['palabras']);
		$data['keywords'] = mostrar_palabra(52, $data['palabras']).",".mostrar_palabra(53, $data['palabras']).",".mostrar_palabra(54, $data['palabras']).",".mostrar_palabra(55, $data['palabras']).",".mostrar_palabra(107, $data['palabras']).",".mostrar_palabra(50, $data['palabras']).",".mostrar_palabra(51, $data['palabras']).",".mostrar_palabra(93, $data['palabras']);
		
		$mail = $this->mails_model->get_item($mail_id);
		if($mail)
		{
			$this->load->helper('mails');

            //$result = mail_publicidad($mail['mail_direccion'], $mail['mail_id'], $mail['mail_codigo'], "es");
            $result = mail_publicidad_sendgrid($mail['mail_direccion'], $mail['mail_id'], $mail['mail_codigo'], "es");

			if($result)
			{
				$data['mensaje'] = "Mail sent.";
			}
			else
			{
				$data['mensaje'] = "We can not send this mail.";
			}
		}
		else
		{
			$data['mensaje'] = "This mail no longer exist.";
		}

		echo $data['mensaje'];
	}

	public function detect_mobile()
	{
		$this->load->library('user_agent');

		if($this->agent->is_mobile())
		{
		    redirect('http://www.nocnode.com/Mobile', 'refresh');
		}
	}

	public function error_404()
	{
		$data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));
		$data['idiomas_completos'] = $this->idiomas_model->get_items_completos();
		$data['paises'] = $this->paises_model->get_items($this->session->userdata('idi_code'));
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$data['description'] = mostrar_palabra(118, $data['palabras']);
		$data['keywords'] = mostrar_palabra(52, $data['palabras']).",".mostrar_palabra(53, $data['palabras']).",".mostrar_palabra(54, $data['palabras']).",".mostrar_palabra(55, $data['palabras']).",".mostrar_palabra(107, $data['palabras']).",".mostrar_palabra(50, $data['palabras']).",".mostrar_palabra(51, $data['palabras']).",".mostrar_palabra(93, $data['palabras']);
		$data['error'] = "";

		//echo $data['keywords'];
		
		$this->load->view(self::$solapa.'/error_404', $data);
	}

	public function buscar_ultimos_ajax($offset = 0, $limit = 10)
	{
		$aux = "";
		$palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		if($offset == 0) //Traigo todos los ADS solo la primera vez
		{
			if($this->session->userdata('usr_pais') != "")
			{
				$data['ads'] = $this->ads_model->get_items_x_pais($this->session->userdata('idi_code'), $this->session->userdata('usr_pais'));
			}
		}
		
		$resultados = $this->resultados_model->get_ultimos_diferentes_usuarios($this->session->userdata('idi_code'), $offset, $limit);

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
					$ult_acceso = str_replace("00.00", substr($resultados[$key]['usr_ult_acceso'],11,5), mostrar_palabra(167, $palabras));
				}
				elseif($dias_aux < 2)
				{
					$ult_acceso = str_replace("00.00", substr($resultados[$key]['usr_ult_acceso'],11,5), mostrar_palabra(168, $palabras));
				}
				else
				{
					$ult_acceso = str_replace("21", substr($resultados[$key]['usr_ult_acceso'],8,2), mostrar_palabra(169, $palabras));
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

	public function robar_uncomtrade()
	{
		//CRON_JOB
		//wget --no-check-certificate -O /dev/null https://www.nocnode.com/pages/procesa_excel >/dev/null 2>&1
		for($i=0;$i<6276;$i++)
		{
			$this->load->model('aranceles_model');
			$this->load->model('comtrade_model');

			//set_time_limit(0);
			$termino = false;
			$anio = 2010;
			$destino = 0; //world
			$last_comtrade = $this->comtrade_model->get_last($anio);

			if(!$last_comtrade)
			{
				$next_pais = $this->paises_model->get_next();
				$next_arancel = $this->aranceles_model->get_next();

				$origen = $next_pais['ctry_code3'];
				$rg = 1; //primero import
				$ara = $next_arancel['ara_id'];
			}
			else
			{
				if($last_comtrade['com_tipo'] == 1)
				{
					$origen = $last_comtrade['com_origen'];
					$rg = 2; //export
					$ara = $last_comtrade['com_arancel'];
				}
				else//($last_comtrade['com_tipo'] == 2)
				{
					$next_arancel = $this->aranceles_model->get_next($last_comtrade['com_arancel']);

					$rg = 1; //import

					if($next_arancel)
					{
						$origen = $last_comtrade['com_origen'];
						$ara = $next_arancel['ara_id'];
					}
					else
					{
						$next_pais = $this->paises_model->get_next($last_comtrade['com_origen']);
						if(!$next_pais)
						{
							$termino = true;
						}
						$origen = $next_pais['ctry_code3'];
						$next_arancel = $this->aranceles_model->get_next();
						$ara = $next_arancel['ara_id'];
					}
				}
			}

			if(!$termino)
			{
				echo $ara;
				$json = file_get_contents("http://comtrade.un.org/api/get?type=C&freq=A&px=HS&ps=".$anio."&r=".$origen."&p=".$destino."&rg=".$rg."&cc=".$ara."&fmt=json");
		        $data = json_decode($json);

		        if(count($data->dataset)>0)
		        {
		        	$result = $this->comtrade_model->set_item($anio, $origen, $destino, $rg, $ara, $data->dataset[0]->TradeQuantity, $data->dataset[0]->TradeValue);
		        	if($result)
		        	{
		        		echo " - Value: ".$data->dataset[0]->TradeValue." - qty: ".$data->dataset[0]->TradeQuantity."<br>";
		        	}
		        	else
		        	{
		        		echo " - Error al insertar con datos<br>";
		        	}
		        }
		        else
		        {
		        	$result = $this->comtrade_model->set_item($anio, $origen, $destino, $rg, $ara);
		        	if($result)
		        	{
		        		echo " - No hay nada<br>";
		        	}
		        	else
		        	{
		        		echo " - Error al insertar vacio<br>";
		        	}
		        }
	    	}
	    	else
	    	{
	    		echo "termino<br>";
	    	}
    	}
	}

	public function acceso($extra = "")
	{
		if($this->session->userdata('inicio') == "")
		{
			$this->session->set_userdata('inicio', time());
			//echo time();
		}
		$this->load->model('accesos_model');
		$this->load->library('user_agent');

		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	    {
	      $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
	      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else
	    {
	      $ip=$_SERVER['REMOTE_ADDR'];
	    }

	    if($this->session->userdata('geoplugin') != "")
	    {
	    	$geo = $this->session->userdata('geoplugin');
	    }
	    else
	    {
			$geoplugin = file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);
			$geo = json_decode($geoplugin);
			$this->session->set_userdata('geoplugin', $geo);

			if($geo->geoplugin_countryCode != "" && $this->session->userdata('usr_pais') == "")
			{
				$pais = $this->paises_model->get_item_code2($this->session->userdata('idi_code'), $geo->geoplugin_countryCode);
				if($pais)
				{
					$this->session->set_userdata('usr_pais', $pais['ctry_code']);
					echo $this->session->userdata('usr_pais');
				}
			}
		}

		/*
		echo date('Y-m-d H:i:s');
		echo "<br>";
		echo $this->agent->platform();
		echo "<br>";
		echo $this->agent->browser();
		echo "<br>";
		echo $this->agent->mobile();
		echo "<br>";
		echo $this->agent->robot();
		echo "<br>";
		echo $this->agent->referrer();
		echo "<br>";

		echo $ip;
		echo "<br>";
		echo $geo->geoplugin_countryName;
		echo "<br>";
		echo $geo->geoplugin_countryCode;
		echo "<br>";
		echo $geo->geoplugin_city;
		echo "<br>";
		echo $geo->geoplugin_region;
		echo "<br>";
		echo $geo->geoplugin_latitude;
		echo "<br>";
		echo $geo->geoplugin_longitude;
		*/
		$this->accesos_model->set_item(
				$this->agent->platform(),
				$this->agent->browser(),
				$this->agent->mobile(),
				$this->agent->robot(),
				$this->agent->referrer(),
				$ip,
				$geo->geoplugin_countryName,
				$geo->geoplugin_city,
				$geo->geoplugin_region,
				$geo->geoplugin_latitude,
				$geo->geoplugin_longitude,
				$this->session->userdata('inicio'),
				$extra,
				$this->session->userdata('usr_id')
			);
		/*
		if($geo->geoplugin_countryCode != "")
		{
			$pais = $this->paises_model->get_item_code2($this->session->userdata('idi_code'), $geo->geoplugin_countryCode);
			if($pais)
			{
				$this->session->set_userdata('ctry_code', $pais['ctry_code']);
			}
		}
		*/
		$data['error'] = FALSE;

		echo json_encode($data);
	}

	public function get_pais()
	{
		if($this->session->userdata('inicio') == "")
		{
			$this->session->set_userdata('inicio', time());
			//echo time();
		}
		$this->load->model('accesos_model');
		$this->load->library('user_agent');

		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	    {
	      $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
	      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else
	    {
	      $ip=$_SERVER['REMOTE_ADDR'];
	    }

		if($this->session->userdata('geoplugin') != "")
	    {
	    	$geo = $this->session->userdata('geoplugin');
	    }
	    else
	    {
			$geoplugin = file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);
			$geo = json_decode($geoplugin);
			$this->session->set_userdata('geoplugin', $geo);
		}


		if($geo->geoplugin_countryCode != "" && $this->session->userdata('usr_pais') == "")
		{
			$pais = $this->paises_model->get_item_code2($this->session->userdata('idi_code'), $geo->geoplugin_countryCode);
			if($pais)
			{
				$this->session->set_userdata('usr_pais', $pais['ctry_code']);
				echo $this->session->userdata('usr_pais');
			}
		}
	}

}
