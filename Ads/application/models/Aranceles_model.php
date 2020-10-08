<?php
class Aranceles_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($lang = "en", $id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->query("SELECT A.ara_id, A.ara_code, A.cat_id, A.ara_desc_".$lang." as ara_desc
                                        FROM Aranceles AS A");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT A.ara_id, A.ara_code, A.cat_id, A.ara_desc_".$lang." as ara_desc
                                    FROM Aranceles AS A
                                    WHERE A.ara_id='".$id."'");
        return $query->row_array();
    }

    public function buscar_items($lang = "en", $buscar = "")
    {
        $query = $this->db->query("SELECT A.ara_id, A.ara_code, A.cat_id, A.ara_desc_".$lang." as ara_desc
                                    FROM Aranceles AS A
                                    WHERE A.ara_desc_".$lang." LIKE '%".$buscar."%'
                                    OR A.ara_id LIKE '%".$buscar."%'
                                    OR A.ara_code LIKE '%".$buscar."%'");
        return $query->result_array();
    }

    public function get_next($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->query("SELECT A.ara_id
                                        FROM Aranceles AS A
                                        ORDER BY A.ara_id ASC
                                        LIMIT 1");
            return $query->row_array();
        }

        $query = $this->db->query("SELECT A.ara_id
                                    FROM Aranceles AS A
                                    WHERE A.ara_id > ".$id."
                                    ORDER BY A.ara_id ASC
                                    LIMIT 1");
        return $query->row_array();
    }

    public function get_items_categoria($lang = "en", $id = FALSE)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT A.ara_id, A.ara_code, A.cat_id, A.ara_desc_".$lang." as ara_desc
                                    FROM Aranceles AS A
                                    WHERE A.cat_id='".$id."'");
        return $query->result_array();
    }

    public function get_items_seccion($lang = "en", $id = FALSE)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT A.ara_id, A.ara_code, A.cat_id, A.ara_desc_".$lang." as ara_desc
                                    FROM Aranceles AS A
                                    INNER JOIN Categorias AS C ON A.cat_id = C.cat_id
                                    WHERE C.sec_id=".$id);
        return $query->result_array();
    }

    public function get_principales_pais($lang = "es", $ctry_code = FALSE, $tp_id = 1)
    {
        $where_array = null;

        if($ctry_code !== FALSE)
        {
            $where_array[] = "P.ctry_code='".$ctry_code."'";
        }

        $where_array[] = "P.tp_id=".$tp_id;

        $where = implode(' AND ',$where_array);
        $query = $this->db->query("SELECT A.ara_id, A.ara_code, A.ara_desc_".$lang." as ara_desc, COUNT(P.prod_id) as cant
                                    FROM Productos AS P
                                    INNER JOIN Categorias AS C ON P.cat_id = C.cat_id
                                    INNER JOIN Aranceles AS A ON P.ara_id = A.ara_id
                                    WHERE $where
                                    GROUP BY A.ara_id
                                    ORDER BY cant DESC
                                    LIMIT 5");

        return $query->result_array();
    }

    public function get_principales_resto($lang = "es", $ctry_code = FALSE, $tp_id = 1)
    {
        $where_array = null;

        if($ctry_code !== FALSE)
        {
            $where_array[] = "P.ctry_code<>'".$ctry_code."'";
        }

        $where_array[] = "P.tp_id=".$tp_id;

        $where = implode(' AND ',$where_array);
        $query = $this->db->query("SELECT A.ara_id, A.ara_code, A.ara_desc_".$lang." as ara_desc, COUNT(P.prod_id) as cant
                                    FROM Productos AS P
                                    INNER JOIN Categorias AS C ON P.cat_id = C.cat_id
                                    INNER JOIN Aranceles AS A ON P.ara_id = A.ara_id
                                    WHERE $where
                                    GROUP BY A.ara_id
                                    ORDER BY cant DESC
                                    LIMIT 5");

        return $query->result_array();
    }

    public function get_principales_pais_comtrade($lang = "es", $ctry_origen = FALSE, $ctry_destino = FALSE, $tp_id = 1)
    {
        $where_array = null;

        if($ctry_origen !== FALSE)
        {
            $where_array[] = "P.com_origen='".$ctry_origen."'";
        }

        if($ctry_destino !== FALSE)
        {
            $where_array[] = "P.com_destino='".$ctry_destino."'";
        }

        $where_array[] = "P.com_tipo=".$tp_id;

        $where_array[] = "(P.com_cantidad IS NOT NULL OR P.com_valor IS NOT NULL)";

        $where = implode(' AND ',$where_array);
        $query = $this->db->query("SELECT A.ara_id, A.ara_code, A.ara_desc_".$lang." as ara_desc
                                    FROM Comtrade AS P
                                    INNER JOIN Aranceles AS A ON P.com_arancel = A.ara_id
                                    WHERE $where
                                    ORDER BY P.com_valor DESC
                                    LIMIT 5");

        return $query->result_array();
    }

    public function get_pais_comtrade($lang = "es", $ctry_origen = FALSE, $ctry_destino = FALSE, $tp_id = 1)
    {
        $where_array = null;

        if($ctry_origen !== FALSE)
        {
            $where_array[] = "P.com_origen='".$ctry_origen."'";
        }

        if($ctry_destino !== FALSE)
        {
            $where_array[] = "P.com_destino='".$ctry_destino."'";
        }

        $where_array[] = "P.com_tipo=".$tp_id;

        $where_array[] = "(P.com_cantidad IS NOT NULL OR P.com_valor IS NOT NULL)";

        $where = implode(' AND ',$where_array);
        $query = $this->db->query("SELECT A.ara_id, A.ara_code, A.ara_desc_".$lang." as ara_desc,
                                    P.com_cantidad, P.com_valor
                                    FROM Comtrade AS P
                                    INNER JOIN Aranceles AS A ON P.com_arancel = A.ara_id
                                    WHERE $where
                                    ORDER BY P.com_valor DESC");

        return $query->result_array();
    }

}