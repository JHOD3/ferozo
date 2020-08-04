<?php
class Politicas_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($lang = "en", $id = FALSE)
    {
    	if ($id === FALSE)
    	{
    	    $query = $this->db->query("SELECT *
                                        FROM politicas AS P
                                        WHERE P.idi_code='".$lang."'");
    		return $query->result_array();
    	}

    	$query = $this->db->query("SELECT *
                                    FROM politicas AS P
                                    WHERE P.idi_code='".$lang."'
                                    AND P.pol_tipo_id=".$id);
    	return $query->row_array();
    }

}