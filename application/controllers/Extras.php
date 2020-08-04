<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Extras extends CI_Controller {

	private static $solapa = "extras";

	public function __construct()
	{
		parent::__construct();

		if($this->session->userdata('idi_code') == "")
		{
			$this->session->set_userdata('idi_code',"en");
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
		$this->load->model('favoritos_model');
		$this->load->model('aranceles_model');
		/*
		if($this->session->userdata('usr_id') != "")
		{
		    redirect('resultados', 'refresh');
		    exit();
		}
		*/
		//$this->detect_mobile();
	}

	public function robar_tailandia()
	{
		$xmlDoc = new DOMDocument();
		$archivos = array('19000c.xml');
		foreach ($archivos as $archivo)
		{
			$xmlDoc->load("assets/".$archivo);

			$x = $xmlDoc->documentElement;
			$items = $x->getElementsByTagName('company');
			
			foreach ($items as $item)
			{
				$id = $item->getAttribute('id');
				$companys = $item->getElementsByTagName('company_name');
				$company = $companys->item(0)->nodeValue;
				$addresses = $item->getElementsByTagName('address');
				$address = $addresses->item(0)->nodeValue;
				$telephones = $item->getElementsByTagName('telephone');
				$telephone = $telephones->item(0)->nodeValue;
				$faxs = $item->getElementsByTagName('fax');
				$fax = $faxs->item(0)->nodeValue;
				$emails = $item->getElementsByTagName('email');
				$email = $emails->item(0)->nodeValue;
				$websites = $item->getElementsByTagName('website');
				$website = $websites->item(0)->nodeValue;
				$establishs = $item->getElementsByTagName('establish');
				$establish = $establishs->item(0)->nodeValue;
				$contacts = $item->getElementsByTagName('contact');
				$contact = $contacts->item(0)->nodeValue;
				$capitals = $item->getElementsByTagName('capital');
				$capital = $capitals->item(0)->nodeValue;
				$products = $item->getElementsByTagName('product');
				$product = $products->item(0)->nodeValue;
				$services = $item->getElementsByTagName('service_product');
				$service = $services->item(0)->nodeValue;


	            $query = $this->db->query("SELECT *
	                                        FROM mails_tailandia
	                                        WHERE id=".$id."
	                                        OR email='".$email."'");

		        $result = $query->row_array();

		        if(!$result)
		        {
					$data = array(
						'id' => $id, 
						'company_name' => $company, 
						'address' => $address, 
						'telephone' => $telephone, 
						'fax' => $fax, 
						'email' => $email, 
						'website' => $website, 
						'establish' => $establish, 
						'contact' => $contact, 
						'capital' => $capital, 
						'product' => $product, 
						'service_product' => $service
					);

					if($this->db->insert('mails_tailandia', $data))
					{
						echo $id . " OK<br>";
					}
					else
					{
						echo $id . " Error<br>";
					}
				}
				else
				{
					echo $id . " Ya existe<br>";
				}
			}
		}
	}

	public function arreglar_tailandia()
	{
		$query = $this->db->query("SELECT *
                                    FROM mails_tailandia");

        $items = $query->result_array();

		foreach ($items as $item)
		{
			$mails = explode(',', $item['email']);
			if(count($mails) > 0)
			{
				if(count($mails) > 1)
				{
					for($i=1; $i<count($mails); $i++)
					{
						$nuevo_id = $item['id']+$i;
						$data = array(
							'id' => NULL, 
							'company_name' => $item['company_name'], 
							'address' => $item['address'], 
							'telephone' => $item['telephone'], 
							'fax' => $item['fax'], 
							'email' => $mails[$i], 
							'website' => $item['website'], 
							'establish' => $item['establish'], 
							'contact' => $item['contact'], 
							'capital' => $item['capital'], 
							'product' => $item['product'], 
							'service_product' => $item['service_product']
						);

						$query = $this->db->query("SELECT *
			                                        FROM mails_tailandia
			                                        WHERE email='".$email."'");

				        $result = $query->row_array();
				        if(!$result)
				        {
							if($this->db->insert('mails_tailandia', $data))
							{
								echo $nuevo_id . " OK<br>";
							}
							else
							{
								echo $nuevo_id . " Error<br>";
							}
						}
					}

					$data2 = array( 'email' => $mails[0] );
					$this->db->where(array('id'=>$item['id']));
        			if($this->db->update('mails_tailandia', $data2))
        			{
        				echo $item['id'] . " Update<br>";
        			}
        			else
        			{
        				echo $item['id'] . " Error Update<br>";
        			}
				}/*
				else
				{
					$query2 = $this->db->query("SELECT *
			                                    FROM mails_tailandia
			                                    WHERE email = '".$item['email']."'
			                                    AND id <> ".$item['id']);
			        $items2 = $query2->result_array();
			        foreach ($items2 as $item2)
			        {
			        	$this->db->where(array('id'=>$item2['id']));
		        		$this->db->delete('mails_tailandia');
		        		echo $item2['id'] . " Eliminado duplicado<br>";
			        }
				}*/
			}
			else
			{
				$this->db->where(array('id'=>$item['id']));
        		$this->db->delete('mails_tailandia');
        		echo $item['id'] . " Eliminado<br>";
			}
		}
		
	}

	public function procesa_excel()
    {
        $usr_id = FALSE;

        $this->load->helper('mails');

        $error = "";
        //$myfile = fopen("result_productos.txt", "w");
        //fwrite($myfile, "Inicio\n");

        $this->load->model('user_model');
		$this->load->model('mails_model');
		$this->load->model('productos_model');
        $this->load->model('excel_model');
        
        $items = $this->excel_model->get_items_estado();
        //$items = $this->excel_model->get_items_arancel(220421);
        foreach ($items as $key => $item)
        {
            //Busco el pais
            $paisAux = $this->paises_model->buscar_items("es", trim($item['exc_pais']));
            if($paisAux)
            {
            	if($paisAux['ctry_code'] == "UMI")
            	{
            		$paisAux['ctry_code'] = "USA";
            	}

                if($paisAux['idi_code'])
                {
                    //Busco si el mail existe
                    $userAux = $this->user_model->get_items_byMail(strtolower($item['exc_mail']));
                    
                    //Si no existe el usuario lo creo
                    if($userAux == FALSE)
                    {
                        if($item['exc_mail'] && $paisAux['idi_code'])
                        {
                        	if(is_valid_email($item['exc_mail']))
                        	{
                        		$usr_id = $this->user_model->set_item(strtolower($item['exc_mail']), "", $paisAux['idi_code'], $paisAux['ctry_code'], 0, "perfil.jpg");
                            	//echo "Nuevo usuario creado ".$item['exc_mail']." - ".$usr_id."<br>";
                        	}
                            else
                            {
                            	echo "El email es invalido ".$item['exc_mail']."<br>";
                            	$error .= "El email es invalido ".$item['exc_mail']."<br>";
                            }
                        }
                        else
                        {
                            echo "Faltan datos para crear el usuario ".$item['exc_mail']."<br>";
                            $error .= "Faltan datos para crear el usuario ".$item['exc_mail']."<br>";
                            //fwrite($myfile, "Faltan datos para crear el usuario ".$item['exc_mail']."\n");
                        }
                    }
                    else
                    {
                        $usr_id = $userAux['usr_id'];
                    }

                    //Busco la ciudad
                    $ciudadAux = $this->paises_model->buscar_provincia_ciudad("es", $paisAux['ctry_code'], trim($item['exc_ciudad']));
                    if(!$ciudadAux)
                    {
                        $ciudadAux = $this->paises_model->buscar_alguna_provincia("es", $paisAux['ctry_code']);
                    }

                    if($ciudadAux)
                    {
	                    if($usr_id)
	                    {
	                        // VALIDAR MAIL
	                        $mail = $this->mails_model->existe_mail_usuario(strtolower($item['exc_mail']), $usr_id);
	                        if($mail == FALSE)
	                        {
	                            $codigo = RandomString(4);
	                            $mail_id = $this->mails_model->set_item($usr_id, strtolower($item['exc_mail']), $codigo, 0);

	                            //echo strtolower($item['exc_mail'])." - ".$mail_id." - ".$codigo." - ".$paisAux['idi_code']."<br>";
	                            $result = mail_publicidad_sendgrid(strtolower($item['exc_mail']), $mail_id, $codigo, $paisAux['idi_code']);
						        if($result)
						        {
						        	$data = array(
							    		'mail_id' => $mail_id,
							    		'fecha' => date('Y-m-d H:i'),
							    		'estado' => 1
							    	);

							    	$this->db->insert('mails_ultimo_spam', $data);

						        	echo "Mail de publi enviado - ".strtolower($item['exc_mail'])."<br>";
						        }
						        else
						        {
						        	$data = array(
							    		'mail_id' => $mail_id,
							    		'fecha' => date('Y-m-d H:i'),
							    		'estado' => 2
							    	);

							    	$this->db->insert('mails_ultimo_spam', $data);

						        	//echo "Error<br>".$this->email->print_debugger();
						        	echo "Mail de publi error - ".strtolower($item['exc_mail'])."<br>";
                					$error .= "Mail de publi error - ".strtolower($item['exc_mail'])."<br>";
						        }
	                        }
	                        else
	                        {
	                            $mail_id = $mail['mail_id'];
	                        }

	                        // Creo el producto
	                        $prod_id = $this->productos_model->set_item($item['tp_id'], $usr_id, 0, 0, $item['ara_id'], trim($item['exc_descripcion']), $paisAux['ctry_code'], $ciudadAux['city_id'], 1);
	                        if($prod_id)
	                        {
	                            $this->productos_model->set_item_mail($prod_id, $mail_id);

	                            $this->productos_model->set_item_idioma($prod_id, $paisAux['idi_code']);

	                            $this->excel_model->update_estado($item['exc_id'], 1);

	                            echo "El producto se ha creado con exito.<br>";
	                            //fwrite($myfile, "El producto se ha creado con exito.\n");
	                        }
	                        else
	                        {
	                            echo "Se produjo un error al crear el producto.<br>";
	                            $error .= "Se produjo un error al crear el producto.<br>";
	                            //fwrite($myfile, "Se produjo un error al crear el producto.\n");
	                        }
	                    }
	                    else
	                    {
	                        echo "No tengo usuario<br>";
	                        $error .= "No tengo usuario<br>";
	                        //fwrite($myfile, "No tengo usuario\n");
	                    }
                	}
                	else
                    {
                    	echo "El pais ".$item['exc_pais']." no tiene ciudad<br>";
                    	$error .= "El pais ".$item['exc_pais']." no tiene ciudad<br>";
                        //fwrite($myfile, "El pais ".$item['exc_pais']." no tiene ciudad<br>\n");
                    }
                }
                else
                {
                    echo "El pais ".$item['exc_pais']." no tiene idioma<br>";
                    $error .= "El pais ".$item['exc_pais']." no tiene idioma<br>";
                    //fwrite($myfile, "El pais ".$item['exc_pais']." no tiene idioma\n");
                }
            }
            else
            {
                echo "No encontro el pais ".$item['exc_pais']."<br>";
                $error .= "No encontro el pais ".$item['exc_pais']."<br>";
                //fwrite($myfile, "No encontro el pais ".$item['exc_pais']."\n");
            }
        }

        //fclose($myfile);

        if($error != "")
        {
	        $this->load->helper("mails");
	        mail_base("contact@Sistema.com", "Error carga de productos", "Error carga de productos", $error);
	    }
    }

    public function procesa_excel_errores()
    {
    	$usr_id = FALSE;

        $this->load->helper('mails');

        $error = "";

        $this->load->model('user_model');
		$this->load->model('mails_model');
		$this->load->model('productos_model');
        $this->load->model('excel_model');
        
        $query = $this->db->query("SELECT *
                                    FROM mails_ultimo_spam AS E
                                    INNER JOIN Mails AS M ON E.mail_id = M.mail_id
                                    INNER JOIN Usuarios AS U ON U.usr_id = M.usr_id
                                    WHERE E.estado = 2
                                    LIMIT 50");
        $items = $query->result_array();

        foreach ($items as $key => $item)
        {
            $result = mail_publicidad(strtolower($item['mail_direccion']), $item['mail_id'], $item['mail_codigo'], $item['idi_code']);
	        if($result)
	        {
	        	$data = array(
		    		'estado' => 1
		    	);

		    	$this->db->where(array('mail_id'=>$item['mail_id']));
        		$this->db->update('mails_ultimo_spam', $data);

	        	echo "Mail de publi enviado - ".strtolower($item['mail_direccion'])."<br>";
	        }
	        else
	        {
	        	echo "Mail de publi error - ".strtolower($item['mail_direccion'])."<br>";
	        }
        }

        echo "FIN";
    }

    /*
    //PAISES SIN CIUDAD
    SELECT *
	FROM `Country` 
	WHERE ctry_code NOT IN (SELECT `city_countryCode` FROM City)
	*/

    public function robar_paises()
	{
		
		//$idiomas = $this->idiomas_model->get_items();
		//foreach ($idiomas as $key => $idioma)
		//{
			$idioma['idi_code'] = "ko";
			$consulta = file_get_contents("http://api.geonames.org/countryInfo?username=mayo&lang=".$idioma['idi_code']."&type=JSON");
			$consulta_array = json_decode($consulta);

			foreach ($consulta_array->geonames as $key => $value)
			{
				$data = array(
		            'ctry_nombre_'.$idioma['idi_code'] => $value->countryName
		        );
				
				$this->db->where(array('ctry_code'=>$value->isoAlpha3));
				$this->db->update('paises', $data);
	    	}
		//}
		
		/*
		$consulta = file_get_contents("http://api.geonames.org/countryInfo?username=mayo&lang=es&type=JSON");
		$consulta_array = json_decode($consulta);
		foreach ($consulta_array->geonames as $key => $value)
		{
			$idioma_code = "en";
			$idiomas_array = explode(',', $value->languages);
			if($idiomas_array && count($idiomas_array)>0)
			{
				foreach ($idiomas_array as $idioma_value)
				{
					$idiomas_array2 = explode('-', $idiomas_array[0]);
					if($idiomas_array2 && count($idiomas_array2)>0)
					{
						$idioma = $idiomas_array2[0];
					}
					else
					{
						$idioma = $idiomas_array[0];
					}

					$existe_idioma = $this->idiomas_model->get_items("es", $idioma);
					if($existe_idioma)
					{
						$idioma_code = $idioma;
						break;
					}
				}
			}
			else
			{
				$idioma = $value->languages;
				$existe_idioma = $this->idiomas_model->get_items("es", $idioma);
				if($existe_idioma)
				{
					$idioma_code = $idioma;
				}
			}
			
			$data = array(
	            'ctry_code' => $value->isoAlpha3,
	            'ctry_code2' => $value->countryCode,
	            'ctry_code3' => $value->isoNumeric,
	            'idi_code' => $idioma_code,
	            'ctry_nombre_zh' => "",
	            'ctry_nombre_es' => $value->countryName,
	            'ctry_nombre_en' => "",
	            'ctry_nombre_hi' => "",
	            'ctry_nombre_ar' => "",
	            'ctry_nombre_pt' => "",
	            'ctry_nombre_ru' => "",
	            'ctry_nombre_ja' => "",
	            'ctry_nombre_de' => "",
	            'ctry_nombre_fr' => "",
	            'ctry_nombre_ko' => "",
	            'ctry_nombre_it' => "",
	            'cont_code' => $value->continent,
	            'ctry_capital' => $value->capital,
	            'ctry_area' => $value->areaInSqKm,
	            'ctry_population' => $value->population,
	            'cur_code' => $value->currencyCode,
	            'geonameId' => $value->geonameId,
	            'ctry_west' => $value->west,
	            'ctry_north' => $value->north,
	            'ctry_east' => $value->east,
	            'ctry_south' => $value->south,
	            'ctry_pcformat' => $value->postalCodeFormat,
	            'ctry_idiomas' => $value->languages
	        );

	        $this->db->insert('paises', $data);
		}
		*/
	}

	public function robar_ciudades()
	{
		$insert = FALSE;
		$ciudad = $this->paises_model->get_last_city();
		if($ciudad == FALSE)
		{
			$insert = TRUE;
			//Buscar primer pais
			$pais = $this->paises_model->get_first_country();
			//Buscar primer idioma
			$idioma = $this->idiomas_model->get_first();
		}
		else
		{
			//Busco el proximo idioma
			$idioma = $this->idiomas_model->get_next($ciudad['idi_code']);
			if($idioma == FALSE)
			{
				$insert = TRUE;
				//Busco el proximo pais
				$pais = $this->paises_model->get_next_country($ciudad['city_countryCode']);
				//Buscar primer idioma
				$idioma = $this->idiomas_model->get_first();
			}
			else
			{
				//Busco el pais actual
				$pais = $this->paises_model->get_items($idioma['idi_code'], $ciudad['city_countryCode']);
			}
		}
		
		if($pais)
		{
			echo "http://api.geonames.org/children?geonameId=".$pais['geonameId']."&username=mayo&lang=".$idioma['idi_code']."&type=JSON<br>";
			$consulta = file_get_contents("http://api.geonames.org/children?geonameId=".$pais['geonameId']."&username=mayo&lang=".$idioma['idi_code']."&type=JSON");
			$consulta_array = json_decode($consulta);
			//print_r($consulta_array->geonames);
			
			if($consulta_array->geonames == null)
			{
				$data = array(
		            'city_id' => NULL,
		            'city_countryCode' => $pais['ctry_code'],
		            'idi_code' => $idioma['idi_code'],
		            'city_nombre' => ""
		        );

		        $this->db->insert('ciudades', $data);

				echo "No tiene ciudades<br>";
			}
			else
			{
				foreach ($consulta_array->geonames as $key => $value)
				{
					$data = array(
			            'city_id' => NULL,
			            'city_countryCode' => $pais['ctry_code'],
			            'idi_code' => $idioma['idi_code'],
			            'city_nombre' => $value->name,
			            'toponymName' => $value->toponymName,
			            'lat' => $value->lat,
			            'lng' => $value->lng,
			            'geonameId' => $value->geonameId,
			            'fcl' => $value->fcl,
			            'fcode' => $value->fcode
			        );

			        $this->db->insert('ciudades', $data);

					if($insert)
					{
						$data = array(
				            'city_id' => NULL,
				            'city_countryCode' => $pais['ctry_code'],
				            'city_nombre_zh' => "",
				            'city_nombre_es' => "",
				            'city_nombre_en' => "",
				            'city_nombre_hi' => "",
				            'city_nombre_ar' => $value->name,
				            'city_nombre_pt' => "",
				            'city_nombre_ru' => "",
				            'city_nombre_ja' => "",
				            'city_nombre_de' => "",
				            'city_nombre_fr' => "",
				            'city_nombre_ko' => "",
				            'city_nombre_it' => "",
				            'toponymName' => $value->toponymName,
				            'lat' => $value->lat,
				            'lng' => $value->lng,
				            'geonameId' => $value->geonameId,
				            'fcl' => $value->fcl,
				            'fcode' => $value->fcode
				        );

				        $this->db->insert('ciudades2', $data);
			    	}
			    	else
			    	{
			    		$data = array(
				            'city_nombre_'.$idioma['idi_code'] => $value->name
				        );

			    		$this->db->where(array('geonameId'=>$value->geonameId));
						$this->db->update('ciudades2', $data);
			    	}
		    	}
	    	}

	    	echo $pais['ctry_code']."<br>";
			echo $idioma['idi_code']."<br>";
		}
		else
		{
			echo "Termino";
		}
	}

	/*
	public function robar_bahrein($idi = "ar")
	{
		$insert = FALSE;
		$pais = $this->paises_model->get_items('es',"IRQ");
		$idioma['idi_code'] = $idi;
		
		if($pais)
		{
			echo "http://api.geonames.org/children?geonameId=".$pais['geonameId']."&username=mayo&lang=".$idioma['idi_code']."&type=JSON<br>";
			$consulta = file_get_contents("http://api.geonames.org/children?geonameId=".$pais['geonameId']."&username=mayo&lang=".$idioma['idi_code']."&type=JSON");
			$consulta_array = json_decode($consulta);
			//print_r($consulta_array->geonames);
			
			if($consulta_array->geonames == null)
			{
				$data = array(
		            'city_id' => NULL,
		            'city_countryCode' => $pais['ctry_code'],
		            'idi_code' => $idioma['idi_code'],
		            'city_nombre' => ""
		        );

		        $this->db->insert('ciudades', $data);

				echo "No tiene ciudades<br>";
			}
			else
			{
				foreach ($consulta_array->geonames as $key => $value)
				{
					if($insert)
					{
						$data = array(
				            'city_id' => NULL,
				            'city_countryCode' => $pais['ctry_code'],
				            'city_nombre_zh' => "",
				            'city_nombre_es' => "",
				            'city_nombre_en' => "",
				            'city_nombre_hi' => "",
				            'city_nombre_ar' => $value->name,
				            'city_nombre_pt' => "",
				            'city_nombre_ru' => "",
				            'city_nombre_ja' => "",
				            'city_nombre_de' => "",
				            'city_nombre_fr' => "",
				            'city_nombre_ko' => "",
				            'city_nombre_it' => "",
				            'toponymName' => $value->toponymName,
				            'lat' => $value->lat,
				            'lng' => $value->lng,
				            'geonameId' => $value->geonameId,
				            'fcl' => $value->fcl,
				            'fcode' => $value->fcode
				        );

				        $this->db->insert('City', $data);
			    	}
			    	else
			    	{
			    		$data = array(
				            'city_nombre_'.$idioma['idi_code'] => $value->name
				        );

			    		$this->db->where(array('geonameId'=>$value->geonameId));
						$this->db->update('City', $data);
			    	}
		    	}
	    	}

	    	echo $pais['ctry_code']."<br>";
			echo $idioma['idi_code']."<br>";
		}
		else
		{
			echo "Termino";
		}
	}
	*/
	
	/*******************/
	/* PRUEBA DE MAILS */
	/*******************/

	public function mail_1()
	{
		$this->load->helper('mails');
		$this->load->model('mails_info_model');

        $this->session->set_userdata('idi_code', "en");

        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'),1);

        $codigo = RandomString(4);
        $send_mail = "fabianmayoral@gmail.com";
        
        $titulo = str_replace("[USER MAIL]", "<a href='mailto:".$send_mail."' style='color:#FFFFFF;'>".$send_mail."</a>", $mail_info['mi_titulo']);
        //$mensaje1 = str_replace("[BOTON]", "<a href='".site_url("login/activar/1/".$codigo)."' style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'>VALIDAR MAIL</a>", $mail_info['mi_cuerpo1']);
        $mensaje2 = str_replace("[LINK]", "<div style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'><a href='".site_url("login/activar/1/".$codigo)."' style='color:#C30D00;'>".$palabras[1]['pal_desc']."</a></div>", $mail_info['mi_cuerpo2']);
        $mensaje2 = str_replace("[HTTP/:]", site_url("login/activar/1/".$codigo), $mensaje2);
        $mensaje2 = str_replace("[USER MAIL]", $send_mail, $mensaje2);
        $mensaje2 = str_replace("[CLAVE]", $codigo, $mensaje2);

        $result = mail_base($send_mail, $mail_info['mi_asunto'], $titulo, $mail_info['mi_cuerpo1'], $mensaje2);
        if($result)
        {
        	echo "OK";
        }
        else
        {
        	echo "Error<br>".$this->email->print_debugger();
        }
	}

	public function mail_2()
	{
		$this->load->helper('mails');
		$this->load->model('mails_info_model');

		$this->session->set_userdata('idi_code', "es");

        $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'), 2);

        $send_mail = "fabianmayoral@hotmail.com";

        $user = $this->user_model->get_items_byMail($send_mail);
        $mail = $this->mails_model->get_item_user($user['usr_id'], $send_mail);
        
        $titulo = str_replace("[USER MAIL]", $send_mail, $mail_info['mi_titulo']);
        $mensaje1 = $mail_info['mi_cuerpo1'];
        $mensaje2 = str_replace("[LINK]", site_url()."login/reset/".$user['usr_id']."/".$mail['mail_codigo'], $mail_info['mi_cuerpo2']);
        $mensaje2 = str_replace("[HOURS]", date('h:i'), $mensaje2);
        $fecha = date('Y-m-d');
		$nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
        $mensaje2 = str_replace("[DAYS]", $nuevafecha, $mensaje2);
        $mensaje2 = str_replace("[SISTEMA MAIL]", "contact@Sistema.com", $mensaje2);
        
        echo $mail_info['mi_asunto']."<br>";
        echo $titulo."<br>";
        echo $mensaje1."<br>";
        echo $mensaje2."<br>";
        echo "<br>";
        
        $result = mail_base("fabianmayoral@gmail.com", $mail_info['mi_asunto'], $titulo, $mensaje1, $mensaje2);
        if($result)
        {
        	echo "OK";
        }
        else
        {
        	echo "Error<br>".$this->email->print_debugger();
        }
	}

	public function mail_3()
	{
		$this->load->helper('mails');
		$this->load->model('mails_info_model');

		$this->session->set_userdata('idi_code', "es");

        $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'), 3);

        $send_mail = "fabianmayoral@hotmail.com";
        
        $titulo = str_replace("[USER MAIL]", $send_mail, $mail_info['mi_titulo']);
        $mensaje1 = $mail_info['mi_cuerpo1'];
        $mensaje2 = str_replace("[SISTEMA MAIL]", "contact@Sistema.com", $mail_info['mi_cuerpo2']);
        
        echo $mail_info['mi_asunto']."<br>";
        echo $titulo."<br>";
        echo $mensaje1."<br>";
        echo $mensaje2."<br>";
        echo "<br>";
        /*
        $result = mail_base("fabianmayoral@gmail.com", $mail_info['mi_asunto'], $titulo, $mensaje1, $mensaje2);
        if($result)
        {
        	echo "OK";
        }
        else
        {
        	echo "Error<br>".$this->email->print_debugger();
        }
        */
	}

	public function mail_4()
	{
		$this->load->helper('mails');
		$this->load->model('mails_info_model');

        $this->session->set_userdata('idi_code', "es");

        $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'), 4);

        $codigo = RandomString(4);
        $send_mail = "fabianmayoral@hotmail.com";
        
        $titulo = str_replace("[USER MAIL]", $send_mail, $mail_info['mi_titulo']);
        $mensaje1 = str_replace("[USER MAIL 2]", $send_mail, $mail_info['mi_cuerpo1']);
        $mensaje2 = str_replace("[LINK]", "<a href='".site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo)."' style='color:#FFFFFF; text-decoration:none;'>".site_url("login/activar/1/".$codigo)."</a>", $mail_info['mi_cuerpo2']);
        $mensaje2 = str_replace("[HTTP/:]", site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo), $mensaje2);
        $mensaje2 = str_replace("[USER MAIL]", $send_mail, $mensaje2);
        $mensaje2 = str_replace("[CLAVE]", $codigo, $mensaje2);

        echo $mail_info['mi_asunto']."<br>";
        echo $titulo."<br>";
        echo $mensaje1."<br>";
        echo $mensaje2."<br>";
        echo "<br>";

        $result = mail_base($send_mail, $mail_info['mi_asunto'], $titulo, $mensaje1, $mensaje2);
        if($result)
        {
        	echo "OK";
        }
        else
        {
        	echo "Error<br>".$this->email->print_debugger();
        }
	}

	public function mail_publi($idi_code = "en")
	{
		$this->load->helper('mails');

        $send_mail = "fabianmayoral@hotmail.com";

        $result = mail_publicidad($send_mail, $idi_code);
        if($result)
        {
        	echo "OK - ".$send_mail;
        }
        else
        {
        	echo "Error<br>".$this->email->print_debugger();
        }
	}

	public function crecimiento()
	{
		$query = $this->db->query("SELECT A.ara_id, A.ara_code, A.ara_desc_es as ara_desc
									FROM Aranceles AS A
									WHERE A.cat_id=27");
		$aranceles = $query->result_array();
									
        foreach ($aranceles as $key => $arancel)
        {
        	if($arancel['ara_id'] < 100000)
        	{
        		$ara_code = "0".$arancel['ara_id'];
        	}
        	else
        	{
        		$ara_code = $arancel['ara_id'];
        	}
        	$query = $this->db->query("SELECT C.com_valor
										FROM Comtrade AS C 
										WHERE C.com_arancel='".$ara_code."'
										AND C.com_anio=2010 
										AND C.com_origen=566 
										AND C.com_destino=0 
										AND C.com_tipo=2");
	        $min = $query->row_array();

	        $query = $this->db->query("SELECT C.com_valor
										FROM Comtrade AS C 
										WHERE C.com_arancel='".$ara_code."'
										AND C.com_anio=2014
										AND C.com_origen=566 
										AND C.com_destino=0 
										AND C.com_tipo=2");
	        $max = $query->row_array();

        	echo $arancel['ara_id'].": ".$max['com_valor']." - ".$min['com_valor']."<br>";
        }
	}

	public function eliminar_noreply()
	{
    	$query = $this->db->query("SELECT *
									FROM noreply AS N");
		$noreplys = $query->result_array();

		foreach ($noreplys as $key => $noreply)
		{
			$this->db->where(array('exc_mail'=>$noreply['nr_mail']));
        	$this->db->delete('excel');
		}
	}

	public function cargar_noreply()
	{
		$ruta = "assets/no-reply.xls";
		$this->load->library('PHPExcel/IOFactory');

		try
            {
                $inputFileType = IOFactory::identify($ruta);
                //$objReader = new PHPExcel_Reader_Excel2003XML();
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($ruta);

                //  Get worksheet dimensions
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                //echo $highestRow."<br>".$highestColumn."<br>";
                
                $num = 0;

                //  Loop through each row of the worksheet in turn
                for ($row = 610; $row <= $highestRow; $row++)
                {
                	$num++;
                    $userAux = FALSE;
                    $padreAux = FALSE;
                    $aux = NULL;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    
                    $aux['col_1'] = "";
                    $aux['col_2'] = "";
                    $aux['col_3'] = "";
                    

                    if(array_key_exists(2, $rowData[0]))
                        $aux['col_2'] = $rowData[0][1];

                    if(array_key_exists(3, $rowData[0]))
                        $aux['col_3'] = $rowData[0][2];

                    if(array_key_exists(11, $rowData[0]))
                        $aux['col_11'] = $rowData[0][11];
                    

                    //print_r($aux);
                    $emails2 = $this->extract_email_address($aux['col_2']);
                    $emails3 = $this->extract_email_address($aux['col_3']);
                    $emails11 = $this->extract_email_address($aux['col_11']);
                    $emails = array_merge($emails2,$emails3,$emails11);

                    echo $num.": ";

                    foreach ($emails as $key => $email)
                    {
                    	//echo $email." - ";
                    	$query = $this->db->query("SELECT *
													FROM noreply AS N
													WHERE N.nr_mail='".$email."'");
						$encontro = $query->row_array();
						if(!$encontro)
						{
	                    	$data = array(
					            'nr_id' => NULL,
					            'nr_mail' => $email
					        );

					        if($this->db->insert('noreply', $data))
					        {
					        	echo "ok";
					        }
					        else
					        {
					        	echo "error";
					        }
				    	}
				    	else
				    	{
				    		echo "dup";
				    	}
                    }

                    echo "<br>";
                }
                
            }
            catch (Exception $e)
            {
                $data['error'] = true;
                $data['data'] = 'Error loading file "' . pathinfo($ruta, PATHINFO_BASENAME) . '": ' . $e->getMessage();
                print_r($data);
            }
	}

	public function extract_email_address ($string) {
		$emails = [];
	    foreach(preg_split('/\s/', $string) as $token) {
	        $email = filter_var(filter_var($token, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
	        if ($email !== false) {
	            $emails[] = $email;
	        }
	    }
	    return $emails;
	}


	public function cargar_csv_comtrade()
	{
		//$aranceles = $this->aranceles_model->get_items('es');
		$query = $this->db->query("SELECT *
									FROM comtrade_csv
									WHERE csv_estado = 0
									LIMIT 1");
		$csv = $query->row_array();

		$ruta = "assets/csv/".$csv['csv_nombre'];

		// Lo actualizo en pasos por si no termina de procesar
		$update = array(
			'csv_estado' => 1
		);
		$this->db->where('csv_id',$csv['csv_id']);
		$this->db->update('comtrade_csv', $update);
		/////////////////

		$archivo = fopen($ruta,"rb");

		$ctry_code_origen = "";
		$ctry_code_destino = "";

		$crecimiento_impo_array = array();
		$crecimiento_expo_array = array();

		$num_linea = 0;
		while( feof($archivo) == false)
		{
			$linea = fgets($archivo);
			$num_linea++;
			$linea_array = explode(',', $linea);

			if($num_linea > 1 && array_key_exists(1, $linea_array))
			{
				$largo_array = count($linea_array);

				$arancel = $this->aranceles_model->get_items('es', $linea_array[21]);
				if($arancel)
				{
					$data = array(
			            'com_id' => NULL,
			            'com_anio' => $linea_array[1],
			            'ctry_code_origen' => $linea_array[10],
			            'ctry_code_destino' => $linea_array[13],
			            'com_tipo' => $linea_array[6],
			            'ara_id' => $linea_array[21],
			            'com_unidad' => $linea_array[$largo_array-12],
			            'com_cantidad' => $linea_array[$largo_array-8],
			            'com_peso' => $linea_array[$largo_array-6],
			            'com_valor' => $linea_array[$largo_array-4]
			        );

					$ctry_code_origen = $linea_array[10];
					$ctry_code_destino = $linea_array[13];

					if($linea_array[6] == IMPORTACION)
					{
						$crecimiento_impo_array[$data['ara_id']][$data['com_anio']] = $data['com_valor'];
					}
					else
					{
			        	$crecimiento_expo_array[$data['ara_id']][$data['com_anio']] = $data['com_valor'];
			        }
			        
			        // INSERT comtrade2
			        if($this->db->insert('comtrade2', $data))
			        {
			        	//echo $num_linea." - ok<br>";
			        }
			        else
			        {
			        	echo $num_linea." - error<br>";
			        }
		        }
		        else
		        {
		        	echo $linea_array[21]." - no existe en la tabla de posiciones arancelarias<br>";
		        }
	    	}
		}

		if($num_linea > 9)
		{
			echo $num_linea." - Posiciones cargadas<br>";
		}
		else
		{
			echo $num_linea." - DUDOSO<br>";
			die();
		}

		// Lo actualizo en pasos por si no termina de procesar
		$update = array(
			'csv_estado' => 2
		);
		$this->db->where('csv_id',$csv['csv_id']);
		$this->db->update('comtrade_csv', $update);
		/////////////////
		
		foreach ($crecimiento_impo_array as $ara_id => $crecimiento)
		{
			$anio_min = 9999;
			$anio_max = 0;
			$valor_min = 9999;
			$valor_max = 0;

			foreach ($crecimiento as $anio => $valor)
			{
				if($anio < $anio_min)
				{
					$anio_min = $anio;
					$valor_min = $valor;
				}

				if($anio > $anio_max)
				{
					$anio_max = $anio;
					$valor_max = $valor;
				}
			}

			if($valor_min == "")
			{
				$valor_min = 0;
			}
			if($valor_max == "")
			{
				$valor_max = 0;
			}

			$valor_total = $valor_max - $valor_min;
			if($valor_min > 0)
			{
				$porcentaje = (($valor_max / $valor_min) - 1) * 100;
			}
			else
			{
				$porcentaje = 100;
			}
			
			$data_crecimiento = array(
	            'comc_id' => NULL,
	            'comc_anio_ini' => $anio_min,
	            'comc_anio_fin' => $anio_max,
	            'ctry_code_origen' => $ctry_code_origen,
	            'ctry_code_destino' => $ctry_code_destino,
	            'comc_tipo' => IMPORTACION,
	            'ara_id' => $ara_id,
	            'comc_valor_ini' => $valor_min,
	            'comc_valor_fin' => $valor_max,
	            'comc_porcentaje' => $porcentaje
	        );
			
			if($this->db->insert('comtrade_crecimiento', $data_crecimiento))
	        {
	        	//echo $ara_id." IMPORTACION - ok<br>";
	        }
	        else
	        {
	        	echo $ara_id." IMPORTACION - error<br>";
	        }
		}

		echo "IMPORTACION - ok<br>";

		// Lo actualizo en pasos por si no termina de procesar
		$update = array(
			'csv_estado' => 3
		);
		$this->db->where('csv_id',$csv['csv_id']);
		$this->db->update('comtrade_csv', $update);
		/////////////////

		foreach ($crecimiento_expo_array as $ara_id => $crecimiento)
		{
			$anio_min = 9999;
			$anio_max = 0;
			$valor_min = 9999;
			$valor_max = 0;

			foreach ($crecimiento as $anio => $valor)
			{
				if($anio < $anio_min)
				{
					$anio_min = $anio;
					$valor_min = $valor;
				}

				if($anio > $anio_max)
				{
					$anio_max = $anio;
					$valor_max = $valor;
				}
			}

			if($valor_min == "")
			{
				$valor_min = 0;
			}
			if($valor_max == "")
			{
				$valor_max = 0;
			}

			$valor_total = $valor_max - $valor_min;
			if($valor_min > 0)
			{
				$porcentaje = (($valor_max / $valor_min) - 1) * 100;
			}
			else
			{
				$porcentaje = 100;
			}
			
			$data_crecimiento = array(
	            'comc_id' => NULL,
	            'comc_anio_ini' => $anio_min,
	            'comc_anio_fin' => $anio_max,
	            'ctry_code_origen' => $ctry_code_origen,
	            'ctry_code_destino' => $ctry_code_destino,
	            'comc_tipo' => EXPORTACION,
	            'ara_id' => $ara_id,
	            'comc_valor_ini' => $valor_min,
	            'comc_valor_fin' => $valor_max,
	            'comc_porcentaje' => $porcentaje
	        );
			
			if($this->db->insert('comtrade_crecimiento', $data_crecimiento))
	        {
	        	//echo $ara_id." EXPORTACION - ok<br>";
	        }
	        else
	        {
	        	echo $ara_id." EXPORTACION - error<br>";
	        }
		}

		echo "EXPORTACION - ok<br>";

		// Lo actualizo en pasos por si no termina de procesar
		$update = array(
			'csv_estado' => 4
		);
		$this->db->where('csv_id',$csv['csv_id']);
		$this->db->update('comtrade_csv', $update);
		/////////////////
		
	    fclose($archivo);
	}

	public function palabras_clave($lang = "en")
	{
		$palabras = $this->palabras_model->get_items($lang);
		echo $palabras[102]['pal_desc']."<br>";
		//echo "Sistema, ".$palabras[49]['pal_desc'].", ".$palabras[50]['pal_desc'].", ".$palabras[51]['pal_desc'].", ".$palabras[52]['pal_desc'].", ".$palabras[53]['pal_desc'].", ".$palabras[54]['pal_desc'].", ".$palabras[55]['pal_desc'].", ".$palabras[57]['pal_desc'];
		echo $palabras[50]['pal_desc'].", ".$palabras[51]['pal_desc'].", ".$palabras[52]['pal_desc'].", ".$palabras[53]['pal_desc'].", ".$palabras[57]['pal_desc'];
	}

	public function robar_exp_imp()
	{
		$query = $this->db->query("SELECT *
                                    FROM exp_imp AS A
                                    WHERE A.field1 = ''
                                    LIMIT 10");
        $items = $query->result_array();

        foreach ($items as $key => $item)
        {
			$data = file_get_contents('http://121.241.212.132/exp_imp/ajax_func.php?mode=firm_detail_im&val=all&val2='.$item['id']);
			$dom = new domDocument;

			$data_array = explode('####', $data);
			$datos_contacto = explode('*', $data_array[0]);
			/*
			foreach ($datos_contacto as $key => $value)
			{
				$field1 = $datos_contacto[0];
			}
			*/
			print_r($datos_contacto);
			$field1 = $datos_contacto[1]; //nombre
			$field2 = $datos_contacto[2]; //direccion
			$field3 = $datos_contacto[8]; //web
			if(array_key_exists(11, $datos_contacto))
			{
				$field4 = $datos_contacto[11]; //city
			}
			else
			{
				$field4 = "";
			}
			$field5 = $datos_contacto[10]; //state
			$field6 = $datos_contacto[5]; //telefono
			$field7 = $datos_contacto[4]; //mail
			$field8 = $datos_contacto[9]; //contacto

			@$dom->loadHTML($data_array[1]);
			$dom->preserveWhiteSpace = false;
			$tables = $dom->getElementsByTagName('table');
			
			$rows = $tables->item(0)->getElementsByTagName('tr');
			$field9 = "";
			foreach ($rows as $key => $row) {
				if($key > 0)
				{
					$cols = $row->getElementsByTagName('td');
					$field9 = "";
					foreach ($cols as $key_col => $col)
					{
						if($key_col > 0)
						{
							$field9 .= " - ";
						}
						$field9 .= $col->textContent;
					}
					$field9 .= "\n";
				}
			}

			$data_update = array(
	            'field1' => $field1,
	            'field2' => $field2,
	            'field3' => $field3,
	            'field4' => $field4,
	            'field5' => $field5,
	            'field6' => $field6,
	            'field7' => $field7,
	            'field8' => $field8,
	            'field9' => $field9
	        );

	        $this->db->where(array('id'=>$item['id']));
	        $this->db->update('exp_imp', $data_update);
		}
	}

	public function eliminar_usuario($usr_id = FALSE)
	{
		if($usr_id)
		{
			//13041
	        $this->db->where(array('usr_id'=>$usr_id));
	        $this->db->delete('Mails');

	        $this->db->where(array('usr_id'=>$usr_id));
	        $this->db->delete('Productos_Favoritos');

	        $this->db->where(array('usr_id'=>$usr_id));
	        $this->db->delete('Productos');

	        $this->db->where(array('usr_id'=>$usr_id));
	        $this->db->delete('Usuarios_Datos');

	        $this->db->where(array('usr_id'=>$usr_id));
	        $this->db->delete('Usuarios_Favoritos');

	        $this->db->where(array('usr_id'=>$usr_id));
	        $this->db->delete('Usuarios');
	        
	        echo "ok";
		}
		else
		{
			echo "Falta el id";
		}
	}

	/**********************
	Borro los usuarios y productos que rebotaron los mails de publicidad
	**********************/
	public function borrar_mails_rebotados()
	{
        $emails = array(
'contact@vercors-restauration.com',
'arcodovinho@net.sapo.pt',
'luis.lebon@petrobras.com'
        );

        //  Loop through each row of the worksheet in turn
        foreach ($emails as $key => $email)
        {
            echo $key.": ".$email;

        	$userAux = $this->user_model->get_items_byMail($email);

			if($userAux)
			{
				//Borro los productos
				$productos = $this->productos_model->get_items('es', $userAux['usr_id']);
				foreach ($productos as $key => $producto)
				{
					$result = $this->productos_model->delete_item($producto['prod_id'], $userAux['usr_id']);
					$result = $this->productos_model->delete_item_mails($producto['prod_id']);
					$result = $this->productos_model->delete_item_idiomas($producto['prod_id']);
					$result = $this->favoritos_model->delete_producto_favorito($userAux['usr_id'], $producto['prod_id']);
					if(!$result)
					{
						echo "error";
					}
				}
				
				//Borro los mails
				$result = $this->mails_model->delete_items_usuario($userAux['usr_id']);

				//Borro los favoritos
				$result = $this->favoritos_model->delete_usuarios_favoritos($userAux['usr_id']);
				
				//Borro el usuario
				$result = $this->user_model->delete_datos($userAux['usr_id']);
				$result = $this->user_model->delete_item($userAux['usr_id']);
			}
			else
			{
				$this->db->where(array('mpp_mail'=>$email));
        		$this->db->delete('mails_para_publicidad');

				echo " El usuario no existe";
			}

            echo "<br>";
        }

	}

	public function verificar_imagenes()
	{
		$query = $this->db->query("SELECT *
                                    FROM productos_imagenes AS PM");

        $results = $query->result_array();
        foreach ($results as $key => $value)
        {
        	if(file_exists( "./images/productos/".$value['pi_ruta'] ))
        	{
        		//echo $value['pi_ruta']." OK<br>";
        	}
        	else
        	{
        		/*
        		$array = explode('.', $value['pi_ruta']);
				$extension = end($array);
        		echo $value['prod_id']." ".$value['pi_ruta']." ERROR ".time().'_'.$key.'.'.$extension."<br>";
        		$data = array(
		            'pi_ruta' => time().'_'.$key.'.'.$extension
		        );

		        $this->db->where(array('pi_id'=>$value['pi_id']));
		        //$this->db->update('productos_imagenes', $data);
		        */
		        $this->db->where(array('pi_id'=>$value['pi_id']));
        		$this->db->delete('productos_imagenes');
        	}
        }
        echo "<br>FIN";
	}

	public function mail_publi_flavio()
	{
		$this->load->helper('mails');
		$result = mail_publicidad_sendgrid("flaviogariglio@gmail.com", 1, "xxxy", 'en');
        if($result)
        {
        	echo "OK";
        }
        else
        {
        	echo "Error";
        }
	}

	public function actualizar_telefonos()
	{
		$query = $this->db->query("SELECT *
                                    FROM codigos_telefono AS CT
                                    WHERE CT.ct_estado=0");
        $results = $query->result_array();

        foreach ($results as $key => $value)
        {
        	$query2 = $this->db->query("SELECT *
	                                    FROM Country AS C
	                                    WHERE C.ctry_nombre_es LIKE '%".$value['ct_pais']."%'
	                                    AND C.ctry_phone_code IS NULL");
	        $results2 = $query2->result_array();

	        if($results2 && count($results2)==1)
	        {
	        	//Actualizar
	        	$data = array(
		            'ctry_phone_code' => $value['ct_numero']
		        );
		        $this->db->where('ctry_code', $results2[0]['ctry_code']);
		        $this->db->update('Country', $data);

		        //Borrar
	        	$data = array(
		            'ct_estado' => 1
		        );
		        $this->db->where('ct_id', $value['ct_id']);
		        $this->db->update('codigos_telefono', $data);

	        	echo $value['ct_pais']." OK<br>";
	        }
	        elseif($results2 && count($results2)>1)
	        {
	        	echo $value['ct_pais']." VARIOS - ";
	        	foreach ($results2 as $key2 => $value2)
	        	{
	        		echo $value2['ctry_nombre_es']." / ";
	        	}
	        	echo "<br>";
	        }
	        else
	        {
	        	echo $value['ct_pais']." ERROR<br>";
	        }
        }
        echo "<br>FIN";
	}

}
