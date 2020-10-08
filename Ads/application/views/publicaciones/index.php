<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<?php
$this->load->view('templates/head');
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="<?=base_url()?>assets/plugins/DataTables/css/data-table.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

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
            
            <!-- begin row -->
            <div class="row">
                <!-- begin col-12 -->
                <div class="col-md-12">
                    <div class="email-btn-row hidden-xs">
                        <a href="<?=site_url('publicaciones/nueva/'.$tipo['ads_tipo_id'])?>" class="btn btn-sm btn-default"><i class="fa fa-plus m-r-5"></i> <?=$palabras[362]['pal_desc']?></a>
                    </div>
                    <!-- begin panel -->
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?=$palabras[370]['pal_desc']?></h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="data-table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?=ucfirst($palabras[348]['pal_desc'])?></th>
                                            <th><?=ucfirst($palabras[352]['pal_desc'])?></th>
                                            <!--<th><?=ucfirst($palabras[358]['pal_desc'])?></th>-->
                                            <th><?=ucfirst($palabras[353]['pal_desc'])?></th>
                                            <th><?=ucfirst($palabras[365]['pal_desc'])?> (USD <?=$importes[0]['ads_imp_valor']?>)</th>
                                            <th><?=ucfirst($palabras[366]['pal_desc'])?> (USD <?=$importes[1]['ads_imp_valor']?>)</th>
                                            <th><?=ucfirst($palabras[367]['pal_desc'])?> (USD <?=$importes[2]['ads_imp_valor']?>)</th>
                                            <th>Consumo USD</th>
                                            <th><?=ucfirst($palabras[369]['pal_desc'])?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($items as $key => $item)
                                        {
                                          $consumo = $item['consumo_impresiones'] + $item['consumo_clicks'] + $item['consumo_formularios'];
                                          $class = "";
                                          $btn_pausa = "";
                                          $btn_play = "style='display:none;'";
                                          if($item['ads_estado'] == 2)
                                          {
                                            $class = "class='danger'";
                                            $btn_pausa = "style='display:none;'";
                                            $btn_play = "";
                                          }

                                            echo '<tr id="item_'.$item['ads_id'].'" '.$class.'>';
                                                echo '<td>'.$item['ads_nombre'].'</td>';
                                                echo '<td>'.$item['ads_link'].'</td>';
                                                //echo '<td>'.$item['ads_forms_mail'].'</td>';
                                                echo '<td>';
                                                if($item['ads_imagen'] && $item['ads_imagen'] != "")
                                                {
                                                  echo '<img src="'.FRONT_URL.'images/ads/'.$item['ads_imagen'].'" width="100px">';
                                                }
                                                echo '</td>';
                                                echo '<td>'.$item['impresiones'].'</td>';
                                                echo '<td>'.$item['clicks'].'</td>';
                                                echo '<td><a href="'.site_url('formularios/publicacion/'.$item['ads_id']).'">'.$item['formularios'].'</a></td>';
                                                echo '<td>'.$consumo.'</td>';
                                                echo '<td>';
                                                  echo '<a class="btn btn-inverse btn-sm m-r-5" href="'.site_url('publicaciones/stats/'.$item['ads_id']).'"><i class="fa fa-chart-area fa-lg"></i></a> ';
                                                  echo '<a class="btn btn-inverse btn-sm m-r-5" href="'.site_url('publicaciones/edit/'.$item['ads_id']).'"><i class="fa fa-edit fa-lg"></i></a> ';
                                                  echo '<button class="btn btn-inverse btn-sm m-r-5" '.$btn_pausa.' id="btn_pausa_'.$item['ads_id'].'" onclick="confirm_pausar('.$item['ads_id'].', 2)"><i class="fa fa-pause fa-lg"></i></button> ';
                                                  echo '<button class="btn btn-inverse btn-sm m-r-5" '.$btn_play.' id="btn_play_'.$item['ads_id'].'" onclick="confirm_pausar('.$item['ads_id'].', 1)"><i class="fa fa-play fa-lg"></i></button> ';
                                                  echo '<button class="btn btn-inverse btn-sm" onclick="confirm_eliminar('.$item['ads_id'].')"><i class="fa fa-trash fa-lg"></i></button> ';
                                                echo '</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->
            </div>
            <!-- end row -->
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
	
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="<?=base_url()?>assets/plugins/DataTables/js/jquery.dataTables.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    
    <script>
    $(document).ready(function() {
        if ($('#data-table').length !== 0) {
            $('#data-table').DataTable({
                "language": {
                    "sSearch": "<?=mostrar_palabra(36, $palabras)?>"
                }
            });
        }
    });

    function confirm_eliminar(id)
    {
        new PNotify({
               title: "Confirmaci&oacute;n!",
               text: "Esta seguro de que quiere eliminar el item?",
               addclass: "alert-info",
               hide: false,
               confirm: {
                  confirm: true
               },
               buttons: {
                  closer: false,
                  sticker: false
               }
            }).get().on('pnotify.confirm', function() {
               eliminar(id);
               this.remove();
            });
    }

    function eliminar(id)
    {
        var data = {id:id};
        $.ajax({
          url: SITE_URL+'/publicaciones/eliminar_ajax',
          type: 'POST',
          data: jQuery.param( data ),
          cache: false,
          dataType: 'json',
          processData: false, // Don't process the files
          //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
          success: function(data, textStatus, jqXHR)
          {
            if(data.error == false)
            {
              new PNotify({
                  title: "Perfecto!",
                  text: data.data,
                  addclass: "alert-success"
              });
              $('#item_'+id).remove();
            }
            else
            {
              new PNotify({
                  title: "Error!",
                  text: data.data,
                  addclass: "alert-danger"
              });
            }
          },
          error: function(x, status, error)
          {
            new PNotify({
                title: "Error!",
                text: "An error occurred: " + status + " nError: " + error,
                addclass: "alert-danger"
            });
          }
        });
    }

    function confirm_pausar(id, estado)
    {
        new PNotify({
               title: "Confirmaci&oacute;n!",
               text: "Esta seguro de que quiere pausar el item?",
               addclass: "alert-info",
               hide: false,
               confirm: {
                  confirm: true
               },
               buttons: {
                  closer: false,
                  sticker: false
               }
            }).get().on('pnotify.confirm', function() {
               pausar(id, estado);
               this.remove();
            });
    }

    function pausar(id, estado)
    {
        var data = {id:id, estado:estado};
        $.ajax({
          url: SITE_URL+'/publicaciones/pausar_ajax',
          type: 'POST',
          data: jQuery.param( data ),
          cache: false,
          dataType: 'json',
          processData: false, // Don't process the files
          //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
          success: function(data, textStatus, jqXHR)
          {
            if(data.error == false)
            {
              new PNotify({
                  title: "Perfecto!",
                  text: data.data,
                  addclass: "alert-success"
              });

              if(estado==2)
              {
                $('#item_'+id).addClass('danger');
                $('#btn_pausa_'+id).hide();
                $('#btn_play_'+id).show();
              }
              else
              {
                $('#item_'+id).removeClass('danger');
                $('#btn_pausa_'+id).show();
                $('#btn_play_'+id).hide();
              }
            }
            else
            {
              new PNotify({
                  title: "Error!",
                  text: data.data,
                  addclass: "alert-danger"
              });
            }
          },
          error: function(x, status, error)
          {
            new PNotify({
                title: "Error!",
                text: "An error occurred: " + status + " nError: " + error,
                addclass: "alert-danger"
            });
          }
        });
    }
    </script>

</body>
</html>
