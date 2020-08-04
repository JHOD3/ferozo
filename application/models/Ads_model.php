<?php
class Ads_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_items($lang = "en", $id =FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->query("SELECT *
                                        FROM ads AS A
                                        AND A.ads_estado = 1
                                        ORDER BY RAND()");

            return $query->result_array();
        }

        $query = $this->db->query("SELECT *
                                    FROM ads AS A
                                    WHERE A.ads_id=".$id);

        return $query->row_array();
    }

    public function get_items_match($lang = "en", $id =FALSE)
    {
        if($id == FALSE)
        {
            $query = $this->db->query("SELECT *
                                        FROM ads AS A
                                        INNER JOIN usuarios_ads_saldo AS UAS ON A.usr_id = UAS.usr_id
                                        WHERE A.ads_estado = 1
                                        AND ((
                                            A.ads_tipo_id = ".TARGET_ADS."
                                            AND A.ads_id IN (SELECT AC.ads_id FROM ads_countrys AS AC WHERE AC.ctry_code IN (SELECT P.ctry_code FROM Productos AS P WHERE P.usr_id=".$this->session->userdata('usr_id')."))
                                            AND A.ads_id IN (SELECT AA.ads_id FROM ads_aranceles AS AA WHERE AA.ara_id IN (SELECT P2.ara_id FROM Productos AS P2 WHERE P2.usr_id=".$this->session->userdata('usr_id')."))
                                            
                                        )
                                        OR
                                        (
                                            A.ads_tipo_id = ".MARKET_ADS."
                                            AND A.ads_id IN (SELECT AC.ads_id FROM ads_countrys AS AC WHERE AC.ctry_code = '".$this->session->userdata('usr_pais')."')
                                        ))
                                        AND UAS.saldo >= (SELECT ads_imp_valor FROM ads_importes WHERE ads_imp_id = ".ADS_ID_IMPORTE_IMPRESION.")
                                        AND ".$this->session->userdata('usr_id')." NOT IN (SELECT ads_blo_usr_id FROM ads_bloqueos WHERE usr_id = A.usr_id)
                                        ORDER BY RAND()");

            return $query->result_array();
        }

        $query = $this->db->query("SELECT *
                                    FROM ads AS A
                                    WHERE A.ads_id=".$id);

        return $query->row_array();
    }

    public function get_items_x_pais($lang = "en", $ctry_code = FALSE)
    {
        if($ctry_code == FALSE)
        {
            return FALSE;
        }

        $bloqueo = "";
        if($this->session->userdata('usr_id') != "")
        {
            $bloqueo = "AND ".$this->session->userdata('usr_id')." NOT IN (SELECT ads_blo_usr_id FROM ads_bloqueos WHERE usr_id = A.usr_id)";
        }

        $query = $this->db->query("SELECT A.*
                                    FROM ads AS A
                                    INNER JOIN usuarios_ads_saldo AS UAS ON A.usr_id = UAS.usr_id
                                    WHERE A.ads_tipo_id = ".MARKET_ADS."
                                    AND A.ads_id IN (SELECT AC.ads_id FROM ads_countrys AS AC WHERE AC.ctry_code = '".$ctry_code."')
                                    AND A.ads_estado = 1
                                    AND UAS.saldo >= (SELECT ads_imp_valor FROM ads_importes WHERE ads_imp_id = ".ADS_ID_IMPORTE_IMPRESION.")
                                    ".$bloqueo."
                                    ORDER BY RAND()");

        return $query->result_array();
    }

    public function get_item_imagenes($id = FALSE)
    {
        if($id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM ads_imagenes AS AI
                                    WHERE AI.ads_id=".$id);

        return $query->result_array();
    }

    public function set_item_impresion($ads_id, $usr_id = FALSE)
    {
        $importe = 0;
        $query = $this->db->get_where('ads_importes', array('ads_imp_id' => ADS_ID_IMPORTE_IMPRESION));
        $select = $query->row_array();
        if($select)
        {
            $importe = $select['ads_imp_valor'];
        }

        $data = array(
            'ads_imp_id' => NULL,
            'ads_id' => $ads_id,
            'usr_id' => $usr_id,
            'ads_imp_fecha' => date('Y-m-d H:i:s'),
            'ads_imp_importe' => $importe
        );

        $this->db->insert('ads_impresion', $data);
        return $this->db->insert_id();
    }

    public function set_item_click($ads_id, $usr_id = FALSE)
    {
        $importe = 0;
        $query = $this->db->get_where('ads_importes', array('ads_imp_id' => ADS_ID_IMPORTE_CLICK));
        $select = $query->row_array();
        if($select)
        {
            $importe = $select['ads_imp_valor'];
        }

        $data = array(
            'ads_click_id' => NULL,
            'ads_id' => $ads_id,
            'usr_id' => $usr_id,
            'ads_click_fecha' => date('Y-m-d H:i:s'),
            'ads_click_importe' => $importe
        );

        $this->db->insert('ads_click', $data);
        return $this->db->insert_id();
    }

    public function set_item_form($ads_id, $usr_id = FALSE, $ads_form_nombre = "", $ads_form_mail = FALSE, $ads_form_telefono = FALSE, $ads_form_consulta = FALSE)
    {
        $importe = 0;
        $query = $this->db->get_where('ads_importes', array('ads_imp_id' => ADS_ID_IMPORTE_FORMULARIO));
        $select = $query->row_array();
        if($select)
        {
            $importe = $select['ads_imp_valor'];
        }
        
        $data = array(
            'ads_form_id' => NULL,
            'ads_id' => $ads_id,
            'usr_id' => $usr_id,
            'ads_form_nombre' => $ads_form_nombre,
            'ads_form_mail' => $ads_form_mail,
            'ads_form_telefono' => $ads_form_telefono,
            'ads_form_consulta' => $ads_form_consulta,
            'ads_form_fecha' => date('Y-m-d H:i:s'),
            'ads_form_importe' => $importe
        );

        $this->db->insert('ads_forms', $data);
        return $this->db->insert_id();
    }

    public function get_user_ads($usr_id)
    {
        if($usr_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM usuarios_ads
                                    WHERE usr_id=".$usr_id);

        return $query->row_array();
    }

    public function set_user_ads($usr_id)
    {
        $data = array(
            'usr_id' => $usr_id,
            'usr_ads_fecha_ini' => date('Y-m-d H:i:s'),
            'usr_ads_estado' => 1
        );

        return $this->db->insert('usuarios_ads', $data);
    }

}