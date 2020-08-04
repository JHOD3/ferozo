<?php
class User_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($usr_id = FALSE)
    {
        if ($usr_id === FALSE)
        {
            $query = $this->db->query('SELECT *
                                    FROM Usuarios AS U');
            return $query->result_array();
        }

        $query = $this->db->query('SELECT *
                                    FROM Usuarios AS U
                                    WHERE U.usr_id ='.$usr_id);
        return $query->row_array();
    }

    public function get_otro_item($lang = "es", $usr_id = FALSE)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT U.*,
                                    Ctry.ctry_nombre_".$lang." as ctry_nombre,
                                    City.city_nombre_".$lang." as city_nombre,
                                    I.idi_desc_".$lang." as idi_desc,
                                    (SELECT COUNT(1) FROM Usuarios_Favoritos AS UF WHERE UF.usr_favorito = U.usr_id) as cant_seguidores,
                                    (SELECT AVG(UF2.uf_puntaje) FROM Usuarios_Favoritos AS UF2 WHERE UF2.usr_favorito = U.usr_id) as puntaje
                                    FROM Usuarios AS U
                                    LEFT JOIN Country AS Ctry ON U.usr_pais = Ctry.ctry_code
                                    LEFT JOIN City AS City ON U.usr_provincia = City.city_id
                                    INNER JOIN Idiomas AS I ON U.idi_code = I.idi_code
                                    WHERE U.usr_id =".$usr_id);
        return $query->row_array();
    }

    public function get_items_byMail($usr_mail = FALSE)
    {
        if ($usr_mail === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM Usuarios AS U
                                    WHERE U.usr_mail = "'.$usr_mail.'"');
        return $query->row_array();
    }

    public function get_tipo_datos($usr_id = FALSE, $td_id = FALSE)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        if ($td_id === FALSE)
        {
            $query = $this->db->query('SELECT *
                                    FROM Usuarios_Datos AS U
                                    WHERE U.usr_id='.$usr_id);
            return $query->result_array();
        }

        $query = $this->db->query('SELECT *
                                    FROM Usuarios_Datos AS U
                                    WHERE U.usr_id ='.$usr_id.'
                                    AND U.td_id='.$td_id);
        return $query->result_array();
    }

    public function get_cantidad()
    {
        $query = $this->db->query('SELECT COUNT(1) as cant
                                    FROM Usuarios AS U');
        return $query->row_array();
    }

    public function login($mail, $clave)
    {
        if ($mail === FALSE || $clave === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT U.*, UA.usr_ads_estado
                                    FROM Usuarios AS U
                                    LEFT JOIN usuarios_ads AS UA ON U.usr_id = UA.usr_id
                                    WHERE U.usr_mail = "'.$mail.'"
                                    AND U.usr_clave = "'.$clave.'"');

        return $query->row_array();
    }

    public function login_facebook($usr_facebook)
    {
        if ($usr_facebook === FALSE || $usr_facebook == NULL)
        {
            return FALSE;
        }

        $query = $this->db->get_where('Usuarios', array('usr_facebook' => $usr_facebook));
        return $query->row_array();
    }

    public function login_google($usr_google)
    {
        if ($usr_google === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->get_where('Usuarios', array('usr_google' => $usr_google));
        return $query->row_array();
    }

    public function existe_mail($mail)
    {
        if ($mail === FALSE)
    	{
    		return FALSE;
    	}

        $query = $this->db->get_where('Usuarios', array('usr_mail' => $mail));

        if($query->num_rows()>0)
    	    return TRUE;

        return FALSE;
    }

    public function set_item($usr_mail, $usr_clave, $idi_code, $usr_pais, $estado, $imagen)
    {
        $data = array(
            'usr_id' => NULL,
            'usr_nombre' => "",
            'usr_apellido' => "",
            'usr_mail' => $usr_mail,
            'usr_clave' => $usr_clave,
            'usr_fecha' => date('Y-m-d H:i:s'),
            'usr_estado' => $estado,
            'idi_code' => $idi_code,
            'usr_publica' => 0,
            'usr_imagen' => $imagen,
            'usr_empresa' => NULL,
            'usr_pais' => $usr_pais,
            'usr_provincia' => NULL,
            'usr_ciudad' => NULL,
            'usr_direccion' => NULL,
            'usr_ult_acceso' => date('Y-m-d H:i:s'),
            'usr_nac' => NULL,
            'usr_cp' => NULL
        );

        $this->db->insert('Usuarios', $data);
        return $this->db->insert_id();
    }

    public function set_item_facebook($usr_nombre, $usr_apellido, $usr_mail, $idi_code, $usr_facebook, $usr_pais)
    {
        $data = array(
            'usr_id' => NULL,
            'usr_nombre' => $usr_nombre,
            'usr_apellido' => $usr_apellido,
            'usr_mail' => $usr_mail,
            'usr_clave' => "",
            'usr_fecha' => date('Y-m-d H:i:s'),
            'usr_estado' => 1,
            'idi_code' => $idi_code,
            'usr_facebook' => $usr_facebook,
            'usr_publica' => 0,
            'usr_pais' => $usr_pais,
            'usr_ult_acceso' => date('Y-m-d H:i:s')
        );

        $this->db->insert('Usuarios', $data);
        return $this->db->insert_id();
    }

    public function set_item_google($usr_nombre, $usr_apellido, $usr_mail, $idi_code, $usr_google, $usr_pais)
    {
        $data = array(
            'usr_id' => NULL,
            'usr_nombre' => $usr_nombre,
            'usr_apellido' => $usr_apellido,
            'usr_mail' => $usr_mail,
            'usr_clave' => "",
            'usr_fecha' => date('Y-m-d H:i:s'),
            'usr_estado' => 1,
            'idi_code' => $idi_code,
            'usr_google' => $usr_google,
            'usr_publica' => 0,
            'usr_pais' => $usr_pais,
            'usr_ult_acceso' => date('Y-m-d H:i:s')
        );

        $this->db->insert('Usuarios', $data);
        return $this->db->insert_id();
    }

    public function update_item($usr_id, $usr_nombre, $usr_apellido, $idi_code, $usr_publica, $usr_imagen, $usr_empresa, $usr_pais, $usr_provincia, $usr_ciudad, $usr_direccion, $usr_cp)
    {
        $data = array(
            'usr_nombre' => $usr_nombre,
            'usr_apellido' => $usr_apellido,
            'idi_code' => $idi_code,
            'usr_publica' => $usr_publica,
            'usr_imagen' => $usr_imagen,
            'usr_empresa' => $usr_empresa,
            'usr_pais' => $usr_pais,
            'usr_provincia' => $usr_provincia,
            'usr_ciudad' => $usr_ciudad,
            'usr_direccion' => $usr_direccion,
            'usr_cp' => $usr_cp
        );

        $this->db->where('usr_id',$usr_id);
        return $this->db->update('Usuarios', $data);
    }

    public function update_pais($usr_id, $usr_pais)
    {
        $data = array(
            'usr_pais' => $usr_pais
        );

        $this->db->where('usr_id',$usr_id);
        return $this->db->update('Usuarios', $data);
    }

    public function update_clave($usr_id, $clave)
    {
        $data = array(
            'usr_clave' => $clave
        );

        $this->db->where('usr_id',$usr_id);
        return $this->db->update('Usuarios', $data);
    }

    public function update_facebook($cli_mail, $cli_facebook)
    {
        $data = array(
            'usr_facebook' => $cli_facebook,
            'usr_estado' => 1
        );

        $this->db->where('usr_mail', $cli_mail);
        return $this->db->update('Usuarios', $data);
    }

    public function update_google($cli_mail, $cli_google, $cli_imagen = NULL)
    {
        $data = array(
            'usr_google' => $cli_google,
            'usr_estado' => 1
        );

        $this->db->where('usr_mail', $cli_mail);
        return $this->db->update('Usuarios', $data);
    }

    public function set_foto($usr_id, $imagen)
    {
    	$data = array(
    		'usr_imagen' => $imagen
    	);

        $this->db->where('usr_id',$usr_id);
        return $this->db->update('Usuarios', $data);
    }

    public function set_password($usr_id, $clave)
    {
        if ($usr_id === FALSE)
    	{
    		return FALSE;
    	}

    	$data = array(
    		'usr_clave' => $clave
    	);

        $this->db->where('usr_id',$usr_id);
        return $this->db->update('Usuarios', $data);
    }

    public function estado_item($usr_id, $estado)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $data = array(
            'usr_estado' => $estado
        );

        $this->db->where('usr_id',$usr_id);
        return $this->db->update('Usuarios', $data);
    }

    public function update_ultimo_acceso($usr_id)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $data = array(
            'usr_ult_acceso' => date('Y-m-d H:i:s')
        );

        $this->db->where('usr_id',$usr_id);
        return $this->db->update('Usuarios', $data);
    }

    public function set_dato($usr_id, $td_id, $ctd_id, $ud_descripcion)
    {
        if($ctd_id == 0)
            $ctd_id = NULL;
        
        $data = array(
            'ud_id' => NULL,
            'usr_id' => $usr_id,
            'td_id' => $td_id,
            'ctd_id' => $ctd_id,
            'ud_descripcion' => $ud_descripcion
        );

        $this->db->insert('Usuarios_Datos', $data);
        return $this->db->insert_id();
    }

    public function delete_item($usr_id)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where('usr_id',$usr_id);
        return $this->db->delete('Usuarios');
    }

    public function delete_datos($usr_id)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where('usr_id',$usr_id);
        return $this->db->delete('Usuarios_Datos');
    }

}