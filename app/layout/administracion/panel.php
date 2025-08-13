<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>
        <?= $this->_titlepage ?>
    </title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWYVxdF4VwIPfmB65X2kMt342GbUXApwQ&sensor=true">
    </script>
    <link rel="stylesheet" href="/components/bootstrap/dist/css/bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Arizonia' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css2?family=Euphoria+Script&family=Homemade+Apple&family=Miss+Fajardose&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.standalone.min.css">
    <link rel="stylesheet" href="/components/bootstrap-fileinput/css/fileinput.css">
    <link rel="stylesheet" href="/components/Font-Awesome/web-fonts-with-css/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="/components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="/components/select2-bootstrap-theme/dist/select2-bootstrap.min.css">
	<link rel="stylesheet" href="/components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/skins/administracion/css/global.css?v=1.01">
    <link rel="stylesheet" href="/skins/administracion/css/estiloseditor.css">
    <script type="text/javascript">
        var map;
        var longitude = 0;
        var latitude = 0;
        var icon = '/skins/administracion/images/ubicacion.png';
        var point = false;
        var zoom = 10;

        function setValuesMap(longitud, latitud, punto, zoomm, icono) {
            longitude = longitud;
            latitude = latitud;
            if (punto) {
                point = punto;
            }
            if (zoomm) {
                zoom = zoomm;
            }
            if (icono) {
                icon = icono
            }
        }

        function initializeMap() {
            var mapOptions = {
                zoom: parseInt(zoom),
                center: new google.maps.LatLng(longitude, longitude),
            };
            // Place a draggable marker on the map
            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            if (point == true) {
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(longitude, latitude),
                    map: map,
                    icon: icon
                });
            }
            map.setCenter(new google.maps.LatLng(longitude, latitude));
        }
    </script>

    <script src="/components/jquery/dist/jquery.min.js">
    </script>
    <script src="/scripts/popper.min.js">
    </script>
    <script src="/components/bootstrap/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js">
    </script>
    <script src="/components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js">
    </script>
    <script src="/components/bootstrap-validator/dist/validator.min.js">
    </script>
    <script src="/components/bootstrap-fileinput/js/fileinput.min.js">
    </script>
    <script src="/components/bootstrap-fileinput/js/locales/es.js">
    </script>
    <script src="/components/tinymce/tinymce.min.js">
    </script>
    <script src="/components/bootstrap-switch/dist/js/bootstrap-switch.min.js">
    </script>
    <script src="/components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js">
    
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="/skins/administracion/js/main.js?v=1.1">
    </script>
	<script type="text/javascript" src="/components/select2/dist/js/select2.min.js"></script>
</head>

<body>
    <header>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-4">
				 <?php if($_SESSION['ingreso_temporal']==""){?>
                    <button type="button" class="btn" onclick="$('#panel-botones').toggle();">MENU <i class="fas fa-bars"></i></button>
                    <img src="/corte/logowhy.png" class="logo-blanco d-none">
				 <?php }?>
                </div>
                <div class="col-8">
                    <?= $this->_data['panel_header']; ?>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
            <nav id="panel-botones" class="col-2">
                <?= $this->_data['panel_botones']; ?>
            </nav>
            <article id="contenido_panel" class="col-12">
                <section id="contenido_general">
                    <?= $this->_content ?>
                </section>
            </article>
        </div>
    </div>
    <footer class="panel-derechos col-md-12 d-none">&copy;2019 Todos los derechos reservados | info@why.com.co  | Diseñado por <a href="http://www.why.com.co" target="_blank">WHY CREATIVE SOLUTIONS</a>
    </footer>

</body>

</html>
