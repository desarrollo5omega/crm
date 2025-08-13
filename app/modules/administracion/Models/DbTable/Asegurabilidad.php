<?php 
/**
* clase que genera la insercion y edicion  de asegurabilidad en la base de datos
*/
class Administracion_Model_DbTable_Asegurabilidad extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'asegurabilidad';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un asegurabilidad y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$solicitud = $data['solicitud'];
		$paso = $data['paso'];
		$fecha = $data['fecha'];
		$tipo_documento = $data['tipo_documento'];
		$documento = $data['documento'];
		$nombres = $data['nombres'];
		$nombres2 = $data['nombres2'];
		$apellido1 = $data['apellido1'];
		$apellido2 = $data['apellido2'];
		$fn_dia = $data['fn_dia'];
		$fn_mes = $data['fn_mes'];
		$fn_anio = $data['fn_anio'];
		$telefono_oficina = $data['telefono_oficina'];
		$correo_personal = $data['correo_personal'];
		$direccion_residencia = $data['direccion_residencia'];
		$ciudad_residencia = $data['ciudad_residencia'];
		$sexo = $data['sexo'];
		$celular = $data['celular'];
		$ocupacion = $data['ocupacion'];
		$estado_civil = $data['estado_civil'];
		$peso = $data['peso'];
		$estatura = $data['estatura'];
		$prima = $data['prima'];
		$prima_valor = $data['prima_valor'];
		$otra_cual = $data['otra_cual'];
		$otra_cual2 = $data['otra_cual2'];
		$tiene = $data['tiene'];
		$drogas = $data['drogas'];
		$alcoholismo = $data['alcoholismo'];
		$drogadiccion = $data['drogadiccion'];
		$hospitalizado = $data['hospitalizado'];
		$antecedentes = $data['antecedentes'];
		$observaciones = $data['observaciones'];
		$cobertura = $data['cobertura'];
		$consecutivo = $data['consecutivo'];
		$query = "INSERT INTO asegurabilidad( solicitud, paso, fecha, tipo_documento, documento, nombres, nombres2, apellido1, apellido2, fn_dia, fn_mes, fn_anio, telefono_oficina, correo_personal, direccion_residencia, ciudad_residencia, sexo, celular, ocupacion, estado_civil, peso, estatura, prima, prima_valor, otra_cual, otra_cual2, tiene, drogas, alcoholismo, drogadiccion, hospitalizado, antecedentes, observaciones, cobertura, consecutivo) VALUES ( '$solicitud', '$paso', '$fecha', '$tipo_documento', '$documento', '$nombres', '$nombres2', '$apellido1', '$apellido2', '$fn_dia', '$fn_mes', '$fn_anio', '$telefono_oficina', '$correo_personal', '$direccion_residencia', '$ciudad_residencia', '$sexo', '$celular', '$ocupacion', '$estado_civil', '$peso', '$estatura', '$prima', '$prima_valor', '$otra_cual', '$otra_cual2', '$tiene', '$drogas', '$alcoholismo', '$drogadiccion', '$hospitalizado', '$antecedentes', '$observaciones', '$cobertura', '$consecutivo')";
		echo $query;
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un asegurabilidad  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$solicitud = $data['solicitud'];
		$paso = $data['paso'];
		$fecha = $data['fecha'];
		$tipo_documento = $data['tipo_documento'];
		$documento = $data['documento'];
		$nombres = $data['nombres'];
		$nombres2 = $data['nombres2'];
		$apellido1 = $data['apellido1'];
		$apellido2 = $data['apellido2'];
		$fn_dia = $data['fn_dia'];
		$fn_mes = $data['fn_mes'];
		$fn_anio = $data['fn_anio'];
		$telefono_oficina = $data['telefono_oficina'];
		$correo_personal = $data['correo_personal'];
		$direccion_residencia = $data['direccion_residencia'];
		$ciudad_residencia = $data['ciudad_residencia'];
		$sexo = $data['sexo'];
		$celular = $data['celular'];
		$ocupacion = $data['ocupacion'];
		$estado_civil = $data['estado_civil'];
		$peso = $data['peso'];
		$estatura = $data['estatura'];
		$prima = $data['prima'];
		$prima_valor = $data['prima_valor'];
		$otra_cual = $data['otra_cual'];
		$otra_cual2 = $data['otra_cual2'];
		$tiene = $data['tiene'];
		$drogas = $data['drogas'];
		$alcoholismo = $data['alcoholismo'];
		$drogadiccion = $data['drogadiccion'];
		$hospitalizado = $data['hospitalizado'];
		$antecedentes = $data['antecedentes'];
		$observaciones = $data['observaciones'];
		$cobertura = $data['cobertura'];
		$consecutivo = $data['consecutivo'];
		$query = "UPDATE asegurabilidad SET  solicitud = '$solicitud', paso = '$paso', fecha = '$fecha', tipo_documento = '$tipo_documento', documento = '$documento', nombres = '$nombres', nombres2 = '$nombres2', apellido1 = '$apellido1', apellido2 = '$apellido2', fn_dia = '$fn_dia', fn_mes = '$fn_mes', fn_anio = '$fn_anio', telefono_oficina = '$telefono_oficina', correo_personal = '$correo_personal', direccion_residencia = '$direccion_residencia', ciudad_residencia = '$ciudad_residencia', sexo = '$sexo', celular = '$celular', ocupacion = '$ocupacion', estado_civil = '$estado_civil', peso = '$peso', estatura = '$estatura', prima = '$prima', prima_valor = '$prima_valor', otra_cual = '$otra_cual', otra_cual2 = '$otra_cual2', tiene = '$tiene', drogas = '$drogas', alcoholismo = '$alcoholismo', drogadiccion = '$drogadiccion', hospitalizado = '$hospitalizado', antecedentes = '$antecedentes', observaciones = '$observaciones', cobertura = '$cobertura', consecutivo = '$consecutivo' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}

	public function borrar($solicitud){
		$query = " DELETE FROM asegurabilidad WHERE formulario='$solicitud' ";
		$res = $this->_conn->query($query);
	}


}