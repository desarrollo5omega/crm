<?php 
/**
* clase que genera la insercion y edicion  de logs en la base de datos
*/
class Administracion_Model_DbTable_Proyectosing extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'proyectosing';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'proyectosing_id';

	public function insert($data){
		$proyectosing_user = $data['proyectosing_user'];
		$proyectosing_proyecto = $data['proyectosing_proyecto'];
		$proyectosing_observacion = $data['proyectosing_observacion'];
		
		$query = "INSERT INTO proyectosing ( proyectosing_user, proyectosing_proyecto, proyectosing_observacion ) VALUES ( '$proyectosing_user', '$proyectosing_proyecto', '$proyectosing_observacion')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	public function deleteAll($id)
    {
        $update = "DELETE FROM proyectosing WHERE proyectosing_proyecto = '".$id."'";
        $this->_conn->query( $update );
    }

}