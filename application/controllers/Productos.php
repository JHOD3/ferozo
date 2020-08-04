<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

	private static $solapa = "productos";

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
        $this->load->model('mensajes_model');

        $this->session->set_userdata('search', $this->input->post('search'));
		
		$this->load->view('templates/validate_login');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

	public function index($tp_id = 1)
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        $data['tipo_producto'] = $this->productos_model->get_tipos($this->session->userdata('idi_code'), $tp_id);
        $data['resultados'] = $this->productos_model->get_items($this->session->userdata('idi_code'), $this->session->userdata('usr_id'), $tp_id);
        $data['referencias_validadas'] = $this->referencias_model->get_cant_validados($this->session->userdata('usr_id'));

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

        $this->load->view(self::$solapa.'/index', $data);
    }

	public function nuevo($tp_id = 1, $ara_precargado = FALSE)
	{
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

        $this->lang->load('form_validation', $this->session->userdata('idi_code'));
        $data['error_descripcion'] = str_replace('{field}', mostrar_palabra(27, $data['palabras']), $this->lang->line('form_validation_required', FALSE));
        $data['error_arancel'] = str_replace('{field}', mostrar_palabra(255, $data['palabras']), $this->lang->line('form_validation_required', FALSE));
        $data['error_mail'] = str_replace('{field}', mostrar_palabra(4, $data['palabras']), $this->lang->line('form_validation_required', FALSE));
        $data['error_idioma'] = str_replace('{field}', mostrar_palabra(3, $data['palabras']), $this->lang->line('form_validation_required', FALSE));

        //$this->form_validation->set_rules('seccion', mostrar_palabra(76, $data['palabras']), 'required');
        //$this->form_validation->set_rules('categoria', mostrar_palabra(25, $data['palabras']), 'required');
        //$this->form_validation->set_rules('arancel[]', mostrar_palabra(157, $data['palabras']), 'required');
        $this->form_validation->set_rules('pais', mostrar_palabra(2, $data['palabras']), 'required');
        $this->form_validation->set_rules('ciudad', mostrar_palabra(32, $data['palabras']), 'required');
        $this->form_validation->set_rules('descripcion', mostrar_palabra(27, $data['palabras']), 'required');
        $this->form_validation->set_rules('mail[]', mostrar_palabra(4, $data['palabras']), 'required|valid_email');
        $this->form_validation->set_rules('idioma[]', mostrar_palabra(3, $data['palabras']), 'required');

        if($this->form_validation->run() !== FALSE)
        {
            if($this->input->post('arancel_select') == "" && $this->input->post('arancel[]') == "")
            {
                $data['error'] = str_replace('{field}', mostrar_palabra(255, $data['palabras']), $this->lang->line('form_validation_required', FALSE));
            }
            else
            {
                $aranceles = array();
                if($this->input->post('arancel[]') != "")
                {
                    foreach ($this->input->post('arancel[]') as $value)
                    {
                        $aranceles[] = $value;
                    }
                }
                if($this->input->post('arancel_select') != "")
                {
                    $aranceles[] = $this->input->post('arancel_select');
                }


                $config['upload_path']          = './images/productos/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 2048; //2MB
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);

                $imagenes = FALSE;
                if (!empty($_FILES['imagen']['name'][0]))
                {
                    $imagenes = $this->upload_files('./images/productos/', time(), $_FILES['imagen']);
                    if ( $imagenes === FALSE)
                    {
                        $data['error'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
                    }
                } 
                
                if(!$data['error'])
                {
                    foreach($aranceles as $key_arancel => $arancel)
                    {
                        $cantidad_productos = $this->productos_model->get_cant_items($this->session->userdata('usr_id'), $tp_id);
                        if($cantidad_productos['cant'] < 5 || $this->session->userdata('tu_id') == TU_PREMIUM)
                        {
                        	$result = $this->productos_model->set_item($tp_id, $this->session->userdata('usr_id'), $this->input->post('seccion'), $this->input->post('categoria'), $arancel, $this->input->post('descripcion'), $this->input->post('pais'), $this->input->post('ciudad'), 1);
                        	if($result)
                        	{
                        		foreach ($this->input->post('mail[]') as $key => $mail)
                        		{
                        			// VALIDAR MAIL
                                    $mailAux = $this->mails_model->existe_mail_usuario($mail, $this->session->userdata('usr_id'));
                        			if($mailAux == FALSE)
                                    {
                                        $codigo = RandomString(4);
                                        $mail_id = $this->mails_model->set_item($this->session->userdata('usr_id'), $mail, $codigo, 0);
                                        
                                        $this->load->helper('mails');

                                        $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'), 4);
                                        
                                        $titulo = str_replace("[USER MAIL]", $this->session->userdata('usr_mail'), $mail_info['mi_titulo']);
                                        $mensaje1 = str_replace("[USER MAIL 2]", $mail, $mail_info['mi_cuerpo1']);
                                        $mensaje2 = str_replace("[LINK]", "<div style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'><a href='".site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo)."' style='color:#C30D00;'>".mostrar_palabra(1, $data['palabras'])."</a></div>", $mail_info['mi_cuerpo2']);
                                        $mensaje2 = str_replace("[HTTP/:]", site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo), $mensaje2);
                                        $mensaje2 = str_replace("[USER MAIL]", $mail, $mensaje2);
                                        $mensaje2 = str_replace("[CLAVE]", $codigo, $mensaje2);
                                        
                                        mail_base($mail, $mail_info['mi_asunto'], $titulo, $mensaje1, $mensaje2);
                                    }
                                    else
                                    {
                                        $mail_id = $mailAux['mail_id'];
                                    }

                                    $this->productos_model->set_item_mail($result, $mail_id);
                        		}

                        		foreach ($this->input->post('idioma[]') as $key => $idioma)
                        		{
                        			$this->productos_model->set_item_idioma($result, $idioma);
                        		}

                                if($imagenes)
                                {
                                    foreach ($imagenes as $key => $value)
                                    {
                                        $this->productos_model->set_item_imagen($result, $value);
                                    }
                                }

                                $this->session->set_flashdata('item_'.$key_arancel, $result);
                                //$this->mails_nuevos_match($result);
                        	}
                        	else
                        	{
                        		$data['error'] = "Se produjo un error al crear el producto.";
                        	}
                        }
                        else
                        {
                            $data['error'] = str_replace('XXXX', '<a class="btn btn-danger" href="'.site_url('planes/premium').'">'.mostrar_palabra(535, $data['palabras']).'</a>', mostrar_palabra(567, $data['palabras']));
                        }
                    }

                    $ref_ids = $this->input->post('ref_id[]');
                    $ref_est_ids = $this->input->post('ref_est_id[]');
                    if($this->input->post('ref_mail[]') != "")
                    {
                        foreach ($this->input->post('ref_mail[]') as $key => $dato)
                        {
                            if($ref_ids[$key] == "" && $dato != "") //INSERT
                            {
                                $ref_id = $this->referencias_model->set_item($this->session->userdata('usr_id'), $dato);

                                //ENVIAR MAIL
                                $this->load->helper('mails');
                                $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'),21);

                                $mensaje1 = str_replace("[USER MAIL]", $this->session->userdata('usr_mail'), $mail_info['mi_cuerpo1']);
                                $mensaje1 = str_replace("[USER COMPLETE NAME]", $this->session->userdata('usr_nombre')." ".$this->session->userdata('usr_apellido'), $mensaje1);
                                $mensaje2 = str_replace("[LINK]", "<div style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'><a href='".site_url("referencias/validar/".$ref_id."/".$this->session->userdata('usr_id'))."' style='color:#C30D00;'>".mostrar_palabra(6, $data['palabras'])."</a></div>", $mail_info['mi_cuerpo2']);

                                mail_base($dato, $mail_info['mi_asunto'], $mail_info['mi_titulo'], $mensaje1, $mensaje2);
                            }
                            else
                            {
                                if($ref_est_ids[$key] == REFERENCIA_ELIMINAR) //ELIMINAR
                                {
                                    $this->referencias_model->delete_item($ref_ids[$key]);
                                }
                                else
                                {
                                    //NADA
                                }
                            }
                        }
                    }
                    
                    $data['success'] = "El producto se ha creado con exito.";
                    redirect('productos/index/'.$tp_id, 'refresh');
                }
            }
        }

        $data['referencias'] = $this->referencias_model->get_items($this->session->userdata('usr_id'));
        $this->load->view(self::$solapa.'/nuevo', $data);
	}

    private function upload_files($path, $title, $files)
    {
        $config = array(
            'upload_path'   => $path,
            'allowed_types' => 'jpg|gif|png',
            'overwrite'     => 1,                       
        );

        $this->load->library('upload', $config);

        $images = array();

        foreach ($files['name'] as $key => $image) {
            $_FILES['images[]']['name']= $files['name'][$key];
            $_FILES['images[]']['type']= $files['type'][$key];
            $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES['images[]']['error']= $files['error'][$key];
            $_FILES['images[]']['size']= $files['size'][$key];

            $ext = pathinfo($files['name'][$key], PATHINFO_EXTENSION);

            //$fileName = $title .'_'. $image;
            $fileName = $title.'_'.$key.'.'.$ext;

            $images[] = $fileName;

            $config['file_name'] = $fileName;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('images[]')) {
                $this->upload->data();
            } else {
                return false;
            }
        }

        return $images;
    }

	public function edit($prod_id)
	{
		$data['error'] = "";
		$data['success'] = "";

		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        if($prod_id == "")
        {
            redirect('productos');
        }

		$data['producto'] = $this->productos_model->get_item($this->session->userdata('idi_code'), $prod_id);
        if(!$data['producto'])
        {
            redirect('productos');
        }

        if($data['producto']['usr_id'] != $this->session->userdata('usr_id'))
        {
            redirect('productos');
        }

		$data['producto_mails'] = $this->productos_model->get_item_mails($prod_id);
		$data['producto_idiomas'] = $this->productos_model->get_item_idiomas($this->session->userdata('idi_code'), $prod_id);
        $data['producto_imagenes'] = $this->productos_model->get_item_imagenes($prod_id);
		$data['tipo_producto'] = $this->productos_model->get_tipos($this->session->userdata('idi_code'), $data['producto']['tp_id']);
		$data['secciones'] = $this->secciones_model->get_items($this->session->userdata('idi_code'));
        /*foreach ($data['secciones'] as $key => $seccion)
        {
            $data['secciones'][$key]['aranceles'] = $this->aranceles_model->get_items_seccion($this->session->userdata('idi_code'), $seccion['sec_id']);
        }*/
		//$data['categorias'] = $this->categorias_model->get_items_seccion($this->session->userdata('idi_code'), $data['producto']['sec_id']);
		//$data['aranceles'] = $this->aranceles_model->get_items_categoria($this->session->userdata('idi_code'), $data['producto']['cat_id']);
		$data['paises'] = $this->paises_model->get_items($this->session->userdata('idi_code'));
		$data['ciudades'] = $this->paises_model->get_provincias_ciudad($this->session->userdata('idi_code'), $data['producto']['ctry_code']);
		$data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));

        //$this->form_validation->set_rules('seccion', mostrar_palabra(76, $data['palabras']), 'required');
        //$this->form_validation->set_rules('categoria', mostrar_palabra(25, $data['palabras']), 'required');
        $this->form_validation->set_rules('arancel', mostrar_palabra(157, $data['palabras']), 'required');
        $this->form_validation->set_rules('pais', mostrar_palabra(2, $data['palabras']), 'required');
        $this->form_validation->set_rules('ciudad', mostrar_palabra(32, $data['palabras']), 'required');
        $this->form_validation->set_rules('descripcion', mostrar_palabra(27, $data['palabras']), 'required');
        $this->form_validation->set_rules('mail[]', mostrar_palabra(4, $data['palabras']), 'required|valid_email');
        $this->form_validation->set_rules('idioma[]', mostrar_palabra(3, $data['palabras']), 'required');

        if ($this->form_validation->run() !== FALSE)
        {
        	$result = $this->productos_model->update_item($data['producto']['prod_id'], $this->session->userdata('usr_id'), $this->input->post('seccion'), $this->input->post('categoria'), $this->input->post('arancel'), $this->input->post('descripcion'), $this->input->post('pais'), $this->input->post('ciudad'));
        	if($result)
        	{
                $config['upload_path']          = './images/productos/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 2048; //2MB
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);

                $imagenes = FALSE;
                if (!empty($_FILES['imagen']['name'][0]))
                {
                    $imagenes = $this->upload_files('./images/productos/', time(), $_FILES['imagen']);
                    if ( $imagenes === FALSE)
                    {
                        $data['error'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
                    }
                }

                if(!$data['error'])
                {
                    if($imagenes)
                    {
                        foreach ($imagenes as $key => $value)
                        {
                            $this->productos_model->set_item_imagen($data['producto']['prod_id'], $value);
                        }
                    }

            		$this->productos_model->delete_item_mails($data['producto']['prod_id']);
            		foreach ($this->input->post('mail[]') as $key => $mail)
            		{
            			//$this->productos_model->set_item_mail($data['producto']['prod_id'], $mail);
                        // VALIDAR MAIL
                        $mailAux = $this->mails_model->existe_mail_usuario($mail, $this->session->userdata('usr_id'));
                        if($mailAux == FALSE)
                        {
                            $codigo = RandomString(4);
                            $mail_id = $this->mails_model->set_item($this->session->userdata('usr_id'), $mail, $codigo, 0);

                            $this->load->helper('mails');

                            $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'), 4);
                            
                            $titulo = str_replace("[USER MAIL]", $this->session->userdata('usr_mail'), $mail_info['mi_titulo']);
                            $mensaje1 = str_replace("[USER MAIL 2]", $mail, $mail_info['mi_cuerpo1']);
                            $mensaje2 = str_replace("[LINK]", "<div style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'><a href='".site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo)."' style='color:#C30D00;'>".mostrar_palabra(1, $data['palabras'])."</a></div>", $mail_info['mi_cuerpo2']);
                            $mensaje2 = str_replace("[HTTP/:]", site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo), $mensaje2);
                            $mensaje2 = str_replace("[USER MAIL]", $mail, $mensaje2);
                            $mensaje2 = str_replace("[CLAVE]", $codigo, $mensaje2);
                            
                            mail_base($mail, $mail_info['mi_asunto'], $titulo, $mensaje1, $mensaje2);
                        }
                        else
                        {
                            $mail_id = $mailAux['mail_id'];
                        }

                        $this->productos_model->set_item_mail($prod_id, $mail_id);
            		}

            		$this->productos_model->delete_item_idiomas($data['producto']['prod_id']);
            		foreach ($this->input->post('idioma[]') as $key => $idioma)
            		{
            			$this->productos_model->set_item_idioma($data['producto']['prod_id'], $idioma);
            		}

                    if($this->input->post('imagenes_borrar') != "")
                    {
                        $imagenes_borrar = explode('|', $this->input->post('imagenes_borrar'));
                        foreach ($imagenes_borrar as $key => $imagen_borrar)
                        {
                            $this->productos_model->delete_item_imagen($imagen_borrar);
                        }
                    }

                    $ref_ids = $this->input->post('ref_id[]');
                    $ref_est_ids = $this->input->post('ref_est_id[]');
                    if($this->input->post('ref_mail[]') != "")
                    {
                        foreach ($this->input->post('ref_mail[]') as $key => $dato)
                        {
                            if($ref_ids[$key] == "" && $dato != "") //INSERT
                            {
                                $ref_id = $this->referencias_model->set_item($this->session->userdata('usr_id'), $dato);

                                //ENVIAR MAIL
                                $this->load->helper('mails');
                                $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'),21);

                                $mensaje1 = str_replace("[USER MAIL]", $this->session->userdata('usr_mail'), $mail_info['mi_cuerpo1']);
                                $mensaje1 = str_replace("[USER COMPLETE NAME]", $this->session->userdata('usr_nombre')." ".$this->session->userdata('usr_apellido'), $mensaje1);
                                $mensaje2 = str_replace("[LINK]", "<div style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'><a href='".site_url("referencias/validar/".$ref_id."/".$this->session->userdata('usr_id'))."' style='color:#C30D00;'>".mostrar_palabra(6, $data['palabras'])."</a></div>", $mail_info['mi_cuerpo2']);

                                mail_base($dato, $mail_info['mi_asunto'], $mail_info['mi_titulo'], $mensaje1, $mensaje2);
                            }
                            else
                            {
                                if($ref_est_ids[$key] == REFERENCIA_ELIMINAR) //ELIMINAR
                                {
                                    $this->referencias_model->delete_item($ref_ids[$key]);
                                }
                                else
                                {
                                    //NADA
                                }
                            }
                        }
                    }

            		$data['success'] = "El producto se ha creado con exito.";
            		redirect('productos/index/'.$data['producto']['tp_id'], 'refresh');
                }
        	}
        	else
        	{
        		$data['error'] = "Se produjo un error al crear el producto.";
        	}
        }

        $data['referencias'] = $this->referencias_model->get_items($this->session->userdata('usr_id'));
        $this->load->view(self::$solapa.'/edit', $data);
	}

	public function delete($prod_id)
	{
		$data['error'] = "";
		$data['success'] = "";

		$data['producto'] = $this->productos_model->get_item($this->session->userdata('idi_code'), $prod_id);

        $this->productos_model->delete_item_mails($prod_id);
        $this->productos_model->delete_item_idiomas($prod_id);
        $this->productos_model->delete_item($prod_id, $this->session->userdata('usr_id'));

        redirect('productos/index/'.$data['producto']['tp_id'], 'refresh');
	}

	public function cargar_categorias_noajax($sec_id)
	{
		$palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$categorias = $this->categorias_model->get_items_seccion($this->session->userdata('idi_code'), $sec_id);
		echo "<option value='' selected disabled style='display:none;'>".mostrar_palabra(155, $palabras)."</option>";
		foreach ($categorias as $categoria)
		{
			echo "<option value='".$categoria['cat_id']."'>".$categoria['cat_code']." - ".$categoria['cat_desc']."</option>";
		}
	}

	public function cargar_aranceles_noajax($cat_id)
	{
		$palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        $categoria = $this->categorias_model->get_items($this->session->userdata('idi_code'), $cat_id);
		$aranceles = $this->aranceles_model->get_items_categoria($this->session->userdata('idi_code'), $cat_id);
        if($categoria['sec_id'] == 22)
        {
            echo "<option value='' selected disabled style='display:none;'>".mostrar_palabra(160, $palabras)."</option>";
        }
        else
        {
            echo "<option value='' selected disabled style='display:none;'>".mostrar_palabra(159, $palabras)."</option>";
        }
		
		foreach ($aranceles as $arancel)
		{
			echo "<option value='".$arancel['ara_id']."'>".$arancel['ara_code']." - ".$arancel['ara_desc']."</option>";
		}
	}

	public function cargar_ciudades_noajax($ctry_code)
	{
		$ciudades = $this->paises_model->get_provincias_ciudad($this->session->userdata('idi_code'), $ctry_code);
		foreach ($ciudades as $ciudad)
		{
			echo "<option value='".$ciudad['city_id']."'>";
            if($ciudad['city_nombre'] == $ciudad['toponymName'])
                echo $ciudad['city_nombre'];
            else
                echo $ciudad['city_nombre']." / ".$ciudad['toponymName'];
            echo "</option>";
		}
	}

	public function nuevo_mail_noajax($id = 0)
    {
        echo "<div id='area_mail_".$id."'>";
            echo "<div class='input-group'>";
                echo "<input type='email' class='form-control' name='mail[]' placeholder='Email' value='".$this->session->userdata('usr_mail')."'>";
                echo "<div class='input-group-addon' style='cursor:pointer;' onclick='borrar_mail(".$id.")'>";
                    echo "<i class='fa fa-minus'></i>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    }

    public function nuevo_imagen_noajax($id = 0)
    {
        echo "<div id='area_imagen_".$id."'>";
            echo "<div class='input-group'>";
                echo "<input type='file' class='form-control' name='imagen[]' placeholder='Imagen'>";
                echo "<div class='input-group-addon' style='cursor:pointer;' onclick='borrar_imagen(".$id.")'>";
                    echo "<i class='fa fa-minus'></i>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    }

	public function nuevo_idioma_noajax($id = 0)
	{
		$idiomas = $this->idiomas_model->get_items($this->session->userdata('idi_code'));

		echo "<div id='area_idioma_".$id."'>";
			echo "<div class='input-group'>";
	            echo "<select class='form-control' name='idioma[]'>";
	              foreach ($idiomas as $idioma)
	              {
	                if($this->session->userdata('idi_code') == $idioma['idi_code'])
	                  echo "<option value='".$idioma['idi_code']."' selected>".ucfirst($idioma['idi_desc'])."</option>";
	                else
	                  echo "<option value='".$idioma['idi_code']."'>".ucfirst($idioma['idi_desc'])."</option>";
	              }
	            echo "</select>";
	            echo "<div class='input-group-addon' style='cursor:pointer;' onclick='borrar_idioma(".$id.")'>";
	                echo "<i class='fa fa-minus'></i>";
	            echo "</div>";
        	echo "</div>";
        echo "</div>";
	}

    public function mails_nuevos_match($prod_id)
    {
        $usuarios = $this->resultados_model->get_usuarios_match_producto($prod_id);
        if($usuarios)
        {
            $this->load->helper('mails');
            foreach ($usuarios as $key => $usuario)
            {
                //echo $usuario['prod_id'].": ".$usuario['mail_direccion']."<br>";

                $mail_info = $this->mails_info_model->get_item($usuario['idi_code'], 5);
                
                $titulo = str_replace("[USER MAIL]", "<a href='mailto:".$usuario['usr_mail']."' style='color:#FFFFFF;'>".$usuario['usr_mail']."</a>", $mail_info['mi_titulo']);
                $mensaje1 = str_replace("[X NEW RESULTS]", 1, $mail_info['mi_cuerpo1']);

                $result = mail_base($usuario['mail_direccion'], $mail_info['mi_asunto'], $titulo, nl2br($mensaje1), nl2br($mail_info['mi_cuerpo2']));
            }
        }
    }

    public function buscar_posiciones_ajax()
    {
        $q = $_POST['data']['q'];
        //$q = "1702";
        $results = array();

        $aranceles = $this->aranceles_model->buscar_items($this->session->userdata('idi_code'), $q);
        if($aranceles)
        {
            foreach($aranceles as $key => $arancel)
            {
                $results[] = array('id' => $arancel['ara_id'], 'text' => $arancel['ara_code']." - ".$arancel['ara_desc']);
            }
        }

        echo json_encode(array('q' => $q, 'results' => $results));
    }

    public function buscar_servicios_ajax()
    {
        $q = $_POST['data']['q'];
        //$q = "1702";
        $results = array();

        $aranceles = $this->aranceles_model->buscar_servicios($this->session->userdata('idi_code'), $q);
        if($aranceles)
        {
            foreach($aranceles as $key => $arancel)
            {
                $results[] = array('id' => $arancel['ara_id'], 'text' => $arancel['ara_code']." - ".$arancel['ara_desc']);
            }
        }

        echo json_encode(array('q' => $q, 'results' => $results));
    }

    /*
	public function subir_excel()
    {
        $data['error'] = false;
        $data['data'] = "";

            $ruta = "assets/demandas.xlsx";

            $this->load->library('PHPExcel/IOFactory');

            $productos_nuevos = 0;
            $usuarios_nuevos = 0;

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
                
                //  Loop through each row of the worksheet in turn
                for ($row = 2; $row <= $highestRow && $row < 50; $row++)
                {
                    $userAux = FALSE;
                    $padreAux = FALSE;
                    $aux = NULL;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    
                    $aux['tp_id'] = "";
                    $aux['usr_id'] = "";
                    $aux['ara_id'] = "";
                    $aux['prod_nombre'] = "";
                    $aux['prod_descripcion'] = "";
                    $aux['ctry_code'] = "";
                    $aux['city_id'] = "";
                    $aux['prod_estado'] = 1;
                    $aux['prod_fecha'] = date('Y-m-d H:i:s');

                    $aux['mail_direccion'] = "";
                    $aux['mail_codigo'] = RandomString(4);

                    $aux['idi_code'] = "";
                    
                    if(array_key_exists(1, $rowData[0]))
                        $aux['tp_id'] = $rowData[0][3];

                    if(array_key_exists(5, $rowData[0]))
                        $aux['ara_id'] = $rowData[0][5];

                    if(array_key_exists(7, $rowData[0]))
                        $aux['ctry_code'] = $rowData[0][7];

                    if(array_key_exists(10, $rowData[0]))
                        $aux['city_id'] = $rowData[0][10];

                    if(array_key_exists(11, $rowData[0]))
                        $aux['prod_descripcion'] = $rowData[0][11];

                    if(array_key_exists(12, $rowData[0]))
                        $aux['mail_direccion'] = $rowData[0][12];

                    if(array_key_exists(14, $rowData[0]))
                        $aux['idi_code'] = $rowData[0][14];

                    
                    //Busco si el mail existe
                    $userAux = $this->user_model->get_items_byMail($aux['mail_direccion']);
                    
                    //Si no existe el usuario lo creo
                    if($userAux == FALSE)
                    {
                        if(array_key_exists('ctry_code', $aux) && $aux['ctry_code'] && array_key_exists('mail_direccion', $aux) && $aux['mail_direccion'] && array_key_exists('idi_code', $aux) && $aux['idi_code'])
                        {
                            $aux['usr_id'] = $this->user_model->set_item($aux['mail_direccion'], "", $aux['idi_code'], $aux['ctry_code'], 0, "perfil.jpg");
                            $usuarios_nuevos++;
                        }
                        else
                        {
                        	echo "faltan datos<br>";
                        }
                    }
                    else
                    {
                    	echo $aux['mail_direccion']."<br>";
                        $aux['usr_id'] = $userAux['usr_id'];
                    }

                }

                //unlink($ruta);
                $data['data'] .= "Se agregaron ".$productos_nuevos." productos nuevos.\nSe cargaron ".$usuarios_nuevos." usuarios nuevos.\n";
                
            }
            catch (Exception $e)
            {
                $data['error'] = true;
                $data['data'] = 'Error loading file "' . pathinfo($ruta, PATHINFO_BASENAME) . '": ' . $e->getMessage();
            }

        echo json_encode($data);
    }
    */
    

}
