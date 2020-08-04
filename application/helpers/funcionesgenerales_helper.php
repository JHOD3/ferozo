<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Se utiliza en RECUPERAR PASSWORD.PHP
function RandomString($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE)
{
    $source = 'abcdefghijklmnopqrstuvwxyz';
    if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if($n==1) $source .= '1234567890';
    if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
    if($length>0){
        $rstr = "";
        $source = str_split($source,1);
        for($i=1; $i<=$length; $i++){
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(1,count($source));
            $rstr .= $source[$num-1];
        }

    }
    return $rstr;
}

function getUserLanguage()
{ 
    $idioma =substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
    return $idioma; 
}

// ------------- FORMATEAR lA FECHA ------///
function formatear_fecha($fecha, $tipo)
{
  if($tipo == 1) //Formato AAAA-MM-DD
  {
    $fecha_aux = explode('-',$fecha);
    if(count($fecha_aux)<3)
    {
        $fecha_aux = explode('/',$fecha);
    }
    if(count($fecha_aux)<3)
    {
        return $fecha;
    }

    if(strlen($fecha_aux[0])>2)
    {
        $fecha_final = $fecha_aux[0].'/'.$fecha_aux[1].'/'.$fecha_aux[2];
    }
    else
        $fecha_final = $fecha_aux[2].'/'.$fecha_aux[1].'/'.$fecha_aux[0];
  }
  else  //Formato DD-MM-AAAA
  {
    $fecha_aux = explode('-',$fecha);
    if(count($fecha_aux)<3)
    {
        $fecha_aux = explode('/',$fecha);
    }
    if(count($fecha_aux)<3)
    {
        return $fecha;
    }

    if(strlen($fecha_aux[0])>2)
    {
        $fecha_final = $fecha_aux[2].'/'.$fecha_aux[1].'/'.$fecha_aux[0];
    }
    else
    {
        $fecha_final = $fecha_aux[0].'/'.$fecha_aux[1].'/'.$fecha_aux[2];
    }
  }

  return $fecha_final;
}

// ------------- FORMATEAR FECHA Y HORA ------///
function formatear_fecha_hora($fecha, $tipo)
{
    $fecha_hora_aux = explode(' ',$fecha);
    $fecha = $fecha_hora_aux[0];
    $hora = $fecha_hora_aux[1];

  if($tipo == 1) //Formato salida AAAA-MM-DD
  {
    $fecha_aux = explode('-',$fecha);
    if(count($fecha_aux)<3)
    {
        $fecha_aux = explode('/',$fecha);
    }
    if(count($fecha_aux)<3)
    {
        return $fecha . " " . $hora;
    }

    if(strlen($fecha_aux[0])>2)
    {
        $fecha_final = $fecha_aux[0].'-'.$fecha_aux[1].'-'.$fecha_aux[2];
    }
    else
    {
        $fecha_final = $fecha_aux[2].'-'.$fecha_aux[1].'-'.$fecha_aux[0];
    }
  }
  else  //Formato salida DD-MM-AAAA
  {
    $fecha_aux = explode('-',$fecha);
    if(count($fecha_aux)<3)
    {
        $fecha_aux = explode('/',$fecha);
    }
    if(count($fecha_aux)<3)
    {
        return $fecha . " " . $hora;
    }

    if(strlen($fecha_aux[0])>2)
    {
        $fecha_final = $fecha_aux[2].'-'.$fecha_aux[1].'-'.$fecha_aux[0];
    }
    else
        $fecha_final = $fecha_aux[0].'-'.$fecha_aux[1].'-'.$fecha_aux[2];
  }

  return $fecha_final . " " . $hora;
}

// VERIFICO QUE EL FORMATO DEL EMAIL SEA CORRECTO //
function checkEmail($email)
{
  // checks proper syntax
  if( !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
    return false;
  else
  	return true;
}

// VERIFICO EL EMAIL PARA PUBLICIDAD
function is_valid_email($str)
{
  $result = (false !== filter_var($str, FILTER_VALIDATE_EMAIL));
  
  if ($result)
  {
    list($user, $domain) = explode('@', $str);
    
    $result = checkdnsrr($domain, 'MX');
  }
  
  return $result;
}

// VERIFICO SI UN CAMPO ESTA VACIO
function esVacio($variable)
{
  if($variable == NULL || $variable == "" )
      return TRUE;

  return FALSE;
}

function cortarTexto($texto, $tam)
{
    $tamano = $tam; // tamaño máximo
    $textoFinal = ''; // Resultado

    if (strlen($texto) < $tamano)
    {
        $textoFinal = $texto;
    }
    else
    {
        $i=0;
        for ($i; $i <= ($tamano - 1); $i++)
        {
            // Añadimos uno por uno cada caracter del texto
            // original al texto final, habiendo puesto
            // como limite la variable $tamano
            $textoFinal .= $texto[$i];
        }
        
        while($texto[$i] != " " && strlen($texto) < $i)
        {
            $textoFinal .= $texto[$i];
            $i++;
        }
        
        $textoFinal .= '...';
    }
    // devolvemos el texto final
    return $textoFinal;
}

function calcular_edad($fecha)
{
    $dias = explode("-", $fecha, 3);
    if($dias && count($dias)==3)
    {
        $dias = mktime(0,0,0,$dias[1],$dias[2],$dias[0]);
        $edad = (int)((time()-$dias)/31556926);
        return $edad;
    }
    
    return FALSE;
}

function cortarTextoArabe($texto, $tam)
{
    $tamano = $tam; // tamaño máximo
    $textoFinal = ''; // Resultado

    // Si el numero de carateres del texto es menor que el tamaño maximo,
    // el tamaño maximo pasa a ser el del texto
    if (strlen($texto) < $tamano)
    {
         $textoFinal = $texto;
    }
    else
    {
        $i=strlen($texto);
        for ($i; $i >= 0; $i--)
        {
            // Añadimos uno por uno cada caracter del texto
            // original al texto final, habiendo puesto
            // como limite la variable $tamano
            $textoFinal .= $texto[$i];
        }
        
        while($texto[$i] != " " && strlen($texto) < $i)
        {
            $textoFinal .= $texto[$i];
            $i--;
        }
        
        $textoFinal .= '...';
    }
    // devolvemos el texto final
    return $textoFinal;
}

function ajustar_fuente($largo_caracteres, $maximo_caracteres, $tamano_maximo, $tamano_minimo)
{
    $return = "font-size:".$tamano_maximo."px;";
    if($largo_caracteres > $maximo_caracteres)
    {
        $return = "font-size:".($tamano_minimo)."px;";
    }
    return $return;
}

function filesize_formatted($path)
{
    $size = filesize($path);
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

function ordenarPorFecha($a, $b)
{
    if ($a['fecha'] == $b['fecha']) {
        return 0;
    }
    return ($a['fecha'] > $b['fecha']) ? -1 : 1;
}

function mes_por_numero($numero)
{
    $meses = array('', 'enero','febrero','marzo','abril','mayo','junio','julio', 'agosto','septiembre','octubre','noviembre','diciembre');
    return $meses[$numero];
}

function interval_date($init,$finish)
{
    //formateamos las fechas a segundos tipo 1374998435
    $diferencia = strtotime($finish) - strtotime($init);
 
    //comprobamos el tiempo que ha pasado en segundos entre las dos fechas
    //floor devuelve el número entero anterior, si es 5.7 devuelve 5
    if($diferencia < 60){
        $tiempo = floor($diferencia) . "s";
    }/*
    else if($diferencia > 60 && $diferencia < 3600){
        $tiempo = floor($diferencia/60) . "m";
    }
    else if($diferencia > 3600 && $diferencia < 86400){
        $horas = floor($diferencia/3600);
        $diferencia = $diferencia - ($horas*3600);
        $min = floor($diferencia/60);
        $tiempo = $horas . "h " . $min . "m";
    }
    else if($diferencia > 86400 && $diferencia < 2592000){
        $dias = floor($diferencia/86400);
        $diferencia = $diferencia - ($dias*86400);
        $horas = floor($diferencia/3600);
        $diferencia = $diferencia - ($horas*3600);
        $min = floor($diferencia/60);
        $tiempo = $dias . "d " . $horas . "h " . $min . "m";
    }
    else if($diferencia > 2592000 && $diferencia < 31104000){
        $meses = floor($diferencia/2592000);
        if($meses > 1)
          $tiempo = $meses  . " meses";
        else
          $tiempo = $meses  . " mes";
    }
    /*
    else if($diferencia > 31104000){
        $anios = floor($diferencia/31104000);
        if($anios > 1)
          $tiempo = $anios . " años";
        else
          $tiempo = $anios . " año";
    }
    */
    else{
        $tiempo = substr($init, 0, 10);
    }
    return $tiempo;
}

function diferencia_dias($fecha_ini, $fecha_fin)
{
    $datetime1 = date_create($fecha_ini);
    $datetime2 = date_create($fecha_fin);
    $interval = date_diff($datetime1, $datetime2);
    return $interval->format('%a');
}

function redondear_millones($num)
{
    $valor = $num;
    for($i=10; $i<10000000; $i=$i*10)
    {
        $valor = $num / $i;
        if($valor < 1000)
        {
            $valor = floor($valor);
            $valor = $valor * $i;
            break;
        }
    }
    return $valor;
}


function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}


function mostrar_palabra($num, $palabras)
{
    //return $palabras[$num]['pal_desc'];
    return $palabras[array_search($num, array_column($palabras, 'pal_id'))]['pal_desc'];
}

function mostrar_traducir($idi_origen, $idi_destino, $texto, $texto_boton)
{
    $boton = "";

    if($idi_origen == "zh")
    {
        $idi_origen = "zh-CN";
    }

    if($idi_destino == "zh")
    {
        $idi_destino = "zh-CN";
    }

    if($idi_origen != $idi_destino)
    {
        $boton = "<a class='btn btn-gris btn-sm' target='_blank' href='https://translate.google.com.ar/#".$idi_origen."/".$idi_destino."/".$texto."'>".$texto_boton."</a>";
    }

    return $boton;
}

function mostrar_nombre($nombre="", $apellido="", $mail="")
{
    $nombre_aux = "";
    if($nombre != "" && $nombre != "null")
    {
        $nombre_aux .= $nombre;
        if($apellido != "" && $apellido != "null")
        {
            $nombre_aux .= " ".$apellido;
        }
    }
    else
    {
        $nombre_aux .= $mail;
    }
    return $nombre_aux;
}
