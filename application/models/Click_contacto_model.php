<?php
class Click_contacto_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function set_item($usr_id_origen=NULL, $usr_id_destino=NULL, $cc_contenido=NULL, $cc_tipo=NULL)
    {
        if($usr_id_origen == "")
        {
            $usr_id_origen = NULL;
        }
        if($usr_id_destino == "")
        {
            $usr_id_destino = NULL;
        }
        if($cc_contenido == "")
        {
            $cc_contenido = NULL;
        }
        if($cc_tipo == "")
        {
            $cc_tipo = NULL;
        }

        $data = array(
            'cc_id' => NULL,
            'cc_fecha' => date('Y-m-d H:i:s'),
            'usr_id_origen' => $usr_id_origen,
            'usr_id_destino' => $usr_id_destino,
            'cc_contenido' => $cc_contenido,
            'cc_tipo' => $cc_tipo
        );

        $this->db->insert('click_contacto', $data);
        return $this->db->insert_id();
    }

}