<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicaciones extends CI_Controller {

	private static $solapa = "publicaciones";

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

	public function index($tipo = 1)
	{
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        $data['tipo'] = $this->ads_model->get_tipos($tipo);

        $data['titulo'] = $data['tipo']['ads_tipo_nombre'];
        $data['subtitulo'] = $data['palabras'][370]['pal_desc'];
        $data['breadcum'] = array( array('link' => 'javascript:;', 'texto' => $data['tipo']['ads_tipo_nombre']), array('link' => '', 'texto' => $data['palabras'][370]['pal_desc']) );
        
		$data['items'] = $this->ads_model->get_items_x_tipo($this->session->userdata('usr_id'), $data['tipo']['ads_tipo_id']);

        $data['importes'] = $this->ads_model->get_importes();

		$this->load->view(self::$solapa.'/index', $data);
	}

	public function nueva($tipo = 1)
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        $data['tipo'] = $this->ads_model->get_tipos($tipo);

        $data['titulo'] = $data['tipo']['ads_tipo_nombre'];
        $data['subtitulo'] = $data['palabras'][362]['pal_desc'];
        $data['breadcum'] = array( array('link' => site_url('publicaciones/index/'.$data['tipo']['ads_tipo_id']), 'texto' => $data['tipo']['ads_tipo_nombre']), array('link' => '', 'texto' => $data['palabras'][362]['pal_desc']) );
        
        $data['error'] = FALSE;

        $this->form_validation->set_rules('nombre', $data['palabras'][348]['pal_desc'], 'required');
        $this->form_validation->set_rules('titulo', $data['palabras'][349]['pal_desc'], 'required');
        $this->form_validation->set_rules('texto_corto', $data['palabras'][350]['pal_desc'], 'required');
        $this->form_validation->set_rules('texto_largo', $data['palabras'][351]['pal_desc'], 'required');
        $this->form_validation->set_rules('link', $data['palabras'][352]['pal_desc'], 'required');

        if($this->form_validation->run() !== FALSE)
        {
            $config['upload_path']          = '../images/ads/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 2048; //2MB
            $config['max_width']            = 1024;
            $config['max_height']           = 768;

            $this->load->library('upload', $config);

            if ( !$this->upload->do_upload('imagen') )
            {
                $imagen = "";
            }
            else
            {
                $data_imagen = array('upload_data' => $this->upload->data());
                $imagen = $data_imagen['upload_data']['file_name'];
            }

            $ads_id = $this->ads_model->set_item($this->session->userdata('usr_id'), $data['tipo']['ads_tipo_id'], $this->input->post('nombre'), $this->input->post('titulo'), $this->input->post('texto_largo'), $this->input->post('texto_corto'), $imagen, $this->input->post('link'), 1, $this->input->post('check_'.TP_OFERTA), $this->input->post('check_'.TP_DEMANDA), $this->input->post('check_form'), $this->input->post('mail_form'));
            if($ads_id)
            {
                foreach ($this->input->post('paises[]') as $key => $value)
                {
                    $result = $this->ads_model->set_item_country($ads_id, $value);
                }

                foreach ($this->input->post('aranceles[]') as $key => $value)
                {
                    $result = $this->ads_model->set_item_arancel($ads_id, $value);
                }
                
                if(array_key_exists('imagenes', $_FILES))
                {
                    $filesCount = count($_FILES['imagenes']['name']);
                    for($i = 0; $i < $filesCount; $i++)
                    {
                        $_FILES['file']['name']     = $_FILES['imagenes']['name'][$i];
                        $_FILES['file']['type']     = $_FILES['imagenes']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['imagenes']['tmp_name'][$i];
                        $_FILES['file']['error']    = $_FILES['imagenes']['error'][$i];
                        $_FILES['file']['size']     = $_FILES['imagenes']['size'][$i];
                        
                        if($this->upload->do_upload('file'))
                        {
                            $fileData = $this->upload->data();
                            $result = $this->ads_model->set_item_imagen($ads_id, $fileData['file_name']);
                        }
                    }
                }


                redirect('publicaciones/index/'.$data['tipo']['ads_tipo_id']);
            }
            else
            {
                $data['error'] = "Ocurrio un error al cargar el anuncio";
            }
        }

        $data['aranceles'] = $this->aranceles_model->get_items($this->session->userdata('idi_code'));
        $data['paises'] = $this->paises_model->get_items($this->session->userdata('idi_code'));
        $data['tipos_productos'] = $this->productos_model->get_tipos($this->session->userdata('idi_code'));

        $this->load->view(self::$solapa.'/nueva', $data);
    }

    public function edit($ads_id)
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        $data['item'] = $this->ads_model->get_item($ads_id);
        $data['tipo'] = $this->ads_model->get_tipos($data['item']['ads_tipo_id']);

        $data['titulo'] = $data['tipo']['ads_tipo_nombre'];
        $data['subtitulo'] = $data['palabras'][368]['pal_desc'];
        $data['breadcum'] = array( array('link' => site_url('publicaciones/index/'.$data['tipo']['ads_tipo_id']), 'texto' => $data['tipo']['ads_tipo_nombre']), array('link' => '', 'texto' => $data['palabras'][368]['pal_desc']) );
        
        $data['error'] = FALSE;
        $data['success'] = FALSE;

        $this->form_validation->set_rules('nombre', $data['palabras'][348]['pal_desc'], 'required');
        $this->form_validation->set_rules('titulo', $data['palabras'][349]['pal_desc'], 'required');
        $this->form_validation->set_rules('texto_corto', $data['palabras'][350]['pal_desc'], 'required');
        $this->form_validation->set_rules('texto_largo', $data['palabras'][351]['pal_desc'], 'required');
        $this->form_validation->set_rules('link', $data['palabras'][352]['pal_desc'], 'required');

        if($this->form_validation->run() !== FALSE)
        {
            $config['upload_path']          = '../images/ads/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 2048; //2MB
            $config['max_width']            = 1024;
            $config['max_height']           = 768;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('imagen'))
            {
                $imagen = $this->input->post('imagen_ant');
            }
            else
            {
                $data_imagen = array('upload_data' => $this->upload->data());
                $imagen = $data_imagen['upload_data']['file_name'];
            }

            $result = $this->ads_model->update_item($ads_id, $this->input->post('nombre'), $this->input->post('titulo'), $this->input->post('texto_largo'), $this->input->post('texto_corto'), $imagen, $this->input->post('link'), $this->input->post('check_'.TP_OFERTA), $this->input->post('check_'.TP_DEMANDA), $this->input->post('check_form'), $this->input->post('mail_form'));
            if($result)
            {
                $result = $this->ads_model->delete_item_countrys($ads_id);
                if($this->input->post('paises[]'))
                {
                    foreach ($this->input->post('paises[]') as $key => $value)
                    {
                        $result = $this->ads_model->set_item_country($ads_id, $value);
                    }
                }

                $result = $this->ads_model->delete_item_aranceles($ads_id);
                if($this->input->post('aranceles[]'))
                {
                    foreach ($this->input->post('aranceles[]') as $key => $value)
                    {
                        $result = $this->ads_model->set_item_arancel($ads_id, $value);
                    }
                }

                if($this->input->post('imagenes_borrar[]'))
                {
                    foreach ($this->input->post('imagenes_borrar[]') as $key => $value)
                    {
                        $result = $this->ads_model->delete_imagen($value);
                    }
                }

                if(array_key_exists('imagenes', $_FILES))
                {
                    $filesCount = count($_FILES['imagenes']['name']);
                    for($i = 0; $i < $filesCount; $i++)
                    {
                        $_FILES['file']['name']     = $_FILES['imagenes']['name'][$i];
                        $_FILES['file']['type']     = $_FILES['imagenes']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['imagenes']['tmp_name'][$i];
                        $_FILES['file']['error']    = $_FILES['imagenes']['error'][$i];
                        $_FILES['file']['size']     = $_FILES['imagenes']['size'][$i];
                        
                        if($this->upload->do_upload('file'))
                        {
                            $fileData = $this->upload->data();
                            $result = $this->ads_model->set_item_imagen($ads_id, $fileData['file_name']);
                        }
                    }
                }

                $data['success'] = "Los datos fueron modificados";
            }
            else
            {
                $data['error'] = "Ocurrio un error al actualizar el anuncio";
            }
        }

        $data['item'] = $this->ads_model->get_item($ads_id);
        $data['item']['aranceles'] = $this->ads_model->get_item_aranceles($this->session->userdata('idi_code'), $ads_id);
        $data['item']['paises'] = $this->ads_model->get_item_paises($this->session->userdata('idi_code'), $ads_id);
        $data['item']['imagenes'] = $this->ads_model->get_item_imagenes($ads_id);
        $data['aranceles'] = $this->aranceles_model->get_items($this->session->userdata('idi_code'));
        $data['paises'] = $this->paises_model->get_items($this->session->userdata('idi_code'));
        $data['tipos_productos'] = $this->productos_model->get_tipos($this->session->userdata('idi_code'));

        $this->load->view(self::$solapa.'/edit', $data);
    }

	public function eliminar_ajax()
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        $data['error'] = FALSE;

        if($this->input->post('id') != "")
        {
            $result = $this->ads_model->update_estado($this->input->post('id'), 0);
            if($result)
            {
                $data['data'] = "El item fue eliminado.";
            }
            else
            {
                $data['error'] = TRUE;
                $data['data'] = "Ocurrio un error al eliminar el anuncio.";
            }
        }
        else
        {
            $data['error'] = TRUE;
            $data['data'] = "Debe completar todos los campos.";
        }

        echo json_encode($data);
    }

    public function pausar_ajax()
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        $data['error'] = FALSE;

        if($this->input->post('id') != "" && $this->input->post('estado') != "")
        {
            $result = $this->ads_model->update_estado($this->input->post('id'), $this->input->post('estado'));
            if($result)
            {
                $data['data'] = "El item fue modificado.";
            }
            else
            {
                $data['error'] = TRUE;
                $data['data'] = "Ocurrio un error al eliminar el anuncio.";
            }
        }
        else
        {
            $data['error'] = TRUE;
            $data['data'] = "Debe completar todos los campos.";
        }

        echo json_encode($data);
    }

    public function stats($ads_id = FALSE)
    {
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        $data['item'] = $this->ads_model->get_item($ads_id);
        $data['tipo'] = $this->ads_model->get_tipos($data['item']['ads_tipo_id']);

        $data['titulo'] = $data['tipo']['ads_tipo_nombre'];
        $data['subtitulo'] = "Stats";
        $data['breadcum'] = array( array('link' => site_url('publicaciones/index/'.$data['tipo']['ads_tipo_id']), 'texto' => $data['tipo']['ads_tipo_nombre']), array('link' => '', 'texto' => 'Stats') );

        if($this->input->post('fecha_desde') == FALSE)
        {
            $primer_item = $this->ads_model->get_primer_item($this->session->userdata('usr_id'));
            if($primer_item)
            {
                $data['fecha_desde'] = substr($primer_item['ads_fecha'],0,10);
            }
            else
            {
                $data['fecha_desde'] = date('Y-m-d');
            }
        }
        else
        {
            $data['fecha_desde'] = formatear_fecha($this->input->post('fecha_desde'),1);
        }

        if($this->input->post('fecha_hasta') == FALSE)
        {
            $data['fecha_hasta'] = date('Y-m-d');
        }
        else
        {
            $data['fecha_hasta'] = formatear_fecha($this->input->post('fecha_hasta'),1);
        }

        $datetime1 = new DateTime($data['fecha_desde']);
        $datetime2 = new DateTime($data['fecha_hasta']);
        $interval = $datetime1->diff($datetime2);
        $data['forma'] = 1;
        $aux_forma = 'day';
        $aux_forma2 = 'Y-m-d';

        if($this->input->post('forma') == FALSE)
        {
            if($interval->format('%a') > 600)
            {
                $data['forma'] = 3;
            }
            elseif($interval->format('%a') > 90)
            {
                $data['forma'] = 2;
            }
        }
        else
        {
            $data['forma'] = $this->input->post('forma');
        }

        $data['impresiones_totales'] = $this->ads_model->get_cant_impresiones_entre_fechas($data['fecha_desde'], $data['fecha_hasta'], FALSE, $ads_id);
        $data['clicks_totales'] = $this->ads_model->get_cant_clicks_entre_fechas($data['fecha_desde'], $data['fecha_hasta'], FALSE, $ads_id);
        $data['forms_totales'] = $this->ads_model->get_cant_forms_entre_fechas($data['fecha_desde'], $data['fecha_hasta'], FALSE, $ads_id);

        $data['max'] = 0;
        $meses_array = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $data['meses'] = array();

        if($data['forma'] == 3)
        {
            $diff = $interval->format('%y');
            $aux_forma = 'year';
            $aux_forma2 = 'Y';
            $completar_fecha_ini = '-01-01';
            $completar_fecha_fin = '-12-31';
        }
        elseif($data['forma'] == 2)
        {
            $diff = $interval->format('%m') + ($interval->format('%y') * 12);
            $aux_forma = 'month';
            $aux_forma2 = 'Y-m';
            $completar_fecha_ini = '-01';
            $completar_fecha_fin = '-31';
        }
        else
        {
            $diff = $interval->format('%a');
            $aux_forma = 'day';
            $aux_forma2 = 'Y-m-d';
            $completar_fecha_ini = '';
            $completar_fecha_fin = '';
        }

        for($i=0; $i<=$diff; $i++)
        {
            $nuevafecha = strtotime ( '+'.$i.' '.$aux_forma , strtotime ( $data['fecha_desde'] ) ) ;
            $nuevafecha2 = date ( $aux_forma2 , $nuevafecha );

            $mes = NULL;
            $mes['id'] = $i;
            $mes['mes'] = $nuevafecha2;
            $mes['impresiones'] = $this->ads_model->get_cant_impresiones_entre_fechas($nuevafecha2.$completar_fecha_ini, $nuevafecha2.$completar_fecha_fin, FALSE, $ads_id);
            $mes['clicks'] = $this->ads_model->get_cant_clicks_entre_fechas($nuevafecha2.$completar_fecha_ini, $nuevafecha2.$completar_fecha_fin, FALSE, $ads_id);
            $mes['forms'] = $this->ads_model->get_cant_forms_entre_fechas($nuevafecha2.$completar_fecha_ini, $nuevafecha2.$completar_fecha_fin, FALSE, $ads_id);
            $data['meses'][] = $mes;

            if($mes['impresiones']['cant'] > $data['max'])
            {
                $data['max'] = $mes['impresiones']['cant'];
            }
            
            if($mes['clicks']['cant'] > $data['max'])
            {
                $data['max'] = $mes['clicks']['cant'];
            }

            if($mes['forms']['cant'] > $data['max'])
            {
                $data['max'] = $mes['forms']['cant'];
            }
        }

        $data['paises'] = $this->ads_model->get_paises_entre_fechas($this->session->userdata('idi_code'), formatear_fecha($data['fecha_desde'],1), formatear_fecha($data['fecha_hasta'],1), FALSE, $ads_id);

        $this->load->view(self::$solapa.'/stats', $data);
    }

}
