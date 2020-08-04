//var base_url = "http://localhost:8888/Mad/";
var myVideo = document.getElementById("video2");
var curVideo = 0;
var idleTime = 0;
var idleInterval = null;

  $(document).ready(function () {
      //Increment the idle time counter every minute.
      idleInterval = setInterval(timerIncrement, 1000); // 1 segundo

      //Zero the idle timer on mouse movement.
      $(this).mousemove(function (e) {
          eventoClick();
      });
      $(this).keypress(function (e) {
          eventoClick();
      });
      $(this).on({ 'mousedown' : eventoClick });
  });

  function timerIncrement()
  {
    idleTime = idleTime + 1;
    if(idleTime == 15)
    {
      if(myVideo.paused)
      {
        if(videos && videos[curVideo].gim_vid_ruta)
        {
          myVideo.src = base_url+"assets/img/gimnasios/videos/"+videos[curVideo].gim_vid_ruta;
          //myVideo.src = cordova.file.dataDirectory+videos[curVideo].gim_vid_ruta;
          myVideo.play();
          $('#video2').fadeIn("slow");
          $('#sumate').fadeIn("fast");
        }
      }
    }
  }

  function eventoClick()
  {
    idleTime = 0;
    if(!myVideo.paused)
    {
      estructura_actividades();
      $('#sumate').fadeOut("fast");
      $('#video2').fadeOut("slow");
      myVideo.pause();
    }
  }

  myVideo.onended = function(){
    curVideo++;
    if(curVideo >= videos.length)
    { 
      curVideo = 0;
    }
    myVideo.src = base_url+"assets/img/gimnasios/videos/"+videos[curVideo].gim_vid_ruta;
    //myVideo.src = cordova.file.dataDirectory+videos[curVideo].gim_vid_ruta;
    myVideo.play();
  }
