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
            <div class="media" style="border:none; padding-bottom:0px; overflow: visible;">
              <div class="media-left">
                <?php
                if($foro['usr_imagen'])
                {
                  echo '<img src="'.base_url('images/usuarios/'.$foro['usr_imagen']).'" class="img-circle img-user" width="40px" style="float:left;">';
                }
                else
                {
                  echo '<img src="'.base_url('images/usuarios/perfil.jpg').'" class="img-circle img-user" width="40px" style="float:left;">';
                }
                ?>
              </div>
              <div class="media-body">
                <h3 class="panel-title" style="padding:5px;">
                  <?php
                  echo '<a href="'.site_url('user/view/'.$foro['usr_id']).'" style="font-size:14px;">'.$foro['usr_mail'].'</a><br>';
                  echo '<small>'.$foro['foro_fecha'].'</small>';
                  ?>
                </h3>
              </div>
              <div class="media-right" style="position:relative; z-index:999;">
                <div data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer;"><i class="fa fa-ellipsis-v fa-lg"></i></div>
                <ul class="dropdown-menu dropdown-menu-right pull-right flip" style="margin-top:-20px;">
                  <li><a onclick='CopyLink(<?=$foro['foro_id']?>)' style="color:#000; font-size:14px;"><?=mostrar_palabra(317, $palabras)?></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="panel">
          <div class="panel-body">
              <?php
              //echo "<small>".mostrar_palabra(272, $palabras)."</small><br>";
              echo nl2br($foro['foro_descripcion'])."<br><br>";

              if($foro['cat_code'])
              {
                echo '<small class="texto-bordo">';
                  if($foro['cat_code'] == "00")
                    echo '<b>'.$foro['ara_code'].'</b> - '.mostrar_palabra(21, $palabras).'<br>';
                  else
                    echo '<b>'.$foro['ara_code'].'</b> - '.mostrar_palabra(22, $palabras).'<br>';
                echo '</small>';
                echo $foro['ara_desc'].'<br><br>';
              }

              if($foro['ctry_code'])
              {
                //echo "<small>".mostrar_palabra(2, $palabras)."</small><br>";
                echo "<small><img src='".base_url("images/banderas/".$foro['ctry_code'].".png")."'> ".$foro['ctry_nombre']."</small><br>";
              }
              echo '<br>';
              echo mostrar_traducir($foro['idi_code'], $this->session->userdata('idi_code'), $foro['foro_descripcion'], mostrar_palabra(39, $palabras));
              ?>
          </div>
        </div>

        <div class="panel panel-danger">
          <div class="panel-heading">
            <h3 class="panel-title"><?=mostrar_palabra(207, $palabras)?></h3>
          </div>
        </div>

        <div class="panel">
          <div class="panel-body">
              <form action="<?=site_url()?><?=$solapa?>/view/<?=$foro['foro_id']?>" method="POST">
                <div class="form-group <?php if(form_error('comentario')) echo 'has-error';?>">
                  <?php echo form_error('comentario'); ?>
                  <textarea class="form-control" rows="3" id="comentario" name="comentario"></textarea>
                </div>

                <button type="submit" class="btn btn-danger"><?=mostrar_palabra(208, $palabras)?></button>
              </form>
          </div>
        </div>

        <div class="panel">
          <div class="panel-body">
              <?php
              foreach ($mensajes as $key => $mensaje)
              {
                echo '<div class="media" style="position:relative;">
                  <div class="media-left">
                    <a href="'.site_url().'user/view/'.$mensaje['usr_id'].'">';
                      if($mensaje['usr_imagen'])
                      {
                        echo '<img class="media-object img-circle" src="'.base_url().'images/usuarios/'.$mensaje['usr_imagen'].'" width="40px">';
                      }
                      else
                      {
                        echo '<img class="media-object img-circle" src="'.base_url().'images/usuarios/perfil.jpg" width="40px">';
                      }
                    echo '</a>';
                  echo '</div>';

                  echo '<div class="media-body">';
                    echo '<strong class="media-heading">';
                      echo '<a href="'.site_url().'user/view/'.$mensaje['usr_id'].'">'.$mensaje['usr_mail'].'</a>';
                    echo '</strong><br>';
                    echo '<small>'.$mensaje['forom_fecha'].'</small><br>';
                  echo '</div>';

                  echo '<div class="media-right">';
                    echo '<div data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer;"><i class="fa fa-ellipsis-v"></i></div>';
                    echo '<ul class="dropdown-menu dropdown-menu-right pull-right flip" style="margin-top:-42px; margin-right:10px;">';
                      if($mensaje['idi_code'] != $this->session->userdata('idi_code'))
                      {
                        echo "<li>";
                          echo mostrar_traducir($mensaje['idi_code'], $this->session->userdata('idi_code'), $mensaje['forom_descripcion'], mostrar_palabra(39, $palabras));
                        echo "</li>";
                      }
                      //echo "<li role='separator' class='divider'></li>";
                      echo "<li><a href='javascript: reportar(".$mensaje['forom_id'].");'>".mostrar_palabra(328, $palabras)."</a></li>";
                    echo '</ul>';
                  echo '</div>';

                  echo nl2br($mensaje['forom_descripcion']).'<br>';
                echo '</div>';
              }

              echo "<br>";
              ?>

          </div>
        </div>
      </div>

		</div>
	</section>
	<!-- /Features -->

</main>


<!-- Modal -->
<div class="modal fade" id="modal_mensaje_reportar" tabindex="-1" role="dialog" aria-labelledby="modal_reportar_texto-label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal_reportar_texto-label"><?=mostrar_palabra(330, $palabras)?></h4>
      </div>
      <div class="modal-body">
        <div id="modal_mensaje_reportar_texto"></div>
        <div style="clear:both;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(284, $palabras)?></button>
      </div>
    </div>
  </div>
</div>


<?php
$this->load->view('templates/footer');
?>

<script type="text/javascript">
function CopyLink(id) {
  copyTextToClipboard(SITE_URL+"foro/view/"+id);
}

function reportar(id)
{
  $.ajax({
     type: 'post',
     dataType: "json",
     data: jQuery.param({tipo_id:6, descripcion:"", pal_id:id}),
     cache: false,
     url: SITE_URL+"errores/grabar_error_ajax",
     success: function(data){
        if(data.error == false)
        {
          var htmlData = '<div class="alert with-icon alert-success" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
          htmlData += data.data;
          htmlData += '</div>';
          $("#modal_mensaje_reportar_texto").html(htmlData);
          $("#modal_mensaje_reportar").modal('show');
        }
        else
        {
          var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
          htmlData += data.data;
          htmlData += '</div>';
          $("#modal_mensaje_reportar_texto").html(htmlData);
          $("#modal_mensaje_reportar").modal('show');
        }
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        $("#modal_mensaje_reportar_texto").html(htmlData);
        $("#modal_mensaje_reportar").modal('show');
      }
  });
}
</script>

</body>
</html>