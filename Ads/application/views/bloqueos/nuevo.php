<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<?php
$this->load->view('templates/head');
?>

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

            <form action="<?=site_url('bloqueos/nuevo')?>" id="form" class="form-horizontal" method="POST" enctype='multipart/form-data'>

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
                    if($success)
                    {
                        echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo $success;
                        echo '</div>';
                    }
                    echo validation_errors();
                    ?>
                    <!-- begin panel -->
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h4 class="panel-title">&nbsp;</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-horizontal">
                                <?php
                                input_text('Mails', 'mail', 'text');
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

</body>
</html>
