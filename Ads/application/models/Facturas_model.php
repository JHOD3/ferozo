<?php
class Facturas_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->query('SELECT *
                                        FROM facturas AS F
                                        INNER JOIN usuarios AS U ON F.usr_id = U.usr_id');
            return $query->result_array();
        }

        $query = $this->db->query('SELECT *
                                    FROM facturas AS F
                                    WHERE F.fac_id ='.$id);
        return $query->row_array();
    }

    public function get_items_usuario($id = FALSE)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM facturas
                                    WHERE usr_id ='.$id);
        return $query->result_array();
    }

    public function get_subitems_usuario_sin_pagar($id = FALSE)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT F.*, FI.*
                                    FROM facturas AS F
                                    INNER JOIN factura_items AS FI ON F.fac_id = FI.fac_id
                                    WHERE usr_id ='.$id.'
                                    AND FI.rec_id IS NULL');
        return $query->result_array();
    }

    public function get_total_adeudado()
    {
        $query = $this->db->query('SELECT SUM(FI.faci_total) as sum
                                    FROM factura_items AS FI
                                    WHERE FI.rec_id IS NULL');
        $result = $query->row_array();
        if(!$result || $result['sum'] == "")
        {
            $result['sum'] = 0;
        }
        return $result;
    }

    public function get_usuarios_con_deuda()
    {
        $query = $this->db->query('SELECT SUM(FI.faci_total) as sum, U.usr_id, U.usr_apellido, U.usr_nombre, U.usr_dni
                                    FROM facturas AS F
                                    INNER JOIN factura_items AS FI ON F.fac_id = FI.fac_id
                                    INNER JOIN usuarios AS U ON F.usr_id = U.usr_id
                                    WHERE FI.rec_id IS NULL
                                    GROUP BY U.usr_id');
        return $query->result_array();
    }

    public function get_total_usuario($id = FALSE)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT SUM(F.fac_subtotal) as subtotal, SUM(F.fac_bonif) as bonif, SUM(F.fac_total) as total
                                    FROM facturas AS F
                                    WHERE F.usr_id ='.$id);
        $result = $query->row_array();
        if(!$result || $result['total'] == "")
        {
            $result = array('subtotal' => 0, 'bonif' => 0, 'total' => 0);
        }
        return $result;
    }

    public function set_item($usr_id, $fac_fecha, $fac_condicion, $fac_subtotal, $fac_bonif, $fac_total)
    {
        $data = array(
            'fac_id' => NULL,
            'usr_id' => $usr_id,
            'fac_fecha' => $fac_fecha,
            'fac_condicion' => $fac_condicion,
            'fac_subtotal' => $fac_subtotal,
            'fac_bonif' => $fac_bonif,
            'fac_total' => $fac_total
        );

        $this->db->insert('facturas', $data);
        return $this->db->insert_id();
    }

    public function set_subitem($fac_id, $rec_id, $val_id,  $faci_descripcion, $faci_subtotal, $faci_bonif, $faci_total)
    {
        $data = array(
            'faci_id' => NULL,
            'fac_id' => $fac_id,
            'rec_id' => $rec_id,
            'val_id' => $val_id,
            'faci_descripcion' => $faci_descripcion,
            'faci_subtotal' => $faci_subtotal,
            'faci_bonif' => $faci_bonif,
            'faci_total' => $faci_total
        );

        $this->db->insert('factura_items', $data);
        return $this->db->insert_id();
    }
    
    public function update_subitem($faci_id, $rec_id)
    {
        $data = array(
            'rec_id' => $rec_id
        );

        $this->db->where('faci_id',$faci_id);
        return $this->db->update('factura_items', $data);
    }
    
    public function delete_item($fac_id)
    {
        if($fac_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where('fac_id',$fac_id);
        $this->db->delete('factura_items');

        $this->db->where('fac_id',$fac_id);
        return $this->db->delete('facturas');
    }

}