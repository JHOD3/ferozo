<?php
class Resultados_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_cant_items()
    {
        $query = $this->db->query("SELECT COUNT(1) as cant
                                    FROM Productos AS P
                                    INNER JOIN Productos AS P2 ON P.ara_id = P2.ara_id
                                    WHERE P.tp_id=".TP_OFERTA."
                                    AND P2.tp_id=".TP_DEMANDA."
                                    AND P.prod_estado > 0
                                    AND P2.prod_estado > 0
                                    AND P.usr_id <> P2.usr_id");

        return $query->row_array();
    }

    public function get_cant_items_reales()
    {
        $query = $this->db->query("SELECT COUNT(1) as cant
                                    FROM Productos AS P
                                    INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                    INNER JOIN Productos AS P2 ON P.ara_id = P2.ara_id
                                    INNER JOIN Usuarios AS U2 ON P2.usr_id = U2.usr_id
                                    WHERE P.tp_id=".TP_OFERTA."
                                    AND P2.tp_id=".TP_DEMANDA."
                                    AND P.prod_estado > 0
                                    AND P2.prod_estado > 0
                                    AND U.usr_estado = 1
                                    AND U2.usr_estado = 1
                                    AND P.usr_id <> P2.usr_id");

        return $query->row_array();
    }

    public function get_cant_usuarios()
    {
        $query = $this->db->query("SELECT DISTINCT(P.ara_id)
                                    FROM Productos AS P
                                    INNER JOIN Productos AS P2 ON P.ara_id = P2.ara_id
                                    WHERE P.tp_id=".TP_OFERTA."
                                    AND P2.tp_id=".TP_DEMANDA."
                                    AND P.prod_estado > 0
                                    AND P2.prod_estado > 0
                                    AND P.usr_id <> P2.usr_id");

        $posiciones = $query->result_array();
        $pos_aux = '';
        if($posiciones)
        {
            foreach ($posiciones as $key => $value)
            {
                if($key > 0)
                {
                    $pos_aux .= ',';
                }
                $pos_aux .= $value['ara_id'];
            }

            $query = $this->db->query("SELECT COUNT(DISTINCT(P.usr_id)) as cant
                                        FROM Productos AS P
                                        WHERE P.ara_id IN (".$pos_aux.")");

            return $query->row_array();
        }
        
        return array('cant' => 0);
    }

    public function get_cant_usuarios_reales()
    {
        $query = $this->db->query("SELECT DISTINCT(P.ara_id)
                                    FROM Productos AS P
                                    INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                    INNER JOIN Productos AS P2 ON P.ara_id = P2.ara_id
                                    INNER JOIN Usuarios AS U2 ON P2.usr_id = U2.usr_id
                                    WHERE P.tp_id=".TP_OFERTA."
                                    AND P2.tp_id=".TP_DEMANDA."
                                    AND P.prod_estado > 0
                                    AND P2.prod_estado > 0
                                    AND U.usr_estado = 1
                                    AND U2.usr_estado = 1
                                    AND P.usr_id <> P2.usr_id");

        $posiciones = $query->result_array();
        $pos_aux = '';
        if($posiciones)
        {
            foreach ($posiciones as $key => $value)
            {
                if($key > 0)
                {
                    $pos_aux .= ',';
                }
                $pos_aux .= $value['ara_id'];
            }

            $query = $this->db->query("SELECT COUNT(DISTINCT(P.usr_id)) as cant
                                        FROM Productos AS P
                                        INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                        WHERE P.ara_id IN (".$pos_aux.")
                                        AND U.usr_estado = 1");

            return $query->row_array();
        }

        return array('cant' => 0);
    }

    public function get_aranceles_cant_items()
    {
        $query = $this->db->query("SELECT COUNT(1) as cant, P.ara_id, A.ara_code, A.ara_desc_es as ara_desc
                                    FROM Productos AS P
                                    INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                    INNER JOIN Productos AS P2 ON P.ara_id = P2.ara_id
                                    INNER JOIN Usuarios AS U2 ON P2.usr_id = U2.usr_id
                                    INNER JOIN Aranceles AS A ON P.ara_id = A.ara_id
                                    WHERE P.tp_id=".TP_OFERTA."
                                    AND P2.tp_id=".TP_DEMANDA."
                                    AND P.prod_estado > 0
                                    AND P2.prod_estado > 0
                                    AND U.usr_estado = 1
                                    AND U2.usr_estado = 1
                                    AND P.usr_id <> P2.usr_id
                                    GROUP BY P.ara_id
                                    ORDER BY cant DESC
                                    LIMIT 15");

        return $query->result_array();
    }

    public function get_paises_cant_items()
    {
        $query = $this->db->query("SELECT COUNT(1) as cant, P.ctry_code, C.ctry_nombre_es as ctry_nombre
                                    FROM Productos AS P
                                    INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                    INNER JOIN Productos AS P2 ON P.ara_id = P2.ara_id
                                    INNER JOIN Usuarios AS U2 ON P2.usr_id = U2.usr_id
                                    INNER JOIN Country AS C ON P.ctry_code = C.ctry_code
                                    WHERE P.tp_id=".TP_OFERTA."
                                    AND P2.tp_id=".TP_DEMANDA."
                                    AND P.prod_estado > 0
                                    AND P2.prod_estado > 0
                                    AND U.usr_estado = 1
                                    AND U2.usr_estado = 1
                                    AND P.usr_id <> P2.usr_id
                                    GROUP BY P.ctry_code
                                    ORDER BY cant DESC
                                    LIMIT 15");

        return $query->result_array();
    }

}