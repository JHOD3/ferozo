<?php
$pal_ids = array(1, 103, 112, 116, 117, 290, 38, 286, 287, 294, 57, 240, 45, 18, 505);
$palabras_footer = $this->palabras_model->get_items_especificos($this->session->userdata('idi_code'), $pal_ids);
?>
<footer id="footer" class="">
	<section class="container">
		<div class="row">
			<div class="col-md-8 font14-px">
				<!--<h2>Secciones</h2>-->
				<?php
				if($this->session->userdata('usr_id') == "")
				{
					echo '<a href="'.site_url().'">'.mostrar_palabra(1, $palabras_footer).'</a> - ';
				}
				else
				{
					echo '<a href="'.site_url('resultados').'">'.mostrar_palabra(1, $palabras_footer).'</a> - ';
				}
				echo '<a href="'.site_url('pages/nosotros').'">'.mostrar_palabra(103, $palabras_footer).'</a> -';
				echo '<a href="'.site_url('pages/mundo').'">'.mostrar_palabra(112, $palabras_footer).'</a> - ';
				echo '<a href="'.site_url('pages/servicio').'">'.mostrar_palabra(116, $palabras_footer).'</a> - ';
				echo '<a href="'.site_url('pages/privacidad').'">'.mostrar_palabra(117, $palabras_footer).'</a> - ';
				echo '<a href="'.site_url('faq').'">'.mostrar_palabra(290, $palabras_footer).'</a> - ';
				echo '<a href="'.site_url('pages/contacto').'">'.mostrar_palabra(38, $palabras_footer).'</a>';
				echo '<br>';
				if($this->session->userdata('idi_code') == "en")
				{
					echo mostrar_palabra(286, $palabras_footer).' &copy;';
				}
				else
				{
					echo 'Copyright &copy; ('.mostrar_palabra(286, $palabras_footer).')';
				}
				echo ' 2016-'.date('Y').' - Sistema LLC - '.mostrar_palabra(287, $palabras_footer);
				?>
                
                <div class="pt-5 pb-3 row">
                    <a href="" class="col-6 col-md-2">
                        <embed src="<?=base_url()?>assets/images/google-play.svg" class="mx-auto d-block" type="">
                    </a>
                   <a href=""  class="col-6 col-md-2" >
                        <embed src="<?=base_url()?>assets/images/app-store.svg" class="mx-auto d-block" type="">
                   </a>
                </div>
			</div>
			<div class="col-md-4 text-right hidden-xs ">
				<img src="<?=base_url('assets/images/logo-footer.png')?>" alt="Sistema" class="mx-auto d-block" style="margin-bottom:10px;">
				<br>
				<div class="mx-auto d-flex">
                    <img src="<?=base_url('assets/images/2.png')?>" alt="" class="mx-auto mr-md-2  d-block">
                    <img src="<?=base_url('assets/images/3.png')?>" alt="" class="mx-auto ml-md-2 d-block">
                </div>
			</div>
		</div>	
	</section>
</footer>