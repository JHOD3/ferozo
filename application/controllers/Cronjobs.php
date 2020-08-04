<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjobs extends CI_Controller {

	private static $solapa = "cronjobs";

	public function __construct()
	{
		parent::__construct();

		if($this->session->userdata('idi_code') == "")
		{
			$this->session->set_userdata('idi_code',"en");
		}

		$this->config->set_item('language', $this->session->userdata('idi_code'));
		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->model('idiomas_model');
		$this->load->model('paises_model');
		$this->load->model('comtrade_model');
		$this->load->model('palabras_model');
		$this->load->model('user_model');
		$this->load->model('mails_model');
		$this->load->model('productos_model');
		$this->load->model('resultados_model');
		$this->load->model('notificaciones_model');
		$this->load->model('mails_info_model');
		$this->load->model('foro_model');
	}


	/********************/
	/*   NUEVO MATCH    */
	/********************/
	/*
	Agrupo los match para notificar una sola vez
	Agrupo todos los foros en los que participo para notificar una sola vez
	*/
	public function buscar_matchs()
	{
		$this->load->helper('mails');

		/* MATCHS */

		$query = $this->db->query('SELECT *
                                    FROM Productos AS P
                                    INNER JOIN Usuarios AS U ON P.usr_id = U.usr_id
                                    WHERE P.prod_fecha >= "'.date('Y-m-d').' 00:00:00"
                                    AND P.prod_fecha <= "'.date('Y-m-d').' 23:59:59"');
        $productos = $query->result_array();

        if($productos)
        {
	        foreach ($productos as $key_prod => $producto)
	        {
	        	$usuarios = $this->resultados_model->get_usuarios_match_producto($producto['prod_id']);
		        if($usuarios)
		        {
		            foreach ($usuarios as $key_usr => $usuario)
		            {
		                $not_id = $this->notificaciones_model->set_item($producto['usr_id'], $usuario['usr_id'], $producto['prod_id'], $usuario['prod_id'], NOTIFICACION_NUEVO_MATCH, NOTI_ESTADO_PENDIENTE, NULL);
		                if($not_id)
		                {
		                	echo 'Nuevo match. Notificacion cargada con exito.<br>';
		                }
		                else
		                {
		                	echo 'Ocurrio un error al cargar la notificacion.<br>';
		                }
		            }
		        }
		        else
		        {
		        	echo 'No hay ningun match.<br>';
		        }
	        }
    	}
    	else
    	{
    		echo 'No hay productos nuevos.<br>';
    	}

    	/* FOROS */

    	$query = $this->db->query('SELECT COUNT(1) as cant, F.*, U.*
                                    FROM Foro AS F
                                    INNER JOIN foro_mensaje AS FM ON F.foro_id = FM.foro_id
                                    INNER JOIN Usuarios AS U ON FM.usr_id = U.usr_id
                                    WHERE FM.forom_fecha >= "'.date('Y-m-d').' 00:00:00"
                                    AND FM.forom_fecha <= "'.date('Y-m-d').' 23:59:59"
                                    GROUP BY F.foro_id, FM.usr_id');
        $mensajes = $query->result_array();

        if($mensajes)
        {
	        foreach ($mensajes as $key_msj => $msj)
	        {
	        	$usuarios = $this->foro_model->get_usuarios($msj['foro_id']);
		        if($usuarios)
		        {
		            foreach ($usuarios as $key_usr => $usuario)
		            {
		                $not_id = $this->notificaciones_model->set_item($msj['usr_id'], $usuario['usr_id'], NULL, NULL, NOTIFICACION_NUEVO_COMENTARIO_FORO, NOTI_ESTADO_PENDIENTE, $msj['foro_id']);
		                if($not_id)
		                {
		                	echo 'Nuevo mensaje en foro. Notificacion cargada con exito.<br>';
		                }
		                else
		                {
		                	echo 'Ocurrio un error al cargar la notificacion.<br>';
		                }
		            }
		        }
		        else
		        {
		        	echo 'No hay ningun mensaje nuevo en foros.<br>';
		        }
	        }
    	}
    	else
    	{
    		echo 'No hay mensajes de foros nuevos.<br>';
    	}
	}

	/*
	ESTA NO LA USO PORQUE AGRUPO TODOS LOS MATCH EN UN SOLO MAIL
	*/
	public function enviar_notificaciones()
	{
		$this->load->helper('mails');

		$tipos = $this->notificaciones_model->get_tipos();
		foreach ($tipos as $key_tipo => $tipo)
		{
			$notificaciones = $this->notificaciones_model->get_pendientes_x_tipo($tipo['not_tipo_id']);

	        if($notificaciones)
	        {
		        foreach ($notificaciones as $key_not => $notificacion)
		        {
		        	$mail_info = $this->mails_info_model->get_item($notificacion['idi_code'], 5);
	                
	                $titulo = str_replace("[USER MAIL]", "<a href='mailto:".$notificacion['usr_mail']."' style='color:#FFFFFF;'>".$notificacion['usr_mail']."</a>", $mail_info['mi_titulo']);
	                $mensaje1 = str_replace("[FOROS]", 1, $mail_info['mi_cuerpo1']);
	                $mensaje2 = str_replace("[HTTP/:]", site_url(), $mail_info['mi_cuerpo2']);

	                $result_mail = mail_base($notificacion['usr_mail'], $mail_info['mi_asunto'], $titulo, nl2br($mensaje1), nl2br($mensaje2));
	                if($result_mail)
	                {
	                	echo "Email enviado. ";
	                	$result_update = $this->notificaciones_model->estado_item($notificacion['not_id'], NOTI_ESTADO_ENVIADA);
	                	if($result_update)
	                	{
	                		echo "Notificacion actualizada. ";
	                	}
	                	else
	                	{
	                		echo "Error al actualizar la notificacion. ";
	                	}
	                }
	                else
	                {
	                	echo "Error al enviar el Email. ";
	                }
	                echo "<br>";
		        }
	    	}
	    	else
	    	{
	    		echo 'No hay productos nuevos.';
	    	}
		}
	}

	public function enviar_notificaciones_match()
	{
		$this->load->helper('mails');

		/* MATCHS */

        $notificaciones = $this->notificaciones_model->get_acumulados_x_tipo(NOTIFICACION_NUEVO_MATCH);

        if($notificaciones)
        {
	        foreach ($notificaciones as $key_not => $notificacion)
	        {
	        	$mail_info = $this->mails_info_model->get_item($notificacion['idi_code'], 5);
                
                $titulo = str_replace("[USER MAIL]", "<a href='mailto:".$notificacion['usr_mail']."' style='color:#FFFFFF;'>".$notificacion['usr_mail']."</a>", $mail_info['mi_titulo']);
                $mensaje1 = str_replace("[X NEW RESULTS]", $notificacion['cant'], $mail_info['mi_cuerpo1']);
                $mensaje2 = str_replace("[HTTP/:]", site_url(), $mail_info['mi_cuerpo2']);

                $result_mail = mail_base($notificacion['usr_mail'], $mail_info['mi_asunto'], $titulo, nl2br($mensaje1), nl2br($mensaje2));
                if($result_mail)
                {
                	echo "Email enviado. ";
                	$ids = explode(',', $notificacion['not_ids']);
                	foreach ($ids as $key_id => $not_id)
                	{
                		$result_update = $this->notificaciones_model->estado_item($not_id, NOTI_ESTADO_ENVIADA);
	                	if($result_update)
	                	{
	                		echo "Notificacion actualizada.<br>";
	                	}
	                	else
	                	{
	                		echo "Error al actualizar la notificacion.<br>";
	                	}
                	}
                }
                else
                {
                	echo "Error al enviar el Email.<br>";
                }
                echo "<br>";
	        }
    	}
    	else
    	{
    		echo 'No hay productos nuevos.<br>';
    	}

    	/* FORO */

    	$notificaciones = $this->notificaciones_model->get_acumulados_x_foro();

        if($notificaciones)
        {
        	$usuario_anterior = 0;
	        //foreach ($notificaciones as $key_not => $notificacion)
	        for($i = 0; $i < count($notificaciones); $i++)
	        {
	        	$mail_info = $this->mails_info_model->get_item($notificaciones[$i]['idi_code'], 19);
                
                $foros = "";
                while($i < count($notificaciones) && $usuario_anterior != $notificaciones[$i]['usr_id'])
                {
                	$foros .= "<a href='".site_url('foro/view/'.$notificaciones[$i]['foro_id'])."' style='color:#FFFFFF;'>".$notificaciones[$i]['foro_descripcion']."</a><br>";
                	$usuario_anterior = $notificaciones[$i]['usr_id'];
                	$i++;
                }

                $titulo = str_replace("[USER MAIL]", $notificaciones[$i-1]['usr_mail'], $mail_info['mi_titulo']);
                $mensaje1 = str_replace("[FOROS]", $foros, $mail_info['mi_cuerpo1']);
                $mensaje2 = str_replace("[HTTP/:]", site_url(), $mail_info['mi_cuerpo2']);

                $result_mail = mail_base($notificaciones[$i-1]['usr_mail'], $mail_info['mi_asunto'], $titulo, nl2br($mensaje1), nl2br($mensaje2));
                if($result_mail)
                {
                	echo "Email enviado. ";
                	$ids = explode(',', $notificaciones[$i-1]['not_ids']);
                	foreach ($ids as $key_id => $not_id)
                	{
                		$result_update = $this->notificaciones_model->estado_item($not_id, NOTI_ESTADO_ENVIADA);
	                	if($result_update)
	                	{
	                		echo "Notificacion actualizada.<br>";
	                	}
	                	else
	                	{
	                		echo "Error al actualizar la notificacion.<br>";
	                	}
                	}
                }
                else
                {
                	echo "Error al enviar el Email.<br>";
                }
                echo "<br>";
	        }
    	}
    	else
    	{
    		echo 'No hay mensajes de foros nuevos.<br>';
    	}
	}


	/*******************/
	/*   PUBLICIDAD    */
	/*******************/

	public function mail_publi_usuarios()
	{
		$this->load->helper('mails');

		$query = $this->db->query('SELECT *
                                    FROM Mails AS M
                                    INNER JOIN Usuarios AS U ON M.usr_id = U.usr_id
                                    WHERE M.mail_id NOT IN (SELECT MU.mail_id FROM mails_ultimo_spam AS MU)
                                    AND M.mail_estado = 0
                                    LIMIT 25');
        $mails = $query->result_array();

        foreach ($mails as $key => $mail)
        {
	        $result = mail_publicidad_sendgrid($mail['mail_direccion'], $mail['mail_id'], $mail['mail_codigo'], $mail['idi_code']);
	        if($result)
	        {
	        	$data = array(
		    		'mail_id' => $mail['mail_id'],
		    		'fecha' => date('Y-m-d H:i'),
		    		'estado' => 1
		    	);

		    	$this->db->insert('mails_ultimo_spam', $data);

	        	echo "OK - ".$mail['mail_direccion'];
	        }
	        else
	        {
	        	$data = array(
		    		'mail_id' => $mail['mail_id'],
		    		'fecha' => date('Y-m-d H:i'),
		    		'estado' => 2
		    	);

		    	$this->db->insert('mails_ultimo_spam', $data);

	        	echo "Error<br>".$this->email->print_debugger();
	        }
    	}
	}

}
