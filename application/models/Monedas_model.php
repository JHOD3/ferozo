<?php
class Paises_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($lang = "en", $id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->query("SELECT C.ctry_code, C.ctry_nombre_".$lang." as ctry_nombre, C.ctry_code3, C.geonameId
                                        FROM Country AS C
                                        ORDER BY C.ctry_nombre_".$lang);
            return $query->result_array();
        }

        $query = $this->db->query("SELECT C.ctry_code, C.ctry_nombre_".$lang." as ctry_nombre, C.ctry_code3, C.geonameId
                                    FROM Country AS C
                                    WHERE C.ctry_code='".$id."'");
        return $query->row_array();
    }

    public function get_item_code2($lang = "en", $id = FALSE)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT C.ctry_code, C.ctry_nombre_".$lang." as ctry_nombre, C.ctry_code3, C.geonameId
                                    FROM Country AS C
                                    WHERE C.ctry_code2='".$id."'");
        return $query->row_array();
    }

    public function get_provincias_ciudad($lang = "en", $id = FALSE)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT C.city_id, C.city_countryCode, C.toponymName, C.city_nombre_".$lang." as city_nombre
                                    FROM City AS C
                                    WHERE C.city_countryCode='".$id."'
                                    ORDER BY C.city_nombre_".$lang);
        return $query->result_array();
    }

    public function get_next($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->query("SELECT C.ctry_code, C.ctry_code3
                                        FROM Country AS C
                                        ORDER BY C.ctry_code3 ASC
                                        LIMIT 1");
            return $query->row_array();
        }

        $query = $this->db->query("SELECT C.ctry_code, C.ctry_code3
                                    FROM Country AS C
                                    WHERE C.ctry_code3 > ".$id."
                                    ORDER BY C.ctry_code3 ASC
                                    LIMIT 1");
        return $query->row_array();
    }

    public function buscar_items($lang = "es", $nombre = "")
    {
        $query = $this->db->query("SELECT C.ctry_code, C.ctry_nombre_".$lang." as ctry_nombre, C.ctry_code3, C.idi_code
                                    FROM Country AS C
                                    WHERE C.ctry_nombre_".$lang." LIKE '%".$nombre."%'
                                    LIMIT 1");
        return $query->row_array();
    }

    public function buscar_provincia_ciudad($lang = "en", $ctry_code = FALSE, $nombre = "")
    {
        if($ctry_code == FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT C.city_id, C.city_countryCode, C.city_nombre_".$lang." as city_nombre
                                    FROM City AS C
                                    WHERE C.city_nombre_".$lang." LIKE '%".$nombre."%'
                                    LIMIT 1");
        return $query->row_array();
    }

    public function buscar_alguna_provincia($lang = "en", $id = FALSE)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT C.city_id, C.city_countryCode, C.city_nombre_".$lang." as city_nombre
                                    FROM City AS C
                                    WHERE C.city_countryCode='".$id."'
                                    ORDER BY C.city_id
                                    LIMIT 1");
        return $query->row_array();
    }

    public function get_last_city()
    {
        $query = $this->db->query("SELECT *
                                    FROM ciudades AS C
                                    ORDER BY C.city_id DESC
                                    LIMIT 1");
        return $query->row_array();
    }

    public function get_first_country()
    {
        $query = $this->db->query("SELECT *
                                    FROM Country AS C
                                    ORDER BY C.ctry_code
                                    LIMIT 1");
        return $query->row_array();
    }

    public function get_next_country($id)
    {
        $query = $this->db->query("SELECT *
                                    FROM Country AS C
                                    WHERE C.ctry_code > '".$id."'
                                    ORDER BY C.ctry_code
                                    LIMIT 1");
        return $query->row_array();
    }

}
