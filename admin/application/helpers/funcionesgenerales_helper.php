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
        $fecha_final = $fecha_aux[0].'/'.$fecha_aux[1].'/'.$fecha_aux[2];
  }

  return $fecha_final;
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

    // Si el numero de carateres del texto es menor que el tamaño maximo,
    // el tamaño maximo pasa a ser el del texto
    if (strlen($texto) < $tamano)
    {
    	 $textoFinal = $texto;
    }
    else
    {
	    for ($i=0; $i <= $tamano - 1; $i++)
	    {
	        // Añadimos uno por uno cada caracter del texto
	        // original al texto final, habiendo puesto
	        // como limite la variable $tamano
	        $textoFinal .= $texto[$i];
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

function calcular_edad($fecha)
{
    $dias = explode("-", $fecha, 3);
    $dias = mktime(0,0,0,$dias[1],$dias[2],$dias[0]);
    $edad = (int)((time()-$dias)/31556926);
    return $edad;
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