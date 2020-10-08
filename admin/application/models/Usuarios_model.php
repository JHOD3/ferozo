<?php
class Usuarios_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($usr_id = FALSE)
    {
        if($usr_id === FALSE)
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

    public function get_cantidad($estado = FALSE)
    {
        if($estado == FALSE)
        {
            $query = $this->db->query('SELECT COUNT(1) as cant
                                        FROM Usuarios AS U');
            return $query->row_array();
        }

        $query = $this->db->query('SELECT COUNT(1) as cant
                                    FROM Usuarios AS U
                                    WHERE U.usr_estado = '.$estado);
        return $query->row_array();
    }

    public function get_items_x_fecha($fecha_ini = FALSE, $fecha_fin = FALSE, $estado = 1)
    {
        if($fecha_ini === FALSE)
        {
            return FALSE;
        }

        if($fecha_fin === FALSE)
        {
            $query = $this->db->query('SELECT *
                                        FROM Usuarios AS U
                                        WHERE U.usr_fecha >= "'.$fecha_ini.' 00:00:00"
                                        AND U.usr_estado = '.$estado);
            return $query->result_array();
        }
        
        $query = $this->db->query('SELECT *
                                    FROM Usuarios AS U
                                    WHERE U.usr_fecha >= "'.$fecha_ini.' 00:00:00"
                                    AND U.usr_fecha < "'.$fecha_fin.' 00:00:00"
                                    AND U.usr_estado = '.$estado);
        return $query->result_array();
    }

    public function get_items_byMail($usr_mail = FALSE)
    {
        if ($usr_mail === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM Usuarios AS C
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

        $query = $this->db->get_where('usuarios', array('usr_usuario' => $usuario, 'usr_clave' => $clave));
        return $query->row_array();
    }

    public function existe_mail($mail)
    {
        if ($mail === FALSE)
    	{
    		return FALSE;
    	}

        $query = $this->db->get_where('usuarios', array('usr_mail' => $mail));

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