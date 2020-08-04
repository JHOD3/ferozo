<?php
class Accesos_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function set_item($acc_plataforma, $acc_navegador, $acc_mobile, $acc_robot, $acc_referred, $acc_ip, $acc_pais, $acc_ciudad, $acc_region, $acc_lat, $acc_lng, $acc_session, $acc_extra, $usr_id = NULL)
    {
        $data = array(
            'acc_id' => NULL,
            'acc_fecha' => date('Y-m-d H:i:s'),
            'acc_plataforma' => $acc_plataforma,
            'acc_navegador' => $acc_navegador,
            'acc_mobile' => $acc_mobile,
            'acc_robot' => $acc_robot,
            'acc_referred' => $acc_referred,
            'acc_ip' => $acc_ip,
            'acc_pais' => $acc_pais,
            'acc_ciudad' => $acc_ciudad,
            'acc_region' => $acc_region,
            'acc_lat' => $acc_lat,
            'acc_lng' => $acc_lng,
            'acc_session' => $acc_session,
            'acc_extra' => $acc_extra,
            'usr_id' => $usr_id
        );

        $this->db->insert('accesos', $data);
        return $this->db->insert_id();
    }

    public function get_items_mapa()
    {
        $query = $this->db->query("SELECT A.acc_lat, A.acc_lng
                                    FROM accesos AS A
                                    WHERE A.acc_lat IS NOT NULL
                                    AND A.acc_lng IS NOT NULL
                                    GROUP BY A.acc_lat, A.acc_lng");
        return $query->result_array();
    }

}