<?php
class Mails_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_item($mail_id = FALSE)
    {
        if ($mail_id === FALSE)
        {
            $query = $this->db->query('SELECT *
                                        FROM Mails AS M');
            return $query->result_array();
        }

        $query = $this->db->query('SELECT *
                                    FROM Mails AS M
                                    WHERE M.mail_id ='.$mail_id);
        return $query->row_array();
    }

    public function get_item_user_codigo($usr_id = FALSE, $codigo = FALSE)
    {
        if ($usr_id === FALSE || $codigo === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM Mails AS M
                                    WHERE M.usr_id ='.$usr_id.'
                                    AND M.mail_codigo="'.$codigo.'"');
        return $query->row_array();
    }

    public function get_item_id_codigo($mail_id = FALSE, $codigo = FALSE)
    {
        if ($mail_id === FALSE || $codigo === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM Mails AS M
                                    WHERE M.mail_id ='.$mail_id.'
                                    AND M.mail_codigo="'.$codigo.'"');
        return $query->row_array();
    }

    public function get_item_user($usr_id = FALSE, $mail = FALSE)
    {
        if ($usr_id === FALSE || $mail === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM Mails AS M
                                    WHERE M.usr_id ='.$usr_id.'
                                    AND M.mail_direccion="'.$mail.'"');
        return $query->row_array();
    }

    public function existe_mail($mail)
    {
        if ($mail === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->get_where('Mails', array('mail_direccion' => $mail));

        if($query->num_rows()>0)
            return TRUE;

        return FALSE;
    }

    public function existe_mail_usuario($mail = FALSE, $usr_id = FALSE)
    {
        if ($mail === FALSE || $usr_id == FALSE)
        {
            return FALSE;
        }

        $query = $this->db->get_where('Mails', array('usr_id' => $usr_id, 'mail_direccion' => $mail));

        if($query->num_rows()>0)
            return $query->row_array();

        return FALSE;
    }

    public function set_item($usr_id, $mail_direccion, $mail_codigo, $mail_estado)
    {
    	$data = array(
    		'mail_id' => NULL,
    		'usr_id' => $usr_id,
    		'mail_direccion' => $mail_direccion,
            'mail_codigo' => $mail_codigo,
    		'mail_estado' => $mail_estado
    	);

    	$this->db->insert('Mails', $data);
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

    public function delete_items_usuario($usr_id)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('usr_id'=>$usr_id));
        return $this->db->delete('Mails');
    }

    public function delete_item($usr_id)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('usr_id'=>$usr_id));
        return $this->db->delete('Usuarios');
    }

}