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
            
            <!-- begin row -->
            <div class="row">
                <!-- begin col-12 -->
                <div class="col-md-12">

                    <!-- begin panel -->
                    <div class="panel panel-danger" data-sortable-id="form-stuff-1">
                        <div class="panel-heading">
                            <h4 class="panel-title">DATOS</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-horizontal">
                                <?php
                                input_text($palabras[348]['pal_desc'], 'anuncio', 'text', $item['ads_nombre'], 'readonly="readonly"');
                                input_text($palabras[220]['pal_desc'], 'fecha', 'text', $item['ads_form_fecha'], 'readonly="readonly"');
                                input_text($palabras[11]['pal_desc'], 'nombre', 'text', $item['ads_form_nombre'], 'readonly="readonly"');
                                input_text($palabras[358]['pal_desc'], 'mail', 'text', $item['ads_form_mail'], 'readonly="readonly"');
                                input_text($palabras[133]['pal_desc'], 'telefono', 'text', $item['ads_form_telefono'], 'readonly="readonly"');
                                input_text($palabras[2]['pal_desc'], 'pais', 'text', $item['ctry_nombre'], 'readonly="readonly"');
                                input_textarea($palabras[347]['pal_desc'], 'consulta', $item['ads_form_consulta'], 'readonly="readonly"');
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-6 -->

            </div>
            <!-- end row -->


            <div class="row">
                <div class="col-md-9">
                    <button class="btn btn-lg btn-danger" onclick="goBack()"><?=$palabras[7]['pal_desc']?></button>
                </div>
            </div>

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

<script>
function goBack() {
    window.history.back();
}
</script>

</body>
</html>
