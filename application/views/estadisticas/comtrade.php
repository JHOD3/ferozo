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
				<div class="panel panel-danger">
				  <div class="panel-heading">
				    <h3 class="panel-title">
				    	<?=$title?>
				    </h3>
				  </div>
				</div>

				<?php
			    if($resultados)
			    {
					echo '<div class="panel">';
						echo '<div class="panel-body" style="padding: 0px;">';
				    
			              	echo "<table class='table table-striped' id='results'>";
				              echo "<tr>";
				                //echo "<th>".mostrar_palabra(22, $palabras)."</th>";
				                //echo "<th class='hidden-xs'><p>".mostrar_palabra(164, $palabras)."</p></th>";
				                $tit = str_replace('0.00', '', mostrar_palabra(197, $palabras));
				                $tit = str_replace('2014', $resultados[0]['comc_anio_ini'], $tit);
				                
				                $tit = str_replace('2014', $resultados[0]['comc_anio_fin'], mostrar_palabra(232, $palabras));
				                //echo "<th>$ ".mostrar_palabra(215, $palabras)."<br>".$tit."</th>";
				                //echo "<th>".str_replace("[XXX]", "%", mostrar_palabra(62, $palabras))." <br>".mostrar_palabra(66, $palabras)." ".$resultados[0]['comc_anio_ini']."-".$resultados[0]['comc_anio_fin']."</th>";
				              	echo "<th width='120px' style='text-align:center; background:#C8241B; border:none;'><i class='fa fa-code fa-2x'        data-toogle='tooltip' data-placement='bottom' title='".mostrar_palabra(22, $palabras)."'  style='color:#78081E;'></i></th>";
				              	echo "<th class='hidden-xs' style='text-align:center; background:#C8241B; border:none;'><i class='fa fa-align-left fa-2x'  data-toogle='tooltip' data-placement='bottom' title='".mostrar_palabra(164, $palabras)."' style='color:#78081E;'></i></th>";
				              	echo "<th style='text-align:center; background:#C8241B; border:none;'><i class='fa fa-dollar-sign fa-2x' data-toogle='tooltip' data-placement='bottom' title='".mostrar_palabra(215, $palabras)." ".$tit."' style='color:#78081E;'></i></th>";
				              	$title_th = str_replace("[XXX]", "%", mostrar_palabra(62, $palabras))." ".mostrar_palabra(66, $palabras)." ".$resultados[0]['comc_anio_ini']."-".$resultados[0]['comc_anio_fin'];
				              	echo "<th width='120px' style='text-align:center; background:#C8241B; border:none;'>
				              		<i class='fa fa-percent fa-2x' data-toogle='tooltip' data-placement='bottom' title='".$title_th."' style='color:#78081E;'></i>
				              		<i class='fa fa-signal fa-2x' data-toogle='tooltip' data-placement='bottom' title='".$title_th."' style='color:#78081E;'></i>
				              	</th>";
				              echo "</tr>";
			              	echo "</table>";

						echo '</div>';
					echo '</div>';
				}
				else
				{
					echo '<div class="panel">';
						echo '<div class="panel-body">';
							echo mostrar_palabra(56, $palabras);
						echo '</div>';
					echo '</div>';
				}
				?>

			  	<p id="loading" style="display:none;">
					<img src="<?=base_url('assets/images/loading.png')?>" alt="Loading…" width="50px;"/>
		        </p>

		        <br>
			  	<?=mostrar_palabra(215, $palabras)?>
			  	<br>
			  	<?=mostrar_palabra(152, $palabras)?>
				
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

$('th i').tooltip();
</script>

</body>
</html>