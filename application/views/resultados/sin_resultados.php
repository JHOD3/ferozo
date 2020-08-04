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

			<div class="col-md-12 col-lg-6 col-lg-offset-3">

        <div id="area_botones_cargar">
          <p><?=mostrar_palabra(56, $palabras)?> <?=mostrar_palabra(243, $palabras)?></p>
          <div class='col-xs-6 btn-nuevo-gigante'>
            <a href='<?=site_url()?>productos/nuevo/<?=TP_DEMANDA?>' onmouseover='btn_demanda_hover2()' onmouseout='btn_demanda_out2()'>
              <img src='<?=base_url()?>images/demanda_gris.png' id='img_nueva_demanda2' class='img-responsive'>
            </a><br>
            <a id='btn_nueva_demanda2' href='<?=site_url()?>productos/nuevo/<?=TP_DEMANDA?>' class='btn btn-lg btn-rojo' onmouseover='btn_demanda_hover2()' onmouseout='btn_demanda_out2()'><i class='fa fa-plus-circle fa-2x hidden-xs pull-left flip'></i> <?=mostrar_palabra(24, $palabras)?></a>
          </div>

          <div class='col-xs-6 btn-nuevo-gigante'>
            <a href='<?=site_url()?>productos/nuevo/<?=TP_OFERTA?>' onmouseover='btn_oferta_hover2()' onmouseout='btn_oferta_out2()'>
              <img src='<?=base_url()?>images/oferta_gris.png' id='img_nueva_oferta2' class='img-responsive'>
            </a><br>
            <a id='btn_nueva_oferta2' href='<?=site_url()?>productos/nuevo/<?=TP_OFERTA?>' class='btn btn-lg btn-rojo' onmouseover='btn_oferta_hover2()' onmouseout='btn_oferta_out2()'><i class='fa fa-plus-circle fa-2x hidden-xs pull-left flip'></i> <?=mostrar_palabra(23, $palabras)?></a>
          </div>

          <div style="clear:both; margin-bottom:20px;"></div>
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
function btn_demanda_hover2()
{
  $('#btn_nueva_demanda2').addClass('btn-rojo2');
  $('#img_nueva_demanda2').attr('src',"<?=base_url()?>images/demanda.png");
}

function btn_demanda_out2()
{
  $('#btn_nueva_demanda2').removeClass('btn-rojo2');
  $('#img_nueva_demanda2').attr('src',"<?=base_url()?>images/demanda_gris.png");
}

function btn_oferta_hover2()
{
  $('#btn_nueva_oferta2').addClass('btn-rojo2');
  $('#img_nueva_oferta2').attr('src',"<?=base_url()?>images/oferta.png");
}

function btn_oferta_out2()
{
  $('#btn_nueva_oferta2').removeClass('btn-rojo2');
  $('#img_nueva_oferta2').attr('src',"<?=base_url()?>images/oferta_gris.png");
}
</script>

</body>
</html>