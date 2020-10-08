//var base_url = "http://localhost:8888/Mad/";
var encuesta_actual = 0;

  function estructura_encuestas()
  {
    var htmlData = '<h1>ENCUESTAS</h1>';

    htmlData += '<div id="area_pregunta" class="color_texto" style="font-size:40px;"></div>';

    htmlData += '<div id="area_mensaje"></div>';
    htmlData += '<div id="area_calendario"></div>';

    $('section').html(htmlData);

    $('footer').show();
    $('#sumate').show();
    
    cargar_encuesta(0);
  }


function cargar_encuesta(cat_id)
{
  $('#area_calendario').html("cargando...");

  var htmlData = "";

  if(encuestas != null && encuestas != false)
  {
    $('#area_pregunta').html(encuestas[cat_id].gim_enc_pregunta);

    htmlData += '<div id="table_scroll" style="height:875px; background:none;">';

      $.each( encuestas[cat_id].respuestas, function( i, item ) {
        htmlData += '<div class="item_encuesta" id="resp_'+item.gim_enc_resp_id+'">';
          htmlData += '<div style="width:660px; float:left; background:#FFF;">';
            htmlData += '<div style="font-size:40px; font-weight:bold; color:#414042; padding:20px 10px 20px 40px;">'+nl2br(item.gim_enc_resp_texto)+'</div>';
          htmlData += '</div>';
          htmlData += '<div class="enc_abrir" style="width:65px; float:left; padding:10px; text-align:center; display:none;">';
            htmlData += '<img src="'+base_url+'assets/img/gimnasios/ok.png" width="100%">';
          htmlData += '</div>';
          htmlData += '<div class="enc_cerrar" style="width:65px; float:left; padding:10px; text-align:center;" onclick="select_respuesta('+item.gim_enc_resp_id+')">';
            htmlData += '<img src="'+base_url+'assets/img/gimnasios/ok2.png"  width="100%">';
          htmlData += '</div>';
          htmlData += '<div style="clear:both;"></div>';
        htmlData += '</div>';
      });

      htmlData += '<button id="enc_cargar" class="color_fondo" style="width:300px; border-radius:8px; border:none; margin:auto; padding:15px 10px; font-size:32px; color:#FFF;" onclick="votar()">';
        htmlData += 'CARGAR MI VOTO';
      htmlData += '</button>';

      htmlData += '<input id="voto" type="hidden" name="voto" value="">';

    htmlData += '</div>';
  }
  else
  {
    htmlData += 'No hay encuestas por el momento.';
  }


  $('#area_calendario').html(htmlData);
}

function select_respuesta(id)
{
  $('.enc_abrir').hide();
  $('.enc_cerrar').show();
  $('#resp_'+id+' .enc_cerrar').hide();
  $('#resp_'+id+' .enc_abrir').show();
  $('#voto').val(id);
}

function votar()
{
  $('#enc_cargar').html("Cargando...");
  $.ajax({
     type: 'POST',
      data: jQuery.param({usr_id:0, resp_id:$('#voto').val()}),
      cache: false,
      dataType: 'json',
      processData: false, // Don't process the files
      //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
      url: base_url+'index.php/webservices/votar',
     //url: "http://www.openpark.com.ar/webservices/index.php",
     //url: "horarios.js",
     timeout: 5000, // sets timeout to 5 seconds
     success: function(data){
        if(data.error == false)
        {
          encuesta_actual++;
          var htmlData = "";
          htmlData += '<div id="table_scroll" style="height:875px; background:none">';
            htmlData += '<button id="enc_cargar" class="color_fondo" style="width:300px; border-radius:8px; border:none; margin:auto; padding:15px 10px; font-size:32px; color:#FFF; margin-top:50px;" onclick="encuesta_siguiente()">';
              htmlData += 'Responder otra encuesta';
            htmlData += '</button>';
          htmlData += '</div>';
          $('#area_calendario').html(htmlData);
          $('#area_pregunta').html(data.data);
        }
        else
        {
          alert(data.data);
          cargar_encuesta(encuesta_actual);
        }
     },
     error: function(x, status, error){
        var htmlData = "An error occurred: " + status + " nError: " + error;
        $('#area_calendario').html(htmlData);
     }
  });
}

function encuesta_siguiente()
{
  if(encuesta_actual == encuestas.length)
  {
    encuesta_actual = 0;
  }

  cargar_encuesta(encuesta_actual);
}