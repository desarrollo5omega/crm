<?php 
/**
* clase que genera la insercion y edicion  de config en la base de datos
*/
class Administracion_Model_DbTable_Config extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'config';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un config y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$cuota_min = $data['cuota_min'];
		$cuota_max = $data['cuota_max'];
		$valor_min = $data['valor_min'];
		$valor_max = $data['valor_max'];
		$tasa = $data['tasa'];
		$salario_minimo = $data['salario_minimo'];
		$query = "INSERT INTO config( salario_minimo,cuota_min, cuota_max, valor_min, valor_max, tasa) VALUES ( '$salario_minimo','$cuota_min', '$cuota_max', '$valor_min', '$valor_max', '$tasa')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un config  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$cuota_min = $data['cuota_min'];
		$cuota_max = $data['cuota_max'];
		$valor_min = $data['valor_min'];
		$valor_max = $data['valor_max'];
		$tasa = $data['tasa'];
		$salario_minimo = $data['salario_minimo'];
		$query = "UPDATE config SET salario_minimo = '$salario_minimo',  cuota_min = '$cuota_min', cuota_min = '$cuota_min', cuota_max = '$cuota_max', valor_min = '$valor_min', valor_max = '$valor_max', tasa = '$tasa' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}