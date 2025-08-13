<?php 
/**
* clase que genera la insercion y edicion  de logcreditos en la base de datos
*/
class Administracion_Model_DbTable_Logcreditos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'log_creditos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un logcreditos y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$solicitud = $data['solicitud'];
		$post = $data['post'];
		$files = $data['files'];
		$fecha = $data['fecha'];
		$query = "INSERT INTO log_creditos( solicitud, post, files, fecha) VALUES ( '$solicitud', '$post', '$files', '$fecha')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un logcreditos  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$solicitud = $data['solicitud'];
		$post = $data['post'];
		$files = $data['files'];
		$fecha = $data['fecha'];
		$query = "UPDATE log_creditos SET  solicitud = '$solicitud', post = '$post', files = '$files', fecha = '$fecha' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}