<?php
class Favoritos_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

    public function buscar_producto_favorito($usr_id = FALSE, $prod_id = FALSE)
    {
        if($usr_id === false || $prod_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM Productos_Favoritos AS PF
                                    WHERE PF.usr_id=".$usr_id."
                                    AND PF.prod_id=".$prod_id);
        return $query->row_array();
    }

    public function buscar_usuario_favorito($usr_id = FALSE, $usr_favorito = FALSE)
    {
        if($usr_id === false || $usr_favorito === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT *
                                    FROM Usuarios_Favoritos AS UF
                                    WHERE UF.usr_id=".$usr_id."
                                    AND UF.usr_favorito=".$usr_favorito);
        return $query->row_array();
    }

    public function buscar_puntaje_producto($prod_id = FALSE)
    {
        if($prod_id === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT AVG(pf_puntaje) as puntaje, 
                                    COUNT(1) as cant_seguidores
                                    FROM Productos_Favoritos AS PF
                                    WHERE PF.prod_id=".$prod_id);
        return $query->row_array();
    }

    public function buscar_puntaje_usuario($usr_favorito = FALSE)
    {
        if($usr_favorito === FALSE)
        {
            return FALSE;
        }

        $query = $this->db->query("SELECT AVG(uf_puntaje) as puntaje, 
                                    COUNT(1) as cant_seguidores
                                    FROM Usuarios_Favoritos AS UF
                                    WHERE UF.usr_favorito=".$usr_favorito);
        $aux = $query->row_array();

        if($aux['puntaje'] == null)
        {
            $aux['puntaje'] = 0;
        }
        
        return $aux;
    }

    public function set_producto_favorito($usr_id, $prod_id, $puntaje)
    {
        $data = array(
            'usr_id' => $usr_id,
            'prod_id' => $prod_id,
            'pf_puntaje' => $puntaje
        );

        return $this->db->insert('Productos_Favoritos', $data);
    }

    public function set_usuario_favorito($usr_id, $usr_favorito, $puntaje)
    {
        $data = array(
            'usr_id' => $usr_id,
            'usr_favorito' => $usr_favorito,
            'uf_puntaje' => $puntaje
        );

        return $this->db->insert('Usuarios_Favoritos', $data);
    }

    public function delete_producto_favorito($usr_id, $prod_id)
    {
        if ($prod_id === FALSE || $usr_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('prod_id'=>$prod_id, 'usr_id'=>$usr_id));
        return $this->db->delete('Productos_Favoritos');
    }

    public function delete_usuario_favorito($usr_id, $usr_favorito)
    {
        if ($usr_favorito === FALSE || $usr_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('usr_favorito'=>$usr_favorito, 'usr_id'=>$usr_id));
        return $this->db->delete('Usuarios_Favoritos');
    }

    public function delete_usuarios_favoritos($usr_id)
    {
        if ($usr_id === FALSE)
        {
            return FALSE;
        }

        $this->db->where(array('usr_id'=>$usr_id));
        return $this->db->delete('Usuarios_Favoritos');
    }

}