//var base_url = "http://localhost:8888/Mad/";
var touchmoved;

  function estructura_actividades()
  {
    var htmlData = '<h1>CLASES Y HORARIOS</h1>';

    htmlData += '<div id="area_categorias"></div>';

    htmlData += '<div id="area_flecha_izquierda" onmousedown="izquierda()"><!--<i class="fa fa-chevron-left fa-5x" style="color:#000;"></i>--> <img src="'+base_url+'assets/img/gimnasios/arrows-izquierda.png"></div>';
    htmlData += '<div id="area_actividades"></div>';
    htmlData += '<div id="area_flecha_derecha" onmousedown="derecha()"><!--<i class="fa fa-chevron-right fa-5x" style="color:#000;"></i>--><img src="'+base_url+'assets/img/gimnasios/arrows-derecha.png"></div>';

    htmlData += '<div id="area_calendario"></div>';

    htmlData += '<div id="area_popup" style="display:none;">';
      htmlData += '<img src="" alt="clase" width="200px">';
      htmlData += '<div class="titulo"></div>';
      htmlData += '<div class="subtitulo"></div>';
      htmlData += '<hr>';
      htmlData += '<div class="salon"></div>';
      htmlData += '<p></p>';
      htmlData += '<i id="btn_cerrar_popup" class="fas fa-times-circle fa-3x"></i>';
    htmlData += '</div>';

    htmlData += '<div id="area_clase" style="display:none;">';
      htmlData += '<h4></h4>';
      htmlData += '<div class="gris">';
        htmlData += '<img src="" alt="clase" width="400px">';
        htmlData += '<div class="derecha">';
          htmlData += '<div class="titulo"></div>';
          htmlData += '<p></p>';
          htmlData += '<div class="salon"></div>';
        htmlData += '</div>';
        htmlData += '<div style="clear:both;"></div>';
      htmlData += '</div>';
    htmlData += '</div>';

    $('section').html(htmlData);

    $('#area_flecha_izquierda').on('touchend', function(e){
        e.preventDefault();
    }).on('touchmove', function(e){
        e.preventDefault();
    }).on('touchstart', function(e){
        //e.preventDefault();
        izquierda();
    });

    $('#area_flecha_derecha').on('touchend', function(e){
        e.preventDefault();
    }).on('touchmove', function(e){
        e.preventDefault();
    }).on('touchstart', function(e){
        //e.preventDefault();
        derecha();
    });

    $('#btn_cerrar_popup').on('touchend', function(e){
        e.preventDefault();
    }).on('touchmove', function(e){
        e.preventDefault();
    }).on('touchstart', function(e){
        //e.preventDefault();
        cerrar_popup();
    });

    $('footer').show();
    $('#sumate').show();

    cargar_categorias();
    cargar_actividades(0);
    cargar_ahora();
  }

  function cargar_categorias()
  {
    $('#area_categorias').html("cargando...");

    var htmlData = "";
    var clase = "active";
    htmlData += '<button class="btn '+clase+'" id="btn_cat_0" onmousedown="cargar_actividades(0)">Todos</button>';
    $('#area_categorias').html(htmlData);
     
    $('#btn_cat_0').on('touchend', function(e){
        e.preventDefault();
    }).on('touchmove', function(e){
        e.preventDefault();
    }).on('touchstart', function(){
        cargar_actividades(0);
    });

    $.each( categorias, function( i, categoria ) {
      htmlData = "";
      clase = "";
      if(categoria.gim_act_cat_id==0)
      {
        clase = "active";
      }
      htmlData += '<button class="btn '+clase+'" id="btn_cat_'+categoria.gim_act_cat_id+'" onmousedown="cargar_actividades('+categoria.gim_act_cat_id+')">'+categoria.gim_act_cat_nombre+'</button>';
      $('#area_categorias').append(htmlData);

      $('#btn_cat_'+categoria.gim_act_cat_id).on('touchend', function(e){
          e.preventDefault();
      }).on('touchmove', function(e){
          e.preventDefault();
      }).on('touchstart', function(){
          cargar_actividades(categoria.gim_act_cat_id);
      });
    });
  }


  function cargar_actividades(id)
  {
    $('#area_actividades').html("cargando...");

    $('#btn_cat_0').removeClass('active');
    $.each( categorias, function( i, categoria ) {
      $('#btn_cat_'+categoria.gim_act_cat_id).removeClass('active');
    });
    $('#btn_cat_'+id).addClass('active');

    var cantidad = 0;
    $.each( actividades, function( i, actividad ) {
      if(id==0 || id==actividad.gim_act_cat_id)
      {
        cantidad++;
      }
    });

    var htmlData = "";
    htmlData += "<div id='slider_actividades'>";
    htmlData += '<ul style="width:'+(cantidad*195)+'px">';

    $.each( actividades, function( i, actividad ) {
      if(id==0 || id==actividad.gim_act_cat_id)
      {
        htmlData += '<li id="li_actividad_'+actividad.gim_act_id+'" data-actividad="'+actividad.gim_act_id+'">'+actividad.gim_act_nombre+'</li>';
      }
    });

    htmlData += '</ul>';
    htmlData += '</div>';

    $('#area_actividades').html(htmlData);

    if($('#slider_actividades').hasScrollBar())
    {
      $('#area_flecha_derecha').show();
      $('#area_flecha_izquierda').show();
    }
    else
    {
      $('#area_flecha_derecha').hide();
      $('#area_flecha_izquierda').hide();
    }

    $('#slider_actividades li').on('mouseup', function(e){
        //var distance = touchposX_ini - touchposX;

        //if (distance < 20 && distance > -20){
            var gim_act_id = $(this).data('actividad');
            cargar_horarios(0, gim_act_id);
        //}
    }).on('mousemove', function(e){
      //e.preventDefault();
        touchmoved = true;
        //touchposX = e.originalEvent.touches[0].pageX;
        //touchposY = e.originalEvent.touches[0].pageY;
        //alert(xPos);
        //$('#slider_actividades').scrollLeft($('#slider_actividades').scrollLeft() + xPos);
    }).on('mousedown', function(e){
        touchmoved = false;
        //touchposX_ini = e.originalEvent.touches[0].pageX;
        //touchposY_ini = e.originalEvent.touches[0].pageY;
        //touchposX = e.originalEvent.touches[0].pageX;
        //touchposY = e.originalEvent.touches[0].pageY;
    });

    cargar_horarios(id, 0);
  }


  function cargar_ahora()
  {
    $('#area_ahora').html("cargando...");

    var fecha = new Date();
    var htmlData = "";
    htmlData += '<tr>';

    var cant = 0;

    if(clases.length > 0)
    {
        $.each( clases, function( k, clase ) {
          var fecha_ini_aux = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate(), clase.gim_hor_ini.split(':')[0], clase.gim_hor_ini.split(':')[1], 0, 0);
          var fecha_fin_aux = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate(), clase.gim_hor_fin.split(':')[0], clase.gim_hor_fin.split(':')[1], 0, 0);

          if(fecha.getDay() == clase.gim_hor_dia && fecha.getTime() >= fecha_ini_aux.getTime() && fecha.getTime() < fecha_fin_aux.getTime())
          {
            if(cant==2)
            {
              htmlData += '<tr>';
                htmlData += '<td>';
                  htmlData += '<div class="gradient" style="width:100%; height:2px;"></div>';
                htmlData += '</td>';
                htmlData += '<td width="60px"></td>';
                htmlData += '<td>';
                  htmlData += '<div class="gradient" style="width:100%; height:2px;"></div>';
                htmlData += '</td>';
              htmlData += '</tr>';
            }

            if(cant<4)
            {
              htmlData += '<td>';
                htmlData += '<div class="title">'+clase.gim_act_nombre+'</div>';
                htmlData += '<i class="fa fa-clock fa-md"></i> '+clase.gim_hor_ini+' hs <i class="fa fa-map-marker-alt fa-md"></i> Salón '+clase.gim_salon_nombre;
              htmlData += '</td>';
            }

            if(cant==0 || cant==2)
            {
              htmlData += '<td width="60px"></td>';
            }

            cant++;
            if(cant>0)
            {
              $('#titulo_ahora').html("<span>AHORA EN "+gimnasio.gim_nombre+"</span>");
            }
          }
        });
    }

    htmlData += '</tr>';

    $('#area_ahora').html(htmlData);

    setTimeout(function(){ cargar_ahora(); /*check_cambios();*/ }, 60000);
  }


  function cargar_horarios(cat_id, act_id)
  {
    $('#area_calendario').html("cargando...");

    $('#slider_actividades li').removeClass("active");
    $('#li_actividad_'+act_id).addClass("active");

    var fecha = new Date();
    var clase = "";
    var htmlData = "";
    var move_to_hora = "0000";

    htmlData += '<div id="area_flecha_arriba" onmousedown="arriba();"><!--<i class="fa fa-chevron-up fa-4x" style="color:#000;"></i>--><img src="'+base_url+'assets/img/gimnasios/arrows-arriba.png"></div>';

    $('#area_calendario').height(730);
    var altura = 570;
    if(act_id != 0)
    {
      $('#area_calendario').height(550);
      altura = 385;
    }

    if(cant_modulos <= 1)
    {
      $('#area_calendario').height(1030);
      altura = 790;
      if(act_id != 0)
      {
        $('#area_calendario').height(850);
        altura = 605;
      }
      $("#area_flecha_derecha").css({top: 475});
      $("#area_flecha_izquierda").css({top: 475});
    }

    htmlData += '<table class="calendario" spacing="0">';
    htmlData += '<thead>';
    htmlData += '<tr>';
      htmlData += '<th class="th hora" ></th>';
      $.each( dias, function( j, dia ) {
        clase = "th";
        if(fecha.getDay() == j)
        {
          clase += " hoy";
        }
        if(j > 0)
        {
          htmlData += '<th class="'+clase+'" >'+dia+'</th>';
        }
      });
    htmlData += '</tr>';
    htmlData += '</thead>';
    htmlData += '<tbody id="table_scroll" style="height:'+altura+'px" background-color:#CCC>';
    $.each( horarios, function( i, hora ) {

      //Verifico si no hay eventos en el horario, no lo muestro
      var hay_evento = false;
      if(dias)
      {
        $.each( dias, function( j, dia ) {
          if(j > 0)
          {
            if(clases)
            {
              $.each( clases, function( k, clase ) {
                if(clase.gim_hor_dia == j)
                {
                  if(hora.gim_hor_ini == clase.gim_hor_ini)
                  {
                    if(clase.gim_act_cat_id == cat_id || cat_id == 0)
                    {
                      if(clase.gim_act_id == act_id || act_id == 0)
                      {
                        hay_evento = true;
                      }
                    }
                  }
                }
              });
            }
          }
        });
      }
      ///////////////////

      if(hay_evento)
      {
        var fecha_aux = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate(), hora.gim_hor_ini.split(':')[0], hora.gim_hor_ini.split(':')[1], 0, 0);
        if(fecha_aux.getTime() < fecha.getTime())
        {
            move_to_hora = hora.gim_hor_ini.substr(0, 5).replace(":","");
            //alert(move_to_hora);
        }

        htmlData += "<tr id='"+hora.gim_hor_ini.substr(0, 5).replace(":","")+"'>";
        htmlData += "<td class='td hora' >"+hora.gim_hor_ini.substr(0, 5)+"</td>";
        if(dias)
        {
          $.each( dias, function( j, dia ) {
            if(j > 0)
            {
              htmlData += "<td id='"+hora.gim_hor_ini.substr(0, 5).replace(":","")+"_"+j+"' >";
              // Aca las clases
              htmlData += "</td>";
            }
          });
        }
        htmlData += "</tr>";
      }
      
    });
    htmlData += '</tbody>';
    htmlData += '</table>';

    htmlData += '<div id="area_flecha_abajo" onmousedown="abajo();"><!--<i class="fa fa-chevron-down fa-4x" style="color:#000;"></i>--><img src="'+base_url+'assets/img/gimnasios/arrows-abajo.png"></div>';

    $('#area_calendario').html(htmlData);

    $('#area_flecha_arriba').on('touchend', function(e){
        e.preventDefault();
    }).on('touchmove', function(e){
        e.preventDefault();
    }).on('touchstart', function(e){
        //e.preventDefault();
        arriba();
    });

    $('#area_flecha_abajo').on('touchend', function(e){
        e.preventDefault();
    }).on('touchmove', function(e){
        e.preventDefault();
    }).on('touchstart', function(e){
        //e.preventDefault();
        abajo();
    });

    if(clases)
    {
      $.each( clases, function( k, clase ) {
        htmlData = "";
        if(clase.gim_act_cat_id == cat_id || cat_id == 0)
        {
          if(clase.gim_act_id == act_id || act_id == 0)
          {
            if(clase.gim_act_id == act_id)
            {
              $('h3').html("HORARIOS "+clase.gim_act_nombre);
            }
            else if(act_id==0)
            {
              $('h3').html("CLASES Y HORARIOS");
            }

            if($('#'+clase.gim_hor_ini.substr(0, 5).replace(":","")+"_"+clase.gim_hor_dia).html() != "")
            {
              htmlData += "<hr>";
            }

            var clase_aux = "evento";
            if(fecha.getDay() == clase.gim_hor_dia)
            {
              clase_aux += " hoy";
            }

            htmlData += "<div id='"+clase.gim_hor_ini.substr(0, 5).replace(":","")+"_"+clase.gim_hor_dia+"_"+clase.gim_act_id+"' class='td "+clase_aux+"'>";
            htmlData += "<span>"+clase.gim_hor_ini.substr(0, 5)+" hs - "+clase.gim_hor_fin.substr(0, 5)+" hs</span><br>";
            htmlData += "<strong><div class='margen_clase'>"+clase.gim_act_nombre+"</div></strong><br>";
            htmlData += "Prof. "+clase.usr_apellido+" "+clase.usr_nombre+"<br>";
            htmlData += "Salón "+clase.gim_salon_nombre+"<br>";
            htmlData += "</div>";

            $('#'+clase.gim_hor_ini.substr(0, 5).replace(":","")+"_"+clase.gim_hor_dia).append(htmlData);

            $('#'+clase.gim_hor_ini.substr(0, 5).replace(":","")+"_"+clase.gim_hor_dia+"_"+clase.gim_act_id).on('touchend', function(e){
              if(touchmoved != true)
              {
                abrir_popup(clase.gim_act_id, clase.gim_hor_dia, touchposX, touchposY);
              }
            }).on('touchmove', function(e){
                touchmoved = true;
            }).on('touchstart', function(e){
                touchmoved = false;
                touchposX = e.originalEvent.touches[0].pageX;
                touchposY = e.originalEvent.touches[0].pageY;
            });
          }
        }
      });
    }

    if($('#table_scroll').hasScrollBar())
    {
      $('#area_flecha_arriba').show();
      $('#area_flecha_abajo').show();
    }
    else
    {
      $('#area_flecha_arriba').hide();
      $('#area_flecha_abajo').hide();
    }


    if(act_id > 0)
    {
      $.each( actividades, function( i, actividad ) {
        if(act_id==actividad.gim_act_id)
        {
          $.each( categorias, function( j, categoria ) {
            if(categoria.gim_act_cat_id == actividad.gim_act_cat_id)
            {
              $('#area_clase h4').html(categoria.gim_act_cat_nombre);
            }
          });
          $('#area_clase .titulo').html(actividad.gim_act_nombre);
          $('#area_clase p').html(actividad.gim_act_descripcion);

          var extension = actividad.gim_act_imagen.split('.').pop();
          $('#area_clase .gris img').remove();
          $('#area_clase .gris video').remove();
          if(actividad.gim_act_imagen && actividad.gim_act_imagen != "")
          {
            var htmlImg = "";
            if(extension == "mp4" || extension == "avi" || extension == "mov" || extension == "wmv")
            {
              htmlImg += "<video autoplay>";
                htmlImg += "<source src='"+base_url+"assets/img/gimnasios/actividades/"+actividad.gim_act_imagen+"' type='video/mp4'>";
              htmlImg += "</video>";
            }
            else
            {
              //$("#area_clase img").attr("src", base_url+"assets/img/gimnasios/actividades/"+actividad.gim_act_imagen);
              htmlImg += "<img src='"+base_url+"assets/img/gimnasios/actividades/"+actividad.gim_act_imagen+"' alt='clase' width='400px'>";
            }
            $("#area_clase .gris").prepend(htmlImg);
          }
        }
      });

      $.each( clases, function( k, clase ) {
        if(clase.gim_act_id == act_id)
        {
          //alert(JSON.stringify(clase));
          $('#area_clase .salon').html("Salón "+clase.gim_salon_nombre);
        }
      });

      $('#area_clase').fadeIn("slow");
      $('footer').hide();
    }
    else
    {
      $('#area_clase').fadeOut("slow");
      $('footer').show();
    }

    if($('#'+move_to_hora).length)
    {
      $('#table_scroll').animate({
        scrollTop: $('#'+move_to_hora).offset().top-$('.calendario').offset().top-40},
      'slow');
    }

  }

  function abrir_popup(act_id, dia, x, y)
  {
    $('#area_popup').css( 'top', y+10 );
    $('#area_popup').css( 'left', x-($('#area_popup').width()/2) );
    if(dia < 2)
    {
      $('#area_popup').css( 'left', x );
    }
    if(dia > 3)
    {
      $('#area_popup').css( 'left', x-$('#area_popup').width() );
    }

    $.each( actividades, function( i, actividad ) {
      if(act_id==actividad.gim_act_id)
      {
        $.each( categorias, function( j, categoria ) {
          if(categoria.gim_act_cat_id == actividad.gim_act_cat_id)
          {
            $('#area_popup .titulo').html(categoria.gim_act_cat_nombre);
          }
        });
        $('#area_popup .subtitulo').html(actividad.gim_act_nombre);
        $('#area_popup p').html(actividad.gim_act_descripcion);
        //$("#area_popup img").attr("src", base_url+"assets/img/gimnasios/actividades/"+actividad.gim_act_imagen);
      }
    });

    $.each( clases, function( k, clase ) {
      if(clase.gim_act_id == act_id)
      {
        //alert(JSON.stringify(clase));
        $('#area_popup .salon').html("Salón "+clase.gim_salon_nombre);
      }
    });

    $('#area_popup').show();
  }
  function cerrar_popup()
  {
    $('#area_popup').hide();
  }

  function derecha()
  {
    $('#slider_actividades').animate({
      scrollLeft: "+=390px"
    }, "slow");
  }
  function izquierda()
  {
    $('#slider_actividades').animate({
      scrollLeft: "-=390px"
    }, "slow");
  }

  function arriba()
  {
    $('#table_scroll').animate({
      scrollTop: "-=204px"
    }, "slow");
  }
  function abajo()
  {
    $('#table_scroll').animate({
      scrollTop: "+=204px"
    }, "slow");
  }


///////////////
//  EVENTOS  //
///////////////

$('#area_flecha_izquierda').on('touchend', function(e){
    e.preventDefault();
}).on('touchmove', function(e){
    e.preventDefault();
}).on('touchstart', function(e){
    //e.preventDefault();
    izquierda();
});

$('#area_flecha_derecha').on('touchend', function(e){
    e.preventDefault();
}).on('touchmove', function(e){
    e.preventDefault();
}).on('touchstart', function(e){
    //e.preventDefault();
    derecha();
});

(function($) {
    $.fn.hasScrollBar = function() {
      if(this.get(0).scrollWidth > this.width())
      {
        return true;
      }
      if(this.get(0).scrollHeight > this.height())
      {
        return true;
      }
      return false;
    }
  })(jQuery);