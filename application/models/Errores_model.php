<?php
class Errores_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items()
    {
        $query = $this->db->query("SELECT *
                                    FROM errores AS E
                                    INNER JOIN errores_tipos AS ET ON E.err_tipo_id = ET.err_tipo_id");
        return $query->result_array();
    }

    public function get_tipos($id = FALSE)
    {
        if($id === FALSE)
        {
            $query = $this->db->query("SELECT *
                                        FROM errores_tipos AS ET
                                        ORDER BY ET.err_tipo_id");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT *
                                    FROM errores_tipos AS ET
                                    WHERE ET.err_tipo_id=".$id);
        return $query->row_array();
    }

    public function set_item($err_tipo_id, $err_descripcion, $usr_id = NULL, $extra_id = NULL, $idi_code = NULL)
    {
        if($usr_id == "")
        {
            $usr_id = NULL;
        }
        if($extra_id == "")
        {
            $extra_id = NULL;
        }
        if($idi_code == "")
        {
            $idi_code = NULL;
        }

        $data = array(
            'err_id' => NULL,
            'err_tipo_id' => $err_tipo_id,
            'err_descripcion' => $err_descripcion,
            'err_fecha' => date('Y-m-d H:i:s'),
            'usr_id' => $usr_id,
            'extra_id' => $extra_id,
            'idi_code' => $idi_code
        );

        $this->db->insert('errores', $data);
        return $this->db->insert_id();
    }

}