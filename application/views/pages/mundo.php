<!DOCTYPE html>
<html lang="en">

<?php
$this->load->view('templates/head');
?>

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

<?php
$this->load->view('templates/menu_footer');
$this->load->view('templates/footer');
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
              location.href = SITE_URL;
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
</script>

</body>
</html>