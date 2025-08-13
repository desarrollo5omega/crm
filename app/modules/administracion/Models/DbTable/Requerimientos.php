<?php 
/**
* clase que genera la insercion y edicion  de requerimientos en la base de datos
*/
class Administracion_Model_DbTable_Requerimientos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'requerimientos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'requerimientos_id';

	public function insert($data){
		$requerimientos_proyecto = $data['requerimientos_proyecto'];
		$requerimientos_fecha = $data['requerimientos_fecha'];
		$requerimientos_fecha_t = $data['requerimientos_fecha_t'];
        $requerimientos_tipo = $data['requerimientos_tipo'];
        $requerimientos_ing = $data['requerimientos_ing'];
        $requerimientos_desc = $data['requerimientos_desc'];
        $requerimientos_estado = $data['requerimientos_estado'];
		$requerimientos_seccion = $data['requerimientos_seccion'];
		$query = "INSERT INTO requerimientos(requerimientos_proyecto, requerimientos_fecha, requerimientos_fecha_t,requerimientos_tipo, requerimientos_ing, requerimientos_desc, requerimientos_estado, requerimientos_seccion) VALUES ('$requerimientos_proyecto', '$requerimientos_fecha', '$requerimientos_fecha_t','$requerimientos_tipo', '$requerimientos_ing', '$requerimientos_desc', '$requerimientos_estado', '$requerimientos_seccion')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}


}