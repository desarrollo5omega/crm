<?php 
/**
* clase que genera la insercion y edicion  de enfermedades items en la base de datos
*/
class Administracion_Model_DbTable_Enfermedadesitems extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'asegurabilidad_enfermedades_items';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un enfermedad item y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$enfermedad = $data['enfermedad'];
		$formulario = $data['formulario'];
		$query = "INSERT INTO asegurabilidad_enfermedades_items( enfermedad, formulario) VALUES ( '$enfermedad', '$formulario')";
		//echo $query."<br>";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un enfermedad item  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){

		$enfermedad = $data['enfermedad'];
		$formulario = $data['formulario'];
		$query = "UPDATE asegurabilidad_enfermedades_items SET  enfermedad = '$enfermedad', formulario = '$formulario' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}

	public function borrar($formulario){


		$query = " DELETE FROM asegurabilidad_enfermedades_items  WHERE formulario = '".$formulario."'";
		$res = $this->_conn->query($query);
	}

}