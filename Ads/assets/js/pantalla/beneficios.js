//var base_url = "http://localhost:8888/Mad/";

  function estructura_beneficios()
  {
    var htmlData = '<h1>BENEFICIOS</h1>';

    //htmlData += '<div id="area_categorias" style="font-size:32px;">CONSULTA LOS BENEFICIOS PARA LOS SOCIOS</div>';

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

    cargar_categorias_beneficios(0);
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
function cargar_categorias_beneficios(id)
{
  $('#area_actividades').html("cargando...");

  $('#btn_cat_0').removeClass('active');
  $.each( categorias, function( i, categoria ) {
    $('#btn_cat_'+categoria.gim_act_cat_id).removeClass('active');
  });
  $('#btn_cat_'+id).addClass('active');

  var cantidad = 0;
  $.each( categorias_beneficios, function( i, actividad ) {
    if(id==0 || id==actividad.gim_ben_cat_id)
    {
      cantidad++;
    }
  });

  var htmlData = "";
  htmlData += "<div id='slider_actividades'>";
  htmlData += '<ul style="width:'+(cantidad*195)+'px">';

  $.each( categorias_beneficios, function( i, categoria ) {
    if(id==0 || id==categoria.gim_ben_cat_id)
    {
      htmlData += '<li onclick="cargar_beneficios('+categoria.gim_ben_cat_id+')">'+categoria.gim_ben_cat_nombre+'</li>';
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

  cargar_beneficios(0);
}


function cargar_beneficios(cat_id)
{
  $('#area_calendario').html("cargando...");

  var htmlData = "";

  htmlData += '<div id="area_flecha_arriba" onclick="arriba();"><i class="fa fa-chevron-up fa-4x" style="color:#000;"></i></div>';

  htmlData += '<div id="table_scroll" style="height:650px; background:none;">';

    $.each( categorias_beneficios, function( i, categoria ) {
      if(cat_id==0 || cat_id==categoria.gim_ben_cat_id)
      {
        $.each( categoria.beneficios, function( j, item ) {
            htmlData += '<div style="width:950px; height:140px; text-align:left; margin-bottom:20px; overflow:hidden; box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">';
              htmlData += '<div style="width:210px; height:110px; float:left; padding:10px; background:#FFF; overflow:hidden; border-bottom:10px solid #FFF;"><img src="'+base_url+'assets/img/gimnasios/beneficios/'+item.gim_ben_imagen+'" width="100%"></div>';
              htmlData += '<div style="width:500px; height:120px; float:left; padding:10px; background:#FFF;">';
                htmlData += '<div class="color_texto" style="font-size:20px;">'+item.gim_ben_titulo+'</div>';
                htmlData += '<div class="color_texto" style="font-size:17px;">'+item.gim_ben_subtitulo+'</div>';
                htmlData += '<hr style="width:30px; margin-left:0px;">';
                htmlData += '<div style="font-size:13px; color:#414042;">'+nl2br(item.gim_ben_texto)+'</div>';
              htmlData += '</div>';
              htmlData += '<div style="width:170px; height:120px; float:left; padding:10px; background:#E6E7E8; font-size:13px; color:#6D6E71;">'+nl2br(item.gim_ben_condiciones)+'</div>';
              htmlData += '<div class="color_fondo" style="width:10px; height:120px; float:left; padding:10px 0px;">&nbsp;</div>';
            htmlData += '</div>';
        });
      }
    });

  htmlData += '</div>';

  htmlData += '<div id="area_flecha_abajo" onclick="abajo();"><i class="fa fa-chevron-down fa-4x" style="color:#000;"></i></div>';


  $('#area_calendario').html(htmlData);
}