<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<body>

<!-- Header -->
<?php
$this->load->view('templates/analytics');
$this->load->view('muestras/templates/header');
?>
<!-- /Header -->

<?php
$this->load->view('muestras/templates/sidebar_left');
?>

<!-- Content -->
<main class="content">

	<!-- Features -->
	<section class="container-fluid">
		
		<div class="row">

			<div class="col-md-12">

				<div class="panel panel-danger" id="header_resultados">
				  <div class="panel-heading">
            <a href="<?=site_url()?>resultados/filtros" class="pull-right flip" id="filtro" style="margin-top:-1px;"><i class='fa fa-filter'></i></a>
            <span class="pull-right flip" style="margin:0px 10px 0px 10px; height:25px; border-right:1px solid #FFF; text-decoration:none;">&nbsp;</span>
            <?php
            if($this->session->userdata('filtro_ofertas') != "no")
            {
              $select2 = "display:none;";
              $select1 = "";
            }
            else
            {
              $select2 = "";
              $select1 = "display:none;";
            }
            //echo '<span id="filtro_ofertas_on" class="pull-right flip" style="margin:-5px 0px 0px 8px; '.$select1.'"><img src="'.base_url('images/oferta2.png').'" height="26px"></span>';
            echo '<a id="filtro_ofertas_on" onclick="set_ofertas()" class="pull-right flip active" style="margin:0px 0px 0px 8px; '.$select1.'"><span class="icon-oferta_circle"></span></a>';
            echo '<a id="filtro_ofertas_off" onclick="set_ofertas()" class="pull-right flip" style="margin:0px 0px 0px 8px; '.$select2.'"><span class="icon-oferta_circle"></span></a>';

            if($this->session->userdata('filtro_demandas') != "no")
            {
              $select2 = "display:none;";
              $select1 = "";
            }
            else
            {
              $select2 = "";
              $select1 = "display:none;";
            }
            //echo '<span id="filtro_demandas_on" class="pull-right flip" style="margin:-5px 0px 0px 8px; '.$select1.'"><img src="'.base_url('images/demanda2.png').'" height="26px"></span>';
            echo '<a id="filtro_demandas_on" onclick="set_demandas()" class="pull-right flip active" style="margin:0px 0px 0px 8px; '.$select1.'"><span class="icon-demanda_circle"></span></a>';
            echo '<a id="filtro_demandas_off" onclick="set_demandas()" class="pull-right flip" style="margin:0px 0px 0px 8px; '.$select2.'"><span class="icon-demanda_circle"></span></a>';
            ?>
				    <h3 class="panel-title"><?=mostrar_palabra(86, $palabras)?></h3>
				  </div>
				</div>
        
        <div id="results">
        </div>

        <div id="loading" style="display:none; width:100%; text-align:center; clear:both;">
          <img src="<?=base_url('assets/images/loading.png')?>" alt="Loading…" width="50px" style="margin:auto;"/>
        </div>

			</div>
			<?php
			//$this->load->view('templates/sidebar_right');
			?>
		</div>
	</section>
	<!-- /Features -->

</main>



<!-- Modal -->
<div class="modal fade" id="modal_calificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?=mostrar_palabra(309, $palabras)?></h4>
      </div>

      <form id="form_calificar" method="POST" action="#">
        <div class="modal-body">
          <div id="mensaje_calificar"></div>
          <input type="hidden" value="" name="usr_id" id="calificar_usr_id">
          <input type="hidden" value="" name="prod_id" id="calificar_prod_id">
          <input id='input-rating' name='input-rating' type='number' min='0' max='5' step='0.5' data-size='lg' data-default-caption='{rating} hearts' data-star-captions='{012345}'>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(29, $palabras)?></button>
          <button type="submit" class="btn btn-danger" id="btn_calificar"><?=mostrar_palabra(17, $palabras)?></button>
        </div>
      </form>

    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_referenciar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?=mostrar_palabra(313, $palabras)?></h4>
      </div>

      <form id="form_referenciar" method="POST" action="#">
        <div class="modal-body">
          <div id="mensaje_referenciar"></div>
          <input type="text" class="form-control" value="" name="mail" id="referenciar_mail">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(29, $palabras)?></button>
          <button type="submit" class="btn btn-danger" id="btn_referenciar"><?=mostrar_palabra(17, $palabras)?></button>
        </div>
      </form>

    </div>
  </div>
</div>


<?php
//$this->load->view('templates/menu_footer');
$this->load->view('templates/footer');
?>

<script type="text/javascript">
var offset = 0;
var limit = 30;
var fin = false;
var buscando = false;
var ads_mostradas = 0;
var ads_inter_cant = 0;
var ads_inter = 4;
var ads = null;


function ver_producto(id)
{
  location.href=SITE_URL+"resultados/view/"+id;
}

function CopyLink(id) {
  copyTextToClipboard(SITE_URL+"resultados/view/"+id);
}

function set_demandas()
{
  $('#results').html("");
  $('#loading').show();
  $('#filtro_demandas_on').show();
  $('#filtro_demandas_off').hide();
  $('#filtro_ofertas_on').hide();
  $('#filtro_ofertas_off').show();

    $.ajax({
      url: SITE_URL+'resultados/set_demandas_ajax',
      dataType: 'json',
      success: function(data) {
        offset = 0;
        limit = 10;
        fin = false;
        buscando = false;
        buscar();
      }
    });
}

function set_ofertas()
{
  $('#results').html("");
  $('#loading').show();
  $('#filtro_demandas_on').hide();
  $('#filtro_demandas_off').show();
  $('#filtro_ofertas_on').show();
  $('#filtro_ofertas_off').hide();

    $.ajax({
      url: SITE_URL+'resultados/set_ofertas_ajax',
      dataType: 'json',
      success: function(data) {
        offset = 0;
        limit = 10;
        fin = false;
        buscando = false;
        buscar();
      }
    });
}

$(document).ready(function() {
  var win = $(window);

  // Each time the user scrolls
  win.scroll(function() {
    if(!buscando)
    {
      if(($(document).height() - win.height() - 10) <= win.scrollTop() && !fin)
      {
        buscando = true;
        buscar();
      }
    }
  });

  buscar();
});

function buscar()
{
  $('#loading').show();

  if(buscar_ultimos_ajax)
  {
    buscar_ultimos_ajax.abort();
  }

    $.ajax({
      url: SITE_URL+'muestras/buscar_resultados_ajax/'+offset+'/'+limit,
      dataType: 'json',
      timeout: 5000,
      success: function(data) {
        if(data.cant == -1)
        {
          fin = true;
          var htmlData = "";
          htmlData += "<?=mostrar_palabra(56, $palabras)?><br><br>";
          //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_DEMANDA?>'><img src='"+BASE_URL+"images/demanda.png' class='img-responsive'> <?=mostrar_palabra(24, $palabras)?> <i class='fa fa-plus fa-3x'></i></a>";
          //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_OFERTA?>'><img src='"+BASE_URL+"images/oferta.png' class='img-responsive'> <?=mostrar_palabra(23, $palabras)?> <i class='fa fa-plus fa-3x'></i></a>";
          htmlData += "<div style='clear:both; height:20px;'></div>";
          $('#results').append(htmlData);
          $('#area_primera_cargar').show();
          $('#modal_tutorial').modal('show');
        }
        else if(data.cant == -2)
        {
          fin = true;
          var htmlData = "";
          htmlData += "<?=mostrar_palabra(274, $palabras)?><br><br>";
          //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_DEMANDA?>'><img src='"+BASE_URL+"images/demanda.png' class='img-responsive'> <?=mostrar_palabra(24, $palabras)?> <i class='fa fa-plus fa-3x'></i></a>";
          //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_OFERTA?>'><img src='"+BASE_URL+"images/oferta.png' class='img-responsive'> <?=mostrar_palabra(23, $palabras)?> <i class='fa fa-plus fa-3x'></i></a>";
          htmlData += "<div style='clear:both; height:20px;'></div>";
          $('#header_resultados').show();
          $('#results').show();
          $('#results').append(htmlData);
        }
        else if(data.cant == 0)
        {
          fin = true;
          if(offset == 0)
          {
            var htmlData = "";
            htmlData += "<?=mostrar_palabra(56, $palabras)?><br><?=mostrar_palabra(243, $palabras)?><br>";
            //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_DEMANDA?>'><img src='"+BASE_URL+"images/demanda.png' class='img-responsive'> <?=mostrar_palabra(24, $palabras)?> <i class='fa fa-plus fa-3x'></i></a>";
            //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_OFERTA?>'><img src='"+BASE_URL+"images/oferta.png' class='img-responsive'> <?=mostrar_palabra(23, $palabras)?> <i class='fa fa-plus fa-3x'></i></a>";
            htmlData += "<div style='clear:both; height:20px;'></div>";
            //$('#results').append(htmlData);
            $('#area_botones_cargar').show();
            $('#results').show();
            $( "#area-mayor-actividad" ).appendTo( "#results" );
          }
        }
        else
        {
          if(data.ads)
          {
            ads = data.ads;
          }

          $('#header_resultados').show();
          $('#results').show();
          if(data.cant < limit)
          {
            fin = true;
          }
          offset += data.cant;

          var num_item = 0;

          $.each(data.result, function(i, item) {

            var htmlData = "";

            /***** ADS *****/
            if(ads && ads.length > ads_mostradas && ads_inter_cant == ads_inter)
            {
              ads_inter_cant=0;

              htmlData += '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 panel resultado2" onclick="post_click('+ads[ads_mostradas].ads_id+')" style="cursor:pointer;">';
                htmlData += '<div class="panel-body" style="background:#F5F5F5; padding:0px;">';
                  htmlData += '<div class="media" id="prod_">';
                    if(ads[ads_mostradas].ads_imagen)
                    {
                      htmlData += '<div style="width:100%; height:160px; overflow:hidden;">';
                        htmlData += "<img src='"+BASE_URL+"images/ads/"+ads[ads_mostradas].ads_imagen+"' width='100%'>";
                      htmlData += '</div>';
                    }
                    htmlData += '<div class="media-body" style="padding:15px;">';
                      htmlData += '<b class="texto-bordo">'+ads[ads_mostradas].ads_titulo+'</b>';
                      htmlData += '<div class="cortar-texto-ads" style="margin-top:5px;">'+ads[ads_mostradas].ads_texto_corto+'</div>';
                    htmlData += '</div>';
                  htmlData += '</div>';
                htmlData += '</div>';
                htmlData += '<div class="panel-footer" style="text-align:center; background:#999999; color:#FFF;">';
                  htmlData += "<span style='display:block; padding: 3px 0;'>ADVERTISMENT</span>";
                htmlData += '</div>';
              htmlData += '</div>';

              post_impresion(ads[ads_mostradas].ads_id);

              ads_mostradas++;
              num_item++;
            }

            ads_inter_cant++;
            /***************/
            
            var color_visto = "visto";
            if(item.mis_visitas == 0)
            {
              color_visto = "no-visto";
            }

            var premium = "";
            var media_right = '<i class="fa fa-ellipsis-v fa-lg"></i>';
            if(item.tu_id == <?=TU_PREMIUM?>)
            {
              premium = "premium";
              media_right = '<img src="<?=base_url('assets/images/esquina-premium.png')?>">';
              if("<?=$this->session->userdata('idi_code')?>" == "ar")
              {
                media_right = '<img src="<?=base_url('assets/images/esquina-premium-rtl.png')?>">';
              }
            }
            /*
            if(i%2==0)
            {
              if(i>0)
              {
                htmlData += '</div>';
              }
              htmlData += '<div class="row" style="padding:0px 15px;">';
            }
            */
            htmlData += '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 panel resultado2 '+premium+'">';
              htmlData += '<div class="panel-body '+color_visto+'">';

                htmlData += '<div class="menu-tarjeta">';
                  htmlData += '<div data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+media_right+'</div>';
                  htmlData += '<ul class="dropdown-menu dropdown-menu-right pull-right flip">';
                    htmlData += "<li><a href='"+SITE_URL+"resultados/view/"+item.prod_id+"'><?=mostrar_palabra(151, $palabras)?></a></li>";
                    htmlData += "<li><a href='javascript: calificar("+item.usr_id+","+item.prod_id+");'><?=mostrar_palabra(309, $palabras)?></a></li>";
                    if(item.pm_mail)
                    {
                      htmlData += "<li><a href='javascript: referenciar(\""+item.pm_mail.toLowerCase()+"\");'><?=mostrar_palabra(313, $palabras)?></a></li>";
                    }
                    //htmlData += "<li role='separator' class='divider'></li>";
                    htmlData += "<li><a onclick='CopyLink("+item.prod_id+")'><?=mostrar_palabra(317, $palabras)?></a></li>";
                  htmlData += '</ul>';
                htmlData += '</div>';

              htmlData += '<div class="media" id="prod_'+item.prod_id+'">';

                htmlData += '<div class="">';

                  var background = "";
                  var clase = "sin_imagen";
                  if(item.prod_imagen)
                  {
                    background = "background:url("+BASE_URL+"images/productos/"+item.prod_imagen+"); background-size:cover;";
                    clase = "con_imagen";
                  }

                  htmlData += "<div class='media-object img-rounded "+clase+"' style='"+background+"'>";

                  if(item.usr_imagen)
                  {
                    htmlData += "<a href='"+SITE_URL+"user/view/"+item.usr_id+"'><img class='img-circle' src='"+BASE_URL+"images/usuarios/"+item.usr_imagen+"'></a>";
                  }
                  else
                  {
                    htmlData += "<img class='img-circle' src='"+BASE_URL+"images/usuarios/perfil.jpg'>";
                  }

                  if(item.tp_id == <?=TP_OFERTA?>)
                  {
                      htmlData += "<img class='media-tipo' src='"+BASE_URL+"images/oferta.png'>";
                  }
                  else
                  {
                      htmlData += "<img class='media-tipo' src='"+BASE_URL+"images/demanda.png'>";
                  }

                  htmlData += "</div>";

                htmlData += '</div>';

                htmlData += '<div class="media-body" onclick="ver_producto('+item.prod_id+')" style="cursor:pointer;">';
                  /*if(item.pm_mail)
                  {
                    htmlData += '<b class="cortar-texto-mail">'+item.pm_mail.toLowerCase()+'</b>';
                  }*/
                  if(item.tp_id == <?=TP_OFERTA?>)
                  {
                    htmlData += '<b class="cortar-texto-mail"><?=mostrar_palabra(19, $palabras)?></b>';
                  }
                  else
                  {
                    htmlData += '<b class="cortar-texto-mail"><?=mostrar_palabra(20, $palabras)?></b>';
                  }
                  htmlData += '<b class="fecha">'+item.usr_ult_acceso+'</b>';
                  htmlData += '<div class="cortar-texto-productos2" style="margin-top:5px;">'+item.prod_descripcion+'</div>';
                  htmlData += '<div class="cortar-texto-productos2" style="margin:5px 0px;">'+item.ara_desc+'</div>';
                  htmlData += '<small>';
                    if(item.sec_id == 22)
                    {
                      htmlData += '<b class="cortar-texto-mail texto-bordo">'+item.ara_code+' - <?=mostrar_palabra(21, $palabras)?></b>';
                    }
                    else
                    {
                      htmlData += '<b class="cortar-texto-mail texto-bordo">'+item.ara_code+' - <?=mostrar_palabra(22, $palabras)?></b>';
                    }
                    htmlData += "<span class='cortar-texto-mail'><img src='"+BASE_URL+"images/banderas/"+item.ctry_code+".png'> "+item.ctry_nombre;
                    htmlData += " (";
                      if(item.city_nombre == item.toponymName)
                      {
                        htmlData += item.city_nombre;
                      }
                      else
                      {
                        htmlData += item.city_nombre+" / "+item.toponymName;
                      }
                    htmlData += ")</span>";
                  htmlData += '</small>';
                htmlData += '</div>';

              htmlData += '</div>';
              htmlData += '</div>';
              htmlData += '<div class="panel-footer">';
                htmlData += '<div class="col-xs-6 text-left flip">';
                    var color_aux = "";
                    if(item.visitas > 0)
                    {
                      color_aux = "color:#980521;";
                    }
                    htmlData += "<span style='"+color_aux+"'>"+item.visitas+"</span> <i class='fa fa-eye fa-lg' style='"+color_aux+"'></i>";
                    htmlData += "<span style='color:#B2B2B2'> | </span>";
                    color_aux = "";
                    if(item.referencias > 0)
                    {
                      color_aux = "color:#980521;";
                    }
                    htmlData += "<span style='"+color_aux+"'>"+item.referencias+"</span> <i class='icon-relacion' style='"+color_aux+"'></i>";
                htmlData += '</div>';
                htmlData += '<div class="col-xs-6 text-right flip" id="area_puntaje_'+item.prod_id+'">';
                  if(item.puntaje == null)
                  {
                    item.puntaje = 0;
                  }

                  htmlData += "<div class='derecha' onclick='calificar("+item.usr_id+","+item.prod_id+");'>";
                    color_aux = "";
                    if(item.puntaje > 0)
                    {
                      color_aux = "color:#980521;";
                    }

                    if(item.uf_puntaje > 0)
                    {
                      htmlData += "<span style='"+color_aux+"'>"+item.puntaje+"</span> <i class='far fa-star fa-lg' style='"+color_aux+"'></i>";
                      htmlData += "<span style='color:#B2B2B2'> / </span>";
                      htmlData += "<span style='"+color_aux+"'>"+item.cant_seguidores+"</span> <i class='far fa-user fa-lg' style='"+color_aux+"'></i>";
                    }
                    else
                    {
                      htmlData += "<span style='"+color_aux+"'>"+item.puntaje+"</span> <i class='fas fa-star fa-lg' style='"+color_aux+"'></i>";
                      htmlData += "<span style='color:#B2B2B2'> / </span>";
                      htmlData += "<span style='"+color_aux+"'>"+item.cant_seguidores+"</span> <i class='fa fa-user fa-lg' style='"+color_aux+"'></i>";
                    }
                  htmlData += '</div>';
                htmlData += '</div>';
                htmlData += '<div style="clear:both"></div>';
              htmlData += '</div>';
            htmlData += '</div>';
            $("#results").append(htmlData);
          });
          //Cierra el ultimo row
          //htmlData += '</div>';
        }
        $('#loading').hide();
        buscando = false;
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        //alert(htmlData);
      }
    });

}


$('#input-rating').rating({'showCaption':false, showClear:false, 'stars':'5', 'min':'0', 'max':'5', 'step':'0.5', 'size':'lg', 'starCaptions': {0:'0', 1:'1', 2:'2', 3:'3', 4:'4', 5:'5'}});

function calificar(id, prod_id)
{
  $('#calificar_usr_id').val(id);
  $('#calificar_prod_id').val(prod_id);
  $('#input-rating').rating('update', 0);
  $('#modal_calificar').modal('show');
}

$( "#form_calificar" ).submit(function( event ) {
  event.preventDefault();
  $("#mensaje_calificar").html("");
  $('#btn_calificar').button('loading');
  $.ajax({
     type: 'get',
     dataType: "json",
     data: $(event.target).serialize(),
     cache: false,
     url: SITE_URL+"user/marcar_usuario_favorito_ajax/"+$('#calificar_usr_id').val()+"/"+$('#input-rating').val(),
     success: function(data){
        if(data.error == false)
        {
          if(data.puntaje == null)
          {
            data.puntaje = 0;
          }

          var color_aux = "";
          if(data.puntaje > 0)
          {
            color_aux = "color:#980521;";
          }

          htmlData = "";
          htmlData += "<div class='derecha' onclick='calificar("+$('#calificar_usr_id').val()+","+$('#calificar_prod_id').val()+");'>";
            if(data.uf_puntaje > 0)
            {
              htmlData += "<span style='"+color_aux+"'>"+data.puntaje+"</span> <i class='far fa-star fa-lg' style='"+color_aux+"'></i> ";
              htmlData += "/ ";
              htmlData += "<span style='"+color_aux+"'>"+data.cant_seguidores+"</span> <i class='far fa-user fa-lg' style='"+color_aux+"'></i>";
            }
            else
            {
              htmlData += "<span style='"+color_aux+"'>"+data.puntaje+"</span> <i class='fas fa-star fa-lg' style='"+color_aux+"'></i> ";
              htmlData += "/ ";
              htmlData += "<span style='"+color_aux+"'>"+data.cant_seguidores+"</span> <i class='fas fa-user fa-lg' style='"+color_aux+"'></i>";
            }
          htmlData += "</div>";
          $("#area_puntaje_"+$('#calificar_prod_id').val()).html(htmlData);
          
          $("#modal_calificar").modal('hide');
        }
        else
        {
          var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
          htmlData += data.data;
          htmlData += '</div>';
          $("#mensaje_calificar").html(htmlData);
        }
        $('#btn_calificar').button('reset');
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        $("#mensaje_calificar").html(htmlData);
        $('#btn_calificar').button('reset');
      }
  });
});


function referenciar(mail)
{
  $('#referenciar_mail').val(mail);
  $('#modal_referenciar').modal('show');
}

$( "#form_referenciar" ).submit(function( event ) {
  event.preventDefault();
  $("#mensaje_referenciar").html("");
  $('#btn_referenciar').button('loading');
  $.ajax({
     type: 'post',
     dataType: "json",
     data: $(event.target).serialize(),
     cache: false,
     url: SITE_URL+"referencias/referenciar_ajax",
     success: function(data){
        if(data.error == false)
        {
          $("#modal_referenciar").modal('hide');
        }
        else
        {
          var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
          htmlData += data.data;
          htmlData += '</div>';
          $("#mensaje_referenciar").html(htmlData);
        }
        $('#btn_referenciar').button('reset');
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        $("#mensaje_referenciar").html(htmlData);
        $('#btn_referenciar').button('reset');
      }
  });
});
</script>

</body>
</html>