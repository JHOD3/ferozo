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
				    <?=$title2?>
				  </div>
				</div>

				<div class="panel">
				  <div class="panel-body" style="padding: 0px;">
				    <?php
				    if($resultados)
				    {
		              echo "<table class='table table-striped' id='results'>";
		              echo "<tr>";
		                echo "<th width='120px' style='text-align:center; background:#C8241B; border:none;'><i class='fa fa-code fa-2x'            data-toogle='tooltip' data-placement='bottom' title='".mostrar_palabra(22, $palabras)."'  style='color:#78081E;'></i></th>";
		                echo "<th class='hidden-xs' style='text-align:center; background:#C8241B; border:none;'><i class='fa fa-align-left fa-2x'      data-toogle='tooltip' data-placement='bottom' title='".mostrar_palabra(164, $palabras)."' style='color:#78081E;'></i></th>";
		                echo "<th width='120px' style='text-align:center; background:#C8241B; border:none;'><i class='fab fa-stack-overflow fa-2x' data-toogle='tooltip' data-placement='bottom' title='".mostrar_palabra(249, $palabras)."' style='color:#78081E;'></i></th>";
		              echo "</tr>";
		              
		              foreach ($resultados as $key => $resultado)
		              {
		                echo "<tr>";
		                  echo "<td>".$resultado['ara_code']."</td>";
		                  echo "<td class='hidden-xs'><p>".$resultado['ara_desc']."</p></td>";

		                  echo "<td>".$resultado['cant']."</td>";
		                echo "</tr>";
		              }
		              
		              echo "</table>";
  					}
  					else
  					{
  						echo mostrar_palabra(56, $palabras);
  					}
				    ?>
				  </div>
				  
				</div>
			</div>
			<?php
			//$this->load->view('templates/sidebar_right');
			?>
		</div>
	</section>
	<!-- /Features -->

</main>

<?php
$this->load->view('templates/footer');
?>

<script type="text/javascript">
$('th i').tooltip();
</script>

</body>
</html>