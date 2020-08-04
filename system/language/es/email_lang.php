<?php

$lang['email_must_be_array'] = "El método de validación de correo debe ser pasado como un arreglo.";
$lang['email_invalid_address'] = "Dirección de correo no válida: %s";
$lang['email_attachment_missing'] = "No se ha podido localizar el fichero adjunto: %s";
$lang['email_attachment_unreadable'] = "No se ha podido abrir el fichero adjunto: %s";
$lang['email_no_recipients'] = "Debe incluir receptores: Para, CC, o BCC";
$lang['email_send_failure_phpmail'] = "No puedo enviar el correo usando la función mail() de PHP.  Su servidor puede no estar configurado para usar este metodo de envío.";
$lang['email_send_failure_sendmail'] = "No puedo enviar el correo usando SendMail. Su servidor puede no estar configurado para usar este metodo de envío.";
$lang['email_send_failure_smtp'] = "No puedo enviar el correo usando SMTP PHP. Su servidor puede no estar configurado para usar este metodo de envío.";
$lang['email_sent'] = "Su mensaje a sido enviado satisfactoriamente usando el siguiente protocolo: %s";
$lang['email_no_socket'] = "No puedo abrir un socket para Sendmail. Por favor revise las configuraciones.";
$lang['email_no_hostname'] = "No has especificado un servidor SMTP";
$lang['email_smtp_error'] = "Los siguientes errores SMTP han sido encontrados: %s";
$lang['email_no_smtp_unpw'] = "Error: Debes asignar un usuario y contraseña para el servidor SMTP."; 
$lang['email_failed_smtp_login'] = "Falló enviando el comando AUTH LOGIN command. Error: %s";
$lang['email_smtp_auth_un'] = "Falló autentificando el usuario. Error: %s";
$lang['email_smtp_auth_pw'] = "Falló usando la contraseña. Error: %s";
$lang['email_smtp_data_failure'] = "No se han podido enviar los datos: %s";
/* New in 1.6 or Higher  */
$lang['email_exit_status'] = "Código de estado de salida: %s";
// 1
$lang['email_bienvenida_asunto'] = "Bienvenido a Sistema";
$lang['email_bienvenida_titulo'] = "Estimado/a usuario";
$lang['email_bienvenida_mensaje1'] = "Le damos la bienvenida a Sistema.<br>Esta plataforma de negocios le permitirá a Ud. conectarse de manera simple y gratuita con quienes buscan aquellos productos o servicios que tú ofreces, o bien con aquellos que ofrecen los productos o servicios que tú buscas.<br>Por cuestiones de seguridad,​ debe validar su dirección de correo electrónico antes de obtener acceso a esta comunidad.​<br>Solo haga clic en el enlace a continuación para validar su dirección y completar un registro breve: <br>[BOTON]";
$lang['email_bienvenida_mensaje2'] = "Si ese enlace no funciona,​ puede validar su dirección de correo electrónico manualmente en este enlace,​ donde deberá ingresar la siguiente información:​<br>[LINK]<br>Correo electrónico: [MAIL]<br>Símbolo: [CODIGO]<br>Si no solicitó unirse a Sistema, desestime este correo electrónico.​<br><br>Atentamente<br>El equipo de Sistema.";
// 2
$lang['email_olvide_asunto'] = "Solicitud de contraseña perdida en Sistema";
$lang['email_olvide_titulo'] = "Estimado/a usuario";
$lang['email_olvide_mensaje1'] = "Hemos recibido una solicitud para resetear la contraseña de su cuenta [MAIL].<br>Haga clic en el enlace siguiente para completar el proceso:<br>[BOTON]";
$lang['email_olvide_mensaje2'] = "Si no solicitó resetear su contraseña, póngase en contacto con el Equipo de Sistema al siguiente correo electrónico.<br>contact@Sistema.com<br><br>Atentamente<br>El equipo de Sistema";
// 3
$lang['email_clave_asunto'] = "Contraseña cambiada con éxito";
$lang['email_clave_titulo'] = "Estimado/a usuario";
$lang['email_clave_mensaje1'] = "La contraseña para su cuenta en Sistema fue cambiada correctamente.";
$lang['email_clave_mensaje2'] = "Si usted no ha autorizado este cambio, póngase en contacto con el Equipo de Sistema al siguiente correo electrónico.<br>contact@Sistema.com<br><br>Atentamente<br>El equipo de Sistema";
// 4
$lang['email_mail_asunto'] = "Se ha añadido otro correo electrónico a su cuenta Sistema";
$lang['email_mail_titulo'] = "Estimado/a usuario";
$lang['email_mail_mensaje1'] = "Ha añadido un correo electrónico adicional de contacto ([MAIL]) a su cuenta en Sistema.<br>Por cuestiones de seguridad, debe validar la nueva dirección de correo electrónico suministrada.<br>Solo haga clic en el enlace a continuación para validar su dirección de correo electrónico:<br>[BOTON]";
$lang['email_mail_mensaje2'] = "Si ese enlace no funciona, puede validar su dirección de correo electrónico manualmente en este enlace, donde deberá ingresar la siguiente información:<br>[LINK]<br>Correo electrónico: [MAIL]<br>Símbolo: [CODIGO]<br><br>Si no solicitó unirse a Sistema, desestime este correo electrónico.<br><br>Atentamente<br>El equipo de Sistema";
// 5
$lang['email_resultados_asunto'] = "Nuevas coincidencias en tu cuenta de Sistema";
$lang['email_resultados_titulo'] = "Estimado/a usuario";
$lang['email_resultados_mensaje1'] = "Le informamos que existen X nuevos contactos cuyos perfiles de oferta y demanda coinciden con las búsquedas que usted ha cargado en su cuenta de Sistema.<br><br>Atentamente<br>El equipo de Sistema";
$lang['email_resultados_mensaje2'] = "";
// 6
$lang['email_contacto_asunto'] = "Contacto Sistema";
$lang['email_contacto_titulo'] = "Estimado/a usuario";
$lang['email_contacto_mensaje1'] = "Hemos recibido su correo electrónico, le estaremos respondiendo a la brevedad.<br>Muchas gracias!<br><br>Atentamente<br>El equipo de Sistema";
$lang['email_contacto_mensaje2'] = "";
// 7
$lang['email_volve_asunto'] = "Contacto Sistema";
$lang['email_volve_titulo'] = "Estimado/a usuario";
$lang['email_volve_mensaje1'] = "Hace tiempo que no chequeas tu cuenta de Sistema.<br>Muchos contactos te están esperando para hacer negocios!<br>[LINK]<br><br>Atentamente<br>El equipo de Sistema";
$lang['email_volve_mensaje2'] = "";
// 8
$lang['email_destacado_asunto'] = "Alta – Plan Mensual/Anual Usuario Destacado";
$lang['email_destacado_titulo'] = "Estimado/a usuario";
$lang['email_destacado_mensaje1'] = "Le informamos que hemos recibido correctamente su pago por el plan mensual/anual del servicio Usuario Destacado en Sistema.<br>A partir de las 24hs contará con todos los beneficios del servicio.<br><br>Atentamente<br>El equipo de Sistema";
$lang['email_destacado_mensaje2'] = "";
// 9
$lang['email_suspendido_asunto'] = "Suspensión – Plan Mensual/Anual Usuario Destacado";
$lang['email_suspendido_titulo'] = "Estimado/a usuario";
$lang['email_suspendido_mensaje1'] = "Le informamos que procederemos a suspender el plan mensual/anual del servicio Usuario Destacado en Sistema dado que no hemos podido computar el pago por el periodo de [FECHA].";
$lang['email_suspendido_mensaje2'] = "Por favor regularice su situación en las próximas 24hs para evitar la baja del servicio.<br>[LINK]<br><br>Atentamente<br>El equipo de Sistema";
// 10
$lang['email_baja_asunto'] = "Baja – Plan Mensual/Anual Usuario Destacado";
$lang['email_baja_titulo'] = "Estimado/a usuario";
$lang['email_baja_mensaje1'] = "Le informamos que se ha efectuado la baja del plan mensual/anual del servicio Usuario Destacado en Sistema";
$lang['email_baja_mensaje2'] = "Si desea pude volver a contratar el servicio en el siguiente link.<br>[LINK]<br><br>Atentamente<br>El equipo de Sistema";
// 11
$lang['email_pago_rechazado_asunto'] = "Pago rechazado – Plan Mensual/Anual Usuario Destacado";
$lang['email_pago_rechazado_titulo'] = "Estimado/a usuario";
$lang['email_pago_rechazado_mensaje1'] = "Le informamos que no hemos podido procesar su pago por el plan mensual/anual del servicio Usuario Destacado en Sistema.";
$lang['email_pago_rechazado_mensaje2'] = "Por favor póngase en contacto con su tarjeta de crédito para corroborar que todo este orden e intente efectuar la operación nuevamente.<br>Desde ya muchas gracias.<br><br>Atentamente<br>El equipo de Sistema";
// 12
$lang['email_publicidad_asunto'] = "Alta – Plan Mensual/Anual Publicidad 10 HS6/S";
$lang['email_publicidad_titulo'] = "Estimado/a usuario";
$lang['email_publicidad_mensaje1'] = "Le informamos que hemos recibido correctamente su pago por el plan mensual/anual del servicio de Publicidad 10 HS6/S en Sistema.<br>Por favor enviar al correo electrónico contact@Sistema.com:<br>1) Imagen que utilizaremos como banner publicitario. La imagen debe cumplir con los siguientes requisitos.<br>- Tamaño: 12cm x 45cm<br>- Formato: jpg <br>- Contenido: No debe ser obsceno ni ofensivo.<br>2) Dirección http a la cual serán direccionados los usuario que hagan click en el banner publicado.<br>3) Listado de las 10 Posiciones Arancelarias de Producto (HS 6 dígitos) ó Categorías de Servicio, cada una con su correspondiente país, a las que será dirigido el aviso publicitario.";
$lang['email_publicidad_mensaje2'] = "A partir de las 24hs de haber recibido la información solicitada contará con todos los beneficios del servicio.<br><br>Atentamente<br>El equipo de Sistema";

/* End of file email_lang.php */
/* Location: ./system/language/english/email_lang.php */