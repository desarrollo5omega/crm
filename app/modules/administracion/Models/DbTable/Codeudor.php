<?php 
/**
* clase que genera la insercion y edicion  de codeudor en la base de datos
*/
class Administracion_Model_DbTable_Codeudor extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'codeudor';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un coudedor y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$solicitud = $data['solicitud'];
		$nombres = $data['nombres'];
		$nombres2 = $data['nombres2'];
		$apellido1 = $data['apellido1'];
		$apellido2 = $data['apellido2'];
		$cedula = $data['cedula'];
		$tipo_documento = $data['tipo_documento'];
		$sexo = $data['sexo'];
		$ciudad_documento = $data['ciudad_documento'];
		$empresa = $data['empresa'];
		$dependencia = $data['dependencia'];
		$direccion_oficina = $data['direccion_oficina'];
		$ciudad_oficina = $data['ciudad_oficina'];
		$telefono_oficina = $data['telefono_oficina'];
		$cargo = $data['cargo'];
		$ciudad = $data['ciudad'];
		$telefono = $data['telefono'];
		$correo_empresarial = $data['correo_empresarial'];
		$situacion_laboral = $data['situacion_laboral'];
		$cual = $data['cual'];
		$estado_civil = $data['estado_civil'];
		$conyuge_nombre = $data['conyuge_nombre'];
		$conyuge_telefono = $data['conyuge_telefono'];
		$conyuge_celular = $data['conyuge_celular'];
		$declara_renta = $data['declara_renta'];
		$persona_publica = $data['persona_publica'];
		$cuenta_numero = $data['cuenta_numero'];
		$cuenta_tipo = $data['cuenta_tipo'];
		$entidad_bancaria = $data['entidad_bancaria'];
		$celular = $data['celular'];
		$direccion_residencia = $data['direccion_residencia'];
		$barrio = $data['barrio'];
		$ciudad_residencia = $data['ciudad_residencia'];
		$salario = $data['salario'];
		$forma_pago = $data['forma_pago'];
		$tiempo_anio = $data['tiempo_anio'];
		$tiempo_meses = $data['tiempo_meses'];
		$correo = $data['correo'];
		$asociado = $data['asociado'];
		$fecha_nacimiento = $data['fecha_nacimiento'];
		$fecha_documento = $data['fecha_documento'];
		$nomenclatura1 = $data['nomenclatura1'];
		$nomenclatura2 = $data['nomenclatura2'];
		$codeudor_numero = $data['codeudor_numero'];
		$query = "INSERT INTO codeudor( solicitud, nombres, nombres2, apellido1, apellido2, cedula, tipo_documento, sexo, ciudad_documento, empresa, dependencia, direccion_oficina, ciudad_oficina, telefono_oficina, cargo, ciudad, telefono, correo_empresarial, situacion_laboral, cual, estado_civil, conyuge_nombre, conyuge_telefono, conyuge_celular, declara_renta, persona_publica, cuenta_numero, cuenta_tipo, entidad_bancaria, celular, direccion_residencia, barrio, ciudad_residencia, salario, forma_pago, tiempo_anio, tiempo_meses, correo, asociado, fecha_nacimiento, fecha_documento, nomenclatura1, nomenclatura2, codeudor_numero) VALUES ( '$solicitud', '$nombres', '$nombres2', '$apellido1', '$apellido2', '$cedula', '$tipo_documento', '$sexo', '$ciudad_documento', '$empresa', '$dependencia', '$direccion_oficina', '$ciudad_oficina', '$telefono_oficina', '$cargo', '$ciudad', '$telefono', '$correo_empresarial', '$situacion_laboral', '$cual', '$estado_civil', '$conyuge_nombre', '$conyuge_telefono', '$conyuge_celular', '$declara_renta', '$persona_publica', '$cuenta_numero', '$cuenta_tipo', '$entidad_bancaria', '$celular', '$direccion_residencia', '$barrio', '$ciudad_residencia', '$salario', '$forma_pago', '$tiempo_anio', '$tiempo_meses', '$correo', '$asociado', '$fecha_nacimiento', '$fecha_documento', '$nomenclatura1', '$nomenclatura2','$codeudor_numero')";
		//echo $query;
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un coudedor  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$solicitud = $data['solicitud'];
		$nombres = $data['nombres'];
		$nombres2 = $data['nombres2'];
		$apellido1 = $data['apellido1'];
		$apellido2 = $data['apellido2'];
		$cedula = $data['cedula'];
		$tipo_documento = $data['tipo_documento'];
		$sexo = $data['sexo'];
		$ciudad_documento = $data['ciudad_documento'];
		$empresa = $data['empresa'];
		$dependencia = $data['dependencia'];
		$direccion_oficina = $data['direccion_oficina'];
		$ciudad_oficina = $data['ciudad_oficina'];
		$telefono_oficina = $data['telefono_oficina'];
		$cargo = $data['cargo'];
		$ciudad = $data['ciudad'];
		$telefono = $data['telefono'];
		$correo_empresarial = $data['correo_empresarial'];
		$situacion_laboral = $data['situacion_laboral'];
		$cual = $data['cual'];
		$estado_civil = $data['estado_civil'];
		$conyuge_nombre = $data['conyuge_nombre'];
		$conyuge_telefono = $data['conyuge_telefono'];
		$conyuge_celular = $data['conyuge_celular'];
		$declara_renta = $data['declara_renta'];
		$persona_publica = $data['persona_publica'];
		$cuenta_numero = $data['cuenta_numero'];
		$cuenta_tipo = $data['cuenta_tipo'];
		$entidad_bancaria = $data['entidad_bancaria'];
		$celular = $data['celular'];
		$direccion_residencia = $data['direccion_residencia'];
		$barrio = $data['barrio'];
		$ciudad_residencia = $data['ciudad_residencia'];
		$salario = $data['salario'];
		$forma_pago = $data['forma_pago'];
		$tiempo_anio = $data['tiempo_anio'];
		$tiempo_meses = $data['tiempo_meses'];
		$correo = $data['correo'];
		$asociado = $data['asociado'];
		$fecha_nacimiento = $data['fecha_nacimiento'];
		$fecha_documento = $data['fecha_documento'];
		$nomenclatura1 = $data['nomenclatura1'];
		$nomenclatura2 = $data['nomenclatura2'];
		$codeudor_numero = $data['codeudor_numero'];
		$query = "UPDATE codeudor SET  solicitud = '$solicitud', nombres = '$nombres', nombres2 = '$nombres2', apellido1 = '$apellido1', apellido2 = '$apellido2', cedula = '$cedula', tipo_documento = '$tipo_documento', sexo = '$sexo', ciudad_documento = '$ciudad_documento', empresa = '$empresa', dependencia = '$dependencia', direccion_oficina = '$direccion_oficina', ciudad_oficina = '$ciudad_oficina', telefono_oficina = '$telefono_oficina', cargo = '$cargo', ciudad = '$ciudad', telefono = '$telefono', correo_empresarial = '$correo_empresarial', situacion_laboral = '$situacion_laboral', cual = '$cual', estado_civil = '$estado_civil', conyuge_nombre = '$conyuge_nombre', conyuge_telefono = '$conyuge_telefono', conyuge_celular = '$conyuge_celular', declara_renta = '$declara_renta', persona_publica = '$persona_publica', cuenta_numero = '$cuenta_numero', cuenta_tipo = '$cuenta_tipo', entidad_bancaria = '$entidad_bancaria', celular = '$celular', direccion_residencia = '$direccion_residencia', barrio = '$barrio', ciudad_residencia = '$ciudad_residencia', salario = '$salario', forma_pago = '$forma_pago', tiempo_anio = '$tiempo_anio', tiempo_meses = '$tiempo_meses', correo = '$correo', asociado = '$asociado', fecha_nacimiento = '$fecha_nacimiento', fecha_documento = '$fecha_documento', nomenclatura1='$nomenclatura1', nomenclatura2='$nomenclatura2', codeudor_numero='$codeudor_numero' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}


	public function borrar($solicitud){
		$query = " DELETE FROM codeudor WHERE solicitud='$solicitud' ";
		$this->_conn->query($query);
	}

	public function borrarn($solicitud,$n){
		if($n=="2"){
			$query = " DELETE FROM codeudor WHERE solicitud='$solicitud' AND codeudor_numero='$n' ";
		}else{
			$query = " DELETE FROM codeudor WHERE solicitud='$solicitud' AND (codeudor_numero='1' or codeudor_numero='' or codeudor_numero IS NULL ) ";
		}
		$this->_conn->query($query);
	}

}