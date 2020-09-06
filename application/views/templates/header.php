<?php
$pal_ids = array(247, 36, 38, 290, 8, 82, 84, 86, 339, 294, 57, 240, 45, 18, 505,1004,1005,1006,932);
$palabras_header = $this->palabras_model->get_items_especificos($this->session->userdata('idi_code'), $pal_ids);
?>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a href="<?=site_url()?>resultados"><img src="<?=base_url()?>assets/images/logo.png" height="22" style="margin:18px 0 0 10px;"></a>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <form action="<?=site_url()?>resultados/filtros" method="POST" class="navbar-form navbar-left hidden-xs" role="search" style="margin-top:14px;">
        <div class="form-group">
          <input type="text" class="form-control search" placeholder="<?=mostrar_palabra(247, $palabras_header)?>" name="search" value="<?=$this->session->userdata('search')?>">
        </div>
        <button type="submit" class="btn btn-default" name="enviar" value="enviar"><?=mostrar_palabra(36, $palabras_header)?></button>
      </form>

      <ul class="nav navbar-nav navbar-right hidden-xs" style="position:relative">
        <li class="dropdown question">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa-stack" style="font-size:16px;"><i class="fas fa-circle fa-stack-2x" style="color:#78081E"></i><i class="fas fa-question fa-stack-1x fa-inverse" style="color:#BC0F20;"></i></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?=site_url('pages/contacto')?>"><?=mostrar_palabra(38, $palabras_header)?></a></li>
              <li><a href="<?=site_url('faq')?>"><?=mostrar_palabra(290, $palabras_header)?></a></li>
            </ul>
        </li>
        
        <li class="question">
          <a href="<?=site_url('notificaciones')?>" role="button">
            <span class="fa-stack" style="font-size:16px;">
              <i class="fas fa-circle fa-stack-2x" style="color:#78081E"></i>
              <i class="fas fa-bell fa-stack-1x fa-inverse" style="color:#BC0F20;"></i>
            </span>
            <?php
            $cant_noti = $this->notificaciones_model->get_cant_no_vistos($this->session->userdata('usr_id'));
            if($cant_noti && $cant_noti['cant']>0)
            {
              echo '<span class="badge" id="noti_badge">'.$cant_noti['cant'].'</span>';
            }
            ?>
          </a>
        </li>

        <li class="question">
          <a href="<?=site_url('mensajes')?>" role="button">
            <span class="fa-stack" style="font-size:16px;">
              <i class="fas fa-circle fa-stack-2x" style="color:#78081E"></i>
              <i class="fas fa-comment fa-stack-1x fa-inverse" style="color:#BC0F20;"></i>
            </span>
            <?php
            $cant_mensajes = $this->mensajes_model->get_cant_mensajes_sin_leer();
            if($cant_mensajes && $cant_mensajes['cant']>0)
            {
              echo '<span class="badge" id="noti_badge">'.$cant_mensajes['cant'].'</span>';
            }
            ?>
          </a>
        </li>
        
        <li class="dropdown hidden-xs">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="padding:10px 10px; max-width: 280px;">
            <?php
            if($this->session->userdata('usr_id') != "")
            {
              echo "<img src='".base_url()."images/usuarios/".$this->session->userdata('usr_imagen')."' class='img-circle img-user m-r-5' width='40px'> ";
              $nombre_aux = mostrar_nombre($this->session->userdata('usr_nombre'), $this->session->userdata('usr_apellido'), $this->session->userdata('usr_mail'));
              echo cortarTexto($nombre_aux,24);
            }
            ?>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?=site_url('user/profile')?>"><?=mostrar_palabra(8, $palabras_header)?></a></li>
            <li><a href="<?=site_url('productos/index/1')?>"><?=mostrar_palabra(82, $palabras_header)?></a></li>
            <li><a href="<?=site_url('productos/index/2')?>"><?=mostrar_palabra(84, $palabras_header)?></a></li>
            <li><a href="<?=site_url('resultados')?>"><?=mostrar_palabra(86, $palabras_header)?></a></li>
            <?php
            if($this->session->userdata('ads_id') != "")
            {
              echo '<li><a href="'.site_url().LINK_ADS.'">'.mostrar_palabra(505, $palabras_header).'</a></li>';
            }
            else
            {
              echo '<li><a href="'.site_url('planes').'">'.mostrar_palabra(505, $palabras_header).'</a></li>';
            }
            ?>
            <li role="separator" class="divider"></li>
            <li><a href="<?=site_url('resultados/otros')?>"><?=mostrar_palabra(339, $palabras_header)?></a></li>
            <li><a href="<?=site_url('foro')?>"><?=mostrar_palabra(294, $palabras_header)?></a></li>
            <li><a href="<?=site_url('estadisticas')?>"><?=mostrar_palabra(57, $palabras_header)?></a></li>
            <li><a href="<?=site_url('estadisticas/index_productos')?>"><?=mostrar_palabra(240, $palabras_header)?></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?=site_url('user/password')?>"><?=mostrar_palabra(45, $palabras_header)?></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?=site_url('login/logout')?>"><?=mostrar_palabra(18, $palabras_header)?></a></li>
          </ul>
        </li>
      </ul>

      <ul class="nav navbar-nav visible-xs">
        <li><a href="<?=site_url('user/profile')?>" <?php if($this->router->fetch_method() == "profile") echo "class='active'";?>><?=mostrar_palabra(8, $palabras_header)?></a></li>
        <li><a href="<?=site_url('productos/index/1')?>"><?=mostrar_palabra(82, $palabras_header)?></a></li>
        <li><a href="<?=site_url('productos/index/2')?>"><?=mostrar_palabra(84, $palabras_header)?></a></li>
        <li><a href="<?=site_url('resultados')?>"><?=mostrar_palabra(86, $palabras_header)?></a></li>
        <?php
        if($this->session->userdata('ads_id') != "")
        {
          echo '<li><a href="'.site_url().LINK_ADS.'">'.mostrar_palabra(505, $palabras_header).'</a></li>';
        }
        else
        {
          echo '<li><a href="'.site_url('planes').'">'.mostrar_palabra(505, $palabras_header).'</a></li>';
        }
        ?>
        <hr style="margin:0px;"></hr>
        <li><a href="<?=site_url('resultados/otros')?>"><?=mostrar_palabra(339, $palabras_header)?></a>11111</li>
        <li><a href="<?=site_url('foro')?>"><?=mostrar_palabra(294, $palabras_header)?></a></li>
        <li><a href="<?=site_url('estadisticas')?>"><?=mostrar_palabra(57, $palabras_header)?></a></li>
        <li><a href="<?=site_url('estadisticas/index_productos')?>"><?=mostrar_palabra(240, $palabras_header)?></a></li>
        <li><a href="<?=site_url('faq')?>"><?=mostrar_palabra(290, $palabras_header)?> <i class="fa fa-question-circle"></i></a></li>
        <hr style="margin:0px;"></hr>
        <li><a href="<?=site_url('user/password')?>"><?=mostrar_palabra(45, $palabras_header)?></a></li>
        <hr style="margin:0px;"></hr>
        <li><a href="<?=site_url('login/logout')?>"><?=mostrar_palabra(18, $palabras_header)?></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>



