//var base_url = "http://localhost:8888/Mad/";
var sesiones = [];

  function estructura_rutinas()
  {
    var htmlData = '<h1>PLAN DE ENTRENAMIENTO</h1>';

    //htmlData += '<div id="area_pregunta" style="font-size:32px;">CONSULTA AQUÍ TU PLAN DE ENTRENAMIENTO</div>';

    htmlData += '<input type="hidden" value="" name="buscar_letra" id="buscar_letra">';

    htmlData += '<div id="volver" style="float:left; margin-left:10px; margin-top:-115px; display:none;" onclick="cargar_usuarios()"><img src="'+base_url+'assets/img/gimnasios/volver.png"></div>';

    htmlData += '<div id="area_buscar" style="text-align:left; margin:0px 0px 20px 100px;">';
      htmlData += '<span style="font-size:23px;">Buscar</span><br>';
      htmlData += '<input type="text" value="" name="buscar" id="buscar" style="width:846px; height:30px; margin:0px; font-size:30px; float:left;" autocomplete="off">';
      htmlData += '<button style="height:54px; background:#BCBEC0; border:0px; margin:0px; float:left;" onclick="cargar_usuarios()"><img src="'+base_url+'assets/img/gimnasios/lupa.png"></button>';
      htmlData += '<div style="clear:both;"></div>';
    htmlData += '</div>';

    htmlData += '<div id="area_calendario" style="margin-left:0px; width:100%;">';
      htmlData += '<div id="area_letras" style="float:left; width:62px; margin:0px 40px 0px 0px;">';
        var letras = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','ñ','o','p','q','r','s','t','u','v','w','x','y','z'];
        $.each( letras, function( i, letra ) {
          htmlData += '<button class="btn-letra" id="btn_letra_'+letra+'" onclick="select_letra(\''+letra+'\')">'+letra.toUpperCase()+'</button>';
        });
      htmlData += '</div>';
      htmlData += '<div id="area_cosas" style="float:left; width:943px; height:890px;">';
      htmlData += '</div>';
    htmlData += '</div>';

    htmlData += '<div id="area_consultas_rutinas">';
      htmlData += '<h4>BUSQUEDAS RECIENTES</h4>';
      htmlData += '<div id="area_flecha_izquierda_consultas" onclick="izquierda_consultas();"><i class="fa fa-chevron-left fa-5x"></i></div>';
      htmlData += '<div id="area_consultas"></div>';
      htmlData += '<div id="area_flecha_derecha_consultas" onclick="derecha_consultas();"><i class="fa fa-chevron-right fa-5x"></i></div>';
    htmlData += '</div>';

    $('section').html(htmlData);

    $('footer').hide();
    $('#sumate').hide();

    cargar_usuarios();
  }


function cargar_usuarios()
{
  $('#area_cosas').html("cargando...");
  $('#volver').hide();

  var buscar = document.getElementById('buscar');
  var buscar_letra = document.getElementById('buscar_letra');

  var htmlData = "";

  htmlData += '<div id="table_scroll" style="float:left; width:888px; height:890px; background:rgba(167,169,172,0.5); border:0px; overflow:hidden;">';
    $.each( usuarios, function( i, item ) {
      if(buscar_letra=="" || item.gim_usr_apellido.toLowerCase().search(buscar_letra.value)==0)
      {
        if(buscar.value=="" || item.gim_usr_apellido.toLowerCase().search(buscar.value)>=0 || item.gim_usr_nombre.toLowerCase().search(buscar.value)>=0)
        {
          htmlData += '<div class="item_ficha" id="ficha_'+item.gim_usr_id+'" onclick="select_usuario('+item.gim_usr_id+','+i+')">';
            htmlData += '<div class="item_ficha_icono">';
              htmlData += item.gim_usr_apellido.substr(0,1).toUpperCase();
            htmlData += '</div>';
            htmlData += '<p>';
              htmlData += '<strong>'+item.gim_usr_apellido+'</strong><br>'
              htmlData += '<strong>'+item.gim_usr_nombre+'</strong><br>';
              if(item.gim_usr_dni != null && item.gim_usr_dni != "null")
              {
                htmlData += item.gim_usr_dni;
              }
            htmlData += '</p>';
          htmlData += '</div>';
        }
      }
    });
  htmlData += '</div>';

  htmlData += '<div id="flecha_derecha" style="float:left; position:relative; width:55px; height:890px; background:rgba(167,169,172,0.6);">';
    htmlData += '<i class="fa fa-chevron-right fa-3x" style="color:#58595B; position:absolute; top:50%; left:16px;"></i>';
  htmlData += '</div>';

  $('#area_cosas').html(htmlData);

  cargar_consultas();
}

function select_letra(letra)
{
  $('.btn-letra').removeClass('btn-letra-active');
  $('#btn_letra_'+letra).addClass('btn-letra-active');
  $('#buscar_letra').val(letra);
  cargar_usuarios();
}


function select_usuario(id, pos)
{
  $('#area_cosas').html("cargando...");
  $('#volver').show();

  $.ajax({
     type: 'POST',
      data: jQuery.param({usr_id:id}),
      cache: false,
      dataType: 'json',
      processData: false, // Don't process the files
      //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
     url: base_url+"index.php/webservices/get_ficha",
     timeout: 5000, // sets timeout to 5 seconds
     success: function(data){
        if(data.error == false)
        {
          sesiones = data.sesiones;

          var htmlData = "";

          htmlData += '<div id="area_datos">';
            htmlData += '<div class="font-size:23px;">';
              htmlData += 'Socio/a:<br>';
              htmlData += '<span class="color_texto">'+data.usuario.gim_usr_apellido.toUpperCase()+'<br>'+data.usuario.gim_usr_nombre.toUpperCase()+'</span>';
            htmlData += '</div>';
            htmlData += '<hr>';
            htmlData += '<div style="padding:10px 0px 0px 0px;">';
              htmlData += '<b>DNI:</b><br>'+data.data.gim_usr_dni+'<br>';
            htmlData += '</div>';
            htmlData += '<div style="padding:10px 0px 0px 0px;">';
              htmlData += '<b>Profesor/a:</b><br>'+data.data.usr_apellido+' '+data.data.usr_nombre+'<br>';
            htmlData += '</div>';
            /*
            htmlData += '<hr>';
            htmlData += '<div style="padding:10px 0px 0px 0px;">';
              htmlData += '<b>Asistencia:</b><br>';
            htmlData += '</div>';
            */
            htmlData += '<hr>';
            htmlData += '<div style="padding:0px 20px 0px 0px;">';
              htmlData += '<div style="font-size:14px;">';
                htmlData += '<br>Escaneá el código QR con tu celular, y llevate tu rutina para entrenar';
              htmlData += '</div>';
              htmlData += '<div id="codigo_qr" style="padding:10px 0px 0px 0px; margin-left:-8px;">';
              htmlData += '</div>';
            htmlData += '</div>';

            htmlData += '<div id="ultima_actualizacion">';
              htmlData += 'Última Actualización: <b>'+data.data.gim_usr_ficha_fecha+'</b>';
            htmlData += '</div>';
          htmlData += '</div>';

          htmlData += '<div id="area_sesiones">';
            $.each( data.sesiones, function( i, sesion ) {
              htmlData += '<button class="btn-sesion" id="btn_sesion_'+i+'" onclick="select_sesion('+i+')">SESION '+sesion.gim_usr_ses_num+'</button>';
            });
            htmlData += '<div id="area_sesion" style="text-align:left; width:100%; height:890px; background:#FFF;">';
            htmlData += '</div>';
          htmlData += '</div>';

          $('#area_cosas').html(htmlData);

          var options = {
              render: "div",
              ecLevel: "Q",
              minVersion: parseInt(1, 10),
              fill: "#000000",
              background: "#FFFFFF",
              text: base_url+"index.php/webservices/socio_detalle/"+id,
              size: parseInt(180, 10),
              quiet: parseInt(1, 10)
          };

          $("#codigo_qr").qrcode(options);

          select_sesion(0);
        }
        else
        {
          var htmlData = "";

          htmlData += '<div id="area_datos" style="float:left; font-size:18px; text-align:left; width:380px; height:890px; padding:10px 20px; background:#FFF; margin-right:20px; border-left:12px solid #ED1C24;">';
            htmlData += '<div class="font-size:23px;">';
              htmlData += 'Socio/a:<br>';
              htmlData += '<span style="color:#ED1C24;">'+usuarios[pos].gim_usr_apellido.toUpperCase()+' '+usuarios[pos].gim_usr_nombre.toUpperCase()+'</span>';
            htmlData += '</div>';
            htmlData += '<hr>';
            htmlData += '<div>';
              htmlData += 'La ficha no fue creada.';
            htmlData += '</div>';
          htmlData += '</div>';

          $('#area_cosas').html(htmlData);
        }

        $('#flecha_derecha').hide();
        //setTimeout(function(){ cargar(); }, 3000);
     },
     error: function(x, status, error){
        var htmlData = "An error occurred: " + status + " nError: " + error;
        $('#area_cosas').html(htmlData);
     }
  });
}

function select_sesion(pos)
{
  $('.btn-sesion').removeClass('btn-sesion-active');
  $('#btn_sesion_'+pos).addClass('btn-sesion-active');

  var cant_musculacion = 0;
  var cant_cardio = 0;
  var cant_clases = 0;
  var cant_hiit = 0;

  var htmlData = '';

  htmlData += '<div class="sesion_titulo">';
    htmlData += 'SESION '+sesiones[pos].gim_usr_ses_num;
  htmlData += '</div>';

  $('#area_sesion').html(htmlData);

  htmlData = '';

  htmlData += '<div style="color:#414042; font-size:18px; padding:20px 10px;">';
    htmlData += '<div class="sesion_tipo">MUSCULACIÓN</div>';
    htmlData += '<table class="tabla_musculacion" cellpadding="0" cellspacing="0">';
      htmlData += '<tr style="background:#E6E7E8; font-size:15px;">';
        htmlData += '<th width="45%">Ejercicio</th>';
        htmlData += '<th width="10%">N&deg;</th>';
        htmlData += '<th width="15%">Series</th>';
        htmlData += '<th width="10%">Rep.</th>';
        htmlData += '<th width="20%">Peso KG</th>';
      htmlData += '</tr>';
      $.each( sesiones[pos].actividades, function( i, item ) {
        if(item.gim_usr_ses_tipo == 1)
        {
          cant_musculacion++;
          htmlData += '<tr>';
            htmlData += '<td>';
            if(item.gim_ejer_nombre)
            {
              htmlData +=item.gim_ejer_nombre;
            }
            htmlData +='</td>';
            htmlData += '<td>';
            if(item.gim_usr_ejer_num && item.gim_usr_ejer_num != "0")
            {
              htmlData +=item.gim_usr_ejer_num;
            }
            htmlData +='</td>';
            htmlData += '<td>';
            if(item.gim_usr_ejer_series && item.gim_usr_ejer_series != "0")
            {
              htmlData +=item.gim_usr_ejer_series;
            }
            htmlData +='</td>';
            htmlData += '<td>';
            if(item.gim_usr_ejer_repeticiones && item.gim_usr_ejer_repeticiones != "0")
            {
              htmlData +=item.gim_usr_ejer_repeticiones;
            }
            htmlData +='</td>';
            htmlData += '<td>';
            if(item.gim_usr_ejer_peso && item.gim_usr_ejer_peso != "0")
            {
              htmlData +=item.gim_usr_ejer_peso;
            }
            htmlData +='</td>';
          htmlData += '</tr>';
        }
      });
    htmlData += '</table>';
  htmlData += '</div>';

  if(cant_musculacion > 0)
  {
    $('#area_sesion').append(htmlData);
  }

  htmlData = "";
  htmlData += '<div style="color:#414042; font-size:18px; padding:20px 10px;">';
    htmlData += '<div class="sesion_tipo">CARDIO</div>';
    htmlData += '<table class="tabla_musculacion" cellpadding="0" cellspacing="0">';
      htmlData += '<tr style="background:#E6E7E8; font-size:15px;">';
        htmlData += '<th width="50%">Ejercicio</th>';
        htmlData += '<th width="15%">Tiempo</th>';
        htmlData += '<th width="10%">Vel.</th>';
        htmlData += '<th width="10%">Pend.</th>';
        htmlData += '<th width="15%">Pausa</th>';
      htmlData += '</tr>';
      $.each( sesiones[pos].actividades, function( i, item ) {
        if(item.gim_usr_ses_tipo == 2)
        {
          cant_cardio++;
          htmlData += '<tr>';
            htmlData += '<td>';
            if(item.gim_ejer_nombre)
            {
              htmlData +=item.gim_ejer_nombre;
            }
            htmlData +='</td>';
            htmlData += '<td>';
            if(item.gim_usr_ejer_num && item.gim_usr_ejer_num != "0")
            {
              htmlData +=item.gim_usr_ejer_num;
            }
            htmlData +='</td>';
            htmlData += '<td>';
            if(item.gim_usr_ejer_series && item.gim_usr_ejer_series != "0")
            {
              htmlData +=item.gim_usr_ejer_series;
            }
            htmlData +='</td>';
            htmlData += '<td>';
            if(item.gim_usr_ejer_repeticiones && item.gim_usr_ejer_repeticiones != "0")
            {
              htmlData +=item.gim_usr_ejer_repeticiones;
            }
            htmlData +='</td>';
            htmlData += '<td>';
            if(item.gim_usr_ejer_peso && item.gim_usr_ejer_peso != "0")
            {
              htmlData +=item.gim_usr_ejer_peso;
            }
            htmlData +='</td>';
          htmlData += '</tr>';
        }
      });
    htmlData += '</table>';
  htmlData += '</div>';

  if(cant_cardio > 0)
  {
    $('#area_sesion').append(htmlData);
  }

  htmlData = "";
  htmlData += '<div style="color:#414042; font-size:18px; padding:20px 10px;">';
    htmlData += '<div class="sesion_tipo">HIIT</div>';
    htmlData += '<table class="tabla_musculacion" cellpadding="0" cellspacing="0">';
      htmlData += '<tr style="background:#E6E7E8; font-size:15px;">';
        htmlData += '<th width="55%">Ejercicio</th>';
        htmlData += '<th width="15%">Tiempo</th>';
        htmlData += '<th width="15%">Pausa</th>';
        htmlData += '<th width="15%">Series</th>';
      htmlData += '</tr>';
      $.each( sesiones[pos].actividades, function( i, item ) {
        if(item.gim_usr_ses_tipo == 4)
        {
          cant_hiit++;
          htmlData += '<tr>';
            htmlData += '<td>';
            if(item.gim_ejer_nombre)
            {
              htmlData +=item.gim_ejer_nombre;
            }
            htmlData +='</td>';
            htmlData += '<td>';
            if(item.gim_usr_ejer_num && item.gim_usr_ejer_num != "0")
            {
              htmlData +=item.gim_usr_ejer_num;
            }
            htmlData +='</td>';
            htmlData += '<td>';
            if(item.gim_usr_ejer_series && item.gim_usr_ejer_series != "0")
            {
              htmlData +=item.gim_usr_ejer_series;
            }
            htmlData +='</td>';
            htmlData += '<td>';
            if(item.gim_usr_ejer_repeticiones && item.gim_usr_ejer_repeticiones != "0")
            {
              htmlData +=item.gim_usr_ejer_repeticiones;
            }
            htmlData +='</td>';
          htmlData += '</tr>';
        }
      });
    htmlData += '</table>';
  htmlData += '</div>';

  if(cant_hiit > 0)
  {
    $('#area_sesion').append(htmlData);
  }

  htmlData = "";
  htmlData += '<div style="color:#414042; font-size:18px; padding:20px 10px;">';
    htmlData += '<div class="sesion_tipo">CLASES</div>';
      $.each( sesiones[pos].actividades, function( i, item ) {
        if(item.gim_usr_ses_tipo == 3)
        {
          cant_clases++;
          htmlData += '<div style="border-bottom: 1px solid #CCC; padding:5px 0px;">'+item.gim_act_nombre+'</div>';
        }
      });
  htmlData += '</div>';

  if(cant_clases > 0)
  {
    $('#area_sesion').append(htmlData);
  }
}


function cargar_consultas()
{
  $('#area_consultas').html("cargando...");

  $.ajax({
     type: 'POST',
      data: jQuery.param({gim_id:gim_id}),
      cache: false,
      dataType: 'json',
      processData: false, // Don't process the files
      //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
     url: base_url+"index.php/webservices/get_consultas_rutinas",
     timeout: 5000, // sets timeout to 5 seconds
     success: function(data){
        if(data.error == false)
        {
          var cantidad = 0;
          $.each( data.data, function( i, item ) {
              cantidad++;
          });

          var htmlData = "";
          htmlData += "<div id='slider_consultas'>";
            htmlData += '<ul style="width:'+(cantidad*195)+'px">';

            $.each( data.data, function( i, item ) {
                htmlData += '<li onclick="select_usuario_consultas('+item.gim_usr_id+')" class="color_fondo">';
                    htmlData += '<span>';
                      htmlData += item.gim_usr_apellido.substr(0,1).toUpperCase();
                    htmlData += '</span><br>';
                      htmlData += item.gim_usr_apellido+'<br>';
                      htmlData += item.gim_usr_nombre;
                htmlData += '</li>';
            });

            htmlData += '</ul>';
          htmlData += '</div>';

          $('#area_consultas').html(htmlData);

          if($('#slider_consultas').hasScrollBar())
          {
            $('#area_flecha_derecha_consultas').show();
            $('#area_flecha_izquierda_consultas').show();
          }
          else
          {
            $('#area_flecha_derecha_consultas').hide();
            $('#area_flecha_izquierda_consultas').hide();
          }
        }
        else
        {
          var htmlData = "";

          $('#area_consultas').html(htmlData);
        }
     },
     error: function(x, status, error){
        var htmlData = "An error occurred: " + status + " nError: " + error;
        $('#area_consultas').html(htmlData);
     }
  });
}

function select_usuario_consultas(id)
{
  var pos = 0;
  $.each( usuarios, function( i, item ) {
    if(id == item.gim_usr_id)
    {
      pos = i;
    }
  });
  select_usuario(id, pos);
}

function derecha_consultas()
  {
    $('#slider_consultas').animate({
      scrollLeft: "+=390px"
    }, "slow");
  }
  function izquierda_consultas()
  {
    $('#slider_consultas').animate({
      scrollLeft: "-=390px"
    }, "slow");
  }