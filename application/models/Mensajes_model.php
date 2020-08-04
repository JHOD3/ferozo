<?php
class Mensajes_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($id = FALSE)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM mensajes AS M
                                    WHERE (M.usr_id_receptor =".$this->session->userdata('usr_id')."
                                    AND M.usr_id_emisor =".$id.")
                                    OR (M.usr_id_emisor =".$this->session->userdata('usr_id')."
                                    AND M.usr_id_receptor =".$id.")
                                    ORDER BY M.msj_fecha DESC");
        return $query->result_array();
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

    public function get_cant_mensajes_sin_leer()
    {
        $query = $this->db->query("SELECT COUNT(1) as cant
                                    FROM mensajes AS M
                                    WHERE M.usr_id_receptor = ".$this->session->userdata('usr_id')."
                                    AND M.msj_estado < 3");
        return $query->row_array();
    }

    public function get_conversaciones()
    {
        $query = $this->db->query('SELECT U.*,
                                    (SELECT M.msj_texto FROM mensajes AS M WHERE (M.usr_id_receptor = '.$this->session->userdata('usr_id').' AND M.usr_id_emisor=U.usr_id) OR (M.usr_id_emisor = '.$this->session->userdata('usr_id').' AND M.usr_id_receptor=U.usr_id) ORDER BY M.msj_fecha DESC LIMIT 1) as ultimo_mensaje,
                                    (SELECT M.msj_estado FROM mensajes AS M WHERE (M.usr_id_receptor = '.$this->session->userdata('usr_id').' AND M.usr_id_emisor=U.usr_id) ORDER BY M.msj_fecha DESC LIMIT 1) as ultimo_mensaje_estado
                                    FROM Usuarios AS U
                                    WHERE U.usr_id IN (SELECT usr_id_receptor FROM mensajes WHERE usr_id_emisor = '.$this->session->userdata('usr_id').')
                                    OR U.usr_id IN (SELECT usr_id_emisor FROM mensajes WHERE usr_id_receptor = '.$this->session->userdata('usr_id').')');
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

    public function set_item($usr_id_emisor, $usr_id_receptor, $msj_texto)
    {
        $data = array(
            'msj_id' => NULL,
            'usr_id_emisor' => $usr_id_emisor,
            'usr_id_receptor' => $usr_id_receptor,
            'msj_texto' => $msj_texto,
            'msj_fecha' => date('Y-m-d H:i:s'),
            'msj_estado' => 1
        );

        $this->db->insert('mensajes', $data);
        return $this->db->insert_id();
    }

    public function estado_chat($usr_id_emisor, $estado)
    {
        if($usr_id_emisor === FALSE)
    	{
    		return FALSE;
    	}

        $data = array(
    		'msj_estado' => $estado
    	);

        $this->db->where( array('usr_id_emisor' => $usr_id_emisor, 'usr_id_receptor' => $this->session->userdata('usr_id')) );
        return $this->db->update('mensajes', $data);
    }

}