<?php
class Comtrade_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_last()
    {
        $query = $this->db->query("SELECT *
                                    FROM Comtrade AS C
                                    ORDER BY C.com_id DESC
                                    LIMIT 1");
        return $query->row_array();
    }

    public function get_item_max($lang, $ara_id, $com_origen, $com_destino, $tipo)
    {
        $query = $this->db->query("SELECT C.com_anio, C.com_cantidad, C.com_valor,
                                    A.ara_code, A.ara_desc_".$lang." as ara_desc,
                                    Ctry.ctry_nombre_".$lang." as ctry_nombre_origen,
                                    Ctry2.ctry_nombre_".$lang." as ctry_nombre_destino
                                    FROM comtrade2 AS C
                                    INNER JOIN Aranceles AS A ON C.ara_id = A.ara_id
                                    LEFT JOIN Country AS Ctry ON C.ctry_code_origen = Ctry.ctry_code
                                    LEFT JOIN Country AS Ctry2 ON C.ctry_code_destino = Ctry2.ctry_code
                                    WHERE C.ara_id=".$ara_id."
                                    AND C.ctry_code_origen='".$com_origen."'
                                    AND C.ctry_code_destino='".$com_destino."'
                                    AND C.com_tipo=".$tipo."
                                    ORDER BY C.com_anio DESC
                                    LIMIT 1");
        return $query->row_array();
    }

    public function get_item_min($lang, $ara_id, $com_origen, $com_destino, $tipo)
    {
        $query = $this->db->query("SELECT C.com_anio, C.com_cantidad, C.com_valor,
                                    A.ara_code, A.ara_desc_".$lang." as ara_desc,
                                    Ctry.ctry_nombre_".$lang." as ctry_nombre_origen,
                                    Ctry2.ctry_nombre_".$lang." as ctry_nombre_destino
                                    FROM comtrade2 AS C
                                    INNER JOIN Aranceles AS A ON C.ara_id = A.ara_id
                                    LEFT JOIN Country AS Ctry ON C.ctry_code_origen = Ctry.ctry_code
                                    LEFT JOIN Country AS Ctry2 ON C.ctry_code_destino = Ctry2.ctry_code
                                    WHERE C.ara_id='".$ara_id."'
                                    AND C.ctry_code_origen='".$com_origen."'
                                    AND C.ctry_code_destino='".$com_destino."'
                                    AND C.com_tipo=".$tipo."
                                    ORDER BY C.com_anio ASC
                                    LIMIT 1");
        return $query->row_array();
    }

    public function get_item_crecimiento($lang, $ara_id, $com_origen, $com_destino, $tipo)
    {
        $query = $this->db->query("SELECT C.*,
                                    A.ara_code, A.ara_desc_".$lang." as ara_desc,
                                    Ctry.ctry_nombre_".$lang." as ctry_nombre_origen,
                                    Ctry2.ctry_nombre_".$lang." as ctry_nombre_destino
                                    FROM comtrade_crecimiento AS C
                                    INNER JOIN Aranceles AS A ON C.ara_id = A.ara_id
                                    LEFT JOIN Country AS Ctry ON C.ctry_code_origen = Ctry.ctry_code
                                    LEFT JOIN Country AS Ctry2 ON C.ctry_code_destino = Ctry2.ctry_code
                                    WHERE C.ara_id=".$ara_id."
                                    AND C.ctry_code_origen='".$com_origen."'
                                    AND C.ctry_code_destino='".$com_destino."'
                                    AND C.comc_tipo=".$tipo."
                                    LIMIT 1");
        return $query->row_array();
    }

    public function get_principales_pais_crecimiento($lang = "es", $ctry_origen = FALSE, $ctry_destino = FALSE, $tp_id = 1)
    {
        $where_array = null;

        if($ctry_origen !== FALSE)
        {
            $where_array[] = "CC.ctry_code_origen='".$ctry_origen."'";
        }

        if($ctry_destino !== FALSE)
        {
            $where_array[] = "CC.ctry_code_destino='".$ctry_destino."'";
        }

        $where_array[] = "CC.comc_tipo=".$tp_id;
        $where_array[] = "CC.comc_valor_ini>1000";

        $where = implode(' AND ',$where_array);

        $query = $this->db->query("SELECT A.ara_id, A.ara_code, A.ara_desc_".$lang." as ara_desc
                                    FROM comtrade_crecimiento AS CC
                                    INNER JOIN Aranceles AS A ON CC.ara_id = A.ara_id
                                    WHERE $where
                                    ORDER BY CC.comc_porcentaje DESC
                                    LIMIT 5");

        return $query->result_array();
    }

    public function get_pais_crecimiento($lang = "es", $ctry_origen = FALSE, $ctry_destino = FALSE, $tp_id = 1, $offset = 0, $limit = 10)
    {
        $where_array = null;

        if($ctry_origen !== FALSE)
        {
            $where_array[] = "CC.ctry_code_origen='".$ctry_origen."'";
        }

        if($ctry_destino !== FALSE)
        {
            $where_array[] = "CC.ctry_code_destino='".$ctry_destino."'";
        }

        $where_array[] = "CC.comc_tipo=".$tp_id;
        $where_array[] = "CC.comc_valor_ini>1000";

        $where = implode(' AND ',$where_array);

        $query = $this->db->query("SELECT A.ara_id, A.ara_code, A.ara_desc_".$lang." as ara_desc, 
                                    CC.comc_anio_fin, CC.comc_valor_fin, CC.comc_anio_ini, CC.comc_valor_ini, CC.comc_porcentaje
                                    FROM comtrade_crecimiento AS CC
                                    INNER JOIN Aranceles AS A ON CC.ara_id = A.ara_id
                                    WHERE $where
                                    ORDER BY CC.comc_porcentaje DESC
                                    LIMIT ".$limit."
                                    OFFSET ".$offset);

        return $query->result_array();
    }

    public function get_pais_comtrade($lang = "es", $ctry_origen = FALSE, $ctry_destino = FALSE, $tp_id = 1)
    {
        $where_array = null;

        if($ctry_origen !== FALSE)
        {
            $where_array[] = "P.ctry_code_origen='".$ctry_origen."'";
        }

        if($ctry_destino !== FALSE)
        {
            $where_array[] = "P.ctry_code_destino='".$ctry_destino."'";
        }

        $where_array[] = "P.com_tipo=".$tp_id;

        //$where_array[] = "(P.com_cantidad IS NOT NULL OR P.com_valor IS NOT NULL)";
        $where_array[] = "P.com_valor > 0";

        $where = implode(' AND ',$where_array);

        $query = $this->db->query("SELECT A.ara_id, A.ara_code, A.ara_desc_".$lang." as ara_desc,
                                    P.com_cantidad, P.com_valor
                                    FROM comtrade2 AS P
                                    INNER JOIN Aranceles AS A ON P.ara_id = A.ara_id
                                    WHERE $where
                                    ORDER BY P.com_valor DESC");

        return $query->result_array();
    }

    public function set_item($com_anio, $com_origen, $com_destino, $com_tipo, $com_ara, $com_cantidad = NULL, $com_valor = NULL)
    {
        $data = array(
            'com_id' => NULL,
            'com_anio' => $com_anio,
            'ctry_code_origen' => $com_origen,
            'ctry_code_destino' => $com_destino,
            'com_tipo' => $com_tipo,
            'ara_id' => $com_ara,
            'com_cantidad' => $com_cantidad,
            'com_valor' => $com_valor
        );

        $this->db->insert('comtrade2', $data);
        return $this->db->insert_id();
    }

}