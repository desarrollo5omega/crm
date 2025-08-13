<?php 
/**
* clase que genera la insercion y edicion  de info patrimonial en la base de datos
*/
class Administracion_Model_DbTable_Infopatrimonial extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'info_patrimonial';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un info y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$solicitud = $data['solicitud'];
		$cedula = $data['cedula'];
		$concepto = $data['concepto'];
		$v1 = $data['v1'];
		$v2 = $data['v2'];
		$v3 = $data['v3'];
		$query = "INSERT INTO info_patrimonial( solicitud, cedula, concepto, v1, v2, v3) VALUES ( '$solicitud', '$cedula', '$concepto', '$v1', '$v2', '$v3')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un info  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$solicitud = $data['solicitud'];
		$cedula = $data['cedula'];
		$concepto = $data['concepto'];
		$v1 = $data['v1'];
		$v2 = $data['v2'];
		$v3 = $data['v3'];
		$query = "UPDATE info_patrimonial SET  solicitud = '$solicitud', cedula = '$cedula', concepto = '$concepto', v1 = '$v1', v2 = '$v2', v3 = '$v3' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}

	public function borrar($solicitud,$cedula,$concepto){
		$query = " DELETE FROM info_patrimonial WHERE solicitud = '$solicitud' AND cedula='$cedula' AND concepto='$concepto'  ";
		$res = $this->_conn->query($query);
	}

}