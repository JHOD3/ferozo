<?php
class Faq_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($lang = "en", $id = FALSE)
    {
        if($id === FALSE)
        {
            $query = $this->db->query('SELECT *
                                        FROM faq AS F
                                        WHERE F.idi_code ="'.$lang.'"
                                        ORDER BY F.faq_orden, F.faq_numero');
            return $query->result_array();
        }

        $query = $this->db->query('SELECT *
                                    FROM faq AS F
                                    WHERE F.idi_code ="'.$lang.'"
                                    AND F.faq_id ='.$id);
        return $query->row_array();
    }

}