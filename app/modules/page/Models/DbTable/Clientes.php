<?php 
/**
* clase que genera la insercion y edicion  de clientes en la base de datos
*/
class Page_Model_DbTable_Clientes extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'clientes';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un cliente y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$nombre = $data['nombre'];
		$contacto_principal = $data['contacto_principal'];
		$documento = $data['documento'];
		$tipo_documento = $data['tipo_documento'];
		$direccion = $data['direccion'];
		$email = $data['email'];
		$telefono = $data['telefono'];
		$celular = $data['celular'];
		$pagina_web = $data['pagina_web'];
		$categoria = $data['categoria'];
		$estado = $data['estado'];
		$asignado = $data['asignado'];
		$activo = $data['activo'];
		$quien = $data['quien'];
		$fecha_c = $data['fecha_c'];
		$fecha_a = $data['fecha_a'];
		$logo = $data['logo'];
		$query = "INSERT INTO clientes( nombre, contacto_principal, documento, tipo_documento, direccion, email, telefono, celular, pagina_web, categoria, estado, asignado, activo, quien, fecha_c, fecha_a, logo) VALUES ( '$nombre', '$contacto_principal', '$documento', '$tipo_documento', '$direccion', '$email', '$telefono', '$celular', '$pagina_web', '$categoria', '$estado', '$asignado', '$activo', '$quien', '$fecha_c', '$fecha_a', '$logo')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un cliente  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$nombre = $data['nombre'];
		$contacto_principal = $data['contacto_principal'];
		$documento = $data['documento'];
		$tipo_documento = $data['tipo_documento'];
		$direccion = $data['direccion'];
		$email = $data['email'];
		$telefono = $data['telefono'];
		$celular = $data['celular'];
		$pagina_web = $data['pagina_web'];
		$categoria = $data['categoria'];
		$estado = $data['estado'];
		$asignado = $data['asignado'];
		$activo = $data['activo'];
		$quien = $data['quien'];
		$fecha_c = $data['fecha_c'];
		$fecha_a = $data['fecha_a'];
		$logo = $data['logo'];
		$query = "UPDATE clientes SET  nombre = '$nombre', contacto_principal = '$contacto_principal', documento = '$documento', tipo_documento = '$tipo_documento', direccion = '$direccion', email = '$email', telefono = '$telefono', celular = '$celular', pagina_web = '$pagina_web', categoria = '$categoria', estado = '$estado', asignado = '$asignado', activo = '$activo', fecha_a = '$fecha_a', logo = '$logo' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}