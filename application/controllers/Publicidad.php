<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicidad extends CI_Controller {

	private static $solapa = "publicidad";

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
		$this->load->model('mensajes_model');
	}

	public function mail_publi()
	{
		$query = $this->db->query("SELECT *
                                    FROM mails_para_publicidad AS M
                                    WHERE M.mpp_unsubscribe = 0
                                    ORDER BY M.mpp_enviado
                                    LIMIT 50");
        $mails = $query->result_array();

		$this->load->helper('mails');
		
        foreach ($mails as $key => $mail)
        {
        	if(is_valid_email($mail['mpp_mail']))
        	{
		        $result = mail_publicidad($mail['mpp_mail'], $mail['mpp_id'], $mail['idi_code']);
		        if($result)
		        {
		        	$data = array(
		        		'mpp_enviado' => date('Y-m-d H:i:s'),
			            'mpp_valido' => 1
			        );
			        $this->db->where('mpp_id', $mail['mpp_id']);
			        $this->db->update('mails_para_publicidad', $data);
		        	echo "OK - ".$mail['mpp_mail']."<br>";
		        }
		        else
		        {
		        	$data = array(
		        		'mpp_enviado' => date('Y-m-d H:i:s'),
			            'mpp_valido' => 2
			        );
			        $this->db->where('mpp_id', $mail['mpp_id']);
			        $this->db->update('mails_para_publicidad', $data);
		        	echo "Error - ".$mail['mpp_mail']."<br>";
		        }
        	}
        	else
        	{
        		$data = array(
        			'mpp_enviado' => date('Y-m-d H:i:s'),
		            'mpp_valido' => 2
		        );
		        $this->db->where('mpp_id', $mail['mpp_id']);
		        $this->db->update('mails_para_publicidad', $data);
		        echo "Invalido - ".$mail['mpp_mail']."<br>";
        	}
    	}
	}

	public function mail_publi_flavio()
	{
		$idiomas = $this->idiomas_model->get_items();

        foreach ($idiomas as $key => $idioma)
        {
	        $result = $this->mail_publicidad_sendgrid("flavio_gglio@hotmail.com", 0, $idioma['idi_code']);
	        if($result)
	        {
	        	echo "OK - ".$idioma['idi_code']."<br>";
	        }
	        else
	        {
	        	echo "Error - ".$idioma['idi_code']."<br>";
	        }
    	}
	}

	public function unsubscribe($mail_id)
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['title'] = mostrar_palabra(38, $data['palabras']);
		$data['description'] = mostrar_palabra(118, $data['palabras']);
		$data['keywords'] = mostrar_palabra(52, $data['palabras']).",".mostrar_palabra(53, $data['palabras']).",".mostrar_palabra(54, $data['palabras']).",".mostrar_palabra(55, $data['palabras']).",".mostrar_palabra(107, $data['palabras']).",".mostrar_palabra(50, $data['palabras']).",".mostrar_palabra(51, $data['palabras']).",".mostrar_palabra(93, $data['palabras']);
		
		$data2 = array(
            'mpp_unsubscribe' => 1
        );
        $this->db->where('mpp_id', $mail_id);
        $this->db->update('mails_para_publicidad', $data2);

        $data['mensaje'] = "You are no longer receiving this email.";

		$this->load->view('pages/mensaje', $data);
	}

	public function mail_publicidad_sendgrid($destino, $mail_id, $idi_code = "en")
	{
	    $this->load->library('email'); // load library
	    $this->email->clear(TRUE);
	    
	    $config['mailtype'] = 'html';
	    $config['charset'] = 'utf-8';
	    $config['wordwrap'] = TRUE;
	    $config['protocol'] = 'sendmail';

	    $this->email->initialize($config);

	    $this->load->model('palabras_model');
	    $palabras = $this->palabras_model->get_items($idi_code);
	    $palabras_en = $this->palabras_model->get_items("en");

	$cuerpo = "";

	$cuerpo .= '<table style="width:100%; text-align:center; color:#FFFFFF; font-family:Arial;">
	        <tr>
	            <td>

	                <table id="Table_01" width="760" height="715" border="0" cellpadding="0" cellspacing="0" bgcolor="#b10036" style="margin:auto; color:#FFFFFF; background: #b10036 url(\''.base_url('assets/images/mail_fondo.jpg').'\') no-repeat;">
	                    <tr>
	                        <td rowspan="4" width="95" height="680"></td>
	                        <td width="565" height="220" style="text-transform:uppercase; text-align:center; ">
	                            <img src="http://www.Sistema.com/assets/images/logo.png" width="460px" style="margin-top:40px;"><br><br>
	                            '.mostrar_palabra(93, $palabras).'
	                        </td>
	                        <td rowspan="4" width="100" height="680"></td>
	                    </tr>
	                    <tr>
	                        <td width="565" style="padding-bottom:10px;">';
	                        if($idi_code != "en")
	                        {
	                            $cuerpo .= nl2br(mostrar_palabra(102, $palabras)).'<br><br>';
	                        }
	                        $cuerpo .= '<span style="font-style:italic;">'.nl2br(mostrar_palabra(102, $palabras_en)).'</span><br>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td width="565" style="border-top: 1px solid #FFFFFF; border-bottom: 1px solid #FFFFFF; padding: 10px 0px;">';
	                        if($idi_code != "en")
	                        {
	                            $cuerpo .= nl2br(mostrar_palabra(119, $palabras)).'<br><br>';
	                        }
	                        $cuerpo .= '<span style="font-style:italic;">'.nl2br(mostrar_palabra(119, $palabras_en)).'</span>
	                        </td>
	                    </tr>
	                    <tr>
	                        <td width="565">
	                            <a href="'.site_url().'" style="margin:auto; display:block; padding:15px 10px; width:200px; color:#FFFFFF; text-decoration:none;">WWW.Sistema.COM</a>
	                        </td>
	                    </tr>
	                    <tr bgcolor="#FFFFFF" style="background:#FFFFFF; text-align:center">
	                        <td width="95" height="111" bgcolor="#FFFFFF" style="background:#FFFFFF;"></td>
	                        <td width="565" height="111" bgcolor="#FFFFFF" style="background:#FFFFFF;">
	                            
	                        </td>
	                        <td width="100" height="111" bgcolor="#FFFFFF" style="background:#FFFFFF;"></td>
	                    </tr>
	                    <tr>
	                        <td colspan="5" bgcolor="#FFFFFF">
	                            <a href="'.site_url('publicidad/unsubscribe/'.$mail_id).'">Click here to unsubscribe</a>
	                        </td>
	                    </tr>
	                </table>

	            </td>
	        </tr>
	    </table>';

	    /*
	    $this->email->from('contact@Sistema.com', 'Sistema', 'contact@Sistema.com');
	    $this->email->reply_to('contact@Sistema.com', 'Sistema');
	    $this->email->to($destino);
	    //$this->email->cc('another@another-example.com');
	    //$this->email->bcc('them@their-example.com');

	    $this->email->subject(mostrar_palabra(231, $palabras));
	    $this->email->message(htmlspecialchars($cuerpo));
	    $this->email->set_alt_message(mostrar_palabra(102, $palabras).'\r\n'.mostrar_palabra(119, $palabras));
	    
	    if ( ! $this->email->send())
	    {
	        return false;
	    }
	    
	    //echo $cuerpo;
	    return true;
	    */
	    //require_once("sendgrid-php.php");
	    $this->load->helper('sendgrid');

	    $sendgrid = new SendGrid("news@Sistema.com");
	    $mail = new SendGrid\Email();

	    /* SEND MAIL
	    /  Replace the the address(es) in the setTo/setTos
	    /  function with the address(es) you're sending to.
	    ====================================================*/
	    try {
	        $mail->
	        setFrom( "news@Sistema.com" )->
	        addTo( $destino )->
	        setSubject( mostrar_palabra(231, $palabras) )->
	        setText( "Si no puede visualizar el mail por favor ingrese aqui: https://www.Sistema.com/" )->
	        setHtml( $cuerpo );
	        
	        $response = $sendgrid->send( $mail );

	        if (!$response) {
	            return false;
	        } else {
	            return true;
	        }
	    } catch ( Exception $e ) {
	        return false;
	    }
	}

}
