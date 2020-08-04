<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('LINK_ADS', "Ads");

define('TARGET_ADS', 1);
define('MARKET_ADS', 2);

define('TU_COMUN', 1);
define('TU_PREMIUM', 2);

define('TP_OFERTA', 1);
define('TP_DEMANDA', 2);

define('IMPORTACION', 1);
define('EXPORTACION', 2);

define('NOTIFICACION_NUEVO_MATCH', 1);
define('NOTIFICACION_NUEVO_COMENTARIO_FORO', 2);
define('NOTIFICACION_ADS_NUEVO_FORM', 3);
define('NOTIFICACION_COBRANZA_INVITACION', 4);

define('NOTI_ESTADO_PENDIENTE', 0);
define('NOTI_ESTADO_ENVIADA', 1);
define('NOTI_ESTADO_RECIBIDA', 2);
define('NOTI_ESTADO_VISTA', 3);
define('NOTI_ESTADO_RESPONDIDA', 4);

define('REFERENCIA_ELIMINAR', -1);
define('REFERENCIA_PENDIENTE', 0);
define('REFERENCIA_VALIDADA', 1);
define('REFERENCIA_RECHAZADA', 2);

define('ADS_ID_IMPORTE_IMPRESION', 1);
define('ADS_ID_IMPORTE_CLICK', 2);
define('ADS_ID_IMPORTE_FORMULARIO', 3);

define('PAGO_DESTINO_ADS', 1);
define('PAGO_DESTINO_PREMIUM_USER', 2);

define('COBRANZA_ESTADO_INICIADO', 0);
define('COBRANZA_ESTADO_EN_REVISION', 1);
define('COBRANZA_ESTADO_APROBADO', 2);
define('COBRANZA_ESTADO_FINALIDAZA', 3);

define('COBRANZA_USUARIO_TIPO_1', 1);
define('COBRANZA_USUARIO_TIPO_2', 2);
define('COBRANZA_USUARIO_TIPO_3', 3);

define('COBRANZA_DOCUMENTO_ESTADO_ENVIADO', 1);
define('COBRANZA_DOCUMENTO_ESTADO_EN_REVISION', 2);
define('COBRANZA_DOCUMENTO_ESTADO_RECHAZADO', 3);
define('COBRANZA_DOCUMENTO_ESTADO_APROBADO', 4);
