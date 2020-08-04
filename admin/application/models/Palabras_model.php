<?php
class Palabras_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($lang = "en", $id = FALSE)
    {
    	if ($id === FALSE)
    	{
    	    $query = $this->db->query("SELECT P.pal_id, P.pal_desc_".$lang." as pal_desc
                                        FROM palabras AS P");
    		return $query->result_array();
    	}

    	$query = $this->db->query("SELECT P.pal_id, P.pal_desc_".$lang." as pal_desc
                                    FROM palabras AS P
                                    WHERE P.pal_id = ".$id);
    	return $query->row_array();
    }

}