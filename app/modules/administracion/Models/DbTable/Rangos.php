<?php 
/**
* clase que genera la insercion y edicion  de rangos de tasas en la base de datos
*/
class Administracion_Model_DbTable_Rangos extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'rangos';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'rango_id';

	/**
	 * insert recibe la informacion de un rango y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$rango_codigo = $data['rango_codigo'];
		$rango_min = $data['rango_min'];
		$rango_max = $data['rango_max'];
		$rango_tasa_mensual = $data['rango_tasa_mensual'];
		$rango_tasa_anual = $data['rango_tasa_anual'];
		$query = "INSERT INTO rangos( rango_codigo, rango_min, rango_max, rango_tasa_mensual, rango_tasa_anual) VALUES ( '$rango_codigo', '$rango_min', '$rango_max', '$rango_tasa_mensual', '$rango_tasa_anual')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un rango  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$rango_codigo = $data['rango_codigo'];
		$rango_min = $data['rango_min'];
		$rango_max = $data['rango_max'];
		$rango_tasa_mensual = $data['rango_tasa_mensual'];
		$rango_tasa_anual = $data['rango_tasa_anual'];
		$query = "UPDATE rangos SET  rango_codigo = '$rango_codigo', rango_min = '$rango_min', rango_max = '$rango_max', rango_tasa_mensual = '$rango_tasa_mensual', rango_tasa_anual = '$rango_tasa_anual' WHERE rango_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}