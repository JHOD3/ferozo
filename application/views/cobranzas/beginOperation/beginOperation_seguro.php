<?php
$permiso_editar = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 6, $operations['cob_usr_tipo_id'], 3);
$readonly = '';
if(!$permiso_editar || $permiso_editar['cob_per_activo'] == 0)
{
	$readonly = 'readonly';
}

echo '<div class="row" style="margin-left:0px; margin-top:20px;">';
	if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
	{
		echo '<div class="row">';
			echo '<div class="col-xs-12">';
				echo '<button type="button" id="btn_agregar_seguros" class="btn btn-rojo2 pull-right" onclick="agregar_seguro()">'.mostrar_palabra(28, $palabras).'</button>';
			echo '</div>';
		echo '</div>';
	}

	echo '<div id="area-seguros">';
	if($seguros)
	{
		foreach ($seguros as $key_seg => $seguro)
		{
			echo '<div id="item_seguros_'.$key_seg.'">';
				echo '<hr>';
				echo '<input type="hidden" id="seguros'.$key_seg.'_id" name="seguros_id[]" value="'.$seguro['cob_seg_id'].'">';
				echo '<div class="row">';
					echo '<div class="col-xs-3">';
						$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 6, $seguro['cob_seg_id'], 1);
						input_text(mostrar_palabra(640, $palabras), 'seguros'.$key_seg.'_val1', 'seguros_val1[]', 'text', $seguro['cob_seg_numero'], $readonly, TRUE, $estado, 6, $seguro['cob_seg_id'], 1);
					echo '</div>';
					echo '<div class="col-xs-3">';
						echo '<div class="form-group">';
					        echo '<label for="seguros'.$key_seg.'_val2" style="font-weight:normal;">'.mostrar_palabra(697, $palabras).'</label>';
					        echo '<div class="input-group" style="width:100%;">';
					          echo '<select class="form-control" name="seguros_val2[]" id="seguros'.$key_seg.'_val2" '.$readonly.'>';
					          	$selected = "";
					          	if($seguro['cob_seg_tipo_id'] == 1)
					          	{
					          		$selected = "selected";
					          	}
					            echo '<option value="1" '.$selected.'>'.mostrar_palabra(698, $palabras).'</option>';

					            $selected = "";
					          	if($seguro['cob_seg_tipo_id'] == 2)
					          	{
					          		$selected = "selected";
					          	}
					            echo '<option value="2" '.$selected.'>'.mostrar_palabra(699, $palabras).'</option>';

					            $selected = "";
					          	if($seguro['cob_seg_tipo_id'] == 3)
					          	{
					          		$selected = "selected";
					          	}
					            echo '<option value="3" '.$selected.'>'.mostrar_palabra(700, $palabras).'</option>';

					            $selected = "";
					          	if($seguro['cob_seg_tipo_id'] == 4)
					          	{
					          		$selected = "selected";
					          	}
					            echo '<option value="4" '.$selected.'>'.mostrar_palabra(701, $palabras).'</option>';
					          echo '</select>';
					          $estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 6, $seguro['cob_seg_id'], 2);
					          comentarios(6, $seguro['cob_seg_id'], 2, $estado);
					        echo '</div>';
					    echo '</div>';
					echo '</div>';
					echo '<div class="col-xs-3">';
						$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 6, $seguro['cob_seg_id'], 3);
						input_datepicker(mostrar_palabra(702, $palabras), 'seguros'.$key_seg.'_val3', 'seguros_val3[]', 'text', formatear_fecha($seguro['cob_seg_fecha_emision'],2), $readonly, TRUE, $estado, 6, $seguro['cob_seg_id'], 3);
					echo '</div>';
					echo '<div class="col-xs-3">';
						$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 6, $seguro['cob_seg_id'], 4);
						input_text(mostrar_palabra(626, $palabras), 'seguros'.$key_seg.'_val4', 'seguros_val4[]', 'text', $seguro['cob_seg_empresa'], $readonly, TRUE, $estado, 6, $seguro['cob_seg_id'], 4);
					echo '</div>';
				echo '</div>';
				echo '<div class="row">';
					echo '<div class="col-xs-12">';
						echo '<label>'.mostrar_palabra(641, $palabras).'</label>';
					echo '</div>';
					echo '<div class="col-xs-3">';
						$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 6, $seguro['cob_seg_id'], 5);
						input_text(mostrar_palabra(10, $palabras), 'seguros'.$key_seg.'_val5', 'seguros_val5[]', 'text', $seguro['cob_seg_nombre'], $readonly, TRUE, $estado, 6, $seguro['cob_seg_id'], 5);
					echo '</div>';
					echo '<div class="col-xs-3">';
						$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 6, $seguro['cob_seg_id'], 6);
						input_text(mostrar_palabra(11, $palabras), 'seguros'.$key_seg.'_val6', 'seguros_val6[]', 'text', $seguro['cob_seg_apellido'], $readonly, TRUE, $estado, 6, $seguro['cob_seg_id'], 6);
					echo '</div>';
				echo '</div>';
				echo '<div class="row">';
					echo '<div class="col-xs-3">';
						$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 6, $seguro['cob_seg_id'], 7);
						input_text(mostrar_palabra(133, $palabras), 'seguros'.$key_seg.'_val7', 'seguros_val7[]', 'text', $seguro['cob_seg_telefono'], $readonly, TRUE, $estado, 6, $seguro['cob_seg_id'], 7);
					echo '</div>';
					echo '<div class="col-xs-3">';
						$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 6, $seguro['cob_seg_id'], 8);
						input_text(mostrar_palabra(4, $palabras), 'seguros'.$key_seg.'_val8', 'seguros_val8[]', 'text', $seguro['cob_seg_mail'], $readonly, TRUE, $estado, 6, $seguro['cob_seg_id'], 8);
					echo '</div>';
				echo '</div>';
				echo '<div class="row">';
					echo '<div class="col-xs-3">';
						$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 6, $seguro['cob_seg_id'], 9);
						input_text(mostrar_palabra(642, $palabras), 'seguros'.$key_seg.'_val9', 'seguros_val9[]', 'text', $seguro['cob_seg_prima'], $readonly.' onchange="actualizar_subtotal_seguros('.$key_seg.')"', TRUE, $estado, 6, $seguro['cob_seg_id'], 9);
					echo '</div>';
					echo '<div class="col-xs-3">';
						echo '<div class="form-group">';
			                echo '<label for="seguros'.$key_seg.'_val10">'.mostrar_palabra(707, $palabras).'</label>';
			                echo '<div class="input-group" style="width:100%;">';
			                  echo '<select class="form-control" name="seguros_val10[]" id="seguros'.$key_seg.'_val10" '.$readonly.'>';
			                  	$selected = "";
					          	if($seguro['cob_seg_forma_pago'] == 1)
					          	{
					          		$selected = "selected";
					          	}
			                    echo '<option value="1" '.$selected.'>'.mostrar_palabra(708, $palabras).'</option>';

			                    $selected = "";
					          	if($seguro['cob_seg_forma_pago'] == 2)
					          	{
					          		$selected = "selected";
					          	}
			                    echo '<option value="2" '.$selected.'>'.mostrar_palabra(709, $palabras).'</option>';

			                    $selected = "";
					          	if($seguro['cob_seg_forma_pago'] == 3)
					          	{
					          		$selected = "selected";
					          	}
			                    echo '<option value="3" '.$selected.'>'.mostrar_palabra(710, $palabras).'</option>';

			                    $selected = "";
					          	if($seguro['cob_seg_forma_pago'] == 4)
					          	{
					          		$selected = "selected";
					          	}
			                    echo '<option value="4" '.$selected.'>'.mostrar_palabra(711, $palabras).'</option>';
			                  echo '</select>';
			                  $estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 6, $seguro['cob_seg_id'], 10);
			                  comentarios(6, $seguro['cob_seg_id'], 10, $estado);
			                echo '</div>';
			            echo '</div>';
					echo '</div>';
				echo '</div>';
				echo '<div class="row">';
					echo '<div class="col-xs-3">';
						$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 6, $seguro['cob_seg_id'], 11);
						input_text(mostrar_palabra(703, $palabras), 'seguros'.$key_seg.'_val11', 'seguros_val11[]', 'text', $seguro['cob_seg_monto'], $readonly, TRUE, $estado, 6, $seguro['cob_seg_id'], 11);
					echo '</div>';
					echo '<div class="col-xs-3">';
						$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 6, $seguro['cob_seg_id'], 12);
						input_text(mostrar_palabra(704, $palabras), 'seguros'.$key_seg.'_val12', 'seguros_val12[]', 'text', $seguro['cob_seg_descripcion'], $readonly, TRUE, $estado, 6, $seguro['cob_seg_id'], 12);
					echo '</div>';
				echo '</div>';
				echo '<div class="row">';
					echo '<div class="col-xs-9">';
						$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 6, $seguro['cob_seg_id'], 13);
						input_textarea(mostrar_palabra(705, $palabras), 'seguros'.$key_seg.'_val13', 'seguros_val13[]', $seguro['cob_seg_procedimiento'], $readonly, TRUE, $estado, 6, $seguro['cob_seg_id'], 13);
					echo '</div>';
					if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
					{
						echo '<div class="col-xs-3">';
							echo '<div class="form-group">';
								echo '<label class="control-label">&nbsp;</label>';
								echo '<button type="button" class="form-control btn btn-rojo2" onclick="eliminar_seguro('.$key_seg.')"><i class="fas fa-trash"></i></button>';
							echo '</div>';
						echo '</div>';
					}
				echo '</div>';
			echo '</div>';
		}
	}
	else
	{
		echo '<div id="item_seguros_0">';
			echo '<hr>';
			echo '<input type="hidden" id="seguros0_id" name="seguros_id[]" value="">';
			echo '<div class="row">';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(640, $palabras), 'seguros0_val1', 'seguros_val1[]', 'text', '', $readonly);
				echo '</div>';
				echo '<div class="col-xs-3">';
					echo '<div class="form-group">';
				        echo '<label for="seguros0_val2" style="font-weight:normal;">'.mostrar_palabra(697, $palabras).'</label>';
				        echo '<div class="input-group" style="width:100%;">';
				          echo '<select class="form-control" name="seguros_val2[]" id="seguros0_val2" '.$readonly.'>';
				            echo '<option value="1">'.mostrar_palabra(698, $palabras).'</option>';
				            echo '<option value="2">'.mostrar_palabra(699, $palabras).'</option>';
				            echo '<option value="3">'.mostrar_palabra(700, $palabras).'</option>';
				            echo '<option value="4">'.mostrar_palabra(701, $palabras).'</option>';
				          echo '</select>';
				          comentarios(0, 0, 0, 0);
				        echo '</div>';
				    echo '</div>';
				echo '</div>';
				echo '<div class="col-xs-3">';
					input_datepicker(mostrar_palabra(702, $palabras), 'seguros0_val3', 'seguros_val3[]', 'text', '', $readonly);
				echo '</div>';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(626, $palabras), 'seguros0_val4', 'seguros_val4[]', 'text', '', $readonly);
				echo '</div>';
			echo '</div>';
			echo '<div class="row">';
				echo '<div class="col-xs-12">';
					echo '<label>'.mostrar_palabra(641, $palabras).'</label>';
				echo '</div>';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(10, $palabras), 'seguros0_val5', 'seguros_val5[]', 'text', '', $readonly);
				echo '</div>';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(11, $palabras), 'seguros0_val6', 'seguros_val6[]', 'text', '', $readonly);
				echo '</div>';
			echo '</div>';
			echo '<div class="row">';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(133, $palabras), 'seguros0_val7', 'seguros_val7[]', 'text', '', $readonly);
				echo '</div>';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(4, $palabras), 'seguros0_val8', 'seguros_val8[]', 'text', '', $readonly);
				echo '</div>';
			echo '</div>';
			echo '<div class="row">';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(642, $palabras), 'seguros0_val9', 'seguros_val9[]', 'text', '', $readonly.' onchange="actualizar_subtotal_seguros(0)"');
				echo '</div>';
				echo '<div class="col-xs-3">';
					echo '<div class="form-group">';
		                echo '<label for="seguros0_val10">'.mostrar_palabra(707, $palabras).'</label>';
		                echo '<div class="input-group" style="width:100%;">';
		                  echo '<select class="form-control" name="seguros_val10[]" id="seguros0_val10" '.$readonly.'>';
		                    echo '<option value="1">'.mostrar_palabra(708, $palabras).'</option>';
		                    echo '<option value="2">'.mostrar_palabra(709, $palabras).'</option>';
		                    echo '<option value="3">'.mostrar_palabra(710, $palabras).'</option>';
		                    echo '<option value="4">'.mostrar_palabra(711, $palabras).'</option>';
		                  echo '</select>';
		                  comentarios(0, 0, 0, 0);
		                echo '</div>';
		            echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '<div class="row">';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(703, $palabras), 'seguros0_val11', 'seguros_val11[]', 'text', '', $readonly);
				echo '</div>';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(704, $palabras), 'seguros0_val12', 'seguros_val12[]', 'text', '', $readonly);
				echo '</div>';
			echo '</div>';
			echo '<div class="row">';
				echo '<div class="col-xs-9">';
					input_textarea(mostrar_palabra(705, $palabras), 'seguros0_val13', 'seguros_val13[]', mostrar_palabra(706, $palabras), $readonly);
				echo '</div>';
				echo '<div class="col-xs-3">';
					echo '<div class="form-group">';
						echo '<label class="control-label">&nbsp;</label>';
						echo '<button type="button" class="form-control btn btn-rojo2" onclick="eliminar_seguro(0)"><i class="fas fa-trash"></i></button>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
	echo '</div>';
echo '</div>';
?>