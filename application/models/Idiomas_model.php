<?php
class Idiomas_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($lang = "en", $id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->query("SELECT I.idi_code, I.idi_desc_".$lang." as idi_desc
                                    FROM Idiomas AS I
                                    ORDER BY I.idi_desc_".$lang." ASC");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT I.idi_code, I.idi_desc_".$lang." as idi_desc
                                    FROM Idiomas AS I
                                    WHERE I.idi_code ='".$id."'");
        return $query->row_array();
    }

    public function get_items_completos()
    {
        $query = $this->db->query("SELECT *
                                FROM Idiomas AS I
                                ORDER BY I.idi_code ASC");
        return $query->result_array();
    }

    public function get_first()
    {
        $query = $this->db->query("SELECT *
                                    FROM Idiomas AS I
                                    ORDER BY I.idi_code
                                    LIMIT 1");
        return $query->row_array();
    }

    public function get_next($id)
    {
        $query = $this->db->query("SELECT *
                                    FROM Idiomas AS I
                                    WHERE I.idi_code > '".$id."'
                                    ORDER BY I.idi_code
                                    LIMIT 1");
        return $query->row_array();
    }

}