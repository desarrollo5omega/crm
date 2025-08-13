<ul>
  <li class="d-none" <?php if($this->botonpanel == 1){ ?>class="activo" <?php } ?>><a href="/administracion/panel"><i
        class="fas fa-info-circle"></i> Información pagina</a></li>
  <li class="d-none" <?php if($this->botonpanel == 2){ ?>class="activo" <?php } ?>><a
      href="/administracion/publicidad"><i class="far fa-images"></i> Administrar Banner</a></li>
  <li class="d-none" <?php if($this->botonpanel == 3){ ?>class="activo" <?php } ?>>><a
      href="/administracion/contenidos"><i class="fas fa-file-invoice"></i> Administrar Contenidos</a></li>

  <?php if($_SESSION['kt_login_level']=="1" or $_SESSION['kt_login_level']=="3" or $_SESSION['kt_login_level']=="13"  or $_SESSION['kt_login_level']=="15"  or $_SESSION['kt_login_level']=="14"  or $_SESSION['kt_login_level']=="16"){ ?>
    <li <?php if($this->botonpanel == 5){ ?>class="activo" <?php } ?>><a href="/administracion/lineas"><i
          class="fas fa-file-invoice"></i> Líneas de crédito</a></li>
    <li <?php if($this->botonpanel == 7){ ?>class="activo" <?php } ?>><a href="/administracion/config/manage/?id=1"><i
          class="fas fa-file-invoice"></i> Configuración</a></li>
    <li <?php if($this->botonpanel == 8){ ?>class="activo" <?php } ?>><a
        href="/administracion/usuario/exportar/?excel=1"><i class="fas fa-file-invoice"></i> Exportar usuarios</a></li>

    <li <?php if($this->botonpanel == 9){ ?>class="activo" <?php } ?>>
      <a href="/administracion/importarasociados/">
        <i class="fas fa-file-invoice"></i>
        Importar asociados
      </a>
    </li>
    <li <?php if($this->botonpanel == 22){ ?>class="activo" <?php } ?>>
      <a href="/administracion/importarasociadosnacional/">
        <i class="fas fa-file-invoice"></i>
        Importar asociados nacional
      </a>
    </li>
    <!--<li <?php if($this->botonpanel == 20){ ?>class="activo"<?php } ?>><a href="/administracion/importarahorros/"><i class="fas fa-file-invoice"></i> Importar aportes y ahorros</a></li>
    <li <?php if($this->botonpanel == 21){ ?>class="activo"<?php } ?>><a href="/administracion/importarahorrosvol/"><i class="fas fa-file-invoice"></i> Importar ahorros voluntarios</a></li>
    <li <?php if($this->botonpanel == 10){ ?>class="activo"<?php } ?>><a href="/administracion/importarcupos/"><i class="fas fa-file-invoice"></i> Importar cartera</a></li>
    <li <?php if($this->botonpanel == 11){ ?>class="activo"<?php } ?>><a href="/administracion/importarestados/"><i class="fas fa-file-invoice"></i> Actualizar estados solicitudes</a></li> -->
    <li <?php if($this->botonpanel == 4){ ?>class="activo" <?php } ?>>
      <a href="/administracion/usuario">
        <i class="fas fa-users"></i>
        Usuarios
      </a>
    </li>
  <?php } ?>

  <?php if($_SESSION['kt_login_level']=="3" or $_SESSION['kt_login_level']=="1" or $_SESSION['kt_login_level']=="4" or $_SESSION['kt_login_level']=="8" or $_SESSION['kt_login_level']=="12" or $_SESSION['kt_login_level']=="9" or $_SESSION['kt_login_level']=="13" or $_SESSION['kt_login_level']=="14"  or $_SESSION['kt_login_level']=="15" or $_SESSION['kt_login_level']=="16" or $_SESSION['kt_login_level']=="17" or $_SESSION['kt_login_level']=="18"){ ?>

  <li <?php if($this->botonpanel == 6){ ?>class="activo" <?php } ?>>
    <a href="/administracion/solicitudes">
      <i class="fas fa-file-invoice"></i>
      Solicitudes
    </a>
  </li>

  <?php } ?>

  <?php if($_SESSION['kt_login_level']=="1" or $_SESSION['kt_login_level']=="3" or $_SESSION['kt_login_level']=="8" or $_SESSION['kt_login_level']=="12" or $_SESSION['kt_login_level']=="13"  or $_SESSION['kt_login_level']=="16"  or $_SESSION['kt_login_level']=="17" or $_SESSION['kt_login_level']=="18"){ ?>
  <!-- <li <?php if($this->botonpanel == 16){ ?>class="activo"<?php } ?>><a href="/administracion/actascomite"><i class="fas fa-file-invoice"></i> Actas</a></li> -->

  <?php if($_SESSION['kt_login_level']!="12"){ ?>
  <!-- <li <?php if($this->botonpanel == 12){ ?>class="activo"<?php } ?>><a href="/administracion/consultas/"><i class="fas fa-file-invoice"></i> Consultas</a></li> -->
  <li <?php if($this->botonpanel == 13){ ?>class="activo" <?php } ?>>
    <a href="/administracion/reportes/">
      <i class="fas fa-file-invoice"></i>
      Reportes
    </a>
  </li>
  <!-- <li <?php if($this->botonpanel == 23){ ?>class="activo" <?php } ?>>
    <a href="/administracion/reportesfonkoba/">
      <i class="fas fa-file-invoice"></i>
      Reportes
    </a>
  </li> -->
  <?php if($_SESSION['kt_login_level']!="17" && $_SESSION['kt_login_level']!="18"){ ?>
    <li <?php if($this->botonpanel == 14){ ?>class="activo" <?php } ?>><a href="/administracion/gestores/"><i
        class="fas fa-file-invoice"></i> Gestores comerciales</a></li>
    <li <?php if($this->botonpanel == 15){ ?>class="activo" <?php } ?>><a href="/administracion/bancos/"><i
        class="fas fa-file-invoice"></i> Bancos</a></li>
  <!-- <li <?php if($this->botonpanel == 15){ ?>class="activo"<?php } ?>><a href="/administracion/importarsarlaft/manage?id=1"><i class="fas fa-file-invoice"></i> Importar cédulas sarlaft</a></li> -->

  <?php } ?>
  <?php } ?>

  <?php } ?>
  <?php if($_SESSION['kt_login_level']=="1" or $_SESSION['kt_login_level']=="3" or $_SESSION['kt_login_level']=="10" or $_SESSION['kt_login_level']=="8" or $_SESSION['kt_login_level']=="16"){ ?>
  <!-- <li <?php if($this->botonpanel == 16){ ?>class="activo"<?php } ?>><a href="/administracion/listadosarlaft/"><i class="fas fa-file-invoice"></i> Listado Sarlaft</a></li> -->
  <?php } ?>

  <?php if($_SESSION['kt_login_level']=="1" or $_SESSION['kt_login_level']=="3" or $_SESSION['kt_login_level']=="10" or $_SESSION['kt_login_level']=="8" or $_SESSION['kt_login_level']=="16"){ ?>
    <li <?php if($this->botonpanel == 23){ ?>class="activo" <?php } ?> >
      <a href="/administracion/solicitudeseliminadas/">
        <i class="fas fa-trash"></i>
        Historial solicitudes eliminadas
      </a>
    </li>
  <?php } ?>
  <?php if($_SESSION['kt_login_level']=="1" or $_SESSION['kt_login_level']=="3" or $_SESSION['kt_login_level']=="10" or $_SESSION['kt_login_level']=="8" or $_SESSION['kt_login_level']=="16"){ ?>
    <li <?php if($this->botonpanel == 23){ ?>class="activo" <?php } ?> >
      <a href="/administracion/activarlineas/">
        <i class="fa fa-check-circle" aria-hidden="true"></i>
        Activar lineas
      </a>
    </li>
  <?php } ?>

</ul>


<?php
function formato_pesos($x){
	$res = number_format($x,0,',','.');
	return $res;
}

function sin_p($texto){
	$texto = str_replace("<p","<div",$texto);
	$texto = str_replace("p>","div>",$texto);
	return $texto;
}

function formatoNumero($n){
	return number_format($n,2,',','.');
}

function formatoNumero2($n){
	return number_format($n,0,',','.');
}

function formatoNumero3($n){
	$n=$n*1;
	return number_format($n,0,'.','.');
}

function formatoDMY($f){
	$f = substr($f,0,10);
	$aux = explode("-",$f);
	return $aux[2]."/".$aux[1]."/".$aux[0];
}

function estado_val($x){
	$res="";
	if($x==0 or $x==""){
		$res = "Pendiente";
	}
	if($x==1){
		$res = "Aprobada";
	}
	if($x==2){
		$res = "Rechazada";
	}
	if($x==3){
		$res = "Anulada";
	}
	return $res;
}

function con_ceros($x){
	$x = str_pad($x, 5, "0", STR_PAD_LEFT);
	return $x;
}


function UltimoDia($anho,$mes){
   if (((fmod($anho,4)==0) and (fmod($anho,100)!=0)) or (fmod($anho,400)==0)) {
       $dias_febrero = 29;
   } else {
       $dias_febrero = 28;
   }
   switch($mes) {
       case 1: return 31; break;
       case 2: return $dias_febrero; break;
       case 3: return 31; break;
       case 4: return 30; break;
       case 5: return 31; break;
       case 6: return 30; break;
       case 7: return 31; break;
       case 8: return 31; break;
       case 9: return 30; break;
       case 10: return 31; break;
       case 11: return 30; break;
       case 12: return 31; break;
   }
}

function calcular_edad($fecha){
    $cumpleanos = new DateTime("".$fecha);
    $hoy = new DateTime();
    $annos = $hoy->diff($cumpleanos);
    return $annos->y;
}
?>

<script type="text/javascript">
function menos(id) {
  var cantidad = document.getElementById('cantidad' + id).value;
  cantidad--;
  if (cantidad < 1) {
    cantidad = 1;
  }
  document.getElementById('cantidad' + id).value = cantidad;
  document.getElementById('enlace' + id).href += '&cantidad=' + cantidad;
}

function mas(id, dis) {
  var cantidad = document.getElementById('cantidad' + id).value;
  cantidad++;
  if (cantidad > 5) {
    cantidad = 5;
  }
  if (cantidad > dis) {
    cantidad = dis;
  }
  document.getElementById('cantidad' + id).value = cantidad;
  document.getElementById('enlace' + id).href += '&cantidad=' + cantidad;
}

function sumar_ingresos() {
  var ingreso_mensual = document.getElementById('ingreso_mensual').value;
  var otros_ingresos = document.getElementById('otros_ingresos').value;
  ingreso_mensual = sin_puntos(ingreso_mensual);
  otros_ingresos = sin_puntos(otros_ingresos);
  var total = Number(ingreso_mensual) + Number(otros_ingresos);
  document.getElementById('total_ingresos').value = total;
  puntitos(document.getElementById('total_ingresos'));
}

function sumar_egresos() {
  var canon_arrendamiento = document.getElementById('canon_arrendamiento').value;
  var otros_gastos = document.getElementById('otros_gastos').value;
  canon_arrendamiento = sin_puntos(canon_arrendamiento);
  otros_gastos = sin_puntos(otros_gastos);
  var total = Number(canon_arrendamiento) + Number(otros_gastos);
  document.getElementById('total_egresos').value = total;
  puntitos(document.getElementById('total_egresos'));
}

function sumar_patrimonio() {
  var activos = document.getElementById('activos').value;
  var pasivos = document.getElementById('pasivos').value;
  activos = sin_puntos(activos);
  pasivos = sin_puntos(pasivos);
  var total = Number(activos) - Number(pasivos);
  document.getElementById('patrimonio').value = total;
  puntitos(document.getElementById('patrimonio'));
}

<?php if($_GET['mod']!="detalle_solicitud"){ ?>

function seleccion_tipo_garantia() {
  var e = document.getElementById("tipo_garantia");
  var no = e.options[e.selectedIndex].value;
  if (no == 'DEUDOR SOLIDARIO') {
    $('#div_paso4').load('/page/sistema/codeudor/?id=<?php echo $_GET['id']; ?>');
  }
  if (no == 'FONDO MUTUAL') {
    $('#div_paso4').load('/page/sistema/fondomutual/?id=<?php echo $_GET['id']; ?>');
  }
  if (no == 'HIPOTECA') {
    $('#div_paso4').load('/page/sistema/blanco/');
  }
  if (no == 'PRENDA') {
    $('#div_paso4').load('/page/sistema/blanco/');
  }
  if (no == 'APORTES Y AHORROS') {
    $('#div_paso4').load('/page/sistema/blanco/');
    document.getElementById('Enviar').style.display = '';
  }
  if (no == 'AUTORIZACION BBVA') {
    $('#div_paso4').load('/page/sistema/blanco/');
    document.getElementById('Enviar').style.display = '';
  }
  if (no == 'PRIMA') {
    $('#div_paso4').load('/page/sistema/blanco/');
    document.getElementById('Enviar').style.display = '';
  }
  if (no == 'GARANTIA PERSONAL') {
    $('#div_paso4').load('/page/sistema/requisitospersonal/?id=<?php echo $_GET['id']; ?>');
    document.getElementById('Enviar').style.display = '';
  }
}
<?php } else {?>

function seleccion_tipo_garantia() {
  var e = document.getElementById("tipo_garantia");
  var no = e.options[e.selectedIndex].value;
  if (no == 'DEUDOR SOLIDARIO') {
    $('#div_paso4').load(
      '/page/paso2/?id=<?php echo $_GET['id']; ?>&paso=<?php echo $_GET['paso']; ?>&mod=<?php echo $_GET['mod']; ?>');
  }
  if (no == 'FONDO MUTUAL') {
    $('#div_paso4').load('../fondo_mutual.php?id=<?php echo $_GET['id']; ?>&mod=<?php echo $_GET['mod']; ?>');
  }
  if (no == 'HIPOTECA') {
    $('#div_paso4').load('../blank.php?id=<?php echo $_GET['id']; ?>');
  }
  if (no == 'PRENDA') {
    $('#div_paso4').load('../blank.php?id=<?php echo $_GET['id']; ?>');
  }
  if (no == 'APORTES Y AHORROS') {
    $('#div_paso4').load('../blank.php?id=<?php echo $_GET['id']; ?>');
    document.getElementById('Enviar').style.display = '';
  }
  if (no == 'AUTORIZACION BBVA') {
    $('#div_paso4').load('../blank.php?id=<?php echo $_GET['id']; ?>');
    document.getElementById('Enviar').style.display = '';
  }
  if (no == 'PRIMA') {
    $('#div_paso4').load('../blank.php?id=<?php echo $_GET['id']; ?>');
    document.getElementById('Enviar').style.display = '';
  }
  if (no == 'GARANTIA PERSONAL') {
    $('#div_paso4').load('../requisitos_personal.php?id=<?php echo $_GET['id']; ?>');
    document.getElementById('Enviar').style.display = '';
  }
}
<?php }?>


function validar(min1, max1) {
  var valor = document.getElementById('valor').value;
  valor = valor.replace(".", "");
  valor = valor.replace(".", "");
  valor = valor.replace(".", "");
  valor = valor.replace(".", "");
  valor = valor.replace(".", "");
  valor = valor.replace(".", "");
  valor = valor * 1;
  max1 = max1 * 1;
  min1 = min1 * 1;
  if (valor < min1) {
    document.getElementById('e_minimo').style.display = '';
    document.getElementById('resultado').style.display = 'none';
    return false;
  }
  if (valor > max1) {
    document.getElementById('e_max').style.display = '';
    document.getElementById('resultado').style.display = 'none';
    return false;
  }

}

function sin_puntos(valor) {
  valor = valor.replace(".", "");
  valor = valor.replace(".", "");
  valor = valor.replace(".", "");
  valor = valor.replace(".", "");
  valor = valor.replace(".", "");
  valor = valor.replace(".", "");
  return valor;
}

function limitarCuotas2() {

  var e = document.getElementById("cuotas_desembolso");
  var cuotas = e.options[e.selectedIndex].value;

  var frecuencia = $("#frecuencia").val();
  frecuencia = Number(frecuencia);

  console.log("frecuencia: " + frecuencia);

  var maximo = Number(cuotas) / frecuencia;
  if (maximo < 1) {
    maximo = 1;
  }
  //console.log("maximo: "+maximo);
  cont = 0;

  var r = Math.floor(cuotas / 12);
  maximo = maximo + r;
  // if(cuotas>=12){
  // 	maximo = maximo+1;
  // }
  // if(cuotas>=24){
  // 	maximo = maximo+2;
  // }
  // else if(maximo>1){
  // 	maximo = maximo+1;
  // }

  console.log("maximo2: " + maximo);

  var i = 1;
  var abonos = $("#abonos2").val();
  //$cuotaextra = str_replace('.','',$extra);
  var numerocuotasextra = abonos;

  //calcular valor presente cuotas
  let date = new Date()
  var anio = (new Date).getFullYear();
  let day = date.getDate()
  let month = date.getMonth() + 1
  if (month < 10) {
    var hoy = date.getFullYear() + "-0" + date.getMonth() + "-" + date.getDate();
  } else {
    hoy = date.getFullYear() + "-" + date.getMonth() + "-" + date.getDate();
  }
  //console.log(anio+'-06-30');
  //console.log(hoy);
  if (hoy <= anio + '-06-30') {
    //console.log("entro")
    var meses = '<?php echo (6-date('m')) ?>';
    //console.log(meses);
  } else {
    //console.log("entro2")
    meses = '<?php echo 0?>';
  }
  var presente = 0;
  var numerocuotasextra2 = [];
  for (var m = 1; m <= maximo; m++) {
    console.log(meses);
    meses = Number(meses * 1) + 6;
    if (meses == 6) {
      var ms = "Junio";
    } else if (meses == 12) {
      ms = "Diciembre";


    } else if (meses == 18) {
      ms = "Junio y Diciembre";

    }

    numerocuotasextra2[meses] = ms;
    //numerocuotasextra2[meses]=anio;
  }
  console.log(numerocuotasextra2);
  var seleccionado = '';

  var opciones = '';
  var a = 0
  for (i = 0; i <= maximo; i++) {
    console.log("pruebas " + a);

    seleccionado = '';
    if (i == abonos) {
      seleccionado = 'selected';
    }

    if (i >= 1) {
      a = Number(a * 1) + 6

      var aux = numerocuotasextra2[a];

    } else {
      aux = "0";
    }
    opciones += '<option value="' + i + '" ' + seleccionado + ' >' + aux + '</option>';
    if (a == 18) {
      //opciones += '<option value="'+(Number(i+1)*1)+'" '+seleccionado+' >Junio y Diciembre</option>';
      a = 0;
      //console.log("entro");
    }



  }
  $("#abonos2").html(opciones);
}



function limitarCuotas() {

  var e = document.getElementById("cuotas");
  var cuotas = e.options[e.selectedIndex].value;

  var frecuencia = $("#frecuencia").val();
  frecuencia = Number(frecuencia);
  console.log("frec" + cuotas);
  //console.log("frecuencia: "+frecuencia);

  var maximo = Number(cuotas) / frecuencia;
  if (maximo < 1) {
    maximo = 1;
  }
  //console.log("maximo: "+maximo);
  cont = 0;

  var r = Math.floor(cuotas / 12);
  maximo = maximo + r;
  // if(cuotas>=12){
  // 	maximo = maximo+1;
  // }
  // if(cuotas>=24){
  // 	maximo = maximo+2;
  // }
  // else if(maximo>1){
  // 	maximo = maximo+1;
  // }

  //console.log("maximo2: "+maximo);

  var i = 1;
  var abonos = $("#abonos").val();
  //$cuotaextra = str_replace('.','',$extra);
  var numerocuotasextra = abonos;

  //calcular valor presente cuotas
  let date = new Date()
  var anio = (new Date).getFullYear();
  let day = date.getDate()
  let month = date.getMonth() + 1
  if (month < 10) {
    var hoy = date.getFullYear() + "-0" + date.getMonth() + "-" + date.getDate();
  } else {
    hoy = date.getFullYear() + "-" + date.getMonth() + "-" + date.getDate();
  }
  //console.log(anio+'-06-30');
  //console.log(hoy);
  if (hoy <= anio + '-06-30') {
    //console.log("entro")
    var meses = '<?php echo (6-date('m')) ?>';
    //console.log(meses);
  } else {
    //console.log("entro2")
    meses = '<?php echo 0?>';
  }
  var presente = 0;
  var numerocuotasextra2 = [];
  for (var m = 1; m <= maximo; m++) {
    console.log(meses);
    meses = Number(meses * 1) + 6;
    if (meses == 6) {
      var ms = "Junio";
    } else if (meses == 12) {
      ms = "Diciembre";


    } else if (meses == 18) {
      ms = "Junio y Diciembre";

    }

    numerocuotasextra2[meses] = ms;
    //numerocuotasextra2[meses]=anio;
  }
  //console.log(numerocuotasextra2);
  var seleccionado = '';

  var opciones = '';
  var a = 0
  for (i = 0; i <= maximo; i++) {
    //console.log("pruebas "+a);

    seleccionado = '';
    if (i == abonos) {
      seleccionado = 'selected';
    }

    if (i >= 1) {
      a = Number(a * 1) + 6

      var aux = numerocuotasextra2[a];

    } else {
      aux = "0";
    }
    opciones += '<option value="' + i + '" ' + seleccionado + ' >' + aux + '</option>';
    if (a == 18) {
      //opciones += '<option value="'+(Number(i+1)*1)+'" '+seleccionado+' >Junio y Diciembre</option>';
      a = 0;
      //console.log("entro");
    }



  }
  $("#abonos").html(opciones);
}


<?php if($getlinea==10 or $getlinea==19 or $getlinea==25 or $getlinea==18 or $getlinea==24 or $getlinea==26){ ?>

function validar_extra() {
  var prestamo = document.getElementById('valor').value;
  prestamo = prestamo.split('.').join('');
  var extra = document.getElementById('extra').value;
  extra = extra.split('.').join('');

  var e = document.getElementById("abonos");
  var abonos = e.options[e.selectedIndex].value;

  //alert(prestamo+' - '+extra+' - '+abonos);
  console.log(prestamo + " " + (Math.round((prestamo / 2))) + " " + extra * abonos);
  if (Number(extra * abonos) > Number(Math.round(prestamo / 2))) {
    alert('El valor de las cuotas extraordinarias no puede superar el 50% del valor solicitado');
    document.getElementById('extra').value = document.getElementById('extra').value.slice(0, -1);
    puntitos(document.getElementById('extra'));
  }
}
<?php } else{ ?>

function validar_extra() {
  var prestamo = document.getElementById('monto_solicitado').value;
  prestamo = prestamo.split('.').join('');
  var extra = document.getElementById('extra').value;
  extra = extra.split('.').join('');

  var e = document.getElementById("abonos");
  var abonos = e.options[e.selectedIndex].value;

  //alert(prestamo+' - '+extra+' - '+abonos);
  console.log(prestamo + " " + (Math.round((prestamo / 2))) + " " + extra * abonos);
  if (Number(extra * abonos) > Number(Math.round(prestamo / 2))) {
    alert('El valor de las cuotas extraordinarias no puede superar el 50% del monto unificado');
    document.getElementById('extra').value = document.getElementById('extra').value.slice(0, -1);
    puntitos(document.getElementById('extra'));
  }
}
<?php }?>



function total_patrimonio() {
  var total = 0;
  total += sin_puntos(document.getElementById('VIVIENDA_v1').value) * 1;
  total += sin_puntos(document.getElementById('OTRAS_v1').value) * 1;
  total += sin_puntos(document.getElementById('VEHICULO_v1').value) * 1;
  total += sin_puntos(document.getElementById('OTROS_v1').value) * 1;
  total += sin_puntos(document.getElementById('CLASE_v1').value) * 1;
  document.getElementById('PATRIMONIO_v1').value = total;
  puntitos(document.getElementById('PATRIMONIO_v1'));

  total_patrimonial();
}

function total_patrimonio2() {
  var total = 0;
  total += sin_puntos(document.getElementById('HIPOTECA_v2').value) * 1;
  total += sin_puntos(document.getElementById('PRENDA_v2').value) * 1;
  document.getElementById('PATRIMONIO_v2').value = total;
  puntitos(document.getElementById('PATRIMONIO_v2'));

  total_patrimonial();
}

function total_patrimonio3() {
  var total = 0;
  total += sin_puntos(document.getElementById('HIPOTECA_v3').value) * 1;
  total += sin_puntos(document.getElementById('PRENDA_v3').value) * 1;
  document.getElementById('PATRIMONIO_v3').value = total;
  puntitos(document.getElementById('PATRIMONIO_v3'));

  total_patrimonial();
  total_obligaciones();
}

function total_otras() {
  var total = 0;
  total += sin_puntos(document.getElementById('TARJETAS_v1').value) * 1;
  total += sin_puntos(document.getElementById('OTROS2_v1').value) * 1;
  document.getElementById('OBLIGACIONES_v1').value = total;
  puntitos(document.getElementById('OBLIGACIONES_v1'));

  total_patrimonial();
}

function total_otras3() {
  var total = 0;
  total += sin_puntos(document.getElementById('TARJETAS_v3').value) * 1;
  total += sin_puntos(document.getElementById('OTROS2_v3').value) * 1;
  document.getElementById('OBLIGACIONES_v3').value = total;
  puntitos(document.getElementById('OBLIGACIONES_v3'));

  total_patrimonial();
  total_obligaciones();
}

function total_patrimonial() {
  var total = 0;
  total += sin_puntos(document.getElementById('PATRIMONIO_v1').value) * 1;
  total -= sin_puntos(document.getElementById('PATRIMONIO_v2').value) * 1;
  total -= sin_puntos(document.getElementById('OBLIGACIONES_v1').value) * 1;
  document.getElementById('TOTALPATRIMONIAL_v3').value = total;
  puntitos(document.getElementById('TOTALPATRIMONIAL_v3'));
}

function validar_hipoteca() {
  if (document.getElementById('HIPOTECA_v1').checked === true) {
    document.getElementById('HIPOTECA_v2').style.display = '';
    document.getElementById('HIPOTECA_v3').style.display = '';
  } else {
    document.getElementById('HIPOTECA_v2').style.display = 'none';
    document.getElementById('HIPOTECA_v3').style.display = 'none';
  }
}

function validar_prenda() {
  if (document.getElementById('PRENDA_v1').checked === true) {
    document.getElementById('PRENDA_v2').style.display = '';
    document.getElementById('PRENDA_v3').style.display = '';
  } else {
    document.getElementById('PRENDA_v2').style.display = 'none';
    document.getElementById('PRENDA_v3').style.display = 'none';
  }
}

function total_obligaciones() {
  var total = 0;
  total += sin_puntos(document.getElementById('PATRIMONIO_v3').value) * 1;
  total += sin_puntos(document.getElementById('OBLIGACIONES_v3').value) * 1;
  document.getElementById('TOTAL_OBLIGACIONES').value = total;
  puntitos(document.getElementById('TOTAL_OBLIGACIONES'));
}

function total_ingresos1() {
  var total = 0;
  total += sin_puntos(document.getElementById('salario1').value) * 1;
  total += sin_puntos(document.getElementById('pension').value) * 1;
  total += sin_puntos(document.getElementById('arriendos').value) * 1;
  total += sin_puntos(document.getElementById('dividendos').value) * 1;
  total += sin_puntos(document.getElementById('rentas').value) * 1;
  total += sin_puntos(document.getElementById('otros_ingresos').value) * 1;
  document.getElementById('total_ingresos').value = total;
  puntitos(document.getElementById('total_ingresos'));

  total_capacidad();
  validar_gastos_familiares();
  validar_salario_pension();

}

function total_egresos1() {
  var total = 0;
  total += sin_puntos(document.getElementById('arrendamientos').value) * 1;
  total += sin_puntos(document.getElementById('gastos_familiares').value) * 1;
  total += sin_puntos(document.getElementById('obligaciones_financieras').value) * 1;
  total += sin_puntos(document.getElementById('otros_gastos').value) * 1;
  document.getElementById('total_gastos').value = total;
  puntitos(document.getElementById('total_gastos'));

  total_capacidad();
  validar_gastos_familiares();
  validar_salario_pension();
}

function validar_gastos_familiares() {
  if (document.getElementById('Enviar')) {
    var gastos_familiares = sin_puntos(document.getElementById('gastos_familiares').value) * 1;
    if (gastos_familiares == 0) {
      document.getElementById('Enviar').style.display = 'none';
      document.getElementById('error_gastos_familiares').style.display = '';
    } else {
      document.getElementById('Enviar').style.display = '';
      document.getElementById('error_gastos_familiares').style.display = 'none';
    }
  }
}

function validar_salario_pension() {
  if (document.getElementById('Enviar')) {
    var salario = sin_puntos(document.getElementById('salario1').value) * 1;
    var pension = sin_puntos(document.getElementById('pension').value) * 1;
    if (salario == 0 && pension == 0) {
      document.getElementById('Enviar').style.display = 'none';
      document.getElementById('error_salario_pension').style.display = '';
    } else {
      document.getElementById('Enviar').style.display = '';
      document.getElementById('error_salario_pension').style.display = 'none';
    }
  }
}

function total_capacidad() {
  var total = 0;
  total += sin_puntos(document.getElementById('total_ingresos').value) * 1;
  total -= sin_puntos(document.getElementById('total_gastos').value) * 1;
  document.getElementById('capacidad_endeudamiento').value = total;
  puntitos(document.getElementById('capacidad_endeudamiento'));
}

function validar_actividad(id) {
  var e = document.getElementById("actividad" + id);
  var actividad = e.options[e.selectedIndex].value;
  if (actividad == "EMPLEADO") {
    $(".empleado" + id).show();
  } else {
    $(".empleado" + id).hide();
  }
}

function req_referido(i) {
  if (document.getElementById('nombres' + i).value != '') {
    document.getElementById('direccion' + i).required = true;
    document.getElementById('departamento' + i).required = true;
    document.getElementById('ciudad' + i).required = true;
    //document.getElementById('telefono'+i).required=true;
    document.getElementById('celular' + i).required = true;
    document.getElementById('actividad' + i).required = true;
    if (i == 2) {
      document.getElementById('parentesco' + i).required = true;
    }
  } else {
    document.getElementById('direccion' + i).required = false;
    document.getElementById('departamento' + i).required = false;
    document.getElementById('ciudad' + i).required = false;
    //document.getElementById('telefono'+i).required=false;
    document.getElementById('celular' + i).required = false;
    document.getElementById('actividad' + i).required = false;
    if (i == 2) {
      document.getElementById('parentesco' + i).required = false;
    }
  }
}

function set_observaciones() {
  var observaciones = document.getElementById('observaciones1').value;
  document.getElementById('observaciones').value = observaciones;
}

function calcular_monto_solicitado() {
  var valor = sin_puntos(document.getElementById('valor').value);
  var valor_disponible = sin_puntos(document.getElementById('valor_disponible').value);
  if (valor > 30000000) {
    //valor = 30000000;
    //document.getElementById('valor').value="30.000.000"
  }
  var monto_solicitado = 0;
  var saldo_actual = sin_puntos(document.getElementById('saldo_actual').value);
  monto_solicitado = Number(saldo_actual) + Number(valor);
  document.getElementById('monto_solicitado').value = monto_solicitado;
  document.getElementById('monto_solicitado2').value = monto_solicitado;
  puntitos(document.getElementById('monto_solicitado2'));
  document.getElementById('monto_solicitado1').innerHTML = '$ ' + document.getElementById('monto_solicitado2').value;
}

function seleccionar_tramite() {
  if (document.getElementById('tramite_1').checked === true) {
    document.getElementById('div_gestor_comercial').style.display = '';
    document.getElementById('tramite').value = "GESTOR COMERCIAL";
    seleccionar_gestor();
  } else {
    document.getElementById('div_gestor_comercial').style.display = 'none';
    document.getElementById('tramite').value = "DIRECTO";
    document.getElementById("gestor_comercial").value = "";
  }
}

function seleccionar_gestor() {
  var e = document.getElementById("gestor_comercial1");
  var gestor = e.options[e.selectedIndex].value;
  document.getElementById("gestor_comercial").value = gestor;
}

function validar_extra1() {
  var e = document.getElementById("abonos");
  var cuotas = e.options[e.selectedIndex].value;
  if (cuotas > 0) {
    document.getElementById("extra").required = true;
  } else {
    document.getElementById("extra").required = false;
  }
}

function validar_extra2() {
  var extra = document.getElementById("extra").value;
  var primer = document.getElementById("abonos").options[0].value;
  if (extra != "" && primer > 0) {
    document.getElementById("abonos").required = true;
  } else {
    document.getElementById("abonos").required = false;
  }
}


function eliminar_solicitud(id) {
  var x = confirm("Esta seguro que desea elmininar la solicitud " + id + "?");
  if (x === true) {
    window.location = "/page/sistema/eliminarsolicitud/?id=" + id;
  }
}

function validar_codeudor() {
  var cedula_codeudor = document.getElementById("cedula").value;
  var cedula_asociado = document.getElementById("cedula_asociado").value;
  if (cedula_codeudor == cedula_asociado) {
    document.getElementById("cedula").value = "";
    alert("El solicitante y el codeudor no pueden ser la misma persona");
  }
}


function calcularEdad() {
  var fecha = document.getElementById('fecha_nacimiento').value;
  var hoy = new Date();
  var cumpleanos = new Date(fecha);
  var edad = hoy.getFullYear() - cumpleanos.getFullYear();
  var m = hoy.getMonth() - cumpleanos.getMonth();

  if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
    edad--;
  }
  document.getElementById('edad').value = edad;
  if (edad < 18) {
    alert("Debe ser mayor de edad");
    document.getElementById('fecha_nacimiento').value = "";
    document.getElementById('edad').value = "";
  }
}

function validar_fecha_expedicion() {
  var fecha = document.getElementById('fecha_nacimiento').value;
  var fecha2 = document.getElementById('fecha_documento').value;
  if (fecha2 <= fecha) {
    alert("La fecha de expedición del documento debe ser mayor a la fecha de nacimiento");
    document.getElementById('fecha_documento').value = "";
  }
}

function validar_conyuge() {
  var estado_civil = $("#estado_civil").val();
  if (estado_civil == "Casado(a)" || estado_civil == "Union libre") {
    $("#div_conyuge").show();
    document.getElementById("conyuge_nombre").required = true;
    document.getElementById("conyuge_celular").required = true;
  } else {
    $("#div_conyuge").hide();
    document.getElementById("conyuge_nombre").required = false;
    document.getElementById("conyuge_celular").required = false;
  }
}

//Código para colocar
//los indicadores de miles mientras se escribe
//script por tunait!
function puntitos(donde) {
  var caracter = donde.value.charAt(donde.value.length - 1);
  var pat = /[\*,\+,\(,\),\?,\,$,\[,\],\^]/
  var valor = donde.value;
  var largo = valor.length;
  var crtr = true;

  if (isNaN(caracter) || pat.test(caracter) == true) {
    if (pat.test(caracter) == true) {
      //caracter = '\' + caracter;
    }
    carcter = new RegExp(caracter, "g")
    valor = valor.replace(carcter, "")
    donde.value = valor
    crtr = false
  } else {
    var nums = new Array()
    cont = 0
    for (m = 0; m < largo; m++) {
      if (valor.charAt(m) == "." || valor.charAt(m) == " ") {
        continue;
      } else {
        nums[cont] = valor.charAt(m)
        cont++
      }
    }
  }

  var cad1 = "",
    cad2 = "",
    tres = 0
  if (largo > 3 && crtr == true) {
    for (k = nums.length - 1; k >= 0; k--) {
      cad1 = nums[k];
      cad2 = cad1 + cad2;
      tres++;
      if ((tres % 3) == 0) {
        if (k != 0) {
          cad2 = "." + cad2;
        }
      }
    }
    donde.value = cad2
  }
  if (donde.value == "") {
    //donde.value=0;
  }
}
//puntitos
</script>