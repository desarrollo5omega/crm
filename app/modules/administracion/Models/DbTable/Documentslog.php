<?php 
/**
* clase que genera la insercion y edicion  de Log de Documentos en la base de datos
*/
class Administracion_Model_DbTable_Documentslog extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'documents_log';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'log_id';

	/**
	 * insert recibe la informacion de un Log de Documentos y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$log_date = $data['log_date'];
		$log_solicitud = $data['log_solicitud'];
		$log_log = $data['log_log'];
		$query = "INSERT INTO documents_log( log_date, log_solicitud, log_log) VALUES ( '$log_date', '$log_solicitud', '$log_log')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un Log de Documentos  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$log_date = $data['log_date'];
		$log_solicitud = $data['log_solicitud'];
		$log_log = $data['log_log'];
		$query = "UPDATE documents_log SET  log_date = '$log_date', log_solicitud = '$log_solicitud', log_log = '$log_log' WHERE log_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}