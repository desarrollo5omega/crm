<?php 
/**
* clase que genera la insercion y edicion  de seguimiento proyecto en la base de datos
*/
class Page_Model_DbTable_Seguimientoproyecto extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'seguimiento_proyecto';

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
		$fecha = $data['fecha'];
		$seguimiento = $data['seguimiento'];
		$programar = $data['programar'];
		$quien = $data['quien'];
		$proyecto_id = $data['proyecto_id'];
		$client_id = $data['client_id'];
		$query = "INSERT INTO seguimiento_proyecto( fecha, seguimiento, programar, quien, proyecto_id, client_id) VALUES ( '$fecha', '$seguimiento', '$programar', '$quien', '$proyecto_id', '$client_id')";
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
		
		$fecha = $data['fecha'];
		$seguimiento = $data['seguimiento'];
		$programar = $data['programar'];
		$quien = $data['quien'];
		$proyecto_id = $data['proyecto_id'];
		$client_id = $data['client_id'];
		$query = "UPDATE seguimiento_proyecto SET  fecha = '$fecha', seguimiento = '$seguimiento', programar = '$programar', proyecto_id = '$proyecto_id', client_id = '$client_id' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}