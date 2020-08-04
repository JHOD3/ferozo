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
	<section class="container-fluid estadisticas">
		
		<div class="row">

			<div class="col-md-12">
        <div class="panel panel-danger" id="area-mayor-actividad">
          <div class="panel-heading">
            <h3 class="panel-title"><?=mostrar_palabra(240, $palabras)?></h3>
          </div>
        </div>
      </div>

      <?php
        echo '<div class="col-md-6">';
          echo '<div class="panel">';
            echo '<div class="panel-body">';
            if($principales_demandas)
            {
              echo "<span class='panel-title'>".mostrar_palabra(20, $palabras)."</span><br>";
              echo "<small>";
              foreach ($principales_demandas as $key => $oferta)
              {
                //echo "<b>".$oferta['ara_code']."</b> - ".cortarTexto($oferta['ara_desc'],110)."<br>";
                echo "<div class='cortar-texto' ><span class='badge'>".$oferta['cant']."</span> - <b class='texto-bordo'>".$oferta['ara_code']."</b> - ".$oferta['ara_desc']."</div>";
              }
              echo "</small>";
              echo "<a class='btn btn-default btn-block' style='margin-top:5px;' href='".site_url('estadisticas/productos/'.TP_DEMANDA)."'>".mostrar_palabra(151, $palabras)."</a>";
            }
            echo '</div>';
          echo '</div>';
        echo '</div>';
          
        echo '<div class="col-md-6">';
          echo '<div class="panel">';
            echo '<div class="panel-body">';
            if($principales_ofertas)
            {
              echo "<span class='panel-title'>".mostrar_palabra(19, $palabras)."</span><br>";
              echo "<small>";
              foreach ($principales_ofertas as $key => $oferta)
              {
                //echo "<b>".$oferta['ara_code']."</b> - ".cortarTexto($oferta['ara_desc'],110)."<br>";
                echo "<div class='cortar-texto' ><span class='badge'>".$oferta['cant']."</span> - <b class='texto-bordo'>".$oferta['ara_code']."</b> - ".$oferta['ara_desc']."</div>";
              }
              echo "</small>";
              echo "<a class='btn btn-default btn-block' style='margin-top:5px;' href='".site_url('estadisticas/productos/'.TP_OFERTA)."'>".mostrar_palabra(151, $palabras)."</a>";
            }
            echo '</div>';
          echo '</div>';
        ?>
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

$(document).ready(function() {
  var win = $(window);

  // Each time the user scrolls
  win.scroll(function() {
    if(!buscando)
    {
      if(($(document).height() - win.height() - 10) <= win.scrollTop() && !fin)
      {
        buscando = true;
        buscar();
      }
    }
  });

  buscar();
});

function buscar()
{
  $('#loading').show();
  
    $.ajax({
      url: SITE_URL+'estadisticas/buscar_generales_ajax/<?=$ctry_code_origen?>/<?=$ctry_code_destino?>/<?=$tipo?>/'+offset+'/'+limit,
      dataType: 'json',
      success: function(data) {
        if(data.cant == 0)
        {
          fin = true;
          if(offset == 0)
          {
            $('#results').append("<?=mostrar_palabra(56, $palabras)?>");
          }
        }
        else
        {
          if(data.cant < limit)
          {
            fin = true;
          }
          offset += data.cant;

          var htmlData = "";
          $.each(data.result, function(i, item) {
            htmlData += "<tr>";
              htmlData += "<td>"+item.ara_code+"</td>";
              htmlData += "<td class='hidden-xs'><p>"+item.ara_desc+"</p></td>";

              var valor = item.comc_valor_fin;

              htmlData += "<td>"+valor+"</td>";
              htmlData += "<td>"+item.comc_porcentaje+"</td>";
            htmlData += "</tr>";
          });

          $("#results").append(htmlData);
        }
        $('#loading').hide();
        buscando = false;
      },
      error: function(x, status, error){
            //alert("An error occurred: " + status + " nError: " + error);
        }
    });
}
</script>

</body>
</html>