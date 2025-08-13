<?php 
/**
* clase que genera la insercion y edicion  de documentos adicionales en la base de datos
*/
class Administracion_Model_DbTable_Documentosadicionales extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'documentos_adicionales';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un documentos adicionales y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$titulo = $data['titulo'];
		$archivo = $data['archivo'];
		$fecha = $data['fecha'];
		$quien = $data['quien'];
		$solicitud = $data['solicitud'];
		$query = "INSERT INTO documentos_adicionales( titulo, archivo, fecha, quien, solicitud) VALUES ( '$titulo', '$archivo', '$fecha', '$quien', '$solicitud')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un documentos adicionales  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$titulo = $data['titulo'];
		$archivo = $data['archivo'];
		$fecha = $data['fecha'];
		$quien = $data['quien'];
		$solicitud = $data['solicitud'];
		$query = "UPDATE documentos_adicionales SET  titulo = '$titulo', archivo = '$archivo', fecha = '$fecha', quien = '$quien', solicitud = '$solicitud' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}