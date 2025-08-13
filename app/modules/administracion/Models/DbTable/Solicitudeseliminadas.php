<?php 
/**
* clase que genera la insercion y edicion  de Solicitudes Eliminadas en la base de datos
*/
class Administracion_Model_DbTable_Solicitudeseliminadas extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'solicitudes_eliminadas';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'solicitud_id';

	/**
	 * insert recibe la informacion de un Solicitudes Eliminadas y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$solicitud_solicitud = $data['solicitud_solicitud'];
		$solicitud_fecha_eliminacion = $data['solicitud_fecha_eliminacion'];
		$solicitud_usuario = $data['solicitud_usuario'];
		$solicitud_datos = $data['solicitud_datos'];
		$query = "INSERT INTO solicitudes_eliminadas( solicitud_solicitud, solicitud_fecha_eliminacion, solicitud_usuario, solicitud_datos) VALUES ( '$solicitud_solicitud', '$solicitud_fecha_eliminacion', '$solicitud_usuario', '$solicitud_datos')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un Solicitudes Eliminadas  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$solicitud_solicitud = $data['solicitud_solicitud'];
		$solicitud_fecha_eliminacion = $data['solicitud_fecha_eliminacion'];
		$solicitud_usuario = $data['solicitud_usuario'];
		$solicitud_datos = $data['solicitud_datos'];
		$query = "UPDATE solicitudes_eliminadas SET  solicitud_solicitud = '$solicitud_solicitud', solicitud_fecha_eliminacion = '$solicitud_fecha_eliminacion', solicitud_usuario = '$solicitud_usuario', solicitud_datos = '$solicitud_datos' WHERE solicitud_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}