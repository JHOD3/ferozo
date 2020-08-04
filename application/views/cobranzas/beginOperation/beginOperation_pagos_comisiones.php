<?php
$permiso_editar = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 7, $operations['cob_usr_tipo_id'], 3);
$readonly = '';
if(!$permiso_editar || $permiso_editar['cob_per_activo'] == 0)
{
	$readonly = 'readonly';
}

echo '<div class="row" style="margin-left:0px; margin-top:20px;">';
	echo '<div class="row">';
		echo '<div class="col-xs-3">';
			echo '<div class="form-group">';
                echo '<label for="moneda_pagos" style="font-weight:normal;">'.mostrar_palabra(630, $palabras).'</label>';
                echo '<div class="input-group" style="width:100%;">';
                  echo '<select class="form-control" name="moneda_pagos_comisiones" id="moneda_pagos_comisiones">';
                    foreach ($monedas as $moneda)
	                {
	                	$selected = '';
	                	if($moneda['mon_code'] == $operations['mon_code'])
	                	{
	                		$selected = 'selected';
	                		echo '<option value="'.$moneda['mon_code'].'" '.$selected.'>'.$moneda['mon_code'].' - '.$moneda['mon_simbolo'].'</option>';
	                	}
	                    //echo '<option value="'.$moneda['mon_code'].'" '.$selected.'>'.$moneda['mon_code'].' - '.$moneda['mon_simbolo'].'</option>';
	                }
                  echo '</select>';
                echo '</div>';
            echo '</div>';
		echo '</div>';
		echo '<div class="col-xs-3">';
			input_text('Total comisión', 'subtotal_pagos_comisiones', 'subtotal_pagos_comisiones', 'number', '0', 'readonly', FALSE);
		echo '</div>';
	echo '</div>';

	if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
	{
		echo '<div class="row">';
			echo '<div class="col-xs-12">';
				echo '<button type="button" id="btn_agregar_pagos_comisiones" class="btn btn-rojo2 pull-right" onclick="agregar_pago_comisiones()"><i class="fas fa-plus"></i> Pagos comisión</button>';
			echo '</div>';
		echo '</div>';
	}

		echo '<div class="row">';
			echo '<div class="col-xs-12">';
				echo '<table class="table">';
					echo '<thead>';
						echo '<tr>';
							echo '<th>&nbsp;</th>';
							echo '<th>'.mostrar_palabra(715, $palabras).'</th>';
							echo '<th>'.mostrar_palabra(400, $palabras).'</th>';
							echo '<th>'.mostrar_palabra(685, $palabras).'</th>';
							echo '<th>'.mostrar_palabra(716, $palabras).'</th>';
							echo '<th>'.mostrar_palabra(665, $palabras).'</th>';
							echo '<th>'.mostrar_palabra(630, $palabras).'</th>';
							echo '<th>'.mostrar_palabra(717, $palabras).'</th>';
							echo '<th>'.mostrar_palabra(718, $palabras).'</th>';
							//echo '<th>'.mostrar_palabra(719, $palabras).'</th>';
							echo '<th>&nbsp;</th>';
						echo '</tr>';
					echo '</thead>';

					echo '<tbody id="area-pagos_comisiones">';
						if($pagos_comisiones)
						{
							foreach ($pagos_comisiones as $key_pago => $pago)
							{
								echo '<tr id="item_pagos_comisiones_'.$key_pago.'">';
									echo '<input type="hidden" name="pagos_comisiones_id[]" id="pagos_comisiones'.$key_pago.'_id" value="'.$pago['cob_pago_com_id'].'">';
									echo '<td><label class="control-label">'.($key_pago+1).'</label></td>';
									echo '<td><input type="text" class="form-control" name="pagos_comisiones_val1[]" id="pagos_comisiones'.$key_pago.'_val1" value="'.$pago['cob_pago_com_descripcion'].'" '.$readonly.'></td>';
									echo '<td><input type="text" class="form-control datepicker" name="pagos_comisiones_val2[]" id="pagos_comisiones'.$key_pago.'_val2" value="'.formatear_fecha($pago['cob_pago_com_fecha'],2).'" '.$readonly.'></td>';
									echo '<td>';
										echo '<div class="form-group">';
							                echo '<div class="input-group" style="width:100%;">';
							                  echo '<select class="form-control" name="pagos_comisiones_val3[]" id="pagos_comisiones'.$key_pago.'_val3" '.$readonly.'>';
							                  	$selected = "";
							                  	if($pago['cob_pago_com_hito'] == 1)
							                  	{
							                  		$selected = "selected";
							                  	}
							                    echo '<option value="1" '.$selected.'>Hitos</option>';
							                  echo '</select>';
							                echo '</div>';
							            echo '</div>';
						            echo '</td>';
									echo '<td>';
										echo '<div class="form-group">';
							                echo '<div class="input-group" style="width:100%;">';
							                  echo '<select class="form-control" name="pagos_comisiones_val4[]" id="pagos_comisiones'.$key_pago.'_val4" onchange="actualizar_pago_comisiones('.$key_pago.')" '.$readonly.'>';
							                    $selected = "";
							                  	if($pago['cob_pago_com_calculo'] == 1)
							                  	{
							                  		$selected = "selected";
							                  	}
							                    echo '<option value="1" '.$selected.'>Porcentaje del subtotal</option>';

							                    $selected = "";
							                  	if($pago['cob_pago_com_calculo'] == 2)
							                  	{
							                  		$selected = "selected";
							                  	}
							                    echo '<option value="2" '.$selected.'>Monto fijo</option>';
							                  echo '</select>';
							                echo '</div>';
							            echo '</div>';
						            echo '</td>';
									echo '<td><input type="number" class="form-control" name="pagos_comisiones_val5[]" id="pagos_comisiones'.$key_pago.'_val5" value="'.$pago['cob_pago_com_importe'].'" onchange="actualizar_pago_comisiones('.$key_pago.')" '.$readonly.'></td>';
									echo '<td>';
							        	echo '<div class="form-group">';
							                echo '<div class="input-group" style="width:100%;">';
							                  	echo '<select class="form-control" name="pagos_comisiones_val6[]" id="pagos_comisiones'.$key_pago.'_val6" '.$readonly.'>';
								                    foreach ($monedas as $moneda)
									                {
									                	$selected = "";
									                    if($pago['mon_code'] == $moneda['mon_code'])
									                    {
									                    	$selected = "selected";
									                    	echo '<option value="'.$moneda['mon_code'].'" '.$selected.'>'.$moneda['mon_code'].' - '.$moneda['mon_simbolo'].'</option>';
									                    }
									                    //echo '<option value="'.$moneda['mon_code'].'" '.$selected.'>'.$moneda['mon_code'].' - '.$moneda['mon_simbolo'].'</option>';
									                }
								                echo '</select>';
							                echo '</div>';
						            	echo '</div>';
						            echo '</td>';
									echo '<td><input type="number" class="form-control" name="pagos_comisiones_val7[]" id="pagos_comisiones'.$key_pago.'_val7" value="'.$pago['cob_pago_com_subtotal'].'" readonly></td>';
							        echo '<td>';
							        	echo '<div class="form-group">';
							                echo '<div class="input-group" style="width:100%;">';
							                  	echo '<select class="form-control" name="pagos_comisiones_val8[]" id="pagos_comisiones'.$key_pago.'_val8" '.$readonly.'>';
								                    $selected = "";
								                  	if($pago['cob_pago_com_metodo'] == 1)
								                  	{
								                  		$selected = "selected";
								                  	}
								                    echo '<option value="1" '.$selected.'>Transferencia bancaria</option>';

								                    $selected = "";
								                  	if($pago['cob_pago_com_metodo'] == 2)
								                  	{
								                  		$selected = "selected";
								                  	}
								                    echo '<option value="2" '.$selected.'>Efectivo</option>';
							                  	echo '</select>';
							                echo '</div>';
						            	echo '</div>';
						            echo '</td>';
						            //echo '<td><input type="text" class="form-control" name="pagos_comisiones_val9[]" id="pagos'.$key_pago.'_val9" value=""></td>';
									echo '<td>';
										echo '<div class="input-group-btn">';
											if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
											{
												echo '<button type="button" class="btn btn-rojo2" onclick="eliminar_pago_comisiones('.$key_pago.')"><i class="fas fa-trash"></i></button>';
											}
							                $estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 9, $pago['cob_pago_com_id'], 1);
											comentarios(9, $pago['cob_pago_com_id'], 1, $estado, 0);
						              	echo '</div>';
					              	echo '</td>';
								echo '</tr>';
							}
						}
						else
						{
							echo '<tr id="item_pagos_comisiones_0">';
								echo '<input type="hidden" name="pagos_comisiones_id[]" id="pagos_comisiones0_id" value="">';
								echo '<td><label class="control-label">1</label></td>';
								echo '<td><input type="text" class="form-control" name="pagos_comisiones_val1[]" id="pagos_comisiones0_val1" value="" '.$readonly.'></td>';
								echo '<td><input type="text" class="form-control datepicker" name="pagos_comisiones_val2[]" id="pagos_comisiones0_val2" value="" '.$readonly.'></td>';
								echo '<td>';
									echo '<div class="form-group">';
						                echo '<div class="input-group" style="width:100%;">';
						                  echo '<select class="form-control" name="pagos_comisiones_val3[]" id="pagos_comisiones0_val3" '.$readonly.'>';
						                    echo '<option value="1">Hitos</option>';
						                  echo '</select>';
						                echo '</div>';
						            echo '</div>';
					            echo '</td>';
								echo '<td>';
									echo '<div class="form-group">';
						                echo '<div class="input-group" style="width:100%;">';
						                  echo '<select class="form-control" name="pagos_comisiones_val4[]" id="pagos_comisiones0_val4" onchange="actualizar_pago_comisiones(0)" '.$readonly.'>';
						                    echo '<option value="1">Porcentaje del subtotal</option>';
						                    echo '<option value="2">Monto fijo</option>';
						                  echo '</select>';
						                echo '</div>';
						            echo '</div>';
					            echo '</td>';
								echo '<td><input type="number" class="form-control" name="pagos_comisiones_val5[]" id="pagos_comisiones0_val5" value="0" onchange="actualizar_pago_comisiones(0)" '.$readonly.'></td>';
								echo '<td>';
						        	echo '<div class="form-group">';
						                echo '<div class="input-group" style="width:100%;">';
						                  	echo '<select class="form-control" name="pagos_comisiones_val6[]" id="pagos_comisiones0_val6" '.$readonly.'>';
							                    foreach ($monedas as $moneda)
								                {
								                	$selected = '';
								                	if($moneda['mon_code'] == $operations['mon_code'])
								                	{
								                		$selected = 'selected';
								                		echo '<option value="'.$moneda['mon_code'].'" '.$selected.'>'.$moneda['mon_code'].' - '.$moneda['mon_simbolo'].'</option>';
								                	}
								                    //echo '<option value="'.$moneda['mon_code'].'" '.$selected.'>'.$moneda['mon_code'].' - '.$moneda['mon_simbolo'].'</option>';
								                }
							                echo '</select>';
						                echo '</div>';
					            	echo '</div>';
					            echo '</td>';
								echo '<td><input type="number" class="form-control" name="pagos_comisiones_val7[]" id="pagos_comisiones0_val7" value="0" readonly></td>';
						        echo '<td>';
						        	echo '<div class="form-group">';
						                echo '<div class="input-group" style="width:100%;">';
						                  	echo '<select class="form-control" name="pagos_comisiones_val8[]" id="pagos_comisiones0_val8" '.$readonly.'>';
							                    echo '<option value="1">Transferencia bancaria</option>';
							                    echo '<option value="2">Efectivo</option>';
						                  	echo '</select>';
						                echo '</div>';
					            	echo '</div>';
					            echo '</td>';
					            //echo '<td><input type="text" class="form-control" name="pagos_comisiones_val9[]" id="pagos_comisiones0_val9" value=""></td>';
								echo '<td>';
									echo '<div class="input-group-btn">';
										if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
										{
											echo '<button type="button" class="btn btn-rojo2" onclick="eliminar_pago_comisiones(0)"><i class="fas fa-trash"></i></button>';
										}
						                comentarios(0, 0, 0, 0, 0);
					              	echo '</div>';
				              	echo '</td>';
							echo '</tr>';
						}
					echo '</tbody>';

				echo '</table>';
			echo '</div>';
		echo '</div>';
		
echo '</div>';
?>