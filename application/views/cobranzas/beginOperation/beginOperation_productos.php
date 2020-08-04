<?php
$permiso_editar = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 4, $operations['cob_usr_tipo_id'], 3);
$readonly = '';
if(!$permiso_editar || $permiso_editar['cob_per_activo'] == 0)
{
	$readonly = 'readonly';
}

echo '<div class="row" style="margin-left:0px; margin-top:20px;">';
//echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(613, $palabras).' <i class="fas fa-unlock" aria-hidden="true"></i></div>';
	if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
	{
		echo '<div class="row">';
			echo '<div class="col-xs-12">';
				echo '<button id="btn_agregar_productos" type="button" class="btn btn-rojo2 pull-right" onclick="agregar_producto()">'.mostrar_palabra(28, $palabras).'</button>';
			echo '</div>';
		echo '</div>';
	}

	echo '<div id="area-productos">';
	if($productos)
	{
		foreach ($productos as $key_prod => $producto)
		{
			echo '<div id="item_producto_'.$key_prod.'">';
			echo '<hr>';
			echo '<div class="row">';
				echo '<input type="hidden" id="producto'.$key_prod.'_id" name="producto_id[]" value="'.$producto['cob_prod_id'].'">';
				echo '<input type="hidden" id="arancel'.$key_prod.'_id" name="arancel_id[]" value="'.$producto['ara_id'].'">';
			echo '<div class="col-xs-3">';
				echo '<div class="form-group">';
	                echo '<label for="arancel'.$key_prod.'"><i class="fa fa-code fa-lg texto-bordo2"></i> '.mostrar_palabra(22, $palabras).'</label>';
	                echo '<div class="input-group" style="width:100%;">';
	                  echo '<select data-num="'.$key_prod.'" data-placeholder="'.mostrar_palabra(245, $palabras).'..." class="chosen-select form-control" name="arancel[]" id="arancel'.$key_prod.'" '.$readonly.'>';
	                    echo '<option value=""></option>';
	                    echo "<option value='".$producto['ara_id']."' selected>".$producto['ara_code']." - ".$producto['ara_desc']."</option>\n";
	                  echo '</select>';
	                  $estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 2, $producto['cob_prod_id'], 1);
	                  comentarios(2, $producto['cob_prod_id'], 1, $estado);
	                echo '</div>';
	            echo '</div>';
			echo '</div>';
			echo '<div class="col-xs-3">';
				$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 2, $producto['cob_prod_id'], 2);
				input_text(mostrar_palabra(412, $palabras), 'producto'.$key_prod.'_val1', 'producto_val1[]', 'text', $producto['cob_prod_detalle'], $readonly, TRUE, $estado, 2, $producto['cob_prod_id'], 2);
			echo '</div>';
			echo '<div class="col-xs-3">';
				$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 2, $producto['cob_prod_id'], 3);
				input_text(mostrar_palabra(628, $palabras), 'producto'.$key_prod.'_val2', 'producto_val2[]', 'text', $producto['cob_prod_marca'], $readonly, TRUE, $estado, 2, $producto['cob_prod_id'], 3);
			echo '</div>';
		echo '</div>';
		echo '<div class="row">';
			echo '<div class="col-xs-3">';
				$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 2, $producto['cob_prod_id'], 4);
				input_text(mostrar_palabra(250, $palabras), 'producto'.$key_prod.'_val3', 'producto_val3[]', 'text', $producto['cob_prod_unidad'], $readonly, TRUE, $estado, 2, $producto['cob_prod_id'], 4);
			echo '</div>';
			echo '<div class="col-xs-3">';
				$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 2, $producto['cob_prod_id'], 5);
				input_text(mostrar_palabra(687, $palabras), 'producto'.$key_prod.'_val4', 'producto_val4[]', 'number', $producto['cob_prod_cantidad'], 'min="0" '.$readonly.' onchange="actualizar_subtotal_producto('.$key_prod.');"', TRUE, $estado, 2, $producto['cob_prod_id'], 5);
			echo '</div>';
			echo '<div class="col-xs-3">';
				$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 2, $producto['cob_prod_id'], 6);
				input_text(mostrar_palabra(684, $palabras), 'producto'.$key_prod.'_val5', 'producto_val5[]', 'number', $producto['cob_prod_tolerancia'], $readonly, TRUE, $estado, 2, $producto['cob_prod_id'], 6);
			echo '</div>';
		echo '</div>';
		echo '<div class="row">';
			echo '<div class="col-xs-3">';
				$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 2, $producto['cob_prod_id'], 7);
				input_text(mostrar_palabra(631, $palabras), 'producto'.$key_prod.'_val6', 'producto_val6[]', 'text', $producto['cob_prod_incoterm'], $readonly, TRUE, $estado, 2, $producto['cob_prod_id'], 7);
			echo '</div>';
			echo '<div class="col-xs-3">';
				echo '<div class="form-group">
	                <label for="pais'.$key_prod.'" style="font-weight:normal;">'.mostrar_palabra(689, $palabras).'</label>
	                <div class="input-group" style="width:100%;">
	                  <select class="form-control" name="pais[]" id="pais'.$key_prod.'" onchange="cargar_ciudades('.$key_prod.', this.value);" '.$readonly.'>
	                    <option disabled style="display:none;">'.mostrar_palabra(161, $palabras).'</option>';
		                foreach ($paises as $pais)
		                {
		                	$selected = "";
		                    if($pais['ctry_code'] == $producto['ctry_code'])
		                    {
		                    	$selected = "selected";
		                    }
		                    
		                    echo "<option value='".$pais['ctry_code']."' ".$selected.">".$pais['ctry_nombre']."</option>";
		                }
	                  echo '</select>';
	                  $estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 2, $producto['cob_prod_id'], 8);
	                  comentarios(2, $producto['cob_prod_id'], 8, $estado);
	                echo '</div>';
	            echo '</div>';
			echo '</div>';
			echo '<div class="col-xs-3">';
				echo '<div class="form-group">
		                <label for="ciudad'.$key_prod.'" style="font-weight:normal;">'.mostrar_palabra(688, $palabras).'</label>
		                <div class="input-group" style="width:100%;">
		                  <select class="form-control" name="ciudad[]" id="ciudad'.$key_prod.'" '.$readonly.'>
		                    <option disabled style="display:none;">'.mostrar_palabra(165, $palabras).'</option>';
		                    foreach ($producto['ciudades'] as $ciudad)
			                {
			                	$selected = "";
			                    if($producto['city_id'] == $ciudad['city_id'])
			                    {
			                    	$selected = "selected";
			                    }
			                    
			                    echo "<option value='".$ciudad['city_id']."' ".$selected.">";
			                      if($ciudad['city_nombre'] == $ciudad['toponymName'])
			                        echo $ciudad['city_nombre'];
			                      else
			                        echo $ciudad['city_nombre'] ." / ".$ciudad['toponymName'];
			                    echo "</option>";
			                }
		                  echo '</select>';
		                  $estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 2, $producto['cob_prod_id'], 9);
		                  comentarios(2, $producto['cob_prod_id'], 9, $estado);
		                echo '</div>';
		            echo '</div>';
			echo '</div>';
		echo '</div>';
		echo '<div class="row">';
			echo '<div class="col-xs-3">';
				echo '<div class="form-group">
		                <label for="moneda'.$key_prod.'" style="font-weight:normal;">'.mostrar_palabra(630, $palabras).'</label>
		                <div class="input-group" style="width:100%;">
		                  <select class="form-control" name="moneda[]" id="moneda'.$key_prod.'" '.$readonly.'>
		                    <option disabled style="display:none;">'.mostrar_palabra(165, $palabras).'</option>';
		                    foreach ($monedas as $moneda)
			                {
			                	$selected = "";
			                    if($producto['mon_code'] == $moneda['mon_code'])
			                    {
			                    	$selected = "selected";
			                    	echo '<option value="'.$moneda['mon_code'].'" '.$selected.'>'.$moneda['mon_code'].' - '.$moneda['mon_simbolo'].'</option>';
			                    }
			                    
			                    //echo '<option value="'.$moneda['mon_code'].'" '.$selected.'>'.$moneda['mon_code'].' - '.$moneda['mon_simbolo'].'</option>';
			                }
		                  echo '</select>';
		                  $estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 2, $producto['cob_prod_id'], 10);
		                  comentarios(2, $producto['cob_prod_id'], 10, $estado);
		                echo '</div>';
		            echo '</div>';
			echo '</div>';
			echo '<div class="col-xs-3">';
				$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 2, $producto['cob_prod_id'], 11);
				input_text(mostrar_palabra(690, $palabras), 'producto'.$key_prod.'_val9', 'producto_val9[]', 'number', $producto['cob_prod_precio'], $readonly.' onchange="actualizar_subtotal_producto('.$key_prod.');"', TRUE, $estado, 2, $producto['cob_prod_id'], 11);
			echo '</div>';
			echo '<div class="col-xs-3">';
				$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 2, $producto['cob_prod_id'], 12);
				input_text(mostrar_palabra(660, $palabras), 'producto'.$key_prod.'_subtotal', 'producto_subtotal[]', 'text', $producto['cob_prod_subtotal'], 'readonly', TRUE, $estado, 2, $producto['cob_prod_id'], 12);
			echo '</div>';
			if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
			{
				echo '<div class="col-xs-3">';
					echo '<div class="form-group">';
						echo '<label class="control-label">&nbsp;</label>';
						echo '<button type="button" class="btn btn-rojo2" onclick="eliminar_producto('.$key_prod.')" style="margin-top:25px;"><i class="fas fa-trash"></i></button>';
					echo '</div>';
				echo '</div>';
			}
		echo '</div>';
		

		echo '<div class="row" style="margin-left:0px; margin-top:20px;">';
			echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(661, $palabras).'</div>';
			if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
			{
				echo '<div class="row">';
	  				echo '<div class="col-xs-12">';
	  					echo '<button id="btn_agregar_producto'.$key_prod.'_servicios" type="button" class="btn btn-rojo2 pull-right" onclick="agregar_producto_servicios('.$key_prod.')">'.mostrar_palabra(28, $palabras).'</button>';
	  				echo '</div>';
	  			echo '</div>';
	  		}

  			echo '<div class="row">';
				echo '<div class="col-xs-12">';
					echo '<table class="table">';
						echo '<thead>';
							echo '<tr>';
								echo '<th>&nbsp;</th>';
								echo '<th>'.mostrar_palabra(21, $palabras).'</th>';
								echo '<th>'.mostrar_palabra(663, $palabras).'</th>';
								echo '<th>'.mostrar_palabra(664, $palabras).'</th>';
								echo '<th>'.mostrar_palabra(665, $palabras).'</th>';
								echo '<th>'.mostrar_palabra(630, $palabras).'</th>';
								echo '<th>'.mostrar_palabra(660, $palabras).'</th>';
								echo '<th>&nbsp;</th>';
							echo '</tr>';
						echo '</thead>';

						echo '<tbody id="area_producto'.$key_prod.'_servicios">';
						if($producto['servicios'])
			  			{
			  				foreach ($producto['servicios'] as $key => $value)
			  				{
								echo '<tr id="item_producto'.$key_prod.'_servicio'.$key.'">';
									echo '<input type="hidden" id="producto'.$key_prod.'_servicios'.$key.'_id" name="producto'.$key_prod.'_servicios_id[]" value="'.$value['cob_prod_serv_id'].'">';
									echo '<input type="hidden" id="producto'.$key_prod.'_servicios'.$key.'_ara_id" name="producto'.$key_prod.'_servicios_ara_id[]" value="'.$value['ara_id'].'">';
									echo '<td><label class="control-label">'.($key+1).'</label></td>';
									echo '<td>';
										echo '<div class="form-group">';
						 	                echo '<div class="input-group">';
						 	                  echo '<select data-num="'.$key.'" data-num_prod="'.$key_prod.'" data-placeholder="'.mostrar_palabra(245, $palabras).'..." class="chosen-servicios form-control" name="producto'.$key_prod.'_servicios_arancel[]" id="producto'.$key_prod.'_servicios'.$key.'_arancel" '.$readonly.'>';
						 	                    echo "<option value='".$value['ara_id']."' selected>".$value['ara_code']." - ".$value['ara_desc']."</option>\n";
						 	                  echo '</select>';
						 	                echo '</div>';
						 	            echo '</div>';
									echo '</td>';
									echo '<td><input type="text" class="form-control" name="producto'.$key_prod.'_servicios_val1[]" id="producto'.$key_prod.'_servicios'.$key.'_val1" value="'.$value['cob_prod_serv_descripcion'].'" '.$readonly.'></td>';
									echo '<td>';
										echo '<div class="form-group">';
								                echo '<div class="input-group" style="width:100%;">';
								                  echo '<select class="form-control" name="producto'.$key_prod.'_servicios_val2[]" id="producto'.$key_prod.'_servicios'.$key.'_val2" onchange="actualizar_producto_servicio('.$key_prod.', '.$key.')" '.$readonly.'>';
								                    $selected = "";
									                  if($value['cob_prod_serv_calculo_importe'] == 1)
									                  {
									                  	$selected = "selected";
									                  }
									                  echo '<option value="1">'.mostrar_palabra(666, $palabras).'</option>';

									                  $selected = "";
									                  if($value['cob_prod_serv_calculo_importe'] == 2)
									                  {
									                  	$selected = "selected";
									                  }
									                  echo '<option value="2">'.mostrar_palabra(667, $palabras).'</option>';

									                  $selected = "";
									                  if($value['cob_prod_serv_calculo_importe'] == 3)
									                  {
									                  	$selected = "selected";
									                  }
									                  echo '<option value="1">'.mostrar_palabra(668, $palabras).'</option>';
								                  echo '</select>';
								                echo '</div>';
								            echo '</div>';
									echo '</td>';
									echo '<td><input type="text" class="form-control" name="producto'.$key_prod.'_servicios_val3[]" id="producto'.$key_prod.'_servicios'.$key.'_val3" value="'.$value['cob_prod_serv_importe'].'" onchange="actualizar_producto_servicio('.$key_prod.', '.$key.')" '.$readonly.'></td>';
									echo '<td>';
										echo '<div class="form-group">';
						                echo '<div class="input-group" style="width:100%;">';
						                  echo '<select class="form-control" name="producto'.$key_prod.'_servicios_moneda[]" id="producto'.$key_prod.'_servicios'.$key.'_moneda" '.$readonly.'>';
						                    echo '<option disabled style="display:none;">'.mostrar_palabra(165, $palabras).'</option>';
						                    foreach ($monedas as $moneda)
							                {
							                	$selected = "";
							                    if($producto['mon_code'] == $moneda['mon_code'])
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
									echo '<td><input type="text" class="form-control" name="producto'.$key_prod.'_servicios_val4[]" id="producto'.$key_prod.'_servicios'.$key.'_val4" value="'.$value['cob_prod_serv_subtotal'].'" readonly="readonly"></td>';
									echo '<td>';
										echo '<div class="input-group-btn">';
											if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
											{
												echo '<button type="button" class="btn btn-rojo2" onclick="eliminar_producto_servicio('.$key_prod.','.$key.')"><i class="fas fa-trash"></i></button>';
											}
							                // echo '<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-comment"></i></button>';
							                // echo '<ul class="dropdown-menu dropdown-menu-right">';
							                //   echo '<li><a href="javascript:abrir_comentar();"><i class="fas fa-comment"></i> Comentarios</a></li>';
							                //   echo '<li><a href="javascript:;"><i class="fas fa-thumbs-up"></i> Aprobado</a></li>';
							                // echo '</ul>';
							                $estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 3, $value['cob_prod_serv_id'], 1);
							                comentarios(3, $value['cob_prod_serv_id'], 1, $estado, 0);
						            	echo '</div>';
						            echo '</td>';
								echo '</tr>';
							}
  						}
						echo '</tbody>';
					echo '</table>';
				echo '</div>';
			echo '</div>';

		echo '</div>';
		echo '</div>';
		}
	}
	else
	{
		if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
		{
			echo '<div id="item_producto_0">';
				echo '<hr>';
				echo '<div class="row">';
					echo '<input type="hidden" id="producto0_id" name="producto_id[]" value="">';
					echo '<input type="hidden" id="arancel0_id" name="arancel_id[]" value="">';
				echo '<div class="col-xs-3">';
					echo '<div class="form-group">';
		                echo '<label for="arancel0"><i class="fa fa-code fa-lg texto-bordo2"></i> '.mostrar_palabra(22, $palabras).'</label>';
		                echo '<div class="input-group" style="width:100%;">';
		                  echo '<select data-num="0" data-placeholder="'.mostrar_palabra(245, $palabras).'..." class="chosen-select form-control" name="arancel[]" id="arancel0">';
		                    echo '<option value=""></option>';
		                  echo '</select>';
		                  comentarios(0, 0, 0, 0);
		                echo '</div>';
		            echo '</div>';
				echo '</div>';
				echo '<div class="col-xs-3">';
					$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 2, 0, 1);
					input_text(mostrar_palabra(412, $palabras), 'producto0_val1', 'producto_val1[]', 'text', '', '', TRUE, $estado, 2, 0, 1);
				echo '</div>';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(628, $palabras), 'producto0_val2', 'producto_val2[]', 'text', '');
				echo '</div>';
			echo '</div>';
			echo '<div class="row">';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(250, $palabras), 'producto0_val3', 'producto_val3[]', 'text', '');
				echo '</div>';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(687, $palabras), 'producto0_val4', 'producto_val4[]', 'number', '', 'min="0" onchange="actualizar_subtotal_producto(0);"');
				echo '</div>';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(684, $palabras), 'producto0_val5', 'producto_val5[]', 'number', '');
				echo '</div>';
			echo '</div>';
			echo '<div class="row">';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(631, $palabras), 'producto0_val6', 'producto_val6[]', 'text', '');
				echo '</div>';
				echo '<div class="col-xs-3">';
					echo '<div class="form-group">';
		                echo '<label for="pais0" style="font-weight:normal;">'.mostrar_palabra(689, $palabras).'</label>';
		                echo '<div class="input-group" style="width:100%;">';
		                  echo '<select class="form-control" name="pais[]" id="pais0" onchange="cargar_ciudades(0, this.value);">';
		                    echo '<option selected disabled style="display:none;">'.mostrar_palabra(161, $palabras).'</option>';
			                foreach ($paises as $pais)
			                {
			                    echo "<option value='".$pais['ctry_code']."'>".$pais['ctry_nombre']."</option>";
			                }
		                  echo '</select>';
		                  comentarios(0, 0, 0, 0);
		                echo '</div>';
		            echo '</div>';
				echo '</div>';
				echo '<div class="col-xs-3">';
					echo '<div class="form-group">';
		                echo '<label for="ciudad0" style="font-weight:normal;">'.mostrar_palabra(688, $palabras).'</label>';
		                echo '<div class="input-group" style="width:100%;">';
		                  echo '<select class="form-control" name="ciudad[]" id="ciudad0">';
		                    echo '<option disabled style="display:none;">'.mostrar_palabra(165, $palabras).'</option>';
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
		                  echo '<select class="form-control" name="moneda[]" id="moneda0">';
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
					input_text(mostrar_palabra(690, $palabras), 'producto0_val9', 'producto_val9[]', 'number', '', 'onchange="actualizar_subtotal_producto(0);"');
				echo '</div>';
				echo '<div class="col-xs-3">';
					input_text(mostrar_palabra(660, $palabras), 'producto0_subtotal', 'producto_subtotal[]', 'text', '', 'readonly');
				echo '</div>';
				echo '<div class="col-xs-3">';
					echo '<div class="form-group">';
						//echo '<label class="control-label">&nbsp;</label>';
						echo '<button type="button" class="btn btn-rojo2" onclick="eliminar_producto(0)" style="margin-top:25px;"><i class="fas fa-trash"></i></button>';
					echo '</div>';
				echo '</div>';
			echo '</div>';

			echo '<div class="row" style="margin-left:0px; margin-top:20px;">';
				echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.mostrar_palabra(661, $palabras).'</div>';
				echo '<div class="row">';
					echo '<div class="col-xs-12">';
						echo '<button id="btn_agregar_producto0_servicios" type="button" class="btn btn-rojo2 pull-right" onclick="agregar_producto_servicios(0)">'.mostrar_palabra(28, $palabras).'</button>';
					echo '</div>';
				echo '</div>';

				echo '<div class="row">';
					echo '<div class="col-xs-12">';
						echo '<table class="table">';
							echo '<thead>';
								echo '<tr>';
									echo '<th>&nbsp;</th>';
									echo '<th>'.mostrar_palabra(21, $palabras).'</th>';
									echo '<th>'.mostrar_palabra(663, $palabras).'</th>';
									echo '<th>'.mostrar_palabra(664, $palabras).'</th>';
									echo '<th>'.mostrar_palabra(665, $palabras).'</th>';
									echo '<th>'.mostrar_palabra(630, $palabras).'</th>';
									echo '<th>'.mostrar_palabra(660, $palabras).'</th>';
									echo '<th>&nbsp;</th>';
								echo '</tr>';
							echo '</thead>';

							echo '<tbody id="area_producto0_servicios">';
								echo '<tr id="item_producto0_servicio0">';
									echo '<input type="hidden" id="producto0_servicios0_id" name="producto0_servicios_id[]" value="">';
									echo '<input type="hidden" id="producto0_servicios0_ara_id" name="producto0_servicios_ara_id[]" value="">';
									echo '<td>'.form_label('1', '', array('class' => 'control-label')).'</td>';
									echo '<td>';
										echo '<div class="form-group">';
						 	                echo '<div class="input-group" style="width:100%;">';
						 	                  echo '<select data-num="0" data-num_prod="0" data-placeholder="'.mostrar_palabra(245, $palabras).'..." class="chosen-servicios form-control" name="producto0_servicios_arancel[]" id="producto0_servicios0_arancel">';
						 	                    echo '<option value=""></option>';
						 	                  echo '</select>';
						 	                echo '</div>';
						 	            echo '</div>';
									echo '</td>';
									echo '<td><input type="text" class="form-control" name="producto0_servicios_val1[]" id="producto0_servicios0_val1" value=""></td>';
									echo '<td>';
										echo '<div class="form-group">';
							                echo '<div class="input-group" style="width:100%;">';
							                  echo '<select class="form-control" name="producto0_servicios_val2[]" id="producto0_servicios0_val2" onchange="actualizar_producto_servicio(0, 0)">';
							                    echo '<option value="1">'.mostrar_palabra(666, $palabras).'</option>';
							                    echo '<option value="2">'.mostrar_palabra(667, $palabras).'</option>';
							                    echo '<option value="3">'.mostrar_palabra(668, $palabras).'</option>';
							                  echo '</select>';
							                echo '</div>';
							            echo '</div>';
									echo '</td>';
									echo '<td><input type="text" class="form-control" name="producto0_servicios_val3[]" id="producto0_servicios0_val3" value="" onchange="actualizar_producto_servicio(0, 0)"></td>';
									echo '<td>';
										echo '<div class="form-group">';
						                echo '<div class="input-group" style="width:100%;">';
						                  echo '<select class="form-control" name="producto0_servicios_moneda[]" id="producto0_servicios0_moneda">';
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
						                echo '</div>';
						            echo '</div>';
									echo '</td>';
									echo '<td><input type="text" class="form-control" name="producto0_servicios_val4[]" id="producto0_servicios0_val4" value="0" readonly="readonly"></td>';
									echo '<td>';
										echo '<div class="input-group-btn">';
											echo '<button type="button" class="btn btn-rojo2" onclick="eliminar_producto_servicio(0,0)"><i class="fas fa-trash"></i></button>';
									        comentarios(0, 0, 0, 0, 0);
						            	echo '</div>';
						            echo '</td>';
								echo '</tr>';
							echo '</tbody>';
						echo '</table>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	}
	echo '</div>';
echo '</div>';
?>