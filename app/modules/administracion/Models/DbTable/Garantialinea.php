<?php 
/**
* clase que genera la insercion y edicion  de garantialinea en la base de datos
*/
class Administracion_Model_DbTable_Garantialinea extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'garantia_linea';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'gl_id';

	/**
	 * insert recibe la informacion de un garantialinea y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$gl_linea_id = $data['gl_linea_id'];
		$gl_garantia_id = $data['gl_garantia_id'];
		$gl_obligatoria = $data['gl_obligatoria'];
		$query = "INSERT INTO garantia_linea( gl_linea_id, gl_garantia_id, gl_obligatoria) VALUES ( '$gl_linea_id', '$gl_garantia_id', '$gl_obligatoria')";
		//echo $query."<br>";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}


	public function vaciar($linea_id){

		$query = " DELETE FROM garantia_linea WHERE gl_linea_id='$linea_id' ";
		$res = $this->_conn->query($query);

        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un garantialinea  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){

		$gl_linea_id = $data['gl_linea_id'];
		$gl_garantia_id = $data['gl_garantia_id'];
		$query = "UPDATE garantia_linea SET  gl_linea_id = '$gl_linea_id', gl_garantia_id = '$gl_garantia_id' WHERE gl_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}