		<!-- begin #header -->
		<div id="header" class="header navbar navbar-inverse navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="<?=site_url()?>" class="navbar-brand"><span class="navbar-logo"><img src="<?=base_url('assets/img/logo.png')?>" width="130px"></span><span style="line-height:54px;">Ads</span></a>
					<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
				
				<!-- begin header navigation right -->
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<img src="<?=FRONT_URL.'images/usuarios/'.$this->session->userdata('usr_imagen')?>" alt="" /> 
							<?php
							echo '<span class="hidden-xs">';
							if($this->session->userdata('usr_nombre') != "" || $this->session->userdata('usr_apellido') != "")
							{
								echo $this->session->userdata('usr_nombre')." ".$this->session->userdata('usr_apellido');
							}
							else
							{
								echo $this->session->userdata('usr_mail');
							}
							echo '</span> <b class="caret"></b>';
							?>
						</a>
						<ul class="dropdown-menu animated fadeInLeft">
							<li><a href="<?=FRONT_URL?>/resultados"><?=ucfirst(mostrar_palabra(609, $palabras))?></a></li>
							<li class="divider"></li>
							<li><a href="<?=site_url('login/logout')?>"><?=ucfirst(mostrar_palabra(18, $palabras))?></a></li>
						</ul>
					</li>
				</ul>
				<!-- end header navigation right -->
			</div>
			<!-- end container-fluid -->
		</div>
		<!-- end #header -->
		