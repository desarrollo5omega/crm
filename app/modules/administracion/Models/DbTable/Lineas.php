<?php 
/**
* clase que genera la insercion y edicion  de l&iacute;neas de cr&eacute;dito en la base de datos
*/
class Administracion_Model_DbTable_Lineas extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'lineas_credito';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un l&iacute;nea y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$codigo = $data['codigo'];
		$nombre = $data['nombre'];
		$detalle = $data['detalle'];
		$tasa_cobrada = $data['tasa_cobrada'];
		$tasa_real = $data['tasa_real'];
		$efectivo_anual = $data['efectivo_anual'];
		$min_meses = $data['min_meses'];
		$max_meses = $data['max_meses'];
		$maxMonto = $data['maxMonto'];
		$descripcionGeneral = $data['descripcionGeneral'];
		$requisitos = $data['requisitos'];
		$activo = $data['activo'];
		$archivo1 = $data['archivo1'];
		$archivo2 = $data['archivo2'];
		$archivo3 = $data['archivo3'];
		$archivo4 = $data['archivo4'];
		$archivo22 = $data['archivo22'];
		$archivo23 = $data['archivo23'];
		$archivo24 = $data['archivo24'];
		$certificado_tradicion = $data['certificado_tradicion'];
		$estado_obligacion = $data['estado_obligacion'];
		$estado_obligacion2 = $data['estado_obligacion2'];
		$estado_obligacion3 = $data['estado_obligacion3'];
		$factura_proforma = $data['factura_proforma'];
		$recibo_matricula = $data['recibo_matricula'];
		$orden_medica = $data['orden_medica'];
		$certificacion = $data['certificacion'];
		$cotizacion = $data['cotizacion'];
		$peritaje_vehiculo = $data['peritaje_vehiculo'];
		$evidencia_calamidad = $data['evidencia_calamidad'];
		$soat = $data['soat'];
		$impuesto_vehiculo = $data['impuesto_vehiculo'];
		$query = "INSERT INTO lineas_credito( codigo, nombre, detalle, tasa_cobrada, tasa_real, efectivo_anual, max_meses, maxMonto, descripcionGeneral, requisitos, activo, archivo1, archivo2, archivo3, archivo4, archivo22, archivo23, archivo24, certificado_tradicion, estado_obligacion, estado_obligacion2, estado_obligacion3, factura_proforma, recibo_matricula,orden_medica,certificacion,cotizacion,peritaje_vehiculo,evidencia_calamidad,impuesto_vehiculo,soat,min_meses) VALUES ( '$codigo', '$nombre', '$detalle', '$tasa_cobrada', '$tasa_real', '$efectivo_anual', '$max_meses', '$maxMonto', '$descripcionGeneral', '$requisitos', '$activo', '$archivo1', '$archivo2', '$archivo3', '$archivo4', '$archivo22', '$archivo23', '$archivo24', '$certificado_tradicion', '$estado_obligacion', '$estado_obligacion2', '$estado_obligacion3', '$factura_proforma', '$recibo_matricula','$orden_medica','$certificacion','$cotizacion','$peritaje_vehiculo','$evidencia_calamidad','$impuesto_vehiculo','$soat','$min_meses')";
		//echo $query."<br>";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un l&iacute;nea  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){

		$codigo = $data['codigo'];
		$nombre = $data['nombre'];
		$detalle = $data['detalle'];
		$tasa_cobrada = $data['tasa_cobrada'];
		$tasa_real = $data['tasa_real'];
		$efectivo_anual = $data['efectivo_anual'];
		$min_meses = $data['min_meses'];
		$max_meses = $data['max_meses'];
		$maxMonto = $data['maxMonto'];
		$descripcionGeneral = $data['descripcionGeneral'];
		$requisitos = $data['requisitos'];
		$activo = $data['activo'];
		$archivo1 = $data['archivo1'];
		$archivo2 = $data['archivo2'];
		$archivo3 = $data['archivo3'];
		$archivo4 = $data['archivo4'];
		$archivo22 = $data['archivo22'];
		$archivo23 = $data['archivo23'];
		$archivo24 = $data['archivo24'];
		$certificado_tradicion = $data['certificado_tradicion'];
		$estado_obligacion = $data['estado_obligacion'];
		$estado_obligacion2 = $data['estado_obligacion2'];
		$estado_obligacion3 = $data['estado_obligacion3'];
		$factura_proforma = $data['factura_proforma'];
		$recibo_matricula = $data['recibo_matricula'];
		$orden_medica = $data['orden_medica'];
		$certificacion = $data['certificacion'];
		$cotizacion = $data['cotizacion'];
		$peritaje_vehiculo = $data['peritaje_vehiculo'];
		$evidencia_calamidad = $data['evidencia_calamidad'];
		$soat = $data['soat'];
		$impuesto_vehiculo = $data['impuesto_vehiculo'];
		$query = "UPDATE lineas_credito SET  codigo = '$codigo', nombre = '$nombre', detalle = '$detalle', tasa_cobrada = '$tasa_cobrada', tasa_real = '$tasa_real', efectivo_anual = '$efectivo_anual', max_meses = '$max_meses', maxMonto = '$maxMonto', descripcionGeneral = '$descripcionGeneral', requisitos = '$requisitos', activo = '$activo', archivo1 = '$archivo1', archivo2 = '$archivo2', archivo3 = '$archivo3', archivo4 = '$archivo4', archivo22 = '$archivo22', archivo23 = '$archivo23', archivo24 = '$archivo24', certificado_tradicion = '$certificado_tradicion', estado_obligacion = '$estado_obligacion', estado_obligacion2 = '$estado_obligacion2', estado_obligacion3 = '$estado_obligacion3', factura_proforma = '$factura_proforma', recibo_matricula = '$recibo_matricula', orden_medica = '$orden_medica',certificacion = '$certificacion',cotizacion = '$cotizacion',peritaje_vehiculo = '$peritaje_vehiculo',evidencia_calamidad = '$evidencia_calamidad', impuesto_vehiculo = '$impuesto_vehiculo', soat = '$soat', min_meses='$min_meses' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}