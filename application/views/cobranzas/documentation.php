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
						<a class="btn btn-danger pull-right" href="<?=site_url('cobranzas/dashboard')?>" style="color:#FFF; font-size:14px;">Dashboard</a>
						<h3 class="panel-title"><?=mostrar_palabra(646, $palabras)?></h3>
					</div>
				</div>
			</div>

		</div>
	</section>
	<!-- /Features -->

	<!-- Lead -->
	<section class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="media">
				  <div class="media-left media-middle">
				    <img src="<?=base_url('assets/images/cobranza/doc.png')?>" width="80px">
				  </div>
				  <div class="media-body">
				    <div class="media-heading-cobranza">
				    	<?=mostrar_palabra(762, $palabras)?><br>
				    	<span style="font-size:14px; color:#999;"><?=$operations['cob_nombre']?></span>
				    </div>
				  </div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">

				<?php if($this->session->flashdata('error') != "") { ?>
				  <div class="alert alert-danger">
					<?php echo $this->session->flashdata('error'); ?>
				  </div>
				<?php } ?>
				<?php if($this->session->flashdata('success') != "") { ?>
				  <div class="alert alert-success">
					<?php echo $this->session->flashdata('success'); ?>
				  </div>
				<?php } ?>

				<?php
				$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 3, $operations['cob_usr_tipo_id'], 1);
				$permiso_comentar = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 3, $operations['cob_usr_tipo_id'], 2);
				$permiso_editar = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 3, $operations['cob_usr_tipo_id'], 3);
				$permiso_confirmar = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 3, $operations['cob_usr_tipo_id'], 4);
				$permiso_subir = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 3, $operations['cob_usr_tipo_id'], 5);
	        	
	        	if($permiso_subir && $permiso_subir['cob_per_activo'])
	        	{
					echo '<a href="'.site_url('cobranzas/uploadDocument/'.$operations['cob_id']).'" class="btn btn-rojo2 pull-right">'.mostrar_palabra(761, $palabras).'</a>';
				}

				echo '<table class="table table-dashboard table-striped">';
				    echo '<thead>';
				        echo '<tr>';
					        echo '<th>'.mostrar_palabra(726, $palabras).'</th>';
						 	echo '<th>'.mostrar_palabra(758, $palabras).'</th>';
						 	if($permiso_ver && $permiso_ver['cob_per_activo'])
		        			{
					        	echo '<th>'.mostrar_palabra(760, $palabras).'</th>';
					        }
					        echo '<th>'.mostrar_palabra(759, $palabras).'</th>';   
					        echo '<th>'.mostrar_palabra(725, $palabras).'</th>';
							echo '<th>'.mostrar_palabra(369, $palabras).'</th>';
				        echo '</tr>';
				    echo '</thead>';
				    echo '<tbody>';
					
					$i=1;
					foreach($documents as $document)
					{
				      	echo '<tr>';
					        echo '<td>'.$i.'</td>';
					        echo '<td>'.ucwords($document['cob_doc_nombre']).'</td>';
					        if($permiso_ver && $permiso_ver['cob_per_activo'])
	        				{
						        echo '<td>';
						        	echo '<a href="'.base_url('images/cobranza/'.$document['cob_doc_ruta']).'" target="_blank" class="btn btn-default">'.mostrar_palabra(311, $palabras).'</a>';
						        echo '</td>';
						    }
					        echo '<td>';
					        	echo '<div class="btn-group">';
									echo '<button type="button" class="btn '.$document['cob_doc_est_color'].'" id="btn_estado_'.$document['cob_doc_id'].'">'.$document['cob_doc_est_desc'].'</button>';
									if($permiso_confirmar && $permiso_confirmar['cob_per_activo'])
	        						{
									  	echo '<button type="button" class="btn '.$document['cob_doc_est_color'].' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
										    echo '<span class="caret"></span>';
										    echo '<span class="sr-only">Toggle Dropdown</span>';
									  	echo '</button>';
									  	echo '<ul class="dropdown-menu">';
									  	foreach ($estados_documentos as $key => $value)
									  	{
										  	$disabled = '';
										  	if($document['cob_doc_est_id'] == $value['cob_doc_est_id'])
										  	{
										  		$disabled = 'class="disabled"';
										  	}
										  	echo '<li '.$disabled.'><a href="javascript: cambiar_estado('.$document['cob_doc_id'].', '.$value['cob_doc_est_id'].');">'.$value['cob_doc_est_desc'].'</a></li>';
									  	}
									}
								  	echo '</ul>';
								echo '</div>';
							echo '</td>';
							echo '<td>'.$document['cob_doc_fecha_modif'].'</td>';
					        echo '<td>';
					        	if($permiso_comentar && $permiso_comentar['cob_per_activo'])
		        				{
					        		echo '<a href="'.site_url('cobranzas/markDocument/'.$document['cob_doc_id'].'/'.$operations['cob_id']).'" class="btn btn-gris-chico btn-xs"><i class="fas fa-user-edit" aria-hidden="true"></i></a> ';
					        	}
					        	if($permiso_editar && $permiso_editar['cob_per_activo'])
		        				{
					        		echo '<a href="'.site_url('cobranzas/editDocument/'.$document['cob_doc_id'].'/'.$operations['cob_id']).'" class="btn btn-gris-chico btn-xs"><i class="fas fa-edit" aria-hidden="true"></i></a> ';
					        	}
					        	if($this->session->userdata('usr_id') == $document['usr_id'] )
					        	{
					        		echo '<a href="'.site_url('cobranzas/deleteDocument/'.$document['cob_doc_id'].'/'.$operations['cob_id']).'" class="btn btn-gris-chico btn-xs"><i class="fas fa-trash" aria-hidden="true"></i></a> ';
					        	}
							echo '</td>';
				      	echo '</tr>';
				    	$i++; 
					}  
					?>
				    </tbody>
			  	</table>
			</div>
		</div>

	</section>
	<!-- /Lead -->

</main>


<!-- Modal -->
<div class="modal fade" id="modal_invitar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Invitar</h4>
      </div>

      <form id="form_invitar" method="POST" action="#">
        <div class="modal-body">
          <div id="mensaje_referenciar"></div>
          <input type="hidden" value="<?=$operations['cob_id']?>" name="cob_id" id="invitar_cob_id">
          <input type="hidden" value="" name="cob_usr_tipo_id" id="invitar_cob_usr_tipo_id">
          <input type="text" class="form-control" value="" name="mail" id="invitar_mail">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(29, $palabras)?></button>
          <button type="submit" class="btn btn-danger" id="btn_referenciar"><?=mostrar_palabra(17, $palabras)?></button>
        </div>
      </form>

    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_comentar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Comentar</h4>
      </div>

      <form id="form_invitar" method="POST" action="#">
        <div class="modal-body">
          <div id="mensaje_referenciar"></div>
          <textarea class="form-control" value="" name="" id=""></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(29, $palabras)?></button>
          <button type="submit" class="btn btn-danger" id="btn_referenciar"><?=mostrar_palabra(17, $palabras)?></button>
        </div>
      </form>

    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_permisos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Permisos</h4>
      </div>

      <form id="form_permisos" method="POST" action="#">
        <div class="modal-body">
          <table class="table">
          	<?php
          	echo '<tr>';
				echo '<th></th>';
				foreach ($tipos as $key => $tipo)
				{
					echo '<th>'.$tipo['cob_usr_tipo_desc'].'</th>';
				}
			echo '</tr>';
			echo '<tr>';
				echo '<td>Ver</td>';
				foreach ($tipos as $key => $tipo)
				{
					echo '<td><input type="checkbox"></td>';
				}
			echo '</tr>';
			echo '<tr>';
				echo '<td>Comentar</td>';
				foreach ($tipos as $key => $tipo)
				{
					echo '<td><input type="checkbox"></td>';
				}
			echo '</tr>';
			echo '<tr>';
				echo '<td>Editar</td>';
				foreach ($tipos as $key => $tipo)
				{
					echo '<td><input type="checkbox"></td>';
				}
			echo '</tr>';
          	?>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(29, $palabras)?></button>
          <button type="submit" class="btn btn-danger" id="btn_referenciar"><?=mostrar_palabra(17, $palabras)?></button>
        </div>
      </form>

    </div>
  </div>
</div>


<?php
$this->load->view('templates/footer');
?>

<!-- Choosen -->
<link href="<?=base_url()?>assets/css/chosen.min.css" rel="stylesheet">
<script src="<?=base_url()?>assets/js/chosen.jquery.mobile.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/chosen.ajaxaddition.jquery.js"></script>
<style type="text/css">
.chosen-container-single .chosen-single{
  height: 34px;
  line-height: 30px;
}
</style>

<script type="text/javascript">
$('.chosen-select').ajaxChosen({
  dataType: 'json',
  type: 'POST',
  url:'<?=site_url()?>productos/buscar_posiciones_ajax'
},{
  loadingImg: '<?=base_url()?>assets/js/loading.png',
  minLength: 2
},{
  no_results_text: "<?=mostrar_palabra(246, $palabras)?> <i class='fa fa-search'></i>"
});

function cargar_ciudades(ctry_code, num)
{
	$.get('<?=site_url()?>productos/cargar_ciudades_noajax/'+ctry_code, function(resp){
		var htmlData = "<label style='font-weight:normal;'><?=mostrar_palabra( 32, $palabras)?></label>";
		htmlData += "<select class='form-control'>";
		htmlData += resp;
		htmlData += "</select>";
		$('#ciudad_'+num).html(htmlData);
	});
}

function cambiar_estado(cob_doc_id, est_id)
{
	$('#btn_estado_'+cob_doc_id).button('loading');
    $.ajax({
      url: SITE_URL+'cobranzas/cambiar_estado_documento_ajax',
      type: 'POST',
      data: jQuery.param({cob_doc_id: cob_doc_id, est_id: est_id}),
      dataType: 'json',
      success: function(data) {
        if(data.error == false)
        {
        	location.reload();
        }
        else
        {
        	alert(data.data);
        }
        $('#loading').hide();
      },
      error: function(x, status, error){
            alert("An error occurred: " + status + " nError: " + error);
      }
    });
}

function ver_modal_invitar(tipo)
{
	$('#invitar_cob_usr_tipo_id').val(tipo);
	$('#modal_invitar').modal('show');
}

$( "#form_invitar" ).submit(function( event ) {
  event.preventDefault();
  $("#mensaje_referenciar").html("");
  $('#btn_referenciar').button('loading');
  $.ajax({
     type: 'post',
     dataType: "json",
     data: $(event.target).serialize(),
     cache: false,
     url: SITE_URL+"cobranzas/invitar_ajax",
     success: function(data){
        if(data.error == false)
        {
          var htmlData = '<div class="alert with-icon alert-success" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
          htmlData += data.data;
          htmlData += '</div>';
          $("#mensaje_referenciar").html(htmlData);
        }
        else
        {
          var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
          htmlData += data.data;
          htmlData += '</div>';
          $("#mensaje_referenciar").html(htmlData);
        }
        $('#btn_referenciar').button('reset');
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        $("#mensaje_referenciar").html(htmlData);
        $('#btn_referenciar').button('reset');
      }
  });
});

function abrir_permisos()
{
	$('#modal_permisos').modal('show');
}

function abrir_comentar()
{
	$('#modal_comentar').modal('show');
}
</script>

</body>
</html>