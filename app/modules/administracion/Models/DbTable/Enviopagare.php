<?php 
/**
* clase que genera la insercion y edicion  de enviopagare en la base de datos
*/
class Administracion_Model_DbTable_Enviopagare extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'enviopagare';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'envio_id';

	/**
	 * insert recibe la informacion de un enviopagare y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$envio_solicitud = $data['envio_solicitud'];
		$envio_fecha = $data['envio_fecha'];
		$envio_quien = $data['envio_quien'];
		$query = "INSERT INTO enviopagare( envio_solicitud, envio_fecha, envio_quien) VALUES ( '$envio_solicitud', '$envio_fecha', '$envio_quien')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un enviopagare  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$envio_solicitud = $data['envio_solicitud'];
		$envio_fecha = $data['envio_fecha'];
		$envio_quien = $data['envio_quien'];
		$query = "UPDATE enviopagare SET  envio_solicitud = '$envio_solicitud', envio_fecha = '$envio_fecha', envio_quien = '$envio_quien' WHERE envio_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}