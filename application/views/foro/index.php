<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<body>

<!-- Header -->
<?php
$this->load->view('templates/analytics');
$this->load->view('templates/header');
?>
<!-- /Header -->
	
<?php
$this->load->view('templates/sidebar_left');
?>

<!-- Content -->
<main class="content">

	<!-- Features -->
	<section class="container-fluid">
		
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-danger" style="background:#FFFFFF;">
				  <div class="panel-heading">
        		<a href="<?=site_url('foro/filtros')?>" class="pull-right flip" id="filtro"><i class='fa fa-filter'></i></a>
        		<a class="pull-right flip" style="margin-right:10px;" href="<?=site_url()?><?=$solapa?>/nuevo"><i class="fas fa-plus-circle"></i></a>
				    <h3 class="panel-title" style="padding:6px 0px;"><?=mostrar_palabra(294, $palabras)?></h3>
				  </div>
				  <div class="panel-body" style="padding:0px;">
				    <?php
				    if($foros)
				    {
              echo '<div class="row make-columns">';
	              foreach ($foros as $key => $foro)
	              {
	                echo '<div class="media foro" id="prod_'.$foro['foro_id'].'" onclick="ver_foro('.$foro['foro_id'].')" style="cursor:pointer;">';
	                  echo '<div class="media-left">';
	                  if($foro['usr_imagen'])
	                  {
	                    echo "<img id='img_user' src='".base_url()."images/usuarios/".$foro['usr_imagen']."' class='img-circle img-user' width='50'>";
	                  }
	                  else
	                  {
	                  	echo "<img id='img_user' src='".base_url("images/usuarios/perfil.jpg")."' class='img-circle img-user' width='50'>";
	                  }
	                  echo '</div>';
	                  echo '<div class="media-body">';
	                    echo '<strong>'.$foro['usr_mail'].'</strong><br>';
	                    echo '<small class="texto-bordo" style="display:block; margin-bottom:5px;"><strong>'.interval_date($foro['fecha_ultimo_comentario'], date('Y-m-d H:i:s'))."</strong></small>";
	                    echo '<span>'.nl2br($foro['foro_descripcion']).'</span><br>';
	                      //echo $foro['ara_desc'].'<br>';
	                    if($foro['sec_id'])
	                    {
		                  	echo '<small class="texto-bordo" style="display:block; margin-top:5px;">';
			                    if($foro['sec_id'] == 22)
			                    {
			                      echo '<b>'.$foro['ara_code'].'</b> - '.mostrar_palabra(21, $palabras).'<br>';
			                  	}
			                    else
			                    {
			                      echo '<b>'.$foro['ara_code'].'</b> - '.mostrar_palabra(22, $palabras).'<br>';
			                  	}
		                  	echo '</small>';
		                  	if($foro['ctry_code'])
		                    {
		                    	echo "<small><img src='".base_url("images/banderas/".$foro['ctry_code'].".png")."'> ".$foro['ctry_nombre']."</small>";
		                	}
		                }
	                  echo '</div>';
	                  	echo '<div class="panel-footer">';
		                    echo '<div class="col-xs-6 visit text-left flip">';
			                	echo $foro['cant_visitas']." <i class='fa fa-eye fa-lg'></i>";
			              	echo '</div>';
			              	echo '<div class="col-xs-6 cant text-right flip">';
			                	echo $foro['cant_mensajes']." <i class='fa fa-comments fa-lg'></i>";
			              	echo '</div>';
			              	echo '<div style="clear:both;"></div>';
	                  	echo '</div>';
	                echo '</div>';
	              }
              echo '</div>';
  					}
  					else
  					{
  						echo "No se han encontrado foros abiertos.<br>";
  					}
  					
				    ?>

				    <div id="results" style="display:none;">
			        </div>

			        <p id="loading" style="display:none;">
			          <img src="<?=base_url('assets/images/loading.png')?>" alt="Loading…" width="50px"/>
			        </p>

				  </div>
				</div>
			</div>

		</div>
	</section>
	<!-- /Features -->

</main>

<?php
$this->load->view('templates/footer');
?>

<script type="text/javascript">
var offset = 0;
var limit = 10;
var fin = false;
var buscando = false;

function ver_foro(id)
{
  location.href=SITE_URL+"<?=$solapa?>/view/"+id;
}

$(document).ready(function() {
  var win = $(window);

  // Each time the user scrolls
  win.scroll(function() {
    if(!buscando)
    {
      if ($(document).height() - win.height() == win.scrollTop() && !fin)
      {
        buscando = true;
        //buscar();
      }
    }
  });

  //buscar();
});

function buscar()
{
  $('#loading').show();

  if(buscar_ultimos_ajax)
  {
    buscar_ultimos_ajax.abort();
  }

    $.ajax({
      url: SITE_URL+'foro/buscar_resultados_ajax/'+offset+'/'+limit,
      dataType: 'json',
      timeout: 5000,
      success: function(data) {
        if(data.cant == -1)
        {
          fin = true;
          var htmlData = "";
          htmlData += "<?=mostrar_palabra(56, $palabras)?><br><br>";
          //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_DEMANDA?>'><img src='"+BASE_URL+"images/demanda.png' class='img-responsive'> <?=$palabras[24]['pal_desc']?> <i class='fa fa-plus fa-3x'></i></a>";
          //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_OFERTA?>'><img src='"+BASE_URL+"images/oferta.png' class='img-responsive'> <?=$palabras[23]['pal_desc']?> <i class='fa fa-plus fa-3x'></i></a>";
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
          //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_DEMANDA?>'><img src='"+BASE_URL+"images/demanda.png' class='img-responsive'> <?=$palabras[24]['pal_desc']?> <i class='fa fa-plus fa-3x'></i></a>";
          //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_OFERTA?>'><img src='"+BASE_URL+"images/oferta.png' class='img-responsive'> <?=$palabras[23]['pal_desc']?> <i class='fa fa-plus fa-3x'></i></a>";
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
            //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_DEMANDA?>'><img src='"+BASE_URL+"images/demanda.png' class='img-responsive'> <?=$palabras[24]['pal_desc']?> <i class='fa fa-plus fa-3x'></i></a>";
            //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_OFERTA?>'><img src='"+BASE_URL+"images/oferta.png' class='img-responsive'> <?=$palabras[23]['pal_desc']?> <i class='fa fa-plus fa-3x'></i></a>";
            htmlData += "<div style='clear:both; height:20px;'></div>";
            //$('#results').append(htmlData);
            $('#area_botones_cargar').show();
            $('#results').show();
            $( "#area-mayor-actividad" ).appendTo( "#results" );
          }
        }
        else
        {
          $('#header_resultados').show();
          $('#results').show();
          if(data.cant < limit)
          {
            fin = true;
          }
          offset += data.cant;

          var htmlData = "";
          $.each(data.result, function(i, item) {
            
            htmlData += '<div class="media foro" id="prod_'+item.foro_id+'" onclick="ver_foro('+item.foro_id+')" style="cursor:pointer;">';
              htmlData += '<div class="media-left">';
              if($foro['usr_imagen'])
              {
                htmlData += "<img id='img_user' src='"+BASE_URL+"images/usuarios/"+item.usr_imagen+"' class='img-circle img-user' width='50'>";
              }
              else
              {
              	htmlData += "<img id='img_user' src='"+BASE_URL+"images/usuarios/perfil.png' class='img-circle img-user' width='50'>";
              }
              htmlData += '</div>';
              htmlData += '<div class="media-body">';
                htmlData += '<strong>'+item.usr_mail+'</strong><br>';
                htmlData += '<small class="texto-bordo" style="display:block; margin-bottom:5px;"><strong>'+item.fecha_ultimo_comentario+"</strong></small>";
                htmlData += '<span>'+item.foro_descripcion+'</span><br>';
                  //htmlData += $foro['ara_desc'].'<br>';
                if($foro['sec_id'])
                {
                  	htmlData += '<small class="texto-bordo" style="display:block; margin-top:5px;">';
	                    if($foro['sec_id'] == 22)
	                    {
	                      htmlData += '<b>'+item.ara_code+'</b> - <?=mostrar_palabra(21, $palabras)?><br>';
	                  	}
	                    else
	                    {
	                      htmlData += '<b>'+item.ara_code+'</b> - <?=mostrar_palabra(22, $palabras)?><br>';
	                  	}
                  	htmlData += '</small>';
                  	if($foro['ctry_code'])
                    {
                    	htmlData += "<small><img src='"+BASE_URL+"images/banderas/"+item.ctry_code+".png'> "+item.ctry_nombre+"</small>";
                	}
                }
              htmlData += '</div>';
              	htmlData += '<div class="panel-footer">';
                    htmlData += '<div class="col-xs-6 visit text-left flip">';
	                	htmlData += item.cant_visitas+" <i class='fa fa-eye fa-lg'></i>";
	              	htmlData += '</div>';
	              	htmlData += '<div class="col-xs-6 cant text-right flip">';
	                	htmlData += item.cant_mensajes+" <i class='fa fa-comments fa-lg'></i>";
	              	htmlData += '</div>';
	              	htmlData += '<div style="clear:both;"></div>';
              	htmlData += '</div>';
            htmlData += '</div>';
          });

          $("#results").append(htmlData);
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
</script>

</body>
</html>