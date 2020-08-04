<?php
class Referencias_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($usr_id = FALSE, $ref_id = FALSE)
    {
        if($usr_id === FALSE)
        {
            return FALSE;
        }

        if($ref_id === FALSE)
        {
            $query = $this->db->query("SELECT *
                                        FROM referencias AS R
                                        WHERE R.usr_id=".$usr_id);
            return $query->result_array();
        }

        $query = $this->db->query("SELECT *
                                    FROM referencias AS R
                                    WHERE R.usr_id=".$usr_id."
                                    AND R.ref_id=".$ref_id);
        return $query->row_array();
    }

    public function check_item($usr_id = FALSE, $mail = FALSE)
    {
        if($usr_id === FALSE || $mail === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM referencias AS R
                                    WHERE R.usr_id=".$usr_id."
                                    AND R.ref_mail='".$mail."'
                                    AND R.ref_est_id <> ".REFERENCIA_RECHAZADA);
        return $query->row_array();
    }

    public function get_items_validados($usr_id = FALSE)
    {
        if($usr_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM referencias AS R
                                    WHERE R.usr_id=".$usr_id."
                                    AND R.ref_est_id=".REFERENCIA_VALIDADA);
        return $query->result_array();
    }

    public function get_cant_validados($usr_id = FALSE)
    {
        if($usr_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT COUNT(1) as cant
                                    FROM referencias AS R
                                    WHERE R.usr_id=".$usr_id."
                                    AND R.ref_est_id=".REFERENCIA_VALIDADA);
        return $query->row_array();
    }

    public function set_item($usr_id, $mail)
    {
        $data = array(
            'ref_id' => NULL,
            'usr_id' => $usr_id,
            'ref_mail' => $mail,
            'ref_est_id' => REFERENCIA_PENDIENTE,
            'ref_fecha' => date('Y-m-d H:i:s')
        );

        $this->db->insert('referencias', $data);
        return $this->db->insert_id();
    }

    public function validar_item($usr_id, $ref_id)
    {
        $data = array(
            'ref_est_id' => REFERENCIA_VALIDADA
        );

        $this->db->where(array('ref_id'=>$ref_id, 'usr_id'=>$usr_id));
        return $this->db->update('referencias', $data);
    }

    public function delete_item($ref_id)
    {
        if ($ref_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('ref_id'=>$ref_id));
        return $this->db->delete('referencias');
    }

}