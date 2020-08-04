<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<body>

<!-- Header -->
<?php
$this->load->view('templates/analytics');
$this->load->view('muestras/templates/header');
?>
<!-- /Header -->
	
<?php
$this->load->view('muestras/templates/sidebar_left');
?>

<!-- Content -->
<main class="content">

	<!-- Features -->
	<section class="container-fluid">
		
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-danger">
				  <div class="panel-heading">
            <a class="pull-right flip texto_agregar" href="<?=site_url()?>productos/nuevo/<?=$tipo_producto['tp_id']?>" data-toggle="tooltip" data-placement="top" title="<?=$texto_agregar?>"><i class="fa fa-plus"></i></a>
				    <h3 class="panel-title"><?=$tipo_producto['tp_desc']?></h3>
				  </div>
				</div>

        <?php
            if($resultados)
            {
              foreach ($resultados as $key => $resultado)
              {
                echo '<div class="col-xs-12 col-md-6 panel resultado">';
                  echo '<div class="panel-body">';
                  echo '<div class="media" id="prod_'.$resultado['prod_id'].'">';
                    echo '<div class="media-right pull-right flip">';
                      echo '<div data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v fa-lg"></i></div>';
                      echo '<ul class="dropdown-menu dropdown-menu-right pull-right flip">';
                        echo "<li><a href='".site_url()."productos/edit/".$resultado['prod_id']."'>";
                          if($tipo_producto['tp_id'] == TP_OFERTA)
                          {
                            echo mostrar_palabra(33, $palabras);
                          }
                          else
                          {
                            echo mostrar_palabra(34, $palabras);
                          }
                        echo "</a></li>";
                        echo "<li><a href='".site_url()."productos/delete/".$resultado['prod_id']."'>".mostrar_palabra(234, $palabras)."</a></li>";
                        echo "<li role='separator' class='divider'></li>";
                        echo "<li><a onclick='CopyLink(".$resultado['prod_id'].")'>".mostrar_palabra(317, $palabras)."</a></li>";
                      echo '</ul>';
                      //echo "<a href='".site_url()."productos/delete/".$resultado['prod_id']."'><i class='fa fa-times-circle fa-2x'></i></a>";
                      //echo "<a href='".site_url()."productos/edit/".$resultado['prod_id']."'><i class='fa fa-pencil fa-2x'></i></a>";
                    echo '</div>';

                    echo '<div class="media-left" onclick="ver_producto('.$resultado['prod_id'].')" style="cursor:pointer;">';
                      $background = "";
                      $clase = "sin_imagen";
                      if($resultado['prod_imagen'])
                      {
                        $background = "background:url(".base_url("images/productos/".$resultado['prod_imagen'])."); background-size:cover;";
                        $clase = "con_imagen";
                      }
                      echo "<div class='media-object img-rounded ".$clase."' style='".$background."'>";
                      if($resultado['tp_id'] == 1)
                      {
                          echo "<img class='img-circle' src='".base_url()."images/oferta.png'>";
                      }
                      else
                      {
                          echo "<img class='img-circle' src='".base_url()."images/demanda.png'>";
                      }
                      echo "</div>";
                    echo '</div>';
                    
                    echo '<div class="media-body" onclick="ver_producto('.$resultado['prod_id'].')" style="cursor:pointer;">';
                      echo '<div class="cortar-texto-productos" style="font-weight:bold;">'.$resultado['prod_descripcion'].'</div>';
                      echo '<div class="cortar-texto-productos">'.$resultado['ara_desc'].'</div>';
                      echo '<small>';
                        if($resultado['cat_id'] >= 98)
                          echo '<b class="texto-bordo">'.$resultado['ara_code'].'</b> - '.mostrar_palabra(21, $palabras).' (HS)<br>';
                        else
                          echo '<b class="texto-bordo">'.$resultado['ara_code'].'</b> - '.mostrar_palabra(22, $palabras).'<br>';
                        echo "<img src='".base_url()."images/banderas/".$resultado['ctry_code'].".png'> ".$resultado['ctry_nombre'];
                          echo " (";
                            if($resultado['city_nombre'] == $resultado['toponymName'])
                            {
                              echo $resultado['city_nombre'];
                            }
                            else
                            {
                              echo $resultado['city_nombre']."/".$resultado['toponymName'];
                            }
                          echo ")";
                      echo '</small>';
                    echo '</div>';
                  echo '</div>';
                  echo '</div>';
                  echo '<div class="panel-footer">';
                    if($resultado['puntaje'] == null)
                    {
                      $resultado['puntaje'] = 0;
                    }
                    echo '<div class="col-xs-6 text-left flip">';
                      echo "<span>".$resultado['visitas']."</span> <i class='fa fa-eye fa-lg'></i>";
                      echo "<span style='color:#B2B2B2'> | </span>";
                      echo "<span>".$referencias_validadas['cant']."</span> <i class='icon-relacion' style='font-size:18px;'></i>";
                    echo '</div>';
                    echo '<div class="col-xs-6 text-right flip">';
                      echo '<div class="">';
                        echo "<span>".$resultado['puntaje']."</span> <i class='fa fa-star fa-lg'></i>";
                        echo "<span style='color:#B2B2B2'> / </span>";
                        echo "<span>".$resultado['cant_seguidores']."</span> <i class='fa fa-user fa-lg'></i>";
                      echo '</div>';
                    echo '</div>';
                    echo '<div style="clear:both"></div>';
                  echo '</div>';
                echo '</div>';
              }
            }
            else
            {
              if($tipo_producto['tp_id'] == TP_OFERTA)
              {
                echo mostrar_palabra(121, $palabras);
              }
              else
              {
                echo mostrar_palabra(122, $palabras);
              }
            }

        echo '<div style="clear:both"></div>';
        
        
        if(count($resultados) < 5 || $this->session->userdata('tu_id') == TU_PREMIUM)
        {
          echo '<a href="'.site_url().'productos/nuevo/'.$tipo_producto['tp_id'].'" class="btn-nuevo-producto texto_agregar" data-toggle="tooltip" data-placement="top" title="'.$texto_agregar.'"><i class="fa fa-plus fa-3x"></i></a>';
        }
        else
        {
          echo '<a href="javascript: abrir_modal_cinco();" class="btn-nuevo-producto texto_agregar" data-toggle="tooltip" data-placement="top" title="'.$texto_agregar.'"><i class="fa fa-plus fa-3x"></i></a>';
        }

        
        if(isset($matchs))
        {
          echo '<p style="margin-top:20px; text-align:center;">';
          if($matchs == 0)
          {
            echo mostrar_palabra(56, $palabras).' '.mostrar_palabra(243, $palabras);
          }
          else
          {
            echo '<a href="'.site_url('resultados').'">'.str_replace('X', $matchs, mostrar_palabra(344, $palabras)).'</a>';
          }
          echo '</p>';
        }
        ?>
			</div>

		</div>
	</section>
	<!-- /Features -->

</main>


<!-- Modal -->
<div class="modal fade" id="modal_more_than_five" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?=mostrar_palabra(566, $palabras)?></h4>
      </div>

      <form id="form_calificar" method="POST" action="#">
        <div class="modal-body">
          <?=str_replace('XXXX', '<a class="btn btn-danger" href="'.site_url('planes/premium').'">'.mostrar_palabra(535, $palabras).'</a>', mostrar_palabra(567, $palabras))?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(29, $palabras)?></button>
          <a href="<?=site_url('planes/premium')?>" class="btn btn-danger" id="btn_calificar"><?=mostrar_palabra(518, $palabras)?></a>
        </div>
      </form>

    </div>
  </div>
</div>


<?php
$this->load->view('templates/footer');
?>

<script type="text/javascript">
$('.texto_agregar').tooltip();

function ver_producto(id)
{
  location.href=SITE_URL+"productos/edit/"+id;
}

function CopyLink(id) {
  copyTextToClipboard(SITE_URL+"resultados/view/"+id);
}

/*
function ver_edit(id)
{
  $('#prod_'+id+' .media-right').show();
}

function sacar_edit(id)
{
  $('#prod_'+id+' .media-right').hide();
}
*/

function abrir_modal_cinco()
{
  $('#modal_more_than_five').modal('show');
}
</script>

</body>
</html>