<head>
	<meta charset="utf-8" />
	<title>Nocnode | Ads</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />-->
	<link href="<?=base_url()?>assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/plugins/font-awesome/css/all.min.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/css/animate.min.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/css/style-responsive.min.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/css/theme/red.css" rel="stylesheet" id="theme" />
	<link href="<?=base_url()?>assets/plugins/notifications/notifications.css" rel="stylesheet" />  
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?=base_url()?>assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
	<script type="text/javascript">
	var SITE_URL = "<?=site_url()?>";
	var BASE_URL = "<?=base_url()?>";
	</script>

	<?php 
    if(isset($css_files))
    {
        foreach($css_files as $file)
        {
            echo "<link type='text/css' rel='stylesheet' href='".$file."'/>";
        }
    }
    ?>
</head>
