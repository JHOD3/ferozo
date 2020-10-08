<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function input_text($display='Nombre', $campo='nombre', $type='text', $value='', $extra='')
{
    echo '<div class="form-group">';
        $attributes = array(
            'class' => 'col-md-2 control-label',
            'style' => ''
        );
        echo form_label($display, $campo, $attributes);
        echo '<div class="col-md-10">';
        $data = array(
            'type'          => $type,
            'name'          => $campo,
            'id'            => $campo,
            'class'         => 'form-control',
            'value'         => set_value($campo),
            'step'          => 'any'
        );
        if($value!="")
        {
            $data['value'] = $value;
        }
        if(form_error($campo))
        {
            $data['class'] = 'form-control parsley-error';
        }
        echo form_input($data, $data['value'], $extra);
        echo '<ul class="parsley-errors-list filled"><li class="parsley-required">'.form_error($campo).'</li></ul>';
        echo '</div>';
    echo '</div>';
}

function input_textarea($display='Nombre', $campo='nombre', $value='', $extra='')
{
    echo '<div class="form-group">';
        $attributes = array(
            'class' => 'col-md-2 control-label',
            'style' => ''
        );
        echo form_label($display, $campo, $attributes);
        echo '<div class="col-md-10">';
        $data = array(
            'name'          => $campo,
            'id'            => $campo,
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
        echo form_textarea($data, $data['value'], $extra);
        echo '<ul class="parsley-errors-list filled"><li class="parsley-required">'.form_error($campo).'</li></ul>';
        echo '</div>';
    echo '</div>';
}

function input_select($display='Nombre', $campo='nombre', $options='', $value='', $id='', $descripcion='', $extra='')
{
    $array_aux = array();
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
        }
    }
    else
    {
        $array_aux = $options;
    }

    echo '<div class="form-group">';
        $attributes = array(
            'class' => 'col-md-2 control-label',
            'style' => ''
        );
        echo form_label($display, $campo, $attributes);
        echo '<div class="col-md-10" id="area_'.$campo.'">';
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
        echo form_dropdown($data, $array_aux, $value, $extra);
        echo '<ul class="parsley-errors-list filled"><li class="parsley-required">'.form_error($campo).'</li></ul>';
        echo '</div>';
    echo '</div>';
}

function input_checkbox($display='Nombre', $campo='nombre', $value='', $checked = FALSE)
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
            <div class="col-md-2">
            </div>
            <div class="col-md-10">
                <div class="checkbox">
                    <label>
                        <input name="'.$campo.'" type="checkbox" value="'.$value.'" '.$checked_aux.'>
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
        /*
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
        */
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