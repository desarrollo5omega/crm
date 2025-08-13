<?php 
/**
* clase que genera la insercion y edicion  de Regionales Libranza en la base de datos
*/
class Administracion_Model_DbTable_Regionaleslibranza extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'regionales_libranza';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'regional_id';

	/**
	 * insert recibe la informacion de un Regionales Libranza y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$regional_regional = $data['regional_regional'];
		$regional_cedula = $data['regional_cedula'];
		$regional_nombre = $data['regional_nombre'];
		$regional_cargo = $data['regional_cargo'];
		$regional_correos = $data['regional_correos'];
		$regional_identificacion = $data['regional_identificacion'];
		$query = "INSERT INTO regionales_libranza( regional_regional, regional_cedula, regional_nombre, regional_cargo, regional_correos, regional_identificacion) VALUES ( '$regional_regional', '$regional_cedula', '$regional_nombre', '$regional_cargo', '$regional_correos', '$regional_identificacion')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un Regionales Libranza  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$regional_regional = $data['regional_regional'];
		$regional_cedula = $data['regional_cedula'];
		$regional_nombre = $data['regional_nombre'];
		$regional_cargo = $data['regional_cargo'];
		$regional_correos = $data['regional_correos'];
		$regional_identificacion = $data['regional_identificacion'];
		$query = "UPDATE regionales_libranza SET  regional_regional = '$regional_regional', regional_cedula = '$regional_cedula', regional_nombre = '$regional_nombre', regional_cargo = '$regional_cargo', regional_correos = '$regional_correos', regional_identificacion = '$regional_identificacion' WHERE regional_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}