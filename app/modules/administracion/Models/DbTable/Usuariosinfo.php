<?php 
/**
* clase que genera la insercion y edicion  de usuarios info en la base de datos
*/
class Administracion_Model_DbTable_Usuariosinfo extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'usuarios_info';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'documento';

	/**
	 * insert recibe la informacion de un usuarios info y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$documento = $data['documento'];
		$tipo_documento = $data['tipo_documento'];
		$fecha_documento = $data['fecha_documento'];
		$nombres = $data['nombres'];
		$apellidos = $data['apellidos'];
		$ciudad = $data['ciudad'];
		$departamento = $data['departamento'];
		$pais = $data['pais'];
		$ciudad_documento = $data['ciudad_documento'];
		$departamento_documento = $data['departamento_documento'];
		$pais_documento = $data['pais_documento'];
		$fecha_nacimiento = $data['fecha_nacimiento'];
		$ciudad_nacimiento = $data['ciudad_nacimiento'];
		$direccion = $data['direccion'];
		$email = $data['email'];
		$email2 = $data['email2'];
		$telefono = $data['telefono'];
		$telefono2 = $data['telefono2'];
		$celular = $data['celular'];
		$fecha_ingreso = $data['fecha_ingreso'];
		$genero = $data['genero'];
		$empresa = $data['empresa'];
		$empresa_cual = $data['empresa_cual'];
		$barrio = $data['barrio'];
		$estado_civil = $data['estado_civil'];
		$direccion_oficina = $data['direccion_oficina'];
		$telefono_oficina = $data['telefono_oficina'];
		$telefono_oficina2 = $data['telefono_oficina2'];
		$telefono_oficina_ext = $data['telefono_oficina_ext'];
		$fecha_afiliacion = $data['fecha_afiliacion'];
		$cuenta_numero = $data['cuenta_numero'];
		$cuenta_tipo = $data['cuenta_tipo'];
		$entidad_bancaria = $data['entidad_bancaria'];
		$nivel_educativo = $data['nivel_educativo'];
		$titulo = $data['titulo'];
		$intereses = $data['intereses'];
		$codigo_ciuu = $data['codigo_ciuu'];
		$cargo = $data['cargo'];
		$salario = $data['salario'];
		$sede = $data['sede'];
		$ciudad_oficina = $data['ciudad_oficina'];
		$valor_cuota_periodica = $data['valor_cuota_periodica'];
		$valor_ahorro_voluntario = $data['valor_ahorro_voluntario'];
		$valor_ahorro_incentivo = $data['valor_ahorro_incentivo'];
		$recursos_publicos = $data['recursos_publicos'];
		$poder_publico = $data['poder_publico'];
		$reconocimiento = $data['reconocimiento'];
		$familiares = $data['familiares'];
		$especifique = $data['especifique'];
		$ingresos_mensuales = $data['ingresos_mensuales'];
		$egresos_mensuales = $data['egresos_mensuales'];
		$activos = $data['activos'];
		$pasivos = $data['pasivos'];
		$patrimonio = $data['patrimonio'];
		$otros_ingresos = $data['otros_ingresos'];
		$concepto_otros_ingresos = $data['concepto_otros_ingresos'];
		$transacciones_moneda_extranjera = $data['transacciones_moneda_extranjera'];
		$operaciones_internacionales = $data['operaciones_internacionales'];
		$operaciones_cual = $data['operaciones_cual'];
		$producto_tipo = $data['producto_tipo'];
		$producto_numero = $data['producto_numero'];
		$producto_entidad = $data['producto_entidad'];
		$producto_monto = $data['producto_monto'];
		$producto_ciudad = $data['producto_ciudad'];
		$producto_pais = $data['producto_pais'];
		$producto_moneda = $data['producto_moneda'];
		$situacion_laboral = $data['situacion_laboral'];
		$id_deceval = $data['id_deceval'];
		$fecha_afiliacion_koba = $data['fecha_afiliacion_koba'];
		$query = "INSERT INTO usuarios_info(fecha_afiliacion_koba, documento, tipo_documento, fecha_documento, nombres, apellidos, ciudad, departamento, pais, ciudad_documento, departamento_documento, pais_documento, fecha_nacimiento, ciudad_nacimiento, direccion, email, email2, telefono, telefono2, celular, fecha_ingreso, genero, empresa, empresa_cual, barrio, estado_civil, direccion_oficina, telefono_oficina, telefono_oficina2, telefono_oficina_ext, fecha_afiliacion, cuenta_numero, cuenta_tipo, entidad_bancaria, nivel_educativo, titulo, intereses, codigo_ciuu, cargo, salario, sede, ciudad_oficina, valor_cuota_periodica, valor_ahorro_voluntario, valor_ahorro_incentivo, recursos_publicos, poder_publico, reconocimiento, familiares, especifique, ingresos_mensuales, egresos_mensuales, activos, pasivos, patrimonio, otros_ingresos, concepto_otros_ingresos, transacciones_moneda_extranjera, operaciones_internacionales, operaciones_cual, producto_tipo, producto_numero, producto_entidad, producto_monto, producto_ciudad, producto_pais, producto_moneda, situacion_laboral, id_deceval) VALUES ('$fecha_afiliacion_koba', '$documento', '$tipo_documento', '$fecha_documento', '$nombres', '$apellidos', '$ciudad', '$departamento', '$pais', '$ciudad_documento', '$departamento_documento', '$pais_documento', '$fecha_nacimiento', '$ciudad_nacimiento', '$direccion', '$email', '$email2', '$telefono', '$telefono2', '$celular', '$fecha_ingreso', '$genero', '$empresa', '$empresa_cual', '$barrio', '$estado_civil', '$direccion_oficina', '$telefono_oficina', '$telefono_oficina2', '$telefono_oficina_ext', '$fecha_afiliacion', '$cuenta_numero', '$cuenta_tipo', '$entidad_bancaria', '$nivel_educativo', '$titulo', '$intereses', '$codigo_ciuu', '$cargo', '$salario', '$sede', '$ciudad_oficina', '$valor_cuota_periodica', '$valor_ahorro_voluntario', '$valor_ahorro_incentivo', '$recursos_publicos', '$poder_publico', '$reconocimiento', '$familiares', '$especifique', '$ingresos_mensuales', '$egresos_mensuales', '$activos', '$pasivos', '$patrimonio', '$otros_ingresos', '$concepto_otros_ingresos', '$transacciones_moneda_extranjera', '$operaciones_internacionales', '$operaciones_cual', '$producto_tipo', '$producto_numero', '$producto_entidad', '$producto_monto', '$producto_ciudad', '$producto_pais', '$producto_moneda', '$situacion_laboral', '$id_deceval')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un prueba  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$documento = $data['documento'];
		$tipo_documento = $data['tipo_documento'];
		$fecha_documento = $data['fecha_documento'];
		$nombres = $data['nombres'];
		$apellidos = $data['apellidos'];
		$ciudad = $data['ciudad'];
		$departamento = $data['departamento'];
		$pais = $data['pais'];
		$ciudad_documento = $data['ciudad_documento'];
		$departamento_documento = $data['departamento_documento'];
		$pais_documento = $data['pais_documento'];
		$fecha_nacimiento = $data['fecha_nacimiento'];
		$ciudad_nacimiento = $data['ciudad_nacimiento'];
		$direccion = $data['direccion'];
		$email = $data['email'];
		$email2 = $data['email2'];
		$telefono = $data['telefono'];
		$telefono2 = $data['telefono2'];
		$celular = $data['celular'];
		$fecha_ingreso = $data['fecha_ingreso'];
		$genero = $data['genero'];
		$empresa = $data['empresa'];
		$empresa_cual = $data['empresa_cual'];
		$barrio = $data['barrio'];
		$estado_civil = $data['estado_civil'];
		$direccion_oficina = $data['direccion_oficina'];
		$telefono_oficina = $data['telefono_oficina'];
		$telefono_oficina2 = $data['telefono_oficina2'];
		$telefono_oficina_ext = $data['telefono_oficina_ext'];
		$fecha_afiliacion = $data['fecha_afiliacion'];
		$cuenta_numero = $data['cuenta_numero'];
		$cuenta_tipo = $data['cuenta_tipo'];
		$entidad_bancaria = $data['entidad_bancaria'];
		$nivel_educativo = $data['nivel_educativo'];
		$titulo = $data['titulo'];
		$intereses = $data['intereses'];
		$codigo_ciuu = $data['codigo_ciuu'];
		$cargo = $data['cargo'];
		$salario = $data['salario'];
		$sede = $data['sede'];
		$ciudad_oficina = $data['ciudad_oficina'];
		$valor_cuota_periodica = $data['valor_cuota_periodica'];
		$valor_ahorro_voluntario = $data['valor_ahorro_voluntario'];
		$valor_ahorro_incentivo = $data['valor_ahorro_incentivo'];
		$recursos_publicos = $data['recursos_publicos'];
		$poder_publico = $data['poder_publico'];
		$reconocimiento = $data['reconocimiento'];
		$familiares = $data['familiares'];
		$especifique = $data['especifique'];
		$ingresos_mensuales = $data['ingresos_mensuales'];
		$egresos_mensuales = $data['egresos_mensuales'];
		$activos = $data['activos'];
		$pasivos = $data['pasivos'];
		$patrimonio = $data['patrimonio'];
		$otros_ingresos = $data['otros_ingresos'];
		$concepto_otros_ingresos = $data['concepto_otros_ingresos'];
		$transacciones_moneda_extranjera = $data['transacciones_moneda_extranjera'];
		$operaciones_internacionales = $data['operaciones_internacionales'];
		$operaciones_cual = $data['operaciones_cual'];
		$producto_tipo = $data['producto_tipo'];
		$producto_numero = $data['producto_numero'];
		$producto_entidad = $data['producto_entidad'];
		$producto_monto = $data['producto_monto'];
		$producto_ciudad = $data['producto_ciudad'];
		$producto_pais = $data['producto_pais'];
		$producto_moneda = $data['producto_moneda'];
		$situacion_laboral = $data['situacion_laboral'];
		$id_deceval = $data['id_deceval'];
		$fecha_afiliacion_koba = $data['fecha_afiliacion_koba'];
		$query = "UPDATE usuarios_info SET  fecha_afiliacion_koba = '$fecha_afiliacion_koba', documento = '$documento', tipo_documento = '$tipo_documento', fecha_documento = '$fecha_documento', nombres = '$nombres', apellidos = '$apellidos', ciudad = '$ciudad', departamento = '$departamento', pais = '$pais', ciudad_documento = '$ciudad_documento', departamento_documento = '$departamento_documento', pais_documento = '$pais_documento', fecha_nacimiento = '$fecha_nacimiento', ciudad_nacimiento = '$ciudad_nacimiento', direccion = '$direccion', email = '$email', email2 = '$email2', telefono = '$telefono', telefono2 = '$telefono2', celular = '$celular', fecha_ingreso = '$fecha_ingreso', genero = '$genero', empresa = '$empresa', empresa_cual = '$empresa_cual', barrio = '$barrio', estado_civil = '$estado_civil', direccion_oficina = '$direccion_oficina', telefono_oficina = '$telefono_oficina', telefono_oficina2 = '$telefono_oficina2', telefono_oficina_ext = '$telefono_oficina_ext', fecha_afiliacion = '$fecha_afiliacion', cuenta_numero = '$cuenta_numero', cuenta_tipo = '$cuenta_tipo', entidad_bancaria = '$entidad_bancaria', nivel_educativo = '$nivel_educativo', titulo = '$titulo', intereses = '$intereses', codigo_ciuu = '$codigo_ciuu', cargo = '$cargo', salario = '$salario', sede = '$sede', ciudad_oficina = '$ciudad_oficina', valor_cuota_periodica = '$valor_cuota_periodica', valor_ahorro_voluntario = '$valor_ahorro_voluntario', valor_ahorro_incentivo = '$valor_ahorro_incentivo', recursos_publicos = '$recursos_publicos', poder_publico = '$poder_publico', reconocimiento = '$reconocimiento', familiares = '$familiares', especifique = '$especifique', ingresos_mensuales = '$ingresos_mensuales', egresos_mensuales = '$egresos_mensuales', activos = '$activos', pasivos = '$pasivos', patrimonio = '$patrimonio', otros_ingresos = '$otros_ingresos', concepto_otros_ingresos = '$concepto_otros_ingresos', transacciones_moneda_extranjera = '$transacciones_moneda_extranjera', operaciones_internacionales = '$operaciones_internacionales', operaciones_cual = '$operaciones_cual', producto_tipo = '$producto_tipo', producto_numero = '$producto_numero', producto_entidad = '$producto_entidad', producto_monto = '$producto_monto', producto_ciudad = '$producto_ciudad', producto_pais = '$producto_pais', producto_moneda = '$producto_moneda', situacion_laboral = '$situacion_laboral', id_deceval = '$id_deceval' WHERE  = '".$id."'";
		$res = $this->_conn->query($query);
	}


    public function editField($id,$field,$value){
        $query =' UPDATE '.$this->_name.' SET '.$field.' = "'.$value.'" WHERE '.$this->_id.' = "'.$id.'"';
        //echo $query."<br>";
        $res = $this->_conn->query($query);
    }

}