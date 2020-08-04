//var base_url = "http://localhost:8888/Mad/";

  function estructura_faq()
  {
    var htmlData = '<h1 style="width:600px;">PREGUNTAS FRECUENTES</h1>';

    //htmlData += '<div id="area_categorias" style="font-size:32px;">CONSULTÁ AQUÍ TUS DUDAS</div>';

    htmlData += '<div id="area_flecha_izquierda" onclick="izquierda();"><i class="fa fa-chevron-left fa-5x" style="color:#000;"></i></div>';
    htmlData += '<div id="area_actividades"></div>';
    htmlData += '<div id="area_flecha_derecha" onclick="derecha();"><i class="fa fa-chevron-right fa-5x" style="color:#000;"></i></div>';

    htmlData += '<div id="area_calendario"></div>';

    htmlData += '<div id="area_popup" style="display:none;">';
      htmlData += '<img src="" alt="clase" width="200px">';
      htmlData += '<div class="titulo"></div>';
      htmlData += '<div class="subtitulo"></div>';
      htmlData += '<hr>';
      htmlData += '<div class="salon"></div>';
      htmlData += '<p></p>';
      htmlData += '<i class="fas fa-times-circle fa-3x" onclick="cerrar_popup();"></i>';
    htmlData += '</div>';

    htmlData += '<div id="area_clase" style="display:none;">';
      htmlData += '<h4></h4>';
      htmlData += '<div class="gris">';
        htmlData += '<img src="" alt="clase" width="400px">';
        htmlData += '<div class="derecha">';
          htmlData += '<div class="titulo"></div>';
          htmlData += '<p></p>';
          htmlData += '<div class="salon"></div>';
        htmlData += '</div>';
        htmlData += '<div style="clear:both;"></div>';
      htmlData += '</div>';
    htmlData += '</div>';

    $('section').html(htmlData);

    $('footer').show();
    $('#sumate').show();

    cargar_categorias_faq(0);
  }
/*
function cargar_categorias_beneficios()
{
  $('#area_categorias').html("cargando...");

  var htmlData = "";
  var clase = "active";
  htmlData += '<button class="btn '+clase+'" id="btn_cat_0" onclick="cargar_beneficios(0)">Todos</button>';

  $.each( categorias_beneficios, function( i, categoria ) {
    clase = "";
    if(categoria.gim_ben_cat_id==0)
    {
      clase = "active";
    }
    htmlData += '<button class="btn '+clase+'" id="btn_cat_'+categoria.gim_ben_cat_id+'" onclick="cargar_beneficios('+categoria.gim_ben_cat_id+')">'+categoria.gim_ben_cat_nombre+'</button>';
  });

  $('#area_categorias').html(htmlData);
}
*/
function cargar_categorias_faq(id)
{
  $('#area_actividades').html("cargando...");

  $('#btn_cat_0').removeClass('active');
  $.each( categorias, function( i, categoria ) {
    $('#btn_cat_'+categoria.gim_act_cat_id).removeClass('active');
  });
  $('#btn_cat_'+id).addClass('active');

  var cantidad = 0;
  $.each( categorias_faqs, function( i, actividad ) {
    if(id==0 || id==actividad.gim_ben_cat_id)
    {
      cantidad++;
    }
  });

  var htmlData = "";
  htmlData += "<div id='slider_actividades'>";
  htmlData += '<ul style="width:'+(cantidad*195)+'px">';

  $.each( categorias_faqs, function( i, categoria ) {
    if(id==0 || id==categoria.gim_ben_cat_id)
    {
      htmlData += '<li onclick="cargar_faq('+categoria.gim_faq_cat_id+')">'+categoria.gim_faq_cat_nombre+'</li>';
    }
  });

  htmlData += '</ul>';
  htmlData += '</div>';

  $('#area_actividades').html(htmlData);

  if($('#slider_actividades').hasScrollBar())
  {
    $('#area_flecha_derecha').show();
    $('#area_flecha_izquierda').show();
  }
  else
  {
    $('#area_flecha_derecha').hide();
    $('#area_flecha_izquierda').hide();
  }

  cargar_faq(0);
}


function cargar_faq(cat_id)
{
  $('#area_calendario').html("cargando...");

  var htmlData = "";

  htmlData += '<div id="area_flecha_arriba" onclick="arriba();"><i class="fa fa-chevron-up fa-4x" style="color:#000;"></i></div>';

  htmlData += '<div id="table_scroll" style="height:650px; background:none;">';

    $.each( categorias_faqs, function( i, categoria ) {
      if(cat_id==0 || cat_id==categoria.gim_faq_cat_id)
      {
        $.each( categoria.faqs, function( j, item ) {
            htmlData += '<div class="item_faq" id="faq_'+item.gim_faq_id+'">';
              htmlData += '<div style="width:890px; float:left; background:#FFF; box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">';
                htmlData += '<div class="faq_pregunta" style="font-size:18px; font-weight:bold; color:#414042; padding:20px 10px 10px 40px;">'+nl2br(item.gim_faq_pregunta)+'</div>';
                htmlData += '<hr style="width:30px; margin-left:40px;">';
                htmlData += '<div class="faq_respuesta color_texto" style="font-size:18px; padding:10px 10px 20px 40px; display:none;">'+nl2br(item.gim_faq_respuesta)+'</div>';
                htmlData += '<div style="clear:both;"></div>';
              htmlData += '</div>';
              htmlData += '<div class="faq_abrir color_fondo" style="width:25px; height:25px; float:left; color:#FFF; padding:10px; text-align:center;" onclick="abrir_faq('+item.gim_faq_id+')">';
                htmlData += '<i class="fas fa-chevron-down fa-2x"></i>';
              htmlData += '</div>';
              htmlData += '<div class="faq_cerrar color_fondo" style="width:25px; height:25px; float:left; color:#FFF; padding:10px; text-align:center; display:none;" onclick="cerrar_faq('+item.gim_faq_id+')">';
                htmlData += '<i class="fas fa-chevron-up fa-2x"></i>';
              htmlData += '</div>';
              htmlData += '<div style="clear:both;"></div>';
            htmlData += '</div>';
        });
      }
    });

  htmlData += '</div>';

  htmlData += '<div id="area_flecha_abajo" onclick="abajo();"><i class="fa fa-chevron-down fa-4x" style="color:#000;"></i></div>';


  $('#area_calendario').html(htmlData);
}

function abrir_faq(id)
{
  $('#faq_'+id+' .faq_respuesta').show();
  $('#faq_'+id+' .faq_abrir').hide();
  $('#faq_'+id+' .faq_cerrar').show();
}

function cerrar_faq(id)
{
  $('#faq_'+id+' .faq_respuesta').hide();
  $('#faq_'+id+' .faq_abrir').show();
  $('#faq_'+id+' .faq_cerrar').hide();
}