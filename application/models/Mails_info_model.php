<?php
class Mails_info_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_item($lang = "en", $codigo = FALSE)
    {
        if ($codigo === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM mails_info AS M
                                    WHERE M.idi_code ="'.$lang.'"
                                    AND M.mi_codigo="'.$codigo.'"');
        return $query->row_array();
    }

}