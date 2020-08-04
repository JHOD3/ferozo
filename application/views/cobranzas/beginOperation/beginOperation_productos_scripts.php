<script type="text/javascript">
var subtotal_productos = 0;

<?php
echo 'var cant_producto_servicios = [];';
if($productos)
{
	echo 'var cant_productos = '.(count($productos)-1).';';
	foreach ($productos as $key => $value)
	{
		if($value['servicios'])
		{
			echo 'cant_producto_servicios['.$key.'] = '.count($value['servicios']).';';

			foreach ($value['servicios'] as $key_serv => $servicio)
			{
				echo "$('#producto".$key."_servicios".$key_serv."_arancel').ajaxChosen({
				  dataType: 'json',
				  type: 'POST',
				  url:'".site_url()."productos/buscar_servicios_ajax'
				},{
				  loadingImg: '".base_url()."assets/js/loading.gif',
				  minLength: 2
				},{
				  no_results_text: '".mostrar_palabra(246, $palabras)." <i class=\"fa fa-search\"></i>'
				}).chosen().change(function(e, params){
					$('#producto'+$(e.target).data('num_prod')+'_servicios'+$(e.target).data('num')+'_ara_id').val(params.selected);
				});";
			}
		}
		else
		{
			echo 'cant_producto_servicios['.$key.'] = 0;';
		}

		echo "$('#arancel".$key."').ajaxChosen({
		  dataType: 'json',
		  type: 'POST',
		  url:'".site_url()."productos/buscar_posiciones_ajax'
		},{
		  loadingImg: '".base_url()."assets/js/loading.gif',
		  minLength: 2
		},{
		  no_results_text: '".mostrar_palabra(246, $palabras)." <i class=\"fa fa-search\"></i>'
		}).chosen().change(function(e, params){
			$('#arancel'+$(e.target).data('num')+'_id').val(params.selected);
		});";
	}
}
else
{
	echo 'var cant_productos = 0;';
	echo 'cant_producto_servicios[0] = 0;';

	echo "$('#arancel0').ajaxChosen({
		  dataType: 'json',
		  type: 'POST',
		  url:'".site_url()."productos/buscar_posiciones_ajax'
		},{
		  loadingImg: '".base_url()."assets/js/loading.gif',
		  minLength: 2
		},{
		  no_results_text: '".mostrar_palabra(246, $palabras)." <i class=\"fa fa-search\"></i>'
		}).chosen().change(function(e, params){
			$('#arancel'+$(e.target).data('num')+'_id').val(params.selected);
		});";

	echo "$('#producto0_servicios0_arancel').ajaxChosen({
		  dataType: 'json',
		  type: 'POST',
		  url:'".site_url()."productos/buscar_servicios_ajax'
		},{
		  loadingImg: '".base_url()."assets/js/loading.gif',
		  minLength: 2
		},{
		  no_results_text: '".mostrar_palabra(246, $palabras)." <i class=\"fa fa-search\"></i>'
		}).chosen().change(function(e, params){
			$('#producto'+$(e.target).data('num_prod')+'_servicios'+$(e.target).data('num')+'_ara_id').val(params.selected);
		});";
}
?>

function agregar_producto()
{
	cant_productos++;
	cant_producto_servicios[cant_productos] = 0;

	$('#btn_agregar_productos').button('loading');

	var htmlData = '';
	htmlData += '<div id="item_producto_'+cant_productos+'">';
		htmlData += '<hr>';
		htmlData += '<div class="row">';
			htmlData += '<input type="hidden" id="producto'+cant_productos+'_id" name="producto_id[]" value="">';
			htmlData += '<input type="hidden" id="arancel'+cant_productos+'_id" name="arancel_id[]" value="">';
			htmlData += '<div class="col-xs-3">';
				htmlData += '<div class="form-group">';
	                htmlData += '<label for="arancel'+cant_productos+'"><i class="fa fa-code fa-lg texto-bordo2"></i> <?=mostrar_palabra(22, $palabras)?></label>';
	                htmlData += '<div class="input-group" style="width:100%;">';
	                  htmlData += '<select data-num="'+cant_productos+'" data-placeholder="<?=mostrar_palabra(245, $palabras)?>..." class="chosen-select form-control" name="arancel[]" id="arancel_'+cant_productos+'">';
	                    htmlData += '<option value=""></option>';
	                  htmlData += '</select>';
	                  htmlData += comentarios(0,0,0,0);
	                htmlData += '</div>';
	            htmlData += '</div>';
			htmlData += '</div>';
			htmlData += '<div class="col-xs-3">';
				htmlData += input_text(cant_productos, '<?=mostrar_palabra(412, $palabras)?>', 'producto'+cant_productos+'_val1', 'producto_val1[]');
			htmlData += '</div>';
			htmlData += '<div class="col-xs-3">';
				htmlData += input_text(cant_productos, '<?=mostrar_palabra(628, $palabras)?>', 'producto'+cant_productos+'_val2', 'producto_val2[]');
			htmlData += '</div>';
		htmlData += '</div>';
		htmlData += '<div class="row">';
			htmlData += '<div class="col-xs-3">';
				htmlData += input_text(cant_productos, '<?=mostrar_palabra(250, $palabras)?>', 'producto'+cant_productos+'_val3', 'producto_val3[]');
			htmlData += '</div>';
			htmlData += '<div class="col-xs-3">';
				htmlData += input_text(cant_productos, '<?=mostrar_palabra(687, $palabras)?>', 'producto'+cant_productos+'_val4', 'producto_val4[]', 'number', 'min="0" onchange="actualizar_subtotal_producto('+cant_productos+');"');
			htmlData += '</div>';
			htmlData += '<div class="col-xs-3">';
				htmlData += input_text(cant_productos, '<?=mostrar_palabra(684, $palabras)?>', 'producto'+cant_productos+'_val5', 'producto_val5[]', 'number');
			htmlData += '</div>';
		htmlData += '</div>';
		htmlData += '<div class="row">';
			htmlData += '<div class="col-xs-3">';
				htmlData += input_text(cant_productos, '<?=mostrar_palabra(631, $palabras)?>', 'producto'+cant_productos+'_val6', 'producto_val6[]');
			htmlData += '</div>';
			htmlData += '<div class="col-xs-3">';
				htmlData += '<div class="form-group">';
	                htmlData += '<label for="pais'+cant_productos+'" style="font-weight:normal;"><?=mostrar_palabra(689, $palabras)?></label>';
	                htmlData += '<div class="input-group" style="width:100%;">';
	                  htmlData += '<select class="form-control" name="pais[]" id="pais'+cant_productos+'" onchange="cargar_ciudades('+cant_productos+', this.value);">';
	                    htmlData += '<option selected disabled style="display:none;"><?=mostrar_palabra(161, $palabras)?></option>';
	                    <?php
		                foreach ($paises as $pais)
		                {
		                    echo "htmlData += '<option value=\"".$pais['ctry_code']."\">".$pais['ctry_nombre']."</option>';";
		                }
		                ?>
	                  htmlData += '</select>';
	                  htmlData += comentarios(0,0,0,0);
	                htmlData += '</div>';
	            htmlData += '</div>';
			htmlData += '</div>';
			htmlData += '<div class="col-xs-3">';
				htmlData += '<div class="form-group">';
	                htmlData += '<label for="ciudad'+cant_productos+'" style="font-weight:normal;"><?=mostrar_palabra(688, $palabras)?></label>';
	                htmlData += '<div class="input-group" style="width:100%;">';
	                  htmlData += '<select class="form-control" name="ciudad[]" id="ciudad'+cant_productos+'">';
	                    htmlData += '<option disabled style="display:none;"><?=mostrar_palabra(165, $palabras)?></option>';
	                  htmlData += '</select>';
	                  htmlData += comentarios(0,0,0,0);
	                htmlData += '</div>';
	            htmlData += '</div>';
			htmlData += '</div>';
		htmlData += '</div>';
		htmlData += '<div class="row">';
			htmlData += '<div class="col-xs-3">';
				htmlData += '<div class="form-group">';
	                htmlData += '<label for="moneda'+cant_productos+'" style="font-weight:normal;"><?=mostrar_palabra(630, $palabras)?></label>';
	                htmlData += '<div class="input-group" style="width:100%;">';
	                  htmlData += '<select class="form-control" name="moneda[]" id="moneda'+cant_productos+'">';
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
	                  htmlData += comentarios(0,0,0,0);
	                htmlData += '</div>';
				htmlData += '</div>';
			htmlData += '</div>';
			htmlData += '<div class="col-xs-3">';
				htmlData += input_text(cant_productos, '<?=mostrar_palabra(690, $palabras)?>', 'producto'+cant_productos+'_val9', 'producto_val9[]', 'number', 'onchange="actualizar_subtotal_producto('+cant_productos+');"');
			htmlData += '</div>';
			htmlData += '<div class="col-xs-3">';
				htmlData += input_text(cant_productos, '<?=mostrar_palabra(660, $palabras)?>', 'producto'+cant_productos+'_subtotal', 'producto_subtotal[]', 'number', 'readonly');
			htmlData += '</div>';
			htmlData += '<div class="col-xs-3">';
				htmlData += '<div class="form-group">';
					htmlData += '<label class="control-label">&nbsp;</label>';
					htmlData += '<button type="button" class="btn btn-rojo2" onclick="eliminar_producto('+cant_productos+')" style="margin-top:25px;"><i class="fas fa-trash"></i></button>';
				htmlData += '</div>';
			htmlData += '</div>';
		htmlData += '</div>';

		htmlData += '<div class="row" style="margin-left:0px; margin-top:20px;">';
			htmlData += '<div class="title" style="margin-top:20px; font-weight:bold;"><?=mostrar_palabra(661, $palabras)?></div>';
			htmlData += '<div class="row">';
				htmlData += '<div class="col-xs-12">';
					htmlData += '<button id="btn_agregar_producto'+cant_productos+'_servicios" type="button" class="btn btn-rojo2 pull-right" onclick="agregar_producto_servicios('+cant_productos+')"><?=mostrar_palabra(28, $palabras)?></button>';
				htmlData += '</div>';
			htmlData += '</div>';

			htmlData += '<div class="row">';
				htmlData += '<div class="col-xs-12">';
					htmlData += '<table class="table">';
						htmlData += '<thead>';
							htmlData += '<tr>';
								htmlData += '<th>&nbsp;</th>';
								htmlData += '<th><?=mostrar_palabra(21, $palabras)?></th>';
								htmlData += '<th><?=mostrar_palabra(663, $palabras)?></th>';
								htmlData += '<th><?=mostrar_palabra(664, $palabras)?></th>';
								htmlData += '<th><?=mostrar_palabra(665, $palabras)?></th>';
								htmlData += '<th><?=mostrar_palabra(630, $palabras)?></th>';
								htmlData += '<th><?=mostrar_palabra(660, $palabras)?></th>';
								htmlData += '<th>&nbsp;</th>';
							htmlData += '</tr>';
						htmlData += '</thead>';
						htmlData += '<tbody id="area_producto'+cant_productos+'_servicios">';
						htmlData += '</tbody>';
					htmlData += '</table>';
				htmlData += '</div>';
			htmlData += '</div>';
		htmlData += '</div>';
	htmlData += '</div>';

	$('#area-productos').append(htmlData);

	$('#arancel_'+cant_productos).ajaxChosen({
	  dataType: 'json',
	  type: 'POST',
	  url:'<?=site_url()?>productos/buscar_posiciones_ajax'
	},{
	  loadingImg: '<?=base_url()?>assets/js/loading.gif',
	  minLength: 2
	},{
	  no_results_text: "<?=mostrar_palabra(246, $palabras)?> <i class='fa fa-search'></i>"
	}).chosen().change(function(e, params){
		$('#arancel'+cant_productos+'_id').val(params.selected);
	});

	$('#btn_agregar_productos').button('reset');
}

function agregar_producto_servicios(num_prod)
{
	cant_producto_servicios[num_prod]++;

	$('#btn_agregar_producto'+num_prod+'_servicios').button('loading');

	var htmlData = '';

	htmlData += '<tr id="item_producto'+num_prod+'_servicio'+cant_producto_servicios[num_prod]+'">';
		htmlData += '<input type="hidden" id="producto'+num_prod+'_servicios'+cant_producto_servicios[num_prod]+'_id" name="producto'+num_prod+'_servicios_id[]" value="">';
		htmlData += '<input type="hidden" id="producto'+num_prod+'_servicios'+cant_producto_servicios[num_prod]+'_ara_id" name="producto'+num_prod+'_servicios_ara_id[]" value="">';
		htmlData += '<td><label class="control-label">'+cant_producto_servicios[num_prod]+'</label></td>';
		htmlData += '<td>';
			htmlData += '<div class="form-group">';
                htmlData += '<div class="input-group" style="width:90%;">';
                  htmlData += '<select data-num="'+cant_producto_servicios[num_prod]+'" data-num_prod="'+num_prod+'" data-placeholder="<?=mostrar_palabra(245, $palabras)?>..." class="chosen-servicios form-control" name="producto'+num_prod+'_servicios_arancel[]" id="producto'+num_prod+'_servicios'+cant_producto_servicios[num_prod]+'_arancel">';
                    htmlData += '<option value=""></option>';
                  htmlData += '</select>';
                htmlData += '</div>';
            htmlData += '</div>';
		htmlData += '</td>';
		htmlData += '<td><input type="text" class="form-control" name="producto'+num_prod+'_servicios_val1[]" id="producto'+num_prod+'_servicios'+cant_producto_servicios[num_prod]+'_val1" value=""></td>';
		htmlData += '<td>';
			htmlData += '<div class="form-group">';
                htmlData += '<div class="input-group" style="width:100%;">';
                  htmlData += '<select class="form-control" name="producto'+num_prod+'_servicios_val2[]" id="producto'+num_prod+'_servicios'+cant_producto_servicios[num_prod]+'_val2" onchange="actualizar_producto_servicio('+num_prod+', '+cant_producto_servicios[num_prod]+')">';
                    htmlData += '<option value="1"><?=mostrar_palabra(666, $palabras)?></option>';
                    htmlData += '<option value="2"><?=mostrar_palabra(667, $palabras)?></option>';
                    htmlData += '<option value="3"><?=mostrar_palabra(668, $palabras)?></option>';
                  htmlData += '</select>';
                htmlData += '</div>';
            htmlData += '</div>';
		htmlData += '</td>';
		htmlData += '<td><input type="number" step="any" class="form-control" name="producto'+num_prod+'_servicios_val3[]" id="producto'+num_prod+'_servicios'+cant_producto_servicios[num_prod]+'_val3" value="" onchange="actualizar_producto_servicio('+num_prod+', '+cant_producto_servicios[num_prod]+')"></td>';
		htmlData += '<td>';
			htmlData += '<div class="form-group">';
            htmlData += '<div class="input-group" style="width:100%;">';
              htmlData += '<select class="form-control" name="producto'+num_prod+'_servicios_moneda[]" id="producto'+num_prod+'_servicios'+cant_producto_servicios[num_prod]+'_moneda">';
                htmlData += '<option disabled style="display:none;"><?=mostrar_palabra(165, $palabras)?></option>';
                <?php
                foreach ($monedas as $moneda)
                {
                	$selected = '';
                	if($moneda['mon_code'] == $operations['mon_code'])
                	{
                		$selected = 'selected';
                		echo "htmlData += '<option value=\"".$moneda['mon_code']."\" ".$selected.">".$moneda['mon_code']." - ".$moneda['mon_simbolo']."</option>';";
                	}
                    //echo "htmlData += '<option value=\"".$moneda['mon_code']."\" ".$selected.">".$moneda['mon_code']." - ".$moneda['mon_simbolo']."</option>';";
                }
                ?>
              htmlData += '</select>';
            htmlData += '</div>';
        htmlData += '</div>';
		htmlData += '</td>';
		htmlData += '<td><input type="text" class="form-control" name="producto'+num_prod+'_servicios_val4[]" id="producto'+num_prod+'_servicios'+cant_producto_servicios[num_prod]+'_val4" value="0" readonly="readonly"></td>';
		htmlData += '<td>';
			htmlData += '<div class="input-group-btn">';
				htmlData += '<button type="button" class="btn btn-rojo2" onclick="eliminar_producto_servicio('+num_prod+','+cant_producto_servicios[num_prod]+')"><i class="fas fa-trash"></i></button>';
	            // htmlData += '<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-comment"></i></button>';
	            // htmlData += '<ul class="dropdown-menu dropdown-menu-right">';
	            //   htmlData += '<li><a href="javascript:abrir_comentar();"><i class="fas fa-comment"></i> Comentarios</a></li>';
	            //   htmlData += '<li><a href="javascript:;"><i class="fas fa-thumbs-up"></i> Aprobado</a></li>';
	            // htmlData += '</ul>';
	            htmlData += comentarios(0,0,0,0,0);
        	htmlData += '</div>';
        htmlData += '</td>';
	htmlData += '</tr>';

	$('#area_producto'+num_prod+'_servicios').append(htmlData);

	$('#producto'+num_prod+'_servicios'+cant_producto_servicios[num_prod]+'_arancel').ajaxChosen({
	  dataType: 'json',
	  type: 'POST',
	  url:'<?=site_url()?>productos/buscar_servicios_ajax'
	},{
	  loadingImg: '<?=base_url()?>assets/js/loading.gif',
	  minLength: 2
	},{
	  no_results_text: "<?=mostrar_palabra(246, $palabras)?> <i class='fa fa-search'></i>"
	}).chosen().change(function(e, params){
		$('#producto'+num_prod+'_servicios'+cant_producto_servicios[num_prod]+'_ara_id').val(params.selected);
	});

	$('#btn_agregar_producto'+num_prod+'_servicios').button('reset');
}

function eliminar_producto(num)
{
	$('#item_producto_'+num).hide();
	$('#arancel'+num+'_id').val('');
}

function eliminar_producto_servicio(prod_num, num)
{
	$('#item_producto'+prod_num+'_servicio'+num).hide();
	$('#producto'+prod_num+'_servicios'+num+'_val1').val('');
}

function actualizar_subtotal_productos()
{
	subtotal_general = 0;
	subtotal_productos = 0;
	for(var i=0; i<=cant_productos; i++)
	{
		subtotal_productos += parseInt($('#producto'+i+'_subtotal').val());

		for(var j=0; j<cant_producto_servicios[i]; j++)
		{
			subtotal_productos += parseInt($('#producto'+i+'_servicios'+j+'_val4').val());
		}
	}

	if(isNaN(subtotal_productos))
	{
		subtotal_productos = 0;
	}
	
	$('#comision_chk1_valor').html('$ '+subtotal_productos);
	subtotal_general += subtotal_productos;
	actualizar_otros_servicios();
}

function actualizar_subtotal_producto(num)
{
	var importe = $('#producto'+num+'_val4').val() * $('#producto'+num+'_val9').val();
	$('#producto'+num+'_subtotal').val(importe);
	
	for(var i=0; i<=cant_producto_servicios[num]; i++)
	{
		actualizar_producto_servicio(num, i);
	}

	actualizar_subtotal_productos();
}

function actualizar_producto_servicio(prod_num, serv_num)
{
	var importe = 0;
	if($('#producto'+prod_num+'_servicios'+serv_num+'_val2').val() == 1)
	{
		importe = $('#producto'+prod_num+'_subtotal').val() * $('#producto'+prod_num+'_servicios'+serv_num+'_val3').val() / 100;
	}
	else if($('#producto'+prod_num+'_servicios'+serv_num+'_val2').val() == 2)
	{
		importe = $('#producto'+prod_num+'_servicios'+serv_num+'_val3').val() * $('#producto'+prod_num+'_val4').val();
	}
	else if($('#producto'+prod_num+'_servicios'+serv_num+'_val2').val() == 3)
	{
		importe = $('#producto'+prod_num+'_servicios'+serv_num+'_val3').val();
	}
	$('#producto'+prod_num+'_servicios'+serv_num+'_val4').val(importe);
}
</script>