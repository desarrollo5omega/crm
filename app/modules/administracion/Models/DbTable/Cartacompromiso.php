<?php 
/**
* clase que genera la insercion y edicion  de carta compromiso en la base de datos
*/
class Administracion_Model_DbTable_Cartacompromiso extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'carta_compromiso';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un carta y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$solicitud = $data['solicitud'];
		$firma = $data['firma'];
		$font = $data['font'];
		$fecha_firma = $data['fecha_firma'];
		$ip = $data['ip'];
		$query = "INSERT INTO carta_compromiso( solicitud, firma, font, fecha_firma, ip) VALUES ( '$solicitud', '$firma', '$font', '$fecha_firma', '$ip')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un carta  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$solicitud = $data['solicitud'];
		$firma = $data['firma'];
		$font = $data['font'];
		$fecha_firma = $data['fecha_firma'];
		$ip = $data['ip'];
		$query = "UPDATE carta_compromiso SET  solicitud = '$solicitud', firma = '$firma', font = '$font', fecha_firma = '$fecha_firma', ip = '$ip' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}