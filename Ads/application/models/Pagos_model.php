<?php
class Pagos_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($id = FALSE)
    {
        if($id === FALSE)
        {
            $query = $this->db->query("SELECT *
                                        FROM pagos AS P");

            return $query->result_array();
        }

        $query = $this->db->query("SELECT *
                                    FROM pagos AS P
                                    WHERE P.pago_id=".$id);

        return $query->row_array();
    }

    public function get_items_usuario($usr_id = FALSE, $pago_id = FALSE)
    {
        if($usr_id === FALSE)
        {
            return FALSE;
        }

        if($pago_id === FALSE)
        {
            $query = $this->db->query("SELECT P.*,
                                        (SELECT PE.pago_est_descripcion FROM pagos_estados AS PE INNER JOIN pagos_actualizaciones AS PA ON PA.pago_est_id = PE.pago_est_id WHERE P.pago_id = PA.pago_id ORDER BY PA.pago_act_fecha DESC LIMIT 1) as pago_est_descripcion
                                        FROM pagos AS P
                                        WHERE P.usr_id=".$usr_id);

            return $query->result_array();
        }

        $query = $this->db->query("SELECT P.*,
                                    (SELECT PE.pago_est_descripcion FROM pagos_estados AS PE INNER JOIN pagos_actualizaciones AS PA ON PA.pago_est_id = PE.pago_est_id WHERE P.pago_id = PA.pago_id ORDER BY PA.pago_act_fecha DESC LIMIT 1) as pago_est_descripcion
                                    FROM pagos AS P
                                    WHERE P.pago_id = ".$pago_id."
                                    AND P.usr_id=".$usr_id);

        return $query->row_array();
    }

    public function get_transaction($id = FALSE)
    {
        if($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM pagos AS P
                                    WHERE P.pago_codigo='".$id."'");

        return $query->row_array();
    }

    public function get_credito_cargado($usr_id = FALSE)
    {
        if($usr_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT SUM(P.pago_cantidad) as cant
                                    FROM pagos AS P
                                    WHERE P.usr_id=".$usr_id."
                                    AND P.pago_destino=".PAGO_DESTINO_ADS."
                                    AND (SELECT PA.pago_est_id 
                                            FROM pagos_actualizaciones AS PA 
                                            WHERE PA.pago_id = P.pago_id
                                            ORDER BY PA.pago_act_fecha DESC 
                                            LIMIT 1) = ".PAGO_APROBADO);

        $result = $query->row_array();
        if(!$result || !$result['cant'])
        {
            $result['cant'] = 0;
        }

        return $result;
    }

    public function get_credito_restante($usr_id = FALSE)
    {
        if($usr_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM usuarios_ads_saldo AS P
                                    WHERE P.usr_id=".$usr_id."");

        $result = $query->row_array();
        if(!$result || !$result['saldo'])
        {
            $result['saldo'] = 0;
        }

        return $result;
    }

    public function get_ultima_suscripcion_activa($usr_id = FALSE)
    {
        if($usr_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM pagos_suscripciones AS PS
                                    INNER JOIN pagos AS P ON PS.pago_id = P.pago_id
                                    WHERE P.usr_id=".$usr_id."
                                    AND PS.pago_sus_estado = 1
                                    ORDER BY PS.pago_sus_fecha_fin DESC
                                    LIMIT 1");

        return $query->row_array();
    }

    public function set_item($usr_id, $pago_cantidad, $pago_metodo, $pago_codigo, $pago_destino=1)
    {
        $data = array(
            'pago_id' => NULL,
            'usr_id' => $usr_id,
            'pago_cantidad' => $pago_cantidad,
            'pago_metodo' => $pago_metodo,
            'pago_codigo' => $pago_codigo,
            'pago_fecha' => date('Y-m-d H:i:s'),
            'pago_destino' => $pago_destino
        );

        $this->db->insert('pagos', $data);
        return $this->db->insert_id();
    }

    public function set_actualizacion($pago_id, $pago_est_id)
    {
        $data = array(
            'pago_act_id' => NULL,
            'pago_id' => $pago_id,
            'pago_est_id' => $pago_est_id,
            'pago_act_fecha' => date('Y-m-d H:i:s')
        );

        $this->db->insert('pagos_actualizaciones', $data);
        return $this->db->insert_id();
    }

    public function set_suscripcion($pago_id, $meses=1, $pago_estado=1)
    {
        $fecha_ini = date('Y-m-d');
        $fecha_fin = date('Y-m-d');
        if($meses > 0)
        {
            $nuevafecha = strtotime ( '+'.$meses.' month' , strtotime ( $fecha_ini ) ) ;
            $fecha_fin = date ( 'Y-m-d' , $nuevafecha );
        }
        else
        {
            $pago_estado = 0;
        }

        $data = array(
            'pago_sus_id' => NULL,
            'pago_id' => $pago_id,
            'pago_sus_fecha_ini' => $fecha_ini,
            'pago_sus_fecha_fin' => $fecha_fin,
            'pago_sus_estado' => $pago_estado
        );

        $this->db->insert('pagos_suscripciones', $data);
        return $this->db->insert_id();
    }

    public function update_item($prod_id, $usr_id, $sec_id, $cat_id, $ara_id, $prod_descripcion, $ctry_code, $city_code)
    {
        $data = array(
            'ara_id' => $ara_id,
            'prod_nombre' => "",
            'prod_descripcion' => $prod_descripcion,
            'ctry_code' => $ctry_code,
            'city_id' => $city_code
        );

        $this->db->where(array('prod_id'=>$prod_id, 'usr_id'=>$usr_id));
        return $this->db->update('pagos', $data);
    }

    /*************************
    FACTURAS
    *************************/

    public function get_facturas_usuario($usr_id = FALSE, $fac_id = FALSE)
    {
        if($usr_id === FALSE)
        {
            return FALSE;
        }

        if($fac_id === FALSE)
        {
            $query = $this->db->query("SELECT *
                                        FROM facturas AS F
                                        WHERE F.usr_id=".$usr_id);

            return $query->result_array();
        }

        $query = $this->db->query("SELECT *
                                    FROM facturas AS F
                                    WHERE F.fac_id = ".$fac_id."
                                    AND F.usr_id=".$usr_id);

        return $query->row_array();
    }

}