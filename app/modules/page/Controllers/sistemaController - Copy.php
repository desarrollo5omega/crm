<?php

/**
 *
 */

class Page_sistemaController extends Page_mainController
{


  public function indexAction()
  {
    if ($_SESSION['kt_login_id'] == "") {
      //header("Location://FONDTODOS.com/sistema/");
      header("Location:/page/");
      //print_r($_SESSION);
    }

    $id = $this->_getSanitizedParam("id");
    if ($id == "") {
      $_SESSION['id_solicitud'] = "";
    }

    if ($id > 0 && $_SESSION['id_solicitud'] == "") {
      header("location: /page/sistema/guardaridsesion?id=" . $id);
    }
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $this->_view->id = $id;
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();

    $regionalModel = new Administracion_Model_DbTable_Regional();
    $docModel = new Administracion_Model_DbTable_Documentos();
    $this->_view->regionales = $regionalModel->getList("", "");
    $ahorrosModel = new Administracion_Model_DbTable_Ahorrosaportes();
    $ahorros_list = $ahorrosModel->getList("cedula='$cedula' ", "")[0];
    $ahorros = $ahorros_list->ahorros;
    $aportes = $ahorros_list->aportes;
    $ahorros_aportes = $ahorros + $aportes;
    //print_r($p);
    $d = $this->_view->documentos = $docModel->getList("solicitud=$id AND tipo='1'", "")[0];
    //print_r($d);
    $this->_view->seccion = 1;
    $this->_view->contenidos = $this->template->getContent(1);

    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    $this->getLayout()->setData("header", $header);

    $filtro_lineas = "";
    $cedula = $_SESSION['kt_login_user'];
    $ultima = $solicitudModel->getById($id);
    //RESTRICCIONES LINEAS POR SOLICITUDES
    //print_r($ultima);
    $f1 = " AND (estado_autorizo!='4' OR estado_autorizo IS NULL) AND confimar_solicitud!='2' ";

    //2024-03-19 se agrego AND confimar_solicitud!='2' para que no tenga en cuenta las solicitudes rechazadas por el usuario

    $linea_ult = $ultima->linea_desembolso;
    if ($linea_ult) {
      $f2 = " AND linea_desembolso!=$linea_ult ";
    }

    $this->_view->monto_solicitado = $ultima->monto_solicitado;
    $ultima_af = count($solicitudModel->getList("cedula = '$cedula' and linea = 'AF'   AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);
    $ultima_li = count($solicitudModel->getList("cedula = '$cedula' and linea = 'LI'   AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2", "id DESC")[0]);
    $ultima_cra = count($solicitudModel->getList("cedula = '$cedula' and linea = 'CRA'   AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);
    $ultima_cf = count($solicitudModel->getList("cedula = '$cedula' and linea = 'CF'   AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);
    $ultima_ca = count($solicitudModel->getList("cedula = '$cedula' and linea = 'CA'   AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);
    $ultima_ap = count($solicitudModel->getList("cedula = '$cedula' and linea = 'AP'   AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);
    $ultima_ml = count($solicitudModel->getList("cedula = '$cedula' and linea = 'ML'   AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);
    $ultima_edu = count($solicitudModel->getList("cedula = '$cedula' and linea = 'EDU'   AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);
    $ultima_cc = count($solicitudModel->getList("cedula = '$cedula' and linea = 'CC'    AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);
    $ultima_tr = count($solicitudModel->getList("cedula = '$cedula' and linea = 'TR'    AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);
    $ultima_se = count($solicitudModel->getList("cedula = '$cedula' and linea = 'SE'    AND (validacion='0' OR validacion='6' OR validacion='3'OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);
    $ultima_so = count($solicitudModel->getList("cedula = '$cedula' and linea = 'SO'   AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);
    $ultima_veh = count($solicitudModel->getList("cedula = '$cedula' and linea = 'VEH'    AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);
    $ultima_cv = count($solicitudModel->getList("cedula = '$cedula' and linea = 'CV'    AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);
    $ultima_cdu = count($solicitudModel->getList("cedula = '$cedula' and linea = 'CDU'    AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);
    $ultima_cn = count($solicitudModel->getList("cedula = '$cedula' and linea = 'CN'    AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ", "id DESC")[0]);

    if($_GET['prueba_li']=="1"){
      echo " cedula = '$cedula' and linea = 'LI'   AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') $f1 $f2 ";
    }

    $hoy = new DateTime("now");
    $fecha_ini = new DateTime("2021-12-24 17:00:00");
    $fecha_fin = new DateTime("2022-06-01 23:59:00");
    $fecha_ini2 = new DateTime("2023-12-22 17:00:00");

    if ($hoy >= $fecha_ini2) {
      $filtro_lineas .= " AND codigo!='CN'";
    }

    if ($ultima_af > 0) {
      $filtro_lineas .= " AND codigo!='AF'";
    }
    if ($ultima_li > 0) {
      $filtro_lineas .= " AND codigo!='LI'";
    }
    if ($ultima_cra > 0) {
      $filtro_lineas .= " AND codigo!='CRA'";
    }
    if ($ultima_cf > 0) {
      $filtro_lineas .= " AND codigo!='CF'";
    }
    if ($ultima_ca > 0) {
      $filtro_lineas .= " AND codigo!='CA'";
    }
    if ($ultima_ap > 0) {
      $filtro_lineas .= " AND codigo!='AP'";
    }
    if ($ultima_ml > 0) {
      $filtro_lineas .= " AND codigo!='ML'";
    }

    if ($ultima_cc > 0) {
      $filtro_lineas .= " AND codigo!='CC'";
    }
    if ($ultima_tr > 0) {
      $filtro_lineas .= " AND codigo!='TR'";
    }
    if ($ultima_se > 0) {
      $filtro_lineas .= " AND codigo!='SE'";
    }
    if ($ultima_so > 0) {
      $filtro_lineas .= " AND codigo!='SO'";
    }
    if ($ultima_veh > 0) {
      $filtro_lineas .= " AND codigo!='VEH'";
    }
    if ($ultima_cv > 0) {
      $filtro_lineas .= " AND codigo!='CV'";
    }
    if ($ultima_edu > 0) {
      $filtro_lineas .= " AND codigo!='EDU'";
    }
    if ($ultima_cn > 0) {
      $filtro_lineas .= " AND codigo!='CN'";
    }
    if ($ultima_cdu > 0) {
      $filtro_lineas .= " AND codigo!='CDU'";
    }

    //RESTRICCIONES LINEAS POR TIEMPO
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
    $saldosModel = new Page_Model_DbTable_Saldos();
    $saldo_vivienda = $saldosModel->getList(" estadocuenta_saldos_linea = 'VIVIENDA  60 MESES' AND estadocuenta_saldos_cedula='$cedula' ", "");
    //echo date("Y-m-d", strtotime(str_replace('/', '-',$fecha_afiliacion_koba)));
    //echo $fecha_afiliacion_koba;
    //$fecha_afiliacion_koba = date("d/m/Y",$fecha_afiliacion_koba);

    //$fecha_afiliacion = date("Y-m-d", strtotime(str_replace('/', '-',$fecha_afiliacion)));
    $fecha_afiliacion_koba_date = DateTime::createFromFormat('m/d/Y', $fecha_afiliacion_koba);
    if ($fecha_afiliacion_koba_date) {
      $fecha_afiliacion_koba = $fecha_afiliacion_koba_date->format('Y-m-d');
    }

    $fecha_afiliacion_date = DateTime::createFromFormat('m/d/Y', $fecha_afiliacion);
    if ($fecha_afiliacion_date) {
      $fecha_afiliacion = $fecha_afiliacion_date->format('Y-m-d');
    }

    //echo $fecha_afiliacion;
    $date1 = new DateTime($hoy);
    $date2 = new DateTime($fecha_afiliacion);
    $date3 = new DateTime($fecha_afiliacion_koba);


    $diff = $date1->diff($date2);
    $meses = ($diff->y * 12) + $diff->m;

    $diff2 = $date1->diff($date3);
    $meses_koba = ($diff2->y * 12) + $diff2->m;
    if ($meses > 12) {
      $flag_afiliacion = false;
    }
    if ($meses_koba > 12) {
      $flag_afiliacion = false;
    }
    if ($fecha_min_3m < $fecha_afiliacion_koba) {
      $flag_afiliacion = false;
      $filtro_lineas .= " AND codigo!='AF'";
    }
    if ($fecha_min_6m < $fecha_afiliacion_koba || $fecha_min_6m < $fecha_afiliacion) {
      $filtro_lineas .= " AND codigo!='EDU' ";
    }
    if ($fecha_min_6m < $fecha_afiliacion_koba) {
      $filtro_lineas .= " AND codigo!='AP'";
    }
    if($fecha_min_6m < $fecha_afiliacion_koba){
      $filtro_lineas .= " AND codigo!='CA'";
    }
    //echo $fecha_afiliacion_koba;
//    echo $ahorros_aportes;
//    $ahorros_aportes = 1;
    if ($fecha_min_12m < $fecha_afiliacion_koba ) {
      $filtro_lineas .= "AND codigo!='CN'";
    }
    if ($fecha_min_3m < $fecha_afiliacion_koba) {
      $filtro_lineas .= " AND codigo!='CF'";
    }
    if ($fecha_min_6m < $fecha_afiliacion_koba) {
      $filtro_lineas .= " AND codigo!='PDI'";
    }
    if ($fecha_min_3m < $fecha_afiliacion) {
      $flag_libre_inversion = false;
      $filtro_lineas .= " AND codigo!='LI'";
      //echo "entro";
    }
    if ($fecha_min_12m < $fecha_afiliacion_koba) {
      $flag_libre_inversion = false;
      $filtro_lineas .= " AND codigo!='LI'";
    }
    if ($flag_libre_inversion) {
      $flag_afiliacion = false;
      $filtro_lineas .= " AND codigo!='AF'";
    }
    if ($flag_afiliacion) {
      $filtro_lineas .= " AND codigo!='LI'";
    }
    if ($fecha_min_6m < $fecha_afiliacion) {
      $filtro_lineas .= " AND codigo!='ML' AND codigo!='TR' AND codigo!='CC'";
    }
    if ($fecha_min_12m < $fecha_afiliacion_koba) {
      $filtro_lineas .= " AND codigo!='ML' AND codigo!='TR' AND codigo!='CC'";
    }
    if ($fecha_min_6m < $fecha_afiliacion) {
      $filtro_lineas .= " AND codigo!='VEH' AND codigo!='CV'";
    }
    if ($fecha_min_24m < $fecha_afiliacion_koba) {
      $filtro_lineas .= " AND codigo!='VEH' AND codigo!='CV'";
    }
    if ($fecha_min_3m < $fecha_afiliacion) {
      $filtro_lineas .= " AND codigo!='SE' AND codigo!='CDU'";
    }
    if ($fecha_min_3m < $fecha_afiliacion_koba) {
      $filtro_lineas .= " AND codigo!='SE' AND codigo!='CDU'";
    }
    if ($fecha_min_12m < $fecha_afiliacion) {
      //$filtro_lineas .=" AND codigo!='VEH'";
    }
    if ($fecha_min_36m < $fecha_afiliacion) {
      //$filtro_lineas .=" AND codigo!='CV'";
    }

    $usuariosCarteraModel = new Administracion_Model_DbTable_Usuarioscartera();
    $usuariosCartera = $usuariosCarteraModel->getList("userc_cedula = '$cedula' ", "");

    if ($usuariosCartera) {
      $filtro_lineas .= " AND codigo != 'CC'";
    } else {
      $filtro_lineas .= " AND codigo != 'CCC'";
    }
    // Filtro especial educación
    if ($cedula == '1233500601' || $cedula == '1015419020' || $cedula == '1073162911' || $cedula == '1192755039') {
      $filtro_lineas .= " OR codigo = 'EDU'";
    }
    if ($cedula == '37712430' || $cedula == '1140850432' || $cedula == '1077033956'  || $cedula == '35537757') {
      $filtro_lineas .= " OR codigo = 'LI'";
    }
    if ($cedula == '1192755039' || $cedula == '1016111951') {
      $filtro_lineas .= " OR codigo = 'AF'";
    }
    if ($cedula == '1024562264') {
      $filtro_lineas .= " OR codigo = 'VEH'";
    }

    $activarLineasModel = new Administracion_Model_DbTable_Activarlineas();
    $activarLineas = $activarLineasModel->getList("activar_documento = '$cedula' ", "");

    foreach ($activarLineas as $activarLinea) {
      $filtro_lineas .= " OR codigo = '$activarLinea->activar_linea'";
    }

    if ($_GET["prueba"] == 1) {
      echo $filtro_lineas;
    }
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $this->_view->lineas = $lineaModel->getList(" activo='1' $filtro_lineas ", " codigo*1 ASC ");


    $this->_view->linea = $linea_id = $this->_getSanitizedParam("linea");
    $this->_view->linea = $linea_id = $ultima->linea;

    $linea_filtro = $lineaModel->getList(" codigo = '$linea_id' ", "")[0];
    $this->_view->tasa_nominal = $linea_filtro->efectivo_anual;

    $this->_view->valor1 = $ultima->valor;
    $this->_view->valor_desembolso = $ultima->valor_desembolso;
    $this->_view->recoger_credito = $ultima->recoger_credito;
    $this->_view->numeros_recogidos = $ultima->numeros_recogidos;

    $gestoresModel = new Administracion_Model_DbTable_Gestores();
    $this->_view->gestores = $gestores = $gestoresModel->getList(" activo='1' ", " nombre ASC ");

    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $user_id = $_SESSION['kt_login_id'];
    $usuario = $usuarioModel->getById($user_id);

    $hoy = date("Y-m-d");
    $ultima_actualizacion = $usuario->user_password_fecha;
    $fecha_vencimiento = date("Y-m-d", strtotime($ultima_actualizacion . "+ 6 months"));
    if ($hoy > $fecha_vencimiento or $ultima_actualizacion == "") {
      //header("Location: /page/sistema/perfil/?actualizar=1");
    }


    $sarlaftModel = new Page_Model_DbTable_Sarlaft();
    $cedula = $_SESSION['kt_login_user'];
    $existe = $sarlaftModel->getList(" cedula='$cedula' ", "");
    //if(count($existe)==0 and ($_SESSION['kt_login_level']=="2" or $cedula=="14326998")){
    //if($cedula=="14326998"){
    //header("Location:/page/sarlaft/");
    //}else{
    //header("Location:/page/index/nopermitido/");
    //header("Location:/page/sarlaft/");
    //}
    //}

    //paso1
    $bancosModel = new Administracion_Model_DbTable_Bancos();
    $this->_view->bancos = $bancosModel->getList("", " nombre ASC ");

    $cedula = $usuario->user_user;
    $cedula  = $_SESSION['kt_login_user'];
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $ultima = $solicitudModel->getList(" cedula='$cedula' AND paso='8' ", " id DESC ")[0];
    $ultima_id = $ultima->id;

    if ($id != "") {
      $ultima = $solicitudModel->getById($id);
      $ultima_id = $ultima->id;
      $this->_view->solicitud = $ultima;
      // $cuposModel = new Administracion_Model_DbTable_Cuposlinea();
      // $linea_id=$linea_filtro->id;
      // $cupos_list = $cuposModel->getList(" cedula='$cedula' AND linea=$linea_id ","");
      // $this->_view->cupo_actual = $cupos_list[0]->cupo*1;

    }

    $fecha_ultima = substr($ultima->fecha, 0, 10);
    //echo $cedula;
    $usuariosinfoModel = new Administracion_Model_DbTable_Usuariosinfo();
    $usuariosinfo = $usuariosinfoModel->getList(" documento='$cedula' ")[0];

    $usuarioslog = new Administracion_Model_DbTable_Usuario();
    $userlog = $usuarioslog->getList("user_user='$cedula'")[0];


    $usuariosinfo = $usuariosinfoModel->getList(" documento='$cedula' ")[0];

    $listadosarlaftModel = new Administracion_Model_DbTable_Listadosarlaft();
    $listadodarlaft = $listadosarlaftModel->getList(" cedula='$cedula' ")[0];
    $fecha_sarlaft = $listadodarlaft->fecha;
    $primero_sarlaft = 1;
    if ($fecha_sarlaft != "" and $fecha_ultima != "") {
      if ($fecha_sarlaft < $fecha_ultima) {
        $primero_sarlaft = 0;
      }
    }

    $aux_nombres = $usuariopanel->user_names;
    $aux_apellidos = explode(" ", $usuariopanel->user_lastnames);

    $contador_nombre = explode(" ", $usuariopanel->user_names);
    if (count($contador_nombre) >= 4) {
      //$aux_nombres = $contador_nombre[0]." ".$contador_nombre[1];
      if ($aux_apellidos[0] == "") {
        //$aux_apellidos[0]=$contador_nombre[2];
        //$aux_apellidos[1]=$contador_nombre[3];
      }
    }

    $this->_view->nombres = $aux_nombres;
    $this->_view->apellido1 = $aux_apellidos[0];
    $this->_view->apellido2 = $aux_apellidos[1];

    if ($usuariosinfo->nombres != "") {
      $aux2 = explode(" ", $usuariosinfo->nombres);
      $this->_view->nombres = $aux2[0];
      $this->_view->nombres2 = $aux2[1];
    }
    if ($usuariosinfo->apellidos != "") {
      $aux = explode(" ", $usuariosinfo->apellidos);
      $this->_view->apellido1 = $aux[0];
      $this->_view->apellido2 = $aux[1];
    }
    if ($usuariosinfo->direccion != "") {
      $this->_view->direccion_residencia = $usuariosinfo->direccion;
    }
    if ($usuariosinfo->email != "") {
      $this->_view->correo_personal = $usuariosinfo->email;
    }
    if ($usuariosinfo->telefono != "") {
      $this->_view->telefono = $usuariosinfo->telefono;
    }
    if ($usuariosinfo->celular != "") {
      $this->_view->celular = $usuariosinfo->celular;
    }
    //print_r($usuariosinfo);
    if ($usuariosinfo->nivel_educativo != "") {
      $this->_view->estudios = $usuariosinfo->nivel_educativo;
    }
    if ($usuariosinfo->regional != "") {
      $this->_view->estudios = $usuariosinfo->regional;
    }
    if ($usuariosinfo->fecha_nacimiento != "") {
      $fecha_ingreso = date("Y-m-d", strtotime($usuariosinfo->fecha_nacimiento));
      $this->_view->fecha_nacimiento = $fecha_ingreso;
    }
    if ($usuariosinfo->fecha_ingreso != "") {
      $fecha_ingreso = date("Y-m-d", strtotime($usuariosinfo->fecha_ingreso));
      $this->_view->fecha_ingreso = $fecha_ingreso;
    }
    if ($usuariosinfo->fecha_documento != "") {
      $fechadocumento = date("Y-m-d", strtotime($usuariosinfo->fecha_documento));
      $this->_view->fecha_documento = $fechadocumento;
    }
    if ($usuariosinfo->genero != "") {
      $this->_view->sexo = $usuariosinfo->genero;
    }
    if ($usuariosinfo->tipo_documento != "") {
      $this->_view->tipo_documento = $usuariosinfo->tipo_documento;
    }
    if ($usuariosinfo->barrio != "") {
      $this->_view->barrio = $usuariosinfo->barrio;
    }
    if ($usuariosinfo->ciudad_documento != "") {
      $this->_view->ciudad_documento = $usuariosinfo->ciudad_documento;
    }
    if ($usuariosinfo->estado_civil != "") {
      $this->_view->estado_civil = $this->remplaceEC($usuariosinfo->estado_civil);
    }
    if ($usuariosinfo->empresa != "") {
      $this->_view->empresa = $usuariosinfo->empresa;
    }
    if ($usuariosinfo->direccion_oficina != "") {
      $this->_view->direccion_oficina = $usuariosinfo->direccion_oficina;
    }
    if ($usuariosinfo->dependencia != "") {
      $this->_view->dependencia = $usuariosinfo->dependencia;
    }
    if ($usuariosinfo->telefono_oficina != "") {
      $this->_view->telefono_oficina = $usuariosinfo->telefono_oficina;
    }
    if ($usuariosinfo->fecha_afiliacion != "") {
      $this->_view->fecha_afiliacion = $usuariosinfo->fecha_afiliacion;
    }
    if ($usuariosinfo->cuenta_numero != "") {
      $this->_view->cuenta_numero = $usuariosinfo->cuenta_numero;
    }
    if ($usuariosinfo->cuenta_tipo != "") {
      $this->_view->cuenta_tipo = $usuariosinfo->cuenta_tipo;
    }
    if ($usuariosinfo->entidad_bancaria != "") {
      $this->_view->entidad_bancaria = $usuariosinfo->entidad_bancaria;
    }
    if ($usuariosinfo->salario != "") {
      $this->_view->salario = $this->limpiar_numero($usuariosinfo->salario);
    }
    if ($usuariosinfo->cargo != "") {
      $this->_view->cargo = $usuariosinfo->cargo;
    }
    if ($usuariosinfo->ciudad_oficina != "") {
      $this->_view->ciudad_oficina = $usuariosinfo->ciudad_oficina;
    }
    if ($usuariosinfo->situacion_laboral != "") {
      $this->_view->situacion_laboral = $usuariosinfo->situacion_laboral;
    }


    $this->_view->documento = $cedula;

    if ($ultima->nombres != "") {
      $this->_view->nombres = explode(' ', $usuariosinfo->nombres)[0];
      $this->_view->nombrecompleto = $userlog->user_names;
      $this->_view->cedula = $cedula;
      //print_r($usuariosinfo);
    }
    if ($ultima->apellido1 != "") {
      $this->_view->apellido1 = explode(' ', $usuariosinfo->apellidos)[0];
    }
    if ($ultima->apellido2 != "") {
      $this->_view->apellido2 = explode(' ', $usuariosinfo->apellidos)[1];
    }
    if ($ultima->sexo != "") {
      $this->_view->sexo = $ultima->sexo;
    }
    if ($ultima->regional != "") {
      $this->_view->regional = $ultima->regional;
    }
    if ($ultima->direccion_residencia != "") {
      $this->_view->direccion_residencia = $ultima->direccion_residencia;
    }
    //print_r($ultima);
    if ($ultima->nivel_escolaridad != "") {
      $this->_view->estudios = $ultima->nivel_escolaridad;
    }
    if ($ultima->personas_cargo != "") {
      $this->_view->personas_cargo = $ultima->personas_cargo;
    }
    if ($ultima->telefono != "") {
      $this->_view->telefono = $ultima->telefono;
    }
    if ($ultima->barrio != "") {
      $this->_view->barrio = $ultima->barrio;
    }
    if ($ultima->ciudad_residencia != "") {
      $this->_view->ciudad_residencia = $ultima->ciudad_residencia;
    }
    if ($ultima->correo_empresarial != "") {
      $this->_view->correo_empresarial = $ultima->correo_empresarial;
    }
    if ($ultima->correo_personal != "") {
      $this->_view->correo_personal = $ultima->correo_personal;
    }
    if ($ultima->tipo_documento != "") {
      $this->_view->tipo_documento = $ultima->tipo_documento;
    }
    if ($ultima->empresa != "") {
      $this->_view->empresa = $ultima->empresa;
    }
    if ($ultima->dependencia != "") {
      $this->_view->dependencia = $ultima->dependencia;
    }
    if ($ultima->direccion_oficina != "") {
      $this->_view->direccion_oficina = $ultima->direccion_oficina;
    }
    if ($ultima->telefono_oficina != "") {
      $this->_view->telefono_oficina = $ultima->telefono_oficina;
    }
    if ($ultima->situacion_laboral != "") {
      $this->_view->situacion_laboral = $ultima->situacion_laboral;
    }
    if ($ultima->cual != "") {
      $this->_view->cual = $ultima->cual;
    }
    if ($ultima->declara_renta != "") {
      $this->_view->declara_renta = $ultima->declara_renta;
    }
    if ($ultima->persona_publica != "") {
      $this->_view->persona_publica = $ultima->persona_publica;
    }
    if ($ultima->persona_publica_indique != "") {
      $this->_view->persona_publica_indique = $ultima->persona_publica_indique;
    }
    if ($ultima->persona_expuesta != "") {
      $this->_view->persona_expuesta = $ultima->persona_expuesta;
    }
    if ($ultima->persona_expuesta_indique != "") {
      $this->_view->persona_expuesta_indique = $ultima->persona_expuesta_indique;
    }
    if ($ultima->persona_internacional != "") {
      $this->_view->persona_internacional = $ultima->persona_internacional;
    }
    if ($ultima->persona_internacional_indique != "") {
      $this->_view->persona_internacional_indique = $ultima->persona_internacional_indique;
    }
    //echo $ultima->vinculo_pep;
    //print_r($ultima);
    if ($ultima->vinculo_pep != "") {
      $this->_view->vinculo_pep = $ultima->vinculo_pep;
    }
    if ($ultima->vinculo_pep_indique != "") {
      $this->_view->vinculo_pep_indique = $ultima->vinculo_pep_indique;
    }
    if ($ultima->obligaciones_tributarias != "") {
      $this->_view->obligaciones_tributarias = $ultima->obligaciones_tributarias;
    }
    if ($ultima->obligaciones_tributarias_indique != "") {
      $this->_view->obligaciones_tributarias_indique = $ultima->obligaciones_tributarias_indique;
    }
    if ($ultima->fecha_nacimiento != "") {
      $this->_view->fecha_nacimiento = $ultima->fecha_nacimiento;
    }
    if ($ultima->fecha_documento != "") {
      $this->_view->fecha_documento = $ultima->fecha_documento;
    }
    if ($ultima->celular != "") {
      $this->_view->celular = $ultima->celular;
    }
    if ($ultima->ciudad_oficina != "") {
      $this->_view->ciudad_oficina = $ultima->ciudad_oficina;
    }
    if ($ultima->ciudad_documento != "") {
      $this->_view->ciudad_documento = $ultima->ciudad_documento;
    }
    if ($ultima->cuenta_numero != "") {
      $this->_view->cuenta_numero = $ultima->cuenta_numero;
    }
    if ($ultima->cuenta_tipo != "") {
      $this->_view->cuenta_tipo = $ultima->cuenta_tipo;
    }
    if ($ultima->entidad_bancaria != "") {
      $this->_view->entidad_bancaria = $ultima->entidad_bancaria;
    }
    if ($ultima->ocupacion != "") {
      $this->_view->ocupacion = $ultima->ocupacion;
    }
    if ($ultima->estado_civil != "") {
      $this->_view->estado_civil = $ultima->estado_civil;
    }
    if ($ultima->peso != "") {
      $this->_view->peso = $ultima->peso;
    }
    if ($ultima->estatura != "") {
      $this->_view->estatura = $ultima->estatura;
    }
    if ($ultima->conyuge_nombre != "") {
      $this->_view->conyuge_nombre = $ultima->conyuge_nombre;
    }
    if ($ultima->conyuge_telefono != "") {
      $this->_view->conyuge_telefono = $ultima->conyuge_telefono;
    }
    if ($ultima->conyuge_celular != "") {
      $this->_view->conyuge_celular = $ultima->conyuge_celular;
    }
    if ($ultima->tipo_vivienda != "") {
      $this->_view->tipo_vivienda = $ultima->tipo_vivienda;
    }
    if ($ultima->origen_ingresos != "") {
      $this->_view->origen_ingresos = $ultima->origen_ingresos;
    }
    if ($ultima->ciiu != "") {
      $this->_view->ciiu = $ultima->ciiu;
    }
    if ($ultima->estrato != "") {
      $this->_view->estrato = $ultima->estrato;
    }
    if ($ultima->fecha_ingreso != "") {
      $this->_view->fecha_ingreso = $ultima->fecha_ingreso;
    }
    if ($ultima->cargo != "") {
      $this->_view->cargo = $ultima->cargo;
    }
    if ($ultima->fecha_afiliacion != "") {
      $this->_view->fecha_afiliacion = $ultima->fecha_afiliacion;
    }
    if ($ultima->personas_cargo != "") {
      $this->_view->personas_cargo = $ultima->personas_cargo;
    }
    if ($ultima->numero_hijos != "") {
      $this->_view->numero_hijos = $ultima->numero_hijos;
    }
    if ($ultima->nomenclatura1 != "") {
      $this->_view->nomenclatura1 = $ultima->nomenclatura1;
    }
    if ($ultima->nomenclatura2 != "") {
      $this->_view->nomenclatura2 = $ultima->nomenclatura2;
    }


    if ($primero_sarlaft == 1) {
      if ($usuariosinfo->direccion != "") {
        $this->_view->direccion_residencia = $usuariosinfo->direccion;
      }
      if ($usuariosinfo->email != "") {
        $this->_view->correo_personal = $usuariosinfo->email;
      }
      if ($usuariosinfo->telefono != "") {
        $this->_view->telefono = $usuariosinfo->telefono;
      }
      if ($usuariosinfo->celular != "") {
        $this->_view->celular = $usuariosinfo->celular;
      }
      if ($usuariosinfo->fecha_nacimiento != "") {
        $fecha_nacimiento = date("Y-m-d", strtotime($usuariosinfo->fecha_nacimiento));
        $this->_view->fecha_nacimiento = $fecha_nacimiento;
      }
      if ($usuariosinfo->fecha_ingreso != "") {
        $fecha_ingreso = date("Y-m-d", strtotime($usuariosinfo->fecha_ingreso));
        $this->_view->fecha_ingreso = $fecha_ingreso;
      }
      if ($usuariosinfo->fecha_documento != "") {
        $fechadocumento = date("Y-m-d", strtotime($usuariosinfo->fecha_documento));
        $this->_view->fecha_documento = $fechadocumento;
      }
      if ($usuariosinfo->genero != "") {
        $this->_view->sexo = $usuariosinfo->genero;
      }
      if ($usuariosinfo->tipo_documento != "") {
        $this->_view->tipo_documento = $usuariosinfo->tipo_documento;
      }
      if ($usuariosinfo->barrio != "") {
        $this->_view->barrio = $usuariosinfo->barrio;
      }
      if ($usuariosinfo->ciudad_documento != "") {
        $this->_view->ciudad_documento = $usuariosinfo->ciudad_documento;
      }
      if ($usuariosinfo->estado_civil != "") {
        $this->_view->estado_civil = $this->remplaceEC($usuariosinfo->estado_civil);
      }
      if ($usuariosinfo->empresa != "") {
        $this->_view->empresa = $usuariosinfo->empresa;
      }
      if ($usuariosinfo->direccion_oficina != "") {
        $this->_view->direccion_oficina = $usuariosinfo->direccion_oficina;
      }
      if ($usuariosinfo->telefono_oficina != "") {
        $this->_view->telefono_oficina = $usuariosinfo->telefono_oficina;
      }
      if ($usuariosinfo->fecha_afiliacion != "") {
        $fecha_afiliacion = date("Y-m-d", strtotime($usuariosinfo->fecha_afiliacion));
        $this->_view->fecha_afiliacion = $fecha_afiliacion;
      }
      if ($usuariosinfo->cuenta_numero != "") {
        $this->_view->cuenta_numero = $usuariosinfo->cuenta_numero;
      }
      if ($usuariosinfo->cuenta_tipo != "") {
        $this->_view->cuenta_tipo = $usuariosinfo->cuenta_tipo;
      }
      if ($usuariosinfo->entidad_bancaria != "") {
        $this->_view->entidad_bancaria = $usuariosinfo->entidad_bancaria;
      }
      if ($usuariosinfo->salario != "") {
        $this->_view->salario = $this->limpiar_numero($usuariosinfo->salario);
      }
      if ($usuariosinfo->cargo != "") {
        $this->_view->cargo = $usuariosinfo->cargo;
      }
      if ($usuariosinfo->ciudad_oficina != "") {
        $this->_view->ciudad_oficina = $usuariosinfo->ciudad_oficina;
      }
      if ($usuariosinfo->situacion_laboral != "") {
        $this->_view->situacion_laboral = $usuariosinfo->situacion_laboral;
      }
    }
    //paso1

    //paso4
    $referenciasModel = new Administracion_Model_DbTable_Referencias();
    $referencias['1'] = $referenciasModel->getList(" solicitud='$id' AND numero='1' ", "")[0];
    if (!$referencias['1']->id > 0) {
      $referencias['1'] = $referenciasModel->getList(" solicitud='$ultima_id' AND numero='1' ", "")[0];
    }
    $referencias['2'] = $referenciasModel->getList(" solicitud='$id' AND numero='2' ", "")[0];
    if (!$referencias['2']->id > 0) {
      $referencias['2'] = $referenciasModel->getList(" solicitud='$ultima_id' AND numero='2' ", "")[0];
    }
    $referencias['3'] = $referenciasModel->getList(" solicitud='$id' AND numero='3' ", "")[0];
    if (!$referencias['3']->id > 0) {
      $referencias['3'] = $referenciasModel->getList(" solicitud='$ultima_id' AND numero='3' ", "")[0];
    }
    $referencias['4'] = $referenciasModel->getList(" solicitud='$id' AND numero='4' ", "")[0];
    if (!$referencias['4']->id > 0) {
      $referencias['4'] = $referenciasModel->getList(" solicitud='$ultima_id' AND numero='4' ", "")[0];
    }
    $this->_view->referencias = $referencias;

    $parentescoModel = new Administracion_Model_DbTable_Parentescos();
    $this->_view->parentescos = $parentescoModel->getList("", " nombre ASC ");


    $ciudadModel = new Administracion_Model_DbTable_Ciudad();
    $this->_view->ciudades = $ciudadModel->getList("", " nombre ASC ");

    $nomenclaturaModel = new Administracion_Model_DbTable_Nomenclatura();
    $this->_view->nomenclaturas = $nomenclaturas = $nomenclaturaModel->getList("", " codigo ASC ");
    //paso4


    //paso5
    $garantialineaModel = new Administracion_Model_DbTable_Garantialinea();
    $filtro_garantias = " ( 1=0 ";
    $codigo = $solicitud->linea;
    $garantialinea = $garantialineaModel->getList(" gl_linea_id='$codigo' ", "");
    foreach ($garantialinea as $key => $value) {
      $garantia_id = $value->gl_garantia_id;
      $filtro_garantias .= " OR garantia_id = '$garantia_id'  ";
    }
    $filtro_garantias .= " )";
    $this->_view->array_garantias = $array_garantias;

    $garantiasModel = new Administracion_Model_DbTable_Garantias();
    $this->_view->garantias = $garantiasModel->getList(" 1=1 AND $filtro_garantias ", " garantia_nombre ASC ");
    //paso5


    $aportesModel = new Page_Model_DbTable_Aportes();
    $aportes_list = $aportesModel->getList(" cedula='$cedula' ", " id ASC ");
    $aportes = $aportes_list[0]->total_aportes;
    $this->_view->aportes = $aportes;
  }

  public function guardarsolicitudAction()
  {
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $data['paso'] = 1;
    $data['cedula'] = $this->_getSanitizedParam("cedula");
    $data['linea'] = $this->_getSanitizedParam("linea");
    $data['valor'] = str_replace(".", "", $this->_getSanitizedParam("valor"));
    $data['cuotas'] = $this->_getSanitizedParam("cuotas") * 1;
    $data['tasa'] = $this->_getSanitizedParam("tasa");
    $data['tasa_anual'] = $this->_getSanitizedParam("tasa_anual");
    $data['fecha'] = date("Y-m-d H:i:s");
    $data['validacion'] = 0;
    $data['radicacion'] = "";
    $data['cuotas_extra'] = $this->_getSanitizedParam("cuotas_extra");
    //$data['nivel_escolaridad']= $this->_getSanitizedParam("nivel_escolaridad");
    $data['valor_extra'] = str_replace(".", "", $this->_getSanitizedParam("valor_extra"));
    $data['valor_cuota'] = $this->_getSanitizedParam("valor_cuota") * 1;
    $data['destino'] = $this->_getSanitizedParam("destino");
    $data['observaciones'] = $this->_getSanitizedParam("observaciones");
    $data['tramite'] = $this->_getSanitizedParam("tramite");
    $data['gestor_comercial'] = $this->_getSanitizedParam("gestor_comercial");
    $data['monto_solicitado'] = $this->_getSanitizedParam("monto_solicitado");
    $data['valor_desembolso'] = $this->sin_puntos($this->_getSanitizedParam("valor_desembolso"));
    if ($data['valor_desembolso'] == "") {
      $data['valor_desembolso'] = $data['valor'];
    }
    $data['linea_desembolso'] = $this->_getSanitizedParam("linea");
    $data['cuotas_desembolso'] = $this->_getSanitizedParam("cuotas");
    $data['valor_cuota_desembolso'] = $this->_getSanitizedParam("valor_cuota");
    $data['tasa_desembolso'] = $this->_getSanitizedParam("tasa");
    $data['cuotas_extra_desembolso'] = $this->_getSanitizedParam("cuotas_extra");
    $data['valor_extra_desembolso'] =  str_replace(".", "", $this->_getSanitizedParam("valor_extra"));
    $data['frecuencia'] = $this->_getSanitizedParam("frecuencia") * 1;
    $data['cuota_prima'] = $this->_getSanitizedParam("cuota_prima");
    $data['cuota_prima_desembolso'] = $this->_getSanitizedParam("cuota_prima");


    $id1 = $this->_getSanitizedParam("id1") * 1;


    if ($data['cedula'] != "") {
      $logcreditosModel = new Administracion_Model_DbTable_Logcreditos();
      //$id = $solicitudModel->insert2($data);

      $cedula = $_SESSION['kt_login_user'];
      $linea = $data['linea'];
      //echo $id1;
      if ($id1 > 0) {
        $solicitud = $solicitudModel->getById($id1);
        $linea = $solicitud->linea_desembolso;
      }
      $ultima_sol = count($solicitudModel->getList(" cedula = '$cedula' AND linea = '$linea'  AND (validacion='0' OR validacion='6' OR validacion='3' OR validacion='1' OR validacion='8') AND (estado_autorizo!='4' OR estado_autorizo IS NULL) AND confimar_solicitud!='2' ", "id DESC")[0]);

      //echo "ultima_sol:".$ultima_sol;

      if ($ultima_sol == 0 or $id1 > 0) {
        //echo "ENTRO".$id1;
        $id = $solicitudModel->insert2($data);
        $data2["solicitud"] = $id;
        $data2["post"] = print_r($data, true);
        $data2["fecha"] = date("Y-m-d");
        $logcreditosModel->insert($data2);
      }
      if ($id1 > 0) {
        if ($id > 0) {
          $solicitudModel->deleteRegister($id1);
          $solicitudModel->editField($id, "id", $id1);
          $id = $id1;
        }
      }
      if ($id > 0) {
        $solicitudModel->editField($id, "pagare", $id);
        //header("Location: /page/sistema/paso1/?id=".$id);
        extract($_POST);
        $paso = 1;
        if ($paso == "1") {
          //guardafirma
          $cartaModel = new Administracion_Model_DbTable_Cartacompromiso();

          $carta_array["solicitud"] = $id;
          $carta_array["firma"] = $firma;
          $carta_array["font"] = $font_input;
          $carta_array["fecha_firma"] = date("Y-m-d H:i:s");
          $carta_array["ip"] = $this->getRealIP();
          if ($firma && ($this->_getSanitizedParam("linea") == "VEH" || $this->_getSanitizedParam("linea") == "EDU" || $this->_getSanitizedParam("linea") == "CC")) {
            $id_carta = $cartaModel->insert($carta_array);
          }
          //print_r($obligacion);
          $obligacionModel = new Administracion_Model_DbTable_Obligaciones();
          $obligacionModel->delete($id);
          for ($i = 0; $i <= count($obligacion); $i++) {
            $obligacion_array["id_carta"] = $id_carta;
            $obligacion_array["entidad"] = $obligacion["entidad"][$i];
            $obligacion_array["numero_obligacion"] = $obligacion["tipo"][$i];
            $obligacion_array["valor"] = str_replace(".", "", $obligacion["valor"][$i]);
            if ($id && $obligacion_array["entidad"] && $obligacion_array["numero_obligacion"] && $obligacion_array["valor"]) {
              $id_obligacion = $obligacionModel->insert($obligacion_array);
            }
          }
          if ($id_obligacion > 0) {
          } else {
            if ($id_carta > 0) {
              $solicitudModel->deleteRegister($id);
              header("Location: /page/sistema?error=3");
            }
          }


          //
          //echo "entro2<br>";
          //echo $nivel_escolaridad;
          $ciudad_residencia = $this->limpiar2($ciudad_residencia);
          $ciudad_oficina = $this->limpiar2($ciudad_oficina);
          $ciudad_documento = $this->limpiar2($ciudad_documento);
          $direccion_oficina = $this->limpiar2($direccion_oficina);
          $direccion_residencia = $this->limpiar2($direccion_residencia);
          $dependencia = $this->limpiar2($dependencia);
          $nombres = $this->limpiar2($nombres);
          $nombres2 = $this->limpiar2($nombres2);
          $apellido1 = $this->limpiar2($apellido1);
          $apellido2 = $this->limpiar2($apellido2);
          $barrio = $this->limpiar2($barrio);
          $cuenta_numero = $this->limpiar2($cuenta_numero);
          $cuenta_tipo = $this->limpiar2($cuenta_tipo);
          $entidad_bancaria = $this->limpiar2($entidad_bancaria);
          $regional = $this->limpiar2($regional);

          $solicitudModel->editField($id, "nombres", $nombres);
          $solicitudModel->editField($id, "nombres2", $nombres2);
          $solicitudModel->editField($id, "apellido1", $apellido1);
          $solicitudModel->editField($id, "apellido2", $apellido2);
          $solicitudModel->editField($id, "sexo", $sexo);
          $solicitudModel->editField($id, "regional", $regional);
          $solicitudModel->editField($id, "tipo_documento", $tipo_documento);
          $solicitudModel->editField($id, "documento", $documento);
          $solicitudModel->editField($id, "dependencia", $dependencia);
          $solicitudModel->editField($id, "direccion_oficina", $direccion_oficina);
          $solicitudModel->editField($id, "nivel_escolaridad", $nivel_escolaridad);
          $solicitudModel->editField($id, "telefono_oficina", $telefono_oficina);
          $solicitudModel->editField($id, "direccion_residencia", $direccion_residencia);
          $solicitudModel->editField($id, "personas_cargo", $personas_cargo);
          $solicitudModel->editField($id, "barrio", $barrio);
          $solicitudModel->editField($id, "ciudad_residencia", $ciudad_residencia);
          $solicitudModel->editField($id, "telefono", $telefono);
          $solicitudModel->editField($id, "correo_empresarial", $correo_empresarial);
          $solicitudModel->editField($id, "correo_personal", $correo_personal);
          $solicitudModel->editField($id, "situacion_laboral", $situacion_laboral);
          $solicitudModel->editField($id, "cual", $cual);
          $solicitudModel->editField($id, "ocupacion", $ocupacion);
          $solicitudModel->editField($id, "estado_civil", $estado_civil);
          $solicitudModel->editField($id, "peso", $peso);
          $solicitudModel->editField($id, "estatura", $estatura);
          $solicitudModel->editField($id, "conyuge_nombre", $conyuge_nombre);
          $solicitudModel->editField($id, "conyuge_telefono", $conyuge_telefono);
          $solicitudModel->editField($id, "conyuge_celular", $conyuge_celular);
          $solicitudModel->editField($id, "declara_renta", $declara_renta);
          $solicitudModel->editField($id, "persona_publica", $persona_publica);
          $solicitudModel->editField($id, "persona_expuesta", $persona_expuesta);
          $solicitudModel->editField($id, "persona_expuesta_indique", $persona_expuesta_indique);
          $solicitudModel->editField($id, "persona_publica_indique", $persona_publica_indique);
          $solicitudModel->editField($id, "persona_internacional", $persona_internacional);
          $solicitudModel->editField($id, "persona_internacional_indique", $persona_internacional_indique);
          $solicitudModel->editField($id, "vinculo_pep", $vinculo_pep);
          $solicitudModel->editField($id, "vinculo_pep_indique", $vinculo_pep_indique);
          $solicitudModel->editField($id, "obligaciones_tributarias", $obligaciones_tributarias);
          $solicitudModel->editField($id, "obligaciones_tributarias_indique", $obligaciones_tributarias_indique);
          $solicitudModel->editField($id, "fecha_nacimiento", $fecha_nacimiento);
          $solicitudModel->editField($id, "fecha_documento", $fecha_documento);
          $solicitudModel->editField($id, "celular", $celular);
          $solicitudModel->editField($id, "ciudad_oficina", $ciudad_oficina);
          $solicitudModel->editField($id, "ciudad_documento", $ciudad_documento);
          $solicitudModel->editField($id, "cuenta_numero", $cuenta_numero);
          $solicitudModel->editField($id, "cuenta_tipo", $cuenta_tipo);
          $solicitudModel->editField($id, "entidad_bancaria", $entidad_bancaria);
          $solicitudModel->editField($id, "empresa", $empresa);

          //fedeaa
          $solicitudModel->editField($id, "tipo_vivienda", $tipo_vivienda);
          $solicitudModel->editField($id, "origen_ingresos", $origen_ingresos);
          $solicitudModel->editField($id, "ciiu", $ciiu);
          $solicitudModel->editField($id, "estrato", $estrato);
          $solicitudModel->editField($id, "fecha_ingreso", $fecha_ingreso);
          $solicitudModel->editField($id, "cargo", $cargo);
          $solicitudModel->editField($id, "fecha_afiliacion", $fecha_afiliacion);
          //$solicitudModel->editField($id,"personas_cargo",$personas_cargo);
          $solicitudModel->editField($id, "numero_hijos", $numero_hijos);
          $solicitudModel->editField($id, "nomenclatura1", $nomenclatura1);
          $solicitudModel->editField($id, "nomenclatura2", $nomenclatura2);
          //fedeaa
          //FONDTODOS
          $solicitudModel->editField($id, "recoger_credito", $recoger_credito);
          $solicitudModel->editField($id, "numeros_recogidos", $numeros_recogidos);
          $solicitudModel->editField($id, "valor_recogidos", $valor_recogidos);
          $solicitudModel->editField($id, "valor_fm", $valor_fm);

          $solicitudModel->editField($id, "salario", $salario);
          $solicitudModel->editField($id, "numero_asignado", $numero_asignado);
          //FONDTODOS
        }

        $paso = 4;
        if ($paso == "4") {

          $referenciasModel = new Administracion_Model_DbTable_Referencias();
          $referenciasModel->borrar($id);

          for ($i = 1; $i <= 4; $i++) {
            $nombres = $_POST['nombres' . $i];
            $parentesco = $_POST['parentesco' . $i];
            $direccion = $_POST['direccion' . $i];
            $ciudad = $_POST['ciudad' . $i];
            $telefono = $_POST['telefono' . $i];
            $celular = $_POST['celular' . $i];
            $departamento = $_POST['departamento' . $i];
            $actividad = $_POST['actividad' . $i];
            $empresa = $_POST['nombre_empresa' . $i];
            $telefono_empresa = $_POST['telefono_empresa' . $i];
            $cargo = $_POST['cargo' . $i];
            $nomenclatura = $_POST['nomenclatura' . $i];
            $correo = $_POST['correo' . $i];

            $data['solicitud'] = $id;
            $data['tipo'] = 0;
            $data['numero'] = $i;
            $data['nombres'] = $nombres;
            $data['parentesco'] = $parentesco;
            $data['direccion'] = $direccion;
            $data['ciudad'] = $ciudad;
            $data['telefono'] = $telefono;
            $data['celular'] = $celular;
            $data['departamento'] = $departamento;
            $data['actividad'] = $actividad;
            $data['empresa'] = $empresa;
            $data['cargo'] = $cargo;
            $data['telefono_empresa'] = $telefono_empresa;
            $data['nomenclatura'] = $nomenclatura;
            $data['correo'] = $correo;
            $referenciasModel->insert($data);

            $existe = $referenciasModel->getList(" solicitud='$id' AND numero='$i' ", "");
            if (count($existe) > 0) {
              $id_referencia = $existe[0]->id;
              $referenciasModel->editField($id_referencia, "nombres", $nombres);
              $referenciasModel->editField($id_referencia, "parentesco", $parentesco);
              $referenciasModel->editField($id_referencia, "nomenclatura", $nomenclatura);
              $referenciasModel->editField($id_referencia, "direccion", $direccion);
              $referenciasModel->editField($id_referencia, "ciudad", $ciudad);
              $referenciasModel->editField($id_referencia, "telefono", $telefono);
              $referenciasModel->editField($id_referencia, "celular", $celular);
              $referenciasModel->editField($id_referencia, "departamento", $departamento);
              $referenciasModel->editField($id_referencia, "actividad", $actividad);
              $referenciasModel->editField($id_referencia, "empresa", $empresa);
              $referenciasModel->editField($id_referencia, "cargo", $cargo);
              $referenciasModel->editField($id_referencia, "telefono_empresa", $telefono_empresa);
              $referenciasModel->editField($id_referencia, "correo", $correo);
            }
          }
        }

        $paso = 5;
        if ($paso == "5") {

          $FM_meses = $FM_meses * 1;
          $FM_meses = 0;

          $solicitudModel->editField($id, "tipo_garantia", $tipo_garantia);
          $solicitudModel->editField($id, "FM_meses", $FM_meses);

          $codeudorModel = new Administracion_Model_DbTable_Codeudor();
          if ($tipo_garantia != "") {
            $afianzafondosModel = new Administracion_Model_DbTable_Archivosafianzafondos();
            $data['archivo'] = $this->afianzafondospdf($id);
            $data['solicitud'] = $id;
            $data['fecha'] = date("Y-m-d h:i:s");
            //$afianzafondosModel->insert($data);
          }
          if ($tipo_garantia == "2") {

            $codeudorModel->borrar($id);

            //codeudor1
            $data['solicitud'] = $id;
            $data['cedula'] = $documento_codeudor;
            $data['nombres'] = $nombres_codeudor;
            $data['nombres2'] = $nombres2_codeudor;
            $data['apellido1'] = $apellido1_codeudor;
            $data['apellido2'] = $apellido2_codeudor;
            $data['salario'] = 0;
            $data['correo'] = $correo_personal_codeudor;
            $data['codeudor_numero'] = "1";
            $codeudorModel->insert($data);

            //codeudor2
            $data['solicitud'] = $id;
            $data['cedula'] = $documento_codeudor2;
            $data['nombres'] = $nombres_codeudor2;
            $data['nombres2'] = $nombres2_codeudor2;
            $data['apellido1'] = $apellido1_codeudor2;
            $data['apellido2'] = $apellido2_codeudor2;
            $data['salario'] = 0;
            $data['correo'] = $correo_personal_codeudor2;
            $data['codeudor_numero'] = "2";
            if ($documento_codeudor2 != "") {
              $codeudorModel->insert($data);
            }
          }
        }

        $paso = 6;
        if ($paso == "6") {

          $documentosModel = new Administracion_Model_DbTable_Documentos();

          $data['solicitud'] = $id;
          $data['tipo'] = 1;
          $documentosModel->insert2($data);

          $data['solicitud'] = $id;
          $data['tipo'] = 2;
          $documentosModel->insert2($data);

          $data['solicitud'] = $id;
          $data['tipo'] = 3;
          $documentosModel->insert2($data);

          $uploadImage =  new Core_Model_Upload_Document();

          //archivos asociado
          $error_archivo = false;
          $tipo = 1;
          if ($_FILES['cedula']['name'] != '') {
            $archivo = $uploadImage->upload("cedula");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('cedula', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['formulario_seguro']['name'] != '') {
            $archivo = $uploadImage->upload("formulario_seguro");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('formulario_seguro', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['desprendible_pago']['name'] != '') {
            $archivo = $uploadImage->upload("desprendible_pago");
            //$archivo="";
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('desprendible_pago', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['desprendible_pago2']['name'] != '') {
            $archivo = $uploadImage->upload("desprendible_pago2");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('desprendible_pago2', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['desprendible_pago3']['name'] != '') {
            $archivo = $uploadImage->upload("desprendible_pago3");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('desprendible_pago3', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['desprendible_pago4']['name'] != '') {
            $archivo = $uploadImage->upload("desprendible_pago4");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('desprendible_pago4', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['desprendible_pago5']['name'] != '') {
            $archivo = $uploadImage->upload("desprendible_pago5");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('desprendible_pago5', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['certificado_laboral']['name'] != '') {
            $archivo = $uploadImage->upload("certificado_laboral");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('certificado_laboral', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['otros_ingresos']['name'] != '') {
            $archivo = $uploadImage->upload("otros_ingresos");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('otros_ingresos', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['certificado_tradicion']['name'] != '') {
            $archivo = $uploadImage->upload("certificado_tradicion");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('certificado_tradicion', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['estado_obligacion']['name'] != '') {
            $archivo = $uploadImage->upload("estado_obligacion");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('estado_obligacion', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['estado_obligacion2']['name'] != '') {
            $archivo = $uploadImage->upload("estado_obligacion2");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('estado_obligacion2', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['estado_obligacion3']['name'] != '') {
            $archivo = $uploadImage->upload("estado_obligacion3");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('estado_obligacion3', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['factura_proforma']['name'] != '') {
            $archivo = $uploadImage->upload("factura_proforma");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('factura_proforma', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['recibo_matricula']['name'] != '') {
            $archivo = $uploadImage->upload("recibo_matricula");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('recibo_matricula', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['contrato_vivienda']['name'] != '') {
            $archivo = $uploadImage->upload("contrato_vivienda");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('contrato_vivienda', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['declaracion_renta']['name'] != '') {
            $archivo = $uploadImage->upload("declaracion_renta");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('declaracion_renta', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['orden_medica']['name'] != '') {
            $archivo = $uploadImage->upload("orden_medica");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('orden_medica', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['certificacion']['name'] != '') {
            $archivo = $uploadImage->upload("certificacion");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('certificacion', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['cotizacion']['name'] != '') {
            $archivo = $uploadImage->upload("cotizacion");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('cotizacion', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['peritaje_vehiculo']['name'] != '') {
            $archivo = $uploadImage->upload("peritaje_vehiculo");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('peritaje_vehiculo', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['evidencia_calamidad']['name'] != '') {
            $archivo = $uploadImage->upload("evidencia_calamidad");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('evidencia_calamidad', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['impuesto_vehiculo']['name'] != '') {
            $archivo = $uploadImage->upload("impuesto_vehiculo");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('impuesto_vehiculo', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['soat']['name'] != '') {
            $archivo = $uploadImage->upload("soat");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('soat', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['documento_recoge_creditos']['name'] != '') {
            $archivo = $uploadImage->upload("documento_recoge_creditos");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('documento_recoge_creditos', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['otros_documentos1']['name'] != '') {
            $archivo = $uploadImage->upload("otros_documentos1");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('otros_documentos1', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['otros_documentos2']['name'] != '') {
            $archivo = $uploadImage->upload("otros_documentos2");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('otros_documentos2', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['otros_documentos3']['name'] != '') {
            $archivo = $uploadImage->upload("otros_documentos3");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('otros_documentos3', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['otros_documentos4']['name'] != '') {
            $archivo = $uploadImage->upload("otros_documentos4");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('otros_documentos4', $archivo, $data['solicitud'], $tipo);
          }
          if ($_FILES['otros_documentos5']['name'] != '') {
            $archivo = $uploadImage->upload("otros_documentos5");
            if (!$archivo) {
              $error_archivo = true;
            }
            $documentosModel->editar('otros_documentos5', $archivo, $data['solicitud'], $tipo);
          }
          $data['log_log'] = print_r($_FILES, true);
          $data['log_tipo'] = 'SOLICITUD DOCUMENTOS-' . $id;
          $logModel = new Administracion_Model_DbTable_Log();
          $logModel->insert($data);
          //archivos asociado

          //archivos codeudor
          if ($solicitud->tipo_garantia == "2") {
            $tipo = 2;
            if ($_FILES['cedula2']['name'] != '') {
              $archivo = $uploadImage->upload("cedula2");
              $documentosModel->editar('cedula', $archivo, $data['solicitud'], $tipo);
            }
            if ($_FILES['desprendible_pagoB']['name'] != '') {
              $archivo = $uploadImage->upload("desprendible_pagoB");
              $documentosModel->editar('desprendible_pago', $archivo, $data['solicitud'], $tipo);
            }
            if ($_FILES['desprendible_pagoB2']['name'] != '') {
              $archivo = $uploadImage->upload("desprendible_pagoB2");
              $documentosModel->editar('desprendible_pago2', $archivo, $data['solicitud'], $tipo);
            }
            if ($_FILES['desprendible_pagoB3']['name'] != '') {
              $archivo = $uploadImage->upload("desprendible_pagoB3");
              $documentosModel->editar('desprendible_pago3', $archivo, $data['solicitud'], $tipo);
            }
            if ($_FILES['desprendible_pagoB4']['name'] != '') {
              $archivo = $uploadImage->upload("desprendible_pagoB4");
              $documentosModel->editar('desprendible_pago4', $archivo, $data['solicitud'], $tipo);
            }
            if ($_FILES['desprendible_pagoB5']['name'] != '') {
              $archivo = $uploadImage->upload("desprendible_pagoB5");
              $documentosModel->editar('desprendible_pago4', $archivo, $data['solicitud'], $tipo);
            }
            if ($_FILES['certificado_laboral2']['name'] != '') {
              $archivo = $uploadImage->upload("certificado_laboral2");
              $documentosModel->editar('certificado_laboral', $archivo, $data['solicitud'], $tipo);
            }
            if ($_FILES['otros_ingresos2']['name'] != '') {
              $archivo = $uploadImage->upload("otros_ingresos2");
              $documentosModel->editar('otros_ingresos', $archivo, $data['solicitud'], $tipo);
            }
            if ($_FILES['certificado_tradicionB']['name'] != '') {
              $archivo = $uploadImage->upload("certificado_tradicionB");
              $documentosModel->editar('certificado_tradicion', $archivo, $data['solicitud'], $tipo);
            }
            if ($_FILES['estado_obligacionB']['name'] != '') {
              $archivo = $uploadImage->upload("estado_obligacionB");
              $documentosModel->editar('estado_obligacion', $archivo, $data['solicitud'], $tipo);
            }
            if ($_FILES['estado_obligacion2B']['name'] != '') {
              $archivo = $uploadImage->upload("estado_obligacion2B");
              $documentosModel->editar('estado_obligacion2', $archivo, $data['solicitud'], $tipo);
            }
            if ($_FILES['estado_obligacion3B']['name'] != '') {
              $archivo = $uploadImage->upload("estado_obligacion3B");
              $documentosModel->editar('estado_obligacion3', $archivo, $data['solicitud'], $tipo);
            }
            if ($_FILES['factura_proformaB']['name'] != '') {
              $archivo = $uploadImage->upload("factura_proformaB");
              $documentosModel->editar('factura_proforma', $archivo, $data['solicitud'], $tipo);
            }
            if ($_FILES['recibo_matriculaB']['name'] != '') {
              $archivo = $uploadImage->upload("recibo_matriculaB");
              $documentosModel->editar('recibo_matricula', $archivo, $data['solicitud'], $tipo);
            }
          }
          $docs_log_model = new Administracion_Model_DbTable_Documentslog();

          $array_documents_log = array();

          $array_documents_log['log_date'] = date('Y-m-d H:i:s');
          $array_documents_log['log_solicitud'] = $data['solicitud'];
          $array_documents_log['log_log'] = print_r($_FILES, true);

          $docs_log_model->insert($array_documents_log);

          //archivos codeudor

        }


        //echo "ENTRO 1";
        if ($error_archivo == true) {
          $solicitudModel->deleteRegister($id);
          header("Location: /page/sistema?error=3");
        } else {
          $solicitudModel->editField($id, "paso", "2");
          header("Location: /page/sistema/terminos/?id=" . $id);
        }
      } else {
        echo "ERROR 1";
        header("Location: /page/sistema/?error=1&linea=".$linea);
      }
    } else {
      echo "ERROR 2";
      header("Location: /page/sistema/?error=2");
    }
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

  public function paso1Action()
  {
    $this->_view->get_monto = $this->_getSanitizedParam("monto");
    $this->_view->seccion = 1;
    $this->_view->contenidos = $this->template->getContent(1);
    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    $this->getLayout()->setData("header", $header);

    $id = $this->_getSanitizedParam("id");
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

    $this->_view->userInfo = $user;
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

    //parametros
    $aux = explode(" ", $user[0]->user_names);

    // $this->_view->apellido1 = $aux[2];
    // $this->_view->apellido2 = $aux[3];
    // $this->_view->nombres = $aux[0];
    // $this->_view->nombres2 = $aux[1];
    $this->_view->apellido1 = $aux[2];
    $this->_view->apellido2 = $aux[3];
    $this->_view->nombres = $aux[0];
    $this->_view->nombres2 = $aux[1];
    $this->_view->direccion_residencia = $user->direccion;
    $this->_view->telefono = $user->telefono;
    $this->_view->barrio = $user->barrio;
    $this->_view->ciudad_residencia = $user->ciudad_residencia;
    $this->_view->correo_empresarial = $user->correo;
    $this->_view->correo_personal = $user[0]->user_email;
    // $this->_view->fecha_nacimiento = $user->fecha_nacimiento;
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
    if ($solicitud->fecha_nacimiento != "") {
      $this->_view->fecha_nacimiento = $solicitud->fecha_nacimiento;
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

  public function paso2Action()
  {

    $id = $this->_getSanitizedParam("id");
    header("Location: /page/sistema/terminos/?id=" . $id);

    $this->_view->seccion = 1;
    $this->_view->contenidos = $this->template->getContent(1);
    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    $this->getLayout()->setData("header", $header);

    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);

    $bancosModel = new Administracion_Model_DbTable_Bancos();
    $this->_view->bancos = $bancosModel->getList("", " nombre ASC ");

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);

    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $user = $usuarioModel->getById($_SESSION['kt_login_id']);



    $cedula = $_SESSION['kt_login_user'];
    if ($this->_getSanitizedParam("usuario") != "") {
      $cedula = $this->_getSanitizedParam("usuario");
    }

    $this->_view->documento = $cedula;



    $infopatrimonialModel = new Administracion_Model_DbTable_Infopatrimonial();

    //info patrimonial
    $concepto = "VIVIENDA";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTRAS";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "HIPOTECA";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "VEHICULO";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTROS";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "PRENDA";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "CLASE";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "PATRIMONIO";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "TARJETAS";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTROS2";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTROS2";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OBLIGACIONES";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "TOTALPATRIMONIAL";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $this->_view->info = $info;
  }



  public function blancoAction()
  {
    $header = "";
    $this->getLayout()->setData("header", $header);
    $this->setLayout('blanco');
  }

  public function requisitospersonalAction()
  {

    $header = "";
    $this->getLayout()->setData("header", $header);
    $this->setLayout('blanco');
  }

  public function fondomutualAction()
  {

    $header = "";
    $this->getLayout()->setData("header", $header);
    $this->setLayout('blanco');

    $id = $this->_getSanitizedParam("id");
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);
    $this->_view->solicitud = $solicitud;

    $valor = $solicitud->valor;
    $this->_view->valor_garantia = $valor * 2 / 100;
  }
  public function afianzafondospdf($id)
  {


    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $this->_view->solicitud = $solicitudModel->getById($id);
    $this->setLayout('blanco');
    $this->getLayout()->setTitle("PDF");
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetHeaderMargin(0);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->AddPage('P', 'A4');
    $pdf->SetFont('helvetica', '', 8);
    $content = $this->_view->getRoutPHP('modules/page/Views/sistema/afianzafondospdf.php');
    $pdf->writeHTML($content, true, false, true, false, '');
    $archivo = 'Afianzafondo' . $id . '.pdf';
    $pdf->Output(FILE_PATH . $archivo, 'F');
    return $archivo;
  }

  public function codeudorAction()
  {

    $header = "";
    $this->getLayout()->setData("header", $header);
    $this->setLayout('blanco');

    $id = $this->_getSanitizedParam("id");
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);

    $bancosModel = new Administracion_Model_DbTable_Bancos();
    $this->_view->bancos = $bancosModel->getList("", " nombre ASC ");

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);

    $codeudorModel = new Administracion_Model_DbTable_Codeudor();
    $codeudor = $codeudorModel->getList(" solicitud='$id' ", "")[0];
    $cedula = $codeudor->cedula;

    $this->_view->documento = $cedula;

    $ultima = $codeudorModel->getList(" cedula='$cedula' ", " id DESC ")[0];

    if ($ultima->nombres != "") {
      $this->_view->nombres = $ultima->nombres;
    }
    if ($ultima->apellido1 != "") {
      $this->_view->apellido1 = $ultima->apellido1;
    }
    if ($ultima->apellido2 != "") {
      $this->_view->apellido2 = $ultima->apellido2;
    }
    if ($ultima->sexo != "") {
      $this->_view->sexo = $ultima->sexo;
    }
    if ($ultima->direccion_residencia != "") {
      $this->_view->direccion_residencia = $ultima->direccion_residencia;
    }
    if ($ultima->telefono != "") {
      $this->_view->telefono = $ultima->telefono;
    }
    if ($ultima->barrio != "") {
      $this->_view->barrio = $ultima->barrio;
    }
    if ($ultima->ciudad_residencia != "") {
      $this->_view->ciudad_residencia = $ultima->ciudad_residencia;
    }
    if ($ultima->correo_empresarial != "") {
      $this->_view->correo_empresarial = $ultima->correo_empresarial;
    }
    if ($ultima->correo_personal != "") {
      $this->_view->correo_personal = $ultima->correo_personal;
    }
    if ($ultima->tipo_documento != "") {
      $this->_view->tipo_documento = $ultima->tipo_documento;
    }
    if ($ultima->empresa != "") {
      $this->_view->empresa = $ultima->empresa;
    }
    if ($ultima->dependencia != "") {
      $this->_view->dependencia = $ultima->dependencia;
    }
    if ($ultima->direccion_oficina != "") {
      $this->_view->direccion_oficina = $ultima->direccion_oficina;
    }
    if ($ultima->telefono_oficina != "") {
      $this->_view->telefono_oficina = $ultima->telefono_oficina;
    }
    if ($ultima->situacion_laboral != "") {
      $this->_view->situacion_laboral = $ultima->situacion_laboral;
    }
    if ($ultima->cual != "") {
      $this->_view->cual = $ultima->cual;
    }
    if ($ultima->declara_renta != "") {
      $this->_view->declara_renta = $ultima->declara_renta;
    }
    if ($ultima->persona_publica != "") {
      $this->_view->persona_publica = $ultima->persona_publica;
    }
    if ($ultima->persona_expuesta != "") {
      $this->_view->persona_expuesta = $ultima->persona_expuesta;
    }
    if ($ultima->persona_expuesta_indique != "") {
      $this->_view->persona_expuesta_indique = $ultima->persona_expuesta_indique;
    }
    if ($ultima->persona_publica_indique != "") {
      $this->_view->persona_publica_indique = $ultima->persona_publica_indique;
    }
    if ($ultima->persona_internacional != "") {
      $this->_view->persona_internacional = $ultima->persona_internacional;
    }
    if ($ultima->persona_internacional_indique != "") {
      $this->_view->persona_internacional_indique = $ultima->persona_internacional_indique;
    }
    if ($ultima->vinculo_pep != "") {
      $this->_view->vinculo_pep = $ultima->vinculo_pep;
    }
    if ($ultima->vinculo_pep_indique != "") {
      $this->_view->vinculo_pep_indique = $ultima->vinculo_pep_indique;
    }
    if ($ultima->obligaciones_tributarias != "") {
      $this->_view->obligaciones_tributarias = $ultima->obligaciones_tributarias;
    }
    if ($ultima->obligaciones_tributarias_indique != "") {
      $this->_view->obligaciones_tributarias_indique = $ultima->obligaciones_tributarias_indique;
    }

    if ($ultima->fecha_nacimiento != "") {
      $this->_view->fecha_nacimiento = $ultima->fecha_nacimiento;
    }
    if ($ultima->fecha_documento != "") {
      $this->_view->fecha_documento = $ultima->fecha_documento;
    }
    if ($ultima->celular != "") {
      $this->_view->celular = $ultima->celular;
    }
    if ($ultima->ciudad_oficina != "") {
      $this->_view->ciudad_oficina = $ultima->ciudad_oficina;
    }
    if ($ultima->ciudad_documento != "") {
      $this->_view->ciudad_documento = $ultima->ciudad_documento;
    }
    if ($ultima->cuenta_numero != "") {
      $this->_view->cuenta_numero = $ultima->cuenta_numero;
    }
    if ($ultima->cuenta_tipo != "") {
      $this->_view->cuenta_tipo = $ultima->cuenta_tipo;
    }
    if ($ultima->entidad_bancaria != "") {
      $this->_view->entidad_bancaria = $ultima->entidad_bancaria;
    }
    if ($ultima->ocupacion != "") {
      $this->_view->ocupacion = $ultima->ocupacion;
    }
    if ($ultima->estado_civil != "") {
      $this->_view->estado_civil = $ultima->estado_civil;
    }
    if ($ultima->peso != "") {
      $this->_view->peso = $ultima->peso;
    }
    if ($ultima->estatura != "") {
      $this->_view->estatura = $ultima->estatura;
    }
    if ($ultima->conyuge_nombre != "") {
      $this->_view->conyuge_nombre = $ultima->conyuge_nombre;
    }
    if ($ultima->conyuge_telefono != "") {
      $this->_view->conyuge_telefono = $ultima->conyuge_telefono;
    }
    if ($ultima->conyuge_celular != "") {
      $this->_view->conyuge_celular = $ultima->conyuge_celular;
    }
    if ($ultima->nomenclatura1 != "") {
      $this->_view->nomenclatura1 = $ultima->nomenclatura1;
    }
    if ($ultima->nomenclatura2 != "") {
      $this->_view->nomenclatura2 = $ultima->nomenclatura2;
    }


    if ($codeudor->nombres != "") {
      $this->_view->nombres = $codeudor->nombres;
    }
    if ($codeudor->apellido1 != "") {
      $this->_view->apellido1 = $codeudor->apellido1;
    }
    if ($codeudor->apellido2 != "") {
      $this->_view->apellido2 = $codeudor->apellido2;
    }
    if ($codeudor->sexo != "") {
      $this->_view->sexo = $codeudor->sexo;
    }
    if ($codeudor->direccion_residencia != "") {
      $this->_view->direccion_residencia = $codeudor->direccion_residencia;
    }
    if ($codeudor->telefono != "") {
      $this->_view->telefono = $codeudor->telefono;
    }
    if ($codeudor->barrio != "") {
      $this->_view->barrio = $codeudor->barrio;
    }
    if ($codeudor->ciudad_residencia != "") {
      $this->_view->ciudad_residencia = $codeudor->ciudad_residencia;
    }
    if ($codeudor->correo_empresarial != "") {
      $this->_view->correo_empresarial = $codeudor->correo_empresarial;
    }
    if ($codeudor->correo_personal != "") {
      $this->_view->correo_personal = $codeudor->correo_personal;
    }
    if ($codeudor->tipo_documento != "") {
      $this->_view->tipo_documento = $codeudor->tipo_documento;
    }
    if ($codeudor->empresa != "") {
      $this->_view->empresa = $codeudor->empresa;
    }
    if ($codeudor->dependencia != "") {
      $this->_view->dependencia = $codeudor->dependencia;
    }
    if ($codeudor->direccion_oficina != "") {
      $this->_view->direccion_oficina = $codeudor->direccion_oficina;
    }
    if ($codeudor->telefono_oficina != "") {
      $this->_view->telefono_oficina = $codeudor->telefono_oficina;
    }
    if ($codeudor->situacion_laboral != "") {
      $this->_view->situacion_laboral = $codeudor->situacion_laboral;
    }
    if ($codeudor->cual != "") {
      $this->_view->cual = $codeudor->cual;
    }
    if ($codeudor->declara_renta != "") {
      $this->_view->declara_renta = $codeudor->declara_renta;
    }
    if ($codeudor->persona_publica != "") {
      $this->_view->persona_publica = $codeudor->persona_publica;
    }
    if ($codeudor->fecha_nacimiento != "") {
      $this->_view->fecha_nacimiento = $codeudor->fecha_nacimiento;
    }
    if ($codeudor->fecha_documento != "") {
      $this->_view->fecha_documento = $codeudor->fecha_documento;
    }
    if ($codeudor->celular != "") {
      $this->_view->celular = $codeudor->celular;
    }
    if ($codeudor->ciudad_oficina != "") {
      $this->_view->ciudad_oficina = $codeudor->ciudad_oficina;
    }
    if ($codeudor->ciudad_documento != "") {
      $this->_view->ciudad_documento = $codeudor->ciudad_documento;
    }
    if ($codeudor->cuenta_numero != "") {
      $this->_view->cuenta_numero = $codeudor->cuenta_numero;
    }
    if ($codeudor->cuenta_tipo != "") {
      $this->_view->cuenta_tipo = $codeudor->cuenta_tipo;
    }
    if ($codeudor->entidad_bancaria != "") {
      $this->_view->entidad_bancaria = $codeudor->entidad_bancaria;
    }
    if ($codeudor->ocupacion != "") {
      $this->_view->ocupacion = $codeudor->ocupacion;
    }
    if ($codeudor->estado_civil != "") {
      $this->_view->estado_civil = $codeudor->estado_civil;
    }
    if ($codeudor->peso != "") {
      $this->_view->peso = $codeudor->peso;
    }
    if ($codeudor->estatura != "") {
      $this->_view->estatura = $codeudor->estatura;
    }
    if ($codeudor->conyuge_nombre != "") {
      $this->_view->conyuge_nombre = $codeudor->conyuge_nombre;
    }
    if ($codeudor->conyuge_telefono != "") {
      $this->_view->conyuge_telefono = $codeudor->conyuge_telefono;
    }
    if ($codeudor->conyuge_celular != "") {
      $this->_view->conyuge_celular = $codeudor->conyuge_celular;
    }
    if ($codeudor->nomenclatura1 != "") {
      $this->_view->nomenclatura1 = $codeudor->nomenclatura1;
    }
    if ($codeudor->nomenclatura2 != "") {
      $this->_view->nomenclatura2 = $codeudor->nomenclatura2;
    }
    //parametros


    $infopatrimonialModel = new Administracion_Model_DbTable_Infopatrimonial();

    //info patrimonial
    $concepto = "VIVIENDA";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTRAS";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "HIPOTECA";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "VEHICULO";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTROS";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "PRENDA";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "CLASE";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "PATRIMONIO";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "TARJETAS";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTROS2";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTROS2";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OBLIGACIONES";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "TOTALPATRIMONIAL";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $this->_view->info = $info;


    //INFO FINANCIERA
    $financieraModel = new Administracion_Model_DbTable_Infofinanciera();
    $financiera = $financieraModel->getList(" solicitud='$id' AND cedula='$cedula' ", "")[0];
    if (count($financiera) == 0) {
      $ultima_id = $ultima->id;
      $financiera = $financieraModel->getList(" solicitud='$ultima_id' AND cedula='$cedula' ", "")[0];
    }
    $this->_view->financiera = $financiera;

    $infopatrimonialModel = new Administracion_Model_DbTable_Infopatrimonial();
    $concepto = "PATRIMONIO";
    $info = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $v1 = $info->v3;
    $concepto = "OBLIGACIONES";
    $info = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $v2 = $info->v3;

    $this->_view->total_obligaciones = $v1 + $v2;

    $ciudadModel = new Administracion_Model_DbTable_Ciudad();
    $this->_view->ciudades = $ciudadModel->getList("", " nombre ASC ");
  }

  public function codeudorparcialAction()
  {

    $header = "";
    $this->getLayout()->setData("header", $header);
    $this->setLayout('blanco');

    $id = $this->_getSanitizedParam("id");
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);

    $bancosModel = new Administracion_Model_DbTable_Bancos();
    $this->_view->bancos = $bancosModel->getList("", " nombre ASC ");

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);

    $codeudorModel = new Administracion_Model_DbTable_Codeudor();
    $codeudor = $codeudorModel->getList(" solicitud='$id' ", "")[0];
    $cedula = $codeudor->cedula;

    $this->_view->documento = $cedula;

    $ultima = $codeudorModel->getList(" cedula='$cedula' ", " id DESC ")[0];

    if ($ultima->nombres != "") {
      $this->_view->nombres = $ultima->nombres;
    }
    if ($ultima->apellido1 != "") {
      $this->_view->apellido1 = $ultima->apellido1;
    }
    if ($ultima->apellido2 != "") {
      $this->_view->apellido2 = $ultima->apellido2;
    }
    if ($ultima->sexo != "") {
      $this->_view->sexo = $ultima->sexo;
    }
    if ($ultima->direccion_residencia != "") {
      $this->_view->direccion_residencia = $ultima->direccion_residencia;
    }
    if ($ultima->telefono != "") {
      $this->_view->telefono = $ultima->telefono;
    }
    if ($ultima->barrio != "") {
      $this->_view->barrio = $ultima->barrio;
    }
    if ($ultima->ciudad_residencia != "") {
      $this->_view->ciudad_residencia = $ultima->ciudad_residencia;
    }
    if ($ultima->correo_empresarial != "") {
      $this->_view->correo_empresarial = $ultima->correo_empresarial;
    }
    if ($ultima->correo_personal != "") {
      $this->_view->correo_personal = $ultima->correo_personal;
    }
    if ($ultima->tipo_documento != "") {
      $this->_view->tipo_documento = $ultima->tipo_documento;
    }
    if ($ultima->empresa != "") {
      $this->_view->empresa = $ultima->empresa;
    }
    if ($ultima->dependencia != "") {
      $this->_view->dependencia = $ultima->dependencia;
    }
    if ($ultima->direccion_oficina != "") {
      $this->_view->direccion_oficina = $ultima->direccion_oficina;
    }
    if ($ultima->telefono_oficina != "") {
      $this->_view->telefono_oficina = $ultima->telefono_oficina;
    }
    if ($ultima->situacion_laboral != "") {
      $this->_view->situacion_laboral = $ultima->situacion_laboral;
    }
    if ($ultima->cual != "") {
      $this->_view->cual = $ultima->cual;
    }
    if ($ultima->declara_renta != "") {
      $this->_view->declara_renta = $ultima->declara_renta;
    }
    if ($ultima->persona_publica != "") {
      $this->_view->persona_publica = $ultima->persona_publica;
    }
    if ($ultima->persona_expuesta != "") {
      $this->_view->persona_expuesta = $ultima->persona_expuesta;
    }
    if ($ultima->persona_expuesta_indique != "") {
      $this->_view->persona_expuesta_indique = $ultima->persona_expuesta_indique;
    }
    if ($ultima->persona_publica_indique != "") {
      $this->_view->persona_publica_indique = $ultima->persona_publica_indique;
    }
    if ($ultima->persona_internacional != "") {
      $this->_view->persona_internacional = $ultima->persona_internacional;
    }
    if ($ultima->persona_internacional_indique != "") {
      $this->_view->persona_internacional_indique = $ultima->persona_internacional_indique;
    }
    if ($ultima->vinculo_pep != "") {
      $this->_view->vinculo_pep = $ultima->vinculo_pep;
    }
    if ($ultima->vinculo_pep_indique != "") {
      $this->_view->vinculo_pep_indique = $ultima->vinculo_pep_indique;
    }
    if ($ultima->obligaciones_tributarias != "") {
      $this->_view->obligaciones_tributarias = $ultima->obligaciones_tributarias;
    }
    if ($ultima->obligaciones_tributarias_indique != "") {
      $this->_view->obligaciones_tributarias_indique = $ultima->obligaciones_tributarias_indique;
    }
    if ($ultima->fecha_nacimiento != "") {
      $this->_view->fecha_nacimiento = $ultima->fecha_nacimiento;
    }
    if ($ultima->fecha_documento != "") {
      $this->_view->fecha_documento = $ultima->fecha_documento;
    }
    if ($ultima->celular != "") {
      $this->_view->celular = $ultima->celular;
    }
    if ($ultima->ciudad_oficina != "") {
      $this->_view->ciudad_oficina = $ultima->ciudad_oficina;
    }
    if ($ultima->ciudad_documento != "") {
      $this->_view->ciudad_documento = $ultima->ciudad_documento;
    }
    if ($ultima->cuenta_numero != "") {
      $this->_view->cuenta_numero = $ultima->cuenta_numero;
    }
    if ($ultima->cuenta_tipo != "") {
      $this->_view->cuenta_tipo = $ultima->cuenta_tipo;
    }
    if ($ultima->entidad_bancaria != "") {
      $this->_view->entidad_bancaria = $ultima->entidad_bancaria;
    }
    if ($ultima->ocupacion != "") {
      $this->_view->ocupacion = $ultima->ocupacion;
    }
    if ($ultima->estado_civil != "") {
      $this->_view->estado_civil = $ultima->estado_civil;
    }
    if ($ultima->peso != "") {
      $this->_view->peso = $ultima->peso;
    }
    if ($ultima->estatura != "") {
      $this->_view->estatura = $ultima->estatura;
    }
    if ($ultima->conyuge_nombre != "") {
      $this->_view->conyuge_nombre = $ultima->conyuge_nombre;
    }
    if ($ultima->conyuge_telefono != "") {
      $this->_view->conyuge_telefono = $ultima->conyuge_telefono;
    }
    if ($ultima->conyuge_celular != "") {
      $this->_view->conyuge_celular = $ultima->conyuge_celular;
    }
    if ($ultima->nomenclatura1 != "") {
      $this->_view->nomenclatura1 = $ultima->nomenclatura1;
    }
    if ($ultima->nomenclatura2 != "") {
      $this->_view->nomenclatura2 = $ultima->nomenclatura2;
    }


    if ($codeudor->nombres != "") {
      $this->_view->nombres = $codeudor->nombres;
    }
    if ($codeudor->apellido1 != "") {
      $this->_view->apellido1 = $codeudor->apellido1;
    }
    if ($codeudor->apellido2 != "") {
      $this->_view->apellido2 = $codeudor->apellido2;
    }
    if ($codeudor->sexo != "") {
      $this->_view->sexo = $codeudor->sexo;
    }
    if ($codeudor->direccion_residencia != "") {
      $this->_view->direccion_residencia = $codeudor->direccion_residencia;
    }
    if ($codeudor->telefono != "") {
      $this->_view->telefono = $codeudor->telefono;
    }
    if ($codeudor->barrio != "") {
      $this->_view->barrio = $codeudor->barrio;
    }
    if ($codeudor->ciudad_residencia != "") {
      $this->_view->ciudad_residencia = $codeudor->ciudad_residencia;
    }
    if ($codeudor->correo_empresarial != "") {
      $this->_view->correo_empresarial = $codeudor->correo_empresarial;
    }
    if ($codeudor->correo_personal != "") {
      $this->_view->correo_personal = $codeudor->correo_personal;
    }
    if ($codeudor->tipo_documento != "") {
      $this->_view->tipo_documento = $codeudor->tipo_documento;
    }
    if ($codeudor->empresa != "") {
      $this->_view->empresa = $codeudor->empresa;
    }
    if ($codeudor->dependencia != "") {
      $this->_view->dependencia = $codeudor->dependencia;
    }
    if ($codeudor->direccion_oficina != "") {
      $this->_view->direccion_oficina = $codeudor->direccion_oficina;
    }
    if ($codeudor->telefono_oficina != "") {
      $this->_view->telefono_oficina = $codeudor->telefono_oficina;
    }
    if ($codeudor->situacion_laboral != "") {
      $this->_view->situacion_laboral = $codeudor->situacion_laboral;
    }
    if ($codeudor->cual != "") {
      $this->_view->cual = $codeudor->cual;
    }
    if ($codeudor->declara_renta != "") {
      $this->_view->declara_renta = $codeudor->declara_renta;
    }
    if ($codeudor->persona_publica != "") {
      $this->_view->persona_publica = $codeudor->persona_publica;
    }
    if ($codeudor->fecha_nacimiento != "") {
      $this->_view->fecha_nacimiento = $codeudor->fecha_nacimiento;
    }
    if ($codeudor->fecha_documento != "") {
      $this->_view->fecha_documento = $codeudor->fecha_documento;
    }
    if ($codeudor->celular != "") {
      $this->_view->celular = $codeudor->celular;
    }
    if ($codeudor->ciudad_oficina != "") {
      $this->_view->ciudad_oficina = $codeudor->ciudad_oficina;
    }
    if ($codeudor->ciudad_documento != "") {
      $this->_view->ciudad_documento = $codeudor->ciudad_documento;
    }
    if ($codeudor->cuenta_numero != "") {
      $this->_view->cuenta_numero = $codeudor->cuenta_numero;
    }
    if ($codeudor->cuenta_tipo != "") {
      $this->_view->cuenta_tipo = $codeudor->cuenta_tipo;
    }
    if ($codeudor->entidad_bancaria != "") {
      $this->_view->entidad_bancaria = $codeudor->entidad_bancaria;
    }
    if ($codeudor->ocupacion != "") {
      $this->_view->ocupacion = $codeudor->ocupacion;
    }
    if ($codeudor->estado_civil != "") {
      $this->_view->estado_civil = $codeudor->estado_civil;
    }
    if ($codeudor->peso != "") {
      $this->_view->peso = $codeudor->peso;
    }
    if ($codeudor->estatura != "") {
      $this->_view->estatura = $codeudor->estatura;
    }
    if ($codeudor->conyuge_nombre != "") {
      $this->_view->conyuge_nombre = $codeudor->conyuge_nombre;
    }
    if ($codeudor->conyuge_telefono != "") {
      $this->_view->conyuge_telefono = $codeudor->conyuge_telefono;
    }
    if ($codeudor->conyuge_celular != "") {
      $this->_view->conyuge_celular = $codeudor->conyuge_celular;
    }
    if ($codeudor->nomenclatura1 != "") {
      $this->_view->nomenclatura1 = $codeudor->nomenclatura1;
    }
    if ($codeudor->nomenclatura2 != "") {
      $this->_view->nomenclatura2 = $codeudor->nomenclatura2;
    }
    //parametros


    $infopatrimonialModel = new Administracion_Model_DbTable_Infopatrimonial();

    //info patrimonial
    $concepto = "VIVIENDA";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTRAS";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "HIPOTECA";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "VEHICULO";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTROS";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "PRENDA";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "CLASE";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "PATRIMONIO";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "TARJETAS";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTROS2";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTROS2";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OBLIGACIONES";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "TOTALPATRIMONIAL";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $this->_view->info = $info;


    //INFO FINANCIERA
    $financieraModel = new Administracion_Model_DbTable_Infofinanciera();
    $financiera = $financieraModel->getList(" solicitud='$id' AND cedula='$cedula' ", "")[0];
    if (count($financiera) == 0) {
      $ultima_id = $ultima->id;
      $financiera = $financieraModel->getList(" solicitud='$ultima_id' AND cedula='$cedula' ", "")[0];
    }
    $this->_view->financiera = $financiera;

    $infopatrimonialModel = new Administracion_Model_DbTable_Infopatrimonial();
    $concepto = "PATRIMONIO";
    $info = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $v1 = $info->v3;
    $concepto = "OBLIGACIONES";
    $info = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $v2 = $info->v3;

    $this->_view->total_obligaciones = $v1 + $v2;
  }


  public function codeudorparcial2Action()
  {

    $header = "";
    $this->getLayout()->setData("header", $header);
    $this->setLayout('blanco');

    $id = $this->_getSanitizedParam("id");
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);

    $bancosModel = new Administracion_Model_DbTable_Bancos();
    $this->_view->bancos = $bancosModel->getList("", " nombre ASC ");

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);

    $codeudorModel = new Administracion_Model_DbTable_Codeudor();
    $codeudor = $codeudorModel->getList(" solicitud='$id' ", "")[1];
    $cedula = $codeudor->cedula;

    $this->_view->documento = $cedula;

    $ultima = $codeudorModel->getList(" cedula='$cedula' ", " id DESC ")[0];

    if ($ultima->nombres != "") {
      $this->_view->nombres = $ultima->nombres;
    }
    if ($ultima->apellido1 != "") {
      $this->_view->apellido1 = $ultima->apellido1;
    }
    if ($ultima->apellido2 != "") {
      $this->_view->apellido2 = $ultima->apellido2;
    }
    if ($ultima->sexo != "") {
      $this->_view->sexo = $ultima->sexo;
    }
    if ($ultima->direccion_residencia != "") {
      $this->_view->direccion_residencia = $ultima->direccion_residencia;
    }
    if ($ultima->telefono != "") {
      $this->_view->telefono = $ultima->telefono;
    }
    if ($ultima->barrio != "") {
      $this->_view->barrio = $ultima->barrio;
    }
    if ($ultima->ciudad_residencia != "") {
      $this->_view->ciudad_residencia = $ultima->ciudad_residencia;
    }
    if ($ultima->correo_empresarial != "") {
      $this->_view->correo_empresarial = $ultima->correo_empresarial;
    }
    if ($ultima->correo_personal != "") {
      $this->_view->correo_personal = $ultima->correo_personal;
    }
    if ($ultima->tipo_documento != "") {
      $this->_view->tipo_documento = $ultima->tipo_documento;
    }
    if ($ultima->empresa != "") {
      $this->_view->empresa = $ultima->empresa;
    }
    if ($ultima->dependencia != "") {
      $this->_view->dependencia = $ultima->dependencia;
    }
    if ($ultima->direccion_oficina != "") {
      $this->_view->direccion_oficina = $ultima->direccion_oficina;
    }
    if ($ultima->telefono_oficina != "") {
      $this->_view->telefono_oficina = $ultima->telefono_oficina;
    }
    if ($ultima->situacion_laboral != "") {
      $this->_view->situacion_laboral = $ultima->situacion_laboral;
    }
    if ($ultima->cual != "") {
      $this->_view->cual = $ultima->cual;
    }
    if ($ultima->declara_renta != "") {
      $this->_view->declara_renta = $ultima->declara_renta;
    }
    if ($ultima->persona_publica != "") {
      $this->_view->persona_publica = $ultima->persona_publica;
    }
    if ($ultima->persona_expuesta != "") {
      $this->_view->persona_expuesta = $ultima->persona_expuesta;
    }
    if ($ultima->persona_expuesta_indique != "") {
      $this->_view->persona_expuesta_indique = $ultima->persona_expuesta_indique;
    }
    if ($ultima->persona_publica_indique != "") {
      $this->_view->persona_publica_indique = $ultima->persona_publica_indique;
    }
    if ($ultima->persona_internacional != "") {
      $this->_view->persona_internacional = $ultima->persona_internacional;
    }
    if ($ultima->persona_internacional_indique != "") {
      $this->_view->persona_internacional_indique = $ultima->persona_internacional_indique;
    }
    if ($ultima->vinculo_pep != "") {
      $this->_view->vinculo_pep = $ultima->vinculo_pep;
    }
    if ($ultima->vinculo_pep_indique != "") {
      $this->_view->vinculo_pep_indique = $ultima->vinculo_pep_indique;
    }
    if ($ultima->obligaciones_tributarias != "") {
      $this->_view->obligaciones_tributarias = $ultima->obligaciones_tributarias;
    }
    if ($ultima->obligaciones_tributarias_indique != "") {
      $this->_view->obligaciones_tributarias_indique = $ultima->obligaciones_tributarias_indique;
    }

    if ($ultima->fecha_nacimiento != "") {
      $this->_view->fecha_nacimiento = $ultima->fecha_nacimiento;
    }
    if ($ultima->fecha_documento != "") {
      $this->_view->fecha_documento = $ultima->fecha_documento;
    }
    if ($ultima->celular != "") {
      $this->_view->celular = $ultima->celular;
    }
    if ($ultima->ciudad_oficina != "") {
      $this->_view->ciudad_oficina = $ultima->ciudad_oficina;
    }
    if ($ultima->ciudad_documento != "") {
      $this->_view->ciudad_documento = $ultima->ciudad_documento;
    }
    if ($ultima->cuenta_numero != "") {
      $this->_view->cuenta_numero = $ultima->cuenta_numero;
    }
    if ($ultima->cuenta_tipo != "") {
      $this->_view->cuenta_tipo = $ultima->cuenta_tipo;
    }
    if ($ultima->entidad_bancaria != "") {
      $this->_view->entidad_bancaria = $ultima->entidad_bancaria;
    }
    if ($ultima->ocupacion != "") {
      $this->_view->ocupacion = $ultima->ocupacion;
    }
    if ($ultima->estado_civil != "") {
      $this->_view->estado_civil = $ultima->estado_civil;
    }
    if ($ultima->peso != "") {
      $this->_view->peso = $ultima->peso;
    }
    if ($ultima->estatura != "") {
      $this->_view->estatura = $ultima->estatura;
    }
    if ($ultima->conyuge_nombre != "") {
      $this->_view->conyuge_nombre = $ultima->conyuge_nombre;
    }
    if ($ultima->conyuge_telefono != "") {
      $this->_view->conyuge_telefono = $ultima->conyuge_telefono;
    }
    if ($ultima->conyuge_celular != "") {
      $this->_view->conyuge_celular = $ultima->conyuge_celular;
    }
    if ($ultima->nomenclatura1 != "") {
      $this->_view->nomenclatura1 = $ultima->nomenclatura1;
    }
    if ($ultima->nomenclatura2 != "") {
      $this->_view->nomenclatura2 = $ultima->nomenclatura2;
    }


    if ($codeudor->nombres != "") {
      $this->_view->nombres = $codeudor->nombres;
    }
    if ($codeudor->apellido1 != "") {
      $this->_view->apellido1 = $codeudor->apellido1;
    }
    if ($codeudor->apellido2 != "") {
      $this->_view->apellido2 = $codeudor->apellido2;
    }
    if ($codeudor->sexo != "") {
      $this->_view->sexo = $codeudor->sexo;
    }
    if ($codeudor->direccion_residencia != "") {
      $this->_view->direccion_residencia = $codeudor->direccion_residencia;
    }
    if ($codeudor->telefono != "") {
      $this->_view->telefono = $codeudor->telefono;
    }
    if ($codeudor->barrio != "") {
      $this->_view->barrio = $codeudor->barrio;
    }
    if ($codeudor->ciudad_residencia != "") {
      $this->_view->ciudad_residencia = $codeudor->ciudad_residencia;
    }
    if ($codeudor->correo_empresarial != "") {
      $this->_view->correo_empresarial = $codeudor->correo_empresarial;
    }
    if ($codeudor->correo_personal != "") {
      $this->_view->correo_personal = $codeudor->correo_personal;
    }
    if ($codeudor->tipo_documento != "") {
      $this->_view->tipo_documento = $codeudor->tipo_documento;
    }
    if ($codeudor->empresa != "") {
      $this->_view->empresa = $codeudor->empresa;
    }
    if ($codeudor->dependencia != "") {
      $this->_view->dependencia = $codeudor->dependencia;
    }
    if ($codeudor->direccion_oficina != "") {
      $this->_view->direccion_oficina = $codeudor->direccion_oficina;
    }
    if ($codeudor->telefono_oficina != "") {
      $this->_view->telefono_oficina = $codeudor->telefono_oficina;
    }
    if ($codeudor->situacion_laboral != "") {
      $this->_view->situacion_laboral = $codeudor->situacion_laboral;
    }
    if ($codeudor->cual != "") {
      $this->_view->cual = $codeudor->cual;
    }
    if ($codeudor->declara_renta != "") {
      $this->_view->declara_renta = $codeudor->declara_renta;
    }
    if ($codeudor->persona_publica != "") {
      $this->_view->persona_publica = $codeudor->persona_publica;
    }
    if ($codeudor->fecha_nacimiento != "") {
      $this->_view->fecha_nacimiento = $codeudor->fecha_nacimiento;
    }
    if ($codeudor->fecha_documento != "") {
      $this->_view->fecha_documento = $codeudor->fecha_documento;
    }
    if ($codeudor->celular != "") {
      $this->_view->celular = $codeudor->celular;
    }
    if ($codeudor->ciudad_oficina != "") {
      $this->_view->ciudad_oficina = $codeudor->ciudad_oficina;
    }
    if ($codeudor->ciudad_documento != "") {
      $this->_view->ciudad_documento = $codeudor->ciudad_documento;
    }
    if ($codeudor->cuenta_numero != "") {
      $this->_view->cuenta_numero = $codeudor->cuenta_numero;
    }
    if ($codeudor->cuenta_tipo != "") {
      $this->_view->cuenta_tipo = $codeudor->cuenta_tipo;
    }
    if ($codeudor->entidad_bancaria != "") {
      $this->_view->entidad_bancaria = $codeudor->entidad_bancaria;
    }
    if ($codeudor->ocupacion != "") {
      $this->_view->ocupacion = $codeudor->ocupacion;
    }
    if ($codeudor->estado_civil != "") {
      $this->_view->estado_civil = $codeudor->estado_civil;
    }
    if ($codeudor->peso != "") {
      $this->_view->peso = $codeudor->peso;
    }
    if ($codeudor->estatura != "") {
      $this->_view->estatura = $codeudor->estatura;
    }
    if ($codeudor->conyuge_nombre != "") {
      $this->_view->conyuge_nombre = $codeudor->conyuge_nombre;
    }
    if ($codeudor->conyuge_telefono != "") {
      $this->_view->conyuge_telefono = $codeudor->conyuge_telefono;
    }
    if ($codeudor->conyuge_celular != "") {
      $this->_view->conyuge_celular = $codeudor->conyuge_celular;
    }
    if ($codeudor->nomenclatura1 != "") {
      $this->_view->nomenclatura1 = $codeudor->nomenclatura1;
    }
    if ($codeudor->nomenclatura2 != "") {
      $this->_view->nomenclatura2 = $codeudor->nomenclatura2;
    }
    //parametros


    $infopatrimonialModel = new Administracion_Model_DbTable_Infopatrimonial();

    //info patrimonial
    $concepto = "VIVIENDA";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTRAS";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "HIPOTECA";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "VEHICULO";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTROS";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "PRENDA";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "CLASE";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "PATRIMONIO";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "TARJETAS";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTROS2";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OTROS2";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "OBLIGACIONES";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $concepto = "TOTALPATRIMONIAL";
    $info[$concepto] = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $this->_view->info = $info;


    //INFO FINANCIERA
    $financieraModel = new Administracion_Model_DbTable_Infofinanciera();
    $financiera = $financieraModel->getList(" solicitud='$id' AND cedula='$cedula' ", "")[0];
    if (count($financiera) == 0) {
      $ultima_id = $ultima->id;
      $financiera = $financieraModel->getList(" solicitud='$ultima_id' AND cedula='$cedula' ", "")[0];
    }
    $this->_view->financiera = $financiera;

    $infopatrimonialModel = new Administracion_Model_DbTable_Infopatrimonial();
    $concepto = "PATRIMONIO";
    $info = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $v1 = $info->v3;
    $concepto = "OBLIGACIONES";
    $info = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $v2 = $info->v3;

    $this->_view->total_obligaciones = $v1 + $v2;
  }


  public function paso3Action()
  {
    $this->_view->seccion = 1;
    $this->_view->contenidos = $this->template->getContent(1);
    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    $this->getLayout()->setData("header", $header);

    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);

    $cedula = $_SESSION['kt_login_user'];
    if ($this->_getSanitizedParam("usuario") != "") {
      $cedula = $this->_getSanitizedParam("usuario");
    }
    if ($this->_getSanitizedParam("paso") == "4") {
      $cedula = $codeudor->cedula;
    }

    $cedula = $solicitud->cedula;

    $ultima = $solicitudModel->getList(" cedula='$cedula' AND paso='8' ", " id DESC ")[0];

    if ($solicitud->descripcion_ingresos == "") {
      $solicitud->descripcion_ingresos = $ultima->descripcion_ingresos;
    }
    if ($solicitud->descripcion_recursos == "") {
      $solicitud->descripcion_recursos = $ultima->descripcion_recursos;
    }

    $this->_view->solicitud = $solicitud;


    $financieraModel = new Administracion_Model_DbTable_Infofinanciera();
    $financiera = $financieraModel->getList(" solicitud='$id' AND cedula='$cedula' ", "")[0];
    if (count($financiera) == 0) {
      $ultima_id = $ultima->id;
      $financiera = $financieraModel->getList(" solicitud='$ultima_id' AND cedula='$cedula' ", "")[0];
    }
    $this->_view->financiera = $financiera;

    $infopatrimonialModel = new Administracion_Model_DbTable_Infopatrimonial();
    $concepto = "PATRIMONIO";
    $info = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $v1 = $info->v3;
    $concepto = "OBLIGACIONES";
    $info = $infopatrimonialModel->getList(" solicitud='$id' AND cedula='$cedula' AND concepto='$concepto' ", "")[0];
    $v2 = $info->v3;

    $this->_view->total_obligaciones = $v1 + $v2;
  }


  public function paso4Action()
  {

    $this->_view->seccion = 1;
    $this->_view->contenidos = $this->template->getContent(1);
    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    $this->getLayout()->setData("header", $header);

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $solicitud = $solicitudModel->getById($id);
    $paso = $this->_getSanitizedParam("paso");

    $cedula = $solicitud->cedula;
    $ultima = $solicitudModel->getList(" cedula='$cedula' AND paso='8' ", " id DESC ")[0];
    $ultima_id = $ultima->id;

    $referenciasModel = new Administracion_Model_DbTable_Referencias();
    $referencias['1'] = $referenciasModel->getList(" solicitud='$id' AND numero='1' ", "")[0];
    if (!$referencias['1']->id > 0) {
      $referencias['1'] = $referenciasModel->getList(" solicitud='$ultima_id' AND numero='1' ", "")[0];
    }
    $referencias['2'] = $referenciasModel->getList(" solicitud='$id' AND numero='2' ", "")[0];
    if (!$referencias['2']->id > 0) {
      $referencias['2'] = $referenciasModel->getList(" solicitud='$ultima_id' AND numero='2' ", "")[0];
    }
    $referencias['3'] = $referenciasModel->getList(" solicitud='$id' AND numero='3' ", "")[0];
    if (!$referencias['3']->id > 0) {
      $referencias['3'] = $referenciasModel->getList(" solicitud='$ultima_id' AND numero='3' ", "")[0];
    }
    $referencias['4'] = $referenciasModel->getList(" solicitud='$id' AND numero='4' ", "")[0];
    if (!$referencias['4']->id > 0) {
      $referencias['4'] = $referenciasModel->getList(" solicitud='$ultima_id' AND numero='4' ", "")[0];
    }
    $this->_view->referencias = $referencias;

    $parentescoModel = new Administracion_Model_DbTable_Parentescos();
    $this->_view->parentescos = $parentescoModel->getList("", " nombre ASC ");


    $ciudadModel = new Administracion_Model_DbTable_Ciudad();
    $this->_view->ciudades = $ciudadModel->getList("", " nombre ASC ");

    $nomenclaturaModel = new Administracion_Model_DbTable_Nomenclatura();
    $this->_view->nomenclaturas = $nomenclaturas = $nomenclaturaModel->getList("", " codigo ASC ");
  }

  public function paso5Action()
  {

    //$this->_view->seccion = 1;
    //$this->_view->contenidos = $this->template->getContent(1);
    //$header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    //$this->getLayout()->setData("header",$header);
    $this->getLayout()->setData("header", "");
    $this->setLayout('blanco');

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $solicitud = $solicitudModel->getById($id);
    $this->_view->solicitud = $solicitud;
    $paso = $this->_getSanitizedParam("paso");

    $cedula = $solicitud->cedula;
    $ultima = $solicitudModel->getList(" cedula='$cedula' AND paso='8' ", " id DESC ")[0];
    $ultima_id = $ultima->id;

    $garantialineaModel = new Administracion_Model_DbTable_Garantialinea();
    $filtro_garantias = " ( 1=0 ";
    $codigo = $solicitud->linea;
    if ($this->_getSanitizedParam("linea") != "") {
      $codigo = $this->_getSanitizedParam("linea");
    }
    $garantialinea = $garantialineaModel->getList(" gl_linea_id='$codigo' ", "");
    foreach ($garantialinea as $key => $value) {
      $garantia_id = $value->gl_garantia_id;
      $filtro_garantias .= " OR garantia_id = '$garantia_id'  ";
    }
    $filtro_garantias .= " )";
    $this->_view->array_garantias = $array_garantias;

    $garantiasModel = new Administracion_Model_DbTable_Garantias();
    $this->_view->garantias = $garantiasModel->getList(" 1=1 AND $filtro_garantias ", " garantia_nombre ASC ");
  }

  public function paso6Action()
  {
    $id = $this->_getSanitizedParam("id");
    if ($_SESSION["kt_login_level"] == 2) {

      if ($_SESSION['id_solicitud']) {
        $id = $_SESSION['id_solicitud'];
      }
    }

    //echo $id;
    //header("Location: /page/sistema/resumen/?id=".$id."");
    //$this->_view->seccion = 1;
    //$this->_view->contenidos = $this->template->getContent(1);
    //$header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    //$this->getLayout()->setData("header",$header);
    $this->getLayout()->setData("header", "");
    $this->setLayout('blanco');


    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    //$id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $solicitud = $solicitudModel->getById($id);
    $this->_view->solicitud = $solicitud;
    $paso = $this->_getSanitizedParam("paso");

    $linea = $solicitud->linea;
    if ($this->_getSanitizedParam("linea") != "") {
      $linea = $this->_getSanitizedParam("linea");
    }
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $this->_view->linea = $lineaModel->getList(" codigo='$linea' ", "")[0];

    $documentosModel = new Administracion_Model_DbTable_Documentos();
    $documentos = $documentosModel->getList(" solicitud = '$id' AND tipo='1' ", "")[0];
    $documentos2 = $documentosModel->getList(" solicitud = '$id' AND tipo='2' ", "")[0];
    $documentos3 = $documentosModel->getList(" solicitud = '$id' AND tipo='3' ", "")[0];
    $this->_view->documentos = $documentos;
    $this->_view->documentos2 = $documentos2;
    $this->_view->documentos3 = $documentos3;
    //print_r($documentos);
    $cedula = $solicitud->cedula;
    $ultima = $solicitudModel->getList(" cedula='$cedula' AND paso='8' ", " id DESC ")[0];
    $ultima_id = $ultima->id;

    $codeudorModel = new Administracion_Model_DbTable_Codeudor();
    $this->_view->codeudor2 = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='2' ", "")[0];
  }


  public function paso7Action()
  {

    $this->_view->seccion = 1;
    $this->_view->contenidos = $this->template->getContent(1);
    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    $this->getLayout()->setData("header", $header);

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $solicitud = $solicitudModel->getById($id);
    $this->_view->solicitud = $solicitud;
    $paso = $this->_getSanitizedParam("paso");

    $linea = $solicitud->linea;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $this->_view->linea = $lineaModel->getById($linea);

    $documentosModel = new Administracion_Model_DbTable_Documentos();
    $documentos = $documentosModel->getList(" solicitud = '$id' AND tipo='1' ", "");
    $documentos2 = $documentosModel->getList(" solicitud = '$id' AND tipo='2' ", "");
    $this->_view->documentos = $documentos;
    $this->_view->documentos2 = $documentos2;

    $cedula = $solicitud->cedula;
    $ultima = $solicitudModel->getList(" cedula='$cedula' AND paso='8' ", " id DESC ")[0];
    $ultima_id = $ultima->id;

    $enfermedadesModel = new Administracion_Model_DbTable_Enfermedades();
    $this->_view->enfermedades = $enfermedadesModel->getList("", " id ASC ");

    $enfermedadesitemsModel = new Administracion_Model_DbTable_Enfermedadesitems();
    $enfermedadesitems = $enfermedadesitemsModel->getList(" formulario='$id' ", "");
    if (count($enfermedadesitems) == 0) {
      $enfermedadesitems = $enfermedadesitemsModel->getList(" formulario='$ultima_id' ", "");
    }

    $enfermedades_array = array();
    foreach ($enfermedadesitems as $key => $value) {
      $item = $value->enfermedad;
      $enfermedades_array[$item] = 1;
    }
    $this->_view->enfermedades_array = $enfermedades_array;

    $asegurabilidadModel = new Administracion_Model_DbTable_Asegurabilidad();
    $asegurabilidad =  $asegurabilidadModel->getList(" solicitud='$id' ", "");
    if (count($asegurabilidad) == 0) {
      $asegurabilidad = $enfermedadesitemsModel->getList(" solicitud='$ultima_id' ", "");
    }
    $this->_view->asegurabilidad = $asegurabilidad;
    //print_r($asegurabilidad);

  }

  public function paso8Action()
  {

    if ($_SESSION['kt_login_id'] == "") {
      //header("Location://FONDTODOS.com/sistema/");
      header("Location:/page/");
    }

    $this->_view->seccion = 1;
    $this->_view->contenidos = $this->template->getContent(1);
    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    $this->getLayout()->setData("header", $header);

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $solicitud = $solicitudModel->getById($id);
    $this->_view->solicitud = $solicitud;
    $paso = $this->_getSanitizedParam("paso");

    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $this->_view->numero = $numero = str_pad($id, 6, "0", STR_PAD_LEFT);

    $emailModel = new Core_Model_Mail();
    $asunto = "Solicitud de crédito WEB" . $numero . "";
    $content = "";


    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);

    $linea = $solicitud->linea;
    $linea2 = $solicitud->linea_desembolso;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];
    $lineas2 = $lineaModel->getList(" codigo='$linea2' ", "")[0];
    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $cedula = $solicitud->cedula;
    $usuario = $usuarioModel->getList(" user_user = '$cedula' ", "")[0];

    $analista_id = $solicitud->asignado;
    $analista = $usuarioModel->getById($analista_id);

    $gestor_comercial1 = $solicitud->gestor_comercial;
    $gestor_comercial = $usuarioModel->getList(" nombre = 'gestor_comercial' ", "")[0];


    $tabla = $this->generartabla($numero, $usuario, $solicitud, $lineas, $analista, $lineas2);
    //$tabla = '<br>'.$tabla;




  }

  public function resumenAction()
  {

    if ($_SESSION['kt_login_id'] == "") {
      //header("Location://FONDTODOS.com/sistema/");
      header("Location:/page/");
    }

    $this->_view->seccion = 1;
    $this->_view->contenidos = $this->template->getContent(1);
    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    $this->getLayout()->setData("header", $header);

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $this->_view->numero = str_pad($id, 6, "0", STR_PAD_LEFT);
    $solicitud = $solicitudModel->getById($id);
    $this->_view->solicitud = $solicitud;
    $paso = $this->_getSanitizedParam("paso");

    $id = $this->_getSanitizedParam("id");
    $this->_view->id = $id;
    $this->_view->numero = $numero = str_pad($id, 6, "0", STR_PAD_LEFT);

    $emailModel = new Core_Model_Mail();
    $asunto = "Solicitud de crédito WEB" . $numero . "";
    $content = "";


    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud = $solicitudModel->getById($id);

    $linea = $solicitud->linea;
    $linea2 = $solicitud->linea_desembolso;
    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];
    $lineas2 = $lineaModel->getList(" codigo='$linea2' ", "")[0];

    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $cedula = $solicitud->cedula;
    $usuario = $usuarioModel->getList(" user_user = '$cedula' ", "")[0];

    $analista_id = $solicitud->asignado;
    $analista = $usuarioModel->getById($analista_id);

    $gestor_comercial1 = $solicitud->gestor_comercial;
    $gestor_comercial = $usuarioModel->getList(" nombre = 'gestor_comercial' ", "")[0];

    $tabla = $this->generartabla2($numero, $usuario, $solicitud, $lineas, $analista, $lineas2);

    $this->_view->tabla = $tabla;
    $documentosModel = new Administracion_Model_DbTable_Documentos();
    $this->_view->documentos = $documentosModel->getList("solicitud = '$id'", "")[0];
  }

  public function guardarpasoAction()
  {
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $id = $this->_getSanitizedParam("id");
    $solicitud = $solicitudModel->getById($id);
    $paso = $this->_getSanitizedParam("paso");
    $cedula = $solicitud->cedula;
    $linea = $solicitud->linea;
    $documentosModel = new Administracion_Model_DbTable_Documentos();
    $documentos = $documentosModel->getList(" solicitud = '$id' AND tipo='1' ", "");
    $documentos2 = $documentosModel->getList(" solicitud = '$id' AND tipo='2' ", "");


    extract($_POST);
    //print_r($_POST);
    if ($id > 0) {
      //echo "entro1";
      if ($paso == "1") {
        //echo "entro2";
        $ciudad_residencia = $this->limpiar2($ciudad_residencia);
        $ciudad_oficina = $this->limpiar2($ciudad_oficina);
        $ciudad_documento = $this->limpiar2($ciudad_documento);
        $direccion_oficina = $this->limpiar2($direccion_oficina);
        $direccion_residencia = $this->limpiar2($direccion_residencia);
        $dependencia = $this->limpiar2($dependencia);
        $nombres = $this->limpiar2($nombres);
        $apellido1 = $this->limpiar2($apellido1);
        $apellido2 = $this->limpiar2($apellido2);
        $barrio = $this->limpiar2($barrio);
        $cuenta_numero = $this->limpiar2($cuenta_numero);
        $cuenta_tipo = $this->limpiar2($cuenta_tipo);
        $entidad_bancaria = $this->limpiar2($entidad_bancaria);

        $solicitudModel->editField($id, "nombres", $nombres);
        $solicitudModel->editField($id, "apellido1", $apellido1);
        $solicitudModel->editField($id, "apellido2", $apellido2);
        $solicitudModel->editField($id, "sexo", $sexo);
        $solicitudModel->editField($id, "tipo_documento", $tipo_documento);
        $solicitudModel->editField($id, "documento", $documento);
        $solicitudModel->editField($id, "dependencia", $dependencia);
        $solicitudModel->editField($id, "direccion_oficina", $direccion_oficina);
        $solicitudModel->editField($id, "telefono_oficina", $telefono_oficina);
        $solicitudModel->editField($id, "direccion_residencia", $direccion_residencia);
        $solicitudModel->editField($id, "barrio", $barrio);
        $solicitudModel->editField($id, "ciudad_residencia", $ciudad_residencia);
        $solicitudModel->editField($id, "telefono", $telefono);
        $solicitudModel->editField($id, "correo_empresarial", $correo_empresarial);
        $solicitudModel->editField($id, "correo_personal", $correo_personal);
        $solicitudModel->editField($id, "situacion_laboral", $situacion_laboral);
        $solicitudModel->editField($id, "cual", $cual);
        $solicitudModel->editField($id, "ocupacion", $ocupacion);
        $solicitudModel->editField($id, "estado_civil", $estado_civil);
        $solicitudModel->editField($id, "peso", $peso);
        $solicitudModel->editField($id, "estatura", $estatura);
        $solicitudModel->editField($id, "conyuge_nombre", $conyuge_nombre);
        $solicitudModel->editField($id, "conyuge_telefono", $conyuge_telefono);
        $solicitudModel->editField($id, "conyuge_celular", $conyuge_celular);
        $solicitudModel->editField($id, "declara_renta", $declara_renta);
        $solicitudModel->editField($id, "persona_publica", $persona_publica);
        $solicitudModel->editField($id, "persona_expuesta", $persona_expuesta);
        $solicitudModel->editField($id, "persona_expuesta_indique", $persona_expuesta_indique);
        $solicitudModel->editField($id, "persona_publica_indique", $persona_publica_indique);
        $solicitudModel->editField($id, "persona_internacional", $persona_internacional);
        $solicitudModel->editField($id, "persona_internacional_indique", $persona_internacional_indique);
        $solicitudModel->editField($id, "vinculo_pep", $vinculo_pep);
        $solicitudModel->editField($id, "vinculo_pep_indique", $vinculo_pep_indique);
        $solicitudModel->editField($id, "obligaciones_tributarias", $obligaciones_tributarias);
        $solicitudModel->editField($id, "obligaciones_tributarias_indique", $obligaciones_tributarias_indique);
        $solicitudModel->editField($id, "fecha_nacimiento", $fecha_nacimiento);
        $solicitudModel->editField($id, "fecha_documento", $fecha_documento);
        $solicitudModel->editField($id, "celular", $celular);
        $solicitudModel->editField($id, "ciudad_oficina", $ciudad_oficina);
        $solicitudModel->editField($id, "ciudad_documento", $ciudad_documento);
        $solicitudModel->editField($id, "cuenta_numero", $cuenta_numero);
        $solicitudModel->editField($id, "cuenta_tipo", $cuenta_tipo);
        $solicitudModel->editField($id, "entidad_bancaria", $entidad_bancaria);
        $solicitudModel->editField($id, "empresa", $empresa);

        //fedeaa
        $solicitudModel->editField($id, "tipo_vivienda", $tipo_vivienda);
        $solicitudModel->editField($id, "origen_ingresos", $origen_ingresos);
        $solicitudModel->editField($id, "ciiu", $ciiu);
        $solicitudModel->editField($id, "estrato", $estrato);
        $solicitudModel->editField($id, "fecha_ingreso", $fecha_ingreso);
        $solicitudModel->editField($id, "cargo", $cargo);
        $solicitudModel->editField($id, "fecha_afiliacion", $fecha_afiliacion);
        $solicitudModel->editField($id, "personas_cargo", $personas_cargo);
        $solicitudModel->editField($id, "numero_hijos", $numero_hijos);
        $solicitudModel->editField($id, "nomenclatura1", $nomenclatura1);
        $solicitudModel->editField($id, "nomenclatura2", $nomenclatura2);
        //fedeaa
        $solicitudModel->editField($id, "paso", "2");


        header("Location: /page/sistema/paso2/?id=" . $id);
      }

      if ($paso == "2") {
        //info_patrimonial
        $cedula = $solicitud->cedula;

        $conceptos = array("", "VIVIENDA", "OTRAS", "HIPOTECA", "VEHICULO", "OTROS", "PRENDA", "CLASE", "PATRIMONIO", "TARJETAS", "OTROS2", "OBLIGACIONES", "TOTALPATRIMONIAL");
        $total = count($conceptos);
        $infopatrimonialModel = new Administracion_Model_DbTable_Infopatrimonial();
        for ($i = 1; $i <= $total; $i++) {
          $concepto = $conceptos[$i];
          if ($concepto != "") {
            $v1 = $this->sin_puntos($_POST[$concepto . "_v1"]) * 1;
            $v2 = $this->sin_puntos($_POST[$concepto . "_v2"]) * 1;
            $v3 = $this->sin_puntos($_POST[$concepto . "_v3"]) * 1;
            $infopatrimonialModel->borrar($id, $cedula, $concepto);

            $data['solicitud'] = $id;
            $data['cedula'] = $cedula;
            $data['concepto'] = $concepto;
            $data['v1'] = $v1;
            $data['v2'] = $v2;
            $data['v3'] = $v3;
            $infopatrimonialModel->insert($data);
          }
        }
        //info_patrimonial

        $solicitudModel->editField($id, "paso", "3");
        header("Location: /page/sistema/paso3/?id=" . $id);
      }


      if ($paso == "3") {

        $ingreso_mensual = $this->sin_puntos($ingreso_mensual);
        $otros_ingresos = $this->sin_puntos($otros_ingresos);
        $total_ingresos = $this->sin_puntos($total_ingresos);
        $canon_arrendamiento = $this->sin_puntos($canon_arrendamiento);
        $otros_gastos = $this->sin_puntos($otros_gastos);
        $total_egresos = $this->sin_puntos($total_egresos);
        $activos = $this->sin_puntos($activos);
        $pasivos = $this->sin_puntos($pasivos);
        $patrimonio = $this->sin_puntos($patrimonio);

        $solicitudModel->editField($id, "ingreso_mensual", $ingreso_mensual);
        $solicitudModel->editField($id, "otros_ingresos", $otros_ingresos);
        $solicitudModel->editField($id, "total_ingresos", $total_ingresos);
        $solicitudModel->editField($id, "canon_arrendamiento", $canon_arrendamiento);
        $solicitudModel->editField($id, "otros_gastos", $otros_gastos);
        $solicitudModel->editField($id, "total_egresos", $total_egresos);
        $solicitudModel->editField($id, "activos", $activos);
        $solicitudModel->editField($id, "pasivos", $pasivos);
        $solicitudModel->editField($id, "patrimonio", $patrimonio);
        $solicitudModel->editField($id, "descripcion_ingresos", $descripcion_ingresos);
        $solicitudModel->editField($id, "descripcion_recursos", $descripcion_recursos);
        $solicitudModel->editField($id, "paso", "4");

        //info financiera
        $salario = $this->sin_puntos($salario1);
        $pension = $this->sin_puntos($pension);
        $arriendos = $this->sin_puntos($arriendos);
        $dividendos = $this->sin_puntos($dividendos);
        $rentas = $this->sin_puntos($rentas);
        $total_ingresos = $this->sin_puntos($total_ingresos);
        $arrendamientos = $this->sin_puntos($arrendamientos);
        $gastos_familiares = $this->sin_puntos($gastos_familiares);
        $obligaciones_financieras = $this->sin_puntos($obligaciones_financieras);
        $otros_gastos = $this->sin_puntos($otros_gastos);
        $total_gastos = $this->sin_puntos($total_gastos);
        $capacidad_endeudamiento = $this->sin_puntos($capacidad_endeudamiento);

        $cedula = $solicitud->cedula;

        $financieraModel = new Administracion_Model_DbTable_Infofinanciera();
        $financieraModel->borrar($id, $cedula);

        $data['solicitud'] = $id;
        $data['cedula'] = $cedula;
        $data['salario'] = $salario;
        $data['pension'] = $pension;
        $data['arriendos'] = $arriendos;
        $data['dividendos'] = $dividendos;
        $data['rentas'] = $rentas;
        $data['otros_ingresos'] = $otros_ingresos;
        $data['total_ingresos'] = $total_ingresos;
        $data['arrendamientos'] = $arrendamientos;
        $data['gastos_familiares'] = $gastos_familiares;
        $data['obligaciones_financieras'] = $obligaciones_financieras;
        $data['otros_gastos'] = $otros_gastos;
        $data['total_gastos'] = $total_gastos;
        $data['capacidad_endeudamiento'] = $capacidad_endeudamiento;

        $financieraModel->insert($data);
        header("Location: /page/sistema/paso4/?id=" . $id);
        //info financiera

      }
      if ($paso == "4") {
        $referenciasModel = new Administracion_Model_DbTable_Referencias();

        $solicitudModel->editField($id, "paso", "5");
        $referenciasModel->borrar($id);

        for ($i = 1; $i <= 4; $i++) {
          $nombres = $_POST['nombres' . $i];
          $parentesco = $_POST['parentesco' . $i];
          $direccion = $_POST['direccion' . $i];
          $ciudad = $_POST['ciudad' . $i];
          $telefono = $_POST['telefono' . $i];
          $celular = $_POST['celular' . $i];
          $departamento = $_POST['departamento' . $i];
          $actividad = $_POST['actividad' . $i];
          $empresa = $_POST['nombre_empresa' . $i];
          $telefono_empresa = $_POST['telefono_empresa' . $i];
          $cargo = $_POST['cargo' . $i];
          $nomenclatura = $_POST['nomenclatura' . $i];
          $correo = $_POST['correo' . $i];

          $data['solicitud'] = $id;
          $data['tipo'] = 0;
          $data['numero'] = $i;
          $data['nombres'] = $nombres;
          $data['parentesco'] = $parentesco;
          $data['direccion'] = $direccion;
          $data['ciudad'] = $ciudad;
          $data['telefono'] = $telefono;
          $data['celular'] = $celular;
          $data['departamento'] = $departamento;
          $data['actividad'] = $actividad;
          $data['empresa'] = $empresa;
          $data['cargo'] = $cargo;
          $data['telefono_empresa'] = $telefono_empresa;
          $data['nomenclatura'] = $nomenclatura;
          $data['correo'] = $correo;
          $referenciasModel->insert($data);

          $existe = $referenciasModel->getList(" solicitud='$id' AND numero='$i' ", "");
          if (count($existe) > 0) {
            $id_referencia = $existe[0]->id;
            $referenciasModel->editField($id_referencia, "nombres", $nombres);
            $referenciasModel->editField($id_referencia, "parentesco", $parentesco);
            $referenciasModel->editField($id_referencia, "nomenclatura", $nomenclatura);
            $referenciasModel->editField($id_referencia, "direccion", $direccion);
            $referenciasModel->editField($id_referencia, "ciudad", $ciudad);
            $referenciasModel->editField($id_referencia, "telefono", $telefono);
            $referenciasModel->editField($id_referencia, "celular", $celular);
            $referenciasModel->editField($id_referencia, "departamento", $departamento);
            $referenciasModel->editField($id_referencia, "actividad", $actividad);
            $referenciasModel->editField($id_referencia, "empresa", $empresa);
            $referenciasModel->editField($id_referencia, "cargo", $cargo);
            $referenciasModel->editField($id_referencia, "telefono_empresa", $telefono_empresa);
            $referenciasModel->editField($id_referencia, "email", $email);
          }
        }
        header("Location: /page/sistema/paso5/?id=" . $id);
      }

      if ($paso == "5") {

        $FM_meses = $FM_meses * 1;
        $FM_meses = 0;

        $solicitudModel->editField($id, "paso", "6");
        $solicitudModel->editField($id, "tipo_garantia", $tipo_garantia);
        $solicitudModel->editField($id, "FM_meses", $FM_meses);

        $codeudorModel = new Administracion_Model_DbTable_Codeudor();

        if ($tipo_garantia == "2") {

          $codeudorModel->borrar($id);

          $salario = $this->sin_puntos($salario);
          $tiempo_anio = $tiempo_anio * 1;
          $tiempo_meses = $tiempo_meses * 1;
          if ($fecha_nacimiento == "") {
            $fecha_nacimiento = "0000-00-00";
          }
          if ($fecha_documento == "") {
            $fecha_documento = "0000-00-00";
          }

          $conyuge_nombre = $this->limpiar2($conyuge_nombre);
          $conyuge_telefono = $this->limpiar2($conyuge_telefono);
          $conyuge_celular = $this->limpiar2($conyuge_celular);
          $direccion_residencia = $this->limpiar2($direccion_residencia);

          $data['solicitud'] = $id;
          $data['nombres'] = $nombres;
          $data['nombres2'] = $nombres2;
          $data['apellido1'] = $apellido1;
          $data['apellido2'] = $apellido2;
          $data['cedula'] = $cedula;
          $data['ciudad_documento'] = $ciudad_documento;
          $data['empresa'] = $empresa;
          $data['dependencia'] = $dependencia;
          $data['cargo'] = $cargo;
          $data['ciudad'] = $ciudad;
          $data['telefono'] = $telefono;
          $data['celular'] = $celular;
          $data['salario'] = $salario;
          $data['forma_pago'] = $forma_pago;
          $data['tiempo_anio'] = $tiempo_anio;
          $data['tiempo_meses'] = $tiempo_meses;
          $data['correo'] = $correo;
          $data['asociado'] = $asociado;
          $data['fecha_nacimiento'] = $fecha_nacimiento;
          $data['fecha_documento'] = $fecha_documento;
          $data['tipo_documento'] = $tipo_documento;
          $data['sexo'] = $sexo;
          $data['direccion_oficina'] = $direccion_oficina;
          $data['telefono_oficina'] = $telefono_oficina;
          $data['ciudad_oficina'] = $ciudad_oficina;
          $data['direccion_residencia'] = $direccion_residencia;
          $data['barrio'] = $barrio;
          $data['ciudad_residencia'] = $ciudad_residencia;
          $data['correo_empresarial'] = $correo_empresarial;
          $data['situacion_laboral'] = $situacion_laboral;
          $data['cual'] = $cual;
          $data['estado_civil'] = $estado_civil;
          $data['declara_renta'] = $declara_renta;
          $data['persona_publica'] = $persona_publica;
          $data['cuenta_numero'] = $cuenta_numero;
          $data['cuenta_tipo'] = $cuenta_tipo;
          $data['entidad_bancaria'] = $entidad_bancaria;
          $data['conyuge_nombre'] = $conyuge_nombre;
          $data['conyuge_telefono'] = $conyuge_telefono;
          $data['conyuge_celular'] = $conyuge_celular;
          $data['nomenclatura1'] = $nomenclatura1;
          $data['nomenclatura2'] = $nomenclatura2;
          $codeudorModel->insert($data);


          //info_patrimonial
          $conceptos = array("", "VIVIENDA", "OTRAS", "HIPOTECA", "VEHICULO", "OTROS", "PRENDA", "CLASE", "PATRIMONIO", "TARJETAS", "OTROS2", "OBLIGACIONES", "TOTALPATRIMONIAL");
          $total = count($conceptos);
          $infopatrimonialModel = new Administracion_Model_DbTable_Infopatrimonial();
          for ($i = 1; $i <= $total; $i++) {
            $concepto = $conceptos[$i];
            if ($concepto != "") {
              $v1 = $this->sin_puntos($_POST[$concepto . "_v1"]) * 1;
              $v2 = $this->sin_puntos($_POST[$concepto . "_v2"]) * 1;
              $v3 = $this->sin_puntos($_POST[$concepto . "_v3"]) * 1;
              $infopatrimonialModel->borrar($id, $cedula, $concepto);

              $data['solicitud'] = $id;
              $data['cedula'] = $cedula;
              $data['concepto'] = $concepto;
              $data['v1'] = $v1;
              $data['v2'] = $v2;
              $data['v3'] = $v3;
              $infopatrimonialModel->insert($data);
            }
          }
          //info_patrimonial

          //info financiera
          $salario = $this->sin_puntos($salario1);
          $pension = $this->sin_puntos($pension);
          $arriendos = $this->sin_puntos($arriendos);
          $dividendos = $this->sin_puntos($dividendos);
          $rentas = $this->sin_puntos($rentas);
          $otros_ingresos = $this->sin_puntos($otros_ingresos);
          $total_ingresos = $this->sin_puntos($total_ingresos);
          $arrendamientos = $this->sin_puntos($arrendamientos);
          $gastos_familiares = $this->sin_puntos($gastos_familiares);
          $obligaciones_financieras = $this->sin_puntos($obligaciones_financieras);
          $otros_gastos = $this->sin_puntos($otros_gastos);
          $total_gastos = $this->sin_puntos($total_gastos);
          $capacidad_endeudamiento = $this->sin_puntos($capacidad_endeudamiento);

          $financieraModel->borrar($id, $cedula);

          $data['solicitud'] = $id;
          $data['cedula'] = $cedula;
          $data['salario'] = $salario;
          $data['pension'] = $pension;
          $data['arriendos'] = $arriendos;
          $data['dividendos'] = $dividendos;
          $data['rentas'] = $rentas;
          $data['otros_ingresos'] = $otros_ingresos;
          $data['total_ingresos'] = $total_ingresos;
          $data['arrendamientos'] = $arrendamientos;
          $data['gastos_familiares'] = $gastos_familiares;
          $data['obligaciones_financieras'] = $obligaciones_financieras;
          $data['otros_gastos'] = $otros_gastos;
          $data['total_gastos'] = $total_gastos;
          $data['capacidad_endeudamiento'] = $capacidad_endeudamiento;

          $financieraModel->insert($data);
          //info financiera
        }

        header("Location: /page/sistema/paso6/?id=" . $id);
      }

      if ($paso == "6") {
        $solicitudModel->editField($id, "paso", "7");

        $data['solicitud'] = $id;
        $data['tipo'] = 1;
        $documentosModel->insert2($data);

        $data['solicitud'] = $id;
        $data['tipo'] = 2;
        $documentosModel->insert2($data);

        $uploadImage =  new Core_Model_Upload_Document();


        //archivos asociado
        $tipo = 1;
        if ($_FILES['cedula']['name'] != '') {
          $archivo = $uploadImage->upload("cedula");
          $documentosModel->editar('cedula', $archivo, $solicitud, $tipo);
        }
        if ($_FILES['desprendible_pago']['name'] != '') {
          $archivo = $uploadImage->upload("desprendible_pago");
          $documentosModel->editar('desprendible_pago', $archivo, $solicitud, $tipo);
        }
        if ($_FILES['desprendible_pago2']['name'] != '') {
          $archivo = $uploadImage->upload("desprendible_pago2");
          $documentosModel->editar('desprendible_pago2', $archivo, $solicitud, $tipo);
        }
        if ($_FILES['desprendible_pago3']['name'] != '') {
          $archivo = $uploadImage->upload("desprendible_pago3");
          $documentosModel->editar('desprendible_pago3', $archivo, $solicitud, $tipo);
        }
        if ($_FILES['desprendible_pago4']['name'] != '') {
          $archivo = $uploadImage->upload("desprendible_pago4");
          $documentosModel->editar('desprendible_pago4', $archivo, $solicitud, $tipo);
        }
        if ($_FILES['certificado_laboral']['name'] != '') {
          $archivo = $uploadImage->upload("certificado_laboral");
          $documentosModel->editar('certificado_laboral', $archivo, $solicitud, $tipo);
        }
        if ($_FILES['otros_ingresos']['name'] != '') {
          $archivo = $uploadImage->upload("otros_ingresos");
          $documentosModel->editar('otros_ingresos', $archivo, $solicitud, $tipo);
        }
        if ($_FILES['certificado_tradicion']['name'] != '') {
          $archivo = $uploadImage->upload("certificado_tradicion");
          $documentosModel->editar('certificado_tradicion', $archivo, $solicitud, $tipo);
        }
        if ($_FILES['estado_obligacion']['name'] != '') {
          $archivo = $uploadImage->upload("estado_obligacion");
          $documentosModel->editar('estado_obligacion', $archivo, $solicitud, $tipo);
        }
        if ($_FILES['estado_obligacion2']['name'] != '') {
          $archivo = $uploadImage->upload("estado_obligacion2");
          $documentosModel->editar('estado_obligacion2', $archivo, $solicitud, $tipo);
        }
        if ($_FILES['estado_obligacion3']['name'] != '') {
          $archivo = $uploadImage->upload("estado_obligacion3");
          $documentosModel->editar('estado_obligacion3', $archivo, $solicitud, $tipo);
        }
        if ($_FILES['factura_proforma']['name'] != '') {
          $archivo = $uploadImage->upload("factura_proforma");
          $documentosModel->editar('factura_proforma', $archivo, $solicitud, $tipo);
        }
        if ($_FILES['recibo_matricula']['name'] != '') {
          $archivo = $uploadImage->upload("recibo_matricula");
          $documentosModel->editar('recibo_matricula', $archivo, $solicitud, $tipo);
        }
        if ($_FILES['contrato_vivienda']['name'] != '') {
          $archivo = $uploadImage->upload("contrato_vivienda");
          $documentosModel->editar('contrato_vivienda', $archivo, $solicitud, $tipo);
        }
        if ($_FILES['declaracion_renta']['name'] != '') {
          $archivo = $uploadImage->upload("declaracion_renta");
          $documentosModel->editar('declaracion_renta', $archivo, $solicitud, $tipo);
        }
        //archivos asociado

        //archivos codeudor
        if ($solicitud->tipo_garantia == "DEUDOR SOLIDARIO") {
          $tipo = 2;
          if ($_FILES['cedula2']['name'] != '') {
            $archivo = $uploadImage->upload("cedula2");
            $documentosModel->editar('cedula', $archivo, $solicitud, $tipo);
          }
          if ($_FILES['desprendible_pagoB']['name'] != '') {
            $archivo = $uploadImage->upload("desprendible_pagoB");
            $documentosModel->editar('desprendible_pago', $archivo, $solicitud, $tipo);
          }
          if ($_FILES['desprendible_pagoB2']['name'] != '') {
            $archivo = $uploadImage->upload("desprendible_pagoB2");
            $documentosModel->editar('desprendible_pago2', $archivo, $solicitud, $tipo);
          }
          if ($_FILES['desprendible_pagoB3']['name'] != '') {
            $archivo = $uploadImage->upload("desprendible_pagoB3");
            $documentosModel->editar('desprendible_pago3', $archivo, $solicitud, $tipo);
          }
          if ($_FILES['desprendible_pagoB4']['name'] != '') {
            $archivo = $uploadImage->upload("desprendible_pagoB4");
            $documentosModel->editar('desprendible_pago4', $archivo, $solicitud, $tipo);
          }
          if ($_FILES['certificado_laboral2']['name'] != '') {
            $archivo = $uploadImage->upload("certificado_laboral2");
            $documentosModel->editar('certificado_laboral', $archivo, $solicitud, $tipo);
          }
          if ($_FILES['otros_ingresos2']['name'] != '') {
            $archivo = $uploadImage->upload("otros_ingresos2");
            $documentosModel->editar('otros_ingresos', $archivo, $solicitud, $tipo);
          }
          if ($_FILES['certificado_tradicionB']['name'] != '') {
            $archivo = $uploadImage->upload("certificado_tradicionB");
            $documentosModel->editar('certificado_tradicion', $archivo, $solicitud, $tipo);
          }
          if ($_FILES['estado_obligacionB']['name'] != '') {
            $archivo = $uploadImage->upload("estado_obligacionB");
            $documentosModel->editar('estado_obligacion', $archivo, $solicitud, $tipo);
          }
          if ($_FILES['estado_obligacion2B']['name'] != '') {
            $archivo = $uploadImage->upload("estado_obligacion2B");
            $documentosModel->editar('estado_obligacion2', $archivo, $solicitud, $tipo);
          }
          if ($_FILES['estado_obligacion3B']['name'] != '') {
            $archivo = $uploadImage->upload("estado_obligacion3B");
            $documentosModel->editar('estado_obligacion3', $archivo, $solicitud, $tipo);
          }
          if ($_FILES['factura_proformaB']['name'] != '') {
            $archivo = $uploadImage->upload("factura_proformaB");
            $documentosModel->editar('factura_proforma', $archivo, $solicitud, $tipo);
          }
          if ($_FILES['recibo_matriculaB']['name'] != '') {
            $archivo = $uploadImage->upload("recibo_matriculaB");
            $documentosModel->editar('recibo_matricula', $archivo, $solicitud, $tipo);
          }
        }
        //archivos codeudor

        $solicitudModel->editField($id, "paso", "7");
        //header("Location: /page/sistema/paso7/?id=".$id);

      }

      if ($paso == "6") {
        $solicitudModel->editField($id, "paso", "6");
        header("Location: /page/sistema/resumen/?id=" . $id);
      }



      if ($paso == "7") {
        /*
        $asegurabilidadModel = new Administracion_Model_DbTable_Asegurabilidad();
        $asegurabilidadModel->borrar($id);

        $data['solicitud'] = $id;
        $data['cobertura'] = $cobertura;
        $data['prima'] = $prima;
        $data['prima_valor'] = $prima_valor;
        $data['otra_cual'] = $otra_cual;
        $data['otra_cual2'] = $otra_cual2;
        $data['tiene'] = $tiene;
        $data['drogas'] = $drogas;
        $data['alcoholismo'] = $alcoholismo;
        $data['drogadiccion'] = $drogadiccion;
        $data['hospitalizado'] = $hospitalizado;
        $data['observaciones'] = $observaciones;
        $data['fecha'] = date("Y-m-d");

        $id_asegurabilidad = $asegurabilidadModel->insert($data);
        $asegurabilidadModel->editField($id_asegurabilidad,"enfermedad",$enfermedad);
        $asegurabilidadModel->editField($id_asegurabilidad,"anio",$anio);
        $asegurabilidadModel->editField($id_asegurabilidad,"tratamiento",$tratamiento);
        $asegurabilidadModel->editField($id_asegurabilidad,"no_conozco",$no_conozco);


        $enfermedadesModel = new Administracion_Model_DbTable_Enfermedades();
        $enfermedades = $enfermedadesModel->getList(""," id ASC ");

        //enfermedades
        $enfermedadesitemsModel = new Administracion_Model_DbTable_Enfermedadesitems();
        $enfermedadesitemsModel->borrar($id);

        foreach ($enfermedades as $enfermedad) {
          $i = $enfermedad->id;
          if($_POST['c'.$i]!=""){
            $enfermedad = $data['enfermedad'] = $i;
            $formulario = $data['formulario'] = $id;
            $enfermedadesitemsModel->insert($data);
          }
        }
        //enfermedades

        */
        //echo $id;

        // header("Location: /page/sistema");

        //2024-02-20 no dejar radicar solicitud si lleva mas de 8 dias sin terminar
        $hoy = date("Y-m-d H:i:s");
        $nuevafecha = strtotime('-8 days', strtotime($hoy));
        $fecha1 = date('Y-m-d H:i:s', $nuevafecha);  

        $solicitud2 = $solicitudModel->getById($id);
        
        if($solicitud2->fecha > $fecha1){
          $solicitudModel->editField($id, "fecha", date('Y-m-d H:i:s'));
          $solicitudModel->editField($id, "paso", "8");
          $solicitud2 = $solicitudModel->getById($id);
        }
        
        if ($solicitud2->paso == "8" and $solicitud2->fecha > $fecha1) {
          header("Location: /page/sistema/asignaranalista/?id=" . $id);
        }else{
          header("Location: /page/sistema");
        }
      }
    }

    //print_r($_POST);

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

  public function asignaranalistaAction()
  {

    $hoy = date("Y-m-d");
    $hora = date("H:i:s");

    $id = $this->_getSanitizedParam("id");
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $solicitud2 = $solicitudModel->getById($id);
    if ($solicitud2->asignado > 0) {

      //2024-02-08 si se radica una solicitud sin terminar se actualiza la fecha de asignación
      $solicitudModel->editField($id, "fecha_asignado", "" . $hoy);
      $solicitudModel->editField($id, "hora_asignado", "" . $hora);
      
      header("Location: /page/sistema/paso8/?id=" . $id);
    } else if ($solicitud2->paso == "8") {
      //asignar analista
      $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
      $logestado = new Administracion_Model_DbTable_Logestado();


      $usuariosModel = new Administracion_Model_DbTable_Usuario();
      $analistas = $usuariosModel->getList(" user_level = '3' AND user_state='1' ", " rand() ");
      //print_r($analistas);
      $analista_id = $analistas[0]->user_id;

      $solicitudModel->editField($id, "asignado", $analista_id);
      $solicitudModel->editField($id, "fecha_asignado", "" . $hoy);
      $solicitudModel->editField($id, "hora_asignado", "" . $hora);
      $solicitudModel->editField($id, "fecha", date('Y-m-d H:i:s'));
      $solicitudModel->editField($id, "validacion", "0");
      $solicitudModel->editField($id, "estado_autorizo", "");
      $dataestado["solicitud"] = $id;
      $dataestado["estado"] = "Radicado";
      $dataestado["usuario"] = $analista_id;
      $dataestado["fecha"] = $hoy . " " . $hora;
      $logestado->insert($dataestado);
      $solicitud = $solicitudModel->getById($id);
      $this->_view->id = $id;
      $this->_view->numero = $numero = str_pad($id, 6, "0", STR_PAD_LEFT);

      $emailModel = new Core_Model_Mail();
      $asunto = "Solicitud de crédito WEB" . $numero . "";
      $content = "";




      $linea = $solicitud->linea;
      $linea2 = $solicitud->linea_desembolso;
      $lineaModel = new Administracion_Model_DbTable_Lineas();
      $lineas = $lineaModel->getList(" codigo='$linea' ", "")[0];
      $lineas2 = $lineaModel->getList(" codigo='$linea2' ", "")[0];

      $usuarioModel = new Administracion_Model_DbTable_Usuario();
      $cedula = $solicitud->cedula;
      $usuario = $usuarioModel->getList(" user_user = '$cedula' ", "")[0];

      $analista_id = $solicitud->asignado;
      $analista = $usuarioModel->getById($analista_id);

      $gestor_comercial1 = $solicitud->gestor_comercial;
      $gestor_comercial = $usuarioModel->getList(" nombre = 'gestor_comercial' ", "")[0];

      $tabla = $this->generartabla($numero, $usuario, $solicitud, $lineas, $analista, $lineas2);
      //$tabla = '<br>'.$tabla;

      $log_model = new Administracion_Model_DbTable_Log();

      $data_log = array();
      $data_log['log_usuario'] = Session::getInstance()->get('kt_login_id');
      $data_log['log_tipo'] = 'ASIGNAR ANALISTA';
      $data_log['log_fecha'] = date('Y-m-d H:i:s');
      $data_log['log_log'] = 'analistas:' . print_r($analistas, true) . 'analista_asigando:' . $analista_id;

      $log_model->insert($data_log);

      if ($solicitud->paso == '8' and $solicitud->asignado > 0) {

        //correo asociado
        $emailModel = new Core_Model_Mail();
        $asunto = "Solicitud de crédito WEB" . $numero . "";
        $content = "Sr.(a) asociado (a), hemos recibido su solicitud de crédito, pronto estaremos enviando una respuesta<br>";

        $content = $content . $tabla;

        //$email = "creyes@omegawebsystems.com";
        $email = $solicitud->correo_personal; //asociado
        $correo1 = $analista->user_email; //analista

        $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
        $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
        $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
        $emailModel->getMail()->addAddress("" . $email);
        //$emailModel->getMail()->addAddress("".$correo1);

        $emailModel->getMail()->Subject = $asunto;
        $emailModel->getMail()->msgHTML($content);
        $emailModel->getMail()->AltBody = $content;
        $emailModel->sed();
        //echo $emailModel->getMail()->ErrorInfo;


        //correo analista
        $emailModel = new Core_Model_Mail();
        $asunto = "Solicitud de crédito WEB" . $numero . "";
        $content = "";

        $content = $tabla;

        $content .= "<br><br>
      <div align='center'>
        <a href='https://creditosfondtodos.com.co/administracion/solicitudes/detalle/?id=" . $id . "'><button type='button' class='btn btn-primary' style='background:#0084C9; color:#FFFFFF; padding:5px 10px;margin-right:20px; text-decoration:none;'>Detalle solicitud</button></a>
        <a href='https://creditosfondtodos.com.co/administracion/solicitudes/manage/?id=" . $id . "'><button type='button' class='btn btn-primary' style='background:#0084C9; color:#FFFFFF; padding:5px 10px; text-decoration:none;'>Editar solicitud</button></a>
      </div>
      ";

        //$email = "creyes@omegawebsystems.com";
        $email = $solicitud->correo_personal; //asociado
        $correo1 = $analista->user_email; //analista

        $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
        $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
        $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
        //$emailModel->getMail()->addAddress("".$email);
        $emailModel->getMail()->addAddress("" . $correo1);

        $emailModel->getMail()->Subject = $asunto;
        $emailModel->getMail()->msgHTML($content);
        $emailModel->getMail()->AltBody = $content;
        $emailModel->sed();
        //echo $emailModel->getMail()->ErrorInfo;


        if ($solicitud->tipo_garantia == "2") {


          //envio codeudor
          $emailModel = new Core_Model_Mail();

          $asunto = "Notificación Codeudor - Solicitud de crédito WEB" . $numero . "";

          $codeudorModel = new Administracion_Model_DbTable_Codeudor();
          $codeudor = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='1' ", "")[0];

          $correo = $codeudor->correo;
          $correo_codificado = md5($codeudor->cedula);
          $nombres_codeudor = $codeudor->nombres . " " . $codeudor->nombres2 . " " . $codeudor->apellido1 . " " . $codeudor->apellido2;
          $nombres_asociado = $solicitud->nombres . " " . $solicitud->nombres2 . " " . $solicitud->apellido1 . " " . $solicitud->apellido2;
          $valor = $solicitud->valor;

          $content = "Estimado(a) <b>" . $nombres_codeudor . "</b>, el/la asociado(a) <b>" . $nombres_asociado . "</b> lo ha ingresado como codeudor en la solicitud de crédito <b>No. WEB" . $numero . "</b> del sistema de solicitudes de crédito de FONDTODOS por valor de <b>$" . number_format($valor) . "<b/><br><br>Por favor ingrese en el siguiente enlace para completar su información personal: <a href='https://creditosfondtodos.com.co/page/codeudor/?id=" . $id . "&e=" . $correo_codificado . "&n=1'><button type='button' class='btn btn-primary' style='background:#0084C9; color:#FFFFFF; padding:5px 10px;'>Ingresar</button></a>";

          $emailModel->getMail()->ClearAllRecipients();
          $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
          $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
          $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
          $emailModel->getMail()->addAddress("" . $correo);

          $emailModel->getMail()->Subject = $asunto;
          $emailModel->getMail()->msgHTML($content);
          $emailModel->getMail()->AltBody = $content;
          $emailModel->sed();
          //envio codeudor


          //envio codeudor2
          $emailModel = new Core_Model_Mail();

          $asunto = "Notificación Codeudor2 - Solicitud de crédito WEB" . $numero . "";

          $codeudorModel = new Administracion_Model_DbTable_Codeudor();
          $codeudor = $codeudorModel->getList(" solicitud='$id' AND codeudor_numero='2' ", "")[0];

          if ($codeudor->id > 0) {
            $correo = $codeudor->correo;
            $correo_codificado = md5($codeudor->cedula);
            $nombres_codeudor = $codeudor->nombres . " " . $codeudor->nombres2 . " " . $codeudor->apellido1 . " " . $codeudor->apellido2;
            $nombres_asociado = $solicitud->nombres . " " . $solicitud->nombres2 . " " . $solicitud->apellido1 . " " . $solicitud->apellido2;
            $valor = $solicitud->valor;

            $content = "<img src='Estimado(a) <b>" . $nombres_codeudor . "</b>, el/la asociado(a) <b>" . $nombres_asociado . "</b> lo ha ingresado como codeudor en la solicitud de crédito <b>No. WEB" . $numero . "</b> del sistema de solicitudes de crédito de FONDTODOS por valor de <b>$" . number_format($valor) . "<b/><br><br>Por favor ingrese en el siguiente enlace para completar su información personal: <a href='https://creditosfondtodos.com.co/page/codeudor/?id=" . $id . "&e=" . $correo_codificado . "&n=2'><button type='button' class='btn btn-primary' style='background:#0084C9; color:#FFFFFF; padding:5px 10px;'>Ingresar</button></a>";

            $emailModel->getMail()->ClearAllRecipients();
            $emailModel->getMail()->setFrom("notificaciones@fondtodos.com", "Notificaciones FONDTODOS");
            $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com");
            $emailModel->getMail()->addBCC("desarrollo2@omegawebsystems.com");
            $emailModel->getMail()->addAddress("" . $correo);

            $emailModel->getMail()->Subject = $asunto;
            $emailModel->getMail()->msgHTML($content);
            $emailModel->getMail()->AltBody = $content;
            $emailModel->sed();
          }
          //envio codeudor2

        }

        header("Location: /page/sistema/paso8/?id=" . $id);
      } else {
        header("Location: /page/sistema/resumen/?id=" . $id);
      }
    } else {
      header("Location: /page/sistema/resumen/?id=" . $id);
    }
  }


  public function solicitudesAction()
  {

    if ($_SESSION['kt_login_id'] == "") {
      //header("Location://FONDTODOS.com/sistema/");
      header("Location:/page/");
    }

    $this->_view->seccion = 1;
    $this->_view->contenidos = $this->template->getContent(1);

    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    $this->getLayout()->setData("header", $header);

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $user = $usuarioModel->getById($_SESSION['kt_login_id']);

    //2024-02-20 no mostrar solicitudes de mas de 8 dias sin terminar
    $hoy = date("Y-m-d H:i:s");
    $nuevafecha = strtotime('-8 days', strtotime($hoy));
    $fecha1 = date('Y-m-d H:i:s', $nuevafecha);
  
    $cedula = $user->user_user;
    $solicitudes = $solicitudModel->getList(" cedula='$cedula' AND ( paso=8 OR (paso!=8 AND fecha>='$fecha1') ) ", " id DESC ");
    $this->_view->solicitudes = $solicitudes;

    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();

    $lineaModel = new Administracion_Model_DbTable_Lineas();
    $lineas = $lineaModel->getList(" activo='1' ", " nombre ASC ");
    $lineas_array  = array();
    foreach ($lineas as $key => $value) {
      $lineas_array[$value->codigo] = $value->nombre;
    }
    $this->_view->lineas_array = $lineas_array;
  }


  public function perfilAction()
  {

    $header = $this->_view->getRoutPHP('modules/page/Views/partials/botonera.php');
    $this->getLayout()->setData("header", $header);

    $usuarioModel = new Administracion_Model_DbTable_Usuario();
    $user = $usuarioModel->getById($_SESSION['kt_login_id']);
    $this->_view->content = $user;
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

  public function eliminarsolicitudAction()
  {
    $solicitudModel = new Administracion_Model_DbTable_Solicitudes();
    $id = $this->_getSanitizedParam("id");
    if ($id > 0) {
      $solicitudModel->deleteRegister($id);
    }
    header("Location:/page/sistema/solicitudes/");
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
}
