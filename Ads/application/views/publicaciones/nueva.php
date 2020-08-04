<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<?php
$this->load->view('templates/head');
?>

<style type="text/css">
.subject-info-box-1,
.subject-info-box-2{
    float: left;
    width: 45%;
}
select {
    height: 200px;
    padding: 0;
}
option {
    padding: 4px 10px 4px 10px;
}

option:hover {
    background: #EEEEEE;
}

.subject-info-arrows {
    float: left;
    width: 10%;
}
input {
    width: 70%;
    margin-bottom: 5px;
}
</style>

<body>
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<?php
		$this->load->view('templates/header');
		$this->load->view('templates/menu');
		?>
		
		<!-- begin #content -->
        <div id="content" class="content">
            <?php
            $this->load->view('templates/title');
            ?>

            <form action="<?=site_url('publicaciones/nueva/'.$tipo['ads_tipo_id'])?>" id="form" class="form-horizontal" method="POST" enctype='multipart/form-data'>

            <!-- begin row -->
            <div class="row">
                <!-- begin col-md-6 -->
                <div class="col-md-6">
                    <?php
                    if($error)
                    {
                        echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo $error;
                        echo '</div>';
                    }
                    //echo validation_errors();
                    ?>
                    <!-- begin panel -->
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?=$palabras[362]['pal_desc']?></h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-horizontal">
                                <?php
                                input_text($palabras[348]['pal_desc'], 'nombre', 'text');
                                input_text($palabras[349]['pal_desc'], 'titulo', 'text');
                                input_textarea($palabras[350]['pal_desc'], 'texto_corto');
                                echo '<div class="form-group" id="area_imagen_0">';
                                    echo '<label class="col-md-2 control-label">'.$palabras[353]['pal_desc'].'</label>';
                                    echo '<div class="col-md-8">';
                                        echo '<input type="file" name="imagen" id="imagen" class="form-control">';
                                        echo str_replace('WxH', '350x300px', $palabras[361]['pal_desc']);
                                    echo '</div>';
                                echo '</div>';

                                echo '<hr>';
                                
                                input_textarea($palabras[351]['pal_desc'], 'texto_largo');
                                input_text($palabras[352]['pal_desc'], 'link', 'text');
                                echo '<div class="form-group">';
                                    echo '<div class="col-md-2"><label>'.$palabras[359]['pal_desc'].'</label></div>';
                                    echo '<div class="col-md-10"><button type="button" class="btn btn-danger btn-sm" onclick="nueva_imagen()"><i class="fas fa-plus"></i></button> ('.str_replace('NN', '10', str_replace('XX', '2', $palabras[360]['pal_desc'])).')</div>';
                                echo '</div>';
                                echo '<div id="area-imagenes">';
                                    echo '<div class="form-group" id="area_imagen_0">';
                                        echo '<label class="col-md-2 control-label"></label>';
                                        echo '<div class="col-md-8">';
                                            echo '<input type="file" name="imagenes[]" id="imagen_0" class="form-control input_imagen">';
                                            echo str_replace('WxH', '1024x768px', $palabras[361]['pal_desc']);
                                        echo '</div>';
                                        echo '<div class="col-md-2">';
                                            echo '<button type="button" class="btn btn-danger btn-sm" onclick="eliminar_imagen(0)"><i class="fas fa-trash"></i></button>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';

                                echo '<hr>';
                                
                                if($tipo['ads_tipo_id'] == 1)
                                {
                                    echo '<div class="form-group">
                                            <label class="col-md-2 control-label">
                                                '.$palabras[19]['pal_desc'].'
                                            </label>
                                            <div class="col-md-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="check_'.TP_OFERTA.'" id="check_'.TP_OFERTA.'" type="checkbox" value="1" checked>
                                                        ('.$palabras[354]['pal_desc'].')
                                                    </label>
                                                </div>
                                            </div>
                                        </div>';

                                    echo '<div class="form-group">
                                            <label class="col-md-2 control-label">
                                                '.$palabras[20]['pal_desc'].'
                                            </label>
                                            <div class="col-md-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="check_'.TP_DEMANDA.'" id="check_'.TP_DEMANDA.'" type="checkbox" value="1" checked>
                                                        ('.$palabras[355]['pal_desc'].')
                                                    </label>
                                                </div>
                                            </div>
                                        </div>';
                                }

                                echo '<div class="form-group">
                                        <label class="col-md-2 control-label">
                                            '.$palabras[356]['pal_desc'].'
                                        </label>
                                        <div class="col-md-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="check_form" id="check_form" type="checkbox" value="1" onclick="mostrar_mail_form()" checked>
                                                    ('.$palabras[357]['pal_desc'].')
                                                </label>
                                            </div>
                                        </div>
                                    </div>';

                                echo '<div class="form-group" id="area_mail_form">
                                        <label class="col-md-2 control-label">
                                            '.$palabras[358]['pal_desc'].'
                                        </label>
                                        <div class="col-md-10">
                                            <input class="form-control" name="mail_form" id="mail_form" type="email" value="">
                                        </div>
                                    </div>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-6 -->

                <!--
                <div class="col-md-6 resultado2">
                    <div class="panel-body" style="background:#F5F5F5; padding:0px;">
                        <div class="media" id="prod_">
                            <div style="width:100%; height:160px; overflow:hidden;">
                              <img src='' width='100%'>
                            </div>
                          <div class="media-body" style="padding:15px;">
                            <b class="texto-bordo"></b>
                            <div class="cortar-texto-productos2" style="margin-top:5px;"></div>
                          </div>
                        </div>
                    </div>
                    <div class="panel-footer" style="text-align:center; background:#999999; color:#FFF;">
                        ADVERTISMENT
                    </div>
                </div>
                -->

            </div>
            <!-- end row -->

            <!-- begin row -->
            <div class="row">
                <!-- begin col-md-6 -->
                <div class="col-md-6">
                    <!-- begin panel -->
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?=$palabras[2]['pal_desc']?></h4>
                        </div>
                        <div class="panel-body">
                            <?php
                                echo '<div class="subject-info-box-1">';
                                  echo '<select multiple="multiple" id="lstBox1" class="form-control" style="height:200px;">';
                                    foreach ($paises as $key => $value)
                                    {
                                        echo '<option value="'.$value['ctry_code'].'">'.$value['ctry_nombre'].'</option>';
                                        echo "\n";
                                    }
                                  echo '</select>';
                                echo '</div>';

                                echo '<div class="subject-info-arrows text-center">';
                                  echo '<input type="button" id="btnAllRight" value=">>" class="btn btn-inverse m-t-10" /><br />';
                                  echo '<input type="button" id="btnRight" value=">" class="btn btn-inverse m-t-10" /><br />';
                                  echo '<input type="button" id="btnLeft" value="<" class="btn btn-inverse m-t-10" /><br />';
                                  echo '<input type="button" id="btnAllLeft" value="<<" class="btn btn-inverse m-t-10" />';
                                echo '</div>';

                                echo '<div class="subject-info-box-2">';
                                  echo '<select name="paises[]" multiple="multiple" id="lstBox2" class="form-control" style="height:200px;">';
                                  echo '</select>';
                                echo '</div>';

                                echo '<div class="clearfix"></div>';
                            ?>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-6 -->

                <?php
                if($tipo['ads_tipo_id'] == 1)
                {
                    echo '<!-- begin col-6 -->';
                    echo '<div class="col-md-6">';
                        echo '<!-- begin panel -->';
                        echo '<div class="panel panel-danger">';
                            echo '<div class="panel-heading">';
                                echo '<h4 class="panel-title">'.$palabras[255]['pal_desc'].'</h4>';
                            echo '</div>';
                            echo '<div class="panel-body">';
                                
                                    echo '<div class="subject-info-box-1">';
                                      echo '<select multiple="multiple" id="lstBox3" class="form-control" style="height:200px;">';
                                        foreach ($aranceles as $key => $value)
                                        {
                                            echo '<option value="'.$value['ara_id'].'">'.$value['ara_code'].' - '.$value['ara_desc'].'</option>';
                                            echo "\n";
                                        }
                                      echo '</select>';
                                    echo '</div>';

                                    echo '<div class="subject-info-arrows text-center">';
                                      echo '<input type="button" id="btnAllRight2" value=">>" class="btn btn-inverse m-t-10" /><br />';
                                      echo '<input type="button" id="btnRight2" value=">" class="btn btn-inverse m-t-10" /><br />';
                                      echo '<input type="button" id="btnLeft2" value="<" class="btn btn-inverse m-t-10" /><br />';
                                      echo '<input type="button" id="btnAllLeft2" value="<<" class="btn btn-inverse m-t-10" />';
                                    echo '</div>';

                                    echo '<div class="subject-info-box-2">';
                                      echo '<select name="aranceles[]" multiple="multiple" id="lstBox4" class="form-control" style="height:200px;">';
                                      echo '</select>';
                                    echo '</div>';

                                    echo '<div class="clearfix"></div>';
                                
                            echo '</div>';
                        echo '</div>';
                        echo '<!-- end panel -->';
                    echo '</div>';
                    echo '<!-- end col-6 -->';
                }
                ?>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-lg btn-danger"><?=$palabras[17]['pal_desc']?></button>
                </div>
            </div>
            
            </form>
        </div>
        <!-- end #content -->
		
		<?php
		$this->load->view('templates/footer');
		?>
	</div>
	<!-- end page container -->
	
	<?php
	$this->load->view('templates/scripts');
	?>

<script type="text/javascript">
var cant_imagenes = 0;

function eliminar_imagen(num)
{
    $('#area_imagen_'+num).remove();
}

function nueva_imagen()
{
    if($(".input_imagen").length < 10)
    {
        cant_imagenes++;

        var htmlData = '';
        htmlData += '<div class="form-group" id="area_imagen_'+cant_imagenes+'">';
            htmlData += '<label class="col-md-2 control-label"></label>';
            htmlData += '<div class="col-md-8">';
                htmlData += '<input type="file" name="imagenes[]" id="imagen_'+cant_imagenes+'" class="form-control input_imagen">';
                htmlData += "<?=str_replace('WxH', '1024x768px', $palabras[361]['pal_desc'])?>";
            htmlData += '</div>';
            htmlData += '<div class="col-md-2"><button type="button" class="btn btn-danger btn-sm" onclick="eliminar_imagen('+cant_imagenes+')"><i class="fas fa-trash"></i></button></div>';
        htmlData += '</div>';
        
        $('#area-imagenes').append(htmlData);
    }
}

function mostrar_mail_form()
{
    if( $('#check_form').prop('checked') )
    {
        $('#area_mail_form').show();
    }
    else
    {
        $('#area_mail_form').hide();
        $('#mail_form').val("");
    }
}

(function () {
    $('#btnRight').click(function (e) {
        var selectedOpts = $('#lstBox1 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox2').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnAllRight').click(function (e) {
        var selectedOpts = $('#lstBox1 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox2').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnLeft').click(function (e) {
        var selectedOpts = $('#lstBox2 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnAllLeft').click(function (e) {
        var selectedOpts = $('#lstBox2 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });


    $('#btnRight2').click(function (e) {
        var selectedOpts = $('#lstBox3 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox4').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnAllRight2').click(function (e) {
        var selectedOpts = $('#lstBox3 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox4').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnLeft2').click(function (e) {
        var selectedOpts = $('#lstBox4 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox3').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnAllLeft2').click(function (e) {
        var selectedOpts = $('#lstBox4 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox3').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });
}(jQuery));


$( "#form" ).submit(function( event ) {
    $('#lstBox2 option').prop('selected', true);
    $('#lstBox4 option').prop('selected', true);
});
</script>

</body>
</html>
