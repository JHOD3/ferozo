<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

<link href="<?=base_url()?>assets/css/mensajes.css" rel="stylesheet" id="theme" />

<body>

<!-- Header -->
<?php
$this->load->view('templates/analytics');
$this->load->view('templates/header');
?>
<!-- /Header -->
	
<?php
$this->load->view('templates/sidebar_left');
?>

<!-- Content -->
<main class="content">

	<!-- Features -->
	<section class="container-fluid">
		
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-danger" style="background:#FFFFFF;">
				  <div class="panel-heading">
        		<a href="<?=site_url('foro/filtros')?>" class="pull-right flip" id="filtro"><i class='fa fa-filter'></i></a>
        		<a class="pull-right flip" style="margin-right:10px;" href="<?=site_url()?><?=$solapa?>/nuevo"><i class="fas fa-plus-circle"></i></a>
				    <h3 class="panel-title" style="padding:6px 0px;">CHAT</h3>
				  </div>
				  <div class="panel-body" style="padding:0px;">





                <!-- begin wrapper -->
                    <div class="wrapper bg-silver-lighter">
                        <!-- begin btn-toolbar -->
                        <div class="btn-toolbar">
                            <!-- begin btn-group -->
                            <!-- <div class="btn-group pull-right">
                                <button class="btn btn-white btn-sm">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="btn btn-white btn-sm">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div> -->
                            <!-- end btn-group -->
                            <!-- begin btn-group -->
                            <!-- <div class="btn-group dropdown">
                                <button class="btn btn-white btn-sm dropdown-toggle" data-toggle="dropdown">
                                    View All <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu text-left text-sm">
                                    <li class="active"><a href="#"><i class="fas fa-circle f-s-10 fa-fw m-r-5"></i> All</a></li>
                                    <li><a href="javascript:;"><i class="fa f-s-10 fa-fw m-r-5"></i> Unread</a></li>
                                    <li><a href="javascript:;"><i class="fa f-s-10 fa-fw m-r-5"></i> Contacts</a></li>
                                    <li><a href="javascript:;"><i class="fa f-s-10 fa-fw m-r-5"></i> Groups</a></li>
                                    <li><a href="javascript:;"><i class="fa f-s-10 fa-fw m-r-5"></i> Newsletters</a></li>
                                    <li><a href="javascript:;"><i class="fa f-s-10 fa-fw m-r-5"></i> Social updates</a></li>
                                    <li><a href="javascript:;"><i class="fa f-s-10 fa-fw m-r-5"></i> Everything else</a></li>
                                </ul>
                            </div> -->
                            <!-- end btn-group -->
                            <!-- begin btn-group -->
                            <!-- <div class="btn-group">
                                <button class="btn btn-sm btn-white" data-toggle="tooltip" data-placement="top" data-title="Refresh" data-original-title="" title=""><i class="fas fa-sync"></i></button>
                            </div> -->
                            <!-- end btn-group -->
                            <!-- begin btn-group -->
                            <!-- <div class="btn-group">
                                <button class="btn btn-sm btn-white hide" data-email-action="delete"><i class="fas fa-times m-r-3"></i> <span class="hidden-xs">Delete</span></button>
                                <button class="btn btn-sm btn-white hide" data-email-action="archive"><i class="fas fa-folder m-r-3"></i> <span class="hidden-xs">Archive</span></button>
                                <button class="btn btn-sm btn-white hide" data-email-action="archive"><i class="fas fa-trash m-r-3"></i> <span class="hidden-xs">Junk</span></button>
                            </div> -->
                            <!-- end btn-group -->
                        </div>
                        <!-- end btn-toolbar -->
                    </div>
                <!-- end wrapper -->
                <!-- begin list-email -->
                    <ul class="list-group list-group-lg no-radius list-email">
                      <?php
                      foreach ($chats as $key => $chat) 
                      {
                        $background = "";
                        if($chat['ultimo_mensaje_estado'] < 3)
                        {
                          $background = "background:#EEE;";
                        }

                        echo '<li class="list-group-item danger" style="'.$background.'" onclick="location.href=\''.site_url('mensajes/view/'.$chat['usr_id']).'\'">
                              <!-- <div class="email-checkbox">
                                  <label>
                                      <i class="fa fa-square-o"></i>
                                      <input type="checkbox" data-checked="email-checkbox" />
                                  </label>
                              </div> -->
                              <a href="javascript:;" class="email-user">
                                  <img src="'.base_url('images/usuarios/perfil.jpg').'" alt="" />
                              </a>
                              <div class="email-info">
                                  <span class="email-time">Today</span>
                                  <h5 class="email-title">
                                      <a href="javascript:;">'.$chat['usr_apellido'].' '.$chat['usr_nombre'].'</a>
                                      <!-- <span class="label label-inverse f-s-10">admin</span> -->
                                  </h5>
                                  <p class="email-desc">'.$chat['ultimo_mensaje'].'</p>
                              </div>
                          </li>';
                      }
                      ?>
                    </ul>
                <!-- end list-email -->






				      <div id="results" style="display:none;">
			        </div>

			        <p id="loading" style="display:none;">
			          <img src="<?=base_url('assets/images/loading.png')?>" alt="Loading…" width="50px"/>
			        </p>

				  </div>
				</div>
			</div>

		</div>
	</section>
	<!-- /Features -->

</main>

<?php
$this->load->view('templates/footer');
?>

<script type="text/javascript">
var offset = 0;
var limit = 10;
var fin = false;
var buscando = false;

function ver_foro(id)
{
  location.href=SITE_URL+"<?=$solapa?>/view/"+id;
}

$(document).ready(function() {
  var win = $(window);

  // Each time the user scrolls
  win.scroll(function() {
    if(!buscando)
    {
      if ($(document).height() - win.height() == win.scrollTop() && !fin)
      {
        buscando = true;
        //buscar();
      }
    }
  });

  //buscar();
});

function buscar()
{
  $('#loading').show();

  if(buscar_ultimos_ajax)
  {
    buscar_ultimos_ajax.abort();
  }

    $.ajax({
      url: SITE_URL+'foro/buscar_resultados_ajax/'+offset+'/'+limit,
      dataType: 'json',
      timeout: 5000,
      success: function(data) {
        if(data.cant == -1)
        {
          fin = true;
          var htmlData = "";
          htmlData += "<?=mostrar_palabra(56, $palabras)?><br><br>";
          //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_DEMANDA?>'><img src='"+BASE_URL+"images/demanda.png' class='img-responsive'> <?=$palabras[24]['pal_desc']?> <i class='fa fa-plus fa-3x'></i></a>";
          //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_OFERTA?>'><img src='"+BASE_URL+"images/oferta.png' class='img-responsive'> <?=$palabras[23]['pal_desc']?> <i class='fa fa-plus fa-3x'></i></a>";
          htmlData += "<div style='clear:both; height:20px;'></div>";
          $('#results').append(htmlData);
          $('#area_primera_cargar').show();
          $('#modal_tutorial').modal('show');
        }
        else if(data.cant == -2)
        {
          fin = true;
          var htmlData = "";
          htmlData += "<?=mostrar_palabra(274, $palabras)?><br><br>";
          //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_DEMANDA?>'><img src='"+BASE_URL+"images/demanda.png' class='img-responsive'> <?=$palabras[24]['pal_desc']?> <i class='fa fa-plus fa-3x'></i></a>";
          //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_OFERTA?>'><img src='"+BASE_URL+"images/oferta.png' class='img-responsive'> <?=$palabras[23]['pal_desc']?> <i class='fa fa-plus fa-3x'></i></a>";
          htmlData += "<div style='clear:both; height:20px;'></div>";
          $('#header_resultados').show();
          $('#results').show();
          $('#results').append(htmlData);
        }
        else if(data.cant == 0)
        {
          fin = true;
          if(offset == 0)
          {
            var htmlData = "";
            htmlData += "<?=mostrar_palabra(56, $palabras)?><br><?=mostrar_palabra(243, $palabras)?><br>";
            //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_DEMANDA?>'><img src='"+BASE_URL+"images/demanda.png' class='img-responsive'> <?=$palabras[24]['pal_desc']?> <i class='fa fa-plus fa-3x'></i></a>";
            //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_OFERTA?>'><img src='"+BASE_URL+"images/oferta.png' class='img-responsive'> <?=$palabras[23]['pal_desc']?> <i class='fa fa-plus fa-3x'></i></a>";
            htmlData += "<div style='clear:both; height:20px;'></div>";
            //$('#results').append(htmlData);
            $('#area_botones_cargar').show();
            $('#results').show();
            $( "#area-mayor-actividad" ).appendTo( "#results" );
          }
        }
        else
        {
          $('#header_resultados').show();
          $('#results').show();
          if(data.cant < limit)
          {
            fin = true;
          }
          offset += data.cant;

          var htmlData = "";
          $.each(data.result, function(i, item) {
            
            htmlData += '<div class="media foro" id="prod_'+item.foro_id+'" onclick="ver_foro('+item.foro_id+')" style="cursor:pointer;">';
              htmlData += '<div class="media-left">';
              if($foro['usr_imagen'])
              {
                htmlData += "<img id='img_user' src='"+BASE_URL+"images/usuarios/"+item.usr_imagen+"' class='img-circle img-user' width='50'>";
              }
              else
              {
              	htmlData += "<img id='img_user' src='"+BASE_URL+"images/usuarios/perfil.png' class='img-circle img-user' width='50'>";
              }
              htmlData += '</div>';
              htmlData += '<div class="media-body">';
                htmlData += '<strong>'+item.usr_mail+'</strong><br>';
                htmlData += '<small class="texto-bordo" style="display:block; margin-bottom:5px;"><strong>'+item.fecha_ultimo_comentario+"</strong></small>";
                htmlData += '<span>'+item.foro_descripcion+'</span><br>';
                  //htmlData += $foro['ara_desc'].'<br>';
                if($foro['sec_id'])
                {
                  	htmlData += '<small class="texto-bordo" style="display:block; margin-top:5px;">';
	                    if($foro['sec_id'] == 22)
	                    {
	                      htmlData += '<b>'+item.ara_code+'</b> - <?=mostrar_palabra(21, $palabras)?><br>';
	                  	}
	                    else
	                    {
	                      htmlData += '<b>'+item.ara_code+'</b> - <?=mostrar_palabra(22, $palabras)?><br>';
	                  	}
                  	htmlData += '</small>';
                  	if($foro['ctry_code'])
                    {
                    	htmlData += "<small><img src='"+BASE_URL+"images/banderas/"+item.ctry_code+".png'> "+item.ctry_nombre+"</small>";
                	}
                }
              htmlData += '</div>';
              	htmlData += '<div class="panel-footer">';
                    htmlData += '<div class="col-xs-6 visit text-left flip">';
	                	htmlData += item.cant_visitas+" <i class='fa fa-eye fa-lg'></i>";
	              	htmlData += '</div>';
	              	htmlData += '<div class="col-xs-6 cant text-right flip">';
	                	htmlData += item.cant_mensajes+" <i class='fa fa-comments fa-lg'></i>";
	              	htmlData += '</div>';
	              	htmlData += '<div style="clear:both;"></div>';
              	htmlData += '</div>';
            htmlData += '</div>';
          });

          $("#results").append(htmlData);
        }
        $('#loading').hide();
        buscando = false;
      },
      error: function(x, status, error){
        var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i>';
        htmlData += "An error occurred: " + status + " nError: " + error;
        htmlData += '</div>';
        //alert(htmlData);
      }
    });

}
</script>

</body>
</html>