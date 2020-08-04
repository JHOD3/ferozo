<div class="col-md-3 foros hidden-xs sidebar-right">
	<div class="panel panel-danger">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?=mostrar_palabra(339, $palabras)?></h3>
	  </div>
	  <div class="panel-body" style="padding:0px;">
	  	<div id="results_ultimos"></div>
	  	<div style="padding:10px;">
	  		<a class="btn btn-default btn-block" style="margin-top:5px;" href="<?=site_url('resultados/otros')?>"><?=mostrar_palabra(151, $palabras)?></a>
	  	</div>
	  </div>
	</div>

	<div class="panel panel-danger">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?=mostrar_palabra(296, $palabras)?></h3>
	  </div>
	  <div class="panel-body">
	  	<?php
    	$foros = $this->foro_model->get_last_items($this->session->userdata('idi_code'));
    	echo '<small>';
    	foreach($foros as $foro)
    	{
	    	//echo "<a href='".site_url()."foro/view/".$foro['foro_id']."' class='cortar-texto'>";
	    	echo "<div class='cortar-texto' onclick='location.href=\"".site_url("foro/view/".$foro['foro_id'])."\"' style='cursor:pointer;'>";
	    		if($foro['ctry_code'])
	            {
	            	echo "<img src='".base_url("images/banderas/".$foro['ctry_code'].".png")."'> ";
	        	}
	            echo '<b class="texto-bordo">'.$foro['ara_code'].'</b> - ';
	    	echo nl2br($foro['foro_descripcion']);
	    	echo "</div>";
	    	//echo "</a><br>";
    	}
    	echo '</small>';

    	echo '<hr style="border-color:#d0d0d0;">';
    	//if(count($foros)>=5)
    	//{
    		echo '<a class="btn btn-default btn-block" style="margin-top:5px;" href="'.site_url('foro').'">'.mostrar_palabra(151, $palabras).'</a>';
    	//}
    	//echo '<button class="btn btn-danger btn-block" style="margin-top:10px;" onclick="location.href=SITE_URL+\'foro/nuevo\'">'.mostrar_palabra(210, $palabras).'</button>';
    	?>
	  </div>
	</div>

	<!--
	<div class="panel panel-danger">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?=mostrar_palabra(213, $palabras)?></h3>
	  </div>
	  <div class="panel-body">
    	<a class="btn btn-default btn-block" href="<?=site_url('planes')?>"><?=mostrar_palabra(173, $palabras)?></a><br>
    	<a style="color:#FFFFFF;" class="btn btn-danger btn-block" href="<?=site_url('planes/publicitar')?>"><?=mostrar_palabra(178, $palabras)?></a>
	  </div>
	</div>
	-->
	<div class="panel panel-danger" id="area-mayor-actividad">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?=mostrar_palabra(240, $palabras)?></h3>
	  </div>
	  <div class="panel-body">
	  	<?php
	  	$principales_demandas = $this->productos_model->get_max_x_tipo($this->session->userdata('idi_code'), TP_DEMANDA, 5);
    	if($principales_demandas)
    	{
    		echo "<strong class='panel-title'>".mostrar_palabra(20, $palabras)."</strong><br>";
	    	echo "<small>";
	    	foreach ($principales_demandas as $key => $oferta)
	    	{
	    		//echo "<b>".$oferta['ara_code']."</b> - ".cortarTexto($oferta['ara_desc'],110)."<br>";
	    		echo "<div class='cortar-texto' ><span class='badge'>".$oferta['cant']."</span> - <b class='texto-bordo'>".$oferta['ara_code']."</b> - ".$oferta['ara_desc']."</div>";
	    	}
	    	echo "</small>";
	    	echo '<hr style="border-color:#d0d0d0;">';
	    	echo "<a class='btn btn-default btn-block' style='margin-top:5px;' href='".site_url('estadisticas/productos/'.TP_DEMANDA)."'>".mostrar_palabra(151, $palabras)."</a>";
	    	echo "<br><br>";
    	}

    	$principales_ofertas = $this->productos_model->get_max_x_tipo($this->session->userdata('idi_code'), TP_OFERTA, 5);
    	if($principales_ofertas)
    	{
    		echo "<strong class='panel-title'>".mostrar_palabra(19, $palabras)."</strong><br>";
	    	echo "<small>";
	    	foreach ($principales_ofertas as $key => $oferta)
	    	{
	    		//echo "<b>".$oferta['ara_code']."</b> - ".cortarTexto($oferta['ara_desc'],110)."<br>";
	    		echo "<div class='cortar-texto' ><span class='badge'>".$oferta['cant']."</span> - <b class='texto-bordo'>".$oferta['ara_code']."</b> - ".$oferta['ara_desc']."</div>";
	    	}
	    	echo "</small>";
	    	echo '<hr style="border-color:#d0d0d0;">';
	    	echo "<a class='btn btn-default btn-block' style='margin-top:5px;' href='".site_url('estadisticas/productos/'.TP_OFERTA)."'>".mostrar_palabra(151, $palabras)."</a>";
    	}
    	?>
	  </div>
	</div>
</div>