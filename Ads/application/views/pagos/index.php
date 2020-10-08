<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<?php
$this->load->view('templates/head');
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="<?=base_url()?>assets/plugins/DataTables/css/data-table.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<body>
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<?php
		$this->load->view('templates/header');
		$this->load->view('templates/menu');
		?>
		
		<!-- begin #content -->
        <div id="content" class="content">
            <?php
            $this->load->view('templates/title');
            ?>
            
            <!-- begin row -->
            <div class="row">
                <!-- begin col-12 -->
                <div class="col-md-3">
                  <div class="widget widget-stats bg-green">
                    <div class="stats-icon"><i class="fas fa-credit-card"></i></div>
                    <div class="stats-info">
                      <h4><?=ucfirst(mostrar_palabra(531, $palabras))?></h4>
                      <p>USD <?=number_format($saldo['saldo'],2)?></p>  
                    </div>
                    <div class="stats-link">
                      <a href="<?=site_url('pagos/checkout_ads/'.PAGO_DESTINO_ADS)?>"><?=mostrar_palabra(532, $palabras)?> <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
                  </div>
                </div>
                <!-- end col-12 -->
                <?php
                  echo '<!-- begin col-12 -->
                  <div class="col-md-3">
                    <div class="widget widget-stats bg-yellow-darker">
                      <div class="stats-icon"><i class="fas fa-user-graduate"></i></div>
                      <div class="stats-info">
                        <h4>'.ucfirst(mostrar_palabra(514, $palabras)).'</h4>';
                        if($suscripcion)
                        {
                          echo '<p>'.ucfirst(mostrar_palabra(533, $palabras)).'</p>';
                        }
                        else
                        {
                          echo '<p>'.ucfirst(mostrar_palabra(534, $palabras)).'</p>';
                        }
                      echo '</div>
                      <div class="stats-link">
                        <a href="'.site_url('pagos/checkout_ads/'.PAGO_DESTINO_PREMIUM_USER).'">'.mostrar_palabra(532, $palabras).' <i class="fa fa-arrow-circle-o-right"></i></a>
                      </div>
                    </div>
                  </div>
                  <!-- end col-12 -->';
                ?>
            </div>
            <!-- end row -->

            <!-- begin row -->
            <div class="row">
                <!-- begin col-12 -->
                <div class="col-md-6">
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?=ucfirst(mostrar_palabra(535, $palabras))?></h4>
                        </div>
                        <div class="panel-body">
                          <table class="table table-striped">
                            <?php
                            echo '<tr>';
                              echo '<th>'.mostrar_palabra(400, $palabras).'</th>';
                              echo '<th style="text-align:center;">'.ucfirst(mostrar_palabra(537, $palabras)).'</th>';
                              echo '<th style="text-align:right;">'.mostrar_palabra(555, $palabras).' (USD)</th>';
                            echo '</tr>';
                            foreach ($pagos as $key => $value)
                            {
                              echo '<tr>';
                                echo '<td>'.substr($value['pago_fecha'],0,10).'</td>';
                                echo '<td align="center">'.$value['pago_est_descripcion'].'</td>';
                                echo '<td align="right">$ '.number_format($value['pago_cantidad'],2).'</td>';
                              echo '</tr>';
                            }
                            ?>
                          </table>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->

                <!-- begin col-12 -->
                <div class="col-md-6">
                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?=ucfirst(mostrar_palabra(538, $palabras))?></h4>
                        </div>
                        <div class="panel-body">
                          <table class="table table-striped">
                            <?php
                            echo '<tr>';
                              echo '<th>'.mostrar_palabra(400, $palabras).'</th>';
                              echo '<th style="text-align:center;">'.ucfirst(mostrar_palabra(539, $palabras)).'</th>';
                              echo '<th style="text-align:right;">'.ucfirst(mostrar_palabra(536, $palabras)).' (USD)</th>';
                              echo '<th></th>';
                            echo '</tr>';
                            foreach ($facturas as $key => $value)
                            {
                              echo '<tr>';
                                echo '<td>'.substr($value['fac_fecha'],0,10).'</td>';
                                echo '<td align="center">'.$value['fac_cae'].'</td>';
                                echo '<td align="right">$ '.number_format($value['fac_total'],2).'</td>';
                                //echo '<td align="right"><a href="'.site_url('pagos/factura/'.$value['fac_id']).'" target="_blank" class="btn btn-xs btn-inverse"><i class="fas fa-eye"></i></a></td>';
                                echo '<td align="right"><a href="'.base_url('assets/facturas/FACT-00002-00000008.pdf').'" target="_blank" class="btn btn-xs btn-inverse"><i class="fas fa-eye"></i></a></td>';
                              echo '</tr>';
                            }
                            ?>
                          </table>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->
            </div>
            <!-- end row -->
        </div>
        <!-- end #content -->
		
		<?php
		$this->load->view('templates/footer');
		?>
	</div>
	<!-- end page container -->
	
	<?php
	$this->load->view('templates/scripts');
	?>
	
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="<?=base_url()?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    
    <script>
    $(document).ready(function() {
        if ($('#data-table').length !== 0) {
            $('#data-table').DataTable({
                "language": {
                    "sSearch": "<?=mostrar_palabra(36, $palabras)?>"
                }
            });
        }
    });
    </script>

</body>
</html>
