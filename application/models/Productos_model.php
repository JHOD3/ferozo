<?php
class Productos_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_item($lang = "es", $prod_id = FALSE)
    {
        if($prod_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT P.prod_id, P.tp_id, P.usr_id, P.ara_id, P.prod_nombre, P.prod_descripcion, P.ctry_code, P.city_id, 
                                    S.sec_desc_".$lang." as sec_desc, S.sec_code, S.sec_id,
                                    C.cat_desc_".$lang." as cat_desc, C.cat_code, C.cat_id,
                                    A.ara_desc_".$lang." as ara_desc, A.ara_code,
                                    U.usr_nombre, U.usr_apellido, U.usr_mail, U.usr_ult_acceso, U.idi_code,
                                    Ctry.ctry_nombre_".$lang." as ctry_nombre, 
                                    City.city_nombre_".$lang." as city_nombre, City.toponymName,
                                    (SELECT COUNT(1) FROM Usuarios_Favoritos AS UF WHERE UF.usr_favorito = P.usr_id) as cant_seguidores,
                                    (SELECT AVG(UF2.uf_puntaje) FROM Usuarios_Favoritos AS UF2 WHERE UF2.usr_favorito = P.usr_id) as puntaje,
                                    (SELECT COUNT(DISTINCT(PV.usr_id)) FROM productos_visitados AS PV WHERE PV.prod_id = P.prod_id) as visitas
                                    FROM Productos AS P
                                    INNER JOIN Aranceles AS A ON P.ara_id = A.ara_id
                                    INNER JOIN Categorias AS C ON A.cat_id = C.cat_id
                                    INNER JOIN Secciones AS S ON C.sec_id = S.sec_id
                                    INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                    INNER JOIN Country AS Ctry ON P.ctry_code = Ctry.ctry_code
                                    INNER JOIN City AS City ON P.city_id = City.city_id
                                    WHERE P.prod_id=".$prod_id);
        $aux = $query->row_array();
        if($aux)
        {
            if(!$aux['puntaje'])
            {
                $aux['puntaje']=0;
            }
        }
        
        return $aux;
    }

    public function get_items($lang = "es", $usr_id = FALSE, $tp_id = FALSE)
    {
        $where_array = null;

        if($usr_id === FALSE)
        {
            return FALSE;
        }
        else
        {
            $where_array[] = "P.usr_id='".$usr_id."'";
        }

        if($tp_id !== FALSE)
        {
            $where_array[] = "P.tp_id='".$tp_id."'";
        }

        if(count($where_array) > 0)
        {
            $where = implode(' AND ',$where_array);
            $query = $this->db->query("SELECT P.prod_id, P.tp_id, P.usr_id, S.sec_id, P.ara_id, P.prod_nombre, P.prod_descripcion, P.ctry_code, P.city_id, A.ara_desc_".$lang." as ara_desc, A.ara_code,
                                        C.cat_desc_".$lang." as cat_desc, C.cat_id, C.cat_code,
                                        U.usr_nombre, U.usr_apellido, U.usr_mail, U.usr_ult_acceso, U.tu_id, U.usr_imagen,
                                        Ctry.ctry_nombre_".$lang." as ctry_nombre, 
                                        City.city_nombre_".$lang." as city_nombre, City.toponymName,
                                        (SELECT mail_direccion FROM Mails AS M INNER JOIN Productos_Mails AS PM ON PM.mail_id = M.mail_id WHERE PM.prod_id=P.prod_id LIMIT 1) as pm_mail,
                                        (SELECT PI.pi_ruta FROM productos_imagenes AS PI WHERE PI.prod_id=P.prod_id LIMIT 1) as prod_imagen,
                                        (SELECT COUNT(1) FROM Usuarios_Favoritos AS UF WHERE UF.usr_favorito = P.usr_id) as cant_seguidores,
                                        (SELECT AVG(UF2.uf_puntaje) FROM Usuarios_Favoritos AS UF2 WHERE UF2.usr_favorito = P.usr_id) as puntaje,
                                        (SELECT COUNT(DISTINCT(PV.usr_id)) FROM productos_visitados AS PV WHERE PV.prod_id = P.prod_id) as visitas,
                                        (SELECT COUNT(1) FROM productos_visitados AS PV WHERE PV.prod_id = P.prod_id AND PV.usr_id=".$this->session->userdata('usr_id').") as mis_visitas,
                                        (SELECT COUNT(1) FROM referencias AS R WHERE R.usr_id = P.usr_id) as referencias
                                        FROM Productos AS P
                                        INNER JOIN Aranceles AS A ON P.ara_id = A.ara_id
                                        INNER JOIN Categorias AS C ON A.cat_id = C.cat_id
                                        INNER JOIN Secciones AS S ON C.sec_id = S.sec_id
                                        INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                        INNER JOIN Country AS Ctry ON P.ctry_code = Ctry.ctry_code
                                        INNER JOIN City AS City ON P.city_id = City.city_id
                                        WHERE $where");
        }
        else
        {
            return FALSE;
        }

        return $query->result_array();
    }

    /*
    LE SAQUE mis_visitas PORQUE LO USO CUANDO NO ESTAS LOGUEADO
    */
    public function get_items_free($lang = "es", $usr_id = FALSE, $tp_id = FALSE)
    {
        $where_array = null;

        if($usr_id === FALSE)
        {
            return FALSE;
        }
        else
        {
            $where_array[] = "P.usr_id='".$usr_id."'";
        }

        if($tp_id !== FALSE)
        {
            $where_array[] = "P.tp_id='".$tp_id."'";
        }

        if(count($where_array) > 0)
        {
            $where = implode(' AND ',$where_array);
            $query = $this->db->query("SELECT P.prod_id, P.tp_id, P.usr_id, S.sec_id, P.ara_id, P.prod_nombre, P.prod_descripcion, P.ctry_code, P.city_id, A.ara_desc_".$lang." as ara_desc, A.ara_code,
                                        C.cat_desc_".$lang." as cat_desc, C.cat_id, C.cat_code,
                                        U.usr_nombre, U.usr_apellido, U.usr_mail, U.usr_ult_acceso, U.tu_id, U.usr_imagen,
                                        Ctry.ctry_nombre_".$lang." as ctry_nombre, 
                                        City.city_nombre_".$lang." as city_nombre, City.toponymName,
                                        (SELECT mail_direccion FROM Mails AS M INNER JOIN Productos_Mails AS PM ON PM.mail_id = M.mail_id WHERE PM.prod_id=P.prod_id LIMIT 1) as pm_mail,
                                        (SELECT PI.pi_ruta FROM productos_imagenes AS PI WHERE PI.prod_id=P.prod_id LIMIT 1) as prod_imagen,
                                        (SELECT COUNT(1) FROM Usuarios_Favoritos AS UF WHERE UF.usr_favorito = P.usr_id) as cant_seguidores,
                                        (SELECT AVG(UF2.uf_puntaje) FROM Usuarios_Favoritos AS UF2 WHERE UF2.usr_favorito = P.usr_id) as puntaje,
                                        (SELECT COUNT(DISTINCT(PV.usr_id)) FROM productos_visitados AS PV WHERE PV.prod_id = P.prod_id) as visitas,
                                        (SELECT COUNT(1) FROM referencias AS R WHERE R.usr_id = P.usr_id) as referencias
                                        FROM Productos AS P
                                        INNER JOIN Aranceles AS A ON P.ara_id = A.ara_id
                                        INNER JOIN Categorias AS C ON A.cat_id = C.cat_id
                                        INNER JOIN Secciones AS S ON C.sec_id = S.sec_id
                                        INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                        INNER JOIN Country AS Ctry ON P.ctry_code = Ctry.ctry_code
                                        INNER JOIN City AS City ON P.city_id = City.city_id
                                        WHERE $where");
        }
        else
        {
            return FALSE;
        }

        return $query->result_array();
    }

    public function get_items_mapa()
    {
        $query = $this->db->query("SELECT City.lat, City.lng
                                    FROM Productos AS P
                                    INNER JOIN City AS City ON P.city_id = City.city_id
                                    GROUP BY City.lat, City.lng");
        return $query->result_array();
    }

    public function get_item_mails($prod_id = FALSE)
    {
        if($prod_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM Productos_Mails AS PM
                                    INNER JOIN Mails AS M ON PM.mail_id = M.mail_id
                                    WHERE PM.prod_id=".$prod_id);

        return $query->result_array();
    }

    public function get_item_imagenes($prod_id = FALSE)
    {
        if($prod_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM productos_imagenes AS PM
                                    WHERE PM.prod_id=".$prod_id);

        return $query->result_array();
    }

    public function get_item_idiomas($lang = "es", $prod_id = FALSE)
    {
        if($prod_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT PI.*, I.idi_desc_".$lang." as idi_desc
                                    FROM Productos_Idiomas AS PI
                                    INNER JOIN Idiomas AS I ON PI.idi_code = I.idi_code
                                    WHERE PI.prod_id=".$prod_id);

        return $query->result_array();
    }

    public function get_cant_items($usr_id = FALSE, $tp_id = FALSE)
    {
        $where_array = null;

        if($usr_id !== FALSE)
        {
            $where_array[] = "P.usr_id='".$usr_id."'";
        }

        if($tp_id !== FALSE)
        {
            $where_array[] = "P.tp_id='".$tp_id."'";
        }

        $where = "";
        if(count($where_array) > 0)
        {
            $where = "WHERE ".implode(' AND ',$where_array);
        }
            
        $query = $this->db->query("SELECT COUNT(1) as cant
                                    FROM Productos AS P
                                    $where");

        return $query->row_array();
    }

    public function get_max_x_tipo($lang = "en", $tp_id = FALSE, $limit = 9999)
    {
        if($tp_id === FALSE)
        {
            return FALSE;
        }
            
        $query = $this->db->query("SELECT A.ara_desc_".$lang." as ara_desc, A.ara_code, COUNT(1) as cant
                                    FROM Productos AS P
                                    INNER JOIN Aranceles AS A ON P.ara_id = A.ara_id
                                    WHERE P.tp_id = ".$tp_id."
                                    GROUP BY A.ara_id
                                    ORDER BY cant DESC
                                    LIMIT ".$limit);

        return $query->result_array();
    }

    public function get_tipos($lang = "en", $id = FALSE)
    {
        if($id === FALSE)
        {
            $query = $this->db->query("SELECT TP.tp_id, TP.tp_desc_".$lang." as tp_desc
                                        FROM Tipo_Productos AS TP");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT TP.tp_id, TP.tp_desc_".$lang." as tp_desc
                                    FROM Tipo_Productos AS TP
                                    WHERE TP.tp_id=".$id);


        return $query->row_array();
    }

    public function set_item($tp_id, $usr_id, $sec_id, $cat_id, $ara_id, $prod_descripcion, $ctry_code, $city_code, $prod_estado)
    {
        $data = array(
            'prod_id' => NULL,
            'tp_id' => $tp_id,
            'usr_id' => $usr_id,
            'ara_id' => $ara_id,
            'prod_nombre' => "",
            'prod_descripcion' => $prod_descripcion,
            'ctry_code' => $ctry_code,
            'city_id' => $city_code,
            'prod_estado' => $prod_estado,
            'prod_fecha' => date('Y-m-d H:i:s')
        );

        $this->db->insert('Productos', $data);
        return $this->db->insert_id();
    }

    public function set_item_mail($prod_id, $mail)
    {
        $data = array(
            'pm_id' => NULL,
            'prod_id' => $prod_id,
            'mail_id' => $mail
        );

        $this->db->insert('Productos_Mails', $data);
        return $this->db->insert_id();
    }

    public function set_item_idioma($prod_id, $idi_code)
    {
        $data = array(
            'prod_id' => $prod_id,
            'idi_code' => $idi_code
        );

        return $this->db->insert('Productos_Idiomas', $data);
    }

    public function set_item_imagen($prod_id, $ruta)
    {
        $data = array(
            'pi_id' => NULL,
            'prod_id' => $prod_id,
            'pi_ruta' => $ruta
        );

        $this->db->insert('productos_imagenes', $data);
        return $this->db->insert_id();
    }

    public function update_item($prod_id, $usr_id, $sec_id, $cat_id, $ara_id, $prod_descripcion, $ctry_code, $city_code)
    {
        $data = array(
            'ara_id' => $ara_id,
            'prod_nombre' => "",
            'prod_descripcion' => $prod_descripcion,
            'ctry_code' => $ctry_code,
            'city_id' => $city_code
        );

        $this->db->where(array('prod_id'=>$prod_id, 'usr_id'=>$usr_id));
        return $this->db->update('Productos', $data);
    }

    public function delete_item($prod_id, $usr_id)
    {
        if ($prod_id === FALSE || $usr_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('prod_id'=>$prod_id, 'usr_id'=>$usr_id));
        return $this->db->delete('Productos');
    }

    public function delete_items_usuario($usr_id)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('usr_id'=>$usr_id));
        return $this->db->delete('Productos');
    }

    public function delete_item_mails($prod_id)
    {
        if ($prod_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('prod_id'=>$prod_id));
        return $this->db->delete('Productos_Mails');
    }

    public function delete_item_idiomas($prod_id)
    {
        if ($prod_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('prod_id'=>$prod_id));
        return $this->db->delete('Productos_Idiomas');
    }

    public function delete_item_imagenes($prod_id)
    {
        if ($prod_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('prod_id'=>$prod_id));
        return $this->db->delete('productos_imagenes');
    }

    public function delete_item_imagen($pi_id)
    {
        if ($pi_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('pi_id'=>$pi_id));
        return $this->db->delete('productos_imagenes');
    }


    /************************
    PRODUCTOS VISITADOS
    ************************/

    public function set_item_visitado($prod_id, $usr_id)
    {
        $data = array(
            'pv_id' => NULL,
            'prod_id' => $prod_id,
            'usr_id' => $usr_id,
            'pv_fecha' => date('Y-m-d H:i:s')
        );

        $this->db->insert('productos_visitados', $data);
        return $this->db->insert_id();
    }

}