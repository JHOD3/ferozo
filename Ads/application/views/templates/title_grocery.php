<?php
if(isset($extra['breadcum']))
{
	echo '<ol class="breadcrumb pull-right">';
	for($i=0; $i<count($extra['breadcum']); $i++)
	{
		$link = '';
		$link2 = '';
		if($extra['breadcum'][$i]['link'] != "")
		{
			$link = '<a href="'.$extra['breadcum'][$i]['link'].'">';
			$link2 = '</a>';
		}

		$active = '';
		if($i==(count($extra['breadcum'])-1))
		{
			$active = 'class="active"';
		}
		echo '<li '.$active.'>'.$link.$extra['breadcum'][$i]['texto'].$link2.'</li>';
	}
	echo '</ol>';
}
?>
<!-- begin page-header -->
<h1 class="page-header"><?=$extra['titulo']?> <small><?=$extra['subtitulo']?></small></h1>
<!-- end page-header -->