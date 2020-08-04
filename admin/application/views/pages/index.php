<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<body>

    <div id="wrapper">

        <?php
		$this->load->view('templates/header');
		?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Inicio <small>estadisticas generales</small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                <!--
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong>Like SB Admin?</strong> Try out <a href="http://startbootstrap.com/template-overviews/sb-admin-2" class="alert-link">SB Admin 2</a> for additional features!
                        </div>
                    </div>
                </div>
                -->
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$cant_usuarios['cant']?> <small>(<?=$cant_usuarios_activos['cant']?>)</small></div>
                                        <div>Usuarios</div>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <a href="<?=site_url()?>horas/nueva/add">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver más</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                            -->
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$ultimos_accesos['cant']?></div>
                                        <div>Ultimos accesos (7 dias)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$cant_productos['cant']?> <small>(<?=$cant_productos_oferta['cant']?> O - <?=$cant_productos_demanda['cant']?> D)</small></div>
                                        <div>Productos</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$cant_servicios['cant']?> <small>(<?=$cant_servicios_oferta['cant']?> O - <?=$cant_servicios_demanda['cant']?> D)</small></div>
                                        <div>Servicios</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Usuarios x mes</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-area-chart"></div>
                                <!--
                                <div class="text-right">
                                    <a href="<?=site_url()?>estadisticas/usuarios">Ver todos los años <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                                -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <hr>

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$cant_matchs['cant']?> <small>(<?=$cant_matchs_reales['cant']?>)</small></div>
                                        <div>Matchs</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=$cant_usuarios_match['cant']?> <small>(<?=$cant_usuarios_match_reales['cant']?>)</small></div>
                                        <div>Usuarios con matchs</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Matchs x mes</h3>
                            </div>
                            <div class="panel-body">
                                <div id="matchs-area-chart"></div>
                                <!--
                                <div class="text-right">
                                    <a href="<?=site_url()?>estadisticas/usuarios">Ver todos los años <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                                -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Posiciones con más matchs</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table">
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Descripcion</th>
                                        <th>Cantidad</th>
                                    </tr>
                                    <?php
                                    foreach ($posiciones_match as $key => $value)
                                    {
                                        echo '<tr>';
                                            echo '<td>'.$value['ara_code'].'</td>';
                                            echo '<td>'.$value['ara_desc'].'</td>';
                                            echo '<td>'.$value['cant'].'</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </table>
                                <!--
                                <div class="text-right">
                                    <a href="<?=site_url()?>estadisticas/usuarios">Ver todos los años <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                                -->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Paises con más matchs</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table">
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Cantidad</th>
                                    </tr>
                                    <?php
                                    foreach ($paises_match as $key => $value)
                                    {
                                        echo '<tr>';
                                            echo '<td>'.$value['ctry_code'].'</td>';
                                            echo '<td>'.$value['ctry_nombre'].'</td>';
                                            echo '<td>'.$value['cant'].'</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </table>
                                <!--
                                <div class="text-right">
                                    <a href="<?=site_url()?>estadisticas/usuarios">Ver todos los años <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                                -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php
    $this->load->view('templates/footer');
    ?>

<script type="text/javascript">
function cargar_grafico_plata()
{
    $.ajax({
        url: "<?=site_url()?>pages/grafico_usuarios_ajax",
        type: "GET",
        dataType: "json",
        success: function(data){
            // Bar Chart
            chart = Morris.Area({
                element: 'morris-area-chart',
                data: data.data,
                xkey: 'period',
                ykeys: ['usuarios', 'productos'],
                labels: ['Usuarios', 'Productos'],
                lineColors: ["#5CB85C", "#D9534F"],
                pointSize: 2,
                hideHover: 'auto',
                resize: true
            });

            chart.on('click', function(i, row) {
                location.href="<?=site_url()?>estadisticas/plata_mensual/"+row.period;
            });
        },
       error: function(x, status, error){
          alert("An error occurred: " + status + " nError: " + error);
       }
    });
}

cargar_grafico_plata();
</script>

</body>

</html>