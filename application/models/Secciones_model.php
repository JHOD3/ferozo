<?php
class Secciones_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($lang = "en", $id = FALSE)
    {
    	if ($id === FALSE)
    	{
    	    $query = $this->db->query("SELECT S.sec_id, S.sec_code, S.sec_desc_".$lang." as sec_desc
                                        FROM Secciones AS S");
    		return $query->result_array();
    	}

    	$query = $this->db->query("SELECT S.sec_id, S.sec_code, S.sec_desc_".$lang." as sec_desc
                                    FROM Secciones AS S
                                    WHERE S.sec_id='".$id."'");
    	return $query->row_array();
    }

}