<?php
class Administradores_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($usr_id = FALSE)
    {
        if ($usr_id === FALSE)
        {
            $query = $this->db->query('SELECT *
                                    FROM administradores');
            return $query->result_array();
        }

        $query = $this->db->query('SELECT *
                                    FROM administradores
                                    WHERE admin_id ='.$usr_id);
        return $query->row_array();
    }

    public function get_items_byMail($usr_mail = FALSE)
    {
        if ($usr_mail === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM administradores AS C
                                    WHERE C.usr_mail ="'.$usr_mail.'"
                                    LIMIT 1');
        return $query->row_array();
    }

    public function login($usuario, $clave)
    {
        if ($usuario === FALSE || $clave === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->get_where('administradores', array('admin_usuario' => $usuario, 'admin_clave' => $clave));
        return $query->row_array();
    }

    public function existe_mail($mail)
    {
        if ($mail === FALSE)
    	{
    		return FALSE;
    	}

        $query = $this->db->get_where('administradores', array('usr_mail' => $mail));

        if($query->num_rows()>0)
    	    return TRUE;

        return FALSE;
    }

    public function set_item($nombre, $apellido, $mail, $clave, $usuario, $pais, $sexo, $newsletter)
    {
    	$data = array(
    		'usr_id' => NULL,
    		'usr_nombre' => $nombre,
    		'usr_apellido' => $apellido,
    		'usr_clave' => $clave,
    		'usr_mail' => $mail,
    		'usr_fecha' => NULL,
            'usr_usuario' => $usuario,
            'usr_pais' => $pais,
            'usr_sexo' => $sexo,
            'usr_newsletter' => $newsletter
    	);

    	$this->db->insert('usuarios', $data);
        return $this->db->insert_id();
    }

    public function update_item($usr_id, $nombre, $apellido, $mail, $telefono, $sexo, $imagen)
    {
        $data = array(
            'usr_nombre' => $nombre,
            'usr_apellido' => $apellido,
            'usr_mail' => $mail,
            'usr_telefono' => $telefono,
            'usr_sexo' => $sexo,
            'usr_imagen' => $imagen
        );

        $this->db->where('usr_id',$usr_id);
        return $this->db->update('usuarios', $data);
    }

    public function update_clave($usr_id, $clave)
    {
        $data = array(
            'usr_clave' => $clave
        );

        $this->db->where('usr_id',$usr_id);
        return $this->db->update('usuarios', $data);
    }

    public function update_telefono($usr_id, $telefono)
    {
        $data = array(
            'usr_telefono' => $telefono
        );

        $this->db->where('usr_id',$usr_id);
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

    public function delete_item($usr_id)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where('usr_id',$usr_id);
        return $this->db->delete('usuarios');
    }

}