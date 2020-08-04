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

    public function get_items_especificos($lang = "en", $ids = FALSE)
    {
        if ($ids === FALSE)
        {
            return FALSE;
        }

        //////// GRABO LAS PALABRAS USADAS ///////
        $data_insert = array();

        foreach ($ids as $key => $id)
        {
            $aux = array(
                    'pal_us_id' => NULL,
                    'pal_id' => $id,
                    'pal_us_fecha' => date('Y-m-d H:i:s'),
                    'pal_us_link' => $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
            );
            $data_insert[] = $aux;
        }

        $this->db->insert_batch('palabras_usadas', $data_insert);
        ///////////////////////////////////////////

        $query = $this->db->query("SELECT P.pal_id, P.pal_desc_".$lang." as pal_desc
                                    FROM palabras AS P
                                    WHERE P.pal_id IN (".join(',', $ids).")");
        return $query->result_array();
    }

}