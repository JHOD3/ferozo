<?php
$permiso_ver = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], $permiso, $operations['cob_usr_tipo_id'], 1);
if($permiso_ver && $permiso_ver['cob_per_activo'] == 1)
{
	$permiso_comentar = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], $permiso, $operations['cob_usr_tipo_id'], 2);
	if($permiso_comentar && $permiso_comentar['cob_per_activo'] == 1)
	{
		$permiso_comentar = TRUE;
	}
	else
	{
		$permiso_comentar = FALSE;
	}
	
	//echo $operations['cob_id'].' '.$permiso.' '.$operations['cob_usr_tipo_id'].'<br>';
	$permiso_editar = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], $permiso, $operations['cob_usr_tipo_id'], 3);
	$readonly = '';
	if(!$permiso_editar || $permiso_editar['cob_per_activo'] == 0)
	{
		$readonly = 'readonly';
	}
	
	$permiso_confirmar = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $operations['cob_id'], $permiso, $operations['cob_usr_tipo_id'], 4);
	if($permiso_confirmar && $permiso_confirmar['cob_per_activo'] == 1)
	{
		$permiso_confirmar = TRUE;
	}
	else
	{
		$permiso_confirmar = FALSE;
	}
	
	echo '<div class="col-xs-3">';
		echo '<div class="title" style="margin-top:20px; font-weight:bold;">'.$title;
		//echo ' <button class="btn btn-xs btn-default" onclick="abrir_permisos();" type="button"><i class="fas fa-unlock" aria-hidden="true"></i></button>';
		echo '</div>';
		echo '<input type="hidden" name="usr_'.($key+1).'_emp_'.($num_empresa+1).'_id" id="usr_'.($key+1).'_emp_'.($num_empresa+1).'_id" value="'.$tipo['empresas'][$num_empresa]['cob_emp_id'].'">';
		$cant_items = 7;

		$base_item_id = $num_empresa_offset*$cant_items;
		$item_id = $tipo['empresas'][$num_empresa]['cob_emp_id'];
		if(!$item_id)
		{
			$item_id = 0;
		}

		$num_aux = 1;
		$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 1, $item_id, ($base_item_id+$num_aux));
		input_text(mostrar_palabra(  13, $palabras), 'usr_'.($key+1).'_emp_'.($num_empresa+1).'_item_'.$num_aux, 'usr_'.($key+1).'_emp_'.($num_empresa+$num_aux).'_item_'.$num_aux, 'text', $tipo['empresas'][$num_empresa]['cob_emp_nombre'], $readonly, TRUE, $estado, 1, $item_id, ($base_item_id+$num_aux), $permiso_comentar, $permiso_confirmar);

		$num_aux = 2;
		$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 1, $item_id, ($base_item_id+$num_aux));
		input_select(mostrar_palabra( 2, $palabras), 'usr_'.($key+1).'_emp_'.($num_empresa+1).'_item_'.$num_aux, $paises, $tipo['empresas'][$num_empresa]['ctry_code'], 'ctry_code', 'ctry_nombre', $readonly.' onchange="cargar_ciudades_empresa(this.value, '.($key+1).', '.($num_empresa+1).');"', TRUE, $estado, 1, $item_id, ($base_item_id+$num_aux), $permiso_comentar, $permiso_confirmar);

		$num_aux = 3;
		$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 1, $item_id, ($base_item_id+$num_aux));
		input_select(mostrar_palabra(32, $palabras), 'usr_'.($key+1).'_emp_'.($num_empresa+1).'_item_'.$num_aux, array(array('city_id'=>$tipo['empresas'][$num_empresa]['city_id'], 'city_nombre'=>$tipo['empresas'][$num_empresa]['city_nombre'])), $tipo['empresas'][$num_empresa]['city_id'], 'city_id', 'city_nombre', $readonly, TRUE, $estado, 1, $item_id, ($base_item_id+$num_aux), $permiso_comentar, $permiso_confirmar);
		/*
		echo '<div class="form-group">';
		    echo '<label class="control-label" style="font-weight:normal;">'.mostrar_palabra(32, $palabras).'</label>';
		    echo '<div class="input-group">';
			    echo '<select class="form-control" name="usr_'.($key+1).'_emp_'.($num_empresa+1).'_item_'.$num_aux.'" id="usr_'.($key+1).'_emp_'.($num_empresa+1).'_item_'.$num_aux.'" '.$readonly.'>';
			        echo '<option value="">'.mostrar_palabra(165, $palabras).'</option>';
			        if($tipo['empresas'][$num_empresa]['city_id'])
			        {
			            echo '<option value="'.$tipo['empresas'][$num_empresa]['city_id'].'" selected>'.$tipo['empresas'][$num_empresa]['city_nombre'].'</option>';
			        }
			    echo '</select>';
			    comentarios(1, $item_id, ($base_item_id+$num_aux), $estado, 1, $permiso_comentar, $permiso_confirmar);
		    echo '</div>';
		echo '</div>';
		*/

		$num_aux = 4;
		$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 1, $item_id, ($base_item_id+$num_aux));
		input_text(mostrar_palabra( 130, $palabras), 'usr_'.($key+1).'_emp_'.($num_empresa+1).'_item_'.$num_aux, 'usr_'.($key+1).'_emp_'.($num_empresa+1).'_item_'.$num_aux, 'text', $tipo['empresas'][$num_empresa]['cob_emp_cp'], $readonly, TRUE, $estado, 1, $item_id, ($base_item_id+$num_aux), $permiso_comentar, $permiso_confirmar);

		$num_aux = 5;
		$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 1, $item_id, ($base_item_id+$num_aux));
		input_text(mostrar_palabra( 131, $palabras), 'usr_'.($key+1).'_emp_'.($num_empresa+1).'_item_'.$num_aux, 'usr_'.($key+1).'_emp_'.($num_empresa+1).'_item_'.$num_aux, 'text', $tipo['empresas'][$num_empresa]['cob_emp_direccion'], $readonly, TRUE, $estado, 1, $item_id, ($base_item_id+$num_aux), $permiso_comentar, $permiso_confirmar);

		$num_aux = 6;
		$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 1, $item_id, ($base_item_id+$num_aux));
		input_text(mostrar_palabra( 133, $palabras), 'usr_'.($key+1).'_emp_'.($num_empresa+1).'_item_'.$num_aux, 'usr_'.($key+1).'_emp_'.($num_empresa+1).'_item_'.$num_aux, 'text', $tipo['empresas'][$num_empresa]['cob_emp_telefono'], $readonly, TRUE, $estado, 1, $item_id, ($base_item_id+$num_aux), $permiso_comentar, $permiso_confirmar);

		$num_aux = 7;
		$estado = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $operations['cob_id'], 1, $item_id, ($base_item_id+$num_aux));
		input_text(mostrar_palabra(   4, $palabras), 'usr_'.($key+1).'_emp_'.($num_empresa+1).'_item_'.$num_aux, 'usr_'.($key+1).'_emp_'.($num_empresa+1).'_item_'.$num_aux, 'text', $tipo['empresas'][$num_empresa]['cob_emp_mail'], $readonly, TRUE, $estado, 1, $item_id, ($base_item_id+$num_aux), $permiso_comentar, $permiso_confirmar);
	echo '</div>';
}
?>