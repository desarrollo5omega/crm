<?php 
/**
* clase que genera la insercion y edicion  de cupos linea en la base de datos
*/
class Administracion_Model_DbTable_Cuposlinea extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'cupos_linea';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un cupos y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$cedula = $data['cedula'];
		$linea = $data['linea'];
		$cupo = $data['cupo'];
		$saldo_actual = $data['saldo_actual'];
		$query = "INSERT INTO cupos_linea( cedula, linea, cupo, saldo_actual) VALUES ( '$cedula', '$linea', '$cupo', '$saldo_actual')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un cupos  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$cedula = $data['cedula'];
		$linea = $data['linea'];
		$cupo = $data['cupo'];
		$saldo_actual = $data['saldo_actual'];
		$query = "UPDATE cupos_linea SET  cedula = '$cedula', linea = '$linea', cupo = '$cupo', saldo_actual = '$saldo_actual' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}