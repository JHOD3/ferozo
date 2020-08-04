<script type="text/javascript">
$.ajax({
   type: 'POST',
    //data: JSON.param({landing: ""}),
    cache: false,
    dataType: 'json',
    processData: false, // Don't process the files
    //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
   url: SITE_URL+"pages/acceso/<?if(isset($acceso))echo $acceso;?>"
});
</script>