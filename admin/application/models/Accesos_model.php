<?php
class Accesos_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items_x_fecha($fecha_ini = FALSE, $fecha_fin = FALSE)
    {
        if ($fecha_ini === FALSE)
        {
            return FALSE;
        }

        if ($fecha_fin === FALSE)
        {
            $query = $this->db->query('SELECT COUNT(1) as cant
                                        FROM accesos AS A
                                        WHERE A.acc_fecha >= "'.$fecha_ini.'"
                                        GROUP BY A.acc_session');
            return $query->row_array();
        }

        $query = $this->db->query('SELECT COUNT(1) as cant
                                    FROM usuarios AS A
                                    WHERE A.acc_fecha >= "'.$fecha_ini.'"
                                    AND A.acc_fecha < "'.$fecha_fin.'"
                                    GROUP BY A.acc_session');
        return $query->row_array();
    }

}