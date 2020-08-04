<!-- jQuery -->
<script src="<?=base_url()?>assets/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="<?=base_url()?>assets/js/plugins/morris/raphael.min.js"></script>
<script src="<?=base_url()?>assets/js/plugins/morris/morris.min.js"></script>

<?php
if(isset($js_files))
{
	foreach($js_files as $file)
	{
	    echo "<script src='".$file."'></script>";
	}
}
?>