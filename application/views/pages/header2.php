<?php
$pal_ids = array(1, 103, 112, 116, 117, 290, 38);
$palabras_header = $this->palabras_model->get_items_especificos($this->session->userdata('idi_code'), $pal_ids);
?>
<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a href="<?=site_url()?>resultados"><img src="<?=base_url()?>assets/images/logo.png" height="22" style="margin:15px 0 0 10px;"></a>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <!--<li <?php if($this->router->fetch_method() == "nosotros") echo "class='active'";?>><a href="<?=site_url('pages/nosotros')?>"><?=mostrar_palabra(103, $palabras_header)?></a></li>-->
        <li <?php if($this->router->fetch_method() == "mundo") echo "class='active'";?>><a href="<?=site_url('pages/mundo')?>"><?=mostrar_palabra(112, $palabras_header)?></a></li>
        <li <?php if($this->router->fetch_method() == "servicio") echo "class='active'";?>><a href="<?=site_url('pages/servicio')?>"><?=mostrar_palabra(116, $palabras_header)?></a></li>
        <li <?php if($this->router->fetch_method() == "privacidad") echo "class='active'";?>><a href="<?=site_url('pages/privacidad')?>"><?=mostrar_palabra(117, $palabras_header)?></a></li>
        <li <?php if($this->router->fetch_class() == "faq") echo "class='active'";?>><a href="<?=site_url('faq')?>"><?=mostrar_palabra(290, $palabras_header)?></a></li>
        <li <?php if($this->router->fetch_method() == "contacto") echo "class='active'";?>><a href="<?=site_url('pages/contacto')?>"><?=mostrar_palabra(38, $palabras_header)?></a></li>
        <li class="dropdown">
          <?php
            if($this->session->userdata('usr_id') == "")
            {
              echo '<a href="'.site_url('pages').'" role="button" >'.mostrar_palabra(1, $palabras_header).'</a>';
            }
            else
            {
              echo '<a href="'.site_url('resultados').'" role="button" >'.mostrar_palabra(1, $palabras_header).'</a>';
            }
          ?>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
