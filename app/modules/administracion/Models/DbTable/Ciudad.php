<?php 
/**
* clase que genera la insercion y edicion  de ciudades en la base de datos
*/
class Administracion_Model_DbTable_Ciudad extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'ciudad';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'codigo';

	/**
	 * insert recibe la informacion de un ciudad y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$nombre = $data['nombre'];
		$departamento = $data['departamento'];
		$pais = $data['pais'];
		$query = "INSERT INTO ciudad( nombre, departamento, pais) VALUES ( '$nombre', '$departamento', '$pais')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un ciudad  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$nombre = $data['nombre'];
		$departamento = $data['departamento'];
		$pais = $data['pais'];
		$query = "UPDATE ciudad SET  nombre = '$nombre', departamento = '$departamento', pais = '$pais' WHERE codigo = '".$id."'";
		$res = $this->_conn->query($query);
	}
}