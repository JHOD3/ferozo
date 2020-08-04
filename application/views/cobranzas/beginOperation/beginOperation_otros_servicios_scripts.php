<script type="text/javascript">
var subtotal_otros_servicios = 0;

<?php
if($otros_servicios)
{
	echo 'var cant_otros_servicios = '.(count($otros_servicios)-1).';';

	foreach ($otros_servicios as $key_serv => $servicio)
	{
		echo "$('#otros_servicios".$key_serv."_val2').ajaxChosen({
		  dataType: 'json',
		  type: 'POST',
		  url:'".site_url()."productos/buscar_servicios_ajax'
		},{
		  loadingImg: '".base_url()."assets/js/loading.gif',
		  minLength: 2
		},{
		  no_results_text: '".mostrar_palabra(246, $palabras)." <i class=\"fa fa-search\"></i>'
		}).chosen().change(function(e, params){
			$('#otros_servicios'+$(e.target).data('num')+'_val2').val(params.selected);
		});";
	}
}
else
{
	echo 'var cant_otros_servicios = 0;';

	echo "$('#otros_servicios0_val2').ajaxChosen({
		  dataType: 'json',
		  type: 'POST',
		  url:'".site_url()."productos/buscar_servicios_ajax'
		},{
		  loadingImg: '".base_url()."assets/js/loading.gif',
		  minLength: 2
		},{
		  no_results_text: '".mostrar_palabra(246, $palabras)." <i class=\"fa fa-search\"></i>'
		}).chosen().change(function(e, params){
			$('#otros_servicios'+$(e.target).data('num')+'_ara_id').val(params.selected);
		});";
}
?>

function agregar_otros_servicios()
{
	cant_otros_servicios++;

	$('#btn_agregar_otros_servicios').button('loading');

	var htmlData = '';
	htmlData += '<tr id="item_otros_servicios'+cant_otros_servicios+'">';
		htmlData += '<input type="hidden" id="otros_servicios'+cant_otros_servicios+'_id" name="otros_servicios_id[]" value="">';
		htmlData += '<td><label class="control-label">'+(cant_otros_servicios+1)+'</label></td>';
		htmlData += '<td><input type="text" class="form-control" name="otros_servicios_val1[]" id="otros_servicios'+cant_otros_servicios+'_val1" value=""></td>';
		htmlData += '<td>';
	        htmlData += '<div class="form-group">';
                htmlData += '<div class="input-group" style="width:90%;">';
                  htmlData += '<select data-num="'+cant_otros_servicios+'" data-placeholder="<?=mostrar_palabra(245, $palabras)?>..." class="chosen-servicios form-control" name="otros_servicios_val2[]" id="otros_servicios'+cant_otros_servicios+'_val2">';
                    htmlData += '<option value=""></option>';
                  htmlData += '</select>';
                htmlData += '</div>';
            htmlData += '</div>';
	    htmlData += '</td>';
		htmlData += '<td><input type="text" class="form-control datepicker" name="otros_servicios_val3[]" id="otros_servicios'+cant_otros_servicios+'_val3" value=""></td>';
		htmlData += '<td><div class="form-group">';
	        htmlData += '<div class="input-group" style="width:100%;">';
	          htmlData += '<select class="form-control" name="otros_servicios_val4[]" id="otros_servicios'+cant_otros_servicios+'_val4">';
	            htmlData += '<option value="">Porcentaje del subtotal</option>';
	            htmlData += '<option value="">Monto fijo</option>';
	          htmlData += '</select>';
	        htmlData += '</div>';
	    htmlData += '</div></td>';
		htmlData += '<td><input type="text" class="form-control" name="otros_servicios_val5[]" id="otros_servicios'+cant_otros_servicios+'_val5" value=""></td>';
		htmlData += '<td><input type="text" class="form-control" name="otros_servicios_val6[]" id="otros_servicios'+cant_otros_servicios+'_val6" value="" readonly="readonly"></td>';
		htmlData += '<td><div class="form-group">';
	        htmlData += '<div class="input-group" style="width:100%;">';
	          htmlData += '<select class="form-control" name="otros_servicios_val7[]" id="otros_servicios'+cant_otros_servicios+'_val7">';
	            htmlData += '<option value="">Transferencia bancaria</option>';
	            htmlData += '<option value="">Efectivo</option>';
	          htmlData += '</select>';
	        htmlData += '</div>';
	    htmlData += '</div></td>';
		htmlData += '<td>';
			htmlData += '<div class="input-group-btn">';
				htmlData += '<button type="button" class="btn btn-rojo2" onclick="eliminar_otro_servicio('+cant_otros_servicios+')"><i class="fas fa-trash"></i></button>';
			    htmlData += comentarios(0,0,0,0,0);
		  	htmlData += '</div>';
	  	htmlData += '</td>';
	htmlData += '</tr>';

	$('#area_otros_servicios').append(htmlData);

	$('#otros_servicios'+cant_otros_servicios+'_val2').ajaxChosen({
	  dataType: 'json',
	  type: 'POST',
	  url:'<?=site_url()?>productos/buscar_servicios_ajax'
	},{
	  loadingImg: '<?=base_url()?>assets/js/loading.gif',
	  minLength: 2
	},{
	  no_results_text: "<?=mostrar_palabra(246, $palabras)?> <i class='fa fa-search'></i>"
	}).chosen().change(function(e, params){
		$('#otros_servicios'+cant_otros_servicios+'_val2').val(params.selected);
	});

	$('#otros_servicios'+cant_otros_servicios+'_val3').datepicker({
	  format: 'dd/mm/yyyy',
	  language: '<?=$this->session->userdata('idi_code')?>'
	});

	$('#btn_agregar_otros_servicios').button('reset');
}

function actualizar_otros_servicios(num)
{
	for(var i=0; i<=cant_otros_servicios; i++)
	{
		actualizar_otro_servicio(i);
	}
}

function actualizar_otro_servicio(num)
{
	var importe = 0;
	if($('#otros_servicios'+num+'_val4').val() == 1)
	{
		importe = subtotal_productos * $('#otros_servicios'+num+'_val5').val() / 100;
	}
	else if($('#otros_servicios'+num+'_val4').val() == 2)
	{
		importe = $('#otros_servicios'+num+'_val5').val();
	}
	$('#otros_servicios'+num+'_val6').val(importe);

	actualizar_subtotal_otros_servicios();
}

function eliminar_otro_servicio(num)
{
	$('#item_otros_servicios'+num).hide();
	$('#otros_servicios'+num+'_val1').val('');
}

function actualizar_subtotal_otros_servicios()
{
	subtotal_otros_servicios = 0;
	for(var i=0; i<=cant_otros_servicios; i++)
	{
		subtotal_otros_servicios += parseInt($('#otros_servicios'+i+'_val6').val());
	}

	//alert(subtotal_otros_servicios);
	$('#comision_chk2_valor').html('$ '+subtotal_otros_servicios);
	subtotal_general += subtotal_otros_servicios;
	actualizar_subtotal_transporte();
}
</script>