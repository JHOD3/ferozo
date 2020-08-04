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
	<section class="container-fluid estadisticas">
		
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-danger">
			    	<?php
			    	echo '<div class="panel-heading" style="text-transform: uppercase;">';
			    		echo '<h3 class="panel-title">';
			    			echo mostrar_palabra(57, $palabras).'<br>';
			    		echo '</h3>';
			    		echo $pais['ctry_nombre'];
			    	echo '</div>';
            ?>
        </div>
      </div>
        
      <?php
      if($principales_ofertas)
      {
        echo '<div class="col-md-6">';
          echo '<div class="panel">';
			    	echo '<div class="panel-body">';
				    	
				    		echo "<span class='panel-title'>".mostrar_palabra(145, $palabras)."</span><br>";
					    	echo "<small>";
					    	foreach ($principales_ofertas as $key => $oferta)
					    	{
					    		//echo "<b>".$oferta['ara_code']."</b> - ".cortarTexto($oferta['ara_desc'],110)."<br>";
					    		echo "<div class='cortar-texto' ><b class='texto-bordo'>".$oferta['ara_code']."</b> - ".$oferta['ara_desc']."</div>";
					    	}
					    	echo "</small>";
					    	echo "<a class='btn btn-default btn-block' style='margin-top:5px;' href='".site_url("estadisticas/comtrade/".$pais['ctry_code']."/WLD/2")."'>".mostrar_palabra(151, $palabras)."</a>";
				    	
            echo '</div>';
          echo '</div>';
        echo '</div>';
			}

      if($principales_demandas)
      {
        echo '<div class="col-md-6">';
          echo '<div class="panel">';
            echo '<div class="panel-body">';
              
                echo "<span class='panel-title'>".mostrar_palabra(148, $palabras)."</span><br>";
                echo "<small>";
                foreach ($principales_demandas as $key => $demanda)
                {
                  //echo "<b>".$demanda['ara_code']."</b> - ".cortarTexto($demanda['ara_desc'],110)."<br>";
                  echo "<div class='cortar-texto' ><b class='texto-bordo'>".$demanda['ara_code']."</b> - ".$demanda['ara_desc']."</div>";
                }
                echo "</small>";
                echo "<a class='btn btn-default btn-block' style='margin-top:5px;' href='".site_url("estadisticas/comtrade/".$pais['ctry_code']."/WLD/1")."'>".mostrar_palabra(151, $palabras)."</a>";
              
            echo '</div>';
          echo '</div>';
        echo '</div>';
      }

      if(!$principales_ofertas && !$principales_demandas)
      {
        echo '<div class="col-md-12">';
          echo '<div class="panel">';
            echo '<div class="panel-body">';

                echo mostrar_palabra(233, $palabras);

            echo '</div>';
          echo '</div>';
        echo '</div>';
      }

      echo '<div class="col-md-12">';
        echo mostrar_palabra(152, $palabras);
      echo '</div>';
			?>
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