<?php 
/**
* clase que genera la insercion y edicion  de afianzafondos en la base de datos
*/
class Administracion_Model_DbTable_Archivosafianzafondos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'archivos_afianzafondos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un afianzafondos y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$archivo = $data['archivo'];
		$solicitud = $data['solicitud'];
		$fecha = $data['fecha'];
		$query = "INSERT INTO archivos_afianzafondos( archivo, solicitud, fecha) VALUES ( '$archivo', '$solicitud', '$fecha')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un afianzafondos  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$archivo = $data['archivo'];
		$solicitud = $data['solicitud'];
		$fecha = $data['fecha'];
		$query = "UPDATE archivos_afianzafondos SET  archivo = '$archivo', solicitud = '$solicitud', fecha = '$fecha' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}