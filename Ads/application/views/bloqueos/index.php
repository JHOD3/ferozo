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
                        <a href="<?=site_url('bloqueos/nuevo')?>" class="btn btn-sm btn-default"><i class="fa fa-plus m-r-5"></i> Nuevo</a>
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
                                            <th>E-mail</th>
                                            <th><?=ucfirst($palabras[369]['pal_desc'])?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($items as $key => $item)
                                        {
                                            echo '<tr id="item_'.$item['ads_blo_id'].'">';
                                                echo '<td>'.$item['usr_mail'].'</td>';
                                                echo '<td>';
                                                  echo '<button class="btn btn-inverse btn-sm" onclick="confirm_eliminar('.$item['ads_blo_id'].')"><i class="fa fa-trash fa-lg"></i></button> ';
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
                    "sSearch": "<?=$palabras[36]['pal_desc']?>"
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
          url: SITE_URL+'/bloqueos/eliminar_ajax',
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
    </script>

</body>
</html>
