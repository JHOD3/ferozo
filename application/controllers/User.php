<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user extends CI_Controller {

	private static $solapa = "user";

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
		$this->load->model('secciones_model');
		$this->load->model('categorias_model');
		$this->load->model('aranceles_model');
        $this->load->model('tipo_datos_model');
        $this->load->model('foro_model');
        $this->load->model('palabras_model');
        $this->load->model('mails_model');
        $this->load->model('comtrade_model');
        $this->load->model('favoritos_model');
        $this->load->model('referencias_model');
        $this->load->model('mails_info_model');
        $this->load->model('mensajes_model');
		
		$this->load->view('templates/validate_login');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
	}

	public function profile()
	{
		$data['error'] = "";
		$data['success'] = "";

        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        //$this->form_validation->set_rules('apellido', 'apellido', 'required');
        //$this->form_validation->set_rules('nombre', 'nombre', 'required');
        $this->form_validation->set_rules('pais', mostrar_palabra(2, $data['palabras']), 'required');
        //$this->form_validation->set_rules('ciudad', 'ciudad', 'required');
        $this->form_validation->set_rules('idioma', mostrar_palabra(3, $data['palabras']), 'required');

        if ($this->form_validation->run() === FALSE)
        {
        	//$this->load->view(self::$solapa.'/profile', $data);
        }
        else
        {
            $config['upload_path'] = "./images/usuarios/";
            $config['allowed_types'] = '*';
            $config['max_size'] = '10000';
            $config['file_name'] = time();
            $this->load->library('upload', $config);
            $imagen_aux = $this->input->post('imagen_ant');

            if($this->input->post('nueva_imagen') == 1)
            {
                if($this->upload->do_upload("imagen"))
                {
                    $imagen = $this->upload->data();

                    //Achico la imagen grande//
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = "./images/usuarios/".$imagen['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 300;
                    $config['height'] = 300;
                    $dim = (intval($imagen["image_width"]) / intval($imagen["image_height"])) - ($config['width'] / $config['height']);
                    $config['master_dim'] = ($dim > 0)? "height" : "width";

                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $this->image_lib->clear();

                    $config['maintain_ratio'] = FALSE;
                    $this->image_lib->initialize($config);
                    $this->image_lib->crop();

                    $this->image_lib->clear();
                    ///////////////////////////

                    $imagen_aux = $imagen['file_name'];
                    if(file_exists("./images/usuarios/".$this->input->post('imagen_ant')) && $this->input->post('imagen_ant') != "perfil.jpg")
                    {
                        unlink("./images/usuarios/".$this->input->post('imagen_ant'));
                    }
                }
                else
                {
                    $data['error'] = $this->upload->display_errors();
                }
            }

        	$result = $this->user_model->update_item($this->session->userdata('usr_id'), $this->input->post('nombre'), $this->input->post('apellido'), $this->input->post('idioma'), $this->input->post('publica'), $imagen_aux, $this->input->post('empresa'), $this->input->post('pais'), $this->input->post('ciudad'), $this->input->post('localidad'), $this->input->post('direccion'), $this->input->post('cp'));
        	if($result)
        	{
                if($this->input->post('idioma') != $this->session->userdata('idi_code'))
                {
                    $this->session->set_userdata('idi_code', $this->input->post('idioma'));
                    $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
                }
                $this->session->set_userdata('usr_nombre', $this->input->post('nombre'));
                $this->session->set_userdata('usr_apellido', $this->input->post('apellido'));
                //$this->lang->load('form_validation_lang', $this->input->post('idioma'));
                //$this->lang->load('imglib_lang', $this->input->post('idioma'));
                //$this->lang->load('upload_lang', $this->input->post('idioma'));
                //$this->lang->load('db_lang', $this->input->post('idioma'));
                $this->session->set_userdata('usr_pais', $this->input->post('pais'));
                $this->session->set_userdata('usr_imagen', $imagen_aux);

                if($this->session->userdata('usr_nombre') == "" && $this->session->userdata('usr_apellido') == "")
                {
                    $this->session->set_userdata('usr_nombre', substr($this->session->userdata('usr_mail'),0,strpos($this->session->userdata('usr_mail'), '@')));
                }

        		$this->user_model->delete_datos($this->session->userdata('usr_id'));
                $ctd = $this->input->post('dato_ctd[]');
                $desc = $this->input->post('dato_desc[]');
                if($this->input->post('dato_td[]') != "")
                {
                    foreach ($this->input->post('dato_td[]') as $key => $dato)
                    {
                        $this->user_model->set_dato($this->session->userdata('usr_id'), $dato, $ctd[$key], $desc[$key]);
                        
                        if($dato == 2) // VALIDAR MAIL
                        {
                            if(!$this->mails_model->existe_mail_usuario($desc[$key], $this->session->userdata('usr_id')))
                            {
                                $codigo = RandomString(4);
                                $mail_id = $this->mails_model->set_item($this->session->userdata('usr_id'), $desc[$key], $codigo, 0);

                                $this->load->helper('mails');
                                $this->lang->load('email', $this->session->userdata('idi_code'));
                                
                                $mensaje1 = str_replace("[BOTON]", "<a href='".site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo)."' style='padding:20px 40px; background:#FFFFFF; width:auto; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'>VALIDAR MAIL</a>", $this->lang->line('email_mail_mensaje1'));
                                $mensaje1 = str_replace("[MAIL]", $desc[$key], $mensaje1);
                                $mensaje2 = str_replace("[LINK]", "<a href='".site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo)."' style='color:#FFFFFF; text-decoration:none;'>".site_url("login/validar_mail/".$this->session->userdata('usr_id')."/".$codigo)."</a>", $this->lang->line('email_mail_mensaje2'));
                                $mensaje2 = str_replace("[MAIL]", $desc[$key], $mensaje2);
                                $mensaje2 = str_replace("[CODIGO]", $codigo, $mensaje2);

                                mail_base($desc[$key], $this->lang->line('email_mail_asunto'), $this->lang->line('email_mail_titulo'), $mensaje1, $mensaje2);
                            }
                        }
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

        		$data['success'] = mostrar_palabra(222, $data['palabras']);
        	}
        	else
        	{
        		$data['error'] = mostrar_palabra(223, $data['palabras']);
        	}
        }

        $data['user'] = $this->user_model->get_items($this->session->userdata('usr_id'));
        $data['paises'] = $this->paises_model->get_items($this->session->userdata('idi_code'));
        $data['ciudades'] = $this->paises_model->get_provincias_ciudad($this->session->userdata('idi_code'), $data['user']['usr_pais']);
        $data['idiomas'] = $this->idiomas_model->get_items($this->session->userdata('idi_code'));
        $data['tipo_datos'] = $this->tipo_datos_model->get_items($this->session->userdata('idi_code'));
        foreach($data['tipo_datos'] as $key_td => $tipo_dato)
        {
            $data['tipo_datos'][$key_td]['categorias'] = $this->tipo_datos_model->get_categorias($this->session->userdata('idi_code'), $tipo_dato['td_id']);
            $data['tipo_datos'][$key_td]['datos'] = $this->user_model->get_tipo_datos($data['user']['usr_id'], $tipo_dato['td_id']);
        }
        $data['referencias'] = $this->referencias_model->get_items($this->session->userdata('usr_id'));

        $this->load->view(self::$solapa.'/profile', $data);
	}

    public function pais()
    {
        $data['error'] = "";
        $data['success'] = "";

        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $this->form_validation->set_rules('pais', mostrar_palabra(2, $data['palabras']), 'required');

        if ($this->form_validation->run() === FALSE)
        {
            //$this->load->view(self::$solapa.'/profile', $data);
        }
        else
        {
            $result = $this->user_model->update_pais($this->session->userdata('usr_id'), $this->input->post('pais'));
            if($result)
            {
                $this->session->set_userdata('usr_pais', $this->input->post('pais'));

                $data['success'] = mostrar_palabra(222, $data['palabras']);

                redirect("resultados");
            }
            else
            {
                $data['error'] = mostrar_palabra(223, $data['palabras']);
            }
        }

        $data['paises'] = $this->paises_model->get_items($this->session->userdata('idi_code'));

        $this->load->view(self::$solapa.'/pais', $data);
    }
    
    public function nuevo_dato_noajax($td_id = 0, $id = 0)
    {
            $tipo_dato = $this->tipo_datos_model->get_items($this->session->userdata('idi_code'), $td_id);
            $tipo_dato['categorias'] = $this->tipo_datos_model->get_categorias($this->session->userdata('idi_code'), $tipo_dato['td_id']);

            echo "<div id='area_dato_".$id."'>";
                    if(count($tipo_dato['categorias']) > 0)
                    {
                        /*
                        echo "<div class='col-xs-5'>";
                        echo "<select class='form-control' name='dato_ctd[]'>";
                          foreach ($tipo_dato['categorias'] as $categoria)
                          {
                              echo "<option value='".$categoria['ctd_id']."'>".$categoria['ctd_desc']."</option>";
                          }
                        echo "</select>";
                        echo "</div>";
                        echo "<div class='col-xs-6'>";
                        echo "<input type='text' class='form-control' name='dato_desc[]' value=''>";
                        echo "</div>";
                        */
                        echo '<div class="input-group">';
                          echo '<div class="input-group-btn">';
                            echo "<select class='btn btn-default dropdown-toggle' name='dato_ctd[]' style='height:35px;'>";
                            foreach ($tipo_dato['categorias'] as $categoria)
                            {
                                echo "<option value='".$categoria['ctd_id']."'>".$categoria['ctd_desc']."</option>";
                            }
                          echo "</select>";
                          echo '</div><!-- /btn-group -->
                          <input type="text" class="form-control" name="dato_desc[]" value="">
                          <span class="input-group-btn">
                            <button class="btn" type="button" onclick="borrar_dato('.$id.')"><i class="fa fa-minus"></i></button>
                          </span>';
                        echo '</div>';
                    }
                    else
                    {
                        echo "<input type='hidden' class='form-control' name='dato_ctd[]' value='0'>";
                        /*
                        echo "<div class='col-xs-11'>";
                        echo "<input type='text' class='form-control' name='dato_desc[]' value=''>";
                        echo "</div>";
                        */
                        echo '<div class="input-group">';
                          echo '<input type="text" class="form-control" name="dato_desc[]" value="">
                          <span class="input-group-btn">
                            <button class="btn" type="button" onclick="borrar_dato('.$id.')"><i class="fa fa-minus"></i></button>
                          </span>';
                        echo '</div>';
                    }
                    echo "<input type='hidden' class='form-control' name='dato_td[]' value='".$tipo_dato['td_id']."'>";
                    /*
                    echo "<div class='col-xs-1'>";
                    echo "<button type='button' class='btn' onclick='borrar_dato(".$id.")'><i class='fa fa-minus'></i></button>";
                    echo "</div>";
                    */
                    echo "</div>";
            echo "</div>";
    }

    public function nueva_referencia_noajax($id = 0)
    {
        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        
            echo "<div id='area_referencia_".$id."' style='margin-bottom:5px;'>";
                echo '<div class="input-group">';
                  echo '<input type="hidden" class="form-control" id="ref_id_'.$id.'" name="ref_id[]" value="">';
                  echo '<input type="hidden" class="form-control" id="ref_est_id_'.$id.'" name="ref_est_id[]" value="">';
                  echo '<input type="email" class="form-control" name="ref_mail[]" value="" placeholder="'.mostrar_palabra(4, $palabras).'">';
                  echo '<span class="input-group-btn">';
                    //echo '<button class="btn btn-default" type="button"><i class="fa fa-share-square-o"></i></button>';
                    echo '<button class="btn btn-default" type="button" onclick="borrar_referencia('.$id.')"><i class="fa fa-minus"></i></button>';
                  echo '</span>';
                echo '</div>';
                echo "</div>";
            echo "</div>";
    }

    public function password()
    {
        $data['error'] = "";
        $data['success'] = "";

        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['user'] = $this->user_model->get_items($this->session->userdata('usr_id'));

        $this->form_validation->set_rules('clave_ant', mostrar_palabra(46, $data['palabras']), 'required');
        $this->form_validation->set_rules('clave', mostrar_palabra(47, $data['palabras']), 'required');
        $this->form_validation->set_rules('clave2', mostrar_palabra(48, $data['palabras']), 'required|matches[clave]');

        if ($this->form_validation->run() === FALSE)
        {
            //$this->load->view(self::$solapa.'/password', $data);
        }
        else
        {
            if($this->input->post('clave_ant') == $data['user']['usr_clave'])
            {
                $result = $this->user_model->update_clave($this->session->userdata('usr_id'), $this->input->post('clave'));
                if($result)
                {
                    $this->load->helper('mails');
                    $this->lang->load('email', $this->session->userdata('idi_code'));

                    mail_base($data['user']['usr_mail'], $this->lang->line('email_clave_asunto'), $this->lang->line('email_clave_titulo'), $this->lang->line('email_clave_mensaje1'), $this->lang->line('email_clave_mensaje2'));

                    $data['success'] = mostrar_palabra(222, $data['palabras']);
                }
                else
                {
                    $data['error'] = mostrar_palabra(223, $data['palabras']);
                }
            }
            else
            {
                $data['error'] = mostrar_palabra(223, $data['palabras']).': '.mostrar_palabra(46, $data['palabras']);
            }
        }
        $this->load->view(self::$solapa.'/password', $data);
    }

    public function view($usr_id = false)
    {
        if($usr_id == FALSE)
        {
            redirect('resultados');
        }

        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['user'] = $this->user_model->get_otro_item($this->session->userdata('idi_code'), $usr_id);
        if($data['user'])
        {
            if(!$data['user']['puntaje'])
            {
                $data['user']['puntaje'] = 0;
            }
            $data['tipo_datos'] = $this->tipo_datos_model->get_items($this->session->userdata('idi_code'));
            foreach($data['tipo_datos'] as $key_td => $tipo_dato)
            {
                $data['tipo_datos'][$key_td]['categorias'] = $this->tipo_datos_model->get_categorias($this->session->userdata('idi_code'), $tipo_dato['td_id']);
                $data['tipo_datos'][$key_td]['datos'] = $this->user_model->get_tipo_datos($data['user']['usr_id'], $tipo_dato['td_id']);
            }

            $data['favorito'] = $this->favoritos_model->buscar_usuario_favorito($this->session->userdata('usr_id'), $usr_id);
            $data['referencias_validadas'] = $this->referencias_model->get_items($usr_id);
            $data['resultados'] = $this->productos_model->get_items($this->session->userdata('idi_code'), $usr_id, FALSE);
        }
        else
        {
            redirect('resultados');
        }

        $this->load->view(self::$solapa.'/view', $data);
    }

    public function buscar_usuario_favorito_ajax($usr_id = FALSE)
    {
        $data['data'] = $this->favoritos_model->buscar_usuario_favorito($this->session->userdata('usr_id'), $usr_id);
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

    public function marcar_usuario_favorito_ajax($usr_id = FALSE, $puntaje = 0)
    {
        $data['error'] = FALSE;
        $this->favoritos_model->delete_usuario_favorito($this->session->userdata('usr_id'), $usr_id);
        if($puntaje > 0)
        {
            $result = $this->favoritos_model->set_usuario_favorito($this->session->userdata('usr_id'), $usr_id, $puntaje);
            if($result)
            {
                $data['error'] = FALSE;
            }
            else
            {
                $data['error'] = TRUE;
                $data['data'] = "Surgio un error al grabar el favorito.";
            }
        }

        $puntaje_array = $this->favoritos_model->buscar_puntaje_usuario($usr_id);
        $data['puntaje'] = $puntaje_array['puntaje'];
        $data['cant_seguidores'] = $puntaje_array['cant_seguidores'];
        $data['uf_puntaje'] = $puntaje;

        echo json_encode($data);
    }

    public function borrar_usuario_favorito_ajax($usr_id = FALSE)
    {
        $result = $this->favoritos_model->delete_usuario_favorito($this->session->userdata('usr_id'), $usr_id);
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

    public function eliminar_imagen_ajax()
    {
        $result = $this->user_model->set_foto($this->session->userdata('usr_id'), 'perfil.jpg');
        if($result)
        {
            $this->session->set_userdata('usr_imagen', 'perfil.jpg');
            $data['error'] = FALSE;
            $data['data'] = "ok";
        }
        else
        {
            $data['error'] = TRUE;
            $data['data'] = "Surgio un error al borrar la imagen.";
        }

        echo json_encode($data);
    }

}
