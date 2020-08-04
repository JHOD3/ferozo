<?php
class Resultados_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_items($lang = "en", $usr_id = FALSE, $offset = 0, $limit = 20)
    {
        $query = $this->db->query("SELECT DISTINCT P.ara_id
                                                FROM Productos AS P 
                                                WHERE P.usr_id=".$usr_id."
                                                AND P.tp_id=".TP_OFERTA);
        $ofertas_propias = $query->result_array();

        $query = $this->db->query("SELECT DISTINCT P.ara_id
                                                FROM Productos AS P
                                                WHERE P.usr_id=".$usr_id."
                                                AND P.tp_id=".TP_DEMANDA);
        $demandas_propias = $query->result_array();

        $where_array = array();
        $where_array_or = array();

        $where_array[] = "P.usr_id <> '".$usr_id."'";
        $where_array[] = "P.prod_estado > 0";

        if($this->session->userdata('search') != "")
        {
            $where_array[] = "(P.prod_descripcion LIKE '%".$this->session->userdata('search')."%'
                                OR A.ara_desc_".$lang." LIKE '%".$this->session->userdata('search')."%'
                                OR C.cat_desc_".$lang." LIKE '%".$this->session->userdata('search')."%'
                                OR C.cat_code LIKE '%".$this->session->userdata('search')."%'
                                OR A.ara_code LIKE '%".$this->session->userdata('search')."%')";
        }

        if($this->session->userdata('filtro_productos') == "no")
        {
            $where_array[] = "S.sec_id > 21";
        }

        if($this->session->userdata('filtro_servicios') == "no")
        {
            $where_array[] = "S.sec_id <> 22";
        }

        if($this->session->userdata('filtro_arancel') != "")
        {
            $where_array[] = "A.ara_id = '".$this->session->userdata('filtro_arancel')."'";
        }

        if($this->session->userdata('filtro_pais') != "")
        {
            $where_array[] = "P.ctry_code = '".$this->session->userdata('filtro_pais')."'";

            if($this->session->userdata('filtro_ciudad') != "")
            {
                $where_array[] = "P.city_id = '".$this->session->userdata('filtro_ciudad')."'";
            }
        }

        
            if($this->session->userdata('filtro_ofertas') != "no")
            {
                if(count($demandas_propias)>0)
                {
                    $dem_ara_ids = null;
                    foreach($demandas_propias as $demanda_propia)
                    {
                        $dem_ara_ids[] = "'".$demanda_propia['ara_id']."'";
                    }
                    $where_array_or[] = "(P.ara_id IN(".join($dem_ara_ids,",").") AND P.tp_id=".TP_OFERTA.")";
                }
                else
                {
                    $where_array[] = "P.tp_id <> ".TP_OFERTA;
                }
            }
            else
            {
                $where_array[] = "P.tp_id <> ".TP_OFERTA;
            }

            if($this->session->userdata('filtro_demandas') != "no")
            {
                if(count($ofertas_propias)>0)
                {
                    $ofe_ara_ids = null;
                    foreach($ofertas_propias as $oferta_propia)
                    {
                        $ofe_ara_ids[] = "'".$oferta_propia['ara_id']."'";
                    }
                    $where_array_or[] = "(P.ara_id IN(".join($ofe_ara_ids,",").") AND P.tp_id=".TP_DEMANDA.")";
                }
                else
                {
                    $where_array[] = "P.tp_id <> ".TP_DEMANDA;
                }
            }
            else
            {
                $where_array[] = "P.tp_id <> ".TP_DEMANDA;
            }
        

        if($this->session->userdata('filtro_orden') == "acceso")
        {
            $orden = "U.usr_ult_acceso DESC";
        }
        elseif($this->session->userdata('filtro_orden') == "creacion")
        {
            $orden = "P.prod_fecha DESC";
        }
        elseif($this->session->userdata('filtro_orden') == "arancel")
        {
            $orden = "A.ara_code";
        }
        elseif($this->session->userdata('filtro_orden') == "pais")
        {
            $orden = "Ctry.ctry_nombre_".$lang;
        }
        else
        {
            $orden = "U.usr_ult_acceso DESC";
        }

        if($this->session->userdata('filtro_ofertas') != "no" || $this->session->userdata('filtro_demandas') != "no")
        {
            if(count($where_array_or) > 0)
                $where_array[] = "(".join($where_array_or," OR ").")";

            if($this->session->userdata('filtro_favoritos') == "si")
            {
                $where_array[] = "UF.usr_id = '".$usr_id."'";
                $where = implode(' AND ',$where_array);
                $query = $this->db->query("SELECT P.prod_id, P.tp_id, P.usr_id, P.ara_id, P.prod_nombre, P.prod_descripcion, P.ctry_code, P.city_id,
                                        S.sec_id,
                                        C.cat_desc_".$lang." as cat_desc, C.cat_code, C.cat_id,
                                        A.ara_desc_".$lang." as ara_desc, A.ara_code,
                                        U.usr_ult_acceso, U.tu_id, U.usr_imagen,
                                        Ctry.ctry_nombre_".$lang." as ctry_nombre, 
                                        City.city_nombre_".$lang." as city_nombre, City.toponymName
                                        FROM Productos AS P
                                        INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                        INNER JOIN Country AS Ctry ON Ctry.ctry_code = P.ctry_code
                                        INNER JOIN City AS City ON City.city_id = P.city_id
                                        INNER JOIN Aranceles AS A ON P.ara_id = A.ara_id
                                        INNER JOIN Categorias AS C ON A.cat_id = C.cat_id
                                        INNER JOIN Secciones AS S ON C.sec_id = S.sec_id
                                        INNER JOIN Usuarios_Favoritos AS UF ON P.usr_id = UF.usr_favorito
                                        WHERE $where
                                        ORDER BY U.tu_id DESC, ".$orden."
                                        LIMIT ".$limit."
                                        OFFSET ".$offset);
            }
            else
            {
                $where = implode(' AND ',$where_array);
                $query = $this->db->query("SELECT P.prod_id, P.tp_id, P.usr_id, P.ara_id, P.prod_nombre, P.prod_descripcion, P.ctry_code, P.city_id,
                                        S.sec_id,
                                        C.cat_desc_".$lang." as cat_desc, C.cat_code, C.cat_id,
                                        A.ara_desc_".$lang." as ara_desc, A.ara_code,
                                        U.usr_ult_acceso, U.tu_id, U.usr_imagen,
                                        Ctry.ctry_nombre_".$lang." as ctry_nombre,
                                        City.city_nombre_".$lang." as city_nombre, City.toponymName
                                        FROM Productos AS P
                                        INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                        INNER JOIN Country AS Ctry ON Ctry.ctry_code = P.ctry_code
                                        INNER JOIN City AS City ON City.city_id = P.city_id
                                        INNER JOIN Aranceles AS A ON P.ara_id = A.ara_id
                                        INNER JOIN Categorias AS C ON A.cat_id = C.cat_id
                                        INNER JOIN Secciones AS S ON C.sec_id = S.sec_id
                                        WHERE $where
                                        ORDER BY U.tu_id DESC, ".$orden."
                                        LIMIT ".$limit."
                                        OFFSET ".$offset);
            }

            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_ultimos($lang = "en", $offset = 0, $limit = 20)
    {
        $where_array = array();

        $where_array[] = "P.prod_estado > 0";

        if($this->session->userdata('usr_id') != "")
        {
            $where_array[] = "P.usr_id <> '".$this->session->userdata('usr_id')."'";
        }

        if($this->session->userdata('filtro_ofertas') != "no" && $this->session->userdata('filtro_demandas') == "no")
        {
            $where_array[] = "P.tp_id <> ".TP_DEMANDA;
        }
        elseif($this->session->userdata('filtro_ofertas') == "no" && $this->session->userdata('filtro_demandas') != "no")
        {
            $where_array[] = "P.tp_id <> ".TP_OFERTA;
        }

        $orden = "U.tu_id DESC, U.usr_ult_acceso DESC";

        $where = implode(' AND ', $where_array);

        $query = $this->db->query("SELECT P.prod_id, P.tp_id, P.usr_id, P.ara_id, P.prod_nombre, P.prod_descripcion, P.ctry_code, P.city_id,
                                U.usr_ult_acceso, U.tu_id
                                FROM Productos AS P
                                INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                WHERE ".$where."
                                ORDER BY ".$orden."
                                LIMIT ".$limit."
                                OFFSET ".$offset);
        /*
        $query = $this->db->query("(
                                    SELECT P.prod_id, P.tp_id, P.usr_id, P.ara_id, P.prod_nombre, P.prod_descripcion, P.ctry_code, P.city_id,
                                    U.usr_ult_acceso, U.tu_id
                                    FROM Productos AS P
                                    INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                    WHERE ".$where."
                                    LIMIT ".$limit."
                                    OFFSET ".$offset."
                                )
                                UNION 
                                (
                                    SELECT A.ads_id, 0, A.usr_id, 0, '', '', '', 0, U.usr_ult_acceso, U.tu_id
                                    FROM ads AS A
                                    INNER JOIN Usuarios AS U ON A.usr_id = U.usr_id
                                    LIMIT 3
                                )
                                ");
        */
        return $query->result_array();
    }

    public function get_ultimos_diferentes_usuarios($lang = "en", $offset = 0, $limit = 20)
    {
        $where_array = array();

        $where_array[] = "P2.prod_estado > 0";
        $where_array[] = "((U2.usr_imagen NOT LIKE 'perfil.jpg' AND U2.usr_imagen IS NOT NULL) OR (P2.prod_id IN (SELECT prod_id FROM productos_imagenes)))";

        if($this->session->userdata('usr_id') != "")
        {
            $where_array[] = "P2.usr_id <> '".$this->session->userdata('usr_id')."'";
        }

        $where = implode(' AND ', $where_array);
        $query = $this->db->query("SELECT P.prod_id, P.tp_id, P.usr_id, P.ara_id, P.prod_nombre, P.prod_descripcion, P.ctry_code, P.city_id
                                    FROM Productos AS P
                                    INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id 
                                    WHERE P.prod_id IN (SELECT MAX(P2.prod_id) 
                                                        FROM Productos AS P2 
                                                        INNER JOIN Usuarios AS U2 ON P2.usr_id = U2.usr_id 
                                                        WHERE P2.prod_estado > 0
                                                        AND ((U2.usr_imagen NOT LIKE 'perfil.jpg' AND U2.usr_imagen IS NOT NULL) OR (P2.prod_id IN (SELECT prod_id FROM productos_imagenes)))
                                                        GROUP BY P2.usr_id)
                                    ORDER BY U.tu_id DESC, U.usr_ult_acceso DESC
                                    LIMIT 20
                                    OFFSET 0");

        return $query->result_array();
    }

    public function get_data_item($lang = "en", $prod_id = FALSE)
    {
        if($prod_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT P.prod_id, P.tp_id, P.usr_id, P.ara_id, P.prod_nombre, P.prod_descripcion, P.ctry_code, P.city_id,
                                    S.sec_id,
                                    C.cat_desc_".$lang." as cat_desc, C.cat_code, C.cat_id,
                                    A.ara_desc_".$lang." as ara_desc, A.ara_code,
                                    U.usr_ult_acceso, U.tu_id, U.usr_imagen,
                                    Ctry.ctry_nombre_".$lang." as ctry_nombre, 
                                    City.city_nombre_".$lang." as city_nombre, City.toponymName,
                                    (SELECT mail_direccion FROM Mails AS M INNER JOIN Productos_Mails AS PM ON PM.mail_id = M.mail_id WHERE PM.prod_id=P.prod_id LIMIT 1) as pm_mail,
                                    (SELECT UF2.uf_puntaje FROM Usuarios_Favoritos AS UF2 WHERE UF2.usr_favorito=P.usr_id AND UF2.usr_id=".$this->session->userdata('usr_id').") as uf_puntaje,
                                    (SELECT PI.pi_ruta FROM productos_imagenes AS PI WHERE PI.prod_id=P.prod_id LIMIT 1) as prod_imagen,
                                    (SELECT COUNT(1) FROM Usuarios_Favoritos AS UF3 WHERE UF3.usr_favorito = P.usr_id) as cant_seguidores,
                                    (SELECT AVG(UF4.uf_puntaje) FROM Usuarios_Favoritos AS UF4 WHERE UF4.usr_favorito = P.usr_id) as puntaje,
                                    (SELECT COUNT(DISTINCT(PV.usr_id)) FROM productos_visitados AS PV WHERE PV.prod_id = P.prod_id) as visitas,
                                    (SELECT COUNT(1) FROM productos_visitados AS PV WHERE PV.prod_id = P.prod_id AND PV.usr_id=".$this->session->userdata('usr_id').") as mis_visitas,
                                    (SELECT COUNT(1) FROM referencias AS R WHERE R.usr_id = P.usr_id AND R.ref_est_id = ".REFERENCIA_VALIDADA.") as referencias
                                    FROM Productos AS P
                                    INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                    INNER JOIN Country AS Ctry ON Ctry.ctry_code = P.ctry_code
                                    INNER JOIN City AS City ON City.city_id = P.city_id
                                    INNER JOIN Aranceles AS A ON P.ara_id = A.ara_id
                                    INNER JOIN Categorias AS C ON A.cat_id = C.cat_id
                                    INNER JOIN Secciones AS S ON C.sec_id = S.sec_id
                                    WHERE P.prod_id = ".$prod_id);

        return $query->row_array();
    }

    public function get_data_items($lang = "en", $prods = FALSE/*, $ads = FALSE*/)
    {
        if($prods === FALSE)
        {
            return FALSE;
        }

        $orden = "U.tu_id DESC, U.usr_ult_acceso DESC";
        
        if($this->session->userdata('usr_id') != "")
        {
            $query = $this->db->query("SELECT P.prod_id, P.tp_id, P.usr_id, P.ara_id, P.prod_nombre, P.prod_descripcion, P.ctry_code, P.city_id,
                                        S.sec_id,
                                        C.cat_desc_".$lang." as cat_desc, C.cat_code, C.cat_id,
                                        A.ara_desc_".$lang." as ara_desc, A.ara_code,
                                        U.usr_ult_acceso, U.tu_id, U.usr_imagen,
                                        Ctry.ctry_nombre_".$lang." as ctry_nombre, 
                                        City.city_nombre_".$lang." as city_nombre, City.toponymName,
                                        (SELECT mail_direccion FROM Mails AS M INNER JOIN Productos_Mails AS PM ON PM.mail_id = M.mail_id WHERE PM.prod_id=P.prod_id LIMIT 1) as pm_mail,
                                        (SELECT UF2.uf_puntaje FROM Usuarios_Favoritos AS UF2 WHERE UF2.usr_favorito=P.usr_id AND UF2.usr_id=".$this->session->userdata('usr_id').") as uf_puntaje,
                                        (SELECT PI.pi_ruta FROM productos_imagenes AS PI WHERE PI.prod_id=P.prod_id LIMIT 1) as prod_imagen,
                                        (SELECT COUNT(1) FROM Usuarios_Favoritos AS UF3 WHERE UF3.usr_favorito = P.usr_id) as cant_seguidores,
                                        (SELECT AVG(UF4.uf_puntaje) FROM Usuarios_Favoritos AS UF4 WHERE UF4.usr_favorito = P.usr_id) as puntaje,
                                        (SELECT COUNT(DISTINCT(PV.usr_id)) FROM productos_visitados AS PV WHERE PV.prod_id = P.prod_id) as visitas,
                                        (SELECT COUNT(1) FROM productos_visitados AS PV WHERE PV.prod_id = P.prod_id AND PV.usr_id=".$this->session->userdata('usr_id').") as mis_visitas,
                                        (SELECT COUNT(1) FROM referencias AS R WHERE R.usr_id = P.usr_id AND R.ref_est_id = ".REFERENCIA_VALIDADA.") as referencias
                                        FROM Productos AS P
                                        INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                        INNER JOIN Country AS Ctry ON Ctry.ctry_code = P.ctry_code
                                        INNER JOIN City AS City ON City.city_id = P.city_id
                                        INNER JOIN Aranceles AS A ON P.ara_id = A.ara_id
                                        INNER JOIN Categorias AS C ON A.cat_id = C.cat_id
                                        INNER JOIN Secciones AS S ON C.sec_id = S.sec_id
                                        WHERE P.prod_id IN (".$prods.")
                                        ORDER BY ".$orden);
            /*
                                        UNION 
                                        SELECT A.ads_id, 0, A.usr_id, 0, '', A.ads_texto_corto, '', 0, '', '', '', '', A.ads_titulo, '', U.usr_ult_acceso, U.tu_id, '', '', '', ''
                                        '', '', '', A.ads_imagen, '', '', '', '', ''
                                        FROM ads AS A
                                        INNER JOIN Usuarios AS U ON A.usr_id = U.usr_id
                                        WHERE A.ads_id IN (".$ads.")
            */
        }
        else
        {
            $query = $this->db->query("SELECT P.prod_id, P.tp_id, P.usr_id, P.ara_id, P.prod_nombre, P.prod_descripcion, P.ctry_code, P.city_id,
                                        S.sec_id,
                                        C.cat_desc_".$lang." as cat_desc, C.cat_code, C.cat_id,
                                        A.ara_desc_".$lang." as ara_desc, A.ara_code,
                                        U.usr_ult_acceso, U.tu_id, U.usr_imagen,
                                        Ctry.ctry_nombre_".$lang." as ctry_nombre, 
                                        City.city_nombre_".$lang." as city_nombre, City.toponymName,
                                        (SELECT mail_direccion FROM Mails AS M INNER JOIN Productos_Mails AS PM ON PM.mail_id = M.mail_id WHERE PM.prod_id=P.prod_id LIMIT 1) as pm_mail,
                                        (SELECT PI.pi_ruta FROM productos_imagenes AS PI WHERE PI.prod_id=P.prod_id LIMIT 1) as prod_imagen,
                                        (SELECT COUNT(1) FROM Usuarios_Favoritos AS UF3 WHERE UF3.usr_favorito = P.usr_id) as cant_seguidores,
                                        (SELECT AVG(UF4.uf_puntaje) FROM Usuarios_Favoritos AS UF4 WHERE UF4.usr_favorito = P.usr_id) as puntaje,
                                        (SELECT COUNT(DISTINCT(PV.usr_id)) FROM productos_visitados AS PV WHERE PV.prod_id = P.prod_id) as visitas,
                                        (SELECT COUNT(1) FROM referencias AS R WHERE R.usr_id = P.usr_id AND R.ref_est_id = ".REFERENCIA_VALIDADA.") as referencias
                                        FROM Productos AS P
                                        INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                        INNER JOIN Country AS Ctry ON Ctry.ctry_code = P.ctry_code
                                        INNER JOIN City AS City ON City.city_id = P.city_id
                                        INNER JOIN Aranceles AS A ON P.ara_id = A.ara_id
                                        INNER JOIN Categorias AS C ON A.cat_id = C.cat_id
                                        INNER JOIN Secciones AS S ON C.sec_id = S.sec_id
                                        WHERE P.prod_id IN (".$prods.")
                                        ORDER BY ".$orden);
        }

        return $query->result_array();
    }

    public function get_cant_items($usr_id = FALSE)
    {
        $query = $this->db->query("SELECT DISTINCT P.ara_id
                                    FROM Productos AS P 
                                    WHERE P.usr_id=".$usr_id."
                                    AND P.tp_id=".TP_OFERTA);
        $ofertas_propias = $query->result_array();

        $query = $this->db->query("SELECT DISTINCT P.ara_id
                                    FROM Productos AS P
                                    WHERE P.usr_id=".$usr_id."
                                    AND P.tp_id=".TP_DEMANDA);
        $demandas_propias = $query->result_array();

        $where_array = array();
        $where_array_or = array();

        $where_array[] = "P.usr_id <> '".$usr_id."'";
        $where_array[] = "P.prod_estado > 0";

        if(count($demandas_propias)>0)
        {
            $dem_ara_ids = null;
            foreach($demandas_propias as $demanda_propia)
            {
                $dem_ara_ids[] = "'".$demanda_propia['ara_id']."'";
            }
            $where_array_or[] = "(P.ara_id IN(".join($dem_ara_ids,",").") AND P.tp_id=".TP_OFERTA.")";
        }
        else
        {
            $where_array[] = "P.tp_id <> ".TP_OFERTA;
        }

        if(count($ofertas_propias)>0)
        {
            $ofe_ara_ids = null;
            foreach($ofertas_propias as $oferta_propia)
            {
                $ofe_ara_ids[] = "'".$oferta_propia['ara_id']."'";
            }
            $where_array_or[] = "(P.ara_id IN(".join($ofe_ara_ids,",").") AND P.tp_id=".TP_DEMANDA.")";
        }
        else
        {
            $where_array[] = "P.tp_id <> ".TP_DEMANDA;
        }

        if(count($where_array_or) > 0)
                $where_array[] = "(".join($where_array_or," OR ").")";

        $where = implode(' AND ',$where_array);
        $query = $this->db->query("SELECT COUNT(P.prod_id) as cant
                                    FROM Productos AS P
                                    WHERE $where");

        return $query->row_array();
    }

    
    public function get_usuarios_match_producto($prod_id = FALSE)
    {
        $query = $this->db->query("SELECT *
                                    FROM Productos AS P 
                                    WHERE P.prod_id=".$prod_id);
        $producto = $query->row_array();

        $where_array = array();

        $where_array[] = "P.usr_id <> ".$producto['usr_id'];
        $where_array[] = "U.usr_estado = 1";
        $where_array[] = "P.prod_estado > 0";
        $where_array[] = "P.ara_id = ".$producto['ara_id'];

        if($producto['tp_id']==TP_DEMANDA)
        {
            $where_array[] = "P.tp_id = ".TP_OFERTA;
        }
        else
        {
            $where_array[] = "P.tp_id = ".TP_DEMANDA;
        }

        $where = implode(' AND ', $where_array);
        $query = $this->db->query("SELECT *
                                    FROM Productos AS P
                                    INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                    INNER JOIN Productos_Mails AS PM ON P.prod_id = PM.prod_id
                                    INNER JOIN Mails AS M ON PM.mail_id = M.mail_id
                                    WHERE $where");

        return $query->result_array();
    }

    public function get_matchs_producto($prod_id = FALSE)
    {
        $query = $this->db->query("SELECT *
                                    FROM Productos AS P 
                                    WHERE P.prod_id=".$prod_id);
        $producto = $query->row_array();

        $where_array = array();

        $where_array[] = "P.usr_id <> ".$producto['usr_id'];
        $where_array[] = "P.ara_id = ".$producto['ara_id'];

        if($producto['tp_id']==TP_DEMANDA)
        {
            $where_array[] = "P.tp_id = ".TP_OFERTA;
        }
        else
        {
            $where_array[] = "P.tp_id = ".TP_DEMANDA;
        }

        $where = implode(' AND ', $where_array);
        $query = $this->db->query("SELECT *
                                    FROM Productos AS P
                                    INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                    INNER JOIN Productos_Mails AS PM ON P.prod_id = PM.prod_id
                                    INNER JOIN Mails AS M ON PM.mail_id = M.mail_id
                                    WHERE $where");

        return $query->result_array();
    }
    

    public function get_aranceles($lang = "en", $usr_id = FALSE)
    {
        $query = $this->db->query("SELECT DISTINCT P.ara_id
                                                FROM Productos AS P 
                                                WHERE P.usr_id=".$usr_id."
                                                AND P.tp_id=".TP_OFERTA);
        $ofertas_propias = $query->result_array();

        $query = $this->db->query("SELECT DISTINCT P.ara_id
                                                FROM Productos AS P
                                                WHERE P.usr_id=".$usr_id."
                                                AND P.tp_id=".TP_DEMANDA);
        $demandas_propias = $query->result_array();

        $where_array = array();
        $where_array_or = array();

        $where_array[] = "P.usr_id <> '".$usr_id."'";
        $where_array[] = "P.prod_estado > 0";

        if(count($demandas_propias)>0)
        {
            $dem_ara_ids = null;
            foreach($demandas_propias as $demanda_propia)
            {
                $dem_ara_ids[] = "'".$demanda_propia['ara_id']."'";
            }
            $where_array_or[] = "(P.ara_id IN(".join($dem_ara_ids,",").") AND P.tp_id=".TP_OFERTA.")";
        }
        else
        {
            $where_array[] = "P.tp_id <> ".TP_OFERTA;
        }


        if(count($ofertas_propias)>0)
        {
            $ofe_ara_ids = null;
            foreach($ofertas_propias as $oferta_propia)
            {
                $ofe_ara_ids[] = "'".$oferta_propia['ara_id']."'";
            }
            $where_array_or[] = "(P.ara_id IN(".join($ofe_ara_ids,",").") AND P.tp_id=".TP_DEMANDA.")";
        }
        else
        {
            $where_array[] = "P.tp_id <> ".TP_DEMANDA;
        }

        if(count($where_array_or) > 0)
            $where_array[] = "(".join($where_array_or," OR ").")";

        $where = implode(' AND ',$where_array);
        $query = $this->db->query("SELECT DISTINCT(A.ara_id),
                                A.ara_desc_".$lang." as ara_desc, A.ara_code
                                FROM Productos AS P
                                INNER JOIN Aranceles AS A ON P.ara_id = A.ara_id
                                WHERE $where
                                ORDER BY A.ara_id");

        return $query->result_array();
    }

    public function get_paises($lang = "en", $usr_id = FALSE)
    {
        $query = $this->db->query("SELECT DISTINCT P.ara_id
                                                FROM Productos AS P 
                                                WHERE P.usr_id=".$usr_id."
                                                AND P.tp_id=".TP_OFERTA);
        $ofertas_propias = $query->result_array();

        $query = $this->db->query("SELECT DISTINCT P.ara_id
                                                FROM Productos AS P
                                                WHERE P.usr_id=".$usr_id."
                                                AND P.tp_id=".TP_DEMANDA);
        $demandas_propias = $query->result_array();

        $where_array = array();
        $where_array_or = array();

        $where_array[] = "P.usr_id <> '".$usr_id."'";
        $where_array[] = "P.prod_estado > 0";

        if(count($demandas_propias)>0)
        {
            $dem_ara_ids = null;
            foreach($demandas_propias as $demanda_propia)
            {
                $dem_ara_ids[] = "'".$demanda_propia['ara_id']."'";
            }
            $where_array_or[] = "(P.ara_id IN(".join($dem_ara_ids,",").") AND P.tp_id=".TP_OFERTA.")";
        }
        else
        {
            $where_array[] = "P.tp_id <> ".TP_OFERTA;
        }


        if(count($ofertas_propias)>0)
        {
            $ofe_ara_ids = null;
            foreach($ofertas_propias as $oferta_propia)
            {
                $ofe_ara_ids[] = "'".$oferta_propia['ara_id']."'";
            }
            $where_array_or[] = "(P.ara_id IN(".join($ofe_ara_ids,",").") AND P.tp_id=".TP_DEMANDA.")";
        }
        else
        {
            $where_array[] = "P.tp_id <> ".TP_DEMANDA;
        }

        if(count($where_array_or) > 0)
            $where_array[] = "(".join($where_array_or," OR ").")";

        $where = implode(' AND ',$where_array);
        $query = $this->db->query("SELECT DISTINCT(P.ctry_code), C.ctry_nombre_".$lang." as ctry_nombre
                                    FROM Productos AS P
                                    INNER JOIN Country AS C ON P.ctry_code = C.ctry_code
                                    WHERE $where
                                    ORDER BY P.ctry_code");

        return $query->result_array();
    }


    public function get_paises_match($lang = "en", $usr_id = FALSE, $ara_id = 0)
    {
        $query = $this->db->query("SELECT DISTINCT (P.ctry_code)
                                    FROM Productos AS P 
                                    WHERE P.usr_id=".$usr_id."
                                    AND P.ara_id=".$ara_id);

        return $query->result_array();
    }

}