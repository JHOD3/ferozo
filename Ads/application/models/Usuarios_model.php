<?php
class Usuarios_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($usr_id = FALSE)
    {
        if ($usr_id === FALSE)
        {
            $query = $this->db->query('SELECT U.*
                                        FROM usuarios AS U');
            return $query->result_array();
        }

        $query = $this->db->query('SELECT U.*
                                    FROM usuarios AS U
                                    WHERE U.usr_id ='.$usr_id);
        return $query->row_array();
    }

    public function login($usuario, $clave)
    {
        if ($usuario === FALSE || $clave === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT U.*
                                    FROM Usuarios AS U
                                    INNER JOIN usuarios_ads AS UA ON U.usr_id = UA.usr_id
                                    WHERE U.usr_mail = "'.$usuario.'"
                                    AND U.usr_clave = "'.$clave.'"');
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

    public function check_login()
    {
        if($this->session->userdata('ads_id') != "")
        {
            return TRUE;
        }
        return FALSE;
    }

    public function check_permisos($ut_id = FALSE, $class = FALSE, $method = FALSE, $gim_id = FALSE)
    {
        if($ut_id === FALSE)
        {
            $ut_id = $this->session->userdata('ut_id');
        }
        if($class === FALSE)
        {
            $class = $this->router->fetch_class();
        }
        elseif($class == "gimnasios_ejercicios")
        {
            $class = "gimnasios_rutinas";
        }
        if($method === FALSE)
        {
            $method = $this->router->fetch_method();
        }
        if($gim_id === FALSE)
        {
            $gim_id = $this->session->userdata('gim_id');
        }

        $result_modulo = FALSE;
        if($ut_id == 3)
        {
            // Veo si el modulo existe
            $query_modulo = $this->db->query('SELECT *
                                        FROM gim_modulos AS GM
                                        WHERE GM.gim_mod_class LIKE "'.$class.'"');
            $result_modulo = $query_modulo->row_array();
        }

        if($this->check_login())
        {
            $query = $this->db->query('SELECT *
                                        FROM permisos AS P
                                        INNER JOIN paginas AS PA ON P.pag_id = PA.pag_id
                                        WHERE P.ut_id = '.$ut_id.'
                                        AND PA.pag_class LIKE "'.$class.'"
                                        AND PA.pag_padre IS NULL
                                        AND PA.pag_metodos_libres = 1');
            $result = $query->row_array();
            if($result)
            {
                if($ut_id == 3 && $result_modulo)
                {
                    // Veo si el modulo esta habilitado
                    $query = $this->db->query('SELECT *
                                                FROM gim_modulos_permisos AS GMP
                                                WHERE GMP.gim_id='.$gim_id.'
                                                AND GMP.gim_mod_id = '.$result_modulo['gim_mod_id']);
                    $result = $query->row_array();
                    if($result)
                    {
                        return TRUE;
                    }
                }
                else
                {
                    return TRUE;
                }
            }
            else
            {
                $query = $this->db->query('SELECT *
                                            FROM permisos AS P
                                            INNER JOIN paginas AS PA ON P.pag_id = PA.pag_id
                                            WHERE P.ut_id = '.$ut_id.'
                                            AND PA.pag_class LIKE "'.$class.'"
                                            AND PA.pag_method LIKE "'.$method.'"');
                $result = $query->row_array();
                if($result)
                {
                    if($ut_id == 3)
                    {
                        // Veo si el modulo esta habilitado
                        $query = $this->db->query('SELECT *
                                                    FROM gim_modulos_permisos AS GMP
                                                    WHERE GMP.gim_id='.$gim_id.'
                                                    AND GMP.gim_mod_id = '.$result_modulo['gim_mod_id']);
                        $result = $query->row_array();
                        if($result)
                        {
                            return TRUE;
                        }
                    }
                    else
                    {
                        return TRUE;
                    }
                }
            }
        }

        return FALSE;
    }

    public function set_item($nombre, $apellido, $clave='', $mail='', $ut_id=ALUMNO)
    {
    	$data = array(
    		'usr_id' => NULL,
            'usr_mail' => $mail,
            'usr_clave' => $clave,
    		'usr_nombre' => $nombre,
    		'usr_apellido' => $apellido,
    		'usr_fecha' => date('Y-m-d'),
            'ut_id' => $ut_id
    	);

    	$this->db->insert('usuarios', $data);
        return $this->db->insert_id();
    }

    public function update_item($usr_id, $nombre, $apellido, $clave='', $mail='')
    {
        $data = array(
            'usr_mail' => $mail,
            'usr_clave' => $clave,
            'usr_nombre' => $nombre,
            'usr_apellido' => $apellido,
        );

        $this->db->where('usr_id', $usr_id);
        return $this->db->update('usuarios', $data);
    }

    public function update_dato($usr_id, $nombre, $valor)
    {
        if($nombre == "usr_fecha_nac")
        {
            $valor = formatear_fecha($valor,1);
        }
        
        $data = array(
            $nombre => $valor
        );

        $this->db->where('usr_id', $usr_id);
        return $this->db->update('usuarios', $data);
    }

    public function set_foto($usr_id, $imagen)
    {
        $data = array(
            'usr_imagen' => $imagen
        );

        $this->db->where('usr_id',$usr_id);
        return $this->db->update('usuarios', $data);
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
        return $this->db->update('usuarios', $data);
    }

    public function update_tipo_item($usr_id, $tipo)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $data = array(
            'tu_id' => $tipo
        );

        $this->db->where('usr_id',$usr_id);
        return $this->db->update('Usuarios', $data);
    }

    public function delete_item($usr_id)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where('usr_id',$usr_id);
        return $this->db->delete('usuarios');
    }

    /*****************
    DATOS FACTURACION
    ******************/

    public function get_datos_facturacion($usr_id)
    {
        if($usr_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM usuarios_datos_facturacion AS UDF
                                    WHERE UDF.usr_id = '.$usr_id);
        return $query->row_array();
    }

    public function set_datos_facturacion($usr_id, $nombre, $apellido, $empresa='', $id='', $pais, $telefono, $direccion, $cp)
    {
        $data = array(
            'usr_id' => $usr_id,
            'usr_dat_fac_nombre' => $nombre,
            'usr_dat_fac_apellido' => $apellido,
            'usr_dat_fac_empresa' => $empresa,
            'usr_dat_fac_id' => $id,
            'ctry_code' => $pais,
            'usr_dat_fac_telefono' => $telefono,
            'usr_dat_fac_direccion' => $direccion,
            'usr_dat_fac_cp' => $cp
        );

        return $this->db->insert('usuarios_datos_facturacion', $data);
    }

    public function update_datos_facturacion($usr_id, $nombre, $apellido, $empresa='', $id='', $pais, $telefono, $direccion, $cp)
    {
        $data = array(
            'usr_dat_fac_nombre' => $nombre,
            'usr_dat_fac_apellido' => $apellido,
            'usr_dat_fac_empresa' => $empresa,
            'usr_dat_fac_id' => $id,
            'ctry_code' => $pais,
            'usr_dat_fac_telefono' => $telefono,
            'usr_dat_fac_direccion' => $direccion,
            'usr_dat_fac_cp' => $cp
        );

        $this->db->where('usr_id', $usr_id);
        return $this->db->update('usuarios_datos_facturacion', $data);
    }

}