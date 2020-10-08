		<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar nav -->
				<ul class="nav">
					<?php
						$active = "";
						if($this->router->fetch_class() == 'pages')
						{
							$active = "active";
						}
						echo '<li class="'.$active.'">
							<a href="'.site_url('pages').'">
							    <i class="fas fa-home"></i>
							    <span>'.$palabras[363]['pal_desc'].'</span>
						    </a>
						</li>';

						$active = "";
						if($this->router->fetch_class() == 'publicaciones' && $this->router->fetch_method() == 'index' && $this->uri->segment(3) == 1)
						{
							$active = "active";
						}
						echo '<li class="'.$active.'">
							<a href="'.site_url('publicaciones/index/1').'">
							    <i class="fab fa-leanpub"></i>
							    <span>'.$palabras[508]['pal_desc'].'</span>
						    </a>
						</li>';

						$active = "";
						if($this->router->fetch_class() == 'publicaciones' && $this->router->fetch_method() == 'index' && $this->uri->segment(3) == 2)
						{
							$active = "active";
						}
						echo '<li class="'.$active.'">
							<a href="'.site_url('publicaciones/index/2').'">
							    <i class="fas fa-globe-americas"></i>
							    <span>'.$palabras[511]['pal_desc'].'</span>
						    </a>
						</li>';

						$active = "";
						if($this->router->fetch_class() == 'formularios')
						{
							$active = "active";
						}
						echo '<li class="'.$active.'">
							<a href="'.site_url('formularios').'">
							    <i class="fas fa-file-alt"></i>
							    <span>'.$palabras[367]['pal_desc'].'</span>
						    </a>
						</li>';
						/*
						$active = "";
						if($this->router->fetch_class() == 'premium')
						{
							$active = "active";
						}
						echo '<li class="'.$active.'">
							<a href="'.site_url('premium').'">
							    <i class="fas fa-user-circle"></i>
							    <span>'.$palabras[514]['pal_desc'].'</span>
						    </a>
						</li>';
						*/
						$active = "";
						if($this->router->fetch_class() == 'pagos')
						{
							$active = "active";
						}
						echo '<li class="'.$active.'">
							<a href="'.site_url('pagos').'">
							    <i class="fas fa-dollar-sign"></i>
							    <span>'.$palabras[559]['pal_desc'].'</span>
						    </a>
						</li>';

						$active = "";
						if($this->router->fetch_class() == 'bloqueos')
						{
							$active = "active";
						}
						echo '<li class="'.$active.'">
							<a href="'.site_url('bloqueos').'">
							    <i class="fas fa-user-slash"></i>
							    <span>'.$palabras[560]['pal_desc'].'</span>
						    </a>
						</li>';
						
						/*
							echo '<li class="has-sub '.$active.'">
								<a href="javascript:;">
								    <b class="caret pull-right"></b>
								    <i class="'.$pagina['pag_icono'].'"></i> 
								    <span>'.$pagina['pag_nombre'].'</span>
								</a>
								<ul class="sub-menu">';
								foreach ($subpaginas as $key_subpag => $subpagina)
								{
									$subactive = "";
									if($this->router->fetch_class() == $subpagina['pag_class'] && $this->router->fetch_method() == $subpagina['pag_method'])
									{
										$subactive = "active";
									}
									echo '<li class="'.$subactive.'"><a href="'.site_url($subpagina['pag_class'].'/'.$subpagina['pag_method']).'">'.$subpagina['pag_nombre'].'</a></li>';
								}
							echo '</ul>
							</li>';
						*/
					?>
			        <!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			        <!-- end sidebar minify button -->
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->