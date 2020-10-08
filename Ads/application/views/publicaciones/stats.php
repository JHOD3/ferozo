<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<?php
$this->load->view('templates/head');
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="<?=base_url()?>assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
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
			
			<div class="row">
            	<div class="col-md-12">
					<form class="form-inline" action="<?=site_url('publicaciones/stats/'.$item['ads_id'])?>" method="POST" style="margin-bottom:20px;">
	                  <label class="control-label"><?=ucfirst($palabras[61]['pal_desc'])?></label>
	                  <div class="input-group">
	                    <input type="text" class="form-control datepicker-autoClose <?php if(form_error('fecha_desde')) echo 'parsley-error'; ?>" placeholder="" name="fecha_desde" value="<?=formatear_fecha($fecha_desde,2)?>" />
	                  </div>
	                  <label class="control-label"> <?=$palabras[364]['pal_desc']?></label>
	                  <div class="input-group">
	                    <input type="text" class="form-control datepicker-autoClose <?php if(form_error('fecha_hasta')) echo 'parsley-error'; ?>" placeholder="" name="fecha_hasta" value="<?=formatear_fecha($fecha_hasta,2)?>" />
	                  </div>
	                  <select class="form-control" name="forma">
	                  	<option value="1" <?php if($forma == 1) echo "selected"; ?>>Dias</option>
	                  	<option value="2" <?php if($forma == 2) echo "selected"; ?>>Meses</option>
	                  	<option value="3" <?php if($forma == 3) echo "selected"; ?>>Años</option>
	                  </select>
	                  <button type="submit" class="btn btn-default"><?=$palabras[311]['pal_desc']?></button>
	              	</form>
              	</div>
            </div>

			<!-- begin row -->
			<div class="row">
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-blue">
						<div class="stats-icon"><i class="fas fa-print"></i></div>
						<div class="stats-info">
							<h4><?=strtoupper($palabras[365]['pal_desc'])?></h4>
							<p><?=$impresiones_totales['cant']?> <small>(USD <?=$impresiones_totales['consumo']?>)</small></p>	
						</div>
						<!--<div class="stats-link">
							<a href="javascript:;">Ver detalle <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>-->
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-green">
						<div class="stats-icon"><i class="fas fa-mouse-pointer"></i></div>
						<div class="stats-info">
							<h4><?=strtoupper($palabras[366]['pal_desc'])?></h4>
							<p><?=$clicks_totales['cant']?> <small>(USD <?=$clicks_totales['consumo']?>)</small></p>
						</div>
						<!--<div class="stats-link">
							<a href="javascript:;">Ver detalle <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>-->
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-red">
						<div class="stats-icon"><i class="fas fa-file-alt"></i></div>
						<div class="stats-info">
							<h4><?=strtoupper($palabras[367]['pal_desc'])?></h4>
							<p><?=$forms_totales['cant']?> <small>(USD <?=$forms_totales['consumo']?>)</small></p>	
						</div>
						<!--<div class="stats-link">
							<a href="javascript:;">Ver detalle <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>-->
					</div>
				</div>
				<!-- end col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-purple">
						<div class="stats-icon"><i class="fa fa-chain-broken"></i></div>
						<div class="stats-info">
							<h4>CONSUMO</h4>
							<p>USD <?=($impresiones_totales['consumo']+$clicks_totales['consumo']+$forms_totales['consumo'])?></p>	
						</div>
					</div>
				</div>
			</div>
			<!-- end row -->

			<!-- begin row -->
			<div class="row">
				<!-- begin col-8 -->
				<div class="col-md-12">
					<div class="panel panel-danger" data-sortable-id="index-1">
						<div class="panel-heading">
							<div class="panel-heading-btn">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-expand"><i class="fa fa-expand"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							</div>
							<h4 class="panel-title"><?=$palabras[143]['pal_desc']?></h4>
						</div>
						<div class="panel-body">
							<div id="interactive-chart" class="height-md"></div>
						</div>
					</div>
				</div>
				<!-- end col-8 -->
			</div>
			<!-- end row -->

			<!-- begin row -->
			<div class="row">
				<!-- begin col-8 -->
				<div class="col-md-6">
					<div class="panel panel-danger" data-sortable-id="index-2">
						<div class="panel-heading">
							<div class="panel-heading-btn">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-expand"><i class="fa fa-expand"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							</div>
							<h4 class="panel-title"><?=$palabras[205]['pal_desc']?></h4>
						</div>
						<div class="panel-body">
							<table class="table">
								<tr>
									<th><?=$palabras[2]['pal_desc']?></th>
									<th><?=$palabras[365]['pal_desc']?></th>
									<th><?=$palabras[366]['pal_desc']?></th>
									<th><?=$palabras[367]['pal_desc']?></th>
									<th>Consumo</th>
								</tr>
								<?php
								foreach ($paises as $key => $value)
								{
									echo '<tr>';
										echo '<td>'.$value['ctry_nombre'].'</td>';
										echo '<td>'.$value['impresiones'].'</td>';
										echo '<td>'.$value['clicks'].'</td>';
										echo '<td>'.$value['formularios'].'</td>';
										echo '<td>'.($value['impresiones_consumo']+$value['clicks_consumo']+$value['formularios_consumo']).'</td>';
									echo '</tr>';
								}
								?>
							</table>
						</div>
					</div>
				</div>
				<!-- end col-8 -->
			</div>
			<!-- end row -->

			<!--
			<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="EXVA393AKBD8J">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
			-->

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
	<script src="<?=base_url()?>assets/plugins/flot/jquery.flot.min.js"></script>
	<script src="<?=base_url()?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?=base_url()?>assets/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
<script>
var blue		= '#348fe2',
    blueLight	= '#5da5e8',
    blueDark	= '#1993E4',
    aqua		= '#49b6d6',
    aquaLight	= '#6dc5de',
    aquaDark	= '#3a92ab',
    green		= '#00acac',
    greenLight	= '#33bdbd',
    greenDark	= '#008a8a',
    orange		= '#f59c1a',
    orangeLight	= '#f7b048',
    orangeDark	= '#c47d15',
    dark		= '#2d353c',
    grey		= '#b6c2c9',
    purple		= '#727cb6',
    purpleLight	= '#8e96c5',
    purpleDark	= '#5b6392',
    red         = '#ff5b57';

var handleInteractiveChart = function () {
	"use strict";
    function showTooltip(x, y, contents) {
        $('<div id="tooltip" class="flot-tooltip">' + contents + '</div>').css( {
            top: y - 45,
            left: x - 55
        }).appendTo("body").fadeIn(200);
    }
	if ($('#interactive-chart').length !== 0) {
	
        var data1 = [ 
        	<?php
        	foreach ($meses as $key => $mes)
        	{
        		echo '['.$mes['id'].','.$mes['impresiones']['cant'].'],';
        	}
        	?>
        ];

        var data2 = [ 
        	<?php
        	foreach ($meses as $key => $mes)
        	{
        		echo '['.$mes['id'].','.$mes['clicks']['cant'].'],';
        	}
        	?>
        ];

        var data3 = [ 
        	<?php
        	foreach ($meses as $key => $mes)
        	{
        		echo '['.$mes['id'].','.$mes['forms']['cant'].'],';
        	}
        	?>
        ];
        /*
        var data2 = [
            [1, 10],  [2, 6], [3, 10], [4, 12], [5, 18], [6, 20], [7, 25], [8, 23], [9, 24], [10, 25], [11, 18], [12, 30]
        ];
        */
        var xLabel = [
        	<?php
        	foreach ($meses as $key => $mes)
        	{
        		echo '['.$mes['id'].',"'.$mes['mes'].'"],';
        	}
        	?>
        ];
        $.plot($("#interactive-chart"), [
                {
                    data: data1, 
                    label: "<?=$palabras[365]['pal_desc']?>", 
                    color: blue,
                    lines: { show: true, fill:false, lineWidth: 2 },
                    points: { show: true, radius: 3, fillColor: '#fff' },
                    shadowSize: 0
                }, {
                    data: data2,
                    label: "<?=$palabras[366]['pal_desc']?>",
                    color: green,
                    lines: { show: true, fill:false, lineWidth: 2 },
                    points: { show: true, radius: 3, fillColor: '#fff' },
                    shadowSize: 0
                }, {
                    data: data3,
                    label: "<?=$palabras[367]['pal_desc']?>",
                    color: red,
                    lines: { show: true, fill:false, lineWidth: 2 },
                    points: { show: true, radius: 3, fillColor: '#fff' },
                    shadowSize: 0
                }
            ], 
            {
                xaxis: {  ticks:xLabel, tickDecimals: 0, tickColor: '#ddd' },
                yaxis: {  ticks: 10, tickDecimals: 0, tickColor: '#ddd', min: 0, max: <?=$max?> },
                grid: { 
                    hoverable: true, 
                    clickable: true,
                    tickColor: "#ddd",
                    borderWidth: 1,
                    backgroundColor: '#fff',
                    borderColor: '#ddd'
                },
                legend: {
                    labelBoxBorderColor: '#ddd',
                    margin: 10,
                    noColumns: 1,
                    show: true
                }
            }
        );
        var previousPoint = null;
        $("#interactive-chart").bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint !== item.dataIndex) {
                    previousPoint = item.dataIndex;
                    $("#tooltip").remove();
                    var y = item.datapoint[1].toFixed(2);
                    
                    var content = item.series.label + " " + y;
                    showTooltip(item.pageX, item.pageY, content);
                }
            } else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
            event.preventDefault();
        });
    }
};

$(document).ready(function() {
	handleInteractiveChart();
});


$('.datepicker-autoClose').datepicker({
    todayHighlight: true,
    autoclose: true,
    format: 'dd-mm-yyyy',
    language: 'es'
});
</script>

</body>
</html>
