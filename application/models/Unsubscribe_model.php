<?php
class Unsubscribe_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($uns_id = FALSE)
    {
        if ($uns_id === FALSE)
        {
            $query = $this->db->query('SELECT *
                                        FROM unsubscribes AS U');
            return $query->result_array();
        }

        $query = $this->db->query('SELECT *
                                    FROM unsubscribes AS U
                                    WHERE U.uns_id ='.$uns_id);
        return $query->row_array();
    }

    public function set_item($mail_id)
    {
    	$data = array(
    		'uns_id' => NULL,
    		'mail_id' => $mail_id
    	);

    	$this->db->insert('unsubscribes', $data);
        return $this->db->insert_id();
    }

}