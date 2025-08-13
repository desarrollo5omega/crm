<?php 
/**
* clase que genera la insercion y edicion  de documentos en la base de datos
*/
class Administracion_Model_DbTable_Documentos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'documentos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'documentos_id';

	public function insert($data){
		$documentos_proyecto = $data['documentos_proyecto'];
		$documentos_nombre = $data['documentos_nombre'];
		$query = "INSERT INTO documentos( documentos_proyecto, documentos_nombre) VALUES ( '$documentos_proyecto', '$documentos_nombre')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	public function deleteDoc($id)
    {
        $update = "DELETE FROM documentos WHERE documentos_proyecto = '".$id."' ";
        $this->_conn->query( $update );
    }

}