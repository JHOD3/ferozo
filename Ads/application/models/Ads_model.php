<?php
class Ads_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($usr_id = FALSE)
    {
        if($usr_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM ads AS A
                                    WHERE A.usr_id='.$usr_id.'
                                    AND A.ads_estado > 0');
        return $query->result_array();
    }

    public function get_primer_item($usr_id = FALSE)
    {
        if($usr_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM ads AS A
                                    WHERE A.usr_id='.$usr_id.'
                                    AND A.ads_estado > 0
                                    ORDER BY A.ads_fecha
                                    LIMIT 1');
        return $query->row_array();
    }

    public function get_items_x_tipo($usr_id = FALSE, $ads_tipo_id = FALSE)
    {
        if($usr_id === FALSE || $ads_tipo_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT A.*,
                                    (SELECT COUNT(1) FROM ads_impresion AS AI WHERE AI.ads_id = A.ads_id) as impresiones,
                                    (SELECT COUNT(1) FROM ads_click AS AC WHERE AC.ads_id = A.ads_id) as clicks,
                                    (SELECT COUNT(1) FROM ads_forms AS AF WHERE AF.ads_id = A.ads_id) as formularios,
                                    (SELECT SUM(AI.ads_imp_importe) FROM ads_impresion AS AI WHERE AI.ads_id = A.ads_id) as consumo_impresiones,
                                    (SELECT SUM(AC.ads_click_importe) FROM ads_click AS AC WHERE AC.ads_id = A.ads_id) as consumo_clicks,
                                    (SELECT SUM(AF.ads_form_importe) FROM ads_forms AS AF WHERE AF.ads_id = A.ads_id) as consumo_formularios
                                    FROM ads AS A
                                    WHERE A.usr_id='.$usr_id.'
                                    AND A.ads_tipo_id='.$ads_tipo_id.'
                                    AND A.ads_estado > 0');
        return $query->result_array();
    }

    public function get_tipos($ads_tipo_id = FALSE)
    {
        if($ads_tipo_id === FALSE)
        {
            $query = $this->db->query('SELECT *
                                        FROM ads_tipos AS AT');
            return $query->result_array();
        }

        $query = $this->db->query('SELECT *
                                    FROM ads_tipos AS AT
                                    WHERE AT.ads_tipo_id='.$ads_tipo_id);
        return $query->row_array();
    }

    public function get_item($ads_id = FALSE)
    {
        if($ads_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM ads AS A
                                    WHERE A.ads_id='.$ads_id);
        return $query->row_array();
    }

    public function get_item_aranceles($lang="es", $ads_id = FALSE)
    {
        if($ads_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT AA.*, A.ara_code, A.cat_id, A.ara_desc_'.$lang.' as ara_desc
                                    FROM ads_aranceles AS AA
                                    INNER JOIN Aranceles AS A ON AA.ara_id = A.ara_id
                                    WHERE AA.ads_id='.$ads_id);
        return $query->result_array();
    }

    public function get_item_paises($lang="es", $ads_id = FALSE)
    {
        if($ads_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT AC.*, C.ctry_nombre_'.$lang.' as ctry_nombre
                                    FROM ads_countrys AS AC
                                    INNER JOIN Country AS C ON AC.ctry_code = C.ctry_code
                                    WHERE AC.ads_id='.$ads_id);
        return $query->result_array();
    }

    public function get_item_imagenes($ads_id = FALSE)
    {
        if($ads_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM ads_imagenes AS AI
                                    WHERE AI.ads_id='.$ads_id);
        return $query->result_array();
    }

    public function get_item_formularios($ads_id = FALSE)
    {
        if($ads_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM ads_forms AS AF
                                    LEFT JOIN ads AS A ON A.ads_id = AF.ads_id
                                    WHERE AF.ads_id='.$ads_id.'
                                    ORDER BY AF.ads_form_fecha DESC');
        return $query->result_array();
    }

    public function get_formularios($usr_id = FALSE)
    {
        if($usr_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM ads_forms AS AF
                                    LEFT JOIN ads AS A ON A.ads_id = AF.ads_id
                                    WHERE A.usr_id='.$usr_id.'
                                    ORDER BY AF.ads_form_fecha DESC');
        return $query->result_array();
    }

    public function get_formulario($lang="es", $ads_form_id = FALSE)
    {
        if($ads_form_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT AF.*, A.ads_nombre, C.ctry_nombre_'.$lang.' as ctry_nombre
                                    FROM ads_forms AS AF
                                    LEFT JOIN ads AS A ON A.ads_id = AF.ads_id
                                    LEFT JOIN Usuarios AS U ON AF.usr_id = U.usr_id
                                    LEFT JOIN Country AS C ON U.usr_pais = C.ctry_code
                                    WHERE AF.ads_form_id='.$ads_form_id);
        return $query->row_array();
    }
    
    public function set_item($usr_id, $ads_tipo_id, $ads_nombre, $ads_titulo, $ads_texto, $ads_texto_corto, $ads_imagen, $ads_link, $ads_estado=1, $ads_oferta=1, $ads_demanda=1, $ads_forms=1, $ads_forms_mail=NULL)
    {
        if(!$ads_oferta)
        {
            $ads_oferta = 0;
        }

        if(!$ads_demanda)
        {
            $ads_demanda = 0;
        }

        if(!$ads_forms)
        {
            $ads_forms = 0;
        }

        if($ads_forms_mail == "")
        {
            $ads_forms_mail = NULL;
        }

        $data = array(
            'ads_id' => NULL,
            'ads_tipo_id' => $ads_tipo_id,
            'usr_id' => $usr_id,
            'ads_nombre' => $ads_nombre,
            'ads_titulo' => $ads_titulo,
            'ads_texto' => $ads_texto,
            'ads_texto_corto' => $ads_texto_corto,
            'ads_imagen' => $ads_imagen,
            'ads_link' => $ads_link,
            'ads_estado' => $ads_estado,
            'ads_fecha' => date('Y-m-d H:i:s'),
            'ads_oferta' => $ads_oferta,
            'ads_demanda' => $ads_demanda,
            'ads_forms' => $ads_forms,
            'ads_forms_mail' => $ads_forms_mail
        );

        $this->db->insert('ads', $data);
        return $this->db->insert_id();
    }

    public function set_item_country($ads_id, $ctry_code)
    {
        $data = array(
            'ads_ctry_id' => NULL,
            'ads_id' => $ads_id,
            'ctry_code' => $ctry_code
        );

        $this->db->insert('ads_countrys', $data);
        return $this->db->insert_id();
    }

    public function set_item_arancel($ads_id, $ara_id)
    {
        $data = array(
            'ads_ara_id' => NULL,
            'ads_id' => $ads_id,
            'ara_id' => $ara_id
        );

        $this->db->insert('ads_aranceles', $data);
        return $this->db->insert_id();
    }

    public function set_item_imagen($ads_id, $ads_img_ruta)
    {
        $data = array(
            'ads_img_id' => NULL,
            'ads_id' => $ads_id,
            'ads_img_ruta' => $ads_img_ruta
        );

        $this->db->insert('ads_imagenes', $data);
        return $this->db->insert_id();
    }

    public function update_item($id, $ads_nombre, $ads_titulo, $ads_texto, $ads_texto_corto, $ads_imagen, $ads_link, $ads_oferta=1, $ads_demanda=1, $ads_forms=1, $ads_forms_mail=NULL)
    {
        if(!$ads_oferta)
        {
            $ads_oferta = 0;
        }

        if(!$ads_demanda)
        {
            $ads_demanda = 0;
        }

        if(!$ads_forms)
        {
            $ads_forms = 0;
        }

        if($ads_forms_mail == "")
        {
            $ads_forms_mail = NULL;
        }
        
        $data = array(
            'ads_nombre' => $ads_nombre,
            'ads_titulo' => $ads_titulo,
            'ads_texto' => $ads_texto,
            'ads_texto_corto' => $ads_texto_corto,
            'ads_imagen' => $ads_imagen,
            'ads_link' => $ads_link,
            'ads_oferta' => $ads_oferta,
            'ads_demanda' => $ads_demanda,
            'ads_forms' => $ads_forms,
            'ads_forms_mail' => $ads_forms_mail
        );

        $this->db->where('ads_id',$id);
        return $this->db->update('ads', $data);
    }

    public function update_estado($id, $ads_estado)
    {
        $data = array(
            'ads_estado' => $ads_estado
        );

        $this->db->where('ads_id',$id);
        return $this->db->update('ads', $data);
    }

    public function delete_item($id)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $this->db->where('ads_id',$id);
        return $this->db->delete('ads');
    }

    public function delete_item_aranceles($id)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $this->db->where('ads_id',$id);
        return $this->db->delete('ads_aranceles');
    }

    public function delete_item_countrys($id)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $this->db->where('ads_id',$id);
        return $this->db->delete('ads_countrys');
    }

    public function delete_imagen($id)
    {
        if ($id === FALSE)
        {
            return FALSE;
        }

        $this->db->where('ads_img_id',$id);
        return $this->db->delete('ads_imagenes');
    }
    

    /**********************
    STATS
    **********************/

    public function get_cant_impresiones_entre_fechas($fecha_ini = FALSE, $fecha_fin = FALSE, $usr_id = FLASE, $ads_id = FALSE)
    {
        $where = array();

        if($fecha_ini === FALSE)
        {
            $fecha_ini = "2000-01-01";
        }

        $where[] = 'AI.ads_imp_fecha >= "'.$fecha_ini.' 00:00:00"';

        if($fecha_fin === FALSE)
        {
            $fecha_fin = "2999-31-12";
        }

        $where[] = 'AI.ads_imp_fecha <= "'.$fecha_fin.' 23:59:59"';

        if($usr_id !== FALSE)
        {
            $where[] = 'A.usr_id = '.$usr_id;
        }

        if($ads_id !== FALSE)
        {
            $where[] = 'AI.ads_id = '.$ads_id;
        }

        $where_string = implode(' AND ', $where);

        $query = $this->db->query('SELECT COUNT(1) as cant, SUM(ads_imp_importe) as consumo
                                    FROM ads_impresion AS AI
                                    INNER JOIN ads AS A ON AI.ads_id = A.ads_id
                                    WHERE '.$where_string);
        return $query->row_array();
    }

    public function get_cant_clicks_entre_fechas($fecha_ini = FALSE, $fecha_fin = FALSE, $usr_id = FLASE, $ads_id = FALSE)
    {
        $where = array();

        if($fecha_ini === FALSE)
        {
            $fecha_ini = "2000-01-01";
        }

        $where[] = 'AC.ads_click_fecha >= "'.$fecha_ini.' 00:00:00"';

        if($fecha_fin === FALSE)
        {
            $fecha_fin = "2999-31-12";
        }

        $where[] = 'AC.ads_click_fecha <= "'.$fecha_fin.' 23:59:59"';

        if($usr_id !== FALSE)
        {
            $where[] = 'A.usr_id = '.$usr_id;
        }

        if($ads_id !== FALSE)
        {
            $where[] = 'AC.ads_id = '.$ads_id;
        }

        $where_string = implode(' AND ', $where);

        $query = $this->db->query('SELECT COUNT(1) as cant, SUM(ads_click_importe) as consumo
                                    FROM ads_click AS AC
                                    INNER JOIN ads AS A ON AC.ads_id = A.ads_id
                                    WHERE '.$where_string);
        return $query->row_array();
    }

    public function get_cant_forms_entre_fechas($fecha_ini = FALSE, $fecha_fin = FALSE, $usr_id = FLASE, $ads_id = FALSE)
    {
        $where = array();

        if($fecha_ini === FALSE)
        {
            $fecha_ini = "2000-01-01";
        }

        $where[] = 'AC.ads_form_fecha >= "'.$fecha_ini.' 00:00:00"';

        if($fecha_fin === FALSE)
        {
            $fecha_fin = "2999-31-12";
        }

        $where[] = 'AC.ads_form_fecha <= "'.$fecha_fin.' 23:59:59"';

        if($usr_id !== FALSE)
        {
            $where[] = 'A.usr_id = '.$usr_id;
        }

        if($ads_id !== FALSE)
        {
            $where[] = 'AC.ads_id = '.$ads_id;
        }

        $where_string = implode(' AND ', $where);

        $query = $this->db->query('SELECT COUNT(1) as cant, SUM(ads_form_importe) as consumo
                                    FROM ads_forms AS AC
                                    INNER JOIN ads AS A ON AC.ads_id = A.ads_id
                                    WHERE '.$where_string);
        return $query->row_array();
    }

    public function get_paises_entre_fechas($lang = "en", $fecha_ini = FALSE, $fecha_fin = FALSE, $usr_id = FLASE, $ads_id = FALSE)
    {
        $where = array();
        
        if($fecha_ini === FALSE)
        {
            $fecha_ini = "2000-01-01";
        }
        //$where[] = 'AI.ads_imp_fecha >= "'.$fecha_ini.' 00:00:00"';

        if($fecha_fin === FALSE)
        {
            $fecha_fin = "2999-31-12";
        }
        //$where[] = 'AI.ads_imp_fecha <= "'.$fecha_fin.' 23:59:59"';
        
        if($usr_id !== FALSE)
        {
            $where[] = 'A.usr_id = '.$usr_id;
        }
        
        if($ads_id !== FALSE)
        {
            $where[] = 'A.ads_id = '.$ads_id;
        }

        $where_string = implode(' AND ', $where);

        $query = $this->db->query('SELECT C.ctry_nombre_'.$lang.' as ctry_nombre,
                                        COUNT(1) as impresiones,
                                        SUM(AI.ads_imp_importe) as impresiones_consumo,
                                        (SELECT COUNT(1) 
                                            FROM ads_click AS AI 
                                            INNER JOIN ads AS A ON AI.ads_id = A.ads_id
                                            INNER JOIN Usuarios AS U ON AI.usr_id = U.usr_id 
                                            WHERE AI.ads_click_fecha >= "'.$fecha_ini.' 00:00:00" 
                                            AND AI.ads_click_fecha <= "'.$fecha_fin.' 23:59:59" 
                                            AND '.$where_string.'
                                            AND U.usr_pais=C.ctry_code) as clicks,
                                        (SELECT COUNT(1) 
                                            FROM ads_forms AS AI 
                                            INNER JOIN ads AS A ON AI.ads_id = A.ads_id
                                            INNER JOIN Usuarios AS U ON AI.usr_id = U.usr_id 
                                            WHERE AI.ads_form_fecha >= "'.$fecha_ini.' 00:00:00" 
                                            AND AI.ads_form_fecha <= "'.$fecha_fin.' 23:59:59"
                                            AND '.$where_string.'
                                            AND U.usr_pais=C.ctry_code) as formularios,
                                        (SELECT SUM(AI.ads_click_importe) 
                                            FROM ads_click AS AI 
                                            INNER JOIN ads AS A ON AI.ads_id = A.ads_id
                                            INNER JOIN Usuarios AS U ON AI.usr_id = U.usr_id 
                                            WHERE AI.ads_click_fecha >= "'.$fecha_ini.' 00:00:00" 
                                            AND AI.ads_click_fecha <= "'.$fecha_fin.' 23:59:59" 
                                            AND '.$where_string.'
                                            AND U.usr_pais=C.ctry_code) as clicks_consumo,
                                        (SELECT SUM(AI.ads_form_importe) 
                                            FROM ads_forms AS AI 
                                            INNER JOIN ads AS A ON AI.ads_id = A.ads_id
                                            INNER JOIN Usuarios AS U ON AI.usr_id = U.usr_id 
                                            WHERE AI.ads_form_fecha >= "'.$fecha_ini.' 00:00:00" 
                                            AND AI.ads_form_fecha <= "'.$fecha_fin.' 23:59:59"
                                            AND '.$where_string.'
                                            AND U.usr_pais=C.ctry_code) as formularios_consumo
                                    FROM ads AS A
                                    INNER JOIN ads_impresion AS AI ON A.ads_id = AI.ads_id
                                    INNER JOIN Usuarios AS U ON AI.usr_id = U.usr_id
                                    INNER JOIN Country AS C ON U.usr_pais = C.ctry_code
                                    WHERE AI.ads_imp_fecha >= "'.$fecha_ini.' 00:00:00" 
                                    AND AI.ads_imp_fecha <= "'.$fecha_fin.' 23:59:59" 
                                    AND '.$where_string.'
                                    GROUP BY C.ctry_code
                                    ORDER BY ctry_nombre');
        return $query->result_array();
    }

    /****************
    PRECIOS
    ****************/

    public function get_importes()
    {
        $query = $this->db->query('SELECT *
                                    FROM ads_importes AS AI
                                    ORDER BY AI.ads_imp_id');
        return $query->result_array();
    }

    /****************
    PRECIOS
    ****************/

    public function get_bloqueos($usr_id)
    {
        if($usr_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM ads_bloqueos AS AB
                                    INNER JOIN Usuarios AS U ON AB.ads_blo_usr_id = U.usr_id
                                    WHERE AB.usr_id='.$usr_id.'
                                    ORDER BY U.usr_mail');
        return $query->result_array();
    }

    public function get_usuario_bloqueado($usr_id, $ads_blo_usr_id)
    {
        if($usr_id === FALSE || $ads_blo_usr_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM ads_bloqueos AS AB
                                    WHERE AB.usr_id='.$usr_id.'
                                    AND AB.ads_blo_usr_id='.$ads_blo_usr_id);
        return $query->result_array();
    }

    public function set_bloqueo($usr_id, $ads_blo_usr_id)
    {
        $data = array(
            'ads_blo_id' => NULL,
            'ads_blo_usr_id' => $ads_blo_usr_id,
            'usr_id' => $usr_id
        );

        $this->db->insert('ads_bloqueos', $data);
        return $this->db->insert_id();
    }

    public function delete_bloqueo($id)
    {
        if($id === FALSE)
        {
            return FALSE;
        }

        $this->db->where('ads_blo_id',$id);
        return $this->db->delete('ads_bloqueos');
    }

}