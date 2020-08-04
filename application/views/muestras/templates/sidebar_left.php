<?php
$pal_ids = array(82, 84, 86, 23, 24, 339, 294, 504, 57, 240, 116, 117);
$palabras_sidebar = $this->palabras_model->get_items_especificos($this->session->userdata('idi_code'), $pal_ids);
?>
<div class="sidebar hidden-xs">
	<div class="sidebar-todo">
		<div class="panel panel-default" style="margin-bottom:0px;">
		    <div class="panel-body">
		    	<?php
		    	if($usr_id != "")
				{
					echo "<a href='".site_url('user/profile')."'><img src='".base_url()."images/usuarios/".$usr_imagen."' class='img-circle img-user' width='70px' style='margin-bottom: 10px;'></a><br>";
					
					$nombre_aux = "";
					if($usr_nombre != "" && $usr_nombre != "null")
					{
						echo "<span class='panel-title' style='text-transform: uppercase; font-weight:bold; width:100%; display:block; height:22px; overflow:hidden;'>";
						echo $usr_nombre;
						if($usr_apellido != "" && $usr_apellido != "null")
						{
							echo " ".$usr_apellido;
						}
						echo "</span>";
					}
					echo "<small style='width:100%; display:block; height:16px; overflow:hidden;'>".$usr_mail."</small>";
					//echo "<small>".$this->session->userdata('usr_pais_desc')."</small><br>";
					//echo "<small>".$this->session->userdata('idi_desc')."</small>";
		  		}

		  		//echo "<div class='linea-roja'></div>";
		  		echo "<br>";

		    	$tipos_producto = $this->productos_model->get_tipos($this->session->userdata('idi_code'));
		    	foreach($tipos_producto as $tipo_prod)
		    	{
		            if($tipo_prod['tp_id'] == TP_OFERTA)
		            {
		                $tipo_prod['tp_desc'] = mostrar_palabra(82, $palabras_sidebar);
		                $tipo_prod['imagen'] = "oferta";
		            }
		            elseif($tipo_prod['tp_id'] == TP_DEMANDA)
		            {
		                $tipo_prod['tp_desc'] = mostrar_palabra(84, $palabras_sidebar);
		                $tipo_prod['imagen'] = "demanda";
		            }

			    	$cant = $this->productos_model->get_cant_items($usr_id, $tipo_prod['tp_id']);
			    	$cant_num = 0;
			    	if($cant)
			    	{
			    		$cant_num = $cant['cant'];
			    	}
			    	$active = "";
					if($this->router->fetch_class() == "productos" && $this->router->fetch_method() == "index" && $this->uri->segment(3) == $tipo_prod['tp_id'])
					{
						$active = "active";
					}
			    	echo "<div class='left-info ".$active."' onclick='location.href=\"".site_url()."productos/index/".$tipo_prod['tp_id']."\"'>";
			    		echo "<span class='tp'><span class='icon-".$tipo_prod['imagen']."_circle'></span> ".$tipo_prod['tp_desc']."</span> <span class='num pull-right flip'>".$cant_num."</span>";
			    	echo "</div>";
		    	}

		    	$cant = $this->resultados_model->get_cant_items($usr_id);
		    	$cant_num = 0;
		    	if($cant)
		    	{
		    		$cant_num = $cant['cant'];
		    	}
		    	$active = "";
				if($this->router->fetch_class() == "resultados" && $this->router->fetch_method() == "index")
				{
					$active = "active";
				}
		    	echo "<div class='left-info ".$active."' onclick='reset_filtros_resultados()'>";
		    		echo "<span class='tp'><span class='icon-match_circle'></span> ".mostrar_palabra(86, $palabras_sidebar).":</span> <span class='num pull-right flip'>".$cant_num."</span>";
		    	echo "</div>";
		    	?>
		    </div>
		</div>

		<ul class="nav nav-pills nav-stacked">
			<?php
			$active = "";
			if($this->router->fetch_class() == "productos" && $this->router->fetch_method() == "nuevo" && $this->uri->segment(3) == TP_OFERTA)
			{
				$active = "active";
			}
			echo '<li role="presentation" class="'.$active.'"><a href="'.site_url('productos/nuevo/'.TP_OFERTA).'"><span class="icon-nueva_oferta"></span> '.mostrar_palabra(23, $palabras_sidebar).'</a></li>';

			$active = "";
			if($this->router->fetch_class() == "productos" && $this->router->fetch_method() == "nuevo" && $this->uri->segment(3) == TP_DEMANDA)
			{
				$active = "active";
			}
			echo '<li role="presentation" class="'.$active.'"><a href="'.site_url('productos/nuevo/'.TP_DEMANDA).'"><span class="icon-nueva_demanda"></span> '.mostrar_palabra(24, $palabras_sidebar).'</a></li>';

			$active = "";
			if($this->router->fetch_class() == "resultados" && $this->router->fetch_method() == "otros")
			{
				$active = "active";
			}
			echo '<li role="presentation" class="'.$active.'"><a href="'.site_url('resultados/otros').'"><span class="icon-publicaciones"></span> '.mostrar_palabra(339, $palabras_sidebar).'</a></li>';

			$active = "";
			if($this->router->fetch_class() == "foro")
			{
				$active = "active";
			}
			echo '<li role="presentation" class="'.$active.'"><a href="'.site_url('foro').'"><span class="icon-foro"></span> '.mostrar_palabra(294, $palabras_sidebar).'</a></li>';

			$expanded = "";
			$collapsed = "collapsed";
			if($this->router->fetch_class() == "estadisticas")
			{
				$expanded = "in";
				$collapsed = "";
			}
			echo '<li role="presentation" class="dropdown-toggle">';
	            echo '<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle '.$collapsed.'"><span class="icon-herramientas"></span> '.mostrar_palabra(504, $palabras_sidebar).' <i class="fas fa-caret-right"></i></a>';
	            echo '<ul class="collapse '.$expanded.' list-unstyled" id="homeSubmenu">';

	            	$active = "";
					if($this->router->fetch_class() == "estadisticas" && $this->router->fetch_method() == "index")
					{
						$active = "active";
					}
	                echo '<li role="presentation" class="'.$active.'"><a href="'.site_url('estadisticas').'"><span class="icon-estadisticas"></span> '.mostrar_palabra(57, $palabras_sidebar).'</a></li>';

	                $active = "";
					if($this->router->fetch_class() == "estadisticas" && $this->router->fetch_method() == "index_productos")
					{
						$active = "active";
					}
	                echo '<li role="presentation" class="'.$active.'"><a href="'.site_url('estadisticas/index_productos').'"><span class="icon-estadisticasp"></span> '.mostrar_palabra(240, $palabras_sidebar).'</a></li>';
	            echo '</ul>';
	        echo '</li>';
	        ?>
		</ul>
	</div>

	<div class="footer">
		<div class="separador"></div>
		<?php
		echo '<a href="'.site_url('pages/servicio').'">'.mostrar_palabra(116, $palabras_sidebar).'</a><br>';
		echo '<a href="'.site_url('pages/privacidad').'">'.mostrar_palabra(117, $palabras_sidebar).'</a>';
		echo '<br>';
		echo 'Sistema LLC &copy; 2019';
		?>
	</div>
</div>