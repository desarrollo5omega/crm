<?php

/**
 *
 */


class Page_sistemaController extends Page_mainController
{
    public $botonpanel = 1;

  public function indexAction()
  {
      if ($_SESSION['kt_login_id'] == "") {
        header("Location:/page/login/logout");
      }

      $f1=" 1=1 ";
      if($_GET['cliente1']!=""){
        $cliente1 = $_GET['cliente1'];
        $f1=" 1=1 AND id='$cliente1' ";
      }

      $clientesModel =  new Page_Model_DbTable_Clientes();
      $clientes = $clientesModel->getList(" $f1 "," fecha_c DESC LIMIT 60 ");
      $this->_view->clientes = $clientes;


      $f2="";
      if($_GET['cliente2']!=""){
        $cliente2 = $_GET['cliente2'];
        $f2=" AND cliente_id='$cliente2' ";
      }

      $f3="";
      if($_GET['cliente3']!=""){
        $cliente3 = $_GET['cliente3'];
        $f3=" AND cliente_id='$cliente3' ";
      }

      $requerimientosModel = new Administracion_Model_DbTable_Requerimientos();
      $proyectosModel =  new Page_Model_DbTable_Proyectos();

      $proyectos = $proyectosModel->getList(" estado='6' $f2 "," fecha_c DESC LIMIT 100 "); // Proyectos en estado Pendiente
      $this->_view->proyectos = $proyectos;

      $aprobados = $proyectosModel->getList(" estado IN ('1', '7', '8') $f3 "," fecha_c DESC LIMIT 100 "); // Proyectos en estado Aprobado

      foreach($aprobados as $value){
        $id = $value->id;
        $countReq = $requerimientosModel->getList(" requerimientos_estado != 3 AND requerimientos_proyecto = '".$id."' ","");
        if ($countReq) {
          $value->cuenta_reque = count($countReq);
        } else{
          $value->cuenta_reque = "0";
        }
      }

      $this->_view->aprobados = $aprobados;

      $ultimo = $proyectosModel->getList("","consecutivo DESC LIMIT 1")[0]; // Ultimo consecutivo
      $this->_view->ultimo = $ultimo->consecutivo;


      $this->_view->list_tipo = $this->getTipo();
      $this->_view->list_cliente_id = $this->getClienteid();
      $this->_view->list_cliente_id_proyectos = $this->getClienteidProyectos();
      $this->_view->list_cliente_id_cotiza = $this->getClienteidCotiza();
      $this->_view->list_estado = $this->getEstado();
      $this->_view->list_estado2 = $this->getEstado2();
      $this->_view->list_categoria = $this->getCategoria();

      //print_r($clientes);
      //print_r($proyectos);

      $anio = date("Y");
      $proyectos_aprobados = $proyectosModel->getList(" estado IN ('1', '7', '8') AND fecha_aprobado LIKE '$anio-%' "," fecha_aprobado DESC ");

      $total_aprobados = array();
      foreach($proyectos_aprobados as $aprobados){
        $fecha = $aprobados->fecha_aprobado;
        $aux = explode("-",$fecha);
        $mes = $aux[1];
        $array_aprobados[$mes][]=$aprobados;
        $total_aprobados[$mes]++;
      }

      //print_r($array_aprobados);

      $this->_view->array_aprobados = $array_aprobados;
      $this->_view->meses = $this->get_meses();


      $seguimiento_proyectoModel =  new Page_Model_DbTable_Seguimientoproyecto();
      $programaciones = $seguimiento_proyectoModel->getList(" programar IS NOT NULL AND programar!='' AND (finalizado='' OR finalizado='0' OR finalizado IS NULL) "," programar ASC ");
      $this->_view->programaciones = $programaciones;
      $this->_view->list_proyectos = $this->getProyectos();

      $this->_view->total_aprobados = $total_aprobados;
      $this->_view->list_tipo_documento = $this->getTipodocumento();

      // Graficas
      $proyectosModel =  new Page_Model_DbTable_Proyectos();
        
      $anio = date("Y");
      $cotizaciones = $proyectosModel->getList(" estado NOT IN ('7','8','9') AND fecha_c LIKE '$anio-%' "," fecha_c DESC ");

      $total_coti_aprobados = array();
      $totales_coti = array();
      foreach($cotizaciones as $coti){
          $fecha = $coti->fecha_c;
          $aux = explode("-",$fecha);
          $mes = $aux[1];
          $array_coti_aprobados[$mes][]=$coti;
          $total_coti_aprobados[$mes]++;
          $totales_coti[$mes] += $coti->valor;
      }

      $this->_view->array_coti_aprobados = $array_coti_aprobados;
      $this->_view->total_coti_aprobados = $total_coti_aprobados;
      $this->_view->totales_coti = $totales_coti;


      $proyectos_desarrollo = $proyectosModel->getList(" estado IN ('1', '7', '8') AND fecha_aprobado LIKE '$anio-%' "," fecha_aprobado DESC ");

      $total_desarrollo = array();
      $totales = array();
      foreach($proyectos_desarrollo as $aprobados){
          $fecha = $aprobados->fecha_aprobado;
          $aux = explode("-",$fecha);
          $mes = $aux[1];
          $array_aprobados[$mes][]=$aprobados;
          $total_desarrollo[$mes]++;
          $totales[$mes] += $aprobados->valor;
      }

      //$this->_view->array_aprobados = $array_aprobados;
      $this->_view->total_desarrollo = $total_desarrollo;
      $this->_view->totales = $totales;


      $anio_mes = date("Y-m");
      $lista = $proyectosModel->getList(" fecha_c LIKE '$anio_mes-%' OR fecha_aprobado LIKE '$anio_mes-%' ", " fecha_c DESC ");

      $totalProyectos = 0; // Contador total de proyectos
      $estado = array(); // Para contar proyectos por estado
      $estadoSuma = array(); // Para sumar valores por estado
      $this->_view->listaestado = $this->getEstado3();

      foreach ($lista as $proyectos) {
          $estadoProyecto = $proyectos->estado;

          // Inicializar los contadores por estado si no existen
          if (!isset($estado[$estadoProyecto])) {
              $estado[$estadoProyecto] = 0;
              $estadoSuma[$estadoProyecto] = 0; // Inicializa el suma para ese estado
          }

          // Contar proyectos por estado
          $estado[$estadoProyecto]++;

          // Sumar valores por estado
          $estadoSuma[$estadoProyecto] += $proyectos->valor; // Sumar valores por estado
      }

      // Calcular el total de proyectos
      $totalProyectos = array_sum($estado); // Total de proyectos

      // Preparar los datos para la vista
      $this->_view->totalProyectos = $totalProyectos; // Total de proyectos
      $this->_view->estado = $estado; // Conteo de estados
      $this->_view->estadoSuma = $estadoSuma; // Suma de valores por estado



      $this->_view->meses = $this->get_meses();
      $this->_view->meses_completos = $this->get_meses_completos();

  }


  private function getTipodocumento()
	{
		$array = array();
		$array['CC'] = 'CC';
		$array['CE'] = 'CE';
		$array['Pasaporte'] = 'Pasaporte';
		$array['Nit'] = 'Nit';
		return $array;
	}

  private function getCategoria()
  {
    $array = array();
    $array['1'] = 'Prospecto';
    $array['2'] = 'Cliente';
    return $array;
  }

  private function getClienteid()
  {
    $clienteModel = new Page_Model_DbTable_Clientes();
    $listado = $clienteModel->getList(""," nombre ASC ");
    $array = array();
    foreach($listado as $value){
      $array[$value->id] = $value->nombre;
    }
    
    return $array;
  }

  private function getClienteidProyectos()
  {
    $proyectosModel = new Page_Model_DbTable_Proyectos();
    $clienteModel = new Page_Model_DbTable_Clientes();

    $listado = $proyectosModel->getList(" estado IN ('1', '7', '8') ", " nombre ASC ");
    $array = array();
    foreach ($listado as $value) {
        $cliente = $value->cliente_id;
        $listcliente = $clienteModel->getById($cliente);
        if ($listcliente) {
          $array[$listcliente->id] = $listcliente->nombre;
        }
    }

    asort($array, SORT_NATURAL | SORT_FLAG_CASE);

    return $array;
  }


  private function getClienteidCotiza()
  {
    
    $proyectosModel = new Page_Model_DbTable_Proyectos();
    $clienteModel = new Page_Model_DbTable_Clientes();

    $listado = $proyectosModel->getList(" estado = '6' "," nombre ASC ");
    $array = array();
    foreach($listado as $value){
      $cliente = $value->cliente_id;
      $listcliente = $clienteModel->getById($cliente);
      if ($listcliente) {
        $array[$listcliente->id] = $listcliente->nombre;
      }
    }

    asort($array, SORT_NATURAL | SORT_FLAG_CASE);

    return $array;
  }

  private function getProyectos()
  {
    $proyectosModel = new Page_Model_DbTable_Proyectos();
    $listado = $proyectosModel->getList(""," nombre ASC ");
    $array = array();
    foreach($listado as $value){
      $array[$value->id] = $value->nombre;
    }
    
    return $array;
  }  

  private function getEstado()
  {
    $array = array();
    $array['6'] = 'Pendiente';
    //$array['5'] = 'En cotización';
    // $array['1'] = 'Aprobado';
    $array['2'] = 'No Aprobado';
    // $array['3'] = 'En desarrollo';
    // $array['4'] = 'Finalizado';
    return $array;
  }  

  private function getEstado2()
  {
		$array = array();
		//$array['6'] = 'Pendiente';
		//$array['5'] = 'En cotización';
		$array['1'] = 'Aprobado';
		//$array['2'] = 'No Aprobado';
		// $array['3'] = 'En desarrollo';
		$array['4'] = 'Finalizado';
		return $array;
	} 

  private function getEstado3()
  {
		$array = array();
		$array['6'] = 'Pendiente';
		$array['7'] = 'Finalizado con soporte';
		$array['1'] = 'Aprobado';
		$array['2'] = 'No Aprobado';
		// $array['3'] = 'En desarrollo';
		$array['4'] = 'Finalizado';
		return $array;
	} 


  private function getTipo()
  {
    $array = array();
    $array['1'] = 'Desarrollo';
    $array['2'] = 'Soporte';
    $array['3'] = 'Diseño';
    return $array;
  }

  public function terminosAction()
  {
    //$_SESSION['id_solicitud']="";
    if ($_SESSION['kt_login_id'] == "") {
      //header("Location://FONDTODOS.com/sistema/");
      header("Location:/page/");
    }

    $this->_view->contenidos = $this->template->getContent(1);
    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    $this->getLayout()->setData("header", $header);

    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $this->_getSanitizedParam("id");
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $this->_view->solicitud = $solicitudModel->getById($id);

    $documentosModel = new Administracion_Model_DbTable_Documentos();
    $this->_view->documentos = $documentosModel->getList("solicitud = '$id'", "")[0];
  }

 

  public function blancoAction()
  {
    $header = "";
    $this->getLayout()->setData("header", $header);
    $this->setLayout('blanco');
  }





  public function pruebaenvioAction()
  {
    //correo asociado
    $emailModel = new Core_Model_Mail();
    $asunto = "Solicitud de crédito WEB 0000";
    $content = "Solicitud de crédito WEB 0000";

    $email = "creyes@omegawebsystems.com";

    $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
    $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
    $emailModel->getMail()->addAddress("" . $email);

    $emailModel->getMail()->Subject = $asunto;
    $emailModel->getMail()->msgHTML($content);
    $emailModel->getMail()->AltBody = $content;
    $emailModel->sed();
    echo $emailModel->getMail()->ErrorInfo;
  }



  public function perfilAction()
  {

    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    $this->getLayout()->setData("header", $header);

    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $user = $usuarioModel->getById($_SESSION['kt_login_id']);
    $this->_view->content = $user;
  }

  public function updateclienteAction() {
    header('Content-Type: application/json');
    $this->setLayout('blanco');

    $clientesModel = new Page_Model_DbTable_Clientes();

    
    $json = file_get_contents('php://input');
    $data = json_decode($json, true); 

    $id = $data['cliente_id'];
    $info = $clientesModel->getById($id);

    if ($info) {
        
        foreach ($data as $key => $value) {
            if ($key !== 'cliente_id' && !empty($value)) { 
                $clientesModel->editField($id, $key, $value);
            }
        }

        $respuesta["msm"] = "Actualización realizada con éxito.";
        $respuesta["err"] = "1";
    }
    
    $data['id'] = $id;
    $data['log_log'] = print_r($data, true);
    $data['log_tipo'] = 'ACTUALIZAR CLIENTE';
    $logModel = new Administracion_Model_DbTable_Log();
    $logModel->insert($data);

    echo json_encode($respuesta);
  }

  public function updatecotizacionAction() {
    header('Content-Type: application/json');
    $this->setLayout('blanco');

    $cotizacionesModel = new Page_Model_DbTable_Proyectos();
    
    $json = file_get_contents('php://input');
    $data = json_decode($json, true); 

    $id = $data['id'];
    $info = $cotizacionesModel->getById($id);

    if ($info) {
        
        foreach ($data as $key => $value) {
          if ($key !== 'cliente_id' && !empty($value)) {
            if ($key == 'valor') {
              $valor = str_replace(".","", $value);
              $cotizacionesModel->editField($id, $key, $valor);
            } else {
              $cotizacionesModel->editField($id, $key, $value);
            }
            
          }
        }

        $respuesta["msm"] = "Actualización realizada con éxito.";
        $respuesta["err"] = "1";
    }
    
    $data['id'] = $id;
    $data['log_log'] = print_r($data, true);
    $data['log_tipo'] = 'ACTUALIZAR COTIZACION';
    $logModel = new Administracion_Model_DbTable_Log();
    $logModel->insert($data);

    echo json_encode($respuesta);
  }

  public function updateproyectosAction() {
    header('Content-Type: application/json');
    $this->setLayout('blanco');

    $proyectosModel = new Page_Model_DbTable_Proyectos();
    
    $json = file_get_contents('php://input');
    $data = json_decode($json, true); 

    $id = $data['id'];
    $info = $proyectosModel->getById($id);

    if ($info) {
        
        foreach ($data as $key => $value) {
          if ($key !== 'cliente_id' && !empty($value)) {
            if ($key == 'valor') {
              $valor = str_replace(".","", $value);
              $proyectosModel->editField($id, $key, $valor);
            } else {
              $proyectosModel->editField($id, $key, $value);
            }
            
          }
        }

        $respuesta["msm"] = "Actualización realizada con éxito.";
        $respuesta["err"] = "1";
    }
    
    $data['id'] = $id;
    $data['log_log'] = print_r($data, true);
    $data['log_tipo'] = 'ACTUALIZAR PROYECTO';
    $logModel = new Administracion_Model_DbTable_Log();
    $logModel->insert($data);

    echo json_encode($respuesta);
  }
  
  public function guardarperfilAction()
  {

    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $id = $this->_getSanitizedParam("id");

    $email = $this->_getSanitizedParam("user_email");
    $usuarioModel->editField($id, "user_email", $email);
    $user_password = $this->_getSanitizedParam("user_password");
    if ($user_password != "") {
      $hoy = date("Y-m-d");
      $user_password2 = password_hash($user_password, PASSWORD_DEFAULT);
      $usuarioModel->editField($id, "user_password", $user_password2);
      $usuarioModel->editField($id, "user_password_fecha", $hoy);
    }
    header("Location:/page/sistema/perfil/?a=1");
  }



  public function sin_puntos($x)
  {
    $x = str_replace(".", "", $x);
    $x = str_replace(",", "", $x);
    $x = $x * 1;
    return $x;
  }

  public function limpiar($x)
  {
    $mal = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "Ñ", "*", "'", " ", "&", "$", '"');
    $bien = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "", "", "_", "", "", '');
    $x = str_replace($mal, $bien, $x);
    //$x = utf8_encode($x);
    $x = trim($x);
    return $x;
  }

  public function limpiar2($x)
  {
    $mal = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "*", "'", " ", "&", "$", '"');
    $bien = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "", "", " ", "", "", '');
    $x = str_replace($mal, $bien, $x);
    $x = trim($x);
    return $x;
  }
  public function limpiar_numero($x)
  {
    $mal = array(".", ",", "$", " ", "'");
    $bien = array("", "", "", "", "");
    $x = str_replace($mal, $bien, $x);
    $x = trim($x);
    return $x;
  }

  public function cargar_imagen($archivo)
  {
    //$pre = date("ymdhis")."_";
    $pre = "WEB" . $_POST['id'] . "_";
    $target_dir = "documentos/";
    $target_file = $target_dir . $pre . basename($_FILES["" . $archivo]["name"]);
    $archivo1 = $pre . basename($_FILES["" . $archivo]["name"]);
    $target_file = limpiar($target_file);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    if ($uploadOk == 0) {
      //echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["" . $archivo]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $archivo1 = limpiar($archivo1);
        return $archivo1;
      } else {
        //echo "Sorry, there was an error uploading your file.";
        if ($_POST[$archivo . '_ant'] != "") {
          return $_POST[$archivo . '_ant'];
        } else {
          return 0;
        }
      }
    }
  }


  public function filtrolineaAction()
  {
    header('Content-Type:application/json');
    $this->setLayout('blanco');

    $linea = $this->_getSanitizedParam("linea");
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];

    $res .= $lineas->requisitos;
    $respuesta['valores'] = $res;


    //CALCULAR CUPOS
    $cedula = $_SESSION['kt_login_user'];

    $cedulasModel = new Administracion_Model_DbTable_Cedulas();
    $infousuariosModel = new Administracion_Model_DbTable_Usuariosinfo();
    $usuarioinfo = $infousuariosModel->getById($cedula);
    $nomina_list = $cedulasModel->getList(" cedula='$cedula' ", "");

    $linea_id = $lineas->id;

    $linea_list = $lineaModel->getById($linea_id);
    $linea = $linea_list->codigo;
    $this->_view->tasa_nominal = $linea_list->efectivo_anual;
    $respuesta['tasa_nominal'] = $linea_list->efectivo_anual;

    $cuposModel = new Administracion_Model_DbTable_Cuposlinea();
    $cupos_list = $cuposModel->getList(" cedula='$cedula' AND linea='$linea_id' ", "");

    //$cupo_actual = $cupos_list[0]->cupo*1;
    $salario = $usuarioinfo->salario;

    $ahorrosModel = new Administracion_Model_DbTable_Ahorrosaportes();
    $ahorros_list = $ahorrosModel->getList("cedula='$cedula' ", "")[0];
    $ahorros = $ahorros_list->ahorros;
    $aportes = $ahorros_list->aportes;
    $ahorrosvol = $ahorros_list->ahorrosvol;
    $ahorrototal = $ahorros_list->ahorrosvol + $ahorros_list->ahorros;


    $configModel = new Administracion_Model_DbTable_Config();
    $config_list = $configModel->getList("", "");
    $smlv = $config_list[0]->salario_minimo;
    //$aportes = 0; //aportes sociales y ahorro permantente


    $saldosModel = new Page_Model_DbTable_Saldos();


    //cupo max
    $saldos_list = $saldosModel->getList("  estadocuenta_saldos_cedula='$cedula' ", "");
    $saldos = 0;
    foreach ($saldos_list as $key => $value) {
      $saldos += $value->estadocuenta_saldos_stotal;
    }
    //$cupo_max = (10*$aportes) - $saldos;
    if ($cupo_max > 150000000) { //tope supersolidaria
      $cupo_max = 150000000;
    }

    if ($linea == "AF") {
      $cupo_actual = $linea_list->maxMonto;
    }
    if ($linea == "ML") {
      $cupo_actual = $linea_list->maxMonto;
    }
    if ($linea == "CDU") {
      $cupo_actual = $linea_list->maxMonto;
    }

    if ($linea == "LI") {
      $cupo_actual = ($salario * 4) + $aportes + $ahorros;

      // $saldos_list = $saldosModel->getList("estadocuenta_saldos_linea = 13 AND estadocuenta_saldos_cedula='$cedula' ","");
      // foreach ($saldos_list as $key => $value) {
      //  $saldos=$saldos+$value->saldoactual;
      // }
      // if($cupo_actual > $cupo_max){
      //  $cupo_actual = $cupo_max;
      // }
      // $cupo_actual = $cupo_actual - $saldos;     
    }
    if ($linea == "CRA") {
      $cupo_actual = $aportes + $ahorros;

      // $saldos_list = $saldosModel->getList("estadocuenta_saldos_linea = 13 AND estadocuenta_saldos_cedula='$cedula' ","");
      // foreach ($saldos_list as $key => $value) {
      //  $saldos=$saldos+$value->saldoactual;
      // }
      // if($cupo_actual > $cupo_max){
      //  $cupo_actual = $cupo_max;
      // }
      // $cupo_actual = $cupo_actual - $saldos;     

      $respuesta['aportes']=$aportes;
      $respuesta['ahorros']=$ahorros;
      $respuesta['cupo_CRA']=$cupo_actual;

    }
    if ($linea == "CF") {
      $cupo_actual = 1000000;
    }
    if ($linea == "CA") {
      $cupo_actual = $linea_list->maxMonto;
    }
    if ($linea == "VEH" || $linea == "SO" || $linea == "EDU" || $linea == "CC" || $linea == "CCC" || $linea == "TR" || $linea == "CV" || $linea == "SE" || $linea == "PDI" || $linea == "CF") {
      $cupo_actual = 100000000000000;
    }
    if ($linea == "AP") {
      $cupo_actual = $cupo_max =  $salario * 0.35;
      // $saldos_list = $saldosModel->getList(" (estadocuenta_saldos_linea = 7 AND estadocuenta_saldos_cedula='$cedula' ","");
      // $saldos=0;
      // foreach ($saldos_list as $key => $value) {
      //  $saldos=$saldos+$value->saldoactual;
      // }

      // if($cupo_actual > $cupo_max){
      //  $cupo_actual = $cupo_max;
      // }
      // $cupo_actual = $cupo_actual - $saldos;
    }
    if ($linea == "SA") {
      $cupo_max = $smlv * 10;
      $cupo_max2 = $aportes * 2.5;
      $cupo_max3 = $ahorros * 2.5;
      // $saldos_list = $saldosModel->getList(" estadocuenta_saldos_linea LIKE '%SALUD%' AND estadocuenta_saldos_linea!='CREDIFACIL CUOTA UNICA' AND estadocuenta_saldos_cedula='$cedula' ","");
      // foreach ($saldos_list as $key => $value) {
      //  $saldos=$saldos+$value->saldoactual;

      // }

      $cupo_actual = $cupo_max;

      if ($cupo_actual > $cupo_max2 || $cupo_actual > $cupo_max3) {
        if ($cupo_max2 > $cupo_max3) {
          $cupo_actual = $cupo_max2;
        }
        if ($cupo_max3 > $cupo_max2) {
          $cupo_actual = $cupo_max3;
        }
      }
      //$cupo_actual = $cupo_actual - $saldos;
    }



    if ($linea == "CD") {
      $cupo_actual = $cupo_max = $smlv * 3;

      $saldos_list = $saldosModel->getList(" estadocuenta_saldos_linea = 'CALAMIDAD DOMESTICA' AND estadocuenta_saldos_cedula='$cedula' ", "");
      $saldos = 0;
      foreach ($saldos_list as $key => $value) {
        $saldos = $saldos + $value->saldoactual;
      }


      if ($cupo_actual > $cupo_max) {
        $cupo_actual = $cupo_max;
      }
      $cupo_actual = $cupo_actual - $saldos;
    }
    if ($linea == "CN") {
      $cupo_actual = 2000000;
    }



    $saldo_actual = $cupos_list[0]->saldo_actual * 1;
    $valor_disponible = $cupo_actual;

    $this->_view->cupo_actual = $cupo_actual;
    $this->_view->saldo_actual = $saldo_actual;
    $this->_view->valor_disponible = $valor_disponible;
    $respuesta['cupo_actual'] = $this->formato_pesos($cupo_actual);
    $respuesta['saldo_actual'] = $saldo_actual;
    $respuesta['saldo_actual1'] = $this->formato_pesos($saldo_actual);
    $respuesta['valor_disponible'] = $this->formato_pesos($valor_disponible);
    //CALCULAR CUPOS

    //PARAMETROS
    $min = 1;
    $max = 36;

    $max_meses = $linea_list->max_meses;
    $min_meses = $linea_list->min_meses;
    if ($config_list[0]->cuota_min != "") {
      $min = $config_list[0]->cuota_min;
    }
    if ($config_list[0]->cuota_max != "") {
      $max = $config_list[0]->cuota_max;
    }
    if ($min_meses > 0) {
      $min = $min_meses;
    }
    if ($max_meses > 0) {
      $max = $max_meses;
    }
    $this->_view->min = $min;
    $this->_view->max = $max;

    $this->_view->valor_min = $valor_min = $config_list[0]->valor_min * 0;
    $this->_view->valor_max = $valor_max = $config_list[0]->valor_max;

    $respuesta['min'] = $min;
    $respuesta['max'] = $max;
    $respuesta['valor_min'] = $valor_min;
    $respuesta['valor_max'] = $valor_max;

    $cuotas = $this->_getSanitizedParam("cuotas");
    $menu_cuotas = '';
    for ($i = $min; $i <= $max; $i++) {
      $seleccionado = '';
      if ($cuotas == $i) {
        $seleccionado = ' selected ';
      }
      $menu_cuotas .= '<option value="' . $i . '" ' . $seleccionado . ' >' . $i . '</option>';
    }
    if ($linea_id) {
    }
    $respuesta['menu_cuotas'] = $menu_cuotas;

    $valor1 = $this->_getSanitizedParam("valor");
    if ($valor1 == "") {
      $valor1 = $this->formato_pesos($valor_min);
    }
    $valor = str_replace(".", "", $valor1);
    $this->_view->valor1 = $valor1;
    $this->_view->valor = $valor;
    $respuesta['valor1'] = $valor1;
    $respuesta['valor'] = $valor;

    $monto_solicitado = $this->_getSanitizedParam("monto_solicitado");
    $this->_view->monto_solicitado = $monto_solicitado;
    $respuesta['monto_solicitado'] = $monto_solicitado;

    $monto_aux = $monto_solicitado;

    $cuotas = $this->_getSanitizedParam("cuotas");
    $this->_view->n = $cuotas;
    $respuesta['n'] = $cuotas;
    $rangosModel = new Administracion_Model_DbTable_Rangos();



    $abonos = $this->_getSanitizedParam("abonos");
    $this->_view->abonos = $abonos;
    $respuesta['abonos'] = $abonos;

    $extra = $this->_getSanitizedParam("extra");
    $this->_view->extra = $extra;
    $respuesta['extra'] = $extra;

    $tasa = $linea_list->tasa_real;
    $tasa_nominal = $linea_list->efectivo_anual;
    //$tasa = $tasa_nominal/12;

    // rango cuotas
    if ($linea == "LI") {
      $rango = $rangosModel->getList("rango_codigo=2", "");
      foreach ($rango as $key => $item) {
        if ($cuotas >= $item->rango_min && $cuotas <= $item->rango_max) {
          $tasa = $item->rango_tasa_mensual;
          $respuesta['tasa_nominal'] = $item->rango_tasa_anual;
          break;
        }
      }
    }
    // if ($linea == "CC") {
    //   $rango = $rangosModel->getList("rango_codigo=8", "");
    //   foreach ($rango as $key => $item) {
    //     if ($cuotas >= $item->rango_min && $cuotas <= $item->rango_max) {
    //       $tasa = $item->rango_tasa_mensual;
    //       $respuesta['tasa_nominal'] = $item->rango_tasa_anual;
    //       break;
    //     }
    //   }
    // }
    // if($linea=="CC"){
    //  $rango=$rangosModel->getList("rango_codigo=8","");
    //  foreach($rango as $key => $item){
    //    if($cuotas>=$item->rango_min && $cuotas<=$item->rango_max){
    //   $tasa=$item->rango_tasa_mensual  ;
    //   $respuesta['tasa_nominal']=$item->rango_tasa_anual ;
    //    break;
    //    }
    //  }

    // }

    $this->_view->tasa = $tasa;

    $respuesta['tasa'] = $tasa;

    $destino = $this->_getSanitizedParam("destino");
    $this->_view->destino = $destino;
    $respuesta['destino'] = $destino;
    //PARAMETROS


    //CALCULAR CUOTA

    //CUOTAS EXTRA
    $cuotaextra = str_replace('.', '', $extra);
    $abono_extra = $abonos;
    $i = $tasa / 100;

    //calcular valor presente cuotas
    $anio = date('Y');
    $hoy = date("Y-m-d");
    if ($hoy <= $anio . '-06-30') {
      $meses = 6 - date('m');
    } else {
      $meses = 12 - date('m');
    }
    $fecha_final = date("Y-m-d", strtotime($hoy . "+ " . $cuotas . " month"));
    $start = $month = strtotime($hoy);
    $end = strtotime($fecha_final);
    $presente = 0;
    $array = array();
    $respuesta['mesinicio'] = $start;
    while ($month < $end) {
      $meses = date('m', $month);
      $m = $meses * 1;
      if ($abonos == "Junio" && $meses == 06) {
        $p = 1 + ($i);
        $p = pow($p, -1 * $m);
        $p = $p * $cuotaextra;
        $presente = $presente + $p;
      }
      if ($abonos == "Diciembre" && $meses == 12) {
        $p = 1 + ($i);
        $p = pow($p, -1 * $m);
        $p = $p * $cuotaextra;
        $presente = $presente + $p;
      }
      if ($abonos == "Junio y Diciembre" && ($meses == 12 || $meses == 06)) {
        $p = 1 + ($i);
        $p = pow($p, -1 * $m);
        $p = $p * $cuotaextra;
        $presente = $presente + $p;
      }
      $month = strtotime("+1 month", $month);
    }
    $respuesta['mesespr'] = $array;
    //calcular valor presente cuotas

    //CUOTAS EXTRA

    $i = $tasa / 100;
    $k1 = $valor - $presente; // prestamo
    $n = $max_meses;
    if ($cuotas != "") {
      $n = $cuotas; //cuotas
    }
    $r = $k1 * $i;
    $factor_seguro = 0.26 / 1000;
    $r1 = 1 - pow((1 + $i + $factor_seguro), (-1 * $n));
    if ($r1 > 0) {
      $r = round($k1 * (($i + $factor_seguro) / $r1), 0);
    }
    if ($i == 0) {
      if ($linea = "CDU") {
        $k1 = $k1 + 8800;
      }
      $r = $k1 / $n;
    }

    $hoy = date("Y") . "-" . date("m") . "-" . date("d");
    $diahoy = date("d");

    $this->_view->r = $r;
    $this->_view->numerocuotasextra = $numerocuotasextra;
    $this->_view->cuotaextra = $cuotaextra;
    $respuesta['r'] = $r;
    $respuesta['r2'] = number_format($r, 0, ',', '.');
    $respuesta['r1'] = number_format($r);

    $respuesta['numerocuotasextra'] = $numerocuotasextra;
    $respuesta['numerocuotasextra2'] = $numerocuotasextra2;
    $respuesta['cuotaextra'] = $cuotaextra;
    //CALCULAR CUOTA

    $hoy = date("Y-m-d");
    $diahoy = date("d");
    $k = $monto_aux;
    $interes = $k * $i;
    //$seguro = $k*0.35/1000;
    //$seguro = 0;
    $abono = $r - $interes;
    $saldo = $k;
    if ($linea == "AP") {
      $tasa_diaria = (pow(1 + $i, 1 / 30)) - 1;
      $ultimo = $this->UltimoDia(date("Y"), date("m"));
      $fecha1 = date("Y-m-") . $ultimo;

      $fecha_ultimo = "2021-06-30";
      if ($hoy >= "2021-06-01") {
        $fecha_ultimo = "2021-12-31";
      }

      $date1 = new Datetime($fecha1);
      $date2 = new Datetime($fecha_ultimo);
      $diff = $date1->diff($date2);
      $dias_intereses3 = $diff->days;
      $meses1 = floor($dias_intereses3 / 30);
      $dias_intereses3 = $meses1 * 30;
      $interes = $monto_aux * ((pow(1 + $tasa_diaria, $dias_intereses3)) - 1);
      $r = $monto_aux + $interes;
    }

    $tabla = '<table width="100%" border="1" cellspacing="3" class="table-striped">
              <tr class="fondo-gris azul">
                <th class="text-center">NUMERO</th>
                <th class="text-center">FECHA</th>
                <th class="text-center">CAPITAL</th>
                <th class="text-center">INTERESES</th>
                <th class="text-center">CUOTA</th>
                <!--<th class="text-center">CUOTA EXTRA</th>-->
                <th class="text-center">TOTAL</th>
                <th class="text-center">SALDO</th>
              </tr>';
    for ($j = 1; $j <= $n; $j++) {

      if ($diahoy >= 9) {
        $meses = $j;
      } else {
        $meses = $j - 1;
      }
      $fecha = date("Y-m-d", strtotime("$hoy +$meses month"));
      $var = explode("-", $fecha);

      $max_meses = 120;


      $ultimo =  $this->UltimoDia($var[0], $var[1]);
      $fecha = $var[0] . "-" . $var[1] . "-" . $ultimo;
      if ($max_meses > 1) {
        $fecha2 = $var[0] . "-" . $var[1];
      } else {
        if ($hoy <= (date("Y") . "-06-30")) {
          $fecha2 = date("Y") . "-06";
        } else {
          $fecha2 = date("Y") . "-12";
        }
      }
      if ($linea == "AP") {
        $fecha = $fecha_ultimo;
      }

      $tabla .= '
      <tr>
        <td class="text-center">' . $j . '</td>
        <td class="text-center">' . $fecha . '</td>
        <td class="text-center">' . number_format($abono) . '</td>
        <td class="text-center">' . number_format($interes) . '</td>
        <td class="text-center">' . number_format($abono + $interes - $seguro) . '</td>
        <!--<td class="text-center">' . number_format($cuota_extra) . '</td>-->
        <td class="text-center">' . number_format($r) . '</td>';
      $saldo = $saldo - $abono - $extra2;
      if ($saldo < 200) {
        //$saldo=0;
      }

      $tabla .= '
        <td class="text-center">' . number_format($saldo) . '</td>
      </tr>';

      $interes = $saldo * $i;
      $seguro = $saldo * 0.35 / 1000;
      //$seguro = 0;
      $abono = $r - $interes;
    }

    $tabla .= '</table>';

    $tabla = str_replace(array("\r", "\n", "\t", "      "), '', $tabla);

    $respuesta['tabla'] = $tabla;


    echo json_encode($respuesta);
  }

  public function recogerAction()
  {
    header('Content-Type:application/json');
    $this->setLayout('blanco');
    $cedula = $this->_getSanitizedParam("cedula");
    $linea = $this->_getSanitizedParam("linea");
    $saldosModel = new Page_Model_DbTable_Saldos();
    $filtro = "1=1";
    if ($linea == "EDU" || $linea == "CC" || $linea == "CV" || $linea == "TR") {
      $filtro = $filtro . " AND  estadocuenta_saldos_linea='$linea'";
    }


    $saldos = $saldosModel->getList(" AND estadocuenta_saldos_cedula='$cedula' ", "");

    $tabla = '<br><table width="100%" cellspacing="0" cellpadding="3" border="1" class="tabla_gris">
          <tr>
            <th>No. Obligación</th>
            <th>Valor Inicial</th>
            <th>Saldo</th>
            <th><div align="center">¿Recoger?</div></th>
          </tr>
    ';

    foreach ($saldos as $key => $value) {
      $tabla .= '
          <tr>
            <td><a class="enlace_modal" data-bs-toggle="modal" data-bs-target="#modal_recoger' . $key . '">' . $value->pagare . '</a></td>
            <td>$' . number_format($value->monto) . '</td>
            <td>$' . number_format($value->saldoactual) . '</td>
            <td align="center"><input type="checkbox" id="saldo' . $key . '" onclick="sumar_saldos(' . $key . ')" /></td>
          </tr>
          <input type="hidden" value="' . $value->saldoactual . '" id="valor_saldo' . $key . '" />
          <input type="hidden" value="' . $value->pagare . '" id="numero' . $key . '" />
          <input type="hidden" value="' . $value->estadocuenta_saldos_linea . '" id="linea_recoger' . $key . '" />
      ';

      $modal = '
        <div class="modal fade" id="modal_recoger' . $key . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
              <div class="col-6"><b>No. Obligación: </b></div>
              <div class="col-6">' . $value->estadocuenta_saldos_numero . '</div>
              <div class="col-6"><b>Línea: </b></div>
              <div class="col-6">' . $value->estadocuenta_saldos_linea . '</div>
              <div class="col-6"><b>Cuotas pendientes: </b></div>
              <div class="col-6">' . $value->estadocuenta_saldos_cuotasp . '</div>
              <div class="col-6"><b>Valor cuota: </b></div>
              <div class="col-6">$' . number_format($value->estadocuenta_saldos_vcuota) . '</div>
              <div class="col-6"><b>Fecha emisión: </b></div>
              <div class="col-6">' . $value->estadocuenta_saldos_femision . '</div>
              <div class="col-6"><b>Fecha vencimiento: </b></div>
              <div class="col-6">' . $value->estadocuenta_saldos_fvencimiento . '</div>
              <div class="col-6"><b>Valor Inicial: </b></div>
              <div class="col-6">$' . number_format($value->estadocuenta_saldos_vinicial) . '</div>
              <div class="col-6"><b>Saldo: </b></div>
              <div class="col-6">$' . number_format($value->estadocuenta_saldos_stotal) . '</div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
      ';

      $tabla .= $modal;
    }
    $tabla .= '</table><br>';

    $tabla = str_replace(array("\r", "\n", "\t", "      "), '', $tabla);

    //$tabla = print_r($saldos,true);
    $respuesta['tabla'] = $tabla;
    echo json_encode($respuesta);
  }


  public function consultarcodeudorAction()
  {
    header('Content-Type:application/json');
    $this->setLayout('blanco');
    $cedula = $this->_getSanitizedParam("cedula");
    $usuariosModel = new Page_Model_DbTable_Usuarios();
    $usuario = $usuariosModel->getList(" user_user ='$cedula' ", "");

    $existe = count($usuario);
    $nombres = $usuario[0]->user_names;
    $apellidos = $usuario[0]->user_lastnames;
    $nombres = html_entity_decode($nombres);
    $apellidos = html_entity_decode($apellidos);
    $aux = explode(" ", $nombres);
    $aux2 = explode(" ", $apellidos);
    $nombre1 = $aux[0];
    $nombre2 = $aux[1];
    $apellido1 = $aux2[0];
    $apellido2 = $aux2[1];
    $email = $usuario[0]->user_email;

    $respuesta['existe'] = $existe;
    $respuesta['nombre1'] = $nombre1;
    $respuesta['nombre2'] = $nombre2;
    $respuesta['apellido1'] = $apellido1;
    $respuesta['apellido2'] = $apellido2;
    $respuesta['email'] = $email;
    echo json_encode($respuesta);
  }


  function formato_pesos($x)
  {
    $res = number_format($x, 0, ',', '.');
    return $res;
  }

  function UltimoDia($anho, $mes)
  {
    if (((fmod($anho, 4) == 0) and (fmod($anho, 100) != 0)) or (fmod($anho, 400) == 0)) {
      $dias_febrero = 29;
    } else {
      $dias_febrero = 28;
    }
    switch ($mes) {
      case 1:
        return 31;
        break;
      case 2:
        return $dias_febrero;
        break;
      case 3:
        return 31;
        break;
      case 4:
        return 30;
        break;
      case 5:
        return 31;
        break;
      case 6:
        return 30;
        break;
      case 7:
        return 31;
        break;
      case 8:
        return 31;
        break;
      case 9:
        return 30;
        break;
      case 10:
        return 31;
        break;
      case 11:
        return 30;
        break;
      case 12:
        return 31;
        break;
    }
  }


  function generartabla($numero, $usuario, $solicitud, $lineas, $analista, $lineas2)
  {

    $estilo1 = 'style="background: #eee;"';
    $estilo2 = 'style="background: #0084C9; color:#FFFFFF;"';
    $estilo2 = 'style="background: #CCCCCC; background-color: #CCCCCC; color:#FFFFFF;"';

    $garantias = array("", "APORTES SOCIALES INDIVIDUALES", "DEUDOR SOLIDARIO", "AFIANZADORA", "HIPOTECARIA", "PRENDARIA");

    $nombres = $solicitud->nombres . " " . $solicitud->nombres2 . " " . $solicitud->apellido1 . " " . $solicitud->apellido2;

    $tabla .= '<table width="100%" style="max-width:900px;" border="1" cellspacing="0" cellpadding="3" class="formulario tabla_lineas">


      <tr class="fondo-gris" ' . $estilo2 . '>
        <td colspan="2"><div align="center">
        <b>Datos personales</b></div></td>
      </tr>

      <tr ' . $estilo1 . '>
        <td><strong>Documento</strong></td>
        <td align="right">' . $solicitud->cedula . '</td>
      </tr>
      <tr>
        <td><strong>Nombre</strong></td>
        <td align="right">' . $nombres . '</td>
      </tr>
      <tr ' . $estilo1 . '>
        <td><strong>Email</strong></td>
        <td align="right">' . $solicitud->correo_personal . '</td>
      </tr>
      <tr>
        <td><strong>Celular</strong></td>
        <td align="right">' . $solicitud->celular . '</td>
      </tr>
      <tr ' . $estilo1 . '>
        <td><strong>Tel&eacute;fono</strong></td>
        <td align="right">' . $solicitud->telefono . '</td>
      </tr>

      <tr class="fondo-gris" ' . $estilo2 . '>
        <td colspan="2"><div align="center">
        <b>Resumen de solicitud</b></div></td>
      </tr>

      <tr>
        <td><strong>Solicitud</strong></td>
        <td align="right">WEB' . $numero . '</td>
      </tr>

      <tr>
        <td><strong>L&iacute;nea de cr&eacute;dito</strong></td>
        <td align="right">' . $lineas->codigo . ' - ' . $lineas->nombre . '&nbsp;</td>
      </tr>';


    $valida = array("NO", "SI");
    $valida[''] = "NO";
    $saldo = $solicitud->valor - $solicitud->valor_desembolso;

    $tabla .= '
      <tr ' . $estilo1 . '>
        <td><strong>Valor solicitado</strong></td>
        <td align="right">$' . $this->formato_pesos($solicitud->valor) . '</td>
      </tr>
      <tr>';
    if ($solicitud->linea_desembolso == "LI") {
      $tabla .= '
        <td><strong>Recoge créditos?</strong></td>
        <td align="right">' . $valida[$solicitud->recoger_credito] . '</td>
      </tr>';
    }

    // if($solicitud->recoger_credito=="1"){
    //  $tabla.='
    //    <tr '.$estilo1.'>
    //      <td><strong>Créditos recogidos</strong></td>
    //      <td align="right">'.$solicitud->numeros_recogidos.'</td>
    //    </tr>
    //    <tr>
    //      <td><strong>Total saldo recogidos</strong></td>
    //      <td align="right">$'.$this->formato_pesos($solicitud->valor_recogidos).'</td>
    //    </tr>';
    // }

    // if($solicitud->valor_fm>0){
    //   $tabla.='
    //   <tr>
    //     <td><strong>Valor fondo mutual</strong></td>
    //     <td align="right">$'.$this->formato_pesos($solicitud->valor_fm).'</td>
    //   </tr>';
    // }

    $tabla .= '
      
      <tr>
        <td><strong>N&uacute;mero de Cuotas</strong></td>
        <td align="right">' . $solicitud->cuotas . '</td>
      </tr>
      <tr ' . $estilo1 . '>
        <td><strong>Valor aproximado de cuota</strong></td>
        <td align="right">$' . $this->formato_pesos($solicitud->valor_cuota) . '</td>
      </tr>';
    if ($solicitud->cuotas_extra_desembolso && $solicitud->valor_extra_desembolso) {
      $tabla .= ' <tr>
        <td><strong>Compromiso de primas</strong></td>
        <td align="right">' . $solicitud->cuotas_extra_desembolso . '</td>
      </tr>
        <tr>
        <td><strong>Valor compromiso de primas</strong></td>
        <td align="right">$' . $this->formato_pesos($solicitud->valor_extra_desembolso) . '</td>
      </tr>';
    }

    $tabla .= ' 

      <tr>
        <td><strong>Fecha solicitud</strong></td>
        <td align="right">' . $solicitud->fecha_asignado . '</td>
      </tr>

      <tr class="fondo-gris" ' . $estilo2 . '>
        <td colspan="2"><div align="center">
        <b>Condiciones otorgadas</b></div></td>
      </tr>
<tr>
        <td><strong>Linea de crédito</strong></td>
        <td align="right">' . $lineas2->codigo . ' - ' . $lineas2->nombre . '&nbsp;</td>
      </tr>
      <tr ' . $estilo1 . '>
        <td><strong>Tasa mes vencido</strong></td>
        <td align="right">' . $solicitud->tasa_desembolso . '%</td>
      </tr>

      <tr ' . $estilo1 . '>
        <td><strong>Garantía</strong></td>
        <td align="right">' . $garantias[$solicitud->tipo_garantia] . '</td>
      </tr>
      ';
    if ($solicitud->garantia_adicional) {
      $tabla .= '
       <tr>
         <td><strong>Garantía Adicional</strong></td>
         <td align="right">' . $garantias[$solicitud->garantia_adicional] . '</td>
        </tr>';
    }

    if ($solicitud->fecha_anterior != "") {
      $tabla .= '
        <tr>
          <td><strong>Fecha solicitud anterior incompleta</strong></td>
          <td align="right">' . $solicitud->fecha_anterior . '</td>
        </tr>';
    }

    $correo1 = $analista->user_email;
    $extension = "";
    if ($analista->user_ext != "") {
      $extension = " ext " . $analista->user_ext;
    }

    $userModel = new Administracion_Model_DbTable_Usuario();
    $comercial = $userModel->getList("user_regional LIKE '%$solicitud->regional%'  AND user_level = 13", "")[0];
    $tabla .= '


      <tr class="fondo-gris" ' . $estilo2 . '>
        <td colspan="2"><div align="center">
        <b>Información Fondtodos</b></div></td>
      </tr>

      <tr>
        <td><strong>Trámite</strong></td>
        <td align="right">' . $solicitud->tramite . '</td>
      </tr>
      <tr>
        <td><strong>Comercial asignado </strong></td>
        <td align="right">' . $comercial->user_names . '</td>
      </tr>
      <tr>
        <td><strong>Email</strong></td>
        <td align="right">' . $comercial->user_email . '</td>
      </tr>
      <tr>
        <td><strong>Celular</strong></td>
        <td align="right">' . $comercial->user_celular . '</td>
      </tr>
      </table>';

    return $tabla;
  }


  function generartabla2($numero, $usuario, $solicitud, $lineas, $analista, $lineas2)
  {

    $estilo2 = 'style="background: #CCCCCC; background-color: #CCCCCC; color:#FFFFFF;"';

    $nombres = $solicitud->nombres . " " . $solicitud->nombres2 . " " . $solicitud->apellido1 . " " . $solicitud->apellido2;
    $garantias = array("", "APORTES SOCIALES INDIVIDUALES", "DEUDOR SOLIDARIO", "AFIANZADORA", "HIPOTECARIA", "PRENDARIA");
    $tabla = '';
    $tabla .= '

    <table width="100%" style="" border="1" cellspacing="0" cellpadding="3" class="tabla-resumen">

      <tr class="fondo-gris" ' . $estilo2 . '>
        <td colspan="2"><div align="center">
        <b>Datos personales</b></div></td>
      </tr>

      <tr>
        <td><strong>Documento</strong></td>
        <td align="right">' . $solicitud->cedula . '</td>
      </tr>
      <tr>
        <td><strong>Nombre</strong></td>
        <td align="right">' . $nombres . '</td>
      </tr>
      <tr>
        <td><strong>Email</strong></td>
        <td align="right">' . $solicitud->correo_personal . '</td>
      </tr>
      <tr>
        <td><strong>Celular</strong></td>
        <td align="right">' . $solicitud->celular . '</td>
      </tr>
      <tr>
        <td><strong>Tel&eacute;fono</strong></td>
        <td align="right">' . $solicitud->telefono . '</td>
      </tr>

      <tr class="fondo-gris" ' . $estilo2 . '>
        <td colspan="2"><div align="center">
        <b>Resumen de solicitud</b></div></td>
      </tr>       

      <tr>
        <td><strong>Solicitud</strong></td>
        <td align="right">WEB' . $numero . '</td>
      </tr>

      <tr>
        <td><strong>L&iacute;nea de cr&eacute;dito</strong></td>
        <td align="right">' . $lineas->codigo . ' - ' . $lineas->nombre . '&nbsp;</td>
      </tr>';


    $valida = array("NO", "SI");
    $valida[''] = "NO";
    $saldo = $solicitud->valor - $solicitud->valor_desembolso;

    $tabla .= '
      <tr>
        <td><strong>Valor solicitado</strong></td>
        <td align="right">$' . $this->formato_pesos($solicitud->valor) . '</td>
      </tr>
      <tr>';
    if ($solicitud->linea_desembolso == "LI") {
      $tabla .= '
        <td><strong>Recoge créditos?</strong></td>
        <td align="right">' . $valida[$solicitud->recoger_credito] . '</td>
      </tr>';
    }

    // if($solicitud->recoger_credito=="1"){
    //  $tabla.='
    //    <tr>
    //      <td><strong>Créditos recogidos</strong></td>
    //      <td align="right">'.$solicitud->numeros_recogidos.'</td>
    //    </tr>
    //    <tr>
    //      <td><strong>Total saldo recogidos</strong></td>
    //      <td align="right">$'.$this->formato_pesos($solicitud->valor_recogidos).'</td>
    //    </tr>';
    // }


    // if($solicitud->valor_fm>0){
    //   $tabla.='
    //   <tr>
    //     <td><strong>Valor fondo mutual</strong></td>
    //     <td align="right">$'.$this->formato_pesos($solicitud->valor_fm).'</td>
    //   </tr>';
    // }


    $tabla .= '
     
      <tr>
        <td><strong>N&uacute;mero de Cuotas</strong></td>
        <td align="right">' . $solicitud->cuotas . '</td>
      </tr>
      <tr>
        <td><strong>Valor aproximado de cuota</strong></td>
        <td align="right">$' . $this->formato_pesos($solicitud->valor_cuota) . '</td>
      </tr>';
    if ($solicitud->cuotas_extra_desembolso && $solicitud->valor_extra_desembolso) {
      $tabla .= ' <tr>
        <td><strong>Compromiso de primas</strong></td>
        <td align="right">' . $solicitud->cuotas_extra_desembolso . '</td>
      </tr>
        <tr>
        <td><strong>Valor compromiso de primas</strong></td>
        <td align="right">$' . $this->formato_pesos($solicitud->valor_extra_desembolso) . '</td>
      </tr>';
    }

    $tabla .= ' 

      <tr class="fondo-gris" ' . $estilo2 . '>
        <td colspan="2"><div align="center">
        <b>Condiciones otorgadas</b></div></td>
      </tr> 
<tr>
        <td><strong>Linea de crédito</strong></td>
        <td align="right">' . $lineas2->codigo . ' - ' . $lineas2->nombre . '&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Tasa mes vencido</strong></td>
        <td align="right">' . $solicitud->tasa_desembolso . '%</td>
      </tr>
      <tr>
        <td><strong>Garantía</strong></td>
        <td align="right">' . $garantias[$solicitud->tipo_garantia] . '</td>
      </tr>';
    if ($solicitud->garantia_adicional) {
      $tabla .= '
       <tr>
         <td><strong>Garantía Adicional</strong></td>
         <td align="right">' . $garantias[$solicitud->garantia_adicional] . '</td>
        </tr></table>';
    }




    return $tabla;
  }
  public function remplaceEC($x)
  {
    $x = str_replace(" ", "", $x);
    return $x;
  }
  public function validarSinTerminarAction()
  {
    $this->setLayout('blanco');
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    //$solicitudModel->editField("2307","confimar_solicitud",0);
    $fecha_actual = date("Y-m-d");
    $fecha_ini = '2022-02-02';
    $fechavalidacion = date("Y-m-d", strtotime($fecha_actual . "- 2 days"));
    $solicitudes_vencidas = $solicitudModel->getList("validacion='0' AND paso < 8  AND fecha <= '" . $fechavalidacion . "'", "");
    $hoy = date("Y-m-d H:i:s");
    //print_r($solicitudes_vencidas);
    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    foreach ($solicitudes_vencidas as $key => $value) {
      $numero = str_pad($value->id, 6, "0", STR_PAD_LEFT);
      $emailModel = new Core_Model_Mail();
      $asunto = "Novedad solicitud de crédito WEB " . $numero . " - Rechazada";
      $content = '
    <p>Buen día estimado(a) asociado(a), Me permito informarle que el estado de esta solicitud es anulada ya que por vigencia de tiempo (2 días) no se recibió la documentación requerida. <br><br> Cordial Saludo.';


      $email = $value->correo_personal;
      $asignado = $solicitud->asignado;
      $analista = $usuarioModel->getById($asignado);
      $correo1 = $analista->user_email;

      $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONKOBA");
      $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
      $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
      $emailModel->getMail()->addBCC("" . $correo1);
      $emailModel->getMail()->addAddress("" . $email);

      $emailModel->getMail()->Subject = $asunto;
      $emailModel->getMail()->msgHTML($content);
      $emailModel->getMail()->AltBody = $content;
      if ($emailModel->sed()) {
        $solicitudModel->editField($value->id, "validacion", 4);
        $solicitudModel->editField($value->id, "vencimiento_aplazado", 1);
        $logestado = new Administracion_Model_DbTable_Logestado();
        $dataestado["solicitud"] = $value->id;
        $dataestado["estado"] = "Rechazado(vencimiento)";
        $dataestado["usuario"] = "Asociado";
        $dataestado["fecha"] = $hoy;
        $texto_rechazado = "Rechazado por expiración de fecha";
        $id_estado = $logestado->insert($dataestado);
        $logestado->editField($id_estado, "observacion", $texto_rechazado);
      }
    }
  }
  public function validaraplazadosAction()
  {

    //2024-03-01 se empezo a guardar la hora de la fecha incompleta, para poder comparar la fecha y hora, dato que si un credito se aplaza, a la media noche de una vez se rechaza, dado que no tiene en cuenta la hora sino solo el dia. antes no pasaba nada porque el plazo era mayor a 24 horas

    $this->setLayout('blanco');
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    //$solicitudModel->editField("2307","confimar_solicitud",0);
    $fecha_actual = date("Y-m-d H:i:s");
    $fecha_ini = '2022-02-02';
    $fechavalidacion = date("Y-m-d H:i:s", strtotime($fecha_actual . "- 1 days"));
    $solicitudes_vencidas = $solicitudModel->getList("validacion='3' AND CONCAT(fecha_incompleta,' ',hora_incompleta) <= '" . $fechavalidacion . "' AND fecha_incompleta >= '" . $fecha_ini . "' AND vencimiento_aplazado='0' ", "");
    $hoy = date("Y-m-d H:i:s");
    //print_r($solicitudes_vencidas);
    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    foreach ($solicitudes_vencidas as $key => $value) {
      $numero = str_pad($value->id, 6, "0", STR_PAD_LEFT);
      $emailModel = new Core_Model_Mail();
      $asunto = "Novedad solicitud de crédito WEB " . $numero . " - Rechazada";
      $content = '
    <p>Buen día estimado(a) asociado(a), Me permito informarle que el estado de esta solicitud es anulada ya que por vigencia de tiempo (24 horas) no se recibió la documentación requerida. <br><br> Cordial Saludo.';


      $email = $value->correo_personal;
      $asignado = $solicitud->asignado;
      $analista = $usuarioModel->getById($asignado);
      $correo1 = $analista->user_email;

      $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONKOBA");
      $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
      $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
      $emailModel->getMail()->addBCC("" . $correo1);
      $emailModel->getMail()->addAddress("" . $email);

      $emailModel->getMail()->Subject = $asunto;
      $emailModel->getMail()->msgHTML($content);
      $emailModel->getMail()->AltBody = $content;
      if ($emailModel->sed()) {
        $solicitudModel->editField($value->id, "validacion", 4);
        $solicitudModel->editField($value->id, "vencimiento_aplazado", 1);
        $logestado = new Administracion_Model_DbTable_Logestado();
        $dataestado["solicitud"] = $value->id;
        $dataestado["estado"] = "Rechazado(vencimiento)";
        $dataestado["usuario"] = "Asociado";
        $dataestado["fecha"] = $hoy;
        $texto_rechazado = "Rechazado por expiración de fecha";
        $id_estado = $logestado->insert($dataestado);
        $logestado->editField($id_estado, "observacion", $texto_rechazado);
      }
    }
  }
  public function validaraprobadosAction()
  {
    $this->setLayout('blanco');
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();

    $fecha_actual = date("Y-m-d");
    $fecha_ini = '2022-02-03';
    $fechavalidacion = date("Y-m-d", strtotime($fecha_actual . "- 30 days"));
    $solicitudes_vencidas = $solicitudModel->getList("validacion=1 AND fecha_aprobado <= '" . $fechavalidacion . "' AND fecha_aprobado >= '" . $fecha_ini . "'  AND vencimiento_aprobado=0 AND (confimar_solicitud=0 || confimar_solicitud is NULL) AND (acepto_cambios=0 || acepto_cambios is NULL) ", "");
    $solicitudes_vencidas_confirmadas = $solicitudModel->getList("validacion=1 AND fecha_confirmar_solicitud < '" . $fechavalidacion . "' AND fecha_confirmar_solicitud >= '" . $fecha_ini . "'  AND vencimiento_aprobado=0 AND confimar_solicitud=1  ", "");
    $solicitudes_vencidas_cambios = $solicitudModel->getList("validacion=1 AND fecha_aceptacion < '" . $fechavalidacion . "' AND fecha_aceptacion >= '" . $fecha_ini . "'  AND vencimiento_aprobado=0 AND acepto_cambios=1  ", "");
    $hoy = date("Y-m-d H:i:s");
    //print_r($solicitudes_vencidas);
    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    foreach ($solicitudes_vencidas as $key => $value) {
      $numero = str_pad($value->id, 6, "0", STR_PAD_LEFT);
      $emailModel = new Core_Model_Mail();
      $asunto = "Novedad solicitud de crédito WEB " . $numero . " - Rechazada";
      $content = '
      <p>Buen día estimado(a) asociado(a), Me permito informarle que el estado de esta solicitud es anulada ya que por vigencia de tiempo (30 días) no se recibio la confirmación requerida. <br><br> Cordial Saludo.';


      $email = $value->correo_personal;
      $asignado = $solicitud->asignado;
      $analista = $usuarioModel->getById($asignado);
      $correo1 = $analista->user_email;

      $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONKOBA");
      $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
      $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
      $emailModel->getMail()->addBCC("" . $correo1);
      $emailModel->getMail()->addAddress("" . $email);

      $emailModel->getMail()->Subject = $asunto;
      $emailModel->getMail()->msgHTML($content);
      $emailModel->getMail()->AltBody = $content;
      if ($emailModel->sed()) {
        $solicitudModel->editField($value->id, "validacion", 4);
        $solicitudModel->editField($value->id, "vencimiento_aprobado", 1);
        $logestado = new Administracion_Model_DbTable_Logestado();
        $dataestado["solicitud"] = $value->id;
        $dataestado["estado"] = "Rechazado(vencimiento)";
        $dataestado["usuario"] = "Asociado";
        $dataestado["fecha"] = $hoy;
        $texto_rechazado = "Rechazado por expiración de fecha";
        $id_estado = $logestado->insert($dataestado);
        $logestado->editField($id_estado, "observacion", $texto_rechazado);
      }
    }
    foreach ($solicitudes_vencidas_confirmadas as $key => $value) {
      $numero = str_pad($value->id, 6, "0", STR_PAD_LEFT);
      $emailModel = new Core_Model_Mail();
      $asunto = "Novedad solicitud de crédito WEB " . $numero . " - Rechazada";
      $content = '
    <p>Buen día estimado(a) asociado(a), Me permito informarle que el estado de esta solicitud es anulada ya que por vigencia de tiempo (30 días) no se recibio la confirmación requerida. <br><br> Cordial Saludo.';


      $email = $value->correo_personal;
      $asignado = $solicitud->asignado;
      $analista = $usuarioModel->getById($asignado);
      $correo1 = $analista->user_email;

      $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONKOBA");
      $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
      $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
      $emailModel->getMail()->addBCC("" . $correo1);
      $emailModel->getMail()->addAddress("" . $email);

      $emailModel->getMail()->Subject = $asunto;
      $emailModel->getMail()->msgHTML($content);
      $emailModel->getMail()->AltBody = $content;
      if ($emailModel->sed()) {
        $solicitudModel->editField($value->id, "validacion", 4);
        $solicitudModel->editField($value->id, "vencimiento_aprobado", 1);
        $logestado = new Administracion_Model_DbTable_Logestado();
        $dataestado["solicitud"] = $value->id;
        $dataestado["estado"] = "Rechazado(vencimiento)";
        $dataestado["usuario"] = "Asociado";
        $dataestado["fecha"] = $hoy;
        $texto_rechazado = "Rechazado por expiración de fecha";
        $id_estado = $logestado->insert($dataestado);
        $logestado->editField($id_estado, "observacion", $texto_rechazado);
      }
    }
    foreach ($solicitudes_vencidas_cambios as $key => $value) {
      $numero = str_pad($value->id, 6, "0", STR_PAD_LEFT);
      $emailModel = new Core_Model_Mail();
      $asunto = "Novedad solicitud de crédito WEB " . $numero . " - Rechazada";
      $content = '
    <p>Buen día estimado(a) asociado(a), Me permito informarle que el estado de esta solicitud es anulada ya que por vigencia de tiempo (30 días) no se recibio la confirmación requerida. <br><br> Cordial Saludo.';


      $email = $value->correo_personal;
      $asignado = $solicitud->asignado;
      $analista = $usuarioModel->getById($asignado);
      $correo1 = $analista->user_email;

      $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONKOBA");
      $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
      $emailModel->getMail()->addBCC("notificaciones@fondtodos.com");
      $emailModel->getMail()->addBCC("" . $correo1);
      $emailModel->getMail()->addAddress("" . $email);

      $emailModel->getMail()->Subject = $asunto;
      $emailModel->getMail()->msgHTML($content);
      $emailModel->getMail()->AltBody = $content;
      if ($emailModel->sed()) {
        $solicitudModel->editField($value->id, "validacion", "4");
        $solicitudModel->editField($value->id, "vencimiento_aprobado", 1);
        $logestado = new Administracion_Model_DbTable_Logestado();
        $dataestado["solicitud"] = $value->id;
        $dataestado["estado"] = "Rechazado(vencimiento)";
        $dataestado["usuario"] = "Asociado";
        $dataestado["fecha"] = $hoy;
        $texto_rechazado = "Rechazado por expiración de fecha";
        $id_estado = $logestado->insert($dataestado);
        $logestado->editField($id_estado, "observacion", $texto_rechazado);
      }
    }
  }
  public function cartacompromisoAction()
  {
    $this->_view->seccion = 1;
    $this->_view->contenidos = $this->template->getContent(1);
    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    $this->getLayout()->setData("header", $header);
    if ($this->_getSanitizedParam('layout') == 'blanco') {
      $this->setLayout('blanco');
    }
    $id = $this->_getSanitizedParam("id");
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $this->_view->solicitud = $solicitud = $solicitudModel->getById($id);
    $cartaModel = new Administracion_Model_DbTable_Cartacompromiso();
    $obligacionModel = new Administracion_Model_DbTable_Obligaciones();
    $this->_view->carta = $carta = $cartaModel->getList("solicitud=$id")[0];
    $this->_view->obligaciones = $obligaciones = $obligacionModel->getList("id_carta=$carta->id");
    //print_r($obligaciones);


  }
  function getRealIP()
  {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
      return $_SERVER['HTTP_CLIENT_IP'];

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
      return $_SERVER['HTTP_X_FORWARDED_FOR'];

    return $_SERVER['REMOTE_ADDR'];
  }

  public function guardaridsesionAction()
  {
    $_SESSION['id_solicitud'] = $_GET['id'];
    header("location: /page/sistema?id=" . $_SESSION['id_solicitud']);
  }
  public function paso1pdfAction()
  {
    $this->_view->get_monto = $this->_getSanitizedParam("monto");
    $this->_view->seccion = 1;
    $this->setLayout('blanco');
    $this->_view->contenidos = $this->template->getContent(1);
    $mod = $this->_getSanitizedParam("mod");
    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    $this->getLayout()->setData("header", $header);
    $id = $this->_getSanitizedParam("id");
    if ($_SESSION['id_solicitud']) {
      $id = $_SESSION['id_solicitud'];
    }

    //echo $_SESSION['id_solicitud'];
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);

    $bancosModel = new Administracion_Model_DbTable_Bancos();
    $this->_view->bancos = $bancosModel->getList("", " nombre ASC ");

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $this->_view->get_solicitud = $solicitud = $solicitudModel->getById($id);
    $lineas2 = $solicitud->linea;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $this->_view->lineas2 = $lineaModel->getList(" codigo='$lineas2' ", "")[0];

    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $usrId = $_SESSION['kt_login_id'];
    if ($_SESSION['kt_login_level'] != '2') {
      $usuariosModel = new Administracion_Model_DbTable_Usuario();
      $usr = $usuariosModel->getList("user_user = '" . $solicitud->documento . "'", "")[0];
      $usrId = $usr->user_id;
    }
    $user = $usuarioModel->getList("user_id = '$usrId'", "");
    // $user = $usuarioModel->getList($_SESSION['kt_login_id']);
    $usuariosinfoModel = new Administracion_Model_DbTable_Usuariosinfo();
    $this->_view->infoUser = $usuariosinfoModel->getList("documento = '" . $user[0]->user_user . "'", "")[0];
    $referenciasFamiliaresModel = new Administracion_Model_DbTable_Referencias();
    $this->_view->refFamiliares = $referenciasFamiliaresModel->getList("solicitud = '$id' AND nombres != ''", "");
    $ciudadesModel = new Administracion_Model_DbTable_Ciudad();
    $ciudades = $ciudadesModel->getList("", " nombre ASC ");
    $city = array();
    foreach ($ciudades as $ciudad) {
      $city[$ciudad->codigo] = $ciudad->nombre . ' - ' . $ciudad->departamento;
    }
    $this->_view->ciudadesUser = $city;
    $codeudorModel = new Administracion_Model_DbTable_Codeudor();
    $this->_view->codeudor = $codeudorModel->getList("solicitud = '$id'", "")[0];

    $nomenclaturaModel = new Administracion_Model_DbTable_Nomenclatura();
    $this->_view->nomenclaturas = $nomenclaturas = $nomenclaturaModel->getList("", " codigo ASC ");

    $ciudadModel = new Administracion_Model_DbTable_Ciudad();
    $this->_view->ciudades = $ciudadModel->getList("", " nombre ASC ");

    $regionalModel = new Administracion_Model_DbTable_Regional();
    $this->_view->regionales = $regionalModel->getList("", "");

    $pagareModel = new Administracion_Model_DbTable_Pagares();
    $this->_view->pagares = $pagares = $pagareModel->getList2("pagare_deceval.pagare = '$id'", "")[0];
    //parametros
    $aux = explode(" ", $user[0]->user_names);
    $this->_view->apellido1 = $aux[2];
    $this->_view->apellido2 = $aux[3];
    $this->_view->nombres = $aux[0];
    $this->_view->nombres2 = $aux[1];
    $this->_view->direccion_residencia = $user->direccion;
    $this->_view->telefono = $user->telefono;
    $this->_view->barrio = $user->barrio;
    $this->_view->ciudad_residencia = $user->ciudad_residencia;
    $this->_view->correo_empresarial = $user->correo;
    $this->_view->correo_personal = $user->correo;
    $this->_view->fecha_nacimiento = $user->fecha_nacimiento;
    $this->_view->celular = $user->celular;
    $this->_view->ciudad_documento = $user->ciudad_documento;

    $cedula = $_SESSION['kt_login_user'];
    $cedula = $solicitud->cedula;
    if ($this->_getSanitizedParam("usuario") != "") {
      $cedula = $this->_getSanitizedParam("usuario");
    }
    if ($this->_getSanitizedParam("paso") == "4") {
      $cedula = $codeudor->cedula;
    }

    $this->_view->documento = $cedula;

    /*
    $ultima = $solicitudModel->getList(" cedula='$cedula' AND paso='8' "," id DESC ")[0];

    if($ultima->nombres!=""){
      $this->_view->nombres = $ultima->nombres;
    }
    if($ultima->apellido1!=""){
      $this->_view->apellido1 = $ultima->apellido1;
    }
    if($ultima->apellido2!=""){
      $this->_view->apellido2 = $ultima->apellido2;
    }
    if($ultima->sexo!=""){
      $this->_view->sexo = $ultima->sexo;
    }
    if($ultima->direccion_residencia!=""){
      $this->_view->direccion_residencia = $ultima->direccion_residencia;
    }
    if($ultima->telefono!=""){
      $this->_view->telefono = $ultima->telefono;
    }
    if($ultima->barrio!=""){
      $this->_view->barrio = $ultima->barrio;
    }
    if($ultima->ciudad_residencia!=""){
      $this->_view->ciudad_residencia = $ultima->ciudad_residencia;
    }
    if($ultima->correo_empresarial!=""){
      $this->_view->correo_empresarial = $ultima->correo_empresarial;
    }
    if($ultima->correo_personal!=""){
      $this->_view->correo_personal = $ultima->correo_personal;
    }
    if($ultima->tipo_documento!=""){
      $this->_view->tipo_documento = $ultima->tipo_documento;
    }
    if($ultima->empresa!=""){
      $this->_view->empresa = $ultima->empresa;
    }
    if($ultima->dependencia!=""){
      $this->_view->dependencia = $ultima->dependencia;
    }
    if($ultima->direccion_oficina!=""){
      $this->_view->direccion_oficina = $ultima->direccion_oficina;
    }
    if($ultima->telefono_oficina!=""){
      $this->_view->telefono_oficina = $ultima->telefono_oficina;
    }
    if($ultima->situacion_laboral!=""){
      $this->_view->situacion_laboral = $ultima->situacion_laboral;
    }
    if($ultima->cual!=""){
      $this->_view->cual = $ultima->cual;
    }
    if($ultima->declara_renta!=""){
      $this->_view->declara_renta = $ultima->declara_renta;
    }
    if($ultima->persona_publica!=""){
      $this->_view->persona_publica = $ultima->persona_publica;
    }
    if($ultima->fecha_nacimiento!=""){
      $this->_view->fecha_nacimiento = $ultima->fecha_nacimiento;
    }
    if($ultima->fecha_documento!=""){
      $this->_view->fecha_documento = $ultima->fecha_documento;
    }
    if($ultima->celular!=""){
      $this->_view->celular = $ultima->celular;
    }
    if($ultima->ciudad_oficina!=""){
      $this->_view->ciudad_oficina = $ultima->ciudad_oficina;
    }
    if($ultima->ciudad_documento!=""){
      $this->_view->ciudad_documento = $ultima->ciudad_documento;
    }
    if($ultima->cuenta_numero!=""){
      $this->_view->cuenta_numero = $ultima->cuenta_numero;
    }
    if($ultima->cuenta_tipo!=""){
      $this->_view->cuenta_tipo = $ultima->cuenta_tipo;
    }
    if($ultima->entidad_bancaria!=""){
      $this->_view->entidad_bancaria = $ultima->entidad_bancaria;
    }
    if($ultima->ocupacion!=""){
      $this->_view->ocupacion = $ultima->ocupacion;
    }
    if($ultima->estado_civil!=""){
      $this->_view->estado_civil = $ultima->estado_civil;
    }
    if($ultima->peso!=""){
      $this->_view->peso = $ultima->peso;
    }
    if($ultima->estatura!=""){
      $this->_view->estatura = $ultima->estatura;
    }
    if($ultima->conyuge_nombre!=""){
      $this->_view->conyuge_nombre = $ultima->conyuge_nombre;
    }
    if($ultima->conyuge_telefono!=""){
      $this->_view->conyuge_telefono = $ultima->conyuge_telefono;
    }
    if($ultima->conyuge_celular!=""){
      $this->_view->conyuge_celular = $ultima->conyuge_celular;
    }
    if($ultima->tipo_vivienda!=""){
      $this->_view->tipo_vivienda = $ultima->tipo_vivienda;
    }
    if($ultima->fecha_ingreso!=""){
      $this->_view->fecha_ingreso = $ultima->fecha_ingreso;
    }
    if($ultima->cargo!=""){
      $this->_view->cargo = $ultima->cargo;
    }
    if($ultima->fecha_afiliacion!=""){
      $this->_view->fecha_afiliacion = $ultima->fecha_afiliacion;
    }
    if($ultima->personas_cargo!=""){
      $this->_view->personas_cargo = $ultima->personas_cargo;
    }
    if($ultima->numero_hijos!=""){
      $this->_view->numero_hijos = $ultima->numero_hijos;
    }
    if($ultima->nomenclatura1!=""){
      $this->_view->nomenclatura1 = $ultima->nomenclatura1;
    }
    if($ultima->nomenclatura2!=""){
      $this->_view->nomenclatura2 = $ultima->nomenclatura2;
    }
    */

    $this->_view->edad = $this->calculaedad($solicitud->fecha_nacimiento);
    // if ($solicitud->nombres != "") {
    //   $this->_view->nombres = $solicitud->nombres;
    // }
    // if ($solicitud->apellido1 != "") {
    //   $this->_view->apellido1 = $solicitud->apellido1;
    // }
    // if ($solicitud->apellido2 != "") {
    //   $this->_view->apellido2 = $solicitud->apellido2;
    // }
    if ($solicitud->sexo != "") {
      $this->_view->sexo = $solicitud->sexo;
    }
    if ($solicitud->direccion_residencia != "") {
      $this->_view->direccion_residencia = $solicitud->direccion_residencia;
    }
    if ($solicitud->telefono != "") {
      $this->_view->telefono = $solicitud->telefono;
    }
    if ($solicitud->barrio != "") {
      $this->_view->barrio = $solicitud->barrio;
    }
    if ($solicitud->ciudad_residencia != "") {
      $this->_view->ciudad_residencia = $solicitud->ciudad_residencia;
    }
    if ($solicitud->correo_empresarial != "") {
      $this->_view->correo_empresarial = $solicitud->correo_empresarial;
    }
    if ($solicitud->correo_personal != "") {
      $this->_view->correo_personal = $solicitud->correo_personal;
    }
    if ($solicitud->tipo_documento != "") {
      $this->_view->tipo_documento = $solicitud->tipo_documento;
    }
    if ($solicitud->empresa != "") {
      $this->_view->empresa = $solicitud->empresa;
    }
    if ($solicitud->dependencia != "") {
      $this->_view->dependencia = $solicitud->dependencia;
    }
    if ($solicitud->direccion_oficina != "") {
      $this->_view->direccion_oficina = $solicitud->direccion_oficina;
    }
    if ($solicitud->telefono_oficina != "") {
      $this->_view->telefono_oficina = $solicitud->telefono_oficina;
    }
    if ($solicitud->situacion_laboral != "") {
      $this->_view->situacion_laboral = $solicitud->situacion_laboral;
    }
    if ($solicitud->cual != "") {
      $this->_view->cual = $solicitud->cual;
    }
    if ($solicitud->declara_renta != "") {
      $this->_view->declara_renta = $solicitud->declara_renta;
    }
    if ($solicitud->persona_publica != "") {
      $this->_view->persona_publica = $solicitud->persona_publica;
    }
    if ($solicitud->persona_expuesta != "") {
      $this->_view->persona_expuesta = $solicitud->persona_expuesta;
    }
    if ($solicitud->persona_expuesta_indique != "") {
      $this->_view->persona_expuesta_indique = $solicitud->persona_expuesta_indique;
    }
    if ($solicitud->persona_publica_indique != "") {
      $this->_view->persona_publica_indique = $solicitud->persona_publica_indique;
    }
    if ($solicitud->persona_internacional != "") {
      $this->_view->persona_internacional = $solicitud->persona_internacional;
    }
    if ($solicitud->persona_internacional_indique != "") {
      $this->_view->persona_internacional_indique = $solicitud->persona_internacional_indique;
    }
    if ($solicitud->vinculo_pep != "") {
      $this->_view->vinculo_pep = $solicitud->vinculo_pep;
    }
    if ($solicitud->vinculo_pep_indique != "") {
      $this->_view->vinculo_pep_indique = $solicitud->vinculo_pep_indique;
    }
    if ($solicitud->obligaciones_tributarias != "") {
      $this->_view->obligaciones_tributarias = $solicitud->obligaciones_tributarias;
    }
    if ($solicitud->obligaciones_tributarias_indique != "") {
      $this->_view->obligaciones_tributarias_indique = $solicitud->obligaciones_tributarias_indique;
    }
    if ($solicitud->fecha_nacimiento != "") {
      $fecha_ingreso = date("Y-m-d", strtotime($solicitud->fecha_nacimiento));
      $this->_view->fecha_nacimiento = $fecha_ingreso;
    }
    if ($solicitud->fecha_documento != "") {
      $this->_view->fecha_documento = $solicitud->fecha_documento;
    }
    if ($solicitud->celular != "") {
      $this->_view->celular = $solicitud->celular;
    }
    if ($solicitud->ciudad_oficina != "") {
      $this->_view->ciudad_oficina = $solicitud->ciudad_oficina;
    }
    if ($solicitud->ciudad_documento != "") {
      $this->_view->ciudad_documento = $solicitud->ciudad_documento;
    }
    if ($solicitud->cuenta_numero != "") {
      $this->_view->cuenta_numero = $solicitud->cuenta_numero;
    }
    if ($solicitud->cuenta_tipo != "") {
      $this->_view->cuenta_tipo = $solicitud->cuenta_tipo;
    }
    if ($solicitud->entidad_bancaria != "") {
      $this->_view->entidad_bancaria = $solicitud->entidad_bancaria;
    }
    if ($solicitud->ocupacion != "") {
      $this->_view->ocupacion = $solicitud->ocupacion;
    }
    if ($solicitud->estado_civil != "") {
      $this->_view->estado_civil = $solicitud->estado_civil;
    }
    if ($solicitud->peso != "") {
      $this->_view->peso = $solicitud->peso;
    }
    if ($solicitud->estatura != "") {
      $this->_view->estatura = $solicitud->estatura;
    }
    if ($solicitud->conyuge_nombre != "") {
      $this->_view->conyuge_nombre = $solicitud->conyuge_nombre;
    }
    if ($solicitud->conyuge_telefono != "") {
      $this->_view->conyuge_telefono = $solicitud->conyuge_telefono;
    }
    if ($solicitud->conyuge_celular != "") {
      $this->_view->conyuge_celular = $solicitud->conyuge_celular;
    }
    if ($solicitud->tipo_vivienda != "") {
      $this->_view->tipo_vivienda = $solicitud->tipo_vivienda;
    }
    if ($solicitud->regional != "") {
      $this->_view->regional = $solicitud->regional;
    }
    if ($solicitud->origen_ingresos != "") {
      $this->_view->origen_ingresos = $solicitud->origen_ingresos;
    }
    if ($solicitud->ciiu != "") {
      $this->_view->ciiu = $solicitud->ciiu;
    }
    if ($solicitud->estrato != "") {
      $this->_view->estrato = $solicitud->estrato;
    }
    if ($solicitud->fecha_ingreso != "") {
      $fecha_ingreso = date("Y-m-d", strtotime($usuariosinfo->fecha_ingreso));
      $this->_view->fecha_ingreso = $solicitud->fecha_ingreso;
    }
    if ($solicitud->cargo != "") {
      $this->_view->cargo = $solicitud->cargo;
    }
    if ($solicitud->fecha_afiliacion != "") {
      $this->_view->fecha_afiliacion = $solicitud->fecha_afiliacion;
    }
    if ($solicitud->personas_cargo != "") {
      $this->_view->personas_cargo = $solicitud->personas_cargo;
    }
    if ($solicitud->numero_hijos != "") {
      $this->_view->numero_hijos = $solicitud->numero_hijos;
    }
    if ($solicitud->nomenclatura1 != "") {
      $this->_view->nomenclatura1 = $solicitud->nomenclatura1;
    }
    if ($solicitud->nomenclatura2 != "") {
      $this->_view->nomenclatura2 = $solicitud->nomenclatura2;
    }
    if ($solicitud->nivel_escolaridad != "") {
      $this->_view->nivel_escolaridad = $solicitud->nivel_escolaridad;
    }
    //parametros



  }
  function calculaedad($fechanacimiento)
  {
    list($ano, $mes, $dia) = explode("-", $fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
      $ano_diferencia--;
    return $ano_diferencia;
  }

  public function deleterequestAction()
  {
    $id = $this->_getSanitizedParam('id');

    $log_eliminadas = new Administracion_Model_DbTable_Solicitudeseliminadas();
    $solicitudesModel = new Administracion_Model_DbTable_Solicitudes();

    $log_data = array();
    $log_data['solicitud_solicitud'] = $id;
    $log_data['solicitud_usuario'] = $_SESSION['kt_login_id'];
    $log_data['solicitud_fecha_eliminacion'] = date('Y-m-d H:i:s');
    // $log_data['solicitud_datos'] = print_r($solicitudesModel->getById($id));
    $log_eliminadas->insert($log_data);

    $logModel = new Administracion_Model_DbTable_Logestado();
    $logModel->delete("solicitud = $id");
    $solicitudesModel->deleteRegister($id);
    die(json_encode(array('status' => 'success')));
  }
  public function viewUserInfoAction()
  {
    //hash = 5b485cf3bf0b0ffc9823e88a8ae858a6
    $hash = md5('Omega.2023');
    $get_hash = $this->_getSanitizedParam('hash');
    if ($hash != $get_hash) {
      die('No tiene permisos para ver esta información');
    }
    $this->setLayout('blanco');
    $cedula = $_SESSION['kt_login_user'];
    echo 'Cedula: ' . $cedula . '<br>';
    $flag_afiliacion = true;
    $flag_libre_inversion = true;
    $usuarioinfo = new Administracion_Model_DbTable_Usuariosinfo();
    $usuarios_info = $usuarioinfo->getList("documento = '$cedula'", "")[0];
    $fecha_afiliacion = $usuarios_info->fecha_afiliacion;
    $fecha_afiliacion_koba = $usuarios_info->fecha_afiliacion_koba;
    $hoy = date("Y-m-d");
    $fecha_min_2m = date("Y-m-d", strtotime($hoy . " -2 months"));
    $fecha_min_6m = date("Y-m-d", strtotime($hoy . " -6 months"));
    $fecha_min_3m = date("Y-m-d", strtotime($hoy . " -3 months"));
    $fecha_min_12m = date("Y-m-d", strtotime($hoy . " -12 months"));
    $fecha_min_24m = date("Y-m-d", strtotime($hoy . " -24 months"));
    $fecha_min_36m = date("Y-m-d", strtotime($hoy . " -36 months"));

    echo 'Fecha de afiliacion: ' . $fecha_afiliacion . '<br>';
    echo 'Fecha de afiliacion koba: ' . $fecha_afiliacion_koba . '<br>';
    echo 'Fecha de hoy: ' . $hoy . '<br>';
    echo 'Fecha de hoy - 2 meses: ' . $fecha_min_2m . '<br>';
    echo 'Fecha de hoy - 6 meses: ' . $fecha_min_6m . '<br>';
    echo 'Fecha de hoy - 3 meses: ' . $fecha_min_3m . '<br>';
    echo 'Fecha de hoy - 12 meses: ' . $fecha_min_12m . '<br>';
    echo 'Fecha de hoy - 24 meses: ' . $fecha_min_24m . '<br>';
    echo 'Fecha de hoy - 36 meses: ' . $fecha_min_36m . '<br>';


    $saldosModel = new Page_Model_DbTable_Saldos();
    $saldo_vivienda = $saldosModel->getList(" estadocuenta_saldos_linea = 'VIVIENDA  60 MESES' AND estadocuenta_saldos_cedula='$cedula' ", "");

    echo '<pre> Saldo vivienda: ';
    print_r($saldo_vivienda);
    echo '</pre>';

    $cedulasModel = new Administracion_Model_DbTable_Cedulas();
    $infousuariosModel = new Administracion_Model_DbTable_Usuariosinfo();
    $usuarioinfo = $infousuariosModel->getById($cedula);
    $nomina_list = $cedulasModel->getList(" cedula='$cedula' ", "");

    echo '<pre> Info Usuario: ';
    print_r($usuarioinfo);
    echo '</pre>';

    //$cupo_actual = $cupos_list[0]->cupo*1;
    $salario = $usuarioinfo->salario;

    echo 'Salario: ' . $salario . '<br>';

    $ahorrosModel = new Administracion_Model_DbTable_Ahorrosaportes();
    $ahorros_list = $ahorrosModel->getList("cedula='$cedula' ", "")[0];
    $ahorros = $ahorros_list->ahorros;
    $aportes = $ahorros_list->aportes;
    $ahorrosvol = $ahorros_list->ahorrosvol;
    $ahorrototal = $ahorros_list->ahorrosvol + $ahorros_list->ahorros;

    $configModel = new Administracion_Model_DbTable_Config();
    $config_list = $configModel->getList("", "");
    $smlv = $config_list[0]->salario_minimo;
    //$aportes = 0; //aportes sociales y ahorro permantente

    echo 'Ahorros: ' . $ahorros . '<br>';
    echo 'Aportes: ' . $aportes . '<br>';
    echo 'Ahorros voluntarios: ' . $ahorrosvol . '<br>';
    echo 'Total: ' . $ahorrototal . '<br>';

    $saldosModel = new Page_Model_DbTable_Saldos();


    //cupo max
    $saldos_list = $saldosModel->getList("  estadocuenta_saldos_cedula='$cedula' ", "");
    $saldos = 0;
    foreach ($saldos_list as $key => $value) {
      $saldos += $value->estadocuenta_saldos_stotal;
    }
    echo 'Saldos: ' . $saldos;
  }
  public function filtrolineaadminAction()
  {
    header('Content-Type:application/json');
    $this->setLayout('blanco');

    $linea = $this->_getSanitizedParam("linea");
    $solicitud = $this->_getSanitizedParam("solicitud");
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];

    $res .= $lineas->requisitos;
    $respuesta['valores'] = $res;


    //CALCULAR CUPOS
    $cedula = $_SESSION['kt_login_user'];

    $cedulasModel = new Administracion_Model_DbTable_Cedulas();
    $infousuariosModel = new Administracion_Model_DbTable_Usuariosinfo();

    $linea_id = $lineas->id;

    $linea_list = $lineaModel->getById($linea_id);
    $linea = $linea_list->codigo;
    $this->_view->tasa_nominal = $linea_list->efectivo_anual;
    $respuesta['tasa_nominal'] = $linea_list->efectivo_anual;

    $this->_view->cupo_actual = $cupo_actual;
    $this->_view->saldo_actual = $saldo_actual;
    $this->_view->valor_disponible = $valor_disponible;
    $respuesta['cupo_actual'] = $this->formato_pesos($cupo_actual);
    $respuesta['saldo_actual'] = $saldo_actual;
    $respuesta['saldo_actual1'] = $this->formato_pesos($saldo_actual);
    $respuesta['valor_disponible'] = $this->formato_pesos($valor_disponible);

    //PARAMETROS
    $min = 1;
    $max = 36;

    $max_meses = $linea_list->max_meses;
    $min_meses = $linea_list->min_meses;
    if ($config_list[0]->cuota_min != "") {
      $min = $config_list[0]->cuota_min;
    }
    if ($config_list[0]->cuota_max != "") {
      $max = $config_list[0]->cuota_max;
    }
    if ($min_meses > 0) {
      $min = $min_meses;
    }
    if ($max_meses > 0) {
      $max = $max_meses;
    }
    $this->_view->min = $min;
    $this->_view->max = $max;

    $this->_view->valor_min = $valor_min = $config_list[0]->valor_min * 0;
    $this->_view->valor_max = $valor_max = $config_list[0]->valor_max;

    $respuesta['min'] = $min;
    $respuesta['max'] = $max;
    $respuesta['valor_min'] = $valor_min;
    $respuesta['valor_max'] = $valor_max;

    $cuotas = $this->_getSanitizedParam("cuotas");
    $menu_cuotas = '';
    for ($i = $min; $i <= $max; $i++) {
      $seleccionado = '';
      if ($cuotas == $i) {
        $seleccionado = ' selected ';
      }
      $menu_cuotas .= '<option value="' . $i . '" ' . $seleccionado . ' >' . $i . '</option>';
    }
    if ($linea_id) {
    }
    $respuesta['menu_cuotas'] = $menu_cuotas;

    $valor1 = $this->_getSanitizedParam("valor");
    if ($valor1 == "") {
      $valor1 = $this->formato_pesos($valor_min);
    }
    $valor = str_replace(".", "", $valor1);
    $this->_view->valor1 = $valor1;
    $this->_view->valor = $valor;
    $respuesta['valor1'] = $valor1;
    $respuesta['valor'] = $valor;

    $monto_solicitado = $this->_getSanitizedParam("monto_solicitado");
    $this->_view->monto_solicitado = $monto_solicitado;
    $respuesta['monto_solicitado'] = $monto_solicitado;

    $monto_aux = $monto_solicitado;

    $cuotas = $this->_getSanitizedParam("cuotas");
    $this->_view->n = $cuotas;
    $respuesta['n'] = $cuotas;
    $rangosModel = new Administracion_Model_DbTable_Rangos();



    $abonos = $this->_getSanitizedParam("abonos");
    $this->_view->abonos = $abonos;
    $respuesta['abonos'] = $abonos;

    $extra = $this->_getSanitizedParam("extra");
    $this->_view->extra = $extra;
    $respuesta['extra'] = $extra;

    $tasa = $linea_list->tasa_real;
    $tasa_nominal = $linea_list->efectivo_anual;
    //$tasa = $tasa_nominal/12;

    // rango cuotas
    if ($linea == "LI") {
      $rango = $rangosModel->getList("rango_codigo=2", "");
      foreach ($rango as $key => $item) {
        if ($cuotas >= $item->rango_min && $cuotas <= $item->rango_max) {
          $tasa = $item->rango_tasa_mensual;
          $respuesta['tasa_nominal'] = $item->rango_tasa_anual;
          break;
        }
      }
    }


    $solicitud_model = new Administracion_Model_DbTable_Solicitudes();

    $soli = $solicitud_model->getById($solicitud);

    $fecha_soli = date("Y-m-d", strtotime($soli->fecha));

    $date_last = date("Y-m-d", strtotime("2023-02-07"));
    if( $fecha_soli < $date_last ){
      if($linea == "LI"){
        if($cuotas >= 1 && $cuotas <= 24){
          $tasa = 1.20;
        }else if($cuotas >= 25 && $cuotas <= 36){
          $tasa = 1.30;
        }else if($cuotas >= 37 && $cuotas <= 60){
          $tasa = 1.50;
        }
      }else if($linea == "CC" || $linea == "CCC"){
        if($cuotas >= 1 && $cuotas <= 24){
          $tasa = 0.9;
        }else if($cuotas >= 25 && $cuotas <= 36){
          $tasa = 0.99;
        }else if($cuotas >= 37 && $cuotas <= 60){
          $tasa = 1.25;
        }
      }
    }
    
    $this->_view->tasa = $tasa;
    $respuesta['tasa'] = $tasa;


    $destino = $this->_getSanitizedParam("destino");
    $this->_view->destino = $destino;
    $respuesta['destino'] = $destino;
    //PARAMETROS


    //CALCULAR CUOTA

    //CUOTAS EXTRA
    $cuotaextra = str_replace('.', '', $extra);
    $abono_extra = $abonos;
    $i = $tasa / 100;

    //calcular valor presente cuotas
    $anio = date('Y');
    $hoy = date("Y-m-d");
    if ($hoy <= $anio . '-06-30') {
      $meses = 6 - date('m');
    } else {
      $meses = 12 - date('m');
    }
    $fecha_final = date("Y-m-d", strtotime($hoy . "+ " . $cuotas . " month"));
    $start = $month = strtotime($hoy);
    $end = strtotime($fecha_final);
    $presente = 0;
    $array = array();
    $respuesta['mesinicio'] = $start;
    while ($month < $end) {
      $meses = date('m', $month);
      $m = $meses * 1;
      if ($abonos == "Junio" && $meses == 06) {
        $p = 1 + ($i);
        $p = pow($p, -1 * $m);
        $p = $p * $cuotaextra;
        $presente = $presente + $p;
      }
      if ($abonos == "Diciembre" && $meses == 12) {
        $p = 1 + ($i);
        $p = pow($p, -1 * $m);
        $p = $p * $cuotaextra;
        $presente = $presente + $p;
      }
      if ($abonos == "Junio y Diciembre" && ($meses == 12 || $meses == 06)) {
        $p = 1 + ($i);
        $p = pow($p, -1 * $m);
        $p = $p * $cuotaextra;
        $presente = $presente + $p;
      }
      $month = strtotime("+1 month", $month);
    }
    $respuesta['mesespr'] = $array;
    //calcular valor presente cuotas

    //CUOTAS EXTRA

    $i = $tasa / 100;
    $k1 = $valor - $presente; // prestamo
    $n = $max_meses;
    if ($cuotas != "") {
      $n = $cuotas; //cuotas
    }
    $r = $k1 * $i;
    $factor_seguro = 0.26 / 1000;
    $r1 = 1 - pow((1 + $i + $factor_seguro), (-1 * $n));
    if ($r1 > 0) {
      $r = round($k1 * (($i + $factor_seguro) / $r1), 0);
    }
    if ($i == 0) {
      if ($linea = "CDU") {
        $k1 = $k1 + 8800;
      }
      $r = $k1 / $n;
    }

    $hoy = date("Y") . "-" . date("m") . "-" . date("d");
    $diahoy = date("d");

    $this->_view->r = $r;
    $this->_view->numerocuotasextra = $numerocuotasextra;
    $this->_view->cuotaextra = $cuotaextra;
    $respuesta['r'] = $r;
    $respuesta['r2'] = number_format($r, 0, ',', '.');
    $respuesta['r1'] = number_format($r);

    $respuesta['numerocuotasextra'] = $numerocuotasextra;
    $respuesta['numerocuotasextra2'] = $numerocuotasextra2;
    $respuesta['cuotaextra'] = $cuotaextra;
    //CALCULAR CUOTA

    $hoy = date("Y-m-d");
    $diahoy = date("d");
    $k = $monto_aux;
    $interes = $k * $i;
    //$seguro = $k*0.35/1000;
    //$seguro = 0;
    $abono = $r - $interes;
    $saldo = $k;
    if ($linea == "AP") {
      $tasa_diaria = (pow(1 + $i, 1 / 30)) - 1;
      $ultimo = $this->UltimoDia(date("Y"), date("m"));
      $fecha1 = date("Y-m-") . $ultimo;

      $fecha_ultimo = "2021-06-30";
      if ($hoy >= "2021-06-01") {
        $fecha_ultimo = "2021-12-31";
      }

      $date1 = new Datetime($fecha1);
      $date2 = new Datetime($fecha_ultimo);
      $diff = $date1->diff($date2);
      $dias_intereses3 = $diff->days;
      $meses1 = floor($dias_intereses3 / 30);
      $dias_intereses3 = $meses1 * 30;
      $interes = $monto_aux * ((pow(1 + $tasa_diaria, $dias_intereses3)) - 1);
      $r = $monto_aux + $interes;
    }

    echo json_encode($respuesta);
  }




    public function get_meses(){
      $array['01'] = "Ene";
      $array['02'] = "Feb";
      $array['03'] = "Mar";
      $array['04'] = "Abr";
      $array['05'] = "May";
      $array['06'] = "Jun";
      $array['07'] = "Jul";
      $array['08'] = "Ago";
      $array['09'] = "Sep";
      $array['10'] = "Oct";
      $array['11'] = "Nov";
      $array['12'] = "Dic";
      return $array;
    }

    public function get_meses_completos(){
      $array['01'] = "Enero";
      $array['02'] = "Febrero";
      $array['03'] = "Marzo";
      $array['04'] = "Abril";
      $array['05'] = "Mayo";
      $array['06'] = "Junio";
      $array['07'] = "Julio";
      $array['08'] = "Agosto";
      $array['09'] = "Septiembre";
      $array['10'] = "Octubre";
      $array['11'] = "Noviembre";
      $array['12'] = "Diciembre";
      return $array;
    }

    public function generarAction(){
      $tipo = $this->_getSanitizedParam("tipo");
      $cedula = $_SESSION['kt_login_user'];

      if($tipo=="1"){
        $this->generar_pdf_deuda();
      }
      if($tipo=="2"){
        $this->generar_pdf_ahorros();
      } 
      if($tipo=="3"){
        $this->setLayout('blanco');
        header('Content-disposition: attachment; filename=certificado.pdf');
        header('Content-type: application/pdf');
        readfile('/home/foebbva/public_html/certificados.foebbva.com/public/pdf_tributario/'.$cedula.'.pdf');
      }            

    }

    public function corregir($x)
    {
        $mal = array("si?n","ci?n");
        $bien = array("sión","ción");
        $x = str_replace($mal,$bien,$x);
        return $x;
    }


    public function generar_pdf_deuda(){

      $this->setLayout('blanco');
      $cedula = $_SESSION['kt_login_user'];

      $usuarioinfo = new Administracion_Model_DbTable_Usuariosinfo();
      $usuarios_info = $usuarioinfo->getList("documento = '$cedula'", "")[0];
      $fecha_afiliacion = $usuarios_info->fecha_afiliacion;
      $fecha_afiliacion = date("Y-m-d",strtotime($fecha_afiliacion));

      $aux = explode("-",$fecha_afiliacion);
      $anio = $aux[0];
      $mes = $aux[1];
      $dia = $aux[2];
      $meses = $this->get_meses();
      $mes_nombre = $meses[$mes];

      $saldosModel = new Page_Model_DbTable_Saldos();
      $obligaciones = $saldosModel->getList("  estadocuenta_saldos_cedula='$cedula' ", "");      

    
      $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);

      //$pdf->SetHeaderData('../../../corte/Logo.png', 50,$codigo,$titulo);
      $pdf->SetHeaderData('Logo.png', 50, $codigo, $titulo);
      $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      //$pdf->setPrintFooter(false);
      //$pdf->SetPrintHeader(false);

      // set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      // set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, 22, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(10);

      // set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

      // set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

      // set some language-dependent strings (optional)
      if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
      }


        $div_saldos ='<table width="100%" border="1" style="font-size:12px">
        <tr>
          <td align="center"><b>No OBLIGACION</b></td>
          <td align="center" colspan="2"><b>CONCEPTO</b></td>
          <td align="center"><b>SALDO</b></td>
        </tr>
        ';
        foreach($obligaciones as $key => $saldo1){
            $div_saldos.='<tr>
              <td align="center">'.$saldo1->pagare.'</td>
              <td align="center" colspan="2">'.$this->corregir($saldo1->estadocuenta_saldos_linea.' '.$saldo1->linea).'</td>
              <td align="center">$ '.number_format($saldo1->saldoactual).'</td>
            </tr>';
        }
        $div_saldos.='</table>';

        $nombre = $_SESSION['kt_login_name'];
        $documento = $_SESSION['kt_login_user'];

      $pdf->AddPage();
      $pdf->SetFont('', '', 9, '', true);
      $html = '

      <br><br><br><br>
  
      <table>
        <tr>
          <td>
            <h3 align="center">EL FONDO DE EMPLEADOS FONDTODOS</h3>
          </td>
        </tr>
        <tr>
          <td>
            <h3 align="center">CERTIFICA</h3>
          </td>
        </tr>
        <tr>
          <td align="justify"><br><br>Que el(la) señor(a) '.$nombre.', identificado(a) con la cédula de ciudadanía '.$documento.', se encuentra afiliado(a) al Fondo de Empleados FONDTODOS desde el '.$dia.' de '.$mes_nombre.' del '.$anio.', a la fecha presenta saldo en las siguientes obligaciones:<br>
          </td>
        </tr>
      </table>
      

      '.$div_saldos.'


      <p align="justify">A continuación, relaciono la cuenta para pagos, cuenta corriente BBVA XXXXXXX.</p>

      <p align="justify">Esta certificación se expide en Bogotá D.C., a los '.date("d").' días del mes de '.$meses[date("m")].' del '.date("Y").'  a las '.date("h:i A").'.</p>

      <p align="justify">Cordialmente.</p><br>

      <p align="justify">_________________________________<br>XXXX XXXX<br>Subgerente Administrativo y Comercial<br><br>
      </p>';



      $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
      $pdf->Output('certificado_obligaciones.pdf', 'I');


    }



    public function generar_pdf_ahorros(){

      $this->setLayout('blanco');
      $cedula = $_SESSION['kt_login_user'];

      $usuarioinfo = new Administracion_Model_DbTable_Usuariosinfo();
      $usuarios_info = $usuarioinfo->getList("documento = '$cedula'", "")[0];
      $fecha_afiliacion = $usuarios_info->fecha_afiliacion;
      $fecha_afiliacion = date("Y-m-d",strtotime($fecha_afiliacion));

      $aux = explode("-",$fecha_afiliacion);
      $anio = $aux[0];
      $mes = $aux[1];
      $dia = $aux[2];
      $meses = $this->get_meses();
      $mes_nombre = $meses[$mes];

      $ahorrosModel = new Administracion_Model_DbTable_Ahorrosaportes();
      $ahorros_list = $ahorrosModel->getList("cedula='$cedula' ", "")[0];

      $obligaciones = array();
      $obligaciones["Ahorros"]=$ahorros_list->ahorros;
      $obligaciones["Aportes"]=$ahorros_list->aportes;
      $obligaciones["Ahorros voluntarios"]=$ahorros_list->ahorrosvol;
      $obligaciones["<b>Total</b>"]=$ahorros_list->ahorros+$ahorros_list->ahorros+$aportes->ahorrosvol;

      //print_r($obligaciones);

    
      $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);

      //$pdf->SetHeaderData('../../../corte/Logo.png', 50,$codigo,$titulo);
      $pdf->SetHeaderData('Logo.png', 50, $codigo, $titulo);
      $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      //$pdf->setPrintFooter(false);
      //$pdf->SetPrintHeader(false);

      // set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      // set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, 22, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(10);

      // set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

      // set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

      // set some language-dependent strings (optional)
      if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
      }


        $div_saldos ='<table width="100%" border="1" style="font-size:12px">
        <tr>
          <td align="center" colspan="2"><b>CONCEPTO</b></td>
          <td align="center"><b>SALDO</b></td>
        </tr>
        ';
        foreach($obligaciones as $key => $saldo1){
            $div_saldos.='<tr>
              <td align="center" colspan="2">'.$this->corregir($key).'</td>
              <td align="center">$ '.number_format($saldo1).'</td>
            </tr>';
        }
        $div_saldos.='</table>';

        $nombre = $_SESSION['kt_login_name'];
        $documento = $_SESSION['kt_login_user'];

      $pdf->AddPage();
      $pdf->SetFont('', '', 9, '', true);
      $html = '
      <br><br><br><br>
      <table>
        <tr>
          <td>
            <h3 align="center">EL FONDO DE EMPLEADOS FONDTODOS</h3>
          </td>
        </tr>
        <tr>
          <td>
            <h3 align="center">CERTIFICA</h3>
          </td>
        </tr>
        <tr>
          <td align="justify"><br><br>Que el(la) señor(a) '.$nombre.', identificado(a) con la cédula de ciudadanía '.$documento.', se encuentra afiliado(a) al Fondo de Empleados FONDTODOS desde el '.$dia.' de '.$mes_nombre.' del '.$anio.', a la fecha posee el siguiente ahorro:<br>
          </td>
        </tr>
      </table>

      '.$div_saldos.'

      <p align="justify">Se expide en Bogotá D.C., a los '.date("d").' días del mes de '.$meses[date("m")].' del '.date("Y").' a las '.date("h:i A").', por solicitud del interesado.</p>

      <p align="justify">Cordialmente.</p><br>

      <p align="justify">_________________________________<br>XXXX XXXX<br>Subgerente Administrativo y Comercial<br><br>
        </p>';

      $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
      $pdf->Output('certificado_ahorros.pdf', 'I');

    }    



}
