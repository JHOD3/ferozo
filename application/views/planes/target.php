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
	<section class="container-fluid">
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h3 class="panel-title"><?=mostrar_palabra(505, $palabras)?></h3>
					</div>
				</div>
			</div>

		</div>
	</section>
	<!-- /Features -->

	<!-- Lead -->
	<section class="container-fluid">
		<div class="row space-after">
			<div class="col-md-12 col-lg-6">
				<div class="media">
				  <div class="media-left media-middle">
				    <img src="<?=base_url('assets/images/target2.png')?>" width="80px">
				  </div>
				  <div class="media-body texto-rojo">
				    <div class="media-heading" style="margin-top: 20px; font-family: 'Gotham-Bold'; font-size: 24px;"><?=mostrar_palabra(508, $palabras)?></div>
				  </div>
				</div>
			</div>
			<div class="col-md-12 col-lg-6 lead" style="font-size: 14px; font-family: 'Gotham-Light';">
				<?=mostrar_palabra(506, $palabras)?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-lg-6" style="font-family:'Gotham-Book'; font-size: 14px; color:#666666;">
				<?=nl2br(mostrar_palabra(510, $palabras))?>
				<br><br><br>
				<div id="resultado"></div>
				<button class="btn btn-danger" id="btn_contratar" onclick="contratar()"><?=nl2br(mostrar_palabra(518, $palabras))?></button>
				<a class="btn btn-default" href="<?=site_url('planes')?>"><?=nl2br(mostrar_palabra(7, $palabras))?></a>
			</div>
			<div class="col-md-12 col-lg-6 text-center" style="color: #666666; font-family:'Gotham-Book'; font-size: 17px;">
				<img src="<?=base_url('assets/images/ads4.jpg')?>" class="img-responsive" style="margin:auto;">
				<br>
				<?=mostrar_palabra(509, $palabras)?>
			</div>
		</div>
	</section>
	<!-- /Lead -->

</main>

<?php
$this->load->view('templates/footer');
?>

<script type="text/javascript">
function contratar()
{
	$('#resultado').html('');
	$('#btn_contratar').button('loading');

	$.ajax({
		url: SITE_URL+'planes/contratar_ajax',
		dataType: 'json',
		success: function(data) {
			location.href=SITE_URL+"<?=LINK_ADS?>/index.php/publicaciones/index/<?=TARGET_ADS?>";
			$('#btn_contratar').button('reset');
		},
		error: function(x, status, error){
			var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
			htmlData += "An error occurred: " + status + " nError: " + error;
			htmlData += '</div>';
			$('#resultado').html(htmlData);
			$('#btn_contratar').button('reset');
		}
	});
}
</script>

</body>
</html>