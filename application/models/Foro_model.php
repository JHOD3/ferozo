<?php
class Foro_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($lang = "es", $id = FALSE)
    {
        if ($id === FALSE)
        {
            $where_array = array();

            if($this->session->userdata('foro_search') != "")
            {
                $where_array[] = "(F.foro_titulo LIKE '%".$this->session->userdata('foro_search')."%'
                                    OR F.foro_descripcion LIKE '%".$this->session->userdata('foro_search')."%'
                                    OR A.ara_desc_".$lang." LIKE '%".$this->session->userdata('foro_search')."%'
                                    OR Ctry.ctry_nombre_".$lang." LIKE '%".$this->session->userdata('foro_search')."%')";
            }

            if($this->session->userdata('foro_arancel') != "")
            {
                $where_array[] = "F.ara_id = '".$this->session->userdata('foro_arancel')."'";
            }

            if($this->session->userdata('foro_pais') != "")
            {
                $where_array[] = "F.ctry_code = '".$this->session->userdata('foro_pais')."'";
            }

            if(count($where_array)>0)
            {
                $where = "WHERE ".implode(' AND ', $where_array);
            }
            else
            {
                $where = "";
            }

            $query = $this->db->query("SELECT F.*, U.*,
                                        S.sec_desc_".$lang." as sec_desc, S.sec_code, S.sec_id,
                                        C.cat_desc_".$lang." as cat_desc, C.cat_code, C.cat_id,
                                        A.ara_desc_".$lang." as ara_desc, A.ara_code,
                                        Ctry.ctry_nombre_".$lang." as ctry_nombre,
                                        (SELECT COUNT(1) FROM foro_visitados AS FV WHERE FV.foro_id = F.foro_id) as cant_visitas,
                                        (SELECT COUNT(1) FROM foro_mensaje AS FM2 WHERE FM2.foro_id = F.foro_id) as cant_mensajes,
                                        IF((SELECT MAX(FM.forom_fecha) FROM foro_mensaje AS FM WHERE FM.foro_id = F.foro_id) IS NULL, 
                                            F.foro_fecha, 
                                            (SELECT MAX(FM.forom_fecha) FROM foro_mensaje AS FM WHERE FM.foro_id = F.foro_id)) as fecha_ultimo_comentario
                                        FROM Foro AS F
                                        LEFT JOIN Usuarios AS U ON F.usr_id = U.usr_id
                                        LEFT JOIN Aranceles AS A ON F.ara_id = A.ara_id
                                        LEFT JOIN Categorias AS C ON A.cat_id = C.cat_id
                                        LEFT JOIN Secciones AS S ON C.sec_id = S.sec_id
                                        LEFT JOIN Country AS Ctry ON F.ctry_code = Ctry.ctry_code
                                        ".$where."
                                        ORDER BY fecha_ultimo_comentario DESC");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT F.*, U.*,
                                    S.sec_desc_".$lang." as sec_desc, S.sec_code, S.sec_id,
                                    C.cat_desc_".$lang." as cat_desc, C.cat_code, C.cat_id,
                                    A.ara_desc_".$lang." as ara_desc, A.ara_code,
                                    Ctry.ctry_nombre_".$lang." as ctry_nombre,
                                    (SELECT COUNT(1) FROM foro_mensaje AS FM2 WHERE FM2.foro_id = F.foro_id) as cant_mensajes
                                    FROM Foro AS F
                                    LEFT JOIN Usuarios AS U ON F.usr_id = U.usr_id
                                    LEFT JOIN Aranceles AS A ON F.ara_id = A.ara_id
                                    LEFT JOIN Categorias AS C ON A.cat_id = C.cat_id
                                    LEFT JOIN Secciones AS S ON C.sec_id = S.sec_id
                                    LEFT JOIN Country AS Ctry ON F.ctry_code = Ctry.ctry_code
                                    WHERE F.foro_id =".$id);
        return $query->row_array();
    }

    public function buscar_items($lang = "es", $offset = 0, $limit = 10)
    {
        $where_array = array();

        if($this->session->userdata('foro_search') != "")
        {
            $where_array[] = "(F.foro_titulo LIKE '%".$this->session->userdata('foro_search')."%'
                                OR F.foro_descripcion LIKE '%".$this->session->userdata('foro_search')."%'
                                OR A.ara_desc_".$lang." LIKE '%".$this->session->userdata('foro_search')."%'
                                OR Ctry.ctry_nombre_".$lang." LIKE '%".$this->session->userdata('foro_search')."%')";
        }

        if($this->session->userdata('foro_arancel') != "")
        {
            $where_array[] = "F.ara_id = '".$this->session->userdata('foro_arancel')."'";
        }

        if($this->session->userdata('foro_pais') != "")
        {
            $where_array[] = "F.ctry_code = '".$this->session->userdata('foro_pais')."'";
        }

        if(count($where_array)>0)
        {
            $where = "WHERE ".implode(' AND ', $where_array);
        }
        else
        {
            $where = "";
        }

        $query = $this->db->query("SELECT F.*, U.*,
                                    S.sec_desc_".$lang." as sec_desc, S.sec_code, S.sec_id,
                                    C.cat_desc_".$lang." as cat_desc, C.cat_code, C.cat_id,
                                    A.ara_desc_".$lang." as ara_desc, A.ara_code,
                                    Ctry.ctry_nombre_".$lang." as ctry_nombre,
                                    (SELECT COUNT(1) FROM foro_visitados AS FV WHERE FV.foro_id = F.foro_id) as cant_visitas,
                                    (SELECT COUNT(1) FROM foro_mensaje AS FM2 WHERE FM2.foro_id = F.foro_id) as cant_mensajes,
                                    IF((SELECT MAX(FM.forom_fecha) FROM foro_mensaje AS FM WHERE FM.foro_id = F.foro_id) IS NULL, 
                                        F.foro_fecha, 
                                        (SELECT MAX(FM.forom_fecha) FROM foro_mensaje AS FM WHERE FM.foro_id = F.foro_id)) as fecha_ultimo_comentario
                                    FROM Foro AS F
                                    LEFT JOIN Usuarios AS U ON F.usr_id = U.usr_id
                                    LEFT JOIN Aranceles AS A ON F.ara_id = A.ara_id
                                    LEFT JOIN Categorias AS C ON A.cat_id = C.cat_id
                                    LEFT JOIN Secciones AS S ON C.sec_id = S.sec_id
                                    LEFT JOIN Country AS Ctry ON F.ctry_code = Ctry.ctry_code
                                    ".$where."
                                    ORDER BY fecha_ultimo_comentario DESC");
        return $query->result_array();
    }

    public function get_last_items($lang = "es", $limit = 5)
    {
        $query = $this->db->query("SELECT F.*,
                                    S.sec_desc_".$lang." as sec_desc, S.sec_code, S.sec_id,
                                    C.cat_desc_".$lang." as cat_desc, C.cat_code, C.cat_id,
                                    A.ara_desc_".$lang." as ara_desc, A.ara_code,
                                    Ctry.ctry_nombre_".$lang." as ctry_nombre
                                    FROM Foro AS F
                                    LEFT JOIN Aranceles AS A ON F.ara_id = A.ara_id
                                    LEFT JOIN Categorias AS C ON A.cat_id = C.cat_id
                                    LEFT JOIN Secciones AS S ON C.sec_id = S.sec_id
                                    LEFT JOIN Country AS Ctry ON F.ctry_code = Ctry.ctry_code
                                    ORDER BY foro_fecha DESC
                                    LIMIT ".$limit);
        return $query->result_array();
    }

    public function get_usuarios($id = FALSE)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT U.*
                                    FROM foro_mensaje AS FM
                                    INNER JOIN Usuarios AS U ON FM.usr_id = U.usr_id
                                    WHERE FM.foro_id ='.$id.'
                                    GROUP BY U.usr_id');
        return $query->result_array();
    }

    public function get_mensajes($id = FALSE)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM foro_mensaje AS FM
                                    INNER JOIN Usuarios AS U ON FM.usr_id = U.usr_id
                                    WHERE FM.foro_id ='.$id.'
                                    ORDER BY FM.forom_fecha DESC');
        return $query->result_array();
    }

    public function get_aranceles($lang = "en")
    {
        $query = $this->db->query("SELECT DISTINCT(A.ara_id),
                                A.ara_desc_".$lang." as ara_desc, A.ara_code
                                FROM Foro AS F
                                INNER JOIN Aranceles AS A ON F.ara_id = A.ara_id
                                ORDER BY A.ara_id");

        return $query->result_array();
    }

    public function get_paises($lang = "en")
    {
        $query = $this->db->query("SELECT DISTINCT(F.ctry_code), 
                                C.ctry_nombre_".$lang." as ctry_nombre
                                FROM Foro AS F
                                INNER JOIN Country AS C ON F.ctry_code = C.ctry_code
                                ORDER BY F.ctry_code");

        return $query->result_array();
    }

    public function set_item($foro_titulo, $foro_descripcion, $usr_id, $ara_id = NULL, $ctry_code = NULL, $foro_estado = 0)
    {
        if($ara_id == 0 || $ara_id == "")
        {
            $ara_id = NULL;
        }
        
        if($ctry_code == "")
        {
            $ctry_code = NULL;
        }
        
        $data = array(
            'foro_id' => NULL,
            'foro_titulo' => $foro_titulo,
            'foro_descripcion' => $foro_descripcion,
            'usr_id' => $usr_id,
            'foro_fecha' => date('Y-m-d H:i:s'),
            'foro_estado' => $foro_estado,
            'ctry_code' => $ctry_code,
            'ara_id' => $ara_id
        );

        $this->db->insert('Foro', $data);
        return $this->db->insert_id();
    }

    public function set_mensaje($forom_descripcion, $usr_id, $foro_id)
    {
        $data = array(
            'forom_id' => NULL,
            'foro_id' => $foro_id,
            'forom_descripcion' => $forom_descripcion,
            'usr_id' => $usr_id,
            'forom_fecha' => date('Y-m-d H:i:s')
        );

        $this->db->insert('foro_mensaje', $data);
        return $this->db->insert_id();
    }

    public function estado_item($mail_id, $estado)
    {
        if ($mail_id === FALSE)
    	{
    		return FALSE;
    	}

        $data = array(
    		'mail_estado' => $estado
    	);

        $this->db->where('mail_id',$mail_id);
        return $this->db->update('Mails', $data);
    }

    /************************
    FOROS VISITADOS
    ************************/

    public function set_item_visitado($foro_id, $usr_id)
    {
        $data = array(
            'fv_id' => NULL,
            'foro_id' => $foro_id,
            'usr_id' => $usr_id,
            'fv_fecha' => date('Y-m-d H:i:s')
        );

        $this->db->insert('foro_visitados', $data);
        return $this->db->insert_id();
    }

}