<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li <?php if($this->router->fetch_class()=='administradores') echo "class='active'"; ?>>
            <a href="<?=site_url('administradores')?>"><i class="fa fa-fw fa-user-secret"></i> Administradores</a>
        </li>
        <li <?php if($this->router->fetch_class()=='usuarios') echo "class='active'"; ?>>
            <a href="<?=site_url('usuarios')?>"><i class="fa fa-fw fa-users"></i> Usuarios</a>
        </li>
        <li <?php if($this->router->fetch_class()=='paises'||$this->router->fetch_class()=='ciudades'||$this->router->fetch_class()=='idiomas') echo "class='active'"; ?>>
            <a href="javascript:;" data-toggle="collapse" data-target="#posiciones"><i class="fa fa-fw fa-podcast"></i> Posiciones arancelarias <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="posiciones" class="collapse">
                <li><a href="<?=site_url('posiciones/secciones')?>">Secciones</a></li>
                <li><a href="<?=site_url('posiciones/categorias')?>">Categorias</a></li>
                <li><a href="<?=site_url('posiciones')?>">Aranceles</a></li>
            </ul>
        </li>
        <li <?php if($this->router->fetch_class()=='productos') echo "class='active'"; ?>>
            <a href="<?=site_url('productos')?>"><i class="fa fa-fw fa-shopping-cart"></i> Productos</a>
        </li>
        <li <?php if($this->router->fetch_class()=='mails') echo "class='active'"; ?>>
            <a href="<?=site_url('mails')?>"><i class="fa fa-fw fa-envelope"></i> Mails</a>
        </li>
        <li <?php if($this->router->fetch_class()=='palabras') echo "class='active'"; ?>>
            <a href="<?=site_url('palabras')?>"><i class="fa fa-fw fa-font"></i> Palabras</a>
        </li>
        <li <?php if($this->router->fetch_class()=='mails_contenido') echo "class='active'"; ?>>
            <a href="<?=site_url('mails_contenido')?>"><i class="fa fa-fw fa-envelope-o"></i> Mails contenido</a>
        </li>
        <li <?php if($this->router->fetch_class()=='faq') echo "class='active'"; ?>>
            <a href="<?=site_url('faq')?>"><i class="fa fa-fw fa-question-circle-o"></i> FAQ</a>
        </li>
        <li <?php if($this->router->fetch_class()=='paises'||$this->router->fetch_class()=='ciudades'||$this->router->fetch_class()=='idiomas') echo "class='active'"; ?>>
            <a href="javascript:;" data-toggle="collapse" data-target="#datos"><i class="fa fa-fw fa-database"></i> Datos <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="datos" class="collapse">
                <li><a href="<?=site_url('paises')?>">Paises</a></li>
                <li><a href="<?=site_url('ciudades')?>">Ciudades</a></li>
                <li><a href="<?=site_url('idiomas')?>">Idiomas</a></li>
            </ul>
        </li>
        <li <?php if($this->router->fetch_class()=='politicas') echo "class='active'"; ?>>
            <a href="<?=site_url('politicas')?>"><i class="fa fa-fw fa-copyright"></i> Politicas</a>
        </li>
        <li <?php if($this->router->fetch_class()=='precios') echo "class='active'"; ?>>
            <a href="<?=site_url('precios')?>"><i class="fa fa-fw fa-usd"></i> Precios</a>
        </li>
    </ul>
</div>
<!-- /.navbar-collapse -->