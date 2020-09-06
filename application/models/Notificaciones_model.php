<?php
class Notificaciones_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function get_item($not_id = FALSE)
    {
        if ($not_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM notificaciones AS N
                                    WHERE N.not_id ='.$not_id);
        return $query->row_array();
    }

    public function get_cant_no_vistos($usr_id = FALSE)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT COUNT(1) as cant
                                    FROM notificaciones AS N
                                    WHERE N.usr_receptor ='.$usr_id.'
                                    AND N.note_id < 3');
        return $query->row_array();
    }

    public function get_items_usuario($usr_id = FALSE, $idi_code="es", $offset=0, $limit=0)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $limit_aux = "";
        if($limit > 0)
        {
            $limit_aux = "LIMIT ".$limit;
        }

        $offset_aux = "";
        if($offset > 0)
        {
            $offset_aux = "OFFSET ".$offset;
        }

        $query = $this->db->query('SELECT *
                                    FROM notificaciones AS N
                                    LEFT JOIN Usuarios AS U ON U.usr_id = N.usr_emisor
                                    WHERE N.usr_receptor ='.$usr_id.'
                                    ORDER BY N.not_fecha DESC
                                    '.$limit_aux.'
                                    '.$offset_aux);
        return $query->result_array();
    }

    public function get_items_x_estado($estado = NOTI_ESTADO_PENDIENTE)
    {
        if ($estado === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT *
                                    FROM notificaciones AS N
                                    INNER JOIN Usuarios AS U ON N.usr_receptor = U.usr_id
                                    WHERE N.note_id ='.$estado);
        return $query->result_array();
    }

    public function get_acumulados_x_tipo($tipo = FALSE)
    {
        if ($tipo === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT COUNT(1) as cant, GROUP_CONCAT(N.not_id) as not_ids, U.*
                                    FROM notificaciones AS N
                                    INNER JOIN Usuarios AS U ON N.usr_receptor = U.usr_id
                                    WHERE N.note_id ='.NOTI_ESTADO_PENDIENTE.'
                                    AND N.not_tipo_id='.$tipo.'
                                    GROUP BY N.usr_receptor');
        return $query->result_array();
    }

    public function get_acumulados_x_foro()
    {
        $query = $this->db->query('SELECT COUNT(1) as cant, GROUP_CONCAT(N.not_id) as not_ids, F.*, U.*
                                    FROM notificaciones AS N
                                    INNER JOIN Usuarios AS U ON N.usr_receptor = U.usr_id
                                    INNER JOIN Foro AS F ON N.not_aux_id = F.foro_id
                                    WHERE N.note_id ='.NOTI_ESTADO_PENDIENTE.'
                                    AND N.not_tipo_id='.NOTIFICACION_NUEVO_COMENTARIO_FORO.'
                                    GROUP BY F.foro_id, N.usr_receptor
                                    ORDER BY N.usr_receptor, F.foro_id');
        return $query->result_array();
    }

    public function get_pendientes_x_tipo($tipo = FALSE)
    {
        if ($tipo === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query('SELECT N.*, U.*
                                    FROM notificaciones AS N
                                    INNER JOIN Usuarios AS U ON N.usr_receptor = U.usr_id
                                    WHERE N.note_id ='.NOTI_ESTADO_PENDIENTE.'
                                    AND N.not_tipo_id='.$tipo);
        return $query->result_array();
    }

    public function get_tipos()
    {
        $query = $this->db->query('SELECT *
                                    FROM notificaciones_tipos AS NT
                                    ORDER BY NT.not_tipo_id');
        return $query->result_array();
    }

    public function set_item($usr_emisor, $usr_receptor, $prod_emisor, $prod_receptor, $tipo, $estado = NOTI_ESTADO_PENDIENTE, $not_aux_id = NULL, $not_descripcion=NULL, $not_link=NULL)
    {
    	$data = array(
    		'not_id' => NULL,
    		'usr_emisor' => $usr_emisor,
    		'usr_receptor' => $usr_receptor,
            'prod_emisor' => $prod_emisor,
    		'prod_receptor' => $prod_receptor,
            'not_fecha' => date('Y-m-d H:i:s'),
            'note_id' => $estado,
            'not_tipo_id' => $tipo,
            'not_aux_id' => $not_aux_id,
            'not_descripcion' => $not_descripcion,
            'not_link' => $not_link
    	);

    	$this->db->insert('notificaciones', $data);
        return $this->db->insert_id();
    }

    public function estado_item($not_id, $estado = NOTI_ESTADO_PENDIENTE)
    {
        if ($not_id === FALSE)
        {
            return FALSE;
        }

        $data = array(
            'note_id' => $estado
        );

        $this->db->where('not_id',$not_id);
        return $this->db->update('notificaciones', $data);
    }

    public function estado_items_usuario($usr_id, $estado = NOTI_ESTADO_VISTA)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $data = array(
            'note_id' => $estado
        );

        $this->db->where('usr_receptor', $usr_id);
        return $this->db->update('notificaciones', $data);
    }

    public function delete_item($not_id)
    {
        if ($not_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('not_id'=>$not_id));
        return $this->db->delete('notificaciones');
    }
	
		/*robert 04/09/2020*/
	function get_cta_suspendida($usr_id){
		$usr_id=($usr_id=="") ?0:$usr_id;
        $query = $this->db->query("SELECT * FROM usuarios_retiros WHERE usr_id = $usr_id and activo = 'Si' and estado='Suspender' LIMIT 1");
        return ($query->num_rows() > 0) ? true:false;
    }
	/*robert 04/09/2020*/

	
	
	

}