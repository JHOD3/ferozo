<script type="text/javascript">
var subtotal_transporte = 0;

<?php
if($transportes)
{
	echo 'var cant_transportes = '.(count($transportes)-1).';';
}
else
{
	echo 'var cant_transportes = 0;';
}
?>

function agregar_transporte()
{
	cant_transportes++;

	$('#btn_agregar_transportes').button('loading');

	var htmlData = '';
	htmlData += '<div id="item_transporte_'+cant_transportes+'">';
				htmlData += '<hr>';
				htmlData += '<input type="hidden" id="transportes'+cant_transportes+'_id" name="transportes_id[]" value="">';
				htmlData += '<div class="row">';
					htmlData += '<div class="col-xs-3">';
						htmlData += '<div class="form-group">';
			                htmlData += '<label for="transportes'+cant_transportes+'_val1"><?=mostrar_palabra(691, $palabras)?></label>';
			                htmlData += '<div class="input-group" style="width:100%;">';
			                  htmlData += '<select class="form-control" name="transportes_val1[]" id="transportes'+cant_transportes+'_val1">';
			                    htmlData += '<option value="1">Aereo</option>';
			                    htmlData += '<option value="2">Maritimo</option>';
			                    htmlData += '<option value="3">Terrestre</option>';
			                  htmlData += '</select>';
			                htmlData += '</div>';
			            htmlData += '</div>';
					htmlData += '</div>';
					htmlData += '<div class="col-xs-3">';
						htmlData += input_text(cant_transportes, '<?=mostrar_palabra(632, $palabras)?>', 'transportes'+cant_transportes+'_val2', 'transportes_val2[]', 'text');
					htmlData += '</div>';
					htmlData += '<div class="col-xs-3">';
						htmlData += input_text(cant_transportes, '<?=mostrar_palabra(633, $palabras)?>', 'transportes'+cant_transportes+'_val3', 'transportes_val3[]', 'text');
					htmlData += '</div>';
					htmlData += '<div class="col-xs-3">';
						htmlData += input_text(cant_transportes, '<?=mostrar_palabra(634, $palabras)?>', 'transportes'+cant_transportes+'_val4', 'transportes_val4[]', 'text');
					htmlData += '</div>';
				htmlData += '</div>';
				htmlData += '<div class="row">';
					htmlData += '<div class="col-xs-3">';
						htmlData += input_text(cant_transportes, '<?=mostrar_palabra(692, $palabras)?>', 'transportes'+cant_transportes+'_val5', 'transportes_val5[]', 'text');
					htmlData += '</div>';
					htmlData += '<div class="col-xs-3">';
						htmlData += input_text(cant_transportes, '<?=mostrar_palabra(639, $palabras)?>', 'transportes'+cant_transportes+'_val6', 'transportes_val6[]', 'text');
					htmlData += '</div>';
				htmlData += '</div>';
				htmlData += '<div class="row">';
					htmlData += '<div class="col-xs-12">';
				        htmlData += '<label class="control-label"><?=mostrar_palabra(693, $palabras)?></label>';
					htmlData += '</div>';
					htmlData += '<div class="col-xs-3">';
						htmlData += input_text(cant_transportes, '<?=mostrar_palabra(694, $palabras)?>', 'transportes'+cant_transportes+'_val7', 'transportes_val7[]', 'text');
					htmlData += '</div>';
					htmlData += '<div class="col-xs-3">';
						htmlData += input_text(cant_transportes, '<?=mostrar_palabra(695, $palabras)?>', 'transportes'+cant_transportes+'_val8', 'transportes_val8[]', 'text');
					htmlData += '</div>';
					htmlData += '<div class="col-xs-3">';
						htmlData += input_text(cant_transportes, '<?=mostrar_palabra(637, $palabras)?>', 'transportes'+cant_transportes+'_val9', 'transportes_val9[]', 'text');
					htmlData += '</div>';
					htmlData += '<div class="col-xs-3">';
						htmlData += '<div class="form-group">';
			                htmlData += '<label for="transportes'+cant_transportes+'_val10"><?=mostrar_palabra(636, $palabras)?></label>';
			                htmlData += '<div class="input-group" style="width:100%;">';
			                  htmlData += '<select class="form-control" name="transportes_val10[]" id="transportes'+cant_transportes+'_val10">';
			                    htmlData += '<option value="1">A bordo</option>';
			                    htmlData += '<option value="2">Para cargar</option>';
			                  htmlData += '</select>';
			                htmlData += '</div>';
			            htmlData += '</div>';
					htmlData += '</div>';
				htmlData += '</div>';
				htmlData += '<div class="row">';
					// htmlData += '<div class="col-xs-12">';
				 //        htmlData += '<label class="control-label">Costos</label>';
					// htmlData += '</div>';
					htmlData += '<div class="col-xs-3">';
						htmlData += '<div class="form-group">';
			                htmlData += '<label for="transportes'+cant_transportes+'_val11" style="font-weight:normal;"><?=mostrar_palabra(630, $palabras)?></label>';
			                htmlData += '<div class="input-group" style="width:100%;">';
			                  htmlData += '<select class="form-control" name="transportes_val11[]" id="transportes'+cant_transportes+'_val11">';
			                    <?php
			                    foreach ($monedas as $moneda)
				                {
				                	$selected = '';
				                	if($moneda['mon_code'] == $operations['mon_code'])
				                	{
				                		$selected = 'selected';
				                		echo "htmlData += '<option value=\"".$moneda['mon_code']."\" ".$selected.">".$moneda['mon_code'].' - '.$moneda['mon_simbolo']."</option>';";
				                	}
				                    //echo "htmlData += '<option value=\"".$moneda['mon_code']."\" ".$selected.">".$moneda['mon_code'].' - '.$moneda['mon_simbolo']."</option>';";
				                }
				                ?>
			                  htmlData += '</select>';
			                htmlData += '</div>';
						htmlData += '</div>';
					htmlData += '</div>';
					htmlData += '<div class="col-xs-3">';
						htmlData += input_text(cant_transportes, '<?=mostrar_palabra(696, $palabras)?>', 'transportes'+cant_transportes+'_val12', 'transportes_val12[]', 'text');
					htmlData += '</div>';
					htmlData += '<div class="col-xs-3">';
						htmlData += '<div class="form-group">';
			                htmlData += '<label for="transportes'+cant_transportes+'_val13"><?=mostrar_palabra(707, $palabras)?></label>';
			                htmlData += '<div class="input-group" style="width:100%;">';
			                  htmlData += '<select class="form-control" name="transportes_val13[]" id="transportes'+cant_transportes+'_val13">';
			                    htmlData += '<option value="1"><?=mostrar_palabra(708, $palabras)?></option>';
			                    htmlData += '<option value="2"><?=mostrar_palabra(709, $palabras)?></option>';
			                    htmlData += '<option value="3"><?=mostrar_palabra(710, $palabras)?></option>';
			                    htmlData += '<option value="4"><?=mostrar_palabra(711, $palabras)?></option>';
			                  htmlData += '</select>';
			                htmlData += '</div>';
			            htmlData += '</div>';
					htmlData += '</div>';
					// htmlData += '<div class="col-xs-3">';
					// 	input_checkbox('Quiero sumar este importe al costo de la operacion', 'transportes'+cant_transportes+'_val2', 'transportes_val2[]', 'text', '');
					// htmlData += '</div>';
					htmlData += '<div class="col-xs-3">';
						htmlData += '<div class="form-group">';
							htmlData += '<label class="control-label">&nbsp;</label>';
							htmlData += '<button type="button" class="form-control btn btn-rojo2" onclick="eliminar_transporte('+cant_transportes+')"><i class="fas fa-trash"></i></button>';
						htmlData += '</div>';
					htmlData += '</div>';
				htmlData += '</div>';
			htmlData += '</div>';

	$('#area-transportes').append(htmlData);

	$('#transportes'+cant_transportes+'_val7').datepicker({
	  format: 'dd/mm/yyyy',
	  language: '<?=$this->session->userdata('idi_code')?>'
	});

	$('#transportes'+cant_transportes+'_val8').datepicker({
	  format: 'dd/mm/yyyy',
	  language: '<?=$this->session->userdata('idi_code')?>'
	});

	$('#btn_agregar_transportes').button('reset');
}

function eliminar_transporte(num)
{
	$('#item_transporte_'+num).hide();
	$('#transportes'+num+'_val2').val('');
}

function actualizar_subtotal_transporte()
{
	subtotal_transporte = 0;
	for(var i=0; i<=cant_transportes; i++)
	{
		if($('#transportes'+i+'_val12').val() != "")
		{
			subtotal_transporte += parseInt($('#transportes'+i+'_val12').val());
		}
	}

	//alert(subtotal_transporte);
	$('#comision_chk3_valor').html('$ '+subtotal_transporte);
	subtotal_general += subtotal_transporte;
	actualizar_subtotal_seguros();
}
</script>