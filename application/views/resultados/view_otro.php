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
<main class="content fondo-derecha">

	<!-- Features -->
	<section class="container-fluid">
		
		<div class="row">

			<div class="col-md-12 col-lg-6">
				<div class="panel panel-danger">
				  <div class="panel-heading">
            <h3 class="panel-title" style="margin-top:2px; line-height:30px;"><?=$tipo_producto['tp_desc']?>
            <div class="pull-right">
              <?php
                echo "<span>".$producto['visitas']."</span> <i class='fa fa-eye fa-lg' style='color:#540614;'></i>";
                echo "<span style='color:#540614;'> | </span>";
                echo "<span>".count($referencias_validadas)."</span> <span class='icon-relacion' style='font-size:18px; color:#540614;'></span> ";

                if($producto['puntaje'] == null)
                {
                  $producto['puntaje'] = 0;
                }
                echo "<div class='derecha' id='favorito' onclick='calificar();' style='color:#FFF;'>";
                  if(!$favorito)
                  {
                    echo "<span>".$producto['puntaje']."</span> <i class='far fa-star fa-lg'></i>";
                    echo "<span style='color:#960A25'> / </span>";
                    echo "<span>".$producto['cant_seguidores']."</span> <i class='far fa-user fa-lg'></i>";
                  }
                  else
                  {
                    echo "<span>".$producto['puntaje']."</span> <i class='fas fa-star fa-lg'></i>";
                    echo "<span style='color:#960A25'> / </span>";
                    echo "<span>".$producto['cant_seguidores']."</span> <i class='fa fa-user fa-lg'></i>";
                  }
                echo '</div>';
              ?>
            </div></h3>
            <div class="clearfix"></div>
				  </div>
				  <div class="panel-body">

                <?php
                if($imagenes && count($imagenes))
                {
                  echo '<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="margin-bottom:10px;">';
                    
                    echo '<ol class="carousel-indicators">';
                      foreach ($imagenes as $key => $imagen)
                      {
                        $active = '';
                        if($key==0)
                        {
                          $active = 'class="active"';
                        }
                        echo '<li data-target="#carousel-example-generic" data-slide-to="'.$key.'" '.$active.'></li>';
                      }
                    echo '</ol>';

                    echo '<div class="carousel-inner" role="listbox">';
                      foreach ($imagenes as $key => $imagen)
                      {
                        $active = 'class="item"';
                        if($key==0)
                        {
                          $active = 'class="item active"';
                        }
                        echo '<div '.$active.'><img src="'.base_url('images/productos/'.$imagen['pi_ruta']).'" alt="imagen_'.$key.'"></div>';
                      }
                    echo '</div>';

                    if(count($imagenes)>1)
                    {
                      echo '<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <i class="fas fa-chevron-left fa-2x" aria-hidden="true"></i>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <i class="fas fa-chevron-right fa-2x" aria-hidden="true"></i>
                        <span class="sr-only">Next</span>
                      </a>';
                    }
                  echo '</div>';
                }

                echo "<strong><i class='fa fa-code fa-lg texto-bordo2'></i> ".mostrar_palabra(22, $palabras)."</strong><br>";
                echo "<b class='texto-bordo'>".$producto['sec_code']."</b> - ".$producto['sec_desc']."<br>";
                echo "<b class='texto-bordo'>".$producto['cat_code']."</b> - ".$producto['cat_desc']."<br>";
                echo "<b class='texto-bordo'>".$producto['ara_code']."</b> - ".$producto['ara_desc']."<br>";
                
                echo "<br>";

                echo "<strong><i class='fa fa-map-marker-alt fa-lg texto-bordo2'></i> ".mostrar_palabra(14, $palabras)."</strong><br>";
                echo $producto['ctry_nombre']." <img src='".base_url()."images/banderas/".$producto['ctry_code'].".png' width='20'><br>";
                  if($producto['city_nombre'] == $producto['toponymName'])
                  {
                    echo $producto['city_nombre'];
                  }
                  else
                  {
                    echo $producto['city_nombre']."/".$producto['toponymName'];
                  }
                echo "<br>";

                echo "<br>";

                echo "<strong><i class='fa fa-pencil-alt fa-lg texto-bordo2'></i> ".mostrar_palabra(27, $palabras)."</strong><br>";
                echo $producto['prod_descripcion']."<br>";
                
                echo mostrar_traducir($producto['idi_code'], $this->session->userdata('idi_code'), $producto['prod_descripcion'], mostrar_palabra(39, $palabras));
                echo "<br>";

                echo "<br>";

                echo "<div style='background:#e5e6e6; padding:15px; margin-left:-15px; margin-right:-15px;'>";

                  echo "<strong><i class='fa fa-user fa-lg texto-bordo2'></i> ".mostrar_palabra(38, $palabras)."</strong><br>";
                  //echo '<a href="mailto:'.$producto['usr_mail'].'">'.strtolower($producto['usr_mail'])."</a><br>";
                  if($producto['tp_id'] == TP_OFERTA)
                  {
                      echo mostrar_palabra(341, $palabras)."<br>";
                      echo "<a class='btn btn-gris btn-sm' href='".site_url("productos/nuevo/".TP_DEMANDA."/".$producto['ara_id'])."'>".mostrar_palabra(24, $palabras)."</a><br>";
                  }
                  else
                  {
                      echo mostrar_palabra(340, $palabras)."<br>";
                      echo "<a class='btn btn-gris btn-sm' href='".site_url("productos/nuevo/".TP_OFERTA."/".$producto['ara_id'])."'>".mostrar_palabra(23, $palabras)."</a><br>";
                  }

                  echo "<br>";
                  /*
                  echo "<strong><i class='fa fa-envelope fa-lg texto-bordo2'></i> ".mostrar_palabra(4, $palabras)."</strong><br>";
                  foreach ($producto_mails as $key_mail => $mail)
                  {
                    echo '<a href="mailto:'.$mail['mail_direccion'].'">'.strtolower($mail['mail_direccion'])."</a><br>";
                  }

                  echo "<br>";
                  */
                  echo "<strong><i class='fa fa-language fa-lg texto-bordo2'></i> ".mostrar_palabra(3, $palabras)."</strong><br>";
                  foreach ($producto_idiomas as $key_idioma => $prod_idioma)
                  {
                    echo $prod_idioma['idi_desc']."<br>";
                  }

                  echo "<br>";

                  if($referencias_validadas && count($referencias_validadas)>0)
                  {
                    echo "<strong><span class='icon-relacion texto-bordo2' style='font-size:18px;'></span> ".mostrar_palabra(314, $palabras)."</strong> <i class='fa fa-check-square-o fa-lg texto-bordo'></i><br>";
                    foreach ($referencias_validadas as $key_ref => $referencia)
                    {
                      echo substr($referencia['ref_mail'], strpos($referencia['ref_mail'], '@'))."<br>";
                    }
                    echo "<br>";
                  }
                
                echo "</div>";
                ?>

				  </div>

          <div class="panel-heading">
            <h3 class="panel-title"><?=mostrar_palabra(57, $palabras)?></h3>
          </div>
          <div class="panel-body" id='estadisticas' style="padding:0;">
          </div>
          <div class="panel-footer">
            <?=mostrar_palabra(215, $palabras)?><br>
            <?=mostrar_palabra(152, $palabras)?>
          </div>

				</div>
			</div>

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


<?php
$this->load->view('templates/footer');
?>

<script type="text/javascript">
function buscar_estadisticas(tipo, cat, ara, pais)
{
  //$("#estadisticas").html("<div class='tit'>"+palabras[57, $palabras)+"</div>");
  $("#estadisticas").append("<img src='"+BASE_URL+"assets/images/loading.png' width='20px' style='margin:20px;'>");

  var datos = {cat: cat, ara: ara, rg: tipo, ctry_code_origen: pais, prod_id: <?=$producto['prod_id']?> };
  //alert(JSON.stringify(datos));
  $.ajax({
     type: 'POST',
     data: jQuery.param( datos ),
     dataType: "json",
     cache: false,
     url: SITE_URL+"estadisticas/producto_ajax",
     success: function(data){
        if(data.error == false)
        {
            var htmlData = "";

            if(data.data.texto1 != "")
            {
              htmlData += data.data.texto1;
            }
            if(data.data.texto3 != "")
            {
              htmlData += data.data.texto3;
            }

            $("#estadisticas").html(htmlData);
        }
        else
        {
          $("#estadisticas").html("<div class='estadistica2'>"+data.data+"</div>");
        }
     },
     error: function(x, status, error){
       $("#estadisticas").html("<div class='estadistica1'><?=mostrar_palabra(233, $palabras)?></div>");
     }
  });
}

var cant_seguidores = <?=$producto['cant_seguidores']?>;
var puntaje = <?=$producto['puntaje']?>;

//buscar_favorito();
buscar_estadisticas(<?=$producto['tp_id']?>,<?=$producto['cat_id']?>,<?=$producto['ara_id']?>,"<?=$producto['ctry_code']?>");

$('#input-rating').rating({'showCaption':false, showClear:false, 'stars':'5', 'min':'0', 'max':'5', 'step':'0.5', 'size':'xs', 'starCaptions': {0:'0', 1:'1', 2:'2', 3:'3', 4:'4', 5:'5'}});

function calificar()
{
  $('#calificar_usr_id').val(<?=$producto['usr_id']?>);
  $('#calificar_prod_id').val(<?=$producto['prod_id']?>);
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

          htmlData = "";
          if(data.uf_puntaje > 0)
          {
            htmlData += "<span>"+data.puntaje+"</span> <i class='fas fa-star fa-lg'></i> ";
            htmlData += "<span style='color:#960A25'>/ </span>";
            htmlData += "<span>"+data.cant_seguidores+"</span> <i class='fas fa-user fa-lg'></i>";
          }
          else
          {
            htmlData += "<span>"+data.puntaje+"</span> <i class='far fa-star fa-lg'></i> ";
            htmlData += "<span style='color:#960A25'>/ </span>";
            htmlData += "<span>"+data.cant_seguidores+"</span> <i class='far fa-user fa-lg'></i>";
          }
          
          $("#favorito").html(htmlData);

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
</script>

</body>
</html>