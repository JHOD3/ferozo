<?php
class Cobranzas_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_items($usr_id=FALSE, $cob_id=FALSE)
    {
        if($usr_id==FALSE && $cob_id==FALSE)
        {
            return FALSE;
        }

        if($cob_id == FALSE)
        {
            $query = $this->db->query("SELECT C.*,
                                            CU.cob_usr_id, CU.cob_usr_tipo_id,
                                            P.pal_desc_".$this->session->userdata('idi_code')." as cob_usr_tipo_desc, CE.cob_est_desc_".$this->session->userdata('idi_code')." as cob_est_desc, CE.cob_est_color
                                        FROM cobranzas AS C
                                        INNER JOIN cobranzas_usuarios AS CU ON C.cob_id = CU.cob_id
                                        INNER JOIN cobranzas_usuarios_tipos AS CUT ON CU.cob_usr_tipo_id = CUT.cob_usr_tipo_id
                                        INNER JOIN cobranzas_estados AS CE ON C.cob_est_id = CE.cob_est_id
                                        INNER JOIN palabras AS P ON CUT.pal_id = P.pal_id
                                        WHERE CU.usr_id = ".$usr_id);
            return $query->result_array();
        }

        $query = $this->db->query("SELECT C.*,
                                        CU.cob_usr_id, CU.cob_usr_tipo_id,
                                        P.pal_desc_".$this->session->userdata('idi_code')." as cob_usr_tipo_desc, CE.cob_est_desc_".$this->session->userdata('idi_code')." as cob_est_desc, CE.cob_est_color
                                    FROM cobranzas AS C
                                    INNER JOIN cobranzas_usuarios AS CU ON C.cob_id = CU.cob_id
                                    INNER JOIN cobranzas_usuarios_tipos AS CUT ON CU.cob_usr_tipo_id = CUT.cob_usr_tipo_id
                                    INNER JOIN cobranzas_estados AS CE ON C.cob_est_id = CE.cob_est_id
                                    INNER JOIN palabras AS P ON CUT.pal_id = P.pal_id
                                    WHERE C.cob_id = ".$cob_id);
        return $query->row_array();
    }

    public function get_item_x_codigo($cob_codigo=FALSE)
    {
        if($cob_codigo==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT C.*,
                                        CU.cob_usr_id, CU.cob_usr_tipo_id,
                                        P.pal_desc_".$this->session->userdata('idi_code')." as cob_usr_tipo_desc, CE.cob_est_desc_".$this->session->userdata('idi_code')." as cob_est_desc, CE.cob_est_color
                                    FROM cobranzas AS C
                                    INNER JOIN cobranzas_usuarios AS CU ON C.cob_id = CU.cob_id
                                    INNER JOIN cobranzas_usuarios_tipos AS CUT ON CU.cob_usr_tipo_id = CUT.cob_usr_tipo_id
                                    INNER JOIN cobranzas_estados AS CE ON C.cob_est_id = CE.cob_est_id
                                    INNER JOIN palabras AS P ON CUT.pal_id = P.pal_id
                                    WHERE C.cob_codigo = '".$cob_codigo."'");
        return $query->row_array();
    }

    public function set_item($usr_id, $cob_nombre="", $cob_descripcion="", $cob_est_id=0, $cob_codigo="", $cob_detalle_documentacion=NULL, $cob_acciones_requeridas=NULL, $mon_code=NULL)
    {
        $data = array(
            'cob_id' => NULL,
            'usr_id' => $usr_id,
            'cob_nombre' => $cob_nombre,
            'cob_descripcion' => $cob_descripcion,
            'cob_est_id' => $cob_est_id,
            'cob_fecha' => date('Y-m-d H:i:s'),
            'cob_codigo' => $cob_codigo,
            'cob_detalle_documentacion' => $cob_detalle_documentacion,
            'cob_acciones_requeridas' => $cob_acciones_requeridas,
            'mon_code' => $mon_code
        );

        $this->db->insert('cobranzas', $data);
        $id = $this->db->insert_id();

        $this->set_permisos_default($id);

        return $id;
    }

    public function update_item($cob_id, $cob_nombre="", $cob_descripcion="", $cob_detalle_documentacion=NULL, $cob_acciones_requeridas=NULL)
    {
        $data = array(
            'cob_nombre' => $cob_nombre,
            'cob_descripcion' => $cob_descripcion,
            'cob_detalle_documentacion' => $cob_detalle_documentacion,
            'cob_acciones_requeridas' => $cob_acciones_requeridas
        );

        $this->db->where(array('cob_id'=>$cob_id));
        return $this->db->update('cobranzas', $data);
    }

    public function update_estado($cob_id, $cob_est_id=0)
    {
        $data = array(
            'cob_est_id' => $cob_est_id
        );

        $this->db->where(array('cob_id'=>$cob_id));
        return $this->db->update('cobranzas', $data);
    }

    public function update_fecha($cob_id)
    {
        $data = array(
            'cob_fecha_modif' => date('Y-m-d H:i:s')
        );

        $this->db->where(array('cob_id'=>$cob_id));
        return $this->db->update('cobranzas', $data);
    }

    public function delete_item($cob_id)
    {
        if ($cob_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('cob_id'=>$cob_id));
        return $this->db->delete('cobranzas');
    }

    /*********************
    ESTADOS
    *********************/

    public function get_estados()
    {
        $query = $this->db->query("SELECT CE.cob_est_id, CE.cob_est_desc_".$this->session->userdata('idi_code')." as cob_est_desc
                                    FROM cobranzas_estados AS CE");
        return $query->result_array();
    }

    public function get_documentos_estados()
    {
        $query = $this->db->query("SELECT CE.cob_doc_est_id, CE.cob_doc_est_desc_".$this->session->userdata('idi_code')." as cob_doc_est_desc
                                    FROM cobranzas_documentos_estados AS CE");
        return $query->result_array();
    }

    /*********************
    TIPOS DE USUARIOS
    *********************/

    public function get_tipos($lang="es", $cob_usr_tipo_id=FALSE)
    {
        if($cob_usr_tipo_id==FALSE)
        {
            $query = $this->db->query("SELECT CUT.cob_usr_tipo_id, P.pal_desc_".$lang." as cob_usr_tipo_desc
                                        FROM cobranzas_usuarios_tipos AS CUT
                                        INNER JOIN palabras AS P ON CUT.pal_id = P.pal_id
                                        ORDER BY CUT.cob_usr_tipo_id");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT CUT.cob_usr_tipo_id, P.pal_desc_".$lang." as cob_usr_tipo_desc
                                    FROM cobranzas_usuarios_tipos AS CUT
                                    INNER JOIN palabras AS P ON CUT.pal_id = P.pal_id
                                    WHERE CUT.cob_usr_tipo_id = ".$cob_usr_tipo_id);
        return $query->row_array();
    }

    public function get_item_usuarios($cob_id=FALSE, $usr_id=FALSE)
    {
        if($cob_id==FALSE)
        {
            return FALSE;
        }

        if($usr_id==FALSE)
        {
            $query = $this->db->query("SELECT *
                                        FROM cobranzas_usuarios AS CU
                                        INNER JOIN Usuarios AS U ON CU.usr_id = U.usr_id
                                        WHERE CU.cob_id = ".$cob_id);
            return $query->result_array();
        }

        $query = $this->db->query("SELECT *
                                    FROM cobranzas_usuarios AS CU
                                    INNER JOIN Usuarios AS U ON CU.usr_id = U.usr_id
                                    WHERE CU.cob_id = ".$cob_id."
                                    AND CU.usr_id = ".$usr_id);
        return $query->row_array();
    }

    public function get_item_usuario_x_tipo($cob_id=FALSE, $tipo=FALSE)
    {
        if($cob_id==FALSE || $tipo==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM cobranzas_usuarios AS CU
                                    INNER JOIN Usuarios AS U ON CU.usr_id = U.usr_id
                                    WHERE CU.cob_id = ".$cob_id."
                                    AND CU.cob_usr_tipo_id = ".$tipo);
        return $query->row_array();
    }

    public function set_usuario($cob_id, $usr_id, $cob_usr_tipo_id=0)
    {
        $data = array(
            'cob_usr_id' => NULL,
            'cob_id' => $cob_id,
            'usr_id' => $usr_id,
            'cob_usr_tipo_id' => $cob_usr_tipo_id
        );

        $this->db->insert('cobranzas_usuarios', $data);
        return $this->db->insert_id();
    }

    public function delete_usuario($cob_usr_id)
    {
        if($cob_usr_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('cob_usr_id'=>$cob_usr_id));
        return $this->db->delete('cobranzas_usuarios');
    }


    /*********************
    DOCUMENTOS
    *********************/

    public function get_item_documentos($cob_id=FALSE, $cob_doc_id=FALSE)
    {
        if($cob_id==FALSE && $cob_doc_id==FALSE)
        {
            return FALSE;
        }

        if($cob_doc_id==FALSE)
        {
            $query = $this->db->query("SELECT CD.*, CDE.cob_doc_est_desc_".$this->session->userdata('idi_code')." as cob_doc_est_desc, CDE.cob_doc_est_color
                                        FROM cobranzas_documentos AS CD
                                        INNER JOIN cobranzas_documentos_estados AS CDE ON CD.cob_doc_est_id = CDE.cob_doc_est_id
                                        WHERE CD.cob_id = ".$cob_id);
            return $query->result_array();
        }

        $query = $this->db->query("SELECT *
                                    FROM cobranzas_documentos AS CD
                                    WHERE CD.cob_doc_id = ".$cob_doc_id);
        return $query->row_array();
    }

    public function set_documento($cob_id, $usr_id, $cob_doc_nombre="", $cob_doc_ruta="", $cob_doc_est_id=COBRANZA_DOCUMENTO_ESTADO_ENVIADO)
    {
        $data = array(
            'cob_doc_id' => NULL,
            'cob_id' => $cob_id,
            'usr_id' => $usr_id,
            'cob_doc_nombre' => $cob_doc_nombre,
            'cob_doc_ruta' => $cob_doc_ruta,
            'cob_doc_est_id' => $cob_doc_est_id,
            'cob_doc_fecha' => date('Y-m-d H:i:s'),
        );

        $this->db->insert('cobranzas_documentos', $data);
        return $this->db->insert_id();
    }

    public function update_documento($cob_doc_id, $cob_doc_nombre="", $cob_doc_ruta="")
    {
        $data = array(
            'cob_doc_nombre' => $cob_doc_nombre,
            'cob_doc_ruta' => $cob_doc_ruta,
        );

        $this->db->where(array('cob_doc_id'=>$cob_doc_id));
        return $this->db->update('cobranzas_documentos', $data);
    }

    public function update_documento_estado($cob_doc_id, $cob_doc_est_id=0)
    {
        $data = array(
            'cob_doc_est_id' => $cob_doc_est_id
        );

        $this->db->where(array('cob_doc_id'=>$cob_doc_id));
        return $this->db->update('cobranzas_documentos', $data);
    }

    public function delete_documento($cob_doc_id)
    {
        if($cob_doc_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('cob_doc_id'=>$cob_doc_id));
        return $this->db->delete('cobranzas_documentos');
    }

    /*********************
    DOCUMENTOS NOTAS
    *********************/
    
    public function get_documento_notas($cob_doc_id=FALSE)
    {
        if($cob_doc_id==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM cobranzas_documentos_notas AS CDN
                                    WHERE CDN.cob_doc_id = ".$cob_doc_id);
        return $query->result_array();
    }

    public function set_documento_nota($cob_doc_id, $usr_id, $cob_doc_not_titulo, $cob_doc_not_texto="", $cob_doc_not_tipo=0, $cob_doc_not_estado=0, $cob_doc_not_pos_x=0, $cob_doc_not_pos_y=0)
    {
        $data = array(
            'cob_doc_not_id' => NULL,
            'cob_doc_id' => $cob_doc_id,
            'cob_doc_not_titulo' => $cob_doc_not_titulo,
            'cob_doc_not_texto' => $cob_doc_not_texto,
            'cob_doc_not_tipo' => $cob_doc_not_tipo,
            'cob_doc_not_estado' => $cob_doc_not_estado,
            'cob_doc_not_pos_x' => $cob_doc_not_pos_x,
            'cob_doc_not_pos_y' => $cob_doc_not_pos_y,
            'usr_id' => $usr_id,
            'cob_doc_not_fecha' => date('Y-m-d H:i:s')
        );

        $this->db->insert('cobranzas_documentos_notas', $data);
        return $this->db->insert_id();
    }

    public function update_documento_nota($cob_doc_not_id, $cob_doc_not_titulo="", $cob_doc_not_texto="", $cob_doc_not_pos_x=0, $cob_doc_not_pos_y=0)
    {
        $data = array(
            'cob_doc_not_titulo' => $cob_doc_not_titulo,
            'cob_doc_not_texto' => $cob_doc_not_texto,
            'cob_doc_not_pos_x' => $cob_doc_not_pos_x,
            'cob_doc_not_pos_y' => $cob_doc_not_pos_y
        );

        $this->db->where(array('cob_doc_not_id'=>$cob_doc_not_id));
        return $this->db->update('cobranzas_documentos_notas', $data);
    }

    public function update_documento_nota_estado($cob_doc_not_id, $cob_doc_not_estado=0)
    {
        $data = array(
            'cob_doc_not_estado' => $cob_doc_not_estado
        );

        $this->db->where(array('cob_doc_not_id'=>$cob_doc_not_id));
        return $this->db->update('cobranzas_documentos_notas', $data);
    }

    public function delete_documento_nota($cob_doc_not_id)
    {
        if($cob_doc_not_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('cob_doc_not_id'=>$cob_doc_not_id));
        return $this->db->delete('cobranzas_documentos_notas');
    }


    /*********************
    CAMPOS
    *********************/
    
    public function get_campos_tipos($lang="es", $cob_camp_tipo_id=FALSE)
    {
        if($cob_camp_tipo_id==FALSE)
        {
            $query = $this->db->query("SELECT CCT.*, P.pal_desc_".$lang." as pal_desc
                                        FROM cobranzas_campos_tipos AS CCT
                                        INNER JOIN palabras AS P ON CCT.pal_id = P.pal_id
                                        ORDER BY CCT.cob_camp_tipo_id");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT CCT.*, P.pal_desc_".$lang." as pal_desc
                                    FROM cobranzas_campos_tipos AS CCT
                                    INNER JOIN palabras AS P ON CCT.pal_id = P.pal_id
                                    WHERE CCT.cob_camp_tipo_id = ".$cob_camp_tipo_id);
        return $query->row_array();
    }

    public function get_campos_tipos_padre_x_tipo_usuario($lang="es", $cob_usr_tipo_id=FALSE)
    {
        if($cob_usr_tipo_id==FALSE)
        {
            $query = $this->db->query("SELECT CCT.*, P.pal_desc_".$lang." as pal_desc
                                        FROM cobranzas_campos_tipos AS CCT
                                        INNER JOIN palabras AS P ON CCT.pal_id = P.pal_id
                                        WHERE CCT.cob_camp_tipo_id IN (SELECT cob_camp_tipo_id FROM cobranzas_campos WHERE cob_usr_tipo_id IS NULL)
                                        AND CCT.cob_camp_tipo_padre IS NULL");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT DISTINCT(CCT.cob_camp_tipo_id), P.pal_desc_".$lang." as pal_desc
                                    FROM cobranzas_campos_tipos AS CCT
                                    INNER JOIN cobranzas_campos_tipos AS CCT2 ON CCT.cob_camp_tipo_id = CCT2.cob_camp_tipo_padre
                                    INNER JOIN palabras AS P ON CCT.pal_id = P.pal_id
                                    WHERE CCT2.cob_camp_tipo_id IN (SELECT cob_camp_tipo_id FROM cobranzas_campos WHERE cob_usr_tipo_id = ".$cob_usr_tipo_id.")
                                    AND CCT.cob_camp_tipo_padre IS NULL");
        return $query->result_array();
    }

    public function get_campos_tipos_x_tipo_usuario($lang="es", $cob_usr_tipo_id=FALSE)
    {
        if($cob_usr_tipo_id==FALSE)
        {
            $query = $this->db->query("SELECT CCT.*, P.pal_desc_".$lang." as pal_desc
                                        FROM cobranzas_campos_tipos AS CCT
                                        INNER JOIN palabras AS P ON CCT.pal_id = P.pal_id
                                        WHERE CCT.cob_camp_tipo_id IN (SELECT cob_camp_tipo_id FROM cobranzas_campos WHERE cob_usr_tipo_id IS NULL)");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT CCT.*, P.pal_desc_".$lang." as pal_desc
                                    FROM cobranzas_campos_tipos AS CCT
                                    INNER JOIN palabras AS P ON CCT.pal_id = P.pal_id
                                    WHERE CCT.cob_camp_tipo_id IN (SELECT cob_camp_tipo_id FROM cobranzas_campos WHERE cob_usr_tipo_id = ".$cob_usr_tipo_id.")");
        return $query->result_array();
    }

    public function get_campos_tipos_x_tipo_usuario_y_padre($lang="es", $cob_usr_tipo_id=FALSE, $cob_usr_tipo_padre=FALSE)
    {
        if($cob_usr_tipo_id==FALSE)
        {
            $query = $this->db->query("SELECT CCT.*, P.pal_desc_".$lang." as pal_desc
                                        FROM cobranzas_campos_tipos AS CCT
                                        INNER JOIN palabras AS P ON CCT.pal_id = P.pal_id
                                        WHERE CCT.cob_camp_tipo_id IN (SELECT cob_camp_tipo_id FROM cobranzas_campos WHERE cob_usr_tipo_id IS NULL)
                                        AND CCT.cob_camp_tipo_padre = ".$cob_usr_tipo_padre);
            return $query->result_array();
        }

        $query = $this->db->query("SELECT CCT.*, P.pal_desc_".$lang." as pal_desc
                                    FROM cobranzas_campos_tipos AS CCT
                                    INNER JOIN palabras AS P ON CCT.pal_id = P.pal_id
                                    WHERE CCT.cob_camp_tipo_id IN (SELECT cob_camp_tipo_id FROM cobranzas_campos WHERE cob_usr_tipo_id = ".$cob_usr_tipo_id.")
                                    AND CCT.cob_camp_tipo_padre = ".$cob_usr_tipo_padre);
        return $query->result_array();
    }

    public function get_campos_x_tipo($lang="es", $cob_camp_tipo_id=FALSE, $cob_usr_tipo_id=FALSE)
    {
        if($cob_camp_tipo_id==FALSE)
        {
            return FALSE;
        }

        if($cob_usr_tipo_id==FALSE)
        {
            $query = $this->db->query("SELECT CC.*, P.pal_desc_".$lang." as pal_desc
                                        FROM cobranzas_campos AS CC
                                        INNER JOIN palabras AS P ON CC.pal_id = P.pal_id
                                        WHERE CC.cob_camp_tipo_id = ".$cob_camp_tipo_id);
            return $query->result_array();
        }

        $query = $this->db->query("SELECT CC.*, P.pal_desc_".$lang." as pal_desc
                                    FROM cobranzas_campos AS CC
                                    INNER JOIN palabras AS P ON CC.pal_id = P.pal_id
                                    WHERE CC.cob_camp_tipo_id = ".$cob_camp_tipo_id."
                                    AND CC.cob_usr_tipo_id = ".$cob_usr_tipo_id);
        return $query->result_array();
    }

    /********************
    PERMISOS
    ********************/

    public function get_permisos_tipos($lang="es", $cob_per_tipo_id=FALSE)
    {
        if($cob_per_tipo_id==FALSE)
        {
            $query = $this->db->query("SELECT CPT.*, pal_desc_".$lang." as pal_desc
                                        FROM cobranzas_permisos_tipos AS CPT
                                        LEFT JOIN palabras AS P ON CPT.pal_id = P.pal_id");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT CPT.*, pal_desc_".$lang." as pal_desc
                                    FROM cobranzas_permisos_tipos AS CPT
                                    LEFT JOIN palabras AS P ON CPT.pal_id = P.pal_id
                                    WHERE CPT.cob_per_tipo_id = ".$cob_per_tipo_id);
        return $query->row_array();
    }

    public function get_permisos_acciones($lang="es", $cob_per_acc_id=FALSE)
    {
        if($cob_per_acc_id==FALSE)
        {
            $query = $this->db->query("SELECT *
                                        FROM cobranzas_permisos_acciones AS CPA");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT *
                                    FROM cobranzas_permisos_acciones AS CPA
                                    WHERE CPA.cob_per_acc_id = ".$cob_per_acc_id);
        return $query->row_array();
    }

    public function get_permisos($lang="es", $cob_per_id=FALSE)
    {
        if($cob_per_id==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM cobranzas_permisos AS CP
                                    WHERE CP.cob_per_id = ".$cob_per_id);
        return $query->row_array();
    }

    public function get_permisos_cobranza($lang="es", $cob_id=FALSE)
    {
        if($cob_id==FALSE)
        {
            $query = $this->db->query("SELECT *
                                        FROM cobranzas_permisos AS CP
                                        WHERE CP.cob_id IS NULL");
            return $query->result_array();
        }

        $query = $this->db->query("SELECT *
                                    FROM cobranzas_permisos AS CP
                                    WHERE CP.cob_id = ".$cob_id);
        return $query->result_array();
    }

    public function get_permiso_x_cobranza_tipo_accion_tipousuario($lang="es", $cob_id=FALSE, $tipo_id=FALSE, $cob_usr_tipo_id=FALSE, $acc_id=FALSE)
    {
        if($cob_id == FALSE || $tipo_id==FALSE || $cob_usr_tipo_id==FALSE)
        {
            return FALSE;
        }

        if($acc_id == FALSE)
        {
            $query = $this->db->query("SELECT *
                                        FROM cobranzas_permisos AS CP
                                        INNER JOIN cobranzas_permisos_acciones AS CPA ON CP.cob_per_acc_id = CPA.cob_per_acc_id

                                        WHERE CP.cob_id = ".$cob_id."
                                        AND CP.cob_usr_tipo_id=".$cob_usr_tipo_id."
                                        AND CP.cob_per_tipo_id=".$tipo_id);
            return $query->result_array();
        }

        $query = $this->db->query("SELECT *
                                        FROM cobranzas_permisos AS CP
                                        INNER JOIN cobranzas_permisos_acciones AS CPA ON CP.cob_per_acc_id = CPA.cob_per_acc_id
                                        WHERE CP.cob_id = ".$cob_id."
                                        AND CP.cob_usr_tipo_id=".$cob_usr_tipo_id."
                                        AND CP.cob_per_tipo_id=".$tipo_id."
                                        AND CP.cob_per_acc_id=".$acc_id);
        return $query->row_array();
    }

    public function set_permisos_default($cob_id)
    {
        $permisos = $this->get_permisos_cobranza("es");
        if($permisos)
        {
            foreach ($permisos as $key => $value)
            {
                $data = array(
                    'cob_per_id' => NULL,
                    'cob_id' => $cob_id,
                    'cob_usr_tipo_id' => $value['cob_usr_tipo_id'],
                    'cob_per_tipo_id' => $value['cob_per_tipo_id'],
                    'cob_per_acc_id' => $value['cob_per_acc_id'],
                    'cob_per_activo' => $value['cob_per_activo']
                );

                $this->db->insert('cobranzas_permisos', $data);
            }
        }
        
        return TRUE;
    }

    public function set_permiso($cob_id, $cob_usr_tipo_id, $cob_per_tipo_id, $cob_per_acc_id, $cob_per_activo=0)
    {
        $data = array(
            'cob_per_id' => NULL,
            'cob_id' => $cob_id,
            'cob_usr_tipo_id' => $cob_usr_tipo_id,
            'cob_per_tipo_id' => $cob_per_tipo_id,
            'cob_per_acc_id' => $cob_per_acc_id,
            'cob_per_activo' => $cob_per_activo
        );

        $this->db->insert('cobranzas_permisos', $data);
        return $this->db->insert_id();
    }

    public function update_permiso($cob_per_id, $cob_per_activo=0)
    {
        $data = array(
            'cob_per_activo' => $cob_per_activo
        );

        $this->db->where(array('cob_per_id'=>$cob_per_id));
        return $this->db->update('cobranzas_permisos', $data);
    }

    /*******************
    PRODUCTOS
    ******************/

    public function get_productos($lang="es", $cob_id=FALSE)
    {
        if($cob_id==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT CP.*, A.ara_code, A.ara_desc_".$this->session->userdata('idi_code')." as ara_desc
                                    FROM cobranzas_productos AS CP
                                    INNER JOIN Aranceles AS A ON CP.ara_id = A.ara_id
                                    WHERE CP.cob_id = ".$cob_id);
        return $query->result_array();
    }

    public function set_producto($cob_id, $ara_id="", $cob_prod_detalle="", $cob_prod_marca=0, $cob_prod_unidad="", $cob_prod_cantidad=NULL, $cob_prod_tolerancia=NULL, $cob_prod_incoterm=NULL, $ctry_code=NULL, $city_id=NULL, $cob_prod_precio=NULL, $mon_code=NULL, $cob_prod_subtotal=NULL)
    {
        $data = array(
            'cob_prod_id' => NULL,
            'cob_id' => $cob_id,
            'ara_id' => $ara_id,
            'cob_prod_detalle' => $cob_prod_detalle,
            'cob_prod_marca' => $cob_prod_marca,
            'cob_prod_unidad' => $cob_prod_unidad,
            'cob_prod_cantidad' => $cob_prod_cantidad,
            'cob_prod_precio' => $cob_prod_precio,
            'mon_code' => $mon_code,
            'cob_prod_incoterm' => $cob_prod_incoterm,
            'cob_prod_tolerancia' => $cob_prod_tolerancia,
            'ctry_code' => $ctry_code,
            'city_id' => $city_id,
            'cob_prod_subtotal' => $cob_prod_subtotal
        );

        $this->db->insert('cobranzas_productos', $data);
        return $this->db->insert_id();
    }

    public function update_producto($cob_prod_id, $ara_id="", $cob_prod_detalle="", $cob_prod_marca=0, $cob_prod_unidad="", $cob_prod_cantidad=NULL, $cob_prod_tolerancia=NULL, $cob_prod_incoterm=NULL, $ctry_code=NULL, $city_id=NULL, $cob_prod_precio=NULL, $mon_code=NULL, $cob_prod_subtotal=NULL)
    {
        $data = array(
            'ara_id' => $ara_id,
            'cob_prod_detalle' => $cob_prod_detalle,
            'cob_prod_marca' => $cob_prod_marca,
            'cob_prod_unidad' => $cob_prod_unidad,
            'cob_prod_cantidad' => $cob_prod_cantidad,
            'cob_prod_precio' => $cob_prod_precio,
            'mon_code' => $mon_code,
            'cob_prod_incoterm' => $cob_prod_incoterm,
            'cob_prod_tolerancia' => $cob_prod_tolerancia,
            'ctry_code' => $ctry_code,
            'city_id' => $city_id,
            'cob_prod_subtotal' => $cob_prod_subtotal
        );

        $this->db->where(array('cob_prod_id'=>$cob_prod_id));
        return $this->db->update('cobranzas_productos', $data);
    }

    public function delete_producto($cob_prod_id)
    {
        if ($cob_prod_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('cob_prod_id'=>$cob_prod_id));
        return $this->db->delete('cobranzas_productos');
    }

    /*******************
    PRODUCTO SERVICIOS
    ******************/

    public function get_producto_servicios($lang="es", $cob_prod_id=FALSE)
    {
        if($cob_prod_id==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT COS.*, A.ara_code, A.ara_desc_".$this->session->userdata('idi_code')." as ara_desc
                                    FROM cobranzas_productos_servicios AS COS
                                    INNER JOIN Aranceles AS A ON COS.ara_id = A.ara_id
                                    WHERE COS.cob_prod_id = ".$cob_prod_id);
        return $query->result_array();
    }

    public function set_producto_servicio($cob_prod_id, $ara_id=0, $cob_prod_serv_descripcion="", $cob_prod_serv_calculo_importe="", $cob_prod_serv_importe=0, $mon_code="", $cob_prod_serv_subtotal=0)
    {
        $data = array(
            'cob_prod_serv_id' => NULL,
            'cob_prod_id' => $cob_prod_id,
            'ara_id' => $ara_id,
            'cob_prod_serv_descripcion' => $cob_prod_serv_descripcion,
            'cob_prod_serv_calculo_importe' => $cob_prod_serv_calculo_importe,
            'cob_prod_serv_importe' => $cob_prod_serv_importe,
            'mon_code' => $mon_code,
            'cob_prod_serv_subtotal' => $cob_prod_serv_subtotal
        );

        $this->db->insert('cobranzas_productos_servicios', $data);
        return $this->db->insert_id();
    }

    public function update_producto_servicio($cob_prod_serv_id, $ara_id=0, $cob_prod_serv_descripcion="", $cob_prod_serv_calculo_importe="", $cob_prod_serv_importe=0, $mon_code="", $cob_prod_serv_subtotal=0)
    {
        $data = array(
            'ara_id' => $ara_id,
            'cob_prod_serv_descripcion' => $cob_prod_serv_descripcion,
            'cob_prod_serv_calculo_importe' => $cob_prod_serv_calculo_importe,
            'cob_prod_serv_importe' => $cob_prod_serv_importe,
            'mon_code' => $mon_code,
            'cob_prod_serv_subtotal' => $cob_prod_serv_subtotal
        );

        $this->db->where(array('cob_prod_serv_id'=>$cob_prod_serv_id));
        return $this->db->update('cobranzas_productos_servicios', $data);
    }

    public function delete_producto_servicio($cob_prod_serv_id)
    {
        if ($cob_prod_serv_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('cob_prod_serv_id'=>$cob_prod_serv_id));
        return $this->db->delete('cobranzas_productos_servicios');
    }


    /*******************
    OTROS SERVICIOS
    ******************/

    public function get_otros_servicios($lang="es", $cob_id=FALSE)
    {
        if($cob_id==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT COS.*, A.ara_code, A.ara_desc_".$lang." as ara_desc
                                    FROM cobranzas_otros_servicios AS COS
                                    LEFT JOIN Aranceles AS A ON COS.ara_id = A.ara_id
                                    WHERE COS.cob_id = ".$cob_id);
        return $query->result_array();
    }

    public function set_otro_servicio($cob_id, $cob_otro_serv_descripcion="", $ara_id="", $cob_otro_serv_fecha="", $cob_otro_serv_calculo_importe=0, $cob_otro_serv_importe=0, $cob_otro_serv_subtotal=0, $cob_otro_serv_metodo_pago=0)
    {
        $data = array(
            'cob_otro_serv_id' => NULL,
            'cob_id' => $cob_id,
            'cob_otro_serv_descripcion' => $cob_otro_serv_descripcion,
            'ara_id' => $ara_id,
            'cob_otro_serv_fecha' => $cob_otro_serv_fecha,
            'cob_otro_serv_calculo_importe' => $cob_otro_serv_calculo_importe,
            'cob_otro_serv_importe' => $cob_otro_serv_importe,
            'cob_otro_serv_subtotal' => $cob_otro_serv_subtotal,
            'cob_otro_serv_metodo_pago' => $cob_otro_serv_metodo_pago
        );

        $this->db->insert('cobranzas_otros_servicios', $data);
        return $this->db->insert_id();
    }

    public function update_otro_servicio($cob_otro_serv_id, $cob_otro_serv_descripcion="", $ara_id="", $cob_otro_serv_fecha="", $cob_otro_serv_calculo_importe=0, $cob_otro_serv_importe=0, $cob_otro_serv_subtotal=0, $cob_otro_serv_metodo_pago=0)
    {
        $data = array(
            'cob_otro_serv_descripcion' => $cob_otro_serv_descripcion,
            'ara_id' => $ara_id,
            'cob_otro_serv_fecha' => $cob_otro_serv_fecha,
            'cob_otro_serv_calculo_importe' => $cob_otro_serv_calculo_importe,
            'cob_otro_serv_importe' => $cob_otro_serv_importe,
            'cob_otro_serv_subtotal' => $cob_otro_serv_subtotal,
            'cob_otro_serv_metodo_pago' => $cob_otro_serv_metodo_pago
        );

        $this->db->where(array('cob_otro_serv_id'=>$cob_otro_serv_id));
        return $this->db->update('cobranzas_otros_servicios', $data);
    }

    public function delete_otro_servicio($cob_otro_serv_id)
    {
        if ($cob_otro_serv_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('cob_otro_serv_id'=>$cob_otro_serv_id));
        return $this->db->delete('cobranzas_otros_servicios');
    }

    /*******************
    TRANSPORTES
    ******************/

    public function get_transportes($lang="es", $cob_id=FALSE)
    {
        if($cob_id==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT CT.*
                                    FROM cobranzas_transportes AS CT
                                    WHERE CT.cob_id = ".$cob_id);
        return $query->result_array();
    }

    public function set_transporte($cob_id, $cob_trans_tipo_id="", $cob_trans_nombre="", $cob_trans_origen="", $cob_trans_destino=0, $cob_trans_numero=0, $cob_trans_container=0, $cob_trans_fecha_ini=0, $cob_trans_fecha_fin=0, $cob_trans_tiempo=0, $cob_trans_estado=0, $mon_code=0, $cob_trans_importe=0, $cob_trans_forma_pago=0)
    {
        $data = array(
            'cob_trans_id' => NULL,
            'cob_id' => $cob_id,
            'cob_trans_tipo_id' => $cob_trans_tipo_id,
            'cob_trans_nombre' => $cob_trans_nombre,
            'cob_trans_origen' => $cob_trans_origen,
            'cob_trans_destino' => $cob_trans_destino,
            'cob_trans_numero' => $cob_trans_numero,
            'cob_trans_container' => $cob_trans_container,
            'cob_trans_fecha_ini' => $cob_trans_fecha_ini,
            'cob_trans_fecha_fin' => $cob_trans_fecha_fin,
            'cob_trans_tiempo' => $cob_trans_tiempo,
            'cob_trans_estado' => $cob_trans_estado,
            'mon_code' => $mon_code,
            'cob_trans_importe' => $cob_trans_importe,
            'cob_trans_forma_pago' => $cob_trans_forma_pago
        );

        $this->db->insert('cobranzas_transportes', $data);
        return $this->db->insert_id();
    }

    public function update_transporte($cob_trans_id, $cob_trans_tipo_id="", $cob_trans_nombre="", $cob_trans_origen="", $cob_trans_destino=0, $cob_trans_numero=0, $cob_trans_container=0, $cob_trans_fecha_ini=0, $cob_trans_fecha_fin=0, $cob_trans_tiempo=0, $cob_trans_estado=0, $mon_code=0, $cob_trans_importe=0, $cob_trans_forma_pago=0)
    {
        $data = array(
            'cob_trans_tipo_id' => $cob_trans_tipo_id,
            'cob_trans_nombre' => $cob_trans_nombre,
            'cob_trans_origen' => $cob_trans_origen,
            'cob_trans_destino' => $cob_trans_destino,
            'cob_trans_numero' => $cob_trans_numero,
            'cob_trans_container' => $cob_trans_container,
            'cob_trans_fecha_ini' => $cob_trans_fecha_ini,
            'cob_trans_fecha_fin' => $cob_trans_fecha_fin,
            'cob_trans_tiempo' => $cob_trans_tiempo,
            'cob_trans_estado' => $cob_trans_estado,
            'mon_code' => $mon_code,
            'cob_trans_importe' => $cob_trans_importe,
            'cob_trans_forma_pago' => $cob_trans_forma_pago
        );

        $this->db->where(array('cob_trans_id'=>$cob_trans_id));
        return $this->db->update('cobranzas_transportes', $data);
    }

    public function delete_transporte($cob_trans_id)
    {
        if ($cob_trans_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('cob_trans_id'=>$cob_trans_id));
        return $this->db->delete('cobranzas_transportes');
    }

    /*******************
    SEGUROS
    ******************/

    public function get_seguros($lang="es", $cob_id=FALSE)
    {
        if($cob_id==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT CS.*
                                    FROM cobranzas_seguros AS CS
                                    WHERE CS.cob_id = ".$cob_id);
        return $query->result_array();
    }

    public function set_seguro($cob_id, $cob_seg_numero="", $cob_seg_tipo_id="", $cob_seg_fecha_emision="", $cob_seg_empresa=0, $cob_seg_nombre=0, $cob_seg_apellido=0, $cob_seg_telefono=0, $cob_seg_mail=0, $cob_seg_prima=0, $cob_seg_forma_pago=0, $cob_seg_monto=0, $cob_seg_descripcion=0, $cob_seg_procedimiento=0)
    {
        $data = array(
            'cob_seg_id' => NULL,
            'cob_id' => $cob_id,
            'cob_seg_numero' => $cob_seg_numero,
            'cob_seg_tipo_id' => $cob_seg_tipo_id,
            'cob_seg_fecha_emision' => $cob_seg_fecha_emision,
            'cob_seg_empresa' => $cob_seg_empresa,
            'cob_seg_nombre' => $cob_seg_nombre,
            'cob_seg_apellido' => $cob_seg_apellido,
            'cob_seg_telefono' => $cob_seg_telefono,
            'cob_seg_mail' => $cob_seg_mail,
            'cob_seg_prima' => $cob_seg_prima,
            'cob_seg_forma_pago' => $cob_seg_forma_pago,
            'cob_seg_monto' => $cob_seg_monto,
            'cob_seg_descripcion' => $cob_seg_descripcion,
            'cob_seg_procedimiento' => $cob_seg_procedimiento
        );

        $this->db->insert('cobranzas_seguros', $data);
        return $this->db->insert_id();
    }

    public function update_seguro($cob_seg_id, $cob_seg_numero="", $cob_seg_tipo_id="", $cob_seg_fecha_emision="", $cob_seg_empresa=0, $cob_seg_nombre=0, $cob_seg_apellido=0, $cob_seg_telefono=0, $cob_seg_mail=0, $cob_seg_prima=0, $cob_seg_forma_pago=0, $cob_seg_monto=0, $cob_seg_descripcion=0, $cob_seg_procedimiento=0)
    {
        $data = array(
            'cob_seg_numero' => $cob_seg_numero,
            'cob_seg_tipo_id' => $cob_seg_tipo_id,
            'cob_seg_fecha_emision' => $cob_seg_fecha_emision,
            'cob_seg_empresa' => $cob_seg_empresa,
            'cob_seg_nombre' => $cob_seg_nombre,
            'cob_seg_apellido' => $cob_seg_apellido,
            'cob_seg_telefono' => $cob_seg_telefono,
            'cob_seg_mail' => $cob_seg_mail,
            'cob_seg_prima' => $cob_seg_prima,
            'cob_seg_forma_pago' => $cob_seg_forma_pago,
            'cob_seg_monto' => $cob_seg_monto,
            'cob_seg_descripcion' => $cob_seg_descripcion,
            'cob_seg_procedimiento' => $cob_seg_procedimiento
        );

        $this->db->where(array('cob_seg_id'=>$cob_seg_id));
        return $this->db->update('cobranzas_seguros', $data);
    }

    public function delete_seguro($cob_seg_id)
    {
        if ($cob_seg_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('cob_seg_id'=>$cob_seg_id));
        return $this->db->delete('cobranzas_seguros');
    }

    /*******************
    COMISIONES
    ******************/

    public function get_comision($lang="es", $cob_id=FALSE)
    {
        if($cob_id==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT CC.*
                                    FROM cobranzas_comisiones AS CC
                                    WHERE CC.cob_id = ".$cob_id);
        return $query->row_array();
    }

    public function set_comision($cob_id, $cob_com_calculo=0, $cob_com_calculo_productos=0, $cob_com_calculo_servicios=0, $cob_com_calculo_transporte=0, $cob_com_calculo_seguros=0, $cob_com_calculo_suma=0, $cob_com_importe=0, $cob_com_total=0)
    {
        if($cob_com_calculo_productos == NULL)
        {
            $cob_com_calculo_productos = 0;
        }
        if($cob_com_calculo_servicios == NULL)
        {
            $cob_com_calculo_servicios = 0;
        }
        if($cob_com_calculo_transporte == NULL)
        {
            $cob_com_calculo_transporte = 0;
        }
        if($cob_com_calculo_seguros == NULL)
        {
            $cob_com_calculo_seguros = 0;
        }

        $data = array(
            'cob_com_id' => NULL,
            'cob_id' => $cob_id,
            'cob_com_calculo' => $cob_com_calculo,
            'cob_com_calculo_productos' => $cob_com_calculo_productos,
            'cob_com_calculo_servicios' => $cob_com_calculo_servicios,
            'cob_com_calculo_transporte' => $cob_com_calculo_transporte,
            'cob_com_calculo_seguros' => $cob_com_calculo_seguros,
            'cob_com_calculo_suma' => $cob_com_calculo_suma,
            'cob_com_importe' => $cob_com_importe,
            'cob_com_total' => $cob_com_total
        );

        $this->db->insert('cobranzas_comisiones', $data);
        return $this->db->insert_id();
    }

    public function update_comision($cob_com_id, $cob_com_calculo=0, $cob_com_calculo_productos=0, $cob_com_calculo_servicios=0, $cob_com_calculo_transporte=0, $cob_com_calculo_seguros=0, $cob_com_calculo_suma=0, $cob_com_importe=0, $cob_com_total=0)
    {
        if($cob_com_calculo_productos == NULL)
        {
            $cob_com_calculo_productos = 0;
        }
        if($cob_com_calculo_servicios == NULL)
        {
            $cob_com_calculo_servicios = 0;
        }
        if($cob_com_calculo_transporte == NULL)
        {
            $cob_com_calculo_transporte = 0;
        }
        if($cob_com_calculo_seguros == NULL)
        {
            $cob_com_calculo_seguros = 0;
        }
        
        $data = array(
            'cob_com_calculo' => $cob_com_calculo,
            'cob_com_calculo_productos' => $cob_com_calculo_productos,
            'cob_com_calculo_servicios' => $cob_com_calculo_servicios,
            'cob_com_calculo_transporte' => $cob_com_calculo_transporte,
            'cob_com_calculo_seguros' => $cob_com_calculo_seguros,
            'cob_com_calculo_suma' => $cob_com_calculo_suma,
            'cob_com_importe' => $cob_com_importe,
            'cob_com_total' => $cob_com_total
        );

        $this->db->where(array('cob_com_id'=>$cob_com_id));
        return $this->db->update('cobranzas_comisiones', $data);
    }

    public function delete_comision($cob_com_id)
    {
        if ($cob_com_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('cob_com_id'=>$cob_com_id));
        return $this->db->delete('cobranzas_comisiones');
    }


    /*******************
    PAGOS
    ******************/

    public function get_pagos($lang="es", $cob_id=FALSE)
    {
        if($cob_id==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT CP.*
                                    FROM cobranzas_pagos AS CP
                                    WHERE CP.cob_id = ".$cob_id);
        return $query->result_array();
    }

    public function set_pago($cob_id, $cob_pago_descripcion=0, $cob_pago_fecha=0, $cob_pago_hito=0, $cob_pago_calculo=0, $cob_pago_importe=0, $mon_code=0, $cob_pago_subtotal=0, $cob_pago_metodo=0, $cob_pago_destinatario)
    {
        $data = array(
            'cob_pago_id' => NULL,
            'cob_id' => $cob_id,
            'cob_pago_descripcion' => $cob_pago_descripcion,
            'cob_pago_fecha' => $cob_pago_fecha,
            'cob_pago_hito' => $cob_pago_hito,
            'cob_pago_calculo' => $cob_pago_calculo,
            'cob_pago_importe' => $cob_pago_importe,
            'mon_code' => $mon_code,
            'cob_pago_subtotal' => $cob_pago_subtotal,
            'cob_pago_metodo' => $cob_pago_metodo,
            'cob_pago_destinatario' => $cob_pago_destinatario
        );

        $this->db->insert('cobranzas_pagos', $data);
        return $this->db->insert_id();
    }

    public function update_pago($cob_pago_id, $cob_pago_descripcion=0, $cob_pago_fecha=0, $cob_pago_hito=0, $cob_pago_calculo=0, $cob_pago_importe=0, $mon_code=0, $cob_pago_subtotal=0, $cob_pago_metodo=0, $cob_pago_destinatario)
    {
        $data = array(
            'cob_pago_descripcion' => $cob_pago_descripcion,
            'cob_pago_fecha' => $cob_pago_fecha,
            'cob_pago_hito' => $cob_pago_hito,
            'cob_pago_calculo' => $cob_pago_calculo,
            'cob_pago_importe' => $cob_pago_importe,
            'mon_code' => $mon_code,
            'cob_pago_subtotal' => $cob_pago_subtotal,
            'cob_pago_metodo' => $cob_pago_metodo,
            'cob_pago_destinatario' => $cob_pago_destinatario
        );

        $this->db->where(array('cob_pago_id'=>$cob_pago_id));
        return $this->db->update('cobranzas_pagos', $data);
    }

    public function delete_pago($cob_pago_id)
    {
        if ($cob_pago_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('cob_pago_id'=>$cob_pago_id));
        return $this->db->delete('cobranzas_pagos');
    }

    /*******************
    PAGOS COMISIONES
    ******************/

    public function get_pagos_comisiones($lang="es", $cob_id=FALSE)
    {
        if($cob_id==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT CP.*
                                    FROM cobranzas_pagos_comisiones AS CP
                                    WHERE CP.cob_id = ".$cob_id);
        return $query->result_array();
    }

    public function set_pago_comisiones($cob_id, $cob_pago_com_descripcion=0, $cob_pago_com_fecha=0, $cob_pago_com_hito=0, $cob_pago_com_calculo=0, $cob_pago_com_importe=0, $mon_code=0, $cob_pago_com_subtotal=0, $cob_pago_com_metodo=0, $cob_pago_com_destinatario)
    {
        $data = array(
            'cob_pago_com_id' => NULL,
            'cob_id' => $cob_id,
            'cob_pago_com_descripcion' => $cob_pago_com_descripcion,
            'cob_pago_com_fecha' => $cob_pago_com_fecha,
            'cob_pago_com_hito' => $cob_pago_com_hito,
            'cob_pago_com_calculo' => $cob_pago_com_calculo,
            'cob_pago_com_importe' => $cob_pago_com_importe,
            'mon_code' => $mon_code,
            'cob_pago_com_subtotal' => $cob_pago_com_subtotal,
            'cob_pago_com_metodo' => $cob_pago_com_metodo,
            'cob_pago_com_destinatario' => $cob_pago_com_destinatario
        );

        $this->db->insert('cobranzas_pagos_comisiones', $data);
        return $this->db->insert_id();
    }

    public function update_pago_comisiones($cob_pago_com_id, $cob_pago_com_descripcion=0, $cob_pago_com_fecha=0, $cob_pago_com_hito=0, $cob_pago_com_calculo=0, $cob_pago_com_importe=0, $mon_code=0, $cob_pago_com_subtotal=0, $cob_pago_com_metodo=0, $cob_pago_com_destinatario)
    {
        $data = array(
            'cob_pago_com_descripcion' => $cob_pago_com_descripcion,
            'cob_pago_com_fecha' => $cob_pago_com_fecha,
            'cob_pago_com_hito' => $cob_pago_com_hito,
            'cob_pago_com_calculo' => $cob_pago_com_calculo,
            'cob_pago_com_importe' => $cob_pago_com_importe,
            'mon_code' => $mon_code,
            'cob_pago_com_subtotal' => $cob_pago_com_subtotal,
            'cob_pago_com_metodo' => $cob_pago_com_metodo,
            'cob_pago_com_destinatario' => $cob_pago_com_destinatario
        );

        $this->db->where(array('cob_pago_com_id'=>$cob_pago_com_id));
        return $this->db->update('cobranzas_pagos_comisiones', $data);
    }

    public function delete_pago_comisiones($cob_pago_com_id)
    {
        if ($cob_pago_com_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('cob_pago_com_id'=>$cob_pago_com_id));
        return $this->db->delete('cobranzas_pagos_comisiones');
    }


    /******************
    EMPRESAS
    ******************/

    public function get_cobranza_empresas($lang="es", $cob_id=FALSE)
    {
        if($cob_id==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM cobranzas_empresas AS CE
                                    WHERE CE.cob_id = ".$cob_id."
                                    ORDER BY CE.cob_usr_tipo_id, CE.cob_emp_tipo_id");
        return $query->result_array();
    }

    public function get_cobranza_empresas_x_tipo_usuario($lang="es", $cob_id=FALSE, $cob_usr_tipo_id=FALSE)
    {
        if($cob_id==FALSE || $cob_usr_tipo_id==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM cobranzas_empresas AS CE
                                    WHERE CE.cob_id = ".$cob_id."
                                    AND CE.cob_usr_tipo_id=".$cob_usr_tipo_id.'
                                    ORDER BY CE.cob_emp_tipo_id');
        return $query->result_array();
    }

    public function get_cobranza_tipo_empresas_x_tipo_usuario($lang="es", $cob_id=FALSE, $cob_usr_tipo_id=FALSE)
    {
        if($cob_id==FALSE || $cob_usr_tipo_id==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT CUTE.*, CE.cob_emp_id, CE.cob_emp_nombre, CE.ctry_code, CE.city_id, CE.cob_emp_cp, CE.cob_emp_direccion, CE.cob_emp_telefono, CE.cob_emp_mail,
                                    Ctry.ctry_nombre_".$lang." as ctry_nombre, 
                                    City.city_nombre_".$lang." as city_nombre
                                    FROM cobranzas_usuarios_tipos_empresas AS CUTE
                                    LEFT JOIN cobranzas_empresas AS CE ON CUTE.cob_emp_tipo_id = CE.cob_emp_tipo_id AND CE.cob_id=".$cob_id." AND CE.cob_usr_tipo_id=CUTE.cob_usr_tipo_id
                                    LEFT JOIN Country AS Ctry ON CE.ctry_code = Ctry.ctry_code
                                    LEFT JOIN City AS City ON CE.city_id = City.city_id
                                    WHERE CUTE.cob_usr_tipo_id=".$cob_usr_tipo_id."
                                    ORDER BY CUTE.cob_emp_tipo_id ASC");
        return $query->result_array();
    }

    public function set_empresa($cob_id, $cob_usr_tipo_id, $cob_emp_tipo_id, $cob_emp_nombre='', $ctry_code=NULL, $city_id=NULL, $cob_emp_cp='', $cob_emp_direccion='', $cob_emp_telefono='', $cob_emp_mail='')
    {
        $data = array(
            'cob_emp_id' => NULL,
            'cob_id' => $cob_id,
            'cob_usr_tipo_id' => $cob_usr_tipo_id,
            'cob_emp_tipo_id' => $cob_emp_tipo_id,
            'cob_emp_nombre' => $cob_emp_nombre,
            'ctry_code' => $ctry_code,
            'city_id' => $city_id,
            'cob_emp_cp' => $cob_emp_cp,
            'cob_emp_direccion' => $cob_emp_direccion,
            'cob_emp_telefono' => $cob_emp_telefono,
            'cob_emp_mail' => $cob_emp_mail
        );

        $this->db->insert('cobranzas_empresas', $data);
        return $this->db->insert_id();
    }

    public function update_empresa($cob_emp_id, $cob_emp_nombre='', $ctry_code=NULL, $city_id=NULL, $cob_emp_cp='', $cob_emp_direccion='', $cob_emp_telefono='', $cob_emp_mail='')
    {
        $data = array(
            'cob_emp_nombre' => $cob_emp_nombre,
            'ctry_code' => $ctry_code,
            'city_id' => $city_id,
            'cob_emp_cp' => $cob_emp_cp,
            'cob_emp_direccion' => $cob_emp_direccion,
            'cob_emp_telefono' => $cob_emp_telefono,
            'cob_emp_mail' => $cob_emp_mail
        );

        $this->db->where(array('cob_emp_id'=>$cob_emp_id));
        return $this->db->update('cobranzas_empresas', $data);
    }

    public function delete_empresa($cob_emp_id)
    {
        if ($cob_emp_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('cob_emp_id'=>$cob_emp_id));
        return $this->db->delete('cobranzas_empresas');
    }


    /******************
    COMENTARIOS
    ******************/

    public function get_comentarios($lang="es", $cob_id=FALSE, $item_tipo_id=FALSE, $item_id=FALSE, $sub_item_id=FALSE)
    {
        if($cob_id==FALSE || $item_id==FALSE || $item_tipo_id==FALSE || $sub_item_id==FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT CC.*, U.usr_mail
                                    FROM cobranzas_comentarios AS CC
                                    LEFT JOIN Usuarios AS U ON CC.usr_id = U.usr_id
                                    WHERE CC.cob_id = ".$cob_id."
                                    AND CC.item_tipo_id = ".$item_tipo_id."
                                    AND CC.item_id = ".$item_id."
                                    AND CC.sub_item_id = ".$sub_item_id."
                                    ORDER BY CC.cob_com_fecha DESC");
        return $query->result_array();
    }

    public function get_comentario_estado($lang="es", $cob_id=FALSE, $item_tipo_id=FALSE, $item_id=FALSE, $sub_item_id=FALSE)
    {
        $cob_com_est_id = 0;

        if($cob_id==FALSE || $item_id==FALSE || $item_tipo_id == FALSE || $sub_item_id == FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT CU.*,
                                    (SELECT CC.cob_com_est_id FROM cobranzas_comentarios AS CC WHERE CC.cob_id = CU.cob_id AND CC.item_tipo_id = ".$item_tipo_id." AND CC.item_id = ".$item_id." AND CC.sub_item_id = ".$sub_item_id." AND CC.usr_id = CU.usr_id ORDER BY CC.cob_com_fecha DESC LIMIT 1) as cob_com_est_id,
                                    (SELECT CC.cob_com_texto FROM cobranzas_comentarios AS CC WHERE CC.cob_id = CU.cob_id AND CC.item_tipo_id = ".$item_tipo_id." AND CC.item_id = ".$item_id." AND CC.sub_item_id = ".$sub_item_id." AND CC.usr_id = CU.usr_id ORDER BY CC.cob_com_fecha DESC LIMIT 1) as cob_com_texto
                                    FROM cobranzas_usuarios AS CU
                                    WHERE CU.cob_id = ".$cob_id."
                                    ORDER BY CU.cob_usr_tipo_id");
        $result = $query->result_array();

        if($result)
        {
            foreach ($result as $key => $value)
            {
                if($cob_com_est_id == 0 && $value['cob_com_est_id'] == 1)
                {
                    $cob_com_est_id = $value['cob_com_est_id'];
                }
                elseif($cob_com_est_id < 3 && $value['cob_com_est_id'] == 2)
                {
                    $cob_com_est_id = $value['cob_com_est_id'];
                }

                if($value['cob_com_texto'] != NULL && $value['cob_com_texto'] != "")
                {
                    if($cob_com_est_id == 0)
                    {
                        $cob_com_est_id = 3;
                    }
                }
            }
        }

        return $cob_com_est_id;
    }

    public function set_comentario($cob_id, $usr_id, $item_tipo_id=FALSE, $item_id, $sub_item_id=NULL, $cob_com_est_id='', $cob_com_texto='')
    {
        $data = array(
            'cob_com_id' => NULL,
            'cob_id' => $cob_id,
            'usr_id' => $usr_id,
            'item_tipo_id' => $item_tipo_id,
            'item_id' => $item_id,
            'sub_item_id' => $sub_item_id,
            'cob_com_est_id' => $cob_com_est_id,
            'cob_com_texto' => $cob_com_texto,
            'cob_com_fecha' => date('Y-m-d H:i:s')
        );

        $this->db->insert('cobranzas_comentarios', $data);
        return $this->db->insert_id();
    }

}