<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    private static $solapa = "pages";

	public function __construct()
    {
        parent::__construct();
        $this->load->model('ads_model');
        $this->load->model('palabras_model');
    }

	public function index()
	{
        $data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

        $data['titulo'] = $data['palabras'][363]['pal_desc'];
        $data['subtitulo'] = "";
        $data['breadcum'] = array( array('link' => 'javascript:;', 'texto' => 'Inicio') );
        
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

        $data['impresiones_totales'] = $this->ads_model->get_cant_impresiones_entre_fechas($data['fecha_desde'], $data['fecha_hasta'], $this->session->userdata('usr_id'));
        $data['clicks_totales'] = $this->ads_model->get_cant_clicks_entre_fechas($data['fecha_desde'], $data['fecha_hasta'], $this->session->userdata('usr_id'));
        $data['forms_totales'] = $this->ads_model->get_cant_forms_entre_fechas($data['fecha_desde'], $data['fecha_hasta'], $this->session->userdata('usr_id'));

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
            $mes['impresiones'] = $this->ads_model->get_cant_impresiones_entre_fechas($nuevafecha2.$completar_fecha_ini, $nuevafecha2.$completar_fecha_fin, $this->session->userdata('usr_id'));
            $mes['clicks'] = $this->ads_model->get_cant_clicks_entre_fechas($nuevafecha2.$completar_fecha_ini, $nuevafecha2.$completar_fecha_fin, $this->session->userdata('usr_id'));
            $mes['forms'] = $this->ads_model->get_cant_forms_entre_fechas($nuevafecha2.$completar_fecha_ini, $nuevafecha2.$completar_fecha_fin, $this->session->userdata('usr_id'));
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

        $data['paises'] = $this->ads_model->get_paises_entre_fechas($this->session->userdata('idi_code'), formatear_fecha($data['fecha_desde'],1), formatear_fecha($data['fecha_hasta'],1), $this->session->userdata('usr_id'));
        
        $this->load->view(self::$solapa.'/index', $data);
	}
	
}
