<?php 
/**
* clase que genera la insercion y edicion  de comite en la base de datos
*/
class Administracion_Model_DbTable_Comite extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'comite';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'comite_id';

	/**
	 * insert recibe la informacion de un comite y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$comite_solicitud_id = $data['comite_solicitud_id'];
		$comite_aprobacion = $data['comite_aprobacion'];
		$comite_observacion = $data['comite_observacion'];
		$comite_user_id = $data['comite_user_id'];
		$comite_fecha = $data['comite_fecha'];
		$comite_tipo = $data['comite_tipo'];
		$query = "INSERT INTO comite( comite_solicitud_id, comite_aprobacion, comite_observacion, comite_user_id, comite_fecha,comite_tipo) VALUES ( '$comite_solicitud_id', '$comite_aprobacion', '$comite_observacion', '$comite_user_id', '$comite_fecha','$comite_tipo')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un comite  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$comite_solicitud_id = $data['comite_solicitud_id'];
		$comite_aprobacion = $data['comite_aprobacion'];
		$comite_observacion = $data['comite_observacion'];
		$comite_user_id = $data['comite_user_id'];
		$comite_fecha = $data['comite_fecha'];
		$query = "UPDATE comite SET  comite_solicitud_id = '$comite_solicitud_id', comite_aprobacion = '$comite_aprobacion', comite_observacion = '$comite_observacion', comite_user_id = '$comite_user_id', comite_fecha = '$comite_fecha' WHERE comite_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}