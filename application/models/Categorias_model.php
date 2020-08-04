<?php
class Categorias_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($lang = "en", $id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->query("SELECT C.cat_id, C.cat_code, C.sec_id, C.cat_desc_".$lang." as cat_desc
                                        FROM Categorias AS C");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT C.cat_id, C.cat_code, C.sec_id, C.cat_desc_".$lang." as cat_desc
                                    FROM Categorias AS C
                                    WHERE C.cat_id='".$id."'");
        return $query->row_array();
    }

    public function get_items_seccion($lang = "en", $id = FALSE)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT C.cat_id, C.cat_code, C.sec_id, C.cat_desc_".$lang." as cat_desc
                                    FROM Categorias AS C
                                    WHERE C.sec_id='".$id."'");
        return $query->result_array();
    }

}