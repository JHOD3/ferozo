	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?=base_url()?>assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="<?=base_url()?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="<?=base_url()?>assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="<?=base_url()?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
		<script src="<?=base_url()?>assets/crossbrowserjs/html5shiv.js"></script>
		<script src="<?=base_url()?>assets/crossbrowserjs/respond.min.js"></script>
		<script src="<?=base_url()?>assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?=base_url()?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?=base_url()?>assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<script src="<?=base_url()?>assets/plugins/notifications/pnotify.min.js"></script>
	<!-- ================== END BASE JS ================== -->

	<script src="<?=base_url()?>assets/js/apps.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		App.init();
	});
	</script>

<?php
if(isset($js_files))
{
	foreach($js_files as $file)
	{
	    echo "<script src='".$file."'></script>";
	}
}
?>