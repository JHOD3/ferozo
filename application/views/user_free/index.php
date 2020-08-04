<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<body>

<!-- Header -->
<?php
$this->load->view('templates/analytics');
$this->load->view('pages/header2');
?>
<!-- /Header -->
	

<!-- Content -->
<main class="">

	<!-- Features -->
	<section class="container">
		
		<div class="row fondo-derecha">
			<div class="col-md-12 col-lg-6">
				<div class="panel panel-danger">
				  <div class="panel-heading">
            <div class="pull-right flip" id="favorito" style="margin-top:-5px;"></div>
				    <h3 class="panel-title"><?=mostrar_palabra(38, $palabras)?></h3>
            <div class="area-estrellas" style="display:none;">
              <input id='input-rating' name='input-rating' type='number' min='0' max='5' step='0.5' data-size='xs' data-default-caption='{rating} hearts' data-star-captions='{012345}' onchange="marcar_favorito()">
            </div>
				  </div>
				  <div class="panel-body">

              <div class="form-group col-xs-12 col-sm-6">
                <div id="preview">
                <?php
                  echo "<img id='img_user' src='".base_url()."images/usuarios/".$user['usr_imagen']."' class='img-circle img-user'>";
                ?>
                </div>
              </div>

              <div class="form-group col-xs-12 col-sm-6" style="text-align:center;">
                <div id="qr"></div>
              </div>

              <div style="clear:both;"></div>
              <?php
              echo '<small>'.mostrar_palabra(4, $palabras).'</small><br>';
              echo '<span style="color:#e0103a; -moz-user-select: none; -webkit-user-select: none; -ms-user-select:none; user-select:none;-o-user-select:none;" unselectable="on" onselectstart="return false;" onmousedown="return false;">'.$user['usr_mail']."</span><button class='btn btn-link' data-toggle='tooltip' data-placement='top' title='".mostrar_palabra(317, $palabras)."' onclick='post_click_contacto(null,".$user['usr_id'].",\"".$user['usr_mail']."\",\"mail\")'><i class='fas fa-copy'></i></button><br>";
              ?>

              <small><?=mostrar_palabra(3, $palabras)?></small><br>
              <?=$user['idi_desc']?><br>

              <?php
              echo "<small>".mostrar_palabra(219, $palabras)."</small><br>";
              echo interval_date($user['usr_ult_acceso'], date('Y-m-d H:i:s'))."<br>";

              echo "<br>";
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
                $color_visto = "no-visto";

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
                      if($resultado['cat_code'] == "00")
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

<?php
$this->load->view('templates/footer');
?>

<script src="<?=base_url()?>assets/js/jquery-qrcode-0.14.0.min.js"></script>

<script type="text/javascript">
$('.btn-link').tooltip();

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
</script>

</body>
</html>