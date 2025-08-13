<?php 
/**
* clase que genera la insercion y edicion  de cedulas en la base de datos
*/
class Administracion_Model_DbTable_Cedulas extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'cedulas';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un cedula y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$cedula = $data['cedula'];
		$nombre = $data['nombre'];
		$cupo = $data['cupo']*1;
		$aportes = $data['aportes']*1;
		$codigo_nomina = $data['codigo_nomina'];
		$nombre_nomina = $data['nombre_nomina'];

		$apellidos = $data['apellidos'];
		$salario = $data['salario'];
		$fecha_afiliacion = $data['fecha_afiliacion'];

		$query = "INSERT INTO cedulas( cedula, nombre, cupo, aportes, codigo_nomina, nombre_nomina, apellidos, salario, fecha_afiliacion) VALUES ( '$cedula', '$nombre', '$cupo', '$aportes', '$codigo_nomina', '$nombre_nomina', '$apellidos', '$salario', '$fecha_afiliacion' )";
		//echo $query."<br>";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un cedula  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){

		$cedula = $data['cedula'];
		$nombre = $data['nombre'];
		$cupo = $data['cupo']*1;
		$aportes = $data['aportes']*1;
		$codigo_nomina = $data['codigo_nomina'];
		$nombre_nomina = $data['nombre_nomina'];
		$query = "UPDATE cedulas SET  cedula = '$cedula', nombre = '$nombre', cupo = '$cupo', aportes = '$aportes', codigo_nomina = '$codigo_nomina', nombre_nomina = '$nombre_nomina' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}