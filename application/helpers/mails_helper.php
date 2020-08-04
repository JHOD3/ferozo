<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

////////////////////
// USO COMUN /////
///////////////////
function mail_style()
{
    $htmlData = "<style type='text/css'>
            body {width: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased; font-family: 'Open Sans', sans-serif;}
            table {border-collapse: collapse;}
        </style>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>";

    return $htmlData;
}


////////////////////////
/// MAILS
///////////////////////

function mail_crudo($destino, $asunto = "Sistema", $titulo = "Sistema", $mensaje1 = "", $mensaje2 = "")
{
    $CI =& get_instance();

$cuerpo = "";

$cuerpo .= '<table align="center" cellspacing="0" cellpadding="0" bgcolor="#ce2600" width="100%" style="font-family:Arial,Helvetica,Verdana,sans-serif; font-size:18px; color:#666666; line-height:1em;">
        <tbody>
            <tr>
                <td style="padding:20px 20px 20px 20px;">
                    <table style="background-color:#ffffff;" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" align="center" width="560">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <img style="display:block;" border="0" height="10" width="560" alt="" src="'.base_url().'images/top.jpg">
                                </td>
                            </tr>
                            <tr>
                                <td width="508">
                                    <table cellpadding="0" cellspacing="0" border="0" width="500">
                                        <tbody>
                                            <tr>
                                                <td style="padding:36px 27px 0 30px;" align="left">
                                                    <div style="font-family:Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;font-size:18px;color:#666666;line-height:1em;">
                                                        '.$titulo.'
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td align="right" width="52">
                                    <table cellpadding="0" cellspacing="0" border="0" width="60">
                                        <tbody>
                                            <tr>
                                                <td style="padding:0px 0px 0 0;" align="left">
                                                    <img style="display:block;padding-bottom:3px;" border="0" height="50" width="50" alt="" src="'.base_url().'images/icono_chico_rojo.png">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" height="24"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <table cellpadding="0" cellspacing="0" border="0" width="560">
                                        <tbody>
                                            <tr>
                                                <td style="padding:0 30px 0 30px;" align="left">
                                                    <div style="font-family:Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;font-size:12px;color:#666666;line-height:1.4em;">
                                                        '.$mensaje1.'
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" height="24"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <table cellpadding="0" cellspacing="0" border="0" width="560">
                                        <tbody>
                                            <tr>
                                                <td style="padding:0 30px 0 30px;" align="left">
                                                    <div style="font-family:Lucida Grande,Lucida Sans,Lucida Sans Unicode,Arial,Helvetica,Verdana,sans-serif;font-size:12px;color:#666666;line-height:1.4em;">
                                                        '.$mensaje2.'
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" height="24"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-top:11px;">
                                    <img style="display:block;" alt="" border="0" height="10" width="560" src="'.base_url().'images/bot.jpg">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="font-size:9px;line-height:1.4em;" align="center" cellpadding="0" cellspacing="0" border="0" width="500">
                        <tbody>
                            <tr>
                                <td style="padding-top:20px;" align="center">
                                    <div style="font-family:Geneva,Verdana,Arial,Helvetica,sans-serif;color:#FFFFFF;">
                                        Copyright &copy; 2016-'.date('Y').' <a href="'.site_url().'">Sistema LLC</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>';

    //mail_smtp($destino, $asunto, $cuerpo);

    mail_sendgrid($destino, $asunto, $cuerpo);
}


function mail_base($destino, $asunto = "Sistema", $titulo = "Sistema", $mensaje1 = "", $mensaje2 = "")
{
    $CI =& get_instance();

    $CI->load->model('palabras_model');
    $palabras = $CI->palabras_model->get_items($CI->session->userdata('idi_code'));

$cuerpo = "";

$cuerpo .= '<table style="width:100%; text-align:center; color:#FFFFFF; font-family:Arial;">
        <tr>
            <td>

                <table id="Table_01" width="760" height="715" border="0" cellpadding="0" cellspacing="0" bgcolor="#b10036" style="margin:auto; color:#FFFFFF; background: #b10036 url(\''.base_url('assets/images/mail_fondo.jpg').'\') no-repeat;">
                    <tr>
                        <td rowspan="4" width="95" height="680"></td>
                        <td width="565" height="278" style="text-transform:uppercase; text-align:center; ">
                            <img src="http://www.Sistema.com/assets/images/logo.png" width="460px" style="margin-top:40px;"><br><br>
                            '.mostrar_palabra(93, $palabras).'
                        </td>
                        <td rowspan="4" width="100" height="680"></td>
                    </tr>
                    <tr>
                        <td width="565" style="padding-bottom:10px;">
                        <span style="font-weight:bold; font-size:20px; color:#FFFFFF;">'.$titulo.'</span><br>
                        '.nl2br($mensaje1).'<br>
                        </td>
                    </tr>
                    <tr>';
                    if($mensaje2 != "")
                    {
                        $borde = 'style="border-top: 1px solid #FFFFFF; border-bottom: 1px solid #FFFFFF; padding: 10px 0px;"';
                    }
                    else
                    {
                        $borde = '';
                    }
            $cuerpo .= '<td width="565" '.$borde.'>
                        '.nl2br($mensaje2).'
                        </td>';
        $cuerpo .= '</tr>
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
                </table>

            </td>
        </tr>
    </table>';

    //mail_smtp($destino, $asunto, $cuerpo);

    mail_sendgrid($destino, $asunto, $cuerpo);
}


function mail_base_sendgrid($destino, $asunto = "Sistema", $titulo = "Sistema", $mensaje1 = "", $mensaje2 = "")
{
    $CI =& get_instance();

    $CI->load->model('palabras_model');
    $palabras = $CI->palabras_model->get_items($CI->session->userdata('idi_code'));

$cuerpo = "";

$cuerpo .= '<table style="width:100%; text-align:center; color:#FFFFFF; font-family:Arial;">
        <tr>
            <td>

                <table id="Table_01" width="760" height="715" border="0" cellpadding="0" cellspacing="0" bgcolor="#b10036" style="margin:auto; color:#FFFFFF; background: #b10036 url(\''.base_url('assets/images/mail_fondo.jpg').'\') no-repeat;">
                    <tr>
                        <td rowspan="4" width="95" height="680"></td>
                        <td width="565" height="278" style="text-transform:uppercase; text-align:center; ">
                            <img src="http://www.Sistema.com/assets/images/logo.png" width="460px" style="margin-top:40px;"><br><br>
                            '.mostrar_palabra(93, $palabras).'
                        </td>
                        <td rowspan="4" width="100" height="680"></td>
                    </tr>
                    <tr>
                        <td width="565" style="padding-bottom:10px;">
                        <span style="font-weight:bold; font-size:20px; color:#FFFFFF;">'.$titulo.'</span><br>
                        '.nl2br($mensaje1).'<br>
                        </td>
                    </tr>
                    <tr>';
                    if($mensaje2 != "")
                    {
                        $borde = 'style="border-top: 1px solid #FFFFFF; border-bottom: 1px solid #FFFFFF; padding: 10px 0px;"';
                    }
                    else
                    {
                        $borde = '';
                    }
            $cuerpo .= '<td width="565" '.$borde.'>
                        '.nl2br($mensaje2).'
                        </td>';
        $cuerpo .= '</tr>
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
                </table>

            </td>
        </tr>
    </table>';

    
    //mail_smtp($destino, $asunto, $cuerpo);

    mail_sendgrid($destino, $asunto, $cuerpo);
}


function mail_base_texto($destino, $asunto = "Sistema", $titulo = "Sistema", $mensaje1 = "", $mensaje2 = "")
{
    $CI =& get_instance();

    $CI->load->model('palabras_model');
    $palabras = $CI->palabras_model->get_items($CI->session->userdata('idi_code'));

    $cuerpo = "";

    $cuerpo .= mostrar_palabra(93, $palabras).'\n\r';
    $cuerpo .= $titulo.'\n\r';
    $cuerpo .= $mensaje1.'\n\r';
    $cuerpo .= $mensaje2.'\n\r';
    $cuerpo .= 'WWW.Sistema.COM';

    
    //mail_smtp($destino, $asunto, $cuerpo);

    mail_sendgrid($destino, $asunto, $cuerpo);
}


function mail_publicidad($destino, $mail_id, $mail_codigo, $idi_code = "en")
{
    $CI =& get_instance();
    $CI->load->library('email'); // load library
    $CI->email->clear(TRUE);
    
    $config['mailtype'] = 'html';
    $config['charset'] = 'utf-8';
    $config['wordwrap'] = TRUE;
    $config['protocol'] = 'sendmail';

    $CI->email->initialize($config);

    $CI->load->model('palabras_model');
    $palabras = $CI->palabras_model->get_items($idi_code);
    $palabras_en = $CI->palabras_model->get_items("en");

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
                            <a href="'.site_url('pages/unsubscribe/'.$mail_id.'/'.$mail_codigo).'">Click here to unsubscribe</a>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>';

    
    $CI->email->from('news@Sistema.com', 'Sistema', 'news@Sistema.com');
    $CI->email->reply_to('news@Sistema.com', 'Sistema');
    $CI->email->to($destino);
    //$CI->email->cc('another@another-example.com');
    //$CI->email->bcc('them@their-example.com');

    $CI->email->subject(mostrar_palabra(231, $palabras));
    $CI->email->message(htmlspecialchars($cuerpo));
    $CI->email->set_alt_message(mostrar_palabra(102, $palabras).'\r\n'.mostrar_palabra(119, $palabras));
    
    if ( ! $CI->email->send())
    {
        return false;
    }
    
    //echo $cuerpo;
    return true;
}


function mail_publicidad_sendgrid($destino, $mail_id, $mail_codigo, $idi_code = "en")
{
    $CI =& get_instance();
    $CI->load->library('email'); // load library
    $CI->email->clear(TRUE);
    
    $config['mailtype'] = 'html';
    $config['charset'] = 'utf-8';
    $config['wordwrap'] = TRUE;
    $config['protocol'] = 'sendmail';

    $CI->email->initialize($config);

    $CI->load->model('palabras_model');
    $palabras = $CI->palabras_model->get_items($idi_code);
    $palabras_en = $CI->palabras_model->get_items("en");

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
                        <br>
                        https://youtu.be/mWCN47BwVIk
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
                            <a href="'.site_url().'" style="margin:auto; display:block; padding:15px 10px; width:200px; color:#FFFFFF; text-decoration:none;">WWW.Sistema.COM</a><br>
                            <br>
                            Copyright © 2016-2018 - Sistema LLC<br>
                            All rights reserved
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
                            <a href="'.site_url('pages/unsubscribe/'.$mail_id.'/'.$mail_codigo).'">Click here to unsubscribe</a>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>';

    /*
    $CI->email->from('contact@Sistema.com', 'Sistema', 'contact@Sistema.com');
    $CI->email->reply_to('contact@Sistema.com', 'Sistema');
    $CI->email->to($destino);
    //$CI->email->cc('another@another-example.com');
    //$CI->email->bcc('them@their-example.com');

    $CI->email->subject(mostrar_palabra(231, $palabras));
    $CI->email->message(htmlspecialchars($cuerpo));
    $CI->email->set_alt_message(mostrar_palabra(102, $palabras).'\r\n'.mostrar_palabra(119, $palabras));
    
    if ( ! $CI->email->send())
    {
        return false;
    }
    
    //echo $cuerpo;
    return true;
    */
    require_once("sendgrid-php.php");

    $sendgrid = new SendGrid("contact@Sistema.com");
    $mail = new SendGrid\Email();

    /* SEND MAIL
    /  Replace the the address(es) in the setTo/setTos
    /  function with the address(es) you're sending to.
    ====================================================*/
    try {
        $mail->
        setFrom( "contact@Sistema.com" )->
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

function mail_smtp($destino, $asunto, $cuerpo)
{
    $CI->load->library('email'); // load library
    $CI->email->clear(TRUE);
    
    $config = array(
                    'mailtype' => 'html',
                    'protocol' => 'sendmail',
                    'smtp_host' => 'mail.Sistema.com',
                    'smtp_port' => 25, 
                    'smtp_user' => 'contact@Sistema.com',
                    'smtp_pass' => 'Contact1234',
                    'charset' => 'utf-8',
                    'smtp_timeout' => 30
                ); 
    
    $CI->email->initialize($config);

    $CI->email->from('contact@Sistema.com', 'Sistema');
    $CI->email->reply_to('contact@Sistema.com', 'Sistema');
    $CI->email->to($destino);
    //$CI->email->cc('another@another-example.com');
    $CI->email->bcc('contact@Sistema.com');

    $CI->email->subject($asunto);
    $CI->email->message($cuerpo);
    $CI->email->set_alt_message("Si no puede visualizar el mail por favor ingrese aqui: https://www.Sistema.com/");
    
    if ( ! $CI->email->send())
    {
        return false;
    }
    
    //echo $cuerpo;
    return true;
}

function mail_sendgrid($destino, $asunto, $cuerpo)
{
    require_once("sendgrid-php.php");

    $sendgrid = new SendGrid( );
    $mail = new SendGrid\Email();

    /* SEND MAIL
    /  Replace the address(es) in the setTo/setTos
    /  function with the address(es) you're sending to.
    ====================================================*/
    try {
        $mail->
        setFrom( "contact@Sistema.com" )->
        addTo( $destino )->
        setSubject( $asunto )->
        setText( "Si no puede visualizar el mail por favor ingrese aqui: https://www.Sistema.com/" )->
        setHtml( $cuerpo );
        
        $response = $sendgrid->send( $mail );
        //print_r($response);
        if (!$response) {
            return false;
        } else {
            return true;
        }
    } catch ( Exception $e ) {
        //print_r($e);
        return false;
    }
}