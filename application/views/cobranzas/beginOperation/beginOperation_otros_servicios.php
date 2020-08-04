<?php
$permiso_editar = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 25, $operations['cob_usr_tipo_id'], 3);
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
						  					echo '<button id="btn_agregar_otros_servicios" type="button" class="btn btn-rojo2 pull-right" onclick="agregar_otros_servicios()">'.mostrar_palabra(28, $palabras).'</button>';
						  				echo '</div>';
						  			echo '</div>';
						  		}

				  				echo '<div class="row">';
					  				echo '<div class="col-xs-12">';
					  					echo '<table class="table">';
					  						echo '<thead>';
						  						echo '<tr>';
						  							echo '<th>&nbsp;</th>';
						  							echo '<th>Descripcion</th>';
						  							echo '<th>Tipo</th>';
						  							echo '<th>Fecha</th>';
						  							echo '<th>Calculo importe</th>';
						  							echo '<th>Importe</th>';
						  							echo '<th>Subtotal</th>';
						  							echo '<th>Metodo pago</th>';
						  							echo '<th>&nbsp;</th>';
						  						echo '</tr>';
					  						echo '</thead>';

					  						echo '<tbody id="area_otros_servicios">';
					  						if($otros_servicios)
					  						{
					  							foreach ($otros_servicios as $key_otro => $otro_serv)
					  							{
					  								echo '<tr id="item_otros_servicios'.$key_otro.'">';
							  							echo '<input type="hidden" id="otros_servicios'.$key_otro.'_id" name="otros_servicios_id[]" value="'.$otro_serv['cob_otro_serv_id'].'">';
							  							echo '<td>'.form_label(($key_otro+1), '', array('class' => 'control-label')).'</td>';
							  							echo '<td><input type="text" class="form-control" name="otros_servicios_val1[]" id="otros_servicios'.$key_otro.'_val1" value="'.$otro_serv['cob_otro_serv_descripcion'].'" '.$readonly.'></td>';
												        echo '<td>';
															echo '<div class="form-group">';
											 	                echo '<div class="input-group">';
											 	                  echo '<select data-num="'.$key_otro.'" data-placeholder="'.mostrar_palabra(245, $palabras).'..." class="chosen-servicios form-control" name="otros_servicios_val2[]" id="otros_servicios'.$key_otro.'_val2" '.$readonly.'>';
											 	                    echo "<option value='".$otro_serv['ara_id']."' selected>".$otro_serv['ara_code']." - ".$otro_serv['ara_desc']."</option>\n";
											 	                  echo '</select>';
											 	                echo '</div>';
											 	            echo '</div>';
														echo '</td>';
							  							echo '<td><input type="text" class="form-control datepicker" name="otros_servicios_val3[]" id="otros_servicios'.$key_otro.'_val3" value="'.formatear_fecha($otro_serv['cob_otro_serv_fecha'],2).'" '.$readonly.'></td>';
							  							echo '<td><div class="form-group">';
												                echo '<div class="input-group" style="width:100%;">';
												                  echo '<select class="form-control" name="otros_servicios_val4[]" id="otros_servicios'.$key_otro.'_val4" onchange="actualizar_otro_servicio('.$key_otro.')" '.$readonly.'>';
												                    $selected = "";
													                if($otro_serv['cob_otro_serv_calculo_importe'] == 1)
													                {
													                  	$selected = "selected";
													                }
												                    echo '<option value="1" '.$selected.'>Porcentaje del subtotal</option>';

												                    $selected = "";
													                if($otro_serv['cob_otro_serv_calculo_importe'] == 2)
													                {
													                  	$selected = "selected";
													                }
												                    echo '<option value="2" '.$selected.'>Monto fijo</option>';
												                  echo '</select>';
												                echo '</div>';
												            echo '</div></td>';
							  							echo '<td><input type="text" class="form-control" name="otros_servicios_val5[]" id="otros_servicios'.$key_otro.'_val5" value="'.$otro_serv['cob_otro_serv_importe'].'" onchange="actualizar_otro_servicio('.$key_otro.')" '.$readonly.'></td>';
							  							echo '<td><input type="text" class="form-control" name="otros_servicios_val6[]" id="otros_servicios'.$key_otro.'_val6" value="'.$otro_serv['cob_otro_serv_subtotal'].'" readonly="readonly" '.$readonly.'></td>';
							  							echo '<td><div class="form-group">';
												                echo '<div class="input-group" style="width:100%;">';
												                  echo '<select class="form-control" name="otros_servicios_val7[]" id="otros_servicios'.$key_otro.'_val7" '.$readonly.'>';
												                    $selected = "";
													                if($otro_serv['cob_otro_serv_metodo_pago'] == 1)
													                {
													                  	$selected = "selected";
													                }
												                    echo '<option value="1" '.$selected.'>Transferencia bancaria</option>';

												                    $selected = "";
													                if($otro_serv['cob_otro_serv_metodo_pago'] == 2)
													                {
													                  	$selected = "selected";
													                }
												                    echo '<option value="2" '.$selected.'>Efectivo</option>';
												                  echo '</select>';
												                echo '</div>';
												            echo '</div></td>';
							  							echo '<td>';
							  								echo '<div class="input-group-btn">';
								  								if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
																{
								  									echo '<button type="button" class="btn btn-rojo2" onclick="eliminar_otro_servicio('.$key_otro.')"><i class="fas fa-trash"></i></button>';
								  								}
								  								$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 4, $otro_serv['cob_otro_serv_id'], 1);
												                comentarios(4, $otro_serv['cob_otro_serv_id'], 1, $estado, 0);
											              	echo '</div>';
											              echo '</td>';
							  						echo '</tr>';
					  							}
					  						}
					  						else
					  						{
						  						echo '<tr id="item_otros_servicios0">';
						  							echo '<input type="hidden" id="otros_servicios0_id" name="otros_servicios_id[]" value="">';
						  							echo '<td>'.form_label('1', '', array('class' => 'control-label')).'</td>';
						  							echo '<td><input type="text" class="form-control" name="otros_servicios_val1[]" id="otros_servicios0_val1" value=""></td>';
						  							echo '<td>';
											            echo '<div class="form-group">';
										 	                echo '<div class="input-group" style="width:100%;">';
										 	                  echo '<select data-num="0" data-placeholder="'.mostrar_palabra(245, $palabras).'..." class="chosen-servicios form-control" name="otros_servicios_val2[]" id="otros_servicios0_val2">';
										 	                    echo '<option value=""></option>';
										 	                  echo '</select>';
										 	                echo '</div>';
										 	            echo '</div>';
											        echo '</td>';
						  							echo '<td><input type="text" class="form-control datepicker" name="otros_servicios_val3[]" id="otros_servicios0_val3" value=""></td>';
						  							echo '<td>';
						  								echo '<div class="form-group">';
											                echo '<div class="input-group" style="width:100%;">';
											                  echo '<select class="form-control" name="otros_servicios_val4[]" id="otros_servicios0_val4" onchange="actualizar_otro_servicio(0)">';
											                    echo '<option value="1">Porcentaje del subtotal</option>';
											                    echo '<option value="2">Monto fijo</option>';
											                  echo '</select>';
											                echo '</div>';
											            echo '</div>';
											        echo '</td>';
						  							echo '<td><input type="text" class="form-control" name="otros_servicios_val5[]" id="otros_servicios0_val5" value="" onchange="actualizar_otro_servicio(0)"></td>';
						  							echo '<td><input type="text" class="form-control" name="otros_servicios_val6[]" id="otros_servicios0_val6" value="" readonly="readonly"></td>';
						  							echo '<td>';
						  								echo '<div class="form-group">';
											                echo '<div class="input-group" style="width:100%;">';
											                  echo '<select class="form-control" name="otros_servicios_val7[]" id="otros_servicios0_val7">';
											                    echo '<option value="1">Transferencia bancaria</option>';
											                    echo '<option value="2">Efectivo</option>';
											                  echo '</select>';
											                echo '</div>';
											            echo '</div>';
											        echo '</td>';
						  							echo '<td>';
						  								echo '<div class="input-group-btn">';
							  								echo '<button type="button" class="btn btn-rojo2" onclick="eliminar_otro_servicio(0)"><i class="fas fa-trash"></i></button>';
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