<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
/*robert*/
$palabras_header = $this->palabras_model->get_items_especificos($this->session->userdata('idi_code'), array(236,1000,915,826,917,29,912,835,1002,922,924,926,841,928,1001,916,1003,913,923,925,927,929));
$palabras_check_b = $this->palabras_model->get_items_especificos($this->session->userdata('idi_code'), array(919,920,921,834));
$palabras_check_e = $this->palabras_model->get_items_especificos($this->session->userdata('idi_code'), array(918,919,920,921,834));

/*robert*/
/*<style>
.modal .modal-dialog .modal-content{  background-color: #B00035; }
.modal .modal-dialog .modal-content .modal-header{  background-color: #B00035; }
.modal .modal-dialog .modal-content .modal-footer{  background-color: #ce2600; }
</style>
*/
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
						<h5 class="text-center"><?=mostrar_palabra(826, $palabras)?></h5>
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

<!-- Modal -->

 <div class="modal fade" id="23b" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
					<h4 class="modal-title"><?=mostrar_palabra(1000, $palabras_header)?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
					<h5><?=mostrar_palabra(915, $palabras_header)?></h5>
					<h5><?=mostrar_palabra(826, $palabras_header)?></h5>
					<div class="container-fluid">
						<h5><?=mostrar_palabra(917, $palabras_header)?></h5>
						<form id="form_motivo" class="form-horizontal" role="form" action="#">
						
						<?php
						$i=0;
					  	foreach ($palabras_check_b as $row => $item)
						{
							echo '<div class="row form-group">
									<div class="col-md-12 text-rigth">
										<div class="custom-control custom-radio">
										<input type="radio" class="custom-control__input" id="sendrequest-'.$i.'" value="'.$item['pal_id'].'" name="sendrequest" required="">
                                        <label class="custom-control__label font-weight--bold" for="sendrequest-'.$i.'">'.$item['pal_desc'].'</label>
										</div>
									</div>
								  </div>';
							$i++;
						}
							echo '<div class="row form-group">
									<div class="col-md-12 text-rigth">
										<div class="custom-control custom-radio">
										<input type="radio" class="custom-control__input" id="sendrequest-'.$i.'" value="834" name="sendrequest" required="">
                                        <label class="custom-control__label font-weight--bold" for="sendrequest-'.$i.'">'.mostrar_palabra(834, $palabras_header).'</label>
										</div>
									</div>
								  </div>';
							$i++;
						?>
						<label for="cancelComment"><?=mostrar_palabra(1002, $palabras_header)?>:</label>
                            <input maxlength="255" type="text" id="cancelComment" class="form-control form-control--sm" value=""><span class="form-control__indicator"></span>
						</form>
					</div>	
                 
                    
					
                </div>
                <div class="modal-footer">
				<div class="row">
					<div class="col-md-8">
						<button type="button" class="btn btn-default bt-cancela pull-left"><?=mostrar_palabra(29, $palabras_header)?></button>
						<button type="button" class="btn btn-google-plus bt-pasoDos pull-left"><?=mostrar_palabra(912, $palabras_header)?></button>
					</div>
					<div class="col-md-4">
						<button type="button" class="btn btn-default bt-omite pull-right"><?=mostrar_palabra(835, $palabras_header)?></button>
					</div>					
				</div>
                </div>
            </div>
        </div>
    </div>
	
	<!-- paso 2 -->
	<div class="modal fade" id="23c" tabindex="-1" role="dialog" aria-labelledby="pasoDosLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
					<h4 class="modal-title"><?=mostrar_palabra(922, $palabras_header)?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
					<div id="result_suspender"></div>
					<div class="container-fluid">
					<form id="form_pasoDos" class="form-horizontal" role="form" action="#">
					<h5><?=mostrar_palabra(924, $palabras_header)?></h5>
					<h5><?=mostrar_palabra(926, $palabras_header)?></h5>
					</form>
                 </div>
                </div>
                <div class="modal-footer">
				<div class="row">
					<div class="col-md-6">
						<button type="button" class="btn btn-default bt-pasoUno pull-rigth"><?=mostrar_palabra(841, $palabras_header)?></button>
					</div>
					<div class="col-md-6">
						<button type="button" class="btn btn-google-plus bt-pasoSuspender pull-left"><?=mostrar_palabra(928, $palabras_header)?></button>
					</div>					
				</div>
                </div>
            </div>
        </div>
    </div>
	
	<!-- paso eliminar -->
	<div class="modal fade" id="23e" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
					<h4 class="modal-title"><?=mostrar_palabra(1001, $palabras_header)?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
					<h5><?=mostrar_palabra(916, $palabras_header)?></h5>
					<div class="container-fluid">
						<h5><h5><?=mostrar_palabra(826, $palabras_header)?></h5></h5>
						<form id="form_motivo" class="form-horizontal" role="form" action="#">
						<?php
						$i=0;
					  	foreach ($palabras_check_e as $row => $item)
						{
							echo '<div class="row form-group">
									<div class="col-md-12 text-rigth">
										<div class="custome-control custom-radio">
										<input type="radio" class="custome-control__input" id="sendrequeste-'.$i.'" value="'.$item['pal_id'].'" name="sendrequeste" required="">
                                        <label class="custom-control__label font-weight--bold" for="sendrequeste-'.$i.'">'.$item['pal_desc'].'</label>
										</div>
									</div>
								  </div>';
							$i++;
						}
							echo '<div class="row form-group">
									<div class="col-md-12 text-rigth">
										<div class="custome-control custom-radio">
										<input type="radio" class="custome-control__input" id="sendrequeste-'.$i.'" value="834" name="sendrequeste" required="">
                                        <label class="custom-control__label font-weight--bold" for="sendrequeste-'.$i.'">'.mostrar_palabra(834, $palabras_header).'</label>
										</div>
									</div>
								  </div>';
							$i++;
						?>
						<label for="cancelComment"><?=mostrar_palabra(1003, $palabras_header)?>:</label>
                            <input maxlength="255" type="text" id="cancelComment_e" class="form-control form-control--sm" value=""><span class="form-control__indicator"></span>
						</form>
					</div>	
                 
                    
					
                </div>
                <div class="modal-footer">
				<div class="row">
					<div class="col-md-8">
						<button type="button" class="btn btn-default bt-cancela-e pull-left"><?=mostrar_palabra(29, $palabras_header)?></button>
						<button type="button" class="btn btn-google-plus bt-pasoDos-e pull-left"><?=mostrar_palabra(913, $palabras_header)?></button>
					</div>
					<div class="col-md-4">
						<button type="button" class="btn btn-default bt-omite-e pull-right"><?=mostrar_palabra(835, $palabras_header)?></button>
					</div>					
				</div>
                </div>
            </div>
        </div>
    </div>
	
	
	
	
	<!-- paso 3 -->
	<div class="modal fade" id="23f" tabindex="-1" role="dialog" aria-labelledby="pasoTresLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
					<h4 class="modal-title"><?=mostrar_palabra(923, $palabras_header)?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
					<div id="result_eliminar"></div>
					<div class="container-fluid">
					<h5><?=mostrar_palabra(925, $palabras_header)?></h5>
					<h5><?=mostrar_palabra(927, $palabras_header)?></h5>
						<form id="form_pasoDos" class="form-horizontal" role="form" action="#">
						</form>
					</div>	
                </div>
                <div class="modal-footer">
				<div class="row">
					<div class="col-md-6">
						<button type="button" class="btn btn-default bt-pasoUno-e pull-rigth"><?=mostrar_palabra(841, $palabras_header)?></button>
					</div>
					<div class="col-md-6">
						<button type="button" class="btn btn-google-plus bt-pasoEliminar pull-left"><?=mostrar_palabra(929, $palabras_header)?></button>
					</div>					
				</div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->load->view('templates/menu_footer');
$this->load->view('templates/footer');
$this->load->view('pages/header_scripts');
?>

<script type="text/javascript">
  $(document).ready(function () {
		  
		  var cancelaBtn = $('.bt-cancela'),
		  pasoUnoBtn = $('.bt-pasoUno'),
		  pasoDosBtn = $('.bt-pasoDos'),
		  cancelaBtne = $('.bt-cancela-e'),
		  pasoUnoBtne = $('.bt-pasoUno-e'),
		  pasoDosBtne = $('.bt-pasoDos-e'),
		  pasoSuspenderBtn = $('.bt-pasoSuspender'),
		  pasoEliminarBtn = $('.bt-pasoEliminar'),
		  susPenderBtn = $('.bt-suspender'),
		  eliMinarBtn = $('.bt-eliminar'),
		  omiteBtn = $('.bt-omite'),
		  omiteBtne = $('.bt-omite-e');

		/*suspender*/
		susPenderBtn.click(function(e){
				$('#23b').modal('show');
		});
		
		cancelaBtn.click(function(e){
				$('#23b').modal('hide');
		});
		
		pasoUnoBtn.click(function(){
				$('#23b').modal('show');
				$('#23c').modal('hide');
		});
		
		pasoDosBtn.click(function(){
				$('#23b').modal('hide');
				$('#23c').modal('show');
		});
		
		omiteBtn.click(function(){
				pasoDosBtn.click();
		});
		
		pasoSuspenderBtn.click(function(){
					
			let comentario="";
			let id_comentario="";

        //Cancelar la transaccion
			if($(".custom-control__input:checked").length > 0){
				console.log("Si Hay Chequeados");
				let id = $(".custom-control__input:checked").val();
				id_comentario = id;
			}

			if($("#cancelComment").val()!=""){
				comentario = $("#cancelComment").val();
			}
		
				$.post('<?php echo base_url() ?>faq/retiro_motivo',{
					comentarios_usuario:comentario,
					pal_id:id_comentario,
					estado:'Suspender',
				}).done(function(resp){
					let data = JSON.parse(resp);
							if(data.code=="200"){
								$('#23c').modal('hide');
								window.location.href="<?php echo base_url() ?>/login/logout"; 
							}else{
								$('#result_suspender').html('<div class="alert alert-danger">'+data.message+'</div>');
							}
				}).fail(function() {
						alert( "error" );
				});		
		});
		/*suspender*/
		
		/*eliminar*/
		
		eliMinarBtn.click(function(e){
				$('#23e').modal('show');
		});
		
		cancelaBtne.click(function(e){
				$('#23e').modal('hide');
		});
		
		pasoUnoBtne.click(function(){
				$('#23e').modal('show');
				$('#23f').modal('hide');
		});
		
		pasoDosBtne.click(function(){
				$('#23e').modal('hide');
				$('#23f').modal('show');
		});
		
		pasoEliminarBtn.click(function(){
			let comentario="";
			let id_comentario="";

        //Cancelar la transaccion
			if($(".custom-control__input:checked").length > 0){
				console.log("Si Hay Chequeados");
				let id = $(".custom-control__input:checked").val();
				id_comentario = id;
			}

			if($("#cancelComment").val()!=""){
				comentario = $("#cancelComment").val();
			}
		
				$.post('<?php echo base_url() ?>faq/retiro_motivo',{
					comentarios_usuario:comentario,
					pal_id:id_comentario,
					estado:'Suspender',
				}).done(function(resp){
					let data = JSON.parse(resp);
							if(data.code=="200"){
								$('#23c').modal('hide');
								window.location.href="<?php echo base_url() ?>/login/logout"; 
							}else{
								$('#result_suspender').html('<div class="alert alert-danger">'+data.message+'</div>');
							}
				}).fail(function() {
						alert( "error" );
				});		
		});
		
		omiteBtne.click(function(){
				pasoDosBtne.click();
		});
		
		
		/*eliminar*/
	});
  </script>
</body>
</html>