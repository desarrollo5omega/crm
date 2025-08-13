<?php 
/**
* clase que genera la insercion y edicion  de solicitudes en la base de datos
*/
class Administracion_Model_DbTable_Solicitudes extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'solicitudes';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un solicitud y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$cedula = $data['cedula'];
		$linea = $data['linea'];
		$destino = $data['destino'];
		$valor = $data['valor'];
		$monto_solicitado = $data['monto_solicitado'];
		$valor_desembolso = $data['valor_desembolso'];
		$linea_desembolso = $data['linea_desembolso'];
		$cuotas_desembolso = $data['cuotas_desembolso'];
		$valor_cuota_desembolso = $data['valor_cuota_desembolso'];
		$tasa_desembolso = $data['tasa_desembolso'];
		$cuotas_extra_desembolso = $data['cuotas_extra_desembolso'];
		$valor_extra_desembolso = $data['valor_extra_desembolso'];
		$cuotas = $data['cuotas'];
		$valor_cuota = $data['valor_cuota'];
		$cuotas_extra = $data['cuotas_extra'];
		$valor_extra = $data['valor_extra'];
		$tasa = $data['tasa'];
		$tasa_anual = $data['tasa_anual'];
		$fecha = $data['fecha'];
		$validacion = $data['validacion'];
		$radicacion = $data['radicacion'];
		$paso = $data['paso'];
		$nombres = $data['nombres'];
		$nombres2 = $data['nombres2'];
		$apellido1 = $data['apellido1'];
		$apellido2 = $data['apellido2'];
		$sexo = $data['sexo'];
		$tipo_documento = $data['tipo_documento'];
		$documento = $data['documento'];
		$fecha_documento = $data['fecha_documento'];
		$ciudad_documento = $data['ciudad_documento'];
		$fecha_nacimiento = $data['fecha_nacimiento'];
		$empresa = $data['empresa'];
		$dependencia = $data['dependencia'];
		$direccion_oficina = $data['direccion_oficina'];
		$ciudad_oficina = $data['ciudad_oficina'];
		$telefono_oficina = $data['telefono_oficina'];
		$celular = $data['celular'];
		$direccion_residencia = $data['direccion_residencia'];
		$barrio = $data['barrio'];
		$ciudad_residencia = $data['ciudad_residencia'];
		$telefono = $data['telefono'];
		$correo_empresarial = $data['correo_empresarial'];
		$correo_personal = $data['correo_personal'];
		$situacion_laboral = $data['situacion_laboral'];
		$cual = $data['cual'];
		$ocupacion = $data['ocupacion'];
		$estado_civil = $data['estado_civil'];
		$conyuge_nombre = $data['conyuge_nombre'];
		$conyuge_telefono = $data['conyuge_telefono'];
		$conyuge_celular = $data['conyuge_celular'];
		$peso = $data['peso'];
		$estatura = $data['estatura'];
		$declara_renta = $data['declara_renta'];
		$persona_publica = $data['persona_publica'];
		$cuenta_numero = $data['cuenta_numero'];
		$cuenta_tipo = $data['cuenta_tipo'];
		$entidad_bancaria = $data['entidad_bancaria'];
		$ingreso_mensual = $data['ingreso_mensual'];
		$otros_ingresos = $data['otros_ingresos'];
		$total_ingresos = $data['total_ingresos'];
		$canon_arrendamiento = $data['canon_arrendamiento'];
		$otros_gastos = $data['otros_gastos'];
		$total_egresos = $data['total_egresos'];
		$activos = $data['activos'];
		$pasivos = $data['pasivos'];
		$patrimonio = $data['patrimonio'];
		$descripcion_ingresos = $data['descripcion_ingresos'];
		$descripcion_recursos = $data['descripcion_recursos'];
		$tipo_garantia = $data['tipo_garantia'];
		$FM_meses = $data['FM_meses'];
		$observaciones = $data['observaciones'];
		$observacion_analista = $data['observacion_analista'];
		$observacion_auxiliar = $data['observacion_auxiliar'];
		$observacion_riesgo = $data['observacion_riesgo'];
		$tramite = $data['tramite'];
		$gestor_comercial = $data['gestor_comercial'];
		$asignado = $data['asignado'];
		$fecha_asignado = $data['fecha_asignado'];
		$pagare = $data['pagare'];
		$quien = $data['quien'];
		$fecha_estado = $data['fecha_estado'];
		$numero_obligacion = $data['numero_obligacion'];
		$autorizo = $data['autorizo'];
		$fecha_autorizo = $data['fecha_autorizo'];
		$estado_autorizo = $data['estado_autorizo'];
		$incompleta = $data['incompleta'];
		$fecha_anterior = $data['fecha_anterior'];
		$asignado_anterior = $data['asignado_anterior'];
		$nomenclatura1 = $data['nomenclatura1'];
		$nomenclatura2 = $data['nomenclatura2'];
		$capacidad_endeudamiento = $data['capacidad_endeudamiento'];
		$cuota_prima = $data['cuota_prima'];
		$cuota_prima_desembolso = $data['cuota_prima_desembolso'];
		$query = "INSERT INTO solicitudes(cuota_prima_desembolso, cuota_prima,cedula, linea, destino, valor, monto_solicitado, valor_desembolso, linea_desembolso, cuotas_desembolso, valor_cuota_desembolso, tasa_desembolso, cuotas_extra_desembolso, valor_extra_desembolso, cuotas, valor_cuota, cuotas_extra, valor_extra, tasa, fecha, validacion, radicacion, paso, nombres, nombres2, apellido1, apellido2, sexo, tipo_documento, documento, fecha_documento, ciudad_documento, fecha_nacimiento, empresa, dependencia, direccion_oficina, ciudad_oficina, telefono_oficina, celular, direccion_residencia, barrio, ciudad_residencia, telefono, correo_empresarial, correo_personal, situacion_laboral, cual, ocupacion, estado_civil, conyuge_nombre, conyuge_telefono, conyuge_celular, peso, estatura, declara_renta, persona_publica, cuenta_numero, cuenta_tipo, entidad_bancaria, ingreso_mensual, otros_ingresos, total_ingresos, canon_arrendamiento, otros_gastos, total_egresos, activos, pasivos, patrimonio, descripcion_ingresos, descripcion_recursos, tipo_garantia, FM_meses, observaciones, observacion_analista, observacion_auxiliar, observacion_riesgo, tramite, gestor_comercial, asignado, fecha_asignado, pagare, quien, fecha_estado, numero_obligacion, autorizo, fecha_autorizo, estado_autorizo, incompleta, fecha_anterior, asignado_anterior,nomenclatura1,nomenclatura2,tasa_anual,capacidad_endeudamiento) VALUES ('$cuota_prima_desembolso','$cuota_prima', '$cedula', '$linea', '$destino', '$valor', '$monto_solicitado', '$valor_desembolso', '$linea_desembolso', '$cuotas_desembolso', '$valor_cuota_desembolso', '$tasa_desembolso', '$cuotas_extra_desembolso', '$valor_extra_desembolso', '$cuotas', '$valor_cuota', '$cuotas_extra', '$valor_extra', '$tasa', '$fecha', '$validacion', '$radicacion', '$paso', '$nombres', '$nombres2', '$apellido1', '$apellido2', '$sexo', '$tipo_documento', '$documento', '$fecha_documento', '$ciudad_documento', '$fecha_nacimiento', '$empresa', '$dependencia', '$direccion_oficina', '$ciudad_oficina', '$telefono_oficina', '$celular', '$direccion_residencia', '$barrio', '$ciudad_residencia', '$telefono', '$correo_empresarial', '$correo_personal', '$situacion_laboral', '$cual', '$ocupacion', '$estado_civil', '$conyuge_nombre', '$conyuge_telefono', '$conyuge_celular', '$peso', '$estatura', '$declara_renta', '$persona_publica', '$cuenta_numero', '$cuenta_tipo', '$entidad_bancaria', '$ingreso_mensual', '$otros_ingresos', '$total_ingresos', '$canon_arrendamiento', '$otros_gastos', '$total_egresos', '$activos', '$pasivos', '$patrimonio', '$descripcion_ingresos', '$descripcion_recursos', '$tipo_garantia', '$FM_meses', '$observaciones', '$observacion_analista', '$observacion_auxiliar', '$observacion_riesgo', '$tramite', '$gestor_comercial', '$asignado', '$fecha_asignado', '$pagare', '$quien', '$fecha_estado', '$numero_obligacion', '$autorizo', '$fecha_autorizo', '$estado_autorizo', '$incompleta', '$fecha_anterior', '$asignado_anterior','$nomenclatura1','$nomenclatura2','$tasa_anual','$capacidad_endeudamiento')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	public function insert2($data){
		$cedula = $data['cedula'];
		$linea = $data['linea'];
		$destino = $data['destino'];
		$valor = $data['valor'];
		$monto_solicitado = $data['monto_solicitado'];
		$valor_desembolso = $data['valor_desembolso'];
		$linea_desembolso = $data['linea_desembolso'];
		$cuotas_desembolso = $data['cuotas_desembolso'];
		$valor_cuota_desembolso = $data['valor_cuota_desembolso'];
		$tasa_desembolso = $data['tasa_desembolso'];
		$cuotas_extra_desembolso = $data['cuotas_extra_desembolso'];
		$valor_extra_desembolso = $data['valor_extra_desembolso']*1;
		$cuotas = $data['cuotas'];
		$valor_cuota = $data['valor_cuota'];
		$cuotas_extra = $data['cuotas_extra'];
		$valor_extra = $data['valor_extra']*1;
		$tasa = $data['tasa'];
		$fecha = $data['fecha'];
		$validacion = $data['validacion'];
		$radicacion = $data['radicacion'];
		$paso = $data['paso'];
		$observaciones = $data['observaciones'];
		$tramite = $data['tramite'];
		$gestor_comercial = $data['gestor_comercial'];
		$nomenclatura1 = $data['nomenclatura1'];
		$nomenclatura2 = $data['nomenclatura2'];
		$frecuencia = $data['frecuencia'];
		$tasa_anual = $data['tasa_anual'];
		$cuota_prima = $data['cuota_prima'];
		$cuota_prima_desembolso = $data['cuota_prima_desembolso'];
		//print_r($data);

		echo $query = "INSERT INTO solicitudes(cuota_prima_desembolso,cuota_prima, cedula, linea, destino, valor, monto_solicitado, valor_desembolso, linea_desembolso, cuotas_desembolso, valor_cuota_desembolso, tasa_desembolso, cuotas_extra_desembolso, valor_extra_desembolso, cuotas, valor_cuota, cuotas_extra, valor_extra, tasa, fecha, validacion, radicacion, paso, observaciones, tramite, gestor_comercial,nomenclatura1,nomenclatura2,frecuencia,tasa_anual) VALUES ('$cuota_prima_desembolso','$cuota_prima', '$cedula', '$linea', '$destino', '$valor', '$monto_solicitado', '$valor_desembolso', '$linea_desembolso', '$cuotas_desembolso', '$valor_cuota_desembolso', '$tasa_desembolso', '$cuotas_extra_desembolso', '$valor_extra_desembolso', '$cuotas', '$valor_cuota', '$cuotas_extra', '$valor_extra', '$tasa', '$fecha', '$validacion', '$radicacion', '$paso', '$observaciones', '$tramite', '$gestor_comercial','$nomenclatura1','$nomenclatura2','$frecuencia','$tasa_anual')";
		//echo $query."<br>";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un solicitud  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$cedula = $data['cedula'];
		$linea = $data['linea'];
		$destino = $data['destino'];
		$valor = $data['valor'];
		$monto_solicitado = $data['monto_solicitado'];
		$valor_desembolso = $data['valor_desembolso'];
		$linea_desembolso = $data['linea_desembolso'];
		$cuotas_desembolso = $data['cuotas_desembolso'];
		$valor_cuota_desembolso = $data['valor_cuota_desembolso'];
		$tasa_desembolso = $data['tasa_desembolso'];
		$cuotas_extra_desembolso = $data['cuotas_extra_desembolso'];
		$valor_extra_desembolso = $data['valor_extra_desembolso'];
		$cuotas = $data['cuotas'];
		$valor_cuota = $data['valor_cuota'];
		$cuotas_extra = $data['cuotas_extra'];
		$valor_extra = $data['valor_extra'];
		$tasa = $data['tasa'];
		$fecha = $data['fecha'];
		$validacion = $data['validacion'];
		$radicacion = $data['radicacion'];
		$paso = $data['paso'];
		$nombres = $data['nombres'];
		$nombres2 = $data['nombres2'];
		$apellido1 = $data['apellido1'];
		$apellido2 = $data['apellido2'];
		$sexo = $data['sexo'];
		$tipo_documento = $data['tipo_documento'];
		$documento = $data['documento'];
		$fecha_documento = $data['fecha_documento'];
		$ciudad_documento = $data['ciudad_documento'];
		$fecha_nacimiento = $data['fecha_nacimiento'];
		$empresa = $data['empresa'];
		$dependencia = $data['dependencia'];
		$direccion_oficina = $data['direccion_oficina'];
		$ciudad_oficina = $data['ciudad_oficina'];
		$telefono_oficina = $data['telefono_oficina'];
		$celular = $data['celular'];
		$direccion_residencia = $data['direccion_residencia'];
		$barrio = $data['barrio'];
		$ciudad_residencia = $data['ciudad_residencia'];
		$telefono = $data['telefono'];
		$correo_empresarial = $data['correo_empresarial'];
		$correo_personal = $data['correo_personal'];
		$situacion_laboral = $data['situacion_laboral'];
		$cual = $data['cual'];
		$ocupacion = $data['ocupacion'];
		$estado_civil = $data['estado_civil'];
		$conyuge_nombre = $data['conyuge_nombre'];
		$conyuge_telefono = $data['conyuge_telefono'];
		$conyuge_celular = $data['conyuge_celular'];
		$peso = $data['peso'];
		$estatura = $data['estatura'];
		$declara_renta = $data['declara_renta'];
		$persona_publica = $data['persona_publica'];
		$cuenta_numero = $data['cuenta_numero'];
		$cuenta_tipo = $data['cuenta_tipo'];
		$entidad_bancaria = $data['entidad_bancaria'];
		$ingreso_mensual = $data['ingreso_mensual'];
		$otros_ingresos = $data['otros_ingresos'];
		$total_ingresos = $data['total_ingresos'];
		$canon_arrendamiento = $data['canon_arrendamiento'];
		$otros_gastos = $data['otros_gastos'];
		$total_egresos = $data['total_egresos'];
		$activos = $data['activos'];
		$pasivos = $data['pasivos'];
		$patrimonio = $data['patrimonio'];
		$descripcion_ingresos = $data['descripcion_ingresos'];
		$descripcion_recursos = $data['descripcion_recursos'];
		$tipo_garantia = $data['tipo_garantia'];
		$FM_meses = $data['FM_meses'];
		$observaciones = $data['observaciones'];
		$observacion_analista = $data['observacion_analista'];
		$observacion_auxiliar = $data['observacion_auxiliar'];
		$observacion_riesgo = $data['observacion_riesgo'];
		$tramite = $data['tramite'];
		$gestor_comercial = $data['gestor_comercial'];
		$asignado = $data['asignado'];
		$fecha_asignado = $data['fecha_asignado'];
		$pagare = $data['pagare'];
		$quien = $data['quien'];
		$fecha_estado = $data['fecha_estado'];
		$numero_obligacion = $data['numero_obligacion'];
		$autorizo = $data['autorizo'];
		$fecha_autorizo = $data['fecha_autorizo'];
		$estado_autorizo = $data['estado_autorizo'];
		$incompleta = $data['incompleta'];
		$fecha_anterior = $data['fecha_anterior'];
		$asignado_anterior = $data['asignado_anterior'];
		$nomenclatura1 = $data['nomenclatura1'];
		$nomenclatura2 = $data['nomenclatura2'];
		$capacidad_endeudamiento = $data['capacidad_endeudamiento'];
		$cuota_prima = $data['cuota_prima'];
		$cuota_prima_desembolso = $data['cuota_prima_desembolso'];
		$recoger_credito = $data['recoger_credito'];
		$valor_recogidos = $data['valor_recogidos'];
		$query = "UPDATE solicitudes SET valor_recogidos = '$valor_recogidos', recoger_credito = '$recoger_credito', cuota_prima_desembolso = '$cuota_prima_desembolso',cuota_prima = '$cuota_prima', cedula = '$cedula', linea = '$linea', destino = '$destino', valor = '$valor', monto_solicitado = '$monto_solicitado', valor_desembolso = '$valor_desembolso', linea_desembolso = '$linea_desembolso', cuotas_desembolso = '$cuotas_desembolso', valor_cuota_desembolso = '$valor_cuota_desembolso', tasa_desembolso = '$tasa_desembolso', cuotas_extra_desembolso = '$cuotas_extra_desembolso', valor_extra_desembolso = '$valor_extra_desembolso', cuotas = '$cuotas', valor_cuota = '$valor_cuota', cuotas_extra = '$cuotas_extra', valor_extra = '$valor_extra', tasa = '$tasa', fecha = '$fecha', validacion = '$validacion', radicacion = '$radicacion', paso = '$paso', nombres = '$nombres', nombres2 = '$nombres2', apellido1 = '$apellido1', apellido2 = '$apellido2', sexo = '$sexo', tipo_documento = '$tipo_documento', documento = '$documento', fecha_documento = '$fecha_documento', ciudad_documento = '$ciudad_documento', fecha_nacimiento = '$fecha_nacimiento', empresa = '$empresa', dependencia = '$dependencia', direccion_oficina = '$direccion_oficina', ciudad_oficina = '$ciudad_oficina', telefono_oficina = '$telefono_oficina', celular = '$celular', direccion_residencia = '$direccion_residencia', barrio = '$barrio', ciudad_residencia = '$ciudad_residencia', telefono = '$telefono', correo_empresarial = '$correo_empresarial', correo_personal = '$correo_personal', situacion_laboral = '$situacion_laboral', cual = '$cual', ocupacion = '$ocupacion', estado_civil = '$estado_civil', conyuge_nombre = '$conyuge_nombre', conyuge_telefono = '$conyuge_telefono', conyuge_celular = '$conyuge_celular', peso = '$peso', estatura = '$estatura', declara_renta = '$declara_renta', persona_publica = '$persona_publica', cuenta_numero = '$cuenta_numero', cuenta_tipo = '$cuenta_tipo', entidad_bancaria = '$entidad_bancaria', ingreso_mensual = '$ingreso_mensual', otros_ingresos = '$otros_ingresos', total_ingresos = '$total_ingresos', canon_arrendamiento = '$canon_arrendamiento', otros_gastos = '$otros_gastos', total_egresos = '$total_egresos', activos = '$activos', pasivos = '$pasivos', patrimonio = '$patrimonio', descripcion_ingresos = '$descripcion_ingresos', descripcion_recursos = '$descripcion_recursos', tipo_garantia = '$tipo_garantia', FM_meses = '$FM_meses', observaciones = '$observaciones', observacion_analista = '$observacion_analista', observacion_auxiliar = '$observacion_auxiliar', observacion_riesgo = '$observacion_riesgo', tramite = '$tramite', gestor_comercial = '$gestor_comercial', asignado = '$asignado', fecha_asignado = '$fecha_asignado', pagare = '$pagare', quien = '$quien', fecha_estado = '$fecha_estado', numero_obligacion = '$numero_obligacion', autorizo = '$autorizo', fecha_autorizo = '$fecha_autorizo', estado_autorizo = '$estado_autorizo', incompleta = '$incompleta', fecha_anterior = '$fecha_anterior', asignado_anterior = '$asignado_anterior', nomenclatura1='$nomenclatura1', nomenclatura2='$nomenclatura2', capacidad_endeudamiento='$capacidad_endeudamiento' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}


    public function getTotal($filters = '',$order = '')
    {
        $filter = '';
        if($filters != ''){
            $filter = ' WHERE '.$filters;
        }
        $orders ="";
        if($order != ''){
            $orders = ' ORDER BY '.$order;
        }
        $select = 'SELECT COUNT(*) AS total, SUM(valor) AS total2 FROM '.$this->_name.' '.$filter.' '.$orders;
        //echo $select."<br>";
        $res = $this->_conn->query( $select )->fetchAsObject();
        return $res;
    }

	public function getList2($filters = '',$order = '')
    {
        $filter = '';
        if($filters != ''){
            $filter = ' WHERE '.$filters;
        }
        $orders ="";
        if($order != ''){
            $orders = ' ORDER BY '.$order;
        }
        $select = 'SELECT Distinct solicitudes.id as id,solicitudes.nombres as nombre_as,solicitudes.nombres2 as nombre2_as,solicitudes.apellido1 as apellido_as,solicitudes.apellido2 as apellido2_as,solicitudes.cuotas,solicitudes.cuotas_desembolso ,solicitudes.valor_extra_desembolso , solicitudes.recoger_credito , solicitudes.cedula,garantias.garantia_nombre,lineas_credito.nombre as linea,solicitudes.valor_desembolso , regional.nombre as regional, solicitudes.monto_solicitado,solicitudes.linea_desembolso,solicitudes.observacion_analista,solicitudes.fecha_asignado,solicitudes.fecha as fecha,solicitudes.fecha_desembolso as fecha_desembolso, solicitudes.quien as quien, solicitudes.correo_empresarial, solicitudes.correo_personal, solicitudes.telefono_oficina, solicitudes.celular, solicitudes.cuenta_numero, solicitudes.cuenta_tipo, solicitudes.entidad_bancaria FROM '.$this->_name.' 
		left JOIN lineas_credito 
		ON lineas_credito.codigo = solicitudes.linea 
		left JOIN regional 
		ON regional.id = solicitudes.regional
		left JOIN garantias 
		ON garantias.garantia_id = solicitudes.tipo_garantia
		'.$filter.' '.$orders;
        //echo $select."<br>";
        $res = $this->_conn->query( $select )->fetchAsObject();
        return $res;
    }

  public function getListPages2($filters = '', $order = '', $page, $amount)
  {
    $filter = '';
    if ($filters != '') {
      $filter = ' WHERE ' . $filters;
    }
    $orders = "";
    if ($order != '') {
      $orders = ' ORDER BY ' . $order;
    }
    $select = 'SELECT Distinct solicitudes.* FROM ' . $this->_name . ' left JOIN comite 
		 ON comite.comite_solicitud_id = solicitudes.id  ' . $filter . '  ' . $orders . ' LIMIT ' . $page . ' , ' . $amount;
    $res = $this->_conn->query($select)->fetchAsObject();
    return $res;
  }

	public function borrarexpirados($fecha)
    {
        $update = "DELETE FROM ".$this->_name." WHERE paso!='8' AND incompleta IS NULL AND fecha<'".$fecha."'";
        $this->_conn->query( $update );
    }
      public function getOnlyDates($filters = '', $order = '')
  {
    $filter = '';
    if ($filters != '') {
      $filter = ' WHERE ' . $filters;
    }
    $orders = "";
    if ($order != '') {
      $orders = ' ORDER BY ' . $order;
    }

    $select = 'SELECT id, fecha_desembolso, fecha_asignado, fecha_aprobado FROM ' . $this->_name . ' ' . $filter . ' ' . $orders;
    
    $res = $this->_conn->query($select)->fetchAsObject();
    return $res;
  }

  public function getListFirmas($filters = '', $order = '')
  {
    $filter = '';
    if ($filters != '') {
      $filter = ' WHERE ' . $filters;
    }
    $orders = "";
    if ($order != '') {
      $orders = ' ORDER BY ' . $order;
    }
    $select = '
      SELECT s.id, pd.fecha_firma 
      FROM solicitudes s 
      JOIN pagare_deceval pd ON s.id = pd.pagare
      ' . $filter . '  ' . $orders;
    $res = $this->_conn->query($select)->fetchAsObject();
    return $res;
  }
}