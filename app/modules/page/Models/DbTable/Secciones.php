<?php 
/**
* clase que genera la insercion y edicion  de logs en la base de datos
*/
class Page_Model_DbTable_Secciones extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'secciones';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'secciones_id';

	public function insert($data){
		$secciones_nombre = $data['secciones_nombre'];
		$secciones_activo = $data['secciones_activo'];
		$secciones_cliente = $data['secciones_cliente'];
		$secciones_proyecto = $data['secciones_proyecto'];
		$query = "INSERT INTO secciones ( secciones_nombre, secciones_activo, secciones_cliente, secciones_proyecto) VALUES ('$secciones_nombre', '$secciones_activo', '$secciones_cliente', '$secciones_proyecto')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

}