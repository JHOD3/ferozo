<?php
$permiso_editar = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], 26, $operations['cob_usr_tipo_id'], 3);
$readonly = '';
$disabled = '';
if(!$permiso_editar || $permiso_editar['cob_per_activo'] == 0)
{
	$readonly = 'readonly';
	$disabled = 'disabled';
}

echo '<div class="row" style="margin-left:0px; margin-top:20px;">';
	echo '<div class="row">';
		echo '<div class="col-xs-3">';
			echo '<div class="form-group">';
	            echo '<label for="comision_calculo">'.mostrar_palabra(712, $palabras).'</label>';
	            echo '<div class="input-group" style="width:100%;">';
	              echo '<select class="form-control" name="comision_calculo" id="comision_calculo" onchange="actualizar_subtotal_comision()" '.$readonly.'>';
	              	$selected = "";
	              	if($comision['cob_com_calculo'] == 1)
	              	{
	              		$selected = "selected";
	              	}
	                echo '<option value="1" '.$selected.'>'.mostrar_palabra(722, $palabras).'</option>';

	                $selected = "";
	              	if($comision['cob_com_calculo'] == 2)
	              	{
	              		$selected = "selected";
	              	}
	                echo '<option value="2" '.$selected.'>'.mostrar_palabra(668, $palabras).'</option>';
	              echo '</select>';
	              $estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 7, 1, 1);
	              comentarios(7, 1, 1, $estado);
	            echo '</div>';
	        echo '</div>';
		echo '</div>';
		echo '<div class="col-xs-3">';
			// input_checkbox(mostrar_palabra(613, $palabras).' <span id="comision_chk1_valor">$ 0</span>', 'comision_chk1', 'comision_chk1', '1', '');
			// input_checkbox(mostrar_palabra(669, $palabras), 'comision_chk2', 'comision_chk2', '1', '');
			// input_checkbox(mostrar_palabra(614, $palabras), 'comision_chk3', 'comision_chk3', '1', '');
			// input_checkbox(mostrar_palabra(615, $palabras), 'comision_chk4', 'comision_chk4', '1', '');
			$checked_aux = '';
			if($comision['cob_com_calculo_productos'] == 1)
			{
				$checked_aux = 'checked';
			}
			echo '<div class="checkbox">';
                    echo '<label>';
                        echo '<input id="comision_chk1" name="comision_chk1" type="checkbox" value="1" '.$checked_aux.' onchange="actualizar_subtotal_comision()" '.$disabled.'>';
                        echo mostrar_palabra(613, $palabras).' <span id="comision_chk1_valor">$ 0</span>';
                    echo '</label>';
                echo '</div>';

            $checked_aux = '';
			if($comision['cob_com_calculo_servicios'] == 1)
			{
				$checked_aux = 'checked';
			}
            echo '<div class="checkbox">';
                    echo '<label>';
                        echo '<input id="comision_chk2" name="comision_chk2" type="checkbox" value="1" '.$checked_aux.' onchange="actualizar_subtotal_comision()" '.$disabled.'>';
                        echo mostrar_palabra(669, $palabras).' <span id="comision_chk2_valor">$ 0</span>';
                    echo '</label>';
                echo '</div>';

            $checked_aux = '';
			if($comision['cob_com_calculo_transporte'] == 1)
			{
				$checked_aux = 'checked';
			}
            echo '<div class="checkbox">';
                    echo '<label>';
                        echo '<input id="comision_chk3" name="comision_chk3" type="checkbox" value="1" '.$checked_aux.' onchange="actualizar_subtotal_comision()" '.$disabled.'>';
                        echo mostrar_palabra(614, $palabras).' <span id="comision_chk3_valor">$ 0</span>';
                    echo '</label>';
                echo '</div>';

            $checked_aux = '';
			if($comision['cob_com_calculo_seguros'] == 1)
			{
				$checked_aux = 'checked';
			}
            echo '<div class="checkbox">';
                    echo '<label>';
                        echo '<input id="comision_chk4" name="comision_chk4" type="checkbox" value="1" '.$checked_aux.' onchange="actualizar_subtotal_comision()" '.$disabled.'>';
                        echo mostrar_palabra(615, $palabras).' <span id="comision_chk4_valor">$ 0</span>';
                    echo '</label>';
                echo '</div>';
		echo '</div>';
		echo '<div class="col-xs-3">';
			$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 7, 1, 2);
			input_text(mostrar_palabra(721, $palabras), 'comision_suma', 'comision_suma', 'number', $comision['cob_com_calculo_suma'], 'readonly', TRUE, $estado, 7, 1, 2);
		echo '</div>';
	echo '</div>';

	echo '<div class="row">';
		echo '<div class="col-xs-3">';
			$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 7, 1, 3);
			input_text(mostrar_palabra(665, $palabras), 'comision_importe', 'comision_importe', 'number', $comision['cob_com_importe'], $readonly.' onchange="actualizar_subtotal_comision()"', TRUE, $estado, 7, 1, 3);
		echo '</div>';
		echo '<div class="col-xs-3">';
		echo '</div>';
		echo '<div class="col-xs-3">';
			$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 7, 1, 4);
			input_text(mostrar_palabra(713, $palabras), 'comision_total', 'comision_total', 'number', $comision['cob_com_total'], 'readonly', TRUE, $estado, 7, 1, 4);
		echo '</div>';
	echo '</div>';
echo '</div>';
?>