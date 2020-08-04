<script type="text/javascript">
var subtotal_comision = 0;

function actualizar_subtotal_comision()
{
	subtotal_comision = 0;
	var suma_comision = 0;
	var importe = 0;

	if($('#comision_chk1').is(':checked'))
	{
		suma_comision += subtotal_productos;
	}
	if($('#comision_chk2').is(':checked'))
	{
		suma_comision += subtotal_otros_servicios;
	}
	if($('#comision_chk3').is(':checked'))
	{
		suma_comision += subtotal_transporte;
	}
	if($('#comision_chk4').is(':checked'))
	{
		suma_comision += subtotal_seguros;
	}
	$('#comision_suma').val(suma_comision);
	//alert(suma_comision);

	if($('#comision_calculo').val() == 1)
	{
		importe = suma_comision * $('#comision_importe').val() / 100;
	}
	else if($('#comision_calculo').val() == 2)
	{
		importe = $('#comision_importe').val();
	}

	$('#comision_total').val(importe);
	$('#subtotal_pagos_comisiones').val(importe);
	subtotal_comision = importe;

	actualizar_pagos();
}
</script>