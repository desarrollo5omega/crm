<?php 
/**
* clase que genera la insercion y edicion  de garantias en la base de datos
*/
class Administracion_Model_DbTable_Garantias extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'garantias';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'garantia_id';

	/**
	 * insert recibe la informacion de un garantias y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$garantia_nombre = $data['garantia_nombre'];
		$query = "INSERT INTO garantias( garantia_nombre) VALUES ( '$garantia_nombre')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un garantias  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$garantia_nombre = $data['garantia_nombre'];
		$query = "UPDATE garantias SET  garantia_nombre = '$garantia_nombre' WHERE garantia_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}