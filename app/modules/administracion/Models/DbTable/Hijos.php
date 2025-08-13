<?php 
/**
* clase que genera la insercion y edicion  de hijos en la base de datos
*/
class Administracion_Model_DbTable_Hijos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'hijos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un hijos y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$asociado = $data['asociado'];
		$nombres = $data['nombres'];
		$fecha_d = $data['fecha_d'];
		$fecha_m = $data['fecha_m'];
		$fecha_a = $data['fecha_a'];
		$edad = $data['edad'];
		$nivel_escolar = $data['nivel_escolar'];
		$i = $data['i'];
		$query = "INSERT INTO hijos( asociado, nombres, fecha_d, fecha_m, fecha_a, edad, nivel_escolar, i) VALUES ( '$asociado', '$nombres', '$fecha_d', '$fecha_m', '$fecha_a', '$edad', '$nivel_escolar', '$i')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un hijos  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		$asociado = $data['asociado'];
		$nombres = $data['nombres'];
		$fecha_d = $data['fecha_d'];
		$fecha_m = $data['fecha_m'];
		$fecha_a = $data['fecha_a'];
		$edad = $data['edad'];
		$nivel_escolar = $data['nivel_escolar'];
		$i = $data['i'];
		$query = "UPDATE hijos SET  asociado = '$asociado', nombres = '$nombres', fecha_d = '$fecha_d', fecha_m = '$fecha_m', fecha_a = '$fecha_a', edad = '$edad', nivel_escolar = '$nivel_escolar', i = '$i' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}

	public function borrar($documento){
		$query = " DELETE FROM hijos WHERE asociado = '".$documento."'";
		$res = $this->_conn->query($query);
	}

}