<?php 
/**
* clase que genera la insercion y edicion  de Cedulas Deceval en la base de datos
*/
class Administracion_Model_DbTable_Ceduladeceval extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'cedula_deceval';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un Cedulas Deceval y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$cedula = $data['cedula'];
		$usuario_deceval = $data['usuario_deceval'];
		$fecha = $data['fecha'];
		$query = "INSERT INTO cedula_deceval( cedula, usuario_deceval, fecha) VALUES ( '$cedula', '$usuario_deceval', '$fecha')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un Cedulas Deceval  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$cedula = $data['cedula'];
		$usuario_deceval = $data['usuario_deceval'];
		$fecha = $data['fecha'];
		$query = "UPDATE cedula_deceval SET  cedula = '$cedula', usuario_deceval = '$usuario_deceval', fecha = '$fecha' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}