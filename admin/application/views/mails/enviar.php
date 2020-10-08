<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<body>

    <div id="wrapper">

        <?php
		$this->load->view('templates/header');
		?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Enviar un mail
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div id="area-mensajes">
                        <?php 
                            echo validation_errors();
                            if($error)
                            {
                                echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $error;
                                echo '</div>';
                            }
                            if($success)
                            {
                                echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                echo $success;
                                echo '</div>';
                            }
                        ?>
                        </div>
                        <div id='area-buscar'></div>

                        <form action="<?=site_url('mails/enviar')?>" method="POST">
                            <?php
                            input_select('Mail', 'mail', $mails, '29', 'mi_codigo', 'mi_descripcion');
                            input_select('Idioma', 'idioma', $idiomas, 'en', 'idi_code', 'idi_desc');
                            //echo "<div class='col-xs-10 col-xs-offset-2'><button type='button' class='btn btn-warning' onclick='buscar();'>Cargar</button></div>";
                            
                            echo "<div style='clear:both;'></div><br><br>";

                            input_text('Destino','destino');
                            input_text('Asunto','asunto','text','');
                            input_textarea('Texto crudo','crudo','');
                            input_textarea('Título','titulo','');
                            input_textarea('Cuerpo 1','cuerpo1','');
                            input_textarea('Cuerpo 2','cuerpo2','');
                            input_submit('Enviar');
                            ?>
                        </form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php
    $this->load->view('templates/footer');
    ?>

    <script type="text/javascript">
        $( "#mail" ).change(function() {
            buscar();
        });

        $( "#idioma" ).change(function() {
            buscar();
        });

        function buscar()
        {
            $('#area-buscar').html("");
            $.ajax({
              type: 'POST',
              url: '<?=site_url()?>mails/buscar_mail_ajax',
              data: jQuery.param({mail: $('#mail').val(), idioma: $('#idioma').val()}),
              dataType: 'json',
              success: function(data) {
                if(data.error == false)
                {
                    $('#asunto').val(data.data.mi_asunto);
                    $('#titulo').val(data.data.mi_titulo);
                    $('#cuerpo1').val(data.data.mi_cuerpo1);
                    $('#cuerpo2').val(data.data.mi_cuerpo2);
                    $('#crudo').val(data.data.mi_texto_crudo);
                }
                else
                {
                    var htmlData = '<div class="alert alert-danger alert-dismissible" role="alert"> <i class="icon fa fa-exclamation-triangle"></i> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    htmlData += data.data;
                    htmlData += '</div>';
                    $('#area-buscar').html(htmlData);
                }
              },
              error: function(x, status, error){
                var htmlData = '<div class="alert alert-danger alert-dismissible" role="alert"> <i class="icon fa fa-exclamation-triangle"></i> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                htmlData += "An error occurred: " + status + " nError: " + error;
                htmlData += '</div>';
                $('#area-buscar').html(htmlData);
              }
            });
        }

        buscar();
    </script>

</body>

</html>