<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

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

				<div class="panel panel-danger" id="header_resultados" style="background:#FFF;">
				  <div class="panel-heading">
				    <h3 class="panel-title">Notificaciones</h3>
				  </div>
        
          <?php
            echo '<div class="panel-body" style="padding: 0px;" id="results">';
            /*
                      echo "<table class='table table-striped' id='results'>";
                      echo "<tr>";
                        echo "<th width='120px' style='text-align:center; background:#C8241B; border:none;'><i class='fa fa-code fa-2x'        data-toogle='tooltip' data-placement='bottom' title='".mostrar_palabra(22, $palabras)."'  style='color:#78081E;'></i></th>";
                        echo "<th class='hidden-xs' style='text-align:center; background:#C8241B; border:none;'><i class='fa fa-align-left fa-2x'  data-toogle='tooltip' data-placement='bottom' title='".mostrar_palabra(164, $palabras)."' style='color:#78081E;'></i></th>";
                        echo "<th style='text-align:center; background:#C8241B; border:none;'><i class='fa fa-dollar-sign fa-2x' data-toogle='tooltip' data-placement='bottom' title='".mostrar_palabra(215, $palabras)."' style='color:#78081E;'></i></th>";
                        echo "<th width='120px' style='text-align:center; background:#C8241B; border:none;'>
                          <i class='fa fa-percent fa-2x' data-toogle='tooltip' data-placement='bottom' title='a' style='color:#78081E;'></i>
                          <i class='fa fa-signal fa-2x' data-toogle='tooltip' data-placement='bottom' title='b' style='color:#78081E;'></i>
                        </th>";
                      echo "</tr>";
                      echo "</table>";
            */
            echo '</div>';
          ?>
        </div>

        <div id="loading" style="display:none; width:100%; text-align:center; clear:both;">
          <img src="<?=base_url('assets/images/loading.png')?>" alt="Loading…" width="50px" style="margin:auto;"/>
        </div>

			</div>
			<?php
			//$this->load->view('templates/sidebar_right');
			?>
		</div>
	</section>
	<!-- /Features -->

</main>


<?php
//$this->load->view('templates/menu_footer');
$this->load->view('templates/footer');
?>

<script type="text/javascript">
var offset = 0;
var limit = 20;
var fin = false;
var buscando = false;


function ver_item(link)
{
  if(link && link != "null")
  {
    location.href = SITE_URL+link;
  }
}


$(document).ready(function() {
  var win = $(window);

  // Each time the user scrolls
  win.scroll(function() {
    if(!buscando)
    {
      if(($(document).height() - win.height() - 10) <= win.scrollTop() && !fin)
      {
        buscando = true;
        buscar();
      }
    }
  });

  buscar();
});

function buscar()
{
  $('#loading').show();

  if(buscar_ultimos_ajax)
  {
    buscar_ultimos_ajax.abort();
  }

    $.ajax({
      url: SITE_URL+'notificaciones/buscar_ajax/'+offset+'/'+limit,
      dataType: 'json',
      timeout: 5000,
      success: function(data) {
        if(data.result.length == 0)
        {
          fin = true;
          if(offset == 0)
          {
            var htmlData = "";
            htmlData += "<?=mostrar_palabra(56, $palabras)?><br><?=mostrar_palabra(243, $palabras)?><br>";
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
          if(data.result.length < limit)
          {
            fin = true;
          }
          offset += data.result.length;

          var num_item = 0;

          $.each(data.result, function(i, item) {
            var background = "background:#f1f2f2;";
            if(item.note_id < <?=NOTI_ESTADO_VISTA?>)
            {
              background = "background:#DDD;";
            }
            var htmlData = "";
            htmlData += '<div class="media" style="padding:20px; cursor:pointer; '+background+'" onclick="ver_item(\''+item.not_link+'\')">';
              htmlData += '<div class="pull-right">';
                htmlData += '<a href="#">';
                  htmlData += item.not_fecha.substr(0, 10);
                htmlData += '</a>';
              htmlData += '</div>';
              htmlData += '<div class="media-left">';
                htmlData += '<a href="#">';
                  //htmlData += '<img class="media-object" src="'++'" alt="...">';
                  if(item.usr_imagen)
                  {
                    htmlData += "<a href='"+SITE_URL+"user/view/"+item.usr_id+"'><img class='img-circle media-object' src='"+BASE_URL+"images/usuarios/"+item.usr_imagen+"' width='80px'></a>";
                    //htmlData += "<img class='img-circle media-object' src='"+BASE_URL+"images/usuarios/perfil.jpg' width='80px'>";
                  }
                  else
                  {
                    htmlData += "<img class='img-circle media-object' src='"+BASE_URL+"images/usuarios/perfil.jpg' width='80px'>";
                  }
                htmlData += '</a>';
              htmlData += '</div>';
              htmlData += '<div class="media-body">';
                if(item.usr_emisor && item.usr_emisor != "null")
                {
                  htmlData += '<h4 class="media-heading">'+item.usr_nombre+' '+item.usr_apellido+'</h4>';
                  htmlData += '<p>'+item.usr_mail+'</p>';
                }
                if(item.not_descripcion)
                {
                  htmlData += item.not_descripcion;
                }
              htmlData += '</div>';
            htmlData += '</div>';
            /*
            htmlData += "<tr onclick='ver_item("+item.not_tipo_id+","+item.not_aux_id+")'>";
              htmlData += "<td>"+item.not_fecha+"</td>";
              htmlData += "<td>"+item.usr_nombre+" "+item.usr_apellido+"</td>";
              htmlData += "<td class='hidden-xs'></td>";

              var valor = item.comc_valor_fin;

              htmlData += "<td>"+item.+"</td>";
              htmlData += "<td>"+item.comc_porcentaje+"</td>";
            htmlData += "</tr>";
            */
            $("#results").append(htmlData);
          });
          //Escondo el badge del header
          $('#noti_badge').hide();
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