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

            <!-- BEGIN #checkout-cart -->
            <div class="section-container" id="checkout-cart">
                <!-- BEGIN container -->
                <div class="container-fluid">
                    <!-- BEGIN checkout -->
                    <div class="col-lg-8 col-lg-offset-2 checkout" style="padding:0px;">
                        <form action="#" method="POST" name="form_checkout" id="paymentFrm">
                            <!-- BEGIN checkout-header -->
                            <div class="checkout-header">
                                <!-- BEGIN row -->
                                <div class="row">
                                    <!-- BEGIN col-3 -->
                                    <div class="col-md-3 col-sm-3">
                                        <div class="step">
                                            <a href="<?=site_url('pagos/checkout_ads')?>">
                                                <div class="number">1</div>
                                                <div class="info">
                                                    <div class="title"><?=ucfirst(mostrar_palabra(540, $palabras))?></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END col-3 -->
                                    <!-- BEGIN col-3 -->
                                    <div class="col-md-3 col-sm-3">
                                        <div class="step active">
                                            <a href="#">
                                                <div class="number">2</div>
                                                <div class="info">
                                                    <div class="title"><?=ucfirst(mostrar_palabra(541, $palabras))?></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END col-3 -->
                                    <!-- BEGIN col-3 -->
                                    <div class="col-md-3 col-sm-3">
                                        <div class="step">
                                            <a href="#">
                                                <div class="number">3</div>
                                                <div class="info">
                                                    <div class="title"><?=ucfirst(mostrar_palabra(542, $palabras))?></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END col-3 -->
                                    <!-- BEGIN col-3 -->
                                    <div class="col-md-3 col-sm-3">
                                        <div class="step">
                                            <a href="#">
                                                <div class="number">4</div>
                                                <div class="info">
                                                    <div class="title"><?=ucfirst(mostrar_palabra(543, $palabras))?></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END col-3 -->
                                </div>
                                <!-- END row -->
                            </div>
                            <!-- END checkout-header -->
                            <!-- BEGIN checkout-body -->
                            <div class="checkout-body">
                                <div id="area_errores">
                                    <?php
                                    if($error)
                                    {
                                        echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                                        echo $error;
                                        echo '</div>';
                                    }
                                    //echo validation_errors();
                                    ?>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 text-lg-right">
                                    <?=mostrar_palabra(11, $palabras)?> <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-4">
                                        <?php
                                        $class_error = '';
                                        if(form_error('nombre'))
                                        {
                                            $class_error = 'parsley-error';
                                        }
                                        ?>
                                        <input type="text" class="form-control <?=$class_error?>" name="nombre" value="<?=set_value('nombre')?>" placeholder="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 text-lg-right">
                                    <?=mostrar_palabra(10, $palabras)?> <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-4">
                                        <?php
                                        $class_error = '';
                                        if(form_error('apellido'))
                                        {
                                            $class_error = 'parsley-error';
                                        }
                                        ?>
                                        <input type="text" class="form-control <?=$class_error?>" name="apellido" value="<?=set_value('apellido')?>" placeholder="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 text-lg-right">
                                    <?=mostrar_palabra(13, $palabras)?> (<?=mostrar_palabra(546, $palabras)?>)<span class="text-danger">&nbsp;</span>
                                    </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="empresa" value="<?=set_value('empresa')?>" placeholder="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 text-lg-right">
                                    <?=mostrar_palabra(547, $palabras)?> (<?=mostrar_palabra(546, $palabras)?>)<span class="text-danger">&nbsp;</span>
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="id" value="<?=set_value('id')?>" placeholder="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 text-lg-right">
                                    <?=mostrar_palabra(2, $palabras)?> <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-4">
                                        <?php
                                        $class_error = '';
                                        if(form_error('pais'))
                                        {
                                            $class_error = 'parsley-error';
                                        }
                                        ?>
                                        <select class="form-control <?=$class_error?>" name="pais" id="pais" onchange="cargar_ciudades(this.value);">
                                          <option selected disabled style='display:none;'><?=mostrar_palabra(161, $palabras)?></option>
                                          <?php
                                          foreach ($paises as $pais)
                                          {
                                            if($pais['ctry_code'] == set_value('pais'))
                                            {
                                              echo "<option value='".$pais['ctry_code']."' selected>".$pais['ctry_nombre']."</option>";
                                            }
                                            else
                                            {
                                              echo "<option value='".$pais['ctry_code']."'>".$pais['ctry_nombre']."</option>";
                                            }
                                          }
                                          ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 text-lg-right">
                                    <?=mostrar_palabra(133, $palabras)?> <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-4">
                                        <?php
                                        $class_error = '';
                                        if(form_error('telefono'))
                                        {
                                            $class_error = 'parsley-error';
                                        }
                                        ?>
                                        <input type="text" class="form-control <?=$class_error?>" name="telefono" value="<?=set_value('telefono')?>" placeholder="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 text-lg-right">
                                    <?=mostrar_palabra(131, $palabras)?> <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-4">
                                        <?php
                                        $class_error = '';
                                        if(form_error('direccion'))
                                        {
                                            $class_error = 'parsley-error';
                                        }
                                        ?>
                                        <input type="text" class="form-control <?=$class_error?>" name="direccion" value="<?=set_value('direccion')?>" placeholder="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 text-lg-right">
                                    <?=mostrar_palabra(130, $palabras)?> <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-4">
                                        <?php
                                        $class_error = '';
                                        if(form_error('cp'))
                                        {
                                            $class_error = 'parsley-error';
                                        }
                                        ?>
                                        <input type="text" class="form-control <?=$class_error?>" name="cp" value="<?=set_value('cp')?>" placeholder="" />
                                    </div>
                                </div>
                            </div>
                            <!-- END checkout-body -->
                            <!-- BEGIN checkout-footer -->
                            <div class="checkout-footer">
                                <a href="<?=site_url('pagos/checkout_ads')?>" class="btn btn-white btn-lg pull-left"><?=mostrar_palabra(7, $palabras)?></a>
                                <button type="submit" class="btn btn-inverse btn-lg p-l-30 p-r-30 m-l-10"><?=mostrar_palabra(518, $palabras)?></button>
                            </div>
                            <!-- END checkout-footer -->
                        </form>
                    </div>
                    <!-- END checkout -->
                    <div class="col-lg-8 col-lg-offset-2" style="padding:20px 0px">
                        <a href="https://www.nocnode.com/pages/servicio" target="_blank"><?=mostrar_palabra(170, $palabras)?></a><br>
                        <a href="https://www.nocnode.com/pages/privacidad" target="_blank"><?=mostrar_palabra(117, $palabras)?></a>
                    </div>
                </div>
                <!-- END container -->
            </div>
            <!-- END #checkout-cart -->
        
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
