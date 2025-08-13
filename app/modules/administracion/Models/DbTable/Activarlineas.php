<?php 
/**
* clase que genera la insercion y edicion  de Activar Lineas en la base de datos
*/
class Administracion_Model_DbTable_Activarlineas extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'activar_lineas';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'activar_id';

	/**
	 * insert recibe la informacion de un Activar Lineas y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$activar_documento = $data['activar_documento'];
		$activar_linea = $data['activar_linea'];
		$query = "INSERT INTO activar_lineas( activar_documento, activar_linea) VALUES ( '$activar_documento', '$activar_linea')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un Activar Lineas  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$activar_documento = $data['activar_documento'];
		$activar_linea = $data['activar_linea'];
		$query = "UPDATE activar_lineas SET  activar_documento = '$activar_documento', activar_linea = '$activar_linea' WHERE activar_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}