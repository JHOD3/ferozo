<script type="text/javascript">
var subtotal_pagos = 0;

<?php
if($pagos)
{
	echo 'var cant_pagos = '.(count($pagos)-1).';';
}
else
{
	echo 'var cant_pagos = 0;';
}
?>

function agregar_pago()
{
	cant_pagos++;

	$('#btn_agregar_pagos').button('loading');

	var htmlData = '';
	htmlData += '<tr id="item_pagos_'+cant_pagos+'">';
		htmlData += '<input type="hidden" name="pagos_id[]" id="pagos'+cant_pagos+'_id" value="">';
		htmlData += '<td><label class="control-label">'+(cant_pagos+1)+'</label></td>';
		htmlData += '<td><input type="text" class="form-control" name="pagos_val1[]" id="pagos'+cant_pagos+'_val1" value=""></td>';
		htmlData += '<td><input type="text" class="form-control datepicker" name="pagos_val2[]" id="pagos'+cant_pagos+'_val2" value=""></td>';
		htmlData += '<td>';
			htmlData += '<div class="form-group">';
                htmlData += '<div class="input-group" style="width:100%;">';
                  htmlData += '<select class="form-control" name="pagos_val3[]" id="pagos'+cant_pagos+'_val3">';
                    htmlData += '<option value="1">Hitos</option>';
                  htmlData += '</select>';
                htmlData += '</div>';
            htmlData += '</div>';
        htmlData += '</td>';
		htmlData += '<td>';
			htmlData += '<div class="form-group">';
                htmlData += '<div class="input-group" style="width:100%;">';
                  htmlData += '<select class="form-control" name="pagos_val4[]" id="pagos'+cant_pagos+'_val4" onchange="actualizar_pago('+cant_pagos+')">';
                    htmlData += '<option value="1">Porcentaje del subtotal</option>';
                    htmlData += '<option value="2">Monto fijo</option>';
                  htmlData += '</select>';
                htmlData += '</div>';
            htmlData += '</div>';
        htmlData += '</td>';
		htmlData += '<td><input type="number" class="form-control" name="pagos_val5[]" id="pagos'+cant_pagos+'_val5" value="0" onchange="actualizar_pago('+cant_pagos+')"></td>';
		htmlData += '<td>';
        	htmlData += '<div class="form-group">';
                htmlData += '<div class="input-group" style="width:100%;">';
                  	htmlData += '<select class="form-control" name="pagos_val6[]" id="pagos'+cant_pagos+'_val6">';
                  	<?php
	                    foreach ($monedas as $moneda)
		                {
		                	$selected = '';
		                	if($moneda['mon_code'] == $operations['mon_code'])
		                	{
		                		$selected = 'selected';
		                		echo 'htmlData += "<option value=\''.$moneda['mon_code'].'\' '.$selected.'>'.$moneda['mon_code'].' - '.$moneda['mon_simbolo'].'</option>";';
		                	}
		                    //echo 'htmlData += "<option value=\''.$moneda['mon_code'].'\' '.$selected.'>'.$moneda['mon_code'].' - '.$moneda['mon_simbolo'].'</option>";';
		                    //echo "\n";
		                }
		            ?>
	                htmlData += '</select>';
                htmlData += '</div>';
        	htmlData += '</div>';
        htmlData += '</td>';
		htmlData += '<td><input type="number" class="form-control" name="pagos_val7[]" id="pagos'+cant_pagos+'_val7" value="0" readonly></td>';
        htmlData += '<td>';
        	htmlData += '<div class="form-group">';
                htmlData += '<div class="input-group" style="width:100%;">';
                  	htmlData += '<select class="form-control" name="pagos_val8[]" id="pagos'+cant_pagos+'_val8">';
	                    htmlData += '<option value="1">Transferencia bancaria</option>';
	                    htmlData += '<option value="2">Efectivo</option>';
                  	htmlData += '</select>';
                htmlData += '</div>';
        	htmlData += '</div>';
        htmlData += '</td>';
        //htmlData += '<td><input type="text" class="form-control" name="pagos_val9[]" id="pagos'+cant_pagos+'_val9" value=""></td>';
		htmlData += '<td>';
			htmlData += '<div class="input-group-btn">';
				htmlData += '<button type="button" class="btn btn-rojo2" onclick="eliminar_pago('+cant_pagos+')"><i class="fas fa-trash"></i></button>';
                htmlData += comentarios(0,0,0,0,0);
          	htmlData += '</div>';
      	htmlData += '</td>';
	htmlData += '</tr>';

	$('#area-pagos').append(htmlData);

	$('#pagos'+cant_pagos+'_val2').datepicker({
	  format: 'dd/mm/yyyy',
	  language: '<?=$this->session->userdata('idi_code')?>'
	});

	$('#btn_agregar_pagos').button('reset');
}

function actualizar_pagos()
{
	for(var i=0; i<=cant_pagos; i++)
	{
		actualizar_pago(i);
	}
}

function actualizar_pago(num)
{
	var importe = 0;
	if($('#pagos'+num+'_val4').val() == 1)
	{
		importe = subtotal_general * $('#pagos'+num+'_val5').val() / 100;
	}
	else if($('#pagos'+num+'_val4').val() == 2)
	{
		importe = $('#pagos'+num+'_val5').val();
	}
	$('#pagos'+num+'_val7').val(importe);

	actualizar_subtotal_pagos();
}

function eliminar_pago(num)
{
	$('#item_pagos_'+num).hide();
	$('#pagos'+num+'_val1').val('');
}

function actualizar_subtotal_pagos()
{
	$('#subtotal_pagos').val(subtotal_general);

	subtotal_pagos = 0;
	for(var i=0; i<=cant_pagos; i++)
	{
		subtotal_pagos += parseInt($('#pagos'+i+'_val7').val());
	}

	//alert(subtotal_pagos);
}
</script>