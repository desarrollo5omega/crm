<?php 
/**
* clase que genera la insercion y edicion  de Beneficiarios en la base de datos
*/
class Administracion_Model_DbTable_Beneficarios extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'beneficiarios';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'id';

	/**
	 * insert recibe la informacion de un beneficiarios y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$asociado = $data['asociado'];
		$nombres = $data['nombres'];
		$documento = $data['documento'];
		$fecha_d = $data['fecha_d'];
		$fecha_m = $data['fecha_m'];
		$fecha_a = $data['fecha_a'];
		$parentesco = $data['parentesco'];
		$porcentaje = $data['porcentaje'];
		$i = $data['i'];
		$query = "INSERT INTO beneficiarios( asociado, nombres, documento, fecha_d, fecha_m, fecha_a, parentesco, porcentaje, i) VALUES ( '$asociado', '$nombres', '$documento', '$fecha_d', '$fecha_m', '$fecha_a', '$parentesco', '$porcentaje', '$i')";
		//echo $query."<br>";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un beneficiarios  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){

		$asociado = $data['asociado'];
		$nombres = $data['nombres'];
		$documento = $data['documento'];
		$fecha_d = $data['fecha_d'];
		$fecha_m = $data['fecha_m'];
		$fecha_a = $data['fecha_a'];
		$parentesco = $data['parentesco'];
		$porcentaje = $data['porcentaje'];
		$i = $data['i'];
		$query = "UPDATE beneficiarios SET  asociado = '$asociado', nombres = '$nombres', documento = '$documento', fecha_d = '$fecha_d', fecha_m = '$fecha_m', fecha_a = '$fecha_a', parentesco = '$parentesco', porcentaje = '$porcentaje', i = '$i' WHERE id = '".$id."'";
		$res = $this->_conn->query($query);
	}


	public function borrar($documento){
		$query = " DELETE FROM beneficiarios WHERE asociado = '".$documento."'";
		$res = $this->_conn->query($query);
	}

}