<?php
$permiso_editar = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 5, $operations['cob_usr_tipo_id'], 3);
$readonly = '';
if(!$permiso_editar || $permiso_editar['cob_per_activo'] == 0)
{
	$readonly = 'readonly';
}

	echo '<div class="row" style="margin-left:0px; margin-top:20px;">';
		//echo '<div class="title" style="margin-top:20px; font-weight:bold;">Otros servicios</div>';
		if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
		{
			echo '<div class="row">';
				echo '<div class="col-xs-12">';
					echo '<button type="button" id="btn_agregar_transportes" onclick="agregar_transporte()" class="btn btn-rojo2 pull-right">'.mostrar_palabra(28, $palabras).'</button>';
				echo '</div>';
			echo '</div>';
		}

		echo '<div id="area-transportes">';
		if($transportes)
		{
			foreach ($transportes as $key_trans => $transporte)
			{
				echo '<div id="item_transporte_'.$key_trans.'">';
					echo '<hr>';
					echo '<input type="hidden" id="transportes'.$key_trans.'_id" name="transportes_id[]" value="'.$transporte['cob_trans_id'].'">';
					echo '<div class="row">';
						echo '<div class="col-xs-3">';
							echo '<div class="form-group">';
				                echo '<label for="transportes'.$key_trans.'_val1">'.mostrar_palabra(691, $palabras).'</label>';
				                echo '<div class="input-group" style="width:100%;">';
				                  echo '<select class="form-control" name="transportes_val1[]" id="transportes'.$key_trans.'_val1" '.$readonly.'>';
				                  	$selected = "";
				                  	if($transporte['cob_trans_tipo_id'] == 1)
				                  	{
				                  		$selected = "selected";
				                  	}
				                    echo '<option value="1" '.$selected.'>Aereo</option>';

				                    $selected = "";
				                  	if($transporte['cob_trans_tipo_id'] == 2)
				                  	{
				                  		$selected = "selected";
				                  	}
				                    echo '<option value="2" '.$selected.'>Maritimo</option>';

				                    $selected = "";
				                  	if($transporte['cob_trans_tipo_id'] == 3)
				                  	{
				                  		$selected = "selected";
				                  	}
				                    echo '<option value="3" '.$selected.'>Terrestre</option>';
				                  echo '</select>';
				                  $estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 5, $transporte['cob_trans_id'], 1);
	                  			  comentarios(5, $transporte['cob_trans_id'], 1, $estado);
				                echo '</div>';
				            echo '</div>';
						echo '</div>';
						echo '<div class="col-xs-3">';
							$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 5, $transporte['cob_trans_id'], 2);
							input_text(mostrar_palabra(632, $palabras), 'transportes'.$key_trans.'_val2', 'transportes_val2[]', 'text', $transporte['cob_trans_nombre'], $readonly, TRUE, $estado, 5, $transporte['cob_trans_id'], 2);
						echo '</div>';
						echo '<div class="col-xs-3">';
							$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 5, $transporte['cob_trans_id'], 3);
							input_text(mostrar_palabra(633, $palabras), 'transportes'.$key_trans.'_val3', 'transportes_val3[]', 'text', $transporte['cob_trans_origen'], $readonly, TRUE, $estado, 5, $transporte['cob_trans_id'], 3);
						echo '</div>';
						echo '<div class="col-xs-3">';
							$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 5, $transporte['cob_trans_id'], 4);
							input_text(mostrar_palabra(634, $palabras), 'transportes'.$key_trans.'_val4', 'transportes_val4[]', 'text', $transporte['cob_trans_destino'], $readonly, TRUE, $estado, 5, $transporte['cob_trans_id'], 4);
						echo '</div>';
					echo '</div>';
					echo '<div class="row">';
						echo '<div class="col-xs-3">';
							$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 5, $transporte['cob_trans_id'], 5);
							input_text(mostrar_palabra(692, $palabras), 'transportes'.$key_trans.'_val5', 'transportes_val5[]', 'text', $transporte['cob_trans_numero'], $readonly, TRUE, $estado, 5, $transporte['cob_trans_id'], 5);
						echo '</div>';
						echo '<div class="col-xs-3">';
							$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 5, $transporte['cob_trans_id'], 6);
							input_text(mostrar_palabra(639, $palabras), 'transportes'.$key_trans.'_val6', 'transportes_val6[]', 'text', $transporte['cob_trans_container'], $readonly, TRUE, $estado, 5, $transporte['cob_trans_id'], 6);
						echo '</div>';
					echo '</div>';
					echo '<div class="row">';
						echo '<div class="col-xs-12">';
					        echo form_label(mostrar_palabra(693, $palabras), '', array('class' => 'control-label'));
						echo '</div>';
						echo '<div class="col-xs-3">';
							$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 5, $transporte['cob_trans_id'], 7);
							input_datepicker(mostrar_palabra(694, $palabras), 'transportes'.$key_trans.'_val7', 'transportes_val7[]', 'text', formatear_fecha($transporte['cob_trans_fecha_ini'],2), $readonly, TRUE, $estado, 5, $transporte['cob_trans_id'], 7);
						echo '</div>';
						echo '<div class="col-xs-3">';
							$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 5, $transporte['cob_trans_id'], 8);
							input_datepicker(mostrar_palabra(695, $palabras), 'transportes'.$key_trans.'_val8', 'transportes_val8[]', 'text', formatear_fecha($transporte['cob_trans_fecha_fin'],2), $readonly, TRUE, $estado, 5, $transporte['cob_trans_id'], 8);
						echo '</div>';
						echo '<div class="col-xs-3">';
							$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 5, $transporte['cob_trans_id'], 9);
							input_text(mostrar_palabra(637, $palabras), 'transportes'.$key_trans.'_val9', 'transportes_val9[]', 'text', $transporte['cob_trans_tiempo'], $readonly, TRUE, $estado, 5, $transporte['cob_trans_id'], 9);
						echo '</div>';
						echo '<div class="col-xs-3">';
							echo '<div class="form-group">';
				                echo '<label for="transportes'.$key_trans.'_val10">'.mostrar_palabra(636, $palabras).'</label>';
				                echo '<div class="input-group" style="width:100%;">';
				                  echo '<select class="form-control" name="transportes_val10[]" id="transportes'.$key_trans.'_val10" '.$readonly.'>';
				                  	$selected = "";
				                  	if($transporte['cob_trans_estado'] == 1)
				                  	{
				                  		$selected = "selected";
				                  	}
				                    echo '<option value="1" '.$selected.'>A bordo</option>';

				                    $selected = "";
				                  	if($transporte['cob_trans_estado'] == 2)
				                  	{
				                  		$selected = "selected";
				                  	}
				                    echo '<option value="2" '.$selected.'>Para cargar</option>';
				                  echo '</select>';
				                  $estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 5, $transporte['cob_trans_id'], 10);
				                  comentarios(5, $transporte['cob_trans_id'], 10, $estado);
				                echo '</div>';
				            echo '</div>';
						echo '</div>';
					echo '</div>';
					echo '<div class="row">';
						echo '<div class="col-xs-3">';
							echo '<div class="form-group">';
				                echo '<label for="moneda'.$key_trans.'" style="font-weight:normal;">'.mostrar_palabra(630, $palabras).'</label>';
				                echo '<div class="input-group" style="width:100%;">';
				                  echo '<select class="form-control" name="transportes_val11[]" id="transportes'.$key_trans.'_val11" '.$readonly.'>';
				                    echo '<option disabled style="display:none;">'.mostrar_palabra(165, $palabras).'</option>';
				                    foreach ($monedas as $moneda)
					                {
					                	$selected = "";
					                    if($transporte['mon_code'] == $moneda['mon_code'])
					                    {
					                    	$selected = "selected";
					                    	echo '<option value="'.$moneda['mon_code'].'" '.$selected.'>'.$moneda['mon_code'].' - '.$moneda['mon_simbolo'].'</option>';
					                    }
					                    
					                    //echo '<option value="'.$moneda['mon_code'].'" '.$selected.'>'.$moneda['mon_code'].' - '.$moneda['mon_simbolo'].'</option>';
					                }
				                  echo '</select>';
				                  $estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 5, $transporte['cob_trans_id'], 11);
				                  comentarios(5, $transporte['cob_trans_id'], 11, $estado);
				                echo '</div>';
				            echo '</div>';
						echo '</div>';
						echo '<div class="col-xs-3">';
							$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 5, $transporte['cob_trans_id'], 12);
							input_text(mostrar_palabra(696, $palabras), 'transportes'.$key_trans.'_val12', 'transportes_val12[]', 'text', $transporte['cob_trans_importe'], $readonly, TRUE, $estado, 5, $transporte['cob_trans_id'], 12);
						echo '</div>';
						echo '<div class="col-xs-3">';
							echo '<div class="form-group">';
				                echo '<label for="transportes'.$key_trans.'_val13">'.mostrar_palabra(707, $palabras).'</label>';
				                echo '<div class="input-group" style="width:100%;">';
				                  echo '<select class="form-control" name="transportes_val13[]" id="transportes'.$key_trans.'_val13" '.$readonly.'>';
				                  	$selected = "";
				                    if($transporte['cob_trans_forma_pago'] == 1)
				                    {
				                    	$selected = "selected";
				                    }
				                    echo '<option value="1" '.$selected.'>'.mostrar_palabra(708, $palabras).'</option>';

				                    $selected = "";
				                    if($transporte['cob_trans_forma_pago'] == 2)
				                    {
				                    	$selected = "selected";
				                    }
				                    echo '<option value="2" '.$selected.'>'.mostrar_palabra(709, $palabras).'</option>';

				                    $selected = "";
				                    if($transporte['cob_trans_forma_pago'] == 3)
				                    {
				                    	$selected = "selected";
				                    }
				                    echo '<option value="3" '.$selected.'>'.mostrar_palabra(710, $palabras).'</option>';

				                    $selected = "";
				                    if($transporte['cob_trans_forma_pago'] == 4)
				                    {
				                    	$selected = "selected";
				                    }
				                    echo '<option value="4" '.$selected.'>'.mostrar_palabra(711, $palabras).'</option>';
				                  echo '</select>';
				                  $estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 5, $transporte['cob_trans_id'], 13);
				                  comentarios(5, $transporte['cob_trans_id'], 13, $estado);
				                echo '</div>';
				            echo '</div>';
						echo '</div>';
						if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
						{
							echo '<div class="col-xs-3">';
								echo '<div class="form-group">';
									echo '<label class="control-label">&nbsp;</label>';
									echo '<button type="button" class="form-control btn btn-rojo2" onclick="eliminar_transporte('.$key_trans.')"><i class="fas fa-trash"></i></button>';
								echo '</div>';
							echo '</div>';
						}
					echo '</div>';
				echo '</div>';
			}
		}
		else
		{
			echo '<div id="item_transporte_0">';
				echo '<hr>';
				echo '<input type="hidden" id="transportes0_id" name="transportes_id[]" value="">';
				echo '<div class="row">';
					echo '<div class="col-xs-3">';
						echo '<div class="form-group">';
			                echo '<label for="transportes0_val1">'.mostrar_palabra(691, $palabras).'</label>';
			                echo '<div class="input-group" style="width:100%;">';
			                  echo '<select class="form-control" name="transportes_val1[]" id="transportes0_val1" '.$readonly.'>';
			                    echo '<option value="1">Aereo</option>';
			                    echo '<option value="2">Maritimo</option>';
			                    echo '<option value="3">Terrestre</option>';
			                  echo '</select>';
	                  		  comentarios(0, 0, 0, 0);
			                echo '</div>';
			            echo '</div>';
					echo '</div>';
					echo '<div class="col-xs-3">';
						input_text(mostrar_palabra(632, $palabras), 'transportes0_val2', 'transportes_val2[]', 'text', '', $readonly);
					echo '</div>';
					echo '<div class="col-xs-3">';
						input_text(mostrar_palabra(633, $palabras), 'transportes0_val3', 'transportes_val3[]', 'text', '', $readonly);
					echo '</div>';
					echo '<div class="col-xs-3">';
						input_text(mostrar_palabra(634, $palabras), 'transportes0_val4', 'transportes_val4[]', 'text', '', $readonly);
					echo '</div>';
				echo '</div>';
				echo '<div class="row">';
					echo '<div class="col-xs-3">';
						input_text(mostrar_palabra(692, $palabras), 'transportes0_val5', 'transportes_val5[]', 'text', '', $readonly);
					echo '</div>';
					echo '<div class="col-xs-3">';
						input_text(mostrar_palabra(639, $palabras), 'transportes0_val6', 'transportes_val6[]', 'text', '', $readonly);
					echo '</div>';
				echo '</div>';
				echo '<div class="row">';
					echo '<div class="col-xs-12">';
				        echo form_label(mostrar_palabra(693, $palabras), '', array('class' => 'control-label'));
					echo '</div>';
					echo '<div class="col-xs-3">';
						input_datepicker(mostrar_palabra(694, $palabras), 'transportes0_val7', 'transportes_val7[]', 'text', '', $readonly);
					echo '</div>';
					echo '<div class="col-xs-3">';
						input_datepicker(mostrar_palabra(695, $palabras), 'transportes0_val8', 'transportes_val8[]', 'text', '', $readonly);
					echo '</div>';
					echo '<div class="col-xs-3">';
						input_text(mostrar_palabra(637, $palabras), 'transportes0_val9', 'transportes_val9[]', 'text', '', $readonly);
					echo '</div>';
					echo '<div class="col-xs-3">';
						echo '<div class="form-group">';
			                echo '<label for="transportes0_val10">'.mostrar_palabra(636, $palabras).'</label>';
			                echo '<div class="input-group" style="width:100%;">';
			                  echo '<select class="form-control" name="transportes_val10[]" id="transportes0_val10" '.$readonly.'>';
			                    echo '<option value="1">A bordo</option>';
			                    echo '<option value="2">Para cargar</option>';
			                  echo '</select>';
			                  comentarios(0, 0, 0, 0);
			                echo '</div>';
			            echo '</div>';
					echo '</div>';
				echo '</div>';
				echo '<div class="row">';
					echo '<div class="col-xs-3">';
						echo '<div class="form-group">';
			                echo '<label for="moneda0" style="font-weight:normal;">'.mostrar_palabra(630, $palabras).'</label>';
			                echo '<div class="input-group" style="width:100%;">';
			                  echo '<select class="form-control" name="transportes_val11[]" id="transportes0_val11" '.$readonly.'>';
			                    echo '<option disabled style="display:none;">'.mostrar_palabra(165, $palabras).'</option>';
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
			                  comentarios(0, 0, 0, 0);
			                echo '</div>';
			            echo '</div>';
					echo '</div>';
					echo '<div class="col-xs-3">';
						input_text(mostrar_palabra(696, $palabras), 'transportes0_val12', 'transportes_val12[]', 'text', '', $readonly);
					echo '</div>';
					echo '<div class="col-xs-3">';
						echo '<div class="form-group">';
			                echo '<label for="transportes0_val13">'.mostrar_palabra(707, $palabras).'</label>';
			                echo '<div class="input-group" style="width:100%;">';
			                  echo '<select class="form-control" name="transportes_val13[]" id="transportes0_val13" '.$readonly.'>';
			                  	$selected = "";
			                    echo '<option value="1" '.$selected.'>'.mostrar_palabra(708, $palabras).'</option>';
			                    echo '<option value="2" '.$selected.'>'.mostrar_palabra(709, $palabras).'</option>';
			                    echo '<option value="3" '.$selected.'>'.mostrar_palabra(710, $palabras).'</option>';
			                    echo '<option value="4" '.$selected.'>'.mostrar_palabra(711, $palabras).'</option>';
			                  echo '</select>';
			                  comentarios(0, 0, 0, 0);
			                echo '</div>';
			            echo '</div>';
					echo '</div>';
					if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
					{
						echo '<div class="col-xs-3">';
							echo '<div class="form-group">';
								echo '<label class="control-label">&nbsp;</label>';
								echo '<button type="button" class="form-control btn btn-rojo2" onclick="eliminar_transporte(0)"><i class="fas fa-trash"></i></button>';
							echo '</div>';
						echo '</div>';
					}
				echo '</div>';
			echo '</div>';
		}
		echo '</div>'; //fin area-transportes
	echo '</div>';
?>