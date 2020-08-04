<script type="text/javascript">
var subtotal_pagos_comisiones = 0;

<?php
if($pagos_comisiones)
{
	echo 'var cant_pagos_comisiones = '.(count($pagos_comisiones)-1).';';
}
else
{
	echo 'var cant_pagos_comisiones = 0;';
}
?>

function agregar_pago_comisiones()
{
	cant_pagos_comisiones++;

	$('#btn_agregar_pagos_comisiones').button('loading');

	var htmlData = '';
	htmlData += '<tr id="item_pagos_comisiones_'+cant_pagos_comisiones+'">';
		htmlData += '<input type="hidden" name="pagos_comisiones_id[]" id="pagos_comisiones'+cant_pagos_comisiones+'_id" value="">';
		htmlData += '<td><label class="control-label">'+(cant_pagos_comisiones+1)+'</label></td>';
		htmlData += '<td><input type="text" class="form-control" name="pagos_comisiones_val1[]" id="pagos_comisiones'+cant_pagos_comisiones+'_val1" value=""></td>';
		htmlData += '<td><input type="text" class="form-control" name="pagos_comisiones_val2[]" id="pagos_comisiones'+cant_pagos_comisiones+'_val2" value=""></td>';
		htmlData += '<td>';
			htmlData += '<div class="form-group">';
                htmlData += '<div class="input-group" style="width:100%;">';
                  htmlData += '<select class="form-control" name="pagos_comisiones_val3[]" id="pagos_comisiones'+cant_pagos_comisiones+'_val3">';
                    htmlData += '<option value="1">Hitos</option>';
                  htmlData += '</select>';
                htmlData += '</div>';
            htmlData += '</div>';
        htmlData += '</td>';
		htmlData += '<td>';
			htmlData += '<div class="form-group">';
                htmlData += '<div class="input-group" style="width:100%;">';
                  htmlData += '<select class="form-control" name="pagos_comisiones_val4[]" id="pagos_comisiones'+cant_pagos_comisiones+'_val4" onchange="actualizar_pago_comisiones('+cant_pagos_comisiones+')">';
                    htmlData += '<option value="1">Porcentaje del subtotal</option>';
                    htmlData += '<option value="2">Monto fijo</option>';
                  htmlData += '</select>';
                htmlData += '</div>';
            htmlData += '</div>';
        htmlData += '</td>';
		htmlData += '<td><input type="number" class="form-control" name="pagos_comisiones_val5[]" id="pagos_comisiones'+cant_pagos_comisiones+'_val5" value="0" onchange="actualizar_pago_comisiones('+cant_pagos_comisiones+')"></td>';
		htmlData += '<td>';
        	htmlData += '<div class="form-group">';
                htmlData += '<div class="input-group" style="width:100%;">';
                  	htmlData += '<select class="form-control" name="pagos_comisiones_val6[]" id="pagos_comisiones'+cant_pagos_comisiones+'_val6">';
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
		htmlData += '<td><input type="number" class="form-control" name="pagos_comisiones_val7[]" id="pagos_comisiones'+cant_pagos_comisiones+'_val7" value="0" readonly></td>';
        htmlData += '<td>';
        	htmlData += '<div class="form-group">';
                htmlData += '<div class="input-group" style="width:100%;">';
                  	htmlData += '<select class="form-control" name="pagos_comisiones_val8[]" id="pagos_comisiones'+cant_pagos_comisiones+'_val8">';
	                    htmlData += '<option value="1">Transferencia bancaria</option>';
	                    htmlData += '<option value="2">Efectivo</option>';
                  	htmlData += '</select>';
                htmlData += '</div>';
        	htmlData += '</div>';
        htmlData += '</td>';
        //htmlData += '<td><input type="text" class="form-control" name="pagos_comisiones_val9[]" id="pagos_comisiones'+cant_pagos+'_val9" value=""></td>';
		htmlData += '<td>';
			htmlData += '<div class="input-group-btn">';
				htmlData += '<button type="button" class="btn btn-rojo2" onclick="eliminar_pago_comisiones('+cant_pagos_comisiones+')"><i class="fas fa-trash"></i></button>';
                htmlData += comentarios(0,0,0,0,0);
          	htmlData += '</div>';
      	htmlData += '</td>';
	htmlData += '</tr>';

	$('#area-pagos_comisiones').append(htmlData);

	$('#pagos_comisiones'+cant_pagos_comisiones+'_val2').datepicker({
	  format: 'dd/mm/yyyy',
	  language: '<?=$this->session->userdata('idi_code')?>'
	});

	$('#btn_agregar_pagos_comisiones').button('reset');
}

function actualizar_pagos_comisiones()
{
	for(var i=0; i<=cant_pagos_comisiones; i++)
	{
		actualizar_pago_comisiones(i);
	}
}

function actualizar_pago_comisiones(num)
{
	var importe = 0;
	if($('#pagos_comisiones'+num+'_val4').val() == 1)
	{
		importe = subtotal_comision * $('#pagos_comisiones'+num+'_val5').val() / 100;
	}
	else if($('#pagos_comisiones'+num+'_val4').val() == 2)
	{
		importe = $('#pagos_comisiones'+num+'_val5').val();
	}
	$('#pagos_comisiones'+num+'_val7').val(importe);

	actualizar_subtotal_pagos_comisiones();
}

function eliminar_pago_comisiones(num)
{
	$('#item_pagos_comisiones_'+num).hide();
	$('#pagos_comisiones'+num+'_val1').val('');
}

function actualizar_subtotal_pagos_comisiones()
{
	$('#subtotal_pagos_comisiones').val(subtotal_comision);

	subtotal_pagos_comisiones = 0;
	for(var i=0; i<=cant_pagos_comisiones; i++)
	{
		subtotal_pagos_comisiones += parseInt($('#pagos_comisiones'+i+'_val7').val());
	}

	//alert(subtotal_pagos_comisiones);
}
</script>