<?php
if(isset($breadcum))
{
	echo '<ol class="breadcrumb pull-right" style="white-space:nowrap;">';
	for($i=0; $i<count($breadcum); $i++)
	{
		$link = '';
		$link2 = '';
		if($breadcum[$i]['link'] != "")
		{
			$link = '<a href="'.$breadcum[$i]['link'].'">';
			$link2 = '</a>';
		}

		$active = '';
		if($i==(count($breadcum)-1))
		{
			$active = 'class="active"';
		}
		echo '<li '.$active.'>'.$link.$breadcum[$i]['texto'].$link2.'</li>';
	}
	echo '</ol>';
}
?>
<!-- begin page-header -->
<h1 class="page-header"><?=$titulo?> <small><?=$subtitulo?></small></h1>
<!-- end page-header -->