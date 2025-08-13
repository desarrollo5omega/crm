var videos = [];
$(document).ready(function(){
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    $('.dropdown-toggle').dropdown();
    $(".carouselsection").carousel({
        quantity : 4,
        sizes : {
          '900' : 3,
          '500' : 1
        }
    });
    $(".banner-video-youtube").each(function(){
        console.log($(this).attr("data-video"));
        var datavideo = $(this).attr("data-video");
        var idvideo = $(this).attr("id");
        var playerDefaults = {autoplay: 0, autohide: 1, modestbranding: 0, rel: 0, showinfo: 0, controls: 0, disablekb: 1, enablejsapi: 0, iv_load_policy: 3};
        var video = {'videoId':datavideo, 'suggestedQuality': 'hd720'};
        videos[videos.length] = new YT.Player(idvideo,{ 'videoId':datavideo, playerVars: playerDefaults,events: {
          'onReady': onAutoPlay,
          'onStateChange': onFinish
        }});
    });
    function onAutoPlay(event){
        event.target.playVideo();
        event.target.mute();
    }
    function onFinish(event) {
        if(event.data === 0) {
            event.target.playVideo();
        }
    }


    $(".file-image").fileinput({
        maxFileSize: 10240,
        previewFileType: "image",
        allowedFileExtensions: ["jpg", "jpeg", "gif", "png"],
        browseClass: "btn  btn-verde",
        showUpload: false,
        showRemove: false,
        browseIcon: "<i class=\"fas fa-image\"></i> ",
        browseLabel: "Imagen",
        language:"es",
        dropZoneEnabled: false
    });

    $(".file-document").fileinput({
        maxFileSize: 10240,
        previewFileType: "image",
         browseLabel: "Examinar",
         browseClass: "btn  btn-cafe",
        allowedFileExtensions: ["pdf","jpg", "jpeg", "gif", "png"],
        showUpload: false,
        showRemove: false,
        browseIcon: "<i class=\"fas fa-folder-open\"></i> ",
        language:"es",
        dropZoneEnabled: false
    });

    $(".file-robot").fileinput({
        maxFileSize: 10240,
        previewFileType: "image",
        allowedFileExtensions: ["txt",".txt"],
        browseClass: "btn btn-success btn-file-robot",
        showUpload: false,
        showRemove: false,
        browseLabel: "Robot",
        browseIcon: "<i class=\"fas fa-robot\"></i> ",
        language:"es",
        dropZoneEnabled: false,
        showPreview: false
    });

    $(".file-sitemap").fileinput({
        maxFileSize: 10240,
        previewFileType: "image",
        allowedFileExtensions: ["xml",".xml"],
        browseClass: "btn btn-success btn-file-sitemap",
        showUpload: false,
        showRemove: false,
        browseLabel: "SiteMap",
        browseIcon: "<i class=\"fas fa-sitemap\"></i> ",
        language:"es",
        dropZoneEnabled: false,
        showPreview: false
    });

    if($("#linea") && $("#id1").val()!=""){
        //seleccionar_linea();
        //$("#linea").change();
    }
    if($("#recoge")){
       //recoger();
    }


      $(".selectpagination").change(function () {
        var route = $("#page-route").val();
        var pages = $(this).val();
        $.post(route, { 'pages': pages }, function () {
          location.reload();
        });
      });

});






