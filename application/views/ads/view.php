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
              <h3 class="panel-title" style="margin-top:2px;"><?=$producto['ads_titulo']?></h3>
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
                        echo '<div '.$active.'><img src="'.base_url('images/ads/'.$imagen['ads_img_ruta']).'" alt="imagen_'.$key.'"></div>';
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

                echo "<br>";
                echo $producto['ads_texto']."<br>";
                echo "<br>";
                echo "<br>";
                //echo '<a href="javascript: post_click('.$producto['ads_id'].',\''.$producto['ads_link'].'\');" target="_blank">'.$producto['ads_link']."</a><br>";
                echo '<a href="'.addhttp($producto['ads_link']).'" target="_blank" onclick="post_click('.$producto['ads_id'].', \'\')">'.$producto['ads_link']."</a><br>";

                if($producto['ads_forms'] == 1)
                {
                  echo "<br>";
                  echo '<button type="button" class="btn btn-danger btn-block" onclick="abrir_form()">'.mostrar_palabra(38, $palabras).'</button>';
                }
                ?>

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
        <h4 class="modal-title"><?=mostrar_palabra(38, $palabras)?></h4>
      </div>

      <form id="form_calificar" method="POST" action="#">
        <div class="modal-body">
          <div id="mensaje_calificar"></div>
          <input type="hidden" value="<?=$producto['ads_id']?>" name="ads_id" id="ads_id">

          <div id="area_form">
            <div class="form-group <?php if(form_error('nombre')) echo 'has-error';?>">
              <label for="calificar_nombre"><?=mostrar_palabra(11, $palabras)?></label>
              <input type="text" class="form-control" value="<?=$this->session->userdata('usr_nombre')?>" name="nombre" id="calificar_nombre">
            </div>
            <div class="form-group <?php if(form_error('mail')) echo 'has-error';?>">
              <label for="calificar_mail"><?=mostrar_palabra(4, $palabras)?></label>
              <input type="text" class="form-control" value="<?=$this->session->userdata('usr_mail')?>" name="mail" id="calificar_mail">
            </div>
            <div class="form-group <?php if(form_error('telefono')) echo 'has-error';?>">
              <label for="calificar_telefono"><?=mostrar_palabra(133, $palabras)?></label>
              <input type="text" class="form-control" value="" name="telefono" id="calificar_telefono">
            </div>
            <div class="form-group <?php if(form_error('consulta')) echo 'has-error';?>">
              <label for="calificar_consulta"><?=mostrar_palabra(347, $palabras)?></label>
              <textarea class="form-control" name="consulta" id="calificar_consulta" rows="3"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(29, $palabras)?></button>
          <button type="submit" class="btn btn-danger" id="btn_calificar"><?=mostrar_palabra(316, $palabras)?></button>
        </div>
      </form>

    </div>
  </div>
</div>


<?php
$this->load->view('templates/footer');
?>

<script type="text/javascript">
$( "#form_calificar" ).submit(function( event ) {
  event.preventDefault();
  $("#mensaje_calificar").html("");
  $('#btn_calificar').button('loading');
  $.ajax({
     type: 'post',
     dataType: "json",
     data: $(event.target).serialize(),
     cache: false,
     url: SITE_URL+"ads/set_form_ajax",
     success: function(data){
        if(data.error == false)
        {
          var htmlData = '<div class="alert with-icon alert-success" role="alert"> ';
          htmlData += data.data;
          htmlData += '</div>';
          $("#mensaje_calificar").html(htmlData);

          $('#area_form').hide();
          $('#btn_calificar').hide();
          setTimeout(function(){ cerrar_form(); }, 2000);
        }
        else
        {
          var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
          htmlData += data.data;
          htmlData += '</div>';
          $("#mensaje_calificar").html(htmlData);
        }
        $('#btn_calificar').button('reset');
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        $("#mensaje_calificar").html(htmlData);
        $('#btn_calificar').button('reset');
      }
  });
});

function abrir_form()
{
  $('#area_form').show();
  $('#btn_calificar').show();
  $('#modal_calificar').modal('show');
  $("#mensaje_calificar").html('');
}

function cerrar_form()
{
  $('#modal_calificar').modal('hide');
}

function post_click(id, link) {
    $.ajax({
      type: 'POST',
      url: SITE_URL+'ads/set_ads_click_ajax',
      dataType: 'json',
      data: jQuery.param({ads_id: id}),
      success: function(data) {
        //location.href = link;
        //window.open(link,'_blank')
      },
      error: function(x, status, error){
        //alert("An error occurred: " + status + " nError: " + error);
      }
    });
}
</script>

</body>
</html>