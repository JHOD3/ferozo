<!--<p class="small text-muted text-center">
	Copyright &copy; 2015, Sistema
</p>
<br>
-->

<!-- Modal -->
<div class="modal fade" id="modal_reportar_texto" tabindex="-1" role="dialog" aria-labelledby="modal_reportar_texto-label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal_reportar_texto-label"><?=mostrar_palabra(92, $palabras)?></h4>
      </div>
      <div class="modal-body">
        <div id="area_reportar_resultado"></div>

        <input type="hidden" value="" name="tipo_id" id="area_reportar_tipo">
        <input type="hidden" value="" name="pal_id" id="area_reportar_pal">

      	<p><?=mostrar_palabra(295, $palabras)?></p>
        <div class="form-group">
        	<textarea class="form-control" id="area_reportar_texto" name="texto"></textarea>
        </div>
        
        <div class="form-group">
          <label for="seccion"><?=mostrar_palabra(315, $palabras)?></label>
          <select class="form-control" name="idioma" id="area_reportar_idioma" onchange="reportar_texto_ayuda()">
            <?php
            $idiomas_reportar = $this->idiomas_model->get_items($this->session->userdata('idi_code'));
            echo "<option value=''>".mostrar_palabra(3, $palabras)."</option>";
            foreach ($idiomas_reportar as $idioms_reportar)
            {
              echo "<option value='".$idioms_reportar['idi_code']."'>".$idioms_reportar['idi_desc']."</option>";
            }
            ?>
          </select>
        </div>
        
        <div style="margin-top:20px;" id="area_reportar_texto2"></div>

        <div style="clear:both;"></div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(29, $palabras)?></button>
        <button type="button" class="btn btn-danger" onclick="enviar_error()"><?=mostrar_palabra(316, $palabras)?></button>
      </div>
    </div>
  </div>
</div>


<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<script src="<?=base_url()?>assets/js/jquery-1.11.3.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<!--<script src="<?=base_url()?>assets/js/template.js"></script>-->

<!-- Bootstrap itself -->
<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<?php
if($this->session->userdata('idi_code') == 'ar')
{
    echo '<link href="'.base_url('assets/css/bootstrap-rtl.min.css').'" rel="stylesheet" type="text/css">';
}
?>
<!-- Icons -->
<link href="<?=base_url()?>assets/css/fontawesome-all.min.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/icomoon.css" rel="stylesheet">
<!-- Flags -->
<link href="<?=base_url()?>assets/css/flag-icon.min.css" rel="stylesheet"> 
<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700"> 

<!-- Custom styles -->
<link rel="stylesheet" href="<?=base_url()?>assets/css/styles.css">
<?php
if($this->session->userdata('idi_code') == 'ar')
{
    echo '<link href="'.base_url('assets/css/styles-rtl.css').'" rel="stylesheet" type="text/css">';
}
?>
<link rel="stylesheet" href="<?=base_url()?>assets/css/cs-select.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/cs-skin-elastic.min.css">

<!-- Star rating -->
<link href="<?=base_url()?>assets/css/star-rating.min.css" rel="stylesheet">
<script src="<?=base_url()?>assets/js/star-rating.min.js"></script>

<?php
$this->load->view("templates/acceso");
?>

<script type="text/javascript">
$( ".cortar-texto" ).hover(
  function() {
  	$(this).removeClass('cortar-texto');
    $(this).addClass('cortar-texto-hover');
  }, function() {
    $(this).removeClass('cortar-texto-hover');
    $(this).addClass('cortar-texto');
  }
);

function reportar_texto(tipo_id, pal_id)
{
	$('#modal_reportar_texto').modal('show');
  $('#area_reportar_tipo').val(tipo_id);
  $('#area_reportar_pal').val(pal_id);
  $('#area_reportar_resultado').html("");
  $('#area_reportar_texto').val("");
  $('#area_reportar_texto2').html("");

  $.ajax({
    type: 'POST',
    url: SITE_URL+'errores/cargar_modal_ajax',
    data: jQuery.param({tipo_id: tipo_id, pal_id: pal_id, idi_code:"<?=$this->session->userdata('idi_code')?>"}),
    dataType: 'json',
    success: function(data) {
      var htmlData = "";
      if(data.error == false)
      {
        $('#area_reportar_texto').val(data.data);
        /*
        $.each(data.data, function(i, item) {
          htmlData += "<b>"+item.ara_code+"</b> - "+item.ara_desc+"<br>";
        });
        */
      }
      else
      {
        htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
        htmlData += data.data;
        htmlData += '</div>';
        $('#area_reportar_resultado').html(htmlData);
      }
    },
    error: function(x, status, error){
      var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
      htmlData += "An error occurred: " + status + " nError: " + error;
      htmlData += '</div>';
      $('#area_reportar_resultado').html(htmlData);
    }
  });
}

function reportar_texto_ayuda(tipo_id, pal_id)
{
  if($('#area_reportar_idioma').val() != "")
  {
    $.ajax({
      type: 'POST',
      url: SITE_URL+'errores/cargar_modal_ajax',
      data: jQuery.param({tipo_id: $('#area_reportar_tipo').val(), pal_id: $('#area_reportar_pal').val(), idi_code: $('#area_reportar_idioma').val()}),
      dataType: 'json',
      success: function(data) {
        var htmlData = "";
        if(data.error == false)
        {
          $('#area_reportar_texto2').html(data.data);
        }
        else
        {
          htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
          htmlData += data.data;
          htmlData += '</div>';
          $('#area_reportar_resultado').html(htmlData);
        }
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        $('#area_reportar_resultado').html(htmlData);
      }
    });
  }
  else
  {
    $('#area_reportar_texto2').html("");
  }
}

function enviar_error()
{
  $.ajax({
    type: 'POST',
    url: SITE_URL+'errores/grabar_error_ajax',
    data: jQuery.param({tipo_id: $('#area_reportar_tipo').val(), pal_id: $('#area_reportar_pal').val(), idi_code:"<?=$this->session->userdata('idi_code')?>", usr_id:"<?=$this->session->userdata('usr_id')?>", descripcion:$('#area_reportar_texto').val()}),
    dataType: 'json',
    success: function(data) {
      var htmlData = "";
      if(data.error == false)
      {
        htmlData = '<div class="alert with-icon alert-success" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
        htmlData += data.data;
        htmlData += '</div>';
        $('#area_reportar_resultado').html(htmlData);
        $('#modal_reportar_texto').modal('hide');
      }
      else
      {
        htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
        htmlData += data.data;
        htmlData += '</div>';
        $('#area_reportar_resultado').html(htmlData);
      }
    },
    error: function(x, status, error){
      var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
      htmlData += "An error occurred: " + status + " nError: " + error;
      htmlData += '</div>';
      $('#area_reportar_resultado').html(htmlData);
    }
  });
}


function copyTextToClipboard(text) {
  var textArea = document.createElement("textarea");
  // Place in top-left corner of screen regardless of scroll position.
  textArea.style.position = 'fixed';
  textArea.style.top = 0;
  textArea.style.left = 0;
  // Ensure it has a small width and height. Setting to 1px / 1em
  // doesn't work as this gives a negative w/h on some browsers.
  textArea.style.width = '2em';
  textArea.style.height = '2em';
  // We don't need padding, reducing the size if it does flash render.
  textArea.style.padding = 0;
  // Clean up any borders.
  textArea.style.border = 'none';
  textArea.style.outline = 'none';
  textArea.style.boxShadow = 'none';
  // Avoid flash of white box if rendered for any reason.
  textArea.style.background = 'transparent';
  textArea.value = text;
  document.body.appendChild(textArea);

  var input = textArea;
  var isiOSDevice = navigator.userAgent.match(/ipad|iphone/i);

  if (isiOSDevice) {
    
    var editable = input.contentEditable;
    var readOnly = input.readOnly;

    input.contentEditable = true;
    input.readOnly = false;

    var range = document.createRange();
    range.selectNodeContents(input);

    var selection = window.getSelection();
    selection.removeAllRanges();
    selection.addRange(range);

    input.setSelectionRange(0, 999999);
    input.contentEditable = editable;
    input.readOnly = readOnly;

  } else {
    input.select();
  }

  document.execCommand('copy');
  document.body.removeChild(textArea);

  alert("OK");
}


/**************************
RESULTADO DEL SIDEBAR RIGHT
***************************/
var offset_ultimo = 0;
var limit_ultimo = 1;
var buscar_ultimos_ajax = null;

function ver_producto_ultimo(id)
{
  location.href=SITE_URL+"resultados/view_otro/"+id;
}

function buscar_ultimos()
{
  if(offset_ultimo==0)
  {
    $('#results_ultimos').html('<img src="'+BASE_URL+'assets/images/loading.png" alt="Loading…" width="50px"/>');
  }

    buscar_ultimos_ajax = $.ajax({
      url: SITE_URL+'resultados/buscar_ultimos_ajax/'+offset_ultimo+'/'+limit_ultimo,
      dataType: 'json',
      timeout: 3000,
      success: function(data) {
        if(data.cant == 0)
        {
          offset_ultimo = 0;
        }
        else
        {
          offset_ultimo += data.cant;

          var htmlData = "";
          $.each(data.result, function(i, item) {
            
            var color_visto = "visto";
            if(item.mis_visitas == 0)
            {
              color_visto = "no-visto";
            }

            var premium = "";
            if(item.tu_id == <?=TU_PREMIUM?>)
            {
              premium = "premium";
            }

            if(i%2==0)
            {
              if(i>0)
              {
                htmlData += '</div>';
              }
              htmlData += '<div class="row" style="padding:0px 15px;">';
            }

            htmlData += '<div class="col-xs-12 panel resultado2" style="margin-bottom:0px;">';
              htmlData += '<div class="panel-body '+color_visto+' '+premium+'">';
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
                htmlData += '<div class="media-body" onclick="ver_producto_ultimo('+item.prod_id+')" style="cursor:pointer;">';
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
                        htmlData += item.city_nombre+"/"+item.toponymName;
                      }
                    htmlData += ")</span>";
                  htmlData += '</small>';
                htmlData += '</div>';


              htmlData += '</div>';
              htmlData += '</div>';
              htmlData += '<div class="panel-footer" style="margin-right:0px;">';
                htmlData += '<div class="col-xs-6">';
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
                  htmlData += "<span style='"+color_aux+"'>"+item.referencias+"</span> <span class='icon-icono' style='font-size:18px; "+color_aux+"'></span>";
                htmlData += '</div>';
                htmlData += '<div class="col-xs-6" style="text-align:right;" id="area_puntaje_'+item.prod_id+'">';
                  if(item.puntaje == null)
                  {
                    item.puntaje = 0;
                  }

                  htmlData += "<div class='derecha'>";
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
          });
          //Cierra el ultimo row
          htmlData += '</div>';

          $("#results_ultimos").html(htmlData);
          /*$('#results_ultimos').fadeOut("slow", function(){
              var div = $("<div id='results_ultimos'>test2</div>").hide();
              $(this).replaceWith(htmlData);
              $('#results_ultimos').fadeIn("slow");
          });*/
        }
        buscar_ultimos_ajax = null;
        setTimeout(buscar_ultimos, 8000);
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        //$("#results_ultimos").html(htmlData);
        buscar_ultimos_ajax = null;
        setTimeout(buscar_ultimos, 8000);
      }
    });
}

function reset_filtros_resultados()
{
  $.ajax({
    url: SITE_URL+'resultados/reset_filtros_ajax',
    dataType: 'json',
    success: function(data) {
      location.href=SITE_URL+"resultados";
    },
    error: function(x, status, error){
      var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
      htmlData += "An error occurred: " + status + " nError: " + error;
      htmlData += '</div>';
      //alert(htmlData);
      location.href=SITE_URL+"resultados";
    }
  });
}

function post_impresion(id) {
    $.ajax({
      type: 'POST',
      url: SITE_URL+'ads/set_ads_impresion_ajax',
      dataType: 'json',
      data: jQuery.param({ads_id: id}),
      success: function(data) {
        //alert(data.data);
      },
      error: function(x, status, error){
        //alert("An error occurred: " + status + " nError: " + error);
      }
    });
}

function post_click(id) {
  /*
    $.ajax({
      type: 'POST',
      url: SITE_URL+'ads/set_ads_click_ajax',
      dataType: 'json',
      data: jQuery.param({ads_id: id}),
      success: function(data) {
        location.href = SITE_URL+'ads/view/'+id;
      },
      error: function(x, status, error){
        //alert("An error occurred: " + status + " nError: " + error);
      }
    });
  */
  location.href = SITE_URL+'ads/view/'+id;
}

function post_click_contacto(origen, destino, contenido, tipo) {
  copyTextToClipboard(contenido);
  var datos = jQuery.param({origen:origen, destino:destino, contenido:contenido, tipo:tipo});
    $.ajax({
      type: 'POST',
      url: SITE_URL+'webservices/click_contacto_ajax',
      dataType: 'json',
      data: datos,
      success: function(data) {
        //alert(data.data);
      },
      error: function(x, status, error){
        //alert("An error occurred: " + status + " nError: " + error);
      }
    });
}

function nl2br (str, is_xhtml) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
/*robert correciones*/
			if("<?=(!isset($this->session))?>")
              {
				buscar_ultimos();
			  }	
/*robert correciones*/			  
			  
</script>