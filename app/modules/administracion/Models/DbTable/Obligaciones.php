<?php 
/**
* clase que genera la insercion y edicion  de obligaciones en la base de datos
*/
class Administracion_Model_DbTable_Obligaciones extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'obligaciones';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un obligacion y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$id_carta = $data['id_carta'];
		$entidad = $data['entidad'];
		$numero_obligacion = $data['numero_obligacion'];
		$valor = $data['valor'];
		$query = "INSERT INTO obligaciones( id_carta, entidad, numero_obligacion, valor) VALUES ( '$id_carta', '$entidad', '$numero_obligacion', '$valor')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un obligacion  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$id_carta = $data['id_carta'];
		$entidad = $data['entidad'];
		$numero_obligacion = $data['numero_obligacion'];
		$valor = $data['valor'];
		$query = "UPDATE obligaciones SET  id_carta = '$id_carta', entidad = '$entidad', numero_obligacion = '$numero_obligacion', valor = '$valor' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
	public function delete($id)
    {
        $update = "DELETE FROM ".$this->_name." WHERE id_carta = '".$id."'";
        $this->_conn->query( $update );
    }
}