//var base_url = "http://localhost:8888/Mad/";

  function estructura_reservas()
  {
    var htmlData = '<h1>RESERVA DE CLASES</h1>';

    htmlData += '<div style="position:absolute; top:620px; left:65px; font-size:21px; color:#18141C; text-align:left;">';
      htmlData += '<img src="'+base_url+'assets/img/gimnasios/user.png" ><br>';
      htmlData += usr_apellido+"<br>"+usr_nombre;
    htmlData += '</div>';

    htmlData += '<div id="area_categorias" style="font-size:32px;">RESERVA TU LUGAR AHORA</div>';

    htmlData += '<div id="area_calendario">';

      htmlData += '<div id="area_flecha_arriba" onclick="arriba();"><i class="fa fa-chevron-up fa-4x" style="color:#000;"></i></div>';
      
      htmlData += '<div id="table_scroll" style="height:802px; background:none;">';
      htmlData += '</div>';

      htmlData += '<div id="area_flecha_abajo" onclick="abajo();"><i class="fa fa-chevron-down fa-4x" style="color:#000;"></i></div>';

    htmlData += '</div>';

    $('section').html(htmlData);

    $('footer').show();
    $('#sumate').show();

    cargar_reservas(0);
  }


  function cargar_reservas()
  {
    $('#table_scroll').html("cargando...");
    /*alert(gim_id);*/
    $.ajax({
       type: 'POST',
        data: jQuery.param({usr_id:usr_id}),
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
       url: base_url+"index.php/webservices/get_reservas/"+gim_id,
       success: function(data){
          if(data.error == false)
          {
            var htmlData = "";
            
            $.each( data.data, function( j, item ) {
                htmlData += '<div style="width:950px; height:140px; text-align:left; margin-bottom:20px; overflow:hidden;">';
                  htmlData += '<div class="color_fondo" style="width:170px; height:120px; float:left; padding:10px; color:#FFF; line-height:25px;">';
                    htmlData += '<div style="font-size:24px;;">'+item.gim_act_nombre+'</div>';
                    htmlData += '<hr style="width:30px; margin-left:0px; border:1px solid #FFF; margin-bottom:20px;">';
                    htmlData += '<div style="font-size:16px;"><i class="far fa-clock fa-lg" style="color:#FF4553;"></i> '+item.gim_hor_ini.substr(0,5)+' hs a '+item.gim_hor_fin.substr(0,5)+' hs</div>';
                    htmlData += '<div style="font-size:16px;"><i class="fas fa-map-marker-alt fa-lg" style="color:#FF4553;"></i> '+item.gim_salon_nombre+'</div>';
                  htmlData += '</div>';
                  htmlData += '<div style="width:500px; height:120px; float:left; padding:10px; background:#FFF; line-height:30px;">';
                    htmlData += '<div class="color_texto" style="font-size:17px;">RESERVA DISPONIBLE HASTA LAS '+item.gim_hor_ini.substr(0,5)+' HS</div>';
                    htmlData += '<div style="font-size:17px; color:#414042;">Lugares disponibles: <span class="color_texto" id="disponibles_'+item.gim_hor_id+'">'+(item.gim_hor_cupos-item.cant_reservas)+'</span>/'+item.gim_hor_cupos+'</div>';

                    if(usr_id)
                    {
                      var display1 = "";
                      var display2 = "display:none;";
                      if(item.usr_reserva)
                      {
                        display1 = "display:none;";
                        display2 = "";
                      }
                      htmlData += '<button class="color_fondo" style="font-size:17px; color:#FFF; border:0px; padding:5px 20px; '+display1+'" id="btn_reservar_'+item.gim_hor_id+'" onclick="reservar('+item.gim_hor_id+')">RESERVAR</button>';
                      htmlData += '<button class="color_fondo" style="font-size:17px; color:#FFF; border:0px; padding:5px 20px; '+display2+'" id="btn_cancelar_'+item.gim_hor_id+'" onclick="cancelar_reserva('+item.gim_hor_id+')">CANCELAR</button>';
                    }

                    var display = "display:none;";
                    if(item.usr_reserva)
                    {
                      display = "";
                    }
                    htmlData += '<div id="exito_reserva_'+item.gim_hor_id+'" style="font-size:13px; color:#414042; '+display+'"><i class="far fa-check-square" style="color:#FF021D;"></i> Tu reserva se cargó con éxito</div>';

                  htmlData += '</div>';
                  htmlData += '<div style="width:210px; height:140px; float:left; overflow:hidden;"><img src="'+base_url+"assets/img/gimnasios/actividades/"+item.gim_act_imagen+'" width="100%" height="100%"></div>';
                  htmlData += '<div class="color_fondo" style="width:10px; height:120px; float:left; padding:10px 0px;">&nbsp;</div>';
                htmlData += '</div>';
            });

            $('#table_scroll').html(htmlData);
          }
          else
          {
            var htmlData = "";
            htmlData += data.data;
            $('#table_scroll').html(htmlData);
          }

          if(data.error2 == false)
          {
            var htmlData = "";
            
            htmlData += '<div id="area_categorias2" style="font-size:32px; margin:30px 0px 20px;">PROXIMAS RESERVAS</div>';

            $.each( data.proximas, function( j, item ) {
                htmlData += '<div style="width:950px; height:140px; text-align:left; margin-bottom:20px; overflow:hidden; opacity:0.5;">';
                  htmlData += '<div class="color_fondo" style="width:170px; height:120px; float:left; padding:10px; color:#FFF; line-height:25px;">';
                    htmlData += '<div style="font-size:24px;;">'+item.gim_act_nombre+'</div>';
                    htmlData += '<hr style="width:30px; margin-left:0px; border:1px solid #FFF; margin-bottom:20px;">';
                    htmlData += '<div style="font-size:16px;"><i class="far fa-clock fa-lg" style="color:#FF4553;"></i> '+item.gim_hor_ini.substr(0,5)+' hs a '+item.gim_hor_fin.substr(0,5)+' hs</div>';
                    htmlData += '<div style="font-size:16px;"><i class="fas fa-map-marker-alt fa-lg" style="color:#FF4553;"></i> '+item.gim_salon_nombre+'</div>';
                  htmlData += '</div>';
                  htmlData += '<div style="width:500px; height:120px; float:left; padding:10px; background:#FFF; line-height:30px;">';
                    htmlData += '<div class="color_texto" style="font-size:17px;">RESERVA DISPONIBLE HASTA LAS '+item.gim_hor_ini.substr(0,5)+' HS</div>';
                    htmlData += '<div style="font-size:17px; color:#414042;">Lugares disponibles: <span class="color_texto">'+item.gim_hor_cupos+'</span>/'+item.gim_hor_cupos+'</div>';

                    if(usr_id)
                    {
                      htmlData += '<button class="color_fondo" style="font-size:17px; color:#FFF; border:0px; padding:5px 20px;" id="btn_reservar_'+item.gim_hor_id+'">RESERVAR</button>';
                    }

                  htmlData += '</div>';
                  htmlData += '<div style="width:210px; height:140px; float:left; overflow:hidden;"><img src="'+base_url+"assets/img/gimnasios/actividades/"+item.gim_act_imagen+'" width="100%" height="100%"></div>';
                  htmlData += '<div class="color_fondo" style="width:10px; height:120px; float:left; padding:10px 0px;">&nbsp;</div>';
                htmlData += '</div>';
            });

            $('#table_scroll').append(htmlData);
          }
       },
       error: function(x, status, error){
          var htmlData = "An error occurred: " + status + " nError: " + error;
          $('#table_scroll').html(htmlData);
       }
    });
  }


  function reservar(hor_id)
  {
    $('#btn_reservar_'+hor_id).html("Reservando...");

    $.ajax({
       type: 'POST',
        data: jQuery.param({usr_id:usr_id, hor_id:hor_id}),
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
       url: base_url+"index.php/webservices/set_reserva/"+gim_id,
       success: function(data){
          if(data.error == false)
          {
            $('#btn_cancelar_'+hor_id).html("CANCELAR");
            $('#btn_reservar_'+hor_id).hide();
            $('#btn_cancelar_'+hor_id).show();
            $('#exito_reserva_'+hor_id).show();

            var cant = $('#disponibles_'+hor_id).html();
            $('#disponibles_'+hor_id).html( parseInt(cant)-1 );
          }
          else
          {
            alert(data.data);
          }
       },
       error: function(x, status, error){
          var htmlData = "An error occurred: " + status + " nError: " + error;
          alert(htmlData);
       }
    });
  }

  function cancelar_reserva(hor_id)
  {
    $('#btn_cancelar_'+hor_id).html("Cancelando...");

    $.ajax({
       type: 'POST',
        data: jQuery.param({usr_id:usr_id, hor_id:hor_id}),
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        //contentType: false, // Set content type to false as jQuery will tell the server its a query string request
       url: base_url+"index.php/webservices/cancelar_reserva/"+gim_id,
       success: function(data){
          if(data.error == false)
          {
            $('#btn_reservar_'+hor_id).html("RESERVAR");
            $('#btn_reservar_'+hor_id).show();
            $('#btn_cancelar_'+hor_id).hide();
            $('#exito_reserva_'+hor_id).hide();

            var cant = $('#disponibles_'+hor_id).html();
            $('#disponibles_'+hor_id).html( parseInt(cant)+1 );
          }
          else
          {
            alert(data.data);
          }
       },
       error: function(x, status, error){
          var htmlData = "An error occurred: " + status + " nError: " + error;
          alert(htmlData);
       }
    });
  }