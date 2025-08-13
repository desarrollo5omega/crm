<?php 
/**
* clase que genera la insercion y edicion  de seguimientos en la base de datos
*/
class Page_Model_DbTable_Seguimientos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'seguimientos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un seguimiento y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$seguimiento = $data['seguimiento'];
		$fecha = $data['fecha'];
		$quien = $data['quien'];
		$cliente_id = $data['cliente_id'];
		$query = "INSERT INTO seguimientos( seguimiento, fecha, quien, cliente_id) VALUES ( '$seguimiento', '$fecha', '$quien', '$cliente_id')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un seguimiento  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$seguimiento = $data['seguimiento'];
		$fecha = $data['fecha'];
		$quien = $data['quien'];
		$cliente_id = $data['cliente_id'];
		$query = "UPDATE seguimientos SET  seguimiento = '$seguimiento' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}