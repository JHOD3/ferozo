<?php
class Tipo_datos_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($lang = "en", $id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->query("SELECT TD.td_id, TD.td_icono, TD.td_placeholder, TD.td_desc_".$lang." as td_desc, TD.td_desc_es
                                    FROM Tipo_Datos AS TD");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT TD.td_id, TD.td_icono, TD.td_placeholder, TD.td_desc_".$lang." as td_desc, TD.td_desc_es
                                    FROM Tipo_Datos AS TD
                                    WHERE TD.td_id =".$id);
        return $query->row_array();
    }

    public function get_categorias($lang = "en", $td_id = FALSE)
    {
        if ($td_id === FALSE)
        {
            $query = $this->db->query("SELECT CTD.ctd_id, CTD.td_id, CTD.ctd_desc_".$lang." as ctd_desc, CTD.ctd_desc_es
                                    FROM Categoria_Tipo_Dato AS CTD");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT CTD.ctd_id, CTD.td_id, CTD.ctd_desc_".$lang." as ctd_desc, CTD.ctd_desc_es
                                    FROM Categoria_Tipo_Dato AS CTD
                                    WHERE CTD.td_id =".$td_id);
        return $query->result_array();
    }

}