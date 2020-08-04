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
		
		<div class="row fondo-derecha">

			<div class="col-md-12 col-lg-6">
				<div class="panel panel-danger">
				  <div class="panel-heading">
				    <h3 class="panel-title" style="margin-top:2px; line-height:30px;"><?=mostrar_palabra(38, $palabras)?>
            <div class="pull-right">
              <?php
              if($user['puntaje'] == null)
              {
                $user['puntaje'] = 0;
              }
              echo "<div class='derecha' id='favorito' onclick='calificar();' style='color:#FFFFFF;'>";
                if(!$favorito)
                {
                  echo "<span>".$user['puntaje']."</span> <i class='far fa-star fa-lg'></i>";
                  echo "<span style='color:#960A25'> / </span>";
                  echo "<span>".$user['cant_seguidores']."</span> <i class='far fa-user fa-lg'></i>";
                }
                else
                {
                  echo "<span>".$user['puntaje']."</span> <i class='fas fa-star fa-lg'></i>";
                  echo "<span style='color:#960A25'> / </span>";
                  echo "<span>".$user['cant_seguidores']."</span> <i class='fa fa-user fa-lg'></i>";
                }
              echo '</div>';
              ?>
            </div></h3>
            <div class="clearfix"></div>
				  </div>
				  <div class="panel-body">

              <div class="form-group col-xs-6 col-sm-6">
                <div id="preview">
                <?php
                  echo "<img id='img_user' src='".base_url()."images/usuarios/".$user['usr_imagen']."' class='img-circle img-user'>";
                ?>
                </div>
              </div>

              <div class="form-group col-xs-6 col-sm-6" style="text-align:center;">
                <div id="qr"></div>
              </div>

              <div style="clear:both;"></div>
              <?php
              echo '<small>'.mostrar_palabra(4, $palabras).'</small><br>';
              echo '<span style="color:#e0103a; -moz-user-select: none; -webkit-user-select: none; -ms-user-select:none; user-select:none;-o-user-select:none;" unselectable="on" onselectstart="return false;" onmousedown="return false;">'.$user['usr_mail']."</span><button class='btn btn-link' data-toggle='tooltip' data-placement='top' title='".mostrar_palabra(317, $palabras)."' onclick='post_click_contacto(".$this->session->userdata('usr_id').",".$user['usr_id'].",\"".$user['usr_mail']."\",\"mail\")'><i class='fas fa-copy'></i></button><br>";
              ?>

              <small><?=mostrar_palabra(3, $palabras)?></small><br>
              <?=$user['idi_desc']?><br>

              <?php
              echo "<small>".mostrar_palabra(219, $palabras)."</small><br>";
              echo interval_date($user['usr_ult_acceso'], date('Y-m-d H:i:s'))."<br>";

              echo "<br>";

              if($user['usr_publica'] == 1)
              {
                if($user['usr_apellido'] != "")
                {
                  echo "<small>".mostrar_palabra(10, $palabras)."</small><br>";
                  echo $user['usr_apellido']."<br>";
                }

                if($user['usr_nombre'] != "")
                {
                  echo "<small>".mostrar_palabra(11, $palabras)."</small><br>";
                  echo $user['usr_nombre']."<br>";
                }

                if($user['usr_empresa'] != "")
                {
                  echo "<small>".mostrar_palabra(13, $palabras)."</small><br>";
                  echo $user['usr_empresa']."<br>";
                }

                echo "<small>".mostrar_palabra(14, $palabras)."</small><br>";
                echo $user['ctry_nombre']."<br>";
                if($user['city_nombre'] != "")
                {
                  echo $user['city_nombre']."<br>";
                }
                if($user['usr_ciudad'] != "")
                {
                  echo $user['usr_ciudad']."<br>";
                }
                if($user['usr_direccion'] != "")
                {
                  echo $user['usr_direccion']."<br>";
                }

                echo "<br>";

                $cant_datos = 0;
                foreach ($tipo_datos as $key_td => $tipo_dato)
                {
                  if($tipo_dato['datos'] && count($tipo_dato['datos'])>0)
                  {
                    echo "<div class='form-group' id='area_datos_".$tipo_dato['td_id']."'>";
                      echo "<label><i class='fa ".$tipo_dato['td_icono']." fa-lg texto-rojo'></i> ".$tipo_dato['td_desc']."</label>";

                      foreach ($tipo_dato['datos'] as $key_dato => $dato)
                      {
                        $cant_datos++;
                        echo "<div id='area_dato_".$cant_datos."'>";
                          if(count($tipo_dato['categorias']) > 0)
                          {
                              foreach ($tipo_dato['categorias'] as $categoria)
                              {
                                if($dato['ctd_id'] == $categoria['ctd_id'])
                                {
                                  echo $categoria['ctd_desc']." - ";
                                }
                              }
                              echo '<span style="-moz-user-select: none; -webkit-user-select: none; -ms-user-select:none; user-select:none;-o-user-select:none;" unselectable="on" onselectstart="return false;" onmousedown="return false;">'.$dato['ud_descripcion']."</span><button class='btn btn-link' data-toggle='tooltip' data-placement='top' title='".mostrar_palabra(317, $palabras)."' onclick='post_click_contacto(".$this->session->userdata('usr_id').",".$user['usr_id'].",\"".$dato['ud_descripcion']."\",\"".$tipo_dato['td_desc_es']." - ".$categoria['ctd_desc_es']."\")'><i class='fas fa-copy'></i></button><br>";
                          }
                          else
                          {
                            echo '<span style="-moz-user-select: none; -webkit-user-select: none; -ms-user-select:none; user-select:none;-o-user-select:none;" unselectable="on" onselectstart="return false;" onmousedown="return false;">'.$dato['ud_descripcion']."</span><button class='btn btn-link' data-toggle='tooltip' data-placement='top' title='".mostrar_palabra(317, $palabras)."' onclick='post_click_contacto(".$this->session->userdata('usr_id').",".$user['usr_id'].",\"".$dato['ud_descripcion']."\",\"".$tipo_dato['td_desc_es']." - ".$categoria['ctd_desc_es']."\")'><i class='fas fa-copy'></i></button><br>";
                          }
                        echo "</div>";
                      }
                      echo "<div class='clearfix'></div>";
                    echo "</div>";
                  }
                }

              }


              if($referencias_validadas && count($referencias_validadas)>0)
              {
                echo "<strong><span class='icon-relacion texto-bordo2' style='font-size:18px;'></span> ".mostrar_palabra(314, $palabras)."</strong> <i class='fa fa-check-square-o fa-lg texto-bordo'></i><br>";
                foreach ($referencias_validadas as $key_ref => $referencia)
                {
                  echo substr($referencia['ref_mail'], strpos($referencia['ref_mail'], '@'))."<br>";
                }
                echo "<br>";
              }
              ?>

				  </div>
				</div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-danger">
          <div class="panel-heading">
            <h3 class="panel-title"><?=mostrar_palabra(86, $palabras)?></h3>
          </div>
        </div>

        <?php
            if($resultados)
            {
              foreach ($resultados as $key => $resultado)
              {
                $color_visto = "visto";
                if($resultado['mis_visitas'] == 0)
                {
                  $color_visto = "no-visto";
                }

                $premium = "";
                $media_right = '<i class="fa fa-ellipsis-v fa-lg"></i>';
                if($resultado['tu_id'] == TU_PREMIUM)
                {
                  $premium = "premium";
                  $media_right = '<img src="'.base_url('assets/images/esquina-premium.png').'">';
                  if($this->session->userdata('idi_code') == "ar")
                  {
                    $media_right = '<img src="'.base_url('assets/images/esquina-premium-rtl.png').'">';
                  }
                }
          
                /*
                if($key%2==0)
                {
                  if($key>0)
                  {
                    echo '</div>';
                  }
                  echo '<div class="row" style="padding:0px 15px;">';
                }
                */
                echo '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 panel resultado2 '.$premium.'">';
                echo '<div class="panel-body '.$color_visto.'">';

                  echo '<div class="menu-tarjeta">';
                    echo '<div data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$media_right.'</div>';
                    echo '<ul class="dropdown-menu dropdown-menu-right">';
                      echo "<li><a href='".site_url()."resultados/view/".$resultado['prod_id']."'>".mostrar_palabra(151, $palabras)."</a></li>";
                      //echo "<li><a href='javascript:;'>".mostrar_palabra(309, $palabras)."</a></li>";
                      //echo "<li><a href='javascript: calificar(".$resultado['prod_id'].");'>".mostrar_palabra(313, $palabras)."</a></li>";
                      echo "<li><a onclick='CopyLink(".$resultado['prod_id'].")'>".mostrar_palabra(317, $palabras)."</a></li>";
                    echo '</ul>';
                  echo '</div>';

                echo '<div class="media" id="prod_'.$resultado['prod_id'].'">';

                  echo '<div class="">';
                    $background = "";
                    $clase = "sin_imagen";
                    if($resultado['prod_imagen'])
                    {
                      $background = "background:url(".base_url()."images/productos/".$resultado['prod_imagen']."); background-size:cover;";
                      $clase = "con_imagen";
                    }

                    echo "<div class='media-object img-rounded ".$clase."' style='".$background."'>";

                    if($resultado['usr_imagen'])
                    {
                      echo "<a href='".site_url()."user/view/".$resultado['usr_id']."'><img class='img-circle' src='".base_url()."images/usuarios/".$resultado['usr_imagen']."'></a>";
                    }
                    else
                    {
                      echo "<img class='img-circle' src='".base_url()."images/usuarios/perfil.jpg'>";
                    }

                    if($resultado['tp_id'] == TP_OFERTA)
                    {
                        echo "<img class='media-tipo' src='".base_url()."images/oferta.png'>";
                    }
                    else
                    {
                        echo "<img class='media-tipo' src='".base_url()."images/demanda.png'>";
                    }

                    echo '</div>';
                    /*
                    if($resultado['tp_id'] == 1)
                    {
                        echo "<img class='media-object' src='".base_url()."images/oferta.png' width='50'>";
                    }
                    else
                    {
                        echo "<img class='media-object' src='".base_url()."images/demanda.png' width='50'>";
                    }
                    */
                  echo '</div>';
                  
                  echo '<div class="media-body" onclick="ver_producto('.$resultado['prod_id'].')" style="cursor:pointer;">';
                    //echo '<b class="cortar-texto-mail">'.$resultado['pm_mail'].'</b>';
                    if($resultado['tp_id'] == TP_OFERTA)
                    {
                      echo '<b class="cortar-texto-mail">'.mostrar_palabra(19, $palabras).'</b>';
                    }
                    else
                    {
                      echo '<b class="cortar-texto-mail">'.mostrar_palabra(20, $palabras).'</b>';
                    }
                    echo '<div class="cortar-texto-productos2">'.$resultado['prod_descripcion'].'</div>';
                    echo '<div class="cortar-texto-productos2">'.$resultado['ara_desc'].'</div>';
                    echo '<small>';
                      if($resultado['sec_id'] == 22)
                      {
                        echo '<b class="cortar-texto-mail texto-bordo">'.$resultado['ara_code'].' - '.mostrar_palabra(21, $palabras).'</b>';
                      }
                      else
                      {
                        echo '<b class="cortar-texto-mail texto-bordo">'.$resultado['ara_code'].' - '.mostrar_palabra(22, $palabras).'</b>';
                      }
                      echo "<span class='cortar-texto-mail'><img src='".base_url()."images/banderas/".$resultado['ctry_code'].".png'> ".$resultado['ctry_nombre'];
                      echo " (";
                        if($resultado['city_nombre'] == $resultado['toponymName'])
                        {
                          echo $resultado['city_nombre'];
                        }
                        else
                        {
                          echo $resultado['city_nombre']."/".$resultado['toponymName'];
                        }
                      echo ")</span>";
                    echo '</small>';
                  echo '</div>';

                echo '</div>';
                echo '</div>';

                echo '<div class="panel-footer">';
                  echo '<div class="col-xs-6">';
                    $color_aux = "";
                    if($resultado['visitas'] > 0)
                    {
                      $color_aux = "color:#980521;";
                    }
                    echo "<span style='".$color_aux."'>".$resultado['visitas']."</span> <i class='fa fa-eye fa-lg' style='".$color_aux."'></i>";
                  echo '</div>';
                  echo '<div style="clear:both"></div>';
                echo '</div>';

                echo '</div>';
              }
              //Cierra el ultimo row
              //echo '</div>';
            }
            else
            {
              echo mostrar_palabra(56, $palabras);
            }
            ?>

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

<script src="<?=base_url()?>assets/js/jquery-qrcode-0.14.0.min.js"></script>

<script type="text/javascript">
$('.btn-link').tooltip();

function calificar()
{
  $('#calificar_usr_id').val(<?=$user['usr_id']?>);
  $('#calificar_prod_id').val(0);
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

function ver_edit(id)
{
  //$('#prod_'+id).css("backgroundColor","#F2DEDE");
  $('#prod_'+id+' .media-right').show();
}

function sacar_edit(id)
{
  //$('#prod_'+id).css("backgroundColor","#FFFFFF");
  $('#prod_'+id+' .media-right').hide();
}

function ver_producto(id)
{
  location.href=SITE_URL+"resultados/view/"+id;
}

function CopyLink(id) {
  copyTextToClipboard(SITE_URL+"resultados/view/"+id);
}

var options = {
            // render method: 'canvas', 'image' or 'div'
            render: 'canvas',

            // version range somewhere in 1 .. 40
            minVersion: 1,
            maxVersion: 40,

            // error correction level: 'L', 'M', 'Q' or 'H'
            ecLevel: 'H',

            // offset in pixel if drawn onto existing canvas
            left: 0,
            top: 0,

            // size in pixel
            size: 150,

            // code color or image element
            fill: '#000',

            // background color or image element, null for transparent background
            background: '#FFF',

            // content
            text: "<?=site_url()?>user_free/index/<?=$user['usr_id']?>",

            // corner radius relative to module width: 0.0 .. 0.5
            radius: 0,

            // quiet zone in modules
            quiet: 1,

            // modes
            // 0: normal
            // 1: label strip
            // 2: label box
            // 3: image strip
            // 4: image box
            mode: 0,

            mSize: 0.1,
            mPosX: 0.5,
            mPosY: 0.5,

            label: 'no label',
            fontname: 'sans',
            fontcolor: '#000',

            image: null
        };

$('#qr').qrcode(options);

var cant_seguidores = <?=$user['cant_seguidores']?>;
var puntaje = <?=$user['puntaje']?>;

$('#input-rating').rating({'showCaption':false, showClear:false, 'stars':'5', 'min':'0', 'max':'5', 'step':'0.5', 'size':'xs', 'starCaptions': {0:'0', 1:'1', 2:'2', 3:'3', 4:'4', 5:'5'}});
</script>

</body>
</html>