<script type="text/javascript">
var subtotal_seguros = 0;

<?php
if($seguros)
{
	echo 'var cant_seguros = '.(count($seguros)-1).';';
}
else
{
	echo 'var cant_seguros = 0;';
}
?>

function agregar_seguro()
{
	cant_seguros++;

	$('#btn_agregar_seguros').button('loading');

	var htmlData = '';
	htmlData += '<div id="item_seguros_'+cant_seguros+'">';
			htmlData += '<hr>';
			htmlData += '<input type="hidden" id="seguros'+cant_seguros+'_id" name="seguros_id[]" value="">';
			htmlData += '<div class="row">';
				htmlData += '<div class="col-xs-3">';
					htmlData += input_text(cant_seguros, '<?=mostrar_palabra(640, $palabras)?>', 'seguros'+cant_seguros+'_val1', 'seguros_val1[]');
				htmlData += '</div>';
				htmlData += '<div class="col-xs-3">';
					htmlData += '<div class="form-group">';
				        htmlData += '<label for="seguros'+cant_seguros+'_val2" style="font-weight:normal;"><?=mostrar_palabra(697, $palabras)?></label>';
				        htmlData += '<div class="input-group" style="width:100%;">';
				          htmlData += '<select class="form-control" name="seguros_val2[]" id="seguros'+cant_seguros+'_val2">';
				            htmlData += '<option value="1"><?=mostrar_palabra(698, $palabras)?></option>';
				            htmlData += '<option value="2"><?=mostrar_palabra(699, $palabras)?></option>';
				            htmlData += '<option value="3"><?=mostrar_palabra(700, $palabras)?></option>';
				            htmlData += '<option value="4"><?=mostrar_palabra(701, $palabras)?></option>';
				          htmlData += '</select>';
				          htmlData += comentarios(0,0,0,0);
				        htmlData += '</div>';
				    htmlData += '</div>';
				htmlData += '</div>';
				htmlData += '<div class="col-xs-3">';
					htmlData += input_text(cant_seguros, '<?=mostrar_palabra(702, $palabras)?>', 'seguros'+cant_seguros+'_val3', 'seguros_val3[]');
				htmlData += '</div>';
				htmlData += '<div class="col-xs-3">';
					htmlData += input_text(cant_seguros, '<?=mostrar_palabra(626, $palabras)?>', 'seguros'+cant_seguros+'_val4', 'seguros_val4[]');
				htmlData += '</div>';
			htmlData += '</div>';
			htmlData += '<div class="row">';
				htmlData += '<div class="col-xs-12">';
					htmlData += '<label><?=mostrar_palabra(641, $palabras)?></label>';
				htmlData += '</div>';
				htmlData += '<div class="col-xs-3">';
					htmlData += input_text(cant_seguros, '<?=mostrar_palabra(10, $palabras)?>', 'seguros'+cant_seguros+'_val5', 'seguros_val5[]');
				htmlData += '</div>';
				htmlData += '<div class="col-xs-3">';
					htmlData += input_text(cant_seguros, '<?=mostrar_palabra(11, $palabras)?>', 'seguros'+cant_seguros+'_val6', 'seguros_val6[]');
				htmlData += '</div>';
			htmlData += '</div>';
			htmlData += '<div class="row">';
				htmlData += '<div class="col-xs-3">';
					htmlData += input_text(cant_seguros, '<?=mostrar_palabra(133, $palabras)?>', 'seguros'+cant_seguros+'_val7', 'seguros_val7[]');
				htmlData += '</div>';
				htmlData += '<div class="col-xs-3">';
					htmlData += input_text(cant_seguros, '<?=mostrar_palabra(4, $palabras)?>', 'seguros'+cant_seguros+'_val8', 'seguros_val8[]');
				htmlData += '</div>';
			htmlData += '</div>';
			htmlData += '<div class="row">';
				htmlData += '<div class="col-xs-3">';
					htmlData += input_text(cant_seguros, '<?=mostrar_palabra(642, $palabras)?>', 'seguros'+cant_seguros+'_val9', 'seguros_val9[]', 'onchange="actualizar_subtotal_seguros('+cant_seguros+')"');
				htmlData += '</div>';
				htmlData += '<div class="col-xs-3">';
					htmlData += '<div class="form-group">';
		                htmlData += '<label for="seguros'+cant_seguros+'_val10"><?=mostrar_palabra(707, $palabras)?></label>';
		                htmlData += '<div class="input-group" style="width:100%;">';
		                  htmlData += '<select class="form-control" name="seguros_val10[]" id="seguros'+cant_seguros+'_val10">';
		                    htmlData += '<option value="1"><?=mostrar_palabra(708, $palabras)?></option>';
		                    htmlData += '<option value="2"><?=mostrar_palabra(709, $palabras)?></option>';
		                    htmlData += '<option value="3"><?=mostrar_palabra(710, $palabras)?></option>';
		                    htmlData += '<option value="4"><?=mostrar_palabra(711, $palabras)?></option>';
		                  htmlData += '</select>';
		                  htmlData += comentarios(0,0,0,0,1);
		                htmlData += '</div>';
		            htmlData += '</div>';
				htmlData += '</div>';
			htmlData += '</div>';
			htmlData += '<div class="row">';
				htmlData += '<div class="col-xs-3">';
					htmlData += input_text(cant_seguros, '<?=mostrar_palabra(703, $palabras)?>', 'seguros'+cant_seguros+'_val11', 'seguros_val11[]');
				htmlData += '</div>';
				htmlData += '<div class="col-xs-3">';
					htmlData += input_text(cant_seguros, '<?=mostrar_palabra(704, $palabras)?>', 'seguros'+cant_seguros+'_val12', 'seguros_val12[]');
				htmlData += '</div>';
			htmlData += '</div>';
			htmlData += '<div class="row">';
				htmlData += '<div class="col-xs-9">';
					htmlData += '<label class="col-md-3 control-label" style="font-weight:normal;"><?=mostrar_palabra(705, $palabras)?></label>';
					htmlData += '<div class="input-group">';
			        	htmlData += '<textarea id="seguros'+cant_seguros+'_val13" name="seguros_val13[]" class="form-control"></textarea>';
			            htmlData += comentarios(0,0,0,0);
			        htmlData += '</div>';
				htmlData += '</div>';
				htmlData += '<div class="col-xs-3">';
					htmlData += '<div class="form-group">';
						htmlData += '<label class="control-label">&nbsp;</label>';
						htmlData += '<button type="button" class="form-control btn btn-rojo2" onclick="eliminar_seguro('+cant_seguros+')"><i class="fas fa-trash"></i></button>';
					htmlData += '</div>';
				htmlData += '</div>';
			htmlData += '</div>';
		htmlData += '</div>';

	$('#area-seguros').append(htmlData);

	$('#seguros'+cant_seguros+'_val3').datepicker({
	  format: 'dd/mm/yyyy',
	  language: '<?=$this->session->userdata('idi_code')?>'
	});

	$('#btn_agregar_seguros').button('reset');
}

function eliminar_seguro(num)
{
	$('#item_seguros_'+num).hide();
	$('#seguros'+num+'_val1').val('');
}

function actualizar_subtotal_seguros()
{
	subtotal_seguros = 0;
	for(var i=0; i<=cant_seguros; i++)
	{
		if($('#seguros'+i+'_val9').val() != "")
		{
			subtotal_seguros += parseInt($('#seguros'+i+'_val9').val());
		}
	}

	//alert(subtotal_seguros);
	$('#comision_chk4_valor').html('$ '+subtotal_seguros);
	subtotal_general += subtotal_seguros;
	actualizar_subtotal_comision();
}
</script>