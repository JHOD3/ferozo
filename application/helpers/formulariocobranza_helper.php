<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function input_text($display='Nombre', $id='nombre', $campo='nombre', $type='text', $value='', $extra='', $comentar=TRUE, $estado=0, $tipo=0, $item_id=0, $num=0, $permiso_comentar=TRUE, $permiso_confirmar=TRUE)
{
    echo '<div class="form-group">';
        $attributes = array(
            'class' => 'control-label',
            'style' => 'font-weight:normal;'
        );
        echo form_label($display, $campo, $attributes);
        //echo '<div class="col-md-10">';
        $data = array(
            'type'          => $type,
            'name'          => $campo,
            'id'            => $id,
            'class'         => 'form-control',
            'value'         => set_value($campo),
            'step'          => 'any'
        );
        if(is_array(set_value($campo)))
        {
            $data['value'] = set_value($campo)[0];
        }
        
        if($value!="")
        {
            $data['value'] = $value;
        }
        if(form_error($campo))
        {
            $data['class'] = 'form-control parsley-error';
        }

        echo '<div class="input-group">';
        echo form_input($data, $data['value'], $extra);
        //echo '<ul class="parsley-errors-list filled"><li class="parsley-required">'.form_error($campo).'</li></ul>';
        if($comentar)
        {
            comentarios($tipo, $item_id, $num, $estado, 1, $permiso_comentar, $permiso_confirmar);
        }
        echo '</div>';
    echo '</div>';
}

function input_datepicker($display='Nombre', $id='nombre', $campo='nombre', $type='text', $value='', $extra='', $comentar=TRUE, $estado=0, $tipo=0, $item_id=0, $num=0, $permiso_comentar=TRUE, $permiso_confirmar=TRUE)
{
    echo '<div class="form-group">';
        $attributes = array(
            'class' => 'control-label',
            'style' => 'font-weight:normal;'
        );
        echo form_label($display, $campo, $attributes);
        //echo '<div class="col-md-10">';
        $data = array(
            'type'          => $type,
            'name'          => $campo,
            'id'            => $id,
            'class'         => 'form-control datepicker',
            'value'         => set_value($campo),
            'step'          => 'any'
        );
        if(is_array(set_value($campo)))
        {
            $data['value'] = set_value($campo)[0];
        }
        
        if($value!="")
        {
            $data['value'] = $value;
        }
        if(form_error($campo))
        {
            $data['class'] = 'form-control datepicker parsley-error';
        }

        echo '<div class="input-group">';
        echo form_input($data, $data['value'], $extra);
        //echo '<ul class="parsley-errors-list filled"><li class="parsley-required">'.form_error($campo).'</li></ul>';
        if($comentar)
        {
            comentarios($tipo, $item_id, $num, $estado, 1, $permiso_comentar, $permiso_confirmar);
        }
        echo '</div>';
    echo '</div>';
}

function input_textarea($display='Nombre', $id='nombre', $campo='nombre', $value='', $extra='', $comentar=TRUE, $estado=0, $tipo=0, $item_id=0, $num=0, $permiso_comentar=TRUE, $permiso_confirmar=TRUE)
{
    echo '<div class="form-group">';
        $attributes = array(
            'class' => 'col-md-3 control-label',
            'style' => 'font-weight:normal;'
        );
        echo form_label($display, $campo, $attributes);
        //echo '<div class="col-md-10">';
        $data = array(
            'name'          => $campo,
            'id'            => $id,
            'class'         => 'form-control',
            'value'         => set_value($campo)
        );
        if($value!="")
        {
            $data['value'] = $value;
        }
        if(form_error($campo))
        {
            $data['class'] = 'form-control parsley-error';
        }
        echo '<div class="input-group">';
        echo form_textarea($data, $data['value'], $extra);
        //echo '<ul class="parsley-errors-list filled"><li class="parsley-required">'.form_error($campo).'</li></ul>';
        if($comentar)
        {
            comentarios($tipo, $item_id, $num, $estado, 1, $permiso_comentar, $permiso_confirmar);
        }
        echo '</div>';
        //echo '</div>';
    echo '</div>';
}

function input_select($display='Nombre', $campo='nombre', $options='', $value='', $id='', $descripcion='', $extra='', $comentar=TRUE, $estado=0, $tipo=0, $item_id=0, $num=0, $permiso_comentar=TRUE, $permiso_confirmar=TRUE)
{
    $array_aux = array();
    $value_aux = "";
    if($id != '' && $descripcion != '')
    {
        $array_aux[''] = 'Seleccionar';
        $array_descripcion = explode('|', $descripcion);
        //Armo el array de opciones
        foreach ($options as $key_option => $option)
        {
            $texto_aux = "";
            if($array_descripcion && count($array_descripcion)>0)
            {
                foreach ($array_descripcion as $key_desc => $value_desc)
                {
                    $texto_aux .= $option[$value_desc]." ";
                }
            }
            else
            {
                $texto_aux = $option[$descripcion];
            }
            $array_aux[$option[$id]] = $texto_aux;

            if($option[$id] == $value)
            {
                $value_aux = $texto_aux;
            }
        }
    }
    else
    {
        $array_aux = $options;
    }

    if(strpos($extra, 'readonly') !== FALSE)
    {
        echo '<input type="hidden" name="'.$campo.'" id="'.$campo.'" value="'.$value.'">';
        input_text($display, 'aux_'.$campo, 'aux_'.$campo, 'text', $value_aux, $extra, $comentar, $estado, $tipo, $item_id, $num, $permiso_comentar, $permiso_confirmar);
        return TRUE;
    }

    echo '<div class="form-group">';
        $attributes = array(
            'class' => 'control-label',
            'style' => 'font-weight:normal;'
        );
        echo form_label($display, $campo, $attributes);
        echo '<div class="" id="area_'.$campo.'">';
        $data = array(
            'name'          => $campo,
            'id'            => $campo,
            'class'         => 'form-control',
            'value'         => set_value($campo),
            'options'       => $array_aux
        );
        if($value!="")
        {
            $data['value'] = $value;
        }
        if(form_error($campo))
        {
            $data['class'] = 'form-control parsley-error';
        }
        echo '<div class="input-group">';
        echo form_dropdown($data, $array_aux, $value, $extra);
        if($comentar)
        {
            comentarios($tipo, $item_id, $num, $estado, 1, $permiso_comentar, $permiso_confirmar);
        }
        echo '</div>';
        //echo '<ul class="parsley-errors-list filled"><li class="parsley-required">'.form_error($campo).'</li></ul>';
        echo '</div>';
    echo '</div>';
}

function input_checkbox($display='Nombre', $id='nombre', $campo='nombre', $value='', $checked = FALSE)
{
    /*
    echo '<div class="form-group">';
        $attributes = array(
            'class' => 'col-md-2 control-label',
            'style' => ''
        );
        echo form_label($display, $campo, $attributes);
        echo '<div class="col-md-10 checkbox">';
        $data = array(
            'name'          => $campo,
            'id'            => $campo,
            'value'         => set_value($campo),
            'checked'       => $checked,
            'style'         => ''
        );
        if($value!="")
        {
            $data['value'] = $value;
        }
        if(form_error($campo))
        {
            $data['class'] = 'form-control parsley-error';
        }
        echo form_checkbox($data);
        echo '<ul class="parsley-errors-list filled"><li class="parsley-required">'.form_error($campo).'</li></ul>';
        echo '</div>';
    echo '</div>';
    */
    $checked_aux = "";
    if($checked)
    {
        $checked_aux = "checked";
    }
    echo '<div class="form-group">
            <div class="col-md-12">
                <div class="checkbox">
                    <label>
                        <input id="'.$id.'" name="'.$campo.'" type="checkbox" value="'.$value.'" '.$checked_aux.'>
                        '.$display.'
                    </label>
                </div>
            </div>
        </div>';
    
}

function input_file($display='Nombre', $campo='nombre', $value='', $ruta='')
{
    echo '<div class="form-group">';
        $attributes = array(
            'class' => 'col-md-2 control-label',
            'style' => ''
        );
        echo form_label($display, $campo, $attributes);
        echo '<div class="col-md-8">';
            $data = array(
                'type'          => 'file',
                'name'          => $campo,
                'id'            => $campo,
                'class'         => 'form-control',
                'value'         => set_value($campo),
                'step'          => 'any'
            );
            if(form_error($campo))
            {
                $data['class'] = 'form-control parsley-error';
            }
            echo form_input($data);
            echo '<ul class="parsley-errors-list filled"><li class="parsley-required">'.form_error($campo).'</li></ul>';
        echo '</div>';
        if($value != "")
        {
            echo '<div class="col-md-2">';
                $data2 = array(
                    'type'          => 'hidden',
                    'name'          => $campo.'_ant',
                    'id'            => $campo.'_ant',
                    'value'         => $value
                );
                echo form_input($data2);
                echo '<img src="'.base_url($ruta.$value).'" width="50px;">';
            echo '</div>';
        }
    echo '</div>';
}

function input_submit($display='Nombre', $campo='nombre', $value='')
{
    $type='submit';

    echo '<div class="form-group">';
        $attributes = array(
            'class' => 'col-md-2 control-label',
            'style' => ''
        );
        echo form_label('', $campo, $attributes);
        echo '<div class="col-md-10">';
        $data = array(
            'id'            => $campo,
            'class'         => 'btn btn-success',
            'value'         => $value
        );

        echo form_submit($campo, $display, $data);
        //echo '<ul class="parsley-errors-list filled"><li class="parsley-required">'.form_error($campo).'</li></ul>';
        echo '</div>';
    echo '</div>';
}

function comentarios($tipo=0, $item_id=0, $num=0, $estado=0, $usar_div_group=1, $comentar=TRUE, $aprobar=TRUE)
{
    $disabled = 'disabled';
    if($item_id>0)
    {
        $disabled = '';
    }

    $color = '';
    $icono_interno = '';
    $color_interno = '';
    if($estado==1)
    {
        $color = 'btn-success';
        $color_interno = '#5fb760';
        $icono_interno = '<i class="fas fa-check fa-stack-1x" style="color:'.$color_interno.'"></i>';
    }
    elseif($estado==2)
    {
        $color = 'btn-violeta';
        $color_interno = '#ac009a';
        $icono_interno = '<i class="fas fa-times fa-stack-1x" style="color:'.$color_interno.'"></i>';
    }
    elseif($estado==3)
    {
        $color = 'btn-violeta';
        $color_interno = '#ac009a';
        $icono_interno = '<i class="fas fa-align-left fa-stack-1x" style="color:'.$color_interno.'"></i>';
    }

    if($usar_div_group == 1)
    {
        echo '<div class="input-group-btn">';
    }
        echo '<button type="button" class="btn '.$color.' dropdown-toggle" '.$disabled.' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="btn_comentar_item_'.$tipo.'_'.$item_id.'_'.$num.'" data-loading-text="<i class=\'fas fa-sync fa-spin\'></i>">';
            echo '<span class="fa-stack fa-1x" style="font-size:10px;">';
                echo '<i class="fas fa-comment fa-stack-2x" style="color:#FFF;"></i>';
                echo $icono_interno;
            echo '</span>';
        echo '</button>';
        echo '<ul class="dropdown-menu dropdown-menu-right">';
        if($comentar)
        {
            $permiso_aprobar = 1;
            if(!$aprobar)
            {
                $permiso_aprobar = 0;
            }
            echo '<li><a href="javascript:abrir_comentar('.$tipo.','.$item_id.','.$num.','.$permiso_aprobar.');"><i class="fas fa-comment"></i> Comentarios</a></li>';
        }
        if($aprobar)
        {
            echo '<li><a href="javascript:set_estado_comentario('.$tipo.','.$item_id.','.$num.',1);"><i class="fas fa-thumbs-up"></i> Aprobado</a></li>';
            echo '<li><a href="javascript:set_estado_comentario('.$tipo.','.$item_id.','.$num.',2);"><i class="fas fa-thumbs-down"></i> Rechazar</a></li>';
        }
        echo '</ul>';
    if($usar_div_group == 1)
    {
        echo '</div>';
    }
}
