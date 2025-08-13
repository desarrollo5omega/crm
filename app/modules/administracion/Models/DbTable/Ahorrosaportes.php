<?php 
/**
* clase que genera la insercion y edicion  de ahorros y aportes en la base de datos
*/
class Administracion_Model_DbTable_Ahorrosaportes extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'ahorros_aportes';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un ahorros y aporte y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$cedula = $data['cedula'];
		$ahorros = $data['ahorros'];
		$aportes = $data['aportes'];
		$ahorrovol = $data['ahorrovol'];
		$query = "INSERT INTO ahorros_aportes (ahorrovol, cedula, ahorros, aportes) VALUES ( '$ahorrovol','$cedula', '$ahorros', '$aportes')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un ahorros y aporte  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$cedula = $data['cedula'];
		$ahorros = $data['ahorros'];
		$aportes = $data['aportes'];
		$ahorrovol = $data['ahorrovol'];
		$query = "UPDATE ahorros_aportes SET  ahorrovol = '$ahorrovol',cedula = '$cedula', ahorros = '$ahorros', aportes = '$aportes' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
	public function vaciar(){
		$query = "truncate table ahorros_aportes";
		$res = $this->_conn->query($query);
	}
}