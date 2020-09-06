<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
/*robert*/
$pal_ids = array(93, 0, 2, 3, 4, 5, 6, 41, 1, 94, 95, 96, 97, 98, 99, 171);
$palabras_header = $this->palabras_model->get_items_especificos($this->session->userdata('idi_code'), $pal_ids);

/*robert*/
?>
<style>
.modal .modal-dialog .modal-content{  background-color: #B00035; }
.modal .modal-dialog .modal-content .modal-header{  background-color: #B00035; }
.modal .modal-dialog .modal-content .modal-footer{  background-color: #ce2600; }
</style>

<body>

<?php
$this->load->view('templates/analytics');
$this->load->view('pages/header2');
?>
	

<!-- Content -->
<main class="" style="margin-bottom:0px;">

	<!-- Lead -->
	<section class="container space-before">
    <div id="loading" style="position:fixed; top:60px; right: 20px; display:none;"><img src="<?=base_url('assets/images/loading.png')?>" width="50px"></div>
		<div class="row">
			<div class="col-sm-10 col-sm-push-1">
				<h1 class="text-center"><?=mostrar_palabra(113, $palabras)?></h1>
				<p class="lead text-center">
				</p> 
			</div>
		</div>
	</section>
	<!-- /Lead -->

  <section class="container">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 skills wow fadeInUp">
          <div class="col-sm-4">
            <div class="percentage easyPieChart" data-percent="<?=$cant_usuarios['cant']?>" data-delay="2000"><span>0</span><canvas width="165" height="165"></canvas></div>
            <small><?=mostrar_palabra(214, $palabras)?></small>
          </div>
          <div class="col-sm-4">
            <div class="percentage easyPieChart" data-percent="<?=$cant_ofertas['cant']?>" data-delay="2000"><span>0</span><canvas width="165" height="165"></canvas></div>
            <small><?=mostrar_palabra(19, $palabras)?></small>
          </div>
          <div class="col-sm-4">
            <div class="percentage easyPieChart" data-percent="<?=$cant_demandas['cant']?>" data-delay="2000"><span>0</span><canvas width="165" height="165"></canvas></div>
            <small><?=mostrar_palabra(20, $palabras)?></small>
          </div>
        </div>
    </div>
  </section>
  <!--/ Skills row end -->

  <div id="map"></div>

</main>

<!-- Modal -->
<div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" id="area_registro" role="document">
  <form id="form_registro" class="form-horizontal" role="form" action="#">
    <div class="modal-content">
	 <div class="modal-header">
        <h5 class="modal-title" style="color:#FFFFFF" id="titleModalLabel"><?=mostrar_palabra(97, $palabras_header)?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
        <!-- row -->
		<div class="row">
				<div id="result_login"></div>
				
				<div class="container-fluid">
				<div class="form-group">
					<div class="col-md-6 pull-left"><select class="form-control input" name='pais' id="pais_registro">
															<?php
															echo "<option value='' selected disabled style='display:none;'>".mostrar_palabra(2, $palabras_header)."</option>";
															foreach ($paises as $key => $pais)
															{
																echo "<option value='".$pais['ctry_code']."'>".$pais['ctry_nombre']."</option>";
															}
															?>
														</select></div>
					<div class="col-md-6 pull-right">
					<select class="form-control input" name='idioma' id="idioma_registro">
									<?php
									echo "<option value='' selected disabled style='display:none;'>".mostrar_palabra(3, $palabras_header)."</option>";
									foreach ($idiomas as $key => $idioma)
									{
										if($this->session->userdata('idi_code') == $idioma['idi_code'])
				                          $selected = "selected";
				                        else
				                          $selected = "";
										echo "<option value='".$idioma['idi_code']."' ".$selected.">".ucfirst($idioma['idi_desc'])."</option>";
									}
									?>
								</select>
					</div>
				</div>	
					<div class="form-group">
							<div class="col-sm-12">
								<input type="text" class="form-control input" name="mail" placeholder="<?=mostrar_palabra(4, $palabras_header)?>">
							</div>
					</div>
				<div class="form-group">
							<div class="col-sm-6">
								<input type="password" class="form-control input" name="clave" placeholder="<?=mostrar_palabra(5, $palabras_header)?>">
							</div>
							<div class="col-sm-6">
								<input type="password" class="form-control input" name="clave2" placeholder="<?=mostrar_palabra(6, $palabras_header)?> <?=mostrar_palabra(5, $palabras_header)?>">
							</div>
				</div>
		   
				<div class="form-group">
							<div class="col-sm-12">
							<div class="checkbox">
								    <label>
								    	<input type="checkbox" name="acepto"> <a href="<?=site_url()?>pages/servicio" style="color:#FFFFFF"><?=mostrar_palabra(171, $palabras_header)?></a>
								    </label>
								</div>
							</div>
				</div>
		  
		  </div>
				

				
		</div>	<!--row -->
      </div>
	 <div class="modal-footer">
				<div class="form-group col-sm-12">
				<button type="submit" id="btn_registro" class="btn btn-default pull-left" data-loading-text="<?=mostrar_palabra(41, $palabras_header)?>..."><?=mostrar_palabra(0, $palabras_header)?></button>
				<a href="javascript: validar_google();" id="btn_registro_google" class="btn btn-google-plus pull-left" data-loading-text="<?=mostrar_palabra(41, $palabras_header)?>..."><i class="fab fa-lg fa-google-plus-square"></i> <?=mostrar_palabra(0, $palabras_header)?></a>
				</div>
				<div class="form-group text-left">
					<p class="col-xs-12 small" style="color:#FFFFFF"><?=mostrar_palabra(98, $palabras_header)?> <a class="bt-login" href="#" style="color:#FFFFFF"><?=mostrar_palabra(99, $palabras_header)?></a></p>
				</div>	
	 </div>
    </div>
	</form>
  </div>
</div>


<!--area_olvide-->
<div class="modal fade" id="modal_olvide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" id="area_olvide" role="document">
  <form id="form_olvide" class="form-horizontal" role="form" action="#">
    <div class="modal-content">
	 <div class="modal-header">
        <h5 class="modal-title" style="color:#FFFFFF" id="titleModalLabel"><?=mostrar_palabra(97, $palabras_header)?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
        <!-- row -->
		<div class="row">
				<div class="container-fluid">
				<div class="form-group">
					<div class="col-md-12 pull-left">
						<input type="text" class="form-control input" name="mail" placeholder="<?=mostrar_palabra(4, $palabras_header)?>">
					</div>
				</div>	
		  </div>
		</div>	<!--row -->
      </div>
	 <div class="modal-footer">
				<div class="form-group col-sm-12">
					<button type="submit" id="btn_olvide" class="btn btn-default pull-left" data-loading-text="<?=mostrar_palabra(41, $palabras_header)?>..."><?=mostrar_palabra(6, $palabras_header)?></button>
				</div>
				<div class="form-group">
					<div class="col-md-12 text-left">
						<p class="small" style="color:#FFFFFF"><?=mostrar_palabra(96, $palabras_header)?> <a class="bt-registro" href="#" style="color:#FFFFFF"><?=mostrar_palabra(97, $palabras_header)?></a></p>
					</div>	
				</div>
	 </div>
    </div>
	</form>
  </div>
</div>

<!--area_login-->
<div class="modal fade" id="modal_login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" id="area_login" role="document">
  <form id="form_login" class="form-horizontal" role="form" action="#">
    <div class="modal-content">
	 <div class="modal-header">
        <h5 class="modal-title" style="color:#FFFFFF" id="titleModalLabel"><?=mostrar_palabra(97, $palabras_header)?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
        <!-- row -->
		<div class="row">
				<div class="container-fluid">
				<div class="form-group">
					<div class="col-md-6 pull-left">
						<input type="text" class="form-control input" name="mail" placeholder="<?=mostrar_palabra(4, 	$palabras_header)?>">
					</div>
					<div class="col-md-6 pull-right">
						<input type="password" class="form-control input" name="clave" placeholder="<?=mostrar_palabra(5, $palabras_header)?>">
					</div>
				</div>	
		  </div>
		</div>	<!--row -->
      </div>
	 <div class="modal-footer">
				<div class="form-group col-sm-12">
					<button type="submit" id="btn_login" class="btn btn-default pull-left" data-loading-text="<?=mostrar_palabra(41, $palabras_header)?>..."><?=mostrar_palabra(1, $palabras_header)?></button>
					<a href="javascript: validar_google();" id="btn_registro_google" class="btn btn-google-plus pull-left" data-loading-text="<?=mostrar_palabra(41, $palabras_header)?>..."><i class="fab fa-lg fa-google-plus-square"></i> <?=mostrar_palabra(1, $palabras_header)?></a>
				</div>
					<div class="form-group col-md-12 text-left">
						<p class="small" style="color:#FFFFFF"><?=mostrar_palabra(94, $palabras_header)?> <a class="bt-olvide" href="#" style="color:#FFFFFF"><?=mostrar_palabra(95, $palabras_header)?></a></p>
						<p class="small" style="color:#FFFFFF"><?=mostrar_palabra(96, $palabras_header)?> <a class="bt-registro" href="#" style="color:#FFFFFF"><?=mostrar_palabra(97, $palabras_header)?></a></p>
					</div>	
	 </div>
    </div>
	</form>
  </div>
</div>

<?php
$this->load->view('templates/menu_footer');
$this->load->view('templates/footer');
$this->load->view('pages/header_scripts');
?>

<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.easy-pie-chart.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTN2bD-JhU0juAWZRw569qj9Jk7R80H7k&signed_in=true&libraries=places" ></script>
<script src="<?=base_url()?>assets/js/markerclusterer.js"></script>
<style>
  #map {
    width: 100%;
    height: 600px;
  }
</style>
<script>
var map;
var my_marker;
var infowindow;
var myLatlng;
var markers = [];

function initMap() {
  var lat = 0;
  var lng = 0;
  myLatlng = new google.maps.LatLng(lat, lng);

  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: lat, lng: lng},
    zoom: 3,
    minZoom: 3,
    disableDefaultUI: false,
    mapTypeId: google.maps.MapTypeId.ROADMAP
    /*
      styles: [
            {
              "featureType": "landscape.natural",
              "elementType": "geometry.fill",
              "stylers": [
                {
                  "visibility": "on"
                },
                {
                  "color": "#f6f6f6"
                }
              ]
            }
          ]
    */
  });

  infowindow = new google.maps.InfoWindow();

  //dondeEstoy();
  buscar_accesos();
}

google.maps.event.addDomListener(window, 'load', initMap);

/*
function dondeEstoy()
{
  // Try HTML5 geolocation
  if(navigator.geolocation)
  {
      navigator.geolocation.getCurrentPosition(function(position) {
        myLatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        my_marker = new google.maps.Marker({
          map: map,
          position: myLatlng,
          icon: "<?=base_url('images/my_marker.png')?>",
          title: "Usted esta aquí"
        });
        map.setCenter(myLatlng);
        buscar_vinotecas();
      }, function() {
        my_marker = new google.maps.Marker({
            map: map,
            position: myLatlng,
            icon: "<?=base_url('images/my_marker.png')?>",
            title: "Usted esta aquí"
      });
      map.setCenter(myLatlng);
      alert("Su navegador no nos permite encontrar su ubicacion.");
      buscar_vinotecas();
      });
  }
  else
  {
    my_marker = new google.maps.Marker({
          map: map,
          position: myLatlng,
          icon: "<?=base_url('images/my_marker.png')?>",
          title: "Usted esta aquí"
    });
    map.setCenter(myLatlng);
    alert("Su navegador no nos permite encontrar su ubicacion.");
    buscar_vinotecas();
  }
}
*/
function buscar_accesos()
{
  $('#loading').show();

  $.ajax({
     type: 'POST',
     dataType: "json",
     cache: false,
     processData: false, // Don't process the files
     //data: jQuery.param({lat: myLatlng.lat(), lng: myLatlng.lng()}),
     url: SITE_URL+"pages/mundo_ajax",
     success: function(data){
        if(data.error == false)
        {
          markers = [];

          $.each( data.accesos, function( i, acceso ) {
            marker = new google.maps.Marker( {
                icon: "<?=base_url('assets/images/marker3.png')?>",
                position: new google.maps.LatLng(acceso.acc_lat, acceso.acc_lng)
            });
            marker.addListener('click', function() {
              //location.href = SITE_URL;
			  mostrar_login();
            });
            markers.push(marker);
            /*
            google.maps.event.addListener(markers[i], 'click', function() {
                infowindow.setContent("<span style='color:#000;'>"+acceso.vinot_nombre+"<br>"+acceso.vinot_direccion+"<br>"+acceso.vinot_telefono+"</span>");
                infowindow.open(map, this);
            });
            */
          });

          $.each( data.productos, function( i, acceso ) {
            marker = new google.maps.Marker( {
                icon: "<?=base_url('assets/images/marker2.png')?>",
                position: new google.maps.LatLng(acceso.lat, acceso.lng)
            });
            marker.addListener('click', function() {
              location.href = SITE_URL;
            });
            markers.push(marker);
          });
          //mostrar_todos_los_markers();

          var markerCluster = new MarkerClusterer(map, markers, {imagePath: '<?=base_url("assets/images/m")?>'});
        }
        else
        {
          alert(data.data);
        }
        $('#loading').hide();
     },
     error: function(x, status, error){
      alert("An error occurred: " + status + " nError: " + error);
      $('#loading').hide();
     }
  });
}

function mostrar_todos_los_markers()
  {
    var bounds = new google.maps.LatLngBounds();

    for(i=0;i<markers.length;i++) 
    {
     bounds.extend(markers[i].getPosition());
    }
    if(my_marker)
    {
      bounds.extend(my_marker.getPosition());
    }
    map.fitBounds(bounds);
  }

if($('.percentage').length)
  {
    $('.percentage').easyPieChart({
      animate: 5000,
      onStep: function(value) {
      this.$el.find('span').text(~~value);
      }
    });
  }
  
  function mostrar_login()
{
	$('#modal_registro').modal('show');
}

$(document).ready(function () {
		  var loginBtn = $('.bt-login'),
		  registroBtn = $('.bt-registro'),
		  olvideBtn = $('.bt-olvide');

		  registroBtn.click(function(e){
			  e.preventDefault();
				$('#modal_registro').modal('show');
				$('#modal_login').modal('hide');
				$('#modal_olvide').modal('hide');
				$("#result_login" ).remove();
				$('#modal_registro .modal-content .modal-body').before('<div id="result_login"></div>')
			});
			olvideBtn.click(function(){
				$('#modal_registro').modal('hide');
				$('#modal_login').modal('hide');
				$('#modal_olvide').modal('show');
				$( "#result_login" ).remove();
				$('#modal_olvide .modal-content .modal-body').before('<div id="result_login"></div>')
			});
		loginBtn.click(function(){
				$('#modal_registro').modal('hide');
				$('#modal_login').modal('show');
				$('#modal_olvide').modal('hide');
				$("#result_login" ).remove();
				$('#modal_login .modal-content .modal-body').before('<div id="result_login"></div>')
		});

  //$('div.setup-panel div a.btn-primary').trigger('click');
	});


  
</script>

</body>
</html>