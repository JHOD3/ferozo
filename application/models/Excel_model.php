<?php
class Excel_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items_estado($estado = 0)
    {
        $query = $this->db->query("SELECT E.*
                                    FROM excel AS E
                                    INNER JOIN Aranceles AS A ON E.ara_id = A.ara_id
                                    WHERE E.exc_estado=".$estado."
                                    AND E.ara_id > 0
                                    ORDER BY RAND()
                                    LIMIT 50");

        return $query->result_array();
    }

    public function get_items_mesclados()
    {
        $query = $this->db->query("SELECT DISTINCT E.ara_id, E.exc_pais, E.exc_id, E.exc_fuente, E.tp_id, E.exc_ciudad, E.exc_descripcion, E.exc_mail
                                    FROM excel AS E
                                    INNER JOIN Aranceles AS A ON E.ara_id = A.ara_id
                                    WHERE E.exc_estado=0
                                    AND E.ara_id > 0
                                    LIMIT 50");

        return $query->result_array();
    }

    public function get_items_arancel($ara_id = 0)
    {
        $query = $this->db->query("SELECT *
                                    FROM excel AS E
                                    WHERE E.exc_estado=0
                                    AND E.ara_id=".$ara_id."
                                    LIMIT 50");

        return $query->result_array();
    }

    public function update_estado($exc_id, $estado)
    {
        $data = array(
            'exc_estado' => $estado
        );

        $this->db->where(array('exc_id'=>$exc_id));
        return $this->db->update('excel', $data);
    }
}