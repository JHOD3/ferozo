//var base_url = "http://localhost:8888/Mad/";

  function estructura_login()
  {
    var htmlData = '';

    htmlData += '<input type="hidden" value="" name="buscar_letra" id="buscar_letra">';

    htmlData += '<div id="fondo_negro">';
      htmlData += '<div id="area_login">';
        htmlData += '<div class="area_login_titulo">LOGIN <span class="color_texto">RESERVAS</span></div>';
        htmlData += '<div class="area_login_mensaje" id="area-mensaje"></div>';
        htmlData += 'Usuario<br>';
        htmlData += '<input type="text" name="usuario" id="usuario"><br>';
        htmlData += 'Contraseña<br>';
        htmlData += '<input type="password" name="clave" id="clave"><br>';
        htmlData += '<br>';
        htmlData += '<button class="btn" onclick="login()">LOGIN</button><br>';
        htmlData += '<br>';
        htmlData += 'Registrarme<br>';
        htmlData += 'Olvide mi contraseña<br>';
      htmlData += '</div>';
    htmlData += '</div>';

    $('section').html(htmlData);

    $('footer').show();
    $('#sumate').show();

    //cargar_usuarios();
  }

  function login()
  {
    $.ajax({
       type: 'POST',
        data: jQuery.param({usuario:$('#usuario').val(), clave:$('#clave').val()}),
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
       url: base_url+"index.php/webservices/login",
       success: function(data){
          if(data.error == false)
          {
            usr_id = data.data.gim_usr_id;
            usr_nombre = data.data.gim_usr_nombre;
            usr_apellido = data.data.gim_usr_apellido;
            estructura_reservas();
          }
          else
          {
            $('#area-mensaje').html(data.data);
          }
       },
       error: function(x, status, error){
          var htmlData = "An error occurred: " + status + " nError: " + error;
          $('#area-mensaje').html(htmlData);
       }
    });
  }