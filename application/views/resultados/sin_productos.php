<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<style type="text/css">
  .contenedor-iframe{
    width: 960px;
    height: 540px;
    margin: auto;
    overflow: hidden;
    -webkit-box-shadow: 0px 5px 10px 0px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 5px 10px 0px rgba(0,0,0,0.75);
    box-shadow: 0px 5px 10px 0px rgba(0,0,0,0.75);
  }
  .contenedor-iframe .area-bloqueo{
    position: absolute;
    width: 100%;
    height: 100%;
    margin: auto;
    top: 0px;
    left: 0px;
    background: #FFFFFF;
    z-index:9999;
    opacity: 0;
  }
  iframe{
      zoom: 1;
      -moz-transform: scale(0.5);
      -moz-transform-origin: 0 0;
      -o-transform: scale(0.5);
      -o-transform-origin: 0 0;
      -webkit-transform: scale(0.5);
      -webkit-transform-origin: 0 0;
      margin: auto;
      width: 1920px;
      height: 1080px;
  }
</style>

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

			<div class="col-md-12 col-lg-6 col-lg-offset-3">

        <div id="area_primera_cargar">
          <p><?=mostrar_palabra(242, $palabras)?></p>
          <br>
          <div class='col-xs-6 btn-nuevo-gigante'>
            <a href='<?=site_url()?>productos/nuevo/<?=TP_DEMANDA?>' onmouseover='btn_demanda_hover()' onmouseout='btn_demanda_out()'>
              <img src='<?=base_url()?>images/demanda_gris.png' id='img_nueva_demanda' class='img-responsive'>
            </a><br>
            <a id='btn_nueva_demanda' href='<?=site_url()?>productos/nuevo/<?=TP_DEMANDA?>' class='btn btn-lg btn-verde' onmouseover='img_nueva_demanda.src="<?=base_url()?>images/demanda_verde.png"' onmouseout='img_nueva_demanda.src="<?=base_url()?>images/demanda_gris.png"'><i class='fa fa-plus-circle fa-2x hidden-xs pull-left flip'></i> <?=mostrar_palabra(24, $palabras)?></a>
          </div>

          <div class='col-xs-6 btn-nuevo-gigante'>
            <a href='<?=site_url()?>productos/nuevo/<?=TP_OFERTA?>' onmouseover='btn_oferta_hover()' onmouseout='btn_oferta_out()'>
              <img src='<?=base_url()?>images/oferta_gris.png' id='img_nueva_oferta' class='img-responsive'>
            </a><br>
            <a id='btn_nueva_oferta' href='<?=site_url()?>productos/nuevo/<?=TP_OFERTA?>' class='btn btn-lg btn-verde' onmouseover='img_nueva_oferta.src="<?=base_url()?>images/oferta_verde.png"' onmouseout='img_nueva_oferta.src="<?=base_url()?>images/oferta_gris.png"'><i class='fa fa-plus-circle fa-2x hidden-xs pull-left flip'></i> <?=mostrar_palabra(23, $palabras)?></a>
          </div>

          <div style="clear:both; margin-bottom:50px;"></div>
        </div>

      </div>
    </div>

    <div class="row">
      <div class="col-md-12 text-center">

        <?php
        //mostrar_palabra(279, $palabras);
        ?>
          <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <?php
              for($i=2; $i<7; $i++)
              {
                $active="";
                if($i==2)
                {
                  $active="active";
                }

                echo '<li data-target="#myCarousel" data-slide-to="'.($i-2).'" class="'.$active.'"></li>';
              }
              ?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
              <?php
              $texto_slide = array(0 => 119, 1 => 120, 2 => 121, 3 => 122, 4 => 123, 5 => 124, 6 => 125);
              $link_slide = array(0 => 119, 1 => 120, 2 => 'muestras/productos_index/'.TP_OFERTA, 3 => 'muestras/productos_nuevo/'.TP_DEMANDA, 4 => 'muestras/user_profile', 5 => 'muestras/resultados_index', 6 => 'muestras/estadisticas_index');
              for($i=2; $i<7; $i++)
              {
                $active="";
                if($i==2)
                {
                  $active="active";
                }

                echo '<div class="item '.$active.'" style="text-align:center;">';
                  //echo '<img src="'.base_url('assets/images/slides/D'.$i.'-'.$this->session->userdata('idi_code').'.png').'" alt="">';
                  echo '<div class="contenedor-iframe"><div class="area-bloqueo"></div><iframe src="'.site_url($link_slide[$i]).'" frameborder="0" allowfullscreen></iframe></div>';
                  echo '<div class="carousel-caption">';
                    echo '<!--<h3>Chania</h3>-->';
                    echo '<p>'.mostrar_palabra($texto_slide[$i], $palabras).'</p>';
                  echo '</div>';
                echo '</div>';
              }
              ?>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
              <i class="fas fa-chevron-left fa-2x" aria-hidden="true"></i>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
              <i class="fas fa-chevron-right fa-2x" aria-hidden="true"></i>
              <span class="sr-only">Next</span>
            </a>
          </div>

			</div>

		</div>
	</section>
	<!-- /Features -->

</main>


<?php
//$this->load->view('templates/menu_footer');
$this->load->view('templates/footer');
?>

<script type="text/javascript">
function btn_demanda_hover()
{
  $('#btn_nueva_demanda').addClass('btn-verde2');
  $('#img_nueva_demanda').attr('src',"<?=base_url()?>images/demanda_verde.png");
}

function btn_demanda_out()
{
  $('#btn_nueva_demanda').removeClass('btn-verde2');
  $('#img_nueva_demanda').attr('src',"<?=base_url()?>images/demanda_gris.png");
}

function btn_oferta_hover()
{
  $('#btn_nueva_oferta').addClass('btn-verde2');
  $('#img_nueva_oferta').attr('src',"<?=base_url()?>images/oferta_verde.png");
}

function btn_oferta_out()
{
  $('#btn_nueva_oferta').removeClass('btn-verde2');
  $('#img_nueva_oferta').attr('src',"<?=base_url()?>images/oferta_gris.png");
}
</script>

</body>
</html>