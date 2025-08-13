<?php 
/**
* clase que genera la insercion y edicion  de contactos en la base de datos
*/
class Page_Model_DbTable_Contactos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'contactos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un contacto y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$nombres = $data['nombres'];
		$apellido1 = $data['apellido1'];
		$apellido2 = $data['apellido2'];
		$categoria = $data['categoria'];
		$email = $data['email'];
		$email2 = $data['email2'];
		$celular = $data['celular'];
		$celular2 = $data['celular2'];
		$fecha_c = $data['fecha_c'];
		$quien = $data['quien'];
		$cliente_id = $data['cliente_id'];
		$observacion = $data['observacion'];
		$query = "INSERT INTO contactos( nombres, apellido1, apellido2, categoria, email, email2, celular, celular2, fecha_c, quien, cliente_id, observacion) VALUES ( '$nombres', '$apellido1', '$apellido2', '$categoria', '$email', '$email2', '$celular', '$celular2', '$fecha_c', '$quien', '$cliente_id', '$observacion')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un contacto  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$nombres = $data['nombres'];
		$apellido1 = $data['apellido1'];
		$apellido2 = $data['apellido2'];
		$categoria = $data['categoria'];
		$email = $data['email'];
		$email2 = $data['email2'];
		$celular = $data['celular'];
		$celular2 = $data['celular2'];
		$fecha_c = $data['fecha_c'];
		$quien = $data['quien'];
		$cliente_id = $data['cliente_id'];
		$observacion = $data['observacion'];
		$query = "UPDATE contactos SET  nombres = '$nombres', apellido1 = '$apellido1', apellido2 = '$apellido2', categoria = '$categoria', email = '$email', email2 = '$email2', celular = '$celular', celular2 = '$celular2', observacion = '$observacion' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}