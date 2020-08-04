<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<body>

<?php
$this->load->view('templates/analytics');
$this->load->view('pages/header2');
?>
	

<!-- Content -->
<main class="">

	<!-- Lead -->
	<section class="container space-before space-after">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="text-center"><?=mostrar_palabra(290, $palabras)?></h1>
				<h4 class="text-center"><?=mostrar_palabra(293, $palabras)?></h4>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<?php
						foreach ($faqs as $key_faq => $faq)
						{
							echo '<div class="panel panel-default">
								    <div class="panel-heading" role="tab" id="heading'.$faq['faq_id'].'">
								      <h4 class="panel-title">
								        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$faq['faq_id'].'" aria-expanded="false" aria-controls="collapse'.$faq['faq_id'].'">
								          '.$faq['faq_pregunta'].'
								        </a>
								      </h4>
								    </div>
								    <div id="collapse'.$faq['faq_id'].'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$faq['faq_id'].'">
								      <div class="panel-body">
								        '.nl2br($faq['faq_respuesta']).'
								      </div>
								    </div>
								  </div>';
						}
						?>
					</div>

			</div>
		</div>
	</section>
	<!-- /Lead -->

	<!-- Features -->
	<section class="container space-before">
		
		
	</section>
	<!-- /Features -->

</main>


<?php
$this->load->view('templates/menu_footer');
$this->load->view('templates/footer');
$this->load->view('pages/header_scripts');
?>

</body>
</html>