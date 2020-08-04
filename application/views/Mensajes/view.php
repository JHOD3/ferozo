<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<link href="<?=base_url()?>assets/css/mensajes.css" rel="stylesheet" id="theme" />

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
				    <h3 class="panel-title" style="padding:6px 0px;">CHAT - <?=$usuario['usr_apellido']?> <?=$usuario['usr_nombre']?></h3>
				  </div>
				  <div class="panel-body" style="padding:0px;">

            <div id="area-mensaje"></div>

            <form id="form_enviar" method="POST" style="margin-bottom:20px;">
              
              <div class="form-group">
                <label for="descripcion"><?=mostrar_palabra(294, $palabras)?></label>
                <textarea class="form-control" rows="3" id="descripcion" name="descripcion" placeholder="<?=mostrar_palabra(321, $palabras)?>"><?=$this->input->post('descripcion')?></textarea>
              </div>

              <button type="submit" class="btn btn-danger" id="btn_enviar">Enviar</button>

            </form>


                <!-- begin list-email -->
                    <ul class="list-group list-group-lg no-radius list-email" id="resultados">
                      <?php
                      foreach ($mensajes as $key => $mensaje)
                      {
                        $posicion = "";
                        if($mensaje['usr_id_emisor'] == $this->session->userdata('usr_id'))
                        {
                          $posicion = "right";
                        }
                        echo '<li class="list-group-item '.$posicion.'">
                            <!-- <div class="email-checkbox">
                                <label>
                                    <i class="fa fa-square-o"></i>
                                    <input type="checkbox" data-checked="email-checkbox" />
                                </label>
                            </div> -->
                            <a href="javascript:;" class="email-user">
                                <img src="'.base_url('images/usuarios/perfil.jpg').'" alt="" />
                            </a>
                            <div class="email-info">
                                <span class="email-time-view">'.$mensaje['msj_fecha'].'</span>
                                <p class="email-desc">'.nl2br($mensaje['msj_texto']).'</p>
                            </div>
                        </li>';
                      }
                      ?>
                    </ul>
                <!-- end list-email -->


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

$( "#form_enviar" ).submit(function( event ) {
  event.preventDefault();
  $('#area-mensaje').html('');
  $('#btn_enviar').button('loading');

  $.ajax({
      data: jQuery.param({emisor:<?=$this->session->userdata('usr_id')?>, receptor:<?=$usuario['usr_id']?>, mensaje: $('#descripcion').val()}),
      url: SITE_URL+'mensajes/enviar_ajax',
      dataType: 'json',
      method: 'POST',
      success: function(data) {
        if(data.error == false)
        {
          var htmlData = '';
          htmlData += '<li class="list-group-item right">';
              htmlData += '<a href="javascript:;" class="email-user">';
                  htmlData += '<img src="'+BASE_URL+'images/usuarios/perfil.jpg" alt="" />';
              htmlData += '</a>';
              htmlData += '<div class="email-info">';
                  htmlData += '<span class="email-time-view">Now</span>';
                  var textareaText = $('#descripcion').val();
                  textareaText = textareaText.replace(/\r?\n/g, '<br />');
                  htmlData += '<p class="email-desc">'+textareaText+'</p>';
              htmlData += '</div>';
          htmlData += '</li>';
          
          $( "#resultados" ).prepend( htmlData );

          var htmlData = '<div class="alert with-icon alert-success" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
          htmlData += data.data;
          htmlData += '</div>';
          $('#area-mensaje').html(htmlData);

          $('#descripcion').val('');
        }
        else
        {
          var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
          htmlData += data.data;
          htmlData += '</div>';
          $('#area-mensaje').html(htmlData);
        }
        
        $('#btn_enviar').button('reset');
        buscando = false;
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        
        $('#area-mensaje').html(htmlData);

        $('#btn_enviar').button('reset');
      }
    });
});
</script>

</body>
</html>