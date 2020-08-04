<script type="text/javascript">
$('#area_login').on("submit", "#form_login", function(e){
  e.preventDefault();
  $('#result_login').html("<br>");
  $("#btn_login").button("loading");
    $.ajax({
         type: 'POST',
          data: $(e.target).serialize(),
          //cache: false,
          dataType: 'json',
          //processData: false, // Don't process the files
          //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
         url: SITE_URL + "login/login_ajax",
         success: function(data){
            if(data.error == false)
            {
              location.href = SITE_URL + "resultados";
            }
            else
            {
              $('#result_login').html(data.data);
              $("#btn_login").button("reset");
            }
         },
         error: function(x, status, error){
            $('#result_login').html("An error occurred: " + status + " nError: " + error);
            $("#btn_login").button("reset");
         }
    });
});

$('#area_registro').on("submit", "#form_registro", function(e){
  e.preventDefault();
  $('#result_login').html("<br>");
  $("#btn_registro").button("loading");
    $.ajax({
         type: 'POST',
          data: $(e.target).serialize(),
          //cache: false,
          dataType: 'json',
          //processData: false, // Don't process the files
          //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
         url: SITE_URL + "Login/registro_ajax",
         success: function(data){
            if(data.error == false)
            {
              $('#result_login').html(data.data);
              ga('send', 'event', 'registro', 'click', 'click', 1);
            }
            else
            {
              $('#result_login').html(data.data);
            }
            $("#btn_registro").button("reset");
         },
         error: function(x, status, error){
            $('#result_login').html("An error occurred: " + status + " nError: " + error);
            $("#btn_registro").button("reset");
         }
    });
});

$('#area_olvide').on("submit", "#form_olvide", function(e){
  e.preventDefault();
  $('#result_login').html("<br>");
  $("#btn_olvide").button("loading");
    $.ajax({
         type: 'POST',
          data: $(e.target).serialize(),
          //cache: false,
          dataType: 'json',
          //processData: false, // Don't process the files
          //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
         url: SITE_URL + "Login/olvide_ajax",
         success: function(data){
            if(data.error == false)
            {
              $('#result_login').html(data.data);
            }
            else
            {
              $('#result_login').html(data.data);
            }
            $("#btn_olvide").button("reset");
         },
         error: function(x, status, error){
            $('#result_login').html("An error occurred: " + status + " nError: " + error);
            $("#btn_olvide").button("reset");
         }
    });
});

function validar_google()
{
  /*
  if($('#pais_registro').val() != "" && $('#idioma_registro').val() != "")
  {
    location.href = SITE_URL+"/login_google";
  }
  else
  {
    $('#result_login').html("An error occurred: " + status + " nError: " + error);
  }
  */
  $('#result_login').html("<br>");
  $("#btn_registro_google").button("loading");
    $.ajax({
         type: 'POST',
          data: jQuery.param({pais:$('#pais_registro').val(), idioma:$('#idioma_registro').val()}),
          //cache: false,
          dataType: 'json',
          //processData: false, // Don't process the files
          //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
         url: SITE_URL + "Login_google/validar_ajax",
         success: function(data){
            if(data.error == false)
            {
              location.href = SITE_URL+"/login_google";
              //ga('send', 'event', 'registro', 'click', 'click', 1);
            }
            else
            {
              $('#result_login').html(data.data);
            }
            $("#btn_registro_google").button("reset");
         },
         error: function(x, status, error){
            $('#result_login').html("An error occurred: " + status + " nError: " + error);
            $("#btn_registro_google").button("reset");
         }
    });
}

function ver_registro()
{
	$("#area_login").hide();
	$("#area_olvide").hide();
	$("#area_registro").show();
	$('#result_login').html("<br>");
}

function ver_olvide()
{
	$("#area_login").hide();
	$("#area_registro").hide();
	$("#area_olvide").show();
	$('#result_login').html("<br>");
}

function ver_login()
{
	$("#area_registro").hide();
	$("#area_olvide").hide();
	$("#area_login").show();
	$('#result_login').html("<br>");
}
</script>